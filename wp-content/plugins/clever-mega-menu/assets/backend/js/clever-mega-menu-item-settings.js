var clever_setting_fields = function($context)
{
    'use strict';

    var $ = jQuery;

    // Fix color pickers.
    $('.color-picker', $context).each(function()
    {
        var c = $(this);
        c.wpColorPicker({
            change: function(event, ui)
            {
                c.val(ui.color.toString());
                c.trigger('change');
            },
        });
    });

    var setup_icon_picker = function($_context, $input)
    {
        $('.clever-mega-menu-icon-popup', $_context).each(function()
        {
            var pp = $(this);
            $('.icons-search-input', pp).on('keyup', function()
            {
                var v =  $(this).val();

                if (v !== '') {
                    v = v.toLocaleLowerCase();
                    $('.fip-icons-container .fip-box', pp).addClass('hide');
                    $('.fip-icons-container .fip-box[data-value*="'+v+'"]',  pp).removeClass('hide');
                } else {
                    $('.fip-icons-container .fip-box', pp).removeClass('hide');
                }
            });

            // current-icon
            $('.fip-icons-container .fip-box', pp).on('click', function()
            {
                $('.fip-icons-container .fip-box', pp).removeClass('current-icon');
                $(this).addClass('current-icon');
                $input.val( $(this).attr('data-value'));
                $('.selected-icon', pp).html($(this).html());
                return false;
            });

            // Toggle-list
            $('.toggle-list', pp).on('click', function()
            {
                var t = $(this);

                if (t.hasClass('closed')){
                    t.html('<i class="fip-fa dashicons dashicons-arrow-up-alt2"></i>');
                    $('.selector-popup', pp).slideDown();
                    t.removeClass('closed');
                } else {
                    t.addClass('closed');
                    t.html('<i class="fip-fa dashicons dashicons-arrow-down-alt2"></i>');
                    $('.selector-popup', pp).slideUp();
                }
            });

            // Remove icon
            $('.remove', pp).on('click', function()
            {
                $input.val('');

                $('.selected-icon', pp).html('');

                return false;
            });
        });
    };

    // Icon Picker
    var iconPicker = $('#clever-mega-menu-vc-icon-picker').html();

    $('.vc_icon_picker', $context).each(function()
    {
        var picker = $(iconPicker);
        picker.insertAfter($(this));
        setup_icon_picker(picker, $(this));
        var current_icon = $(this).val();

        if (current_icon !== '') {
            $('.selected-icon', picker).html('<i class="'+current_icon+'"></i>');
        }
    });
};

function clever_menu_settings(settings)
{
    var $ = jQuery;

    $('#update-nav-menu .menu-settings').append(settings);

    return false;
}

jQuery(document).ready(function($)
{
    var settings = $($('#clever-mega-menu-settings').html());

    if (settings) {
        clever_setting_fields(settings);
        clever_menu_settings(settings);
        if (typeof wpNavMenu !== 'undefined') {
            wpNavMenu.menusChanged = false;
        }
    }
});
