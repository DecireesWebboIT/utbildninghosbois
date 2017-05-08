  <div class="settings_title"><h4><?php _e('Flyout Settings',APMM_TD);?></h4></div>
  <div class="wpmm_mega_settings">
       <table class="widefat">
			<tr>
			<td class="wpmm_meta_table">
			    <?php _e("Flyout Horizontal Position", APMM_TD); ?>
			</td>
			<td>
			    <select name='wpmm_settings[flyout_settings][flyout-position]' class="wpmm_flyposition">
			      
			        <option value='left'<?php echo selected( $wpmmenu_item_meta['flyout_settings']['flyout-position'], 'left', false );?>><?php _e("Left", APMM_TD); ?></option>
			        <option value='right' <?php echo selected( $wpmmenu_item_meta['flyout_settings']['flyout-position'], 'right', false );?>><?php _e("Right", APMM_TD); ?></option>
			    <select>
			 
			</td>

			</tr>
			<tr class="show_flyposition_type" style="display:none;">
				<td><?php _e('Position Preview',APMM_TD);?></td>
				<td>
				   <div class="wpmm_preview_flyposition" id="preview2_left" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/flyout-left.PNG'?>" alt="Left"/>
				  </div>
				   <div class="wpmm_preview_flyposition" id="preview2_right" style="display:none;">
				    <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/flyout-right.PNG'?>" alt="Right"/>
				  </div>
					
				  </div>
				</td>

			</tr>


			 <tr>
			<td class="wpmm_meta_table">
			    <?php _e("Flyout Vertical Position", APMM_TD); ?>
			</td>
			<td>
			    <select name='wpmm_settings[flyout_settings][vertical-position]' class="wpmm_flyoutvposition">
			        <option value='full-height' <?php echo selected( $wpmmenu_item_meta['flyout_settings']['vertical-position'], 'full-height', false );?>><?php _e("Full Height", APMM_TD); ?></option>
			        <option value='aligned-to-parent' <?php echo selected( $wpmmenu_item_meta['flyout_settings']['vertical-position'], 'aligned-to-parent', false );?>><?php _e("Aligned to Parent", APMM_TD); ?></option>
			        
			    <select>
			 
			</td>

			</tr>
			<tr class="show_megamenu_flyvposition_type" style="display:none;">
				<td><?php _e('Vertical Position Preview',APMM_TD);?></td>
				<td>
				  <div class="wpmm_preview_flyvposition" id="preview3_full-height" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/flyout-vertical-full-height.PNG'?>" alt="FUll Vertical Height Megamenu"/>
				  </div>
				   <div class="wpmm_preview_flyvposition" id="preview3_aligned-to-parent" style="display:none;">
				   <img src="<?php echo APMM_IMG_DIR.'/mega_menu_images/flyout-vertical-alignedtoparent.PNG'?>" alt="Aligned to parent Vertical Menu"/>
				  </div>
					
				  </div>
				</td>

			</tr>

			</table>
  </div>