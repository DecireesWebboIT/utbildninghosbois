<?php
/*
Plugin Name: CPO Widgets
Description: A number of useful widgets that add some essential functionality to your WordPress site. There widgets are intended to let you add more engaging content in your sidebars, such as a Twitter timeline, recent posts, image banners, or social media links.
Author: CPOThemes
Version: 1.1.0
Author URI: http://www.cpothemes.com
*/

//Add public stylesheets
add_action('wp_enqueue_scripts', 'ctwg_add_styles');
function ctwg_add_styles(){
	$stylesheets_path = plugins_url('css/' , __FILE__);
	wp_enqueue_style('ctwg-shortcodes', $stylesheets_path.'style.css');	
}

//Add all Shortcode components
$core_path = plugin_dir_path(__FILE__).'widgets/';
require_once($core_path.'widget-advert.php');
require_once($core_path.'widget-flickr.php');
require_once($core_path.'widget-recent.php');
require_once($core_path.'widget-tweets.php');
require_once($core_path.'widget-social.php');
require_once($core_path.'widget-author.php');