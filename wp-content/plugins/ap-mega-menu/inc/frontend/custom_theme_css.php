<?php 
global $wpdb;
$options = get_option( 'apmega_settings' );  
$enable_mobile = (isset($options['enable_mobile']) && $options['enable_mobile'] == 1)?'1':'0'; 
// echo $current_theme_location; //current menu location

$themeid = $settings[$current_theme_location]['theme'];

$menuthemes = AP_Theme_Settings::get_custom_theme_rowdata($themeid);

 $wpmm_custom_theme = unserialize($menuthemes->theme_settings);
/* general settings*/
$enable_shadow = (isset($wpmm_custom_theme['general']['enable_shadow']))?'1':'0';
$shadow_color = (isset($wpmm_custom_theme['general']['shadow_color']))?$wpmm_custom_theme['general']['shadow_color']:'#ffffff';
$zindex = (isset($wpmm_custom_theme['general']['zindex']))?$wpmm_custom_theme['general']['zindex']:'999';
$line_height = (isset($wpmm_custom_theme['general']['line_height']))?$wpmm_custom_theme['general']['line_height']:'1.5';
/* menu bar settings*/
$enable_menu_background = (isset($wpmm_custom_theme['menu_bar']['enable_menu_background']))?'1':'0';
$menu_background_from = (isset($wpmm_custom_theme['menu_bar']['menu_background_from']))?$wpmm_custom_theme['menu_bar']['menu_background_from']:'#5ec073';

$font_color = (isset($wpmm_custom_theme['menu_bar']['font_color']))?$wpmm_custom_theme['menu_bar']['font_color']:'#ffffff';
$font_family = (isset($wpmm_custom_theme['menu_bar']['font_family']))?$wpmm_custom_theme['menu_bar']['font_family']:'Open Sans';
$font_weight = (isset($wpmm_custom_theme['menu_bar']['font_weight']))?$wpmm_custom_theme['menu_bar']['font_weight']:'normal';
$padding_top = (isset($wpmm_custom_theme['menu_bar']['padding_top']))?$wpmm_custom_theme['menu_bar']['padding_top']:'20px';
$padding_bottom = (isset($wpmm_custom_theme['menu_bar']['padding_bottom']))?$wpmm_custom_theme['menu_bar']['padding_bottom']:'25px';
$padding_left = (isset($wpmm_custom_theme['menu_bar']['padding_left']))?$wpmm_custom_theme['menu_bar']['padding_left']:'20px';
$padding_right = (isset($wpmm_custom_theme['menu_bar']['padding_right']))?$wpmm_custom_theme['menu_bar']['padding_right']:'22px';
$width = (isset($wpmm_custom_theme['menu_bar']['width']))?$wpmm_custom_theme['menu_bar']['width']:'600px';
$border_radius_topleft = (isset($wpmm_custom_theme['menu_bar']['border_radius_topleft']))?$wpmm_custom_theme['menu_bar']['border_radius_topleft']:'0px';
$border_radius_topright = (isset($wpmm_custom_theme['menu_bar']['border_radius_topright']))?$wpmm_custom_theme['menu_bar']['border_radius_topright']:'0px';
$border_radius_bottomright = (isset($wpmm_custom_theme['menu_bar']['border_radius_bottomright']))?$wpmm_custom_theme['menu_bar']['border_radius_bottomright']:'0px';
$border_radius_bottomleft = (isset($wpmm_custom_theme['menu_bar']['border_radius_bottomleft']))?$wpmm_custom_theme['menu_bar']['border_radius_bottomleft']:'0px';
$border_color = (isset($wpmm_custom_theme['menu_bar']['border_color']))?$wpmm_custom_theme['menu_bar']['border_color']:'#5ec073';
$alignment = (isset($wpmm_custom_theme['menu_bar']['alignment']))?$wpmm_custom_theme['menu_bar']['alignment']:'left';
$margin_top = (isset($wpmm_custom_theme['menu_bar']['margin_top']))?$wpmm_custom_theme['menu_bar']['margin_top']:'0px';
$margin_bottom = (isset($wpmm_custom_theme['menu_bar']['margin_bottom']))?$wpmm_custom_theme['menu_bar']['margin_bottom']:'0px';

/* top menu settings*/
$enable_background_hover1 = (isset($wpmm_custom_theme['top_menu']['enable_background_hover']))?'1':'0';
$background_hover_from1 = (isset($wpmm_custom_theme['top_menu']['background_hover_from']))?$wpmm_custom_theme['top_menu']['background_hover_from']:'#47a35b';
$bg_active_color1 = (isset($wpmm_custom_theme['top_menu']['bg_active_color']))?$wpmm_custom_theme['top_menu']['bg_active_color']:'';
$font_color_active1 = (isset($wpmm_custom_theme['top_menu']['font_color_active']))?$wpmm_custom_theme['top_menu']['font_color_active']:'#ffffff';
$font_size = (isset($wpmm_custom_theme['top_menu']['font_size']))?$wpmm_custom_theme['top_menu']['font_size']:'13px';

$font_weight_hover1 = (isset($wpmm_custom_theme['top_menu']['font_weight_hover']))?$wpmm_custom_theme['top_menu']['font_weight_hover']:'normal';
$transform = (isset($wpmm_custom_theme['top_menu']['transform']))?$wpmm_custom_theme['top_menu']['transform']:'normal';
$font_decoration1 = (isset($wpmm_custom_theme['top_menu']['font_decoration']))?$wpmm_custom_theme['top_menu']['font_decoration']:'none';
$font_decoration_hover1 = (isset($wpmm_custom_theme['top_menu']['font_decoration_hover']))?$wpmm_custom_theme['top_menu']['font_decoration_hover']:'none';


$enable_menu_divider = (isset($wpmm_custom_theme['top_menu']['enable_menu_divider']))?'1':'0';
$menu_divider_color = (isset($wpmm_custom_theme['top_menu']['menu_divider_color']))?$wpmm_custom_theme['top_menu']['menu_divider_color']:'rgb(255,255,255)';
$opacity_glow = (isset($wpmm_custom_theme['top_menu']['opacity_glow']))?$wpmm_custom_theme['top_menu']['opacity_glow']:'1';

$enable_menu_label_bgcolor = (isset($wpmm_custom_theme['top_menu']['enable_menu_label_bgcolor']) && $wpmm_custom_theme['top_menu']['enable_menu_label_bgcolor'] == 1)?'1':'0';
$menu_label_bgcolor = (isset($wpmm_custom_theme['top_menu']['menu_label_bgcolor']))?$wpmm_custom_theme['top_menu']['menu_label_bgcolor']:'';
$menu_label_fontcolor = (isset($wpmm_custom_theme['top_menu']['menu_label_fontcolor']))?$wpmm_custom_theme['top_menu']['menu_label_fontcolor']:'';
$menu_label_fontsize = (isset($wpmm_custom_theme['top_menu']['menu_label_fontsize']))?$wpmm_custom_theme['top_menu']['menu_label_fontsize']:'';
$menu_label_font_weight = (isset($wpmm_custom_theme['top_menu']['menu_label_font_weight']))?$wpmm_custom_theme['top_menu']['menu_label_font_weight']:'';
$menu_label_font_transform = (isset($wpmm_custom_theme['top_menu']['menu_label_font_transform']))?$wpmm_custom_theme['top_menu']['menu_label_font_transform']:'';
$menu_label_font_family = (isset($wpmm_custom_theme['top_menu']['menu_label_font_family']))?$wpmm_custom_theme['top_menu']['menu_label_font_family']:'';

/* megamenu bar settings*/
$enable_megamenu_background2 = (isset($wpmm_custom_theme['megamenu_bar']['enable_megamenu_background']))?'1':'0';
$menu_background_from2 = (isset($wpmm_custom_theme['megamenu_bar']['menu_background_from']))?$wpmm_custom_theme['megamenu_bar']['menu_background_from']:'#ffffff';
$width2 = (isset($wpmm_custom_theme['megamenu_bar']['width']))?$wpmm_custom_theme['megamenu_bar']['width']:'100%';
$padding_top2 = (isset($wpmm_custom_theme['megamenu_bar']['padding_top']))?$wpmm_custom_theme['megamenu_bar']['padding_top']:'15px';
$padding_bottom2 = (isset($wpmm_custom_theme['megamenu_bar']['padding_bottom']))?$wpmm_custom_theme['megamenu_bar']['padding_bottom']:'5px';
$padding_left2 = (isset($wpmm_custom_theme['megamenu_bar']['padding_left']))?$wpmm_custom_theme['megamenu_bar']['padding_left']:'8px';
$padding_right2 = (isset($wpmm_custom_theme['megamenu_bar']['padding_right']))?$wpmm_custom_theme['megamenu_bar']['padding_right']:'8px';
$border_color2 = (isset($wpmm_custom_theme['megamenu_bar']['border_color']))?$wpmm_custom_theme['megamenu_bar']['border_color']:'0px';
$border_radius2 = (isset($wpmm_custom_theme['megamenu_bar']['border_radius']))?$wpmm_custom_theme['megamenu_bar']['border_radius']:'#ffffff';
$box_shadow2 = (isset($wpmm_custom_theme['megamenu_bar']['box_shadow']))?$wpmm_custom_theme['megamenu_bar']['box_shadow']:'0 3px 3px';
$box_shadow_color2 = (isset($wpmm_custom_theme['megamenu_bar']['box_shadow_color']))?$wpmm_custom_theme['megamenu_bar']['box_shadow_color']:'rgba(0, 0, 0, 0.2)';

/* widget settings */
$font_color3 = (isset($wpmm_custom_theme['widgets']['font_color']))?$wpmm_custom_theme['widgets']['font_color']:'#00000';
$font_hover_color3 = (isset($wpmm_custom_theme['widgets']['font_hover_color']))?$wpmm_custom_theme['widgets']['font_hover_color']:'#00000';
$font_size3 = (isset($wpmm_custom_theme['widgets']['font_size']))?$wpmm_custom_theme['widgets']['font_size']:'14px';
$font_weight3 = (isset($wpmm_custom_theme['widgets']['font_weight']))?$wpmm_custom_theme['widgets']['font_weight']:'bold';
$font_weight_hover3 = (isset($wpmm_custom_theme['widgets']['font_weight_hover']))?$wpmm_custom_theme['widgets']['font_weight_hover']:'bold';
$transform3 = (isset($wpmm_custom_theme['widgets']['transform']))?$wpmm_custom_theme['widgets']['transform']:'bold';
$font_family3 = (isset($wpmm_custom_theme['widgets']['font_family']))?$wpmm_custom_theme['widgets']['font_family']:'bold';
$font_decoration3 = (isset($wpmm_custom_theme['widgets']['font_decoration']))?$wpmm_custom_theme['widgets']['font_decoration']:'none';
$font_decoration_hover3 = (isset($wpmm_custom_theme['widgets']['font_decoration_hover']))?$wpmm_custom_theme['widgets']['font_decoration_hover']:'none';
$content_font_color3 = (isset($wpmm_custom_theme['widgets']['content_font_color']))?$wpmm_custom_theme['widgets']['content_font_color']:'#00000';
$content_font_size3 = (isset($wpmm_custom_theme['widgets']['content_font_size']))?$wpmm_custom_theme['widgets']['content_font_size']:'13px';
$content_font_family3 = (isset($wpmm_custom_theme['widgets']['content_font_family']))?$wpmm_custom_theme['widgets']['content_font_family']:'Open Sans';
$margin_top3 = (isset($wpmm_custom_theme['widgets']['margin_top']))?$wpmm_custom_theme['widgets']['margin_top']:'0px';
$margin_bottom3 = (isset($wpmm_custom_theme['widgets']['margin_bottom']))?$wpmm_custom_theme['widgets']['margin_bottom']:'10px';


/* Top Section settings */
$font_color4 = (isset($wpmm_custom_theme['top_section']['font_color']))?$wpmm_custom_theme['top_section']['font_color']:'#000000';
$font_size4 = (isset($wpmm_custom_theme['top_section']['font_size']))?$wpmm_custom_theme['top_section']['font_size']:'13px';
$font_weight4 = (isset($wpmm_custom_theme['top_section']['font_weight']))?$wpmm_custom_theme['top_section']['font_weight']:'normal';
$transform4 = (isset($wpmm_custom_theme['top_section']['transform']))?$wpmm_custom_theme['top_section']['transform']:'normal';
$font_family4 = (isset($wpmm_custom_theme['top_section']['font_family']))?$wpmm_custom_theme['top_section']['font_family']:'Open Sans';
$image_margin_top4 = (isset($wpmm_custom_theme['top_section']['image_margin_top']))?$wpmm_custom_theme['top_section']['image_margin_top']:'0px';
$image_margin_bottom4 = (isset($wpmm_custom_theme['top_section']['image_margin_bottom']))?$wpmm_custom_theme['top_section']['image_margin_bottom']:'10px';
$image_margin_left4 = (isset($wpmm_custom_theme['top_section']['image_margin_left']))?$wpmm_custom_theme['top_section']['image_margin_left']:'0px';
$image_margin_right4 = (isset($wpmm_custom_theme['top_section']['image_margin_right']))?$wpmm_custom_theme['top_section']['image_margin_right']:'0px';
 

/* Bottom Section settings */
$font_color5 = (isset($wpmm_custom_theme['bottom_section']['font_color']))?$wpmm_custom_theme['bottom_section']['font_color']:'#000000';
$font_size5 = (isset($wpmm_custom_theme['bottom_section']['font_size']))?$wpmm_custom_theme['bottom_section']['font_size']:'13px';
$font_weight5 = (isset($wpmm_custom_theme['bottom_section']['font_weight']))?$wpmm_custom_theme['bottom_section']['font_weight']:'normal';
$transform5 = (isset($wpmm_custom_theme['bottom_section']['transform']))?$wpmm_custom_theme['bottom_section']['transform']:'normal';
$font_family5 = (isset($wpmm_custom_theme['bottom_section']['font_family']))?$wpmm_custom_theme['bottom_section']['font_family']:'Open Sans';
$image_margin_top5 = (isset($wpmm_custom_theme['bottom_section']['image_margin_top']))?$wpmm_custom_theme['bottom_section']['image_margin_top']:'10px';
$image_margin_bottom5 = (isset($wpmm_custom_theme['bottom_section']['image_margin_bottom']))?$wpmm_custom_theme['bottom_section']['image_margin_bottom']:'0px';
$image_margin_left5 = (isset($wpmm_custom_theme['bottom_section']['image_margin_left']))?$wpmm_custom_theme['bottom_section']['image_margin_left']:'0px';
$image_margin_right5 = (isset($wpmm_custom_theme['bottom_section']['image_margin_right']))?$wpmm_custom_theme['bottom_section']['image_margin_right']:'0px';


/* Flyout settings */
$enable_background6 = (isset($wpmm_custom_theme['flyout']['enable_background']))?'1':'0';
$menu_bgcurrentcolor6 = (isset($wpmm_custom_theme['flyout']['menu_bgcurrentcolor']))?$wpmm_custom_theme['flyout']['menu_bgcurrentcolor']:'#5ec073';
$menu_bg_hovercolor6 = (isset($wpmm_custom_theme['flyout']['menu_bg_hovercolor']))?$wpmm_custom_theme['flyout']['menu_bg_hovercolor']:'#47a35b';
$font_color6 = (isset($wpmm_custom_theme['flyout']['font_color']))?$wpmm_custom_theme['flyout']['font_color']:'#ffffff';
$font_hover_color6 = (isset($wpmm_custom_theme['flyout']['font_hover_color']))?$wpmm_custom_theme['flyout']['font_hover_color']:'#ffffff';
$font_size6 = (isset($wpmm_custom_theme['flyout']['font_size']))?$wpmm_custom_theme['flyout']['font_size']:'12px';
$font_weight6 = (isset($wpmm_custom_theme['flyout']['font_weight']))?$wpmm_custom_theme['flyout']['font_weight']:'normal';
$font_weight_hover6 = (isset($wpmm_custom_theme['flyout']['font_weight_hover']))?$wpmm_custom_theme['flyout']['font_weight_hover']:'normal';
$transform6 = (isset($wpmm_custom_theme['flyout']['transform']))?$wpmm_custom_theme['flyout']['transform']:'#5ec073';
$font_family6 = (isset($wpmm_custom_theme['flyout']['font_family']))?$wpmm_custom_theme['flyout']['font_family']:'Open Sans';
$font_decoration6 = (isset($wpmm_custom_theme['flyout']['font_decoration']))?$wpmm_custom_theme['flyout']['font_decoration']:'none';
$font_decoration_hover6 = (isset($wpmm_custom_theme['flyout']['font_decoration_hover']))?$wpmm_custom_theme['flyout']['font_decoration_hover']:'none';
$item_margin6 = (isset($wpmm_custom_theme['flyout']['item_margin']))?$wpmm_custom_theme['flyout']['item_margin']:'0px 5px';
$item_padding6 = (isset($wpmm_custom_theme['flyout']['item_padding']))?$wpmm_custom_theme['flyout']['item_padding']:'10px';
$item_width6 = (isset($wpmm_custom_theme['flyout']['item_width']))?$wpmm_custom_theme['flyout']['item_width']:'210px';


/* Mobile settings */
$togglebar_enable_bgcolor = (isset($wpmm_custom_theme['mobile_settings']['togglebar_enable_bgcolor']))?'1':'0';
$togglebar_background_from = (isset($wpmm_custom_theme['mobile_settings']['togglebar_background_from']))?$wpmm_custom_theme['mobile_settings']['togglebar_background_from']:'#5ec073';
$togglebar_height = (isset($wpmm_custom_theme['mobile_settings']['togglebar_height']))?$wpmm_custom_theme['mobile_settings']['togglebar_height']:'40px';
$resposive_breakpoint_width = (isset($wpmm_custom_theme['mobile_settings']['resposive_breakpoint_width']))?$wpmm_custom_theme['mobile_settings']['resposive_breakpoint_width']:'910px';
$toggle_bar_content = (isset($wpmm_custom_theme['mobile_settings']['toggle_bar_content']))?$wpmm_custom_theme['mobile_settings']['toggle_bar_content']:'Menu';
$icon_color = (isset($wpmm_custom_theme['mobile_settings']['icon_color']))?$wpmm_custom_theme['mobile_settings']['icon_color']:'#ffffff';
$text_color = (isset($wpmm_custom_theme['mobile_settings']['text_color']))?$wpmm_custom_theme['mobile_settings']['text_color']:'#ffffff';
$togglebar_align = (isset($wpmm_custom_theme['mobile_settings']['togglebar_align']))?$wpmm_custom_theme['mobile_settings']['togglebar_align']:'left';
$submenu_closebtn_position = (isset($wpmm_custom_theme['mobile_settings']['submenu_closebtn_position']))?$wpmm_custom_theme['mobile_settings']['submenu_closebtn_position']:'bottom';
$submenus_retractor_text = (isset($wpmm_custom_theme['mobile_settings']['submenus_retractor_text']))?$wpmm_custom_theme['mobile_settings']['submenus_retractor_text']:'CLOSE';


/* Search Bar settings */
$font_size7 = (isset($wpmm_custom_theme['search_bar']['font_size']))?$wpmm_custom_theme['search_bar']['font_size']:'10px';
$width7 = (isset($wpmm_custom_theme['search_bar']['width']))?$wpmm_custom_theme['search_bar']['width']:'182px';
$text_color7 = (isset($wpmm_custom_theme['search_bar']['text_color']))?$wpmm_custom_theme['search_bar']['text_color']:'#fffff';
$bg_color7 = (isset($wpmm_custom_theme['search_bar']['bg_color']))?$wpmm_custom_theme['search_bar']['bg_color']:'#5ec073';
$text_placholder_color7 = (isset($wpmm_custom_theme['search_bar']['text_placholder_color']))?$wpmm_custom_theme['search_bar']['text_placholder_color']:'#ccc';
$icon_color7 = (isset($wpmm_custom_theme['search_bar']['icon_color']))?$wpmm_custom_theme['search_bar']['icon_color']:'#fffff';


$theme_slug = '.wpmega-'.$menuthemes->slug;   
$fonts =  $font_family;
$fonts1 = $font_family3; 
$fonts2 = $font_family4; 
$fonts3 = $font_family5; 
$fonts4 = $font_family6; 
 
$fonts_final = str_replace(' ', '+', $fonts);         
$fonts_final1 = str_replace(' ', '+', $fonts1);         
$fonts_final2 = str_replace(' ', '+', $fonts2);         
$fonts_final3 = str_replace(' ', '+', $fonts3);         
$fonts_final4 = str_replace(' ', '+', $fonts4); 
        
?>

<link rel='stylesheet' id='edn-google-fonts-style-css' href='//fonts.googleapis.com/css?family=<?php echo $fonts_final;?>' type='text/css' media='all' /> 
<link rel='stylesheet' id='edn-google-fonts-style-css' href='//fonts.googleapis.com/css?family=<?php echo $fonts_final1;?>' type='text/css' media='all' /> 
<link rel='stylesheet' id='edn-google-fonts-style-css' href='//fonts.googleapis.com/css?family=<?php echo $fonts_final2;?>' type='text/css' media='all' /> 
<link rel='stylesheet' id='edn-google-fonts-style-css' href='//fonts.googleapis.com/css?family=<?php echo $fonts_final3;?>' type='text/css' media='all' /> 
<link rel='stylesheet' id='edn-google-fonts-style-css' href='//fonts.googleapis.com/css?family=<?php echo $fonts_final4;?>' type='text/css' media='all' /> 
<style>
/*#wpmm-wrap-primary{
	display: none;
}*/
<?php if($enable_menu_background == 1){?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal,
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical{
background: <?php echo $menu_background_from;?>;

}
<?php }else{?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal,
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical{
background: #5ec073;

}
<?php }?>
/* a tag small line on before tag */
.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-sub-menu-wrap ul li h4.wpmm-mega-block-title::before, 
.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-sub-menu-wrap ul li.wp-mega-menu-header > a.wp-mega-menu-link::before {
	background:  <?php echo $menu_background_from;?>;
	bottom: 0;
    content: "";
    height: 1px;
    position: absolute;
    width: 30px;
}


<?php if($border_radius_topleft != '' || $margin_top !='' || $margin_bottom!=''){?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal,
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical{
border-radius: <?php echo $border_radius_topleft;?> <?php echo $border_radius_topright;?> <?php echo $border_radius_bottomright ;?> <?php echo $border_radius_bottomleft;?>;
<?php if($border_color != ''){?>
border: 1px solid <?php echo $border_color ?>;
<?php } ?>
margin-top: <?php echo $margin_top;?>;
margin-bottom: <?php echo $margin_bottom;?>;

}
<?php } ?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal ul.wpmm-mega-wrapper{
text-align: <?php echo $alignment;?>;	
}

<?php if($width != ''){?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal{
	width: <?php echo $width;?>;
}
<?php } ?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal ul.wpmm-mega-wrapper > li > a, 
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical ul.wpmm-mega-wrapper > li > a{
color: <?php echo $font_color;?>;
}


.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal ul.wpmm-mega-wrapper > li > a,
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical ul.wpmm-mega-wrapper > li > a{
<?php if($font_size != '' && $font_size != '0px'){ ?>font-size: <?php echo $font_size;?>; <?php } ?>
<?php if($font_family != ''){ ?>font-family: <?php echo $font_family;?>;<?php } ?>
<?php if($font_weight != ''){ ?>font-weight: <?php echo $font_weight;?>;<?php } ?>
<?php if($line_height != ''){ ?>line-height: <?php echo $line_height;?>;<?php } ?>
<?php if($transform != ''){ ?>text-transform: <?php echo $transform;?>;<?php } ?>
<?php if($font_decoration1 != ''){ ?>text-decoration: <?php echo $font_decoration1;?>;<?php } ?>
}

<?php if($padding_top != '0px' && $padding_right != '0px' && $padding_bottom != '0px' && $padding_left != '0px'){?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal ul.wpmm-mega-wrapper > li > a{
padding: <?php echo $padding_top;?> <?php echo $padding_right;?> <?php echo $padding_bottom;?> <?php echo $padding_left;?>;
}
<?php } ?>

<?php if($enable_background_hover1 == 1){?>
	.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal ul.wpmm-mega-wrapper > li:hover,
	.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical ul.wpmm-mega-wrapper > li:hover{
	background: <?php echo $background_hover_from1;?>;
}
<?php }?>

.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper > li:hover > a{
	font-weight: <?php echo $font_weight_hover1;?>;
	text-decoration: <?php echo $font_decoration_hover1;?>;
}

/*menu divider enable*/
<?php if($enable_menu_divider == 1){
	if($menu_divider_color != ''){?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal ul.wpmm-mega-wrapper > li > a::before{
  background: <?php echo $menu_divider_color;?>;
    opacity: <?php echo $opacity_glow;?>;
      content: "";
    height: 100%;
    position: absolute;
    right: 0;
    top: 0;
    width: 1px;	
 }
<?php } 
}?>

<?php if($bg_active_color1 != ''){?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-mega-wrapper > li.current-menu-item{
background: <?php echo $bg_active_color1;?>
}
<?php } ?>

.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-mega-wrapper > li.current-menu-item > a{
	color: <?php echo $font_color_active1;?> !important;
}

/*Mega menu */

<?php if($enable_megamenu_background2 == 1){?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap,
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap{
background: <?php echo $menu_background_from2;?>;
}

<?php } ?>

.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap,
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap{
 width: <?php echo $width2;?>;
 padding-top:<?php echo $padding_top2;?>;
 padding-bottom:<?php echo $padding_bottom2;?>;
 padding-left:<?php echo $padding_left2;?>;
 padding-right: <?php echo $padding_right2;?>;
 border: 1px solid <?php echo $border_color2;?>;
 border-radius: <?php echo $border_radius2;?>;
 box-shadow: <?php echo $box_shadow2;?> <?php echo $box_shadow_color2;?>;
}

/*Widget section*/
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-sub-menu-wrap ul li h4.wpmm-mega-block-title, 
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-sub-menu-wrap ul li.wp-mega-menu-header > a.wp-mega-menu-link span.wpmm-mega-menu-href-title{
color: <?php echo $font_color3;?>;
font-size: <?php echo $font_size3;?>;
font-weight: <?php echo $font_weight3;?>;
text-transform: <?php echo $transform3;?>;
font-family: <?php echo $font_family3;?>;
text-decoration: <?php echo $font_decoration3;?>;
margin-bottom:<?php echo $margin_bottom3;?>;
margin-top:<?php echo $margin_top3;?>; 
}

.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-sub-menu-wrap ul li h4.wpmm-mega-block-title:hover, 
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-sub-menu-wrap ul li.wp-mega-menu-header > a.wp-mega-menu-link span.wpmm-mega-menu-href-title:hover{
color: <?php echo $font_hover_color3;?>;
font-weight: <?php echo $font_weight_hover3;?>;
text-decoration: <?php echo $font_decoration_hover3;?>;
cursor: pointer;

}

.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-sub-menu-wrap ul li {
   color: <?php echo $content_font_color3;?>;
   /*font-size: <?php echo $content_font_size3;?>;*/
   font-family: <?php echo $content_font_family3;?>;
}
.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper
 li .wpmm-sub-menu-wrap ul.wp-mega-sub-menu > li > a{
	color: <?php echo $content_font_color3;?>;
   font-family: <?php echo $content_font_family3;?>;
}
 .wpmm_megamenu .wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-sub-menu-wrap ul li{
	font-size: <?php echo $content_font_size3;?>;
}

  <?php if($content_font_color3 != ''){ ?>
  	 .wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li ul.wp-mega-sub-menu li div.woocommerce ul.products li a h3{
    color: <?php echo $content_font_color3;?>;
  }
  /*.wpmm_megamenu .wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .woocommerce ul.cart_list li a, .wpmm_megamenu .woocommerce ul.product_list_widget li a*/
  .wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li ul.wp-mega-sub-menu li div.woocommerce ul.products li a span.price ins,
   .wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li ul.wp-mega-sub-menu li div.woocommerce ul.products li a span.price .woocommerce-Price-amount{
color: <?php echo $content_font_color3;?>;
  }


.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu li .wpmm-sub-menu-wrapper.wpmm_menu_1 li::before, 
.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu .widget_pages li::before, 
.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu .widget_categories li::before,
 .wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu .widget_archive li::before, 
 .wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu .widget_meta li::before, 
 .wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu .widget_recent_comments li::before, 
 .wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu .widget_recent_entries li::before,
 .wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu .widget_product_categories ul.product-categories li a::before, 
 .wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu .widget_categories li::before, 
.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wp-mega-sub-menu .widget_archive li::before{
	color: <?php echo $content_font_color3;?>;
}
  	.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul ul li a:hover,
 .wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul ul li a,
  .wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul ul li a:focus{
color: <?php echo $content_font_color3;?>;
  }
  .wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wp-mega-sub-menu li.wpmm-custom-post-settings.wpmega-image-left .wpmm-custom-postimage span.wpmm-mega-menu-href-title, 
  .wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wp-mega-sub-menu li.wpmm-custom-post-settings.wpmega-image-top .wpmm-custom-postimage span.wpmm-mega-menu-href-title{
color: <?php echo $content_font_color3;?>;
  }

  <?php } ?>


/*
* Top Section Stylesheet
*/
.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap span.wpmm_megamenu_topcontent{
	font-size :<?php echo $font_size4;?>;
	color:<?php echo $font_color4;?>;
	font-family: <?php echo $font_family4;?>;
	font-weight: <?php echo $font_weight4;?>;
	text-transform: <?php echo $transform4;?>;
	margin-left: <?php echo  $image_margin_left4;?>;
	margin-right: <?php echo  $image_margin_right4;?>;
}

.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap .top_clearfix{
	margin-bottom: <?php echo  $image_margin_bottom4;?>;
	
}

.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap .wpmm-topimage{
    margin-left: <?php echo  $image_margin_left4;?>;
	margin-right: <?php echo  $image_margin_right4;?>;
	margin-top: <?php echo  $image_margin_top4;?>;
}

.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap .wpmm-ctop{
    margin-left: <?php echo  $image_margin_left4;?>;
	margin-right: <?php echo  $image_margin_right4;?>;
	margin-top: <?php echo  $image_margin_top4;?>;
}

/*
* Bottom Section stylhesheet
*/
.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap span.wpmm_megamenu_bottomcontent{
	font-size :<?php echo $font_size5;?>;
	color:<?php echo $font_color5;?>;
	font-family: <?php echo $font_family5;?>;
	font-weight: <?php echo $font_weight5;?>;
	text-transform: <?php echo $transform5;?>;
	margin-left: <?php echo  $image_margin_left5;?>;
	margin-right: <?php echo  $image_margin_right5;?>;
}

.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap .bottom_clearfix{
    margin-top: <?php echo  $image_margin_top5;?>;
}


.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap .wpmm-bottomimage{
    margin-left: <?php echo  $image_margin_left5;?>;
	margin-right: <?php echo  $image_margin_right5;?>;
	margin-bottom: <?php echo  $image_margin_bottom5;?>;
}

.wpmm_megamenu .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li .wpmm-sub-menu-wrap .wpmm-cbottom{
       margin-left: <?php echo  $image_margin_left5;?>;
       margin-right: <?php echo  $image_margin_right5;?>;
	   margin-bottom: <?php echo  $image_margin_bottom5;?>;
}


/*flyout*/
<?php if($enable_background6 == 1){ ?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li.wpmega-menu-flyout ul{
	background: <?php echo $menu_bgcurrentcolor6;?>;
}
<?php }?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li.wpmega-menu-flyout ul{
	width: <?php echo  $item_width6;?>;
}
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li.wpmega-menu-flyout ul.wp-mega-sub-menu li:hover > a {
	background: <?php echo  $menu_bg_hovercolor6;?>;
}
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li.wpmega-menu-flyout.wpmega-flyout-horizontal-left ul.wp-mega-sub-menu li{
	margin: <?php echo $item_margin6;?>;
}

.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li.wpmega-menu-flyout.wpmega-flyout-horizontal-left ul.wp-mega-sub-menu li a.wp-mega-menu-link {
	padding:<?php echo $item_padding6;?>;
}

.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li.wpmega-menu-flyout ul.wp-mega-sub-menu li a {
	color: <?php echo $font_color6;?>;
	font-size: <?php echo $font_size6;?>;
	font-weight: <?php echo $font_weight6;?>;
	text-transform: <?php echo $transform6;?>;
	font-family: <?php echo $font_family6;?>;
	text-decoration: <?php echo $font_decoration6;?>;
}

.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li.wpmega-menu-flyout ul.wp-mega-sub-menu li:hover a {
	color: <?php echo $font_hover_color6;?>;
	font-weight: <?php echo $font_weight_hover6;?>;
	text-decoration: <?php echo $font_decoration_hover6;?>;
}

/* search bar */
 .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper li.wpmm-menu-align-right.wpmm-search-type .wpmm-sub-menu-wrap
 .megamenu-type-search input.search-submit[type="submit"]{
 font-size: <?php echo $font_size7;?>;
 color: <?php echo $text_color7;?>;
 background: <?php echo $bg_color7;?>;
 }

  .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> ul.wpmm-mega-wrapper 
  li.wpmm-menu-align-right.wpmm-search-type .wpmm-sub-menu-wrap .megamenu-type-search input.search-field[type="search"]{
width: <?php echo $width7;?>;
color: <?php echo $text_placholder_color7;?>;
 }


<?php if($icon_color7 != '' ){?>
 .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-search-type  > .wpmm-mega-menu-icon > i.fa-search,
 .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-search-type  > .wpmm-mega-menu-icon > i.genericon-search,
 .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-search-type  > .wpmm-mega-menu-icon > i.dashicons-search{
  color:  <?php echo  $icon_color7;?>;

}
<?php }else{ ?>
 .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> a.wpmm-search-type > .wpmm-mega-menu-icon > i.fa-search,
 .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-search-type  > .wpmm-mega-menu-icon > i.genericon-search,
 .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-search-type  > .wpmm-mega-menu-icon > i.dashicons-search{
  color: <?php echo $font_color;?>;
}

<?php } ?>
 .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-mega-wrapper .wpmega-searchinline input.search-field{
  width: <?php echo $width7;?>;
}

/* menu label custom css */
<?php if($enable_menu_label_bgcolor == 1){ ?>
.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-mega-menu-label::before {
  	<?php if($menu_label_bgcolor != ''){ ?>
  border-color: <?php echo $menu_label_bgcolor;?> transparent transparent;
  <?php } ?>
}

.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-sub-menu-wrap ul.wp-mega-sub-menu li.wp-mega-menu-header a span.wpmm-mega-menu-label{
   <?php if($menu_label_fontsize != ''){ ?>
  font-size:<?php echo $menu_label_fontsize;?>px;
    <?php } ?>
  <?php if($menu_label_fontcolor != ''){ ?>
  color:<?php echo $menu_label_fontcolor;?>;
  <?php } ?>
}

.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmm-mega-menu-label {
	<?php if($menu_label_bgcolor != ''){ ?>
  background: <?php echo $menu_label_bgcolor;?>;
  <?php } ?>
  <?php if($menu_label_fontcolor != ''){ ?>
  color:<?php echo $menu_label_fontcolor;?>;
  <?php } ?>
    <?php if($menu_label_fontsize != ''){ ?>
  font-size:<?php echo $menu_label_fontsize;?>px;
    <?php } ?>
<?php if($menu_label_font_weight != ''){ ?>
  font-weight: <?php echo $menu_label_font_weight;?>;
   <?php } ?>
  <?php if($menu_label_font_transform != ''){ ?>
  text-transform: <?php echo $menu_label_font_transform;?>;
     <?php } ?>
  <?php if($menu_label_font_family != ''){?>
   font-family: <?php echo $menu_label_font_family;?>
  	<?php } ?>
}
<?php }?>


/*Mobile settings*/
<?php if($enable_mobile == 1){?>
@media (max-width: <?php echo $resposive_breakpoint_width;?>) {
	<?php if($togglebar_enable_bgcolor == 1){ ?>
			       .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal,
			       .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical{
			         background: <?php echo  $menu_bg_hovercolor6;?>;
			         
			      }
		<?php }else{ ?>
			.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-horizontal,
			       .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?>.wpmm-orientation-vertical{
			         background: #5ec073;
			      }

			<?php } ?>

		.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmegamenu-toggle{
			display: block !important;
			height: <?php echo $togglebar_height;?>;
			background: <?php echo $togglebar_background_from;?>;
			text-align:  <?php echo $togglebar_align;?>;
		}	

		.wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmegamenu-toggle .wpmega-closeblock{
            display: none;
		}

		.main-navigation button.menu-toggle{
			display: none;
		}
    <?php if($icon_color != ''){?>
      .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmegamenu-toggle .wpmega-openblock,
      .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .wpmegamenu-toggle .wpmega-closeblock{
         color: <?php echo  $icon_color;?>;
     }
     <?php } ?>
<?php if($text_color != ''){?>
     .wp-megamenu-main-wrapper.wpmm-ctheme-wrapper<?php echo $theme_slug;?> .close-primary{
     	 color: <?php echo $text_color;?>;
     }
 <?php } ?>
}
<?php } ?>
</style>



