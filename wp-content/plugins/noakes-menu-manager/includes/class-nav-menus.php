<?php
/**
 * Nav menus functionality.
 * 
 * @since 1.1.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Nav Menus
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Nav_Menus'))
{
	final class Noakes_Menu_Manager_Nav_Menus extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Constructor function.
		 * 
		 * @since 1.1.2 Added functionality for AJAX calls.
		 * @since 1.1.1 Moved nav menu specific action and filter hooks to the page load call.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base Base plugin object.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base)
		{
			parent::__construct($base);

			if ($this->_base->settings->active_class != '')
			{
				add_filter('nav_menu_css_class', array($this, 'nav_menu_css_class'), 10, 2);
			}

			if ($this->_base->settings->enable_id || $this->_base->settings->exclude_default_ids)
			{
				add_filter('nav_menu_item_id', array($this, 'nav_menu_item_id'), 10, 2);
			}

			if ($this->_base->settings->enable_query_string || $this->_base->settings->enable_anchor)
			{
				add_filter('nav_menu_link_attributes', array($this, 'nav_menu_link_attributes'), 10, 2);
			}
			
			if ($this->_cache->has_custom_fields)
			{
				add_filter('wp_setup_nav_menu_item', array($this, 'wp_setup_nav_menu_item'));
			}

			if (is_admin())
			{
				add_action('load-nav-menus.php', array($this, 'load_nav_menus'));

				if (Noakes_Menu_Manager_Utilities::is_ajax_action('add-menu-item'))
				{
					add_action('admin_init', array($this, 'load_nav_menus'));
				}
			}
		}

		/**
		 * Get a default property based on the provided name.
		 * 
		 * @since 1.1.0
		 * 
		 * @access protected
		 * @param  string $name Name of the property to return.
		 * @return string       Default property if it exists, otherwise an empty string.
		 */
		protected function _default($name)
		{
			switch ($name)
			{
				case 'active_classes':

					return array
					(
						'current-menu-item',
						'current-menu-parent',
						'current-menu-ancestor',
						'current_page_item',
						'current_page_parent',
						'current_page_ancestor'
					);

				case 'collapse_expand_all_added':

					return false;
			}

			return parent::_default($name);
		}

		/**
		 * Add the active class to appropriate menu items.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  array  $classes Array of menu item classes.
		 * @param  object $item    Nav menu item data object.
		 * @return array           Modified array of menu item classes.
		 */
		public function nav_menu_css_class($classes, $item)
		{
			$intersecting = array_intersect($this->active_classes, $classes);

			if (!empty($intersecting))
			{
				$classes[] = $this->_base->settings->active_class;
			}

			return $classes;
		}

		/**
		 * Modify menu item DOM IDs.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string $menu_id DOM ID of the current menu item.
		 * @param  object $item    Nav menu item object.
		 * @return string          Filtered menu item DOM ID.
		 */
		public function nav_menu_item_id($menu_id, $item)
		{
			if ($this->_base->settings->enable_id && !empty($item->noakes_id))
			{
				return $item->noakes_id;
			}

			return ($this->_base->settings->exclude_default_ids) ? '' : $menu_id;
		}

		/**
		 * Modify menu item link attributes.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string $atts Initial link attributes.
		 * @param  object $item Nav menu item object.
		 * @return string       Filtered link attributes.
		 */
		public function nav_menu_link_attributes($atts, $item)
		{
			$href_pieces = explode('#', $atts['href']);

			if ($this->_base->settings->enable_query_string && !empty($item->noakes_query_string))
			{
				$href_pieces[0] .= (strpos($href_pieces[0], '?') === false) ? '?' : '&';
				$href_pieces[0] .= $item->noakes_query_string;
			}

			if ($this->_base->settings->enable_anchor && $item->noakes_anchor != '')
			{
				$href_pieces[1] = $item->noakes_anchor;
			}

			$atts['href'] = $href_pieces[0];

			if (isset($href_pieces[1]) && $href_pieces[1] != '')
			{
				$atts['href'] .= '#' . $href_pieces[1];
			}

			return $atts;
		}

		/**
		 * Setup a nav menu item.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  object $menu_item Nav menu item object.
		 * @return string            Filtered nav menu item object.
		 */
		public function wp_setup_nav_menu_item($menu_item)
		{
			$menu_item->noakes_id = ($this->_base->settings->enable_id) ? get_post_meta($menu_item->ID, '_menu_item_noakes_id', true) : '';
			$menu_item->noakes_query_string = ($this->_base->settings->enable_query_string) ? get_post_meta($menu_item->ID, '_menu_item_noakes_query_string', true) : '';
			$menu_item->noakes_anchor = ($this->_base->settings->enable_anchor) ? get_post_meta($menu_item->ID, '_menu_item_noakes_anchor', true) : '';

			return $menu_item;
		}

		/**
		 * Load nav menus page functionality.
		 * 
		 * @since 1.2.5 Moved collapse/expand buttons to the primary action hook.
		 * @since 1.1.1 Moved nav menu specific action and filter hooks from the constructor.
		 * @since 1.0.2
		 * 
		 * @access public
		 * @return void
		 */
		public function load_nav_menus()
		{
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 11);

			if ($this->_base->settings->enable_collapse_expand || $this->_cache->has_custom_fields)
			{
				add_filter('wp_edit_nav_menu_walker', array($this, 'wp_edit_nav_menu_walker'), 99);
			}

			if ($this->_base->settings->enable_collapse_expand)
			{
				add_filter('admin_body_class', array($this, 'admin_body_class'));
				add_action('wp_nav_menu_item_custom_fields', array($this, 'wp_nav_menu_item_custom_buttons'), 9, 4);
			}

			if ($this->_cache->has_custom_fields)
			{
				add_action('wp_nav_menu_item_custom_fields', array($this, 'wp_nav_menu_item_custom_fields'), 9, 4);
				add_action('wp_update_nav_menu_item', array($this, 'wp_update_nav_menu_item'), 11, 2);
				add_filter('manage_nav-menus_columns', array($this, 'manage_columns'), 11);
			}

			$this->add_help_tabs();
		}

		/**
		 * Enqueues scripts for the nav menus page.
		 * 
		 * @since 1.3.0 Changed asset paths.
		 * @since 1.1.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_enqueue_scripts()
		{
			wp_enqueue_style('nmm-admin-nav-menus', $this->_base->assets_url . 'styles/admin-nav-menus.css', array('nmm-admin'), NMM_VERSION);
			wp_enqueue_script('nmm-admin-nav-menus', $this->_base->assets_url . 'scripts/admin-nav-menus.js', array('nmm-admin'), NMM_VERSION, true);
		}

		/**
		 * Filter the Walker class used when adding nav menu items.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return string Class name of the Walker to use.
		 */
		public function wp_edit_nav_menu_walker()
		{
			return 'Noakes_Walker_Nav_Menu_Edit';
		}

		/**
		 * Add additional classes to the nav menu BODY tag.
		 * 
		 * @since 1.1.0
		 * 
		 * @access public
		 * @param  string $classes Existing classes.
		 * @return string          Modified classes.
		 */
		public function admin_body_class($classes)
		{
			global $wp_version;

			$classes .= (empty($classes)) ? '' : ' ';
			$classes .= 'nmm-collapse-expand-enabled';
			$classes .= (version_compare($wp_version, '4.6.dev', '<')) ? ' pre-4-6' : '';

			return $classes;
		}

		/**
		 * Output the nav menu collapse/expand buttons.
		 * 
		 * @since 1.2.5 Moved functionality to the primary action hook.
		 * @since 1.1.0
		 * 
		 * @access public
		 * @param  integer $item_id ID of the nav menu item.
		 * @param  object  $item    Nav menu item object.
		 * @param  integer $depth   Depth of menu item. Used for padding.
		 * @param  array   $args    Not used.
		 * @return void
		 */
		public function wp_nav_menu_item_custom_buttons($item_id, $item, $depth, $args)
		{
			echo '<div class="nmm-buttons hidden">';

			if (!$this->collapse_expand_all_added)
			{
				$this->collapse_expand_all_added = true;

				echo '<div class="nmm-collapse-expand-all">' .
					'<button type="button" class="nmm-collapse-all button">' . $this->_cache->collapse_span . ' ' . sprintf($this->_cache->all, $this->_cache->collapse) . '</button>' .
					'<button type="button" class="nmm-expand-all button">' . $this->_cache->expand_span . ' ' . sprintf($this->_cache->all, $this->_cache->expand) . '</button>' .
					$this->_base->displays->help_button('nmm-collapse-expand') .
					'</div>';
			}

			echo '<a href="javascript:;" class="nmm-collapse-expand">' .
				$this->_cache->collapse_span .
				$this->_cache->expand_span .
				'</a>' .
				'</div>';
		}

		/**
		 * Add custom fields to nav menu items.
		 * 
		 * @since 1.0.2 Added nonce.
		 * @since 1.0.1 Added unused arguments for compatibility.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  integer $item_id ID of the nav menu item.
		 * @param  object  $item    Nav menu item object.
		 * @param  integer $depth   Depth of menu item. Used for padding.
		 * @param  array   $args    Not used.
		 * @return void
		 */
		public function wp_nav_menu_item_custom_fields($item_id, $item, $depth, $args)
		{
			wp_nonce_field(NMM_TOKEN, NMM_TOKEN . '_nonce', false);

			if ($this->_base->settings->enable_id)
			{
				$this->_base->displays->menu_edit_field('noakes-id', $item_id, $item);
			}

			if ($this->_base->settings->enable_query_string)
			{
				$this->_base->displays->menu_edit_field('noakes-query-string', $item_id, $item);
			}

			if ($this->_base->settings->enable_anchor)
			{
				$this->_base->displays->menu_edit_field('noakes-anchor', $item_id, $item);
			}
		}

		/**
		 * Fires after a navigation menu item has been updated.
		 * 
		 * @since 1.0.3 Added removal of leading and trailing redundancies.
		 * @since 1.0.2 Added nonce check and added post meta deletion.
		 * @since 1.0.1 Added flags to prevent undefined index notices.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  integer $menu_id         ID of the updated menu.
		 * @param  integer $menu_item_db_id ID of the updated menu item.
		 * @return void
		 */
		public function wp_update_nav_menu_item($menu_id, $menu_item_db_id)
		{
			if (!isset($_POST[NMM_TOKEN . '_nonce']) || !wp_verify_nonce($_POST[NMM_TOKEN . '_nonce'], NMM_TOKEN)) return;

			if ($this->_base->settings->enable_id && isset($_POST['menu-item-noakes-id']) && !empty($_POST['menu-item-noakes-id'][$menu_item_db_id]))
			{
				update_post_meta($menu_item_db_id, '_menu_item_noakes_id', Noakes_Menu_Manager_Utilities::remove_redundancies($_POST['menu-item-noakes-id'][$menu_item_db_id]));
			}
			else
			{
				delete_post_meta($menu_item_db_id, '_menu_item_noakes_id');
			}

			if ($this->_base->settings->enable_query_string && isset($_POST['menu-item-noakes-query-string']) && !empty($_POST['menu-item-noakes-query-string'][$menu_item_db_id]))
			{
				update_post_meta($menu_item_db_id, '_menu_item_noakes_query_string', Noakes_Menu_Manager_Utilities::remove_redundancies($_POST['menu-item-noakes-query-string'][$menu_item_db_id]));
			}
			else
			{
				delete_post_meta($menu_item_db_id, '_menu_item_noakes_query_string');
			}

			if ($this->_base->settings->enable_anchor && isset($_POST['menu-item-noakes-anchor']) && !empty($_POST['menu-item-noakes-anchor'][$menu_item_db_id]))
			{
				update_post_meta($menu_item_db_id, '_menu_item_noakes_anchor', Noakes_Menu_Manager_Utilities::remove_redundancies($_POST['menu-item-noakes-anchor'][$menu_item_db_id]));
			}
			else
			{
				delete_post_meta($menu_item_db_id, '_menu_item_noakes_anchor');
			}
		}

		/**
		 * Returns the columns for the nav menus page.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return array Nav menu columns.
		 */
		public function manage_columns()
		{
			$columns = array
			(
				'_title' => __('Show advanced menu properties', 'noakes-menu-manager'),
				'cb' => '<input type="checkbox" />',
				'link-target' => __('Link Target', 'noakes-menu-manager'),
				'title-attribute' => __('Title Attribute', 'noakes-menu-manager'),
				'css-classes' => __('CSS Classes', 'noakes-menu-manager'),
				'xfn' => __('Link Relationship (XFN)', 'noakes-menu-manager'),
				'description' => $this->_cache->description
			);

			if ($this->_base->settings->enable_id)
			{
				$columns['noakes-id'] = $this->_cache->noakes_id;
			}

			if ($this->_base->settings->enable_query_string)
			{
				$columns['noakes-query-string'] = $this->_cache->noakes_query_string;
			}

			if ($this->_base->settings->enable_anchor)
			{
				$columns['noakes-anchor'] = $this->_cache->noakes_anchor;
			}

			return $columns;
		}

		/**
		 * Add the help tabs to the page.
		 * 
		 * @since 1.4.0 Added check for disabled help tabs.
		 * @since 1.1.2 Added empty screen object check.
		 * @since 1.1.0
		 * 
		 * @access private
		 * @return void
		 */
		private function add_help_tabs()
		{
			if (!$this->_base->settings->disable_help_tabs)
			{
				$screen = (function_exists('get_current_screen')) ? get_current_screen() : '';

				if (!empty($screen))
				{
					if ($this->_base->settings->enable_collapse_expand)
					{
						$screen->add_help_tab(array
						(
							'id' => 'nmm-collapse-expand',
							'title' => $this->_cache->collapse_expand,

							'content' => '<h3>' . sprintf($this->_cache->plugin_heading, $this->_cache->plugin, $this->_cache->collapse_expand) . '</h3>' .
								'<h4 style="margin-bottom: -10px;">' . __('Overview', 'noakes-menu-manager') . '</h4>' .
								'<p>' . sprintf(__('Nav menu items with children now have collapse (%1$s) and expand (%2$s) buttons on the right side of the menu item bar. Clicking on these buttons will hide/show child nav menu items accordingly. There are also collapse and expand all buttons above the menu to quickly hide or show all child nav menu items.', 'noakes-menu-manager'), $this->_cache->collapse_span, $this->_cache->expand_span) . '</p>' .
								'<h4 style="margin-bottom: -10px;">' . __('Ordering', 'noakes-menu-manager') . '</h4>' .
								'<ul>' .
								'<li>' . __('While dragging a nav menu item, hover over a collapsed nav menu item for one second to expand it.', 'noakes-menu-manager') . '</li>' .
								'<li>' . __('When a nav menu item is dropped into a collapsed nav menu item, that item will expand automatically.', 'noakes-menu-manager') . '</li>' .
								'</ul>'
						));
					}

					if ($this->_cache->has_custom_fields)
					{
						$field_count = 0;
						$content = '';

						if ($this->_base->settings->enable_id)
						{
							$field_count++;

							$content .= '<h4 style="margin-bottom: -10px;">' . $this->_cache->noakes_id . '</h4>' .
								'<p>' . sprintf(__('The %s ID for the list item. If default IDs are enabled, this will replace the default.', 'noakes-menu-manager'), $this->_cache->dom) . '</p>';
						}

						if ($this->_base->settings->enable_query_string)
						{
							$field_count++;

							$content .= '<h4 style="margin-bottom: -10px;">' . $this->_cache->noakes_query_string . '</h4>' .
								'<p>' . __('Query string values for the URL. If the URL already contains a query string, this will be appended.', 'noakes-menu-manager') . '</p>';
						}

						if ($this->_base->settings->enable_anchor)
						{
							$field_count++;

							$content .= '<h4 style="margin-bottom: -10px;">' . $this->_cache->noakes_anchor . '</h4>' .
								'<p>' . __('Appended to the end of the URL. If an anchor already exists in the URL, it will be replaced.', 'noakes-menu-manager') . '</p>';
						}

						$screen->add_help_tab(array
						(
							'id' => 'nmm-custom-fields',
							'title' => __('Custom Fields', 'noakes-menu-manager'),

							'content' => '<h3>' . sprintf(_n('%s Custom Field', '%s Custom Fields', $field_count, 'noakes-menu-manager'), $this->_cache->plugin) . '</h3>' .
								$content
						));
					}
				}
			}
		}
	}
}
