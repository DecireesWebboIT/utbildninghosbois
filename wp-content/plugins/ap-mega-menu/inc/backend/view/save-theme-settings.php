<?php defined('ABSPATH') or die("No script kiddies please!");
/**
 * Posted Data
 * */
global $wpdb;
//$sanitized_array = array_map('sanitize_text_field',$unsanitized_array);
$sanitized_array = array();
foreach($_POST['apmm_theme'] as $key=>$val){
	if(is_array($val)){
		$sanitized_array[$key] = array_map('sanitize_text_field',$val);
	}else{
		$sanitized_array[$key] = sanitize_text_field($val);
	}
}
// echo "<pre>";
// print_r($sanitized_array);
// echo "</pre>";

// exit();

foreach ( $sanitized_array as $keys => $value) {

         $$keys = $value;	
}

$general['enable_shadow'] = (isset($general['enable_shadow']) && $general['enable_shadow'] =='1')?'1':'0';
$menu_bar['enable_menu_background'] = (isset($menu_bar['enable_menu_background']) && $menu_bar['enable_menu_background'] =='1')?'1':'0';
$top_menu['enable_background'] = (isset($top_menu['enable_background']) && $top_menu['enable_background'] =='1')?'1':'0';
$top_menu['enable_background_hover'] = (isset($top_menu['enable_background_hover']) && $top_menu['enable_background_hover'] =='1')?'1':'0';
$top_menu['enable_menu_divider'] = (isset($top_menu['enable_menu_divider']) && $top_menu['enable_menu_divider'] =='1')?'1':'0';
$megamenu_bar['enable_megamenu_background'] = (isset($megamenu_bar['enable_megamenu_background']) && $megamenu_bar['enable_megamenu_background'] =='1')?'1':'0';
$second_menu['enable_background'] = (isset($second_menu['enable_background']) && $second_menu['enable_background'] =='1')?'1':'0';
$second_menu['enable_background_hover'] = (isset($second_menu['enable_background_hover']) && $second_menu['enable_background_hover'] =='1')?'1':'0';
$third_menu['enable_background'] = (isset($third_menu['enable_background']) && $third_menu['enable_background'] =='1')?'1':'0';
$third_menu['enable_background_hover'] = (isset($third_menu['enable_background_hover']) && $third_menu['enable_background_hover'] =='1')?'1':'0';
$flyout['enable_background'] = (isset($flyout['enable_background']) && $flyout['enable_background'] =='1')?'1':'0';
$flyout['enable_menu_divider'] = (isset($flyout['enable_menu_divider']) && $flyout['enable_menu_divider'] =='1')?'1':'0';
$mobile_settings['toggle_bar_enable'] = (isset($mobile_settings['toggle_bar_enable']) && $mobile_settings['toggle_bar_enable'] =='1')?'1':'0';
$mobile_settings['togglebar_enable_bgcolor'] = (isset($mobile_settings['togglebar_enable_bgcolor']) && $mobile_settings['togglebar_enable_bgcolor'] =='1')?'1':'0';
$mobile_settings['togglebar_bghover_enable'] = (isset($mobile_settings['togglebar_bghover_enable']) && $mobile_settings['togglebar_bghover_enable'] =='1')?'1':'0';

$apmm_settings = array();

$apmm_settings['general']         =  $general;
$apmm_settings['menu_bar']        =  $menu_bar;
$apmm_settings['top_menu']        =  $top_menu;
$apmm_settings['megamenu_bar']    =  $megamenu_bar;
$apmm_settings['second_menu']     =  $second_menu;
$apmm_settings['third_menu']      =  $third_menu;
$apmm_settings['widgets']         =  $widgets;
$apmm_settings['top_section']     =  $top_section;
$apmm_settings['bottom_section']  =  $bottom_section;
$apmm_settings['flyout']          =  $flyout;
$apmm_settings['mobile_settings'] =  $mobile_settings;
$apmm_settings['search_bar']      =  $search_bar;

// echo "<pre>";
// print_r($apmm_settings);
// die();

$apmm_theme_settings = serialize($apmm_settings);



$table_name = $wpdb->prefix . "apmm_custom_theme";
$ap_thme = new AP_Theme_Settings();
$theme_slug = $ap_thme->wpmm_theme_make_slug($theme_title,$table_name);

if(isset($_POST['themeid']) && $_POST['themeid'] != '')
{
 $themeid = $_POST['themeid'];
 $nonce = $_POST['_nonce'];
 $modified_date =  date( 'Y-m-d H:m:s' );
	$update = $wpdb->update( 
	$table_name, 
	array(
            'title'          => $theme_title,
            'theme_settings' => $apmm_theme_settings,
            'modified'       => $modified_date,
        ),
    array('theme_id'=>$themeid), 
	array(
        '%s',
        '%s',
        '%s'
    ),
    array('%d')
);

$_SESSION['apmm_success'] = __('Custom Theme Updated Successfully',APMM_TD);
wp_redirect(admin_url('admin.php?page=wpmm-add-theme&action=edit_theme&theme_id='.$themeid.'&_wpnonce='.$nonce));
}else{
$added_date     = date( 'Y-m-d H:m:s' );
$modified_date  =  date( 'Y-m-d H:m:s' );
$wpdb->insert( 
	$table_name, 
    array(
            'title'          => $theme_title,
            'slug'           => $theme_slug,
            'theme_settings' => $apmm_theme_settings,
            'created'        => $added_date,
            'modified'       => $modified_date
        ),
	array(
        '%s',
        '%s',
        '%s',
        '%s',
        '%s'
    )
);
$_SESSION['apmm_success'] = __('Custom Theme Added Successfully.',APMM_TD);

wp_redirect(admin_url('admin.php?page=wpmm-theme-settings'));
}

exit();

