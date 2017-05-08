<?php if ( ! defined( 'ABSPATH' ) ) { 
exit; // disable direct access 
}

if( ! class_exists( 'WPMegamenuWalker_Class' ) ) :

class WPMegamenuWalker_Class extends Walker_Nav_Menu {
/**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        
        $output .= "\n$indent<div class='wpmm-sub-menu-wrapper wpmm-menu{$depth}'>";
            //here
        $output .= "<ul class=\"wp-mega-sub-menu\">\n"; // starting loop for sub items 
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";

    }

    /**
     * Custom walker. Add the widgets into the menu.
     *
     * @see Walker::start_el()
     *
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {


      if (is_array($args)) {
            echo "WP Megamenu Notice: You haven\'t set Menu locations in menu settings or menu you selected as megamenu is not available.";
            die();
        }

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

       
       if (!get_option('apmega_settings')) {
             $ap_menu = new APMM_Class();
             $general_settings = $ap_menu->apmm_default_settings();
        }else{
             $general_settings = get_option( 'apmega_settings' );
        }
        

        if ( property_exists( $item, 'wpmegamenu_settings' ) ) {
            $settings = $item->wpmegamenu_settings;
        } else {
           $settings = AP_Menu_Settings::wpmm_menu_item_defaults();
        }

        // Item Class  passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'menu-item-depth-' . $depth;
       if (isset($args->has_children) && $args->has_children == true) {
            $classes[] = "has-dropdown";
        } else {
            $classes[] = "no-dropdown";
        }

         if (isset($settings['upload_image_settings']['use_custom_settings']) && $settings['upload_image_settings']['use_custom_settings'] == 'true' && $depth > 0 ) {
             $classes[] = "wpmm-custom-post-settings";
             if(isset( $settings['upload_image_settings']['text_position'])){
                   $classes[] = APMM_CSS_PREFIX.'image-'.$settings['upload_image_settings']['text_position'];
             }
         }


        $class = join( ' ', apply_filters( 'wpmm_nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        // strip widget classes back to how they're intended to be output
        $class = str_replace( "wp_mega_menu_widget_wrap-", "", $class );

        // Item ID
        $itemid = esc_attr( apply_filters( 'wpmegamenu_nav_menu_item_id', "wp_nav_menu-item-{$item->ID}", $item, $args ) );
       
      
       // build html
       $output .= $indent ."<li class='{$class}' id='{$itemid}'>";

       // echo "<pre>";
       // print_r($item);

        // output the widgets
        if ( $item->type == 'widget' && $item->content ) {
         $item_output = $item->content;
        } else {

            $sub_attrs = array();

            $sub_attrs['title'] = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $sub_attrs['target'] = ! empty( $item->target ) ? $item->target : '';
            $sub_attrs['class'] = '';
            $sub_attrs['rel'] = ! empty( $item->xfn ) ? $item->xfn : '';

            if (isset($settings['general_settings']['active_link']) && $settings['general_settings']['active_link'] == 'true') {
                $sub_attrs['href'] = ! (empty( $item->url ) && $item->url != '#') ? esc_url($item->url) : '';
            }

            if ( isset( $general_settings['hide_icons']) && $general_settings['hide_icons'] == '1' ) {
                $sub_attrs['class'] = "hide_main_icons";
            }

            $sub_attrs = apply_filters( 'wp_mega_menu_nav_menu_link_attributes', $sub_attrs, $item, $args );

            if ( strlen( $sub_attrs['class'] ) ) {
                $sub_attrs['class'] = $sub_attrs['class'] . ' wp-mega-menu-link';
            } else {
                $sub_attrs['class'] = 'wp-mega-menu-link';
            }

            if (isset($settings['mega_menu_settings']['choose_menu_type']) && $settings['mega_menu_settings']['choose_menu_type'] == 'search_type') {
                      $choose_style = isset($settings['mega_menu_settings']['custom_content'])?$settings['mega_menu_settings']['custom_content']:'';
                      $out = $this->wpmm_get_all_attributes( 'wp_megamenu_search_form', $choose_style );
                      $template_type = $out['template_type'];
                     // $style = $out['style'];
                      if($template_type == "inline-search"){
                       $classtype = "wpmega-searchinline";
                      }else{
                        $classtype = "wpmega-searchdown";
                      }

                $sub_attrs['class'] =  'wpmm-search-type '.$classtype ;
            }

             /* Custom Single Menu Item Link Such as for social links*/
             if (isset($settings['general_settings']['active_single_menu']) && $settings['general_settings']['active_single_menu'] == 'enabled') {
                $sub_attrs['class'] =  'wpmm-csingle-menu';
             }
            if (isset($settings['general_settings']['disable_text']) && $settings['general_settings']['disable_text'] == 'true' ) {
                    $sub_attrs['class'] .=  ' wpmm-disable-text';
               }

            $attributes = '';

            foreach ( $sub_attrs as $attr => $value ) {

                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }

            }

           /* Case 1: Show Menu label*/
           $menu_label = (isset($settings['general_settings']['top_menu_label']) && $settings['general_settings']['top_menu_label'] != "")?esc_attr($settings['general_settings']['top_menu_label']):'';

           $item_output = $args->before;

              
              $item_output .= '<a'. $attributes .'>';
 
               if (isset($settings['upload_image_settings']['use_custom_settings']) && $settings['upload_image_settings']['use_custom_settings'] != 'true') {
                if(!empty($menu_label)){
                      if($depth == 0){
                        $depthclass = "wpmm_depth_first";
                      }else{
                        $depthclass = "wpmm_depth_last";
                      }
                      $mlabel = (isset($general_settings['mlabel_animation_type'])?$general_settings['mlabel_animation_type']:'none');
                      if($mlabel != 'none'){
                        $item_output .= '<span class="wpmm-mega-menu-label '.$depthclass.' '.$mlabel.'" aria-hidden="true">'.ucwords($menu_label).'</span>';
                      }else{
                        $item_output .= '<span class="wpmm-mega-menu-label '.$depthclass.'" aria-hidden="true">'.ucwords($menu_label).'</span>'; 
                      }
                }
              }
  
    // echo "<pre>";
    // print_r($settings);
    // echo '<br/>';

              /* check menu icons */
             /* Case 2: To show icons menu is equal to 1 */
            if (isset( $general_settings['hide_icons']) && $general_settings['hide_icons'] != '1') {
                if (!isset( $settings['general_settings']['menu_icon']) || $settings['general_settings']['menu_icon'] != 'disabled') {
               if( isset( $settings['icons_settings']['icon_choose'] ) ) { 
                $attr_class = $settings['icons_settings']['icon_choose'];

                $split = explode('|',$attr_class,2);  
                $v1 = @$split[0];
                $v2 = @$split[1];
                $icon_class = $v1." ".$v2;
                
                if (isset($settings['mega_menu_settings']['choose_menu_type']) && $settings['mega_menu_settings']['choose_menu_type'] == 'search_type' && $depth == 0) {
                      $choose_style = $settings['mega_menu_settings']['custom_content'];
                      $out = $this->wpmm_get_all_attributes( 'wp_megamenu_search_form', $choose_style );
                      $template_type = $out['template_type'];
                     // $style = $out['style'];
                      if($template_type == "inline-search"){
                       $classtype = "wpmm-search-inline";
                      }else{
                        $classtype = "";
                      }
                      
                     $item_output .= '<span class="wpmm-mega-menu-icon '.$classtype.'"><i class="wpmm-mega-menu-icon ' . $icon_class . '" aria-hidden="true"></i></span>';
                    if($template_type == "inline-search"){
                        $item_output .= '<div class="wpmm-search-form">'.do_shortcode($choose_style).'</div>';
                    }
                }else{
                         if($attr_class != ''){
                             $item_output .= '<i class="wpmm-mega-menu-icon ' . $icon_class . '" aria-hidden="true"></i>';
                         }
                  }
                }
              }
             
            }

          //} // check if second level custom settings is enable or not , if enable dont display menu icon and label here.

          /* Case 3: To display menu title if enable */
            /*menu icons check end*/
           if (isset($settings['general_settings']['disable_text']) && $settings['general_settings']['disable_text'] == 'true' ) {
                /** This filter is documented in wp-includes/post-template.php */
            }else{
                  if (isset($settings['upload_image_settings']['use_custom_settings']) && $settings['upload_image_settings']['use_custom_settings'] == 'true') {
                   //dont show menu text here for custom settings
                  }else{
                    //display menu title
                    if (!isset($settings['general_settings']['disable_text'])) {
                        $item_output .= '<span class="wpmm-mega-menu-href-title">';
                        $item_output .= $args->link_before . apply_filters( 'wp_mega_menu_the_title', $item->title, $item->ID ) . $args->link_after;    
                        $item_output .= '</span>';
                    }else{
                        if (isset($settings['general_settings']['disable_text']) && $settings['general_settings']['disable_text'] == "false") {
                        $item_output .= '<span class="wpmm-mega-menu-href-title">';
                        $item_output .= $args->link_before . apply_filters( 'wp_mega_menu_the_title', $item->title, $item->ID ) . $args->link_after;    
                        $item_output .= '</span>';
                      }
                    }
                  if( isset($item->description) && $item->description != '' ){
                     $item_output .= '<span class="wpmm-span-divider"></span>';
                    $item_output .= '<span class="wpmm-target-description wpmm-target-text">';
                    $item_output .= $item->description;
                    $item_output .= '</span>';
                  }
                 }
                
               
            }

             
  
            $item_output .= '</a>';


            $item_output .= $args->after;



               /* Display Top Content for megamenu*/
            if($depth == 0){
              if(isset($settings['menu_type']) && $settings['menu_type'] == "megamenu" && isset($settings['mega_menu_settings']['choose_menu_type']) && $settings['mega_menu_settings']['choose_menu_type'] != 'search_type'){
                $item_output .= "<div class='wpmm-sub-menu-wrap'>";
               }else if(isset($settings['mega_menu_settings']['choose_menu_type']) && $settings['mega_menu_settings']['choose_menu_type'] == 'search_type' && isset($settings['menu_type']) && $settings['menu_type'] != "megamenu"){
                         $choose_style = $settings['mega_menu_settings']['custom_content'];
                         $out = $this->wpmm_get_all_attributes( 'wp_megamenu_search_form', $choose_style );
                         $template_type = $out['template_type'];
                       if($template_type == "megamenu-type-search"){   
                           $item_output .= "<div class='wpmm-sub-menu-wrap'>";
                         }
               }
               

                if(isset($settings['menu_type']) && $settings['menu_type'] == "megamenu" && isset($settings['mega_menu_settings']['show_top_content']) && $settings['mega_menu_settings']['show_top_content'] == 'true'){
                    if(isset($settings['mega_menu_settings']['top']['top_content_type'])){
                    if($settings['mega_menu_settings']['top']['top_content_type'] == "text_only"){
                        //text only

                     $topcontent = $settings['mega_menu_settings']['top']['top_content'];
                     if($topcontent != ''){
                     $item_output .= "<span class='wpmm_megamenu_topcontent'>".$topcontent."</span><div class='clear top_clearfix'></div>";
                    }
               

                    }else if($settings['mega_menu_settings']['top']['top_content_type'] == "image_only"){
                          //image only
                        $image_url = $settings['mega_menu_settings']['top']['image_url'];
                        if($image_url != ''){
                          $topimage = "<img src='".$image_url."'/>";
                          $item_output .= "<div class='wpmm-topimage'>".$topimage."</div><div class='clear top_clearfix'></div>";
                         }
                    }else{

                      $html_content = (isset($settings['mega_menu_settings']['top']['html_content']) && $settings['mega_menu_settings']['top']['html_content'] != '')?$settings['mega_menu_settings']['top']['html_content']:'';
                      if( $html_content != ''){
                          $item_output .= "<div class='wpmm-html-content wpmm-ctop'>". $html_content."</div><div class='clear top_clearfix'></div>";
                      }


                    }
                 }//close top content type

                }//megamenu check close


                 if (isset($settings['mega_menu_settings']['choose_menu_type']) && $settings['mega_menu_settings']['choose_menu_type'] == 'search_type') {
                        $choose_style = $settings['mega_menu_settings']['custom_content'];
                        $out = $this->wpmm_get_all_attributes( 'wp_megamenu_search_form', $choose_style );
                        $template_type = $out['template_type'];
                        //$style = $out['style'];
                        if($template_type == "megamenu-type-search"){
                         $item_output .= '<div class="wpmm-search-form">'.do_shortcode($choose_style).'</div>';
                        }

                   }
            }//top depth check complete

         /* Case 4: Show custom setting for submegamenu with post details display on sub menu ,feasible only on meagemenu type*/
                if (isset($settings['upload_image_settings']['use_custom_settings']) && $settings['upload_image_settings']['use_custom_settings'] == 'true' && $depth > 0) {
                 $post_id = $item->object_id;
                 $get_posts_details = get_post($item->object_id ); 

                 $title = isset($get_posts_details->post_title)?$get_posts_details->post_title:'';
                 $post_date = isset($get_posts_details->post_date)?date('d F Y',strtotime($get_posts_details->post_date)):'';

                 $post_date = isset($get_posts_details->post_date)?date('d F Y',strtotime($get_posts_details->post_date)):'';
                 
                 if(isset($settings['upload_image_settings']['show_description']) && $settings['upload_image_settings']['show_description'] == 'true'){
                    $post_length = isset($settings['upload_image_settings']['show_desc_length'])?$settings['upload_image_settings']['show_desc_length']:'';
                    $desc = $this->wpmm_get_excerpt_by_id($post_id,$post_length);
                   
                 }else{
                     $desc = '';
                 }

                //author name
                if(isset($settings['upload_image_settings']['display_author_name']) && $settings['upload_image_settings']['display_author_name'] == 'true'){
                     $post_author_id = isset($get_posts_details->post_author)?$get_posts_details->post_author:'';
                   //$author_name = get_author_name($post_author_id); 
                   $author_name = get_the_author_meta('display_name',$post_author_id); 
                 }else{
                     $author_name = '';
                 }

                 //category name
                if(isset($settings['upload_image_settings']['display_cat_name']) && $settings['upload_image_settings']['display_cat_name'] == 'true'){
                    $category = get_the_category( $post_id );
                    $cat_name = (isset($category[0]) && $category[0]->cat_name != '')?$category[0]->cat_name:'';
                 }else{
                     $cat_name = '';
                 }

                 // $desc = isset($post_7->post_content)?$post_7->post_excerpt:'';
                  if(isset($settings['upload_image_settings']['display_posts_images']) && $settings['upload_image_settings']['display_posts_images'] == "featured-image"){
                     $default_imgsetsize = (isset($settings['upload_image_settings']['image_size']))?$settings['upload_image_settings']['image_size']:'default';
                     if( $default_imgsetsize == "default"){
                            $imgsetsize = $general_settings['image_size'];
                     }else{
                            $imgsetsize = $settings['upload_image_settings']['image_size'];
                     }
                     $img_src = get_the_post_thumbnail( $item->object_id, $imgsetsize);
                     $image_url = get_the_post_thumbnail( $item->object_id, $imgsetsize);
                     $class_name = "wpmm-featured-image";
                     $stylee = '';
                 }else{
                    $image_url = isset($settings['upload_image_settings']['default_thumbnail_imageurl'])?esc_url($settings['upload_image_settings']['default_thumbnail_imageurl']):'';
                    $enable_custom_inherit = (isset($settings['upload_image_settings']['enable_custom_inherit']) && $settings['upload_image_settings']['enable_custom_inherit'] ==1)?'1':'0';
                     if( $enable_custom_inherit == "1"){
                        //choose default custom set
                          $image_width = isset($general_settings['custom_width'])?esc_attr($general_settings['custom_width']):'';
                     }else{
                         $image_width = isset($settings['upload_image_settings']['custom_width'])?esc_attr($settings['upload_image_settings']['custom_width']):''; 
                     }
                    
                   if($image_width != ''){
                        $stylee = "style='width:".$image_width.";'";
                    }else{
                        $stylee = ''; 
                    }
                    $img_src = "<img src='".$image_url."'/>";
                    $class_name = "wpmm-custom-image";
                 }


                 if(isset($settings['upload_image_settings']['display_readmore']) && $settings['upload_image_settings']['display_readmore'] == "true"){
                   $readmorelink = isset($settings['upload_image_settings']['readmore_text'])?$settings['upload_image_settings']['readmore_text']:'';
                 }else{
                    $readmorelink = '';
                 }

                $class_position = (isset($settings['upload_image_settings']['text_position'])?$settings['upload_image_settings']['text_position']:'left');
                

                 $item_output .= '<div class="wpmm-sub-menu-posts">';

 
                   $item_output .= '<div class="wpmm-custom-postimage">';
                   $item_output .= '<a'. $attributes .'>';
                   
                    if($image_url != ''){
                     $item_output .= '<div class='.$class_name.' '.$stylee.'>';
                     }
                     if($image_url != ''){
                             // show menu label on image overlap for custom settings
                             if(!empty($menu_label)){
                               
                                $item_output .= '<span class="wpmm-custom-label" aria-hidden="true">'.ucwords($menu_label).'</span>';
                                
                             }
                           $item_output .= $img_src;      
                     }

                    if($class_position != "onlyimage"){
                      if($cat_name != ''){
                        $item_output .= '<span class="wpmm-post-category">'. $cat_name.'</span>'; 
                      }
                    }

                  if($image_url != ''){
                     $item_output .= "</div>";
                   }

                     if($class_position != "onlyimage"){
                        if($image_url == '' && !empty($menu_label)){
               
                            $item_output .= '<span class="wpmm-mega-menu-label" aria-hidden="true">'.ucwords($menu_label).'</span>';
                            
                        }
                     $item_output .= '<span class="wpmm-mega-menu-href-title">'; 
                     $item_output .= $args->link_before .apply_filters( 'wp_mega_menu_the_title', $item->title, $item->ID ). $args->link_after;
                     $item_output .= '</span>';
                     if($author_name != ''){
                        $texxt = __('By',APMM_TD);
                        $item_output .= '<span class="wpmm-author-name">'.$texxt.' '.$author_name.'</span>'; 
                     }
                     if(isset($settings['upload_image_settings']['display_post_date']) && $settings['upload_image_settings']['display_post_date'] == "true"){
                           $item_output .= "<span class='megapost-date'>".$post_date."</span>";
                     }
                    //== display desc ==
                     if(isset($settings['upload_image_settings']['show_description']) && $settings['upload_image_settings']['show_description'] == 'true'){
                     $item_output .= "<p class='wpmm-posts-desc'>".$desc."</p>";
                     }
                    }

                    $item_output .= '</a>';                    
                    //==readmore link here==
                    if(isset($settings['upload_image_settings']['display_readmore']) && $settings['upload_image_settings']['display_readmore'] == "true"){
                                     $item_output .= "<span class='wpmmreadmorelink'>";
                                     $item_output .= '<a'. $attributes .'>';
                                     $item_output .= $args->link_before .$readmorelink. $args->link_after;
                                     $item_output .= '</a>';
                                     $item_output .= '</span>';
                             }
                 
                
                  $item_output .= "</div>";
                  

                  $item_output .= "</div>";
                   /* Case 4: Megamenu Show custom setting for submegamenu Start for post details display end*/
                }
  

      }


         $output .= apply_filters( 'wp_mega_menu_walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $item_output = "";
         /* Display Bottom Content for megamenu*/
            if(isset($item->wpmegamenu_settings['menu_type']) &&  $item->wpmegamenu_settings['menu_type'] == "megamenu" && isset($item->wpmegamenu_settings['mega_menu_settings']['show_bottom_content']) && $item->wpmegamenu_settings['mega_menu_settings']['show_bottom_content'] == 'true' && $depth == 0){
            
              if(isset($item->wpmegamenu_settings['mega_menu_settings']['bottom']['bottom_content_type'])){
                 if($item->wpmegamenu_settings['mega_menu_settings']['bottom']['bottom_content_type'] == "text_only"){
                        //text only
                    $bottomcontent = $item->wpmegamenu_settings['mega_menu_settings']['bottom']['bottom_content'];
                     if($bottomcontent != ''){
                       $item_output .= "<div class='clear bottom_clearfix'></div><span class='wpmm_megamenu_bottomcontent'>".$bottomcontent."</span>";
                      }
                    }else if($item->wpmegamenu_settings['mega_menu_settings']['bottom']['bottom_content_type'] == "image_only"){
                          //image only
                        $bimage_url = $item->wpmegamenu_settings['mega_menu_settings']['bottom']['image_url'];
                        if($bimage_url != ''){
                        $bottomimage = "<img src='".$bimage_url."'/>";
                        $item_output .= "<div class='clear bottom_clearfix'></div><div class='wpmm-bottomimage'>".$bottomimage."</div>";
                        }

                    }else{
                         //html content for bottom
                          $html_bcontent = (isset($item->wpmegamenu_settings['mega_menu_settings']['bottom']['html_content']) && $item->wpmegamenu_settings['mega_menu_settings']['bottom']['html_content'] != '')?$item->wpmegamenu_settings['mega_menu_settings']['bottom']['html_content']:'';
                          if($html_bcontent != ''){
                           $item_output .= "<div class='clear bottom_clearfix'></div><div class='wpmm-html-content wpmm-cbottom'>". $html_bcontent."</div>";
                          }
                    }
                  }
                  if(isset($settings['menu_type']) && $settings['menu_type'] == "megamenu"){
                    $item_output .= "</div>";
                   }
            } 
        // $item_output .="</div>";
        $output .= $item_output;
        $output .= "</li>"; // remove new line to remove the 4px gap between menu items
    
    }

    /**
     * Grab all attributes for a given shortcode in a text
     *
     * @uses get_shortcode_regex()
     * @uses shortcode_parse_atts()
     * @param  string $tag   Shortcode tag
     * @param  string $text  Text containing shortcodes
     * @return array  $out   Array of attributes
     */

    public function wpmm_get_all_attributes( $tag, $text )
    {
        preg_match_all( '/' . get_shortcode_regex() . '/s', $text, $matches );

        if( isset( $matches[2] ) )
        {
            foreach( (array) $matches[2] as $key => $value )
            {
                if( $tag === $value )
                    $out = shortcode_parse_atts( $matches[3][$key] );  
            }
        }
        return $out;
    }

   public function wpmm_get_excerpt_by_id($post_id,$post_length){
        $the_post = get_post($post_id); //Gets post ID
        $the_excerpt = $the_post->post_excerpt; //Gets post_content to be used as a basis for the excerpt
        $excerpt_length = $post_length; //Sets excerpt length by word count
        $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
        $words = explode(' ', $the_excerpt, $excerpt_length + 1);
        if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '');
        $the_excerpt = implode(' ', $words);
        endif;
        $the_excerpt =  $the_excerpt;
        return $the_excerpt;
     }

}

endif;

    