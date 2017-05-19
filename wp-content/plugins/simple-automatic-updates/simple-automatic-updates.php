<?php
/*
Plugin Name: Simple Automatic Updates
Plugin URI: 
Description: Sets WordPress to automatically update core (major and minor releases), plugins and themes.
Author: Jon Tejnung
Version: 0.1.3
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once dirname(__FILE__) . '/sau-automatic-mode.class.php';
require_once dirname(__FILE__) . '/sau-manual-mode.class.php';

// Check if get_plugins() function exists. This is required on the front end of the
// site, since it is in a file that is normally only loaded in the admin.
if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/**
 * The chosen mode
 * @var string
 * 
 * @since 0.1
 */
global $sau_mode;
$sau_mode	= get_option( 'sau_mode', 'automatic' );

/**
 * The standard footer that are sent in all emails
 * @var string
 *
 * @since 0.1
 */
global $sau_mail_footer;
$sau_mail_footer = '';


/**
 * Initiate the plugin depending on which mode is selected
 */

if ( $sau_mode == 'manual' )
{
	SAU_Manual_Mode::initialize();
}
else if ( $sau_mode == 'automatic-silent' )
{
	SAU_Automatic_Mode::initialize( true );
}
else
{
	// Default to automatic
	$sau_mode = 'automatic'; 
	SAU_Automatic_Mode::initialize( false );
}

/**
 * Load plugin textdomain.
 * @return null
 * 
 * @since 0.1
 */
function sau_load_textdomain() 
{
	load_plugin_textdomain( 
		'simple-automatic-updates', 
		false, 
		plugin_basename( dirname( __FILE__ ) ) . '/languages' 
	); 

	/**
	 * Define some global strings that needs translation
	 */
	global $sau_mail_footer;

	$sau_mail_footer = __( 
		"This message was automatically sent from %s.\nYou can change the mode of automatic updates in the WordPress dashboard\nunder Settings->General.", 
		'simple-automatic-updates' 
	);
	$sau_mail_footer = sprintf( $sau_mail_footer, get_site_url() );

	return null;
}
add_action( 'plugins_loaded', 'sau_load_textdomain' );

/**
 * Run on plugin activation
 * @return null
 *
 * @since  0.1
 */
function sau_activation() 
{
	/**
	 * Set last checked to 0, so that you can force a check for manual
	 * updates by de- and re-activate the plugin.
	 * We still have to wait for the cron, though.
	 */
	update_option( 'sau_last_checked', '0' );

	/**
	 * Schedule hook to run hourly
	 */
	if ( ! wp_next_scheduled( 'sau_check_updates' ) ) 
	{
		wp_schedule_event( time(), 'hourly', 'sau_check_updates' );
	}

	return null;
}
register_activation_hook( __FILE__, 'sau_activation' );

/**
 * Run on plugin deactivation
 * @return null
 *
 * @since  0.1
 */
function sau_deactivation() 
{
	/**
	 * Remove scheduled events on deactivation.
	 */
	$event_timestamp = wp_next_scheduled( 'sau_check_updates' );
	if ( $event_timestamp ) 
	{
		wp_unschedule_event( $event_timestamp, 'sau_check_updates' );
	}	

	return null;
}
register_deactivation_hook( __FILE__, 'sau_deactivation' );

/**
 * The function that runs every cron cycle to check if
 * a mail should be sent.
 * @return null 
 */
function sau_cron_check()
{
	global $sau_mode;

	if ( $sau_mode == 'manual' )
	{
		SAU_Manual_Mode::outdated_packages_send_notice();
	}
	else if ( $sau_mode == 'automatic-silent' )
	{
		SAU_Automatic_Mode::updated_packages_clear();
	}
	else
	{
		// Default to automatic 
		SAU_Automatic_Mode::updated_packages_send_notice();
	}

	return null;
}
add_action( 'sau_check_updates', 'sau_cron_check' );

/**
 * Register the mode field on the options page
 * @return Null 
 * 
 * @since 0.1
 */
function sau_custom_options() 
{
	add_settings_field( 
		'sau_mode',
		__('Automatic updates mode', 'simple-automatic-updates' ), 
		'sau_mode_html',
		'general'
	);

	register_setting( 'general', 'sau_mode' );

	return null;
}
add_action( 'admin_init', 'sau_custom_options' );

/**
 * Print the input on the options page
 * @return null 
 * 
 * @since 0.1
 */
function sau_mode_html()
{
	$setting = esc_attr( get_option( 'sau_mode', 'automatic' ) );

	$options = array( 
		'automatic'			=> __(
			'Update automatically', 
			'simple-automatic-updates'
		), 
		'automatic-silent'	=> __(
			'Update automatically (no email)', 
			'simple-automatic-updates'
		), 
		'manual'			=> __(
			'Inform about available updates once a week', 
			'simple-automatic-updates' 
		) 
	);

	$output = "<select name='sau_mode'>";

	foreach( $options as $value => $option )
	{
		$output .= "<option value='$value'";
		if ( $value == $setting ) 
			$output .= ' selected';
		$output .= ">$option</option>";
	}

	$output .= '</select>';
	$output .= '<p class="description">';
	$output .= __(
		'A notification about available updates or updates made will be sent to the admin email address.', 
		'simple-automatic-updates' 
	);
	$output .= '</p>';

	echo $output;

	return null;
}



