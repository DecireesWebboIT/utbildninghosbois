  <div class="settings_title"><h4><?php _e('Custom Menu Settings',APMM_TD);?></h4></div>
  <div class="wpmm_mega_settings">
       <table class="widefat">
	       <p class="description"><?php _e('Here you can select particular post featured images, excerpt, read more text and date for sub menu post selected only on megamenu type.',APMM_TD);?></p>
           <tr>
			<td class="wpmm_meta_table">
			    <label for="use_custom_settings"><?php _e("Use Custom Settings", APMM_TD); ?></label>
			</td>
			<td>
			      <div class="wpmm-switch">
			     <input type='checkbox' class='use_custom_settings' id="use_custom_settings"
			      name='wpmm_settings[upload_image_settings][use_custom_settings]' value='true' <?php echo checked($wpmmenu_item_meta['upload_image_settings']['use_custom_settings'],'true', false ); ?>/>
			     <label for="use_custom_settings"></label>
                 </div>
			     <p class="description"><?php _e('Note: On check , use below custom settings for this sub menu in wp mega menu.',APMM_TD);?></p>
			 
			</td>

			</tr>
          
          <tr>
			<td class="wpmm_meta_table">
			    <?php _e("Display Posts Image", APMM_TD); ?>
			</td>
			<td>
			     <select name='wpmm_settings[upload_image_settings][display_posts_images]' class="wpmm-displaypostimg">
			        <option value='featured-image' <?php echo selected( $wpmmenu_item_meta['upload_image_settings']['display_posts_images'], 'featured-image', false );?>><?php _e("Featured Image", APMM_TD); ?></option>
			        <option value='custom-image' <?php echo selected( $wpmmenu_item_meta['upload_image_settings']['display_posts_images'], 'custom-image', false );?>><?php _e("Custom Image", APMM_TD); ?></option>
			    <select>
			    <p class="description"><?php _e('Note: Choose featured image of this menu as side image or custom image and enter custom thumbnail link below for wp mega menu.',APMM_TD);?></p>
			</td>

			</tr>
		
			<tr>
				<td class="wpmm_meta_table">
				    <label for="default_thumbnail_imageurl"><?php _e("Default Thumbnail Image Link", APMM_TD); ?></label>
				</td>
				<td class="apmega-value">
				     <input type='text' class='wpmm_menu_settingss' id="default_thumbnail_imageurl"
				      name='wpmm_settings[upload_image_settings][default_thumbnail_imageurl]' placeholder="http://placehold.it/45x45/f0f0f0/ccc"
				      value='<?php echo (isset($wpmmenu_item_meta['upload_image_settings']['default_thumbnail_imageurl'])?esc_url($wpmmenu_item_meta['upload_image_settings']['default_thumbnail_imageurl']):'');?>'/>
				</td>

			</tr>

		  <tr>
			<td class="wpmm_meta_table">
			    <label for="show_excerpt"><?php _e("Show Excerpt", APMM_TD); ?></label>
			</td>
			<td>
			    <div class="wpmm-switch">
			     <input type='checkbox' class='wpmm_menu_settingss' id="show_excerpt"
			      name='wpmm_settings[upload_image_settings][show_description]' value='true' <?php echo checked($wpmmenu_item_meta['upload_image_settings']['show_description'],'true', false ); ?>/>
			       <label for="show_excerpt"></label>
                 </div>

			     <p class="description"><?php _e('Show description of posts,page or post type for wp mega menu.',APMM_TD);?></p>
			 
			</td>

			</tr>

			<tr>
			<td class="wpmm_meta_table">
			    <label for="show_desc_length"><?php _e("Excerpt Length", APMM_TD); ?></label>
			</td>
			<td>
			     <input type='number' class='wpmm_menu_settingss' id="show_desc_length"
			      name='wpmm_settings[upload_image_settings][show_desc_length]' 
			      value='<?php echo (isset($wpmmenu_item_meta['upload_image_settings']['show_desc_length'])?esc_attr($wpmmenu_item_meta['upload_image_settings']['show_desc_length']):'10');?>'/>
			</td>

			</tr>

			<tr>
				<td class="wpmm_meta_table">
				    <label for="display_readmore"><?php _e("Display Readmore", APMM_TD); ?></label>
				</td>
				<td>
				<div class="wpmm-switch">
				     <input type='checkbox' class='wpmm_menu_settingss' id="display_readmore"
			      name='wpmm_settings[upload_image_settings][display_readmore]' value='true' <?php echo checked($wpmmenu_item_meta['upload_image_settings']['display_readmore'],'true', false ); ?>/>
				  <label for="display_readmore"></label>
                 </div>
				</td>
			</tr>
			<tr>
				<td class="wpmm_meta_table">
				    <label for="readmore_text"><?php _e("Readmore Text", APMM_TD); ?></label>
				</td>
				<td>
				     <input type='text' class='wpmm_menu_settingss' id="readmore_text"
				      name='wpmm_settings[upload_image_settings][readmore_text]' placeholder="Read More >>"
				      value='<?php echo (isset($wpmmenu_item_meta['upload_image_settings']['readmore_text'])?esc_attr($wpmmenu_item_meta['upload_image_settings']['readmore_text']):'');?>'/>
				</td>

			</tr>

			<tr>
				<td class="wpmm_meta_table">
				    <label for="display_post_date"><?php _e("Display Date", APMM_TD); ?></label>
				</td>
				<td>
				<div class="wpmm-switch">
				     <input type='checkbox' class='wpmm_menu_settingss' id="display_post_date"
			      name='wpmm_settings[upload_image_settings][display_post_date]' value='true' <?php echo checked($wpmmenu_item_meta['upload_image_settings']['display_post_date'],'true', false ); ?>/>
			      <label for="display_post_date"></label>
                 </div>
				</td>
			</tr>

			<tr>
				<td class="wpmm_meta_table">
				    <label for="display_author_name"><?php _e("Display Author Name", APMM_TD); ?></label>
				</td>
				<td>
				<div class="wpmm-switch">
				     <input type='checkbox' class='wpmm_menu_settingss' id="display_author_name"
			      name='wpmm_settings[upload_image_settings][display_author_name]' value='true' <?php echo checked($wpmmenu_item_meta['upload_image_settings']['display_author_name'],'true', false ); ?>/>
			      <label for="display_author_name"></label>
                 </div>
				</td>
			</tr>


			<tr>
				<td class="wpmm_meta_table">
				    <label for="display_cat_name"><?php _e("Display Category Name", APMM_TD); ?></label>
				</td>
				<td>
				<div class="wpmm-switch">
				     <input type='checkbox' class='wpmm_menu_settingss' id="display_cat_name"
			         name='wpmm_settings[upload_image_settings][display_cat_name]' value='true' <?php echo checked($wpmmenu_item_meta['upload_image_settings']['display_cat_name'],'true', false ); ?>/>
			         <label for="display_cat_name"></label>
                 </div>
				</td>
			</tr>
				 

		  <tr>
			<td class="wpmm_meta_table">
			    <?php _e("Image Position", APMM_TD); ?>
			</td>
			<td>
			     <select name='wpmm_settings[upload_image_settings][text_position]' class="wpmm_textposition">
			        <option value='left' <?php echo selected( $wpmmenu_item_meta['upload_image_settings']['text_position'], 'left', false );?>><?php _e("Image Left", APMM_TD); ?></option>
			        <option value='right' <?php echo selected( $wpmmenu_item_meta['upload_image_settings']['text_position'], 'right', false );?>><?php _e("Image Right", APMM_TD); ?></option>
			        <option value='top' <?php echo selected( $wpmmenu_item_meta['upload_image_settings']['text_position'], 'top', false );?>><?php _e("Image Top", APMM_TD); ?></option>
			        <option value='onlyimage' <?php echo selected( $wpmmenu_item_meta['upload_image_settings']['text_position'], 'onlyimage', false );?>><?php _e("Only Image", APMM_TD); ?></option>
			    <select>
			</td>

			</tr>
			<tr class="show_text_position" style="display:none;">
				<td><?php _e('Sub Menu Text Position Preview',APMM_TD);?></td>
				<td>
				  <div class="wpmm_preview_textposition" id="preview_left" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/text-position-left.PNG'?>"/>
				  </div>
				   <div class="wpmm_preview_textposition" id="preview_right" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/text-position-right.PNG'?>"/>
				  </div>
				  <div class="wpmm_preview_textposition" id="preview_top" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/text-position-top.PNG'?>"/>
				  </div>
				  <div class="wpmm_preview_textposition" id="preview_onlyimage" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/text-position-image-only.PNG'?>"/>
				  </div>
					
				  </div>
				</td>

			</tr>
		</table>
</div>