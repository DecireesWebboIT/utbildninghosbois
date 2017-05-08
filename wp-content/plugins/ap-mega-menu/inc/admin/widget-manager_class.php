<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if ( ! class_exists( 'WPMM_Menu_Widget_Manager' ) ) :

/**
 * Derived From: Max Mega Menu
 * https://www.maxmegamenu.com
 * Handles all admin related functionality for widget section.
 * There is very little in WordPress core to help with listing, editing, saving, deleting widgets etc so this class implements that functionality.
 */
class WPMM_Menu_Widget_Manager {
    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_sidebar' ) ); // add sidebar to lists all wp mega menu added widgets on sidebar here

        add_action( 'wp_ajax_wpmm_add_selected_widget', array( $this, 'wpmm_ajax_add_widget' ) ); // add widget on menu item using ajax
        add_action( 'wp_ajax_wpmm_selected_update_widget', array( $this, 'wpmm_ajax_update_widget' ) ); // update widgets 
        add_action( 'wp_ajax_wpmm_update_menu_item_columns', array( $this, 'wpmm_ajax_update_menu_item_columns' ) ); // save ajax mega menu for list of sub menu items
        add_action( 'wp_ajax_wpmm_reorder_widget_items', array( $this, 'wpmm_ajax_reorder_items' ) ); // reorder widgets by sortable techniques
        add_action( 'wp_ajax_wpmm_edit_widget_data', array( $this, 'wpmm_ajax_edit_widget_form' ) ); //edit widget data of specific widgets for menu item
        add_action( 'wp_ajax_wpmm_delete_widget', array( $this, 'wpmm_ajax_delete_widget_form' ) ); //edit widget data of specific widgets for menu item
        add_action( 'wp_ajax_wpmm_saveitemwidget', array( $this, 'wpmm_ajax_save_widget' ) );

        add_filter( 'widget_update_callback', array( $this, 'wpmm_persist_mega_menu_widget_settings'), 10, 4 );
      
     }


      /**
     * Create our own widget area to store all mega menu widgets.
     * All widgets from all menus are stored here, they are filtered later
     * to ensure the correct widgets show under the correct menu item.
     */
    public function register_sidebar() {

        register_sidebar(
            array(
                'id' => 'wp-mega-menu',
                'name' => __("AP Mega Menu Widgets", APMM_TD),
                'description'   => __("Do not manually edit this area.", APMM_TD)
            )
        );
    }



    /**
     * Depending on how a widget has been written, it may not necessarily base the new widget settings on
     * a copy the old settings. If this is the case, the mega menu data will be lost. This function
     * checks to make sure widgets persist the mega menu data when they're saved.
     * Note : This Function specially for plugin that need to filter a widget’s settings before saving.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_persist_mega_menu_widget_settings( $instance, $new_instance, $old_instance, $that ) {

        if ( isset( $old_instance["wpmm_mega_menu_columns"] ) && ! isset( $new_instance["wpmm_mega_menu_columns"] ) ) {
            $instance["wpmm_mega_menu_columns"] = $old_instance["wpmm_mega_menu_columns"];
        }

        if ( isset( $old_instance["wp_menu_order"] ) && ! isset( $new_instance["wp_menu_order"] ) ) {
            $instance["wp_menu_order"] = $old_instance["wp_menu_order"];
        }

        if ( isset( $old_instance["wpmm_mega_menu_parent_menu_id"] ) && ! isset( $new_instance["wpmm_mega_menu_parent_menu_id"] ) ) {
            $instance["wpmm_mega_menu_parent_menu_id"] = $old_instance["wpmm_mega_menu_parent_menu_id"];
        }

        return $instance;
    }

     /**
     * Returns an specific wp mega menu widget object.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_get_specific_widgets() {
        global $wp_widget_factory;
        $wordpress_widgets = array();

        foreach( $wp_widget_factory->widgets as $wordpress_widget ) {

             $enabled_widgets = array('wpmegamenu_contact_info');

             $enabled_widgets = apply_filters( "wpmegamenu_compatible_widgets", $enabled_widgets );

            if (in_array( $wordpress_widget->id_base, $enabled_widgets ) ) {

                $wordpress_widgets[] = array(
                    'text' => $wordpress_widget->name,
                    'value' => $wordpress_widget->id_base,
                    'description' => $wordpress_widget->widget_options['description']
                );

            }

        }

        uasort( $wordpress_widgets, array( $this, 'wpmm_sort_by_text' ) );
        return $wordpress_widgets;

    }


   /**
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * Returns an objects representing all widgets registered in woocommerce widgets
     */
   public function wpmm_get_woo_widgets(){
        global $wp_widget_factory;
        $wordpress_widgets = array();

        foreach( $wp_widget_factory->widgets as $wordpress_widget ) {

           if (strpos($wordpress_widget->id_base, 'woocommerce') !== false) {
                $wordpress_widgets[] = array(
                    'text' => $wordpress_widget->name,
                    'value' => $wordpress_widget->id_base,
                    'description' => $wordpress_widget->widget_options['description']
                );

            }

        }

        uasort( $wordpress_widgets, array( $this, 'wpmm_sort_by_text' ) );
        return $wordpress_widgets;


    }




    /**
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * Returns an object representing all widgets registered in WordPress
     */
    public function wpmm_get_available_widgets() {
        global $wp_widget_factory;
        $wordpress_widgets = array();

        foreach( $wp_widget_factory->widgets as $wordpress_widget ) {

             $disabled_widgets = array('wpmegamenu_widget','wpmegamenu_contact_info');

             $disabled_widgets = apply_filters( "wpmegamenu_incompatible_widgets", $disabled_widgets );

            if ( ! in_array( $wordpress_widget->id_base, $disabled_widgets ) ) {
               if (strpos($wordpress_widget->id_base, 'woocommerce') !== false) {
               
               }else{
                 $wordpress_widgets[] = array(
                    'text' => $wordpress_widget->name,
                    'value' => $wordpress_widget->id_base,
                    'description' => $wordpress_widget->widget_options['description']
                );
               }

            }

        }

        uasort( $wordpress_widgets, array( $this, 'wpmm_sort_by_text' ) );
        return $wordpress_widgets;

    }

    /**
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * Sorts a 2d array by the 'text' key
     * @param array $a
     * @param array $b
     */
   public function wpmm_sort_by_text( $a, $b ) {
        return strcmp( $a['text'], $b['text'] );
    }

   /**
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * Add a widget to the right wp mega menu panel
     */
   public function wpmm_ajax_add_widget(){
      check_ajax_referer( 'apmm-ajax-nonce', '_wpnonce' );
     if(isset($_POST) && $_POST['id_base'] != '' && $_POST['menu_item_id'] != ''){
        $widgets_id_value    = sanitize_text_field($_POST['id_base']);
        $menu_item_id        = $_POST['menu_item_id'];
        $widget_title        = sanitize_text_field( $_POST['title'] );

        $added_widgets = $this->wpmm_add_widget_selected($widgets_id_value, $menu_item_id , $widget_title);
        if ( $added_widgets ) {
             if ( ob_get_contents() ) ob_clean();
              wp_send_json_success($added_widgets );
        } else {
            if ( ob_get_contents() ) ob_clean();
             wp_send_json_error( sprintf( __("Failed to add %s to %d", APMM_TD), $widgets_id_value, $menu_item_id ) );
        }
     }
      
    }

     /**
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * Adds a widget to WordPress. First creates a new widget instance
     */
   public function wpmm_add_widget_selected($widgets_id_value, $menu_item_id , $widget_title){
        require_once( ABSPATH . 'wp-admin/includes/widgets.php' );
        $next_id = next_widget_id_number( $widgets_id_value );

       // $this->wpmm_add_widget_instance( $widgets_id_value, $next_id, $menu_item_id );

        $my_current_widgetss = get_option( 'widget_' . $widgets_id_value );

        $my_current_widgetss[ $next_id ] = array(
            "wpmm_mega_menu_columns" => 2,
            "wpmm_mega_menu_parent_menu_id" => $menu_item_id
        );

        update_option( 'widget_' . $widgets_id_value, $my_current_widgetss );

        $widget_id = $this->wpmm_add_widget_to_sidebar( $widgets_id_value, $next_id );
       // include(APMM_PATH.'inc/backend/menu_settings/top_menu/add-widgets_settings.php');

         $return .= '<div class="wpmm_widget_area" data-title="' . esc_attr( $widget_title ) . '" data-columns="2" data-type="wp_widget" data-id="' . $widget_id . '">';
         $return .= '<div class="widget_main_top_section">';
         $return .= '<div class="widget_title">';
         $return .= '<span><i class="fa fa-arrows" aria-hidden="true"></i></span>';
         $return .= '<span class="wptitle">' . esc_html( $widget_title ) . '</div></span>';
         $return .= '<div class="widget_right_action">';
         $return .= '<a class="widget-option wpmm_widget-contract" title="' . esc_attr( __("Contract",APMM_TD) ) . '">';
         $return .= '<i class="fa fa-caret-left" aria-hidden="true"></i></a>';
         $return .= '<span class="widget-cols"><span class="wpmm_widget-num-cols">2</span><span class="wpmm_widget-of">/</span>';
         $return .= '<span class="wpmm_widget-total-cols">X</span></span>';
         $return .= '<a class="widget-option wpmm_widget-expand" title="' . esc_attr( __("Expand", APMM_TD) ) . '"><i class="fa fa-caret-right" aria-hidden="true"></i></a>';
         $return .= '<a class="widget-option wpmm_widget-action" title="' . esc_attr( __("Edit",APMM_TD) ) . '">';
         $return .= '<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
         $return .= '</div>';
         $return .= '</div>';
         $return .= '<div class="wpmm_widget_inner"></div>';
         $return .= '</div>';

        return $return;

    }
    
     /**
     * Adds a widget to the WP Mega Menu widget sidebar
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    private function wpmm_add_widget_to_sidebar( $id_base, $next_id ) {

        $widget_id = $id_base . '-' . $next_id;

        $sidebar_widgets = $this->wpmm_get_mega_menu_sidebar_widgets();

        $sidebar_widgets[] = $widget_id;

        $this->wpmm_set_mega_menu_sidebar_widgets($sidebar_widgets);

        do_action( "wpmm_after_widget_add" );
        
        return $widget_id;

    }

     /**
     * Update wp mega columns for a widget
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */

    public function wpmm_ajax_update_widget() {

        check_ajax_referer( 'apmm-ajax-nonce', '_wpnonce' );

        $widget_id = sanitize_text_field( $_POST['widget_unique_id'] );
        $columns = absint( $_POST['columns'] );

       $widget_updated = $this->wpmm_update_widget( $widget_id, $columns );

        if ( $widget_updated ) {
            $this->wpmm_send_json_success( sprintf( __( "Updated %s (new columns: %d)", APMM_TD), $widget_id, $columns ) );
        } else {
            $this->wpmm_send_json_error( sprintf( __( "Failed to update %s", APMM_TD), $widget_id ) );
        }

    }

    /**
     * Updates the number of wp mega columns for a specified widget.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * @param string $widget_id
     * @param int $columns
     */
    public function wpmm_update_widget( $widget_id, $columns ) {

        $id_base = $this->wpmm_get_id_base_for_widget_id( $widget_id );

        //$widget_number = $this->get_widget_number_for_widget_id( $widget_id );
        $parts = explode( "-", $widget_id );

        $widget_number = absint( end( $parts ) );

        $current_widgets = get_option( 'widget_' . $id_base );

        $current_widgets[ $widget_number ]["wpmm_mega_menu_columns"] = absint( $columns) ;

        update_option( 'widget_' . $id_base, $current_widgets );

        do_action( "wpmm_after_widget_save" );

        return true;

    }

     /**
     * Update the number of wp mega sub menu columns for a widget in mega menu
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_ajax_update_menu_item_columns() {

        check_ajax_referer( 'apmm-ajax-nonce', '_wpnonce' );
        $submenuid = absint( $_POST['sub_menu_id'] );
        $columns = absint( $_POST['columns'] );

        $updated = $this->wpmm_update_menuitem_columns( $submenuid, $columns );

        if ( $updated ) {
            $this->wpmm_send_json_success( sprintf( __( "Updated %s (new columns: %d)", APMM_TD), $submenuid, $columns ) );
        } else {
            $this->wpmm_send_json_error( sprintf( __( "Failed to update %s", APMM_TD), $submenuid ) );
        }

    }    

    /**
     * Updates the number of wp mega columns for a specified widget.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * @param string $menu_item_id
     * @param int $columns
     */
    public function wpmm_update_menuitem_columns( $submenuid, $columns ) {

        $settings = get_post_meta( $submenuid, '_wpmegamenu', true);

        $settings['wpmm_mega_menu_columns'] = absint( $columns );

        update_post_meta( $submenuid, '_wpmegamenu', $settings );

        return true;

    }

    /**
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * Returns the id_base value for a Widget ID
     */
    public function wpmm_get_id_base_for_widget_id( $widget_id ) {
        global $wp_registered_widget_controls;

        if ( ! isset( $wp_registered_widget_controls[ $widget_id ] ) ) {
            return false;
        }

        $control = $wp_registered_widget_controls[ $widget_id ];

        $id_base = isset( $control['id_base'] ) ? $control['id_base'] : $control['id'];

        return $id_base;

    }


     /**
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * Returns an unfiltered array of all widgets in our sidebar
     */
    public function wpmm_get_mega_menu_sidebar_widgets() {

        $sidebar_widgets = wp_get_sidebars_widgets();

        if ( ! isset( $sidebar_widgets[ 'wp-mega-menu'] ) ) {
            return false;
        }

        return $sidebar_widgets[ 'wp-mega-menu' ];

    }

    /**
     * Sets the sidebar widgets
     *  Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    private function wpmm_set_mega_menu_sidebar_widgets( $widgets ) {

        $sidebar_widgets = wp_get_sidebars_widgets();

        $sidebar_widgets[ 'wp-mega-menu' ] = $widgets;

        wp_set_sidebars_widgets( $sidebar_widgets );

    }


     /**
     * Moves a widget to a new position by sortable order
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_ajax_reorder_items() {

        check_ajax_referer( 'apmm-ajax-nonce', '_wpnonce' );

        $items = isset( $_POST['items'] ) ? $_POST['items'] : false;

        $saved = false;

        if ( $items ) {
            $movedwidgets = $this->wpmm_item_reorder( $items );
        }

        if ( $movedwidgets ) {
            $this->wpmm_send_json_success( sprintf( __( "Moved (%s)", APMM_TD), json_encode( $items ) ) );
        } else {
            $this->wpmm_send_json_error( sprintf( __( "Didn't move items", APMM_TD), json_encode( $items ) ) );
        }

    }

    /**
     * Moves a widget from one position to another.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * @param array $items
     * @return string $widget_id. The widget that has been moved.
     */
    public function wpmm_item_reorder($items){

           foreach ( $items as $item ) {

                    if ( $item['parent_menu_item_id'] ) {
                        $parent_menu_id = $item['parent_menu_item_id'];

                        $submitted_settings = array( 'submenu_ordering' => 'forced' );

                        $existing_settings = get_post_meta( $parent_menu_id, '_wpmegamenu', true );

                        if ( is_array( $existing_settings ) ) {

                            $submitted_settings = array_merge( $existing_settings, $submitted_settings );

                        }

                        update_post_meta( $parent_menu_id, '_wpmegamenu', $submitted_settings );
                    }

                     /*
                      * Change the order if its megamenu is widget added for top level menu and save data 
                      * into postmeta with key as _wpmegamenu
                     */

                    if ( $item['type'] == 'wp_widget' ) {

                        $this->wpmm_update_widget_order( $item['id'], $item['order'], $item['parent_menu_item_id'] );

                    }
                      
                    /*
                    * Change the order if its sub menu items of top level with data-type as wpmm_menu_subitem
                    */

                    if ( $item['type'] == 'wpmm_menu_subitem' ) {

                        //Updates the order of a specified menu item.
                        $submitted_settings['wp_menu_order'] = array($item['parent_menu_item_id']  => absint( $item['order'] ) );

                        $existing_settings = get_post_meta(  $item['id'] , '_wpmegamenu' , true);

                        if ( is_array( $existing_settings ) ) {

                            $submitted_settings = array_merge( $existing_settings, $submitted_settings );

                        }

                        update_post_meta( $item['id'], '_wpmegamenu', $submitted_settings );


                    }

                }
                return true;
    }

    /**
     * Updates the order of a specified widget.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * @param string $widget_id
     * @param int $columns
     */
    public function wpmm_update_widget_order( $widget_id, $order, $parent_menu_item_id ) {

        $widget_id_base = $this->wpmm_get_id_base_for_widget_id( $widget_id );

       // $widget_number = $this->wpmm_get_widget_number_for_widget_id( $widget_id );
        $parts = explode( "-", $widget_id );

        $widget_number = absint( end( $parts ) );

        $current_widgets = get_option( 'widget_' . $widget_id_base );

        $current_widgets[ $widget_number ]["wp_menu_order"] = array( $parent_menu_item_id => absint( $order ) );

        update_option( 'widget_' . $widget_id_base, $current_widgets );

        return true;

    }

     /**
     * Display a widget settings form
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_ajax_edit_widget_form() {

        check_ajax_referer( 'apmm-ajax-nonce', '_wpnonce' );

        $widget_id = sanitize_text_field( $_POST['widget_id_base'] );

        if ( ob_get_contents() ) ob_clean(); // remove any warnings or output from other plugins which may corrupt the response
        //echo trim($this->wpmm_show_widget_form( $widget_id ));

       wp_die( trim( $this->wpmm_show_widget_form( $widget_id ) ) );

    }

  /*
    * Widget CallBack Form: On edit specific widget on megamenu backend display widgets callback form 
    * Derived From: Max Mega Menu
    * https://www.maxmegamenu.com
   */
    function wpmm_show_widget_form($widget_id_base){
        global $wp_registered_widget_controls;

        $control_widget = $wp_registered_widget_controls[ $widget_id_base ];

        $id_base = $this->wpmm_get_id_base_for_widget_id( $widget_id_base );

        //$widget_number = $this->get_widget_number_for_widget_id( $widget_id_base );
        $parts = explode( "-", $widget_id );

        $widget_number = absint( end( $parts ) );


        $widget_nonce = wp_create_nonce('wpmm_save_widget_' . $widget_id_base);

        ?>

        <div class='wpmm_widget-content'>
            <form method='post'>
                <input type="hidden" name="widget_id" class="widget-id" value="<?php echo $widget_id_base ?>" />
                <input type='hidden' name='action'  value='wpmm_saveitemwidget' />
                <input type='hidden' name='id_base'   value='<?php echo $id_base; ?>' />
                <input type='hidden' name='_wpnonce'  value='<?php echo $widget_nonce ?>' />

                <?php
                    if ( is_callable( $control_widget['callback'] ) ) {
                        call_user_func_array( $control_widget['callback'], $control_widget['params'] );
                    }
                ?>

                <div class='wpmm-widget-controls'>
                    <a class='wpmm_delete' href='#delete'><?php _e("Delete", APMM_TD); ?></a> |
                    <a class='wpmm_close' href='#close'><?php _e("Close", APMM_TD); ?></a>
                </div>

                <?php
                    submit_button( __( 'Save' ), 'button-primary alignright', 'wpmm_savewidget', false );
                ?>
            </form>
        </div>

        <?php

    }
    /*
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
  public function wpmm_ajax_delete_widget_form(){
        check_ajax_referer( 'apmm-ajax-nonce', '_wpnonce' );
        
        $widget_id = sanitize_text_field( $_POST['widget_id_base'] );
     
        $deleted_widgets = $this->wpmm_delete_widgets( $widget_id );

        if ( $deleted_widgets ) {
            $this->wpmm_send_json_success( sprintf( __( "Deleted %s", APMM_TD), $widget_id ) );
        } else {
            $this->wpmm_send_json_error( sprintf( __( "Failed to delete %s", APMM_TD), $widget_id ) );
        }
  }

    /**
     * Deletes a widget from WordPress
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     *
     */
    public function wpmm_delete_widgets( $widget_id ) {

        $this->wpmm_remove_widget_from_sidebar( $widget_id );
        $this->wpmm_remove_widget_instance( $widget_id );

        do_action( "wpmm_after_widget_delete" );

        return true;

    }


    /**
     * Removes a widget from the WP Mega Menu widget sidebar
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * @return string The widget that was removed
     */
    private function wpmm_remove_widget_from_sidebar($widget_id) {

        $widgets = $this->wpmm_get_mega_menu_sidebar_widgets();

        $new_mega_menu_widgets = array();

        foreach ( $widgets as $widget ) {

            if ( $widget != $widget_id )
                $new_mega_menu_widgets[] = $widget;

        }

        $this->wpmm_set_mega_menu_sidebar_widgets($new_mega_menu_widgets);

        return $widget_id;

    }


    /**
     * Removes a widget instance from the database
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    private function wpmm_remove_widget_instance( $widget_id ) {

        $id_base = $this->wpmm_get_id_base_for_widget_id( $widget_id );
        //$widget_number = $this->get_widget_number_for_widget_id( $widget_id );
        $parts = explode( "-", $widget_id );
        $widget_number = absint( end( $parts ) );

        // add blank widget
        $current_widgets = get_option( 'widget_' . $id_base );

        if ( isset( $current_widgets[ $widget_number ] ) ) {

            unset( $current_widgets[ $widget_number ] );

            update_option( 'widget_' . $id_base, $current_widgets );

            return true;

        }

        return false;

    }

    /**
     * Save a widget
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
  public function wpmm_ajax_save_widget(){
        $widget_id = sanitize_text_field( $_POST['widget_id'] );
        $id_base = sanitize_text_field( $_POST['id_base'] );

        check_ajax_referer( 'wpmm_save_widget_' . $widget_id );

        $saved_widgets = $this->wpmm_save_widget( $id_base );

        if ( $saved_widgets ) {
            $this->wpmm_send_json_success( sprintf( __("Saved %s",APMM_TD), $id_base ) );
        } else {
            $this->wpmm_send_json_error( sprintf( __("Failed to save %s", APMM_TD), $id_base ) );
        }
       
       

  }

    /**
     * Saves a widget. Calls the update callback on the widget.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * The callback inspects the post values and updates all widget instances which match the base ID.
     */
    public function wpmm_save_widget( $id_base ) {
        global $wp_registered_widget_updates;

        $control_widgets = $wp_registered_widget_updates[$id_base];

        if ( is_callable( $control_widgets['callback'] ) ) {

            call_user_func_array( $control_widgets['callback'], $control_widgets['params'] );

           do_action( "wpmm_after_widget_save" );

            return true;
        }

        return false;

    }

        /**
     * Returns an array of widgets and second level menu items for a specified parent menu item.
     * Used to display the widgets/menu items in the mega menu builder.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * int $parent_menu_item_id
     *  int $menu_id
     */
    public function wpmm_get_widgets_and_menu_items_for_menu_id( $parent_menu_item_id, $menu_id ) {

        $menu_items = $this->wpmm_get_second_level_menu_items( $parent_menu_item_id, $menu_id ); //get all sub menu item
    
        $widgets = $this->wpmm_getwidgets_menuid( $parent_menu_item_id, $menu_id );

        $items = array_merge( $menu_items, $widgets );
   
        $parent_settings = get_post_meta( $parent_menu_item_id, '_wpmegamenu', true );
        // echo "<pre>";
        // print_r($parent_settings);
        // exit();

        $ordering = isset( $parent_settings['submenu_ordering'] ) ? $parent_settings['submenu_ordering'] : 'natural';

        if ( $ordering == 'forced' ) {

            uasort( $items, array( $this, 'wpmm_sort_by_order' ) );

            $new_items = $items;
            $end_items = array();

            foreach ( $items as $key => $value ) {
                if ( $value['order'] == 0 ) {
                    unset( $new_items[$key] );
                    $end_items[] = $value;
                }
            }

            $items = array_merge( $new_items, $end_items );

        }

        return $items;
    }

    /**
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     * Returns an array of all widgets belonging to a specified menu item ID.
     * int $menu_item_id
     */    
    public function wpmm_getwidgets_menuid( $parent_menu_item_id, $menu_id ) {

        $widgets = array();

        if ( $mega_menu_widgets = $this->wpmm_get_mega_menu_sidebar_widgets() ) {
            foreach ( $mega_menu_widgets as $widget_id ) {
             
                $settings = $this->wpmm_get_settings_for_widget_id( $widget_id );


                if ( isset( $settings['wpmm_mega_menu_parent_menu_id'] ) && $settings['wpmm_mega_menu_parent_menu_id'] == $parent_menu_item_id ) {

                    $name = $this->wpmmgetnameforwidgetid( $widget_id );

                    $widgets[ $widget_id ] = array(
                        'id' => $widget_id,
                        'type' => 'wp_widget',
                        'title' => $name,
                        'columns' => $settings['wpmm_mega_menu_columns'],
                        'order' => isset( $settings['wp_menu_order'][ $parent_menu_item_id ] ) ? $settings['wp_menu_order'][ $parent_menu_item_id ] : 0
                    );

                }

            }

        }

        return $widgets;

    }

    /**
     * Returns the name/title of a Widget
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmmgetnameforwidgetid( $widget_id ) {
        global $wp_registered_widgets;

        $registered_widget = $wp_registered_widgets[$widget_id];

        return $registered_widget['name'];

    }


     /**
     * Returns the widget data as stored in the options table
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_get_settings_for_widget_id( $widget_id ) {

        $id_base = $this->wpmm_get_id_base_for_widget_id( $widget_id );

        if ( ! $id_base ) {
            return false;
        }

        //$widget_number = $this->get_widget_number_for_widget_id( $widget_id );
         $parts = explode( "-", $widget_id );

        $widget_number = absint( end( $parts ) );


        $current_widgets = get_option( 'widget_' . $id_base );

        return $current_widgets[ $widget_number ];

    }

  
    /**
     * Returns an array of immediate child menu items for the current item
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    private function wpmm_get_second_level_menu_items( $parent_menu_item_id, $menu_id ) {

        $items = array();

        // check we're using a valid menu ID
        if ( ! is_nav_menu( $menu_id ) ) {
            return $items;
        }

        $menu = wp_get_nav_menu_items( $menu_id );
        // echo "<pre>";
        // print_r($menu);
        // die();

        if ( count( $menu ) ) {

            foreach ( $menu as $item ) {

                // find the child menu items
                if ( $item->menu_item_parent == $parent_menu_item_id ) {

                    $saved_settings = array_filter( (array) get_post_meta( $item->ID, '_wpmegamenu', true ) );
                    $submitted_default_settings = new AP_Menu_Settings();
                    $submitted_settings = $submitted_default_settings->wpmm_menu_item_defaults();
                    $settings = array_merge(  $submitted_settings , $saved_settings );
                      // echo "<pre>";
                      // print_r($submitted_settings);
                      // die();
                    $items[ $item->ID ] = array(
                        'id' => $item->ID,
                        'type' => 'wpmm_menu_subitem', //menu_item i.e second item display on mega menu
                        'title' => $item->title,
                        'columns' => $settings['wpmm_mega_menu_columns'],
                        'order' => isset( $settings['wp_menu_order'][ $parent_menu_item_id ] ) ? $settings['wp_menu_order'][ $parent_menu_item_id ] : 0
                    );

                }

            }

        }


        return $items;
    }


    /**
     * Sorts a 2d array by the 'order' key
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    function wpmm_sort_by_order( $a, $b ) {

        if ($a['order'] == $b['order']) {
            return 1;
        }
        return ($a['order'] < $b['order']) ? -1 : 1;

    }
     /*
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
     public function wpmm_send_json_success( $json ) {
        if ( ob_get_contents() ) ob_clean();

        wp_send_json_success( $json );
    }

     /**
     * Send JSON response.
     *
     * Remove any warnings or output from other plugins which may corrupt the response
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_send_json_error( $json ) {
        if ( ob_get_contents() ) ob_clean();

        wp_send_json_error( $json );
    }



    /**
     * Returns the HTML for a single widget instance.
     *  Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmmshowwidget( $id ) {
        global $wp_registered_widgets;

        $lists_arr_parameters = array_merge(
            array( array_merge( array( 'widgetid' => $id, 'widgetname' => $wp_registered_widgets[$id]['name'] ) ) ),
            (array) $wp_registered_widgets[$id]['params']
        );

        $lists_arr_parameters[0]['before_title']  = apply_filters( "wpmm_before_widget_title", '<h4 class="wpmm-mega-block-title">', $wp_registered_widgets[$id] );
        $lists_arr_parameters[0]['after_title']   = apply_filters( "wpmm_after_widget_title", '</h4>', $wp_registered_widgets[$id] );
        $lists_arr_parameters[0]['before_widget'] = apply_filters( "wpmm_before_widget", "", $wp_registered_widgets[$id] );
        $lists_arr_parameters[0]['after_widget']  = apply_filters( "wpmm_after_widget", "", $wp_registered_widgets[$id] );

        $callback = $wp_registered_widgets[$id]['callback'];

        if ( is_callable( $callback ) ) {
            ob_start();
            call_user_func_array( $callback, $lists_arr_parameters );
            return ob_get_clean();
        }

    }

    /**
     * Returns the class name for a widget instance. Get Class of Widgets
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_getwidget( $id ) {
        global $wp_registered_widgets;

        if ( isset ( $wp_registered_widgets[$id]['classname'] ) ) {
            return $wp_registered_widgets[$id]['classname'];
        }

        return "";
    }

    


}

endif;