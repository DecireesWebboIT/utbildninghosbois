<?php
/**
 * Class for the manual mode
 * 
 * @since 0.1
 */
class SAU_Manual_Mode
{
	public static function initialize()
	{
		/**
		 * Enable automatic updates for core (major and minor), plugins and themes.
		 */
		add_filter( 'allow_dev_auto_core_updates', 		'__return_false' );	// disable development updates 
		add_filter( 'allow_minor_auto_core_updates', 	'__return_false' );	// disable minor updates
		add_filter( 'allow_major_auto_core_updates', 	'__return_false' );	// disable major updates
		add_filter( 'auto_update_plugin', 				'__return_false' );	// disable plugin updates
		add_filter( 'auto_update_theme', 				'__return_false' );	// disable theme updates

		/**
		 * Turn off the automatic core update emails
		 */
		add_filter( 'auto_core_update_send_email', 			'__return_false' );
		add_filter( 'send_core_update_notification_email', 	'__return_false' );
	}

	/**
	 * Check if the any updates can be done. The check is only performed
	 * once a week.
	 * @return null 
	 * 
	 * @since 0.1
	 */
	public static function outdated_packages_send_notice()
	{
		global $sau_mail_footer;

		// Only check once a week
		if ( self::latest_checked_check() ) return;
		self::latest_checked_set();

		$outdated_wordpress = self::available_updates_wordpress_get();
		$outdated_plugins 	= self::available_updates_plugins_get();
		$outdated_themes 	= self::available_updates_themes_get();

		if ( count( $outdated_wordpress ) == 0 &&
			count( $outdated_plugins ) == 0 &&
			count( $outdated_themes ) == 0 )
		{
			self::latest_checked_set();
			return;
		}

		sort( $outdated_wordpress );
		sort( $outdated_plugins );
		sort( $outdated_themes );


		/**
		 * Mail receiver
		 */
		$mail_to	= get_option( 'admin_email' );
		if ( $mail_to === '' ) return;

		/**
		 * Mail subject
		 */
		$mail_subject = __( 
			'Your site needs to be updated: %s', 
			'simple-automatic-updates' 
		);
		$mail_subject = sprintf( $mail_subject, get_site_url() );

		/**
		 * Mail body
		 */
		$mail_body	= '';

		if ( count( $outdated_wordpress ) > 0 )
		{
			$mail_body .= implode("\n", $outdated_wordpress ) . "\n\n";
		}

		if ( count( $outdated_plugins ) > 0 )
		{
			$mail_body .= __('Plugins', 'simple-automatic-updates');
			$mail_body .= ":\n- " . implode("\n- ", $outdated_plugins ) . "\n\n";
		}

		if ( count( $outdated_themes ) > 0 )
		{
			$mail_body .= __('Themes', 'simple-automatic-updates');
			$mail_body .= ":\n-'" . implode("\n- ", $outdated_themes ) . "\n\n";
		}

		$mail_body .=  __(
			'The updates can be installed from the WordPress dashboard:', 
			'simple-automatic-updates' 
		);
		$mail_body .= "\n" . wp_login_url();
		$mail_body .= "\n\n";

		$mail_body .= $sau_mail_footer;

		/**
		 * Send the mail
		 */
		$ret = wp_mail( $mail_to, $mail_subject, $mail_body, array() );

		return null;
	}

	/**
	 * Check if a check has already been performed this week.
	 * @return boolean 
	 * 
	 * @since 0.1
	 */
	private static function latest_checked_check()
	{
		$last_checked = (int)get_option('sau_last_checked');

		return ( $last_checked + WEEK_IN_SECONDS >= time() );
	}

	/**
	 * Save the time so that no more checks is made this week.
	 * @return null 
	 * 
	 * @since 0.1
	 */
	private static function latest_checked_set()
	{
		update_option( 'sau_last_checked', (string)time() );

		return null;
	}

	/**
	 * Check if WordPress can be updated
	 * @return array 
	 * 
	 * @since 0.1
	 */
	private static function available_updates_wordpress_get()
	{
		global $wp_version;

		$to_update		= array();
		$new_version 	= $wp_version;
		$core_info 		= get_site_transient( 'update_core' );

		if ( ! $core_info || empty( $core_info->updates ) )
			return $to_update;

		foreach ( $core_info->updates as $update ) 
		{
			if ( version_compare( $update->current, $new_version, '>' ) )
			{
				$new_version = $update->current;
			}
		}

		if ( $new_version == $wp_version ) 
			return $to_update;

		$msg = __(
			'WordPress can be updated to version %s (currently %s)', 
			'simple-automatic-updates'
		);		

		$to_update[] = sprintf( $msg, $new_version, $wp_version );

		return $to_update;
	}

	/**
	 * Check if any plugins can be updated
	 * @return array 
	 * 
	 * @since 0.1
	 */
	private static function available_updates_plugins_get()
	{
		$to_update		= array();
		$plugins_info 	= get_site_transient( 'update_plugins' );

		if ( ! $plugins_info || empty( $plugins_info->response ) )
			return $to_update;

		foreach ($plugins_info->response as $file => $plugin) 
		{
			$plugin_path = WP_PLUGIN_DIR . '/' . $file;
			$plugin_data = get_plugin_data( $plugin_path, false );

			$name 				= $plugin_data['Name'];
			$current_version 	= $plugin_data['Version'];
			$new_version 		= $plugin->new_version;

			$msg = __(
				'"%s" can be updated to version %s (currently %s)', 
				'simple-automatic-updates'
			);

			$to_update[] = sprintf( $msg, $name, $new_version, $current_version );
		}

		return $to_update;
	}

	/**
	 * Check if any themes can be updated
	 * @return array 
	 * 
	 * @since 0.1
	 */
	private static function available_updates_themes_get()
	{
		$to_update		= array();
		$themes_info 	= get_site_transient( 'update_themes' );
		if ( ! $themes_info || empty( $themes_info->response ) )
			return $to_update;

		foreach ($themes_info->response as $stylesheet => $theme) 
		{
			$theme_data = wp_get_theme( $stylesheet, false );

			$name 				= $theme_data['Name'];
			$new_version 		= $theme['new_version'];
			$current_version 	= $themes_info->checked[ $stylesheet ];

			$msg = __(
				'"%s" can be updated to version %s (currently %s)', 
				'simple-automatic-updates'
			);

			$to_update[] = sprintf( $msg, $name, $new_version, $current_version );
		}

		return $to_update;
	}
}