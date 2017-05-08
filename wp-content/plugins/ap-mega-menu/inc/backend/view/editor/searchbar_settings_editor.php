<?php
if(isset($_GET['action']) && $_GET['action'] == 'edit_theme'){
if(isset($_GET['theme_id'])){
    if(isset($theme_settings['search_bar'])){
			$search_font_size     		   = (isset($theme_settings['search_bar']['font_size'])?$theme_settings['search_bar']['font_size']:'');
			$search_width          		   = (isset($theme_settings['search_bar']['width'])?$theme_settings['search_bar']['width']:'');
			$search_text_color     		   = (isset($theme_settings['search_bar']['text_color'])?$theme_settings['search_bar']['text_color']:'');
			$search_bg_color               = (isset($theme_settings['search_bar']['bg_color'])?$theme_settings['search_bar']['bg_color']:'');
			$search_text_placholder_color  = (isset($theme_settings['search_bar']['text_placholder_color'])?$theme_settings['search_bar']['text_placholder_color']:'');
			$search_icon_color 			   = (isset($theme_settings['search_bar']['icon_color'])?$theme_settings['search_bar']['icon_color']:'');
	 }
  }
}

?>
              <!----------------Search Bar settings  -------------------------->
		        <div class="apmm-slideToggle" id="searchbar_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Search Bar Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_searchbar_settings" style="display: none;">

					<table cellspacing="0" class="widefat apmm_create_seciton">
						<tbody>
						    <tr>
								<td>
									<label><?php _e('Font Size',APMM_TD);?></label>
								</td>
								<td>
									<input type="text" placeholder="E.g., 12px" name="apmm_theme[search_bar][font_size]" value="<?php echo isset( $search_font_size ) ? esc_attr($search_font_size) : ''; ?>" />
								</td>
							</tr>
						    <tr>
						  		<td>
									<label><?php _e('Width',APMM_TD);?></label>
								</td>
								<td>
									<input type="text" value="<?php echo isset( $search_width ) ? esc_attr($search_width) : ''; ?>" placeholder="E.g., 50%" 
									class="apmm_search_width" name="apmm_theme[search_bar][width]" />
								</td>
								                         
							</tr>
							<tr>
								<td>
									<label><?php _e('Text Font Color',APMM_TD);?></label>
								</td>
								<td>
									<input type="text" name="apmm_theme[search_bar][text_color]" 
								     class="apmega-menu_bar_padding apmm-color-picker" value="<?php echo isset( $search_text_color ) ? esc_attr($search_text_color) : ''; ?>">
							 
								</td>
							</tr>
							<tr>
								<td>
									<label><?php _e('Background Color',APMM_TD);?></label>
								</td>
								<td>
									<input type="text" name="apmm_theme[search_bar][bg_color]" 
								     class="apmega-menu_bar_padding apmm-color-picker" value="<?php echo isset( $search_bg_color ) ? esc_attr($search_bg_color) : ''; ?>">
							 
								</td>
							</tr>
							<tr>
								<td>
									<label><?php _e('Text Placeholder Color',APMM_TD);?></label>
								</td>
								<td>
									<input type="text" name="apmm_theme[search_bar][text_placholder_color]" 
								     class="apmega-menu_bar_padding apmm-color-picker" value="<?php echo isset( $search_text_placholder_color ) ? esc_attr($search_text_placholder_color) : ''; ?>" />
							 
								</td>
							</tr>
							<tr>
								<td>
									<label><?php _e('Icon Color',APMM_TD);?></label>
								</td>
								<td>
									<input type="text" name="apmm_theme[search_bar][icon_color]" 
								     class="apmega-menu_bar_padding apmm-color-picker" value="<?php echo isset( $search_icon_color) ? esc_attr($search_icon_color) : ''; ?>" />
							 
								</td>
							</tr>
							
							
							
							
					
						</tbody>
						</table>
		             </div>
                <!----------------Search Bar settings  End-------------------------->