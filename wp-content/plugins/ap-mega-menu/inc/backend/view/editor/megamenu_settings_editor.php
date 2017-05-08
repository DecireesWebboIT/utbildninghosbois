<?php 
if(isset($_GET['action']) && $_GET['action'] == 'edit_theme'){
if(isset($_GET['theme_id'])){
	
   	  if(isset($theme_settings['megamenu_bar'])){
			$megamenu_enable_background      = (isset($theme_settings['megamenu_bar']['enable_megamenu_background'])?$theme_settings['megamenu_bar']['enable_megamenu_background']:'');
			$megamenu_menu_background_from   = (isset($theme_settings['megamenu_bar']['menu_background_from'])?$theme_settings['megamenu_bar']['menu_background_from']:'');
			
			$megamenu_width          		 = (isset($theme_settings['megamenu_bar']['width'])?$theme_settings['megamenu_bar']['width']:'');
			$megamenu_padding_top            = (isset($theme_settings['megamenu_bar']['padding_top'])?$theme_settings['megamenu_bar']['padding_top']:'');
			$megamenu_padding_bottom         = (isset($theme_settings['megamenu_bar']['padding_bottom'])?$theme_settings['megamenu_bar']['padding_bottom']:'');
			$megamenu_padding_left           = (isset($theme_settings['megamenu_bar']['padding_left'])?$theme_settings['megamenu_bar']['padding_left']:'');
			$megamenu_padding_right          = (isset($theme_settings['megamenu_bar']['padding_right'])?$theme_settings['megamenu_bar']['padding_right']:'');
			$megamenu_border_color           = (isset($theme_settings['megamenu_bar']['border_color'])?$theme_settings['megamenu_bar']['border_color']:'');
			$megamenu_border_radius          = (isset($theme_settings['megamenu_bar']['border_radius'])?$theme_settings['megamenu_bar']['border_radius']:'');
			$megamenu_box_shadow             = (isset($theme_settings['megamenu_bar']['box_shadow'])?$theme_settings['megamenu_bar']['box_shadow']:'');
			$megamenu_box_shadow_color       = (isset($theme_settings['megamenu_bar']['box_shadow_color'])?$theme_settings['megamenu_bar']['box_shadow_color']:'');
	 }
	       

      if(isset($theme_settings['widgets'])){
	    
		    $widgets_font_color                  = (isset($theme_settings['widgets']['font_color'])?$theme_settings['widgets']['font_color']:'');
			$widgets_font_color_active           = (isset($theme_settings['widgets']['font_hover_color'])?$theme_settings['widgets']['font_hover_color']:'');
			$widgets_font_size                   = (isset($theme_settings['widgets']['font_size'])?$theme_settings['widgets']['font_size']:'');
			$widgets_font_weight                 = (isset($theme_settings['widgets']['font_weight'])?$theme_settings['widgets']['font_weight']:'');
			$widgets_font_weight_hover           = (isset($theme_settings['widgets']['font_weight_hover'])?$theme_settings['widgets']['font_weight_hover']:'');
			$widgets_transform                   = (isset($theme_settings['widgets']['transform'])?$theme_settings['widgets']['transform']:'');
			$widgets_font_family                 = (isset($theme_settings['widgets']['font_family'])?$theme_settings['widgets']['font_family']:'');
			$widgets_font_decoration             = (isset($theme_settings['widgets']['font_decoration'])?$theme_settings['widgets']['font_decoration']:'');
			$widgets_font_decoration_hover       = (isset($theme_settings['widgets']['font_decoration_hover'])?$theme_settings['widgets']['font_decoration_hover']:'');
			$widgets_content_font_color          = (isset($theme_settings['widgets']['content_font_color'])?$theme_settings['widgets']['content_font_color']:'');
			$widgets_content_font_size           = (isset($theme_settings['widgets']['content_font_size'])?$theme_settings['widgets']['content_font_size']:'');
			$widgets_content_font_family         = (isset($theme_settings['widgets']['content_font_family'])?$theme_settings['widgets']['content_font_family']:'');
		
			$widgets_margin_top      		     = (isset($theme_settings['widgets']['margin_top'])?$theme_settings['widgets']['margin_top']:'');
			$widgets_margin_bottom          	 = (isset($theme_settings['widgets']['margin_bottom'])?$theme_settings['widgets']['margin_bottom']:'');
			$widgets_margin_left        		 = (isset($theme_settings['widgets']['margin_left'])?$theme_settings['widgets']['margin_left']:'');
			$widgets_margin_right        		 = (isset($theme_settings['widgets']['margin_right'])?$theme_settings['widgets']['margin_right']:'');
			
      }

      if(isset($theme_settings['top_section'])){
	    
		    $top_section_font_color                  = (isset($theme_settings['top_section']['font_color'])?$theme_settings['top_section']['font_color']:'');
		
			$top_section_font_size                   = (isset($theme_settings['top_section']['font_size'])?$theme_settings['top_section']['font_size']:'');
			$top_section_font_weight                 = (isset($theme_settings['top_section']['font_weight'])?$theme_settings['top_section']['font_weight']:'');
			
			$top_section_transform                   = (isset($theme_settings['top_section']['transform'])?$theme_settings['top_section']['transform']:'');
			$top_section_font_family                 = (isset($theme_settings['top_section']['font_family'])?$theme_settings['top_section']['font_family']:'');
			$top_section_margin_top      		     = (isset($theme_settings['top_section']['image_margin_top'])?$theme_settings['top_section']['image_margin_top']:'');
			$top_section_margin_bottom          	 = (isset($theme_settings['top_section']['image_margin_bottom'])?$theme_settings['top_section']['image_margin_bottom']:'');
			$top_section_margin_left        		 = (isset($theme_settings['top_section']['image_margin_left'])?$theme_settings['top_section']['image_margin_left']:'');
			$top_section_margin_right        		 = (isset($theme_settings['top_section']['image_margin_right'])?$theme_settings['top_section']['image_margin_right']:'');
      }

          if(isset($theme_settings['bottom_section'])){
	    
		    $bottom_section_font_color               = (isset($theme_settings['bottom_section']['font_color'])?$theme_settings['bottom_section']['font_color']:'');
			$bottom_section_font_size                = (isset($theme_settings['bottom_section']['font_size'])?$theme_settings['bottom_section']['font_size']:'');
			$bottom_section_font_weight              = (isset($theme_settings['bottom_section']['font_weight'])?$theme_settings['bottom_section']['font_weight']:'');
			$bottom_section_transform                = (isset($theme_settings['bottom_section']['transform'])?$theme_settings['bottom_section']['transform']:'');
			$bottom_section_font_family              = (isset($theme_settings['bottom_section']['font_family'])?$theme_settings['bottom_section']['font_family']:'');
			$bottom_section_margin_top      		 = (isset($theme_settings['bottom_section']['image_margin_top'])?$theme_settings['bottom_section']['image_margin_top']:'');
			$bottom_section_margin_bottom          	 = (isset($theme_settings['bottom_section']['image_margin_bottom'])?$theme_settings['bottom_section']['image_margin_bottom']:'');
			$bottom_section_margin_left        		 = (isset($theme_settings['bottom_section']['image_margin_left'])?$theme_settings['bottom_section']['image_margin_left']:'');
			$bottom_section_margin_right             = (isset($theme_settings['bottom_section']['image_margin_right'])?$theme_settings['bottom_section']['image_margin_right']:'');
      }
 }
}
?>
<!----------------Mega Menu settings  -------------------------->
		        <div class="apmm-slideToggle" id="megamenu_settings"  style="cursor:pointer;">
		          <div class="title_toggle"><?php _e('Mega Menu Settings',APMM_TD);?></div>
		        </div>
		        <div class="apmm-Togglebox apmm-slideTogglebox_megamenu_settings" style="display: none;">

					<table cellspacing="0" class="widefat apmm_create_seciton">
						<tbody>
						  	<tr>
								<td>
									<label><?php _e('Background',APMM_TD);?></label>
								</td> 
								<td>
								  <label for="megamenu_bg" class="label_field">
								   <div class="wpmm-switch">
								  <input type="checkbox" value="1" <?php echo (isset($megamenu_enable_background) && $megamenu_enable_background == 1)?'checked':'';?> id="megamenu_bg" 
								  class="apmm_enable_menu_background" 
								  name="apmm_theme[megamenu_bar][enable_megamenu_background]">
								   <label for="megamenu_bg"></label>
                                     </div>
								  <span><?php _e('Enable',APMM_TD);?></span></label>
             
								</td>
							</tr>
								<tr>
								<td>
									<p class="description left_note"><?php _e('Select from background color .',APMM_TD);?></p>
								</td> 
								<td>
								  <div class="color_picker_section menu_bg_colorpicker">
								  <label class="ap-mega_multiple_field">
									<span><?php _e('Bg Color',APMM_TD);?></span>
									<input type="text" value="<?php echo (!isset($megamenu_menu_background_from))?'':esc_attr($megamenu_menu_background_from);?>" data-alpha="true" name="apmm_theme[megamenu_bar][menu_background_from]" class="apmm-color-picker" >
									</label>
									<!-- <label class="ap-mega_multiple_field">
									<span><?php _e('To',APMM_TD);?></span>
									<input type="text" value="<?php echo (!isset($megamenu_menu_background_to))?'':esc_attr($megamenu_menu_background_to);?>" data-alpha="true" name="apmm_theme[megamenu_bar][menu_background_to]" class="apmm-color-picker">
									</label> -->
							      </div>
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Define Width',APMM_TD);?></label>
									<p class="description left_note"><?php _e('Set Mega Menu Panel width in px.',APMM_TD);?></p>
									
								</td> 
								<td>
								 <input type="text" value="<?php echo (!isset($megamenu_width))?'':esc_attr($megamenu_width);?>" placeholder="<?php _e('Eg., 600px',APMM_TD);?>" 
								 class="apmm_megamenu_width" name="apmm_theme[megamenu_bar][width]" />
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Inner Padding',APMM_TD);?></label>
								</td>
								<td>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Top',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($megamenu_padding_top))?'':esc_attr($megamenu_padding_top);?>" placeholder="0px" name="apmm_theme[megamenu_bar][padding_top]" 
								class="apmega-menu_bar_padding">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Bottom',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($megamenu_padding_bottom))?'':esc_attr($megamenu_padding_bottom);?>" placeholder="0px" name="apmm_theme[megamenu_bar][padding_bottom]" 
								class="apmega-menu_bar_padding">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Left',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($megamenu_padding_left))?'':esc_attr($megamenu_padding_left);?>" placeholder="0px" name="apmm_theme[megamenu_bar][padding_left]" 
								class="apmega-menu_bar_padding">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Right',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($megamenu_padding_right))?'':esc_attr($megamenu_padding_right);?>" placeholder="0px" name="apmm_theme[megamenu_bar][padding_right]" 
								class="apmega-menu_bar_padding">
								</label>
							 
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Border',APMM_TD);?></label>
								</td>
								<td>
								<label class="ap-mega_container-padding">
								<span><?php _e('Color',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($megamenu_border_color))?'':esc_attr($megamenu_border_color);?>" name="apmm_theme[megamenu_bar][border_color]" 
								class="apmm-color-picker">
								</label>
								<label data-validation="px" class="ap-mega_container-padding">
								<span><?php _e('Radius',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($megamenu_border_radius))?'':esc_attr($megamenu_border_radius);?>" name="apmm_theme[megamenu_bar][border_radius]" 
								class="apmega-menu_bar_padding">
								</label>
								
							 
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Box Shadow',APMM_TD);?></label>
								</td>
								<td>
								<label data-validation="px" class="ap-mega_container-box_shadow">
							
								<input type="text" value="<?php echo (!isset($megamenu_box_shadow))?'':esc_attr($megamenu_box_shadow);?>" placeholder="0 3px 3px" name="apmm_theme[megamenu_bar][box_shadow]" 
								class="apmega-box_shadow">
								</label>
							 
								</td>
							</tr>

							<tr>
								<td>
									<label><?php _e('Box Shadow Color',APMM_TD);?></label>
								</td>
								<td>
								<label class="ap-mega_container-padding">
								<span><?php _e('Color',APMM_TD);?></span>
								<input type="text" value="<?php echo (!isset($megamenu_box_shadow_color))?'':esc_attr($megamenu_box_shadow_color);?>" name="apmm_theme[megamenu_bar][box_shadow_color]" 
								class="apmm-color-picker">
								</label>
							
							 
								</td>
							</tr>
							
					
						</tbody>
						</table>

			               <div class="widgets_settings_section">
			              	<?php include_once('widgets_settings_editor.php');?>
			              </div>

			                <div class="topsection_settings_section">
			              	<?php include_once('top_section_editor.php');?>
			              </div>

			                <div class="bottomsection_settings_section">
			              	<?php include_once('bottom_section_editor.php');?>
			              </div>


		             </div>
               <!----------------Mega Menu settings End--------------------------> 