<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="apmm-settings-main-wrapper how_to_use_page">
  <div class="apmm-header">
  <?php include_once('panel_head.php');?>
    </div>
<div class="container wpmm-hot-to-use-container">
<div class="col-sm-9">

   <h3><?php _e('How to Use',APMM_TD);?></h3>
      <p>       
       <?php 
       _e(' In order to display the mega menu in the frontend for specific menu location, you need to build the menu location first.
        To build menu location and enable AP Mega Menu settings for specific location, you have to setup options provided on WordPress menu page.',APMM_TD);?>
      </p>
      
          <p>
      <?php 
       _e('There are five main settings panels that will help you to setup the plugin default setup and for the menu display in the frontend, you can set the settings for specific menu from menu location page while creating or editing menu which is briefly described below.',APMM_TD);?>
      </p>
    

     <p><?php _e('For full documentation on the plugin, please visit ',APMM_TD);?><a href="https://accesspressthemes.com/documentation/ap-mega-menu/" target="_blank"><?php _e('View Documentation',APMM_TD);?></a></p>

      <h4><?php _e('Menu Settings');?></h4>
       <p>       
       <?php 
       _e('To enable AP Mega Menu for specific menu location, on menu page, you can choose menu location and on left section you can find options settings as Select AP Mega Menu Settings Metabox Options where you
       can enable AP Mega Menu, choose orientation as vertical or horizontal, choose trigger effect (show mega menu on hover or on click effect), transition effect(slide or fade type). Also AP Mega Menu has provided <strong>7 Free Pre Available Templates/Skins</strong> or you can even setup your own custom theme templates and choose it from this section 
       for specific menu location.',APMM_TD);?>
       </p>
       <p><?php _e('To setup mega menu or flyout type for particular menu. On hover menu you can find AP Mega Menu Button where you can setup options menu wise. In these options, you can set mega menu type sub menu for top level menu only.',APMM_TD);?></p>
     
      <dl>
       <dt><strong><?php _e('Top Level Menu Settings',APMM_TD);?></strong></dt>  
        <p><?php _e('This level menu includes 6 main settings.',APMM_TD);?></p>
       <p><?php _e('This level menu includes following tab options:',APMM_TD);?></p>
        <ul>
          <li><strong><?php _e('* AP Mega Menu Settings',APMM_TD);?></strong>
               <ul><li>
               <p><?php _e('In these Settings, you can set the top level menu as mega menu type or 
                  flyout type for its sub menu display.',APMM_TD);?></p>
               </li>
              </ul>
            </li>
            <li><strong><?php _e('* General Settings',APMM_TD);?></strong></strong>
               <ul><li>
               <p><?php _e('General Settings where there is multiple options such as active link, show menu icons, menu label input field, disable menu text, hide menu on desktop, hide menu on mobile, active single menu useful for displaying custom menu, set menu alignment as left or right an sub menu alignment for flyout settings.',APMM_TD);?></p>
               </li>
              </ul>
             </li>
          <li><strong><?php _e('* Mega Menu Settings',APMM_TD);?></strong>
           <ul><li>
               <p><?php _e('In these Settings, you can even setup Mega Menu settings for horizontal position and vertical position. In Mega Menu Settings, you can even add extra top and bottom content with only text, only image or use html content to display for mega menu type only.',APMM_TD);?></p>
               </li>
              </ul>
          </li>
          <li><strong><?php _e('* Flyout Settings',APMM_TD);?></strong>
             <ul><li>
               <p><?php _e('In these Settings, you can set the flyout horizontal or vertical positions.',APMM_TD);?></p>
               </li>
              </ul>
          </li>
          <li><strong><?php _e('* Menu Replacement Settings',APMM_TD);?></strong>
             <ul><li>
               <p><?php _e('Similarly, if you want to display menu in search form then you can simply choose Menu replacement Settings options and select search type from dropdown button options where you can add shortcode to display search form as inline toggle left or right position or mega menu type. Simply you can use the provided search shortcode in textarea.',APMM_TD);?></p>
               </li>
              </ul>
          </li>
           <li><strong><?php _e('* Icon Settings',APMM_TD);?></strong>
             <ul><li>
                    <p><?php _e('This Settings also contain Icon Settings where you can choose menu icon from multiple font icons sets. Menu Icon Settings contains 300+ FontAwesome, 160+ Genericon and 100+ Dashicons.',APMM_TD);?></p>
               </li>
              </ul>
          </li>
        </ul>

       <dt><strong><?php _e('Other Level Menu Settings',APMM_TD);?></strong></dt>  
        <br/>
        <p><?php _e('This level menu includes following tab options:',APMM_TD);?></p>
        <ul>
          <li><strong><?php _e('* Sub Menu Settings',APMM_TD);?></strong>
               <ul><li>
               <p><?php _e('In this Settings, there is multiple options such as active link, show menu icons, menu label input field, disable menu text, hide menu on desktop, hide menu on mobile, active single menu useful for
                displaying custom menu, set menu alignment as left or right(only for top level menu used) an sub menu alignment for flyout settings for sub menu.',APMM_TD);?></p>
               </li>
              </ul>
            </li>
            <li><strong><?php _e('* Icon Settings',APMM_TD);?></strong>
               <ul><li>
               <p><?php _e('These Settings also contain Icon Settings where you can choose menu icon from multiple font icons sets for sub menus. 
                   Menu Icon Settings contains 300+ FontAwesome, 160+ Genericon and 100+ Dashicons.',APMM_TD);?></p>
               </li>
              </ul>
             </li>
          <li><strong><?php _e('* Custom Settings',APMM_TD);?></strong>
           <ul><li>
               <p><?php _e('In these Settings, you can set sub menu as custom settings type where you can extract the post details such as featured image, excerpt, display author, category name, date and read more button. Here, You can even show custom image by choosing custom image and providing
                custom URL link. Similarly, you can display custom or featured image of particular post type sub menu on different position such as top, left or right or only image type on mega menu.',APMM_TD);?></p>
               </li>
              </ul>
          </li>
          <li><strong><?php _e('* Image Settings',APMM_TD);?></strong>
             <ul><li>
               <p><?php _e('In these image settings, you can choose either default image size settings 
               set from Main Image Settings or simply choose different settings from here for particular post type sub menu featured image or custom image size. Also, if you can use custom image on Custom settings then , you can enable to use default custom image size setup before or fill different image size.',APMM_TD);?></p>
               </li>
              </ul>
          </li>
        </ul>


    </dl>
      
      <h3><?php _e('Main Settings',APMM_TD);?></h3>
      <dl>
      <p><?php _e('In general setting, you can setup plugin default settings. This setup includes tab section with general settings, 
      mobile settings, default image settings, menu shortcode , export and import custom theme settings.',APMM_TD);?></p>
       
        <dt><strong><?php _e('General settings',APMM_TD);?></strong></dt>  
        <p><?php _e('In this tab, you can set the default values such as event behavior while clicking event is 
        selected from menu location for specific theme location, menu label animation type with duration, delay, iteration counter.',APMM_TD);?></p>
         
        <dt><strong><?php _e('Mobile settings',APMM_TD);?></strong></dt>
        <p><?php _e('In this settings, you can enable megamenu on mobile version, add substractor after menu,
        choose toggle behavior, menu toggle open and close icons as overall menu locations.',APMM_TD);?></p>
        
        <dt><strong><?php _e('Image settings',APMM_TD);?></strong></dt>
        <p><?php _e('In this tab you can set default settings regarding the wordpress image size options,
        set custom default width as well as menu icon hide/show and define icon width. You can either enable or disable all menu icons. 
        If you want to change the image size according to image shown on specific menus you can even override the settings from specific 
        menu location page.',APMM_TD);?></p>
        
        <dt><strong><?php _e('Shortcode',APMM_TD);?></strong></dt>
        <p><?php _e('In this tab you can use shortcode provided in any page, post content editor or widgets area.
         You can also use php function instead on your template files which specific menu location generated from shortcode tab. In order to display mega menu of specific menu location, firstly, you must need to enable AP Mega Menu from menu page for specific menu location from left section metabox options.',APMM_TD);?></p>
        
         <dt><strong><?php _e('Import',APMM_TD);?></strong></dt>
          <p><?php _e('In this tab, you can import the custom theme json file of this plugin.',APMM_TD);?></p>

         <dt><strong><?php _e('Export',APMM_TD);?></strong></dt>
         <p><?php _e('In this tab, you can export the custom theme json file of this plugin.',APMM_TD);?></p>
        
      </dl>

      <h4><?php _e('Widgets Information');?></h4>
       <p>       
       <?php 
       _e('To display AP Mega Menu of specific menu location, AP Mega Menu has provided AP Mega Menu Widget on widget page where you can
        choose particular menu location and set on the widget area. Else you can use provided shortcode generated from shortcode tab on 
        any other page or default Text Widget.',APMM_TD);?><br/>
           <?php _e('AP Mega Menu Plugin has also provided its own AP Mega Menu Contact Info widgets where you can setup your contact details with multiple font awesome icon class and any shortcode to display on mega menu.',APMM_TD);?>
        </p>



      </div>
      </div>
</div>


<?php include_once(APMM_PATH.'/inc/backend/sidebar-right.php');?>
