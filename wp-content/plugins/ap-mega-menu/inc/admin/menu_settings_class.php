<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if ( ! class_exists( 'AP_Menu_Settings' ) ) :

/**
 * Admin Menu Settings
 */
class AP_Menu_Settings {

  var $wpmmenu_id = 0;
  var $wpmmenu_item_id = 0;
  var $wpmmenu_item_depth = 0;
  var $wpmmenu_item_meta = array();


    /**
     * Constructor
     */
    public function __construct() {
              add_action( 'admin_menu' , array($this ,  'apmm_menu_page') ); // add plugin menu
              add_action('admin_enqueue_scripts', array($this, 'apmegamenu_admin_scripts'));
              add_action( 'wp_megamenu_nav_menus_scripts', array( $this, 'enqueue_menu_page_scripts' ), 9 );
              add_action('admin_post_apmegamenu_save_settings',array($this,'apmegamenu_save_settings')); //recieves the posted values from general settings
             /* custom metabox to enable */
              add_action( 'admin_head', array($this, 'addAPMegamenuMetaBox')); // Metabox on left of menu to enable megamenu
              add_action( 'wp_ajax_apmm_save_settings', array($this, 'wp_save_settings') ); //ajax ap menu settings save to options
              add_action( 'wp_ajax_wpmm_show_lightbox_html', array( $this, 'wpmm_getlightbox_by_ajax' ) );
              add_action( 'wp_ajax_wpmm_save_menuitem_settings', array( $this, 'save_menuitem_settings_byajax') ); //save ajax data of each menu item
              add_action('admin_footer', array( $this, 'wpmm_admin_footer_function' ));

     }


    /**
     * Set up the class
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    private function wpmm_init() {

        if ( isset( $_POST['menu_item_id'] ) ) {

            $this->wpmmenu_item_id = absint( $_POST['menu_item_id'] );

            $saved_settings = array_filter( (array) get_post_meta( $this->wpmmenu_item_id, '_wpmegamenu', true ) );

           $this->wpmmenu_item_meta =  $saved_settings;

        }

        if ( isset( $_POST['menu_item_depth'] ) ) {

            $this->wpmmenu_item_depth = absint( $_POST['menu_item_depth'] );

        }


        if ( isset( $_POST['menu_id'] ) ) {

            $this->wpmmenu_id = absint( $_POST['menu_id'] );

        }

    }

    /**
     * Return the default settings for each menu item
    */
    public static function wpmm_menu_item_defaults() {

        $defaults = array(
            'menu_type'              => 'flyout', //flyout or megamenu
            'panel_columns'          => 6, // total number of columns displayed in the panel
            'wpmm_mega_menu_columns' => 1, // for sub menu items, how many columns to span in the panel,
            'wp_menu_order'          => 0,
            'general_settings'       => array(
                  'active_link'             => 'true',
                  'disable_text'            => 'false',
                  'visible_hidden_menu'     => 'false',
                  'hide_arrow'              => 'false',
                  'hide_on_mobile'          => 'false',
                  'hide_on_desktop'         => 'false',
                  'menu_icon'               => 'disabled',
                  'active_single_menu'      => 'disabled',   //useful for custom single menu links
                  'menu_align'              => 'left',      //default as left with left or right menitem useful for custom search bar:Right aligned items will appear in reverse order on the right hand side of the menu bar            
                  'top_menu_label'          => '',         // Hot! , New! for top menu
                  'hide_sub_menu_on_mobile' => 'false',
                  'submenu_align'           => 'left'       //left or right, // flyout menu
            ),
           'mega_menu_settings'      => array(
                    'horizontal-menu-position' => 'full-width', //full-width, center, left-edge and right-edge
                   'vertical-menu-position'    => 'full-height', //full-height or aligned-to-parent
                   'show_top_content'          => 'true',
                   'show_bottom_content'       => 'true',
                   'top' => array(
                        'top_content_type'     => 'text_only',
                        'top_content'          => '',
                        'image_url'            =>  '',
                        'html_content'         => ''
                    ),
                'bottom'                   => array(
                        'bottom_content_type'  => 'text_only',
                        'bottom_content'       => '',
                        'image_url'            => '',
                        'html_content'         => ''
                    ),
                    'choose_menu_type'         => 'default',  // for default as sub menu and search form display with custom content for shortcodes.
                    'custom_content'           => ''
              ),
           'flyout_settings'                => array(
                    'flyout-position'          => 'right',       //left or right
                    'vertical-position'        => 'full-height',// full-hegiht or aligned-to-parent,
                 ),
            'icons_settings'                => array(
                 'icon_choose'                => '',
                ),
             'upload_image_settings'    => array(
               'use_custom_settings'        => 'false',
               'text_position'              => 'left' ,          // left image, right image or onlyimage , for pro : above, below and image only.
               'display_posts_images'       =>'featured-image', //featured-image or custom-image of posts
               'default_thumbnail_imageurl' => '',
               'show_description'           => 'true',
               'show_desc_length'           => '',
               'display_readmore'           => 'true',
               'readmore_text'              => 'Read more >>',
               'display_post_date'          => 'true',
               'display_author_name'        => 'true',
               'display_cat_name'           => 'true',
               'image_size'                 => 'default',
               'enable_custom_inherit'      => '1',
               'custom_width'               => ''
              ),

            
        );


          $wpmm_default_settings = get_option('wpmm_default_settings');
            if (empty($wpmm_default_settings)) {
                update_option('wpmm_default_settings', $defaults);
            }

            return $wpmm_default_settings;

    }


         /*
		  * Includes ALl Class Files Here
		  */
		function apmm_menu_page(){

			      add_menu_page( __(APMM_TITLE,APMM_TD), __(APMM_TITLE,APMM_TD),'manage_options',APMM_TD, array($this, 'ap_main_page'),'');
            add_submenu_page(APMM_TD, __('General Settings',APMM_TD), __('General Settings',APMM_TD), 'manage_options', APMM_TD, array($this, 'ap_main_page'));    
            add_submenu_page(APMM_TD, __('Theme Settings',APMM_TD), __('Theme Settings',APMM_TD), 'manage_options', 'wpmm-theme-settings', array($this, 'add_theme_settings'));
            add_submenu_page(APMM_TD, __('How to Use',APMM_TD), __('How to Use',APMM_TD), 'manage_options', 'wpmm-how-to-use', array($this, 'how_to_use_page'));
            add_submenu_page(APMM_TD, __('About',APMM_TD), __('About',APMM_TD), 'manage_options', 'wpmm-about-us', array($this, 'about_us_page'));
           
           if(isset($_GET['action']) && $_GET['action'] == 'edit_theme'){
            add_submenu_page('null', __('Edit theme',APMM_TD),__('Edit theme',APMM_TD), 'manage_options', 'wpmm-add-theme', array($this, 'apmm_add_theme'));
          }else{
             add_submenu_page('null', __('Create theme',APMM_TD),__('Create theme',APMM_TD), 'manage_options', 'wpmm-add-theme', array($this, 'apmm_add_theme'));
          }
		}

		 /*
     * Main Settings Page
     */
      function ap_main_page(){
        //theme settings or main page
        include_once(APMM_PATH.'/inc/backend/main_page.php');
		 }

    /*
     * Theme Lists Page
     */
     function add_theme_settings(){
      include_once(APMM_PATH.'/inc/backend/view/theme_lists_settings.php');
     }

     /*
     * How to use Page
     */
     function how_to_use_page(){
      include_once(APMM_PATH.'/inc/backend/how_to_use.php');
     }

     /*
     *About Us Page
     */
     function about_us_page(){
       include_once(APMM_PATH.'/inc/backend/about.php');
     }

     /*
     * Create New Theme Page
     */  
     function apmm_add_theme(){
      include_once(APMM_PATH.'/inc/backend/view/add_theme_settings.php');
     }

       /*
      *  Saves General Settings to database
      */
         function apmegamenu_save_settings(){
            if(!empty($_POST) && wp_verify_nonce($_POST['apmegamenu-nonce-setup'],'apmegamenu-nonce')){
                if(isset($_POST['settings_submit'])){
                  include_once(APMM_PATH.'/inc/backend/save_settings.php');
                }else if(isset($_POST['export_submit'])){
                      $custom_theme_id = sanitize_text_field( $_POST['custom_theme_id'] );
                      if ( $custom_theme_id != '' ) {

                          $theme_details = AP_Theme_Settings::get_theme_detail( $custom_theme_id );
                          // echo "<pre>";
                          // print_r($theme_details);  
                          // echo "</pre>";
                          // die();
                          $filename = sanitize_title( $theme_details['title'] );
                          $json = json_encode( $theme_details );

                          header( 'Content-disposition: attachment; filename=' . $filename . '.json' );
                          header( 'Content-type: application/json' );

                          echo( $json);
                      }else{
                         wp_redirect( admin_url( 'admin.php?page=ap-mega-menu' ) );
                         exit;
                      } 

                }else if(isset($_POST['import_submit'])){
                    if ( !empty( $_FILES ) && $_FILES['import_theme_file']['name'] != '' ) {
                    $filename = $_FILES['import_theme_file']['name'];
                    $filename_array = explode( '.', $filename );
                    $filename_ext = end( $filename_array );
                    if ( $filename_ext == 'json' ) {

                        $new_filename = 'import-' . rand( 111111, 999999 ) . '.' . $filename_ext;
                        $upload_path = APMM_PATH . 'temp/' . $new_filename;
                        $source_path = $_FILES['import_theme_file']['tmp_name'];
                        $check = @move_uploaded_file( $source_path, $upload_path );

                        if ( $check ) {

                            $url = APMM_URL . 'temp/' . $new_filename;
                            $params = array(
                                'sslverify' => false,
                                'timeout' => 60
                            );
                            $connection = wp_remote_get( $url, $params );
                            if ( !is_wp_error( $connection ) ) {
                                $body = $connection['body'];
                                
                                $theme_row = json_decode( $body );
                         
                                unlink( $upload_path );
                                $check = AP_Theme_Settings::import_custom_theme( $theme_row );
                                if ( $check ) {
                                    $_SESSION['apmm_success'] = __( 'Custom Theme imported successfully.', APMM_TD );
                                     wp_redirect( admin_url( 'admin.php?page=ap-mega-menu' ) );
                                    exit;

                                } else {
                                    $_SESSION['apmm_error'] = __( 'Something went wrong. Please try again later.', APMM_TD );
                                }
                            } else {

                                $_SESSION['apmm_error'] = __( 'Something went wrong. Please try again.', APMM_TD );
                            }
                        } else {
                            $_SESSION['apmm_error'] = __( 'Something went wrong. Please check the write permission of temp folder inside the plugin\'s folder', APMM_TD );
                        }
                    } else {
                        $_SESSION['apmm_error'] = __( 'Invalid File Extension', APMM_TD );
                    }
                }else{
                  $_SESSION['apmm_error'] = __( 'No any file uploaded.', APMM_TD );
                }

                }else if(isset($_POST['restore_old_settings'])){
                   $default_settings = APMM_Class::apmm_default_settings();
                   update_option('apmega_settings', $default_settings);
                   $_SESSION['apmm_success'] = __( 'Restored Default Settings Successfully.', APMM_TD );
                   wp_redirect( admin_url() . 'admin.php?page=ap-mega-menu');
                }
                
            }
            else{
                die('No script kiddies please!');
            }
         }
         

        

      /*
       *  Admin Enqueue style and js
       */
       function apmegamenu_admin_scripts( $hook ){
            $plugin_pages = array( APMM_TD,'wpmm-theme-settings','wpmm-how-to-use','wpmm-add-theme','wpmm-edit-theme','wpmm-about-us','ap-mega-menu');
            if ( isset( $_GET['page'] ) && in_array( $_GET['page'], $plugin_pages ) ) {
            wp_enqueue_style( 'wp_megamenu-bootstrap-style', APMM_CSS_DIR . '/bootstrap.min.css', false, APMM_TD );
            wp_enqueue_style( 'wp_megamenu-verticaltabs-style', APMM_CSS_DIR . '/bootstrap.vertical-tabs.css', false, APMM_TD );
            wp_enqueue_script( 'wp_megamenu-bootstrap-scripts', APMM_JS_DIR . '/bootstrap.min.js',array('jquery') ,false, APMM_TD );
            wp_enqueue_style('wp-color-picker'); //for including color picker css
            wp_enqueue_style( 'wpmm-custom-select-css', APMM_CSS_DIR . '/jquery.selectbox.css', array(), APMM_TD );
            wp_enqueue_style( 'wp_megamenu-admin-style', APMM_CSS_DIR . '/backend.css', false, APMM_TD );
         
            wp_enqueue_script( 'wp_megamenu-color-alpha-scripts', APMM_JS_DIR . '/wp-color-picker-alpha.js',array('wp-color-picker') ,false, APMM_TD );
            
            wp_enqueue_style('wpmm-icon-picker-font-awesome',APMM_CSS_DIR.'/wpmm-icons/font-awesome/font-awesome.css', false, APMM_TD );
            wp_enqueue_style('wpmm-codemirror-css', APMM_CSS_DIR . '/syntax/codemirror.css', false , APMM_TD );
            wp_enqueue_script( 'wpmm-codemirror-js', APMM_JS_DIR . '/syntax/codemirror.js', array('jquery'), APMM_TD );
            wp_enqueue_script( 'wpmm-codemirror-css-js', APMM_JS_DIR . '/syntax/css.js', array('jquery', 'wpmm-codemirror-js'), APMM_TD );
      

         
          }
            wp_enqueue_script( 'wp-megamenu-custom-select-js', APMM_JS_DIR . '/jquery.selectbox-0.2.min.js', array( 'jquery' ), APMM_TD );
             wp_enqueue_script('wp_megamenu-admin-scripts', APMM_JS_DIR . '/backend.js',array('jquery','jquery-ui-core','wp-color-picker',
              'wp-megamenu-custom-select-js') ,false, APMM_TD );
            
         
     
          

       }

    /**
     * Enqueue required CSS and JS for AP Mega Menu
     */
       function enqueue_menu_page_scripts( $hook ){
       // echo "hook".$hook;

          if( 'nav-menus.php' != $hook )
                      return;

          $apmm_variable = array(
                    'plugin_javascript_path' => APMM_JS_DIR,
                    'depth_check_message' => __('Option only available for top level menu.',APMM_TD),
                    'success_msg' => __('Successfully Saved.',APMM_TD),
                    'saving_msg' => __('Saving Data.',APMM_TD),
                    'menu_lightbox' => __("AP Mega Menu", APMM_TD),
                    'ajax_url' => admin_url() . 'admin-ajax.php',
                    'checked_disabled_error' => __("Please enable AP Mega Menu using the AP Mega Menu Settings on left section of this page.", APMM_TD),
                    'ajax_nonce' => wp_create_nonce('apmm-ajax-nonce'));
        
            wp_localize_script( 'wp_megamenu-admin-scripts', 'apmm_variable', $apmm_variable ); //localization of php variable in edn-pro-frontend-js
            wp_enqueue_style( 'wp_megamenu-admin-style', APMM_CSS_DIR . '/backend.css', false, APMM_TD );
            wp_enqueue_media();
            wp_enqueue_script('accordion');
            wp_enqueue_script( 'wpmm-ckeditor-js', APMM_JS_DIR . '/ckeditor/ckeditor.js', array( 'jquery' ), APMM_TD );
            wp_enqueue_script( 'wpmm-ckfinder-js', APMM_JS_DIR . '/ckfinder/ckfinder.js', array( 'jquery' ), APMM_TD );
            wp_enqueue_script( 'wp-megamenu-custom-select-js', APMM_JS_DIR . '/jquery.selectbox-0.2.min.js', array( 'jquery' ), APMM_TD );
            wp_enqueue_script( 'wpmm-mega-menu', APMM_JS_DIR . '/admin-menu.js', array(
            'jquery',
            'jquery-ui-core',
            'jquery-ui-sortable',
            'jquery-ui-accordion'
            ), APMM_TD );
       }

         
      function displayArr($array){
          echo "<pre>";
          print_r($array);
          echo "</pre>";
        }


       /*
       *  AP MEGA MENU METABOX
       */
		  function addAPMegamenuMetaBox() {
            if (wp_get_nav_menus()) {
                add_meta_box('nav-menu-theme-apmegamenus', __('Select AP Mega Menu Settings', APMM_TD), array($this, 'createAPMegamenuMetaBox'), 'nav-menus', 'side', 'high');
            }
        }

       /*
       *  Metabox Location
       */
        function createAPMegamenuMetaBox(){
        	  $active = get_option(AP_MEGAMENU_MENU_LOCATION, array());
            echo "<div class='ap_megamenu-custom_metaBox'>";
            $menuid = $this->apmm_get_selected_menu_id(); //Get the current menu ID. ie. get menu id of current opened page
            $this->apmm_megamenu_options( $menuid );
            echo "</div>";
           
        }

       /**
       * Get the current menu ID.
       * Derived From: Max Mega Menu
       * https://www.maxmegamenu.com
       */
        function apmm_get_selected_menu_id(){
            $nav_menus = wp_get_nav_menus( array('orderby' => 'name') );

            $menu_count = count( $nav_menus );

            $wpmegamenuselectedid = isset( $_REQUEST['menu'] ) ? (int) $_REQUEST['menu'] : 0;

            $add_new_screen = ( isset( $_GET['menu'] ) && 0 == $_GET['menu'] ) ? true : false;

            $page_count = wp_count_posts( 'page' );
            $one_theme_location_no_menus = ( 1 == count( get_registered_nav_menus() ) && ! $add_new_screen && empty( $nav_menus ) && ! empty( $page_count->publish ) ) ? true : false;

            // Get recently edited nav menu
            $recently_edited = absint( get_user_option( 'nav_menu_recently_edited' ) );
            if ( empty( $recently_edited ) && is_nav_menu( $wpmegamenuselectedid ) )
                $recently_edited = $wpmegamenuselectedid;

            // Use $recently_edited if none are selected
            if ( empty( $wpmegamenuselectedid ) && ! isset( $_GET['menu'] ) && is_nav_menu( $recently_edited ) )
                $wpmegamenuselectedid = $recently_edited;

            // On deletion of menu, if another menu exists, show it
            if ( ! $add_new_screen && 0 < $menu_count && isset( $_GET['action'] ) && 'delete' == $_GET['action'] )
                $wpmegamenuselectedid = $nav_menus[0]->term_id;

            // Set $wpmegamenuselectedid to 0 if no menus
            if ( $one_theme_location_no_menus ) {
                $wpmegamenuselectedid = 0;
            } elseif ( empty( $wpmegamenuselectedid ) && ! empty( $nav_menus ) && ! $add_new_screen ) {
                // if we have no selection yet, and we have menus, set to the first one in the list
                $wpmegamenuselectedid = $nav_menus[0]->term_id;
            }

            return $wpmegamenuselectedid;
        }

         /* Derived From: Max Mega Menu
          * https://www.maxmegamenu.com
         */
        function apmm_megamenu_options($menuid){
           $tagged_menu_locations = $this->get_taglocation_menuid( $menuid ); //get location of specific menu id
          
           $menu_theme_locations = get_registered_nav_menus(); // check if theme menu location are empty or is not empty
          
           $menu_general_settings = get_option( 'wpmegabox_settings' );
           // echo "<pre>";
           // print_r($tagged_menu_locations);

           if(!count($menu_theme_locations)){
          
            echo "<p>" . __("This theme does not register any menu locations.", APMM_TD) . "</p>";
            echo "<p>" . __("You will need to create a new menu location to enable AP Mega Menu.", APMM_TD) . "</p>";

           } else if ( ! count ( $tagged_menu_locations ) ) {

              echo "<p>" . __("This Menu is not assigned to any theme location yet. <br/>To Enable AP Mega Menu, First please assign this menu to theme location.", APMM_TD) . "</p>";

           }else{ ?>

            <?php if ( count( $tagged_menu_locations ) == 1 ) : ?>
                <?php

                $locations = array_keys( $tagged_menu_locations );
                $location = $locations[0];


                if (isset( $tagged_menu_locations[ $location ] ) ) {
                    $this->apmm_settings_table( $location, $menu_general_settings );
                }

                ?>

            <?php else: 
            // echo "<pre>";
            // print_r($menu_theme_locations); ?>

                <div id='apmegamenu_accordion'>

                    <?php foreach ( $menu_theme_locations as $location => $name ) : ?>

                        <?php if ( isset( $tagged_menu_locations[ $location ] ) ): ?>

                            <h3 class='theme_settings'><?php echo esc_html( $name ); ?></h3>

                            <div class='accordion_content' style='display: none;'>
                                <?php $this->apmm_settings_table( $location, $menu_general_settings ); ?>
                            </div>

                        <?php endif; ?>

                    <?php endforeach;?>
                </div>


              <?php
                endif;
                 submit_button( __( 'Save' ), 'ap-mega-menu-save button-primary alignright');
            ?>
            <span class='apmm_loader' style="display:none;"><img src="<?php echo APMM_IMG_DIR;?>/ajaxloader.gif"/></span>
            <div class='apmm_success'></div>

           <?php }
          
        }

        /**
       * Return the locations that a specific menu ID has been tagged to.
       * Derived From: Max Mega Menu
       * https://www.maxmegamenu.com
       * $menu_id int
       */
        function get_taglocation_menuid($menuid){
          $menu_locations = array();

           $registered_menu_locations = get_registered_nav_menus();  //Returns all registered navigation menu locations in a theme.
           $nav_menu_locations = get_nav_menu_locations(); // Returns an array with the registered navigation menu locations and the menu assigned to it

           foreach ($registered_menu_locations as $id => $name) {
              if ( isset( $nav_menu_locations[ $id ] ) && $nav_menu_locations[$id] == $menuid )
                
                $menu_locations[$id] = $name;
              
            }

            return $menu_locations;

        }

        
        function apmm_settings_table($location, $menu_general_settings ){
          // echo $location;
          // echo "<pre>";
          // print_r($menu_general_settings);
          // exit();
           ?>

              <table class="wpmm-settings-box">
                      <tr>
                      <td><label for="apmegamenu_enabled_<?php echo $location;?>"><?php _e("Enable", APMM_TD) ?></label></td>
                          <td> 
                           <div class="wpmm-switch">
                              <input type='checkbox' class='apmegamenu_enabled' 
                              name='apmegamenu_meta[<?php echo $location ?>][enabled]' id="apmegamenu_enabled_<?php echo $location;?>" value='1' <?php checked( isset( $menu_general_settings[$location]['enabled'] ) ); ?>/>
                             <label for="apmegamenu_enabled_<?php echo $location;?>"></label>
                           </div>
                          </td>
                       </tr>

                       <tr>
                        <td class='apmega-name'>
                            <?php _e("Orientation", APMM_TD); ?>
                        </td>
                        <td class='apmega-value'>
                            <select name='apmegamenu_meta[<?php echo $location ?>][orientation]' class="select_fields_wpmm wpmm-orientation">
                                <option value='horizontal' <?php selected( isset( $menu_general_settings[$location]['orientation'] ) && $menu_general_settings[$location]['orientation'] == 'horizontal'); ?>><?php _e("Horizontal", APMM_TD); ?></option>
                                <option value='vertical' <?php selected( isset( $menu_general_settings[$location]['orientation'] ) && $menu_general_settings[$location]['orientation'] == 'vertical'); ?>><?php _e("Vertical", APMM_TD); ?></option>
                            <select>
                          
                        </td>
                       </tr>

                        <tr class="wpmm_show_valigntype" style="display:none;">
                        <td class='apmega-name'>
                            <?php _e("Vertical Alignment Type", APMM_TD); ?>
                        </td>
                        <td class='apmega-value'>
                            <select name='apmegamenu_meta[<?php echo $location ?>][vertical_alignment_type]' class="select_fields_wpmm">
                                <option value='left' <?php selected( isset( $menu_general_settings[$location]['vertical_alignment_type'] ) && $menu_general_settings[$location]['vertical_alignment_type'] == 'left'); ?>><?php _e("Left", APMM_TD); ?></option>
                                <option value='right' <?php selected( isset( $menu_general_settings[$location]['vertical_alignment_type'] ) && $menu_general_settings[$location]['vertical_alignment_type'] == 'right'); ?>><?php _e("Right", APMM_TD); ?></option>
                            <select>
                          
                        </td>
                       </tr>

                       <tr>
                        <td class='apmega-name'>
                            <?php _e("Trigger Effect", APMM_TD); ?>
                         
                        </td>
                        <td class='apmega-value'>
                            <select name='apmegamenu_meta[<?php echo $location ?>][trigger_option]' class="select_fields_wpmm">
                                <option value='onhover' <?php selected( isset( $menu_general_settings[$location]['trigger_option'] ) && $menu_general_settings[$location]['trigger_option'] == 'onhover'); ?>><?php _e("Hover", APMM_TD); ?></option>
                                <!-- <option value='hover_indent' < ?php selected( isset( $menu_general_settings[$location]['trigger_option'] ) && $menu_general_settings[$location]['trigger_option'] == 'hover_indent'); ?>><?php _e("Hover Indent", APMM_TD); ?></option> -->
                                <option value='onclick' <?php selected( isset( $menu_general_settings[$location]['trigger_option'] ) && $menu_general_settings[$location]['trigger_option'] == 'onclick'); ?>><?php _e("Click", APMM_TD); ?></option>
                            <select>
                          
                        </td>
                       </tr>
                          <tr>
                        <td class='apmega-name'>
                            <?php _e("Transition", APMM_TD); ?>
                       
                        </td>
                        <td class='apmega-value'>
                            <select name='apmegamenu_meta[<?php echo $location ?>][effect_option]' class="select_fields_wpmm">
                               
                                <option value='fade' <?php selected( isset( $menu_general_settings[$location]['effect_option'] ) && $menu_general_settings[$location]['effect_option'] == 'fade'); ?>><?php _e("Fade", APMM_TD); ?></option>
                                <option value='slide' <?php selected( isset( $menu_general_settings[$location]['effect_option'] ) && $menu_general_settings[$location]['effect_option'] == 'slide'); ?>><?php _e("Slide", APMM_TD); ?></option>
                               
                            <select>
                          
                        </td>
                    </tr>
                <tr class="themetype">
                <td><?php _e("Choose Theme Type", APMM_TD); ?></td>
                 <?php        
                        $available_skin_themes = get_option('apmm_register_skin');
                        // echo "<pre>";
                        // print_r($menu_general_settings[$location]);
                        ?>

        
                <td>
                   <select name="apmegamenu_meta[<?php echo $location;?>][theme_type]" class="wpmm_theme_type">
                      <option value="available_skins" <?php selected( isset( $menu_general_settings[$location]['theme_type'] ) && $menu_general_settings[$location]['theme_type'] == 'available_skins'); ?>><?php _e('Available Skins',APMM_TD);?></option>
                      <option value="custom_themes" <?php selected( isset( $menu_general_settings[$location]['theme_type'] ) && $menu_general_settings[$location]['theme_type'] == 'custom_themes'); ?>><?php _e('Custom Themes',APMM_TD);?></option>  
                    </select>
                </td>
                </tr>
                <tr class="wpmm_show_themes" style="display:none;">
                  <td><?php _e("Custom Theme", APMM_TD); ?></td>
                  <td>
                 <?php  $ap_theme_object = new AP_Theme_Settings();
                        $themes = $ap_theme_object->get_custom_theme_data('');
                        $selected_theme = isset( $menu_general_settings[$location]['theme'] ) ? intval($menu_general_settings[$location]['theme']) : '1';  
                           ?>
                      <select name='apmegamenu_meta[<?php echo $location ?>][theme]'
                      class="select_fields_wpmm">
                          <?php
                             foreach ( $themes as $key => $theme ) {
                                $theme_id = $theme->theme_id;
                                $theme_title = $theme->title;
                               ?>
                               <option value='<?php echo $theme_id;?>' <?php echo selected( $selected_theme, $theme_id );?>><?php echo $theme_title;?></option>
                              <?php }
                          ?>
                      </select>
                  </td>
                 </tr>
                 <tr class="wpmm_show_skins" style="display:none;">
                   <td><?php _e("Available Skin", APMM_TD); ?></td>
                   <td>
                  <select name="apmegamenu_meta[<?php echo $location;?>][available_skin]" 
                   class="select_fields_wpmm">
                        <?php if(isset($available_skin_themes) && !empty($available_skin_themes)){
                          $selected_skin = isset( $menu_general_settings[$location]['available_skin'] ) ? $menu_general_settings[$location]['available_skin'] : 'black-white';
                          foreach ($available_skin_themes as $key => $value) {?>
                           <option value="<?php echo $value['id'];?>" <?php echo selected( $selected_skin, $value['id'] );?>><?php _e($value['title'],APMM_TD);?></option>
                          <?php }
                        } ?>
                      </select>
                   </td>

                 </tr>

                    </table>
              <?php   
                  }


     /**
     * Ajax Save Widget Menu Settings  Data (submitted from Menus Page Meta Box)
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wp_save_settings() {
       check_ajax_referer( 'apmm-ajax-nonce', 'wp_nonce' );
       if ( isset( $_POST['wp_menu_id'] ) && $_POST['wp_menu_id'] > 0 && is_nav_menu( $_POST['wp_menu_id'] ) && isset( $_POST['wp_megamenu_meta'] ) ) {
          $get_raw_metabox_data = $_POST['wp_megamenu_meta'];
          $get_parsed_submitted_settings = json_decode( stripslashes( $get_raw_metabox_data ), true );

         
           $submitted_settings = array();

            foreach ( $get_parsed_submitted_settings as $index => $value ) {
                $name = $value['name'];

                // find values between square brackets
                preg_match_all( "/\[(.*?)\]/", $name, $matches );

                if ( isset( $matches[1][0] ) && isset( $matches[1][1] ) ) {
                    $location = $matches[1][0];
                    $setting = $matches[1][1];

                    $submitted_settings[$location][$setting] = $value['value'];
                }
            }

             // echo "<pre>";
             // print_r($submitted_settings);
            /*
            Array output results as 
             $submitted_settings = Array
                  (
                      [primary] => Array
                          (
                              [enabled] => 1
                              [orientation] => horizontal
                              [vertical_alignment_type]  => left
                              [trigger_option] => onhover
                              [effect_option] => slide
                              [theme_type] => available_skins or custom themes
                              [theme] => 1  //default theme id
                              [available_skin] => 'black-white' //total 6 pre available skins.
                          )

                  )
            */
            if ( ! get_option( 'wpmegabox_settings' ) ) {

                update_option( 'wpmegabox_settings', $submitted_settings );

            } else {

                $existing_settings = get_option( 'wpmegabox_settings' );

                $new_settings = array_merge( $existing_settings, $submitted_settings );

                update_option( 'wpmegabox_settings', $new_settings );

            }


       }
        wp_die();

    }

    /**
     * Ajax Lightbox Html Settings for Menu Items
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_getlightbox_by_ajax(){
      check_ajax_referer( 'apmm-ajax-nonce', 'wp_nonce' );
      if(isset($_POST) && $_POST['menu_item_id'] != '' && $_POST['menu_id'] != ''){
        $wp_menu_item_title = $_POST['menu_item_title'];
        $this->wpmm_init();
      
        $this->wpmm_get_settings_section( $this->wpmmenu_item_id, $this->wpmmenu_id,$wp_menu_item_title ,$this->wpmmenu_item_depth, $this->wpmmenu_item_meta );
        }
      
        wp_die();
    }

    public function wpmm_get_settings_section( $menu_item_id,$menu_id,$menu_item_title,$menu_item_depth,$wpmmenu_item_meta){  
     if ( $menu_item_depth > 0 ) {
           include(APMM_PATH.'inc/backend/menu_settings/submenu_settings.php');
        }else{
            include(APMM_PATH.'inc/backend/menu_settings/top_menu_settings.php');
        }
    }

   /**
     * Save custom menu item fields.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
     public static function save_menuitem_settings_byajax(){
       check_ajax_referer( 'apmm-ajax-nonce', '_wpnonce' );
  
       $wpmm_menu_item_id = absint( $_POST['wpmm_menu_item_id'] );

       if(isset($_POST['wpmm_settings']) && is_array($_POST['wpmm_settings']) &&  $wpmm_menu_item_id > 0){
        // echo "<pre>";
        // print_r($_POST['wpmm_settings']);
        // die();

         if ( isset( $_POST['wpmm_settings']['menu_type'] ) && isset($_POST['wpmm_settings']['panel_columns'])) {
             $_POST['wpmm_settings']['menu_type'] = $_POST['wpmm_settings']['menu_type'];
             $_POST['wpmm_settings']['panel_columns'] = $_POST['wpmm_settings']['panel_columns'];
           }else{    
            //general settings     
             $_POST['wpmm_settings']['general_settings']['disable_text'] = (!isset($_POST['wpmm_settings']['general_settings']['disable_text'])?'false':'true');
             $_POST['wpmm_settings']['general_settings']['active_link'] = (!isset($_POST['wpmm_settings']['general_settings']['active_link'])?'false':'true');
             $_POST['wpmm_settings']['general_settings']['visible_hidden_menu'] = (!isset($_POST['wpmm_settings']['general_settings']['visible_hidden_menu'])?'false':'true');
             $_POST['wpmm_settings']['general_settings']['hide_arrow'] = (!isset($_POST['wpmm_settings']['general_settings']['hide_arrow'])?'false':'true');
             $_POST['wpmm_settings']['general_settings']['hide_on_mobile'] = (!isset($_POST['wpmm_settings']['general_settings']['hide_on_mobile'])?'false':'true');
             $_POST['wpmm_settings']['general_settings']['hide_on_desktop'] = (!isset($_POST['wpmm_settings']['general_settings']['hide_on_desktop'])?'false':'true');
             $_POST['wpmm_settings']['general_settings']['menu_icon'] = (!isset($_POST['wpmm_settings']['general_settings']['menu_icon'])?'disabled':'enabled'); 
                 //show menu icon enabled true
             $_POST['wpmm_settings']['general_settings']['active_single_menu'] = isset($_POST['wpmm_settings']['general_settings']['active_single_menu'])?'enabled':'disabled';

             //sub custom settings     
             $_POST['wpmm_settings']['upload_image_settings']['use_custom_settings'] = isset($_POST['wpmm_settings']['upload_image_settings']['use_custom_settings'])?'true':'false';
             $_POST['wpmm_settings']['upload_image_settings']['show_description'] = isset($_POST['wpmm_settings']['upload_image_settings']['show_description'])?'true':'false';
             $_POST['wpmm_settings']['upload_image_settings']['display_readmore'] = isset($_POST['wpmm_settings']['upload_image_settings']['display_readmore'])?'true':'false';
             $_POST['wpmm_settings']['upload_image_settings']['display_post_date'] = isset($_POST['wpmm_settings']['upload_image_settings']['display_post_date'])?'true':'false';
             $_POST['wpmm_settings']['upload_image_settings']['display_author_name'] = isset($_POST['wpmm_settings']['upload_image_settings']['display_author_name'])?'true':'false';
             $_POST['wpmm_settings']['upload_image_settings']['display_cat_name'] = isset($_POST['wpmm_settings']['upload_image_settings']['display_cat_name'])?'true':'false';
            
           //megamenu settings 
             // $_POST['wpmm_settings']['general_settings']['hide_sub_menu_on_mobile'] = (!isset($_POST['wpmm_settings']['general_settings']['hide_sub_menu_on_mobile'])?'disabled':$_POST['wpmm_settings']['general_settings']['hide_sub_menu_on_mobile']);
             $_POST['wpmm_settings']['mega_menu_settings']['show_top_content'] = (!isset($_POST['wpmm_settings']['mega_menu_settings']['show_top_content'])?'false':'true');
             $_POST['wpmm_settings']['mega_menu_settings']['show_bottom_content'] = (!isset($_POST['wpmm_settings']['mega_menu_settings']['show_bottom_content'])?'false':'true');    
            
             $_POST['wpmm_settings']['mega_menu_settings']['top']['top_content_type'] = (isset($_POST['wpmm_settings']['mega_menu_settings']['top']['top_content_type'])?sanitize_text_field($_POST['wpmm_settings']['mega_menu_settings']['top']['top_content_type']):'text_only');    
             $_POST['wpmm_settings']['mega_menu_settings']['bottom']['bottom_content_type'] = (isset($_POST['wpmm_settings']['mega_menu_settings']['bottom']['bottom_content_type'])?sanitize_text_field($_POST['wpmm_settings']['mega_menu_settings']['bottom']['bottom_content_type']):'text_only');    
             $_POST['wpmm_settings']['mega_menu_settings']['top']['top_content'] = (isset($_POST['wpmm_settings']['mega_menu_settings']['top']['top_content'])?sanitize_text_field($_POST['wpmm_settings']['mega_menu_settings']['top']['top_content']):'');    
             $_POST['wpmm_settings']['mega_menu_settings']['bottom']['bottom_content'] = (isset($_POST['wpmm_settings']['mega_menu_settings']['bottom']['bottom_content'])?sanitize_text_field($_POST['wpmm_settings']['mega_menu_settings']['bottom']['bottom_content']):'');    
           
             $_POST['wpmm_settings']['mega_menu_settings']['top']['image_url'] = (isset($_POST['wpmm_settings']['mega_menu_settings']['top']['image_url'])?sanitize_text_field($_POST['wpmm_settings']['mega_menu_settings']['top']['image_url']):'');    
             $_POST['wpmm_settings']['mega_menu_settings']['bottom']['image_url'] = (isset($_POST['wpmm_settings']['mega_menu_settings']['bottom']['image_url'])?sanitize_text_field($_POST['wpmm_settings']['mega_menu_settings']['bottom']['image_url']):'');    
             $_POST['wpmm_settings']['mega_menu_settings']['top']['html_content'] = (isset($_POST['wpmm_settings']['mega_menu_settings']['top']['html_content']) && $_POST['wpmm_settings']['mega_menu_settings']['top']['html_content'] != '')?$_POST['wpmm_settings']['mega_menu_settings']['top']['html_content']:'';    
             $_POST['wpmm_settings']['mega_menu_settings']['bottom']['html_content'] = (isset($_POST['wpmm_settings']['mega_menu_settings']['bottom']['html_content']) && $_POST['wpmm_settings']['mega_menu_settings']['bottom']['html_content'] != '')?$_POST['wpmm_settings']['mega_menu_settings']['bottom']['html_content']:'';    
         
 
           }
            
        
     
            $get_existing_settings = get_post_meta( $wpmm_menu_item_id, '_wpmegamenu', true);
            if ( is_array( $get_existing_settings ) ) {

              $_POST['wpmm_settings'] = array_merge( $get_existing_settings,$_POST['wpmm_settings']);

            }
           
            update_post_meta( $wpmm_menu_item_id, '_wpmegamenu', $_POST['wpmm_settings'] );

        } 

            if ( ob_get_contents() ) ob_clean(); // remove any warnings or output from other plugins which may corrupt the response

            wp_send_json_success();

    }

    public function wpmm_admin_footer_function()
    {
     echo "<div class='wpmm_menu_wrapper'><div class='wpmm_overlay'></div>";
     echo "<div id='wpmm_menu_settings_frame' style='display:none;'><div class='wpmm_frame_header'>";
     echo "<span class='close_btn'>x</span></div>";
     echo "<div class='wpmm_main_content'></div></div></div>";
    }

    /**
     * Returns the menu ID for a specified menu location, defaults to 0
     */
    private function wpmm_get_menu_id_for_location( $location ) {

        $locations = get_nav_menu_locations();

        $id = isset( $locations[ $location ] ) ? $locations[ $location ] : 0;

        return $id;

    }


}
$global['menu_obj'] = new AP_Menu_Settings();
endif;