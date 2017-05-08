<?php
/**
 * Meta box functionality.
 * 
 * @since 1.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Meta Box
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Meta_Box'))
{
	class Noakes_Menu_Manager_Meta_Box extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Constructor function.
		 * 
		 * @since 1.2.0 Removed screen argument.
		 * @since 1.1.0 Added help button functionality.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base    Base plugin object.
		 * @param  array               $options Optional options for the meta box.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base, $options = array())
		{
			parent::__construct($base);

			$this->_properties = (is_array($options)) ? $options : array();

			if (!empty($this->screen) && $this->title != '' && is_callable($this->callback))
			{
				$this->id = ($this->id != '' || $this->option_name == '' || $this->name == '') ? $this->id : $this->option_name . '_meta_box_' . $this->name;

				if ($this->id != '')
				{
					add_action('add_meta_boxes', array($this, 'add_meta_box'));
				}
			}
		}

		/**
		 * Get a default option based on the provided name.
		 * 
		 * @since 1.0.0
		 * 
		 * @access protected
		 * @param  string $name Name of the option to return.
		 * @return string       Default option if it exists, otherwise an empty string.
		 */
		protected function _default($name)
		{
			switch ($name)
			{
				case 'callback':

					return array($this, 'callback');

				case 'callback_args':
				case 'screen':

					return null;

				case 'classes':

					return array('nmm-meta-box');

				case 'context':

					return 'advanced';

				case 'fields':

					return array();

				case 'priority':

					return 'default';
			}

			return parent::_default($name);
		}

		/**
		 * Add the meta box to the page.
		 * 
		 * @since 1.2.0
		 * 
		 * @access public
		 * @return void
		 */
		public function add_meta_box()
		{
			$title = esc_html($this->title);
			$title .= ($this->help_tab_id == '') ? '' : $this->_base->displays->help_button($this->help_tab_id);

			add_meta_box($this->id, $title, $this->callback, $this->screen, $this->context, $this->priority, $this->callback_args);
			add_filter('postbox_classes_' . esc_attr($this->screen->id) . '_' . esc_attr($this->id), array($this, 'postbox_classes'));
		}

		/**
		 * The default callback that is fired for the meta box when one isn't provided.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  object $post Post object associated with the callback.
		 * @return void
		 */
		public function callback($post)
		{
			$has_option_name = ($this->option_name != '');

			$this->fields = Noakes_Menu_Manager_Utilities::check_array($this->fields);

			foreach ($this->fields as $field)
			{
				if (is_a($field, 'Noakes_Menu_Manager_Field'))
				{
					if ($has_option_name)
					{
						$field->option_name = $this->option_name;
					}

					$field->output(true);
				}
			}

			wp_nonce_field($this->id, $this->id . '_nonce', false);
		}

		/**
		 * Add additional classes to meta boxes.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  array $classes Current meta box classes.
		 * @return array          Modified meta box classes.
		 */
		public function postbox_classes($classes)
		{
			$this->classes = Noakes_Menu_Manager_Utilities::check_array($this->classes);

			return array_merge($classes, $this->classes);
		}

		/**
		 * Add a field to the meta box.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  array $options Options for the field to add.
		 * @return void
		 */
		public function add_field($options)
		{
			$this->_push('fields', new Noakes_Menu_Manager_Field($this->_base, $options));
		}

		/**
		 * Generate the side meta boxes.
		 * 
		 * @since 1.4.0 Added support meta box.
		 * @since 1.1.1
		 * 
		 * @access public static
		 * @param  Noakes_Menu_Manager $base   Base plugin object.
		 * @param  WP_Screen           $screen Current WP_Screen object.
		 * @return void
		 */
		public static function side_meta_boxes(Noakes_Menu_Manager $base, $screen)
		{
			$support_box = new Noakes_Menu_Manager_Meta_Box($base, array
			(
				'context' => 'side',
				'name' => 'nmm_support',
				'option_name' => NMM_OPTION_SETTINGS,
				'screen' => $screen,
				'title' => $base->_cache->support
			));
			
			$support_box->add_field(array
			(
				'content' => sprintf(__('If you are having any issues with the %1$s, %2$splease submit a ticket%3$s.', 'noakes-menu-manager'), '<strong>' . $base->_cache->plugin . '</strong>', '<a href="' . $base->_cache->support_url . '" target="_blank">', '</a>'),
				'type' => 'html'
			));
			
			$support_box->add_field(array
			(
				'content' => '<a href="' . $base->_cache->review_url . '" target="_blank"><strong>' . __('Your feedback is appreciated.', 'noakes-menu-manager') . '</strong></a>',
				'type' => 'html'
			));
			
			$more_information_box = new Noakes_Menu_Manager_Meta_Box($base, array
			(
				'context' => 'side',
				'name' => 'nmm_more_information',
				'option_name' => NMM_OPTION_SETTINGS,
				'screen' => $screen,
				'title' => __('More Information', 'noakes-menu-manager')
			));

			$more_information_box->add_field(array
			(
				'type' => 'html',

				'content' => $base->_cache->developed_by . '<br />' .
					'<a href="http://robertnoak.es/" target="_blank"><img src="' . $base->assets_url . 'images/robert-noakes.png" height="67" width="514" alt="Robert Noakes" class="robert-noakes" /></a>'
			));

			$more_information_box->add_field(array
			(
				'type' => 'html',

				'content' => __('Not hosting with Bluehost yet?', 'noakes-menu-manager') . '<br />' .
					'<a href="//www.bluehost.com/track/rnoakes3rd/noakes-menu-manager" target="_blank"><img src="//bluehost-cdn.com/media/partner/images/rnoakes3rd/190x60/bh-190x60-03-dy.png" height="60" width="190" alt="' . esc_attr__('Bluehost - Unlimited Domains, Space & Transfer - $5.95/month', 'noakes-menu-manager') . '" /></a>'
			));
		}
	}
}
