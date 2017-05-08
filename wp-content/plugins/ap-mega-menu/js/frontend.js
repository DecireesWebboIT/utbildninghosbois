/**
 * WP Mega Menu jQuery Plugin
*/
jQuery(function ($) {
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 var is_mobile = true;
}else{
 var is_mobile = false;
}

  var mobile_toggle_option = wp_megamenu_params.wpmm_mobile_toggle_option; //toggle_standard or toggle_accordion
  var event_behavior = wp_megamenu_params.wpmm_event_behavior;
  var ajaxurl = wp_megamenu_params.wpmm_ajaxurl;
  var ajax_nonce = wp_megamenu_params.wpmm_ajax_nonce;
  var check_woocommerce_enabled = wp_megamenu_params.check_woocommerce_enabled;
  var enable_mobile = wp_megamenu_params.enable_mobile;

    $('body').addClass('wpmm_megamenu');


    //search box
        var submitIcon = $('.wpmm-search-inline');
        var inputBox = $('.wpmm-search-icon .search-field');
        var isOpen = false;

        submitIcon.click(function(e){
          e.preventDefault();
          if($(this).next().find('.wpmm-search-icon').hasClass('inline-search')){
          if(isOpen == false){
             $(this).next().find('.inline-search').addClass('searchbox-open').removeClass('searchbox-closed');
            inputBox.focus();
            isOpen = true;
          } else {
             $(this).next().find('.inline-search').removeClass('searchbox-open').addClass('searchbox-closed');
            inputBox.focusout();
            isOpen = false;
          }
           }
        });



     
    if(check_woocommerce_enabled == "true"){
          if(!$('body').hasClass('woocommerce')){
             $('body').addClass('woocommerce');
          }
        }

          
            var submenu_open = event_behavior; // check event behavior as follow link on second click or toggle menu on second click
            /* searchtype onclick function */
            // $('.wpmm-onclick .wpmega-searchdown').click(function(e){
               $('body').on( "click",'.wpmm-onclick .wpmega-searchdown', function(e) {
                    e.preventDefault();
                     if($(this).closest('.wp-megamenu-main-wrapper').hasClass('wpmm-fade')){
                      //fade
                          if($(this).parent().find('.wpmm-sub-menu-wrap').hasClass('wpmm-open-fade')){
                                $(this).parent().find('.wpmm-sub-menu-wrap').removeClass('wpmm-open-fade');
                                //$(this).parent().removeClass('active-show');
                              }else{
                                $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrap').removeClass('wpmm-open-fade');
                                $(this).parent().find('.wpmm-sub-menu-wrap').addClass('wpmm-open-fade');
                               // $(this).parent().addClass('active-show');
                              }
                     }else{
                        //slide
                                if($(this).parent().find('.wpmm-sub-menu-wrap').hasClass('wpmm-mega-slidedown')){
                                    $(this).parent().find('.wpmm-sub-menu-wrap').removeClass('wpmm-mega-slidedown').addClass('wpmm-mega-slideup');
                                    $(this).parent().find('.wpmm-mega-slideup').slideUp('slow');
                                  }else{
                                    $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrap').removeClass('wpmm-mega-slidedown');
                                    $(this).parent().find('.wpmm-sub-menu-wrap').removeClass("wpmm-mega-slideup").addClass("wpmm-mega-slidedown");
                                       $(this).parent().find('.wpmm-mega-slidedown').slideDown('slow');
                        
                                  }

                     }


            });
            
    
               $('body').on( "click",'.wpmm-onclick .wp-mega-menu-link', function(e) {
                    e.preventDefault();              
                   var link = $(this).attr('href');

                if($(this).parent().find('.wpmm-sub-menu-wrap').length > 0 || $(this).parent().find('.wpmm-sub-menu-wrapper').length > 0){
                    if(submenu_open=="follow_link"){
                      //Open submenu on first click and follow link on second click.
                        if(!$(this).hasClass('clicked')){
                         
                             if($(this).closest('.wp-megamenu-main-wrapper').hasClass('wpmm-fade')){
                                //effect as fade
                                 if($(this).parent().hasClass('wpmega-menu-megamenu')){ 
                                 //megamenu         
                                 if($(this).parent().find('.wpmm-sub-menu-wrap').hasClass('wpmm-open-fade')){
                                 
                                      $(this).closest('.wpmm-mega-wrapper').find('.wp-mega-menu-link').removeClass('clicked');  
                                      $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrap').removeClass('wpmm-open-fade');
                                      $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrapper').removeClass('wpmm-open-fade');
                                      $(this).closest('.wpmm-mega-wrapper').find('li').removeClass('active-show');
                                      
                                 }else{

                                      $(this).parent().find('.wpmm-sub-menu-wrap').addClass('wpmm-open-fade');
                                      $(this).parent().find('.wpmm-sub-menu-wrapper').addClass('wpmm-open-fade');
                                      $(this).parent().find('.wp-mega-menu-link').addClass('clicked');  
                                      $(this).parent().addClass('active-show');

                                 }
                             
                                }else{
                                  //flyout
                                    $(this).siblings('.wpmm-sub-menu-wrapper').toggleClass('wpmm-open-fade');
                                    $(this).parent().addClass('active-show');
                                    if(!$(this).siblings('.wpmm-sub-menu-wrapper').hasClass('wpmm-open-fade')){
                                     $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrap').removeClass('wpmm-open-fade'); 
                                     $(this).closest('.wpmm-mega-wrapper').find('.wp-mega-menu-link').not($(this)).removeClass('clicked');
                                     $(this).closest('.wpmm-mega-wrapper').find('.wp-mega-menu-link').removeClass('clicked');
                                     $(this).parent().removeClass('active-show');
                                   }
                                }
                            }else{
                              
                                //slide
                                if($(this).parent().hasClass('wpmega-menu-megamenu')){
                                    if($(this).parent().find('.wpmm-sub-menu-wrap').hasClass('wpmm-mega-slidedown')){
                                     
                                       $(this).parent().find('.wpmm-sub-menu-wrap').removeClass('wpmm-mega-slidedown').addClass('wpmm-mega-slideup');
                                       $(this).parent().removeClass('active-show');
                                    }else{
                                       
                                      $(this).closest('.wpmm-mega-wrapper').find('.wp-mega-menu-link').removeClass('clicked');  
                                      $(this).closest('.wpmm-mega-wrapper').find('li').removeClass('active-show');
                                       $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrap').removeClass('wpmm-mega-slidedown');
                                       $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrapper').removeClass('wpmm-mega-slidedown');
                                       $(this).parent().find('.wpmm-sub-menu-wrap').removeClass("wpmm-mega-slideup").addClass("wpmm-mega-slidedown");
                                       $(this).parent().addClass('active-show');
                                      }
                                  }else{
                                    //flyout
                                     if($(this).parent().find('.wpmm-sub-menu-wrapper').hasClass('wpmm-mega-slidedown')){
                                       $(this).siblings('.wpmm-sub-menu-wrapper').removeClass('wpmm-mega-slidedown');
                                         $(this).closest('.wpmm-mega-wrapper').find('li').removeClass('active-show');
                                    }else{

                                        $(this).siblings('.wpmm-sub-menu-wrapper').removeClass('wpmm-mega-slideup').addClass("wpmm-mega-slidedown");
                                         $(this).parent().addClass('active-show');
                                      
                                      }
                                  }
                               }
                            $(this).addClass('clicked');                            
                        }else{
                         
                               if(!link || link == '#') {      
                                             $(this).removeClass('clicked');  

                                              if($(this).parent().hasClass('wpmega-menu-megamenu')){
                                                if($('.wp-megamenu-main-wrapper').hasClass('wpmm-fade')){
                                                  $( this ).parent().find('.wpmm-sub-menu-wrap').removeClass('wpmm-open-fade');
                                                  $(this).parent().removeClass('active-show');
                                                }else{

                                                   if($(this).parent().find('.wpmm-sub-menu-wrap').hasClass('wpmm-mega-slidedown')){
                                                     $(this).parent().find('.wpmm-sub-menu-wrap').removeClass('wpmm-mega-slidedown').addClass('wpmm-mega-slideup');
                                                     $(this).parent().removeClass('active-show');
                                                  }else{
                                                    $(this).closest('.wpmm-mega-wrapper').find('.wp-mega-menu-link').removeClass('clicked');  
                                                    $(this).closest('.wpmm-mega-wrapper').find('li').removeClass('active-show');
                                                     $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrap').removeClass('wpmm-mega-slidedown');
                                                     $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrapper').removeClass('wpmm-mega-slidedown');
                                                     $(this).parent().find('.wpmm-sub-menu-wrap').removeClass("wpmm-mega-slideup").addClass("wpmm-mega-slidedown");
                                                     $(this).parent().addClass('active-show');
                                                    }

                                                  // $(this).parent().find('.wpmm-sub-menu-wrap').removeClass('wpmm-mega-slidedown').addClass('wpmm-mega-slideup');
                                                   // $(this).parent().addClass('active-show');
                                                    // $(this).closest('.wpmm-mega-wrapper').find('li').removeClass('active-show');
                                                }
                                              }else{
                                                //flyout
                                                 if($('.wp-megamenu-main-wrapper').hasClass('wpmm-fade')){
                                                  //fade open
                                                   $(this).siblings('.wpmm-sub-menu-wrapper').removeClass('wpmm-open-fade');
                                                   $(this).parent().removeClass('active-show');
                                                }else{
                                                  //slide
                                                   if($(this).parent().find('.wpmm-sub-menu-wrapper').hasClass('wpmm-mega-slidedown')){
                                                         $(this).siblings('.wpmm-sub-menu-wrapper').removeClass('wpmm-mega-slidedown');
                                                           $(this).closest('.wpmm-mega-wrapper').find('li').removeClass('active-show');
                                                      }else{

                                                          $(this).siblings('.wpmm-sub-menu-wrapper').removeClass('wpmm-mega-slideup').addClass("wpmm-mega-slidedown");
                                                           $(this).parent().addClass('active-show');
                                                        
                                                        }

                                                    // $(this).siblings('.wpmm-sub-menu-wrapper').removeClass('wpmm-mega-slidedown');
                                                    // $(this).parent().addClass('active-show');
                                                }

                                              }
                                            return false; 
                                      }else{
                                       
                                        if($(this).hasClass('clicked')){
                                          var target = $(this).attr('target');
                                        //  alert(target);
                                        if(target == "_blank"){
                                          window.open(link,target);
                                        }else{
                                           window.location= link;
                                         }
                                        
                                        }else{
                                          $(this).closest('.wpmm-mega-wrapper').find('.wp-mega-menu-link').removeClass('clicked');  
                                          $(this).addClass('clicked');          
                                        }
                                        
                                      }             
                         }

                    }else{
                        //submenu_click
                        //Open Submenu on first click and close on second click.
                             $(this).removeClass('clicked'); 

                             if($(this).closest('.wp-megamenu-main-wrapper').hasClass('wpmm-fade')){
                              //fade effect
                               if($(this).parent().hasClass('wpmega-menu-megamenu')){
                               // alert('megamenu');
                                //megamennu
                                 if($(this).parent().find('.wpmm-sub-menu-wrap').hasClass('wpmm-open-fade')){
                                    $(this).parent().find('.wpmm-sub-menu-wrap').removeClass('wpmm-open-fade');
                                    $(this).parent().removeClass('active-show');
                                  }else{
                                    $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrap').removeClass('wpmm-open-fade');
                                    $(this).closest('.wpmm-mega-wrapper').find('li').removeClass('active-show');
                                    $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrapper').removeClass('wpmm-open-fade');
                                    $(this).parent().find('.wpmm-sub-menu-wrap').addClass('wpmm-open-fade');
                                    $(this).parent().addClass('active-show');
                                  }
                                }else{
                                  //flyout
                               
                                    if($(this).siblings('.wpmm-sub-menu-wrapper').hasClass('wpmm-open-fade')){
                                      $(this).siblings('.wpmm-sub-menu-wrapper').removeClass('wpmm-open-fade');
                                      $(this).parent().removeClass('active-show');
                                    }else{
                                       $(this).siblings('.wpmm-sub-menu-wrapper').addClass('wpmm-open-fade');
                                       $(this).parent().addClass('active-show');
                                    }

                                }

                               
                      }else{
                            //    alert('yes_slide');
                            //slide effect
                               if($(this).parent().hasClass('wpmega-menu-megamenu')){
                                    if($(this).parent().find('.wpmm-sub-menu-wrap').hasClass('wpmm-mega-slidedown')){
                                       $(this).parent().find('.wpmm-sub-menu-wrap').removeClass('wpmm-mega-slidedown');
                                        $(this).parent().removeClass('active-show');
                                    }else{
                                       $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrap').removeClass('wpmm-mega-slidedown');
                                       $(this).closest('.wpmm-mega-wrapper').find('li').removeClass('active-show');
                                       $(this).closest('.wpmm-mega-wrapper').find('.wpmm-sub-menu-wrapper').removeClass('wpmm-mega-slidedown');
                                       $(this).parent().find('.wpmm-sub-menu-wrap').removeClass("wpmm-mega-slideup").addClass("wpmm-mega-slidedown");
                                        $(this).parent().addClass('active-show');
                                      }
                                  }else{
                                    //flyout
                                     if($(this).siblings('.wpmm-sub-menu-wrapper').hasClass('wpmm-mega-slidedown')){
                                        $(this).siblings('.wpmm-sub-menu-wrapper').removeClass('wpmm-mega-slidedown');
                                        $(this).parent().removeClass('active-show');
                                    }else{
                                        $(this).siblings('.wpmm-sub-menu-wrapper').removeClass("wpmm-mega-slideup").addClass("wpmm-mega-slidedown");
                                        $(this).parent().addClass('active-show');
                                     }

                            
                                  }
                               }
                    }

          }else{
                  var target = $(this).attr('target');
                   if(target== ""){
                   target = "_self";
                   }
                    //  alert(target);
                    if(target == "_blank"){
                      window.open(link,target);
                    }else{
                       window.location= link;
                     }

          }


                
                });


         $(document).on('click', function (e) {
              if ($(e.target).closest(".wp-megamenu-main-wrapper").length === 0) {
                  $(".wp-megamenu-main-wrapper .wpmm-sub-menu-wrap").removeClass('wpmm-open-fade');
                  $(".wp-megamenu-main-wrapper li").removeClass('active-show');
                  $(".wp-megamenu-main-wrapper .wpmm-search-form .wpmm-search-icon").addClass('searchbox-closed');
                  $(".wp-megamenu-main-wrapper .wpmm-sub-menu-wrapper").removeClass('wpmm-open-fade');
                  $(".wp-megamenu-main-wrapper .wp-mega-menu-link").removeClass('clicked');
              }
          });


          /* Responsive Settings Toggle Bar*/

                  // $('.nav-toggle').click(function() {
        //    $('.nav-wrapper .menu').slideToggle('slow');
        //    $(this).parent('.nav-wrapper').toggleClass('active');
        // });
 // $('.nav-wrapper .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>');
        // $('.nav-wrapper .page_item_has_children').append('<span class="sub-toggle-children"> <i class="fa fa-angle-right"></i> </span>');

      
        // $('.nav-wrapper .sub-toggle').click(function() {
        //    $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        //    $(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
        // });

      //  $('body').on( "click",'.wpmm-mega-wrapper .sub-toggle', function(e) {
      //      e.preventDefault();                   
      //      alert(1);
      //    $(this).parent('.menu-item-has-children').children('ul.wpmm-sub-menu-wrap').first().slideToggle('1000');
      //    $(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
      // });
    

    $('.wpmega-closeblock').click(function() {
         $(this).parent().parent().parent().find('.wpmm-mega-wrapper').slideToggle('slow',function(){
         $(this).parent().parent().parent().find('.wpmm-mega-wrapper').addClass('hide-menu'); 
        });
         $(this).parent().parent().parent().find('.wpmega-openblock').show();  
         $(this).hide(); 
         $(this).closest('.wp-megamenu-main-wrapper').find('.wpmega-responsive-closebtn').hide();
      }); 

      $('.wpmega-openblock').click(function() {
        $(this).parent().parent().parent().find('.wpmm-mega-wrapper').slideToggle('slow',function(){
        $(this).parent().parent().parent().find('.wpmm-mega-wrapper').removeClass('hide-menu');  
        });
         $(this).parent().parent().parent().find('.wpmega-closeblock').show();
         $(this).closest('.wp-megamenu-main-wrapper').find('.wpmega-responsive-closebtn').show(); 
         $(this).hide(); 
      }); 

      //    $('.wpmega-openblock').click(function() {
      //   //       $(this).parent().parent().parent().find('.wpmm-mega-wrapper').slideToggle('slow',function(){
      //   // $(this).parent().parent().parent().find('.wpmm-mega-wrapper').removeClass('hide-menu');  
      //   // });
      //    $(this).parent().parent().parent().find('.wpmm-mega-wrapper').slideToggle('slow');
      //    $(this).parent().parent().parent().toggleClass('active');
      //    $(this).parent().parent().parent().find('.wpmega-closeblock').show();
      //    $(this).closest('.wp-megamenu-main-wrapper').find('.wpmega-responsive-closebtn').show(); 
      //    $(this).hide(); 
      // }); 

      
 
     if(enable_mobile == 1){
       $( window ).resize(function() {
        $('.wpmegamenu-toggle').each(function(){
                  var responsive_breakingpoint = $(this).attr('data-responsive-breakpoint');
                  responsive_breakingpoint = responsive_breakingpoint.replace('px', '');
                   if(responsive_breakingpoint == ''){
                    responsive_breakingpoint = "910";
                  }
         
    
                if($(window).width() <= responsive_breakingpoint){

                  if($(this).parent().hasClass('wpmm-orientation-vertical')){
                  if($(window).width() <= 768){
                      $(this).show();
                      $(this).find('.wpmega-openblock').show();
                      $(this).find('.wpmega-closeblock').hide();
                      $(this).parent().find('.wpmm-mega-wrapper').addClass('hide-menu');    
                      $(this).parent().find('.wpmega-responsive-closebtn').hide();
                  }else{
                      $(this).hide();
                      $(this).find('.wpmega-openblock').hide();
                      $(this).find('.wpmega-closeblock').hide();
                      $(this).parent().find('.wpmm-mega-wrapper').removeClass('hide-menu');    
                      $(this).parent().find('.wpmega-responsive-closebtn').hide();
                  }
                }else{
                      $(this).show();
                      $(this).find('.wpmega-openblock').show();
                      $(this).find('.wpmega-closeblock').hide();
                      $(this).parent().find('.wpmm-mega-wrapper').addClass('hide-menu');    
                      $(this).parent().find('.wpmega-responsive-closebtn').hide();
                }
            
                var wrapperid = $(this).parent().attr('id');
                if($('#'+wrapperid).hasClass('wpmm-onhover')){
                  $('#'+wrapperid).removeClass('wpmm-onhover');
                  $('#'+wrapperid).addClass('wpmm-onclick');
                }

            }else{
                 var wrapperid = $(this).parent().find('.wpmm-mega-wrapper').attr('id');
                 var wrapperidd = $(this).parent().attr('id');
                // if($('#'+wrapperid).attr('data-trigger-effect') == "wpmm-onhover"){
                //   $('#'+wrapperidd).addClass('wpmm-onhover');
                //   $('#'+wrapperidd).removeClass('wpmm-onclick');
                // }

             if($(window).width() <= 960){
                 if($('#'+wrapperidd).hasClass('wpmm-onhover')){
                  $('#'+wrapperidd).removeClass('wpmm-onhover');
                  $('#'+wrapperidd).addClass('wpmm-onclick');
                }


             }else{
                if($('#'+wrapperid).attr('data-trigger-effect') == "wpmm-onhover"){
                  $('#'+wrapperidd).addClass('wpmm-onhover');
                  $('#'+wrapperidd).removeClass('wpmm-onclick');
                }
              }

             $(this).hide();
             $(this).parent().find('.wpmm-mega-wrapper').removeClass('hide-menu');    
             $(this).parent().find('.wpmega-responsive-closebtn').hide(); 
             }

           });
      }).resize();
   
    

        $('.wpmega-responsive-closebtn').click(function(){

             $(this).closest('.wp-megamenu-main-wrapper').find('.wpmm-mega-wrapper').slideUp('slow');
             $(this).closest('.wp-megamenu-main-wrapper').find('.wpmega-closeblock').hide();
             $(this).closest('.wp-megamenu-main-wrapper').find('.wpmega-openblock').show();
             $(this).hide();
        });
       }else{
         $( window ).resize(function() {
          var responsive_bp = "910";
           if($(window).width() <= responsive_bp){
            $('.wp-megamenu-main-wrapper').css('display','none');
           }else{
            $('.wp-megamenu-main-wrapper').css('display','block');
           }
         }).resize();

       }


    $('.wpmm-orientation-vertical > .wpmm-mega-wrapper > li > .wpmm-sub-menu-wrap > .wpmm-sub-menu-wrapper').each(function(){
         var height1 = $(this).outerHeight();
         var height2 = $(this).prev().prev().outerHeight();
         var height3 = $(this).next().next().outerHeight();
         var height = parseInt(height1) + parseInt(height2) + parseInt(height3);
         $(this).parent('.wpmm-sub-menu-wrap').height(height);

         
    });

     $( window ).resize(function() {
       $('.wpmm-orientation-vertical').each(function(){
                var win_width = $(window).width();
                if(win_width < 1200){
                  var menu_width = $(this).width();
                  var total_width = parseInt(win_width) - parseInt(menu_width)- 70;
               
                  $(this).find('.wpmm-sub-menu-wrap').width(total_width);

                }
                
       });
            
      }).resize();
 



});