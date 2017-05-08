<?php defined('ABSPATH') or die("No script kiddies please!");
$theme_object = new AP_Theme_Settings();
$custom_theme = $theme_object->get_custom_theme_data('');
?>
<div class="apmm-settings-main-wrapper apmm_theme_settings">
	<div class="apmm-header">
	<?php include_once(APMM_PATH.'/inc/backend/panel_head.php');?>
    </div>

    <?php if(isset($_SESSION['apmm_error'])){ ?>
        <div class="notice notice-error apmm-message">
			<p><?php echo $_SESSION['apmm_error'];unset($_SESSION['apmm_error']);?></p>
		</div>
    <?php } ?>
      <?php if(isset($_SESSION['apmm_success'])){ ?>
         <div class="notice notice-success apmm-message">
			<p><?php echo $_SESSION['apmm_success'];unset($_SESSION['apmm_success']);?></p>
		 </div>
    <?php } ?>

		<div class="container apmm-tab-container">
		    <div class="row">
		      <div  class="col-sm-12">
		       <div class="top_row_section">
                <div class="apmm_list_title"><?php _e('THEME LISTS',APMM_TD);?></div>
		        <div class="apmm_button_section">
		        <a href="<?php echo admin_url() . 'admin.php?page=wpmm-add-theme' ?>" class="button-primary"><?php _e('Create New Theme',APMM_TD);?></a>
		        </div>
		        </div>
		        <div class="clear"></div>
			        <table class="wp-list-table widefat fixed posts">
                    <thead>
                        <tr>
                            <th scope="col" id="title" class="manage-column column-title sortable asc" style="">
                                <a href="javascript:void(0)"> <span><?php _e('Theme Title', APMM_TD); ?></span> </a>
                            </th>
                           <!--  <th scope="col" id="title" class="manage-column column-title sortable asc" style="">
                                <a href="javascript:void(0)"><span><?php _e('Menu Location', APMM_TD); ?></span></a>
                            </th> -->
                             <th scope="col" id="template-shortcode" class="manage-column column-title sortable asc" style="">
                                <a href="javascript:void(0)"><span><?php _e('Last Modified', APMM_TD); ?></span></a>
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                             <th scope="col" class="manage-column column-title sortable asc" style=""><a href="javascript:void(0)"><span><?php _e('Theme Title', APMM_TD); ?></span></a></th>
                             <!-- <th scope="col" id="title" class="manage-column column-title sortable asc" style=""><a href="javascript:void(0)"><span><?php _e('Menu Location', APMM_TD); ?></span></a></th> -->
                             <th scope="col" id="template-shortcode" class="manage-column column-title sortable asc" style=""><a href="javascript:void(0)"><span><?php _e('Last Modified', APMM_TD); ?></span></a></th>
                        </tr>

                    </tfoot>

                    <tbody id="the-list" data-wp-lists="list:post">
                    <?php       $edit_nonce = wp_create_nonce('wpmm-edit-nonce');
                                $delete_nonce = wp_create_nonce('wpmm-delete-nonce');
                                $copy_nonce = wp_create_nonce('wpmm-copy-nonce');
                                
                    if(isset($custom_theme) && is_array($custom_theme) && !empty($custom_theme)){
                        foreach ($custom_theme as $key => $value) {
                         ?>
                                <tr>
                                    <td class="title column-title">
                                        <strong>
                                            <a class="row-title" href="<?php echo admin_url() . 'admin.php?page=wpmm-add-theme&action=edit_theme&theme_id=' . $value->theme_id . '&_wpnonce=' . $edit_nonce; ?>" title="Edit">
                                             <?php echo $value->title;?>
                                            </a>
                                        </strong>
                                        <div class="row-actions">
                                             <span class="edit"><a href="<?php echo admin_url() . 'admin.php?page=wpmm-add-theme&action=edit_theme&theme_id=' . $value->theme_id . '&_wpnonce=' . $edit_nonce; ?>"><?php _e('Edit', APMM_TD); ?></a> | </span>
                                            <span class="copy"><a href="<?php echo admin_url() . 'admin-post.php?action=wpmm_copy_action&theme_id=' . $value->theme_id . '&_wpnonce=' . $copy_nonce; ?>" onclick="return confirm('<?php _e('Are you sure you want to copy this theme?', APMM_TD); ?>')"><?php _e('Copy', APMM_TD); ?></a> | </span>
                                            <span class="delete"><a href="<?php echo admin_url() . 'admin-post.php?action=wpmm_delete_action&theme_id=' . $value->theme_id . '&_wpnonce=' . $delete_nonce; ?>" onclick="return confirm('<?php _e('Are you sure you want to delete this theme?', APMM_TD); ?>')"><?php _e('Delete', APMM_TD); ?></a></span>
                                        </div>
                                    </td>
                                    <td class="shortcode column-shortcode"><?php echo date( 'H:i:s A M jS, Y ', strtotime( $value->modified ) ); ?></td>
                                </tr>
                           <?php } }else{ ?>
                        <tr><td>No any data found.</td><td></td><td></td></tr>
                        <?php    }?>     
                    </tbody>
                </table>

		      </div>
		      </div>

		</div>  
    
    
</div>
<?php include_once(APMM_PATH.'/inc/backend/sidebar-right.php');?>

