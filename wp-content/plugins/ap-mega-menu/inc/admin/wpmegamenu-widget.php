<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('WP_Mega_Menu_Widget') ) :

/**
 * Outputs a registered menu location using wp_nav_menu
 */
class WP_Mega_Menu_Widget extends WP_Widget {

        public function __construct() {
            parent::__construct('wpmegamenu_widget', // Base ID
                                'AP Mega Menu Widget', // Name
                                 array('description' => __('Display AP Mega Menu Location on selected area.', APMM_TD)));
        }

/**
     * Front-end display of widget.
     */
    public function widget( $args, $instance ) {
        extract( $args );

        if ( isset( $instance['location'] ) ) {
            $location = $instance['location'];

            $title = apply_filters( 'widget_title', $instance['title'] );

            echo $before_widget;

            if ( ! empty( $title ) ) {
                echo $before_title . $title . $after_title;
            }

            if ( has_nav_menu( $location ) ) {
                 wp_nav_menu( array( 'theme_location' => $location ) );
            }

            echo $after_widget;
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['location'] = strip_tags( $new_instance['location'] );
        $instance['title'] = strip_tags( $new_instance['title'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     */
    public function form( $instance ) {

        $selected_location = 0;
        $title = "";
        $locations = get_registered_nav_menus();

        if ( isset( $instance['location'] ) ) {
            $selected_location = $instance['location'];
        }

        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        }

        ?>
        <p>
            <?php if ( $locations ) { ?>
                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', APMM_TD); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
                </p>
                <label for="<?php echo $this->get_field_id( 'location' ); ?>"><?php _e( 'Menu Location:', APMM_TD); ?></label>
                <select id="<?php echo $this->get_field_id( 'location' ); ?>" name="<?php echo $this->get_field_name( 'location' ); ?>">
                    <?php
                        foreach ( $locations as $location => $description ) {
                            echo "<option value='{$location}'" . selected($location, $selected_location) . ">{$description}</option>";
                        }
                    ?>
                </select>
            <?php } else {
            _e( 'No menu locations found', APMM_TD);
            } ?>
        </p>
        <?php
    }
}

endif;

if ( ! class_exists('WP_Mega_Menu_Contact_Info') ) :

/**
 * Outputs a contact information from widget
 */
class WP_Mega_Menu_Contact_Info extends WP_Widget {

        public function __construct() {
            parent::__construct('wpmegamenu_contact_info', // Base ID
                                'AP Mega Menu Contact Info', // Name
                                 array('description' => __('Display AP Mega Menu Contact Information.', APMM_TD)));
        }

/**
     * Front-end display of widget.
     */
   public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        echo "<div class='wpmegamenu-contact-info'>";

        if(isset($instance['address_font_icon']) || isset($instance['address'])){
              echo "<p>";
                if(isset($instance['address_font_icon']) && $instance['address_font_icon']!=''){
                    echo "<i class='".$instance['address_font_icon']."'></i>";
                }
                if(isset($instance['address']) && $instance['address']!=''){
                    echo $instance['address'];
                }
              echo "</p>";
        }

       if(isset($instance['phone_font_icon']) || isset($instance['phone'])){
              echo "<p>";
                if(isset($instance['phone_font_icon']) && $instance['phone_font_icon']!=''){
                    echo "<i class='".$instance['phone_font_icon']."'></i>";
                }
                if(isset($instance['phone']) && $instance['phone']!=''){
                    echo $instance['phone'];
                }
              echo "</p>";
        }

      if(isset($instance['email_font_icon']) || isset($instance['email'])){
              echo "<p>";
                if(isset($instance['email_font_icon']) && $instance['email_font_icon']!=''){
                    echo "<i class='".$instance['email_font_icon']."'></i>";
                }
                if(isset($instance['email']) && $instance['email']!=''){
                    echo $instance['email'];
                }
              echo "</p>";
        }

      if(isset($instance['website_font_icon']) || isset($instance['website'])){
              echo "<p>";
                if(isset($instance['website_font_icon']) && $instance['website_font_icon']!=''){
                    echo "<i class='".$instance['website_font_icon']."'></i>";
                }
                if(isset($instance['website']) && $instance['website']!=''){
                    echo $instance['website'];
                }
              echo "</p>";
        }

        if(isset($instance['custom_shortcode_title']) || (isset($instance['custom_shortcode']))){
            echo "<div class='wpmm-social-shortcodes'>";
            echo "<h4>".$instance['custom_shortcode_title']."</h4>";
            if( $instance['custom_shortcode']!=''){
            echo do_shortcode($instance['custom_shortcode']);
            }
            echo "</div>";
        }
         
         echo "</div>";
        echo $args['after_widget'];
    }

    /**
     * Sanitize widget form values as they are saved.
     * @param array   $new_instance Values just sent to be saved.
     * @param array   $old_instance Previously saved values from database.
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['address'] = strip_tags( $new_instance['address'] );
        $instance['address_font_icon'] = strip_tags( $new_instance['address_font_icon'] );
        $instance['phone'] = strip_tags( $new_instance['phone'] );
        $instance['phone_font_icon'] = strip_tags( $new_instance['phone_font_icon'] );
        $instance['email'] = strip_tags( $new_instance['email'] );
        $instance['email_font_icon'] = strip_tags( $new_instance['email_font_icon'] );
        $instance['website'] = strip_tags( $new_instance['website'] );
        $instance['website_font_icon'] = strip_tags( $new_instance['website_font_icon'] );
        $instance['custom_shortcode'] = strip_tags( $new_instance['custom_shortcode'] );
        $instance['custom_shortcode_title'] = strip_tags( $new_instance['custom_shortcode_title'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = '';
        }
         if(isset($instance['address']))
        {
            $address = $instance['address'];
        }
        else
        {
            $address = '';
        }
         if(isset($instance['address_font_icon']))
        {
            $address_font_icon = $instance['address_font_icon'];
        }
        else
        {
            $address_font_icon = '';
        }
         if(isset($instance['phone']))
        {
            $phone = $instance['phone'];
        }
        else
        {
            $phone = '';
        }
          if(isset($instance['phone_font_icon']))
        {
            $phone_font_icon = $instance['phone_font_icon'];
        }
        else
        {
            $phone_font_icon = '';
        }
          if(isset($instance['email']))
        {
            $email = $instance['email'];
        }
        else
        {
            $email = '';
        }
          if(isset($instance['email_font_icon']))
        {
            $email_font_icon = $instance['email_font_icon'];
        }
        else
        {
            $email_font_icon = '';
        }
                  if(isset($instance['website']))
        {
            $website = $instance['website'];
        }
        else
        {
            $website = '';
        }
                    if(isset($instance['website_font_icon']))
        {
            $website_font_icon = $instance['website_font_icon'];
        }
        else
        {
            $website_font_icon = '';
        }
        if(isset($instance['custom_shortcode']))
        {
            $custom_shortcode = $instance['custom_shortcode'];
        }
        else
        {
            $custom_shortcode = '';
        }
          if(isset($instance['custom_shortcode_title']))
        {
            $custom_shortcode_title = $instance['custom_shortcode_title'];
        }
        else
        {
            $custom_shortcode_title = '';
        }
        ?>
        <p>
        
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ,APMM_TD); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'address_font_icon' ); ?>"><?php _e( 'Address Icon:' ,APMM_TD); ?></label> 
        <p class="description"><?php _e('Use Fontawesome Class for Address Icon such as fa fa-home',APMM_TD);?></p>
        <input class="widefat" id="<?php echo $this->get_field_id( 'address_font_icon' ); ?>" name="<?php echo $this->get_field_name( 'address_font_icon' ); ?>" type="text" value="<?php echo esc_attr( $address_font_icon ); ?>" placeholder="<?php _e('E.g., fa fa-home',APMM_TD);?>">
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('address');?>"><?php _e('Address',APMM_TD)?></label>
         <textarea class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>"><?php echo esc_attr( $address ); ?></textarea>
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'phone_font_icon' ); ?>"><?php _e( 'Phone Icon:' ,APMM_TD); ?></label> 
        <p class="description"><?php _e('Use Fontawesome Class for Phone Icon such as fa fa-phone',APMM_TD);?></p>
        <input class="widefat" id="<?php echo $this->get_field_id( 'phone_font_icon' ); ?>" name="<?php echo $this->get_field_name( 'phone_font_icon' ); ?>" type="text" value="<?php echo esc_attr( $phone_font_icon ); ?>" placeholder="<?php _e('E.g., fa fa-phone',APMM_TD);?>">
        </p>
        <p>
        
        <label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:' ,APMM_TD); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>">
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'email_font_icon' ); ?>"><?php _e( 'Email Icon:' ,APMM_TD); ?></label> 
        <p class="description"><?php _e('Use Fontawesome Class for Email Icon such as fa fa-phone',APMM_TD);?></p>
        <input class="widefat" id="<?php echo $this->get_field_id( 'email_font_icon' ); ?>" name="<?php echo $this->get_field_name( 'email_font_icon' ); ?>" type="text" value="<?php echo esc_attr( $email_font_icon ); ?>" placeholder="<?php _e('E.g., fa fa-email',APMM_TD);?>">
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:' ,APMM_TD); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="email" value="<?php echo esc_attr( $email ); ?>">
        </p>
       
         <p>
        
        <label for="<?php echo $this->get_field_id( 'website_font_icon' ); ?>"><?php _e( 'Website Icon:' ,APMM_TD); ?></label> 
        <p class="description"><?php _e('Use Fontawesome Class for Website Icon such as fa fa-phone',APMM_TD);?></p>
        <input class="widefat" id="<?php echo $this->get_field_id( 'website_font_icon' ); ?>" name="<?php echo $this->get_field_name( 'website_font_icon' ); ?>" type="text" value="<?php echo esc_attr( $website_font_icon ); ?>" placeholder="<?php _e('E.g., fa fa-globe',APMM_TD);?>">
        </p>
         <p>
        <label for="<?php echo $this->get_field_id( 'website' ); ?>"><?php _e( 'Website:' ,APMM_TD); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'website' ); ?>" name="<?php echo $this->get_field_name( 'website' ); ?>" type="text" value="<?php echo esc_attr( $website ); ?>">
        </p>



          <p>
          <label for="<?php echo $this->get_field_id('custom_shortcode_title');?>"><?php _e('Custom Title',APMM_TD)?></label>
         <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'custom_shortcode_title' ); ?>" name="<?php echo $this->get_field_name( 'custom_shortcode_title' ); ?>" value="<?php echo esc_attr( $custom_shortcode_title ); ?>"/>
        </p>

          <p>
          <label for="<?php echo $this->get_field_id('custom_shortcode');?>"><?php _e('Custom Shortcode',APMM_TD)?></label>
         <textarea class="widefat" id="<?php echo $this->get_field_id( 'custom_shortcode' ); ?>" name="<?php echo $this->get_field_name( 'custom_shortcode' ); ?>"><?php echo esc_attr( $custom_shortcode ); ?></textarea>
        </p>






        <?php 
    }
}

endif;


      