<?php
/**
 * Clever_Mega_Menu_Dashboard
 *
 * @package    Clever_Mega_Menu
 */
final class Clever_Mega_Menu_Dashboard
{
    /**
     * Hook suffix
     *
     * @var    string
     *
     * @see    https://developer.wordpress.org/reference/functions/add_submenu_page/
     */
    public $hook_suffix;

    /**
     * Settings
     *
     * @var    array
     *
     * @see    Clever_Mega_Menu::$settings
     */
    private $settings;

    /**
     * Constructor
     */
    function __construct($settings)
    {
        $this->settings = $settings;
    }

    /**
     * Add menu page
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/hooks/admin_menu/
     */
    function _add($context)
    {
        $this->hook_suffix = add_menu_page(
            esc_html__('Clever Mega Menu', 'clever-mega-menu'),
            esc_html__('Mega Menu', 'clever-mega-menu'),
            'manage_options',
            basename(__FILE__),
            array($this, '_render'),
            $this->settings['baseuri'] . 'assets/backend/images/clever-mega-menu-icon-16x16.png'
        );
    }

    /**
     * Render
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _render()
    {
        wp_enqueue_script('dashboard');

        ?><div class="wrap clever-mega-menu-admin">
            <div id="welcome-panel" class="welcome-panel">
            <a class="welcome-panel-close" href="#" aria-label="Dismiss the welcome panel"><?php esc_html_e('Dismiss') ?></a>
			<div class="welcome-panel-content">
                <h2 class="welcome-page-title"><?php esc_html_e('Welcome to Clever Mega Menu!', 'clever-mega-menu') ?></h2>
                <p class="description"><?php esc_html_e('Thank you for using Clever Mega Menu, here&#8217;re some resources to help you get started quickly', 'clever-mega-menu') ?>:</p>
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h3><?php esc_html_e('First Steps', 'clever-mega-menu') ?></h3>
                        <a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo admin_url('nav-menus.php?action=edit&menu=0') ?>"><?php esc_html_e('Create a Navigation Menu', 'clever-mega-menu') ?></a>
                    </div>
                    <div class="welcome-panel-column">
                        <h3><?php esc_html_e('Next Steps') ?></h3>
                        <ul>
                            <li><i class="dashicons dashicons-welcome-add-page"></i> <a href="<?php echo admin_url('post-new.php?post_type=clever_menu_theme') ?>"><?php esc_html_e('Create a menu theme', 'clever-mega-menu') ?></a></li>
                            <li><i class="dashicons dashicons-edit"></i> <a href="<?php echo admin_url('nav-menus.php?action=locations') ?>"><?php esc_html_e('Edit a navigation menu', 'clever-mega-menu') ?></a></li>
                        </ul>
                    </div>
                    <div class="welcome-panel-column welcome-panel-last">
                        <h3><?php esc_html_e('More Steps', 'clever-mega-menu') ?></h3>
                        <ul>
                            <li><i class="dashicons dashicons-welcome-learn-more"></i> <a target="_blank" href="http://doc.zootemplate.com/clevermegamenu/"><?php esc_html_e('Learn more about getting started') ?></a></li>
                            <li><i class="dashicons dashicons-universal-access"></i> <a target="_blank" href="http://wpplugin.zootemplate.com/clevermegamenu/"><?php esc_html_e('Upgrade to Clever Menu Menu Pro', 'clever-mega-menu') ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="dashboard-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder">
            	<div id="postbox-container-1" class="postbox-container">
                	<div id="normal-sortables" class="meta-box-sortables">
                        <div class="postbox">
                            <button type="button" class="handlediv button-link" aria-expanded="true"><span class="screen-reader-text"><?php esc_html_e('Toggle panel: At a Glance') ?></span><span class="toggle-indicator" aria-hidden="true"></span></button><h2 class='hndle'><span><?php esc_html_e('At a Glance') ?></span></h2>
                            <div class="inside">
                                <div class="main">
                                    <?php
                                        $themes_count = wp_count_posts('clever_menu_theme');
                                        $theme_text = ($themes_count->publish > 1) ? esc_html__('Menu Themes', 'clever-mega-menu') : esc_html__('Menu Theme', 'clever-mega-menu');
                                    ?>
                                    <ul>
                                        <li><i class="dashicons dashicons-admin-appearance"></i> <a href="<?php echo admin_url('edit.php?post_type=clever_menu_theme') ?>"><?php echo $themes_count->publish . ' ' . esc_html__('Published', 'clever-mega-menu') . ' ' . $theme_text ?></a></li>
                                    </ul>
                                    <p><span id="wp-version"><?php echo sprintf(esc_html__('WordPress %s running'), $GLOBALS['wp_version']) ?> <strong>Clever Mega Menu</strong> <?php echo Clever_Mega_Menu::VERSION ?>, <strong>Visual Composer</strong> <?php echo WPB_VC_VERSION ?>.</span></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div><?php
    }
}
