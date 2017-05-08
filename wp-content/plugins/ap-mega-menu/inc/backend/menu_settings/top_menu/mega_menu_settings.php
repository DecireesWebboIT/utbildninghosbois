<?php defined('ABSPATH') or die("No script kiddies please!"); ?>

<div class="wpmm_mega_settings">
	
   <div class="wpmm_top_section">
    <div class="wpmm_selection_type">
    	<label for='wpmmmm_enable_mega_menu'><?php _e("Sub menu display mode",APMM_TD);?></label>
        <select id='wpmm_enable_mega_menu' name="wpmm_settings[menu_type]" class="wpmm-selection">
           <option value='flyout' <?php echo selected( $wpmmenu_item_meta['menu_type'], 'flyout', false );?>><?php _e("Flyout Menu", APMM_TD);?></option>
           <option id='wpmegamenu' value="megamenu" <?php echo selected( $wpmmenu_item_meta['menu_type'], 'megamenu', false );?>><?php _e("Mega Menu",APMM_TD);?></option>
        </select>
    </div>
    <div class="wpmm_row_selection">
    	<select id='wpmm_number_of_columns' name='wpmm_settings[panel_columns]' class="wpmm-selection">
           <option value='1' <?php echo selected( $wpmmenu_item_meta['panel_columns'], 1, false );?>>1 <?php _e('Columns',APMM_TD);?></option>
           <option value='2' <?php echo selected( $wpmmenu_item_meta['panel_columns'], 2, false );?>>2 <?php _e('Columns',APMM_TD);?></option>
           <option value='3' <?php echo selected( $wpmmenu_item_meta['panel_columns'], 3, false );?>>3 <?php _e('Columns',APMM_TD);?></option>
           <option value='4' <?php echo selected( $wpmmenu_item_meta['panel_columns'], 4, false );?>>4 <?php _e('Columns',APMM_TD);?></option>
           <option value='5' <?php echo selected( $wpmmenu_item_meta['panel_columns'], 5, false );?>>5 <?php _e('Columns',APMM_TD);?></option>
           <option value='6' <?php echo selected( $wpmmenu_item_meta['panel_columns'], 6, false );?>>6 <?php _e('Columns',APMM_TD);?></option>
           <option value='7' <?php echo selected( $wpmmenu_item_meta['panel_columns'], 7, false );?>>7 <?php _e('Columns',APMM_TD);?></option>
           <option value='8' <?php echo selected( $wpmmenu_item_meta['panel_columns'], 8, false );?>>8 <?php _e('Columns',APMM_TD);?></option>
        </select>
    </div>
    <div class="main_widget">
     	<div class="wpmm-add-widget-tool"><i class="fa fa-plus" aria-hidden="true"></i><?php _e('Add Widgets',APMM_TD);?></div>
	   	<div class="wpmm_widget_iframe" style="display:none;">
        <div class="wpmm_widgte_middle_content">
        <!-- left section widgets -->
          <div class="widget_left_section">
            <div class="widgetss_header"><?php _e('ALL WIDGETS',APMM_TD);?></div>
            <ul>
              <li><div class="wpmm_tabss active" id="wordpress_widgets"><?php _e('WORDPRESS WIDGETS',APMM_TD);?></div></li>
              <li><div class="wpmm_tabss" id="wpmm_widgets"><?php _e('AP MEGA MENU WIDGETS',APMM_TD);?></div></li>
              <li><div class="wpmm_tabss" id="wpmm_woocommercewidgets"><?php _e('WOOCOMMERCE WIDGETS',APMM_TD);?></div></li> 
            </ul>
          </div>
        <!-- right section widgets -->
          <div class="widget_right_section">

             <div class="btn_close_me">
              <div class="title_widget_add"><i class="fa fa-wrench" aria-hidden="true"></i><?php _e('ADD WIDGET SETTINGS',APMM_TD);?></div>
               <span><i class="fa fa-close" aria-hidden="true"></i>CLOSE</span>
             </div>

             <div class="right_middle_widgets">
                <div class="tab-panes" id="tabs_wordpress_widgets" style="display:none;">
                 <ul><?php 
                  $wpmm_widget_manager = new WPMM_Menu_Widget_Manager();
                  $all_widgets = $wpmm_widget_manager->wpmm_get_available_widgets();
                    foreach ($all_widgets as $key => $value) { ?>
                     <li class="wpmm_all_wp_widgets" data-value="<?php echo $value['value'];?>" data-text="<?php echo $value['text'];?>">
                       <div class="wpmm_widget-type-wrapper" style="height: 53px;">
                         <span class="wpmm_widget-icon dashicons dashicons-wordpress"></span>
                          <h3><?php echo $value['text'];?></h3>
                          <p class="widgets_description"><?php echo $value['description'];?></p>
                        </div>
                     </li>
                   <?php }
                  ?>
                 </ul>
                </div>
                <div class="tab-panes" id="tabs_wpmm_widgets" style="display:none;">
                   <ul>
                  <?php $wpmm_widget_manager = new WPMM_Menu_Widget_Manager();
                   $all_widgets = $wpmm_widget_manager->wpmm_get_specific_widgets();
                    foreach ($all_widgets as $key => $value) { ?>
                     <li class="wpmm_all_wp_widgets" data-value="<?php echo $value['value'];?>" data-text="<?php echo $value['text'];?>">
                       <div class="wpmm_widget-type-wrapper" style="height: 53px;">
                         <span class="wpmm_widget-icon dashicons dashicons-wordpress"></span>
                          <h3><?php echo $value['text'];?></h3>
                          <p class="widgets_description"><?php echo $value['description'];?></p>
                        </div>
                     </li>
                   <?php }
                  ?>
                 </ul>
                </div>
                   <div class="tab-panes" id="tabs_wpmm_woocommercewidgets" style="display:none;">
                   <ul>
                  <?php $wpmm_widget_manager = new WPMM_Menu_Widget_Manager();
                   $all_widgets = $wpmm_widget_manager->wpmm_get_woo_widgets();
                    foreach ($all_widgets as $key => $value) { ?>
                     <li class="wpmm_all_wp_widgets" data-value="<?php echo $value['value'];?>" data-text="<?php echo $value['text'];?>">
                       <div class="wpmm_widget-type-wrapper" style="height: 53px;">
                         <span class="wpmm_widget-icon dashicons dashicons-wordpress"></span>
                          <h3><?php echo $value['text'];?></h3>
                          <p class="widgets_description"><?php echo $value['description'];?></p>
                        </div>
                     </li>
                   <?php }
                  ?>
                 </ul>
                </div>

             </div>

          </div>
        </div>
	   		
	   	</div>
      </div>
   </div>

<?php 
if(isset($wpmmenu_item_meta['menu_type'])){
 if($wpmmenu_item_meta['menu_type'] == "megamenu"){
  $class = "enabled_megamenu";
 }else{
  $class = "disabled";
 }
}else{
  $class = "disabled";
}
?>
  <div class="wpmm_add_components <?php echo $class;?>">
          <div id="wpmm_widgets_setup" class="<?php echo $class;?>" data-columns="<?php echo (!isset($wpmmenu_item_meta['panel_columns']) && $wpmmenu_item_meta['panel_columns'] == '')?'6':$wpmmenu_item_meta['panel_columns'];?>">
           
         <?php 

            $widgets_items = new WPMM_Menu_Widget_Manager();
            $items = $widgets_items->wpmm_get_widgets_and_menu_items_for_menu_id($menu_item_id, $menu_id);
            if(isset($items)){
              foreach ($items as $item) { ?>
                <div class="wpmm_widget_area" data-title="<?php echo esc_attr( $item['title'] );?>" 
                data-columns="<?php echo esc_attr( $item['columns'] );?>" 
                data-type="<?php echo esc_attr( $item['type'] );?>"
                 data-id="<?php echo esc_attr( $item['id'] );?>">
                <div class="widget_main_top_section">
                <div class="widget_title">
                <span><i class="fa fa-arrows" aria-hidden="true"></i></span>
                <span class="wptitle"><?php echo esc_html( $item['title'] );?></div></span>
                <div class="widget_right_action">
                <a class="widget-option wpmm_widget-contract" title="<?php echo esc_attr( __("Contract",APMM_TD) );?>">
                <i class="fa fa-caret-left" aria-hidden="true"></i></a>
                <span class="widget-cols">
                <span class="wpmm_widget-num-cols"><?php echo esc_attr( $item['columns'] );?></span>
                <span class="wpmm_widget-of">/</span>
                <span class="wpmm_widget-total-cols"><?php echo (!isset($wpmmenu_item_meta['panel_columns']) && $wpmmenu_item_meta['panel_columns'] == '')?'6':$wpmmenu_item_meta['panel_columns'];?></span>
                </span>
                <a class="widget-option wpmm_widget-expand" title="<?php echo esc_attr( __("Expand", APMM_TD) );?>">
                <i class="fa fa-caret-right" aria-hidden="true"></i></a>
                <a class="widget-option wpmm_widget-action" title="<?php echo esc_attr( __("Edit",APMM_TD) );?>">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                </div>
                </div>
                <div class="wpmm_widget_inner"></div>
                </div>
               
             <?php  }
            }else{ ?>
                 <span class="message"><?php _e("No widgets found. Add a widget to this area using the ADD Widget Button (top right).",APMM_TD); ?></span>
            <?php }
             ?>

         </div>
  </div> 


</div>