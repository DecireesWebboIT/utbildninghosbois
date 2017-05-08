<div class="apmega_left_content_wrapper image_settings">

     <div class="apmm-header1 wpmega-image"><?php _e("Image Settings", APMM_TD); ?></div>
                <table>
                    <tr>
                        <td class="apmega-name apmm-image-section" style="width:20%;">
                            <?php _e("Image Size", APMM_TD); ?>
                            <p class='description'>
                                <?php _e("Default image settings", APMM_TD); ?>
                            </p>
                        </td>
                        <?php $image_sizes = APMM_Class::wpmm_get_image_sizes(); ?> 
                        <td>
                            <?php if(isset($image_sizes) && !empty($image_sizes)):
                         foreach ($image_sizes as $size_name => $key): 
                          ?>

                            <input id="ap_<?php echo $size_name;?>_imagesize" class="radio" 
                            type="radio" <?php if($size_name == $image_size) echo "checked='checked'";?> 
                            value="<?php echo $size_name;?>" name="image_size">
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
                            <?php _e("Set Default Custom Width", APMM_TD); ?>
                              <p class="description"><?php _e('Note: Set default custom image width here in px',APMM_TD);?></p>
                        </td>
                        <td>
                        <label data-validation="px" class="ap-mega_container-padding">
                        <span><?php _e('Width',APMM_TD);?></span>
                        <input type="text" value="<?php echo esc_attr($custom_width);?>" name="custom_width" class="apmega-menu_bar_padding" placeholder="45px">
                        </label>
                        </td>
                       
                    </tr>

                </table>
       
       <div class="apmm-header1 wpmega-icon"><?php _e("Icon Settings", APMM_TD); ?></div>
            <table>
                  <tr>
                      <td class='apmega-name'>
                            <label for="hideallicons"><?php _e("Hide All Menu Icons", APMM_TD); ?></label>
                           <p class='description'>
                                <?php _e("Check to hide all icons.", APMM_TD); ?>
                            </p>
                        </td>
                        <td class='apmega-value'>
                          <div class="wpmm-switch">
                             <input type="checkbox" name="hide_icons" id="hideallicons" value="1" <?php if($hide_icons == 1) echo "checked='checked'";?> />
                              <label for="hideallicons"></label>
                           </div>
                        </td>
                    </tr>
                    <tr>
                        <td class='apmega-name'>
                          <?php _e("Icon Width", APMM_TD); ?>
                            <p class='description'>
                                <?php _e("Fill icon width in px.Default set as 13px.", APMM_TD); ?>
                            </p>
                        </td>
                        <td class='apmega-value'>
                            <input type="text" name="icon_width" id="icon_width" value="<?php if($icon_width) echo $icon_width;?> " placeholder="13px"/>
                        </td>
                    </tr>
              </table>

</div>