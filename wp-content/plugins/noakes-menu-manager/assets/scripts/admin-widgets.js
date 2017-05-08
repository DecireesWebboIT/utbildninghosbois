/*!
 * Admin widgets JavaScript include.
 * 
 * @since 1.4.0
 * 
 * @package Nav Menu Manager
 */
 
/**
 * Widgets localization object.
 * 
 * @since 1.4.0
 * 
 * @var    object
 */
var nmm_admin_widgets_l10n = nmm_admin_widgets_l10n || {};

(function ($)
{
	'use strict';

	/**
	 * Primary JSON objects.
	 * 
	 * @since 1.4.0
	 * 
	 * @access jQuery.nmm, jQuery.nmm.data, jQuery.nmm.events, jQuery.nmm.admin, jQuery.nmm.admin.widgets
	 * @var    object
	 */
	$.nmm = $.nmm || {};
	$.nmm.data = $.nmm.data || {};
	$.nmm.events = $.nmm.events || {};
	$.nmm.admin = $.nmm.admin || {};
	$.nmm.admin.widgets = $.nmm.admin.widgets || {};

	/**
	 * Custom data variable names.
	 * 
	 * @since 1.4.0
	 * 
	 * @access jQuery.nmm.data
	 * @var    object
	 */
	$.extend($.nmm.data,
	{
		'sibling': 'nmm-sibling'
	});

	/**
	 * Plugin widgets functionality.
	 * 
	 * @since 1.4.0
	 * 
	 * @access jQuery.nmm.admin.widgets
	 * @var    object
	 */
	$.extend($.nmm.admin.widgets,
	{
		/**
		 * Setup the menu widget dropdowns.
		 * 
		 * @since 1.4.0
		 * 
		 * @access jQuery.nmm.admin.widgets.menu_dropdowns
		 * @param  object widget Widget that is currently being handled.
		 * @return void
		 */
		'menu_dropdowns': function (widget)
		{
			widget = (typeof widget === 'undefined') ? $('.widget[id*="' + nmm_admin_widgets_l10n.menu_id + '"]').not('[id$="__i__"]').not('.' + $.nmm.events.setup) : widget;
			
			widget
			.each(function ()
			{
				var current = $(this).addClass($.nmm.events.setup);
				var theme_location = current.find('select[id$="theme_location"]');
				var menu = current.find('select[id$="nav_menu"]').data($.nmm.data.sibling, theme_location);
				
				theme_location.data($.nmm.data.sibling, menu).add(menu)
				.change(function ()
				{
					var changed = $(this);
					
					if (changed.val() !== '')
					{
						var sibling = changed.data($.nmm.data.sibling);
						
						if (sibling.val() !== '')
						{
							sibling
							.fadeOut(100, function ()
							{
								$(this).val('').fadeIn(100);
							});
						}
					}
				});
				
				current.find('.nmm-help-button').removeClass('nmm-disabled');
			});
		}
	});
	
	$.nmm.admin.widgets.menu_dropdowns();
	$.nmm.include.scroll_stop();
	
	$(document)
	.ready(function ()
	{
		var fire = function (e, widget)
		{
			$.nmm.admin.widgets.menu_dropdowns(widget);
			$.nmm.admin.help_buttons(widget);
		};
		
		fire();
		
		$(this).on('widget-added widget-updated', fire);
	});
})
(jQuery);
