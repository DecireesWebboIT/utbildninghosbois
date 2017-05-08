  <?php 
  // echo "<pre>";
  // print_r($wpmmenu_item_meta['mega_menu_settings']); ?>
  <div class="settings_title"><h4><?php _e('Mega Menu Settings',APMM_TD);?></h4></div>
  <div class="wpmm_mega_settings">
       <table class="widefat">
			<tr>
			<td class="wpmm_meta_table"><label for="show_top_content"><?php _e("Show Top Content", APMM_TD) ?></label></td>
			  <td> 
			    <div class="wpmm-switch">
			      <input type='checkbox' class='wpmm_menu_settingss' id="show_top_content"
			      name='wpmm_settings[mega_menu_settings][show_top_content]' value='true' <?php echo checked($wpmmenu_item_meta['mega_menu_settings']['show_top_content'],'true', false ); ?>/>
			       <label for="show_top_content"></label>
                 </div>
			  </td>
			</tr>
			<tr>
			<td class="wpmm_meta_table"><label for="show_bottom_content"><?php _e("Show Bottom Content", APMM_TD) ?></label></td>
			  <td> 
			  <div class="wpmm-switch">
			      <input type='checkbox' class='wpmm_active_links' id="show_bottom_content"
			      name='wpmm_settings[mega_menu_settings][show_bottom_content]' value='true' <?php echo checked($wpmmenu_item_meta['mega_menu_settings']['show_bottom_content'],'true', false ); ?>/>
			   <label for="show_bottom_content"></label>
                 </div>
			  </td>
			</tr>


 <!-- top content start-->
			<tr>
			<td class="wpmm_meta_table"><label><?php _e("Select Top Content Type", APMM_TD) ?></label></td>
			  <td> 
			     <select title="<?php _e('Select top content type as text only, image only or image with text.',APMM_TD);?>" name="wpmm_settings[mega_menu_settings][top][top_content_type]" id="wpmm_choose_topcontent_type">
			     	 <option value="text_only" <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['top']['top_content_type'], 'text_only', false );?>><?php _e('Text Only');?></option>
                     <option value="image_only" <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['top']['top_content_type'], 'image_only', false );?>><?php _e('Image Only');?></option>
                     <option value="html" <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['top']['top_content_type'], 'html', false );?>><?php _e('HTML');?></option>
			     </select>
			  </td>
			</tr>

			<?php 
			if(isset( $wpmmenu_item_meta['mega_menu_settings']['top']['top_content_type'])){
				$top_content_type = $wpmmenu_item_meta['mega_menu_settings']['top']['top_content_type'];
				if( $top_content_type == "text_only"){
                     $text_only = '';
				}else{
					$text_only = 'style="display:none;"';
				}
               
               	if( $top_content_type == "image_only"){
                     $image_only = '';
				}else{
					$image_only = 'style="display:none;"';
				}
				if( $top_content_type == "html"){
                     $html = '';
				}else{
					$html = 'style="display:none;"';
				}
			}
			?>

          <!-- case 1: only text here -->
			<tr class="toggle_toptext" <?php echo $text_only;?>>
			<td class="wpmm_meta_table"><label><?php _e("Top Text Content", APMM_TD) ?></label></td>
			  <td> 
			   <textarea name='wpmm_settings[mega_menu_settings][top][top_content]' cols="70" rows="3"><?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['top']['top_content']) && $wpmmenu_item_meta['mega_menu_settings']['top']['top_content'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['top']['top_content']):'';?></textarea> 
			  </td>
			</tr>

           <!-- case 2: only image here -->
			<tr class="toggle_topimage" id="top_image" <?php echo $image_only;?>>
			<td class="wpmm_meta_table"><label><?php _e("Top Image", APMM_TD) ?></label></td>
			  <td> 
			    <div class="wpmm-option-field">
		              <input type="hidden" class="wpmm-image-url" name="wpmm_settings[mega_menu_settings][top][image_url]"  value="<?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['top']['image_url']) && $wpmmenu_item_meta['mega_menu_settings']['top']['image_url'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['top']['image_url']):'';?>" />
		            
		              <input type="button" class="wpmm_image_url_button button button-primary button-large" id="top_image" name="wpmm_image_url_button"  value="Upload Image" size="25"/> 
		                 <p class="description"><?php _e('Recommended Image Size to fit on top section with width of 1240px and height of 150px.',APMM_TD);?></p>
		               <div class="wpmm-option-field wpmm-image-preview">
                         <a class="remove_top_image" href="#">
						<i class="dashicons dashicons-trash"></i>
						</a>
                      <img style="width: 100%;" class="wpmm-top-image" 
                      src="<?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['top']['image_url']) && $wpmmenu_item_meta['mega_menu_settings']['top']['image_url'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['top']['image_url']):'';?>" 
                      alt="">
                      </div>
                </div>   
			  </td>
			</tr>

			 <!-- case 3: image with text here -->
			<tr class="toggle_html" id="top_imagetext" <?php echo $html;?>>
			<td class="wpmm_meta_table"><label><?php _e("Html Content", APMM_TD) ?></label></td>
			  <td> 
			   <div class="wpmm-option-field">
			     <div class="wpmm-row">
           
                  
                   <textarea id='wpmm_html_content' class="top_html"><?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['top']['html_content']) && $wpmmenu_item_meta['mega_menu_settings']['top']['html_content'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['top']['html_content']):'';?></textarea>
                       <?php 
                     //  $settings = array('textarea_name' => 'wpmm_settings[mega_menu_settings][top][html_content]','media_buttons' => true);
                        // wp_editor( '', "wpmm_html_content", array('media_buttons' => true,'textarea_name'=>"wpmm_settings[mega_menu_settings][top][html_content]",'quicktags' => array('buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close')));
                      //  wp_editor('','wpmm_html_content',$settings); 
                       //  do_action('admin_print_footer_scripts');
                    ?>
                 </div>

                </div> 
                
			  </td>
			</tr>
 <!-- top content end-->

     

     <!-- bottom content -->
             <tr>
			<td class="wpmm_meta_table"><label><?php _e("Select Bottom Content Type", APMM_TD) ?></label></td>
			  <td> 
			     <select title="<?php _e('Select bottom content type as text only, image only or image with text.',APMM_TD);?>"
			      name="wpmm_settings[mega_menu_settings][bottom][bottom_content_type]" id="wpmm_choose_bottomcontent_type">
			     	<option value="text_only" <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['bottom']['bottom_content_type'], 'text_only', false );?>><?php _e('Text Only');?></option>
                     <option value="image_only" <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['bottom']['bottom_content_type'], 'image_only', false );?>><?php _e('Image Only');?></option>
                     <option value="html" <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['bottom']['bottom_content_type'], 'html', false );?>><?php _e('HTML');?></option>
			     </select>
			  </td>
			</tr>


					<?php 
			if(isset( $wpmmenu_item_meta['mega_menu_settings']['bottom']['bottom_content_type'])){
				$bottom_content_type = $wpmmenu_item_meta['mega_menu_settings']['bottom']['bottom_content_type'];
				if( $bottom_content_type == "text_only"){
                     $bottomtext_only = '';
				}else{
					$bottomtext_only = 'style="display:none;"';
				}
               
               	if( $bottom_content_type == "image_only"){
                     $bottomimage_only = '';
				}else{
					$bottomimage_only = 'style="display:none;"';
				}
				if( $bottomhtml == "html"){
                     $bottomhtml = '';
				}else{
					$bottomhtml = 'style="display:none;"';
				}
			}
			?>

          <!-- case 1: only text here -->
			<tr class="toggle_bottomtext" <?php echo $bottomtext_only;?>>
			<td class="wpmm_meta_table"><label><?php _e("Bottom Text Content", APMM_TD) ?></label></td>
			  <td> 
			   <textarea name='wpmm_settings[mega_menu_settings][bottom][bottom_content]' cols="70" rows="3"><?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['bottom']['bottom_content']) && $wpmmenu_item_meta['mega_menu_settings']['bottom']['bottom_content'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['bottom']['bottom_content']):'';?></textarea> 
			  </td>
			</tr>

           <!-- case 2: only image here -->
			<tr class="toggle_bimage" id="bottom_image" <?php echo $bottomimage_only;?>>
			<td class="wpmm_meta_table"><label><?php _e("Bottom Image", APMM_TD) ?></label></td>
			  <td> 
			    <div class="wpmm-option-field">
		              <input type="hidden" class="wpmm-bimage-url" name="wpmm_settings[mega_menu_settings][bottom][image_url]"  value="<?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['bottom']['image_url']) && $wpmmenu_item_meta['mega_menu_settings']['bottom']['image_url'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['bottom']['image_url']):'';?>" />
		            
		              <input type="button" class="wpmm_image_url_bottom button button-primary button-large" id="bottom_image" name="wpmm_image_url_bottom"  value="Upload Image" size="25"/> 
		               <p class="description"><?php _e('Recommended Image Size to fit on bottom section with width of 1240px and height of 150px.',APMM_TD);?></p>
		               <div class="wpmm-option-field wpmm-bimage-preview">
                         <a class="remove_bottom_image" href="#">
						<i class="dashicons dashicons-trash"></i>
						</a>
                         <img style="width: 100%;" class="wpmm-bottom-image" 
                         src="<?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['bottom']['image_url']) && $wpmmenu_item_meta['mega_menu_settings']['bottom']['image_url'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['bottom']['image_url']):'';?>">

                      </div>
                </div>   
			  </td>
			</tr>

			 <!-- case 3: image with text here -->
			<tr class="toggle_bhtml" id="bottom_html_only" <?php echo $bottomhtml;?>>
			<td class="wpmm_meta_table"><label><?php _e("Bottom Html Content", APMM_TD) ?></label></td>
			  <td> 
			   <div class="wpmm-option-field">
			   <div class="wpmm-row">
			   <textarea id="wpmm_html_content2" name='wpmm_settings[mega_menu_settings][bottom][html_content]'><?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['bottom']['html_content']) && $wpmmenu_item_meta['mega_menu_settings']['bottom']['html_content'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['bottom']['html_content']):'';?></textarea>
			   </div> 
			

                </div> 
                
			  </td>
			</tr>

<!-- bottom content end -->
   

            <tr>
			<td class="wpmm_meta_table">
			    <?php _e("Mega Menu Horizontal Position", APMM_TD); ?>
			</td>
			<td>
			    <select name='wpmm_settings[mega_menu_settings][horizontal-menu-position]' class="wpmm_position">
			        <option value='full-width' <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['horizontal-menu-position'], 'full-width', false );?>><?php _e("Full Width", APMM_TD); ?></option>
			        <option value='center' <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['horizontal-menu-position'], 'center', false );?>><?php _e("Center", APMM_TD); ?></option>
			        <option value='left-edge' <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['horizontal-menu-position'], 'left-edge', false );?>><?php _e("Left-Edge", APMM_TD); ?></option>
			        <option value='right-edge' <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['horizontal-menu-position'], 'right-edge', false );?>><?php _e("Right-Edge", APMM_TD); ?></option>
			    <select>
			 
			</td>

			</tr>
			<tr class="show_megamenu_position_type" style="display:none;">
				<td><?php _e('Position Preview',APMM_TD);?></td>
				<td>
				  <div class="wpmm_preview_position" id="preview_full-width" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/full-width.PNG'?>" alt="FUllwidthMegamenu"/>
				  </div>
				   <div class="wpmm_preview_position" id="preview_center" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/center.PNG'?>" alt="Center Mega menu"/>
				  </div>
				   <div class="wpmm_preview_position" id="preview_left-edge" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/left-edge.PNG'?>" alt="Left edge"/>
				  </div>
				   <div class="wpmm_preview_position" id="preview_right-edge" style="display:none;">
				    <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/right-edge.PNG'?>" alt="Right edge"/>
				  </div>
					
				  </div>
				</td>

			</tr>


			 <tr>
			<td class="wpmm_meta_table">
			    <?php _e("Mega Menu Vertical Position", APMM_TD); ?>
			</td>
			<td>
			    <select name='wpmm_settings[mega_menu_settings][vertical-menu-position]' class="wpmm_vposition">
			        <option value='full-height' <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['vertical-menu-position'], 'full-height', false );?>><?php _e("Full Height", APMM_TD); ?></option>
			        <option value='aligned-to-parent' <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['vertical-menu-position'], 'aligned-to-parent', false );?>><?php _e("Aligned to Parent", APMM_TD); ?></option>   
			    <select>
			 
			</td>

			</tr>
			<tr class="show_megamenu_vposition_type" style="display:none;">
				<td><?php _e('Vertical Position Preview',APMM_TD);?></td>
				<td>
				  <div class="wpmm_preview_vposition" id="preview_full-height" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/vertical-full-height.PNG'?>" alt="FUll Vertical Height Megamenu"/>
				  </div>
				   <div class="wpmm_preview_vposition" id="preview_aligned-to-parent" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/vertical-alignedto-parent.PNG'?>" alt="Aligned to parent Vertical Menu"/>
				  </div>
					
				  </div>
				</td>

			</tr>

			</table>
  </div>
<div id="content2" style="display: none;" data-sample="2">
	<p>The number of <code>change</code> events: <strong><span id="changes"></span></strong>.</p>
	<h3>Mirrored Content</h3>
	<!-- This <div> will be used to display the editor content. -->
	<textarea id="tophtmlcontent" name="wpmm_settings[mega_menu_settings][top][html_content]"><?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['top']['html_content']) && $wpmmenu_item_meta['mega_menu_settings']['top']['html_content'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['top']['html_content']):'';?></textarea>
</div>
  <div id="content1" style="display: none;" data-sample="2">
	<p>The number of <code>change</code> events: <strong><span id="changes2"></span></strong>.</p>
	<h3>Mirrored Content</h3>
	<!-- This <div> will be used to display the editor content. -->
	<textarea id="bottomhtmlcontent" name="wpmm_settings[mega_menu_settings][bottom][html_content]"><?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['bottom']['html_content']) && $wpmmenu_item_meta['mega_menu_settings']['bottom']['html_content'] != '')?esc_attr($wpmmenu_item_meta['mega_menu_settings']['bottom']['html_content']):'';?></textarea>
</div>
