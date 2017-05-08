<?php defined('ABSPATH') or die("No script kiddies please!");
/**
 * Posted Data
 * 
 */
// $this->displayArr($_POST);
$apmega_settings['advanced_click']              = sanitize_text_field($_POST['advanced_click']);
$apmega_settings['enable_mobile']               = isset($_POST['enable_mobile'])?sanitize_text_field($_POST['enable_mobile']):'0';
$apmega_settings['disable_submenu_retractor']   = isset($_POST['disable_submenu_retractor'])?sanitize_text_field($_POST['disable_submenu_retractor']):'0';

$apmega_settings['mlabel_animation_type']       = isset($_POST['mlabel_animation_type'])?sanitize_text_field($_POST['mlabel_animation_type']):'none';
$apmega_settings['animation_delay']             = isset($_POST['animation_delay'])?sanitize_text_field($_POST['animation_delay']):'2';
$apmega_settings['animation_duration']          = isset($_POST['animation_duration'])?sanitize_text_field($_POST['animation_duration']):'3';
$apmega_settings['animation_iteration_count']   = isset($_POST['animation_iteration_count'])?sanitize_text_field($_POST['animation_iteration_count']):'1';

$apmega_settings['mobile_toggle_option']        = sanitize_text_field($_POST['mobile_toggle_option']);
$apmega_settings['image_size']  		        = sanitize_text_field($_POST['image_size']);
$apmega_settings['hide_bg_images']              = isset($_POST['hide_bg_images'])?sanitize_text_field($_POST['hide_bg_images']):'0';
$apmega_settings['hide_icons']                  = isset($_POST['hide_icons'])?sanitize_text_field($_POST['hide_icons']):'0';
// $apmega_settings['transition_duration']         = isset($_POST['transition_duration'])?sanitize_text_field($_POST['transition_duration']):'5000';
// $apmega_settings['use_custom_width']         = isset($_POST['use_custom_width'])?sanitize_text_field($_POST['use_custom_width']):'0';
$apmega_settings['custom_width']                = isset($_POST['custom_width'])?sanitize_text_field($_POST['custom_width']):'';
// $apmega_settings['custom_height']            = isset($_POST['custom_height'])?sanitize_text_field($_POST['custom_height']):'';

$apmega_settings['icon_width']                  = (isset($_POST['icon_width']) && $_POST['icon_width']!= '')?sanitize_text_field($_POST['icon_width']):'15px';

$apmega_settings['close_menu_icon']             = (isset($_POST['close_menu_icon']) && $_POST['close_menu_icon'] != '')?sanitize_text_field($_POST['close_menu_icon']):'dashicons dashicons-menu';
$apmega_settings['open_menu_icon']              = (isset($_POST['open_menu_icon']) && $_POST['open_menu_icon'] != '')?sanitize_text_field($_POST['open_menu_icon']):'dashicons dashicons-no';

$apmega_settings['enable_custom_css']              = (isset($_POST['enable_custom_css']) && $_POST['enable_custom_css'] == '1')?'1':'0';
$apmega_settings['custom_css']              = (isset($_POST['custom_css']) && $_POST['custom_css'] != '')?$_POST['custom_css']:'';

update_option('apmega_settings', $apmega_settings);
$_SESSION['apmm_success']                 = __('AP Mega Menu Settings Saved Successfully', APMM_TD);
wp_redirect(admin_url('admin.php?page=ap-mega-menu'));
exit();