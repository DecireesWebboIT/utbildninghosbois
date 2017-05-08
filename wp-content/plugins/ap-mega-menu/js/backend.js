/*global console,ajaxurl,$,jQuery*/

/**
 * AP Mega Menu jQuery Plugin
 */

jQuery(function ($) {
    "use strict";

    $('.wpmm-selection').selectbox(); 

    $(document).on("click", function () {
     $('.menulistsicons_open').removeClass('list_open').addClass('list_close');
     $('.menulistsicons_close').removeClass('list_open').addClass('list_close');
    });

    $('.toggle_menu_icons').click(function(event){
       event.stopPropagation();
        var id = $(this).attr('id');
        // $('.menulistsicons_'+id).slideToggle();
        if($('.menulistsicons_'+id).hasClass('list_open')){
           $('.menulistsicons_'+id).addClass('list_close').removeClass('list_open');
        }else{
            $('.menulistsicons_'+id).addClass('list_open').removeClass('list_close');
        }
       
        $('.menulistsicons_'+id+' li.wpmm-menuicon').each(function(){
          $(this).click(function(event){
            event.stopPropagation();
            var iconclass = $(this).find('i').attr('class');
            var html = "<i class='"+iconclass+"'></i>";
              $('#'+id).find('span').html(html);
              $('#'+id+'_menu_icon').val(iconclass);
          });
        });
    });

   

   /* create theme toggle */
   $(".apmm-slideToggle").click(function () {
    var idd = $(this).attr('id');
      $('.apmm-slideTogglebox_'+idd).slideToggle();
    });

  /* arrow type preview */
   $('.apmm_theme_arrow').on('change', function() {
      var arrow_type = $(this).val();
      $('.arrow_type').hide();
      $('.arrow_section').show();
      $('#arrow_'+arrow_type).show();
    });

   var selected_arrowtype = $('.apmm_theme_arrow option:selected').val();
      $('.arrow_type').hide();
      $('.arrow_section').show();
      $('#arrow_'+selected_arrowtype).show();

    $('.apmm-color-picker').wpColorPicker();

   /* check of follow_scroll div exists on page or not for visibility of save custom theme on page scroll */
    if ($('.follow-scroll').length > 0) {
       /* scroll save postbox on page scroll */
        var element = $('.follow-scroll'),
            originalY = element.offset().top;
        
        // Space between element and top of screen (when scrolling)
        var topMargin = 50;
        
        // Should probably be set in CSS; but here just for emphasis
        element.css('position', 'relative');
        
        $(window).on('scroll', function(event) {
            var scrollTop = $(window).scrollTop();
            
            element.stop(false, false).animate({
                top: scrollTop < originalY
                        ? 0
                        : scrollTop - originalY + topMargin
            }, 300);
        });
      }




      $('select.wpmm-orientation').on('change',function(){
         var orientation =  this.value;
         if(orientation == "vertical"){
          $('tr.wpmm_show_valigntype').show('slow');
         }else{
          $('tr.wpmm_show_valigntype').hide();
         }
      });

    var orientation_value =  $('select.wpmm-orientation option:selected').val();
      if(orientation_value == "vertical"){
         $('tr.wpmm_show_valigntype').show('slow');
         }else{
         $('tr.wpmm_show_valigntype').hide();
         }

  /*
  * WP Meta Box Settings
  */
 $(".wpmm-settings-box").each(function(index) {
    var thisRow = $(this);
    thisRow.find('select.wpmm_theme_type').change(function () { 
        var selected_value =  this.value;
       
         if(selected_value == "available_skins"){
           thisRow.find('tr.wpmm_show_themes').hide(); 
           thisRow.find('tr.wpmm_show_skins').show('slow');
         }else{
           thisRow.find('tr.wpmm_show_themes').show('slow'); 
           thisRow.find('tr.wpmm_show_skins').hide(); 
         }
          });
});

  $(".wpmm-settings-box").each(function(index) {
        var thisRow2 = $(this);
        var selectedval =   thisRow2.find('select.wpmm_theme_type option:selected').val();
         if(selectedval == "available_skins"){
           thisRow2.find('tr.wpmm_show_themes').hide(); 
           thisRow2.find('tr.wpmm_show_skins').show('slow');
         }else{
           thisRow2.find('tr.wpmm_show_themes').show('slow'); 
           thisRow2.find('tr.wpmm_show_skins').hide(); 
         }
          
});



          $('body').on("click",".icon-picker", function(e){ 
            $(this).iconPicker();
          });


    //Manual code switcher
    $( '.menu_shortcode' ).on( 'change' , function(){
       var id = $(this).val();
       $('.wpmegamenu-integration-code').hide();
       $('#wpmm-integration-'+id).slideDown('slow');
    });

    var selected_menu = $( '.menu_shortcode option:selected' ).val();
     $('#wpmm-integration-'+selected_menu).show();


          //Highlight code
    $( '.highlightcode' ).on( 'click' , function(e){
      wpmm_selectText( $(this)[0] );
    });

   function wpmm_selectText( element ) {
    var doc = document
      //, text = element //doc.getElementById(element)
      , range, selection
    ;
    if (doc.body.createTextRange) { //ms
      range = doc.body.createTextRange();
      range.moveToElementText( element );
      range.select();
    } else if (window.getSelection) { //all others
      selection = window.getSelection();        
      range = doc.createRange();
      range.selectNodeContents( element );
      selection.removeAllRanges();
      selection.addRange(range);
    }
  }
  
  if($('#wpmm_custom_css').length > 0){
  var editor = CodeMirror.fromTextArea(document.getElementById("wpmm_custom_css"), {
                       lineNumbers: true,
                        autofocus: true,
                       matchBrackets: true,
                       styleActiveLine: true
                  });
 }

  $('.tabs-left li a').on('click',function(){

   var bindtab = $(this).attr('href');
   if(bindtab == '#custom_theme_export' || bindtab == '#shortcode_menu_location' || bindtab == '#custom_theme_import'){
    $('#apmm-add-button').hide();
     $('#restore_settings_btn').hide();
   }else{
     $('#apmm-add-button').show();
      $('#restore_settings_btn').show();
   }
     if(bindtab == '#custom_css'){
        setTimeout(function() {
           editor.refresh();
          }, 100);
     }

  });



if (!document.getElementById("wpmm_uploadBtn")) {
//It does not exist
}else{
  document.getElementById("wpmm_uploadBtn").onchange = function () {
    // document.getElementById("wpmm_uploadFile").value = this.value;
         var val = this.value;
         var pathArray = val.split('\\');
         document.getElementById("wpmm_uploadFile").value = pathArray[pathArray.length - 1];
  };
}


});
