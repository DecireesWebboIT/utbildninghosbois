<div class="wpmm_mega_settings">
  <div class="settings_content">
      <div class="settings_title"><h4><?php _e('Menu Item Settings',APMM_TD);?></h4></div>
  	   <table class="widefat">
			<tr>
			<td class="wpmm_meta_table"><label for="disable_menu_text"><?php _e("Disable Menu Text", APMM_TD) ?></label></td>
			  <td> 
			       <div class="wpmm-switch">
			          <input type='checkbox' class='wpmm_menu_settingss' id="disable_menu_text" name='wpmm_settings[general_settings][disable_text]' value='true' <?php echo checked($wpmmenu_item_meta['general_settings']['disable_text'],'true', false ); ?>/>
			          <label for="disable_menu_text"></label>
                    </div>
                       <p class="description"><?php _e("Note: Enabling Disable On Menu Text, the menu text neither the menu description will be not be shown as well as not height will be taken.", APMM_TD); ?></p>
			  </td>
			</tr>	
			<tr>
			<td class="wpmm_meta_table"><label for="visible_hidden_text"><?php _e("Visible Hidden Menu Text", APMM_TD) ?></label></td>
			  <td> 
			       <div class="wpmm-switch">
			          <input type='checkbox' class='wpmm_menu_settingss' id="visible_hidden_text" name='wpmm_settings[general_settings][visible_hidden_menu]' value='true' <?php echo checked($wpmmenu_item_meta['general_settings']['visible_hidden_menu'],'true', false ); ?>/>
			          <label for="visible_hidden_text"></label>
                    </div>
                      <p class="description"><?php _e("Note: Enabling Visible hidden on Menu text, the menu text will be hidden but the respective height of the text will be taken.", APMM_TD); ?></p>
			  </td>
			</tr>
			<tr>
			<td class="wpmm_meta_table"><label for="active_menu_link"><?php _e("Active Menu Link", APMM_TD) ?></label></td>
				  <td> 
					  <div class="wpmm-switch">
					      <input type='checkbox' class='wpmm_active_links' id="active_menu_link"
					      name='wpmm_settings[general_settings][active_link]' value='true' <?php echo checked($wpmmenu_item_meta['general_settings']['active_link'],'true', false ); ?>/>
					      <label for="active_menu_link"></label>
		               </div>
			  </td>
			</tr>
			<tr>
			<td class="wpmm_meta_table"><label for="hide_arrow"><?php _e("Hide Arrow", APMM_TD) ?></label></td>
			  <td> 
			   <div class="wpmm-switch">
			      <input type='checkbox' class='wpmm_menu_settingss' id="hide_arrow"
			      name='wpmm_settings[general_settings][hide_arrow]' value='true' <?php echo checked($wpmmenu_item_meta['general_settings']['hide_arrow'],'true', false ); ?>/>
			       <label for="hide_arrow"></label>
               </div>
			  </td>
			</tr>
			<tr>
			<td class="wpmm_meta_table"><label for="hide_menu_onmobile"><?php _e("Hide Menu On Mobile", APMM_TD) ?></label></td>
			  <td> 
			  <div class="wpmm-switch">
			      <input type='checkbox' class='wpmm_menu_settingss' id="hide_menu_onmobile"
			      name='wpmm_settings[general_settings][hide_on_mobile]' value='true' <?php echo checked($wpmmenu_item_meta['general_settings']['hide_on_mobile'],'true', false ); ?>/>
			      <label for="hide_menu_onmobile"></label>
               </div>
			  </td>
			</tr>
			<tr>
			<td class="wpmm_meta_table"><label for="hide_menu_ondesktop"><?php _e("Hide Menu On Desktop", APMM_TD) ?></label></td>
			  <td> 
			  <div class="wpmm-switch">
			      <input type='checkbox' class='wpmm_menu_settingss' id="hide_menu_ondesktop"
			      name='wpmm_settings[general_settings][hide_on_desktop]' value='true' <?php echo checked($wpmmenu_item_meta['general_settings']['hide_on_desktop'],'true', false ); ?>/>
			     <label for="hide_menu_ondesktop"></label>
               </div>
			  </td>
			</tr>
		  <tr>
			<td class="wpmm_meta_table"><label for="menu_icon"><?php _e("Show Menu Icon", APMM_TD) ?></label></td>
			  <td> 
			  <div class="wpmm-switch">
			      <input type='checkbox' class='wpmm_menu_settingss' id="menu_icon"
			      name='wpmm_settings[general_settings][menu_icon]' value='enabled' <?php echo checked($wpmmenu_item_meta['general_settings']['menu_icon'],'enabled', disabled ); ?>/>
			   <label for="menu_icon"></label>
                           </div>
			  </td>
			</tr>

			  <tr>
			<td class="wpmm_meta_table"><label for="active_single_menu"><?php _e("Active Single Menu", APMM_TD) ?></label></td>
			  <td> 
			  <div class="wpmm-switch">
			      <input type='checkbox' class='wpmm_menu_settingss' id="active_single_menu"
			      name='wpmm_settings[general_settings][active_single_menu]' value='enabled' <?php echo checked($wpmmenu_item_meta['general_settings']['active_single_menu'],'enabled', disabled ); ?>/>
			       <label for="active_single_menu"></label>
              </div>
			  <p class="description"><?php _e('Enable single menu if menu is custom single menu link. Useful for Any Custom Links such as social links',APMM_TD);?></p>
			  </td>
			</tr>

            <tr>
			<td class="wpmm_meta_table">
			    <?php _e("Menu Item Alignment", APMM_TD); ?>
			</td>
			<td>
			    <select name='wpmm_settings[general_settings][menu_align]' class='wpmm_menu_align'>
			        <option value='left' <?php echo selected( $wpmmenu_item_meta['general_settings']['menu_align'], 'left', false );?>><?php _e("Left", APMM_TD); ?></option>
			        <option value='right' <?php echo selected( $wpmmenu_item_meta['general_settings']['menu_align'], 'right', false );?>><?php _e("Right", APMM_TD); ?></option>
			    <select>
			    <p class="description depth_check"></p>
			  <p class="description"><?php _e('Right aligned items will appear in reverse order on the right hand side of the menu bar.Specially for search icon and oher custom links with social icons.',APMM_TD);?></p>
			</td>
			</tr>

			<tr>
				<td class="wpmm_meta_table">
				    <?php _e("Menu Label", APMM_TD); ?>
				</td>
				<td class='apmega-value'>
			       <?php $topmenulabel = (isset($wpmmenu_item_meta['general_settings']['top_menu_label']) && $wpmmenu_item_meta['general_settings']['top_menu_label'] != '')?esc_attr($wpmmenu_item_meta['general_settings']['top_menu_label']):'';?>
				   <input type="text" name="wpmm_settings[general_settings][top_menu_label]" value="<?php echo $topmenulabel;?>" placeholder="<?php _e('E.g., HOT!',APMM_TD);?>">
				   <p class="description"><?php _e("Fill menu label such as HOT!, NEW!, UPDATES! and so on.", APMM_TD); ?></p>
				</td>
			</tr>
		 	 <tr>
			<td class="wpmm_meta_table">
			    <?php _e("Sub Menu Alignment", APMM_TD); ?>

			</td>
			<td>
			    <select name='wpmm_settings[general_settings][submenu_align]'>
			        <option value='left' <?php echo selected( $wpmmenu_item_meta['general_settings']['submenu_align'], 'left', false );?>><?php _e("Left", APMM_TD); ?></option>
			        <option value='right' <?php echo selected( $wpmmenu_item_meta['general_settings']['submenu_align'], 'right', false );?>><?php _e("Right", APMM_TD); ?></option>
			    <select>
			    <p class="description"><?php _e("Note: Choose individual flyout menu display position on hover/click for sub menu.", APMM_TD); ?></p>
			</td>
			</tr>

			 <tr>
			<td class="wpmm_meta_table">
			   <?php _e("Menu Visibility on User Based", APMM_TD); ?>
			</td>
			<td>
			   <input type="radio" id="always_show" name="wpmm_settings[general_settings][show_menu_to_users]"
				<?php if (isset($wpmmenu_item_meta['general_settings']['show_menu_to_users']) && $wpmmenu_item_meta['general_settings']['show_menu_to_users']=="always") echo "checked";?>
				value="always"><label for="always_show"><?php _e('Always',APMM_TD);?></label><br/>
				<input type="radio" id="loggedinshow" name="wpmm_settings[general_settings][show_menu_to_users]"
				<?php if (isset($wpmmenu_item_meta['general_settings']['show_menu_to_users']) && $wpmmenu_item_meta['general_settings']['show_menu_to_users']=="onlyloggedin_users") echo "checked";?>
				value="onlyloggedin_users"><label for="loggedinshow"><?php _e('Show Only To Logged In Users',APMM_TD);?></label><br/>
				<input type="radio" id="loggedoutshow"  name="wpmm_settings[general_settings][show_menu_to_users]"
				<?php if (isset($wpmmenu_item_meta['general_settings']['show_menu_to_users']) && $wpmmenu_item_meta['general_settings']['show_menu_to_users']=="onlyloggedout_users") echo "checked";?>
				value="onlyloggedout_users"><label for="loggedoutshow"><?php _e('Show Only To Logged Out Users',APMM_TD);?></label><br/>
			    <p class="description"><?php _e("Choose any one to show this menu as per logged in users , logged out users or show always.", APMM_TD); ?></p>
			</td>
			</tr> 

	 
			</table>
  </div>

</div>