<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
  Plugin Name: AP Mega Menu
  Plugin URI:  https://accesspressthemes.com/wordpress-plugins/ap-mega-menu/
  Description: Horizontal & Vertical layout Mega menu | Responsive & User friendly | Widgetized, Drag & Drop | Built-in and custom layouts
  Version:     1.0.5
  Author:      AccessPress Themes
  Author URI:  http://accesspressthemes.com
  License:     GPLv2 or later
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Domain Path: /languages
  Text Domain: ap-mega-menu
 */

defined( 'APMM_VERSION' ) or define( 'APMM_VERSION', '1.0.5' ); //plugin version
defined( 'APMM_TITLE' ) or define( 'APMM_TITLE', 'AP MEGA MENU' ); //plugin version
defined( 'APMM_TD' ) or define( 'APMM_TD', 'ap-mega-menu' ); //plugin's text domain
defined( 'APMM_CSS_PREFIX' ) or define( 'APMM_CSS_PREFIX', 'wpmega-' ); //plugin's text domain
defined( 'APMM_IMG_DIR' ) or define( 'APMM_IMG_DIR', plugin_dir_url( __FILE__ ) . 'images' ); //plugin image directory
defined( 'APMM_JS_DIR' ) or define( 'APMM_JS_DIR', plugin_dir_url( __FILE__ ) . 'js' );  //plugin js directory
defined( 'APMM_CSS_DIR' ) or define( 'APMM_CSS_DIR', plugin_dir_url( __FILE__ ) . 'css' ); // plugin css dir
defined( 'APMM_PATH' ) or define( 'APMM_PATH', plugin_dir_path( __FILE__ ) );
defined( 'APMM_URL' ) or define( 'APMM_URL', plugin_dir_url( __FILE__ ) ); //plugin directory url
if( !defined('AP_MEGAMENU_ITEM_OPTIONS')){
    define( 'AP_MEGAMENU_ITEM_OPTIONS', 'ap-mega-menu-item-options' );
}

if( !defined('AP_MEGAMENU_MENU_LOCATION')){
    define( 'AP_MEGAMENU_MENU_LOCATION', 'ap-mega-menu-location' );
}


if(!class_exists('APMM_Class')){

/**
* Plugin's main class
*/
	class APMM_Class 
	{
		var $apmega_settings;
		
		function __construct()
		{


			# code...
			$this->ap_megamenu_includes();
			$this->apmega_settings = get_option('apmega_settings');
			add_action( 'init', array( $this, 'apmm_initialize' ) ); //executes when init hook is fired
			register_activation_hook( __FILE__, array($this,'apmm_pro_activation' ));
      /*
      * Frontend WP Mega Menu Display
      */
      /* Frontend Display WPMegamenu with integration of Walker class Modification */
      add_filter( 'wp_nav_menu_args', array( $this, 'wpmm_navmenuargs' ), 10000 );

      /* Frontend Display WPMegamenu Widgets For specific menu location and hook on menu objects */
      add_filter( 'wp_nav_menu_objects', array( $this, 'wpmm_addwidgetsmegamenu' ), 9, 2 );
      
      /* Save setup array with _wpmegamenu post meta data into posts array for specific posts */
      add_filter( 'wpmegamenu_navmenu_before_setup', array( $this, 'wpmmsetupmenuitems' ), 3, 2 );
      add_filter( 'wpmm_navmenuafterobj', array( $this, 'wpmm_reordermenuitems' ), 5, 2 );

      /* Apply Neccessary Classes for li items of top level menu with depth check*/
      add_filter( 'wpmm_navmenuafterobj', array( $this, 'wpmm_setclassesmenuitems' ), 7, 2 );

      add_shortcode( 'wp_megamenu_search_form', array( $this, 'wpmm_generate_search_shortcode' ) );
      add_action( 'widgets_init',  array( $this,'wpmm_mega_register_widget' ));

       add_shortcode( 'wpmegamenu', array( $this, 'wpmm_print_menu_shortcode' ) );
       add_action('wp_head',array($this,'prefix_add_header_styles'));
       add_filter('widget_text', 'do_shortcode');

      /*
      * Responsive Hook Frontend WP Mega Menu Display
      */
      /* responsive toggle bar content display filter hook start */
      add_filter( 'wp_nav_menu', array( $this, 'wpmm_mobiletoggle' ), 10, 2 ); // display toggle bar on top of menu frontend
      add_filter('wpmegamenu_togglebar_content',array( $this, 'wpmm_responsive_display_togglebar_content'), 9, 5);

      if (is_admin()) {
              add_action( 'admin_enqueue_scripts', array( $this, 'wp_admin_enqueue_scripts'), 11 ); // load custom admin js hool enqueue script for nav menu page metabox form
              new WPMM_Menu_Widget_Manager(); //get widget section for menu
             
			     }else {
                add_action('wp_enqueue_scripts',array($this,'wpmm_megamenu_frontend_scripts'));
                
            }
            $ap_theme_settings = new AP_Theme_Settings();   // Create new Theme Class
		}

   /*
   * Load Stylesheet on Header
   */
   public function prefix_add_header_styles(){
       
        $options = get_option( 'apmega_settings' );      
        $mlabel_animation_type = (isset($options['mlabel_animation_type']))?$options['mlabel_animation_type']:'none';
        $animation_delay = (isset($options['animation_delay']))?$options['animation_delay'].'s':'2s';
        $animation_duration = (isset($options['animation_duration']))?$options['animation_duration'].'s':'3s';
        $animation_iteration_count = (isset($options['animation_iteration_count']))?$options['animation_iteration_count']:'1';
        $enable_custom_css = (isset($options['enable_custom_css']) && $options['enable_custom_css'] == 1)?'1':'0';
        $custom_css = (isset($options['custom_css']))?$options['custom_css']:'';
        $icon_width = (isset($options['icon_width']) && $options['icon_width'] != '')?$options['icon_width']:'';
 
        echo "<style type='text/css'>";   
          if($mlabel_animation_type != 'none'){  ?>
          span.wpmm-mega-menu-label.wpmm_depth_first{
                   animation-duration:  <?php echo esc_attr($animation_duration);?>;
                   animation-delay:     <?php echo esc_attr($animation_delay);?>;
                   animation-iteration-count: <?php echo $animation_iteration_count;?>;
                   -webkit-animation-duration:  <?php echo esc_attr($animation_duration);?>;
                  -webkit-animation-delay:     <?php echo esc_attr($animation_delay);?>;
                  -webkit-animation-iteration-count: <?php echo $animation_iteration_count;?>;
          }
         <?php }
         if($icon_width != ''){?>
         .wp-megamenu-main-wrapper .wpmm-mega-menu-icon{
            font-size: <?php echo esc_attr($icon_width);?>;
          }
        <?php  }
         if($enable_custom_css == 1){
            echo $custom_css;
          }
          echo "</style>";  
          }

     


    /**
     * Query WooCommerce activation check
    */
    function is_woocommerce_activated() {
      return class_exists( 'woocommerce' ) ? true : false;
    }


    function wpmm_megamenu_frontend_scripts(){
       $options = get_option( 'apmega_settings' );              // Variables for JS scripts
       $enable_mobile = (isset($options['enable_mobile']) && $options['enable_mobile'] == 1)?'1':'0';
       wp_enqueue_style( 'wpmm-frontend', APMM_CSS_DIR . '/style.css',APMM_TD );
       if( $enable_mobile == 1){
         wp_enqueue_style( 'wpmm-responsive-stylesheet', APMM_CSS_DIR . '/responsive.css',APMM_TD );
       }
       wp_enqueue_style( 'wpmm-animate-css', APMM_CSS_DIR . '/animate.css', false, APMM_TD );
       wp_enqueue_style( 'wpmm-frontwalker-stylesheet', APMM_CSS_DIR . '/frontend_walker.css', true, APMM_TD );
       wp_enqueue_style('wpmm-google-fonts-style', "//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700");
      
       wp_enqueue_script( 'wp_megamenu-frontend_scripts', APMM_JS_DIR . '/frontend.js',array('jquery') , APMM_TD );

       
       if($this->is_woocommerce_activated()){
              $wooenabled = "true";
        }else{
             $wooenabled = "false";
        }
     
        $mlabel_animation_type = (isset($options['mlabel_animation_type']))?$options['mlabel_animation_type']:'none';
        $animation_delay = (isset($options['animation_delay']))?$options['animation_delay']:'2';
        $animation_duration = (isset($options['animation_duration']))?$options['animation_duration']:'3';
        $animation_iteration_count = (isset($options['animation_iteration_count']))?$options['animation_iteration_count']:'1';
        wp_localize_script('wp_megamenu-frontend_scripts', 'wp_megamenu_params', array(
          'wpmm_mobile_toggle_option'      => esc_attr($options['mobile_toggle_option']),
          'wpmm_event_behavior'            => esc_attr($options['advanced_click']), //click_submenu or follow_link
          'wpmm_ajaxurl'                   => admin_url('admin-ajax.php'),
          'wpmm_ajax_nonce'                => wp_create_nonce('wpm-ajax-nonce'),
          'check_woocommerce_enabled'      => $wooenabled,
          'wpmm_mlabel_animation_type'     => esc_attr($mlabel_animation_type),
          'wpmm_animation_delay'           => esc_attr($animation_delay),
          'wpmm_animation_duration'        => esc_attr($animation_duration),
          'wpmm_animation_iteration_count'      => esc_attr($animation_iteration_count),
          'enable_mobile'                     => $enable_mobile
        ));
      
       wp_enqueue_style('wpmegamenu-fontawesome', APMM_CSS_DIR . '/wpmm-icons/font-awesome/font-awesome.min.css',true,APMM_TD);
       wp_enqueue_style('wpmegamenu-genericons', APMM_CSS_DIR . '/wpmm-icons/genericons.css',true,APMM_TD);
       wp_enqueue_style( 'dashicons' );
    }




    /*
	  * Includes All AP Mega Menu class
	  */
		function ap_megamenu_includes(){
            foreach ( $this->menuincludes() as $id => $path ) {
                if ( is_readable( $path ) && ! class_exists( $id ) ) {
                    require_once $path;
                }
            }
             $available_skin = array(
              '0' => 
             array('title' => 'Black & White',
                     'id' => 'black-white' ,
                     'color' => '#000000',
                  ), 
              '1' => 
             array('title' => 'Gold Yellowish With Black',
                     'id' => 'gold-yellow-black',
                      'color' => '#dace2e' 
                  ), 
              '2' => 
             array('title' => 'Hunter Shades & White',
                     'id' => 'hunter-shades-white',
                      'color' => '#CFA66F' 
                  ), 
              '3' => 
             array('title' => 'Maroon Reddish & Black',
                     'id' => 'maroon-reddish-black',
                      'color' => '#800000'
                  ), 
              '4' => 
             array('title' => 'Light Blue Sky & White',
                     'id' => 'light-blue-sky-white' ,
                      'color' => '#0AA2EE'
                  ), 
              '5' => 
             array('title' => 'Warm Purple & White',
                     'id' => 'warm-purple-white',
                     'color' => '#9768a8'
                  ), 
               '6' => 
             array('title' => 'SeaGreen & White',
                     'id' => 'sea-green-white',
                     'color' => '#2E8B57'
                  ), 
             '7' => 
             array('title' => 'Clean White',
                     'id' => 'clean-white',
                     'color' => '#fff'
                  )

             );
           $available_skin_themes = get_option('apmm_register_skin');
           if (empty($available_skin_themes)) {
            update_option('apmm_register_skin', $available_skin);
            }else{
               $count = count($available_skin_themes);
               if($count  == "7"){
                    update_option('apmm_register_skin', $available_skin);            
                }

            }
		}

		
		  function menuincludes(){
            return array(
              'wpmegamenuwalker_class'          => APMM_PATH . 'inc/frontend/WPMegamenuWalker_Class.php',
              'ap_menu_settings'                => APMM_PATH . 'inc/admin/menu_settings_class.php',   //admin menu display class
	            'ap_theme_settings'               => APMM_PATH . 'inc/admin/theme_settings_class.php',   //admin menu display class
              'wpmm_menu_widget_manager'        => APMM_PATH . 'inc/admin/widget-manager_class.php',
              'wp_mega_menu_widget'             => APMM_PATH . 'inc/admin/wpmegamenu-widget.php',
	        );
		  }

     /*
		  * Loads the text domain for translation and Session Start, Header start Check
		 */
		function apmm_initialize(){
			load_plugin_textdomain(APMM_TD, false, basename( dirname( __FILE__ ) ) . '/languages' ); //Loads plugin text domain for the translation
			if ( !session_id() && !headers_sent() ) {
				session_start(); //starts session if already not started
			}    
		}

    
     /*
      * Plugin Activation Default Setup
     */
       function apmm_pro_activation(){

        if ( is_multisite() ) {
             include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                if (is_plugin_active('wp-mega-menu-pro/wp-mega-menu-pro.php')) {
                 wp_die( __( 'You need to deactivate WP Mega Menu Pro Plugin in order to activate AP Mega Menu Free plugin.Please deactivate premium one. On deactivating premium plugin, your premium plugin data will not be removed.', APMM_PRO_TD ) );
                // deactivate_plugins('wp-mega-menu/wp-mega-menu.php');
               }
          
          include('inc/backend/multisite-activation.php');
            /**
             * Load Default Settings
             * */
            if (!get_option('apmega_settings')) {
                $apmega_settings = $this->apmm_default_settings();
                update_option('apmega_settings', $apmega_settings);
            }

            /**
             * Google font save
             * */
            $family = array('ABeeZee','Abel','Abril Fatface','Aclonica','Acme','Actor','Adamina','Advent Pro','Aguafina Script','Akronim','Aladin','Aldrich','Alef','Alegreya','Alegreya SC','Alegreya Sans','Alegreya Sans SC','Alex Brush','Alfa Slab One','Alice','Alike','Alike Angular','Allan','Allerta','Allerta Stencil','Allura','Almendra','Almendra Display','Almendra SC','Amarante','Amaranth','Amatic SC','Amethysta','Amiri','Amita','Anaheim','Andada','Andika','Angkor','Annie Use Your Telescope','Anonymous Pro','Antic','Antic Didone','Antic Slab','Anton','Arapey','Arbutus','Arbutus Slab','Architects Daughter','Archivo Black','Archivo Narrow','Arimo','Arizonia','Armata','Artifika','Arvo','Arya','Asap','Asar','Asset','Astloch','Asul','Atomic Age','Aubrey','Audiowide','Autour One','Average','Average Sans','Averia Gruesa Libre','Averia Libre','Averia Sans Libre','Averia Serif Libre','Bad Script','Balthazar','Bangers','Basic','Battambang','Baumans','Bayon','Belgrano','Belleza','BenchNine','Bentham','Berkshire Swash','Bevan','Bigelow Rules','Bigshot One','Bilbo','Bilbo Swash Caps','Biryani','Bitter','Black Ops One','Bokor','Bonbon','Boogaloo','Bowlby One','Bowlby One SC','Brawler','Bree Serif','Bubblegum Sans','Bubbler One','Buda','Buenard','Butcherman','Butterfly Kids','Cabin','Cabin Condensed','Cabin Sketch','Caesar Dressing','Cagliostro','Calligraffitti','Cambay','Cambo','Candal','Cantarell','Cantata One','Cantora One','Capriola','Cardo','Carme','Carrois Gothic','Carrois Gothic SC','Carter One','Caudex','Cedarville Cursive','Ceviche One','Changa One','Chango','Chau Philomene One','Chela One','Chelsea Market','Chenla','Cherry Cream Soda','Cherry Swash','Chewy','Chicle','Chivo','Cinzel','Cinzel Decorative','Clicker Script','Coda','Coda Caption','Codystar','Combo','Comfortaa','Coming Soon','Concert One','Condiment','Content','Contrail One','Convergence','Cookie','Copse','Corben','Courgette','Cousine','Coustard','Covered By Your Grace','Crafty Girls','Creepster','Crete Round','Crimson Text','Croissant One','Crushed','Cuprum','Cutive','Cutive Mono','Damion','Dancing Script','Dangrek','Dawning of a New Day','Days One','Dekko','Delius','Delius Swash Caps','Delius Unicase','Della Respira','Denk One','Devonshire','Dhurjati','Didact Gothic','Diplomata','Diplomata SC','Domine','Donegal One','Doppio One','Dorsa','Dosis','Dr Sugiyama','Droid Sans','Droid Sans Mono','Droid Serif','Duru Sans','Dynalight','EB Garamond','Eagle Lake','Eater','Economica','Eczar','Ek Mukta','Electrolize','Elsie','Elsie Swash Caps','Emblema One','Emilys Candy','Engagement','Englebert','Enriqueta','Erica One','Esteban','Euphoria Script','Ewert','Exo','Exo 2','Expletus Sans','Fanwood Text','Fascinate','Fascinate Inline','Faster One','Fasthand','Fauna One','Federant','Federo','Felipa','Fenix','Finger Paint','Fira Mono','Fira Sans','Fjalla One','Fjord One','Flamenco','Flavors','Fondamento','Fontdiner Swanky','Forum','Francois One','Freckle Face','Fredericka the Great','Fredoka One','Freehand','Fresca','Frijole','Fruktur','Fugaz One','GFS Didot','GFS Neohellenic','Gabriela','Gafata','Galdeano','Galindo','Gentium Basic','Gentium Book Basic','Geo','Geostar','Geostar Fill','Germania One','Gidugu','Gilda Display','Give You Glory','Glass Antiqua','Glegoo','Gloria Hallelujah','Goblin One','Gochi Hand','Gorditas','Goudy Bookletter 1911','Graduate','Grand Hotel','Gravitas One','Great Vibes','Griffy','Gruppo','Gudea','Gurajada','Habibi','Halant','Hammersmith One','Hanalei','Hanalei Fill','Handlee','Hanuman','Happy Monkey','Headland One','Henny Penny','Herr Von Muellerhoff','Hind','Holtwood One SC','Homemade Apple','Homenaje','IM Fell DW Pica','IM Fell DW Pica SC','IM Fell Double Pica','IM Fell Double Pica SC','IM Fell English','IM Fell English SC','IM Fell French Canon','IM Fell French Canon SC','IM Fell Great Primer','IM Fell Great Primer SC','Iceberg','Iceland','Imprima','Inconsolata','Inder','Indie Flower','Inika','Inknut Antiqua','Irish Grover','Istok Web','Italiana','Italianno','Jacques Francois','Jacques Francois Shadow','Jaldi','Jim Nightshade','Jockey One','Jolly Lodger','Josefin Sans','Josefin Slab','Joti One','Judson','Julee','Julius Sans One','Junge','Jura','Just Another Hand','Just Me Again Down Here','Kadwa','Kalam','Kameron','Kantumruy','Karla','Karma','Kaushan Script','Kavoon','Kdam Thmor','Keania One','Kelly Slab','Kenia','Khand','Khmer','Khula','Kite One','Knewave','Kotta One','Koulen','Kranky','Kreon','Kristi','Krona One','Kurale','La Belle Aurore','Laila','Lakki Reddy','Lancelot','Lateef','Lato','League Script','Leckerli One','Ledger','Lekton','Lemon','Libre Baskerville','Life Savers','Lilita One','Lily Script One','Limelight','Linden Hill','Lobster','Lobster Two','Londrina Outline','Londrina Shadow','Londrina Sketch','Londrina Solid','Lora','Love Ya Like A Sister','Loved by the King','Lovers Quarrel','Luckiest Guy','Lusitana','Lustria','Macondo','Macondo Swash Caps','Magra','Maiden Orange','Mako','Mallanna','Mandali','Marcellus','Marcellus SC','Marck Script','Margarine','Marko One','Marmelad','Martel','Martel Sans','Marvel','Mate','Mate SC','Maven Pro','McLaren','Meddon','MedievalSharp','Medula One','Megrim','Meie Script','Merienda','Merienda One','Merriweather','Merriweather Sans','Metal','Metal Mania','Metamorphous','Metrophobic','Michroma','Milonga','Miltonian','Miltonian Tattoo','Miniver','Miss Fajardose','Modak','Modern Antiqua','Molengo','Molle','Monda','Monofett','Monoton','Monsieur La Doulaise','Montaga','Montez','Montserrat','Montserrat Alternates','Montserrat Subrayada','Moul','Moulpali','Mountains of Christmas','Mouse Memoirs','Mr Bedfort','Mr Dafoe','Mr De Haviland','Mrs Saint Delafield','Mrs Sheppards','Muli','Mystery Quest','NTR','Neucha','Neuton','New Rocker','News Cycle','Niconne','Nixie One','Nobile','Nokora','Norican','Nosifer','Nothing You Could Do','Noticia Text','Noto Sans','Noto Serif','Nova Cut','Nova Flat','Nova Mono','Nova Oval','Nova Round','Nova Script','Nova Slim','Nova Square','Numans','Nunito','Odor Mean Chey','Offside','Old Standard TT','Oldenburg','Oleo Script','Oleo Script Swash Caps','Open Sans','Open Sans Condensed','Oranienbaum','Orbitron','Oregano','Orienta','Original Surfer','Oswald','Over the Rainbow','Overlock','Overlock SC','Ovo','Oxygen','Oxygen Mono','PT Mono','PT Sans','PT Sans Caption','PT Sans Narrow','PT Serif','PT Serif Caption','Pacifico','Palanquin','Palanquin Dark','Paprika','Parisienne','Passero One','Passion One','Pathway Gothic One','Patrick Hand','Patrick Hand SC','Patua One','Paytone One','Peddana','Peralta','Permanent Marker','Petit Formal Script','Petrona','Philosopher','Piedra','Pinyon Script','Pirata One','Plaster','Play','Playball','Playfair Display','Playfair Display SC','Podkova','Poiret One','Poller One','Poly','Pompiere','Pontano Sans','Poppins','Port Lligat Sans','Port Lligat Slab','Pragati Narrow','Prata','Preahvihear','Press Start 2P','Princess Sofia','Prociono','Prosto One','Puritan','Purple Purse','Quando','Quantico','Quattrocento','Quattrocento Sans','Questrial','Quicksand','Quintessential','Qwigley','Racing Sans One','Radley','Rajdhani','Raleway','Raleway Dots','Ramabhadra','Ramaraja','Rambla','Rammetto One','Ranchers','Rancho','Ranga','Rationale','Ravi Prakash','Redressed','Reenie Beanie','Revalia','Rhodium Libre','Ribeye','Ribeye Marrow','Righteous','Risque','Roboto','Roboto Condensed','Roboto Mono','Roboto Slab','Rochester','Rock Salt','Rokkitt','Romanesco','Ropa Sans','Rosario','Rosarivo','Rouge Script','Rozha One','Rubik','Rubik Mono One','Rubik One','Ruda','Rufina','Ruge Boogie','Ruluko','Rum Raisin','Ruslan Display','Russo One','Ruthie','Rye','Sacramento','Sahitya','Sail','Salsa','Sanchez','Sancreek','Sansita One','Sarala','Sarina','Sarpanch','Satisfy','Scada','Scheherazade','Schoolbell','Seaweed Script','Sevillana','Seymour One','Shadows Into Light','Shadows Into Light Two','Shanti','Share','Share Tech','Share Tech Mono','Shojumaru','Short Stack','Siemreap','Sigmar One','Signika','Signika Negative','Simonetta','Sintony','Sirin Stencil','Six Caps','Skranji','Slabo 13px','Slabo 27px','Slackey','Smokum','Smythe','Sniglet','Snippet','Snowburst One','Sofadi One','Sofia','Sonsie One','Sorts Mill Goudy','Source Code Pro','Source Sans Pro','Source Serif Pro','Special Elite','Spicy Rice','Spinnaker','Spirax','Squada One','Sree Krushnadevaraya','Stalemate','Stalinist One','Stardos Stencil','Stint Ultra Condensed','Stint Ultra Expanded','Stoke','Strait','Sue Ellen Francisco','Sumana','Sunshiney','Supermercado One','Sura','Suranna','Suravaram','Suwannaphum','Swanky and Moo Moo','Syncopate','Tangerine','Taprom','Tauri','Teko','Telex','Tenali Ramakrishna','Tenor Sans','Text Me One','The Girl Next Door','Tienne','Tillana','Timmana','Tinos','Titan One','Titillium Web','Trade Winds','Trocchi','Trochut','Trykker','Tulpen One','Ubuntu','Ubuntu Condensed','Ubuntu Mono','Ultra','Uncial Antiqua','Underdog','Unica One','UnifrakturCook','UnifrakturMaguntia','Unkempt','Unlock','Unna','VT323','Vampiro One','Varela','Varela Round','Vast Shadow','Vesper Libre','Vibur','Vidaloka','Viga','Voces','Volkhov','Vollkorn','Voltaire','Waiting for the Sunrise','Wallpoet','Walter Turncoat','Warnes','Wellfleet','Wendy One','Wire One','Work Sans','Yanone Kaffeesatz','Yantramanav','Yellowtail','Yeseva One','Yesteryear','Zeyada');
            $apmm_font_family = get_option('apmm_font_family');
            if (empty($apmm_font_family)) {
                update_option('apmm_font_family', $family);
            }

           AP_Menu_Settings::wpmm_menu_item_defaults();
            /*
            * Available Skin Themes
            */
             $available_skin = array(
              '0' => 
             array('title' => 'Black & White',
                     'id' => 'black-white' ,
                     'color' => '#000000',
                  ), 
              '1' => 
             array('title' => 'Gold Yellowish With Black',
                     'id' => 'gold-yellow-black',
                      'color' => '#dace2e' 
                  ), 
              '2' => 
             array('title' => 'Hunter Shades & White',
                     'id' => 'hunter-shades-white',
                      'color' => '#CFA66F' 
                  ), 
              '3' => 
             array('title' => 'Maroon Reddish & Black',
                     'id' => 'maroon-reddish-black',
                      'color' => '#800000'
                  ), 
              '4' => 
             array('title' => 'Light Blue Sky & White',
                     'id' => 'light-blue-sky-white' ,
                      'color' => '#0AA2EE'
                  ), 
              '5' => 
             array('title' => 'Warm Purple & White',
                     'id' => 'warm-purple-white',
                     'color' => '#9768a8'
                  ), 
               '6' => 
             array('title' => 'SeaGreen & White',
                     'id' => 'sea-green-white',
                     'color' => '#2E8B57'
                  ), 
             '7' => 
             array('title' => 'Clean White',
                     'id' => 'clean-white',
                     'color' => '#fff'
                  ), 

             );
           $available_skin_themes = get_option('apmm_register_skin');
           if (empty($available_skin_themes)) {
            update_option('apmm_register_skin', $available_skin);
            }else{
               $count = count($available_skin_themes);
               if($count  == "7"){
                    update_option('apmm_register_skin', $available_skin);            
                }

            }
          
        }else{
              include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
               if (is_plugin_active('wp-mega-menu-pro/wp-mega-menu-pro.php')) {
                 wp_die( __( 'You need to deactivate WP Mega Menu Pro Plugin in order to activate AP Mega Menu Free plugin.Please deactivate premium one.', APMM_PRO_TD ) );
                // deactivate_plugins('wp-mega-menu/wp-mega-menu.php');
               }

             include('inc/backend/activation.php');
       	      /**
             * Load Default Settings
             * */
            if (!get_option('apmega_settings')) {
                $apmega_settings = $this->apmm_default_settings();
                update_option('apmega_settings', $apmega_settings);
            }

            /**
             * Google font save
             * */
            $family = array('ABeeZee','Abel','Abril Fatface','Aclonica','Acme','Actor','Adamina','Advent Pro','Aguafina Script','Akronim','Aladin','Aldrich','Alef','Alegreya','Alegreya SC','Alegreya Sans','Alegreya Sans SC','Alex Brush','Alfa Slab One','Alice','Alike','Alike Angular','Allan','Allerta','Allerta Stencil','Allura','Almendra','Almendra Display','Almendra SC','Amarante','Amaranth','Amatic SC','Amethysta','Amiri','Amita','Anaheim','Andada','Andika','Angkor','Annie Use Your Telescope','Anonymous Pro','Antic','Antic Didone','Antic Slab','Anton','Arapey','Arbutus','Arbutus Slab','Architects Daughter','Archivo Black','Archivo Narrow','Arimo','Arizonia','Armata','Artifika','Arvo','Arya','Asap','Asar','Asset','Astloch','Asul','Atomic Age','Aubrey','Audiowide','Autour One','Average','Average Sans','Averia Gruesa Libre','Averia Libre','Averia Sans Libre','Averia Serif Libre','Bad Script','Balthazar','Bangers','Basic','Battambang','Baumans','Bayon','Belgrano','Belleza','BenchNine','Bentham','Berkshire Swash','Bevan','Bigelow Rules','Bigshot One','Bilbo','Bilbo Swash Caps','Biryani','Bitter','Black Ops One','Bokor','Bonbon','Boogaloo','Bowlby One','Bowlby One SC','Brawler','Bree Serif','Bubblegum Sans','Bubbler One','Buda','Buenard','Butcherman','Butterfly Kids','Cabin','Cabin Condensed','Cabin Sketch','Caesar Dressing','Cagliostro','Calligraffitti','Cambay','Cambo','Candal','Cantarell','Cantata One','Cantora One','Capriola','Cardo','Carme','Carrois Gothic','Carrois Gothic SC','Carter One','Caudex','Cedarville Cursive','Ceviche One','Changa One','Chango','Chau Philomene One','Chela One','Chelsea Market','Chenla','Cherry Cream Soda','Cherry Swash','Chewy','Chicle','Chivo','Cinzel','Cinzel Decorative','Clicker Script','Coda','Coda Caption','Codystar','Combo','Comfortaa','Coming Soon','Concert One','Condiment','Content','Contrail One','Convergence','Cookie','Copse','Corben','Courgette','Cousine','Coustard','Covered By Your Grace','Crafty Girls','Creepster','Crete Round','Crimson Text','Croissant One','Crushed','Cuprum','Cutive','Cutive Mono','Damion','Dancing Script','Dangrek','Dawning of a New Day','Days One','Dekko','Delius','Delius Swash Caps','Delius Unicase','Della Respira','Denk One','Devonshire','Dhurjati','Didact Gothic','Diplomata','Diplomata SC','Domine','Donegal One','Doppio One','Dorsa','Dosis','Dr Sugiyama','Droid Sans','Droid Sans Mono','Droid Serif','Duru Sans','Dynalight','EB Garamond','Eagle Lake','Eater','Economica','Eczar','Ek Mukta','Electrolize','Elsie','Elsie Swash Caps','Emblema One','Emilys Candy','Engagement','Englebert','Enriqueta','Erica One','Esteban','Euphoria Script','Ewert','Exo','Exo 2','Expletus Sans','Fanwood Text','Fascinate','Fascinate Inline','Faster One','Fasthand','Fauna One','Federant','Federo','Felipa','Fenix','Finger Paint','Fira Mono','Fira Sans','Fjalla One','Fjord One','Flamenco','Flavors','Fondamento','Fontdiner Swanky','Forum','Francois One','Freckle Face','Fredericka the Great','Fredoka One','Freehand','Fresca','Frijole','Fruktur','Fugaz One','GFS Didot','GFS Neohellenic','Gabriela','Gafata','Galdeano','Galindo','Gentium Basic','Gentium Book Basic','Geo','Geostar','Geostar Fill','Germania One','Gidugu','Gilda Display','Give You Glory','Glass Antiqua','Glegoo','Gloria Hallelujah','Goblin One','Gochi Hand','Gorditas','Goudy Bookletter 1911','Graduate','Grand Hotel','Gravitas One','Great Vibes','Griffy','Gruppo','Gudea','Gurajada','Habibi','Halant','Hammersmith One','Hanalei','Hanalei Fill','Handlee','Hanuman','Happy Monkey','Headland One','Henny Penny','Herr Von Muellerhoff','Hind','Holtwood One SC','Homemade Apple','Homenaje','IM Fell DW Pica','IM Fell DW Pica SC','IM Fell Double Pica','IM Fell Double Pica SC','IM Fell English','IM Fell English SC','IM Fell French Canon','IM Fell French Canon SC','IM Fell Great Primer','IM Fell Great Primer SC','Iceberg','Iceland','Imprima','Inconsolata','Inder','Indie Flower','Inika','Inknut Antiqua','Irish Grover','Istok Web','Italiana','Italianno','Jacques Francois','Jacques Francois Shadow','Jaldi','Jim Nightshade','Jockey One','Jolly Lodger','Josefin Sans','Josefin Slab','Joti One','Judson','Julee','Julius Sans One','Junge','Jura','Just Another Hand','Just Me Again Down Here','Kadwa','Kalam','Kameron','Kantumruy','Karla','Karma','Kaushan Script','Kavoon','Kdam Thmor','Keania One','Kelly Slab','Kenia','Khand','Khmer','Khula','Kite One','Knewave','Kotta One','Koulen','Kranky','Kreon','Kristi','Krona One','Kurale','La Belle Aurore','Laila','Lakki Reddy','Lancelot','Lateef','Lato','League Script','Leckerli One','Ledger','Lekton','Lemon','Libre Baskerville','Life Savers','Lilita One','Lily Script One','Limelight','Linden Hill','Lobster','Lobster Two','Londrina Outline','Londrina Shadow','Londrina Sketch','Londrina Solid','Lora','Love Ya Like A Sister','Loved by the King','Lovers Quarrel','Luckiest Guy','Lusitana','Lustria','Macondo','Macondo Swash Caps','Magra','Maiden Orange','Mako','Mallanna','Mandali','Marcellus','Marcellus SC','Marck Script','Margarine','Marko One','Marmelad','Martel','Martel Sans','Marvel','Mate','Mate SC','Maven Pro','McLaren','Meddon','MedievalSharp','Medula One','Megrim','Meie Script','Merienda','Merienda One','Merriweather','Merriweather Sans','Metal','Metal Mania','Metamorphous','Metrophobic','Michroma','Milonga','Miltonian','Miltonian Tattoo','Miniver','Miss Fajardose','Modak','Modern Antiqua','Molengo','Molle','Monda','Monofett','Monoton','Monsieur La Doulaise','Montaga','Montez','Montserrat','Montserrat Alternates','Montserrat Subrayada','Moul','Moulpali','Mountains of Christmas','Mouse Memoirs','Mr Bedfort','Mr Dafoe','Mr De Haviland','Mrs Saint Delafield','Mrs Sheppards','Muli','Mystery Quest','NTR','Neucha','Neuton','New Rocker','News Cycle','Niconne','Nixie One','Nobile','Nokora','Norican','Nosifer','Nothing You Could Do','Noticia Text','Noto Sans','Noto Serif','Nova Cut','Nova Flat','Nova Mono','Nova Oval','Nova Round','Nova Script','Nova Slim','Nova Square','Numans','Nunito','Odor Mean Chey','Offside','Old Standard TT','Oldenburg','Oleo Script','Oleo Script Swash Caps','Open Sans','Open Sans Condensed','Oranienbaum','Orbitron','Oregano','Orienta','Original Surfer','Oswald','Over the Rainbow','Overlock','Overlock SC','Ovo','Oxygen','Oxygen Mono','PT Mono','PT Sans','PT Sans Caption','PT Sans Narrow','PT Serif','PT Serif Caption','Pacifico','Palanquin','Palanquin Dark','Paprika','Parisienne','Passero One','Passion One','Pathway Gothic One','Patrick Hand','Patrick Hand SC','Patua One','Paytone One','Peddana','Peralta','Permanent Marker','Petit Formal Script','Petrona','Philosopher','Piedra','Pinyon Script','Pirata One','Plaster','Play','Playball','Playfair Display','Playfair Display SC','Podkova','Poiret One','Poller One','Poly','Pompiere','Pontano Sans','Poppins','Port Lligat Sans','Port Lligat Slab','Pragati Narrow','Prata','Preahvihear','Press Start 2P','Princess Sofia','Prociono','Prosto One','Puritan','Purple Purse','Quando','Quantico','Quattrocento','Quattrocento Sans','Questrial','Quicksand','Quintessential','Qwigley','Racing Sans One','Radley','Rajdhani','Raleway','Raleway Dots','Ramabhadra','Ramaraja','Rambla','Rammetto One','Ranchers','Rancho','Ranga','Rationale','Ravi Prakash','Redressed','Reenie Beanie','Revalia','Rhodium Libre','Ribeye','Ribeye Marrow','Righteous','Risque','Roboto','Roboto Condensed','Roboto Mono','Roboto Slab','Rochester','Rock Salt','Rokkitt','Romanesco','Ropa Sans','Rosario','Rosarivo','Rouge Script','Rozha One','Rubik','Rubik Mono One','Rubik One','Ruda','Rufina','Ruge Boogie','Ruluko','Rum Raisin','Ruslan Display','Russo One','Ruthie','Rye','Sacramento','Sahitya','Sail','Salsa','Sanchez','Sancreek','Sansita One','Sarala','Sarina','Sarpanch','Satisfy','Scada','Scheherazade','Schoolbell','Seaweed Script','Sevillana','Seymour One','Shadows Into Light','Shadows Into Light Two','Shanti','Share','Share Tech','Share Tech Mono','Shojumaru','Short Stack','Siemreap','Sigmar One','Signika','Signika Negative','Simonetta','Sintony','Sirin Stencil','Six Caps','Skranji','Slabo 13px','Slabo 27px','Slackey','Smokum','Smythe','Sniglet','Snippet','Snowburst One','Sofadi One','Sofia','Sonsie One','Sorts Mill Goudy','Source Code Pro','Source Sans Pro','Source Serif Pro','Special Elite','Spicy Rice','Spinnaker','Spirax','Squada One','Sree Krushnadevaraya','Stalemate','Stalinist One','Stardos Stencil','Stint Ultra Condensed','Stint Ultra Expanded','Stoke','Strait','Sue Ellen Francisco','Sumana','Sunshiney','Supermercado One','Sura','Suranna','Suravaram','Suwannaphum','Swanky and Moo Moo','Syncopate','Tangerine','Taprom','Tauri','Teko','Telex','Tenali Ramakrishna','Tenor Sans','Text Me One','The Girl Next Door','Tienne','Tillana','Timmana','Tinos','Titan One','Titillium Web','Trade Winds','Trocchi','Trochut','Trykker','Tulpen One','Ubuntu','Ubuntu Condensed','Ubuntu Mono','Ultra','Uncial Antiqua','Underdog','Unica One','UnifrakturCook','UnifrakturMaguntia','Unkempt','Unlock','Unna','VT323','Vampiro One','Varela','Varela Round','Vast Shadow','Vesper Libre','Vibur','Vidaloka','Viga','Voces','Volkhov','Vollkorn','Voltaire','Waiting for the Sunrise','Wallpoet','Walter Turncoat','Warnes','Wellfleet','Wendy One','Wire One','Work Sans','Yanone Kaffeesatz','Yantramanav','Yellowtail','Yeseva One','Yesteryear','Zeyada');
            $apmm_font_family = get_option('apmm_font_family');
            if (empty($apmm_font_family)) {
                update_option('apmm_font_family', $family);
            }

           AP_Menu_Settings::wpmm_menu_item_defaults();
            /*
            * Available Skin Themes
            */
             $available_skin = array(
              '0' => 
             array('title' => 'Black & White',
                     'id' => 'black-white' ,
                     'color' => '#000000',
                  ), 
              '1' => 
             array('title' => 'Gold Yellowish With Black',
                     'id' => 'gold-yellow-black',
                      'color' => '#dace2e' 
                  ), 
              '2' => 
             array('title' => 'Hunter Shades & White',
                     'id' => 'hunter-shades-white',
                      'color' => '#CFA66F' 
                  ), 
              '3' => 
             array('title' => 'Maroon Reddish & Black',
                     'id' => 'maroon-reddish-black',
                      'color' => '#800000'
                  ), 
              '4' => 
             array('title' => 'Light Blue Sky & White',
                     'id' => 'light-blue-sky-white' ,
                      'color' => '#0AA2EE'
                  ), 
              '5' => 
             array('title' => 'Warm Purple & White',
                     'id' => 'warm-purple-white',
                     'color' => '#9768a8'
                  ), 
               '6' => 
             array('title' => 'SeaGreen & White',
                     'id' => 'sea-green-white',
                     'color' => '#2E8B57'
                  ), 
             '7' => 
             array('title' => 'Clean White',
                     'id' => 'clean-white',
                     'color' => '#fff'
                  ), 

             );
           $available_skin_themes = get_option('apmm_register_skin');
           if (empty($available_skin_themes)) {
            update_option('apmm_register_skin', $available_skin);
            }else{
               $count = count($available_skin_themes);
               if($count  == "7"){
                    update_option('apmm_register_skin', $available_skin);            
                }

            }
          
        }
             
       }

	      /**
        * Returns Default Settings
       */
       public static function apmm_default_settings() {
            $apmega_settings = array(
                                'advanced_click'=>'click_submenu',
                                'mlabel_animation_type'=>'none',
                                'animation_delay'=>'2s',
                                'animation_duration'=>'3s',
                                'animation_iteration_count'=>'1',
                                'enable_mobile'=>'1',
                                'disable_submenu_retractor' => 0,
                                'mobile_toggle_option'=> 'toggle_standard',
                                'image_size' => 'thumbnail',
                                'hide_icons'     => 0,
                                'custom_width'   => '',
                                'close_menu_icon' => 'dashicons dashicons-menu',
                                'open_menu_icon'  => 'dashicons dashicons-no',
                                'icon_width' => '13px'
            );
            return $apmega_settings;
        }

      /*
      * Enqueue Backend Scripts
      */
        function wp_admin_enqueue_scripts($hooks){
            if ( 'nav-menus.php' == $hooks ) {
                        do_action("wp_megamenu_nav_menus_scripts", $hooks );
                    }

        }



    
    /**
     * Use the WP Mega Menu walker to output the menu
     * Resets all parameters used in the wp_nav_menu call
     * Wraps the menu in wp-mega-menu IDs and classes
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_navmenuargs( $args ) {

        $settings = get_option( 'wpmegabox_settings' ); //get all plugin metabox data 
        // echo "<pre>";
        // print_r($settings);
        // exit();
        $current_theme_location = $args['theme_location']; // get current menu location i.e primary
        $locations = get_nav_menu_locations(); // get all menu location
        
        /*
        * Check if wp mega menu is enabled or not for specific menu location
        */
        if ( isset ( $settings[ $current_theme_location ]['enabled'] ) && $settings[ $current_theme_location ]['enabled'] == 1 ) {

            if ( ! isset( $locations[ $current_theme_location ] ) ) {
                return $args;
            }

            $menu_id = $locations[ $current_theme_location ];

            if ( ! $menu_id ) {
                return $args;
            }

            if ( ! $current_theme_location ) {
             return false;
              }

              if ( ! has_nav_menu( $current_theme_location ) ) {
                  return false;
              }


              $themes_style_manager = new AP_Theme_Settings();
              $retractor_default_text = __('CLOSE',APMM_TD);

              //$themes = $themes_style_manager->get_custom_theme_data(''); // get all custom themes
              if(isset($settings[ $current_theme_location ]['theme_type'] ) && $settings[ $current_theme_location ]['theme_type'] == "custom_themes" ){
                        $theme = $settings[ $current_theme_location ]['theme']; 
                        $menu_theme = $themes_style_manager->get_custom_theme_rowdata($theme);
                        $theme_title = 'wpmega-'.$menu_theme->slug;
                        $theme_settings = unserialize($menu_theme->theme_settings);
                       
                        $resposive_breakpoint_width = (isset($theme_settings['mobile_settings']['resposive_breakpoint_width']) && $theme_settings['mobile_settings']['resposive_breakpoint_width'] != '')?$theme_settings['mobile_settings']['resposive_breakpoint_width']:''; 
                        $responsive_submenus_retractor =  (isset($theme_settings['mobile_settings']['submenu_closebtn_position']) && $theme_settings['mobile_settings']['submenu_closebtn_position'] == 'top')?'wpmm-top-retractor':'wpmm-bottom-retractor'; 
                        $submenus_retractor_text =  (isset($theme_settings['mobile_settings']['submenus_retractor_text']) && $theme_settings['mobile_settings']['submenus_retractor_text'] != '')?$theme_settings['mobile_settings']['submenus_retractor_text']:$retractor_default_text; 
                       
                        $skin_type = "wpmm-custom-theme"; 
                        $skin_type1 = "wpmm-ctheme-wrapper"; 
                        $arrow_type = (isset($theme_settings['mobile_settings']['submenus_retractor_text']) && $theme_settings['mobile_settings']['submenus_retractor_text'] != '')?$theme_settings['mobile_settings']['submenus_retractor_text']:$retractor_default_text; 
                       
                  }else{
                        $theme = $settings[ $current_theme_location ]['available_skin'];
                        $menu_theme = isset( $theme ) ? 'wpmega-'.$theme : 'wpmega-black-white';

                        
                        $resposive_breakpoint_width = "680"; 
                        $responsive_submenus_retractor = "wpmm-bottom-retractor";
                        $submenus_retractor_text = $retractor_default_text;
                       
                        $skin_type = "wpmm-pre-available-skins"; 
                        $skin_type1 = "wpmm-askins-wrapper"; 
                        $theme_title = 'wpmega-'.$theme;
                        $arrow_type = "";
                  }
// exit();
          $apmega_general_settings = get_option('apmega_settings');
 
          if(isset($apmega_general_settings['disable_submenu_retractor']) && $apmega_general_settings['disable_submenu_retractor'] ==1){
             $retractor = '';
             $retractor_txt = '';
          }else{
              $retractor = $responsive_submenus_retractor;
              $retractor_txt = $submenus_retractor_text;
          }
        
          if(isset($apmega_general_settings['enable_mobile']) && $apmega_general_settings['enable_mobile'] != 1){
            $addClass = "wpmega-disable-mobile-menu";
          }else{
             $addClass = "wpmega-enabled-mobile-menu";
          }

            $orientation   = $settings[ $current_theme_location ]['orientation'];      
            $menu_settings = $settings[ $current_theme_location ]; /* Get data of specific menu location*/  
            $trigger_option = isset( $menu_settings['trigger_option']) ? 'wpmm-'.$menu_settings['trigger_option'] : 'wpmm-onhover';  //trigger option:hover_indent/onhover/onclick

            $wpmm_common_attributes = apply_filters("wpmegamenu_common_attributes", array(
                "id" => '%1$s',    
                "class" => 'wpmm-mega-wrapper',
                "data-advanced-click" => isset( $settings['advanced_click'] ) ? $settings['advanced_click'] : 'wpmm-click-submenu',   
                "data-trigger-effect" =>  $trigger_option,   
            ), $menu_id, $menu_settings, $settings, $current_theme_location );

              $attributes = "";

               foreach( $wpmm_common_attributes as $attribute => $value ) {
                if ( strlen( $value ) ) {
                   // $attributes .= " ". esc_attr( $value );
                  $attributes .= " " . $attribute . '="' . esc_attr( $value ) . '"';
                }
               }

            $sanitized_location = str_replace( apply_filters("wpmegamenu_arg_replacements", array("-", " ") ), "-", $current_theme_location );
            $orientation = $menu_settings['orientation'];

            /* Integrate dynamic Stylesheet for menu */
              if($skin_type =="wpmm-custom-theme"){
               $this->get_custom_designs($current_theme_location,$settings);
              }
            /* End */


            /* Metabox options as per menu location here */
           
            if($orientation == "vertical"){
              $vertical_alignment_type   = (isset( $menu_settings['vertical_alignment_type'] ) && $menu_settings['vertical_alignment_type'] != "") ? 'wpmm-vertical-'.$menu_settings['vertical_alignment_type'].'-align' : 'wpmm-vertical-left-align';
            }else{
              $vertical_alignment_type = '';
            }
            $orientation    = "wpmm-orientation-".$orientation;
            $effectoption   = isset( $menu_settings['effect_option'] ) ? 'wpmm-'.$menu_settings['effect_option'] : 'wpmm-fade';
           
            /* END */

            /* other general common options */
            $hideallmenuicons = (isset( $settings['hide_icons'] ) && $settings['hide_icons'] == "1") ? 'hide-icons-true' : '';
            $mobile_toggle_option = (isset($apmega_general_settings['mobile_toggle_option']) && $apmega_general_settings['mobile_toggle_option'] == "toggle_standard") ? 'wpmm-toggle-standard' : 'wpmm-toggle-accordion';
            /* END */

            $dynamicclass = $skin_type1.' '.$theme_title.' '.$addClass.' '.$mobile_toggle_option.' '.$trigger_option.' '.$orientation.' '.$vertical_alignment_type.' '.$effectoption;
         if($retractor != ''){ 
          if($retractor  == "wpmm-bottom-retractor"){
            $defaults = array(
                'menu'            => $menu_id,
                'container'       => 'div',
                'container_class' => 'wp-megamenu-main-wrapper '.$dynamicclass,
                'container_id'    => 'wpmm-wrap-' .$current_theme_location,
                'menu_class'      => 'wpmegamenu',
                'menu_id'         => 'wpmega-menu-' . $sanitized_location,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul' . $attributes . '>%3$s</ul><div class="wpmega-responsive-closebtn" id="close-'.$current_theme_location.'">'.$submenus_retractor_text.'</div>', 
                'depth'           => 0,
                'walker'          => new WPMegamenuWalker_Class()
            );

          }else{
            /* Top retractor */
            $defaults = array(
                'menu'            => $menu_id,
                'container'       => 'div',
                'container_class' => 'wp-megamenu-main-wrapper '.$dynamicclass,
                'container_id'    => 'wpmm-wrap-' .$current_theme_location,
                'menu_class'      => 'wpmegamenu',
                'menu_id'         => 'wpmega-menu-' . $sanitized_location,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      =>  '<div class="wpmega-responsive-closebtn" id="close-'.$current_theme_location.'">'.$submenus_retractor_text.'</div><ul' . $attributes . '>%3$s</ul>', 
                'depth'           => 0,
                'walker'          => new WPMegamenuWalker_Class()
            );

          }
         }else{
          //noretractor
           $defaults = array(
                'menu'            => $menu_id,
                'container'       => 'div',
                'container_class' => 'wp-megamenu-main-wrapper '.$dynamicclass,
                'container_id'    => 'wpmm-wrap-' .$current_theme_location,
                'menu_class'      => 'wpmegamenu',
                'menu_id'         => 'wpmega-menu-' . $sanitized_location,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      =>  '<ul' . $attributes . '>%3$s</ul>', 
                'depth'           => 0,
                'walker'          => new WPMegamenuWalker_Class()
            );

         }   


          $args = array_merge( $args, apply_filters( "wpmegamenu_menu_args", $defaults, $menu_id, $current_theme_location ) );
        }

        return $args;
    }    

     /**
     * Append the widget objects to the menu array before the
     * menu is processed by the walker.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_addwidgetsmegamenu( $items, $args ) {
     

        // make sure we're working with a Mega Menu
        if ( ! is_a( $args->walker, 'WPMegamenuWalker_Class' ) ) {
            return $items;
        }

        $items = apply_filters( "wpmegamenu_navmenu_before_setup", $items, $args );
     
       // echo "<pre>";
       //      print_r( $items);
       //      exit();
        $mywidget_manager = new WPMM_Menu_Widget_Manager();

        foreach ( $items as $item ) {
          //echo $item->wpmegamenu_settings['menu_type']; megamenu or flyout

            // only look for widgets on top level items
            if ( $item->depth === 0 && $item->wpmegamenu_settings['menu_type'] == 'megamenu' ) {
                $mypanelwidgets = $mywidget_manager->wpmm_getwidgets_menuid( $item->ID, $args->menu );
           
                if ( count( $mypanelwidgets ) ) {

                    $wdposition = 0;
                    $nxtorder = $this->wpmm_getnextmenuorder( $item->ID, $items);
                    $totalwidgetsinwpmenu = count( $mypanelwidgets );
                    // echo "<pre>";
                    // print_r($mypanelwidgets);
                    // die();

                    if ( ! in_array( 'menu-item-has-children', $item->classes ) ) {
                        $item->classes[] = 'menu-item-has-children';
                    }


                    foreach ( $mypanelwidgets as $mywidget ) {
                        $getallwidgetsettings = array_merge( get_post_meta( $item->ID, '_wpmegamenu', true), array(
                            'wpmm_mega_menu_columns' => absint( $mywidget['columns'] )
                        ) );
                        $wpmmmenuitem = array(
                            'type'                      => 'widget',
                            'in_wpmegamenu'             => true,
                            'title'                     => $mywidget['id'],
                            'content'                   => $mywidget_manager->wpmmshowwidget( $mywidget['id'] ),
                            'menu_item_parent'          => $item->ID,
                            'db_id'                     => 0, // This menu item does not have any childen
                            'ID'                        => $mywidget['id'],
                            'wp_menu_order'             => $nxtorder - $totalwidgetsinwpmenu + $wdposition,
                            'wpmegamenu_order'          => $mywidget['order'],
                            'wpmegamenu_settings'       => $getallwidgetsettings,
                            'depth'                     => 1,
                            'classes'                   => array(
                                "menu-item",
                                "menu-item-type-widget",
                                "menu-widget-class-" . $mywidget_manager->wpmm_getwidget( $mywidget['id'] ),
                                $mywidget_manager->wpmm_getwidget( $mywidget['id'] )
                            )
                        );

                        $items[] = (object) $wpmmmenuitem;

                        $wdposition++;
                    }
                }
            }
        }

        $items = apply_filters( "wpmm_navmenuafterobj", $items, $args );

        return $items;
    }



     /**
     * Setup and array for each menu item from wp mega menu settings
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmmsetupmenuitems( $items, $args ) {
        // apply depth
        $parray = array();
        foreach ( $items as $key => $value ) {
            if ( $value->menu_item_parent == 0 ) { // check menu parent id 0 if toplevel menu or not
                $parray[] = $value->ID;
                $value->depth = 0;
            }
        }
        if ( count( $parray ) ) {
            foreach ( $items as $key => $item ) {
                if ( in_array( $item->menu_item_parent, $parray ) ) {
                    $item->depth = 1;
                }
            }
        }

  
        // apply saved metadata to each menu item
        foreach ( $items as $item ) {
            $saved_settings = array_filter( (array) get_post_meta( $item->ID, '_wpmegamenu', true ) );
            $item->wpmegamenu_settings = array_merge( AP_Menu_Settings::wpmm_menu_item_defaults(), $saved_settings );
            $item->wpmegamenu_order = isset( $item->wpmegamenu_settings['wp_menu_order'][$item->menu_item_parent] ) ? $item->wpmegamenu_settings['wp_menu_order'][$item->menu_item_parent] : 0;
            $item->in_wpmegamenu = false;
            $item->wpmenu_order = $item->menu_order * 1000;
            // add in_wpmegamenu
            if ( $item->depth == 1 ) {

                $parent_settings = array_filter( (array) get_post_meta( $item->menu_item_parent, '_wpmegamenu', true ) );

                if ( isset( $parent_settings['menu_type'] ) && $parent_settings['menu_type'] == 'megamenu' ) {

                    $item->in_wpmegamenu = true;

                }

            }

        }

        return $items;
    }

    /**
      * This returns the menu order of the next top level menu item.
      * Derived From: Max Mega Menu
      * https://www.maxmegamenu.com
     */
    private function wpmm_getnextmenuorder( $item_id, $items ) {
   
        $get_next_parent = false;

        foreach ( $items as $key => $item ) {

            if ( $item->menu_item_parent != 0 ) {
                continue;
            }

            if ( $item->type == 'widget' ) {
                continue;
            }

            if ( $get_next_parent ) {
                return $item->menu_order;
            }

            if ( $item->ID == $item_id ) {
                $get_next_parent = true;
            }

            $last_menu_order = $item->menu_order;
        }

        // there isn't a next top level menu item
        return $last_menu_order + 1000;

    }

     /**
     * Reorder items within the wp mega menu.
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_reordermenuitems( $items, $args ) {
        $new_items = array();
        foreach ( $items as $item ) {
           if ( $item->in_wpmegamenu && isset( $item->wpmegamenu_order ) && $item->wpmegamenu_order !== 0 ) {
                $parent_post = get_post( $item->menu_item_parent );
                $item->menu_order = $parent_post->menu_order * 1000 + $item->wpmegamenu_order;
            }
        }
        foreach ( $items as $item ) {
            $new_items[ $item->menu_order ] = $item;
        }
        ksort( $new_items );

        return $new_items;

    }


    /**
     * Apply column and clear classes to menu items (inc. widgets)
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_setclassesmenuitems( $items, $args ) {

        $parents = array();

       $current_theme_location = $args->theme_location; // get current menu location i.e primary
       $settings = get_option( 'apmega_settings' );

       $settings = get_option( 'wpmegabox_settings' ); //get all plugin metabox data
       $orientation = isset($settings[$current_theme_location]['orientation'])?$settings[$current_theme_location]['orientation']:'horizontal';
        foreach ( $items as $item ) {

          if($item->depth == 1){
            $item->classes[] = 'wp-mega-menu-header';
          }
       

            if ( $item->depth === 0 ) {
                //$item->classes[] = 'wpmega-submenu-align-' . $item->wpmegamenu_settings['general_settings']['submenu_align'];
               if (isset($item->wpmegamenu_settings['mega_menu_settings']['choose_menu_type']) && $item->wpmegamenu_settings['mega_menu_settings']['choose_menu_type'] != 'search_type') {
                  if(isset( $item->wpmegamenu_settings['menu_type'])){
                  $item->classes[] = 'wpmega-menu-' . $item->wpmegamenu_settings['menu_type'];
                  }else{
                    $item->classes[] = 'wpmega-menu-flyout';
                 }
              }
            }

        
            if (isset($item->wpmegamenu_settings['general_settings']['hide_arrow']) && $item->wpmegamenu_settings['general_settings']['hide_arrow'] == 'true' ) {
                $item->classes[] = 'wpmega-hide-arrow';
            }else{
                $item->classes[] = 'wpmega-show-arrow';
            }
            

            if (isset($item->wpmegamenu_settings['general_settings']['visible_hidden_menu']) && $item->wpmegamenu_settings['general_settings']['visible_hidden_menu'] == 'true' ) {
                $item->classes[] = 'wpmega-visible-hide-menu';
            }

            if (isset($item->wpmegamenu_settings['general_settings']['active_single_menu']) && $item->wpmegamenu_settings['general_settings']['active_single_menu'] == 'enabled' ) {
                $item->classes[] = 'wpmega-enable-single-menu';
            }

             if ( $item->depth  > 0 ) {
              if(isset($item->wpmegamenu_settings['general_settings']['submenu_align'])) {
                  $item->classes[] = 'wpmm-submenu-align-' . $item->wpmegamenu_settings['general_settings']['submenu_align'];
              }else{
                 $item->classes[] = '';
              }
             }


            if(isset($item->wpmegamenu_settings['general_settings']['menu_align']) && $item->depth == 0) {
                $item->classes[] = 'wpmm-menu-align-' . $item->wpmegamenu_settings['general_settings']['menu_align'];
            }else{
               $item->classes[] = 'wpmm-menu-align-left';
            }
       
            if (isset($item->wpmegamenu_settings['general_settings']['menu_icon']) && $item->wpmegamenu_settings['general_settings']['menu_icon'] == "enabled") {
              //show menu icon
                $item->classes[] = 'wpmega-show-menu-icon';
            }else{
              $item->classes[] = 'wpmega-hide-menu-icon';
            }

            if (isset($item->wpmegamenu_settings['general_settings']['hide_on_desktop']) && $item->wpmegamenu_settings['general_settings']['hide_on_desktop'] == 'true' ) {
                $item->classes[] = 'wpmega-hide-on-desktop';
            }

            if (isset($item->wpmegamenu_settings['general_settings']['hide_on_mobile']) && $item->wpmegamenu_settings['general_settings']['hide_on_mobile'] == 'true' ) {
                $item->classes[] = 'wpmega-hide-on-mobile';
            }


            if($item->depth === 0){
                    if($orientation == "horizontal"){
                      if(isset($item->wpmegamenu_settings['menu_type']) && $item->wpmegamenu_settings['menu_type'] == "megamenu"){
                        //megamenu
                            if ( isset($item->wpmegamenu_settings['mega_menu_settings']['horizontal-menu-position'])) {
                                  $item->classes[] = 'wpmega-horizontal-'.$item->wpmegamenu_settings['mega_menu_settings']['horizontal-menu-position'];
                              }else{
                                  $item->classes[] = 'wpmega-horizontal-full-width';
                              }
                          }else{
                          //flyout
                          if ( $item->depth === 0 ) {
                           if ( isset($item->wpmegamenu_settings['flyout_settings']['flyout-position'])) {
                                $item->classes[] = 'wpmega-flyout-horizontal-'.$item->wpmegamenu_settings['flyout_settings']['flyout-position'];
                            }else{
                                  $item->classes[] = 'wpmega-flyout-horizontal-left';
                              }
                            }

                          }
                    
                    }else{
                      //vertical
                       if(isset($item->wpmegamenu_settings['menu_type']) && $item->wpmegamenu_settings['menu_type'] == "megamenu"){
                        //megamenu
                         if ( isset($item->wpmegamenu_settings['mega_menu_settings']['vertical-menu-position'])) {
                                  $item->classes[] = 'wpmega-vertical-'.$item->wpmegamenu_settings['mega_menu_settings']['vertical-menu-position'];
                              }else{
                                 $item->classes[] = 'wpmega-vertical-full-height';
                              }


                       }else{
                        //flyout
                        if ( $item->depth === 0 ) {
                           if ( isset($item->wpmegamenu_settings['flyout_settings']['vertical-position'])) {
                                $item->classes[] = 'wpmega-flyout-vertical-'.$item->wpmegamenu_settings['flyout_settings']['vertical-position'];
                            }else{
                                 $item->classes[] = 'wpmega-flyout-vertical-full-height';
                              }
                            }

                       }


                    }

                    /* menu replacement class */
                     if (isset($item->wpmegamenu_settings['mega_menu_settings']['choose_menu_type']) && $item->wpmegamenu_settings['mega_menu_settings']['choose_menu_type'] == 'search_type') {
                        $item->classes[] = 'wpmega-custom-content wpmm-search-type';
                     }
                     /* menu replacement class end*/
             }


          if(isset($item->wpmegamenu_settings['general_settings']['show_menu_to_users'])){
              $menu_users_check = $item->wpmegamenu_settings['general_settings']['show_menu_to_users']; //always/loggedin users or logged oout users
              if($menu_users_check != "always"){
                if($menu_users_check == "onlyloggedin_users"){
                  if ( !is_user_logged_in() ) { 
                    $item->classes[] = "wpmm-hide-menu-ltusers";
                  }
                }else if($menu_users_check == "onlyloggedout_users"){
                  if ( is_user_logged_in() ) { 
                   $item->classes[] = "wpmm-hide-menu-ltusers";
                  }

                }

              }
            }

            // add column classes for second level menu items displayed in mega menus
            if ( $item->in_wpmegamenu === true ) {

                $parent_settings = array_filter( (array) get_post_meta( $item->menu_item_parent, '_wpmegamenu', true ) );
                $parent_settings = array_merge( AP_Menu_Settings::wpmm_menu_item_defaults(), $parent_settings );

                $span = (isset($item->wpmegamenu_settings['wpmm_mega_menu_columns']) && $item->wpmegamenu_settings['wpmm_mega_menu_columns'] != '')?$item->wpmegamenu_settings['wpmm_mega_menu_columns']:'1';
                $total_columns = $parent_settings['panel_columns'];
        

                if ( $total_columns >= $span ) {
                    $item->classes[] = "wpmega-{$span}columns-{$total_columns}total";
                    $column_count = $span;
                } else {
                    $item->classes[] = "wpmega-{$total_columns}columns-{$total_columns}total";
                    $column_count = $total_columns;
                }

                if ( ! isset( $parents[ $item->menu_item_parent ] ) ) {
                    $parents[ $item->menu_item_parent ] = $column_count;
                } else {
                    $parents[ $item->menu_item_parent ] = $parents[ $item->menu_item_parent ] + $column_count;

                    if ( $parents[ $item->menu_item_parent ] > $total_columns ) {
                        $parents[ $item->menu_item_parent ] = $column_count;
                        $item->classes[] = 'wpmmclear';
                    }
                }

            }

        }

        return $items;
    }


   public function get_custom_designs($current_theme_location,$settings){
          //ob_start();
          include(APMM_PATH.'/inc/frontend/custom_theme_css.php');
         // $custom_style_css = ob_get_contents();
         // ob_clean();
         // return $custom_style_css;
    }


   
    /**
    * Add Search icon with form Using Shortcode
    * [wp_megamenu_search_form template_type="inline-search" style="inline-toggle-left"] or 
    * [wp_megamenu_search_form template_type="inline-search" style="inline-toggle-right"]
    * [wp_megamenu_search_form template_type="popup-search-form"] //pro 
    * [wp_megamenu_search_form template_type="megamenu-type-search"]
    **/
    function wpmm_generate_search_shortcode($atts,$content = null){
         extract(shortcode_atts(array('template_type' => '','stype'=>''), $atts));

              ob_start();
              include( 'inc/backend/wpmm_search_shortcode.php' );
              $html = ob_get_contents();
              ob_get_clean();
              return $html;

    }



    function wpmm_mega_register_widget(){
         register_widget( 'WP_Mega_Menu_Widget' );
         register_widget( 'WP_Mega_Menu_Contact_Info' );
    } 


    

     /**
     * Add responsive toggle box to the menu
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     *
     */
    public function wpmm_mobiletoggle( $nav_menu, $args ) {
        // make sure we're working with a WP Mega Menu walker class
      // echo "<pre>";
      // print_r($args);
      // exit();
        if ( ! is_a( $args->walker, 'WPMegamenuWalker_Class' ) )
            return $nav_menu;

          $dynamicclass = 'class="' . $args->container_class . '">';

           $current_theme_location = $args->theme_location;
          
           if ( ! $current_theme_location ) {
                return false;
            }

            if ( ! has_nav_menu( $current_theme_location ) ) {
                return false;
            }
              $themes_style_manager = new AP_Theme_Settings();
              $themes = $themes_style_manager->get_custom_theme_data(''); // get all custom themes
        
             // if a current_theme_location has been passed, check to see if MMM has been enabled for the current_theme_location
             $settings = get_option( 'wpmegabox_settings' ); //get all plugin metabox data from nav menu location
           

            if ( is_array( $settings ) && isset( $settings[ $current_theme_location ]['enabled'] ) && $settings[ $current_theme_location ]['enabled'] == 1) {
              if(isset($settings[ $current_theme_location ]['theme_type'] ) && $settings[ $current_theme_location ]['theme_type'] == "custom_themes" ){
                        $theme_id = $settings[ $current_theme_location ]['theme'];    
                        $menu_theme = $themes_style_manager->get_custom_theme_rowdata($theme_id);
                     
                        $theme_settings = unserialize($menu_theme->theme_settings);
                        $responsive_breakpoint_width = (isset($theme_settings['mobile_settings']['resposive_breakpoint_width']) && $theme_settings['mobile_settings']['resposive_breakpoint_width'] != '')?$theme_settings['mobile_settings']['resposive_breakpoint_width']:''; 
                  }else{
                         $theme_id = esc_attr($settings[ $current_theme_location ]['available_skin']);    
                         $responsive_breakpoint_width = "910"; 
                  }

            }
        $apmega_general_settings = get_option('apmega_settings');
        
          if(isset($apmega_general_settings['enable_mobile']) && $apmega_general_settings['enable_mobile'] != 1){
             $addClass = "wpmega-disable-menutoggle";
          }else{
             $addClass = "wpmega-enabled-menutoggle";
          }

        $main_content = "";

        $main_content = apply_filters( "wpmegamenu_togglebar_content", $main_content, $nav_menu, $args, $theme_id ,$apmega_general_settings);

        $replace = $dynamicclass . '<div class="wpmegamenu-toggle '. $addClass.'" data-responsive-breakpoint="'.$responsive_breakpoint_width.'">' . $main_content . '</div>';

        return str_replace( $dynamicclass, $replace, $nav_menu );

    }

     /**
     * Get the HTML output for the toggle blocks
     * Derived From: Max Mega Menu
     * https://www.maxmegamenu.com
     */
    public function wpmm_responsive_display_togglebar_content($content, $nav_menu, $args, $theme_id, $general_settings){

      $close_menu_icon =   $general_settings['close_menu_icon'];
      $open_menu_icon  =   $general_settings['open_menu_icon'];

       // if a current_theme_location has been passed, check to see if MMM has been enabled for the current_theme_location
       $settings = get_option( 'wpmegabox_settings' ); //get all plugin metabox data from nav menu location
       $current_theme_location = $args->theme_location;

        $menutoggle_name = __('Menu',APMM_TD);
        // this is for available theme toggle section
         $blocks_html = "<div class='wp-mega-toggle-block'>";
         $blocks_html .= "<div class='wpmega-closeblock'><i class='".$close_menu_icon."'></i></div>";
         $blocks_html .= "<div class='wpmega-openblock'><i class='".$open_menu_icon."'></i></div>";
         $blocks_html .= "<div class='menutoggle'>".$menutoggle_name."</div>";  
         $blocks_html .= "</div>";

      $content .= $blocks_html;

      return $content;
    }

    /*
    *  Display Menu Using Shortcode [wpmegamenu menu_location=primary]
    */
    function wpmm_print_menu_shortcode($atts, $content = null) {
      extract(shortcode_atts(array( 'menu_location' => null), $atts));
      if ( ! isset( $menu_location ) ) {
            return false;
        }
         if ( has_nav_menu( $menu_location ) ) {
          $settings = get_option( 'wpmegabox_settings' ); //get all plugin metabox data 
          $current_theme_location = $menu_location; // get current menu location i.e primary
           if ( isset ( $settings[ $current_theme_location ]['enabled'] ) && $settings[ $current_theme_location ]['enabled'] == 1 ) {
           
                 if(isset($settings[ $current_theme_location ]['theme_type'] ) && $settings[ $current_theme_location ]['theme_type'] == "custom_themes" ){
                        $skin_type = "wpmm-custom-theme"; 
                      }else{
                        $skin_type = '';
                      }
              if($skin_type =="wpmm-custom-theme"){
                $this->get_custom_designs($current_theme_location,$settings);
              }

           // if(isset ( $settings[ $current_theme_location ]['orientation'] ) &&  $settings[ $current_theme_location ]['orientation'] == "vertical"){
               //$returnvalue = '<div class="wpmm-main-wrapper" data-container-width="'.$container_width.'" data-menu-width="'.$menu_width.'">';
               return wp_nav_menu( array( 'theme_location' => $menu_location, 'echo' => false ) );
              // $returnvalue .='</div>';
              // return $returnvalue;
             //}else{
             //return "<!-- WP MEGA MENU not available with horizontal orientation for [wpmegamenu menu_location={$menu_location}]. -->";
            // }

           }

         
        }
         return "<!-- Menu Location Not found for [wpmegamenu menu_location={$menu_location}] -->";
    }


      /**
       * Get size information for all currently-registered image sizes.
       *
       * @global $_wp_additional_image_sizes
       * @uses   get_intermediate_image_sizes()
       * @return array $sizes Data for all currently-registered image sizes.
       */
        static public function wpmm_get_image_sizes() {
        global $_wp_additional_image_sizes;

        $sizes = array();

        foreach ( get_intermediate_image_sizes() as $_size ) {
          if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
            $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
            $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
            $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
          } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
              'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
              'height' => $_wp_additional_image_sizes[ $_size ]['height'],
              'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
            );
          }
        }

        return $sizes;
      }





	}

	$ap_menu = new APMM_Class();

}