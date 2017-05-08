/**
 * Clever Mega Menu
 * @author Cleversoft
 */
;window.clevermenu = {};

function clever_sub_menu_width( selector ) {
    var w = selector.outerWidth();

    if ( w > jQuery( window ).width() ) {
        w = jQuery( window ).width();
    }

    return w;
}

(function( clevermenu, $ ) {

    clevermenu = clevermenu || {};

    $.extend( clevermenu, {
        options : {
            vmenu_sub_width_default: 600,
            break_point: 992,
            selector : {
                megaMenuSelector                : ".cmm",
                subMegaMenuContainerSelector    : ".cmm-content-container",
                subMegaMenuWrapperSelector      : ".cmm-content-wrapper"
            }
        },
        MegaMenu : {
            init: function() {
                $( clevermenu.options.selector.megaMenuSelector ).each( function() {
                    var options_data = $( this ).data( 'options' );

                    if ( isNaN( options_data.breakPoint ) || options_data.breakPoint <= 0 ) {
                        options_data.breakPoint = clevermenu.options.break_point;
                    }

                    clevermenu.MegaMenu.build( $( this ) );

                    // if( Math.max( window.outerWidth, $( window ).width() ) <= options_data.breakPoint ) {
                    if( $( window ).width() < options_data.breakPoint  ) {
                        clevermenu.MegaMenu.mobile( $( this ) );
                    }

                });
            },
            build: function( menu ) {
                var options_data = menu.data( 'options' );

                $( 'li.cmm-mega', menu ).each( function () {
                    var item = $( this ),
                        settings = $( this ).data( 'settings' ),
                        subMegaMenuContainer = $( clevermenu.options.selector.subMegaMenuContainerSelector, $( this ) ),
                        left = 0,
                        right = 0,
                        menuOffset =  $( menu ).offset(),
                        itemOffset =  $( this ).offset();

                    // Sub menu width
                    if ( isNaN( settings.width ) || settings.width <= 0 ) {
                        settings.width = clever_sub_menu_width( menu );
                    }

                    if ( settings.width > 0 && settings.layout != 'full' ) {
                        subMegaMenuContainer.width( settings.width );
                    }

                    switch ( settings.layout ) {
                        case 'center' :
                            subMegaMenuContainer.css( { 'left': ( - ( ( settings.width - item.width() ) / 2 ) ) + 'px', 'right': 'auto' } );
                            break;
                        case 'full' :
                            var parentWidth = clever_sub_menu_width( menu );

                            if( menu.parents( options_data.parentSelector ).length ) {
                                parentWidth = clever_sub_menu_width( menu.parents( options_data.parentSelector ) );
                            }

                            if ( $( options_data.parentSelector ).length ) {
                                var parentOffset = $( options_data.parentSelector ).offset();
                            } else {
                                var parentOffset = menuOffset;
                            }

                            subMegaMenuContainer.parent().css( { 'position': 'static' } );

                            if ( parentWidth > menu.outerWidth() ) {
                                subMegaMenuContainer.css( {'width': parentWidth, 'left': ( - ( menuOffset.left - parentOffset.left ) ) + 'px'} );
                            }
                            else {
                                subMegaMenuContainer.css( {'width': menu.outerWidth()} );
                            }
                    }

                });
            },
            mobile: function( menu ){

                var dropdownToggle = $( '<button />', { 'class': 'cmm-dropdown-toggle', 'aria-pressed': false }).append( '<i class="dashicons dashicons-arrow-down"></i>' );

                /* Item toggled */
                menu.find( '.menu-item-has-children button' ).remove();
                menu.find( '.menu-item-has-children > a' ).after( dropdownToggle );

                // Set the active submenu dropdown toggle button initial state.
                menu.find( '.current-menu-ancestor > button' )
                    .addClass( 'clever-toggled-on' )
                    .attr( 'aria-pressed', 'true' );

                // Set the active submenu initial state.
                menu.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'clever-toggled-on' );

                menu.find( '.cmm-dropdown-toggle' ).on( 'click', function( e ) {
                    var _this = $( this );

                    e.preventDefault();

                    _this.toggleClass( 'clever-toggled-on' );
                    _this.next( '.children, .sub-menu, .cmm-sub-container, .cmm-content-container' ).toggleClass( 'clever-toggled-on' );

                    _this.attr( 'aria-pressed', _this.attr( 'aria-pressed' ) === 'false' ? 'true' : 'false' );
                });
            }
        }
    });

}).apply( this, [window.clevermenu, jQuery] );

(function( clevermenu, $ ) {
    "use strict";

    function clevermenu_init() {

        // Mega Menu
        if ( typeof clevermenu.MegaMenu !== 'undefined' ) {
            clevermenu.MegaMenu.init();
        }
    }

    $(document).ready( function() {
        clevermenu_init();
    });

    $(window).resize( function() {
        clevermenu_init();
    })

}).apply( this, [window.clevermenu, jQuery] );

(function( $ ) {
    // Add the default attributes for the menu toggle and the navigations.
    var cleverMenuContainer = $( '.cmm-container' );

    cleverMenuContainer.each( function() {
        var cleverMegaMenu = $( this ).find( '.cmm' );
        var cleverMenuContainerId = $( this ).attr( 'id' );
        var cleverMenuContainerSelector = $('#' + cleverMenuContainerId);
        var mobileConfig = cleverMegaMenu.data( 'mobile' );
        var cleverMobileMenuSelector = $( this ).parent();

        if ( mobileConfig.toggleWrapper != '' && $( mobileConfig.toggleWrapper ).length && $( this ).closest( mobileConfig.toggleWrapper ).length && ! $( this ).is( $(mobileConfig.toggleWrapper) ) ) {
            cleverMobileMenuSelector = $( this ).closest( mobileConfig.toggleWrapper );
        }

        // Add menu toggle button.
        if ( mobileConfig.toggleDisable === '0') {;
            cleverMobileMenuSelector.prepend( '<div id="' + cleverMenuContainerId + '-toggle" class="' + cleverMenuContainerId + '-toggle cmm-toggle-wrapper"><button class="cmm-toggle" aria-controls="' + mobileConfig.ariaControls + '" aria-pressed="false"><span class="toggle-icon-open ' + mobileConfig.toggleIconOpen + '"></span><span class="toggle-icon-close ' + mobileConfig.toggleIconClose + '"></span><span class="toggle-text">' + mobileConfig.toggleMenuText + '</span></button></div>' );
        }

        // var cleverMenuToggle = $(this).find( '.cmm-toggle' );
        var cleverMenuToggle = cleverMobileMenuSelector.find( '#' + cleverMenuContainerId + '-toggle' ).children( '.cmm-toggle' );

        // Enable cleverMenuToggle.
        (function() {

            // Return early if cleverMenuToggle is missing.
            if ( ! cleverMenuToggle.length ) {
                return;
            }

            // Add an initial values for the attribute.
            cleverMenuToggle.attr( 'aria-pressed', 'false' );
            cleverMenuContainerSelector.attr( 'aria-expanded', 'false' );

            cleverMenuToggle.on( 'click', function() {
                var thisParent = $( this ).parent();
                $( '.cmm-toggle' ).each( function() {
                    var thisCleverMenuContainerSelector = $('#' + $(this).attr('aria-controls') ).parent();

                    if( ! thisParent.is( $( this ).parent() ) ) {
                        $( this ).add( thisCleverMenuContainerSelector ).removeClass( 'toggled-on' );
                    } else {
                        $( this ).add( cleverMenuContainerSelector ).toggleClass( 'toggled-on' );

                        $( this ).attr( 'aria-pressed', cleverMenuContainerSelector.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
                        cleverMenuContainerSelector.attr( 'aria-expanded', $( this ).attr( 'aria-pressed' ) === 'true' ? 'true' : 'false' );
                    }
                });
            });
        })();

        // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
        (function() {
            if ( ! cleverMenuContainerSelector.length || ! cleverMenuContainerSelector.children().length ) {
                return;
            }

            // Toggle `focus` class to allow submenu access on tablets.
            function cleverToggleFocusClassTouchScreen() {
                if ( 'none' === $( '.cmm-toggle' ).css( 'display' ) ) {

                    $( document.body ).on( 'touchstart', function( e ) {
                        if ( ! $( e.target ).closest( '.cmm-container li' ).length ) {
                            $( '.cmm-container li' ).removeClass( 'focus' );
                        }
                    });

                    cleverMenuContainerSelector.find( '.menu-item-has-children > a, .page_item_has_children > a' )
                        .on( 'touchstart', function( e ) {
                            var el = $( this ).parent( 'li' );

                            if ( ! el.hasClass( 'focus' ) ) {
                                e.preventDefault();
                                el.toggleClass( 'focus' );
                                el.siblings( '.focus' ).removeClass( 'focus' );
                            }
                        });

                } else {
                    cleverMenuContainerSelector.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart' );
                }
            }

            if ( 'ontouchstart' in window ) {
                $( window ).on( 'resize', cleverToggleFocusClassTouchScreen );
                cleverToggleFocusClassTouchScreen();
            }

            cleverMenuContainerSelector.find( 'a' ).on( 'focus blur', function() {
                $( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
            });
        })();

        function onResizeCleverMenu() {
            if ( 'none' != $( '.cmm-toggle' ).css( 'display' ) ) {

                if ( cleverMenuToggle.hasClass( 'toggled-on' ) ) {
                    cleverMenuToggle.attr( 'aria-pressed', 'true' );
                } else {
                    cleverMenuToggle.attr( 'aria-pressed', 'false' );
                }

                if ( cleverMenuContainerSelector.hasClass( 'toggled-on' ) ) {
                    cleverMenuContainerSelector.attr( 'aria-expanded', 'true' );
                } else {
                    cleverMenuContainerSelector.attr( 'aria-expanded', 'false' );
                }
            } else {
                cleverMenuToggle.removeAttr( 'aria-pressed' );
                cleverMenuContainerSelector.removeAttr( 'aria-expanded' );
                cleverMenuToggle.removeAttr( 'aria-controls' );
            }
        }

        $( document ).ready( function() {
            $( window ).on( 'load', onResizeCleverMenu );
            $( window ).on( 'resize', onResizeCleverMenu );
        });
    });
})( jQuery );
