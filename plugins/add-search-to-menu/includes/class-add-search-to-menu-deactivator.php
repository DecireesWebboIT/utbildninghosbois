<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       http://freewptp.com
 * @since      1.0.0
 * @package    ASTM
 * @subpackage ASTM/includes
 * @author     Free WPTP <freewptp@gmail.com>
 */
class Add_Search_To_Menu_Deactivator {

	/**
	 * Short Description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		$options = get_option( 'add_search_to_menu' );

		if ( isset( $options['dismiss_admin_notices'] ) ) {
			unset( $options['dismiss_admin_notices'] );
			update_option( 'add_search_to_menu', $options );
		}
	}

}