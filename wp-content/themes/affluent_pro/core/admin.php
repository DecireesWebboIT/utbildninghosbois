<?php

//Define custom columns for each custom post type page
if(!function_exists('cpotheme_admin_columns')){
	add_action('manage_posts_custom_column', 'cpotheme_admin_columns', 2);
	function cpotheme_admin_columns($column){
		global $post;
		switch($column){
			case 'cpo-image': echo get_the_post_thumbnail($post->ID, array(60,60)); break;
			//Portfolio
			case 'cpo-portfolio-cats': echo get_the_term_list($post->ID, 'cpo_portfolio_category', '', ', ', ''); break;
			case 'cpo-portfolio-tags': echo get_the_term_list($post->ID, 'cpo_portfolio_tag', '', ', ', ''); break;
			//Services
			case 'cpo-service-cats': echo get_the_term_list($post->ID, 'cpo_service_category', '', ', ', ''); break;
			case 'cpo-service-tags': echo get_the_term_list($post->ID, 'cpo_service_tag', '', ', ', ''); break;
			//Team
			case 'cpo-team-cats': echo get_the_term_list($post->ID, 'cpo_team_category', '', ', ', ''); break;
			//Products
			case 'cpo-product-cats': echo get_the_term_list($post->ID, 'cpo_product_category', '', ', ', ''); break;
			case 'cpo-product-tags': echo get_the_term_list($post->ID, 'cpo_product_tag', '', ', ', ''); break;
				
			default:break;
		}
	}
}

add_action('admin_notices', 'cpotheme_admin_welcome_notice', 90);
function cpotheme_admin_welcome_notice(){	
	$screen = get_current_screen();
	$welcome_dismissed = trim(cpotheme_get_option(CPOTHEME_ID.'_wizard', 'cpotheme_settings', false));
	
	$display = true;
	if(isset($_GET['action']) && $_GET['action'] == 'edit' || $screen->action == 'add' || $screen->base == 'plugins' || $screen->base == 'widgets') 
		$display = false;
	
	if(current_user_can('manage_options') && $welcome_dismissed != 'dismissed' && $display){
		$welcome_url = '<a href="'.esc_url(admin_url('themes.php?page=cpotheme-welcome')).'">'.__('quickstart guide', 'cpotheme').'</a>';
		$plugin_url = '<strong><a href="'.esc_url(admin_url('themes.php?page=cpotheme-welcome')).'">CPO Content Types</a></strong>';
		echo '<div class="updated">';
		echo '<div class="cpotheme-notice">';
		echo '<a href="'.add_query_arg('ctdismiss', CPOTHEME_ID.'_wizard').'" class="cpothemes-notice-dismiss">'.__('Dismiss This Notice', 'cpotheme').'</a>';
		echo '<p>'.sprintf(esc_html__('%s is ready! Make sure you install the %s companion plugin and then check the quickstart guide to see how it all works.', 'cpotheme'), esc_attr(CPOTHEME_NAME), $plugin_url, $welcome_url).'</p>';
		echo '<p><a href="'.esc_url(admin_url('themes.php?page=cpotheme-welcome')).'" class="button button-primary" style="text-decoration: none;">'.sprintf(__('Start Using %s', 'cpotheme'), esc_attr(CPOTHEME_NAME)).'</a></p>';
		echo '</div>';
		echo '</div>';
	}
}

add_action('admin_menu', 'cpotheme_admin_welcome');
function cpotheme_admin_welcome(){
	add_theme_page(esc_attr(CPOTHEME_NAME), esc_attr(CPOTHEME_NAME), 'read', 'cpotheme-welcome', 'cpotheme_admin_welcome_page');
}


function cpotheme_admin_welcome_page(){
	echo '<div class="wrap about-wrap">';
	$core_path = get_template_directory().'/core/';
	if(defined('CPOTHEME_CORE')) $core_path = CPOTHEME_CORE;
	require_once($core_path.'/templates/admin-welcome.php');
	echo '</div>';
}


//Notice display and dismissal
if(!function_exists('cpotheme_admin_notice_control')){
	add_action('admin_init', 'cpotheme_admin_notice_control');
	function cpotheme_admin_notice_control(){
		//Display a notice
		if(isset($_GET['ctdisplay']) && $_GET['ctdisplay'] != ''){
			cpotheme_update_option(htmlentities($_GET['ctdisplay']), 'display');
			wp_redirect(remove_query_arg('ctdisplay'));
		}
		//Dismiss a notice
		if(isset($_GET['ctdismiss']) && $_GET['ctdismiss'] != ''){
			cpotheme_update_option(htmlentities($_GET['ctdismiss']), 'dismissed');
			wp_redirect(remove_query_arg('ctdismiss'));
		}
	}
}

//Add a help link next to the Screen Options tab
if(!function_exists('cpotheme_admin_help')){
	//add_action('admin_footer', 'cpotheme_admin_help');
	function cpotheme_admin_help(){
		$core_path = defined('CPOTHEME_CORE_URL') ? CPOTHEME_CORE_URL : get_template_directory_uri().'/core/';
		echo '<div id="cpotheme-help" style="display:none;">';
		echo '<a class="cpotheme-help-link" href="http://cpothemes.com/documentation" target="_blank">';
		echo '<img class="cpotheme-help-link-image" src="'.$core_path.'images/ct-icon.png">';
		echo __('Theme Documentation', 'cpotheme');
		echo '</a>';	
		echo '</div>';
	}
}