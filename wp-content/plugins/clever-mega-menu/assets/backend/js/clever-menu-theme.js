jQuery(document).ready(function($)
{
    "use strict";

    // Change submitdiv box top position.
    $(function()
    {
        var submitDiv = $(".post-type-clever_menu_theme #submitdiv");

        if (submitDiv.length) {
            var side = $("#side-sortables").offset();
            var pos = submitDiv.offset();

            submitDiv.css("top", side.top);

            if (side.top < pos.top) {
                submitDiv.css("top", "32px");
            }

            $(window).scroll(function()
            {
                if ($(window).scrollTop() >= side.top) {
                    submitDiv.css("top", "32px");
                } else {
                    submitDiv.css("top", side.top);
                }
            });
        }
    });

    $("#clever-mega-menu-theme-metabox .nav-tab").on("click", function()
    {
        $(".nav-tab").removeClass("tab-active");
        $(this).addClass("tab-active");
        $(".clever-mega-menu-theme-metabox").hide();
        $(this.dataset.tabId).show();
    });

    $(function()
    {
        var disableMobileToggleCheckbox = $("#cmm-disable-mobile-menu-toggle"),
            disableMobileToggleFields = $(".cmm-mobile-toggle-option-field");

        if (disableMobileToggleCheckbox.is(":checked")) {
          disableMobileToggleFields.hide();
        } else {
          disableMobileToggleFields.show();
        }

        disableMobileToggleCheckbox.change(function() {
            if (disableMobileToggleCheckbox.is(":checked")) {
              disableMobileToggleFields.hide();
            } else {
              disableMobileToggleFields.show();
            }
        });
    });
});
