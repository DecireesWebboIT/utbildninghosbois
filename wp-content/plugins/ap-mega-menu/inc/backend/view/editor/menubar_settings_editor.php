<?php 
if(isset($_GET['action']) && $_GET['action'] == 'edit_theme'){
if(isset($_GET['theme_id'])){
    if(isset($theme_settings['menu_bar'])){
		$enable_menu_background      = (isset($theme_settings['menu_bar']['enable_menu_background'])?$theme_settings['menu_bar']['enable_menu_background']:'');
		$menu_background_from        = (isset($theme_settings['menu_bar']['menu_background_from'])?$theme_settings['menu_bar']['menu_background_from']:'');
	
		$font_color                  = (isset($theme_settings['menu_bar']['font_color'])?$theme_settings['menu_bar']['font_color']:'');
		$font_family                 = (isset($theme_settings['menu_bar']['font_family'])?$theme_settings['menu_bar']['font_family']:'');
		$font_weight                 = (isset($theme_settings['menu_bar']['font_weight'])?$theme_settings['menu_bar']['font_weight']:'');
		$padding_top                 = (isset($theme_settings['menu_bar']['padding_top'])?$theme_settings['menu_bar']['padding_top']:'');
		$padding_bottom              = (isset($theme_settings['menu_bar']['padding_bottom'])?$theme_settings['menu_bar']['padding_bottom']:'');
		$padding_left                = (isset($theme_settings['menu_bar']['padding_left'])?$theme_settings['menu_bar']['padding_left']:'');
		$padding_right               = (isset($theme_settings['menu_bar']['padding_right'])?$theme_settings['menu_bar']['padding_right']:''); 
		$width                       = (isset($theme_settings['menu_bar']['width'])?$theme_settings['menu_bar']['width']:'');
		$border_radius_topleft       = (isset($theme_settings['menu_bar']['border_radius_topleft'])?$theme_settings['menu_bar']['border_radius_topleft']:'');
		$border_radius_topright      = (isset($theme_settings['menu_bar']['border_radius_topright'])?$theme_settings['menu_bar']['border_radius_topright']:'');
		$border_radius_bottomright   = (isset($theme_settings['menu_bar']['border_radius_bottomright'])?$theme_settings['menu_bar']['border_radius_bottomright']:'');
		$border_radius_bottomleft    = (isset($theme_settings['menu_bar']['border_radius_bottomleft'])?$theme_settings['menu_bar']['border_radius_bottomleft']:'');
		$border_color                = (isset($theme_settings['menu_bar']['border_color'])?$theme_settings['menu_bar']['border_color']:'');
		$alignment                   = (isset($theme_settings['menu_bar']['alignment'])?$theme_settings['menu_bar']['alignment']:'');
		$margin_bottom               = (isset($theme_settings['menu_bar']['margin_bottom'])?$theme_settings['menu_bar']['margin_bottom']:'');
		$margin_top                  = (isset($theme_settings['menu_bar']['margin_top'])?$theme_settings['menu_bar']['margin_top']:'');
	}

}
}
?>


<!--Menu Bar settings  -->
		        <div class="apmm-slideToggle" id="menubar_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Menu Bar Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_menubar_settings" style="display: none;">

					<table cellspacing="0" class="widefat apmm_create_seciton">
						<tbody>
						   	<tr>
								<td>
									<label><?php _e('Menu Background',APMM_TD);?></label>
								</td> 
								<td>
								  <label for="menu_bg" class="label_field">
								  <div class="wpmm-switch">
								  <input type="checkbox" value="1" <?php echo (!isset($enable_menu_background))?'':'checked';?> id="menu_bg" 
								  class="apmm_enable_menu_background" 
								  name="apmm_theme[menu_bar][enable_menu_background]">
								  <label for="menu_bg"></label>
                                     </div>
								  <span><?php _e('Enable',APMM_TD);?></span></label>
             
								</td>
							</tr>
								<tr>
								<td>
									<p class="description left_note"><?php _e('Select from background color.',APMM_TD);?></p>
								</td> 
								<td>
								  <div class="color_picker_section menu_bg_colorpicker">
								  <label data-validation="px" class="ap-mega_multiple_field">
									<span><?php _e('Bg Color',APMM_TD);?></span>
									<input type="text" value="<?php echo (!isset($menu_background_from))?'':esc_attr($menu_background_from);?>" data-alpha="true" name="apmm_theme[menu_bar][menu_background_from]" class="apmm-color-picker" >
									</label>
									
							      </div>
								</td>
							</tr>
							<tr>
								<td>
									<label><?php _e('Menu Font color',APMM_TD);?></label>
								</td>
								<td>
									 <div class="color_picker_section">
							      <input type="text" value="<?php echo (!isset($font_color))?'':esc_attr($font_color);?>" name="apmm_theme[menu_bar][font_color]" class="apmm-color-picker" />
							      </div>
								</td>
							</tr>
								<tr>
								<td>
									<label><?php _e('Font Family',APMM_TD);?></label>
								</td>
								<td>
									<select name="apmm_theme[menu_bar][font_family]" class="apmm_font_family">
									  <?php  $apmm_fonts = get_option('apmm_font_family');
									   if(isset($apmm_fonts) && !empty($apmm_fonts)){
									  	foreach ($apmm_fonts as $value) {
									  		?>
									  <option value="<?php echo $value;?>" <?php if(isset($font_family)) if($value == $font_family ) echo "selected";?>><?php echo $value;?></option>
									   <?php } 
									   }?>
									</select>

								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Font Weight',APMM_TD);?></label>
								</td>
								<td>
									<select name="apmm_theme[menu_bar][font_weight]" 
									class="apmm_fontweight">
									   <option value="theme_default" <?php echo (isset($font_weight) && $font_weight == 'theme_default')?'selected="selected"':'';?>><?php _e('Theme Default',APMM_TD);?></option>
									   <option value="normal" <?php echo (isset($font_weight) && $font_weight == 'normal')?'selected="selected"':'';?>><?php _e('Normal(400)',APMM_TD);?></option>
									   <option value="bold" <?php echo (isset($font_weight) && $font_weight == 'bold')?'selected="selected"':'';?>><?php _e('Bold(700)',APMM_TD);?></option>
									   <option value="light" <?php echo (isset($font_weight) && $font_weight == 'light')?'selected="selected"':'';?>><?php _e('Light(300)',APMM_TD);?></option>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label><?php _e('Menu Padding',APMM_TD);?></label>
								</td>
								<td>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Top',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($padding_top))?'':esc_attr($padding_top);?>" name="apmm_theme[menu_bar][padding_top]" 
								class="apmega-menu_bar_padding" placeholder="23px">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Bottom',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($padding_bottom))?'':esc_attr($padding_bottom);?>" name="apmm_theme[menu_bar][padding_bottom]" 
								class="apmega-menu_bar_padding" placeholder="23px">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Left',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($padding_left))?'':esc_attr($padding_left);?>" name="apmm_theme[menu_bar][padding_left]" 
								class="apmega-menu_bar_padding" placeholder="23px">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Right',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($padding_right))?'':esc_attr($padding_right);?>" name="apmm_theme[menu_bar][padding_right]" 
								class="apmega-menu_bar_padding" placeholder="23px">
								</label>
							 
								</td>
							</tr>
							<tr>
								<td>
									<label><?php _e('Menu Bar Width',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Required for centering. Generally not needed.Set Menu Width in px',APMM_TD);?></p>
								</td>
								<td>
							<input type="text" name="apmm_theme[menu_bar][width]" value="<?php echo (!isset($width))?'':esc_attr($width);?>" placeholder="<?php _e('E.g 600px', APMM_TD);?>"/> 
							 
								</td>
							</tr>
							 <tr>
								<td>
									<label><?php _e('Menu Bar Border Radius',APMM_TD);?></label>
									<p class="description"><?php _e('Set a border radius on the menu bar in px',APMM_TD);?></p>
								</td>
								<td>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Top Left',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($border_radius_topleft))?'':esc_attr($border_radius_topleft);?>" placeholder="0px" name="apmm_theme[menu_bar][border_radius_topleft]" 
								class="apmega-widgets_padding">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Top Right',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($border_radius_topright))?'':esc_attr($border_radius_topright);?>" placeholder="0px" name="apmm_theme[menu_bar][border_radius_topright]" 
								class="apmega-widgets_padding">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Bottom Right',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($border_radius_bottomright))?'':esc_attr($border_radius_bottomright);?>" placeholder="0px" name="apmm_theme[menu_bar][border_radius_bottomright]" 
								class="apmega-widgets_padding">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Bottom Left',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($border_radius_bottomleft))?'':esc_attr($border_radius_bottomleft);?>" placeholder="0px" name="apmm_theme[menu_bar][border_radius_bottomleft]" 
								class="apmega-widgets_padding">
								</label>

								</td>
							</tr>

						  <tr>
								<td>
									<label><?php _e('Menu Bar Border Color',APMM_TD);?></label>
								</td>
								<td>
							<input type="text" name="apmm_theme[menu_bar][border_color]" value="<?php echo (!isset($border_color))?'':esc_attr($border_color);?>" class="apmm-color-picker" /> 
							 
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Menu Bar Alignment',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Align all menu items to the left (default), centrally or to the right.',APMM_TD);?></p>

								</td>
								<td>
								    <select name="apmm_theme[menu_bar][alignment]" class="apmm_menu_alignment">
									   <option value="left" <?php echo (isset($alignment) && $alignment == "left")?'selected="selected"':'';?>><?php _e('Left',APMM_TD);?></option>
									   <option value="center" <?php echo (isset($alignment) && $alignment == "center")?'selected="selected"':'';?>><?php _e('Center',APMM_TD);?></option>
									   <option value="right" <?php echo (isset($alignment) && $alignment == "right")?'selected="selected"':'';?>><?php _e('Right',APMM_TD);?></option>
									</select>
									<p class="description right_note"><?php _e('Note: This option will apply to all menu items. To align an individual menu item to the right, edit the menu item itself and set Menu Item Align to Right',APMM_TD);?></p>
							 
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Menu Bar Margin Top',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Set Menu Margin top in px.Useful for tweaking position.',APMM_TD);?></p>
								</td>
								<td>
							     <input type="text" name="apmm_theme[menu_bar][margin_top]" 
							     value="<?php echo isset( $margin_top ) ? esc_attr( $margin_top ) : ''; ?>" placeholder="<?php _e('E.g., 24px',APMM_TD);?>"/> 
							 
								</td>
							</tr>
							<tr>
								<td>
									<label><?php _e('Menu Bar Margin Bottom',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Set Menu Margin bottom in px.Useful for spacing out elements',APMM_TD);?></p>
								</td>
								<td>
							     <input type="text" name="apmm_theme[menu_bar][margin_bottom]" 
							     value="<?php echo isset( $margin_bottom ) ? esc_attr( $margin_bottom ) : ''; ?>" placeholder="<?php _e('E.g., 24px',APMM_TD);?>"/> 
							 
								</td>
							</tr>

						</tbody>
						</table>
		             </div>
            <!---------------- Menu Bar settings End -------------------------->