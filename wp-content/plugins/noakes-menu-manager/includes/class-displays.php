<?php
/**
 * Functionality for displaying content.
 * 
 * @since 1.2.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Displays
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Displays'))
{
	final class Noakes_Menu_Manager_Displays extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Add global help tabs to the current page.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @param  WP_Screen $screen Current WP_Screen object.
		 * @return void
		 */
		public function global_help_tabs($screen)
		{
			$template_functions = __('Template Functions', 'noakes-menu-manager');

			$screen->add_help_tab(array
			(
				'id' => 'nmm-template-functions',
				'title' => $template_functions,

				'content' => '<h3>' . $template_functions . '</h3>' .
					'<h4 style="margin-bottom: -10px;">nmm_custom_field($name, $item_id, $item)</h4>' .
					'<p style="margin-bottom: -10px;">' . __('Generates output for a custom nav menu field. It currently generates just a basic text field. The function accepts three arguments:', 'noakes-menu-manager') . '</p>' .
					'<ul>' .
					'<li>' . sprintf(__('%s - Input name for the field.', 'noakes-menu-manager'), '<em>$name (string)</em>') . '</li>' .
					'<li>' . sprintf($this->_cache->nav_menu_item_id, '<em>$item_id (integer)</em>') . '</li>' .
					'<li>' . sprintf($this->_cache->nav_menu_item_object, '<em>$item (object)</em>') . '</li>' .
					'</ul>' .
					'<h4 style="margin-bottom: -10px;">nmm_ends_with($needle, $haystack)</h4>' .
					'<p style="margin-bottom: -10px;">' . __('Check to see if a full string ends with a specified enging string. The function accepts two arguments:', 'noakes-menu-manager') . '</p>' .
					'<ul>' .
					'<li>' . sprintf(__('%s - Ending string to check for.', 'noakes-menu-manager'), '<em>$needle (string)</em>') . '</li>' .
					'<li>' . sprintf(__('%s - Full string to check for the ending string.', 'noakes-menu-manager'), '<em>$haystack (string)</em>') . '</li>' .
					'</ul>' .
					'<h4 style="margin-bottom: -10px;">nmm_is_ajax_action($action)</h4>' .
					'<p style="margin-bottom: -10px;">' . __('Check to see if an AJAX action is being executed. Returns a boolean result. The function accepts one argument:', 'noakes-menu-manager') . '</p>' .
					'<ul>' .
					'<li>' . sprintf(__('%s - AJAX action to check for.', 'noakes-menu-manager'), '<em>$action (string)</em>') . '</li>' .
					'</ul>' .
					'<h4 style="margin-bottom: -10px;">nmm_sanitize_classes($raw_classes)</h4>' .
					'<p style="margin-bottom: -10px;">' . __('Sanitizes CSS classes in a string and returns the sanitized string. The function accepts one argument:', 'noakes-menu-manager') . '</p>' .
					'<ul>' .
					'<li>' . sprintf(__('%s - Raw CSS classes to sanitize.', 'noakes-menu-manager'), '<em>$raw_classes (string)</em>') . '</li>' .
					'</ul>' .
					'<h4 style="margin-bottom: -10px;">nmm_starts_with($needle, $haystack)</h4>' .
					'<p style="margin-bottom: -10px;">' . __('Check to see if a full string starts with a specified starting string. The function accepts two arguments:', 'noakes-menu-manager') . '</p>' .
					'<ul>' .
					'<li>' . sprintf(__('%s - Starting string to check for.', 'noakes-menu-manager'), '<em>$needle (string)</em>') . '</li>' .
					'<li>' . sprintf(__('%s - Full string to check for the starting string.', 'noakes-menu-manager'), '<em>$haystack (string)</em>') . '</li>' .
					'</ul>'
			));

			$action_hook = __('Action Hook', 'noakes-menu-manager');

			$screen->add_help_tab(array
			(
				'id' => 'nmm-action-hook',
				'title' => $action_hook,

				'content' => '<h3>' . $action_hook . '</h3>' .
					'<h4 style="margin-bottom: -10px;">wp_nav_menu_item_custom_fields</h4>' .
					'<p style="margin-bottom: -10px;">' . __('Add custom fields and collapse/expand buttons to nav menus. This action is not executed if the nav menu edit walker is incompatible. The hook accepts four arguments:', 'noakes-menu-manager') . '</p>' .
					'<ul>' .
					'<li>' . sprintf($this->_cache->nav_menu_item_id, '<em>$item_id</em>') . '</li>' .
					'<li>' . sprintf($this->_cache->nav_menu_item_object, '<em>$item</em>') . '</li>' .
					'<li>' . sprintf(__('%s - Depth of menu item. Used for padding.', 'noakes-menu-manager'), '<em>$depth</em>') . '</li>' .
					'<li>' . sprintf(__('%s - Not used.', 'noakes-menu-manager'), '<em>$args</em>') . '</li>' .
					'</ul>'
			));
		}
		
		/**
		 * Generates a button that opens a specified help tab.
		 * 
		 * @since 1.4.1 Fixed customizer preview function call for ealier versions of WordPress.
		 * @since 1.4.0 Prevented buttons from appearing in the Customizer. Buttons can now be added in a disabled state.
		 * @since 1.2.0 Moved from the utilities class and made help tab ID optional.
		 * @since 1.1.0
		 * 
		 * @access public
		 * @param  string  $help_tab_id Optional ID for the help tab to open.
		 * @param  boolean $disabled    Optional flag to disable the help button by default.
		 * @return string               Generated help button.
		 */
		public function help_button($help_tab_id = '', $disabled = false)
		{
			if (function_exists('is_customize_preview') && is_customize_preview()) return '';
			
			$leading_space = (empty($help_tab_id)) ? '' : ' ';
			$class = ($disabled) ? ' nmm-disabled' : '';

			return (empty($this->_base->settings->disable_help_buttons) || empty($leading_space)) ? $leading_space . '<a href="javascript:;" title="' . esc_attr($this->_cache->help) . '" class="nmm-help-button dashicons dashicons-editor-help' . $class . '" tabindex="-1" data-nmm-help-tab-id="' . esc_attr($help_tab_id) . '">' . $this->_cache->help . '</a>' : '';
		}

		/**
		 * Outputs a nav menu item field.
		 * 
		 * @since 1.2.0 Moved from the utilities class.
		 * @since 1.1.0 Added optional help tab ID argument.
		 * @since 1.0.4 Added optional label argument.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string  $name        Input name for the field.
		 * @param  integer $item_id     Escaped nav menu item ID.
		 * @param  object  $item        Nav menu item object.
		 * @param  string  $label       Optional label for the field.
		 * @param  string  $help_tab_id Optional ID for the help tab associated with this field.
		 * @return void
		 */
		public function menu_edit_field($name, $item_id, $item, $label = '', $help_tab_id = 'nmm-custom-fields')
		{
			$name = esc_attr($name);
			$index = str_replace('-', '_', $name);
			$label = (empty($label)) ? $this->_cache->$index : $label;
			$label .= $this->help_button($help_tab_id);

			echo '<p class="field-' . $name . ' description description-wide">' .
				'<label for="edit-menu-item-' . $name . '-' . $item_id . '">' .
				$label . '<br />' .
				'<input type="text" id="edit-menu-item-' . $name . '-' . $item_id . '" class="widefat edit-menu-item-' . $name . '" name="menu-item-' . $name . '[' . $item_id . ']" value="' . esc_attr($item->$index) . '" />' .
				'</label>' .
				'</p>';
		}

		/**
		 * Outputs an options page.
		 * 
		 * @since 1.4.0 Added tabs output and removed the reset query string from the HTTP referrer.
		 * @since 1.2.0 Moved from the utilities class.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string $option_name Option name to generate the page for.
		 * @param  string $heading     Optional heading to display at the top of the options page.
		 * @param  array  $tabs        Option array containing the tabs output.
		 * @return void
		 */
		public function options_page($option_name, $heading = '', $tabs = array())
		{
			$option_name = (empty($option_name)) ? '' : sanitize_key($option_name);

			if ($option_name != '')
			{
				$heading = ($heading == '') ? $this->_cache->plugin : $heading;
				$tabs = Noakes_Menu_Manager_Utilities::check_array($tabs);
				$screen = get_current_screen();
				$columns = $screen->get_columns();
				$columns = (empty($columns)) ? 2 : $columns;

				echo '<div id="' . $option_name . '" class="wrap">' .
					'<h1>' . $heading . '</h1>' .
					'<form action="options.php" method="post">';

				if (!empty($tabs))
				{
					echo '<h2 class="nav-tab-wrapper">';
					
					foreach ($tabs as $page => $name)
					{
						$active_class = (Noakes_Menu_Manager_Utilities::ends_with($page, $screen->id)) ? ' nav-tab-active' : '';
						
						echo '<a href="' . esc_url(get_admin_url(null, 'options-general.php?page=' . $page)) . '" class="nav-tab' . $active_class . '">' . $name . '</a>';
					}
					
					echo '</h2>';
				}
				
				ob_start();
				
				settings_fields($option_name);
				wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
				wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
				
				echo str_replace(array('&reset=true', '&amp;reset=true', 'reset=true&', 'reset=true&amp;'), '', ob_get_clean()) .
					'<div id="poststuff">' .
					'<div id="post-body" class="metabox-holder columns-' . $columns . '">' .
					'<div id="postbox-container-1" class="postbox-container">';

				do_meta_boxes($screen->id, 'side', '');

				echo '</div>' .
					'<div id="postbox-container-2" class="postbox-container">';

				do_meta_boxes($screen->id, 'advanced', '');
				do_meta_boxes($screen->id, 'normal', '');

				echo '</div>' .
					'</div>' .
					'</div>' .
					'</form>' .
					'</div>';
			}
		}
	}
}
