<?php
/**
 * Base plugin functionality.
 * 
 * @since 1.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Base
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager'))
{
	final class Noakes_Menu_Manager extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Main instance of Noakes_Menu_Manager.
		 * 
		 * @since 1.0.0
		 * 
		 * @access private static
		 * @var    Noakes_Menu_Manager
		 */
		private static $_instance = null;

		/**
		 * Returns the main instance of Noakes_Menu_Manager.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public static
		 * @param  string              $file Main plugin file.
		 * @return Noakes_Menu_Manager       Main Noakes_Menu_Manager instance. 
		 */
		public static function _get_instance($file)
		{
			if (is_null(self::$_instance))
			{
				self::$_instance = new self($file);
			}

			return self::$_instance;
		}

		/**
		 * Constructor function.
		 * 
		 * @since 1.4.0 Added widgets and generator objects. Removed widget registration and plugin activation/deactivation hooks.
		 * @since 1.3.0 Removed folder, assets folder and assets suffix variables.
		 * @since 1.1.0 Added global CSS & JS registration.
		 * @since 1.0.4 Added sidebar widget registration.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string $file Main plugin file.
		 * @return void
		 */
		public function __construct($file)
		{
			if (!empty($file) && file_exists($file))
			{
				$folder = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? 'assets' : 'dist';
				
				$this->plugin = $file;
				$this->assets_url = trailingslashit(plugins_url('/' . $folder . '/', $this->plugin));

				$this->_cache = new Noakes_Menu_Manager_Cache($this);
				$this->settings = new Noakes_Menu_Manager_Settings($this);
				$this->nav_menus = new Noakes_Menu_Manager_Nav_Menus($this);
				$this->widgets = new Noakes_Menu_Manager_Widgets($this);

				add_action('plugins_loaded', array($this, 'plugins_loaded'));
				add_action('init', array($this, 'register_menus'), 99);

				if (is_admin())
				{
					$this->displays = new Noakes_Menu_Manager_Displays($this);
					$this->generator = new Noakes_Menu_Manager_Generator($this);
					
					add_action('admin_init', array($this, 'load_plugin'), 0);
					add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));

					add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
				}
			}
		}

		/**
		 * Get a default property based on the provided name.
		 * 
		 * @since 1.0.0
		 * 
		 * @access protected
		 * @param  string $name Name of the property to return.
		 * @return string       Default property if it exists, otherwise an empty string.
		 */
		protected function _default($name)
		{
			switch ($name)
			{
				case 'cache':
				case 'displays':
				case 'utilities':
				case 'settings':
				case 'nav_menus':

					return null;
			}

			return parent::_default($name);
		}

		/**
		 * Load plugin text domain.
		 * 
		 * @since 1.0.2 Made public for action hook access.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function plugins_loaded()
		{
			$locale = apply_filters('plugin_locale', get_locale(), NMM_TOKEN);

			load_textdomain(NMM_TOKEN, WP_LANG_DIR . '/' . NMM_TOKEN . '/' . NMM_TOKEN . '-' . $locale . '.mo');
			load_plugin_textdomain(NMM_TOKEN, false, trailingslashit(dirname(plugin_basename($this->plugin))) . 'languages/');

			add_action('init', array($this, 'load_localization'), 0);
		}

		/**
		 * Initialize the plugin localization.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function load_localization()
		{
			load_plugin_textdomain('noakes-menu-manager', false, dirname(plugin_basename($this->plugin)) . '/languages/');
		}

		/**
		 * Initialize the nav menus.
		 * 
		 * @since 1.1.1 Simplified page check for disabled menus.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @return void
		 */
		public function register_menus()
		{
			$this->_cache->registered_menus = get_registered_nav_menus();

			if (count($this->settings->disable) > 0 && (!isset($_GET['page']) || $_GET['page'] != NMM_OPTION_SETTINGS))
			{
				foreach ($this->settings->disable as $location => $value)
				{
					if ($value == '1')
					{
						unregister_nav_menu($location);
					}
				}
			}

			if (count($this->settings->menus) > 0)
			{
				foreach ($this->settings->menus as $menu)
				{
					register_nav_menu($menu['location'], $menu['description']);
				}
			}
		}
		
		/**
		 * Finalize the plugin load.
		 * 
		 * @since 1.4.2 Optimized plugin version changes.
		 * @since 1.4.0
		 * 
		 * @access public
		 * @return void
		 */
		public function load_plugin()
		{
			$current_version = get_option(NMM_OPTION_VERSION);
			
			if ($current_version != NMM_VERSION)
			{
				if (!$current_version)
				{
					add_option(NMM_OPTION_VERSION, NMM_VERSION);
				}
				else
				{
					if (version_compare($current_version, '1.4.0', '<'))
					{
						$this->pre_one_four_zero();
					}
					else if (version_compare($current_version, '1.4.2', '<'))
					{
						$this->pre_one_four_two();
					}

					update_option(NMM_OPTION_VERSION, NMM_VERSION);
				}
			}
		}
		
		/**
		 * Clean up plugin settings for Nav Menu Manager versions earlier than 1.4.0.
		 * 
		 * @since 1.4.2
		 * 
		 * @access private
		 * @return void
		 */
		private function pre_one_four_zero()
		{
			$plugin_settings = Noakes_Menu_Manager_Utilities::check_array(get_option(NMM_OPTION_SETTINGS), true);
			$plugin_settings = $this->settings->sanitize($plugin_settings);

			update_option(NMM_OPTION_SETTINGS, $plugin_settings);
			
			$this->settings->load_option($plugin_settings);
		}
		
		/**
		 * Clean up generator settings for Nav Menu Manager versions earlier than 1.4.2.
		 * 
		 * @since 1.4.2
		 * 
		 * @access private
		 * @return void
		 */
		private function pre_one_four_two()
		{
			$generator_settings = Noakes_Menu_Manager_Utilities::check_array(get_option(NMM_OPTION_GENERATOR), true);
			$dropdown_fields = array('fallback_cb', 'walker', 'items_wrap');

			foreach ($generator_settings as $name => $value)
			{
				if (in_array($name, $dropdown_fields) && $value == 'included')
				{
					$generator_settings[$name] = 'true';
				}
			}

			update_option(NMM_OPTION_GENERATOR, $generator_settings);
			
			$this->generator->load_option($generator_settings);
		}

		/**
		 * Enqueue global plugin assets.
		 * 
		 * @since 1.3.0 Changed asset paths.
		 * @since 1.1.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_enqueue_scripts()
		{
			wp_register_style('nmm-admin', $this->assets_url . 'styles/admin.css', array(), NMM_VERSION);
			wp_register_script('nmm-admin', $this->assets_url . 'scripts/admin.js', array(), NMM_VERSION, true);
		}

		/**
		 * Add links to the plugin page.
		 * 
		 * @since 1.4.0 Added support and review links.
		 * @since 1.0.1
		 * 
		 * @access public
		 * @param  array  $links Default links for the plugin.
		 * @param  string $file  Main plugin file name.
		 * @return array         Modified links for the plugin.
		 */
		public function plugin_row_meta($links, $file)
		{
			if ($file == plugin_basename($this->plugin))
			{
				$links[] = '<a href="' . $this->_cache->support_url . '" target="_blank">' . $this->_cache->support . '</a>';
				$links[] = '<a href="' . $this->_cache->review_url . '" target="_blank">' . $this->_cache->review . '</a>';
				$links[] = '<a href="https://translate.wordpress.org/projects/wp-plugins/noakes-menu-manager" target="_blank">' . __('Translate', 'noakes-menu-manager') . '</a>';
				$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XNE7BREHR7BZQ" target="_blank">' . __('Donate', 'noakes-menu-manager') . '</a>';
			}

			return $links;
		}
	}
}
