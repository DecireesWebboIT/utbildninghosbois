<div class="apmega_left_content_wrapper custom_theme_import">

<div class="apmm-header1 wpmega-import"><?php _e("Import", APMM_TD); ?></div>
<table>
    <tr>
        <td class='apmega-name'>
            <?php _e("Upload Import File", APMM_TD); ?>
            <p class="description"><?php _e('Import custom theme using json file.',APMM_TD);?></p>
        </td>
        <td class='apmega-value'>
           <!-- <input type="file" name="import_theme_file"/>  -->

		    <input id="wpmm_uploadFile" placeholder="Choose File" disabled="disabled" />
			<div class="fileUpload btn btn-primary">
			    <span>Upload</span>
			    <input id="wpmm_uploadBtn" type="file" class="upload" name="import_theme_file" />
			</div>

        </td>
    </tr>

   
</table>

 <div class="wpmm-field">
 <input type="submit" name="import_submit" value="<?php _e('Import',APMM_TD);?>" class="button-primary"/>
</div>  

</div>

<div class="apmega_left_content_wrapper custom_theme_export">
<div class="apmm-header1 wpmega-export"><?php _e("Export", APMM_TD); ?></div>

<table>
    <tr>
        <td class='apmega-name'>
            <?php _e("Choose Custom Theme to Export", APMM_TD); ?>
        </td>
        <td class='apmega-value'>
        <select name="custom_theme_id" class="wpmm-selection"> 
           <option value=""><?php _e( 'Select One', APMM_TD ); ?></option>
               <?php 
                    if(!empty($custom_theme)){
                           foreach ($custom_theme as $key => $value) {
                            $theme_name = $value->title;
                            $theme_id = $value->theme_id; ?>
                        <option value="<?php echo $theme_id;?>"><?php _e($theme_name,APMM_TD);?></option>    
                          <?php }

            }?>
         </select>
         
        </td>
    </tr>

   
</table>
<div class="wpmm-field">
 <input type="submit" name="export_submit" value="<?php _e('Export',APMM_TD);?>" class="button-primary"/>
</div>    

</div>