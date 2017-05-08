<div class="apmega_left_content_wrapper custom_css">

<div class="apmm-header1 wpmega-css"><?php _e("Custom CSS", APMM_TD); ?></div>
<table>
    <tr>
        <td class='apmega-name'>
            <label for="enable_custom_css"><?php _e('Enable Custom CSS',APMM_TD);?>
            <p class="description"><?php _e('Import custom theme using json file.',APMM_TD);?></p>
        </td>
        <td class='apmega-value'>
           <div class="wpmm-switch">
              <input type="checkbox" name="enable_custom_css" id="enable_custom_css" value="1" <?php if($enable_custom_css  == 1) echo "checked";?>/>
             <label for="enable_custom_css"></label>
           </div>
           <p class="description"><?php _e('Do you want to enable below custom css?',APMM_TD)?></p>
        </td>
    </tr>
        
    </tr>
</table>
<textarea name="custom_css" id="wpmm_custom_css" class="large-text code" dir="ltr" style="width:100%;height:350px;"><?php echo $custom_css;?></textarea>
<p class="description"><?php _e( 'Please write your custom css here that you want to be included for ap mega menu.', APMM_TD ); ?> </p>



</div>