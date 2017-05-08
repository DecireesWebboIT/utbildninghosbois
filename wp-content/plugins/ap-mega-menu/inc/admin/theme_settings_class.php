<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if ( ! class_exists( 'AP_Theme_Settings' ) ) :

/**
 * Handles all admin related functionality.
 */
final class AP_Theme_Settings {
    /**
     * Constructor
     */
    public function __construct() {
         $this->settings = get_option( "apmega_settings" );
         $this->wpmm_setup_actions();
     }

     /**
     * Setup actions
     */
     public function wpmm_setup_actions() {
         add_action('admin_post_wpmm_add_action',array($this,'wpmm_add_action')); //recieves the posted values from add form
         add_action('admin_post_wpmm_edit_action', array($this, 'wpmm_edit_action')); // edit action 
         add_action('admin_post_wpmm_copy_action', array($this, 'wpmm_copy_action')); // copy action 
         add_action('admin_post_wpmm_delete_action', array($this, 'wpmm_delete_action')); // delete action 
     }


     /* 
     * Save theme settings
     */
     function wpmm_add_action(){
          if(!empty($_POST) && wp_verify_nonce($_POST['wpmm_add_nonce_field'],'wpmm-add-nonce')){
                include_once(APMM_PATH.'/inc/backend/view/save-theme-settings.php');
            }
            else{
                 die('No script kiddies please!');
            }
     }

       /* 
       * Edit theme settings
       */
       function wpmm_edit_action(){
            if(!empty($_POST) && wp_verify_nonce($_POST['wpmm_edit_nonce_field'],'wpmm-edit-nonce')){
                  include_once(APMM_PATH.'/inc/backend/view/save-theme-settings.php');
              }
              else{
                   die('No script kiddies please!');
              }
       }

         /**
         * Delete Custom theme
         */
         function wpmm_delete_action() {
            if (isset($_GET['action'], $_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'wpmm-delete-nonce')) {
                include_once(APMM_PATH.'/inc/backend/view/delete-theme-settings.php');
            } else {
                die('No script kiddies please!');
            }
         }
         
         /**
         * Copy custom theme to make duplicate
         */
         function wpmm_copy_action() {
            if (isset($_GET['action'], $_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'wpmm-copy-nonce')) {
                include_once(APMM_PATH.'/inc/backend/view/copy-custom-theme.php');
            } else {
                die('No script kiddies please!');
            }
         }


      /**
         * get custom theme data from table. 
         * */
         function get_custom_theme_data($id){
          global $wpdb;
          $table_name = $wpdb->prefix . "apmm_custom_theme";
          if(intval($id)){
              $wpmm_custom_theme = $wpdb->get_results("SELECT * FROM $table_name where theme_id = $id");
          }else{
              $wpmm_custom_theme = $wpdb->get_results("SELECT * FROM $table_name ORDER BY theme_id DESC");
          }
          return $wpmm_custom_theme;
         }

          /**
         * get custom theme row data from table. 
         * */
         public static function get_custom_theme_rowdata($id){
          global $wpdb;
          $table_name = $wpdb->prefix . "apmm_custom_theme";
          if(intval($id)){
              $wpmm_custom_theme = $wpdb->get_row("SELECT * FROM $table_name where theme_id = $id");

          }else{
              $wpmm_custom_theme = $wpdb->get_results("SELECT * FROM $table_name ORDER BY theme_id DESC");
          }
          return $wpmm_custom_theme;
         }

          /**
         * Model to return form settings by form id
         */
        public static function get_theme_detail($id) {
            global $wpdb;
            $table_name = $wpdb->prefix . "apmm_custom_theme";
            $themess = $wpdb->get_row( "SELECT * FROM $table_name WHERE theme_id = $id", ARRAY_A );
            return $themess;
        }

       /**
         * Custom theme Import
         */
        public static function import_custom_theme($theme_row) {
            $theme_row = ( array ) $theme_row;
            global $wpdb;
            $table_name = $wpdb->prefix . "apmm_custom_theme";
            $title = $theme_row['title'];
            $slug      = AP_Theme_Settings::wpmm_theme_make_slug($title,$table_name);
            $theme_settings = $theme_row['theme_settings'];
            $created_date = date( 'Y-m-d H:i:s:u' );
            $check = $wpdb->insert(
                    $table_name , array(
                        'title' => $title,
                        'theme_settings' => $theme_settings,
                        'slug' => $slug,
                        'created' => $created_date,
                        'modified' => $created_date
                            ), array(
                        '%s', '%s', '%s', '%s', '%s'
                            )
                    );

            return $check;
        }

        /*
        * Create theme slug function
        */
           public static function wpmm_theme_make_slug($title, $table_name)
          {
              global $wpdb;
              $slug = preg_replace("/-$/","",preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));
              $wpmm_custom_theme = $wpdb->get_results("SELECT * FROM $table_name where slug like '%$slug'");
          
              $numHits = count($wpmm_custom_theme);
              return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
          }


}
$global['ap_theme_obj'] = new AP_Theme_Settings();

endif;