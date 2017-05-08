jQuery(document).ready(function($)
{
    var saveBtn, closeItemList, saveItemList,
        settings = $($('#clever-mega-menu-item-settings').html()),
        tabs = $($('#clever-mega-menu-item-settings-tabs').html()),
        megaMenuToggle = $('#clever-enable-mega-menu-switch').html();

    $("#wpb-edit-inline").remove();
    $(".vc_show-mobile.vc_pull-right").remove();
    $("#vc_fullscreen-button").parent().remove();
    $("#vc_post-settings-button").parent().remove();
    $("#vc_ui-panel-post-settings .vc_ui-panel-header-heading").html( cleverMenuI18n.megaSettings);
    $("#vc_ui-panel-post-settings .vc_description").text(cleverMenuI18n.megaCssDesc);

    $('<div id="clever-mega-menu-item-header-bar"><ul class="clever-mega-menu-item-controls"><li><a id="clever-mega-menu-close-vc-box" href="#" class="vc_icon-btn vc_back-button" title="'+cleverMenuI18n.close+'"><i class="vc-composer-icon vc-c-icon-close"></i></a></li><li><a id="clever-mega-menu-save-item-settings-btn" class="" href="#">'+cleverMenuI18n.saveAll+'</a></li></ul></div>').insertBefore("#wpb_visual_composer div.inside");

    $("#clever-mega-menu-close-vc-box").on("click", function(e)
    {
        e.preventDefault();

        parentWindow.clever_menu_close_vc_popup();
    });

    if (megaMenuToggle) {
        $('ul.vc_navbar-nav').append('<li class="vc-show-whatever vc_pull-right clever-mega-menu-toggle-btn"><span>'+cleverMenuI18n.enableMega+'</span>'+megaMenuToggle +'</li>');
    }

    if (settings) {
        settings.insertBefore($("#visual_composer_content"));
    }

    tabs.insertBefore($("#wpb_visual_composer div.inside"));

    $(".clever-mega-menu-item-setting-tab").on("click", function()
    {
        var t = $(this);

        $(".clever-mega-menu-item-setting-tab").removeClass("active-item-setting-tab");

        t.addClass("active-item-setting-tab");

        if (t.hasClass("clever-mega-menu-to-design")) {
            $("#vc_navbar").hide();
            $("#vc_no-content-helper").hide();
            $("#visual_composer_content").hide();
            $(".clever-mega-menu-tab-settings", settings).hide();
            $(".clever-mega-menu-tab-icons", settings).hide();
            $(".clever-mega-menu-tab-design", settings).show();
        } else if (t.hasClass('clever-mega-menu-to-settings')) {
            $("#vc_navbar").hide();
            $("#vc_no-content-helper").hide();
            $("#visual_composer_content").hide();
            $(".clever-mega-menu-tab-design", settings).hide();
            $(".clever-mega-menu-tab-icons", settings).hide();
            $(".clever-mega-menu-tab-settings", settings).show();
        } else if (t.hasClass('clever-mega-menu-to-icons')) {
            $("#vc_navbar").hide();
            $("#vc_no-content-helper").hide();
            $("#visual_composer_content").hide();
            $(".clever-mega-menu-tab-design", settings).hide();
            $(".clever-mega-menu-tab-settings", settings).hide();
            $(".clever-mega-menu-tab-icons", settings).show();
        } else {
            $(".clever-mega-menu-tab-icons", settings).hide();
            $(".clever-mega-menu-tab-design", settings).hide();
            $(".clever-mega-menu-tab-settings", settings).hide();
            $("#visual_composer_content").show();
            $("#vc_no-content-helper").show();
            $("#vc_navbar").show();
        }
    });

    clever_setting_fields(settings);

    $('.clever-mega-menu-loading').remove();

    if (typeof vc !== 'undefined') {
        Shortcodes = vc.shortcodes;
        var parentWindow = window.parent || window.top;
        if (self !== parentWindow) {
            function clever_menu_save_item_settings()
            {
                var _data = $('#post').serializeObject();

                _data.enable = $('#clever-mega-menu-item-enable').prop('checked') ? "1" : "0";
                _data.action = 'save_clever_menu_item';

                $.ajax({
                    url: ajaxurl,
                    data: _data,
                    method: 'POST',
                    dataType: 'html'
                }).done(function(r)
                {
                    parentWindow.clever_menu_data_item_changes(_data, JSON.parse(r));
                }).fail(function(r)
                {
                    console.log(r);
                });
            }

            $('<h1>'+parentWindow.clever_mega_menu_item_title+'</h1>').insertBefore("#clever-mega-menu-item-header-bar .clever-mega-menu-item-controls");

            $("#clever-mega-menu-save-item-settings-btn").on('click', function(e)
            {
                e.preventDefault();

                clever_menu_save_item_settings();

                return false;
            });
        }
    }

    // Icon tabs
    if ($('.clever-mega-menu-icons-tabs').length) {
        $('.clever-mega-menu-icons-tabs').each(function()
        {
            var tab = $(this).parent(),
                tabHeader = $(this).find('.clever-mega-menu-icons-tab'),
                tabActive = $(this).find('.clever-mega-menu-icons-tab.active').data('tab'),
                tabContent = $(this).parent().find('.clever-mega-menu-icons-tab-content');

            tabContent.hide();
            tab.find('#' + tabActive).show();

            tabHeader.on('click', function(e)
            {
                e.preventDefault();
                tabHeader.removeClass('active');
                $(this).addClass('active');

                tabActive = $(this).data('tab');
                tabContent.hide();
                tab.find('#' + tabActive).show();
            });
        });
    }
});
