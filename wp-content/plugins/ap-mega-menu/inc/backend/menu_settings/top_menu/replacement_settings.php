  <div class="settings_title"><h4><?php _e('Menu Replacement Settings',APMM_TD);?></h4></div>
  <div class="wpmm_mega_settings">
       <table class="widefat">
	       <tr>
	<td class="wpmm_meta_table"><label for="enable_search_form"><?php _e("Choose Replacement", APMM_TD) ?></label></td>
	  <td> 
	  <select name="wpmm_settings[mega_menu_settings][choose_menu_type]" id="wpmm_choose_menu_type">
	  	<option value="default" <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['choose_menu_type'], 'default', false );?>>Default</option>
	  	<option value="search_type" <?php echo selected( $wpmmenu_item_meta['mega_menu_settings']['choose_menu_type'], 'search_type', false );?>>Search Type</option>
	  </select>
	  <p class="description"><?php _e('Note: Choose replacement instead of default menu setup such as for search form display on menu bar.',APMM_TD);?></p>
	  </td>
	</tr>

			<?php 
			if(isset( $wpmmenu_item_meta['mega_menu_settings']['choose_menu_type'])){
				if( $wpmmenu_item_meta['mega_menu_settings']['choose_menu_type'] == "default"){
                     $style = 'style="display:none;"';
				}else{
					$style = '';
				}
               
			}else{
              $style = 'style="display:none;"';
			}

			?>

			<tr class="toggle_search_form" <?php echo $style;?>>
			<td class="wpmm_meta_table"><label><?php _e("Custom Content", APMM_TD) ?></label></td>
			  <td> 
			     <textarea name='wpmm_settings[mega_menu_settings][custom_content]' cols="40" rows="2" placeholder="<?php _e('Paste Shortcode here',APMM_TD);?>"><?php echo (isset( $wpmmenu_item_meta['mega_menu_settings']['custom_content']) && $wpmmenu_item_meta['mega_menu_settings']['custom_content'] != '')?$wpmmenu_item_meta['mega_menu_settings']['custom_content']:'';?></textarea>
<p class="description"><?php _e('Use Shortcode for search menu as',APMM_TD);?></p>
<p class="description"><?php _e('Inline Search Toggle Left: [wp_megamenu_search_form template_type="inline-search" style="inline-toggle-left"]',APMM_TD);?></p>
<p class="description"><?php _e('Inline toggle to Right search form:  [wp_megamenu_search_form template_type="inline-search" style="inline-toggle-right"]',APMM_TD);?></p>
<p class="description"><?php _e('Display Search form on MegaMenu On hover/click : [wp_megamenu_search_form template_type="megamenu-type-search"]',APMM_TD);?></p>
			  </td>
			</tr>
			</table>
  </div>