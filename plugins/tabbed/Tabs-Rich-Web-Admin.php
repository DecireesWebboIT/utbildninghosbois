<?php
	if(!defined('ABSPATH')) exit;
	if(!current_user_can('manage_options'))
	{
		die('Access Denied');
	}
	global $wpdb;

	$table_name   = $wpdb->prefix . "rich_web_font_family";
	$table_name1  = $wpdb->prefix . "rich_web_icons";
	$table_name2  = $wpdb->prefix . "rich_web_tabs_id";
	$table_name3  = $wpdb->prefix . "rich_web_tabs_manager";
	$table_name4  = $wpdb->prefix . "rich_web_tabs_fields";
	$table_name5  = $wpdb->prefix . "rich_web_tabs_effects_data";

	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if(check_admin_referer( 'edit-menu_'.$comment_id, 'Rich_Web_Tabs_Nonce' ))
		{
			$Rich_Web_Tabs_Name  = str_replace("\&","&", sanitize_text_field(esc_html($_POST['Rich_Web_Tabs_Name'])));
			$Rich_Web_Tabs_Theme = sanitize_text_field($_POST['Rich_Web_Tabs_Theme']);
			$Rich_Web_Tabs_Count = sanitize_text_field($_POST['Rich_Web_Tabs_Count']);

			$Rich_Web_Tabs_SubTitle = array();
			$Rich_Web_Tabs_SubTIcon = array();
			$Rich_Web_Tabs_SubTDesc = array();

			for( $i=1; $i<=$Rich_Web_Tabs_Count; $i++ )
			{
				$Rich_Web_Tabs_SubTitle[$i] = str_replace("\&","&", sanitize_text_field(esc_html($_POST['Rich_Web_Tabs_Add_SubTitle_' . $i])));
				$Rich_Web_Tabs_SubTIcon[$i] = sanitize_text_field($_POST['Rich_Web_Tabs_Add_SubIcon_' . $i]);
				$Rich_Web_Tabs_SubTDesc[$i] = str_replace("\&","&", sanitize_text_field(esc_html($_POST['Rich_Web_Tabs_Editing_Cont_' . $i])));
			}
			if(isset($_POST['Rich_Web_Tabs_Save']))
			{
				$wpdb->query($wpdb->prepare("INSERT INTO $table_name3 (id, Tabs_name, Tabs_theme, SubTitles_Count) VALUES (%d, %s, %s, %d)", '', $Rich_Web_Tabs_Name, $Rich_Web_Tabs_Theme, $Rich_Web_Tabs_Count));
			
				$Tabs_ID=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id>%d order by id desc limit 1",0));
				$Rich_Web_Tabs_Id=$Tabs_ID[0]->Tabs_ID + 1;
				$wpdb->query($wpdb->prepare("INSERT INTO $table_name2 (id, Tabs_ID) VALUES (%d, %d)", '', $Rich_Web_Tabs_Id));
				
				for( $i=1; $i<=$Rich_Web_Tabs_Count; $i++ )
				{
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name4 (id, Tabs_ID, Tabs_Subtitle, Tabs_Subicon, Tabs_Subcontent) VALUES (%d, %d, %s, %s, %s)", '', $Rich_Web_Tabs_Id, $Rich_Web_Tabs_SubTitle[$i], $Rich_Web_Tabs_SubTIcon[$i], $Rich_Web_Tabs_SubTDesc[$i]));
				}
			}
			else if(isset($_POST['Rich_Web_Tabs_Update']))
			{
				$Rich_Web_Tabs_Upd_ID=sanitize_text_field($_POST['Rich_Web_Tabs_Upd_ID']);

				$wpdb->query($wpdb->prepare("UPDATE $table_name3 set Tabs_name=%s, Tabs_theme=%s, SubTitles_Count=%d WHERE id=%d", $Rich_Web_Tabs_Name, $Rich_Web_Tabs_Theme, $Rich_Web_Tabs_Count, $Rich_Web_Tabs_Upd_ID));
				$wpdb->query($wpdb->prepare("DELETE FROM $table_name4 WHERE Tabs_ID=%d", $Rich_Web_Tabs_Upd_ID));
				
				for( $i=1; $i<=$Rich_Web_Tabs_Count; $i++ )
				{
					$wpdb->query($wpdb->prepare("INSERT INTO $table_name4 (id, Tabs_ID, Tabs_Subtitle, Tabs_Subicon, Tabs_Subcontent) VALUES (%d, %d, %s, %s, %s)", '', $Rich_Web_Tabs_Upd_ID, $Rich_Web_Tabs_SubTitle[$i], $Rich_Web_Tabs_SubTIcon[$i], $Rich_Web_Tabs_SubTDesc[$i]));
				}
			}
		}
	    else
	    {
	        wp_die('Security check fail'); 
	    }	
	}
	$Rich_WebIconCount=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name1 WHERE id>%d order by id",0));	
	$Rich_Web_Tabs_ID =$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name2 WHERE id>%d order by id desc limit 1",0));	
	$Rich_Web_Tabs_Dat=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name3 WHERE id>%d",0));
	$Rich_Web_Tabs_Themes=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name5 WHERE id>%d", 0));
?>
<form method="POST" enctype="multipart/form-data">
	<script src='<?php echo plugins_url('/Scripts/tinymce.js',__FILE__);?>'></script>
	<?php wp_nonce_field( 'edit-menu_'.$comment_id, 'Rich_Web_Tabs_Nonce' );?>
	<?php require_once( 'Tabs-Rich-Web-Header.php' ); ?>	
	<div style="position: relative; width: 99%; height: 50px;">
		<input type='button' class='Rich_Web_Tabs_Add'    value='New Tab'    onclick='Rich_Web_Tabs_Added(<?php echo $Rich_Web_Tabs_ID[0]->Tabs_ID+1;?>)'/>
		<input type='submit' class='Rich_Web_Tabs_Save'   value='Save Tab'   name='Rich_Web_Tabs_Save' />
		<input type='submit' class='Rich_Web_Tabs_Update' value='Update Tab' name='Rich_Web_Tabs_Update'/>
		<input type='button' class='Rich_Web_Tabs_Cancel' value='Cancel'     onclick='Rich_Web_Tabs_Canceled()'/>
		<input type='text'   style='display:none' id="Rich_Web_Tabs_Upd_ID"  name='Rich_Web_Tabs_Upd_ID' value="">
    </div>
	<div class='Rich_Web_Tabs_Content'>
		<div class='Rich_Web_Tabs_Content_Data1'>
			<table class='Rich_Web_Tabs_Content_Table'>
				<tr class='Rich_Web_Tabs_Content_Table_Tr'>
					<td>No</td>
					<td>Name</td>
					<td>Theme</td>
					<td>Fields</td>
					<td>Actions</td>
				</tr>
			</table>
			<table class='Rich_Web_Tabs_Content_Table2'>
			<?php for($i=0;$i<count($Rich_Web_Tabs_Dat);$i++){?> 
				<tr class='Rich_Web_Tabs_Content_Table_Tr2'>
					<td><?php echo $i+1; ?></td>
					<td><?php echo $Rich_Web_Tabs_Dat[$i]->Tabs_name; ?></td>
					<td><?php echo $Rich_Web_Tabs_Dat[$i]->Tabs_theme; ?></td>
					<td><?php echo '(' . $Rich_Web_Tabs_Dat[$i]->SubTitles_Count . ')'; ?></td>
					<td onclick="Rich_Web_Tabs_Copy(<?php echo $Rich_Web_Tabs_Dat[$i]->id;?>)"><i class='Rich_Web_Tabs_Clone rich_web rich_web-files-o'></i></td>
					<td onclick="Rich_Web_Tabs_Edit(<?php echo $Rich_Web_Tabs_Dat[$i]->id;?>)"><i class='Rich_Web_Tabs_Edit rich_web rich_web-pencil'></i></td>
					<td onclick="Rich_Web_Tabs_Delete(<?php echo $Rich_Web_Tabs_Dat[$i]->id;?>)"><i class='Rich_Web_Tabs_Del rich_web rich_web-trash'></i></td>
				</tr>
			<?php } ?>
			</table>
		</div>
		<div class="Rich_Web_Tabs_Fixed_Div"></div>
		<div class="Rich_Web_Tabs_Absolute_Div">
			<div class="Rich_Web_Tabs_Relative_Div">
				<p> Are you sure you want to remove ? </p>				 
				<span class="Rich_Web_Tabs_Relative_No">No</span>
				<span class="Rich_Web_Tabs_Relative_Yes">Yes</span>
			</div>			
		</div>
		<div class='Rich_Web_Tabs_Content_Data2'>
			<table class="Rich_Web_Tabs_ShortTable" style="display: table; float: right;">
				<tr style="text-align:center">
					<td>Shortcode</td>
				</tr>
				<tr>
					<td>Copy &amp; paste the shortcode directly into any WordPress post or page.</td>
				</tr>
				<tr>
					<td class="Rich_Web_Tabs_ShortID">[Rich_Web_Tabs id="1"]</td>
				</tr>
				<tr>
					<td>Templete Include</td>
				</tr>
				<tr>
					<td>Copy &amp; paste this code into a template file to include the tab within your theme.</td>
				</tr>
				<tr>
					<td class="Rich_Web_Tabs_ShortID_1">&lt;?php echo do_shortcode(&apos;[Rich_Web_Tabs id="1"]&apos;);?&gt;</td>
				</tr>
			</table>
			<table class="Rich_Web_Tabs_MainTable">
				<tr>
					<td colspan="2">Tabs Title</td>
					<td colspan="2">Select Theme</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" name="Rich_Web_Tabs_Name" id="Rich_Web_Tabs_Name" placeholder="Enter Your Tab's Title . . ."  required>
					</td>
					<td colspan="2">
						<select name="Rich_Web_Tabs_Theme" id="Rich_Web_Tabs_Theme">						
							<option disabled selected>Select Your Theme . . .</option>
							<?php for($i=0;$i<count($Rich_Web_Tabs_Themes);$i++){ ?>
								<option value="<?php echo $Rich_Web_Tabs_Themes[$i]->Rich_Web_Tabs_T_T;?>"><?php echo $Rich_Web_Tabs_Themes[$i]->Rich_Web_Tabs_T_T;?></option>
							<?php }?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="2">SubTitle</td>
					<td colspan="2">Select Icon</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" name="Rich_Web_Tabs_SubTitle" id="Rich_Web_Tabs_SubTitle" placeholder="Enter Your Tab's SubTitle . . .">
					</td>
					<td colspan="2">
						<select name="Rich_Web_Tabs_SubTIcon" id="Rich_Web_Tabs_SubTIcon" style="font-family: 'FontAwesome', Arial;">						
							<option value="none" selected> None </option>
							<?php for($i=0;$i<count($Rich_WebIconCount);$i++){ ?> 
								<option value="<?php echo strtolower(str_replace(" ", "-", $Rich_WebIconCount[$i]->Icon_Name));?>"><?php echo '&#x' . $Rich_WebIconCount[$i]->Icon_Type . '&nbsp; &nbsp; &nbsp;' . $Rich_WebIconCount[$i]->Icon_Name;?></option>
							<?php }?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						Content For SubTitle
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div style="padding: 0 !important;">
							<textarea id="Rich_Web_Tabs_Editing_Cont">
							  
							</textarea>
						</div>
					</td>						
				</tr>
				<tr>
					<td class="Rich_Web_Tabs_Add_Tab" colspan="4">
						<input type='button' class='Rich_Web_Tabs_Sav_Tab' onclick="Rich_Web_Sav_Tabs_Tab()" value='Save'   />
						<input type='button' class='Rich_Web_Tabs_Upd_Tab' onclick="Rich_Web_Upd_Tabs_Tab()" value='Update' />
						<input type='button' class='Rich_Web_Tabs_Res_Tab' onclick="Rich_Web_Res_Tabs_Tab()" value='Reset'  />
						<input type="text" style="display:none;" id="Rich_Web_Tabs_Count" name="Rich_Web_Tabs_Count" value="0">
						<input type="text" style="display:none;" id="Rich_Web_Tabs_HidUp" value="0">
					</td>
				</tr>
			</table>
			<table class='Rich_Web_Save_Tabs_Table1'>
				<tr>
					<td> No </td>
					<td> SubTitle </td>
					<td> Icon </td>
					<td> Clone </td>
					<td> Edit </td>
					<td> Delete </td>
				</tr>
			</table>
			<table class='Rich_Web_Save_Tabs_Table2' onmousemove="Rich_Web_Tabs_Sortable()">
			
			</table>
		</div>
    </div>
</form>