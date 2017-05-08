<?php defined('ABSPATH') or die("No script kiddies please!");
global $wpdb;
$table_name = $table_name = $wpdb->prefix . "apmm_custom_theme";
$theme_id = $_GET['theme_id'];
$theme_object = new AP_Theme_Settings();
$custom_theme = $theme_object->get_custom_theme_data($theme_id);
$custom_themes = $custom_theme[0];
// $t = new AP_Menu_Settings();
// $t->displayArr($custom_themes);
// exit();
/**
 * 
 * stdClass Object
(
    [theme_id] => 1
    [title] =>  theme
    [slug] => theme
    [theme_settings] => a:12:{s:7:"general";a:8:{s:10:"arrow_type";s:5:"type3";s:11:"arrow_color";s:7:"#000000";s:11:"line_height";s:3:"1.7";s:6:"zindex";s:3:"999";s:18:"hover_indent_delay";s:5:"600ms";s:19:"transition_duration";s:5:"400ms";s:13:"enable_shadow";s:1:"1";s:12:"shadow_color";s:7:"#3b3a54";}s:8:"menu_bar";a:20:{s:22:"enable_menu_background";s:1:"1";s:20:"menu_background_from";s:7:"#000000";s:18:"menu_background_to";s:16:"rgba(5,5,5,0.68)";s:10:"font_color";s:7:"#ffffff";s:11:"font_family";s:6:"Roboto";s:11:"font_weight";s:6:"normal";s:11:"padding_top";s:3:"2px";s:14:"padding_bottom";s:3:"2px";s:12:"padding_left";s:3:"2px";s:13:"padding_right";s:3:"2px";s:5:"width";s:5:"500px";s:21:"border_radius_topleft";s:3:"2px";s:22:"border_radius_topright";s:3:"2px";s:25:"border_radius_bottomright";s:3:"2px";s:24:"border_radius_bottomleft";s:3:"2px";s:12:"border_color";s:7:"#000000";s:9:"alignment";s:4:"left";s:10:"margin_top";s:0:"";s:13:"margin_bottom";s:0:"";s:11:"transparent";s:3:"off";}s:8:"top_menu";a:20:{s:17:"enable_background";s:1:"1";s:20:"menu_background_from";s:7:"#1e73be";s:18:"menu_background_to";s:21:"rgba(30,115,190,0.68)";s:21:"background_hover_from";s:0:"";s:19:"background_hover_to";s:0:"";s:10:"font_color";s:7:"#000000";s:17:"font_color_active";s:7:"#dd3333";s:18:"font_color_current";s:0:"";s:9:"font_size";s:4:"18px";s:11:"font_weight";s:6:"normal";s:17:"font_weight_hover";s:4:"bold";s:9:"transform";s:6:"normal";s:11:"font_family";s:6:"Roboto";s:15:"font_decoration";s:4:"none";s:21:"font_decoration_hover";s:4:"none";s:11:"item_margin";s:7:"0px 6px";s:13:"icon_position";s:4:"left";s:14:"menu_alignment";s:5:"right";s:18:"menu_divider_color";s:0:"";s:12:"opacity_glow";s:3:"0.1";}s:12:"megamenu_bar";a:9:{s:20:"menu_background_from";s:7:"#dd3333";s:18:"menu_background_to";s:20:"rgba(221,51,51,0.34)";s:5:"width";s:4:"100%";s:11:"padding_top";s:3:"4px";s:14:"padding_bottom";s:3:"4px";s:12:"padding_left";s:3:"4px";s:13:"padding_right";s:3:"4px";s:12:"border_color";s:7:"#000000";s:13:"border_radius";s:3:"5px";}s:11:"second_menu";a:24:{s:20:"menu_background_from";s:0:"";s:18:"menu_background_to";s:0:"";s:21:"background_hover_from";s:0:"";s:19:"background_hover_to";s:0:"";s:10:"font_color";s:0:"";s:17:"font_color_active";s:0:"";s:18:"font_color_current";s:0:"";s:9:"font_size";s:4:"16px";s:11:"font_weight";s:13:"theme_default";s:17:"font_weight_hover";s:13:"theme_default";s:9:"transform";s:6:"normal";s:11:"font_family";s:6:"Roboto";s:15:"font_decoration";s:4:"none";s:21:"font_decoration_hover";s:4:"none";s:16:"item_padding_top";s:0:"";s:19:"item_padding_bottom";s:0:"";s:17:"item_padding_left";s:0:"";s:18:"item_padding_right";s:0:"";s:15:"item_margin_top";s:0:"";s:18:"item_margin_bottom";s:0:"";s:16:"item_margin_left";s:0:"";s:17:"item_margin_right";s:0:"";s:13:"icon_position";s:4:"left";s:14:"menu_alignment";s:4:"left";}s:10:"third_menu";a:24:{s:20:"menu_background_from";s:0:"";s:18:"menu_background_to";s:0:"";s:21:"background_hover_from";s:0:"";s:19:"background_hover_to";s:0:"";s:10:"font_color";s:0:"";s:17:"font_color_active";s:0:"";s:18:"font_color_current";s:0:"";s:9:"font_size";s:4:"16px";s:11:"font_weight";s:13:"theme_default";s:17:"font_weight_hover";s:13:"theme_default";s:9:"transform";s:6:"normal";s:11:"font_family";s:6:"Roboto";s:15:"font_decoration";s:4:"none";s:21:"font_decoration_hover";s:4:"none";s:16:"item_padding_top";s:0:"";s:19:"item_padding_bottom";s:0:"";s:17:"item_padding_left";s:0:"";s:18:"item_padding_right";s:0:"";s:15:"item_margin_top";s:0:"";s:18:"item_margin_bottom";s:0:"";s:16:"item_margin_left";s:0:"";s:17:"item_margin_right";s:0:"";s:13:"icon_position";s:4:"left";s:14:"menu_alignment";s:4:"left";}s:7:"widgets";a:21:{s:10:"font_color";s:7:"#000000";s:16:"font_hover_color";s:7:"#dd3333";s:9:"font_size";s:4:"16px";s:11:"font_weight";s:6:"normal";s:17:"font_weight_hover";s:6:"normal";s:9:"transform";s:10:"capitalize";s:11:"font_family";s:6:"Roboto";s:15:"font_decoration";s:9:"underline";s:21:"font_decoration_hover";s:4:"none";s:18:"content_font_color";s:7:"#1e73be";s:17:"content_font_size";s:4:"14px";s:19:"content_font_family";s:6:"Roboto";s:11:"padding_top";s:3:"0px";s:14:"padding_bottom";s:3:"0px";s:12:"padding_left";s:3:"0px";s:13:"padding_right";s:3:"0px";s:10:"margin_top";s:3:"0px";s:13:"margin_bottom";s:3:"0px";s:11:"margin_left";s:3:"0px";s:12:"margin_right";s:3:"0px";s:12:"border_color";s:0:"";}s:11:"top_section";a:15:{s:10:"font_color";s:0:"";s:9:"font_size";s:3:"0px";s:11:"font_weight";s:13:"theme_default";s:9:"transform";s:6:"normal";s:11:"font_family";s:6:"Roboto";s:11:"image_width";s:0:"";s:12:"image_height";s:0:"";s:17:"image_padding_top";s:3:"0px";s:20:"image_padding_bottom";s:3:"0px";s:18:"image_padding_left";s:3:"0px";s:19:"image_padding_right";s:3:"0px";s:16:"image_margin_top";s:3:"0px";s:19:"image_margin_bottom";s:3:"0px";s:17:"image_margin_left";s:3:"0px";s:18:"image_margin_right";s:3:"0px";}s:14:"bottom_section";a:15:{s:10:"font_color";s:0:"";s:9:"font_size";s:3:"0px";s:11:"font_weight";s:13:"theme_default";s:9:"transform";s:6:"normal";s:11:"font_family";s:6:"Roboto";s:11:"image_width";s:0:"";s:12:"image_height";s:0:"";s:17:"image_padding_top";s:0:"";s:20:"image_padding_bottom";s:0:"";s:18:"image_padding_left";s:0:"";s:19:"image_padding_right";s:0:"";s:16:"image_margin_top";s:0:"";s:19:"image_margin_bottom";s:0:"";s:17:"image_margin_left";s:0:"";s:18:"image_margin_right";s:0:"";}s:6:"flyout";a:17:{s:19:"menu_bgcurrentcolor";s:0:"";s:18:"menu_bg_hovercolor";s:0:"";s:10:"font_color";s:0:"";s:16:"font_hover_color";s:0:"";s:9:"font_size";s:3:"0px";s:11:"font_weight";s:13:"theme_default";s:17:"font_weight_hover";s:13:"theme_default";s:9:"transform";s:6:"normal";s:11:"font_family";s:6:"Roboto";s:15:"font_decoration";s:4:"none";s:21:"font_decoration_hover";s:4:"none";s:11:"item_margin";s:0:"";s:12:"item_padding";s:0:"";s:13:"icon_position";s:4:"left";s:14:"menu_alignment";s:4:"left";s:18:"menu_divider_color";s:0:"";s:12:"opacity_glow";s:3:"0.1";}s:15:"mobile_settings";a:13:{s:25:"togglebar_background_from";s:0:"";s:23:"togglebar_background_to";s:0:"";s:22:"togglebar_bghover_from";s:0:"";s:20:"togglebar_bghover_to";s:0:"";s:16:"togglebar_height";s:0:"";s:26:"resposive_breakpoint_width";s:0:"";s:18:"toggle_bar_content";s:0:"";s:16:"toggle_icon_type";s:5:"type1";s:10:"icon_color";s:0:"";s:10:"text_color";s:0:"";s:15:"togglebar_align";s:4:"left";s:25:"submenu_closebtn_position";s:3:"top";s:23:"submenus_retractor_text";s:0:"";}s:10:"search_bar";a:8:{s:9:"font_size";s:4:"14px";s:5:"width";s:3:"50%";s:10:"text_color";s:7:"#ffffff";s:8:"bg_color";s:7:"#000000";s:21:"text_placholder_color";s:7:"#ffffff";s:10:"icon_color";s:7:"#1e73be";s:11:"image_width";s:3:"10%";s:12:"image_height";s:3:"10%";}}
    created : 2016-06-23
    modified : 2016-06-23
)
 * */
 foreach($custom_themes as $key=>$val){
    $$key = $val;
 }
 $created_date  =  date( 'Y-m-d H:m:s' );
 $modified_date =  date( 'Y-m-d H:m:s' );
 $theme_slug = $theme_object->wpmm_theme_make_slug($title,$table_name);
 $title .='-copy';
 $wpdb->insert( $table_name, 
   array( 
	        'title'          => $title,
            'slug'           => $theme_slug,
            'theme_settings' => $theme_settings,
            'created'        => $created_date,
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
 $_SESSION['apmm_success'] = __('Custom theme Copied Successfully.',APMM_TD);
 wp_redirect(admin_url().'admin.php?page=wpmm-theme-settings');   
 exit;