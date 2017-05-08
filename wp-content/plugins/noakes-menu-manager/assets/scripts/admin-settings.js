/*!
 * Admin settings JavaScript include.
 * 
 * @since 1.3.0
 * 
 * @package Nav Menu Manager
 */

/**
 * Current WordPress admin page ID.
 * 
 * @since 1.2.4
 * 
 * @var    string
 */
var pagenow = pagenow || '';

/**
 * WordPress postboxes object.
 * 
 * @since 1.2.4
 * 
 * @var    object
 */
var postboxes = postboxes || {};

/**
 * Settings localization object.
 * 
 * @since 1.2.4
 * 
 * @var    object
 */
var nmm_admin_settings_l10n = nmm_admin_settings_l10n || {};

(function ($)
{
	'use strict';
	
	/**
	 * Primary JSON objects.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm, jQuery.nmm.data, jQuery.nmm.events, jQuery.nmm.include, jQuery.nmm.is, jQuery.nmm.admin, jQuery.nmm.admin.settings
	 * @var    object
	 */
	$.nmm = $.nmm || {};
	$.nmm.data = $.nmm.data || {};
	$.nmm.events = $.nmm.events || {};
	$.nmm.include = $.nmm.include || {};
	$.nmm.is = $.nmm.is || {};
	$.nmm.admin = $.nmm.admin || {};
	$.nmm.admin.settings = $.nmm.admin.settings || {};

	/**
	 * Custom data variable names.
	 * 
	 * @since 1.4.0 Added compare, conditional field, field and value data variable names.
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm.data
	 * @var    object
	 */
	$.extend($.nmm.data,
	{
		'compare': 'nmm-compare',
		'conditional': 'nmm-conditional',
		'field': 'nmm-field',
		'index': 'nmm-index',
		'template_name': 'nmm-template-name',
		'value': 'nmm-value'
	});

	/**
	 * Custom event names.
	 * 
	 * @since 1.4.0 Added check conditions event.
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm.events
	 * @var    object
	 */
	$.extend($.nmm.events,
	{
		'check_conditions': 'nmm-check-conditions',
		'finalize': 'nmm-finalize',
		'scale': 'nmm-scale',
		'set_index': 'nmm-set-index'
	});

	/**
	 * Methods for including functionality.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm.include
	 * @var    object
	 */
	$.extend($.nmm.include,
	{
		/**
		 * Include postboxes functionality.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.include.postboxes
		 * @return void
		 */
		'postboxes': function ()
		{
			if (!$.nmm.is.included('postboxes'))
			{
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');

				if (typeof postboxes !== 'undefined' && typeof pagenow !== 'undefined')
				{
					postboxes.add_postbox_toggles(pagenow);
				}
			}
		},

		/**
		 * Include window resize functionality.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.include.resize
		 * @return void
		 */
		'resize': function ()
		{
			if (!$.nmm.is.included('resize'))
			{
				$(window)
				.resize(function ()
				{
					$('.' + $.nmm.events.scale).nmm_trigger_all($.nmm.events.scale);
				});
			}
		}
	});

	/**
	 * Methods for checking values.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm.is
	 * @var object
	 */
	$.extend($.nmm.is,
	{
		/**
		 * Checks for a valid number.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.is.numeric
		 * @param  mixed   value Value to check.
		 * @return boolean       True if the value is a number. 
		 */
		'numeric': function (value)
		{
			return (typeof value === 'number' && !isNaN(value) && isFinite(value));
		}
	});

	/**
	 * Plugin settings functionality.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm.admin.settings
	 * @var    object
	 */
	$.extend($.nmm.admin.settings,
	{
		/**
		 * Prepare the code fields.
		 * 
		 * @since 1.4.0
		 * 
		 * @access jQuery.nmm.admin.settings.code_fields
		 * @return void
		 */
		'code_fields': function ()
		{
			$('.nmm-field-code')
			.each(function ()
			{
				var current = $(this);
				current.find('pre').nmm_select_text();
				
				current.find('button[id]')
				.click(function ()
				{
					var clicked = $(this);
					var code = $('#' + clicked.attr('id') + '-code');
					
					if (!clicked.hasClass('button-primary') && code.length > 0)
					{
						clicked.addClass('button-primary').siblings('button').removeClass('button-primary');
						clicked.siblings('pre').hide();
						code.show();
					}
				});
			});
		},
		
		/**
		 * Prepare fields with conditional logic.
		 * 
		 * @since 1.4.0
		 * 
		 * @access jQuery.nmm.admin.settings.conditional_logic
		 * @return void
		 */
		'conditional_logic': function ()
		{
			$('.nmm-condition[data-' + $.nmm.data.conditional + '][data-' + $.nmm.data.field + '][data-' + $.nmm.data.value + '][data-' + $.nmm.data.compare + ']')
			.each(function ()
			{
				var condition = $(this);
				var conditional = $('[name="' + condition.data($.nmm.data.conditional) + '"]');
				var field = $('[name="' + condition.data($.nmm.data.field) + '"]');
				
				if (!conditional.hasClass($.nmm.events.check_conditions))
				{
					conditional
					.nmm_add_event($.nmm.events.check_conditions, function ()
					{
						var current_conditional = $(this);
						var show_field = true;
						
						$('.nmm-condition[data-' + $.nmm.data.conditional + '="' + current_conditional.attr('name') + '"][data-' + $.nmm.data.field + '][data-' + $.nmm.data.value + '][data-' + $.nmm.data.compare + ']')
						.each(function ()
						{
							var current_condition = $(this);
							var current_field = $('[name="' + current_condition.data($.nmm.data.field) + '"]');
							var current_value = (current_field.is(':radio')) ? current_field.filter(':checked').val() : current_field.val();
							var compare = current_condition.data($.nmm.data.compare);
							var compare_matched = false;
							
							if (current_field.is(':checkbox'))
							{
								current_value = (current_field.is(':checked')) ? current_value : '';
							}
							
							if (compare === '!=')
							{
								compare_matched = (current_condition.data($.nmm.data.value) + '' !== current_value + '');
							}
							else
							{
								compare_matched = (current_condition.data($.nmm.data.value) + '' === current_value + '');
							}
							
							show_field = (show_field && compare_matched);
						});
						
						var parent = current_conditional.closest('.nmm-field');
						parent.next('.nmm-field-spacer').remove();
						
						if (show_field)
						{
							parent.stop(true).slideDown('fast');
						}
						else
						{
							parent.stop(true).slideUp('fast').after($('<div/>').addClass('hidden nmm-field-spacer'));
						}
					});
				}
				
				if (!field.hasClass('nmm-has-condition'))
				{
					field.addClass('nmm-has-condition')
					.on('change', function ()
					{
						$('.nmm-condition[data-' + $.nmm.data.conditional + '][data-' + $.nmm.data.field + '="' + $(this).attr('name') + '"][data-' + $.nmm.data.value + '][data-' + $.nmm.data.compare + ']')
						.each(function ()
						{
							$('[name="' + $(this).data($.nmm.data.conditional) + '"]').nmm_trigger_all($.nmm.events.check_conditions);
						});
					});
				}
			});
		},
		
		/**
		 * Prepare the settings form.
		 * 
		 * @since 1.4.0 Added form setup for the code generator.
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.admin.settings.forms
		 * @return void
		 */
		'forms': function ()
		{
			$.extend($.validator.messages, nmm_admin_settings_l10n.validator);

			$.validator.addMethod('nmm-location', function (value, element)
			{
				if (this.optional(element))
				{
					return true;
				}

				var $element = $(element);
				var valid = true;

				$element.closest('.nmm-meta-box').find('.nmm-location:visible').not($element)
				.each(function ()
				{
					var current = $(this);

					if (current.is('td'))
					{
						valid = (valid && (value !== current.text() || current.prev().children('input').is(':checked')));
					}
					else
					{
						valid = (valid && value !== current.val());
					}
				});

				return valid;
			});

			$.validator.addClassRules('nmm-location',
			{
				'nmm-location': true
			});

			$('#noakes_menu_manager_settings,#noakes_menu_manager_generator').children('form').nmm_validate_form().find('[type="submit"]').prop('disabled', false);
		},

		/**
		 * Prepare the settings repeatable fields.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.admin.settings.repeatable
		 * @return void
		 */
		'repeatable': function ()
		{
			$('.nmm-repeatable')
			.nmm_add_event($.nmm.events.scale, function ()
			{
				var repeatable = $(this);

				if (repeatable.width() < 480)
				{
					repeatable.addClass('nmm-thin-repeatable');
				}
				else
				{
					repeatable.removeClass('nmm-thin-repeatable');
				}
			})
			.on($.nmm.events.setup, function ()
			{
				var repeatable = $(this);

				if (!repeatable.hasClass('ui-sortable') && repeatable.is(':visible'))
				{
					repeatable
					.mousedown(function ()
					{
						var clicked = $(this);
						clicked.height(clicked.height());
					})
					.mouseup(function ()
					{
						$(this).css('height', '');
					})
					.sortable(
					{
						'containment': 'parent',
						'cursor': 'move',
						'forcePlaceholderSize': true,
						'handle': '> .nmm-repeatable-move',
						'items': '> .nmm-repeatable-field',
						'opacity': 0.75,
						'placeholder': 'nmm-repeatable-placeholder',
						'revert': 200,
						'tolerance': 'pointer',

						'stop': function (e, ui)
						{
							ui.item.parent('.nmm-repeatable').children('.nmm-repeatable-field').first().triggerHandler($.nmm.events.set_index, [0]);
						}
					});

					if (repeatable.children('.nmm-repeatable-field').length <= 1)
					{
						repeatable.sortable('disable');
					}
				}
			})
			.nmm_trigger_all($.nmm.events.setup);

			$('.nmm-repeatable-field,.nmm-repeatable-template')
			.mouseenter(function ()
			{
				$(this).addClass('nmm-hover');
			})
			.mouseleave(function ()
			{
				$(this).removeClass('nmm-hover');
			})
			.on($.nmm.events.finalize, function ()
			{
				$(this).css('opacity', '0')
				.animate(
				{
					'opacity': '1'
				},
				{
					'queue': false
				});
			})
			.on($.nmm.events.set_index, function (e, field_index)
			{
				if ($.nmm.is.numeric(field_index) && field_index >= 0)
				{
					var field = $(this);

					if (field_index !== field.data($.nmm.data.index))
					{
						field.data($.nmm.data.index, field_index);

						var placeholder = $('<div/>').addClass('nmm-repeatable-placeholder').insertBefore(field);
						var repeatables = field.parents('.nmm-repeatable-field');
						var dom_indexes = [];

						repeatables
						.each(function ()
						{
							dom_indexes[dom_indexes.length] = $(this).data($.nmm.data.index);
						});

						dom_indexes = dom_indexes.reverse();

						field.children('.nmm-repeatable-count').text(field_index + 1);
						field = field.detach();
						field.find('[data-' + $.nmm.data.template_name + ']').nmm_trigger_all($.nmm.events.finalize, [dom_indexes]);
						field.removeClass('nmm-first').insertAfter(placeholder);

						if (field_index === 0)
						{
							field.addClass('nmm-first');
						}

						placeholder.remove();
					}

					field.next('.nmm-repeatable-field').triggerHandler($.nmm.events.set_index, [field_index + 1]);
				}
			});

			$('.nmm-repeatable-move-down')
			.click(function ()
			{
				var moving = $(this).parent();
				var next = moving.next('.nmm-repeatable-field');

				if (next.length > 0)
				{
					moving.insertAfter(next).add(next).nmm_trigger_all($.nmm.events.finalize);
					next.triggerHandler($.nmm.events.set_index, [moving.data($.nmm.data.index)]);
				}
			});

			$('.nmm-repeatable-move-up')
			.click(function ()
			{
				var moving = $(this).parent();
				var previous = moving.prev('.nmm-repeatable-field');

				if (previous.length > 0)
				{
					moving.insertBefore(previous).add(previous).nmm_trigger_all($.nmm.events.finalize);
					moving.triggerHandler($.nmm.events.set_index, [previous.data($.nmm.data.index)]);
				}
			});

			$('.nmm-repeatable-insert')
			.click(function ()
			{
				var field = $(this).parent('.nmm-repeatable-field');
				field.parent('.nmm-repeatable').children('.nmm-repeatable-add').children('button').triggerHandler('click', [field]);
			});

			$('.nmm-repeatable-remove')
			.click(function ()
			{
				var field = $(this).parent('.nmm-repeatable-field');
				field.find('.ui-sortable').sortable('destroy');
				field.next('.nmm-repeatable-field').triggerHandler($.nmm.events.set_index, [field.data($.nmm.data.index)]);

				var repeatable = field.parent('.nmm-repeatable');

				if (repeatable.children('.nmm-repeatable-field').length <= 2)
				{
					repeatable.sortable('disable');
				}

				field.addClass('nmm-animating')
				.animate(
				{
					'height': '0px'
				},
				{
					'queue': false,

					'complete': function ()
					{
						$(this).remove();
					}
				});
			});

			$('[data-' + $.nmm.data.template_name + ']')
			.on($.nmm.events.finalize, function (e, dom_indexes)
			{
				var input = $(this);

				if ($.isArray(dom_indexes) && input.closest('.nmm-repeatable-template').length === 0)
				{
					var indexes = dom_indexes.slice(0);
					var repeatables = input.closest('.nmm-repeatable-field').parents('.nmm-repeatable-field').addBack();
					var name = input.data($.nmm.data.template_name);

					repeatables
					.each(function ()
					{
						indexes[indexes.length] = $(this).data($.nmm.data.index);
					});

					$.each(indexes, function (i, current_index)
					{
						name = name.replace('%d', current_index);
					});

					input
					.attr(
					{
						'id': name,
						'name': name
					});

					var input_wrapper = input.closest('.nmm-field-input');
					input_wrapper.find('[for]').attr('for', name);
					input_wrapper.closest('.nmm-field').children('.nmm-field-label').find('[for]').attr('for', name);
				}
			});

			$('.nmm-repeatable-add button')
			.click(function (e, insert_before)
			{
				var wrapper = $(this).closest('.nmm-repeatable');
				var template = wrapper.children('.nmm-repeatable-template').first();
				var field_index = -1;

				if (insert_before instanceof $ && insert_before.length > 0)
				{
					insert_before = insert_before.first();
					field_index = insert_before.data($.nmm.data.index);
				}
				else
				{
					insert_before = template;
					field_index = wrapper.children('.nmm-repeatable-field').length;
				}

				var field = template.clone(true, true).toggleClass('nmm-repeatable-field nmm-repeatable-template').addClass('nmm-animating').css('opacity', '0').insertBefore(insert_before);
				var repeatable = field.closest('.nmm-repeatable').sortable('refresh');

				if (repeatable.children('.nmm-repeatable-field').length > 1)
				{
					repeatable.sortable('enable');
				}

				repeatable.find('.nmm-repeatable').nmm_trigger_all($.nmm.events.setup);
				field.triggerHandler($.nmm.events.set_index, [field_index]);

				var height = field.height();

				field
				.css(
				{
					'height': '0',
					'opacity': ''
				})
				.animate(
				{
					'height': height + 'px'
				},
				{
					'queue': false,

					'complete': function ()
					{
						$(this).removeClass('nmm-animating').css('height', '');
					}
				});
			});
		}
	});

	$.fn.extend(
	{
		/**
		 * Add a custom event to all provided elements.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.fn.nmm_add_event
		 * @this   object     Elements to add the event to.
		 * @param  string   e Event name to add to all elements.
		 * @param  function f Function executed when the event is fired.
		 * @return object     Updated elements.
		 */
		'nmm_add_event': function (e, f)
		{
			return this.addClass(e).on(e, f).nmm_trigger_all(e);
		},
		
		/**
		 * Add text selection functionality to the provided elements.
		 * 
		 * @since 1.4.0
		 * 
		 * @access jQuery.fn.nmm_select_text
		 * @this   object Element to select the text for.
		 * @return object Provided elements.
		 */
		'nmm_select_text': function ()
		{
			return this
			.click(function ()
			{
				var range, selection;

				if (document.body.createTextRange)
				{
					range = document.body.createTextRange();
					range.moveToElementText(this);
					range.select();
				}
				else if (window.getSelection)
				{
					selection = window.getSelection();        
					range = document.createRange();
					range.selectNodeContents(this);
					selection.removeAllRanges();
					selection.addRange(range);
				}
			});
		},

		/**
		 * Validate the provided form elements.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.fn.nmm_validate_form
		 * @this   object Elements to validate.
		 * @return object Validated elements.
		 */
		'nmm_validate_form': function ()
		{
			return this
			.each(function ()
			{
				$(this)
				.validate(
				{
					'errorClass': 'nmm-error',
					'errorElement': 'div',
					'focusInvalid': false,

					'errorPlacement': function (error, element)
					{
						var parent = element.parent();

						if (element.is('[type="checkbox"]'))
						{
							error.addClass('nmm-standalone').appendTo(parent.parent());
						}
						else
						{
							error.insertAfter(parent);
						}

						error.hide().slideDown(200);
					},

					'invalidHandler': function (e, validator)
					{
						if (!validator.numberOfInvalids())
						{
							return;
						}

						var the_window = $(window), admin_bar_height = $('#wpadminbar').height();
						var window_height = the_window.height() - admin_bar_height, element = $(validator.errorList[0].element);
						var element_height = element.outerHeight(), element_top = element.offset().top;

						var scroll_top = element_top - admin_bar_height;
						scroll_top -= (element_height > window_height) ? 0 : Math.floor((window_height - element_height) / 2);

						$('html,body')
						.animate(
						{
							'scrollTop': Math.max(0, Math.min($(document).height() - window_height, scroll_top)) + 'px'
						},
						{
							'queue': false
						});
					},

					'submitHandler': function (form)
					{
						$(form).find('[type="submit"]').prop('disabled', true);

						form.submit();
					}
				});
			});
		}
	});

	$.nmm.include.postboxes();
	$.nmm.include.resize();
	$.nmm.include.scroll_stop();
	$.nmm.admin.settings.code_fields();
	$.nmm.admin.settings.conditional_logic();
	$.nmm.admin.settings.forms();
	$.nmm.admin.settings.repeatable();
})
(jQuery);
