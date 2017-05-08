/**
 * WP Mega Menu jQuery Plugin
*/

jQuery(function ($) {
    "use strict";
     var AjaxUrl = apmm_variable.ajax_url;
     var admin_nonce = apmm_variable.ajax_nonce;
     var saved_success_message = apmm_variable.success_msg;
     var menu_lightbox = apmm_variable.menu_lightbox;
     var checked_disabled_error = apmm_variable.checked_disabled_error;
     var saving_data = apmm_variable.saving_msg;
     var plugin_javascript_path = apmm_variable.plugin_javascript_path;
     var depth_check = apmm_variable.depth_check_message;



    //WP Mega menu Settings submit button save data
    $(".ap-mega-menu-save").on('click', function(e) {
        e.preventDefault();
        // retrieve the widget settings form
          var wpmm_settings = JSON.stringify($( "[name^='apmegamenu_meta']" ).serializeArray());
          $.ajax({
                    url: AjaxUrl,
                    type: 'post',
                    data: {
                        action: "apmm_save_settings",
                        wp_menu_id: $('#menu').val(),
                        wp_megamenu_meta: wpmm_settings,
                        wp_nonce: admin_nonce
                    },
                    beforeSend: function() {
                         $(".nav-menu-theme-apmegamenus .apmm_loader").css('display', 'block');
                    },
                    complete: function() {
                         $(".nav-menu-theme-apmegamenus .apmm_loader").css('display', 'none');
                    },
                    success: function(res) {
                       $(".nav-menu-theme-apmegamenus .apmm_loader").css('display', 'none');
                       $(".nav-menu-theme-apmegamenus .apmm_success").html(saved_success_message);
                    }
                });

    });

  /* checked if wp mega menu is enabled or not and add body class */
   var wpmm_enabled_class = function() {
        if ( $('input.apmegamenu_enabled:checked') && $('input.apmegamenu_enabled:checked').length ) {
            $('body').addClass('wp_megamenu_enabled');
        } else {
            $('body').removeClass('wp_megamenu_enabled');
        }
    }

    $('input.apmegamenu_enabled').on('change', function() {
        wpmm_enabled_class();
    });

    wpmm_enabled_class();

  $('#apmegamenu_accordion').accordion({
        heightStyle: "content",
        collapsible: true,
        active: false,
        animate: 200
    });



    $('#menu-to-edit li.menu-item').each(function() {

        var menu_item = $(this);
        var menu_id = $('input#menu').val();
        var title = menu_item.find('.menu-item-title').text();
        // fix for Jupiter theme
        if ( ! title ) {
            title = menu_item.find('.item-title').text();
        }

        var id = parseInt(menu_item.attr('id').match(/[0-9]+/)[0], 10);
        var button = $("<span>").addClass("wpmm_launch")
                             .html(menu_lightbox)
                             .on('click', function(e) {
                                    e.preventDefault();
                             
                                 if ( ! $('body').hasClass('wp_megamenu_enabled') ) {
                                    alert(checked_disabled_error);
                                    return;
                                }
                                   
                                   var depth = menu_item.attr('class').match(/\menu-item-depth-(\d+)\b/)[1];
                              
                                     $.ajax({
                                        url: AjaxUrl,
                                        type: 'post',
                                        data: {
                                            action: "wpmm_show_lightbox_html",
                                            menu_item_id: id,
                                            menu_item_title: title,
                                            menu_item_depth : depth,
                                            menu_id: menu_id,
                                            wp_nonce: admin_nonce,
                                        },
                                        cache: false,

                                        beforeSend: function() {
                                                 $('.wpmm_menu_wrapper .wpmm_overlay').css('display','block');
                                                 $('.wpmm_menu_wrapper .close_btn').css('display','block');
                                            },
                                            complete: function() {
                                                $('.wpmm_overlay').css('display','block');
                                                $('#wpmm_menu_settings_frame').css('display','block');
                                                $('.wpmm_menu_wrapper .close_btn').css('display','block');
                                            },
                                        success: function(res) {
                                            
                                           $('.wpmm_menu_wrapper .wpmm_main_content').html(res);

                                    var depth_class = $('#wpmm_menu_'+id).attr('data-depth');

                                    // tinymce.init( tinyMCEPreInit.mceInit.content); 
                                    // tinymce.execCommand( 'mceRemoveEditor', false, 'wpmm_html_content' );
                                    // tinyMCE.execCommand('mceAddEditor', false, 'wpmm_html_content'); 
                                    // quicktags({id : 'wpmm_html_content'});
                                                        

                                     if(depth_class == "depth_0"){
                                     
                                          var editor =  CKEDITOR.replace( 'wpmm_html_content',{
                                                uiColor: '#dfdfdf',
                                                stylesSet: 'my_custom_style',
                                                allowedContent: true,
                                                width: '600px',
                                                height: '200px',
                                                filebrowserBrowseUrl : plugin_javascript_path+'/ckfinder/ckfinder.html',
                                                filebrowserImageBrowseUrl : plugin_javascript_path+'/ckfinder/ckfinder.html?type=Images',
                                                filebrowserFlashBrowseUrl : plugin_javascript_path+'/ckfinder/ckfinder.html?type=Flash',
                                                filebrowserUploadUrl : plugin_javascript_path+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                                filebrowserImageUploadUrl : plugin_javascript_path+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                                filebrowserFlashUploadUrl : plugin_javascript_path+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                                                filebrowserWindowWidth : '1000',
                                                filebrowserWindowHeight : '700'
                                            });


                                          var changesCount = 0;
                                          var changesCount2 = 0;
                                           editor.on( 'change', function ( ev ) {
                                                 changesCount++;
                                                 // document.getElementById( 'content2' ).style.display = '';
                                                 document.getElementById( 'changes' ).innerHTML = changesCount.toString();
                                                 document.getElementById( 'tophtmlcontent' ).innerHTML = editor.getData();
                                            } );

                                             var beditor =  CKEDITOR.replace( 'wpmm_html_content2',{
                                                                        uiColor: '#dfdfdf',
                                                                        stylesSet: 'my_custom_style',
                                                                        allowedContent: true,
                                                                        width: '600px',
                                                                        height: '200px',
                                                                        filebrowserBrowseUrl : plugin_javascript_path+'/ckfinder/ckfinder.html',
                                                                        filebrowserImageBrowseUrl : plugin_javascript_path+'/ckfinder/ckfinder.html?type=Images',
                                                                        filebrowserFlashBrowseUrl : plugin_javascript_path+'/ckfinder/ckfinder.html?type=Flash',
                                                                        filebrowserUploadUrl : plugin_javascript_path+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                                                        filebrowserImageUploadUrl : plugin_javascript_path+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                                                        filebrowserFlashUploadUrl : plugin_javascript_path+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                                                                        filebrowserWindowWidth : '1000',
                                                                        filebrowserWindowHeight : '700'
                                                                    });

                                         beditor.on( 'change', function ( ev ) {
                                                 changesCount2++;
                                                 document.getElementById( 'changes2' ).innerHTML = changesCount2.toString();
                                                 document.getElementById( 'bottomhtmlcontent' ).innerHTML = beditor.getData();
                                            } );
                                     }


                                      if(depth_class != "depth_0"){
                                            $(".wpmm_menu_align").prop('disabled', 'disabled');
                                            $('.depth_check').html(depth_check);
                                       }


                                             /* tabs menu */
                                              $( '#wpmm_menu_'+id+' .wpmm_tabs' ).on('click', function() {
                                              $('#wpmm_menu_'+id+' .wpmm_tabs').removeClass('active');
                                             var tab_id = $(this).attr('id');

                                             if(tab_id == "wp_mega_menu"){
                                                   $('.main_submit_section').hide();
                                             }else{
                                                   $('.main_submit_section').show();
                                                 }
                                             $(this).addClass('active');
                                             $('#wpmm_menu_'+id+' .tab-pane').css('display','none');
                                             $('#wpmm_menu_'+id+' .wpmm_content_rtsection #tab_'+tab_id).css('display','block');
                                            });

                                             $('#wpmm_menu_'+id+' .wpmm_tabs').each(function() {
                                              if($( this).hasClass( "active" )){
                                                var tabid = $(this).attr('id');
                                                 if(tabid == "wp_mega_menu"){
                                                  $('.main_submit_section').hide();
                                                 }else{
                                                   $('.main_submit_section').show();
                                                 }
                                                $('#wpmm_menu_'+id+' .tab-pane').css('display','none');
                                                $('#wpmm_menu_'+id+' .wpmm_content_rtsection #tab_'+tabid).css('display','block');
                                              } 

                                            });
                                            /* tabs menu closed*/
                                            
                                            /*search form */
                                            $('#wpmm_menu_'+id+' #wpmm_choose_menu_type').on('change',function(){
                                                var change_value = $(this).val();
                                                if(change_value == "search_type"){
                                                    $('#wpmm_menu_'+id+' .toggle_search_form').slideDown('slow');
                                                }else{
                                                    $('#wpmm_menu_'+id+' .toggle_search_form').slideUp('slow');
                                                }
                                            });

                                            var changeval =  $('#wpmm_menu_'+id+' #wpmm_choose_menu_type option:selected').val();
                                              if(changeval == "search_type"){
                                                     $('#wpmm_menu_'+id+' .toggle_search_form').show();
                                                }else{
                                                    $('#wpmm_menu_'+id+' .toggle_search_form').hide();
                                                } 

                                            /* top content */
                                            $('#wpmm_menu_'+id+' #wpmm_choose_topcontent_type').on('change',function(){
                                                var change_value = $(this).val();
                                                if(change_value == "text_only"){
                                                    $('#wpmm_menu_'+id+' .toggle_toptext').show();
                                                    $('#wpmm_menu_'+id+' .toggle_topimage').hide();
                                                     $('#wpmm_menu_'+id+' .toggle_html').hide();
                                                }else if(change_value == "image_only"){
                                                    $('#wpmm_menu_'+id+' .toggle_toptext').hide();
                                                    $('#wpmm_menu_'+id+' .toggle_topimage').show();
                                                     $('#wpmm_menu_'+id+' .toggle_html').hide();
                                                }else{
                                                     $('#wpmm_menu_'+id+' .toggle_toptext').hide();
                                                    $('#wpmm_menu_'+id+' .toggle_topimage').hide();
                                                     $('#wpmm_menu_'+id+' .toggle_html').show();
                                                }
                                            });

                                            var changeval =  $('#wpmm_menu_'+id+' #wpmm_choose_topcontent_type option:selected').val();
                                             if(changeval == "text_only"){
                                                    $('#wpmm_menu_'+id+' .toggle_toptext').show();
                                                    $('#wpmm_menu_'+id+' .toggle_topimage').hide();
                                                     $('#wpmm_menu_'+id+' .toggle_html').hide();
                                                }else if(changeval == "image_only"){
                                                    $('#wpmm_menu_'+id+' .toggle_toptext').hide();
                                                    $('#wpmm_menu_'+id+' .toggle_topimage').show();
                                                     $('#wpmm_menu_'+id+' .toggle_html').hide();
                                                }else{
                                                     $('#wpmm_menu_'+id+' .toggle_toptext').hide();
                                                    $('#wpmm_menu_'+id+' .toggle_topimage').hide();
                                                     $('#wpmm_menu_'+id+' .toggle_html').show();
                                                }

                                            
                                              $('.wpmm_image_url_button').on('click', function(e){
                                                     e.preventDefault();
                                                     var btnClicked = $( this );
                                                     var btnClickedid = $(this).attr('id');
                                                     var image = wp.media({ 
                                                     title: 'Insert Top Content Image',
                                                     button: {text: 'Insert Top Content Image'},
                                                     library: { type: 'image'},
                                                     multiple: false
                                                     }).open()
                                                   .on('select', function(e){
                                                     var uploaded_image = image.state().get('selection').first();
                                                     console.log(uploaded_image);
                                                     var image_url = uploaded_image.toJSON().url;

                                                     $( btnClicked ).closest('#wpmm_menu_'+id+' tr#'+btnClickedid).find( '.wpmm-top-image' ).attr('src',image_url);
                                                     $( btnClicked ).closest('#wpmm_menu_'+id+' tr#'+btnClickedid).find( '.wpmm-image-url' ).val(image_url);
                                                     if( $( btnClicked ).closest('#wpmm_menu_'+id+' tr#'+btnClickedid).find( '.wpmm-image-url' ).val(image_url)!=''){
                                                       $('#wpmm_menu_'+id+' tr#'+btnClickedid+' .wpmm-image-preview').show(); 
                                                       $('#wpmm_menu_'+id+' tr#'+btnClickedid+' .wpmm-image-preview .remove_top_image').show(); 
                                                     }
                                                     else{
                                                       $('#wpmm_menu_'+id+' tr#'+btnClickedid+' .wpmm-image-preview').hide(); 
                                                       $('#wpmm_menu_'+id+' tr#'+btnClickedid+' .wpmm-image-preview .remove_top_image').hide(); 
                                                     }  


                                                     });
                                                   });
                                            
                                                $('#wpmm_menu_'+id+' .wpmm-image-url').each(function(){
                                                   
                                                     if($(this).val() == ''){
                                                      //  alert($(this).parent().find('.wpmm-image-preview').attr('class'));
                                                        $(this).parent().find('.wpmm-image-preview').hide();
                                                      }else{
                                                        $(this).parent().find('.wpmm-image-preview').show();
                                                      }

                                                });


               


                                        

                                          /* bottom content */
                                            $('#wpmm_menu_'+id+' #wpmm_choose_bottomcontent_type').on('change',function(){
                                                var change_value = $(this).val();
                                                if(change_value == "text_only"){
                                                    $('#wpmm_menu_'+id+' .toggle_bottomtext').show();
                                                    $('#wpmm_menu_'+id+' .toggle_bimage').hide();
                                                     $('#wpmm_menu_'+id+' .toggle_bhtml').hide();
                                                }else if(change_value == "image_only"){
                                                    $('#wpmm_menu_'+id+' .toggle_bottomtext').hide();
                                                    $('#wpmm_menu_'+id+' .toggle_bimage').show();
                                                     $('#wpmm_menu_'+id+' .toggle_bhtml').hide();
                                                }else{
                                                     $('#wpmm_menu_'+id+' .toggle_bottomtext').hide();
                                                    $('#wpmm_menu_'+id+' .toggle_bimage').hide();
                                                     $('#wpmm_menu_'+id+' .toggle_bhtml').show();
                                                }
                                            });

                                            var changeval =  $('#wpmm_menu_'+id+' #wpmm_choose_bottomcontent_type option:selected').val();
                                             if(changeval == "text_only"){
                                                    $('#wpmm_menu_'+id+' .toggle_bottomtext').show();
                                                    $('#wpmm_menu_'+id+' .toggle_bimage').hide();
                                                     $('#wpmm_menu_'+id+' .toggle_bhtml').hide();
                                                }else if(changeval == "image_only"){
                                                    $('#wpmm_menu_'+id+' .toggle_bottomtext').hide();
                                                    $('#wpmm_menu_'+id+' .toggle_bimage').show();
                                                     $('#wpmm_menu_'+id+' .toggle_bhtml').hide();
                                                }else{
                                                     $('#wpmm_menu_'+id+' .toggle_bottomtext').hide();
                                                    $('#wpmm_menu_'+id+' .toggle_bimage').hide();
                                                     $('#wpmm_menu_'+id+' .toggle_bhtml').show();
                                                }

                                                  $('.wpmm_image_url_bottom').on('click', function(e){
                                                     e.preventDefault();
                                                     var btnClicked = $( this );
                                                     var btnClickedid = $(this).attr('id');
                                                    
                                                     var image = wp.media({ 
                                                     title: 'Insert Bottom Content Image',
                                                     button: {text: 'Insert Bottom Content Image'},
                                                     library: { type: 'image'},
                                                     multiple: false
                                                     }).open()
                                                   .on('select', function(e){
                                                     var uploaded_image = image.state().get('selection').first();
                                                     //console.log(uploaded_image);
                                                     var image_url = uploaded_image.toJSON().url;

                                                     $( btnClicked ).closest('#wpmm_menu_'+id+' tr#'+btnClickedid).find( '.wpmm-bottom-image' ).attr('src',image_url);
                                                     $( btnClicked ).closest('#wpmm_menu_'+id+' tr#'+btnClickedid).find( '.wpmm-bimage-url' ).val(image_url);
                                                     if( $( btnClicked ).closest('#wpmm_menu_'+id+' tr#'+btnClickedid).find( '.wpmm-bimage-url' ).val(image_url)!=''){
                                                       $('#wpmm_menu_'+id+' tr#'+btnClickedid+' .wpmm-bimage-preview').show(); 
                                                     }
                                                     else{
                                                       $('#wpmm_menu_'+id+' tr#'+btnClickedid+' .wpmm-bimage-preview').hide(); 
                                                     }  


                                                     });
                                                   });

                                            $('#wpmm_menu_'+id+' .wpmm-bimage-url').each(function(){
                                                   // alert($(this).val());
                                                   
                                                     if($(this).val() == ''){
                                                      //  alert($(this).parent().find('.wpmm-image-preview').attr('class'));
                                                        $(this).parent().find('.wpmm-bimage-preview').hide();
                                                      }else{
                                                        $(this).parent().find('.wpmm-bimage-preview').show();
                                                      }

                                                });
                       


                                     
                                      $("#wpmm_menu_"+id+" .remove_top_image").each(function() {
                                         $(this).on('click',function(e){
                                            e.preventDefault();
                                            $(this).parent().find('img').attr('src','');
                                            $(this).parent().parent().find('.wpmm-image-url').val('');
                                            $(this).css('display','none');

                                         });
                                       });

                                         $("#wpmm_menu_"+id+" .remove_bottom_image").each(function() {
                                         $(this).on('click',function(e){
                                            e.preventDefault();
                                            $(this).parent().find('img').attr('src','');
                                            $(this).parent().parent().find('.wpmm-bimage-url').val('');
                                            $(this).css('display','none');

                                         });
                                       });



                                            megamenu_preview_position(id);
                                           
                                             /* 
                                             * Save On click button :id means menu_item_id
                                             */
                                             $('#wpmm_menu_'+id+' form').on("submit", function (e) {
                                               e.preventDefault();
                                                $('#wpmm_menu_'+id).find('.save_ajax_data').show();
                                               $('#wpmm_menu_'+id).find('.saving_message').text(saving_data);
                                              var data = $(this).serialize();
                                              
                                              var content = $( 'textarea#wpmm_html_content2' ).val();
                                              var content2 = $( 'textarea#wpmm_html_content1' ).val();
                                             
                                             // data = data + '&html_content='+content+'&html_content1='+content2;
                                               // console.log(data);
                                               // return false;
                                              $.post(AjaxUrl, data, function (submit_response) {
                                              $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow');
                                               });
                                            });
                                           


                                             /* icon picker */
                                           $('#wpmm_menu_'+id+' .icon-preview').on('click',function(){
                                            $(this).next('.icon-main').show().slideDown('slow');   
                                           });

                                              $('#wpmm_menu_'+id+' .select-icon').on('change',function(){
                                                var idd = $(this).attr('id');
                                                if($(this).val()==1){
                                                    $('.font-awesome-icon').show();
                                                    $('.genericon-icon').hide();
                                                    $('.dash-icon').hide();
                                                }else if($(this).val()==2){
                                                    $('.font-awesome-icon').hide();
                                                    $('.genericon-icon').show();
                                                    $('.dash-icon').hide();
                                                }else if($(this).val()==3){
                                                    $('.font-awesome-icon').hide();
                                                    $('.genericon-icon').hide();
                                                    $('.dash-icon').show();
                                                }
                                                $('.icon').show();
                                                $('.search_icons').val('');
                                            });

                                                $('#wpmm_menu_'+id+' .icon').click(function(){
                                                    var class_name =$(this).children().attr('class');
                                                    $('.icon-preview i').attr({'class':class_name});
                                                    $('#wpmm_menu_'+id+' #icon_picker_icon1').val(class_name);
                                                    $('.icon-main').slideToggle('fast');
                                                    $('.search_icons').val('');

                                                });

                                              $('#wpmm_menu_'+id+' .search_icons').keyup(function() {
                                                   var defaultText = $(this).val();
                                                   var idd = $(this).attr('id');
                                                   if(defaultText == ''){
                                                     if(idd == "search_faicons"){
                                                      $('.font-awesome-icon .icon').show();
                                                   }else if(idd== "search_gicons"){
                                                      $('.genericon-icon .icon').show();
                                                   }else{
                                                      $('.dash-icon .icon').show();
                                                   }

                                                   }else{
                                                   if(idd == "search_faicons"){
                                                    $('.font-awesome-icon .icon').hide();
                                                    $('.font-awesome-icon #icon-'+defaultText).show();
                                                   }else if(idd== "search_gicons"){
                                                    $('.genericon-icon .icon').hide();
                                                    $('.genericon-icon #icon-'+defaultText).show();
                                                   }else{
                                                    $('.dash-icon .icon').hide();
                                                    $('.dash-icon #icon-'+defaultText).show();
                                                   }
                                                  }
                                                
                                                });

                                          $(document).mouseup(function (e)
                                            {
                                                var container = $(".icon-main");

                                                if (!container.is(e.target) 
                                                    && container.has(e.target).length === 0)
                                                    {
                                                        container.slideUp('fast');
                                                        $('.search_icons').val('');
                                                        $('.icon').show();
                                                    }
                                            });

                                           /*icon picker end */
                                        

                                             /* 
                                             * Check Menu type If Megamenu or FLyout And Save Automatic
                                             */
                                            var menu_type = $('#wpmm_menu_'+id).find('#wpmm_enable_mega_menu');

                                              menu_type.on('change', function() {
                                                

                                                if ( $(this).val() == 'megamenu' ) {
                                                    $("#wpmm_widgets_setup").removeClass('disabled').addClass('enabled_megamenu');
                                                    $(".wpmm_add_components").removeClass('disabled');
                                                } else {
                                                    $("#wpmm_widgets_setup").addClass('disabled').removeClass('enabled_megamenu');
                                                    $(".wpmm_add_components").addClass('disabled');
                                                }

                                                $('#wpmm_menu_'+id).find('.save_ajax_data').show(); 
                                                $('#wpmm_menu_'+id).find('.saving_message').text(saving_data);

                                                var menu_type_data = {
                                                    action: "wpmm_save_menuitem_settings",
                                                    wpmm_settings: { menu_type: $(this).val(), panel_columns: $('#wpmm_menu_'+id+' #wpmm_number_of_columns option:selected').val() },
                                                    wpmm_menu_item_id: id,
                                                    _wpnonce: admin_nonce
                                                };
                                                $.post(AjaxUrl, menu_type_data, function (new_response) {
                                                     $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow');  
                                                });

                                            });


                                        /* change on column value */
                                        var get_total_no_of_columns = $('#wpmm_menu_'+id).find('select#wpmm_number_of_columns');

                                            get_total_no_of_columns.on('change', function() {

                                                $('.wpmm_add_components').find("#wpmm_widgets_setup").attr('data-columns', $(this).val());
                                                $('#wpmm_menu_'+id).find(".wpmm_widget-total-cols").html($(this).val());
                                                $('#wpmm_menu_'+id).find('.save_ajax_data').show(); 
                                                $('#wpmm_menu_'+id).find('.saving_message').text(saving_data);
                                                var menutype = $('#wpmm_menu_'+id+' #wpmm_enable_mega_menu option:selected').val();
                                                var post_data = {
                                                    action: "wpmm_save_menuitem_settings",
                                                    wpmm_settings: { panel_columns: $(this).val(), menu_type: menutype },
                                                    wpmm_menu_item_id: id,
                                                    _wpnonce: admin_nonce
                                                };

                                                $.post(AjaxUrl, post_data, function (response) {
                                                  //  alert(response);
                                                  $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow');

                                            
                                                });

                                            });

                                      add_widget_on_click(id);

                               var widget_area = $('#wpmm_menu_'+id).find('#wpmm_widgets_setup');

                                widget_area.bind("wpmm_sortupdate_widgets", function () {

                                  $('#wpmm_menu_'+id).find('.save_ajax_data').show(); 
                                  $('#wpmm_menu_'+id).find('.saving_message').text(saving_data);
                                    var items = [];
                                 
                                    $(".wpmm_widget_area").each(function() {
                                        items.push({
                                            'type'  : $(this).attr('data-type'),
                                            'order' : $(this).index() + 1,
                                            'id'    : $(this).attr('data-id'),
                                            'parent_menu_item_id' :id
                                        });
                                    });

                                    $.post(AjaxUrl, {
                                        action: "wpmm_reorder_widget_items",
                                        items: items,
                                        _wpnonce: admin_nonce
                                    }, function (wpmm_move_response) {
                                        $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow'); 
                                        // panel.log(move_response);
                                    });
                            });

                               widget_area.sortable({
                                    forcePlaceholderSize: true,
                                    // containment: "parent",
                                    items : '.wpmm_widget_area:not(.sub_menu)',
                                    cursor: "move",
                                    placeholder: "drop-area",
                                start: function (event, ui) {
                                    $(".wpmm_widget_area").removeClass("wpmm_open");
                                    ui.item.data('start_position', ui.item.index());
                                },
                                stop: function (event, ui) {
                                    // clean up
                                    ui.item.removeAttr('style');

                                    var start_position = ui.item.data('start_position');

                                    if (start_position !== ui.item.index()) {
                                        widget_area.trigger("wpmm_sortupdate_widgets");

                                    }
                                }
                       });

         
      /*
      * ADD widgets on maindiv widgets structure
      */
        $('#wpmm_menu_'+id+' .wpmm_all_wp_widgets').each(function() {
                $(this).on('click', function() { 
                    var id_bases =$(this).attr('data-value');
                    var widget_title =$(this).attr('data-text');
                    $('#wpmm_menu_'+id).find('.saving_message').text(saving_data);
                                       
                                var widgets_postdata = {
                                        action: "wpmm_add_selected_widget",
                                        id_base: id_bases,
                                        menu_item_id: id, //menu_item_id
                                        title: widget_title,
                                        _wpnonce: admin_nonce,
                                        // dataType: 'html'
                                    };

                                    $.post(AjaxUrl, widgets_postdata, function (response) {
                                         var widget = $(response.data); //display widgets by json
                                    
                                        var number_of_columns = $('#wpmm_menu_'+id).find('#wpmm_number_of_columns option:selected').val();

                                        widget.find("span.wpmm_widget-total-cols").html(number_of_columns);
                                        
                                        wpmm_add_events_to_widget(widget,id);

                                        $('#wpmm_menu_'+id+' #wpmm_widgets_setup').find('span.message').hide();
                                       
                                        $('#wpmm_menu_'+id+' #wpmm_widgets_setup').append(widget);

                                         widget_area.trigger("wpmm_sortupdate_widgets");
                                        
                                        $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow');

                                    });
                               });

                        }); 
                     

                       $('.wpmm_widget_area', widget_area).each(function() {
                           wpmm_add_events_to_widget($(this),id);
                         });

                       

                        }
                    });
                });

        $('.item-title', menu_item).append(button);
    });  // menu item each end
 
  /* preview positon of mega menu */
    function megamenu_preview_position(id){
         $('#wpmm_menu_'+id+' select.wpmm_position').on('change',function(){
            $('#wpmm_menu_'+id+' .show_megamenu_position_type').show('slow'); 
            var previewid = $(this).val();
            $('#wpmm_menu_'+id+' .wpmm_preview_position').css('display','none');
            $('#wpmm_menu_'+id+' .wpmm_preview_position#preview_'+previewid).show();
         });

        var positionid = $('#wpmm_menu_'+id+' select.wpmm_position').val();
        $('#wpmm_menu_'+id+' .show_megamenu_position_type').show('slow');
        $('#wpmm_menu_'+id+' .wpmm_preview_position').css('display','none');
        $('#wpmm_menu_'+id+' .wpmm_preview_position#preview_'+positionid).show();


        //megamenu vertical preview
          $('#wpmm_menu_'+id+' select.wpmm_vposition').on('change',function(){
                $('#wpmm_menu_'+id+' .show_megamenu_vposition_type').show('slow');
                var previewid2 = $(this).val();
                $('#wpmm_menu_'+id+' .wpmm_preview_vposition').css('display','none');
                $('#wpmm_menu_'+id+' .wpmm_preview_vposition#preview_'+previewid2).show();
             });

        var positionid2 = $('#wpmm_menu_'+id+' select.wpmm_vposition').val();
        $('#wpmm_menu_'+id+' .show_megamenu_vposition_type').show('slow');
        $('#wpmm_menu_'+id+' .wpmm_preview_vposition').css('display','none');
        $('#wpmm_menu_'+id+' .wpmm_preview_vposition#preview_'+positionid2).show();

         //flyout horizontal preview
          $('#wpmm_menu_'+id+' select.wpmm_flyposition').on('change',function(){
                $('#wpmm_menu_'+id+' .show_flyposition_type').show('slow');
                var previewid3 = $(this).val();
                $('#wpmm_menu_'+id+' .wpmm_preview_flyposition').css('display','none');
                $('#wpmm_menu_'+id+' .wpmm_preview_flyposition#preview2_'+previewid3).show();
             });

            var positionid3 = $('#wpmm_menu_'+id+' select.wpmm_flyposition').val();
            $('#wpmm_menu_'+id+' .show_flyposition_type').show('slow');
            $('#wpmm_menu_'+id+' .wpmm_preview_flyposition').css('display','none');
            $('#wpmm_menu_'+id+' .wpmm_preview_flyposition#preview2_'+positionid3).show();

           //flyout vertical preview
              $('#wpmm_menu_'+id+' select.wpmm_flyoutvposition').on('change',function(){
              $('#wpmm_menu_'+id+' .show_megamenu_flyvposition_type').show('slow');
              var previewid4 = $(this).val();
              $('#wpmm_menu_'+id+' .wpmm_preview_flyvposition').css('display','none');
              $('#wpmm_menu_'+id+' .wpmm_preview_flyvposition#preview3_'+previewid4).show();
         });

    var positionid4 = $('#wpmm_menu_'+id+' select.wpmm_flyoutvposition').val();
    $('#wpmm_menu_'+id+' .show_megamenu_flyvposition_type').show('slow');
    $('#wpmm_menu_'+id+' .wpmm_preview_flyvposition').css('display','none');
    $('#wpmm_menu_'+id+' .wpmm_preview_flyvposition#preview3_'+positionid4).show();

         /* icon settings start*/
         $('#wpmm_menu_'+id+' a.wpmm_iconpicker').on('click',function(){
             if($("#wpmm_menu_"+id+ " .show_available_icons").is(':visible'))
            {
             $(this).parent().find('.show_available_icons').animate({ width: 'hide' });
            }
            else
            {
             $(this).parent().find('.show_available_icons').animate({ width: 'show' });
            }
          
          });

           $('#wpmm_menu_'+id+' .show_available_icons a').click(function (e) {
                e.preventDefault();
                $('#wpmm_menu_'+id+' .show_available_icons a').removeClass('active_icons');
                $(this).addClass('active_icons');
                var attr_class = $(this).find('i').attr('class').replace('fa-3x', '');
                $('#wpmm_menu_'+id+' .wpmm_show_choosed_icons').css('display','block');
                var append_html = '<i class="' + attr_class + '"></i>';
                $('#wpmm_menu_'+id+' .wpmm_show_choosed_icons').html(append_html);
                $('#wpmm_menu_'+id+' input#selected_font_icon').val(attr_class);

                
                
            });
         /* icon settings end */
         /* upload sub menu image */
            $('#wpmm_menu_'+id+' select.wpmm_textposition').on('change',function(){
                    $('#wpmm_menu_'+id+' .show_text_position').show('slow');
                    var textposition = $(this).val();
                    $('#wpmm_menu_'+id+' .wpmm_preview_textposition').css('display','none');
                    $('#wpmm_menu_'+id+' .wpmm_preview_textposition#preview_'+textposition).show();
          });

    var txt_position = $('#wpmm_menu_'+id+' select.wpmm_textposition').val();
    $('#wpmm_menu_'+id+' .show_text_position').show('slow');
    $('#wpmm_menu_'+id+' .wpmm_preview_textposition').css('display','none');
    $('#wpmm_menu_'+id+' .wpmm_preview_textposition#preview_'+txt_position).show();  


    }
 
function add_widget_on_click (id) {
      $('#wpmm_menu_'+id+' .wpmm-add-widget-tool').on('click', function() {
      $(this).parent().find('.wpmm_widget_iframe').show();
      });

      $('#wpmm_menu_'+id+' .btn_close_me > span').on('click', function() {
         $(this).parent().parent().parent().parent().parent().find('.wpmm_widget_iframe').hide('slow');
      });

        $( '#wpmm_menu_'+id+' .wpmm_tabss' ).on('click', function() {
              $('.wpmm_tabss').removeClass('active');
             var tab_id = $(this).attr('id');
             $(this).addClass('active');
             $('#wpmm_menu_'+id+' .tab-panes').css('display','none');
             $('#wpmm_menu_'+id+' .widget_right_section #tabs_'+tab_id).css('display','block');
       });
       $('#wpmm_menu_'+id+' .wpmm_tabss').each(function() {
              if($( this).hasClass( "active" )){
                var tabid = $(this).attr('id');
                $('#wpmm_menu_'+id+' .tab-panes').css('display','none');
                $('#wpmm_menu_'+id+' .widget_right_section #tabs_'+tabid).css('display','block');
              }

            });


    } 


        var wpmm_add_events_to_widget = function (widget,id) {
           
            var widget_title = widget.find(".widget_title span.wptitle");
            var wpmm_expand = widget.find(".wpmm_widget-expand");
            var wpmm_contract = widget.find(".wpmm_widget-contract");
            var wpmm_edit = widget.find(".wpmm_widget-action");
            var wpmm_widget_inner = widget.find(".wpmm_widget_inner");
            var widget_id = widget.attr("data-id");
            var type = widget.attr('data-type');


            wpmm_expand.on("click", function () {

                var cols = parseInt(widget.attr("data-columns"), 10);  // current colums of widget
                var maxcols = parseInt($("#wpmm_number_of_columns option:selected").val(), 10); //total columns


                if (cols < maxcols) {
                    cols = cols + 1;

                    widget.attr("data-columns", cols);

                    $('.wpmm_widget-num-cols', widget).html(cols);

                         $('#wpmm_menu_'+id).find('.save_ajax_data').show();
                         $('#wpmm_menu_'+id).find('.saving_message').text(saving_data);

                    if (type == 'wp_widget') {
                        $.post(AjaxUrl, {
                            action: "wpmm_selected_update_widget",
                            widget_unique_id: widget_id,
                            columns: cols,
                            _wpnonce: admin_nonce
                        }, function (expandresponse) {
                            $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow');
                        });

                    }

                    if (type == 'wpmm_menu_subitem' ) {
                        $.post(AjaxUrl, {
                            action: "wpmm_update_menu_item_columns",
                            sub_menu_id: widget_id,
                            columns: cols,
                            _wpnonce: admin_nonce
                        }, function (contract_response) {
                           $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow');

                        });

                    }

                }

            });

             wpmm_contract.on('click',function(){
                  var cols = parseInt(widget.attr("data-columns"), 10);

                // account for widgets that have say 8 columns but the panel is only 6 wide
                var maxcols = parseInt($("#wpmm_number_of_columns option:selected").val(), 10);

                if (cols > maxcols) {
                    cols = maxcols;
                }

                if (cols > 1) {
                    cols = cols - 1;
                    widget.attr("data-columns", cols);

                    $('.wpmm_widget-num-cols', widget).html(cols);
                } else {
                    return;
                }

             $('#wpmm_menu_'+id).find('.save_ajax_data').show();
             $('#wpmm_menu_'+id).find('.saving_message').text(saving_data);

                if (type == 'wp_widget') {

                    $.post(ajaxurl, {
                        action: "wpmm_selected_update_widget",
                        widget_unique_id: widget_id,
                        columns: cols,
                        _wpnonce: admin_nonce
                    }, function (contract_response) {
                     if(contract_response){
                         $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow');
                     }
                       
                    });

                }

                if (type == 'wpmm_menu_subitem') {

                    $.post(AjaxUrl, {
                        action: "wpmm_update_menu_item_columns",
                        sub_menu_id: widget_id,
                        columns: cols,
                        _wpnonce: admin_nonce
                    }, function (cresponse) {
                         $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow');
                    });

                }

             });

              wpmm_edit.on('click',function(){
          
                    if (! widget.hasClass("wpmm_open") && ! widget.data("wpmm_loaded")) {
                    widget_title.addClass('wpmm_loading');
                    // widget.addClass('wpmm_open');

                    // retrieve the widget settings form
                    $.post(AjaxUrl, {
                        action: "wpmm_edit_widget_data",
                        widget_id_base: widget_id,
                        _wpnonce: admin_nonce,
                        dataType : 'html'
                    }, function (response) {

                        var $response = $(response);
                        var $form = $response.find('form');

                        // bind delete button action
                        $(".wpmm_delete", $form).on("click", function (e) {
                            e.preventDefault();
                            
                            var data = {
                                action: "wpmm_delete_widget",
                                widget_id_base: widget_id,
                                _wpnonce: admin_nonce
                            };

                            $.post(AjaxUrl, data, function (delete_response) {
                                widget.remove();
                              
                            });

                        });

                        // bind close button action
                        $(".wpmm_close", $form).on("click", function (e) {
                            e.preventDefault();
                            widget.toggleClass("wpmm_open");
                        });

                        // bind save button action
                        $form.on("submit", function (e) {
                            e.preventDefault();

                            var dataa = $(this).serialize();
                            // alert(dataa);

                             $('#wpmm_menu_'+id).find('.save_ajax_data').show();
                             $('#wpmm_menu_'+id).find('.saving_message').text(saving_data);

                            $.post(AjaxUrl, dataa, function (submit_response) {
                                $('#wpmm_menu_'+id).find('.save_ajax_data').fadeOut('slow');
                               
                            });

                        });

                        wpmm_widget_inner.html($response);

                        widget.data("wpmm_loaded", true).toggleClass("wpmm_open");

                        widget_title.removeClass('wpmm_loading');


                        // Init Black Studio TinyMCE
                        // console.log(widget);
                        // if ( widget.is( '[id*=black-studio-tinymce]' ) ) {
                        //     bstw( widget ).deactivate().activate();
                        // }

                    });

                } else {
                 
                    widget.toggleClass("wpmm_open");
                }

                // close all other widgets
                $(".wpmm_widget_area").not(widget).removeClass("wpmm_open");
                    
              }); 
                 return widget;
        };



        $('.wpmm_menu_wrapper .wpmm_overlay').click(function(){
             $(this).css('display','none');
         $('#wpmm_menu_settings_frame').css('display','none');
         $('.wpmm_menu_wrapper .close_btn').css('display','none');

        });
        $('.wpmm_menu_wrapper .close_btn').click(function(){
             $(this).css('display','none');
         $('#wpmm_menu_settings_frame').css('display','none');
         $('.wpmm_menu_wrapper .wpmm_overlay').css('display','none');
        });


});