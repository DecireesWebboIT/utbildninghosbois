<?php
/**
 * Clever_Mega_Menu_Item_Meta
 *
 * @package    Clever_Mega_Menu
 */
final class Clever_Mega_Menu_Item_Meta
{
    /**
     * Meta key
     *
     * @var    string
     */
    const CONTENT_META_KEY = '_clever_mega_menu_item_meta_content';

    /**
     * Meta key
     *
     * @var    string
     */
    const SETTINGS_META_KEY = '_clever_mega_menu_item_meta_settings';

    /**
     * Settings
     *
     * @see    Clever_Mega_Menu::$settings
     *
     * @var    array
     */
    private $settings;

    /**
     * Meta fields
     *
     * @var    array
     */
    public static $fields = array(
        'icon' => '',
        'width' => '',
        'enable' => '0',
        'layout' => 'full',
        'hide_title' => '0',
        'disable_link' => '0',
        'hide_on_mobile' => '0',
        'hide_on_desktop' => '0',
        'hide_sub_item_on_mobile' => '0'
    );

    /**
     * Meta values
     *
     * @var    array
     */
    private $values;

    /**
     * Constructor
     */
    function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Add metabox
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @param    object    \WP_Post
     */
    function _add($post)
    {
        add_meta_box(
            'clever_menu_meta_box',
            esc_html__('Menu Item Settings', 'clever-mega-menu'),
            array($this, '_render'),
            'clever_menu',
            'normal',
            'high'
        );
    }

    /**
     * Add users' capability for VC
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _add_vc_capability()
    {
        global $current_user;

        $current_user->allcaps['vc_access_rules_post_types/clever_menu'] = true;
        $current_user->allcaps['vc_access_rules_post_types'] = 'custom';

        if ( in_array('administrator', $current_user->caps) ) {
            $cap = get_role('administrator');
            $cap->add_cap('vc_access_rules_post_types', 'custom');
            $cap->add_cap('vc_access_rules_presets', true);
            $cap->add_cap('vc_access_rules_settings', true);
            $cap->add_cap('vc_access_rules_templates', true);
            $cap->add_cap('vc_access_rules_shortcodes', true);
            $cap->add_cap('vc_access_rules_grid_builder', true);
            $cap->add_cap('vc_access_rules_post_settings', true);
            $cap->add_cap('vc_access_rules_backend_editor', true);
            $cap->add_cap('vc_access_rules_frontend_editor', true);
            $cap->add_cap('vc_access_rules_post_types/post', true);
            $cap->add_cap('vc_access_rules_post_types/page', true);
            $cap->add_cap('vc_access_rules_post_types/clever_menu', true);
        }
    }

    /**
     * Save metadata
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _save()
    {
        $response = array(
            'url' => '',
            'status' => false,
            'errors' => array(),
            'is_update' => true,
        );

        $item_id = !empty($_POST['clever_menu_item_id']) ? intval($_POST['clever_menu_item_id']) : 0;
        $menu_id = !empty($_POST['clever_menu_id']) ? intval($_POST['clever_menu_id']) : 0;

        if (!$item_id) {
            $response['errors'][] = esc_html__('Menu item not exists.', 'clever-mega-menu');
            exit(json_encode($response));
        }

        $post = get_post($item_id);

        if ($post->post_type !== 'nav_menu_item') {
            $response['errors'][] = esc_html__('Menu item not exists.', 'clever-mega-menu');
            exit(json_encode($response));
        }

        $settings = array_merge(self::$fields, $this->sanitize($_POST));
        $content  = !empty($_POST['content']) ? wp_kses_post($_POST['content']) : '';
        $styles   = $this->parse_shortcodes_css(stripslashes($content));
        $styles   = apply_filters('vc_base_build_shortcodes_custom_css', $styles);

        if ($styles) {
            update_post_meta($item_id, '_vc_custom_item_css', $styles);
        }
        update_post_meta($item_id, self::SETTINGS_META_KEY, $settings);
        update_post_meta($item_id, self::CONTENT_META_KEY, $content);

        $response['url'] = admin_url('post-new.php?post_type=clever_menu&clever_menu_id='.$menu_id.'&clever_menu_item_id='.$item_id);
        $response['settings'] = $settings;

        exit(json_encode($response));
    }

    /**
     * Callback
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _render()
    {
        global $post;

        $menu_id = isset($_REQUEST['clever_menu_id']) ? absint($_REQUEST['clever_menu_id']) : 0;
        $item_id = isset($_REQUEST['clever_menu_item_id']) ? absint($_REQUEST['clever_menu_item_id']) : 0;

        $settings = (array)get_post_meta($item_id, self::SETTINGS_META_KEY, true);
        $settings = array_merge(self::$fields, $settings);

        ?><input type="text" name="clever_menu_item_id" value="<?php echo $item_id ?>">
        <input type="text" name="clever_menu_id" value="<?php echo $menu_id ?>">

        <script type="text/html" id="clever-enable-mega-menu-switch">
            <div class="onoffswitch">
                <input type="checkbox" id="clever-mega-menu-item-enable" name="enable" <?php checked($settings['enable']); ?> value="1" class="onoffswitch-checkbox">
                <label for="clever-mega-menu-item-enable" class="onoffswitch-label"></label>
            </div>
        </script>

        <script type="text/html" id="clever-mega-menu-item-settings-tabs">
            <ul class="clever-mega-menu-item-setting-tabs">
                <li class="clever-mega-menu-item-setting-tab clever-mega-menu-to-content active-item-setting-tab"><span><?php esc_html_e('Mega Menu', 'clever-mega-menu') ?></span></li>
                <li class="clever-mega-menu-item-setting-tab clever-mega-menu-to-settings"><span><?php esc_html_e('Settings', 'clever-mega-menu'); ?></span></li>
                <li class="clever-mega-menu-item-setting-tab clever-mega-menu-to-design"><span><?php esc_html_e('Design', 'clever-mega-menu'); ?></span></li>
                <li class="clever-mega-menu-item-setting-tab clever-mega-menu-to-icons"><span><?php esc_html_e('Icon', 'clever-mega-menu'); ?></span></li>
            </ul>
        </script>

        <script type="text/html" id="clever-mega-menu-vc-icon-picker">
            <div class="clever-mega-menu-icon-popup-w">
                <div class="vc-icons-selector fip-vc-theme-grey clever-mega-menu-icon-popup" style="position:relative;">
                    <div class="selector">
                        <span class="selected-icon"></span>
                        <span class="selector-button toggle-list">
                            <i class="fip-fa dashicons dashicons-arrow-up-alt2"></i>
                        </span>
                        <span class="selector-button remove">
                            <i class="fip-fa dashicons dashicons-no-alt"></i>
                        </span>
                    </div>
                    <div class="selector-popup">
                        <div class="selector-search">
                            <input type="text" class="icons-search-input" placeholder="<?php esc_html_e('Search Icon', 'clever-mega-menu'); ?>" value="" name="">
                            <i class="fip-fa dashicons dashicons-search"></i>
                        </div>
                        <div class="fip-icons-container">
                            <?php echo $this->get_font_icons(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script type="text/html" id="clever-mega-menu-item-settings">
            <div class="clever-mega-menu-item-settings">
                <div class="clever-mega-menu-tab clever-mega-menu-tab-settings" style="display:none">
                    <div class="vc_col-xs-12 vc_column wpb_el_type_checkbox">
                        <div class="wpb_element_label"><?php esc_html_e('Top Level Item Settings', 'clever-mega-menu'); ?></div>
                        <div class="edit_form_line">
                            <label>
                                <span><?php esc_html_e('Hide title', 'clever-mega-menu'); ?></span>
                                <input type="checkbox" value="1" <?php checked($settings['hide_title']); ?> class="wpb_vc_param_value wpb-textinput" name="hide_title">
                                <span class="description"><?php esc_html_e('Whether to display item without text or not.', 'clever-mega-menu') ?></span>
                            </label>
                        </div>
                        <div class="edit_form_line">
                            <label>
                                <span><?php esc_html_e('Disable link', 'clever-mega-menu'); ?></span>
                                <input type="checkbox"  value="1" <?php checked($settings['disable_link']); ?> class="wpb_vc_param_value wpb-textinput" name="disable_link">
                                <span class="description"><?php esc_html_e('Whether to disable item hyperlink or not.', 'clever-mega-menu') ?></span>
                            </label>
                        </div>
                        <div class="edit_form_line">
                            <label>
                                <span><?php esc_html_e('Hide on mobile', 'clever-mega-menu'); ?></span>
                                <input type="checkbox"  value="1" <?php checked($settings['hide_on_mobile']); ?> class="wpb_vc_param_value wpb-textinput" name="hide_on_mobile">
                                <span class="description"><?php esc_html_e('Whether to hide item on mobile devices or not.', 'clever-mega-menu') ?></span>
                            </label>
                        </div>
                        <div class="edit_form_line">
                            <label>
                                <span><?php esc_html_e('Hide on desktop', 'clever-mega-menu'); ?></span>
                                <input type="checkbox"  value="1" <?php checked($settings['hide_on_desktop']); ?> class="wpb_vc_param_value wpb-textinput" name="hide_on_desktop">
                                <span class="description"><?php esc_html_e('Whether to hide item on desktop screens or not.', 'clever-mega-menu') ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="vc_col-xs-12 vc_column wpb_el_type_checkbox">
                        <div class="wpb_element_label"><?php esc_html_e('Sub Menu Item Settings', 'clever-mega-menu'); ?></div>
                        <div class="edit_form_line">
                            <label class="inline"><?php esc_html_e('Sub menu alignment', 'clever-mega-menu'); ?></label>
                            <?php
                            $layouts = array(
                                'full' => array('label' => esc_html__('Full Width', 'clever-mega-menu'), 'url' => $this->settings['baseuri'] . 'assets/backend/images/layouts/submenu-horizontal-full-width.jpg'),
                                'center' => array('label' => esc_html__('Default', 'clever-mega-menu'), 'url' => $this->settings['baseuri'] . 'assets/backend/images/layouts/submenu-horizontal-align-center.jpg'),
                                'right_edge_item' => array('label' => esc_html__('Left edge item', 'clever-mega-menu'), 'url' => $this->settings['baseuri'] . 'assets/backend/images/layouts/submenu-horizontal-align-left.jpg'),
                                'left_edge_item' => array('label' => esc_html__('Right edge item', 'clever-mega-menu'), 'url' => $this->settings['baseuri'] . 'assets/backend/images/layouts/submenu-horizontal-align-right.jpg'),
                            );
                            foreach($layouts as $k => $layout) : ?>
                                <span class="image-radio">
                                    <input id="layout-<?php echo esc_attr($k ); ?>" type="radio" <?php checked($settings['layout'], $k); ?> name="layout" value="<?php echo esc_attr($k); ?>">
                                    <label for="layout-<?php echo esc_attr($k); ?>"><img alt="" src="<?php echo esc_url($layout['url']) ?>"></label>
                                </span>
                            <?php endforeach ?>
                        </div>
                        <div class="edit_form_line submenu-item-with">
                            <?php $subwidth = $settings['width'] ? $settings['width'] . 'px' : '' ?>
                            <label>
                                <span><?php esc_html_e('Sub menu item width (px only)', 'clever-mega-menu'); ?></span>
                                <input type="text" value="<?php echo $subwidth ?>" class="wpb_vc_param_value wpb-textinput el_class textfield" name="width">
                            </label>
                        </div>
                        <div class="edit_form_line">
                            <label>
                                <span><?php esc_html_e('Hide sub item on mobile devices', 'clever-mega-menu'); ?></span>
                                <input type="checkbox"  value="1" <?php checked($settings['hide_sub_item_on_mobile']); ?> class="wpb_vc_param_value wpb-textinput" name="hide_sub_item_on_mobile">
                                <span class="description"><?php esc_html_e('Whether to hide sub item on mobile devices or not.', 'clever-mega-menu') ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="vc_col-xs-12 vc_column wpb_el_type_textfield">
                        <div class="wpb_element_label"><?php esc_html_e('Roles & Restrictions', 'clever-mega-menu'); ?></div>
                        <div class="edit_form_line">
                            <p><?php esc_html_e('This feature is available in Clever Mega Menu Pro only.', 'clever-mega-menu') ?> <a href="http://wpplugin.zootemplate.com/clevermegamenu/"><?php esc_html_e('Upgrade to Pro version now.', 'clever-mega-menu') ?></a></p>
                        </div>
                    </div>
                </div>
                <div class="clever-mega-menu-tab clever-mega-menu-tab-design" style="display:none">
                    <div class="vc_col-xs-12 vc_column wpb_el_type_checkbox">
                        <div class="edit_form_line">
                            <p><?php esc_html_e('This feature is available in Clever Mega Menu Pro only.', 'clever-mega-menu') ?> <a href="http://wpplugin.zootemplate.com/clevermegamenu/"><?php esc_html_e('Upgrade to Pro version now.', 'clever-mega-menu') ?></a></p>
                        </div>
                    </div>
                </div>
                <div class="clever-mega-menu-tab clever-mega-menu-tab-icons" style="display:none">
                    <div class="vc_column vc_col-xs-12 wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param">
                        <input type="hidden" class="vc_icon_picker" value="<?php echo esc_attr($settings['icon']); ?>" name="icon">
                    </div>
                </div>
            </div>
        </script><?php
    }

    /**
     * Add loading spinner
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/hooks/in_admin_header/
     */
    function _add_loading_spinner()
    {
        global $post;

        if (!$post || $post->post_type !== 'clever_menu') {
            return;
        }

        ?><div class="clever-mega-menu-loading">
            <div class="vc-mdl">
                <span class="spinner"></span>
            </div>
        </div><?php
    }

    /**
     * Change post content
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/hooks/edit_form_top/
     */
    function _change_content($post)
    {
        if (isset($_REQUEST['clever_menu_item_id']) && $post->post_type === 'clever_menu') {
            $post_id = absint($_REQUEST['clever_menu_item_id']);
            $GLOBALS['post']->post_content = get_post_meta($post_id, self::CONTENT_META_KEY, true);
        }
    }

    /**
     * Get icons
     *
     * @return    string    $html
     */
    private function get_font_icons()
    {
        ob_start();

        $group_icons = array();
        $dashicons = array(
            array('dashicons dashicons-menu' => esc_html__('Navigation Menu', 'clever-mega-menu')),
            array('dashicons dashicons-admin-site' => esc_html__('Admin Site', 'clever-mega-menu')),
            array('dashicons dashicons-dashboard' => esc_html__('Dashboard', 'clever-mega-menu')),
            array('dashicons dashicons-admin-post' => esc_html__('Pin', 'clever-mega-menu')),
            array('dashicons dashicons-admin-media' => esc_html__('Admin Media', 'clever-mega-menu')),
            array('dashicons dashicons-admin-links' => esc_html__('Admin Link', 'clever-mega-menu')),
            array('dashicons dashicons-admin-page' => esc_html__('Admin Page', 'clever-mega-menu')),
            array('dashicons dashicons-admin-comments' => esc_html__('Admin Comment', 'clever-mega-menu')),
            array('dashicons dashicons-admin-appearance' => esc_html__('Admin Appearance', 'clever-mega-menu')),
            array('dashicons dashicons-admin-plugins' => esc_html__('Admin Plugins', 'clever-mega-menu')),
            array('dashicons dashicons-admin-users' => esc_html__('Admin Users', 'clever-mega-menu')),
            array('dashicons dashicons-admin-tools' => esc_html__('Admin Tools', 'clever-mega-menu')),
            array('dashicons dashicons-admin-network' => esc_html__('Admin Lock Key', 'clever-mega-menu')),
            array('dashicons dashicons-admin-home' => esc_html__('Admin Home', 'clever-mega-menu')),
            array('dashicons dashicons-admin-generic' => esc_html__('Admin Gear', 'clever-mega-menu')),
            array('dashicons dashicons-admin-collapse' => esc_html__('Admin Media Button', 'clever-mega-menu')),
            array('dashicons dashicons-filter' => esc_html__('Admin Filter', 'clever-mega-menu')),
            array('dashicons dashicons-admin-customizer' => esc_html__('Admin Customizer', 'clever-mega-menu')),
            array('dashicons dashicons-admin-multisite' => esc_html__('Admin Multisite', 'clever-mega-menu')),
            array('dashicons dashicons-welcome-write-blog' => esc_html__('Write Blog', 'clever-mega-menu')),
            array('dashicons dashicons-welcome-add-page' => esc_html__('Add Page', 'clever-mega-menu')),
            array('dashicons dashicons-welcome-view-site' => esc_html__('View Site', 'clever-mega-menu')),
            array('dashicons dashicons-welcome-widgets-menus' => esc_html__('Widget Menu', 'clever-mega-menu')),
            array('dashicons dashicons-welcome-comments' => esc_html__('No Comments', 'clever-mega-menu')),
            array('dashicons dashicons-welcome-learn-more' => esc_html__('Graduate Cap', 'clever-mega-menu')),
            array('dashicons dashicons-format-aside' => esc_html__('Format Aside', 'clever-mega-menu')),
            array('dashicons dashicons-format-image' => esc_html__('Format Image', 'clever-mega-menu')),
            array('dashicons dashicons-format-status' => esc_html__('Format status', 'clever-mega-menu')),
            array('dashicons dashicons-format-quote' => esc_html__('Format quote', 'clever-mega-menu')),
            array('dashicons dashicons-format-chat' => esc_html__('Format chat', 'clever-mega-menu')),
            array('dashicons dashicons-format-audio' => esc_html__('Format audio', 'clever-mega-menu')),
            array('dashicons dashicons-camera' => esc_html__('camera', 'clever-mega-menu')),
            array('dashicons dashicons-images-alt' => esc_html__('images-alt', 'clever-mega-menu')),
            array('dashicons dashicons-images-alt2' => esc_html__('images-alt2', 'clever-mega-menu')),
            array('dashicons dashicons-video-alt' => esc_html__('video-alt', 'clever-mega-menu')),
            array('dashicons dashicons-video-alt2' => esc_html__('video-alt2', 'clever-mega-menu')),
            array('dashicons dashicons-video-alt3' => esc_html__('video-alt3', 'clever-mega-menu')),
            array('dashicons dashicons-media-archive' => esc_html__('media-archive', 'clever-mega-menu')),
            array('dashicons dashicons-media-audio' => esc_html__('media-audio', 'clever-mega-menu')),
            array('dashicons dashicons-media-code' => esc_html__('media-code', 'clever-mega-menu')),
            array('dashicons dashicons-media-default' => esc_html__('media-default', 'clever-mega-menu')),
            array('dashicons dashicons-media-document' => esc_html__('media-document', 'clever-mega-menu')),
            array('dashicons dashicons-media-interactive' => esc_html__('media-interactive', 'clever-mega-menu')),
            array('dashicons dashicons-media-spreadsheet' => esc_html__('media-spreadsheet', 'clever-mega-menu')),
            array('dashicons dashicons-media-text' => esc_html__('media-text', 'clever-mega-menu')),
            array('dashicons dashicons-media-video' => esc_html__('media-video', 'clever-mega-menu')),
            array('dashicons dashicons-playlist-audio' => esc_html__('playlist-audio', 'clever-mega-menu')),
            array('dashicons dashicons-playlist-video' => esc_html__('playlist-video', 'clever-mega-menu')),
            array('dashicons dashicons-controls-play' => esc_html__('controls-play', 'clever-mega-menu')),
            array('dashicons dashicons-controls-pause' => esc_html__('controls-pause', 'clever-mega-menu')),
            array('dashicons dashicons-controls-forward' => esc_html__('controls-forward', 'clever-mega-menu')),
            array('dashicons dashicons-controls-skipforward' => esc_html__('controls-skipforward', 'clever-mega-menu')),
            array('dashicons dashicons-controls-back' => esc_html__('controls-back', 'clever-mega-menu')),
            array('dashicons dashicons-controls-skipback' => esc_html__('controls-skipback', 'clever-mega-menu')),
            array('dashicons dashicons-controls-repeat' => esc_html__('controls-repeat', 'clever-mega-menu')),
            array('dashicons dashicons-controls-volumeon' => esc_html__('controls-volumeon', 'clever-mega-menu')),
            array('dashicons dashicons-controls-volumeoff' => esc_html__('controls-volumeoff', 'clever-mega-menu')),
            array('dashicons dashicons-image-crop' => esc_html__('image-crop', 'clever-mega-menu')),
            array('dashicons dashicons-image-rotate' => esc_html__('image-rotate', 'clever-mega-menu')),
            array('dashicons dashicons-image-rotate-left' => esc_html__('image-rotate-left', 'clever-mega-menu')),
            array('dashicons dashicons-image-rotate-right' => esc_html__('image-rotate-right', 'clever-mega-menu')),
            array('dashicons dashicons-image-flip-vertical' => esc_html__('image-flip-vertical', 'clever-mega-menu')),
            array('dashicons dashicons-image-flip-horizontal' => esc_html__('image-flip-horizontal', 'clever-mega-menu')),
            array('dashicons dashicons-image-filter' => esc_html__('image-filter', 'clever-mega-menu')),
            array('dashicons dashicons-undo' => esc_html__('undo', 'clever-mega-menu')),
            array('dashicons dashicons-redo' => esc_html__('redo', 'clever-mega-menu')),
            array('dashicons dashicons-editor-ul' => esc_html__('editor-ul', 'clever-mega-menu')),
            array('dashicons dashicons-editor-ol' => esc_html__('editor-ol', 'clever-mega-menu')),
            array('dashicons dashicons-editor-quote' => esc_html__('editor-quote', 'clever-mega-menu')),
            array('dashicons dashicons-editor-alignleft' => esc_html__('editor-alignleft', 'clever-mega-menu')),
            array('dashicons dashicons-editor-aligncenter' => esc_html__('editor-aligncenter', 'clever-mega-menu')),
            array('dashicons dashicons-editor-alignright' => esc_html__('editor-alignright', 'clever-mega-menu')),
            array('dashicons dashicons-editor-insertmore' => esc_html__('editor-insertmore', 'clever-mega-menu')),
            array('dashicons dashicons-editor-spellcheck' => esc_html__('editor-spellcheck', 'clever-mega-menu')),
            array('dashicons dashicons-editor-expand' => esc_html__('editor-expand', 'clever-mega-menu')),
            array('dashicons dashicons-editor-contract' => esc_html__('editor-contract', 'clever-mega-menu')),
            array('dashicons dashicons-editor-kitchensink' => esc_html__('editor-kitchensink', 'clever-mega-menu')),
            array('dashicons dashicons-editor-justify' => esc_html__('editor-justify', 'clever-mega-menu')),
            array('dashicons dashicons-editor-paste-word' => esc_html__('editor-paste-word', 'clever-mega-menu')),
            array('dashicons dashicons-editor-paste-text' => esc_html__('editor-paste-text', 'clever-mega-menu')),
            array('dashicons dashicons-editor-removeformatting' => esc_html__('editor-removeformatting', 'clever-mega-menu')),
            array('dashicons dashicons-editor-paste-text' => esc_html__('editor-paste-text', 'clever-mega-menu')),
            array('dashicons dashicons-editor-video' => esc_html__('editor-video', 'clever-mega-menu')),
            array('dashicons dashicons-editor-customchar' => esc_html__('editor-customchar', 'clever-mega-menu')),
            array('dashicons dashicons-editor-outdent' => esc_html__('editor-outdent', 'clever-mega-menu')),
            array('dashicons dashicons-editor-indent' => esc_html__('editor-indent', 'clever-mega-menu')),
            array('dashicons dashicons-editor-help' => esc_html__('editor-help', 'clever-mega-menu')),
            array('dashicons dashicons-editor-indent' => esc_html__('editor-indent', 'clever-mega-menu')),
            array('dashicons dashicons-editor-unlink' => esc_html__('editor-unlink', 'clever-mega-menu')),
            array('dashicons dashicons-editor-rtl' => esc_html__('editor-rtl', 'clever-mega-menu')),
            array('dashicons dashicons-editor-break' => esc_html__('editor-break', 'clever-mega-menu')),
            array('dashicons dashicons-editor-code' => esc_html__('editor-code', 'clever-mega-menu')),
            array('dashicons dashicons-editor-paragraph' => esc_html__('editor-paragraph', 'clever-mega-menu')),
            array('dashicons dashicons-editor-table' => esc_html__('editor-table', 'clever-mega-menu')),
            array('dashicons dashicons-align-left' => esc_html__('align-left', 'clever-mega-menu')),
            array('dashicons dashicons-align-right' => esc_html__('align-right', 'clever-mega-menu')),
            array('dashicons dashicons-align-center' => esc_html__('align-center', 'clever-mega-menu')),
            array('dashicons dashicons-align-none' => esc_html__('align-none', 'clever-mega-menu')),
            array('dashicons dashicons-lock' => esc_html__('lock', 'clever-mega-menu')),
            array('dashicons dashicons-unlock' => esc_html__('unlock', 'clever-mega-menu')),
            array('dashicons dashicons-calendar' => esc_html__('calendar', 'clever-mega-menu')),
            array('dashicons dashicons-calendar-alt' => esc_html__('calendar-alt', 'clever-mega-menu')),
            array('dashicons dashicons-visibility' => esc_html__('visibility', 'clever-mega-menu')),
            array('dashicons dashicons-hidden' => esc_html__('hidden', 'clever-mega-menu')),
            array('dashicons dashicons-post-status' => esc_html__('Pin 1', 'clever-mega-menu')),
            array('dashicons dashicons-edit' => esc_html__('Pencil', 'clever-mega-menu')),
            array('dashicons dashicons-trash' => esc_html__('trash', 'clever-mega-menu')),
            array('dashicons dashicons-sticky' => esc_html__('pin 2', 'clever-mega-menu')),
            array('dashicons dashicons-external' => esc_html__('external', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-up' => esc_html__('arrow-up', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-down' => esc_html__('arrow-down', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-right' => esc_html__('arrow-right', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-left' => esc_html__('arrow-left', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-up-alt' => esc_html__('arrow-up 1', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-down-alt' => esc_html__('arrow-down 1', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-right-alt' => esc_html__('arrow-right 1', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-left-alt' => esc_html__('arrow-left 1', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-up-alt2' => esc_html__('arrow-up 2', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-down-alt2' => esc_html__('arrow-down 2', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-right-alt2' => esc_html__('arrow-right 2', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-left-alt2' => esc_html__('arrow-left 2', 'clever-mega-menu')),
            array('dashicons dashicons-arrow-left-alt2' => esc_html__('arrow-left 2', 'clever-mega-menu')),
            array('dashicons dashicons-sort' => esc_html__('sort', 'clever-mega-menu')),
            array('dashicons dashicons-leftright' => esc_html__('leftright', 'clever-mega-menu')),
            array('dashicons dashicons-randomize' => esc_html__('randomize', 'clever-mega-menu')),
            array('dashicons dashicons-list-view' => esc_html__('list-view', 'clever-mega-menu')),
            array('dashicons dashicons-exerpt-view' => esc_html__('exerpt-view', 'clever-mega-menu')),
            array('dashicons dashicons-grid-view' => esc_html__('grid-view', 'clever-mega-menu')),
            array('dashicons dashicons-move' => esc_html__('move', 'clever-mega-menu')),
            array('dashicons dashicons-share' => esc_html__('share', 'clever-mega-menu')),
            array('dashicons dashicons-share-alt' => esc_html__('share-alt', 'clever-mega-menu')),
            array('dashicons dashicons-share-alt2' => esc_html__('share-alt2', 'clever-mega-menu')),
            array('dashicons dashicons-twitter' => esc_html__('twitter', 'clever-mega-menu')),
            array('dashicons dashicons-rss' => esc_html__('rss', 'clever-mega-menu')),
            array('dashicons dashicons-email' => esc_html__('email', 'clever-mega-menu')),
            array('dashicons dashicons-email-alt' => esc_html__('email-alt', 'clever-mega-menu')),
            array('dashicons dashicons-facebook' => esc_html__('facebook', 'clever-mega-menu')),
            array('dashicons dashicons-facebook-alt' => esc_html__('facebook-alt', 'clever-mega-menu')),
            array('dashicons dashicons-googleplus' => esc_html__('googleplus', 'clever-mega-menu')),
            array('dashicons dashicons-networking' => esc_html__('networking', 'clever-mega-menu')),
            array('dashicons dashicons-hammer' => esc_html__('hammer', 'clever-mega-menu')),
            array('dashicons dashicons-art' => esc_html__('art', 'clever-mega-menu')),
            array('dashicons dashicons-migrate' => esc_html__('migrate', 'clever-mega-menu')),
            array('dashicons dashicons-performance' => esc_html__('performance', 'clever-mega-menu')),
            array('dashicons dashicons-universal-access' => esc_html__('universal-access', 'clever-mega-menu')),
            array('dashicons dashicons-universal-access-alt' => esc_html__('universal-access-alt', 'clever-mega-menu')),
            array('dashicons dashicons-tickets' => esc_html__('tickets', 'clever-mega-menu')),
            array('dashicons dashicons-nametag' => esc_html__('nametag', 'clever-mega-menu')),
            array('dashicons dashicons-clipboard' => esc_html__('clipboard', 'clever-mega-menu')),
            array('dashicons dashicons-heart' => esc_html__('heart', 'clever-mega-menu')),
            array('dashicons dashicons-megaphone' => esc_html__('megaphone', 'clever-mega-menu')),
            array('dashicons dashicons-schedule' => esc_html__('schedule', 'clever-mega-menu')),
            array('dashicons dashicons-wordpress' => esc_html__('wordpress', 'clever-mega-menu')),
            array('dashicons dashicons-wordpress-alt' => esc_html__('wordpress-alt', 'clever-mega-menu')),
            array('dashicons dashicons-pressthis' => esc_html__('pressthis', 'clever-mega-menu')),
            array('dashicons dashicons-update' => esc_html__('update', 'clever-mega-menu')),
            array('dashicons dashicons-screenoptions' => esc_html__('screenoptions', 'clever-mega-menu')),
            array('dashicons dashicons-info' => esc_html__('info', 'clever-mega-menu')),
            array('dashicons dashicons-cart' => esc_html__('cart', 'clever-mega-menu')),
            array('dashicons dashicons-feedback' => esc_html__('feedback', 'clever-mega-menu')),
            array('dashicons dashicons-cloud' => esc_html__('cloud', 'clever-mega-menu')),
            array('dashicons dashicons-translation' => esc_html__('translation', 'clever-mega-menu')),
            array('dashicons dashicons-tag' => esc_html__('tag', 'clever-mega-menu')),
            array('dashicons dashicons-category' => esc_html__('category', 'clever-mega-menu')),
            array('dashicons dashicons-archive' => esc_html__('archive', 'clever-mega-menu')),
            array('dashicons dashicons-tagcloud' => esc_html__('tagcloud', 'clever-mega-menu')),
            array('dashicons dashicons-text' => esc_html__('text', 'clever-mega-menu')),
            array('dashicons dashicons-yes' => esc_html__('yes', 'clever-mega-menu')),
            array('dashicons dashicons-no' => esc_html__('no', 'clever-mega-menu')),
            array('dashicons dashicons-no-alt' => esc_html__('no-alt', 'clever-mega-menu')),
            array('dashicons dashicons-plus' => esc_html__('plus', 'clever-mega-menu')),
            array('dashicons dashicons-plus-alt' => esc_html__('plus-alt', 'clever-mega-menu')),
            array('dashicons dashicons-plus-alt' => esc_html__('plus-alt', 'clever-mega-menu')),
            array('dashicons dashicons-minus' => esc_html__('minus', 'clever-mega-menu')),
            array('dashicons dashicons-dismiss' => esc_html__('dismiss', 'clever-mega-menu')),
            array('dashicons dashicons-marker' => esc_html__('marker', 'clever-mega-menu')),
            array('dashicons dashicons-star-filled' => esc_html__('star-filled', 'clever-mega-menu')),
            array('dashicons dashicons-star-half' => esc_html__('star-half', 'clever-mega-menu')),
            array('dashicons dashicons-star-empty' => esc_html__('star-empty', 'clever-mega-menu')),
            array('dashicons dashicons-flag' => esc_html__('flag', 'clever-mega-menu')),
            array('dashicons dashicons-warning' => esc_html__('warning', 'clever-mega-menu')),
            array('dashicons dashicons-location' => esc_html__('location', 'clever-mega-menu')),
            array('dashicons dashicons-location-alt' => esc_html__('location-alt', 'clever-mega-menu')),
            array('dashicons dashicons-vault' => esc_html__('vault', 'clever-mega-menu')),
            array('dashicons dashicons-shield' => esc_html__('shield', 'clever-mega-menu')),
            array('dashicons dashicons-shield-alt' => esc_html__('shield-alt', 'clever-mega-menu')),
            array('dashicons dashicons-sos' => esc_html__('sos', 'clever-mega-menu')),
            array('dashicons dashicons-search' => esc_html__('search', 'clever-mega-menu')),
            array('dashicons dashicons-slides' => esc_html__('slides', 'clever-mega-menu')),
            array('dashicons dashicons-analytics' => esc_html__('analytics', 'clever-mega-menu')),
            array('dashicons dashicons-chart-pie' => esc_html__('chart-pie', 'clever-mega-menu')),
            array('dashicons dashicons-chart-bar' => esc_html__('chart-bar', 'clever-mega-menu')),
            array('dashicons dashicons-chart-line' => esc_html__('chart-line', 'clever-mega-menu')),
            array('dashicons dashicons-chart-area' => esc_html__('chart-area', 'clever-mega-menu')),
            array('dashicons dashicons-groups' => esc_html__('groups', 'clever-mega-menu')),
            array('dashicons dashicons-businessman' => esc_html__('businessman', 'clever-mega-menu')),
            array('dashicons dashicons-id' => esc_html__('id card', 'clever-mega-menu')),
            array('dashicons dashicons-id-alt' => esc_html__('id card-alt', 'clever-mega-menu')),
            array('dashicons dashicons-awards' => esc_html__('awards', 'clever-mega-menu')),
            array('dashicons dashicons-forms' => esc_html__('forms', 'clever-mega-menu')),
            array('dashicons dashicons-portfolio' => esc_html__('portfolio', 'clever-mega-menu')),
            array('dashicons dashicons-book' => esc_html__('book', 'clever-mega-menu')),
            array('dashicons dashicons-book-alt' => esc_html__('book-alt', 'clever-mega-menu')),
            array('dashicons dashicons-download' => esc_html__('download', 'clever-mega-menu')),
            array('dashicons dashicons-upload' => esc_html__('upload', 'clever-mega-menu')),
            array('dashicons dashicons-backup' => esc_html__('backup', 'clever-mega-menu')),
            array('dashicons dashicons-clock' => esc_html__('clock', 'clever-mega-menu')),
            array('dashicons dashicons-lightbulb' => esc_html__('lightbulb', 'clever-mega-menu')),
            array('dashicons dashicons-microphone' => esc_html__('microphone', 'clever-mega-menu')),
            array('dashicons dashicons-desktop' => esc_html__('desktop', 'clever-mega-menu')),
            array('dashicons dashicons-laptop' => esc_html__('laptop', 'clever-mega-menu')),
            array('dashicons dashicons-tablet' => esc_html__('tablet', 'clever-mega-menu')),
            array('dashicons dashicons-smartphone' => esc_html__('smartphone', 'clever-mega-menu')),
            array('dashicons dashicons-phone' => esc_html__('phone', 'clever-mega-menu')),
            array('dashicons dashicons-index-card' => esc_html__('index-card', 'clever-mega-menu')),
            array('dashicons dashicons-carrot' => esc_html__('carrot', 'clever-mega-menu')),
            array('dashicons dashicons-building' => esc_html__('building', 'clever-mega-menu')),
            array('dashicons dashicons-store' => esc_html__('store', 'clever-mega-menu')),
            array('dashicons dashicons-album' => esc_html__('album', 'clever-mega-menu')),
            array('dashicons dashicons-palmtree' => esc_html__('palmtree', 'clever-mega-menu')),
            array('dashicons dashicons-tickets-alt' => esc_html__('tickets-alt', 'clever-mega-menu')),
            array('dashicons dashicons-money' => esc_html__('money', 'clever-mega-menu')),
            array('dashicons dashicons-thumbs-up' => esc_html__('thumbs-up', 'clever-mega-menu')),
            array('dashicons dashicons-thumbs-down' => esc_html__('thumbs-down', 'clever-mega-menu')),
            array('dashicons dashicons-layout' => esc_html__('layout', 'clever-mega-menu')),
            array('dashicons dashicons-paperclip' => esc_html__('paperclip', 'clever-mega-menu')),
        );
        $i = 0;
        ?><div class="clever-mega-menu-icons-tabs">
            <a class="clever-mega-menu-icons-tab active" href="#" data-tab="clever-mega-menu-dashicons-icons"><?php esc_html_e('Dashicons', 'clever-mega-menu'); ?></a>
            <a class="clever-mega-menu-icons-tab" href="#" data-tab="clever-mega-menu-clever-font-icons"><?php esc_html_e('Clever Font', 'clever-mega-menu'); ?></a>
            <a class="clever-mega-menu-icons-tab" href="#" data-tab="clever-mega-menu-font-awesome-icons"><?php esc_html_e('Font Awesome', 'clever-mega-menu'); ?></a>
        </div>
        <div id="clever-mega-menu-dashicons-icons" class="clever-mega-menu-icons-tab-content"><?php
            foreach ($dashicons as $k => $icons) :
                foreach ($icons as $k2 => $icons2) :
                    ?><span class="fip-box lv-2" data-icon-type="dashicons" data-value="<?php echo esc_attr($k2); ?>" title="<?php echo esc_attr($icons2); ?>"><i class="<?php echo esc_attr($k2); ?>"></i></span><?php
                endforeach;
            endforeach;
        ?></div>
        <div id="clever-mega-menu-clever-font-icons" class="clever-mega-menu-icons-tab-content">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_html_e('Clever Front is available in Clever Mega Menu Pro only.', 'clever-mega-menu') ?> <a href="http://wpplugin.zootemplate.com/clevermegamenu/"><?php esc_html_e('Upgrade to Pro version now.', 'clever-mega-menu') ?></a></p>
        </div>
        <div id="clever-mega-menu-font-awesome-icons" class="clever-mega-menu-icons-tab-content">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_html_e('Font Awesome is available in Clever Mega Menu Pro only.', 'clever-mega-menu') ?> <a href="http://wpplugin.zootemplate.com/clevermegamenu/"><?php esc_html_e('Upgrade to Pro version now.', 'clever-mega-menu') ?></a></p>
        </div><?php

        $html = ob_get_clean();

        return $html;
    }

    /**
     * Sanitize metadata
     */
    private function sanitize($data)
    {
        $settings = array();

        $settings['hide_title'] = !empty($data['hide_title']) ? $data['hide_title'] : '0';
        $settings['disable_link'] = !empty($data['disable_link']) ? $data['disable_link'] : '0';
        $settings['hide_on_mobile'] = !empty($data['hide_on_mobile']) ? $data['hide_on_mobile'] : '0';
        $settings['hide_on_desktop'] = !empty($data['hide_on_desktop']) ? $data['hide_on_desktop'] : '0';
        $settings['hide_sub_item_on_mobile'] = !empty($data['hide_sub_item_on_mobile']) ? $data['hide_sub_item_on_mobile'] : '0';
        $settings['layout'] = !empty($data['layout']) ? $data['layout'] : 'full';
        $settings['width'] = !empty($data['width']) ? intval($data['width']) : '';
        $settings['icon'] = !empty($data['icon']) ? $data['icon'] : '';
        $settings['enable'] = !empty($data['enable']) ? $data['enable'] : '0';

        return $settings;
    }

    /**
	 * Parse shortcodes custom css string.
	 *
	 * This function is used by self::buildShortcodesCustomCss and creates css string from shortcodes attributes
	 * like 'css_editor'.
	 *
	 * @see    WPBakeryVisualComposerCssEditor
	 * @since  4.2
	 * @access public
	 *
	 * @param $content
	 *
	 * @return string
	 */
    private function parse_shortcodes_css($content)
    {
        $css = '';

		if (!preg_match('/\s*(\.[^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $content)) {
			return $css;
        }

		WPBMap::addAllMappedShortcodes();

		preg_match_all('/' . get_shortcode_regex() . '/', $content, $shortcodes);

		foreach ($shortcodes[2] as $index => $tag) {
			$shortcode = WPBMap::getShortCode($tag);
			$attr_array = shortcode_parse_atts(trim($shortcodes[3][$index]));
			if (isset($shortcode['params']) && ! empty($shortcode['params'])) {
				foreach ($shortcode['params'] as $param) {
					if (isset($param['type']) && 'css_editor' === $param['type'] && isset($attr_array[$param['param_name']])) {
						$css .= $attr_array[$param['param_name']];
					}
				}
			}
		}

		foreach ($shortcodes[5] as $shortcode_content) {
			$css .= $this->parse_shortcodes_css($shortcode_content);
		}

		return $css;
    }
}
