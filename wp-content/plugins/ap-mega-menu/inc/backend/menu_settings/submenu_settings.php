<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<?php 
// echo $menu_item_id;
// echo "<br/>";
// echo $menu_id;
// echo "<br/>";
// echo $menu_item_title;
// echo "<br/>";
// echo $menu_item_depth;
// echo APMM_TD;
?>

<div class="wpmm_main_container" id="wpmm_menu_<?php echo $menu_item_id;?>" data-depth="depth_<?php echo $menu_item_depth;?>">
	<div class="wpmm_main_header">
	  <div class="settings_megamenu"><i class="fa fa-wrench" aria-hidden="true"></i><?php echo APMM_TITLE;?> SETTINGS</div> 
	 <span class="wpmm_menu_title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo (isset($menu_item_title) && $menu_item_title != '')?$menu_item_title:'';?>
	 
	 </span>
	 <p class="description wpmm_note"><?php _e('Mega Menus can only be created on top level menu items.',APMM_TD);?></p>
	<div class="save_ajax_data" style="display:none;"><img src='<?php echo APMM_IMG_DIR;?>/ajaxloader.gif'/><span class="saving_message"></span></div>
	</div>
	<div class="wpmm_secondary_content">
      <div class="tabs_left_section">
        <ul>
      	  <li><div class="wpmm_tabs active" id="submenu_settings"><?php _e('SubMenu Settings',APMM_TD);?></div></li>
      	  <li><div class="wpmm_tabs" id="sub_icon_settings"><?php _e('Icon Settings',APMM_TD);?></div></li>
      	  <li><div class="wpmm_tabs" id="upload_settings"><?php _e('Custom Settings',APMM_TD);?></div></li>
          <li><div class="wpmm_tabs" id="image_settings"><?php _e('Image Settings',APMM_TD);?></div></li>
      	</ul>
      </div>
      <div class="wpmm_content_rtsection">
       <form action="" method="post">
         <input type="hidden" name="action" value="wpmm_save_menuitem_settings" />
	     <input type="hidden" name="wpmm_menu_item_id" value="<?php echo (isset($menu_item_id) && $menu_item_id != '')?$menu_item_id:'';?>" />
       <input type="hidden" name="wpmm_menu_id" value="<?php echo (isset($menu_id) && $menu_id != '')?$menu_id:'';?>" />
       <input type="hidden" name="wpmm_menu_item_title" value="<?php echo (isset($menu_item_title) && $menu_item_title != '')?$menu_item_title:'';?>" />
       <input type="hidden" name="wpmm_menu_item_depth" value="<?php echo (isset($menu_item_depth) && $menu_item_depth != '')?$menu_item_depth:'';?>" />
            <?php $nonce = wp_create_nonce('apmm-ajax-nonce'); ?>
             <input type="hidden" name="_wpnonce" value="<?php echo $nonce;?>" />
	    <div class="tab-pane" id="tab_submenu_settings" style="display:none;">
        	<?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/general_settings.php'); ?>
        </div>
          <div class="tab-pane" id="tab_sub_icon_settings" style="display:none;"> 
        	<?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/icon_settings.php'); ?>
        </div>
        <div class="tab-pane" id="tab_upload_settings" style="display:none;">
        	<?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/upload_image_settings.php'); ?>
        </div>
        <div class="tab-pane" id="tab_image_settings" style="display:none;">
          <?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/sub_image_settings.php'); ?>
        </div>


       <div class="main_submit_section">
                  <?php echo get_submit_button();?>
       </div>
	  </form>
	</div>


</div>
