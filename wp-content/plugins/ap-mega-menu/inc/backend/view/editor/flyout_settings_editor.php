 <?php 
if(isset($_GET['action']) && $_GET['action'] == 'edit_theme'){
if(isset($_GET['theme_id'])){
 if(isset($theme_settings['flyout'])){
        $flyout_enable_background     = (isset($theme_settings['flyout']['enable_background'])?$theme_settings['flyout']['enable_background']:'');
		$flyout_menu_bgcurrentcolor   = (isset($theme_settings['flyout']['menu_bgcurrentcolor'])?$theme_settings['flyout']['menu_bgcurrentcolor']:'');
		$flyout_menu_bg_hovercolor    = (isset($theme_settings['flyout']['menu_bg_hovercolor'])?$theme_settings['flyout']['menu_bg_hovercolor']:'');
		$flyout_font_color            = (isset($theme_settings['flyout']['font_color'])?$theme_settings['flyout']['font_color']:'');
		$flyout_font_hover_color      = (isset($theme_settings['flyout']['font_hover_color'])?$theme_settings['flyout']['font_hover_color']:'');
		$flyout_font_size             = (isset($theme_settings['flyout']['font_size'])?$theme_settings['flyout']['font_size']:'');
		$flyout_font_weight           = (isset($theme_settings['flyout']['font_weight'])?$theme_settings['flyout']['font_weight']:'');
		$flyout_font_weight_hover     = (isset($theme_settings['flyout']['font_weight_hover'])?$theme_settings['flyout']['font_weight_hover']:'');
		$flyout_transform             = (isset($theme_settings['flyout']['transform'])?$theme_settings['flyout']['transform']:'');
		$flyout_font_family           = (isset($theme_settings['flyout']['font_family'])?$theme_settings['flyout']['font_family']:'');
		$flyout_font_decoration       = (isset($theme_settings['flyout']['font_decoration'])?$theme_settings['flyout']['font_decoration']:'');
		$flyout_font_decoration_hover = (isset($theme_settings['flyout']['font_decoration_hover'])?$theme_settings['flyout']['font_decoration_hover']:'');
		$flyout_item_margin           = (isset($theme_settings['flyout']['item_margin'])?$theme_settings['flyout']['item_margin']:'');
		$flyout_item_padding          = (isset($theme_settings['flyout']['item_padding'])?$theme_settings['flyout']['item_padding']:'');
		$flyout_item_width            = (isset($theme_settings['flyout']['item_width'])?$theme_settings['flyout']['item_width']:'');
	 
	}
}
}

?>
 <!----------------Flyout settings  -------------------------->
		        <div class="apmm-slideToggle" id="flyout_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Flyout Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_flyout_settings" style="display: none;">

					<table cellspacing="0" class="widefat apmm_create_seciton">
						<tbody>
						    <tr>
								<td>
									<label><?php _e('Background',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Select from background color for flyout menu.',APMM_TD);?></p>
								</td> 
								<td>
								  <label for="flyout_bg" class="label_field">
								  <div class="wpmm-switch">
									  <input type="checkbox" value="1" <?php echo (isset($flyout_enable_background) && $flyout_enable_background == '1')?'checked':'';?> id="flyout_bg" 
									  class="apmm_enable_menu_background" 
									  name="apmm_theme[flyout][enable_background]">
									   <label for="flyout_bg"></label>
                                    </div>
									  <span><?php _e('Enable',APMM_TD);?></span>
								     </label><br/><br/>
									  <label class="ap-mega_multiple_field">
										<span><?php _e('Current Color',APMM_TD);?></span>
										<input type="text" value="<?php echo isset( $flyout_menu_bgcurrentcolor ) ? esc_attr($flyout_menu_bgcurrentcolor) : ''; ?>" data-alpha="true" name="apmm_theme[flyout][menu_bgcurrentcolor]" class="apmm-color-picker" >
										</label>
										<label class="ap-mega_multiple_field">
										<span><?php _e('Hover Color',APMM_TD);?></span>
										<input type="text" value="<?php echo isset( $flyout_menu_bg_hovercolor ) ? esc_attr( $flyout_menu_bg_hovercolor ) : ''; ?>" data-alpha="true" name="apmm_theme[flyout][menu_bg_hovercolor]" class="apmm-color-picker">
										</label>
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Fonts',APMM_TD);?></label>
									<p class="description">
										<?php _e('Note: Color [Hover]: Color of items that are active (hover/click depending on trigger),',APMM_TD);?>
									</p>
								</td>
								<td>
								
								<label class="ap-mega_container-padding">
								<span><?php _e('Color',APMM_TD);?></span>
								<input type="text" name="apmm_theme[flyout][font_color]" 
								class="apmega-menu_bar_padding apmm-color-picker" value="<?php echo isset( $flyout_font_color ) ? esc_attr( $flyout_font_color ) : ''; ?>">
								</label>
								<label class="ap-mega_container-padding">
								<span><?php _e('Color [Hover]',APMM_TD);?></span>
								
								<input type="text" name="apmm_theme[flyout][font_hover_color]" 
								class="apmega-menu_bar_padding apmm-color-picker" value="<?php echo isset( $flyout_font_hover_color ) ? esc_attr( $flyout_font_hover_color ) : ''; ?>">
								
								</label>
                                <label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Size',APMM_TD);?></span>
								<input type="text" value="<?php echo isset( $flyout_font_size ) ? esc_attr( $flyout_font_size ) : ''; ?>" name="apmm_theme[flyout][font_size]" 
								class="apmega-menu_bar_padding" placeholder="0px">
								</label><br/><br/>
								
								<label class="ap-mega_container-padding">
								<span><?php _e('Weight',APMM_TD);?></span>
								   <select name="apmm_theme[flyout][font_weight]" 
									class="apmm_fontweight">
									   <option value="theme_default" <?php echo (isset($flyout_font_weight) && $flyout_font_weight == 'theme_default')?'selected="selected"':'';?>><?php _e('Theme Default',APMM_TD);?></option>
									   <option value="normal" <?php echo (isset($flyout_font_weight) && $flyout_font_weight == 'normal')?'selected="selected"':'';?>><?php _e('Normal(400)',APMM_TD);?></option>
									   <option value="bold" <?php echo (isset($flyout_font_weight) && $flyout_font_weight == 'bold')?'selected="selected"':'';?>><?php _e('Bold(700)',APMM_TD);?></option>
									   <option value="light" <?php echo (isset($flyout_font_weight) && $flyout_font_weight == 'light')?'selected="selected"':'';?>><?php _e('Light(300)',APMM_TD);?></option>
									</select>
								</label>
								<label class="ap-mega_container-padding">
								<span><?php _e('Weight On Hover',APMM_TD);?></span>
								   <select name="apmm_theme[flyout][font_weight_hover]" 
									class="apmm_weight_hover">
									   <option value="theme_default" <?php echo (isset($flyout_font_weight_hover) && $flyout_font_weight_hover == 'theme_default')?'selected="selected"':'';?>><?php _e('Theme Default',APMM_TD);?></option>
									   <option value="normal" <?php echo (isset($flyout_font_weight_hover) && $flyout_font_weight_hover == 'normal')?'selected="selected"':'';?>><?php _e('Normal(400)',APMM_TD);?></option>
									   <option value="bold" <?php echo (isset($flyout_font_weight_hover) && $flyout_font_weight_hover == 'bold')?'selected="selected"':'';?>><?php _e('Bold(700)',APMM_TD);?></option>
									   <option value="light" <?php echo (isset($flyout_font_weight_hover) && $flyout_font_weight_hover == 'light')?'selected="selected"':'';?>><?php _e('Light(300)',APMM_TD);?></option>
									</select>
								</label>

								<label class="ap-mega_container-padding">
								<span><?php _e('Transform',APMM_TD);?></span>
									<select name="apmm_theme[flyout][transform]" 
										class="apmm_transform">
										   <option value="normal" <?php echo (isset($flyout_transform) && $flyout_transform == 'normal')?'selected="selected"':'';?>><?php _e('Normal',APMM_TD);?></option>
										   <option value="capitalize" <?php echo (isset($flyout_transform) && $flyout_transform == 'capitalize')?'selected="selected"':'';?>><?php _e('Capitalize',APMM_TD);?></option>
										   <option value="uppercase" <?php echo (isset($flyout_transform) && $flyout_transform == 'uppercase')?'selected="selected"':'';?>><?php _e('Uppercase',APMM_TD);?></option>
										   <option value="lowercase" <?php echo (isset($flyout_transform) && $flyout_transform == 'lowercase')?'selected="selected"':'';?>><?php _e('Lowercase',APMM_TD);?></option>
										</select>
								</label>
								<label class="ap-mega_container-padding">
								<span><?php _e('Family',APMM_TD);?></span>
									<select name="apmm_theme[flyout][font_family]" class="apmm_font_family">
									  <?php  $apmm_fonts = get_option('apmm_font_family');
									   if(isset($apmm_fonts) && !empty($apmm_fonts)){
									  	foreach ($apmm_fonts as $value) {
									  		?>
									  <option value="<?php echo $value;?>" <?php if(isset($flyout_font_family)) if($value == $flyout_font_family) echo "selected";?>><?php echo $value;?></option>
									   <?php } 
									   }?>
									</select>
								</label>
								<label class="ap-mega_container-padding">
								<span><?php _e('Decoration',APMM_TD);?></span>
									<select name="apmm_theme[flyout][font_decoration]" class="apmm_font_decoration">
										   <option value="none" <?php echo (isset($flyout_font_decoration) && $flyout_font_decoration == 'none')?'selected="selected"':'';?>><?php _e('None',APMM_TD);?></option>
										   <option value="underline" <?php echo (isset($flyout_font_decoration) && $flyout_font_decoration == 'underline')?'selected="selected"':'';?>><?php _e('Underline',APMM_TD);?></option>
										</select>
								</label>
								<label class="ap-mega_container-padding">
								<span><?php _e('Decoration On Hover',APMM_TD);?></span>
									<select name="apmm_theme[flyout][font_decoration_hover]" class="apmm_font_decoration_hover">
										   <option value="none" <?php echo (isset($flyout_font_decoration_hover) && $flyout_font_decoration_hover == 'none')?'selected="selected"':'';?>><?php _e('None',APMM_TD);?></option>
										   <option value="underline" <?php echo (isset($flyout_font_decoration_hover) && $flyout_font_decoration_hover == 'underline')?'selected="selected"':'';?>><?php _e('Underline',APMM_TD);?></option>
										</select>
								</label>
                  
							 
								</td>
							</tr>
							
							 <tr>
								<td>
									<label><?php _e('Flyout Item Margin',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Set a margin around individual second items to space them out. e.g. 0px 5px',APMM_TD);?></p>
								</td> 
								<td>
									 <input type="text" value="<?php echo isset( $flyout_item_margin ) ? esc_attr( $flyout_item_margin ) : ''; ?>" id="flyout_item_margin" class="apmm_menu_item_margin" 
									  name="apmm_theme[flyout][item_margin]"/>
								</td>
							</tr>
							<tr>
								<td>
									<label><?php _e('Flyout Item Padding',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Set a padding around individual flyout second items to space them out. e.g. 0px 5px',APMM_TD);?></p>
								</td> 
								<td>
									 <input type="text" value="<?php echo isset( $flyout_item_padding ) ? esc_attr( $flyout_item_padding ) : ''; ?>" id="flyout_item_padding" class="apmm_menu_item_padding" 
									  name="apmm_theme[flyout][item_padding]"/>
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Flyout Width',APMM_TD);?></label>
									<p class="description left_note"><?php _e('The width of each flyout menu. This must be a fixed pixel value.E.g 210px',APMM_TD);?></p>
								</td> 
								<td>
									 <input type="text" value="<?php echo isset( $flyout_item_width ) ? esc_attr( $flyout_item_width ) : ''; ?>" 
									 id="flyout_item_width" class="apmm_menu_item_width" 
									  name="apmm_theme[flyout][item_width]"/>
								</td>
							</tr>

							
					
						</tbody>
						</table>
		             </div>
                <!----------------Flyout settings  End-------------------------->