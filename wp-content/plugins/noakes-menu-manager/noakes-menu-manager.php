<?php
/**
 * Plugin Name: Nav Menu Manager
 * Plugin URI:  https://wordpress.org/plugins/noakes-menu-manager/
 * Description: Simplifies nav menu maintenance and functionality providing more control over nav menus with less coding.
 * Version:     1.4.2
 * Author:      Robert Noakes
 * Author URI:  http://robertnoak.es/
 * Text Domain: noakes-menu-manager
 * Domain Path: /languages/
 * Copyright:   (c) 2016 Robert Noakes (mr@robertnoak.es)
 * License:     GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */
 
/**
 * Main plugin file.
 * 
 * @since 1.4.0 Added generator and widgets classes. Made Third Party and Utilities classes static.
 * @since 1.2.2 Added third-party class.
 * @since 1.2.0 Changed 'lib' folder to 'standalone'.
 * @since 1.0.4 Added global variable for the plugin object.
 * @since 1.0.0
 * 
 * @package Nav Menu Manager
 * 
 * @todo Nav menu shortcode
 * @todo Nav menu item copy functionality
 */
 
if (!defined('ABSPATH')) exit;

$includes = dirname(__FILE__) . '/includes/';

require_once($includes . 'definitions.php');
require_once($includes . 'class-wrapper.php');
require_once($includes . 'class-base.php');
require_once($includes . 'class-cache.php');
require_once($includes . 'class-displays.php');
require_once($includes . 'class-settings.php');
require_once($includes . 'class-generator.php');
require_once($includes . 'class-nav-menus.php');
require_once($includes . 'class-widgets.php');
require_once($includes . 'template-functions.php');

$static = $includes . 'static/';

require_once($static . 'class-third-party.php');
require_once($static . 'class-utilities.php');

$standalone = $includes . 'standalone/';

require_once($standalone . 'class-meta-box.php');
require_once($standalone . 'class-field.php');
require_once($standalone . 'class-walker-nav-menu-edit.php');
require_once($standalone . 'class-widget-menu.php');

/**
 * Returns the main instance of Noakes_Menu_Manager.
 * 
 * @since 1.0.0
 * 
 * @return Noakes_Menu_Manager Main Noakes_Menu_Manager instance.
 */
function Noakes_Menu_Manager()
{
	return Noakes_Menu_Manager::_get_instance(__FILE__);
}

$GLOBALS['noakes_menu_manager'] = Noakes_Menu_Manager();
