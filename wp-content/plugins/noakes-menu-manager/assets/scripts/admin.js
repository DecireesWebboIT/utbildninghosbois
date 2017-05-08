/*!
 * Admin JavaScript include.
 * 
 * @since	1.3.0
 * 
 * @package	Nav Menu Manager
 */

(function ($)
{
	'use strict';
	
	/**
	 * Primary JSON objects.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm, jQuery.nmm.data, jQuery.nmm.events, jQuery.nmm.include, jQuery.nmm.is, jQuery.nmm.admin
	 * @var    object
	 */
	$.nmm = $.nmm || {};
	$.nmm.data = $.nmm.data || {};
	$.nmm.events = $.nmm.events || {};
	$.nmm.include = $.nmm.include || {};
	$.nmm.is = $.nmm.is || {};
	$.nmm.admin = $.nmm.admin || {};

	/**
	 * Custom data variable names.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm.data
	 * @var    object
	 */
	$.extend($.nmm.data,
	{
		'help_tab_id': 'nmm-help-tab-id'
	});

	/**
	 * Custom event names.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm.events
	 * @var    object
	 */
	$.extend($.nmm.events,
	{
		'setup': 'nmm-setup'
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
		 * Include scroll stop functionality.
		 * 
		 * @since	1.2.0
		 * 
		 * @access	jQuery.nmm.include.scroll_stop
		 * @return	void
		 */
		'scroll_stop': function ()
		{
			if (!$.nmm.is.included('scroll-stop'))
			{
				$('html,body')
				.on('DOMMouseScroll keyup mousedown mousewheel scroll touchmove wheel', function ()
				{
					$(this).stop();
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
	 * @var    object
	 */
	$.extend($.nmm.is,
	{
		/**
		 * Checks for included functionality.
		 * 
		 * @since	1.2.0
		 * 
		 * @access jQuery.nmm.is.included
		 * @param  string  name Name for included functionality.
		 * @return boolean      True if the functionality is included.
		 */
		'included': function (name)
		{
			name = name.replace(/[^a-zA-Z0-9]/ig, '');
			name = 'noakes-' + name;

			var html = $('html');

			if (html.hasClass(name))
			{
				return true;
			}

			html.addClass(name);

			return false;
		}
	});

	/**
	 * Global functionality.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm.admin
	 * @var    object
	 */
	$.extend($.nmm.admin,
	{
		/**
		 * Prepare plugin help buttons.
		 * 
		 * @since 1.4.0 Changed functionality to allow for empty help tab IDs.
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.admin.help_buttons
		 * @param  object parent Parent object that contains the help buttons to prepare.
		 * @return void
		 */
		'help_buttons': function (parent)
		{
			var buttons = (typeof parent === 'undefined') ? $('#contextual-help-wrap .nmm-help-button[data-' + $.nmm.data.help_tab_id + '],.wrap .nmm-help-button[data-' + $.nmm.data.help_tab_id + ']').not('.nmm-disabled').not('.' + $.nmm.events.setup).addClass($.nmm.events.setup) : parent.find('.nmm-help-button');
			
			buttons
			.css(
			{
				'display': 'inline-block',
				'opacity': '1'
			})
			.click(function (e)
			{
				e.stopPropagation();

				$('#tab-link-' + $(this).data($.nmm.data.help_tab_id) + ' > a').click();
				$('#contextual-help-link').not('.screen-meta-active').click();

				$('html,body')
				.animate(
				{
					'scrollTop': '0px'
				},
				{
					'queue': false
				});
			});

			$('#screen-options-wrap .nmm-help-button').remove();
		},
		 
		/**
		 * Prepare plugin help tabs.
		 * 
		 * @since 1.4.0
		 * 
		 * @access jQuery.nmm.admin.help_tabs
		 * @return void
		 */
		'help_tabs': function ()
		{
			var help = $('#contextual-help-columns');

			help.find('li[id^="tab-link-nmm-"],.help-tab-content[id^="tab-panel-nmm-"]')
			.each(function ()
			{
				var current = $(this);
				current.appendTo(current.parent());
			});

			help.find('.contextual-help-tabs > ul,.contextual-help-tabs-wrap')
			.each(function ()
			{
				$(this).children().removeClass('active').first().addClass('active');
			});
		}
	});

	$.fn.extend(
	{
		/**
		 * Fire an event on all provided elements.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.fn.nmm_trigger_all
		 * @this   object      Elements to fire the event on.
		 * @param  string e    Event name to fire on all elements.
		 * @param  string attr Attributes that should be included with the event.
		 * @return object      Triggered elements.
		 */
		'nmm_trigger_all': function (e, attr)
		{
			attr = (typeof attr === 'undefined') ? [] : attr;
			attr = ($.isArray(attr)) ? attr : [attr];

			return this
			.each(function ()
			{
				$(this).triggerHandler(e, attr);
			});
		}
	});

	$.nmm.admin.help_buttons();
	$.nmm.admin.help_tabs();
})
(jQuery);
