<?php
/**
 * Generator page functionality.
 * 
 * @since 1.4.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Generator
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Generator'))
{
	final class Noakes_Menu_Manager_Generator extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Constructor function.
		 * 
		 * @since 1.4.2 Moved settings load to a separate method.
		 * @since 1.4.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base Base plugin object.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base)
		{
			parent::__construct($base);

			$this->load_option();
			
			add_action('admin_init', array($this, 'admin_init'));
			add_action('admin_menu', array($this, 'admin_menu'));

			add_filter('plugin_action_links_' . plugin_basename($this->_base->plugin), array($this, 'plugin_action_links'));
		}

		/**
		 * Get a default setting based on the provided name.
		 * 
		 * @since 1.4.0
		 * 
		 * @access protected
		 * @param  string $name Name of the setting to return.
		 * @return string       Default setting if it exists, otherwise an empty string.
		 */
		protected function _default($name)
		{
			switch ($name)
			{
				case 'defaults':
				
					return array
					(
						'theme_location' => '',
						'menu' => '',
						'menu_class' => '',
						'menu_id' => '',
						'container' => 'div',
						'container_class' => '',
						'container_id' => '',
						'fallback_cb' => '',
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',
						'depth' => '0',
						'walker' => '',
						'items_wrap' => '',
						'item_spacing' => 'preserve'
					);
					
				case 'loaded':
				
					return array();
			}
			
			return parent::_default($name);
		}
		
		/**
		 * Load the generator settings option.
		 * 
		 * @since 1.4.2
		 * 
		 * @access public
		 * @param  array $settings Setting array to load, or null of the settings should be loaded from the database.
		 * @return void
		 */
		public function load_option($settings = null)
		{
			if (empty($settings))
			{
				$settings = (!isset($_GET['reset']) || $_GET['reset'] !== 'true') ? get_option(NMM_OPTION_GENERATOR) : array_merge($this->defaults, array
				(
					'echoed' => '1'
				));
			}
			
			$settings = Noakes_Menu_Manager_Utilities::check_array($settings, true);
			
			if (empty($settings))
			{
				$settings['echoed'] = '1';
			}
			
			$this->_properties = array_merge($this->defaults, $settings);
			$this->loaded = $settings;
		}

		/**
		 * Register the generator option.
		 * 
		 * @since 1.4.1 Fixed sanitization callback for earlier versions of WordPress.
		 * @since 1.4.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_init()
		{
			register_setting(NMM_OPTION_GENERATOR, NMM_OPTION_GENERATOR, array($this, 'sanitize'));
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
			$has_container = (!empty($input['container']));
			
			foreach ($input as $name => $value)
			{
				if ($name == 'theme_location')
				{
					$input[$name] = (empty($input['choose_menu_by'])) ? $input[$name] : '';
				}
				else if ($name == 'menu')
				{
					$input[$name] = ($input['choose_menu_by'] == 'menu') ? $input[$name] : '';
				}
				else if ($name == 'menu_class')
				{
					$input[$name] = ($input[$name] == 'menu') ? '' : Noakes_Menu_Manager_Utilities::sanitize_classes($input[$name]);
				}
				else if ($name == 'container_class')
				{
					$input[$name] = ($has_container) ? Noakes_Menu_Manager_Utilities::sanitize_classes($input[$name]) : '';
				}
				else if ($name == 'container_id')
				{
					$input[$name] = ($has_container) ? sanitize_text_field($input[$name]) : '';
				}
				else if ($name == 'depth')
				{
					$input[$name] = (int)$input[$name];
				}
				else
				{
					$input[$name] = sanitize_text_field($input[$name]);
				}
			}
			
			return $input;
		}

		/**
		 * Add the generator page.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_menu()
		{
			if ($this->_cache->is_generator)
			{
				$generator_page = add_options_page($this->_cache->plugin, $this->_cache->plugin, 'manage_options', NMM_OPTION_GENERATOR, array($this, 'generator_page'));

				add_action('load-' . $generator_page, array($this, 'load_generator'));
			}
		}

		/**
		 * Generate the generator page.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @return void
		 */
		public function generator_page()
		{
			$this->_base->displays->options_page(NMM_OPTION_GENERATOR, sprintf($this->_cache->plugin_heading, $this->_cache->plugin, $this->_cache->generator), $this->_cache->settings_tabs);
		}

		/**
		 * Load generator page functionality.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @return void
		 */
		public function load_generator()
		{
			add_filter('admin_body_class', array($this->_base->settings, 'admin_body_class'));
			add_action('admin_enqueue_scripts', array($this->_base->settings, 'admin_enqueue_scripts'), 11);

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
		 * Add help tabs to the page.
		 * 
		 * @since 1.4.0
		 * 
		 * @access private
		 * @param  WP_Screen $screen Current WP_Screen object.
		 * @return void
		 */
		private function add_help_tabs($screen)
		{
			if (!$this->_base->settings->disable_help_tabs)
			{
				$screen->set_help_sidebar($this->_cache->help_sidebar);

				$screen->add_help_tab(array
				(
					'id' => 'nmm-generator',
					'title' => $this->_cache->generator,

					'content' => '<h3>' . $this->_cache->generator . '</h3>' .
						'<h4 style="margin-bottom: -10px;">' . __('This tool allows for theme code to be generated for a specified theme location or nav menu.', 'noakes-menu-manager') . '</h4>' .
						'<ul>' .
						'<li>' . sprintf(__('Select or enter the values to use in the %s output.', 'noakes-menu-manager'), $this->_cache->wp_nav_menu) . '</li>' .
						'<li>' . sprintf(__('Click on the %s button to generate the code output and save the settings.', 'noakes-menu-manager'), '<em>' . $this->_cache->generate . '</em>') . '</li>' .
						'<li>' . __('Default values will not be included in the code output.', 'noakes-menu-manager') . '</li>' .
						'<li>' . __('Once generated, choose the output style then click on the code box to select the code.', 'noakes-menu-manager') . '</li>' .
						'</ul>'
				));
				
				$this->_base->displays->global_help_tabs($screen);
			}
		}

		/**
		 * Add meta boxes to the page.
		 * 
		 * @since 1.4.2 Optimized dropdown arguments.
		 * @since 1.4.0
		 * 
		 * @access private
		 * @param  WP_Screen $screen Current WP_Screen object.
		 * @return void
		 */
		private function add_meta_boxes($screen)
		{
			$code = $this->generate_code();
			
			if (!empty($code))
			{
				$code_output_box = new Noakes_Menu_Manager_Meta_Box($this->_base, array
				(
					'context' => 'normal',
					'help_tab_id' => 'nmm-generator',
					'name' => 'nmm_code_output',
					'option_name' => NMM_OPTION_GENERATOR,
					'screen' => $screen,
					'title' => __('Code Output', 'noakes-menu-manager')
				));
				
				$code_output_box->add_field(array
				(
					'complex' => true,
					'description' => sprintf(__('Generated %s code based on the selected options.', 'noakes-menu-manager'), strip_tags($this->_cache->wp_nav_menu)),
					'label' => __('Generated Code', 'noakes-menu-manager'),
					'type' => 'code',
					'value' => $code
				));

				$code_output_box->add_field(array
				(
					'type' => 'reset',
					'value' => get_admin_url(null, 'options-general.php?page=' . NMM_OPTION_GENERATOR . '&reset=true')
				));
			}
			
			$generator_box = new Noakes_Menu_Manager_Meta_Box($this->_base, array
			(
				'context' => 'normal',
				'help_tab_id' => 'nmm-generator',
				'name' => 'nmm_generator',
				'option_name' => NMM_OPTION_GENERATOR,
				'screen' => $screen,
				'title' => $this->_cache->generator
			));
			
			$generator_box->add_field(array
			(
				'description' => __('Method for selecting the nav menu to generate code for.', 'noakes-menu-manager'),
				'label' => __('Choose Menu By', 'noakes-menu-manager'),
				'name' => 'choose_menu_by',
				'type' => 'radio',
				'value' => $this->choose_menu_by,
				
				'options' => array
				(
					'' => $this->_cache->theme_location,
					'menu' => $this->_cache->nav_menu
				)
			));
			
			$select_one = array
			(
				'' => __('Select one...', 'noakes-menu-manager')
			);
			
			$generator_box->add_field(array
			(
				'classes' => ($this->choose_menu_by == '') ? array() : array('hidden'),
				'description' => __('Theme location to be used.', 'noakes-menu-manager'),
				'label' => $this->_cache->theme_location,
				'name' => 'theme_location',
				'required' => true,
				'type' => 'select',
				'options' => array_merge($select_one, get_registered_nav_menus()),
				'value' => $this->theme_location,
				
				'conditional' => array
				(
					array
					(
						'field' => 'choose_menu_by',
						'value' => ''
					)
				)
			));
			
			$menus = wp_get_nav_menus();
			$nav_menus = array();
			
			foreach ($menus as $menu)
			{
				$nav_menus[$menu->slug] = $menu->name;
			}
			
			$generator_box->add_field(array
			(
				'classes' => ($this->choose_menu_by == 'menu') ? array() : array('hidden'),
				'description' => __('Nav menu to be used.', 'noakes-menu-manager'),
				'label' => $this->_cache->nav_menu,
				'name' => 'menu',
				'required' => true,
				'type' => 'select',
				'options' => array_merge($select_one, $nav_menus),
				'value' => $this->menu,
				
				'conditional' => array
				(
					array
					(
						'field' => 'choose_menu_by',
						'value' => 'menu'
					)
				)
			));

			$generator_box->add_field(array
			(
				'description' => __('CSS class to use for the nav menu. Default is \'menu\'.', 'noakes-menu-manager'),
				'label' => $this->_cache->menu_classes,
				'name' => 'menu_class',
				'type' => 'text',
				'value' => $this->menu_class
			));

			$generator_box->add_field(array
			(
				'description' => sprintf(__('%s that is applied to the nav menu. Default is the menu slug, incremented.', 'noakes-menu-manager'), $this->_cache->noakes_id),
				'label' => $this->_cache->menu_id,
				'name' => 'menu_id',
				'type' => 'text',
				'value' => $this->menu_id
			));

			$generator_box->add_field(array
			(
				'description' => __('Whether to wrap the nav menu, and what to wrap it with.', 'noakes-menu-manager'),
				'label' => $this->_cache->container,
				'name' => 'container',
				'options' => $this->_cache->container_options,
				'type' => 'select',
				'value' => $this->container
			));
			
			$has_container = (!empty($this->container));

			$generator_box->add_field(array
			(
				'classes' => ($has_container) ? array() : array('hidden'),
				'description' => __('Class that is applied to the nav menu container. Default is \'menu-{menu slug}-container\'.', 'noakes-menu-manager'),
				'label' => $this->_cache->container_classes,
				'name' => 'container_class',
				'type' => 'text',
				'value' => $this->container_class,
				
				'conditional' => array
				(
					array
					(
						'compare' => '!=',
						'field' => 'container',
						'value' => ''
					)
				)
			));

			$generator_box->add_field(array
			(
				'classes' => ($has_container) ? array() : array('hidden'),
				'description' => sprintf(__('%s that is applied to the nav menu container.', 'noakes-menu-manager'), $this->_cache->noakes_id),
				'label' => $this->_cache->container_id,
				'name' => 'container_id',
				'type' => 'text',
				'value' => $this->container_id,
				
				'conditional' => array
				(
					array
					(
						'compare' => '!=',
						'field' => 'container',
						'value' => ''
					)
				)
			));

			$generator_box->add_field(array
			(
				'description' => __('If the menu doesn\'t exist, a callback function will fire. Default is \'wp_page_menu\'.', 'noakes-menu-manager'),
				'label' => $this->_cache->fallback_cb,
				'name' => 'fallback_cb',
				'type' => 'select',
				'value' => $this->fallback_cb,
				
				'options' => array
				(
					'' => $this->_cache->exclude_arg,
					'true' => $this->_cache->include_arg,
					'false' => sprintf(__('Explicitly disable %s', 'noakes-menu-manager'), $this->_cache->fallback_cb)
				)
			));

			$generator_box->add_field(array
			(
				'description' => __('Tag wrapped around each nav menu item link.', 'noakes-menu-manager'),
				'label' => $this->_cache->before_after_link,
				'name' => 'before_after_link',
				'options' => $this->_cache->before_after_options,
				'type' => 'select',
				'value' => $this->before_after_link
			));

			$generator_box->add_field(array
			(
				'description' => __('Tag wrapped around the content in each nav menu item link.', 'noakes-menu-manager'),
				'label' => $this->_cache->before_after_text,
				'name' => 'before_after_text',
				'options' => $this->_cache->before_after_options,
				'type' => 'select',
				'value' => $this->before_after_text
			));

			$generator_box->add_field(array
			(
				'description' => __('Whether to echo the menu or return it.', 'noakes-menu-manager'),
				'label' => __('Echo', 'noakes-menu-manager'),
				'name' => 'echoed',
				'type' => 'checkbox',
				'value' => $this->echoed
			));

			$generator_box->add_field(array
			(
				'description' => __('How many levels of the hierarchy are to be included.', 'noakes-menu-manager'),
				'label' => $this->_cache->depth,
				'name' => 'depth',
				'options' => $this->_cache->depth_options,
				'type' => 'select',
				'value' => $this->depth
			));

			$generator_box->add_field(array
			(
				'description' => __('Instance of a custom walker class.', 'noakes-menu-manager'),
				'label' => __('Walker', 'noakes-menu-manager'),
				'name' => 'walker',
				'type' => 'select',
				'value' => $this->walker,
				
				'options' => array
				(
					'' => $this->_cache->exclude_arg,
					'true' => $this->_cache->include_arg
				)
			));

			$generator_box->add_field(array
			(
				'description' => sprintf(__('How the list items should be wrapped. Default is a UL with an %s and CSS class. Uses printf() format with numbered placeholders.', 'noakes-menu-manager'), $this->_cache->noakes_id),
				'label' => __('Items Wrap', 'noakes-menu-manager'),
				'name' => 'items_wrap',
				'type' => 'select',
				'value' => $this->items_wrap,
				
				'options' => array
				(
					'' => $this->_cache->exclude_arg,
					'true' => $this->_cache->include_arg
				)
			));

			$generator_box->add_field(array
			(
				'description' => __('Whether to preserve whitespace within the nav menu HTML.', 'noakes-menu-manager'),
				'label' => $this->_cache->item_spacing,
				'name' => 'item_spacing',
				'options' => $this->_cache->item_spacing_options,
				'type' => 'select',
				'value' => $this->item_spacing
			));
			
			$generator_box->add_field(array
			(
				'content' => $this->_cache->generate,
				'type' => 'submit'
			));
			
			$this->_base->settings->finalize_meta_boxes($screen);
		}
		
		/**
		 * Generate the code array based on the saved options.
		 * 
		 * @since 1.4.2 Changed echo argument output.
		 * @since 1.4.0
		 * 
		 * @access private
		 * @return string Generated code array.
		 */
		private function generate_code()
		{
			$loaded = $this->loaded;
			$args = array();
			
			foreach ($loaded as $name => $value)
			{
				if ($name == 'before_after_link')
				{
					if (!empty($value))
					{
						$tag = esc_attr($value);
						$args['before'] = '<' . $tag . '>';
						$args['after'] = '</' . $tag . '>';
					}
				}
				else if ($name == 'before_after_text')
				{
					if (!empty($value))
					{
						$tag = esc_attr($value);
						$args['link_before'] = '<' . $tag . '>';
						$args['link_after'] = '</' . $tag . '>';
					}
					
					if (!isset($loaded['echoed']))
					{
						$args['echo'] = 'false';
					}
				}
				else if ($name != 'choose_menu_by' && $name != 'echoed')
				{
					$args[$name] = $value;
				}
			}
			
			$options = array_diff_assoc($args, $this->defaults);
			
			if (isset($options['fallback_cb']) && $options['fallback_cb'] === 'true')
			{
				$options['fallback_cb'] = 'wp_page_menu';
			}
			
			if (isset($options['walker']) && $options['walker'] === 'true')
			{
				$options['walker'] = 'new Walker_Nav_Menu()';
			}
			
			if (isset($options['items_wrap']) && $options['items_wrap'] === 'true')
			{
				$options['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s</ul>';
			}
			
			if (empty($options)) return '';
			
			$code = array
			(
				'wp_nav_menu( array('
			);
			
			foreach ($options as $name => $value)
			{
				$value = ($name == 'walker' || is_numeric($value) || $value === 'true' || $value === 'false') ? $value : '\'' . esc_attr($value) . '\'';
				$code[] = '\'' . esc_attr($name) . '\' => ' . esc_attr($value) . ',';
			}
			
			$last_line = array_pop($code);
			
			$code = array_merge($code, array
			(
				substr($last_line, 0, strlen($last_line) - 1),
				') );'
			));
			
			return $code;
		}

		/**
		 * Add action links to the plugin list.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @param  array $links Existing action links.
		 * @return array        Modified action links.
		 */
		public function plugin_action_links($links)
		{
			array_unshift($links, '<a href="' . esc_url(get_admin_url(null, 'options-general.php?page=' . NMM_OPTION_GENERATOR)) . '">' . $this->_cache->generator . '</a>');

			return $links;
		}
	}
}
