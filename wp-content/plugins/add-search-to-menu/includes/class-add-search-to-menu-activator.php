<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       http://freewptp.com
 * @since      1.0.0
 * @package    ASTM
 * @subpackage ASTM/includes
 * @author     Free WPTP <freewptp@gmail.com>
 */
class Add_Search_To_Menu_Activator {

	/**
	 * Short Description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$options = get_option( 'add_search_to_menu' );

		if ( ! isset( $options['add_search_to_menu_locations'] ) ) {
			$options['add_search_to_menu_locations']['initial'] = 'initial';
			update_option( 'add_search_to_menu', $options );
		}
	}

}