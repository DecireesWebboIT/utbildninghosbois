<?php
/**
 * Meta box field functionality.
 * 
 * @since 1.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Field
 * @uses       Noakes_Menu_Manager_Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Field'))
{
	class Noakes_Menu_Manager_Field extends Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Constructor function.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base    Base plugin object.
		 * @param  array               $options Optional options for the field.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base, $options = array())
		{
			parent::__construct($base);

			$this->_properties = (is_array($options)) ? $options : array();

			if ($this->name != '')
			{
				$this->hierarchy = Noakes_Menu_Manager_Utilities::check_array($this->hierarchy);
				$this->_push('hierarchy', $this->name);

				$this->template_hierarchy = Noakes_Menu_Manager_Utilities::check_array($this->template_hierarchy);
				$this->_push('template_hierarchy', $this->name);
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
				case 'add_row':

					return __('Add Row', 'noakes-menu-manager');

				case 'classes':
				case 'conditional':
				case 'field_classes':
				case 'fields':
				case 'hierarchy':
				case 'template_hierarchy':

					return array();

				case 'complex':
				case 'grouped':
				case 'grouped_repeatable':
				case 'is_group':
				case 'is_row':
				case 'is_row_header':
				case 'repeatable':
				case 'repeatable_output':
				case 'required':

					return false;

				case 'field_name':

					return $this->generate_name($this->hierarchy, $this->name);

				case 'global_attributes':

					$field_name = esc_attr($this->field_name);

					return (strpos($field_name, '%') === false) ? ' id="' . $field_name . '" name="' . $field_name . '"' : '';

				case 'template_data':

					$template_name = $this->generate_name($this->template_hierarchy);

					return (strpos($template_name, '%d') === false) ? '' : ' data-nmm-template-name="' . esc_attr($template_name) . '"';

				case 'type':

					return 'text';
			}

			return parent::_default($name);
		}

		/**
		 * Generate the output for the field.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  boolean     $echo True if the field should be echoed.
		 * @return string/void       Generated field if $echo is false.
		 */
		public function output($echo = false)
		{
			$output = '';
			$is_repeatable = ($this->repeatable && !$this->repeatable_output);
			$field = '';
			$is_header_field = ($this->is_row_header && $this->type != 'group');

			if ($is_repeatable)
			{
				$field = $this->field_repeatable();
			}
			else if ($this->type != 'repeatable' && !$is_header_field)
			{
				if ($this->required)
				{
					$this->_push('field_classes', 'required');
				}

				$field = (method_exists($this, 'field_' . $this->type)) ? call_user_func(array($this, 'field_' . $this->type)) : $this->field_text();
			}

			if ($field != '' || $is_header_field)
			{
				if (is_array($this->conditional) && !empty($this->conditional))
				{
					foreach ($this->conditional as $condition)
					{
						if (is_array($condition) && isset($condition['field']) && isset($condition['value']))
						{
							if (!isset($condition['compare']))
							{
								$condition['compare'] = '=';
							}
							
							$field .= $this->generate_condition($condition['field'], $condition['value'], $condition['compare']);
						}
					}
				}
				
				$is_complex = ($this->complex || $this->is_group || $is_repeatable);
				$field = ($is_complex) ? $field : '<div class="nmm-simple-field">' . $field . '</div>';

				if ($this->repeatable_output)
				{
					$output .= $field;
				}
				else
				{
					$this->_push('classes', 'nmm-field');
					$this->_push('classes', 'nmm-field-' . str_replace('_', '-', $this->type));

					if (!empty($this->columns))
					{
						$this->_push('classes', 'nmm-columns-' . $this->columns);
					}

					$label_for = ($this->field_name == '' || $is_header_field) ? '' : ' for="' . esc_attr($this->field_name) . '"';
					$label = '';

					$description = ($this->description == '') ? '' : '<div class="nmm-description">' .
						'<label' . $label_for . '>' . $this->description . '</label>' .
						'</div>';

					if (!$this->repeatable_output && $this->label != '')
					{
						$label = '<div class="nmm-field-label">' .
							'<label' . $label_for . '><strong>' . $this->label . '</strong></label>';

						$label .= ($is_complex) ? $description : '';
						$label .= '</div>';
					}

					$output = '<div class="' . esc_attr(implode(' ', $this->classes)) . '">' .
						$label .
						'<div class="nmm-field-input">' .
						$field;

					$output .= ($is_complex) ? '' : $description;

					$output .= '</div>' .
						'</div>';
						
					if (in_array('hidden', $this->classes))
					{
						$output .= '<div class="hidden nmm-field-spacer"></div>';
					}
				}
			}

			if (!$echo)
			{
				return $output;
			}

			echo $output;
		}

		/**
		 * Generate a checkbox field.
		 * 
		 * @since 1.0.0
		 * 
		 * @access private
		 * @return string Generated checkbox field.
		 */
		private function field_checkbox()
		{
			return ($this->field_name == '') ? '' : '<input' . $this->global_attributes . $this->template_data . ' type="checkbox" value="1" ' . $this->get_field_classes() . ' ' . checked('1', $this->value, false) . ' />';
		}
		
		/**
		 * Generate code output field.
		 * 
		 * @since 1.4.0
		 * 
		 * @access private
		 * @return string Generated fcode output.
		 */
		private function field_code()
		{
			if (empty($this->value) || !is_array($this->value)) return '';
			
			$value = $this->value;
			$wp_core = '';
			$one_line = '';
			$author_preference = '';
			$tabs = '';
			
			if (isset($value['comment']))
			{
				$comment = $value['comment'] . PHP_EOL;
				$wp_core = $comment;
				$one_line = $comment;
				$author_preference = $comment;
				
				unset($value['comment']);
			}
			
			foreach ($value as $line)
			{
				if ($line == PHP_EOL)
				{
					$author_preference .= $line;
				}
				else
				{
					$add_tab = (Noakes_Menu_Manager_Utilities::ends_with('{', $line) || Noakes_Menu_Manager_Utilities::ends_with('(', $line));
					$remove_tab = (!$add_tab && (Noakes_Menu_Manager_Utilities::starts_with(')', $line) || Noakes_Menu_Manager_Utilities::starts_with('}', $line)));
					
					if ($remove_tab)
					{
						$tabs = substr($tabs, 1);
					}
					
					$wp_core .= $tabs . $line . PHP_EOL;
					$line = str_replace(array('( ', '! ', ' )', ' {'), array('(', '!', ')', '{'), $line);
					$line .= (Noakes_Menu_Manager_Utilities::ends_with(',', $line)) ? ' ' : '';
					$one_line .= $line;
					$new_line = PHP_EOL . $tabs;
					$line = str_replace(array('{', 'array('), array($new_line . '{', 'array' . $new_line . '('), $line);
					$author_preference .= $tabs . trim($line) . PHP_EOL;
					
					if ($add_tab)
					{
						$tabs .= "\t";
					}
				}
			}
			
			return __('Style:', 'noakes-menu-manager') .
				'<button type="button" id="nmm-wp-core" class="button button-primary nmm-button">' . __('WP Core', 'noakes-menu-manager') . '</button>' .
				'<button type="button" id="nmm-one-line" class="button nmm-button">' . __('One Line', 'noakes-menu-manager') . '</button>' .
				'<button type="button" id="nmm-author-preference" class="button nmm-button">' . __('Author Preference', 'noakes-menu-manager') . '</button>' .
				'<pre id="nmm-wp-core-code">' .
				$wp_core .
				'</pre>' .
				'<pre id="nmm-one-line-code" style="display: none;">' .
				$one_line .
				'</pre>' .
				'<pre id="nmm-author-preference-code" style="display: none;">' .
				$author_preference .
				'</pre>';
		}

		/**
		 * Generate an existing menus field.
		 * 
		 * @since 1.0.4 Added conditional code that fixes the table layout in earlier versions of WordPress.
		 * @since 1.0.0
		 * 
		 * @access private
		 * @return string Generated existing menus field.
		 */
		private function field_existing_menus()
		{
			global $wp_version;

			$this->repeatable = false;

			if (count($this->_cache->registered_menus) > 0)
			{
				$assigned = get_nav_menu_locations();
				$select_all = ' checked="checked"';
				$rows = '';

				foreach ($this->_cache->registered_menus as $location => $description)
				{
					$location_attr = esc_attr($location);
					$attributes = $this->global_attributes;
					$attributes = str_replace('[' . $this->name . ']', '[' . $this->name . '][' . $location_attr . ']', $attributes);
					$checked = (isset($this->value[$location_attr])) ? ' checked="checked"' : '';
					$select_all = ($checked) ? $select_all : '';
					$menu = (isset($assigned[$location])) ? wp_get_nav_menu_object($assigned[$location]) : '';
					$assigned_to = (empty($menu)) ? $this->_cache->none : '<a href="' . esc_url(get_admin_url(null, 'nav-menus.php?action=edit&menu=' . $menu->term_id)) . '" target="_blank">' . $menu->name . '</a>';

					$rows .= '<tr>' .
						'<th class="check-column" scope="row">' .
						'<label class="screen-reader-text" for="' . esc_attr($this->field_name) . '[' . $location_attr . ']">' . sprintf($this->_cache->select, $location) . '</label>' .
						'<input' . $attributes . ' type="checkbox" value="1"' . $checked . ' />' .
						'</th>' .
						'<td class="nmm-location">' . $location . '</td>' .
						'<td>' . $description . '</td>' .
						'<td>' . $assigned_to . '</td>' .
						'</tr>';
				}

				$first_header_cell = (version_compare($wp_version, '4.3.dev', '>=')) ? 'td' : 'th';

				$header_row = '<tr>' .
					'<' . $first_header_cell . ' class="check-column">' .
					'<label class="screen-reader-text" for="cb-select-all-1">' . sprintf($this->_cache->select, __('All', 'noakes-menu-manager')) . '</label>' .
					'<input id="cb-select-all-1" type="checkbox"' . $select_all . ' />' .
					'</' . $first_header_cell . '>' .
					'<th>' . $this->_cache->location . '</th>' .
					'<th>' . $this->_cache->description . '</th>' .
					'<th>' . __('Assigned To', 'noakes-menu-manager') . '</th>' .
					'</tr>';

				return '<table cellspacing="0" class="nmm-existing-menus nmm-table widefat striped' . $this->get_field_classes(false) . '">' .
					'<thead>' .
					$header_row .
					'</thead>' .
					'<tbody>' .
					$rows .
					'</tbody>' .
					'<tfoot>' .
					str_replace('cb-select-all-1', 'cb-select-all-2', $header_row) .
					'</tfoot>' .
					'</table>';
			}

			return '';
		}

		/**
		 * Generate a field group.
		 * 
		 * @since 1.0.0
		 * 
		 * @access private
		 * @return string Generated field group.
		 */
		private function field_group()
		{
			$output = '';

			if (is_array($this->fields))
			{
				$field_output = '';
				$base_width = '';
				$leftover_width = '';

				if ($this->layout == 'row')
				{
					$this->is_row = true;

					$field_count = count($this->fields);
					$columns = ceil($field_count / 12) * 12;
					$base_width = floor($columns / $field_count);
					$leftover_width = $columns % $field_count;
				}

				foreach ($this->fields as $i => $options)
				{
					if (is_array($options))
					{
						$options['attr_prefix'] = $this->attr_prefix;
						$options['grouped'] = true;
						$options['grouped_repeatable'] = $this->repeatable;
						$options['option_name'] = $this->option_name;
						$options['hierarchy'] = $this->hierarchy;
						$options['is_row_header'] = $this->is_row_header;
						$options['template_hierarchy'] = $this->template_hierarchy;
						$options['value'] = (isset($options['name']) && is_array($this->value) && isset($this->value[$options['name']])) ? $this->value[$options['name']] : '';

						if ($this->is_row)
						{
							$options['columns'] = $base_width;

							if ($leftover_width > 0)
							{
								$options['columns']++;
								$leftover_width--;
							}
						}

						$grouped_field = new self($this->_base, $options);
						$field_output .= $grouped_field->output();
					}
				}

				if ($field_output != '')
				{
					$this->is_group = true;

					$output = '<div class="nmm-group' . $this->get_field_classes(false) . '">';
					$output .= ($this->is_row) ? '<div class="nmm-row">' : '';
					$output .= $field_output;
					$output .= ($this->is_row) ? '</div>' : '';
					$output .= '</div>';
				}
			}

			return $output;
		}

		/**
		 * Generate an HTML field.
		 * 
		 * @since 1.0.0
		 * 
		 * @access private
		 * @return string Generated HMTL field.
		 */
		private function field_html()
		{
			$this->repeatable = false;

			return '<div class="nmm-html' . $this->get_field_classes(false) . '">' .
				wpautop(do_shortcode($this->content)) .
				'</div>';
		}

		/**
		 * Generate a radio buttons field.
		 * 
		 * @since 1.4.0
		 * 
		 * @access private
		 * @return string Generated radio buttons field.
		 */
		private function field_radio()
		{
			if (empty($this->options)) return '';
			
			$output = '';
			
			foreach ($this->options as $value => $label)
			{
				$output .= '<label><input' . $this->global_attributes . $this->template_data . ' type="radio" value="' . esc_attr($value) . '" ' . $this->get_field_classes() . ' ' . checked($value, $this->value, false) . ' /> <span>' . $label . '</span></label>';
			}
			
			return $output;
		}

		/**
		 * Generate a repeatable field.
		 * 
		 * @since 1.0.0
		 * 
		 * @access private
		 * @return string Generated repeatable field.
		 */
		private function field_repeatable()
		{
			$output = '';

			if ($this->type == 'group' && $this->layout == 'row')
			{
				$row_header_field = clone $this;
				$row_header_field->is_row_header = true;
				$row_header_field->repeatable_output = true;
				$row_header_field->value = '';
				$row_header_output = $row_header_field->output();

				$output = ($row_header_output == '') ? '' : '<div class="nmm-repeatable-header">' .
					$row_header_output .
					'</div>';
			}

			$buttons = '<a href="javascript:;" title="' . esc_attr__('Move', 'noakes-menu-manager') . '" class="nmm-repeatable-move">' .
				$this->_cache->move_menu .
				'</a>' .
				'<a href="javascript:;" title="' . esc_attr__('Move Down', 'noakes-menu-manager') . '" class="nmm-repeatable-move-down">' .
				$this->_cache->move_menu_down .
				'</a>' .
				'<a href="javascript:;" title="' . esc_attr__('Move Up', 'noakes-menu-manager') . '" class="nmm-repeatable-move-up">' .
				$this->_cache->move_menu_up .
				'</a>' .
				'<a href="javascript:;" title="' . esc_attr__('Insert Above', 'noakes-menu-manager') . '" class="nmm-repeatable-insert">' .
				$this->_cache->insert_menu .
				'</a>' .
				'<a href="javascript:;" title="' . esc_attr__('Remove', 'noakes-menu-manager') . '" class="nmm-repeatable-remove">' .
				$this->_cache->remove_menu .
				'</a>';

			if (is_array($this->value))
			{
				foreach ($this->value as $i => $value)
				{
					if (is_numeric($i))
					{
						$first_class = ($i == 0) ? ' nmm-first' : '';
						$value_field = clone $this;
						$value_field->repeatable_output = true;
						$value_field->value = $value;
						$value_field->_push('hierarchy', $i);
						$value_field->_push('template_hierarchy', '%d');
						$value_output = $value_field->output();

						$output .= ($value_output == '') ? '' : '<div class="nmm-repeatable-field' . $first_class . '" data-nmm-index="' . $i . '">' .
							'<span class="nmm-repeatable-count">' . ($i + 1) . '</span>' .
							$buttons .
							$value_output .
							'</div>';
					}
				}
			}

			$template_field = clone $this;
			$template_field->repeatable_output = true;
			$template_field->value = '';
			$template_field->_push('hierarchy', '%d');
			$template_field->_push('template_hierarchy', '%d');
			$template_output = $template_field->output();

			$output .= ($template_output == '') ? '' : '<div class="nmm-repeatable-template">' .
				'<span class="nmm-repeatable-count"></span>' .
				$buttons .
				$template_output .
				'</div>';

			return ($output == '') ? '' : '<div class="nmm-repeatable' . $this->get_field_classes(false) . '">' .
				$output .
				'<div class="nmm-repeatable-add">' .
				'<button type="button" class="button nmm-button">' . $this->add_row . '</button>' .
				'</div>' .
				'</div>';
		}

		/**
		 * Generate a reset button.
		 * 
		 * @since 1.4.0
		 * 
		 * @access private
		 * @return string Generated reset button.
		 */
		private function field_reset()
		{
			$this->repeatable = false;
			$this->content = ($this->content == '') ? __('Reset', 'noakes-menu-manager') : $this->content;
			$button = ' class="button button-large nmm-button' . $this->get_field_classes(false) . '"><span>' . $this->content . '</span></';

			return (empty($this->value)) ? '<button type="reset"' . $button . 'button>' : '<a href="' . esc_url($this->value) . '"' . $button . 'a>';
		}

		/**
		 * Generate a select field.
		 * 
		 * @since 1.4.0
		 * 
		 * @access private
		 * @return string Generated select field.
		 */
		private function field_select()
		{
			if (empty($this->options)) return '';
			
			$output = '<select' . $this->global_attributes . $this->template_data . $this->get_field_classes() . '>';
			
			foreach ($this->options as $value => $label)
			{
				$output .= '<option value="' . esc_attr($value) . '" ' . selected($value, $this->value, false) . '>' . $label . '</option>';
			}
			
			$output .= '</select>';
			
			return $output;
		}

		/**
		 * Generate a submit button.
		 * 
		 * @since 1.0.0
		 * 
		 * @access private
		 * @return string Generated submit button.
		 */
		private function field_submit()
		{
			$this->repeatable = false;
			$this->content = ($this->content == '') ? __('Submit', 'noakes-menu-manager') : $this->content;

			return '<button type="submit" disabled="disabled" class="button button-large button-primary nmm-button' . $this->get_field_classes(false) . '"><span>' . $this->content . '</span></button>';
		}

		/**
		 * Generate a text field.
		 * 
		 * @since 1.0.0
		 * 
		 * @access private
		 * @return string Generated text field.
		 */
		private function field_text()
		{
			if ($this->field_name != '')
			{
				$max_length = ($this->max_length == '' || !is_numeric($this->max_length)) ? '' : ' maxlength="' . $this->max_length . '"';

				return '<input' . $this->global_attributes . $this->template_data . ' type="text"' . $max_length . ' value="' . esc_attr($this->value) . '"' . $this->get_field_classes() . ' />';
			}

			return '';
		}

		/**
		 * Generate a contition field.
		 * 
		 * @since 1.4.0
		 * 
		 * @access private
		 * @param  string $field   Name of the field to check the condition for.
		 * @param  string $value   Value of the field to meet the condition.
		 * @param  string $compare Operator for comparing the field value.
		 * @return string          Generated condition field.
		 */
		private function generate_condition($field, $value, $compare)
		{
			return '<div class="hidden nmm-condition" data-nmm-conditional="' . esc_attr($this->field_name) . '" data-nmm-field="' . $this->generate_name(array($field)) . '" data-nmm-value="' . esc_attr($value) . '" data-nmm-compare="' . esc_attr($compare) . '"></div>';
		}
		
		/**
		 * Generate a field name.
		 *  
		 * @since 1.4.0
		 * 
		 * @access private
		 * @param  array  $hierarchy    Field hierarchy for the generated name.
		 * @param  array  $default_name Default name if there is no option name or hierarchy.
		 * @return string               Generated field name.
		 */
		private function generate_name($hierarchy, $default_name = '')
		{
			return ($this->option_name == '' || empty($hierarchy)) ? $default_name : $this->option_name . '[' . implode('][', $hierarchy) . ']';
		}

		/**
		 * Get the field class(es).
		 * 
		 * @since 1.0.0
		 * 
		 * @access private
		 * @param  boolean $add_attr True if the class attribute should be added.
		 * @return string            Generated field class(es).
		 */
		private function get_field_classes($add_attr = true)
		{
			if (!empty($this->field_classes))
			{
				$classes = esc_attr(implode(' ', $this->field_classes));

				return ($add_attr) ? ' class="' . $classes . '"' : ' ' . $classes;
			}

			return '';
		}
	}
}
