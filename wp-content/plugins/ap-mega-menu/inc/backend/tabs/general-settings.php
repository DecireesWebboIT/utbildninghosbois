<div class="apmega_left_content_wrapper general_settings">

     <div class="apmm-header1 wpmega-general"><?php _e("General Settings", APMM_TD); ?></div>
                <table>
                    <tr>
                        <td class='apmega-name'>
                            <?php _e("Event Behaviour", APMM_TD); ?>
                            <p class='description'>
                                <?php _e("Define what should happen when the event is set to 'click'. This also applies to mobiles.", APMM_TD); ?>
                            </p>
                        </td>
                        <td class='apmega-value'>
                            <select name='advanced_click' class="wpmm-selection">
                                <option value='click_submenu' <?php if($advanced_click == "click_submenu") echo "selected='selected'";?>><?php _e("Open Submenu on first click and close on second click.", APMM_TD); ?></option>
                                <option value='follow_link' <?php if($advanced_click == "follow_link") echo "selected='selected'";?>><?php _e("Open submenu on first click and follow link on second click.", APMM_TD); ?></option>
                            <select>
                            <p class='description'>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td class='apmega-name'>
                           <?php _e("Menu Label Animation Type", APMM_TD); ?>
                           <p class="description"><?php _e('Choose default animation type for menu label such as Hot!,New!.Default is set as None which will disable animation.',APMM_TD);?></p>
                        </td>
                        <td class='apmega-value'>
                           <select name="mlabel_animation_type" class="wpmm-selection">
                               <option value="none" <?php if($mlabel_animation_type == "none") echo "selected='selected'";?>><?php _e('None',APMM_TD);?></option>
                               <option value="mybounce" <?php if($mlabel_animation_type == "mybounce") echo "selected='selected'";?>><?php _e('Bounce',APMM_TD);?></option>
                               <option value="flash" <?php if($mlabel_animation_type == "flash") echo "selected='selected'";?>><?php _e('Flash',APMM_TD);?></option>
                               <option value="shake" <?php if($mlabel_animation_type == "shake") echo "selected='selected'";?>><?php _e('Shake',APMM_TD);?></option>
                               <option value="swing" <?php if($mlabel_animation_type == "swing") echo "selected='selected'";?>><?php _e('Swing',APMM_TD);?></option>
                               <option value="tada" <?php if($mlabel_animation_type == "tada") echo "selected='selected'";?>><?php _e('Tada',APMM_TD);?></option>
                               <option value="bounceIn" <?php if($mlabel_animation_type == "bounceIn") echo "selected='selected'";?>><?php _e('BounceIn',APMM_TD);?></option>
                               <option value="flipInX" <?php if($mlabel_animation_type == "flipInX") echo "selected='selected'";?> ><?php _e('FlipInX',APMM_TD);?></option>
                               <option value="flipInY" <?php if($mlabel_animation_type == "flipInY") echo "selected='selected'";?> ><?php _e('FlipInY',APMM_TD);?></option>
                               <option value="slideInUp" <?php if($mlabel_animation_type == "slideInUp") echo "selected='selected'";?>><?php _e('SlideInUp',APMM_TD);?></option>
                               <option value="slideInDown" <?php if($mlabel_animation_type == "slideInDown") echo "selected='selected'";?>><?php _e('SlideInDown',APMM_TD);?></option>
                           </select>
                        </td>
                    </tr>

                  <tr>
                        <td class='apmega-name'>
                           <?php _e("Animation Duration", APMM_TD); ?>
                           <p class="description"><?php _e('Choose the animation duration time in second. Default value set to 3s.',APMM_TD);?></p>
                        </td>
                        <td class='apmega-value'>
                          <input type="number" value="<?php echo esc_attr($animation_duration);?>" class="apmm_animation_duration" 
                           placeholder="1" name="animation_duration"/>
                        </td>
                    </tr>
                    <tr>
                        <td class='apmega-name'>
                           <?php _e("Animation Delay", APMM_TD); ?>
                           <p class="description"><?php _e('Choose the animation delay time in second.Default value set to 2s.',APMM_TD);?></p>
                        </td>
                        <td class='apmega-value'>
                          <input type="number" value="<?php echo esc_attr($animation_delay);?>" class="apmm_animation_delay" 
                           placeholder="1" name="animation_delay"/>
                        </td>
                    </tr>
                     <tr>
                        <td class='apmega-name'>
                           <?php _e("Animation Iteration Count", APMM_TD); ?>
                           <p class="description"><?php _e('Fill the animation Iteration count in number such as 2,3. You can also use "infinite" word instead of number which let the
                            animation to repeat forever.',APMM_TD);?></p>
                           <p class="description"><?php _e('The number of times the animation should repeat; this is 1 by default. Negative values are invalid. You may specify non-integer values to play part of an animation cycle (for example 0.5 will play half of the animation cycle).',APMM_TD);?></p>
                        </td>
                        <td class='apmega-value'>
                          <input type="text" value="<?php echo esc_attr($animation_iteration_count);?>" class="apmm_animation_iteration_count" 
                           placeholder="<?php _e('E.g., infinite,2,3,1,2.3',APMM_TD);?>" name="animation_iteration_count"/>
                        </td>
                    </tr>
             
                </table>
    <div class="apmm-header1 wpmega-mob"><?php _e("Mobile Settings", APMM_TD); ?></div>
            <table>
                    <tr>
                        <td class='apmega-name'>
                          <label for="enable_wpmegamenu"><?php _e("Enable AP Mega Menu on Mobile", APMM_TD); ?></label>
                            <p class='description'>
                                <?php _e("Enable or disable submenu on mobile version.", APMM_TD); ?>
                            </p>
                        </td>
                        <td class='apmega-value'>
                           <div class="wpmm-switch">
                             <input type="checkbox" name="enable_mobile" id="enable_wpmegamenu" value="1" <?php if($enable_mobile  == 1) echo "checked";?>/>
                             <label for="enable_wpmegamenu"></label>
                           </div>
                        </td>
                    </tr>
                      <tr>
                        <td class='apmega-name'>
                          <label for="disable_submenu_retractor"><?php _e("Disable Submenu Retractor", APMM_TD); ?></label>
                            <p class='description'>
                                <?php _e("Check to disable submenu retractor close button at last of menu after toggle open on mobile version.", APMM_TD); ?>
                            </p>
                        </td>
                        <td class='apmega-value'>
                         <div class="wpmm-switch">
                            <input type="checkbox" name="disable_submenu_retractor" id="disable_submenu_retractor" value="1" <?php if($disable_submenu_retractor  == 1) echo "checked";?>/>
                            <label for="disable_submenu_retractor"></label>
                           </div>
                        </td>
                    </tr>
                    <tr>
                        <td class='apmega-name'>
                            <?php _e("Toggle Behavior", APMM_TD); ?>
                           <p class='description'>
                                <?php _e("Standard toggle will open sub menus even if another menu is clicked and 
                                accordion toggle will close opened submenus automatically when another one is open.", APMM_TD); ?>
                            </p>
                        </td>
                        <td class='apmega-value'>
                            <select name='mobile_toggle_option' class="wpmm-selection">
                                <option value='toggle_standard' <?php if($mobile_toggle_option == "toggle_standard") echo "selected='selected'";?>><?php _e("Standard", APMM_TD); ?></option>
                                <option value='toggle_accordion' <?php if($mobile_toggle_option == "toggle_accordion") echo "selected='selected'";?>><?php _e("Accordion", APMM_TD); ?></option>
                            <select>
                          
                        </td>
                    </tr>

                    <tr>
                        <td class='apmega-name'>
                            <?php _e("Toggle Menu Close Icon", APMM_TD); ?>
                           <p class='description'>
                                <?php _e("Choose toggle close icon for responsive menubar.", APMM_TD); ?>
                            </p>
                        </td>
                        <td class='apmega-value'>
                            <!-- <div class="toggle_menu_icons"></div> -->
                           <div class="wp-mega-toggle"> 
                            <div class="toggle_menu_icons" id="close">
                              <span class="dash-closedmenu"><i class="<?php echo esc_attr($close_menu_icon);?>"></i></span>
                            </div>
                            <input type="hidden" name="close_menu_icon" id="close_menu_icon" value="<?php echo esc_attr($close_menu_icon);?>"/>
                            <div class="menulistsicons_close">
                            <ul>
                               <li class="wpmm-menuicon">
                                <span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-menu"></i>
                                </span></li>
                                 <li class="wpmm-menuicon"><span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-editor-justify"></i>
                                </span></li>
                                 <li class="wpmm-menuicon"><span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-no"></i>
                                </span></li>
                                 <li class="wpmm-menuicon"><span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-no-alt"></i>
                                </span></li>
                                 <li class="wpmm-menuicon"><span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-arrow-up"></i>
                                </span></li>
                                 <li class="wpmm-menuicon"><span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-arrow-up-alt"></i>
                                </span></li>
                                 <li class="wpmm-menuicon"><span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons  dashicons-plus-alt"></i>
                                </span></li>
                                 <li class="wpmm-menuicon"><span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-arrow-down-alt2"></i>
                                </span></li>
                              </ul>
                            </div>
                         </div>
                          
                        </td>
                    </tr>


                         <tr>
                        <td class='apmega-name'>
                            <?php _e("Toggle Menu Open Icon", APMM_TD); ?>
                           <p class='description'>
                                <?php _e("Choose toggle open icon for responsive menubar.", APMM_TD); ?>
                            </p>
                        </td>
                        <td class='apmega-value'>
                           <div class="wp-mega-toggle"> 
                             <div class="toggle_menu_icons" id="open">
                              <span class="dash-openmenu"><i class="<?php echo esc_attr($open_menu_icon);?>"></i></span>
                            </div>
                            <input type="hidden" name="open_menu_icon" id="open_menu_icon" value="<?php echo esc_attr($open_menu_icon);?>"/>

                            <div class="menulistsicons_open">
                            <ul>
                                <li class="wpmm-menuicon">
                                <span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-menu"></i>
                                </span>
                                </li>
                                 <li class="wpmm-menuicon">
                                 <span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-editor-justify"></i>
                                </span></li>
                                  <li class="wpmm-menuicon">
                                  <span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-no"></i>
                                </span></li>
                                 <li class="wpmm-menuicon">
                                 <span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-no-alt"></i>
                                </span></li>
                                 <li class="wpmm-menuicon">
                                 <span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-arrow-up"></i>
                                </span></li>
                              <li class="wpmm-menuicon">
                                <span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-arrow-up-alt"></i>
                                </span></li>
                                 <li class="wpmm-menuicon">
                                 <span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons  dashicons-plus-alt"></i>
                                </span></li>
                                 <li class="wpmm-menuicon">
                                 <span id="select2-chosen-66" class="select2-chosen">
                                <i class="dashicons dashicons-arrow-down-alt2"></i>
                                </span></li>
                                </ul>
                            </div>

                           </div>

                          
                        </td>
                    </tr>

                   
                </table>

</div>