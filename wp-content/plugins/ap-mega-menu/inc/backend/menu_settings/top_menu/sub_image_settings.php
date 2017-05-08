  <div class="settings_title"><h4><?php _e('Image Settings',APMM_TD);?></h4></div>
  
<?php 
$image_size = (isset($wpmmenu_item_meta['upload_image_settings']['image_size'])?$wpmmenu_item_meta['upload_image_settings']['image_size']:'default');
$enable_custom_inherit = (isset($wpmmenu_item_meta['upload_image_settings']['enable_custom_inherit'])?$wpmmenu_item_meta['upload_image_settings']['enable_custom_inherit']:'0');
$custom_width = (isset($wpmmenu_item_meta['upload_image_settings']['custom_width'])?$wpmmenu_item_meta['upload_image_settings']['custom_width']:'');

?>
  <div class="wpmm_mega_settings">
       <table class="widefat">
	       <tr>
				<td class="wpmm_meta_table"><label for="enable_search_form"><?php _e("Image Size", APMM_TD) ?></label></td>
				  <td> 
				           <input id="ap_default_imagesize" class="radio" 
                            type="radio" <?php if($image_size == "default") echo "checked='checked'";?> 
                            value="default" name="wpmm_settings[upload_image_settings][image_size]">
                           <label for="ap_default_imagesize" class="image_label"><?php _e('Default Value',APMM_TD);?></label>
                           <br>
                  <p class="description"><?php _e('Inherit default image size settings.',APMM_TD);?></p>

				  <?php $image_sizes = APMM_Class::wpmm_get_image_sizes(); ?> 
				         <?php if(isset($image_sizes) && !empty($image_sizes)):
                         foreach ($image_sizes as $size_name => $key): 
                          ?>

                            <input id="ap_<?php echo $size_name;?>_imagesize" class="radio" 
                            type="radio" <?php if($size_name == $image_size) echo "checked='checked'";?> 
                            value="<?php echo $size_name;?>" name="wpmm_settings[upload_image_settings][image_size]">
                           <label for="ap_<?php echo $size_name;?>_imagesize" class="image_label"><?php echo ucwords($size_name);?></label>
                           <br>
                            <p class="description"><?php _e('Registered image size:',APMM_TD);?> <?php echo $size_name;?> <?php echo $key['width'].' * '.$key['height'];?></p>
                           <?php endforeach; 
                           endif;
                           ?>
				 </td>
				</tr>

				  <tr>
                      <td class='apmega-name'>
                            <label for="customdefaultwidth"><?php _e("Inherit Custom Default Width", APMM_TD); ?></label>
                           <p class='description'>
                                <?php _e("On enable, default custom width you set will be used for image.", APMM_TD); ?>
                            </p>
                        </td>
                        <td class='apmega-value'>
                          <div class="wpmm-switch">
                             <input type="checkbox" name="wpmm_settings[upload_image_settings][enable_custom_inherit]" id="customdefaultwidth" value="1" <?php if($enable_custom_inherit == 1) echo "checked='checked'";?> />
                              <label for="customdefaultwidth"></label>
                           </div>
                        </td>
                    </tr>

			    <tr>
                    <td class='apmega-name'>
                        <?php _e("Image Custom Width", APMM_TD); ?>
                    </td>
                    <td>
                    <label data-validation="px" class="ap-mega_container-padding">
                    <span><?php _e('Width',APMM_TD);?></span>
                    <input type="text" value="<?php echo esc_attr($custom_width);?>" name="wpmm_settings[upload_image_settings][custom_width]" class="apmega-menu_bar_padding" placeholder="45px">
                    </label>
                    </td>
                   
                </tr>




		
			</table>
  </div>