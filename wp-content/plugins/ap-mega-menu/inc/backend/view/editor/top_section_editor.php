<!----------------Extra Top Section settings  -------------------------->
		        <div class="apmm-slideToggle" id="extra_top_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Extra Top Section Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_extra_top_settings" style="display: none;">

					<table cellspacing="0" class="widefat apmm_create_seciton">
						<tbody>
						    
						     <tr>
								<td>
									<label><?php _e('Top Content Fonts',APMM_TD);?></label>
									<p class="description">
									<?php _e('Set these font to use top section content in the mega menu.',APMM_TD);?>
									</p>
								</td>
								<td>
								
								<label class="ap-mega_container-padding">
								<span><?php _e('Color',APMM_TD);?></span>
								<input type="text" name="apmm_theme[top_section][font_color]" 
								class="apmega-menu_bar_padding apmm-color-picker" value="<?php echo (!isset($top_section_font_color))?'':esc_attr($top_section_font_color);?>">
								</label>
								
                                <label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Size',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($top_section_font_size))?'':esc_attr($top_section_font_size);?>" name="apmm_theme[top_section][font_size]" 
								class="apmega-menu_bar_padding" placeholder="0px">
								</label>
								
								<label class="ap-mega_container-padding">
								<span><?php _e('Weight',APMM_TD);?></span>
								   <select name="apmm_theme[top_section][font_weight]" 
									class="apmm_fontweight">
									   <option value="theme_default" <?php echo (isset($top_section_font_weight) && $top_section_font_weight == 'theme_default')?'selected="selected"':'';?>><?php _e('Theme Default',APMM_TD);?></option>
									   <option value="normal" <?php echo (isset($top_section_font_weight) && $top_section_font_weight == 'normal')?'selected="selected"':'';?>><?php _e('Normal(400)',APMM_TD);?></option>
									   <option value="bold" <?php echo (isset($top_section_font_weight) && $top_section_font_weight == 'bold')?'selected="selected"':'';?>><?php _e('Bold(700)',APMM_TD);?></option>
									   <option value="light" <?php echo (isset($top_section_font_weight) && $top_section_font_weight == 'light')?'selected="selected"':'';?>><?php _e('Light(300)',APMM_TD);?></option>
									</select>
								</label>

								<label class="ap-mega_container-padding">
								<span><?php _e('Transform',APMM_TD);?></span>
									<select name="apmm_theme[top_section][transform]" 
										class="apmm_transform">
										   <option value="normal" <?php echo (isset($top_section_transform) && $top_section_transform == 'normal')?'selected="selected"':'';?>><?php _e('Normal',APMM_TD);?></option>
										   <option value="capitalize" <?php echo (isset($top_section_transform) && $top_section_transform == 'capitalize')?'selected="selected"':'';?>><?php _e('Capitalize',APMM_TD);?></option>
										   <option value="uppercase" <?php echo (isset($top_section_transform) && $top_section_transform == 'uppercase')?'selected="selected"':'';?>><?php _e('Uppercase',APMM_TD);?></option>
										   <option value="lowercase" <?php echo (isset($top_section_transform) && $top_section_transform == 'lowercase')?'selected="selected"':'';?>><?php _e('Lowercase',APMM_TD);?></option>
										</select>
								</label>
								<label class="ap-mega_container-padding">
								<span><?php _e('Family',APMM_TD);?></span>
									<select name="apmm_theme[top_section][font_family]" class="apmm_font_family">
									  <?php  $apmm_fonts = get_option('apmm_font_family');
									   if(isset($apmm_fonts) && !empty($apmm_fonts)){
									  	foreach ($apmm_fonts as $value) {
									  		?>
									  <option value="<?php echo $value;?>" <?php if(isset($top_section_font_family)) if($value == $top_section_font_family) echo "selected";?>><?php echo $value;?></option>
									   <?php } 
									   }?>
									</select>
								</label>
								
								
                  
							 
								</td>
							</tr>
							 <tr>
								<td>
									<label><?php _e('Content Margin',APMM_TD);?></label>
									<p class="description">
									<?php _e('Set margin in px if top section contain upload image.',APMM_TD);?>
									</p>
								</td>
								<td>
								 <label data-validation="px" class="ap-mega_container-padding">
								   <span><?php _e('Top',APMM_TD);?></span>
								   <input type="text" value="<?php echo (!isset($top_section_margin_top))?'':esc_attr($top_section_margin_top);?>" name="apmm_theme[top_section][image_margin_top]" 
								    class="apmega-widgets_padding" placeholder="0px">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								   <span><?php _e('Bottom',APMM_TD);?></span>
								    <input type="text" value="<?php echo (!isset($top_section_margin_bottom))?'':esc_attr($top_section_margin_bottom);?>" name="apmm_theme[top_section][image_margin_bottom]" 
								    class="apmega-widgets_padding" placeholder="0px">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								   <span><?php _e('Left',APMM_TD);?></span>
								   <input type="text" value="<?php echo (!isset($top_section_margin_left))?'':esc_attr($top_section_margin_left);?>" name="apmm_theme[top_section][image_margin_left]" 
								   class="apmega-widgets_padding" placeholder="0px">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								   <span><?php _e('Right',APMM_TD);?></span>
								   <input type="text" value="<?php echo (!isset($top_section_margin_right))?'':esc_attr($top_section_margin_right);?>" name="apmm_theme[top_section][image_margin_right]" 
								   class="apmega-widgets_padding" placeholder="0px">
								</label>
								</td>
							 </tr>

						</tbody>
						</table>
		             </div>
                <!----------------Extra Top Section settings  End-------------------------->