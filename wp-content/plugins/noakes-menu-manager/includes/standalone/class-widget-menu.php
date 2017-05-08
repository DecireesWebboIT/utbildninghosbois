<?php
/**
 * Nav menu sidebar widget.
 * 
 * @since 1.0.4
 * 
 * @package    Nav Menu Manager
 * @subpackage Menu Widget
 * @uses       WP_Widget
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Widget'))
{
	class Noakes_Menu_Widget extends WP_Widget
	{
		/**
		 * Constructor function.
		 * 
		 * @since 1.4.0 Added widget ID definition.
		 * @since 1.1.1 Changed widget name to NMM Menu and added standard nav menu CSS class.
		 * @since 1.0.4
		 * 
		 * @access public
		 * @return void
		 */
		public function __construct()
		{
			parent::__construct(NMM_WIDGET_ID_MENU, Noakes_Menu_Manager()->_cache->nmm_menu, array
			(
				'classname' => 'widget_' . NMM_WIDGET_ID_MENU . ' widget_nmm_menu widget_nav_menu',
				'customize_selective_refresh' => true,
				'description' => __('Add a nav menu to the sidebar.', 'noakes-menu-manager')
			));
		}

		/**
		 * Output the widget.
		 * 
		 * @since 1.4.0 Added theme location output and item spacing field.
		 * @since 1.0.4
		 * 
		 * @access public
		 * @param  array $args     Sidebar settings to apply to the widget.
		 * @param  array $instance Settings for the current widget.
		 * @return void
		 */
		public function widget($args, $instance)
		{
			$assigned = get_nav_menu_locations();
			$nav_menu = (empty($instance['theme_location']) || !isset($assigned[$instance['theme_location']])) ? false : wp_get_nav_menu_object($assigned[$instance['theme_location']]);
			$nav_menu = (empty($nav_menu) && !empty($instance['nav_menu'])) ? wp_get_nav_menu_object($instance['nav_menu']) : $nav_menu;

			if (empty($nav_menu)) return;

			$title = (empty($instance['title'])) ? '' : apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

			echo $args['before_widget'];

			if (!empty($title))
			{
				echo $args['before_title'] . $title . $args['after_title'];
			}

			$nav_menu_args = array
			(
				'menu' => $nav_menu,
				'fallback_cb' => false
			);

			$arg_names = array('menu_class', 'menu_id', 'container', 'container_class', 'container_id', 'depth', 'item_spacing');

			foreach ($arg_names as $arg_name)
			{
				if (!empty($instance[$arg_name]) || $arg_name == 'container')
				{
					$nav_menu_args[$arg_name] = $instance[$arg_name];
				}
			}

			if (!empty($instance['before_after_link']))
			{
				$tag = esc_attr($instance['before_after_link']);
				$nav_menu_args['link_before'] = '<' . $tag . '>';
				$nav_menu_args['link_after'] = '</' . $tag . '>';
			}

			if (!empty($instance['before_after_text']))
			{
				$tag = esc_attr($instance['before_after_text']);
				$nav_menu_args['before'] = '<' . $tag . '>';
				$nav_menu_args['after'] = '</' . $tag . '>';
			}

			wp_nav_menu(apply_filters('widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance));
			
			echo $args['after_widget'];
		}

		/**
		 * Update the widget settings.
		 * 
		 * @since 1.4.0 Added theme location processing and item spacing field.
		 * @since 1.0.4
		 * 
		 * @access public
		 * @param  array $new_instance New settings for the current widget.
		 * @param  array $old_instance Old settings for the current widget.
		 * @return array               Updated settings for the current widget.
		 */
		public function update($new_instance, $old_instance)
		{
			$instance = array();
			$text_fields = array('theme_location', 'title', 'menu_id', 'container', 'container_id', 'before_after_link', 'before_after_text', 'item_spacing');
			$integer_fields = array('nav_menu', 'depth');
			$class_fields = array('menu_class', 'container_class');

			foreach ($text_fields as $field)
			{
				if (!empty($new_instance[$field]) || $field == 'container')
				{
					$instance[$field] = sanitize_text_field($new_instance[$field]);
				}
			}

			foreach ($integer_fields as $field)
			{
				if (!empty($new_instance[$field]))
				{
					$instance[$field] = (int)$new_instance[$field];
				}
			}

			foreach ($class_fields as $field)
			{
				if (!empty($new_instance[$field]))
				{
					$instance[$field] = ($field == 'menu_class' && $new_instance[$field] == 'menu') ? '' : Noakes_Menu_Manager_Utilities::sanitize_classes($new_instance[$field]);
				}
			}

			return $instance;
		}

		/**
		 * Output the widget form.
		 * 
		 * @since 1.4.0 Added theme location functionality and item spacing field.
		 * @since 1.1.2 Added empty option for nav menu.
		 * @since 1.0.4
		 * 
		 * @access public
		 * @param  array $instance Settings for the current widget.
		 * @return void
		 */
		public function form($instance)
		{
			global $noakes_menu_manager, $wp_customize;

			$menus = wp_get_nav_menus();
			$has_menus = (!empty($menus));
			$display_none = ' style="display: none;"';
			$widget_label = __('%1$s:', 'noakes-menu-manager');

			echo '<p class="nav-menu-widget-no-menus-message"' . (($has_menus) ? $display_none : '') . '>' .
				__('No menus have been created yet.', 'noakes-menu-manager') . '<br />' .
				sprintf('<a href="' . (($wp_customize instanceof WP_Customize_Manager) ? "javascript:wp.customize.panel('nav_menus').focus();" : esc_url(get_admin_url(null, 'nav-menus.php'))) . '">%s</a>', __('Create a menu &raquo;', 'noakes-menu-manager')) .
				'<p>' .
				'<div class="nav-menu-widget-form-controls"' . (($has_menus) ? '' : $display_none) . '>';

			$this->field_text($instance, sprintf($widget_label, __('Title', 'noakes-menu-manager')), 'title');

			$nav_menu_options = array
			(
				'' => __('&mdash; Disabled &mdash;', 'noakes-menu-manager')
			);
			
			$this->field_select($instance, sprintf($widget_label, $noakes_menu_manager->_cache->theme_location), 'theme_location', array_merge($nav_menu_options, get_registered_nav_menus()));
			
			foreach ($menus as $menu)
			{
				$nav_menu_options[$menu->term_id] = $menu->name;
			}
			
			$this->field_select($instance, sprintf($widget_label, sprintf(__('or %s', 'noakes-menu-manager'), $noakes_menu_manager->_cache->nav_menu)), 'nav_menu', $nav_menu_options, '', 'nmm-' . NMM_WIDGET_ID_MENU);
			$this->field_text($instance, sprintf($widget_label, $noakes_menu_manager->_cache->menu_classes), 'menu_class');
			$this->field_text($instance, sprintf($widget_label, $noakes_menu_manager->_cache->menu_id), 'menu_id');
			$this->field_select($instance, sprintf($widget_label, $noakes_menu_manager->_cache->container), 'container', $noakes_menu_manager->_cache->container_options, 'div');
			$this->field_text($instance, sprintf($widget_label, $noakes_menu_manager->_cache->container_classes), 'container_class');
			$this->field_text($instance, sprintf($widget_label, $noakes_menu_manager->_cache->container_id), 'container_id');
			$this->field_select($instance, sprintf($widget_label, $noakes_menu_manager->_cache->before_after_link), 'before_after_link', $noakes_menu_manager->_cache->before_after_options);
			$this->field_select($instance, sprintf($widget_label, $noakes_menu_manager->_cache->before_after_text), 'before_after_text', $noakes_menu_manager->_cache->before_after_options);
			$this->field_select($instance, sprintf($widget_label, $noakes_menu_manager->_cache->depth), 'depth', $noakes_menu_manager->_cache->depth_options);
			$this->field_select($instance, sprintf($widget_label, $noakes_menu_manager->_cache->item_spacing), 'item_spacing', $noakes_menu_manager->_cache->item_spacing_options);

			echo '</div>';
		}

		/**
		 * Output a widget select field.
		 * 
		 * @since 1.4.0 Added help button output.
		 * @since 1.0.4
		 * 
		 * @access private
		 * @param  array  $instance      Settings for the current widget.
		 * @param  string $label         Label displayed with the select field.
		 * @param  string $field_name    Name of the select field.
		 * @param  array  $options       Options for the select field.
		 * @param  mixed  $default_value Optional default value for the select field.
		 * @param  string $help_tab_id   Optional help tab ID used to add a help button to the field.
		 * @return void
		 */
		private function field_select($instance, $label, $field_name, $options, $default_value = '', $help_tab_id = '')
		{
			global $noakes_menu_manager;
			
			$value = (isset($instance[$field_name])) ? $instance[$field_name] : $default_value;
			$value = ($field_name == 'nav_menu' && $noakes_menu_manager->_cache->has_wpml) ? icl_object_id($value, 'nav_menu') : $value;
			$id = $this->get_field_id($field_name);

			echo '<p>' .
				'<label for="' . $id . '">' . $label . '</label> ' .
				'<select id="' . $id . '" name="' . $this->get_field_name($field_name) . '">';

			foreach ($options as $option_value => $option_label)
			{
				echo '<option value="' . esc_attr($option_value) . '" ' . selected($option_value, $value, false) . '>' . esc_html($option_label) . '</option>';
			}

			echo '</select>';
			echo (empty($help_tab_id)) ? '' : $noakes_menu_manager->displays->help_button($help_tab_id, true);
			echo '</p>';
		}

		/**
		 * Output a widget text field.
		 * 
		 * @since 1.0.4
		 * 
		 * @access private
		 * @param  array  $instance      Settings for the current widget.
		 * @param  string $label         Label displayed with the text field.
		 * @param  string $field_name    Name of the text field.
		 * @param  mixed  $default_value Default value for the text field.
		 * @return void
		 */
		private function field_text($instance, $label, $field_name, $default_value = '')
		{
			$value = (isset($instance[$field_name])) ? $instance[$field_name] : $default_value;
			$id = $this->get_field_id($field_name);

			echo '<p>' .
				'<label for="' . $id . '">' . $label . '</label>' .
				'<input id="' . $id . '" name="' . $this->get_field_name($field_name) . '" type="text" value="' . esc_attr($value) . '" class="widefat" />' .
				'</p>';
		}
	}
}
