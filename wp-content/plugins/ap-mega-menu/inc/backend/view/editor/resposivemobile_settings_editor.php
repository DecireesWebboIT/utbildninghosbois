<?php 
if(isset($_GET['action']) && $_GET['action'] == 'edit_theme'){
if(isset($_GET['theme_id'])){
    if(isset($theme_settings['mobile_settings'])){
				
				$togglebar_background_from   = (isset($theme_settings['mobile_settings']['togglebar_background_from'])?$theme_settings['mobile_settings']['togglebar_background_from']:'');
				
				$togglebar_enable_bgcolor    = (isset($theme_settings['mobile_settings']['togglebar_enable_bgcolor'])?$theme_settings['mobile_settings']['togglebar_enable_bgcolor']:'');
			
				$togglebar_height            = (isset($theme_settings['mobile_settings']['togglebar_height'])?$theme_settings['mobile_settings']['togglebar_height']:'');
				$resposive_breakpoint_width  = (isset($theme_settings['mobile_settings']['resposive_breakpoint_width'])?$theme_settings['mobile_settings']['resposive_breakpoint_width']:'');
				
				$togglebar_icon_type         = (isset($theme_settings['mobile_settings']['toggle_icon_type'])?$theme_settings['mobile_settings']['toggle_icon_type']:''); 
				$togglebar_icon_color        = (isset($theme_settings['mobile_settings']['icon_color'])?$theme_settings['mobile_settings']['icon_color']:'');
				$togglebar_text_color        = (isset($theme_settings['mobile_settings']['text_color'])?$theme_settings['mobile_settings']['text_color']:'');
				$togglebar_align             = (isset($theme_settings['mobile_settings']['togglebar_align'])?$theme_settings['mobile_settings']['togglebar_align']:'');
				$submenu_closebtn_position   = (isset($theme_settings['mobile_settings']['submenu_closebtn_position'])?$theme_settings['mobile_settings']['submenu_closebtn_position']:'');
				$submenus_retractor_text     = (isset($theme_settings['mobile_settings']['submenus_retractor_text'])?$theme_settings['mobile_settings']['submenus_retractor_text']:'');
	  }
  }
}
?>
 <!----------------Responsive Items settings  -------------------------->
		        <div class="apmm-slideToggle" id="mobile_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Responsive & Mobile Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_mobile_settings" style="display: none;">
                    
               <!----------------Toggle Bar Main Settings  -------------------------->
                <div class="apmm-slideToggle" id="toggle_bar_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Toggle Bar Main Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_toggle_bar_settings" style="display: none;">

				
					<table cellspacing="0" class="widefat apmm_create_seciton">
						<tbody>

						    <tr>
								<td>
									<label><?php _e('Toggle Bar Background Color',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Check enable if you want toggle bar with background color.',APMM_TD);?></p>
								</td> 
								<td>
								      <label for="bgcolor_enable" class="label_field">
								       <div class="wpmm-switch">
									  <input type="checkbox" value="1" <?php echo (isset($togglebar_enable_bgcolor) && $togglebar_enable_bgcolor == 1)?'checked':'';?> id="bgcolor_enable" class="toggle_bar_bgcolor_enable" 
									  name="apmm_theme[mobile_settings][togglebar_enable_bgcolor]">
									  	  <label for="bgcolor_enable"></label>
                                     </div>
									  <span><?php _e('Enable',APMM_TD);?></span>
								     </label><br/><br/>
									  <label class="ap-mega_multiple_field">
										<span><?php _e('Bg Color',APMM_TD);?></span>
										<input type="text" value="<?php echo (!isset($togglebar_background_from))?'':esc_attr($togglebar_background_from);?>" data-alpha="true" 
										name="apmm_theme[mobile_settings][togglebar_background_from]" 
										class="apmm-color-picker" >
										</label>
			
								</td>
							</tr>


							<tr>
								<td>
									<label><?php _e('Toggle Bar Height',APMM_TD);?></label>
									<p class="description left_note">
									<?php _e('Set Toggle Bar Height in px.',APMM_TD);?>
									</p>
								</td>
								<td>
							    <input type="text" value="<?php echo (!isset($togglebar_height))?'':esc_attr($togglebar_height);?>" id="mobile_settings_item_margin" 
							    class="apmm_menu_item_margin" name="apmm_theme[mobile_settings][togglebar_height]" placeholder="0px"/>
								</td>
							</tr>
							
							 <tr>
								<td>
									<label><?php _e('Responsive Breakpoint',APMM_TD);?></label>
									<p class="description left_note">
									<?php _e('Set the width at which the menu turns into a mobile menu. Set to 0px to disable responsive menu.Default is set to 910px.',APMM_TD);?></p>
								</td> 
								<td>
									 <input type="text" value="<?php echo (!isset($resposive_breakpoint_width))?'':esc_attr($resposive_breakpoint_width);?>" placeholder="<?php _e('E.g., 600px',APMM_TD);?>" id="mobile_settings_breakpoint" class="apmm_menu_settings_breakpoint" 
									  name="apmm_theme[mobile_settings][resposive_breakpoint_width]"/>
								</td>
							</tr>

                       </tbody>
				</table>
				</div>

             <!----------------Toggle Icons settings  -------------------------->
                <div class="apmm-slideToggle" id="toggle_icons_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Toggle Icons Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_toggle_icons_settings" style="display: none;">

					<table cellspacing="0" class="widefat apmm_create_seciton">
						<tbody>


							<tr>
								<td>
									<label><?php _e('Toggle Icons Font',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Set icon color for toggle icon and text color for resposive menu content.',APMM_TD);?></p>
								</td> 
								<td>
									<label class="ap-mega_container-padding">
								      <span><?php _e('Icon Color',APMM_TD);?></span>
								      <input type="text" name="apmm_theme[mobile_settings][icon_color]" 
								       class="apmega-menu_bar_padding apmm-color-picker" value="<?php echo (!isset($togglebar_icon_color))?'':esc_attr($togglebar_icon_color);?>">
								    </label>
								   <label class="ap-mega_container-padding">
								     <span><?php _e('Text Color',APMM_TD);?></span>
								
								      <input type="text" name="apmm_theme[mobile_settings][text_color]" 
								       class="apmega-menu_bar_padding apmm-color-picker" value="<?php echo (!isset($togglebar_text_color))?'':esc_attr($togglebar_text_color);?>">
								
								   </label>
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Toggle Bar Icon Alignment',APMM_TD);?></label>
								</td> 
								<td>
							    <select name="apmm_theme[mobile_settings][togglebar_align]" class="apmm_togglemenu_alignment">
								   <option value="left" <?php echo (isset($togglebar_align) && $togglebar_align == 'left')?'selected="selected"':'';?>><?php _e('Left',APMM_TD);?></option>
								   <option value="right" <?php echo (isset($togglebar_align) && $togglebar_align == 'right')?'selected="selected"':'';?>><?php _e('Right',APMM_TD);?></option>
								   <option value="center" <?php echo (isset($togglebar_align) && $togglebar_align == 'center')?'selected="selected"':'';?>><?php _e('Center',APMM_TD);?></option>
								</select>
								</td>
							</tr>
                       </tbody>
						</table>
						</div>
						 <!----------------Toggle Icons settings End  -------------------------->

            <!----------------Toggle Submenu settings  -------------------------->
                <div class="apmm-slideToggle" id="toggle_submenus_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Responsive Submenus Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_toggle_submenus_settings" style="display: none;">

					<table cellspacing="0" class="widefat apmm_create_seciton">
						<tbody>
						
							<tr>
								<td>
									<label><?php _e('Responsive Submenus Retractor',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Display a "Close" button at the top or bottom of the submenu on mobile devices.',APMM_TD);?></p>

								</td> 
								<td>
							    <select name="apmm_theme[mobile_settings][submenu_closebtn_position]" class="apmm_togglemenu_position_closebtn">
								
								   <option value="bottom" <?php echo (isset($submenu_closebtn_position) && $submenu_closebtn_position == 'bottom')?'selected="selected"':'';?>><?php _e('Bottom',APMM_TD);?></option>
								</select>
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Responsive Submenus Retractor Text',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Display a text after or before sub menu on mobile devices to close.',APMM_TD);?></p>
								</td> 
								<td>
							    <input type="text" name="apmm_theme[mobile_settings][submenus_retractor_text]" 
								      placeholder="<?php _e('E.g., Close',APMM_TD);?>" value="<?php echo (!isset($submenus_retractor_text))?'':esc_attr($submenus_retractor_text);?>">
								      <p class="description right_note"><?php _e('By default, the retractor will read "Close", and will be translatable. You can override it here but it will no longer be translatable.',APMM_TD);?></p>
								</td>
							</tr>
					     </tbody>
						</table>
						</div>


		             </div>
              <!----------------Responsive Items settings  End-------------------------->