<?php
/**
 * Class for the automatic mode
 * 
 * @since 0.1
 */
class SAU_Automatic_Mode
{
	/**
	 * Initialize the automatic mode.
	 * @param  boolean $silent If it is in silend mode, don't bother to save updates.
	 * @return null  
	 * 
	 * @since 0.1        
	 */
	public static function initialize( $silent = false )
	{
		/**
		 * Enable automatic updates for core (major and minor), plugins and themes.
		 */
		add_filter( 'allow_dev_auto_core_updates', 		'__return_false' ); // disable development updates 
		add_filter( 'allow_minor_auto_core_updates', 	'__return_true' );	// enable minor updates
		add_filter( 'allow_major_auto_core_updates', 	'__return_true' );	// enable major updates
		add_filter( 'auto_update_plugin', 				'__return_true' );	// enable plugin updates
		add_filter( 'auto_update_theme', 				'__return_true' );	// enable theme updates

		/**
		 * Turn off the automatic core update emails
		 */
		add_filter( 'auto_core_update_send_email', 			'__return_false' );
		add_filter( 'send_core_update_notification_email', 	'__return_false' );

		/**
		 * Filter that is run when an upgrade process has been run.
		 */
		if ( $silent == false )
		{
			add_action( 
				'upgrader_process_complete', 
				array( 
					'SAU_Automatic_Mode', 
					'sau_upgrader_process_complete'
				), 
				10, 
				2 	
			);	
		}

		return null;
	}

	/**
	 * Clear the list of updated packages
	 * @return null 
	 * 
	 * @since 0.1
	 */
	public static function updated_packages_clear()
	{
		delete_option( 'sau_updated_packages' );

		return null;
	}

	/**
	 * Mails the user about packages that has been updated.
	 * @return null
	 * 
	 * @since 0.1
	 */
	public static function updated_packages_send_notice()
	{
		global $sau_mail_footer;

		$updated_packages = get_option( 'sau_updated_packages' );
		SAU_Automatic_Mode::updated_packages_clear();

		if ( ! $updated_packages || count( $updated_packages ) == 0 )
		{
			return null;
		}

		/**
		 * Mail receiver
		 */
		$mail_to	= get_option( 'admin_email' );
		if ( $mail_to === '' )
		{
			return null;
		}

		/**
		 * Mail subject
		 */
		$mail_subject = __( 
			'Your site has been updated: %s', 
			'simple-automatic-updates' 
		);
		$mail_subject = sprintf( $mail_subject, get_site_url() );

		/**
		 * Mail body
		 */
		$mail_body	= '';

		if ( isset($updated_packages['core'] ) && count( $updated_packages['core'] > 0 ) )
		{
			$mail_body .= implode("\n", $updated_packages['core'] ) . "\n\n";
		}

		if ( isset($updated_packages['plugin'] ) && count( $updated_packages['plugin'] > 0 ) )
		{
			$mail_body .= __('Plugins', 'simple-automatic-updates');
			$mail_body .= ":\n- " . implode("\n- ", $updated_packages['plugin'] ) . "\n\n";
		}

		if ( isset($updated_packages['theme'] ) && count( $updated_packages['theme'] > 0 ) )
		{
			$mail_body .= __('Themes', 'simple-automatic-updates');
			$mail_body .= ":\n- " . implode("\n- ", $updated_packages['theme'] ) . "\n\n";
		}

		$mail_body .= $sau_mail_footer;

		/**
		 * Send the mail
		 */
		$ret = wp_mail( $mail_to, $mail_subject, $mail_body, array() );

		return null;
	}

	/**
	 * Save updates for the email that should be sent.
	 *
	 * This is triggered by manual updates as well. For all updates but
	 * the core updates, this can be distinguished by the $data not holding
	 * the same information as in other case.
	 * 
	 * @param  Plugin_Upgrader $upgrader
	 * @param  Array $data 
	 * @return null
	 * 
	 * @since 0.1
	 */
	public static function sau_upgrader_process_complete( $upgrader, $data )
	{
		global $wp_version;

		$updated_packages = get_option( 'sau_updated_packages' );
		if ( ! $updated_packages )
		{
			$updated_packages = array();
		}

		$type			= $data['type'];
		$url			= get_site_url();

		if ( ! isset( $updated_packages[ $type ] ) )
		{
			$updated_packages[ $type ] = array();
		}

		/**
		 * Core 
		 */
		if ( $type === 'core' )
		{
			$msg = __( 
				'WordPress was updated to version %s', 
				'simple-automatic-updates' 
			);
			$msg = sprintf( $msg, $wp_version );
		}

		/**
		 * Plugin 
		 */
		else if ( $type === 'plugin' && isset($data['plugin']) && $data['plugin'] != '' )
		{
			$plugin_path = WP_PLUGIN_DIR . '/' . $data['plugin'];
			$plugin_data = get_plugin_data( $plugin_path, false );

			$msg = __( 
				'%s was updated', 
				'simple-automatic-updates' 
			);
			$msg = sprintf( $msg, $plugin_data['Name'] );

			if ( isset( $plugin_data['Version'] ) && $plugin_data['Version'] != '' )
			{
				$msg .= ' ' . __('to version %s', 'simple-automatic-updates');
				$msg = sprintf( $msg, $plugin_data['Version'] );
			}
		}

		/**
		 * Theme 
		 */
		else if ( $type === 'theme' && isset($data['theme']) && $data['theme'] != '' )
		{
			$theme_data = wp_get_theme( $data['theme'], false );

			$msg = __( 
				'%s was updated', 
				'simple-automatic-updates' 
			);
			$msg = sprintf( $msg, $theme_data['Name'] );

			if ( isset( $theme_data['Version'] ) && $theme_data['Version'] != '' )
			{
				$msg .= ' ' . __('to version %s', 'simple-automatic-updates');
				$msg = sprintf( $msg, $theme_data['Version'] );
			}
			
		}

		/**
		 * Probably not an automatic update
		 */
		else
		{
			return null;
		}

		$updated_packages[ $type ][] = $msg;

		update_option( 'sau_updated_packages', $updated_packages );

		return null;
	}
}