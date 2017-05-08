<?php
/**
 * Plugin Name: Clever Mega Menu
 * Plugin URI:  http://www.zootemplate.com/wordpress-plugins/clevermegamenu
 * Description: Fully control over WordPress navigation menus with ease of visual editing from Visual Composer. <strong>Clever Mega Menu</strong> lets you add HTML, shortcodes or widgets into navigation menus easily without any coding knowledge.
 * Author:      Zootemplate
 * Version:     1.0.0
 * Author URI:  http://zootemplate.com/
 * Text Domain: clever-mega-menu
 */
final class Clever_Mega_Menu
{
    /**
     * Version
     *
     * @var    string
     */
    const VERSION = '1.0.0';

    /**
     * Option name
     *
     * @var    string
     */
    const OPTION_NAME = 'clever_mega_menu_settings';

    /**
     * Settings
     *
     * @var    array
     */
    private $settings;

    /**
     * Constructor
     */
    function __construct($settings = array())
    {
        $this->settings = $settings ? (array)$settings : array();
        $this->settings['basedir']  = __DIR__ . '/';
        $this->settings['baseuri']  = plugins_url('/', __FILE__);
    }

    /**
     * Do activation
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/functions/register_activation_hook/
     *
     * @param    bool    $network    Whether activating this plugin on network or not.
     */
    function _activate($network)
    {
        $vc_ver  = defined('WPB_VC_VERSION') ? WPB_VC_VERSION : 0;
        $compare = version_compare($vc_ver, '4.9');

        try {
            if ($compare < 0) {
                throw new Exception(esc_html__('Whoops, Clever Mega Menu requires Visual Composer version 4.9 at least. Please install latest version of Visual Composer before activating Clever Mega Menu!', 'clever-mega-menu'));
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }

        global $wpdb;

        $results = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type='clever_menu_theme' AND post_status='publish'");

        if (empty($results)) {
            $wpdb->insert($wpdb->posts, array(
                'post_type'      => 'clever_menu_theme',
                'post_name'      => 'default-461836',
                'post_title'     => esc_html__('Default', 'clever-mega-menu'),
                'post_status'    => 'publish',
                'ping_status'    => 'closed',
                'comment_status' => 'closed'
            ));
        }
    }

    /**
     * Do deactivation
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/functions/register_deactivation_hook/
     *
     * @param    bool    $network    Whether deactivating this plugin on network or not.
     */
    function _deactivate($network)
    {
        flush_rewrite_rules(false);
    }

    /**
     * Do installation
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/hooks/plugins_loaded/
     */
    function _install()
    {
        load_plugin_textdomain('clever-mega-menu', false,  $this->settings['basedir'] . 'languages');

        $this->load_resources();

        if (is_admin()) {
            $this->add_dashboard_page();
            $this->add_import_export_page();
        }

        $this->register_post_types();

        $this->register_menu_item_meta();

        $this->register_menu_term_meta();

        $this->register_menu_theme_meta();

        add_action('init', array($this, '_register_assets'));

        add_action('admin_menu', array($this, '_remove_slugdiv_metabox'), PHP_INT_MAX);
    }

    /**
     * Do uninstallation
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/functions/register_uninstall_hook/
     */
    static function _uninstall()
    {
        delete_option(self::OPTION_NAME);

        global $wpdb;

        $results = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type='clever_menu_theme' OR post_type='clever_menu' OR post_type='clever_menu_location'");

        if (!empty($results)) {
            foreach ($results as $post_ID) {
                wp_delete_post($post_ID, true);
            }
        }
    }

    /**
     * Register assets
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _register_assets()
    {
        $js_suffix  = SCRIPT_DEBUG ? '.js' : '.min.js';
        $css_suffix = SCRIPT_DEBUG ? '.css' : '.min.css';
        $assets_uri = $this->settings['baseuri'] . 'assets/';

        // Register stylesheets.
        wp_register_style('clever-nav-menu', $assets_uri.'backend/css/clever-nav-menu'.$css_suffix, array(), self::VERSION);
        wp_register_style('clever-menu-item', $assets_uri . 'backend/css/clever-menu-item' . $css_suffix, array('wp-color-picker'), self::VERSION);
        wp_register_style('clever-menu-theme', $assets_uri.'backend/css/clever-menu-theme'.$css_suffix, array('wp-color-picker'), self::VERSION);
        wp_register_style('clever-mega-menu-admin', $assets_uri.'backend/css/clever-mega-menu-admin'.$css_suffix, array('dashicons', 'wp-color-picker'), self::VERSION);
        wp_register_style('clever-mega-menu-theme-default', $this->settings['baseuri'] . 'assets/frontend/css/clever-mega-menu-theme-default-461836' . $css_suffix, array('dashicons'), self::VERSION);

        // Register scripts.
        wp_register_script('wp-color-picker-alpha', $assets_uri . 'backend/js/wp-color-picker-alpha' . $js_suffix, array('wp-color-picker'), '1.2.2', true);
        wp_register_script('clever-mega-menu-item-settings', $assets_uri . 'backend/js/clever-mega-menu-item-settings' . $js_suffix, array(), self::VERSION, true);
        wp_register_script('clever-mega-menu-admin', $assets_uri . 'backend/js/clever-mega-menu-admin' . $js_suffix, array('wp-color-picker-alpha'), self::VERSION, true );
        wp_register_script('jquery-serialize-object', $assets_uri . 'backend/js/jquery-serialize-object' . $js_suffix, array(), '2.5.0', true);
        wp_register_script('clever-menu-item', $assets_uri . 'backend/js/clever-menu-item' . $js_suffix, array('jquery-core'), self::VERSION, true);
        wp_register_script('clever-menu-theme', $assets_uri . 'backend/js/clever-menu-theme' . $js_suffix, array('jquery-core'), self::VERSION, true);
        wp_register_script('clever-mega-menu',  $assets_uri . 'frontend/js/clever-mega-menu' . $js_suffix , array('jquery'), self::VERSION, true);

        // Localize scripts.
        wp_localize_script('jquery-core', 'cleverMenuI18n', array(
            'enableMega'     => esc_html__('Enable Mega', 'clever-mega-menu'),
            'editItem'       => esc_html__('Edit Item', 'clever-mega-menu'),
            'megaMenu'       => esc_html__('Mega Menu', 'clever-mega-menu'),
            'select'         => esc_html__('Select', 'clever-mega-menu'),
            'insert'         => esc_html__('Insert', 'clever-mega-menu'),
            'save'           => esc_html__('Save', 'clever-mega-menu'),
            'saveAll'        => esc_html__('Save All', 'clever-mega-menu'),
            'close'          => esc_html__('Close', 'clever-mega-menu'),
            'change'         => esc_html__('Change', 'clever-mega-menu'),
            'done'           => esc_html__('Done', 'clever-mega-menu'),
            'megaSettings'   => esc_html__('Mega Settings', 'clever-mega-menu'),
            'menuSettings'   => esc_html__('Menu Settings', 'clever-mega-menu'),
            'itemSettings'   => esc_html__('Item Settings', 'clever-mega-menu'),
            'selectOrUpload' => esc_html__('Select or Upload', 'clever-mega-menu'),
            'megaCssDesc'    => esc_html__('The custom CSS will be generated for this menu item only.', 'clever-mega-menu')
        ));
        wp_localize_script('jquery-core', 'cleverMenuConfig', array(
            'newCleverMenu' => admin_url('post-new.php?post_type=clever_menu'),
            '_nonce'        => wp_create_nonce('clever_menu'),
            'menuUrl'       => admin_url('nav-menus.php')
        ));
    }

    /**
     * Load admin assets
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @param    string    $hook_suffix    Hook suffix of current screen.
     *
     * @see    https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
     */
    function _load_admin_assets($hook_suffix)
    {
        wp_enqueue_style('clever-mega-menu-admin');
        wp_enqueue_script('clever-mega-menu-admin');
        if ($hook_suffix === 'toplevel_page_class-clever-mega-menu-settings') {
            wp_enqueue_style('dashboard');
            wp_enqueue_script('dashboard');
        }
        if ($hook_suffix === 'nav-menus.php') {
            wp_enqueue_style('clever-nav-menu');
            wp_localize_script('clever-mega-menu-admin', 'cleverMenuItems', $this->get_item_settings($this->get_selected_menu_id()));
            wp_enqueue_script('clever-mega-menu-item-settings');
        }
        if (($hook_suffix === 'post-new.php' || $hook_suffix === 'post.php')) {
            if ($GLOBALS['post']->post_type === 'clever_menu') {
                if (isset($_GET['clever_menu_item_id'])) {
                    $item_id = intval($_GET['clever_menu_item_id']);
                    wp_localize_script('clever-menu-item', 'cleverMenuItem', array(
                        'style' => get_post_meta($item_id, '_vc_custom_post_css', true)
                    ));
                }
                wp_enqueue_media();
                wp_enqueue_style('clever-menu-item');
                wp_enqueue_script('jquery-serialize-object');
                wp_enqueue_script('clever-mega-menu-item-settings');
                wp_enqueue_script('clever-menu-item');
            }
            if ($GLOBALS['post']->post_type === 'clever_menu_theme') {
                wp_enqueue_style('clever-menu-theme');
                wp_enqueue_script('clever-menu-theme');
            }
        }
    }

    /**
     * Load public assets
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @param    string    $hook_suffix    Hook suffix of current screen.
     *
     * @see    https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
     */
    function _load_public_assets()
    {
        $menus = get_terms(array(
    		'hide_empty' => true,
    		'taxonomy'   => 'nav_menu',
    		'fields'     => 'id=>slug'
    	));
        $themes = array();
        $items  = array();

        if (!empty($menus)) {
            foreach ($menus as $id => $menu) {
                $menu_meta = get_term_meta($id, Clever_Mega_Menu_Term_Meta::META_KEY, true);
                if (!empty($menu_meta['enabled'])) {
                    $menu_items = wp_get_nav_menu_items($id, array(
                        'post_type'        => 'nav_menu_item',
                        'post_status'      => 'publish',
                        'no_found_rows'    => true,
                        'suppress_filters' => true
                    ));
                    if ($menu_items) {
                        $items = array_merge($items, $menu_items);
                    }
                    if (!empty($menu_meta['theme'])) {
                        $theme = get_page_by_path($menu_meta['theme'], OBJECT, 'clever_menu_theme');
                        if ($theme && !isset($themes[$menu_meta['theme']])) {
                            $themes[$menu_meta['theme']] = $theme;
                        }
                    } else {
                        if (!isset($themes['default-461836'])) {
                            $themes[] = get_page_by_path('default-461836', OBJECT, 'clever_menu_theme');
                        }
                    }
                }
            }
            if ($themes) {
                $uploads = wp_upload_dir();
                foreach ($themes as $name => $object) {
                    $theme_css = $theme_css = $uploads['basedir'] . '/clever-mega-menu/clever-mega-menu-theme-' . $name . '.css';
                    $theme_meta = (array)get_post_meta($object->ID, Clever_Mega_Menu_Theme_Meta::META_KEY, true);
                    if (file_exists($theme_css)) {
                        $theme_meta['general_css_output'] = !empty($theme_meta['general_css_output']) ? $theme_meta['general_css_output'] : 'sitehead';
                        if ('filesystem' === $theme_meta['general_css_output']) {
                            wp_enqueue_style('clever-mega-menu-' . $name, $uploads['baseurl'] . '/clever-mega-menu/clever-mega-menu-theme-' . $name . '.css' , array('dashicons'), self::VERSION);
                        } else {
                            $inline_css = file_get_contents($theme_css);
                            if ($inline_css) {
                                wp_add_inline_style('dashicons', $inline_css);
                            }
                        }
                    } else {
                        wp_enqueue_style('clever-mega-menu-theme-default');
                    }
                    if (!empty($theme_meta['custom_js'])) {
                        wp_add_inline_script('clever-mega-menu', $theme_meta['custom_js']);
                    }
                }
            }
            if ($items) {
                $custom_vc_styles = '';
                foreach ($items as $menu_item) {
                    $item_meta = get_post_meta($menu_item->ID, '_vc_custom_item_css', true);
                    if (!empty($item_meta)) {
                        $custom_vc_styles .= $item_meta;
                    }
                }
                if ($custom_vc_styles) {
                    $custom_vc_styles = preg_replace(
                        array('/:\s*/', '/\s*{\s*/', '/(;)*\s*}\s*/', '/\s+/'),
                        array(':', '{', '}', ' '),
                        $custom_vc_styles
                    );
                    wp_add_inline_style('dashicons', $custom_vc_styles);
                }
            }
            wp_enqueue_style('dashicons');
        }

        wp_enqueue_script('clever-mega-menu');
    }

    /**
     * Remove slugdiv meta box
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @param    string    $context
     *
     * @see    https://developer.wordpress.org/reference/hooks/admin_menu/
     */
    function _remove_slugdiv_metabox($context)
    {
        remove_meta_box('slugdiv', array('clever_menu_theme', 'clever_menu_location'), 'normal');
    }

    /**
     * Load resources
     */
    private function load_resources()
    {
        $inc = $this->settings['basedir'] . 'includes/';

        require $inc . 'class-leafo-scss-compiler.php';
        require $inc . 'class-clever-mega-menu-walker.php';
        require $inc . 'class-clever-mega-menu-dashboard.php';
        require $inc . 'class-clever-mega-menu-post-type.php';
        require $inc . 'class-clever-mega-menu-item-meta.php';
        require $inc . 'class-clever-mega-menu-term-meta.php';
        require $inc . 'class-clever-mega-menu-theme-meta.php';
        require $inc . 'class-clever-mega-menu-import-export.php';
        require $inc . 'class-clever-mega-menu-theme-post-type.php';

        add_action('admin_enqueue_scripts', array($this, '_load_admin_assets'));

        add_action('wp_enqueue_scripts', array($this, '_load_public_assets'), PHP_INT_MAX, 0);
    }

    /**
     * Add settings page
     */
    private function add_dashboard_page()
    {
        $page = new Clever_Mega_Menu_Dashboard($this->settings);

        add_action('admin_menu', array($page, '_add'), 0, 1);
    }

    /**
     * Add import/export page
     */
    private function add_import_export_page()
    {
        $page = new Clever_Mega_Menu_Import_Export($this->settings);

        add_action('admin_menu', array($page, '_add'), PHP_INT_MAX, 1);

        add_action('admin_init', array($page, '_import'), 0, 0);

        add_action('admin_init', array($page, '_export'), 0, 0);

        add_action('admin_notices', array($page, '_notify'), 0, 0);
    }

    /**
     * Register clever menu item post type
     */
    private function register_post_types()
    {
        $menu_post_type = new Clever_Mega_Menu_Post_Type($this->settings);
        $menu_theme_post_type = new Clever_Mega_Menu_Theme_Post_Type($this->settings);

        add_action('init', array($menu_post_type, '_register'), 10, 0);

        add_action('init', array($menu_theme_post_type, '_register'), 10, 0);

        add_filter('post_updated_messages', array($menu_theme_post_type, '_notify'));

        add_filter('post_row_actions', array($menu_theme_post_type, '_remove_quick_edit'), PHP_INT_MAX, 2);

        add_filter('wpb_vc_js_status_filter', array($menu_post_type, '_filter_cs_js_status'));
    }

    /**
     * Register clever menu item metadata.
     */
    private function register_menu_item_meta()
    {
        $meta = new Clever_Mega_Menu_Item_Meta($this->settings);

        add_action('add_meta_boxes_clever_menu', array($meta, '_add'));

        add_action('admin_init', array($meta, '_add_vc_capability'));

        add_action('edit_form_top', array($meta, '_change_content'));

        add_action('in_admin_header', array($meta, '_add_loading_spinner'), 0, 0);

        add_action('wp_ajax_save_clever_menu_item', array($meta, '_save'), 0, 0);
    }

    /**
     * Register clever menu theme metadata.
     */
    private function register_menu_theme_meta()
    {
        $meta = new Clever_Mega_Menu_Theme_Meta($this->settings);

        add_action('delete_post', array($meta, '_delete'));

        add_action('add_meta_boxes_clever_menu_theme', array($meta, '_add'));

        add_action('save_post_clever_menu_theme', array($meta, '_save'), 10, 2);
    }

    /**
     * Register clever menu term metadata.
     */
    private function register_menu_term_meta()
    {
        $meta = new Clever_Mega_Menu_Term_Meta($this->settings);

        add_action('admin_footer-nav-menus.php', array($meta, '_render'), 10, 0);

        add_filter('wp_nav_menu_args', array($meta, '_change_nav_menu_args'), PHP_INT_MAX);

        if (!isset($_REQUEST['wp_customize']) || $_REQUEST['wp_customize'] !== 'on') {
            add_action('wp_update_nav_menu', array($meta, '_save'));
        }
    }

    /**
     * Get menu items' data
     */
    private function get_item_settings($nav_menu_selected_id)
    {
        $items = wp_get_nav_menu_items($nav_menu_selected_id);

        $menu_items = array();

        if ($items) {
            $meta_key = Clever_Mega_Menu_Item_Meta::SETTINGS_META_KEY;
            $meta_fields = Clever_Mega_Menu_Item_Meta::$fields;
            foreach ($items as $item) {
                $settings = (array)get_post_meta($item->ID, $meta_key, true);
                $settings = array_merge($meta_fields, $settings);
                $menu_items[$item->ID] = array(
                    'url' =>  admin_url('post-new.php?post_type=clever_menu&clever_menu_id='.$nav_menu_selected_id.'&clever_menu_item_id=' . $item->ID),
                    'options' => $settings,
              );
            }
        }

        return $menu_items;
    }

    /**
     * Get selected nav menu ID
     */
    private function get_selected_menu_id()
    {
        $nav_menus = wp_get_nav_menus(array('orderby' => 'name'));

        $menu_count = count($nav_menus);

        $nav_menu_selected_id = isset($_REQUEST['menu']) ? (int)$_REQUEST['menu'] : 0;

        $add_new_screen = (isset($_GET['menu']) && 0 === $_GET['menu']) ? true : false;

        $page_count = wp_count_posts('page');

        $one_theme_location_no_menus = (1 === count(get_registered_nav_menus()) && !$add_new_screen && empty($nav_menus) && !empty($page_count->publish)) ? true : false;

        $recently_edited = absint(get_user_option('nav_menu_recently_edited'));

        if (empty($recently_edited) && is_nav_menu($nav_menu_selected_id))
            $recently_edited = $nav_menu_selected_id;

        if (empty($nav_menu_selected_id) && !isset($_GET['menu']) && is_nav_menu($recently_edited))
            $nav_menu_selected_id = $recently_edited;

        if (!$add_new_screen && 0 < $menu_count && isset($_GET['action']) && 'delete' === $_GET['action'])
            $nav_menu_selected_id = $nav_menus[0]->term_id;

        if ($one_theme_location_no_menus) {
            $nav_menu_selected_id = 0;
        } elseif (empty($nav_menu_selected_id) && !empty($nav_menus) && !$add_new_screen) {
            $nav_menu_selected_id = $nav_menus[0]->term_id;
        }

        return $nav_menu_selected_id;
    }
}

// Get Clever_Mega_Menu instance.
$clevermenu = new Clever_Mega_Menu(get_option(Clever_Mega_Menu::OPTION_NAME));

// Register activation hook.
register_activation_hook(__FILE__, array($clevermenu, '_activate'));

// Register deactivation hook.
register_deactivation_hook(__FILE__, array($clevermenu, '_deactivate'));

// Register installation hook.
add_action('plugins_loaded', array($clevermenu, '_install'), 10, 0);

// Register uninstallation hook.
register_uninstall_hook(__FILE__, 'Clever_Mega_Menu::_uninstall');

// Unset Clever_Mega_Menu from global space.
unset($clevermenu);
