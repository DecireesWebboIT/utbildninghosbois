;(function ( $ ) {
    $.fn.turbotabs = function(options){
        // setting the defaults
        var settings = $.extend({
            mode: 'horizontal',
            width: '100%',
            animation: 'Scale',
            cb_after_animation: function(){},
        },options);
        if( settings.deinitialize === 'true' ){
            return
        }
        var tabs = this.find('.Rich_Web_Tabs_tt_tabs');
        var container = this.find('.Rich_Web_Tabs_tt_container');
        var tab = this.find('.Rich_Web_Tabs_tt_container .Rich_Web_Tabs_tt_tab');
        var sel = this;
        var random =  'tab-' + Math.floor( Math.random() * 100 ); // for assigning random class (tobe used for hover effect)
        var animation = settings.animation;
        var animationIn = '';
        var animationOut = '';
        var once = 0;
        var primWidth = []; // create an array that will store the primary widths, before resizing (used in responsive function)
        var tabsResponsive = false;
        var timer = 340;
        var tabHeights = '';
        var maxHeight = '';

        setTimeout(function(){ // delay setting the heigh for small interval, giving it a time to collect right value
        calcHeight();
        },150);

        if( settings.mode == 'vertical' ){ // check if mode is set to vertical
            sel.addClass('vertical');
        }
        // applying the color, background and other options to the actual tab
        this.css({width: settings.width,});
        /*==============================================
                            ANIMATIONS
        ================================================*/
        function return_animation(animation){
            if( 'Scale' === animation ){
                animationIn = 'zoomIn';
                animationOut = 'zoomOut';
            }
            else if( 'FadeUp' === animation ){
                animationIn = 'fadeInUp';
                animationOut = 'fadeOutDown';
            }
            else if( 'FadeDown' === animation ){
                animationIn = 'fadeInDown';
                animationOut = 'fadeOutUp';
            }
            else if( 'FadeLeft' === animation ){
                animationIn = 'fadeInLeft';
                animationOut = 'fadeOutLeft';
            }
            else if( 'FadeRight' === animation ){
                animationIn = 'fadeInRight';
                animationOut = 'fadeOutRight';
            }
             else if( 'SlideUp' === animation ){
                animationIn = 'slideInUp';
                animationOut = 'slideOutUp';
                timer = 80;
            }
            else if( 'SlideDown' === animation ){
                animationIn = 'slideInDown';
                animationOut = 'slideOutDown';
                timer = 80;
            }
            else if( 'SlideLeft' === animation ){
                animationIn = 'slideInLeft';
                animationOut = 'slideOutLeft';
                timer = 80;
            }
            else if( 'SlideRight' === animation ){
                animationIn = 'slideInRight';
                animationOut = 'slideOutRight';
                timer = 80;
            }
            else if( 'ScrollDown' === animation ){
                animationIn = 'fadeInUp';
                animationOut = 'fadeOutUp';
            }
            else if( 'ScrollUp' === animation ){
                animationIn = 'fadeInDown';
                animationOut = 'fadeOutDown';
            }
            else if( 'ScrollRight' === animation ){
                animationIn = 'fadeInLeft';
                animationOut = 'fadeOutRight';
            }
            else if( 'ScrollLeft' === animation ){
                animationIn = 'fadeInRight';
                animationOut = 'fadeOutLeft';
            }
            else if( 'Bounce' === animation ){
                animationIn = 'bounceIn';
                animationOut = 'bounceOut';
            }
            else if( 'BounceLeft' === animation ){
                animationIn = 'bounceInLeft';
                animationOut = 'bounceOutLeft';
            }
            else if( 'BounceRight' === animation ){
                animationIn = 'bounceInRight';
                animationOut = 'bounceOutRight';
            }
            else if( 'BounceDown' === animation ){
                animationIn = 'bounceInDown';
                animationOut = 'bounceOutDown';
            }
            else if( 'BounceUp' === animation ){
                animationIn = 'bounceInUp';
                animationOut = 'bounceOutUp';
            } 
             else if( 'HorizontalFlip' === animation ){
                animationIn = 'flipInX';
                animationOut = 'flipOutX';
            }
            else if( 'VerticalFlip' === animation ){
                animationIn = 'flipInY';
                animationOut = 'flipOutY';
            }
             else if( 'RotateDownLeft' === animation ){
                animationIn = 'rotateInDownLeft';
                animationOut = 'rotateOutDownLeft';
            }
            else if( 'RotateDownRight' === animation ){
                animationIn = 'rotateInDownRight';
                animationOut = 'rotateOutDownRight';
            } 
            else if( 'RotateUpLeft' === animation ){
                animationIn = 'rotateInUpLeft';
                animationOut = 'rotateOutUpLeft';
            }
            else if( 'RotateUpRight' === animation ){
                animationIn = 'rotateInUpRight';
                animationOut = 'rotateOutUpRight';
            } 
            else if( 'TopZoom' === animation ){
                animationIn = 'zoomInUp';
                animationOut = 'zoomOutUp';
            }
            else if( 'BottomZoom' === animation ){
                animationIn = 'zoomInDown';
                animationOut = 'zoomOutDown';
            }
            else if( 'LeftZoom' === animation ){
                animationIn = 'zoomInLeft';
                animationOut = 'zoomOutLeft';
            }
            else if( 'RightZoom' === animation ){
                animationIn = 'zoomInRight';
                animationOut = 'zoomOutRight';
            }
        }

        /*==============================================
                       Initialize Tabs
        ===============================================*/
        return_animation(animation);
        tabs.find('li').on('click', function(){
            if( true === tabsResponsive ){
                 if( !$(this).hasClass("active") ) {
                    $(this).addClass('active').find('.Rich_Web_Tabs_tt_tab').slideDown(400, settings.cb_after_animation).parent().siblings().removeClass('active').find('.Rich_Web_Tabs_tt_tab').slideUp();
                 } else{
                     $(this).removeClass('active').find('.Rich_Web_Tabs_tt_tab').slideUp();
                 }// else
            } else {
                if( !$(this).hasClass("active") ) {

                    if( 'Random' === animation ){               
                        var animations_array = Array("Scale","Bounce","FadeUp","FadeDown","FadeLeft","FadeRight","SlideUp","SlideDown","SlideLeft","SlideRight","ScrollUp","ScrollDown","ScrollLeft","ScrollRight","BounceUp","BounceDown","BounceLeft","BounceRight","HorizontalFlip","VerticalFlip","RotateDownLeft","RotateDownRight","RotateUpLeft","RotateUpRight","TopZoom","BottomZoom","LeftZoom","RightZoom");
                        var rand_animation = animations_array[Math.floor(Math.random()*animations_array.length)];
                        return_animation(rand_animation);
                    }
                    var index = $(this).index();
                    var current = $(this);
                    $(this).parent().find("li.active").removeClass("active");
                    $(this).addClass("active");
                    $(this).closest(sel).find("div.Rich_Web_Tabs_tt_tab.active").attr('class', 'Rich_Web_Tabs_tt_tab Rich_Web_Tabs_animated ' + animationOut); 
                     setTimeout(function(){
                        current.closest(sel).find("div.Rich_Web_Tabs_tt_tab").eq(index).attr('class', 'Rich_Web_Tabs_tt_tab active Rich_Web_Tabs_animated '+ animationIn);
                        settings.cb_after_animation();
                    },timer);
                }// if
            }// else
        });
        /*==============================================
                        RESPONSIVENESS
        ===============================================*/
        // create variables that will store values that will be added later
            var tabsWidth = 0;
            var currWidth = 0;
            var conWidth = 0;
            var mobile = false;
            var tabW = 0;
            var called = 0;
            var resized = 0;
            primWidth['resized'] = 0;           
            calcWidth(); 
        if( settings.mode != 'accordion' ) {   

            if( settings.mode != 'vertical' ) {

                if( tabW < tabsWidth + 20 ){ // if starting from small screen transform it to accordion now
                    reset(); 
                    mobile = true;
                }
                
                $(window).resize(function(){
                    var windowWidth = parseInt( $(window).outerWidth() ); // check for device width;
                    calcWidth(); //callback

                    if( !mobile ) { // if viewed on larger screen and then resized to smaller one 
                        
                        if( true === tabsResponsive && currWidth > primWidth['container'] ||  tabs.width() > primWidth['container'] ){
                           resize(); 
                           $("div.Rich_Web_Tabs_tt_tab").removeClass('Rich_Web_Tabs_animated');
                        } else if( false === tabsResponsive && tabW < ( tabsWidth + 10 ) ){
                           reset(); 
                        } else if( primWidth['resized'] != 0 ){
                            if( currWidth > primWidth['resized'] + 40 ) {
                                resize(); 
                            }
                        }
                    } else { 
                       // if starting from small screen
                       if( windowWidth < 480 ) {
                           if(  true === tabsResponsive && currWidth > primWidth['container']  * 1.5 ) { 
                                resize(); 
                                $("div.Rich_Web_Tabs_tt_tab").removeClass('Rich_Web_Tabs_animated');
                                setTimeout(function(){
                                calcHeight();    
                                if( 1 === once ){
                                    primWidth['disposal'] = tabW + 130;
                                } //if
                                },120);
                                
                            } //if 
                            if( false === tabsResponsive && primWidth['disposal'] > currWidth ){ 
                                reset(); 
                            }//if
                        } else if( windowWidth > 480  ){
                            var zbr = tabs.find('li').length * 170; // calculate approximate width for each tab nav
                            if( currWidth > zbr ) {
                                resize();
                            } else {
                                reset();
                            }
                        }    
                    }//else
                }); //window.resize()
            } else { // if vertical mode 
                var windowWidth = parseInt( $(window).outerWidth() );
                
                 if( windowWidth < 760 ){ // if starting from small screen transform it to accordion now
                       reset();
                       mobile = true;
                       $("div.Rich_Web_Tabs_tt_tab").removeClass('Rich_Web_Tabs_animated');
                }

                $(window).resize(function(){
                    windowWidth = parseInt( $(window).outerWidth() ); //  updatedevice width;
                    calcWidth(); 
                    if( !mobile ) { // if viewed on larger screen and then resized to smaller one
                        if( windowWidth < 720 ){
                            reset(); 
                        } else {
                            resize(); 
                        }  
                    } else {
                        if( windowWidth > 720 ){
                            resize();
                            setTimeout(function(){
                                calcHeight();    
                            },120);
                        } else {
                            reset();
                        }//else

                    }//else
                });//window.resize()
            } // else (is vertical)
        } else {
            reset();
        }//else( is accordion)
        
        /*==============================================
                        HELPER FUNCTIONS
        ===============================================*/
        function calcWidth(){
             // reset variables before adding new values
             tabsWidth = 0;
             currWidth = 0;
             conWidth = 0;
             // get the widths of both navigations and container
             currWidth = parseInt( tabs.find('li').first().outerWidth(true) ); // get current width of resized tab li
             conWidth = parseInt( container.outerWidth(true) );
             if( tabsResponsive === false ){
                 tabs.find('li').each(function(){ // loop through navs and add width to variable
                    tabsWidth += parseInt( $(this).outerWidth(true) );
                 }); //if
            } else {
                tabsWidth = primWidth['tabs'];
            }//else
            // use the array created in the beginning to store primary widths
            //make sure that this process is done only once (preventing the new values to override the old ones)
            if( 0 === once ) {
                once++ ;
                primWidth['tabs'] = tabsWidth + 10;
                primWidth['container'] = conWidth;
            } else if ( 0 === once && mobile ){
                primWidth['container'] = sel.find('.Rich_Web_Tabs_tt_tabs li.active .Rich_Web_Tabs_tt_tab').width();
            }
            tabW = parseInt( $('.Rich_Web_Tabs_tt_tab').width() );
        }// calcWidth()

        function calcHeight(){
            //seting the the tab content height to the tallest tab content
            // src = http://stackoverflow.com/questions/6781031/use-jquery-css-to-find-the-tallest-of-all-elements
            // Get an array of all element heights
            tabHeights = tab.map(function() {
            return $(this).outerHeight(true);
            }).get();
            // Math.max takes a variable number of arguments
            // `apply` is equivalent to passing each height as an argument
            maxHeight = Math.max.apply(null, tabHeights);
            container.css('height', maxHeight);
        }// calcHeight()

        function reset(){ // transform tab to accordion if number of nav tabs exceeds container width
            tabsResponsive = true;
            if( called === 0 ){
                primWidth['resized'] = parseInt( container.width() );
                called++;
            }
            sel.addClass('responsive');
            if( tabs.find('li').first().find('h3').length != 1 ){
                tabs.find('li').wrapInner('<h3></h3>');
            }
            var index = -1;
            var zbir = tab.length;
            for( var i = 0; i < zbir; i++ ){
                (tab.eq(i)).appendTo(tabs.find('> li').eq(i));
            }
            if( resized === 0 ){
                resized++;
            }
            sel.find('.Rich_Web_Tabs_tt_tabs .Rich_Web_Tabs_tt_tab').not('.active').slideUp();
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_2').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_3').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_4').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_5').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_6').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_7').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_8').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_9').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_11').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_12').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_13').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_14').addClass('Rich_Web_Tabs_tabs_1');
            sel.find('.Rich_Web_Tabs_tt_tabs').removeClass('Rich_Web_Tabs_tabs_15').addClass('Rich_Web_Tabs_tabs_1');
            $("div.Rich_Web_Tabs_tt_tab").removeClass('Rich_Web_Tabs_animated');
        }// reset

        function resize(){ // reset accordion to tab again
            if( !mobile && settings.mode != 'vertical' ){
                tabsWidth = 0;
                currWidth = 0;
                conWidth = 0;
             }
            var activeIndex = tabs.find('li.active').index();
            sel.removeClass('responsive');  
            tabsResponsive = false;
            tabs.find('li').each(function(){
                var h3 = $(this).find('h3');
                var value = h3.html();
                $(this).find('.Rich_Web_Tabs_tt_tab').appendTo(container);
                $(this).html(value).find(h3).remove();
                tab.css('display', 'block');
            });
            tabs.find('li').eq(activeIndex).addClass('active').siblings().removeClass('active');
            container.find('.Rich_Web_Tabs_tt_tab').eq(activeIndex).addClass('active').siblings().removeClass('active');
            if( mobile ){
                tabW = 0;
                tabs.find('li').each(function(){ // loop through navs and add width to variable
                    tabW += parseInt( $(this).outerWidth(true) ); 
                });    
                conWidth = parseInt( container.outerWidth(true) );
            }   
        }// resize
       
        return this;

    }; // TurboTabs

}( jQuery ));
