<?php
/*
Plugin Name:       Add Search To Menu
Plugin URI:        http://freewptp.com/plugins/add-search-to-menu/
Description:       The plugin displays search form in the navigation bar which can be configured from the admin area.
Version:           1.0
Author:            Vinod Dalvi
Author URI:        http://freewptp.com
License:           GPL-2.0+
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
Domain Path:       /languages
Text Domain:       add-search-to-menu

Add Search To Menu plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Add Search To Menu plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Add Search To Menu plugin. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

/**
 * Changelog :
 * 1.0 - Intial release.
 */

/**
 * The file responsible for starting the Add Search To Menu plugin
 *
 * The Add Search To Menu is a plugin that can be used
 * to display search menu in the navigation bar. This particular file is responsible for
 * including the necessary dependencies and starting the plugin.
 *
 * @package ASTM
 */


/**
 * If this file is called directly, then abort execution.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die;
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-add-search-to-menu-activator.php
 */
function activate_add_search_to_menu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-add-search-to-menu-activator.php';
	Add_Search_To_Menu_Activator::activate();
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-add-search-to-menu-deactivator.php
 */
function deactivate_add_search_to_menu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-add-search-to-menu-deactivator.php';
	Add_Search_To_Menu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_add_search_to_menu' );
register_deactivation_hook( __FILE__, 'deactivate_add_search_to_menu' );


/**
 * Include the core class responsible for loading all necessary components of the plugin.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-add-search-to-menu.php';

/**
 * Instantiates the Add Search To Menu class and then
 * calls its run method officially starting up the plugin.
 */
function run_add_search_to_menu() {
	$ewpd = new Add_Search_To_Menu();
	$ewpd->run();
}

/**
 * Call the above function to begin execution of the plugin.
 */
run_add_search_to_menu();