<?php
/**
 * Cached functions, flags and strings.
 * 
 * @since 1.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Cache
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Cache'))
{
	final class Noakes_Menu_Manager_Cache extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Get a default cached item based on the provided name.
		 * 
		 * @since 1.0.0
		 * 
		 * @access protected
		 * @param  string $name Name of the cached item to return.
		 * @return string       Default cached item if it exists, otherwise an empty string.
		 */
		protected function _default($name)
		{
			switch ($name)
			{
				case 'active_class':

					return __('Active Class', 'noakes-menu-manager');

				case 'add_menu':

					return __('Add Menu', 'noakes-menu-manager');

				case 'all':

					return __('%s All', 'noakes-menu-manager');
					
				case 'before_after_link':
				
					return __('Before/After Link', 'noakes-menu-manager');
					
				case 'before_after_options':
				
					return array
					(
						'' => $this->none,
						'em' => sprintf($this->tag, 'EM'),
						'span' => sprintf($this->tag, 'SPAN'),
						'strong' => sprintf($this->tag, 'STRONG')
					);
					
				case 'before_after_text':
				
					return __('Before/After Text', 'noakes-menu-manager');

				case 'collapse':

					return __('Collapse', 'noakes-menu-manager');

				case 'collapse_span':

					return '<span title="' . esc_attr($this->collapse) . '" class="nmm-collapse">&ndash;</span>';

				case 'collapse_expand':

					return __('Collapse/Expand', 'noakes-menu-manager');
					
				case 'container':
				
					return __('Container', 'noakes-menu-manager');
					
				case 'container_classes':
				
					return __('Container Class(es)', 'noakes-menu-manager');
					
				case 'container_id':
				
					return __('Container ID', 'noakes-menu-manager');
					
				case 'container_options':
				
					return array
					(
						'' => $this->none,
						'div' => sprintf($this->tag, 'DIV'),
						'nav' => sprintf($this->tag, 'NAV')
					);

				case 'depth':

					return __('Depth', 'noakes-menu-manager');

				case 'depth_options':
				
					return array
					(
						__('No Limit', 'noakes-menu-manager'),
						1,
						2,
						3,
						4,
						5,
						6,
						7,
						8,
						9
					);

				case 'description':

					return __('Description', 'noakes-menu-manager');

				case 'developed_by':

					return __('Plugin developed by', 'noakes-menu-manager');

				case 'disable_help_buttons':

					return __('Disable Help Buttons', 'noakes-menu-manager');

				case 'disable_help_tabs':

					return __('Disable Help Tabs', 'noakes-menu-manager');

				case 'dom':

					return '<abbr title="' . esc_attr__('Document Object Model', 'noakes-menu-manager') . '">' . __('DOM', 'noakes-menu-manager') . '</abbr>';

				case 'enable_anchor':

					return __('Enable Anchor', 'noakes-menu-manager');

				case 'enable_collapse_expand':

					return __('Enable Collapse/Expand', 'noakes-menu-manager');

				case 'enable_id':

					return __('Enable ID', 'noakes-menu-manager');

				case 'enable_query_string':

					return __('Enable Query String', 'noakes-menu-manager');

				case 'enable_widget':

					return __('Enable Widget', 'noakes-menu-manager');

				case 'exclude_default_ids':

					return __('Exclude Default IDs', 'noakes-menu-manager');
					
				case 'exclude_arg':
				
					return __('Exclude argument from output', 'noakes-menu-manager');

				case 'existing_menus':

					return __('Existing Menus', 'noakes-menu-manager');

				case 'expand':

					return __('Expand', 'noakes-menu-manager');

				case 'expand_span':

					return '<span title="' . esc_attr($this->expand) . '" class="nmm-expand">+</span>';
					
				case 'fail_safe_code':
				
					return __('Fail-safe Code', 'noakes-menu-manager');
					
				case 'fallback_cb':
				
					return __('Fallback Callback', 'noakes-menu-manager');

				case 'four_seven':

					global $wp_version;

					return version_compare($wp_version, '4.7.dev', '>=');

				case 'general_settings':

					return __('General Settings', 'noakes-menu-manager');
					
				case 'generate':
				
					return __('Generate', 'noakes-menu-manager');
					
				case 'generator':
				
					return __('Generator', 'noakes-menu-manager');

				case 'has_custom_fields':

					return ($this->_base->settings->enable_id || $this->_base->settings->enable_query_string || $this->_base->settings->enable_anchor);

				case 'has_wpml':

					return Noakes_Menu_Manager_Utilities::is_plugin_active('sitepress-multilingual-cms/sitepress.php');

				case 'help':

					return __('Help', 'noakes-menu-manager');
					
				case 'help_sidebar':
				
					return '<h4 style="margin-bottom: -10px;">' . $this->developed_by . '</h4>' .
						'<p><a href="http://robertnoak.es/" target="_blank">Robert Noakes</a></p>' .
						'<hr />' .
						'<p><a href="' . $this->support_url . '" target="_blank" class="button">' . $this->support . '</a> <a href="' . $this->review_url . '" target="_blank" class="button">' . $this->review . '</a></p>';
						
				case 'include_arg':
				
					return __('Include argument in output with default value', 'noakes-menu-manager');

				case 'insert_menu':

					return '<span class="dashicons dashicons-plus"></span>';
					
				case 'is_generator':
				
					return (isset($_GET['page']) && $_GET['page'] == NMM_OPTION_GENERATOR);
					
				case 'item_spacing':
				
					return __('Item Spacing', 'noakes-menu-manager');
					
				case 'item_spacing_options':
				
					return array
					(
						'preserve' => __('Preserve', 'noakes-menu-manager'),
						'discard' => __('Discard', 'noakes-menu-manager')
					);

				case 'location':

					return __('Location', 'noakes-menu-manager');
					
				case 'menu_classes':
				
					return __('Menu Class(es)', 'noakes-menu-manager');
					
				case 'menu_id':
				
					return __('Menu ID', 'noakes-menu-manager');

				case 'menu_settings':

					return __('Menu Settings', 'noakes-menu-manager');

				case 'menus':

					return __('Menus', 'noakes-menu-manager');

				case 'move_menu':

					global $wp_version;

					return (version_compare($wp_version, '4.5.dev', '>=')) ? '<span class="dashicons dashicons-move"></span>' : '<span class="faux-dashicons"><img src="' . $this->_base->assets_url . 'images/move.png" height="40" width="40" alt="" /></span>';

				case 'move_menu_down':

					return '<span class="dashicons dashicons-arrow-down-alt"></span>';

				case 'move_menu_up':

					return '<span class="dashicons dashicons-arrow-up-alt"></span>';
					
				case 'nav_menu':
				
					return __('Nav Menu', 'noakes-menu-manager');

				case 'nav_menu_item_id':

					return __('%s - Escaped nav menu item ID.', 'noakes-menu-manager');

				case 'nav_menu_item_object':

					return __('%s - Nav menu item object.', 'noakes-menu-manager');

				case 'nmm_menu':

					return __('NMM Menu', 'noakes-menu-manager');

				case 'noakes_anchor':

					return __('Anchor', 'noakes-menu-manager');

				case 'noakes_id':

					return sprintf(__('%s ID', 'noakes-menu-manager'), $this->dom);

				case 'noakes_query_string':

					return __('Query String', 'noakes-menu-manager');

				case 'none':

					return __('None', 'noakes-menu-manager');

				case 'plugin':

					return __('Nav Menu Manager', 'noakes-menu-manager');

				case 'plugin_heading':

					return __('%1$s %2$s', 'noakes-menu-manager');

				case 'preserve_all_options':

					return __('Preserve All Options', 'noakes-menu-manager');

				case 'preserve_post_meta':

					return __('Preserve Post Meta', 'noakes-menu-manager');

				case 'registered_menus':

					return array();

				case 'remove_menu':

					return '<span class="dashicons dashicons-no"></span>';
					
				case 'review':
				
					return __('Review', 'noakes-menu-manager');
					
				case 'review_url':
				
					return 'https://wordpress.org/support/plugin/noakes-menu-manager/reviews/';

				case 'save_all':

					return array
					(
						'content' => __('Save All Settings', 'noakes-menu-manager'),
						'type' => 'submit'
					);

				case 'select':

					return __('Select %s', 'noakes-menu-manager');

				case 'settings':

					return __('Settings', 'noakes-menu-manager');
					
				case 'settings_tabs':
				
					return array
					(
						NMM_OPTION_SETTINGS => $this->settings,
						NMM_OPTION_GENERATOR => $this->generator
					);

				case 'site_menus':

					return __('Site Menus', 'noakes-menu-manager');
					
				case 'support':
				
					return __('Support', 'noakes-menu-manager');
					
				case 'support_url':
				
					return 'https://wordpress.org/support/plugin/noakes-menu-manager/';

				case 'tag':

					return __('%s Tag', 'noakes-menu-manager');
					
				case 'theme_location':
				
					return __('Theme Location', 'noakes-menu-manager');

				case 'uninstall_settings':

					return __('Uninstall Settings', 'noakes-menu-manager');
					
				case 'wp_nav_menu':
				
					return '<a href="https://developer.wordpress.org/reference/functions/wp_nav_menu/" target="_blank">wp_nav_menu</a>';
			}

			return parent::_default($name);
		}
	}
}
