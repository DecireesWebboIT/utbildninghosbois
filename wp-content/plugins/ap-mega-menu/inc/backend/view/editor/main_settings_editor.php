<?php 
if(isset($_GET['action']) && $_GET['action'] == 'edit_theme'){
if(isset($_GET['theme_id'])){
 if(isset($theme_settings['general'])){
	
		$arrow_color                 = (isset($theme_settings['general']['arrow_color'])?$theme_settings['general']['arrow_color']:'');
		$line_height                 = (isset($theme_settings['general']['line_height'])?$theme_settings['general']['line_height']:'');
		$zindex                      = (isset($theme_settings['general']['zindex'])?$theme_settings['general']['zindex']:'');
		$enable_shadow               = (isset($theme_settings['general']['enable_shadow'])?$theme_settings['general']['enable_shadow']:'');
		$shadow_color                = (isset($theme_settings['general']['shadow_color'])?$theme_settings['general']['shadow_color']:'');
	 
	}
}
}
?>

<!---------------- Main theme settings  -------------------------->
		        <div class="apmm-slideToggle" id="main_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Main Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_main_settings" style="display: none;">

					<table cellspacing="0" class="widefat apmm_create_seciton">
						<tbody>
						    <tr>
						  		<td>
									<label><?php _e('Theme Title',APMM_TD);?></label>
								</td>
								<td>
									<input type="text" value="<?php echo (!isset($theme_title))?'':esc_attr($theme_title);?>" class="apmm_theme_title" name="apmm_theme[theme_title]" required="required"/>
								</td>
								                         
							</tr>

							<tr>
								<td>
									<label><?php _e('Line Height',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Set line height to use in the panel contents.',APMM_TD);?></p>
								</td>
								<td>
							      <input type="text" value="<?php echo (!isset($line_height))?'':esc_attr($line_height);?>" placeholder="1.5" class="apmm_line_height" name="apmm_theme[general][line_height]"/>
								</td>
							</tr>
							<tr>
								<td>
									<label><?php _e('Z Index',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Set z-index to appear menu or sub menu ontop of other content such as slider.',APMM_TD);?></p>

								</td>
								<td>
							      <input type="text" value="<?php echo (!isset($zindex))?'':esc_attr($zindex);?>" placeholder="999" class="apmm_zindex" name="apmm_theme[general][zindex]"/>
								</td>
							</tr>

							<tr>
								<td>
									<label for="enable_shadow"><?php _e('Shadow',APMM_TD);?></label>
									<p class="description"><?php _e('Apply a shadow to mega and flyout menus.',APMM_TD);?></p>
									
								</td> 
								<td>
								  <label for="enable_shadow" class="label_field">
								  <div class="wpmm-switch">
								  <input type="checkbox" value="1" <?php echo (!isset($enable_shadow))?'':'checked';?> id="enable_shadow" class="apmm_enable_shadow" name="apmm_theme[general][enable_shadow]">
								  <label for="enable_shadow"></label>
                                 </div>
								  <span><?php _e('Enable',APMM_TD);?></span>
								  </label>
                                 
								  <div class="color_picker_section">
							      <input type="text" value="<?php echo (!isset($shadow_color))?'':esc_attr($shadow_color);?>" name="apmm_theme[general][shadow_color]" class="apmm-color-picker" />
							      </div>
								</td>
							</tr>
							
					
						</tbody>
						</table>
		             </div>
             <!-- Main theme settings End-->