<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

$theme_version_from_stylesheet = wp_get_theme();

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://cpothemes.com', // Site where EDD is hosted
		'item_name'      => 'Affluent Pro', // Name of theme
		'theme_slug'     => 'affluent_pro', // Theme slug
		'version'        => $theme_version_from_stylesheet->get('Version'), // The current version of this theme
		'author'         => 'CPOThemes', // The author of this theme
		'download_id'    => '', // Optional, used for generating a license renewal link
		'renew_url'      => '', // Optional, allows for a custom license renewal link
		'beta'           => false, // Optional, set to true to opt into beta versions
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'affluent' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'affluent' ),
		'license-key'               => __( 'License Key', 'affluent' ),
		'license-action'            => __( 'License Action', 'affluent' ),
		'deactivate-license'        => __( 'Deactivate License', 'affluent' ),
		'activate-license'          => __( 'Activate License', 'affluent' ),
		'status-unknown'            => __( 'License status is unknown.', 'affluent' ),
		'renew'                     => __( 'Renew?', 'affluent' ),
		'unlimited'                 => __( 'unlimited', 'affluent' ),
		'license-key-is-active'     => __( 'License key is active.', 'affluent' ),
		'expires%s'                 => __( 'Expires %s.', 'affluent' ),
		'expires-never'             => __( 'Lifetime License.', 'affluent' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'affluent' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'affluent' ),
		'license-key-expired'       => __( 'License key has expired.', 'affluent' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'affluent' ),
		'license-is-inactive'       => __( 'License is inactive.', 'affluent' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'affluent' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'affluent' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'affluent' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'affluent' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'affluent' ),
	)

);
