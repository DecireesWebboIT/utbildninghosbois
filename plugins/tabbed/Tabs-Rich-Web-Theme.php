<?php
	if(!defined('ABSPATH')) exit;
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	global $wpdb;
	$table_name   = $wpdb->prefix . "rich_web_font_family";
	$table_name5  = $wpdb->prefix . "rich_web_tabs_effects_data";
	$table_name6  = $wpdb->prefix . "rich_web_tabs_effect_1";
	
	$Rich_WebFontCount = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id>%d",0));
	$Rich_Web_Tabs_Dat = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE id>%d",0));
?>
<form method="POST" enctype="multipart/form-data">
	<?php require_once( 'Tabs-Rich-Web-Header.php' ); ?>	
	<div style="position: relative; width: 99%; height: 50px;">
		<input type='button' class='Rich_Web_Tabs_Add_Theme'    value='New Theme (Pro)' onclick='Rich_Web_Tabs_Added_Theme()'/>
		<input type='button' class='Rich_Web_Tabs_Cancel_Theme' value='Cancel' onclick='Rich_Web_Tabs_Theme_Canceled()'/>
    </div>
	<div class='Rich_Web_Tabs_Content_Theme'>
		<div class='Rich_Web_Tabs_Content_Data1_Theme'>
			<table class='Rich_Web_Tabs_Content_Table_Theme'>
				<tr class='Rich_Web_Tabs_Content_Table_Tr_Theme'>
					<td>No</td>
					<td>Theme Name</td>
					<td>Actions</td>
				</tr>
			</table>
			<table class='Rich_Web_Tabs_Content_Table2_Theme'>
			<?php for($i=0;$i<count($Rich_Web_Tabs_Dat);$i++){?> 
				<tr class='Rich_Web_Tabs_Content_Table_Tr2_Theme'>
					<td><?php echo $i+1; ?></td>
					<td><?php echo $Rich_Web_Tabs_Dat[$i]->Rich_Web_Tabs_T_T; ?></td>
					<td onclick="Rich_Web_Tabs_Copy_Theme(<?php echo $Rich_Web_Tabs_Dat[$i]->id;?>)"><i class='Rich_Web_Tabs_Copy rich_web rich_web-files-o'></i></td>
					<td onclick="Rich_Web_Tabs_Edit_Theme(<?php echo $Rich_Web_Tabs_Dat[$i]->id;?>)"><i class='Rich_Web_Tabs_Edit rich_web rich_web-pencil'></i></td>
					<td onclick='Rich_Web_Tabs_Added_Theme()'><i class='Rich_Web_Tabs_Del rich_web rich_web-trash'></i></td>
				</tr>
			<?php } ?>
			</table>
		</div>
		<div class='Rich_Web_Tabs_Content_Data2_Theme'>
			<table class="Rich_Web_Tabs_Content_Table3_Theme Rich_Web_Tabs_Content_Table3_Theme_1">
				<tr>
					<td colspan="4">General Options</td>
				</tr>
				<tr>
					<td>Theme Name <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Width (%) <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Align <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Content Animation <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_T" placeholder="Theme Title. . ."  required>
					</td>
					<td>
						<div class="Rich_Web_Tabs_Range">  
							<input class="Rich_Web_Tabs_Range__range" type="range" id="Rich_Web_Tabs_T_W" name="" value="" min="0" max="100">
							<span class="Rich_Web_Tabs_Range__value" id="Rich_Web_Tabs_T_W_Span">0</span>
						</div>
					</td>
					<td>
						<select name="Rich_Web_Tabs_T_Al" id="Rich_Web_Tabs_T_Al">
							<option value="left">   Left   </option>
							<option value="right">  Right  </option>
							<option value="center"> Center </option>
						</select>
					</td>
					<td>
						<select name="" id="Rich_Web_Tabs_T_CA">
							<option value="Random">          Random            </option>
							<option value="Scale">           Scale             </option>
							<option value="FadeUp">          Fade Up           </option>
							<option value="FadeDown">        Fade Down         </option>
							<option value="FadeLeft">        Fade Left         </option>
							<option value="FadeRight">       Fade Right        </option>
							<option value="SlideUp">         Slide Up          </option>
							<option value="SlideDown">       Slide Down        </option>
							<option value="SlideLeft">       Slide Left        </option>
							<option value="SlideRight">      Slide Right       </option>
							<option value="ScrollDown">      Scroll Down       </option>
							<option value="ScrollUp">        Scroll Up         </option>
							<option value="ScrollRight">     Scroll Right      </option>
							<option value="ScrollLeft">      Scroll Left       </option>
							<option value="Bounce">          Bounce            </option>
							<option value="BounceLeft">      Bounce Left       </option>
							<option value="BounceRight">     Bounce Right      </option>
							<option value="BounceDown">      Bounce Down       </option>
							<option value="BounceUp">        Bounce Up         </option>
							<option value="HorizontalFlip">  Horizontal Flip   </option>
							<option value="VerticalFlip">    Vertical Flip     </option>
							<option value="RotateDownLeft">  Rotate Down Left  </option>
							<option value="RotateDownRight"> Rotate Down Right </option>
							<option value="RotateUpLeft">    Rotate Up Left    </option>
							<option value="RotateUpRight">   Rotate Up Right   </option>
							<option value="TopZoom">         Top Zoom          </option>
							<option value="BottomZoom">      Bottom Zoom       </option>
							<option value="LeftZoom">        Left Zoom         </option>
							<option value="RightZoom">       Right Zoom        </option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Navigation Mode <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Navigation Align <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td>
						<select name="" id="Rich_Web_Tabs_T_NavM" onchange="Rich_Web_Tabs_T_NavM_Ch()">
							<option value="horizontal"> Horizontal </option>
							<option value="vertical">   Vertical   </option>
						</select>
					</td>
					<td>
						<select name="Rich_Web_Tabs_T_NavAl" id="Rich_Web_Tabs_T_NavAl">
							<option class="Rich_Web_Tabs_T_NavM_H" value="left">   Left   </option>
							<option class="Rich_Web_Tabs_T_NavM_H" value="right">  Right  </option>
							<option class="Rich_Web_Tabs_T_NavM_H" value="center"> Center </option>
							<option class="Rich_Web_Tabs_T_NavM_V" value="top">    Top    </option>
							<option class="Rich_Web_Tabs_T_NavM_V" value="bottom"> Bottom </option>
						</select>
					</td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="4">Navigation Options</td>
				</tr>
				<tr>
					<td>Style <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Main Background Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Main Border Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Place Between (px) <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
				</tr>
				<tr>
					<td>
						<select name="" id="Rich_Web_Tabs_T_N_S">
							<option value="Rich_Web_Tabs_tabs_1">  Bar               </option>
							<option value="Rich_Web_Tabs_tabs_2">  Icon box          </option>
							<option value="Rich_Web_Tabs_tabs_3">  Underline         </option>
							<option value="Rich_Web_Tabs_tabs_4">  Triangle and line </option>
							<option value="Rich_Web_Tabs_tabs_5">  Top Line          </option>
							<option value="Rich_Web_Tabs_tabs_6">  Falling Icon      </option>
							<option value="Rich_Web_Tabs_tabs_7">  Moving Line       </option>
							<option value="Rich_Web_Tabs_tabs_8">  Line              </option>
							<option value="Rich_Web_Tabs_tabs_9">  Circle            </option>
							<option value="Rich_Web_Tabs_tabs_11"> Line Box          </option>
							<option value="Rich_Web_Tabs_tabs_12"> Flip              </option>
							<option value="Rich_Web_Tabs_tabs_13"> Circle fill       </option>
							<option value="Rich_Web_Tabs_tabs_14"> Fill up           </option>
							<option value="Rich_Web_Tabs_tabs_15"> Trapezoid         </option>
						</select>
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_N_MBgC" class="Rich_Web_Tab_Col alpha-color-picker" value="">
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_N_MBC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<div class="Rich_Web_Tabs_Range">  
							<input class="Rich_Web_Tabs_Range__range" type="range" id="Rich_Web_Tabs_T_N_PB" name="" value="" min="0" max="15">
							<span class="Rich_Web_Tabs_Range__value" id="Rich_Web_Tabs_T_N_PB_Span">0</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Inset Box Shadow Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Outset Box Shadow Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Font Size (px) <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Font Family <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_N_IBSh" class="Rich_Web_Tab_Col alpha-color-picker" value="">
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_N_OBSh" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<div class="Rich_Web_Tabs_Range">  
							<input class="Rich_Web_Tabs_Range__range" type="range" id="Rich_Web_Tabs_T_N_FS" name="" value="" min="8" max="48">
							<span class="Rich_Web_Tabs_Range__value" id="Rich_Web_Tabs_T_N_FS_Span">0</span>
						</div>
					</td>
					<td>
						<select id="Rich_Web_Tabs_T_N_FF" name="">
							<?php for($i=0;$i<count($Rich_WebFontCount);$i++){ ?> 
								<option value="<?php echo $Rich_WebFontCount[$i]->Font_family;?>"><?php echo $Rich_WebFontCount[$i]->Font_family;?></option>
							<?php }?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Icon Size (px) <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td>
						<div class="Rich_Web_Tabs_Range">  
							<input class="Rich_Web_Tabs_Range__range" type="range" id="Rich_Web_Tabs_T_N_IS" name="" value="" min="8" max="72">
							<span class="Rich_Web_Tabs_Range__value" id="Rich_Web_Tabs_T_N_IS_Span">0</span>
						</div>
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="4">SubTitle Options</td>
				</tr>
				<tr>
					<td>Background Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Hover Background Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Hover Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_S_BgC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_S_C" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_S_HBgC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_S_HC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
				</tr>
				<tr>
					<td>Current Background Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Current Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_S_CBgC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_S_CC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="4">Content Options</td>
				</tr>
				<tr>
					<td>Background Type <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Background Color 1 <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Background Color 2 <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Border Width (px) <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
				</tr>
				<tr>
					<td>
						<select name="" id="Rich_Web_Tabs_T_C_BgT">
							<option value="color"       > Color       </option>
							<option value="transparent" > Transparent </option>
							<option value="gradient"    > Gradient    </option>
						</select>
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_C_BgC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_C_BgC2" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<div class="Rich_Web_Tabs_Range">  
							<input class="Rich_Web_Tabs_Range__range" type="range" id="Rich_Web_Tabs_T_C_BW" name="" value="" min="0" max="10">
							<span class="Rich_Web_Tabs_Range__value" id="Rich_Web_Tabs_T_C_BW_Span">0</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Border Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Border Radius (px) <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Inset Box Shadow Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
					<td>Outset Box Shadow Color <span class="Rich_Web_Tabs_T_Pro">(Pro)</span></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_C_BC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<div class="Rich_Web_Tabs_Range">  
							<input class="Rich_Web_Tabs_Range__range" type="range" id="Rich_Web_Tabs_T_C_BR" name="" value="" min="0" max="20">
							<span class="Rich_Web_Tabs_Range__value" id="Rich_Web_Tabs_T_C_BW_Span">0</span>
						</div>
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_C_IBSC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
					<td>
						<input type="text" name="" id="Rich_Web_Tabs_T_C_OBSC" class="Rich_Web_Tab_Col alpha-color-picker" value="">						
					</td>
				</tr>
			</table>
		</div>
    </div>
</form>