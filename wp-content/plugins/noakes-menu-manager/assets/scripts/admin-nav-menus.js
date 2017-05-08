/*!
 * Admin nav menus JavaScript include.
 * 
 * @since 1.3.0
 * 
 * @package Nav Menu Manager
 */

/**
 * Main WordPress nav menus object.
 * 
 * @since 1.2.4
 * 
 * @var    object
 */
var wpNavMenu = wpNavMenu || {};

/**
 * Nav menu item currently being dragged.
 * 
 * @since 1.2.0
 * 
 * @var    object
 */
var nmm_dragged_item = null;

/**
 * Last nav menu item dropped.
 * 
 * @since 1.2.0
 * 
 * @var    object
 */
var nmm_dropped_item = null;

/**
 * Item currently hovered over.
 * 
 * @since 1.2.0
 * 
 * @var    object
 */
var nmm_hovered_item = null;

(function ($)
{
	'use strict';

	/**
	 * Primary JSON objects.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm, jQuery.nmm.data, jQuery.nmm.events, jQuery.nmm.admin, jQuery.nmm.admin.nav_menus
	 * @var    object
	 */
	$.nmm = $.nmm || {};
	$.nmm.data = $.nmm.data || {};
	$.nmm.events = $.nmm.events || {};
	$.nmm.admin = $.nmm.admin || {};
	$.nmm.admin.nav_menus = $.nmm.admin.nav_menus || {};

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
		'timeout': 'nmm-timeout'
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
		'extend': 'nmm-extend'
	});

	/**
	 * Plugin nav menus functionality.
	 * 
	 * @since 1.2.0
	 * 
	 * @access jQuery.nmm.admin.nav_menus
	 * @var    object
	 */
	$.extend($.nmm.admin.nav_menus,
	{
		/**
		 * Callbacks stored for the add item to menu functionality.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.admin.nav_menus.callbacks
		 * @var    object
		 */
		'callbacks':
		{
			/**
			 * Array of stored nav menu callbacks.
			 * 
			 * @since 1.2.0
			 * 
			 * @access jQuery.nmm.admin.nav_menus.callbacks.stored
			 * @var    array
			 */
			'stored': [],

			/**
			 * Store a nav menu callback.
			 * 
			 * @since 1.2.0
			 * 
			 * @access jQuery.nmm.admin.nav_menus.callbacks.add
			 * @param  function callback Callback to store.
			 * @return void
			 */
			'add': function (callback)
			{
				if (typeof callback === 'function')
				{
					$.nmm.admin.nav_menus.callbacks.stored[$.nmm.admin.nav_menus.callbacks.stored.length] = callback;
				}
			},

			/**
			 * Fire the first stored nav menu callback.
			 * 
			 * @since 1.2.0
			 * 
			 * @access jQuery.nmm.admin.nav_menus.callbacks.fire
			 * @return void
			 */
			'fire': function ()
			{
				if ($.nmm.admin.nav_menus.callbacks.stored.length > 0)
				{
					$.nmm.admin.nav_menus.callbacks.stored.shift()();
				}
			}
		},

		/**
		 * Check nav menu items for collapsibility.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.admin.nav_menus.check_collapsibility
		 * @return void
		 */
		'check_collapsibility': function ()
		{
			var has_collapsible = false;

			$('#menu-to-edit > .menu-item')
			.each(function ()
			{
				var menu_item = $(this);

				if (menu_item.hasClass('deleting') || menu_item.nmm_direct_child_menu_items().length === 0)
				{
					menu_item.removeClass('nmm-collapsible nmm-collapsed');
				}
				else
				{
					has_collapsible = true;

					menu_item.addClass('nmm-collapsible');
				}
			});

			var all_buttons = $('#nmm-collapse-expand-all').stop(true);
			var is_visible = all_buttons.is(':visible');

			if (has_collapsible && !is_visible)
			{
				all_buttons
				.slideDown(200, function ()
				{
					$(this).css('height', '');
				});
			}
			else if (!has_collapsible && is_visible)
			{
				all_buttons
				.slideUp(200, function ()
				{
					$(this).css('height', '');
				});
			}
		},

		/**
		 * Clear the timeout when hovering out of a nav menu item.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.admin.nav_menus.clear_hovered
		 * @return void
		 */
		'clear_hovered': function ()
		{
			if (nmm_hovered_item !== null)
			{
				clearTimeout(nmm_hovered_item.data($.nmm.data.timeout));

				nmm_hovered_item = null;
			}
		},

		/**
		 * Prepare collapse/expand functionality.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.admin.nav_menus.collapse_expand
		 * @return void
		 */
		'collapse_expand': function ()
		{
			var all_buttons = $('.nmm-collapse-expand-all').first();

			if (!all_buttons.parent().is('#post-body-content'))
			{
				all_buttons.attr('id', 'nmm-collapse-expand-all').insertBefore(all_buttons.closest('ul'));

				all_buttons.find('.nmm-collapse-all')
				.click(function ()
				{
					$('.nmm-collapsible').not('.nmm-collapsed').find('.nmm-collapse-expand').nmm_trigger_all('click');
				});

				all_buttons.find('.nmm-expand-all')
				.click(function ()
				{
					$('.nmm-collapsed').find('.nmm-collapse-expand').nmm_trigger_all('click');
				});
			}

			$('.menu-item > .menu-item-settings > .nmm-buttons > .nmm-collapse-expand')
			.each(function ()
			{
				var button = $(this);

				var menu_item = button.closest('.menu-item')
				.on($.nmm.events.extend, function ()
				{
					var current = $(this);
					var is_null = (nmm_hovered_item === null);

					if (is_null || !nmm_hovered_item.is(current))
					{
						if (!is_null)
						{
							$.nmm.admin.nav_menus.clear_hovered();
						}

						nmm_hovered_item = current;

						nmm_hovered_item
						.data($.nmm.data.timeout, setTimeout(function ()
						{
							nmm_hovered_item.find('.nmm-collapse-expand').triggerHandler('click');
							$.nmm.admin.nav_menus.clear_hovered();
						},
						1000));
					}
				});

				button.appendTo(menu_item.find('.item-controls'));
			})
			.click(function ()
			{
				var menu_item = $(this).closest('.menu-item');

				var complete = function ()
				{
					$(this).css('height', '');
				};

				if (menu_item.hasClass('nmm-collapsed'))
				{
					menu_item.removeClass('nmm-collapsed');

					var children = menu_item.nmm_direct_child_menu_items();

					while (children.length > 0)
					{
						children.stop(true).slideDown(200, complete);
						children = children.filter('.nmm-collapsible').not('.nmm-collapsed').nmm_direct_child_menu_items();
					}
				}
				else
				{
					menu_item.addClass('nmm-collapsed');
					menu_item.childMenuItems().stop(true).slideUp(200, complete);
				}
			});

			$.nmm.admin.nav_menus.check_collapsibility();
		},

		/**
		 * Check the position of the dragged item.
		 * 
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.admin.nav_menus.mousemove
		 * @return void
		 */
		'mousemove': function ()
		{
			var dragged_position = nmm_dragged_item.position();
			dragged_position.right = dragged_position.left + nmm_dragged_item.width();
			dragged_position.bottom = dragged_position.top + nmm_dragged_item.height();

			var collapsed = wpNavMenu.menuList.children('.menu-item.nmm-collapsed:visible').not(nmm_dragged_item)
			.filter(function ()
			{
				var current = $(this);
				var position = current.position();

				return (position.top <= dragged_position.bottom && position.top + current.height() >= dragged_position.top && position.left <= dragged_position.right && position.left + current.width() >= dragged_position.left);
			})
			.first();

			if (collapsed.length === 0)
			{
				$.nmm.admin.nav_menus.clear_hovered();
			}
			else if (!collapsed.is(nmm_hovered_item))
			{
				collapsed.triggerHandler($.nmm.events.extend);
			}
		},

		/**
		 * Tap into the built-in WordPress nav menus functionality.
		 * 
		 * @since 1.2.4 Expand collapsed items when parent item is removed.
		 * @since 1.2.0
		 * 
		 * @access jQuery.nmm.admin.nav_menus.override_nav_menus
		 * @return void
		 */
		'override_nav_menus': function ()
		{
			$.fn.default_shiftDepthClass = $.fn.shiftDepthClass;

			$.fn.shiftDepthClass = function (change)
			{
				this.default_shiftDepthClass(change);

				return this
				.each(function ()
				{
					var current = $(this);

					if (current.menuItemDepth() === 0)
					{
						current.find('.is-submenu').hide();
					}
				});
			};

			wpNavMenu.menuList
			.on('sortstart', function (e, ui)
			{
				nmm_dragged_item = ui.item;

				$(window).mousemove($.nmm.admin.nav_menus.mousemove);
			})
			.on('sortstop', function (e, ui)
			{
				$(window).unbind('mousemove', $.nmm.admin.nav_menus.mousemove);

				$.nmm.admin.nav_menus.clear_hovered();

				nmm_dragged_item = null;
				nmm_dropped_item = ui.item;
			});

			wpNavMenu.default_addItemToMenu = wpNavMenu.addItemToMenu;
			wpNavMenu.default_eventOnClickMenuItemDelete = wpNavMenu.eventOnClickMenuItemDelete;
			wpNavMenu.default_registerChange = wpNavMenu.registerChange;

			wpNavMenu.addItemToMenu = function (menu_item, process_method, callback)
			{
				$('.menu-item.pending:hidden').addClass('hidden');

				$.nmm.admin.nav_menus.callbacks.add(callback);

				callback = function ()
				{
					$('.menu-item.hidden').stop(true, true).hide().removeClass('hidden');

					$.nmm.admin.nav_menus.callbacks.fire();
					$.nmm.admin.help_buttons();
					$.nmm.admin.nav_menus.collapse_expand();
				};

				wpNavMenu.default_addItemToMenu(menu_item, process_method, callback);
			};

			wpNavMenu.eventOnClickMenuItemDelete = function (clicked)
			{
				var menu_item = $(clicked).closest('.menu-item');

				if (menu_item.is('.nmm-collapsed'))
				{
					menu_item.find('.nmm-collapse-expand').nmm_trigger_all('click');
				}

				wpNavMenu.default_eventOnClickMenuItemDelete(clicked);

				return false;
			};

			wpNavMenu.registerChange = function ()
			{
				wpNavMenu.default_registerChange();
				$.nmm.admin.nav_menus.check_collapsibility();

				if (nmm_dropped_item !== null)
				{
					var current_depth = nmm_dropped_item.menuItemDepth();

					while (current_depth > 0)
					{
						current_depth -= 1;

						var parent = nmm_dropped_item.prevAll('.menu-item-depth-' + current_depth).first();

						if (parent.hasClass('nmm-collapsed'))
						{
							parent.find('.nmm-collapse-expand').triggerHandler('click');
						}
					}

					nmm_dropped_item = null;
				}
			};
		}
	});

	$.fn.extend(
	{
		/**
		 * Return the direct children for the provided nav menu item.
		 * 
		 * @since 1.2.4 Added functionality for deleted parent items.
		 * @since 1.2.0
		 * 
		 * @access jQuery.fn.nmm_direct_child_menu_items
		 * @this   object Nav menu item to get children for.
		 * @return object Direct nav menu item children.
		 */
		'nmm_direct_child_menu_items': function ()
		{
			var result = $();

			this
			.each(function ()
			{
				var menu_item = $(this);
				var depth = menu_item.menuItemDepth();
				var next = menu_item.next('.menu-item');
				var target_depth = (next.length === 0) ? depth : next.menuItemDepth();
				var current_depth = target_depth;

				while (next.length > 0 && current_depth > depth)
				{
					if (next.hasClass('deleting'))
					{
						result = result.add(next.nmm_direct_child_menu_items());
					}
					else if (current_depth === target_depth)
					{
						result = result.add(next);
					}

					next = next.next('.menu-item');
					current_depth = (next.length === 0) ? depth : next.menuItemDepth();
				}
			});

			return result;
		}
	});

	$.nmm.include.scroll_stop();

	$(document)
	.ready(function ()
	{
		if ($(document.body).hasClass('nmm-collapse-expand-enabled'))
		{
			$.nmm.admin.nav_menus.override_nav_menus();
			$.nmm.admin.nav_menus.collapse_expand();
		}
	});
})
(jQuery);
