<?php
/**
 * Plugin template functions.
 * 
 * @since 1.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Template Functions
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!function_exists('nmm_custom_field'))
{
	/**
	 * Generates output for a custom nav menu field.
	 * 
	 * @since 1.1.1
	 * 
	 * @param  string  $name    Input name for the field.
	 * @param  integer $item_id Escaped nav menu item ID.
	 * @param  object  $item    Nav menu item object.
	 * @param  string  $label   Optional label for the field.
	 * @return void
	 */
	function nmm_custom_field($name, $item_id, $item, $label = '')
	{
		Noakes_Menu_Manager()->displays->menu_edit_field($name, $item_id, $item, $label, '');
	}
}

if (!function_exists('nmm_ends_with'))
{
	/**
	 * Check to see if a full string ends with a specified ending string.
	 * 
	 * @since 1.4.0
	 * 
	 * @param  string  $needle   Ending string to check for.
	 * @param  string  $haystack Full string to check for the ending string.
	 * @return boolean True if the full string ends with the specified ending string.
	 */
	function nmm_ends_with($needle, $haystack)
	{
		return Noakes_Menu_Manager_Utilities::ends_with($needle, $haystack);
	}
}

if (!function_exists('nmm_is_ajax_action'))
{
	/**
	 * Check to see if an AJAX action is being executed.
	 * 
	 * @since 1.2.0
	 * 
	 * @param  string  $action Action to check for.
	 * @return boolean         True if the action is being executed.
	 */
	function nmm_is_ajax_action($action)
	{
		return Noakes_Menu_Manager_Utilities::is_ajax_action($action);
	}
}

if (!function_exists('nmm_sanitize_classes'))
{
	/**
	 * Sanitize CSS classes.
	 * 
	 * @since 1.1.1
	 * 
	 * @param  string $raw_classes Raw CSS classes to sanitize.
	 * @return string              Sanitized CSS classes.
	 */
	function nmm_sanitize_classes($raw_classes)
	{
		return Noakes_Menu_Manager_Utilities::sanitize_classes($raw_classes);
	}
}

if (!function_exists('nmm_starts_with'))
{
	/**
	 * Check to see if a full string starts with a specified starting string.
	 * 
	 * @since 1.4.0
	 * 
	 * @param  string  $needle   Starting string to check for.
	 * @param  string  $haystack Full string to check for the starting string.
	 * @return boolean True if the full string starts with the specified starting string.
	 */
	function nmm_starts_with($needle, $haystack)
	{
		return Noakes_Menu_Manager_Utilities::starts_with($needle, $haystack);
	}
}
