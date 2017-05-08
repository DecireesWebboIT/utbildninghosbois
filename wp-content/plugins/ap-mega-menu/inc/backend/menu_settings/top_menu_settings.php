<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<?php 
// echo $menu_item_id;
// echo "<br/>";
// echo $menu_id;
// echo "<br/>";
// echo $menu_item_title;
// echo "<br/>";
// echo $menu_item_depth;
?>

<div class="wpmm_main_container" id="wpmm_menu_<?php echo $menu_item_id;?>" data-depth="depth_<?php echo $menu_item_depth;?>">
	<div class="wpmm_main_header">
	<div class="settings_megamenu"><i class="fa fa-wrench" aria-hidden="true"></i><?php echo APMM_TITLE;?> SETTINGS</div>
	 <span class="wpmm_menu_title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo (isset($menu_item_title) && $menu_item_title != '')?$menu_item_title:'';?></span>
	 <div class="save_ajax_data" style="display:none;"><img src='<?php echo APMM_IMG_DIR;?>/ajaxloader.gif'/><span class="saving_message"></span></div>
	</div>
	<div class="wpmm_secondary_content">
	  <div class="tabs_left_section">
      	<ul>
      	  <li><div class="wpmm_tabs active" id="wp_mega_menu"><?php _e('AP Mega Menu Settings',APMM_TD);?></div></li>
      	  <li><div class="wpmm_tabs" id="general_settings"><?php _e('General Settings',APMM_TD);?></div></li>
      	  <li><div class="wpmm_tabs" id="megamenu_settings"><?php _e('Mega Menu Settings',APMM_TD);?></div></li>
      	  <li><div class="wpmm_tabs" id="flyout_settings"><?php _e('Flyout Settings',APMM_TD);?></div></li>
      	  <li><div class="wpmm_tabs" id="replacement_settings"><?php _e('Menu Replacement Settings',APMM_TD);?></div></li>
      	  <li><div class="wpmm_tabs" id="icon_settings"><?php _e('Icon Settings',APMM_TD);?></div></li>

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
			
			<div class="tab-pane" id="tab_wp_mega_menu" style="display:none;">
	        	<?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/mega_menu_settings.php'); ?>
	        </div>
	          <div class="tab-pane" id="tab_general_settings" style="display:none;">
	        	<?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/general_settings.php'); ?>
	        </div>
	         <div class="tab-pane" id="tab_megamenu_settings" style="display:none;"> 
	        	<?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/megamenu_settings.php'); ?>
	        </div>
	         <div class="tab-pane" id="tab_flyout_settings" style="display:none;"> 
	        	<?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/flyout_settings.php'); ?>
	        </div>
	        <div class="tab-pane" id="tab_replacement_settings" style="display:none;"> 
	        	<?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/replacement_settings.php'); ?>
	        </div>
	        <div class="tab-pane" id="tab_icon_settings" style="display:none;"> 
	        	<?php include(APMM_PATH.'inc/backend/menu_settings/top_menu/icon_settings.php'); ?>
	        </div> 

	        <div class="main_submit_section" style="display:none;">
	        	<?php echo get_submit_button();?>
	        </div>
	       
          
		  </form>
	</div>
	</div>


</div>
