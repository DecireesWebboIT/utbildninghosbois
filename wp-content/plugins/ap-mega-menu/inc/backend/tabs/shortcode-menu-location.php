<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<?php 
$menus = get_registered_nav_menus();
$location_settings = new AP_Menu_Settings();
?>

<div class="apmega_left_content_wrapper shortcode_menu_location">
 <div class="apmm-header1 wpmega-shortcode"><?php _e("Shortcodes", APMM_TD); ?></div>
<div class="form-style-2">
  <p class="description"><?php _e('Note: You can use this plugin to display menu using below shortcode.',APMM_TD);?></p>
  <table>
        <tr>
            <td class="apmega-name">
            <label for="field1">
            <?php _e('Integrate Specific Theme Location',APMM_TD);?> </label>
               <p class="description"><?php _e('Select a Theme Location below to generate the proper code below ',APMM_TD);?></p>
           </td>
           <td class="apmega-value">
              <select class="menu_shortcode wpmm-selection">
                <?php  if ( count ( $menus ) ) {
                 foreach ( $menus as $location => $description ) { ?>
                  <option value="<?php echo $location;?>"><?php _e($description,APMM_TD);?></option>
                <?php }
                } ?>
              </select>
           
          </td>
</tr>
</table>
<!-- <div class="clear"></div> -->

  <?php  if ( count ( $menus ) ) {
       foreach ( $menus as $location => $description ) {
        $menu_id = $location_settings->wpmm_get_menu_id_for_location( $location );
         ?>
    <div class="wpmegamenu-integration-code" id="wpmm-integration-<?php echo $location;?>" style="display: none;">
     <table>
        <tr>
          <td class="apmega-name">
     <div class="manual_intergration"><?php _e('Manual Integration Code',APMM_TD);?></div>
     </td>
      <td class="apmega-value">
      <div class="right_code">
     
      <div class="menuname">
      <p class="menu_name"><?php _e(ucwords($location),APMM_TD);?></p>
      <p class="location_name"><?php _e('Menu Location Name: ',APMM_TD);?><?php _e($description,APMM_TD);?>
      <?php if($menu_id != '' || $menu_id != 0){ ?>
      <a href='<?php echo admin_url("nav-menus.php?action=edit&menu={$menu_id}");?>'>
      <i class="fa fa-pencil-square-o" aria-hidden="true"></i><?php _e('Edit',APMM_TD);?>
      </a>
     <?php }else{?>
     <br/><em><?php _e('(You havenot assigned this theme location with any menu.)',APMM_TD); ?>
     <a href='<?php admin_url('nav-menus.php?action=locations');?>'><?php _e("Assign a menu", APMM_TD);?></a></em>
     <?php } ?>
      </p></div>
      <div class="wpmegamenu-desc-row">
      <code class="wpmegamenu-highlight-code">
       <span class="wpmegamenu-code-snippet-type"><?php _e("PHP Function", APMM_TD);?>
        <p class="description"> <?php _e("For use in a theme template (usually header.php)", APMM_TD); ?>
        </p></span>
       <span class="highlightcode">
      &lt;?php wp_nav_menu( array( 'theme_location' => '<?php echo $location ?>' ) ); ?&gt;</span></code>
      </div>
      <div class="wpmegamenu-desc-row">  
        <code class="wpmegamenu-highlight-code">
        <span class="wpmegamenu-code-snippet-type"><?php _e("Shortcode", APMM_TD);?>
        <p class="description"> <?php _e("Shortcodes for use in a post or page with specific menu location.", APMM_TD); ?>
        </p></span>
         <span class="highlightcode">[wpmegamenu menu_location="<?php _e($location,APMM_TD);?>"]</span></code>
      </div>

      <div class="wpmegamenu-desc-row">  
        <code class="wpmegamenu-highlight-code">
        <span class="wpmegamenu-code-snippet-type"><?php _e("Widget", APMM_TD);?>
        <p class="description"> <?php _e("For Widget, add this shortcode in your widget area.", APMM_TD); ?></p></span>
        <span class="highlightcode">[wpmegamenu menu_location="<?php _e($location,APMM_TD);?>"]</span></code>
      </div>
      </div>
   </td>
   </tr>
   </table>
    </div>
   <?php }
      } ?>
</div>
</div>
<div class="clear"></div>