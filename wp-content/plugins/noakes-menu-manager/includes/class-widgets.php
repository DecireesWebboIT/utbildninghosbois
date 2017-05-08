<?php
/**
 * Widgets functionality.
 * 
 * @since 1.4.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Widgets
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Widgets'))
{
	final class Noakes_Menu_Manager_Widgets extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Constructor function.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base Base plugin object.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base)
		{
			parent::__construct($base);

			if ($this->_base->settings->enable_widget)
			{
				add_action('widgets_init', array($this, 'register_widget'));
				
				if (is_admin())
				{
					add_action('load-widgets.php', array($this, 'load_widgets'));
				}
			}
		}
		
		/**
		 * Register the nav menu sidebar widget.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @return void
		 */
		public function register_widget()
		{
			register_widget('Noakes_Menu_Widget');
		}

		/**
		 * Load widgets page functionality.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @return void
		 */
		public function load_widgets()
		{
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 11);
			
			$this->add_help_tab();
		}

		/**
		 * Enqueues scripts for the nav menus page.
		 * 
		 * @since 1.4.0
		 * 
		 * @access public
		 * @return void
		 */
		public function admin_enqueue_scripts()
		{
			wp_enqueue_style('nmm-admin', $this->_base->assets_url . 'styles/admin.css', array(), NMM_VERSION);
			wp_enqueue_script('nmm-admin-widgets', $this->_base->assets_url . 'scripts/admin-widgets.js', array('nmm-admin'), NMM_VERSION, true);

			wp_localize_script('nmm-admin-widgets', 'nmm_admin_widgets_l10n', array
			(
				'menu_id' => NMM_WIDGET_ID_MENU
			));
		}

		/**
		 * Add the help tab to the page.
		 * 
		 * @since 1.4.0
		 * 
		 * @access private
		 * @return void
		 */
		private function add_help_tab()
		{
			if (!$this->_base->settings->disable_help_tabs)
			{
				$screen = (function_exists('get_current_screen')) ? get_current_screen() : '';

				if (!empty($screen))
				{
					$screen->add_help_tab(array
					(
						'id' => 'nmm-' . NMM_WIDGET_ID_MENU,
						'title' => $this->_cache->nmm_menu,

						'content' => '<h3>' . $this->_cache->nmm_menu . '</h3>' .
							'<h4 style="margin-bottom: -10px;">' . __('Theme Location/Nav Menu', 'noakes-menu-manager') . '</h4>' .
							'<p>' . __('The menu can be selected using either a registered nav menu location or a nav menu object. Selecting one will disable the other. If a theme location is used but not associated with a nav menu, the widget won\'t be displayed.', 'noakes-menu-manager') . '</p>' .
							'<h4 style="margin-bottom: -10px;">' . __('Additional Fields', 'noakes-menu-manager') . '</h4>' .
							'<p>' . sprintf(__('The additional fields are based on the %1$s arguments. Any fields not entered will use filtered values set in %2$s or the default values.', 'noakes-menu-manager'), $this->_cache->wp_nav_menu, '<a href="https://developer.wordpress.org/reference/hooks/widget_nav_menu_args/" target="_blank">widget_nav_menu_args</a>') . '</p>'
					));
				}
			}
		}
	}
}
