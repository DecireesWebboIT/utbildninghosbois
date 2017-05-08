window.clever_mega_menu_item_title = '';
window.currentEditItem = {};

function clever_menu_close_vc_popup() {
    jQuery('.clever-mega-menu-popup').hide();
    jQuery('#clever-mega-menu-overlay').hide();
}

function clever_menu_toggle_fields(selectBox, field1, field2, field1Val)
{
    var selectedVal = selectBox.val();

    if (selectedVal === field1Val) {
        field2.hide();
        field1.show();
    } else {
        field1.hide();
        field2.show();
    }

    return false;
}

function clever_menu_insert_iconic_value(btn, icons)
{
    jQuery(btn).on('click', function()
    {
        var i, t;

        t = jQuery(this);
        c = t.parent('label');
        i = t.next(icons, c);

        i.toggle('fast');

        jQuery(jQuery(icons + ' span'), c).on('click', function()
        {
            var iconValue = jQuery(this, c).attr('class');

            c.find('.clever-mega-menu-icon').attr('class', 'clever-mega-menu-icon ' + iconValue);

            c.find('input').val(iconValue);

            i.hide('fast');
        });
    });

    return false;
}

jQuery(document).ready(function($)
{
    // Color picker init.
    $('.color-picker').wpColorPicker();
    $('.wp-color-result').attr('title', cleverMenuI18n.select);

    clever_menu_insert_iconic_value('.clever-mega-menu-icon', '.clever-mega-menu-icons');

    // Conditionally show/hide menu settings.
    $(function()
    {
        var itemIcon = $(".clever-mega-menu-item-icon"),
            vcEditBtn = $(".clever-mega-menu-item-edit-btn"),
            enableCleverMenu = $("#clever-mega-menu-enable-checkbox"),
            advancedSettings = $(".clever-mega-menu-advanced-setting");

        if (enableCleverMenu.is(":checked")) {
            vcEditBtn.addClass('clever-mega-menu-active-edit-btn');
            itemIcon.show();
            advancedSettings.show();
        } else {
            vcEditBtn.removeClass('clever-mega-menu-active-edit-btn');
            itemIcon.hide();
            advancedSettings.hide();
        }

        enableCleverMenu.change(function()
        {
            if (enableCleverMenu.is(":checked")) {
                vcEditBtn.addClass('clever-mega-menu-active-edit-btn');
                itemIcon.show();
                advancedSettings.show();
            } else {
                vcEditBtn.removeClass('clever-mega-menu-active-edit-btn');
                itemIcon.hide();
                advancedSettings.hide();
            }
        });
    });
});


var cleverMenuEditor = function(item)
{
    var that = this, $ = jQuery;

    that.item     = item;
    that.tpl      = $($('#clever-mega-menu-popup-tpl').html());
    that.navId    = $('#update-nav-menu #menu').val();
    that.menuId   = $('input.menu-item-data-db-id', item).val();
    that.settings = false;

    if (typeof cleverMenuItems[that.menuId] !== 'undefined') {
        that.settings = cleverMenuItems[that.menuId];
    }

    if (that.settings) {
        if (that.settings.options.icon !== '') {
            $(".item-title", item).prepend('<span class="clever-mega-menu-item-icon"><i class="' + that.settings.options.icon + '"></i></span>');
        }
        if (that.settings.options.enable === 1 || that.settings.options.enable === '1') {
            item.addClass('clever-mega-menu-item-mega-enabled');
        } else {
            item.removeClass('clever-mega-menu-item-mega-enabled');
        }
    }

    that.autoFrameHeight = function()
    {
        if ($(window).width() < 800) {
            that.tpl.css({
                'left': (20)+'px',
                'top': ($('#wpadminbar').height() + 20)+'px',
            });
        } else {
            that.tpl.css({
                'left': ($('#adminmenuback').width() + 20)+'px',
                'top': ($('#wpadminbar').height() + 20)+'px',
            });
        }

        $('.clever-mega-menu-popup').each(function()
        {
            var h = that.tpl.height();
            $('iframe', that.tpl).eq(0).height (h - 30);
        });

    };

    that.setPopupTitle = function()
    {
        window.clever_mega_menu_item_title = $('.edit-menu-item-title', item).val();
    };

    that.hidePopup = function()
    {
        that.tpl.hide();
        $('#clever-mega-menu-overlay').remove();
    };

    that.openPopup = function(item)
    {
        window.currentEditItem = that;

        if ($('iframe', that.tpl).length > 0) {

        } else {
            var url;
            url = cleverMenuConfig.newCleverMenu+'&clever_menu_id='+that.navId+'&clever_menu_item_id='+that.menuId;
            that.tpl.append('<iframe id="clever-mega-menu-item-frame-'+that.menuId+'" src="'+url+'" class="clever-mega-menu-iframe"></iframe>');
        }

        that.frame = $('iframe', that.tpl).eq(0);
        that.tpl.attr('id', 'clever-mega-menu-menu-id-'+ that.menuId);

        $('#clever-mega-menu-overlay').remove();
        $('body').append('<div id="clever-mega-menu-overlay"></div>');

        $('#clever-mega-menu-overlay').on('click', function()
        {
            that.hidePopup();
            return false;
        });

        $('body .clever-mega-menu-popup').hide();

        that.setPopupTitle();

        if ($('#clever-mega-menu-menu-id-'+ that.menuId).length > 0) {
            that.autoFrameHeight();
        } else {
            that.autoFrameHeight();
            $('body').append(that.tpl);
            that.autoFrameHeight();
            $(window).resize(function()
            {
                that.autoFrameHeight();
            });
        }
        that.tpl.show();
    };

    $('.clever-mega-menu-item-edit-btn', item).on('click', function()
    {
        that.openPopup(item);
        return false;
    });
};

var cleverMenuAddEditBtn = function()
{
    enableCleverMenu = jQuery('#clever-mega-menu-enable-checkbox');

    jQuery('li', wpNavMenu.menuList).each(function()
    {
        var item = jQuery(this),
            itemTitle = jQuery('.item-title', item),
            classAttributeValue = 'clever-mega-menu-item-edit-btn';

        if (enableCleverMenu.is(":checked")) {
            classAttributeValue = 'clever-mega-menu-item-edit-btn clever-mega-menu-active-edit-btn';
        }

        if (jQuery('.clever-mega-menu-item-edit-btn', item).length === 0) {
            itemTitle.append('<span class="'+classAttributeValue+'"><i class="dashicons dashicons-admin-customizer"></i>'+cleverMenuI18n.megaMenu+'</span>');
            new cleverMenuEditor(item);
        }
    });
};

if (typeof wpNavMenu !== 'undefined') {
wpNavMenu.addItemToMenu = function(menuItem, processMethod, callback)
{
    var $ = jQuery;
    var menu = $('#menu').val(),
        nonce = $('#menu-settings-column-nonce').val(),
        params;

    processMethod = processMethod || function(){};
    callback = callback || function(){};

    params = {
        'action': 'add-menu-item',
        'menu': menu,
        'menu-settings-column-nonce': nonce,
        'menu-item': menuItem
    };

    $.post(ajaxurl, params, function(menuMarkup)
    {
        var ins = $('#menu-instructions');

        menuMarkup = $.trim(menuMarkup);

        processMethod(menuMarkup, params);

        $('li.pending').hide().fadeIn('slow');

        $('.drag-instructions').show();

        if(!ins.hasClass('menu-instructions-inactive') && ins.siblings().length) {
            ins.addClass('menu-instructions-inactive');
        }

        cleverMenuAddEditBtn($);

        callback();
    });
};
}
jQuery(document).ready(function($)
{
    if (typeof wpNavMenu !== 'undefined') {
        cleverMenuAddEditBtn();
    }

    $('form#update-nav-menu').submit(function()
    {
        $('body .clever-mega-menu-popup').remove();
    });
});

window['clever_menu_data_item_changes'] = function(data, respond)
{
    window.currentEditItem.tpl.hide();

    if(!respond.is_update) {
        jQuery('iframe', window.currentEditItem.tpl).remove();
    }

    jQuery('#clever-mega-menu-overlay').remove();

    cleverMenuItems[window.currentEditItem.menuId] = {
        url: respond.url,
        options: respond.settings
    };

    window.currentEditItem.settings = {
        url: respond.url,
        options: respond.settings
    };

    jQuery('.clever-mega-menu-item-icon', window.currentEditItem.item).remove();

    if (respond.settings.icon !== '') {
        jQuery('.item-title' , window.currentEditItem.item).prepend('<span class="clever-mega-menu-item-icon"><i class="'+respond.settings.icon+'"></i></span>');
    }

    if (respond.settings.enable === 1 || respond.settings.enable === '1'){
        window.currentEditItem.item.addClass('clever-mega-menu-item-mega-enabled');
    } else {
        window.currentEditItem.item.removeClass('clever-mega-menu-item-mega-enabled');
    }

    if (typeof wpNavMenu !== 'undefined') {
        wpNavMenu.menusChanged = false;
    }
};
