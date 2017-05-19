<?php
	if(!defined('ABSPATH')) exit;
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
?>
<script type="text/javascript">
	function Rich_Web_Tabs_Added_Theme()
	{
		alert("This is free version. For more adventures click to buy Pro version.");
	}
	function Rich_Web_Tabs_Theme_Canceled()
	{
		location.reload();
	}
	function Rich_Web_Tabs_Edit_Theme(Theme_ID)
	{
		var ajaxurl = object.ajaxurl;
		var data = {
		action: 'Rich_Web_Tabs_Edit_Theme', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
		foobar: Theme_ID, // translates into $_POST['foobar'] in PHP
		};
		jQuery.post(ajaxurl, data, function(response) {
			var arr=Array();
			
			var spl=response.split('=>');
			for(var i=3;i<spl.length;i++){
				arr[arr.length]=spl[i].split('[')[0].trim(); 
			}
			arr[arr.length-1]=arr[arr.length-1].split(')')[0].trim();
			jQuery('#Rich_Web_Tabs_T_T').val(arr[1]);
			
			jQuery('.Rich_Web_Tabs_Content_Table3_Theme').hide();
			if(arr[2]=='Rich_Tabs_1')
			{
				jQuery('.Rich_Web_Tabs_Content_Table3_Theme_1').show();

				jQuery('#Rich_Web_Tabs_T_W').val(arr[3]); jQuery('#Rich_Web_Tabs_T_Al').val(arr[4]); jQuery('#Rich_Web_Tabs_T_CA').val(arr[5]); jQuery('#Rich_Web_Tabs_T_NavM').val(arr[6]); jQuery('#Rich_Web_Tabs_T_NavAl').val(arr[7]); jQuery('#Rich_Web_Tabs_T_N_S').val(arr[8]); jQuery('#Rich_Web_Tabs_T_N_MBgC').val(arr[9]); jQuery('#Rich_Web_Tabs_T_N_MBC').val(arr[10]); jQuery('#Rich_Web_Tabs_T_N_PB').val(arr[11]); jQuery('#Rich_Web_Tabs_T_N_IBSh').val(arr[12]); jQuery('#Rich_Web_Tabs_T_N_OBSh').val(arr[13]); jQuery('#Rich_Web_Tabs_T_N_FS').val(arr[14]); jQuery('#Rich_Web_Tabs_T_N_FF').val(arr[15]); jQuery('#Rich_Web_Tabs_T_N_IS').val(arr[16]); jQuery('#Rich_Web_Tabs_T_S_BgC').val(arr[17]); jQuery('#Rich_Web_Tabs_T_S_C').val(arr[18]); jQuery('#Rich_Web_Tabs_T_S_HBgC').val(arr[19]); jQuery('#Rich_Web_Tabs_T_S_HC').val(arr[20]); jQuery('#Rich_Web_Tabs_T_S_CBgC').val(arr[21]); jQuery('#Rich_Web_Tabs_T_S_CC').val(arr[22]); jQuery('#Rich_Web_Tabs_T_C_BgT').val(arr[23]); jQuery('#Rich_Web_Tabs_T_C_BgC').val(arr[24]); jQuery('#Rich_Web_Tabs_T_C_BgC2').val(arr[25]); jQuery('#Rich_Web_Tabs_T_C_BW').val(arr[26]); jQuery('#Rich_Web_Tabs_T_C_BC').val(arr[27]); jQuery('#Rich_Web_Tabs_T_C_BR').val(arr[28]); jQuery('#Rich_Web_Tabs_T_C_IBSC').val(arr[29]); jQuery('#Rich_Web_Tabs_T_C_OBSC').val(arr[30]);
				if( arr[6] == 'horizontal' )
				{
					jQuery('.Rich_Web_Tabs_T_NavM_H').show();
					jQuery('.Rich_Web_Tabs_T_NavM_V').hide();
				}
				else if( arr[6] == 'vertical' )
				{
					jQuery('.Rich_Web_Tabs_T_NavM_V').show();
					jQuery('.Rich_Web_Tabs_T_NavM_H').hide();
				}
			}
			
			jQuery('input.Rich_Web_Tab_Col').alphaColorPicker();
			jQuery('.wp-color-result').attr('title','Select');
			jQuery('.wp-color-result').attr('data-current','Selected');
			Rich_Web_Tabs_RangeSlider();			
		})
		setTimeout(function(){
			jQuery('.Rich_Web_Tabs_Content_Data1_Theme').css('display','none');
			jQuery('.Rich_Web_Tabs_Add_Theme').addClass('Rich_Web_Tabs_AddAnim_Theme');
			jQuery('.Rich_Web_Tabs_Content_Data2_Theme').css('display','block');
			jQuery('.Rich_Web_Tabs_Cancel_Theme').addClass('Rich_Web_Tabs_CancelAnim_Theme');
		},500)	
	}
	function Rich_Web_Tabs_Copy_Theme(Theme_ID)
	{
		var ajaxurl = object.ajaxurl;
		var data = {
		action: 'Rich_Web_Tabs_Clone_Theme', // wp_ajax_my_action / wp_ajax_nopriv_my_action in ajax.php. Can be named anything.
		foobar: Theme_ID, // translates into $_POST['foobar'] in PHP
		};
		jQuery.post(ajaxurl, data, function(response) {
			location.reload();
		})
	}	
	function Rich_Web_Tabs_RangeSlider()
	{  
		var slider = jQuery('.Rich_Web_Tabs_Range'), range = jQuery('.Rich_Web_Tabs_Range__range'), value = jQuery('.Rich_Web_Tabs_Range__value');     
		slider.each(function()
		{   
			value.each(function()
			{   
				var value = jQuery(this).prev().attr('value');
			    jQuery(this).html(value);
			});    
			range.on('input', function()
			{      
				jQuery(this).next(value).html(this.value);
			});  
		});
	}	
	function Rich_Web_Tabs_T_NavM_Ch()
	{
		var Rich_Web_Tabs_T_NavM = jQuery('#Rich_Web_Tabs_T_NavM').val();

		if( Rich_Web_Tabs_T_NavM == 'horizontal' )
		{
			jQuery('.Rich_Web_Tabs_T_NavM_H').show();
			jQuery('.Rich_Web_Tabs_T_NavM_V').hide();
			jQuery('#Rich_Web_Tabs_T_NavAl').val('left');			
		}
		else if( Rich_Web_Tabs_T_NavM == 'vertical' )
		{
			jQuery('.Rich_Web_Tabs_T_NavM_V').show();
			jQuery('.Rich_Web_Tabs_T_NavM_H').hide();
			jQuery('#Rich_Web_Tabs_T_NavAl').val('top');
		}
	}
</script>