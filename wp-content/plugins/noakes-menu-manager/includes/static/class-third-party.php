<?php
/**
 * Functionality for third-party plugins.
 *
 * @since 1.4.0 Made class functions static.
 * @since 1.2.2
 * 
 * @package    Nav Menu Manager
 * @subpackage Third-Party
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Third_Party'))
{
	final class Noakes_Menu_Manager_Third_Party
	{
		/**
		 * Remove third-party plugin meta boxes from the settings page.
		 * 
		 * @since 1.4.0 Made function static.
		 * @since 1.2.3 Revolution Slider meta box removal refinement.
		 * @since 1.2.2
		 * 
		 * @access public static
		 * @return void
		 */
		public static function remove_settings_meta_boxes()
		{
			add_action('add_meta_boxes', array('Noakes_Menu_Manager_Third_Party', 'remove_third_party_meta_boxes'), 99);
		}

		/**
		 * Remove third-party plugin meta boxes.
		 * 
		 * @since 1.4.0 Made function static.
		 * @since 1.2.3
		 * 
		 * @access public static
		 * @return void
		 */
		public static function remove_third_party_meta_boxes()
		{
			$screen = get_current_screen();

			remove_meta_box('mymetabox_revslider_0', $screen->id, 'normal');
		}
	}
}
