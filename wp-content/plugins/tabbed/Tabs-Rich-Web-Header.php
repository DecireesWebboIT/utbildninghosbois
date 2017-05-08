<?php
	if(!defined('ABSPATH')) exit;
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
?>
<style type="text/css">
	.Rich_Web_Header_Main { position:relative; width: 99%; height: 140px; background: #6ecae9; margin-top: 30px; text-align: left; }
	.Rich_Web_Header_Main img { position: relative; width: 222px; }
	.Rich_Web_Header_Free_Version { text-align:center; font-size: 16px; top: 10px; right: 10px; position: absolute; border: 1px solid #30a9d1; border-radius: 10px; box-shadow: 0px 0px 10px #30a9d1;}
	.Rich_Web_Header_Free_Version a { padding: 5px; text-shadow:1px 1px 1px #000000;}
	.Rich_Web_Header_Free_Version:hover { background-color: #ffffff; }
	.Rich_Web_Header_Free_Version a:hover { color: #30a9d1 !important; }
	.Rich_Web_Header_Contacts { position: relative; margin-top: 12px; font-size: 16px; padding: 10px; } 
	.Rich_Web_Header_Contacts a { text-decoration: none; color: #fff; margin-left: 10px; padding: 5px 7px; border-radius: 10px; background-color: #30a9d1; box-shadow: 0px 0px 10px #30a9d1; text-shadow:1px 1px 1px #000000; }
	.Rich_Web_Header_Contacts a:hover { background-color: #ffffff; color: #30a9d1; box-shadow: 0px 0px 10px #fff; }
</style>
<div class='Rich_Web_Header_Main'>
	<img src="<?php echo plugins_url('/Images/rich-web-logo.png',__FILE__)?>">
	<div class="Rich_Web_Header_Free_Version">
		<a href="http://rich-web.esy.es/tabs/" target="_blank" style="text-decoration: none; color: #fff; display: block;">
			<i class='Rich_Web_Free_Version_Icon rich_web rich_web-shopping-basket' style="margin-right: 10px;"></i>
			This is free version. <br>
			<span style="display:block;margin-top:5px;">For more adventures click to buy Pro version.</span>
		</a>
	</div>	
	<div class="Rich_Web_Header_Contacts">
		<!-- <a href="" target="_blank">Rate US</a> -->
		<a href="http://rich-web.esy.es/wordpress-bar-tab-horizontal/" target="_blank">Demo</a>
		<a href="https://wordpress.org/plugins/tabbed/faq/" target="_blank">FAQ</a>
		<a href="https://wordpress.org/support/plugin/tabbed" target="_blank">Contact US</a>
	</div>	
</div>