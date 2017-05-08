<?php
/**
 * Settings page functionality.
 * 
 * @since 1.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Settings
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Settings'))
{
	final class Noakes_Menu_Manager_Settings extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Constructor function.
		 * 
		 * @since 1.4.2 Moved settings load to a separate method.
		 * @since 1.4.0 Added check for generator page.
		 * @since 1.0.4 Added CSS class sanitizing.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base Base plugin object.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base)
		{
			parent::__construct($base);
			
			$this->load_option();

			if (is_admin())
			{
				if (!$this->_cache->is_generator)
				{
					add_action('admin_init', array($this, 'admin_init'));
					add_action('admin_menu', array($this, 'admin_menu'));
				}

				add_filter('plugin_action_links_' . plugin_basename($this->_base->plugin), array($this, 'plugin_action_links'), 11);
			}
		}

		/**
		 * Get a default setting based on the provided name.
		 * 
		 * @since 1.0.4 Added defaults for booleans options.
		 * @since 1.0.0
		 * 
		 * @access protected
		 * @param  string $name Name of the setting to return.
		 * @return string       Default setting if it exists, otherwise an empty string.
		 */
		protected function _default($name)
		{
			switch ($name)
			{
				case 'disable':
				case 'menus':

					return array();

				case 'disable_help_buttons':
				case 'disable_help_tabs':
				case 'enable_anchor':
				case 'enable_id':
				case 'enable_query_string':
				case 'enable_widget':
				case 'exclude_default_ids':
				case 'preserve_all_options':
				case 'preserve_post_meta':

					return false;
			}

			return parent::_default($name);
		}
		
		/**
		 * Load the plugin settings option.
		 * 
		 * @since 1.4.2
		 * 
		 * @access public
		 * @param  array $settings Setting array to load, or null of the settings should be loaded from the database.
		 * @return void
		 */
		public function load_option($settings = null)
		{
			$settings = (empty($settings)) ? get_option(NMM_OPTION_SETTINGS) : $settings;
			
			$this->_properties = Noakes_Menu_Manager_Utilities::check_array($settings, true);
		}

		/**
		 * Register the settings option.
		 * 
		 * @since 1.4.1 Fixed sanitization callback for earlier versions of WordPress.
		 * @since 1.4.0 Added the sanitize callback.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_init()
		{
			register_setting(NMM_OPTION_SETTINGS, NMM_OPTION_SETTINGS, array($this, 'sanitize'));
		}
		
		/**
		 * Sanitize the settings.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @param  array $input Raw settings array.
		 * @return array        Sanitized settings array.
		 */
		public function sanitize($input)
		{
			foreach ($input as $name => $value)
			{
				if ($name == 'disable_help_tabs')
				{
					$input[$name] = (isset($input['disable_help_buttons']) && $input['disable_help_buttons']) ? $input[$name] : false;
				}
				else if ($name == 'disable')
				{
					if (!empty($input[$name]))
					{
						foreach ($input[$name] as $location => $value)
						{
							$input[$name][$location] = sanitize_text_field($value);
						}
					}
				}
				else if ($name == 'menus')
				{
					if (!empty($input[$name]))
					{
						foreach ($input[$name] as $i => $nav_menu)
						{
							$input[$name][$i]['location'] = sanitize_key($nav_menu['location']);
							$input[$name][$i]['description'] = sanitize_text_field($nav_menu['description']);
						}
					}
				}
				else if ($name == 'active_class')
				{
					$input[$name] = Noakes_Menu_Manager_Utilities::sanitize_classes($input[$name]);
				}
				else
				{
					$input[$name] = sanitize_text_field($input[$name]);
				}
			}
			
			return $input;
		}

		/**
		 * Add the settings page.
		 * 
		 * @since 1.2.0 Changed settings page title.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_menu()
		{
			$settings_page = add_options_page($this->_cache->plugin, $this->_cache->plugin, 'manage_options', NMM_OPTION_SETTINGS, array($this, 'settings_page'));
			
			add_action('load-' . $settings_page, array($this, 'load_settings'));
		}

		/**
		 * Generate the settings page.
		 * 
		 * @since 1.4.0 Added tabs output.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function settings_page()
		{
			$this->_base->displays->options_page(NMM_OPTION_SETTINGS, sprintf($this->_cache->plugin_heading, $this->_cache->plugin, $this->_cache->settings), $this->_cache->settings_tabs);
		}

		/**
		 * Load settings page functionality.
		 * 
		 * @since 1.1.1 Added admin body class filter hook.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function load_settings()
		{
			add_filter('admin_body_class', array($this, 'admin_body_class'));
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 11);

			add_screen_option('layout_columns', array
			(
				'default' => 2,
				'max' => 2
			));

			$screen = get_current_screen();

			$this->add_help_tabs($screen);
			$this->add_meta_boxes($screen);
		}

		/**
		 * Add additional classes to the plugin settings BODY tag.
		 * 
		 * @since 1.1.1
		 * 
		 * @access public
		 * @param  string $classes Existing classes.
		 * @return string          Modified classes.
		 */
		public function admin_body_class($classes)
		{
			global $wp_version;

			if (version_compare($wp_version, '4.2.dev', '<'))
			{
				$classes .= (empty($classes)) ? '' : ' ';
				$classes .= 'pre-4-2';
			}

			return $classes;
		}

		/**
		 * Enqueues scripts for the settings page.
		 * 
		 * @since 1.3.0 Changed asset paths.
		 * @since 1.0.4 Removed unused localization strings.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_enqueue_scripts()
		{
			wp_enqueue_style('nmm-admin-settings', $this->_base->assets_url . 'styles/admin-settings.css', array('nmm-admin'), NMM_VERSION);
			wp_enqueue_script('jquery-validate', '//ajax.aspnetcdn.com/ajax/jquery.validate/1.15.1/jquery.validate.min.js', array('jquery-core'), '1.15.1', true);
			wp_enqueue_script('nmm-admin-settings', $this->_base->assets_url . 'scripts/admin-settings.js', array('nmm-admin', 'jquery-validate', 'postbox', 'jquery-ui-draggable', 'jquery-ui-sortable'), NMM_VERSION, true);

			wp_localize_script('nmm-admin-settings', 'nmm_admin_settings_l10n', array
			(
				'validator' => array
				(
					'nmm-location' => __('Location names must be unique.', 'noakes-menu-manager'),
					'required' => __('This field is required.', 'noakes-menu-manager')
				)
			));
		}

		/**
		 * Add help tabs to the page.
		 * 
		 * @since 1.4.0 Added check for disabled help tabs. Moved help sidebar text to the cache and global help tabs to a separate function.
		 * @since 1.3.0 Removed the buttons action hook description.
		 * @since 1.2.0 Separated uninstall settings into a new tab.
		 * @since 1.1.0 Updated sanitize classes template function and added collapse/expand details.
		 * @since 1.0.4 Added widget-related help.
		 * @since 1.0.1 Changed action hook details.
		 * @since 1.0.0
		 * 
		 * @access private
		 * @param  WP_Screen $screen Current WP_Screen object.
		 * @return void
		 */
		private function add_help_tabs($screen)
		{
			if (!$this->disable_help_tabs)
			{
				$screen->set_help_sidebar($this->_cache->help_sidebar);

				$screen->add_help_tab(array
				(
					'id' => 'nmm-general-settings',
					'title' => $this->_cache->general_settings,

					'content' => '<h3>' . $this->_cache->general_settings . '</h3>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->enable_collapse_expand . '</h4>' .
						'<p>' . __('Allows for nested nav menu items to be collapsed and expanded simplifying the process of nav menu item maintenance.', 'noakes-menu-manager') . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->enable_widget . '</h4>' .
						'<p>' . sprintf(__('Adds the %1$s widget which can be added to sidebars. This nav menu widget provides more control over the settings used for the %2$s output.', 'noakes-menu-manager'), '<em>' . $this->_cache->nmm_menu . '</em>', $this->_cache->wp_nav_menu) . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->disable_help_buttons . '</h4>' .
						'<p>' . sprintf(__('Removes all help buttons (%1$s) associated with the %2$s functionality. The help buttons are meant for users that aren\'t yet familiar with the plugin.', 'noakes-menu-manager'), $this->_base->displays->help_button(), $this->_cache->plugin) . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->disable_help_tabs . '</h4>' .
						'<p>' . sprintf(__('Removes all help tabs associated with the %s functionality. The help tabs are meant for users that aren\'t yet familiar with the plugin.', 'noakes-menu-manager'), $this->_cache->plugin) . '</p>'
				));

				$screen->add_help_tab(array
				(
					'id' => 'nmm-site-menus',
					'title' => $this->_cache->site_menus,

					'content' => '<h3>' . $this->_cache->site_menus . '</h3>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->existing_menus . '</h4>' .
						'<p>' . sprintf(__('Lists nav menus that are added outside of the %s as well as their current assignments. Checking a box next to one of these menus will hide it from the nav menus page. If there are no existing menus, this field will not be displayed.', 'noakes-menu-manager'), $this->_cache->plugin) . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->menus . '</h4>' .
						'<p style="margin-bottom: -10px;">' . __('Repeatable field that allows for the quick registration of nav menus. They are maintained using the following functionality:', 'noakes-menu-manager') . '</p>' .
						'<ul>' .
						'<li>' . sprintf(__('%s Adds a new menu to the bottom of the list.', 'noakes-menu-manager'), '<span class="button nmm-button" style="vertical-align: baseline; cursor: default;">' . $this->_cache->add_menu . '</span>') . '</li>' .
						'<li>' . sprintf(__('%s Inserts a new menu above the menu clicked on.', 'noakes-menu-manager'), $this->_cache->insert_menu) . '</li>' .
						'<li>' . sprintf(__('%s Removes the menu from the list.', 'noakes-menu-manager'), $this->_cache->remove_menu) . '</li>' .
						'<li>' . sprintf(__('%s Handle for dragging the menu to a new position.', 'noakes-menu-manager'), $this->_cache->move_menu) . '</li>' .
						'<li>' . sprintf(__('%1$s%2$s Quickly swap positions with the menu above or below.', 'noakes-menu-manager'), $this->_cache->move_menu_down, $this->_cache->move_menu_up) . '</li>' .
						'</ul>'
				));

				$screen->add_help_tab(array
				(
					'id' => 'nmm-menu-settings',
					'title' => $this->_cache->menu_settings,

					'content' => '<h3>' . $this->_cache->menu_settings . '</h3>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->active_class . '</h4>' .
						'<p>' . sprintf(__('Any nav menu item containing a general WordPress active class will also get this class if it is entered. General WordPress active classes include %1$s. This functionality relies on the %2$s filter hook which is used in the default nav menu walker.', 'noakes-menu-manager'), '<em>' . implode(', ', $this->_base->nav_menus->active_classes) . '</em>', '<em>nav_menu_css_class</em>') . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->exclude_default_ids . '</h4>' .
						'<p>' . sprintf(__('Enabling this option will exclude the ID attribute from all list items in nav menus. This functionality relies on the %s filter hook which is used in the default nav menu walker.', 'noakes-menu-manager'), '<em>nav_menu_item_id</em>') . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->enable_id . '</h4>' .
						'<p>' . sprintf(__('Adds a %1$s ID field to nav menus. This functionality also relies on the %2$s filter hook.', 'noakes-menu-manager'), $this->_cache->dom, '<em>nav_menu_item_id</em>') . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->enable_query_string . '</h4>' .
						'<p>' . sprintf(__('Adds a field that allows query string values to be added to the nav menu item URL. If the URL already contains a query string, these values are appended. This functionality relies on the %s filter hook which is used in the default nav menu walker.', 'noakes-menu-manager'), '<em>nav_menu_link_attributes</em>') . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->enable_anchor . '</h4>' .
						'<p>' . sprintf(__('Allows and anchor to be added to the end of the nav menu item URL. If an anchor already exists in the URL, it is replaced by this value. This functionality also relies on the %s filter hook.', 'noakes-menu-manager'), '<em>nav_menu_link_attributes</em>') . '</p>'
				));

				$screen->add_help_tab(array
				(
					'id' => 'nmm-uninstall-settings',
					'title' => $this->_cache->uninstall_settings,

					'content' => '<h3>' . $this->_cache->uninstall_settings . '</h3>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->fail_safe_code . '</h4>' .
						'<p>' . sprintf(__('Outputs theme functions.php code based on the site menus registered by the %s. Adding this code to the theme will add a layer of protection to the site menus in the event of plugin deactivation or uninstallation.', 'noakes-menu-manager'), $this->_cache->plugin) . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->preserve_all_options . '</h4>' .
						'<p>' . sprintf(__('Allows for the %s settings to remain in the database after the plugin is uninstalled.', 'noakes-menu-manager'), $this->_cache->plugin) . '</p>' .
						'<h4 style="margin-bottom: -10px;">' . $this->_cache->preserve_post_meta . '</h4>' .
						'<p>' . __('When using the custom nav menu fields, post meta is added to the database for nav menu items. Enabling this option will allow for the post meta to remain in the database after the plugin is uninstalled.', 'noakes-menu-manager') . '</p>'
				));

				$this->_base->displays->global_help_tabs($screen);
			}
		}

		/**
		 * Add meta boxes to the page.
		 * 
		 * @since 1.4.0 Added Disable Help Tabs & Fail-safe Code fields. Moved finalize functionality to a separate function.
		 * @since 1.2.2 Removal of third-party plugin meta boxes.
		 * @since 1.2.1 Minor fix for qTranslateX.
		 * @since 1.2.0 Separated uninstall settings into a new meta box.
		 * @since 1.1.1 Moved side meta boxes to the Meta Box class.
		 * @since 1.1.0 Added collapse/expand setting.
		 * @since 1.0.4 Added Enable Widget setting to the Site Menus meta box.
		 * @since 1.0.0
		 * 
		 * @access private
		 * @param  WP_Screen $screen Current WP_Screen object.
		 * @return void
		 */
		private function add_meta_boxes($screen)
		{
			$general_settings_box = new Noakes_Menu_Manager_Meta_Box($this->_base, array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-general-settings',
				'name' => 'nmm_general_settings',
				'option_name' => NMM_OPTION_SETTINGS,
				'screen' => $screen,
				'title' => $this->_cache->general_settings
			));

			$general_settings_box->add_field(array
			(
				'description' => __('Add collapse/expand functionality will be added to nav menus.', 'noakes-menu-manager'),
				'label' => $this->_cache->enable_collapse_expand,
				'name' => 'enable_collapse_expand',
				'type' => 'checkbox',
				'value' => $this->enable_collapse_expand
			));

			$general_settings_box->add_field(array
			(
				'description' => sprintf(__('Make the %s widget available to use in sidebars.', 'noakes-menu-manager'), $this->_cache->nmm_menu),
				'label' => $this->_cache->enable_widget,
				'name' => 'enable_widget',
				'type' => 'checkbox',
				'value' => $this->enable_widget
			));

			$general_settings_box->add_field(array
			(
				'description' => sprintf(__('Remove help buttons specific to %s.', 'noakes-menu-manager'), $this->_cache->plugin),
				'label' => $this->_cache->disable_help_buttons,
				'name' => 'disable_help_buttons',
				'type' => 'checkbox',
				'value' => $this->disable_help_buttons
			));

			$general_settings_box->add_field(array
			(
				'classes' => ($this->disable_help_buttons) ? array() : array('hidden'),
				'description' => sprintf(__('Remove help tabs specific to %s.', 'noakes-menu-manager'), $this->_cache->plugin),
				'label' => $this->_cache->disable_help_tabs,
				'name' => 'disable_help_tabs',
				'type' => 'checkbox',
				'value' => $this->disable_help_tabs,
				
				'conditional' => array
				(
					array
					(
						'field' => 'disable_help_buttons',
						'value' => '1'
					)
				)
			));

			$general_settings_box->add_field($this->_cache->save_all);

			$site_menus_box = new Noakes_Menu_Manager_Meta_Box($this->_base, array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-site-menus',
				'name' => 'nmm_site_menus',
				'option_name' => NMM_OPTION_SETTINGS,
				'screen' => $screen,
				'title' => $this->_cache->site_menus
			));

			$site_menus_box->add_field(array
			(
				'complex' => true,
				'description' => __('Menus added by the theme or another plugin. Use the checkboxes to disable menus that aren\'t in use.', 'noakes-menu-manager'),
				'label' => $this->_cache->existing_menus,
				'name' => 'disable',
				'type' => 'existing_menus',
				'value' => $this->disable
			));

			$site_menus_box->add_field(array
			(
				'add_row' => $this->_cache->add_menu,
				'description' => __('Menus to register for the site.', 'noakes-menu-manager'),
				'label' => $this->_cache->menus,
				'layout' => 'row',
				'name' => 'menus',
				'repeatable' => true,
				'type' => 'group',
				'value' => $this->menus,

				'fields' => array
				(
					array
					(
						'description' => __('Menu location identifier, like a slug.', 'noakes-menu-manager'),
						'field_classes' => array('nmm-location'),
						'label' => $this->_cache->location,
						'name' => 'location',
						'required' => true,
						'type' => 'text'
					),

					array
					(
						'description' => __('Menu description that is displayed in the dashboard.', 'noakes-menu-manager'),
						'label' => $this->_cache->description,
						'name' => 'description',
						'required' => true,
						'type' => 'text'
					)
				)
			));

			$site_menus_box->add_field($this->_cache->save_all);

			$menu_settings_box = new Noakes_Menu_Manager_Meta_Box($this->_base, array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-menu-settings',
				'name' => 'nmm_menu_settings',
				'option_name' => NMM_OPTION_SETTINGS,
				'screen' => $screen,
				'title' => $this->_cache->menu_settings
			));

			$menu_settings_box->add_field(array
			(
				'description' => __('If entered, this class will be added to all active nav menu items.', 'noakes-menu-manager'),
				'label' => $this->_cache->active_class,
				'name' => 'active_class',
				'type' => 'text',
				'value' => $this->active_class
			));

			$menu_settings_box->add_field(array
			(
				'description' => sprintf(__('Remove default nav menu item %s IDs.', 'noakes-menu-manager'), $this->_cache->dom),
				'label' => $this->_cache->exclude_default_ids,
				'name' => 'exclude_default_ids',
				'type' => 'checkbox',
				'value' => $this->exclude_default_ids
			));

			$menu_settings_box->add_field(array
			(
				'description' => sprintf(__('Add a %s ID field to nav menu items.', 'noakes-menu-manager'), $this->_cache->dom),
				'label' => $this->_cache->enable_id,
				'name' => 'enable_id',
				'type' => 'checkbox',
				'value' => $this->enable_id
			));

			$menu_settings_box->add_field(array
			(
				'description' => __('Add a query string field to nav menu items.', 'noakes-menu-manager'),
				'label' => $this->_cache->enable_query_string,
				'name' => 'enable_query_string',
				'type' => 'checkbox',
				'value' => $this->enable_query_string
			));

			$menu_settings_box->add_field(array
			(
				'description' => __('Add an anchor field to nav menu items.', 'noakes-menu-manager'),
				'label' => $this->_cache->enable_anchor,
				'name' => 'enable_anchor',
				'type' => 'checkbox',
				'value' => $this->enable_anchor
			));

			$menu_settings_box->add_field($this->_cache->save_all);

			$uninstall_settings_box = new Noakes_Menu_Manager_Meta_Box($this->_base, array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-uninstall-settings',
				'name' => 'nmm_uninstall_settings',
				'option_name' => NMM_OPTION_SETTINGS,
				'screen' => $screen,
				'title' => $this->_cache->uninstall_settings
			));

			$uninstall_settings_box->add_field(array
			(
				'complex' => true,
				'description' => sprintf(__('Add this code to the theme functions.php to prevent site menus from disappearing if the %s is disabled or uninstalled.', 'noakes-menu-manager'), $this->_cache->plugin),
				'label' => $this->_cache->fail_safe_code,
				'type' => 'code',
				'value' => $this->fail_safe_code()
			));

			$uninstall_settings_box->add_field(array
			(
				'description' => sprintf(__('Keep plugin configuration options when uninstalling %s.', 'noakes-menu-manager'), $this->_cache->plugin),
				'label' => $this->_cache->preserve_all_options,
				'name' => NMM_SETTING_PRESERVE_OPTIONS,
				'type' => 'checkbox',
				'value' => $this->{NMM_SETTING_PRESERVE_OPTIONS}
			));

			$uninstall_settings_box->add_field(array
			(
				'description' => sprintf(__('Keep %s post meta when the plugin is uninstalled.', 'noakes-menu-manager'), $this->_cache->plugin),
				'label' => $this->_cache->preserve_post_meta,
				'name' => NMM_SETTING_PRESERVE_POST_META,
				'type' => 'checkbox',
				'value' => $this->{NMM_SETTING_PRESERVE_POST_META}
			));

			$uninstall_settings_box->add_field($this->_cache->save_all);

			$this->finalize_meta_boxes($screen);
		}
		
		/**
		 * Generate the fail-safe code output.
		 * 
		 * @since 1.4.0
		 * 
		 * @access private
		 * @return array Lines of generated code.
		 */
		private function fail_safe_code()
		{
			if (empty($this->menus)) return '';
			
			$code = array
			(
				'comment' => '/* ' . esc_html($this->_cache->plugin) . ' Fail-safe Code */',
				'if ( ! class_exists( \'Noakes_Menu_Manager\' ) && ! function_exists( \'nmm_fail_safe_code\' ) ) {',
				'add_action( \'after_setup_theme\', \'nmm_fail_safe_code\' );',
				PHP_EOL,
				'function nmm_fail_safe_code() {',
				'register_nav_menus( array(',
			);
			
			$theme = wp_get_theme();
			$text_domain = $theme->get('TextDomain');
			$text_domain = (empty($text_domain)) ? 'noakes-menu-manager' : esc_attr($text_domain);
			
			foreach ($this->menus as $i => $menu)
			{
				$code[] = '\'' . esc_attr($menu['location']) . '\' => __( \'' . esc_attr($menu['description']) . '\', \'' . $text_domain . '\' ),';
			}
			
			$last_line = array_pop($code);
			
			$code = array_merge($code, array
			(
				substr($last_line, 0, strlen($last_line) - 1),
				') );',
				'}',
				'}'
			));
			
			return $code;
		}
		
		/**
		 * Finalize the settings meta boxes.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @param  WP_Screen $screen Current WP_Screen object.
		 * @return void
		 */
		public function finalize_meta_boxes($screen)
		{
			Noakes_Menu_Manager_Meta_Box::side_meta_boxes($this->_base, $screen);
			Noakes_Menu_Manager_Third_Party::remove_settings_meta_boxes();

			do_action('add_meta_boxes', $screen->id, null);
		}

		/**
		 * Add action links to the plugin list.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  array $links Existing action links.
		 * @return array        Modified action links.
		 */
		public function plugin_action_links($links)
		{
			array_unshift($links, '<a href="' . esc_url(get_admin_url(null, 'options-general.php?page=' . NMM_OPTION_SETTINGS)) . '">' . $this->_cache->settings . '</a>');

			return $links;
		}
	}
}
