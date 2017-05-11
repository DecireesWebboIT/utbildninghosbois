<?php
	if(!defined('ABSPATH')) exit;
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	require_once( 'Tabs-Rich-Web-Header.php' );
?>
<style type="text/css">
	.Rich_Web_Header_Main { position:relative; width: 100%; height: 140px; background: #6ecae9; margin-top: 30px; text-align: left; margin-bottom:20px;box-shadow:0 0 10px rgba(50, 50, 50, 1);}
	.Rich_Web_Header_Main img { position: relative; width: 222px; }
	.Rich_Web_Header_Free_Version { text-align:center; font-size: 16px; top: 10px; right: 10px; position: absolute; border: 1px solid #30a9d1; border-radius: 10px; box-shadow: 0px 0px 10px #30a9d1;}
	.Rich_Web_Header_Free_Version a { padding: 5px; text-shadow:1px 1px 1px #000000;}
	.Rich_Web_Header_Free_Version:hover { background-color: #ffffff; }
	.Rich_Web_Header_Free_Version a:hover { color: #30a9d1 !important; }
	.Rich_Web_Header_Contacts { position: relative; margin-top: 12px; font-size: 16px; padding: 10px; } 
	.Rich_Web_Header_Contacts a { text-decoration: none; color: #fff; margin-left: 10px; padding: 5px 7px; border-radius: 10px; background-color: #30a9d1; box-shadow: 0px 0px 10px #30a9d1; text-shadow:1px 1px 1px #000000; }
	.Rich_Web_Header_Contacts a:hover { background-color: #ffffff; color: #30a9d1; box-shadow: 0px 0px 10px #fff; }
	.Rich_Web_Products_Main_Div
	{
		width: 99%;
		position: relative;
		margin: 15px 0px;
		float: left;
	}
	.Rich_Web_Products_Product_Div
	{
		float: left;
		position: relative;
		width: 270px;
		height: 530px;
		text-align: center;
		background: #fff;
		margin-left: 5px;
		margin-top: 5px;
		box-shadow: 0px 0px 20px #c0c0c0 inset ;
	}
	.Rich_Web_Products_Product_Div img
	{
		margin-top: 10px;
	}
	.Rich_Web_Products_Product_Div p
	{
		padding: 0px 15px 10px 15px;	
		text-align: justify;	
		font-size: 14px;
		line-height: 1;
		text-shadow: 0px 0px 1px #6ecae9;
	}
	.Rich_Web_Products_Product_Div p span
	{
		margin-left: 5px;
		margin-right: 3px;
		padding: 0px;
		font-size: 24px;
		color: #6ecae9;
		font-style: bold;
		text-shadow: 0px 0px 1px #000;
	}
	.Rich_Web_Products_Product_Div h1
	{
		display: block;
		width: 90%;
		margin: 0 auto;
		border-top: 1px solid #6ecae9; 
	}
	.Rich_Web_Products_Product_Div a
	{
		padding: 8px 0px;
	    box-shadow: 0px 0px 20px #c0c0c0 inset;
	    /* display: block; */
	    width: 90%;
	    /* margin: 0 auto 15px auto; */
	    text-decoration: none;
	    color: #000;
	    text-shadow: 0px 0px 1px #000;
	    position: absolute;
	    left: 5%;
	    bottom: 10px;
	}
	.Rich_Web_Products_Product_Div a:hover
	{
		box-shadow: 0px 0px 20px #8a8a8a inset ;
		color: #000;
		text-shadow: 0px 0px 1px #8a8a8a;

	}
</style>
<div class="Rich_Web_Products_Main_Div">
	<div class="Rich_Web_Products_Product_Div">
		<img src="<?php echo plugins_url('/Images/Products/Forms.png',__FILE__);?>">
		<h1></h1>
		<p>
			<span>R</span>ich is a WordPress form creator with a multiple choice, that allows to create WordPress form for several minutes. As soon as possible, you can create fully functional contact form without writing a single line of code. Forms Plugin allows to change all settings like the colors, fonts and sizes, which are appropriates to forms standards. Rich Web form has all functions, that you can expect from the other free forms plugin.
		</p>
		<a href="http://rich-web.esy.es/form-forms/" target="_blank"> View More </a>
	</div>
	<div class="Rich_Web_Products_Product_Div">
		<img src="<?php echo plugins_url('/Images/Products/Gallery-Image.png',__FILE__);?>">
		<h1></h1>
		<p>
			<span>P</span>hoto Gallery is awesome WordPress gallery plugin with many useful features and effects. The photo plugin was created and specially designed for photos. Photo Gallery plugin is the responsive photo gallery plugin of the WordPress. There are 8 major versions of gallery style. Photo Gallery plugin is compatible with WordPress themes. You can change the colors of the gallery, sizes, font size and distance from powerful settings panel of gallery plugin.
		</p>
		<a href="http://rich-web.esy.es/gallery/" target="_blank"> View More </a>
	</div>
	<div class="Rich_Web_Products_Product_Div">
		<img src="<?php echo plugins_url('/Images/Products/Slider-Image.png',__FILE__);?>">
		<h1></h1>
		<p>
			<span>S</span>lider Rich Web is one of the most important plugins for WordPress websites. Besides, by beautiful and unrepeatable effects, your slider gives more professional look to your website. Slider Image is one of the best in responsive Slider images plugins. Plugin allows you to modify all setting, such as colors, fonts and sizes, which are corresponding, to standards of the slider. Rich Web Slider Image has that all features, that you can expect from another free slider images plugin. You can create unlimited sliders and images.
		</p>
		<a href="http://rich-web.esy.es/slider-image/" target="_blank"> View More </a>
	</div>
	<div class="Rich_Web_Products_Product_Div">
		<img src="<?php echo plugins_url('/Images/Products/Slider-Video.png',__FILE__);?>">
		<h1></h1>
		<p>
			<span>S</span>lider Video plugin is a great way to create a stunning video slider without programming skills. Fully responsive, works on any mobile device. You can attract more people to your website and amaze them with effective slideshows, that show your videos amazing way. It is very easy. It is necessary to select the video ( currently supports in Youtube, Vimeo, Vevo and MP4) that you would like to show in a Slider using the Rich Web, wich creates a responsive slideshow, thumbnail slider or slider post feed. Slider Video Plugin supports Youtube, Vimeo, Vevo and MP4 videos. It is fully responsive works on iPhone, IPAD, Android, Firefox, Chrome, Safari, Opera and Internet Explorer.
		</p>
		<a href="http://rich-web.esy.es/slider-video/" target="_blank"> View More </a>
	</div>
	<div class="Rich_Web_Products_Product_Div">
		<img src="<?php echo plugins_url('/Images/Products/Tabs.png',__FILE__);?>">
		<h1></h1>
		<p>
			<span>T</span>abs plugin is fully responsive. Tabs plugin is for creating responsive tabbed panels with unlimited options and transition animations support. If you wish to spice up your corporate website, blog, ecommerce site or a message board, with tabbed it’s easy to show any content, video, price or data tables, form or other elements.
		</p>
		<a href="http://rich-web.esy.es/tabs/" target="_blank"> View More </a>
	</div>
	<div class="Rich_Web_Products_Product_Div">
		<img src="<?php echo plugins_url('/Images/Products/Coming-Soon.png',__FILE__);?>">
		<h1></h1>
		<p>
			<span>C</span>oming Soon plugin is a responsive, modern and clean under construction & coming soon WordPress Plugin. This minimal template is packed with a countdown timer, ajax subscription form, social icons and about page where you can write a little bit about yourself and add your phone, email and address information.
		</p>
		<a href="http://rich-web.esy.es/wordpress-coming-soon/" target="_blank"> View More </a>
	</div>
</div>