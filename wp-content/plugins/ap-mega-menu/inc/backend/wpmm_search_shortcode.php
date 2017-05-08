<?php  defined('ABSPATH') or die("No script kiddies please!"); ?>
<?php
/**
* Add Search icon with form in header layout three
**/
// $headerlayout = get_theme_mod('storevilla_pro_header_type','layoutone');
// if($headerlayout == 'headerthree'){
// if ( ! function_exists( 'storevilla_pro_add_search_icon_nav_menu_items' ) ) {
// function storevilla_pro_add_search_icon_nav_menu_items($items, $args) {
//    if( $args->theme_location == 'primary' ){
//  	$searchlink = '<div class="search-icon">
//   <i class="fa fa-search"></i>
//   <div class="svilla-search">
//       <div class="close">×</div>
//    	<div class="overlay-search">'. storevilla_product_search() .'</div> 
//   </div><!-- .svilla-search -->
// </div>';
//  	$items = $items.$searchlink;
//  	return $items;
//    }
// }
// }
// add_filter( 'wp_nav_menu_items', 'storevilla_pro_add_search_icon_nav_menu_items', 10, 2 );
// $array = array('inline-search','popup-search-form');
//use shortcode
$template_type = (isset($atts['template_type']))?$atts['template_type']:'inline-search';
if($template_type == "inline-search"){
$style = (isset($atts['style']))?$atts['style']:'inline-toggle-left'; //inline-toggle-left or inline-toggle-right
}else{
$style = '';
}
?>
<?php if($template_type == "inline-search"){?>
  <div class="wpmm-search-icon <?php echo $template_type;?> <?php echo $style;?>">
   		<?php echo get_search_form($echo = true); ?>
  </div>
<?php }else if($template_type == "megamenu-type-search"){?>
  <div class="wpmm-search-icon <?php echo $template_type;?> <?php echo $style;?>">
      <?php echo get_search_form($echo = true); ?>
  </div>
<?php }
else if($template_type == "popup-search-form"){?>
<div class="wpmm-search-icon <?php echo $template_type;?>">
  <i class="fa fa-search"></i>
  <div class="wpmm-search">
      <div class="close">×</div>
   	<div class="wpmm-overlay-search">
   		<?php echo get_search_form($echo = true); ?>
   	</div> 
  </div>
</div>

<?php } ?>

