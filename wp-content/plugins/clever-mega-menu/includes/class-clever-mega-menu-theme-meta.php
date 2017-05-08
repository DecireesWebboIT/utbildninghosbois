<?php
/**
 * Clever_Mega_Menu_Theme_Meta
 *
 * @package    Clever_Mega_Menu
 */
final class Clever_Mega_Menu_Theme_Meta
{
    /**
     * Meta key
     *
     * @var    string
     */
    const META_KEY = '_clever_mega_menu_theme_meta';

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
        'general_css_output'                    => 'sitehead',
        'general_effect'                        => 'fade-in-up',
        'general_font_size'                     => '13px',
        'general_font_weight'                   => '400',
        'general_line_height'                   => '1.6',
        'general_text_trasform'                 => 'none',
        'general_z_index'                       => '999',
        'general_text_color'                    => '#636363',
        'general_link_color'                    => '#636363',
        'general_link_hover_color'              => '#f26522',
        'general_arrow_up'                      => 'dashicons dashicons-arrow-up',
        'general_arrow_down'                    => 'dashicons dashicons-arrow-down',
        'general_arrow_left'                    => 'dashicons dashicons-arrow-left',
        'general_arrow_right'                   => 'dashicons dashicons-arrow-right',
        'menubar_horizontal_layout'             => 'horizontal-align-left',
        'menubar_menu_height'                   => '50px',
        'menubar_margin_top'                    => '0px',
        'menubar_margin_right'                  => '0px',
        'menubar_margin_bottom'                 => '0px',
        'menubar_margin_left'                   => '0px',
        'menubar_padding_top'                   => '0px',
        'menubar_padding_right'                 => '0px',
        'menubar_padding_bottom'                => '0px',
        'menubar_padding_left'                  => '0px',
        'menubar_border_color'                  => 'rgba(255,255,255,0.1)',
        'menubar_border_top'                    => '0px',
        'menubar_border_right'                  => '0px',
        'menubar_border_bottom'                 => '0px',
        'menubar_border_left'                   => '0px',
        'menubar_border_style'                  => 'solid',
        'menubar_border_radius_top_left'        => '0px',
        'menubar_border_radius_top_right'       => '0px',
        'menubar_border_radius_bottom_right'    => '0px',
        'menubar_border_radius_bottom_left'     => '0px',
        'menubar_background_from_color'         => '#222',
        'menubar_background_to_color'           => '#222',
        'menubar_item_text_color'               => '#fff',
        'menubar_item_text_hover_color'         => '#f26522',
        'menubar_item_text_font_size'           => '14px',
        'menubar_item_text_font_weight'         => '600',
        'menubar_item_text_line_height'         => '3',
        'menubar_item_text_transform'           => 'uppercase',
        'menubar_item_background_color'         => 'rgba(0,0,0,0)',
        'menubar_item_background_hover_color'   => 'rgba(0,0,0,0)',
        'menubar_item_background_active_color'  => 'rgba(0,0,0,0)',
        'menubar_item_padding_top'              => '0px',
        'menubar_item_padding_right'            => '20px',
        'menubar_item_padding_bottom'           => '0px',
        'menubar_item_padding_left'             => '20px',
        'menubar_item_margin_top'               => '0px',
        'menubar_item_margin_right'             => '0px',
        'menubar_item_margin_bottom'            => '0px',
        'menubar_item_margin_left'              => '0px',
        'menubar_item_border_color'             => 'rgba(255,255,255,0.1)',
        'menubar_item_border_top'               => '0px',
        'menubar_item_border_right'             => '0px',
        'menubar_item_border_bottom'            => '0px',
        'menubar_item_border_left'              => '0px',
        'menubar_item_border_style'             => 'solid',
        'menubar_item_border_hover_color'       => 'rgba(255,255,255,0.1)',
        'menubar_item_border_hover_style'       => 'solid',
        'menubar_item_border_last_child'        => '1',
        'mega_panel_css_selector'               => '.cmm',
        'mega_panel_background_from_color'      => '#fff',
        'mega_panel_background_to_color'        => '#fff',
        'mega_panel_padding_top'                => '20px',
        'mega_panel_padding_right'              => '20px',
        'mega_panel_padding_bottom'             => '20px',
        'mega_panel_padding_left'               => '20px',
        'mega_panel_border_color'          => 'rgba(255,255,255,0.1)',
        'mega_panel_border_top'            => '0px',
        'mega_panel_border_right'          => '0px',
        'mega_panel_border_bottom'         => '0px',
        'mega_panel_border_left'           => '0px',
        'mega_panel_border_style'          => 'solid',
        'mega_panel_border_radius_top_left'     => '0px',
        'mega_panel_border_radius_top_right'    => '0px',
        'mega_panel_border_radius_bottom_right' => '0px',
        'mega_panel_border_radius_bottom_left'  => '0px',
        'mega_menu_h_shadow'                    => '0px',
        'mega_menu_v_shadow'                    => '0px',
        'mega_menu_blur_shadow'                 => '12px',
        'mega_menu_spread_shadow'               => '0px',
        'mega_menu_color_shadow'                => 'rgba(0, 0, 0, 0.3)',
        'mega_panel_heading_font_size'          => '15px',
        'mega_panel_heading_font_weight'        => '600',
        'mega_panel_heading_color'              => '#252525',
        'mega_panel_heading_style'              => 'uppercase',
        'mega_panel_heading_margin_top'         => '0px',
        'mega_panel_heading_margin_right'       => '0px',
        'mega_panel_heading_margin_bottom'      => '20px',
        'mega_panel_heading_margin_left'        => '0px',
        'mega_panel_heading_padding_top'        => '0px',
        'mega_panel_heading_padding_right'      => '0px',
        'mega_panel_heading_padding_bottom'     => '0px',
        'mega_panel_heading_padding_left'       => '0px',
        'mega_panel_heading_border_color'               => 'rgba(255,255,255,0.1)',
        'mega_panel_heading_border_top'                 => '0px',
        'mega_panel_heading_border_right'               => '0px',
        'mega_panel_heading_border_bottom'              => '0px',
        'mega_panel_heading_border_left'                => '0px',
        'mega_panel_heading_border_style'               => 'solid',
        'mega_panel_heading_border_radius_top_left'     => '0px',
        'mega_panel_heading_border_radius_top_right'    => '0px',
        'mega_panel_heading_border_radius_bottom_right' => '0px',
        'mega_panel_heading_border_radius_bottom_left'  => '0px',
        'mega_panel_heading_background_from_color'  => '#fff',
        'mega_panel_heading_background_to_color'    => '#fff',
        'mega_panel_item_color'                 => '#636363',
        'mega_panel_item_hover_color'           => '#f26522',
        'mega_panel_item_background_color'      => '#fff',
        'mega_panel_item_background_hover_color'=> '#fff',
        'mega_panel_item_padding_top'           => '8px',
        'mega_panel_item_padding_right'         => '0px',
        'mega_panel_item_padding_bottom'        => '8px',
        'mega_panel_item_padding_left'          => '0px',
        'mega_panel_item_border_color'          => 'rgba(255,255,255,0.1)',
        'mega_panel_item_border_top'            => '0px',
        'mega_panel_item_border_right'          => '0px',
        'mega_panel_item_border_bottom'         => '0px',
        'mega_panel_item_border_left'           => '0px',
        'mega_panel_item_border_style'          => 'solid',
        'mega_panel_item_border_hover_color'    => 'rgba(255,255,255,0.1)',
        'mega_panel_item_border_hover_style'    => 'solid',
        'mega_panel_item_border_last_child'     => '1',
        'mega_panel_second_background_from_color'       => '#fff',
        'mega_panel_second_background_to_color'         => '#fff',
        'mega_panel_second_padding_top'                 => '0px',
        'mega_panel_second_padding_right'               => '0px',
        'mega_panel_second_padding_bottom'              => '0px',
        'mega_panel_second_padding_left'                => '0px',
        'mega_panel_second_border_color'                => 'rgba(255,255,255,0.1)',
        'mega_panel_second_border_top'                  => '0px',
        'mega_panel_second_border_right'                => '0px',
        'mega_panel_second_border_bottom'               => '0px',
        'mega_panel_second_border_left'                 => '0px',
        'mega_panel_second_border_style'                => 'solid',
        'mega_panel_second_border_radius_top_left'      => '0px',
        'mega_panel_second_border_radius_top_right'     => '0px',
        'mega_panel_second_border_radius_bottom_right'  => '0px',
        'mega_panel_second_border_radius_bottom_left'   => '0px',
        'mega_panel_second_menu_h_shadow'               => '0px',
        'mega_panel_second_menu_v_shadow'               => '0px',
        'mega_panel_second_menu_blur_shadow'            => '12px',
        'mega_panel_second_menu_spread_shadow'          => '0px',
        'mega_panel_second_menu_color_shadow'           => 'rgba(0, 0, 0, 0.3)',
        'mega_panel_second_item_color'                  => '#636363',
        'mega_panel_second_item_hover_color'            => '#f26522',
        'mega_panel_second_item_background_color'       => '#fff',
        'mega_panel_second_item_background_hover_color' => '#fff',
        'mega_panel_second_item_padding_top'            => '8px',
        'mega_panel_second_item_padding_right'          => '15px',
        'mega_panel_second_item_padding_bottom'         => '8px',
        'mega_panel_second_item_padding_left'           => '15px',
        'mega_panel_second_item_border_color'           => 'rgba(255,255,255,0.1)',
        'mega_panel_second_item_border_top'             => '0px',
        'mega_panel_second_item_border_right'           => '0px',
        'mega_panel_second_item_border_bottom'          => '0px',
        'mega_panel_second_item_border_left'            => '0px',
        'mega_panel_second_item_border_style'           => 'solid',
        'mega_panel_second_item_border_hover_color'     => 'rgba(255,255,255,0.1)',
        'mega_panel_second_item_border_hover_style'     => 'solid',
        'mega_panel_second_item_border_last_child'      => '1',
        'flyout_width'                          => '200px',
        'flyout_background_from_color'          => '#fff',
        'flyout_background_to_color'            => '#fff',
        'flyout_padding_top'                    => '5px',
        'flyout_padding_right'                  => '0px',
        'flyout_padding_bottom'                 => '5px',
        'flyout_padding_left'                   => '0px',
        'flyout_border_color'                   => 'rgba(255,255,255,0.1)',
        'flyout_border_top'                     => '0px',
        'flyout_border_right'                   => '0px',
        'flyout_border_bottom'                  => '0px',
        'flyout_border_left'                    => '0px',
        'flyout_border_style'                   => 'solid',
        'flyout_border_radius_top_left'         => '0px',
        'flyout_border_radius_top_right'        => '0px',
        'flyout_border_radius_bottom_right'     => '0px',
        'flyout_border_radius_bottom_left'      => '0px',
        'flyout_menu_h_shadow'                  => '0px',
        'flyout_menu_v_shadow'                  => '0px',
        'flyout_menu_blur_shadow'               => '12px',
        'flyout_menu_spread_shadow'             => '0px',
        'flyout_menu_color_shadow'              => 'rgba(0, 0, 0, 0.3)',
        'flyout_item_color'                     => '#636363',
        'flyout_item_hover_color'               => '#f26522',
        'flyout_item_background_color'          => 'rgba(255, 255, 255, 0)',
        'flyout_item_background_hover_color'    => 'rgba(255, 255, 255, 0)',
        'flyout_item_padding_top'               => '5px',
        'flyout_item_padding_right'             => '20px',
        'flyout_item_padding_bottom'            => '5px',
        'flyout_item_padding_left'              => '20px',
        'flyout_item_border_color'              => 'rgba(255,255,255,0.1)',
        'flyout_item_border_top'                => '0px',
        'flyout_item_border_right'              => '0px',
        'flyout_item_border_bottom'             => '0px',
        'flyout_item_border_left'               => '0px',
        'flyout_item_border_style'              => 'solid',
        'flyout_item_border_hover_color'        => 'rgba(255,255,255,0.1)',
        'flyout_item_border_hover_style'        => 'solid',
        'flyout_item_border_last_child'         => '1',
        'mobile_menu_disable_toggle'            => '0',
        'mobile_menu_toggle_button_wrapper'     => '.cmm-container',
        'mobile_menu_open_icon'                 => 'dashicons dashicons-menu',
        'mobile_menu_close_icon'                => 'dashicons dashicons-no-alt',
        'mobile_menu_responsive_breakpoint'     => '992',
        'mobile_menu_item_color'                => 'rgba(255, 255, 255, 0.6)',
        'mobile_menu_item_hover_color'          => '#fff',
        'mobile_menu_background_from_color'     => '#1f1f1f',
        'mobile_menu_background_to_color'       => '#1f1f1f',
        'mobile_menu_item_border_color'         => 'rgba(255, 255, 255, 0.2)',
        'mobile_menu_item_border_style'         => 'dotted',
        'custom_css'                            => '',
        'custom_js'                             => ''
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

        $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;

        $this->values = (array)get_post_meta($post_id, self::META_KEY, true);
    }

    /**
     * Add theme meta boxes
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _add(\WP_Post $post)
    {
        add_meta_box(
            'clever-mega-menu-theme-metabox',
            esc_html__('Menu Theme Options', 'clever-mega-menu'),
            array($this, '_render'),
            'clever_menu_theme',
            'normal',
            'high'
        );
    }

    /**
     * Add general meta box
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _render()
    {
        ?><ul class="tabs nav-tab-wrapper wp-clearfix">
            <li class="nav-tab tab-active" data-tab-id="#cmm-general-options">
                <?php esc_html_e('General', 'clever-mega-menu') ?>
            </li>
            <li class="nav-tab" data-tab-id="#cmm-menu-bar-options">
                <?php esc_html_e('Menu Bar', 'clever-mega-menu') ?>
            </li>
            <li class="nav-tab" data-tab-id="#cmm-flyout-options">
                <?php esc_html_e('Flyout Menu', 'clever-mega-menu') ?>
            </li>
            <li class="nav-tab" data-tab-id="#cmm-mega-options">
                <?php esc_html_e('Mega Menu', 'clever-mega-menu') ?>
            </li>
            <li class="nav-tab" data-tab-id="#cmm-mobile-options">
                <?php esc_html_e('Mobile Menu', 'clever-mega-menu') ?>
            </li>
            <li class="nav-tab" data-tab-id="#cmm-custom-options">
                <?php esc_html_e('Custom', 'clever-mega-menu') ?>
            </li>
        </ul>
        <table id="cmm-general-options" class="form-table clever-mega-menu-admin clever-mega-menu-theme-metabox">
            <tr>
                <td class="row-label"><?php esc_html_e('Link', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('general_link_color') ?>" value="<?php echo $this->get_value('general_link_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('general_link_hover_color') ?>" value="<?php echo $this->get_value('general_link_hover_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Text', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('general_text_color') ?>" value="<?php echo $this->get_value('general_text_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Font Size', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('general_font_size') ?>" value="<?php echo $this->get_value('general_font_size') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Font Weight', 'clever-mega-menu') ?></p>
                        <?php
                            $selected = $this->get_value('general_font_weight');
                            $font_weights = array(100, 200, 300, 400, 500, 600, 700, 800, 900);
                        ?>
                        <select name="<?php echo $this->get_field('general_font_weight') ?>">
                            <?php foreach ($font_weights as $weight) : ?>
                                <option value="<?php echo $weight ?>" <?php selected($selected, $weight) ?>><?php echo $weight ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Line Height', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('general_line_height') ?>" value="<?php echo $this->get_value('general_line_height') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Text Transform', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('general_text_trasform') ?>
                        <select name="<?php echo $this->get_field('general_text_trasform') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="lowercase" <?php selected($selected, 'lowercase') ?>><?php esc_html_e('Lowercase', 'clever-mega-menu') ?></option>
                            <option value="capitalize" <?php selected($selected, 'capitalize') ?>><?php esc_html_e('Capitalize', 'clever-mega-menu') ?></option>
                            <option value="uppercase" <?php selected($selected, 'uppercase') ?>><?php esc_html_e('Uppercase', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Z Index', 'clever-mega-menu') ?></td>
                <td>
                    <input type="number" class="inline" name="<?php echo $this->get_field('general_z_index') ?>" value="<?php echo $this->get_value('general_z_index') ?>">
                    <p class="description"><?php esc_html_e('Set a high number to ensure the menu bar will be displayed on the top of other contents.', 'clever-mega-menu') ?></p>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Arrow Icons', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Up', 'clever-mega-menu') ?></p>
                        <span class="clever-mega-menu-icon <?php echo $this->get_value('general_arrow_up') ?>"></span>
                        <div class="clever-mega-menu-icons clever-arrow-up-icons" style="display:none">
                            <div>
                                <span class="dashicons none">&nbsp;</span>
                                <span class="dashicons dashicons-arrow-up"></span>
                                <span class="dashicons dashicons-arrow-up-alt2"></span>
                                <span class="dashicons dashicons-arrow-up-alt"></span>
                            </div>
                        </div>
                        <input type="hidden" name="<?php echo $this->get_field('general_arrow_up') ?>" value="<?php echo $this->get_value('general_arrow_up') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Down', 'clever-mega-menu') ?></p>
                        <span class="clever-mega-menu-icon <?php echo $this->get_value('general_arrow_down') ?>"></span>
                        <div class="clever-mega-menu-icons clever-arrow-down-icons" style="display:none">
                            <div>
                                <span class="dashicons none">&nbsp;</span>
                                <span class="dashicons dashicons-arrow-down"></span>
                                <span class="dashicons dashicons-arrow-down-alt2"></span>
                                <span class="dashicons dashicons-arrow-down-alt"></span>
                            </div>
                        </div>
                        <input type="hidden" name="<?php echo $this->get_field('general_arrow_down') ?>" value="<?php echo $this->get_value('general_arrow_down') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <span class="clever-mega-menu-icon <?php echo $this->get_value('general_arrow_left') ?>"></span>
                        <div class="clever-mega-menu-icons clever-arrow-down-icons" style="display:none">
                            <div>
                                <span class="dashicons none">&nbsp;</span>
                                <span class="dashicons dashicons-arrow-left"></span>
                                <span class="dashicons dashicons-arrow-left-alt2"></span>
                                <span class="dashicons dashicons-arrow-left-alt"></span>
                            </div>
                        </div>
                        <input type="hidden" name="<?php echo $this->get_field('general_arrow_left') ?>" value="<?php echo $this->get_value('general_arrow_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <span class="clever-mega-menu-icon <?php echo $this->get_value('general_arrow_right') ?>"></span>
                        <div class="clever-mega-menu-icons clever-arrow-down-icons" style="display:none">
                            <div>
                                <span class="dashicons none">&nbsp;</span>
                                <span class="dashicons dashicons-arrow-right"></span>
                                <span class="dashicons dashicons-arrow-right-alt2"></span>
                                <span class="dashicons dashicons-arrow-right-alt"></span>
                            </div>
                        </div>
                        <input type="hidden" name="<?php echo $this->get_field('general_arrow_right') ?>" value="<?php echo $this->get_value('general_arrow_right') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Sub Menu Effect', 'clever-mega-menu') ?></td>
                <td>
                    <?php $selected = $this->get_value('general_effect') ?>
                    <select name="<?php echo $this->get_field('general_effect') ?>">
                        <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                        <option value="fade" <?php selected($selected, 'fade') ?>><?php esc_html_e('Fade', 'clever-mega-menu') ?></option>
                        <option value="fade-in-up" <?php selected($selected, 'fade-in-up') ?>><?php esc_html_e('Fade in Up', 'clever-mega-menu') ?></option>
                    </select>
                    <p class="description"><?php esc_html_e('Set the animation which will be used while showing sub menus.', 'clever-mega-menu') ?></p>
                </td>
            </tr>
            <tr class="last-row">
                <td class="row-label"><?php echo esc_html__('CSS Output Location', 'clever-mega-menu') ?></td>
                <td>
                    <?php $selected = $this->get_value('general_css_output') ?>
                    <select name="<?php echo $this->get_field('general_css_output') ?>">
                        <option value="filesystem" <?php selected($selected, 'filesystem') ?>><?php esc_html_e('Filesystem', 'clever-mega-menu') ?></option>
                        <option value="sitehead" <?php selected($selected, 'sitehead') ?>><?php echo esc_html('Site <head>', 'clever-mega-menu') ?></option>
                    </select>
                    <p class="description"><?php esc_html_e('The place where the compiled CSS of this menu theme will be stored.', 'clever-mega-menu') ?></p>
                </td>
            </tr>
        </table>
        <table id="cmm-menu-bar-options" class="form-table clever-mega-menu-admin clever-mega-menu-theme-metabox" style="display:none">
            <tr>
                <td class="row-label"><?php esc_html_e('Height', 'clever-mega-menu') ?></td>
                <td>
                    <input type="text" class="inline" name="<?php echo $this->get_field('menubar_menu_height') ?>" value="<?php echo $this->get_value('menubar_menu_height') ?>">
                    <p class="description"><?php esc_html_e('Set a fixed height of the horizontal menu bar or leave it empty for default value.', 'clever-mega-menu') ?></p>
                </td>
            </tr>
            <tr>
                <?php
                    $horizontal_layouts = array(
                        'horizontal-align-left',
                        'horizontal-align-center',
                        'horizontal-align-right'
                    );
                    $key = $this->get_field('menubar_horizontal_layout');
                    $val = $this->get_value('menubar_horizontal_layout');
                ?>
                <td class="row-label"><?php esc_html_e('Item Align', 'clever-mega-menu') ?></td>
                <td>
                    <?php
                        foreach ($horizontal_layouts as $layout) :
                            $layout_img = $this->settings['baseuri'] . 'assets/backend/images/layouts/' . $layout . '.jpg';
                            ?><label><input type="radio" name="<?php echo $key ?>" value="<?php echo $layout ?>" <?php checked($val, $layout) ?>><img src="<?php echo $layout_img ?>" alt="" width="150" height="18"></label><?php
                        endforeach;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Margin', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_margin_top') ?>" value="<?php echo $this->get_value('menubar_margin_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_margin_right') ?>" value="<?php echo $this->get_value('menubar_margin_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_margin_bottom') ?>" value="<?php echo $this->get_value('menubar_margin_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_margin_left') ?>" value="<?php echo $this->get_value('menubar_margin_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Padding', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_padding_top') ?>" value="<?php echo $this->get_value('menubar_padding_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_padding_right') ?>" value="<?php echo $this->get_value('menubar_padding_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_padding_bottom') ?>" value="<?php echo $this->get_value('menubar_padding_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_padding_left') ?>" value="<?php echo $this->get_value('menubar_padding_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_border_color') ?>" value="<?php echo $this->get_value('menubar_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_border_top') ?>" value="<?php echo $this->get_value('menubar_border_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_border_right') ?>" value="<?php echo $this->get_value('menubar_border_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_border_bottom') ?>" value="<?php echo $this->get_value('menubar_border_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_border_left') ?>" value="<?php echo $this->get_value('menubar_border_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('menubar_border_style') ?>
                        <select name="<?php echo $this->get_field('menubar_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Border Radius', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_border_radius_top_left') ?>" value="<?php echo $this->get_value('menubar_border_radius_top_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_border_radius_top_right') ?>" value="<?php echo $this->get_value('menubar_border_radius_top_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_border_radius_bottom_right') ?>" value="<?php echo $this->get_value('menubar_border_radius_bottom_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_border_radius_bottom_left') ?>" value="<?php echo $this->get_value('menubar_border_radius_bottom_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('From', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_background_from_color') ?>" value="<?php echo $this->get_value('menubar_background_from_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('To', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_background_to_color') ?>" value="<?php echo $this->get_value('menubar_background_to_color') ?>">
                    </label>
                </td>
            </tr>
            <tr class="heading-row">
                <th scope="row" class="heading">
                    <?php esc_html_e('Top Level Menu Items', 'clever-mega-menu') ?>
                </th>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Text', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_item_text_color') ?>" value="<?php echo $this->get_value('menubar_item_text_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_item_text_hover_color') ?>" value="<?php echo $this->get_value('menubar_item_text_hover_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Font Size', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_text_font_size') ?>" value="<?php echo $this->get_value('menubar_item_text_font_size') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Font Weight', 'clever-mega-menu') ?></p>
                        <?php
                            $selected = $this->get_value('menubar_item_text_font_weight');
                            $font_weights = array(100, 200, 300, 400, 500, 600, 700, 800, 900);
                        ?>
                        <select name="<?php echo $this->get_field('menubar_item_text_font_weight') ?>">
                            <?php foreach ($font_weights as $weight) : ?>
                                <option value="<?php echo $weight ?>" <?php selected($selected, $weight) ?>><?php echo $weight ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Line Height', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_text_line_height') ?>" value="<?php echo $this->get_value('menubar_item_text_line_height') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Text Transform', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('menubar_item_text_transform') ?>
                        <select name="<?php echo $this->get_field('menubar_item_text_transform') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="lowercase" <?php selected($selected, 'lowercase') ?>><?php esc_html_e('Lowercase', 'clever-mega-menu') ?></option>
                            <option value="capitalize" <?php selected($selected, 'capitalize') ?>><?php esc_html_e('Capitalize', 'clever-mega-menu') ?></option>
                            <option value="uppercase" <?php selected($selected, 'uppercase') ?>><?php esc_html_e('Uppercase', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_item_background_color') ?>" value="<?php echo $this->get_value('menubar_item_background_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_item_background_hover_color') ?>" value="<?php echo $this->get_value('menubar_item_background_hover_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Active Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_item_background_active_color') ?>" value="<?php echo $this->get_value('menubar_item_background_active_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Margin', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_margin_top') ?>" value="<?php echo $this->get_value('menubar_item_margin_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_margin_right') ?>" value="<?php echo $this->get_value('menubar_item_margin_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_margin_bottom') ?>" value="<?php echo $this->get_value('menubar_item_margin_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_margin_left') ?>" value="<?php echo $this->get_value('menubar_item_margin_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Padding', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_padding_top') ?>" value="<?php echo $this->get_value('menubar_item_padding_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_padding_right') ?>" value="<?php echo $this->get_value('menubar_item_padding_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_padding_bottom') ?>" value="<?php echo $this->get_value('menubar_item_padding_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_padding_left') ?>" value="<?php echo $this->get_value('menubar_item_padding_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_item_border_color') ?>" value="<?php echo $this->get_value('menubar_item_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_border_top') ?>" value="<?php echo $this->get_value('menubar_item_border_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_border_right') ?>" value="<?php echo $this->get_value('menubar_item_border_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_border_bottom') ?>" value="<?php echo $this->get_value('menubar_item_border_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('menubar_item_border_left') ?>" value="<?php echo $this->get_value('menubar_item_border_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('menubar_item_border_style') ?>
                        <select name="<?php echo $this->get_field('menubar_item_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Border Hover', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('menubar_item_border_hover_color') ?>" value="<?php echo $this->get_value('menubar_item_border_hover_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('menubar_item_border_hover_style') ?>
                        <select name="<?php echo $this->get_field('menubar_item_border_hover_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr class="last-row">
                <td class="row-label"><?php esc_html_e('Hide Last Item Border', 'clever-mega-menu') ?></td>
                <td>
                    <label><input type="checkbox" name="<?php echo $this->get_field('menubar_item_border_last_child') ?>" value="1"<?php checked($this->get_value('menubar_item_border_last_child')) ?>><span class="description"><?php esc_html_e('Whether to hide border of the last item or not.', 'clever-mega-menu') ?></span></label>
                </td>
            </tr>
        </table>
        <table id="cmm-flyout-options" class="form-table clever-mega-menu-admin clever-mega-menu-theme-metabox" style="display:none">
            <tr>
                <td class="row-label"><?php esc_html_e('Width', 'clever-mega-menu') ?></td>
                <td>
                    <input type="text" class="inline" name="<?php echo $this->get_field('flyout_width') ?>" value="<?php echo $this->get_value('flyout_width') ?>">
                    <p class="description"><?php esc_html_e('Set a fixed width of the flyout menu or leave it empty for auto width.', 'clever-mega-menu') ?></p>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Padding', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_padding_top') ?>" value="<?php echo $this->get_value('flyout_padding_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_padding_right') ?>" value="<?php echo $this->get_value('flyout_padding_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_padding_bottom') ?>" value="<?php echo $this->get_value('flyout_padding_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_padding_left') ?>" value="<?php echo $this->get_value('flyout_padding_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_border_color') ?>" value="<?php echo $this->get_value('flyout_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_border_top') ?>" value="<?php echo $this->get_value('flyout_border_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_border_right') ?>" value="<?php echo $this->get_value('flyout_border_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_border_bottom') ?>" value="<?php echo $this->get_value('flyout_border_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_border_left') ?>" value="<?php echo $this->get_value('flyout_border_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('flyout_border_style') ?>
                        <select name="<?php echo $this->get_field('flyout_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Border Radius', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_border_radius_top_left') ?>" value="<?php echo $this->get_value('flyout_border_radius_top_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_border_radius_top_right') ?>" value="<?php echo $this->get_value('flyout_border_radius_top_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_border_radius_bottom_right') ?>" value="<?php echo $this->get_value('flyout_border_radius_bottom_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_border_radius_bottom_left') ?>" value="<?php echo $this->get_value('flyout_border_radius_bottom_left') ?>">
                    </label>
                </td>
            </tr>
            <tr class="clever-mega-menu-box-shadow-field">
                <td class="row-label"><?php esc_html_e('Box Shadow', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Horizontal', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_menu_h_shadow') ?>" value="<?php echo $this->get_value('flyout_menu_h_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Vertical', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_menu_v_shadow') ?>" value="<?php echo $this->get_value('flyout_menu_v_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Blur', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_menu_blur_shadow') ?>" value="<?php echo $this->get_value('flyout_menu_blur_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Spread', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_menu_spread_shadow') ?>" value="<?php echo $this->get_value('flyout_menu_spread_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_menu_color_shadow') ?>" value="<?php echo $this->get_value('flyout_menu_color_shadow') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('From', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_background_from_color') ?>" value="<?php echo $this->get_value('flyout_background_from_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('To', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_background_to_color') ?>" value="<?php echo $this->get_value('flyout_background_to_color') ?>">
                    </label>
                </td>
            </tr>
            <tr class="heading-row">
                <th scope="row" class="heading"><?php esc_html_e('Sub Menu Items', 'clever-mega-menu') ?></th>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_item_color') ?>" value="<?php echo $this->get_value('flyout_item_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_item_hover_color') ?>" value="<?php echo $this->get_value('flyout_item_hover_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_item_background_color') ?>" value="<?php echo $this->get_value('flyout_item_background_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_item_background_hover_color') ?>" value="<?php echo $this->get_value('flyout_item_background_hover_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Padding', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_item_padding_top') ?>" value="<?php echo $this->get_value('flyout_item_padding_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_item_padding_right') ?>" value="<?php echo $this->get_value('flyout_item_padding_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_item_padding_bottom') ?>" value="<?php echo $this->get_value('flyout_item_padding_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_item_padding_left') ?>" value="<?php echo $this->get_value('flyout_item_padding_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_item_border_color') ?>" value="<?php echo $this->get_value('flyout_item_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_item_border_top') ?>" value="<?php echo $this->get_value('flyout_item_border_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_item_border_right') ?>" value="<?php echo $this->get_value('flyout_item_border_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_item_border_bottom') ?>" value="<?php echo $this->get_value('flyout_item_border_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('flyout_item_border_left') ?>" value="<?php echo $this->get_value('flyout_item_border_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('flyout_item_border_style') ?>
                        <select name="<?php echo $this->get_field('flyout_item_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Border Hover', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('flyout_item_border_hover_color') ?>" value="<?php echo $this->get_value('flyout_item_border_hover_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('flyout_item_border_hover_style') ?>
                        <select name="<?php echo $this->get_field('flyout_item_border_hover_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr class="last-row">
                <td class="row-label"><?php esc_html_e('Hide Last Item Border', 'clever-mega-menu') ?></td>
                <td>
                    <label><input type="checkbox" name="<?php echo $this->get_field('flyout_item_border_last_child') ?>" value="1"<?php checked($this->get_value('flyout_item_border_last_child')) ?>><span class="description"><?php esc_html_e('Whether to hide border of the last item or not.', 'clever-mega-menu') ?></span></label>
                </td>
            </tr>
        </table>
        <table id="cmm-mega-options" class="form-table clever-mega-menu-admin clever-mega-menu-theme-metabox" style="display:none">
            <tr>
                <td class="row-label"> <?php esc_html_e('Panel Width Selector', 'clever-mega-menu') ?></td>
                <td>
                    <input type="text" name="<?php echo $this->get_field('mega_panel_css_selector') ?>" value="<?php echo $this->get_value('mega_panel_css_selector') ?>">
                    <p class="description"><?php esc_html_e('Enter a CSS class or id selector of a parent element to synchronize the width and position of mega panels with that element (e.g. `body`, `.main-navigation`). Default is `.cmm`.', 'clever-mega-menu') ?></p>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Panel Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('From', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_background_from_color') ?>" value="<?php echo $this->get_value('mega_panel_background_from_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('To', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_background_to_color') ?>" value="<?php echo $this->get_value('mega_panel_background_to_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Panel Padding', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_padding_top') ?>" value="<?php echo $this->get_value('mega_panel_padding_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_padding_right') ?>" value="<?php echo $this->get_value('mega_panel_padding_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_padding_bottom') ?>" value="<?php echo $this->get_value('mega_panel_padding_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_padding_left') ?>" value="<?php echo $this->get_value('mega_panel_padding_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Panel Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_border_color') ?>" value="<?php echo $this->get_value('mega_panel_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_border_top') ?>" value="<?php echo $this->get_value('mega_panel_border_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_border_right') ?>" value="<?php echo $this->get_value('mega_panel_border_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_border_bottom') ?>" value="<?php echo $this->get_value('mega_panel_border_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_border_left') ?>" value="<?php echo $this->get_value('mega_panel_border_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('mega_panel_border_style') ?>
                        <select name="<?php echo $this->get_field('mega_panel_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Panel Border Radius', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_border_radius_top_left') ?>" value="<?php echo $this->get_value('mega_panel_border_radius_top_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_border_radius_top_right') ?>" value="<?php echo $this->get_value('mega_panel_border_radius_top_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_border_radius_bottom_right') ?>" value="<?php echo $this->get_value('mega_panel_border_radius_bottom_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_border_radius_bottom_left') ?>" value="<?php echo $this->get_value('mega_panel_border_radius_bottom_left') ?>">
                    </label>
                </td>
            </tr>
            <tr class="clever-mega-menu-box-shadow-field">
                <td class="row-label"><?php esc_html_e('Panel Box Shadow', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Horizontal', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_menu_h_shadow') ?>" value="<?php echo $this->get_value('mega_menu_h_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Vertical', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_menu_v_shadow') ?>" value="<?php echo $this->get_value('mega_menu_v_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Blur', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_menu_blur_shadow') ?>" value="<?php echo $this->get_value('mega_menu_blur_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Spread', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_menu_spread_shadow') ?>" value="<?php echo $this->get_value('mega_menu_spread_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_menu_color_shadow') ?>" value="<?php echo $this->get_value('mega_menu_color_shadow') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Pannel Heading', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_heading_color') ?>" value="<?php echo $this->get_value('mega_panel_heading_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Font Size', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_font_size') ?>" value="<?php echo $this->get_value('mega_panel_heading_font_size') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Font Weight', 'clever-mega-menu') ?></p>
                        <?php
                            $selected = $this->get_value('mega_panel_heading_font_weight');
                            $font_weights = array(100, 200, 300, 400, 500, 600, 700, 800, 900);
                        ?>
                        <select name="<?php echo $this->get_field('mega_panel_heading_font_weight') ?>">
                            <?php foreach ($font_weights as $weight) : ?>
                                <option value="<?php echo $weight ?>" <?php selected($selected, $weight) ?>><?php echo $weight ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Text Transform', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('mega_panel_heading_style') ?>
                        <select name="<?php echo $this->get_field('mega_panel_heading_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="lowercase" <?php selected($selected, 'lowercase') ?>><?php esc_html_e('Lowercase', 'clever-mega-menu') ?></option>
                            <option value="capitalize" <?php selected($selected, 'capitalize') ?>><?php esc_html_e('Capitalize', 'clever-mega-menu') ?></option>
                            <option value="uppercase" <?php selected($selected, 'uppercase') ?>><?php esc_html_e('Uppercase', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Panel Heading Margin', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_margin_top') ?>" value="<?php echo $this->get_value('mega_panel_heading_margin_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_margin_right') ?>" value="<?php echo $this->get_value('mega_panel_heading_margin_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_margin_bottom') ?>" value="<?php echo $this->get_value('mega_panel_heading_margin_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_margin_left') ?>" value="<?php echo $this->get_value('mega_panel_heading_margin_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Panel Heading Padding', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_padding_top') ?>" value="<?php echo $this->get_value('mega_panel_heading_padding_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_padding_right') ?>" value="<?php echo $this->get_value('mega_panel_heading_padding_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_padding_bottom') ?>" value="<?php echo $this->get_value('mega_panel_heading_padding_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_padding_left') ?>" value="<?php echo $this->get_value('mega_panel_heading_padding_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Panel Heading Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_heading_border_color') ?>" value="<?php echo $this->get_value('mega_panel_heading_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_border_top') ?>" value="<?php echo $this->get_value('mega_panel_heading_border_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_border_right') ?>" value="<?php echo $this->get_value('mega_panel_heading_border_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_border_bottom') ?>" value="<?php echo $this->get_value('mega_panel_heading_border_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_border_left') ?>" value="<?php echo $this->get_value('mega_panel_heading_border_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('mega_panel_heading_border_style') ?>
                        <select name="<?php echo $this->get_field('mega_panel_heading_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Panel Heading Border Radius', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_border_radius_top_left') ?>" value="<?php echo $this->get_value('mega_panel_heading_border_radius_top_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_border_radius_top_right') ?>" value="<?php echo $this->get_value('mega_panel_heading_border_radius_top_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_border_radius_bottom_right') ?>" value="<?php echo $this->get_value('mega_panel_heading_border_radius_bottom_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_heading_border_radius_bottom_left') ?>" value="<?php echo $this->get_value('mega_panel_heading_border_radius_bottom_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Panel Heading Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('From', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_heading_background_from_color') ?>" value="<?php echo $this->get_value('mega_panel_heading_background_from_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('To', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_heading_background_to_color') ?>" value="<?php echo $this->get_value('mega_panel_heading_background_to_color') ?>">
                    </label>
                </td>
            </tr>
            <tr class="heading-row">
                <th scope="row" class="heading">
                    <?php esc_html_e('Top Level Menu Items', 'clever-mega-menu') ?>
                </th>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_item_color') ?>" value="<?php echo $this->get_value('mega_panel_item_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_item_hover_color') ?>" value="<?php echo $this->get_value('mega_panel_item_hover_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_item_background_color') ?>" value="<?php echo $this->get_value('mega_panel_item_background_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_item_background_hover_color') ?>" value="<?php echo $this->get_value('mega_panel_item_background_hover_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Padding', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_item_padding_top') ?>" value="<?php echo $this->get_value('mega_panel_item_padding_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_item_padding_right') ?>" value="<?php echo $this->get_value('mega_panel_item_padding_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_item_padding_bottom') ?>" value="<?php echo $this->get_value('mega_panel_item_padding_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_item_padding_left') ?>" value="<?php echo $this->get_value('mega_panel_item_padding_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_item_border_color') ?>" value="<?php echo $this->get_value('mega_panel_item_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_item_border_top') ?>" value="<?php echo $this->get_value('mega_panel_item_border_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_item_border_right') ?>" value="<?php echo $this->get_value('mega_panel_item_border_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_item_border_bottom') ?>" value="<?php echo $this->get_value('mega_panel_item_border_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_item_border_left') ?>" value="<?php echo $this->get_value('mega_panel_item_border_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('mega_panel_item_border_style') ?>
                        <select name="<?php echo $this->get_field('mega_panel_item_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Border Hover', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_item_border_hover_color') ?>" value="<?php echo $this->get_value('mega_panel_item_border_hover_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('mega_panel_item_border_hover_style') ?>
                        <select name="<?php echo $this->get_field('mega_panel_item_border_hover_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Hide Last Item Border', 'clever-mega-menu') ?></td>
                <td>
                    <label><input type="checkbox" name="<?php echo $this->get_field('mega_panel_item_border_last_child') ?>" value="1"<?php checked($this->get_value('mega_panel_item_border_last_child')) ?>><span class="description"><?php esc_html_e('Whether to hide border of the last item or not.', 'clever-mega-menu') ?></span></label>
                </td>
            </tr>
            <tr class="heading-row">
                <th scope="row" class="heading">
                    <?php esc_html_e('Second Level Menu Items', 'clever-mega-menu') ?>
                </th>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('From', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_background_from_color') ?>" value="<?php echo $this->get_value('mega_panel_second_background_from_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('To', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_background_to_color') ?>" value="<?php echo $this->get_value('mega_panel_second_background_to_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Padding', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_padding_top') ?>" value="<?php echo $this->get_value('mega_panel_second_padding_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_padding_right') ?>" value="<?php echo $this->get_value('mega_panel_second_padding_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_padding_bottom') ?>" value="<?php echo $this->get_value('mega_panel_second_padding_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_padding_left') ?>" value="<?php echo $this->get_value('mega_panel_second_padding_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_border_color') ?>" value="<?php echo $this->get_value('mega_panel_second_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_border_top') ?>" value="<?php echo $this->get_value('mega_panel_second_border_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_border_right') ?>" value="<?php echo $this->get_value('mega_panel_second_border_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_border_bottom') ?>" value="<?php echo $this->get_value('mega_panel_second_border_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_border_left') ?>" value="<?php echo $this->get_value('mega_panel_second_border_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('mega_panel_second_border_style') ?>
                        <select name="<?php echo $this->get_field('mega_panel_second_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Border Radius', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_border_radius_top_left') ?>" value="<?php echo $this->get_value('mega_panel_second_border_radius_top_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_border_radius_top_right') ?>" value="<?php echo $this->get_value('mega_panel_second_border_radius_top_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_border_radius_bottom_right') ?>" value="<?php echo $this->get_value('mega_panel_second_border_radius_bottom_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_border_radius_bottom_left') ?>" value="<?php echo $this->get_value('mega_panel_second_border_radius_bottom_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Box Shadow', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Horizontal', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_menu_h_shadow') ?>" value="<?php echo $this->get_value('mega_panel_second_menu_h_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Vertical', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_menu_v_shadow') ?>" value="<?php echo $this->get_value('mega_panel_second_menu_v_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Blur', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_menu_blur_shadow') ?>" value="<?php echo $this->get_value('mega_panel_second_menu_blur_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Spread', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_menu_spread_shadow') ?>" value="<?php echo $this->get_value('mega_panel_second_menu_spread_shadow') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_menu_color_shadow') ?>" value="<?php echo $this->get_value('mega_panel_second_menu_color_shadow') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_item_color') ?>" value="<?php echo $this->get_value('mega_panel_second_item_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_item_hover_color') ?>" value="<?php echo $this->get_value('mega_panel_second_item_hover_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_item_background_color') ?>" value="<?php echo $this->get_value('mega_panel_second_item_background_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_item_background_hover_color') ?>" value="<?php echo $this->get_value('mega_panel_second_item_background_hover_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Padding', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_item_padding_top') ?>" value="<?php echo $this->get_value('mega_panel_second_item_padding_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_item_padding_right') ?>" value="<?php echo $this->get_value('mega_panel_second_item_padding_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_item_padding_bottom') ?>" value="<?php echo $this->get_value('mega_panel_second_item_padding_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_item_padding_left') ?>" value="<?php echo $this->get_value('mega_panel_second_item_padding_left') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_item_border_color') ?>" value="<?php echo $this->get_value('mega_panel_second_item_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Top', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_item_border_top') ?>" value="<?php echo $this->get_value('mega_panel_second_item_border_top') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Right', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_item_border_right') ?>" value="<?php echo $this->get_value('mega_panel_second_item_border_right') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Bottom', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_item_border_bottom') ?>" value="<?php echo $this->get_value('mega_panel_second_item_border_bottom') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Left', 'clever-mega-menu') ?></p>
                        <input type="text" class="inline" name="<?php echo $this->get_field('mega_panel_second_item_border_left') ?>" value="<?php echo $this->get_value('mega_panel_second_item_border_left') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('mega_panel_second_item_border_style') ?>
                        <select name="<?php echo $this->get_field('mega_panel_second_item_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Border Hover', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mega_panel_second_item_border_hover_color') ?>" value="<?php echo $this->get_value('mega_panel_second_item_border_hover_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('mega_panel_second_item_border_hover_style') ?>
                        <select name="<?php echo $this->get_field('mega_panel_second_item_border_hover_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
            <tr class="last-row">
                <td class="row-label"><?php esc_html_e('Hide Last Item Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <input type="checkbox" name="<?php echo $this->get_field('mega_panel_second_item_border_last_child') ?>" value="1"<?php checked($this->get_value('mega_panel_second_item_border_last_child'), '0') ?>>
                        <span class="description"><?php esc_html_e('Whether to hide border of the last item or not.', 'clever-mega-menu') ?></span>
                    </label>
                </td>
            </tr>
        </table>
        <table id="cmm-mobile-options" class="form-table clever-mega-menu-admin clever-mega-menu-theme-metabox" style="display:none">
            <tr>
                <td class="row-label"><?php esc_html_e('Disable Mobile Toggle') ?></td>
                <td><label><input id="cmm-disable-mobile-menu-toggle" type="checkbox" name="<?php echo $this->get_field('mobile_menu_disable_toggle') ?>" value="1"<?php checked($this->get_value('mobile_menu_disable_toggle')) ?>><span class="description"><?php esc_html_e('Whether to hide toggle menu bar or not.', 'clever-mega-menu') ?></span></label></td>
            </tr>
            <tr class="cmm-mobile-toggle-option-field">
                <td class="row-label"><?php esc_html_e('Toggle Button Container', 'clever-mega-menu') ?></td>
                <td>
                    <input type="text" name="<?php echo $this->get_field('mobile_menu_toggle_button_wrapper') ?>" value="<?php echo $this->get_value('mobile_menu_toggle_button_wrapper') ?>">
                    <p class="description"><?php esc_html_e('The CSS selector of an HTML element which will contains the toggle menu button on mobile devices. The toggle button will be injected into this element via Javascript.', 'clever-mega-menu') ?></p>
                </td>
            </tr>
            <tr class="last-row">
                <td class="row-label"><?php esc_html_e('Responsive Breakpoint', 'clever-mega-menu') ?></td>
                <td>
                    <input type="text" class="inline" name="<?php echo $this->get_field('mobile_menu_responsive_breakpoint') ?>" value="<?php echo $this->get_value('mobile_menu_responsive_breakpoint') ?>">
                    <p class="description"><?php esc_html_e('Set the width at which the menus using this theme will turns into mobile menus.', 'clever-mega-menu') ?></p>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Background Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('From', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mobile_menu_background_from_color') ?>" value="<?php echo $this->get_value('mobile_menu_background_from_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('To', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mobile_menu_background_to_color') ?>" value="<?php echo $this->get_value('mobile_menu_background_to_color') ?>">
                    </label>
                </td>
            </tr>
            <tr>
                <td class="row-label"><?php esc_html_e('Item Color', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Normal Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mobile_menu_item_color') ?>" value="<?php echo $this->get_value('mobile_menu_item_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Hover Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mobile_menu_item_hover_color') ?>" value="<?php echo $this->get_value('mobile_menu_item_hover_color') ?>">
                    </label>
                </td>
            </tr>
            <tr class="last-row">
                <td class="row-label"><?php esc_html_e('Item Border', 'clever-mega-menu') ?></td>
                <td>
                    <label>
                        <p class="description"><?php esc_html_e('Color', 'clever-mega-menu') ?></p>
                        <input type="text" class="color-picker" data-alpha="true" name="<?php echo $this->get_field('mobile_menu_item_border_color') ?>" value="<?php echo $this->get_value('mobile_menu_item_border_color') ?>">
                    </label>
                    <label>
                        <p class="description"><?php esc_html_e('Style', 'clever-mega-menu') ?></p>
                        <?php $selected = $this->get_value('mobile_menu_item_border_style') ?>
                        <select name="<?php echo $this->get_field('mobile_menu_item_border_style') ?>">
                            <option value="none" <?php selected($selected, 'none') ?>><?php esc_html_e('None', 'clever-mega-menu') ?></option>
                            <option value="inset" <?php selected($selected, 'inset') ?>><?php esc_html_e('Inset', 'clever-mega-menu') ?></option>
                            <option value="outset" <?php selected($selected, 'outset') ?>><?php esc_html_e('Outset', 'clever-mega-menu') ?></option>
                            <option value="solid" <?php selected($selected, 'solid') ?>><?php esc_html_e('Solid', 'clever-mega-menu') ?></option>
                            <option value="ridge" <?php selected($selected, 'ridge') ?>><?php esc_html_e('Ridge', 'clever-mega-menu') ?></option>
                            <option value="inherit" <?php selected($selected, 'inherit') ?>><?php esc_html_e('Inherit', 'clever-mega-menu') ?></option>
                            <option value="hidden" <?php selected($selected, 'hidden') ?>><?php esc_html_e('Hidden', 'clever-mega-menu') ?></option>
                            <option value="dotted" <?php selected($selected, 'dotted') ?>><?php esc_html_e('Dotted', 'clever-mega-menu') ?></option>
                            <option value="dashed" <?php selected($selected, 'dashed') ?>><?php esc_html_e('Dashed', 'clever-mega-menu') ?></option>
                            <option value="double" <?php selected($selected, 'double') ?>><?php esc_html_e('Double', 'clever-mega-menu') ?></option>
                            <option value="groove" <?php selected($selected, 'groove') ?>><?php esc_html_e('Groove', 'clever-mega-menu') ?></option>
                        </select>
                    </label>
                </td>
            </tr>
        </table>
        <table id="cmm-custom-options" class="form-table clever-mega-menu-admin clever-mega-menu-theme-metabox" style="display:none">
            <tr>
                <td class="row-label"><?php esc_html_e('Custom CSS', 'clever-mega-menu') ?></td>
                <td><textarea name="<?php echo $this->get_field('custom_css') ?>" rows="6" cols="60"><?php echo $this->get_value('custom_css') ?></textarea><p class="description"><?php esc_html_e('Define any custom CSS you wish to add to menus using this menu theme.', 'clever-mega-menu') ?> <strong><?php esc_html_e('Do not include <style> or </style> tags.', 'clever-mega-menu') ?></strong></p></td>
            </tr>
            <tr class="last-row">
                <td class="row-label"><?php esc_html_e('Custom Javascript', 'clever-mega-menu') ?></td>
                <td><textarea name="<?php echo $this->get_field('custom_js') ?>" rows="6" cols="60"><?php echo $this->get_value('custom_js'); ?></textarea><p class="description"><?php esc_html_e('Define any custom JS you wish to add to menus using this menu theme.', 'clever-mega-menu') ?> <strong><?php esc_html_e('Do not include <script> or </script> tags.', 'clever-mega-menu') ?></strong></p></td>
            </tr>
        </table><?php
    }

    /**
     * Save metadata
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @param    int    $post_id
     */
    function _save($post_id, \WP_Post $post)
    {
        if (defined('XMLRPC_REQUEST') || defined('WP_IMPORTING')) {
            return;
        }

        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id) || wp_is_post_revision($post_id)) {
            return;
        }

        $meta = !empty($_POST[self::META_KEY]) ? $this->sanitize($_POST[self::META_KEY]) : array();

        $meta = array_merge(self::$fields, $meta);

        if ($meta !== $this->values) {
            update_post_meta($post_id, self::META_KEY, $meta);
            $this->generate_css($meta, $post);
        }
    }

    /**
     * Delete generated css
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/hooks/delete_post/
     */
    function _delete($post_id)
    {
        $post = get_post($post_id);

        if ('clever_menu_theme' !== $post->post_type) {
            return;
        }

        global $wp_filesystem;

        $upload_dir = wp_upload_dir();
        $save_dir   = trailingslashit($upload_dir['basedir']) . 'clever-mega-menu/';
        $file_name  = $save_dir . 'clever-mega-menu-theme-' . $post->post_name . '.css';

        WP_Filesystem(false, $upload_dir['basedir'], true);

        if (file_exists($file_name)) {
            @unlink($file_name);
        }
    }

    /**
     * Generate CSS
     *
     * @param    array    $meta
     */
    public function generate_css(array $meta, \WP_Post $post)
    {
        global $wp_filesystem;

        if (empty($post->post_name) || 'publish' !== $post->post_status) {
            return;
        }

        $scss = $this->generate_scss($meta, $post);

        $scss_compiler = new scssc();
        $scss_compiler->setFormatter('scss_formatter_compressed');

        try {
            $css = $scss_compiler->compile($scss);
        } catch (\Exception $e) {
            return new WP_Error('clever_menu_generate_css_error', esc_html__('Failed to generate menu styles.', 'clever-mega-menu') .  '<br>' . $e->getMessage());
        }

        if (!empty($meta['custom_css'])) {
            $css .= stripslashes($meta['custom_css']);
        }

        $upload_dir = wp_upload_dir();
        $save_dir   = trailingslashit($upload_dir['basedir']) . 'clever-mega-menu/';
        $file_name  = $save_dir . 'clever-mega-menu-theme-' . $post->post_name . '.css';

        WP_Filesystem(false, $upload_dir['basedir'], true);

        if (!$wp_filesystem->is_dir($save_dir)) {
            $wp_filesystem->mkdir($save_dir);
        }

        if (!$wp_filesystem->put_contents($file_name, $css)) {
            return new WP_Error('clever_menu_generate_css_error', esc_html__('Failed to generate menu styles.', 'clever-mega-menu'));
        }
    }

    /**
     * Generate SCSS
     *
     * @param    array    $meta
     *
     * @return    string    $scss
     */
    private function generate_scss(array $meta, \WP_Post $post)
    {
        $meta = array_merge(self::$fields, $meta);
        $arrow_up    = $this->get_arrow_icon($meta['general_arrow_up']);
        $arrow_down  = $this->get_arrow_icon($meta['general_arrow_down']);
        $arrow_left  = $this->get_arrow_icon($meta['general_arrow_left']);
        $arrow_right = $this->get_arrow_icon($meta['general_arrow_right']);
        $arrow_up_font    = $this->get_arrow_font($meta['general_arrow_up']);
        $arrow_down_font  = $this->get_arrow_font($meta['general_arrow_down']);
        $arrow_left_font  = $this->get_arrow_font($meta['general_arrow_left']);
        $arrow_right_font = $this->get_arrow_font($meta['general_arrow_right']);

        $scss = ".cmm-toggle-wrapper {
                    display: none;
                    .toggle-icon-open,
                    .toggle-icon-close {
                        margin-right: 5px;
                    }
                    .toggle-icon-close {
                        display: none;
                    }
                    .cmm-toggle {
                        color: #333;
                        line-height: 20px;
                        text-align: center;
                        padding: 10px;
                        display: inline-block;
                        border: 1px solid #ddd;
                        border-radius: 0;
                        background: #fff;
                        &:hover {
                            cursor: pointer;
                        }
                    }
                }
                .cmm-container {
                    .cmm.cmm-theme-{$post->post_name} {
            			font-size: {$meta['general_font_size']};
                        font-weight: {$meta['general_font_weight']};
            			line-height: {$meta['general_line_height']};
            			text-transform: {$meta['general_text_trasform']};
            			color: {$meta['general_text_color']};
                        width: 100%;
            			height: auto;
                        display: table;
                        margin: {$meta['menubar_margin_top']} {$meta['menubar_margin_right']} {$meta['menubar_margin_bottom']} {$meta['menubar_margin_left']};
            			padding: {$meta['menubar_padding_top']} {$meta['menubar_padding_right']} {$meta['menubar_padding_bottom']} {$meta['menubar_padding_left']};
                        border-width: {$meta['menubar_border_top']} {$meta['menubar_border_right']} {$meta['menubar_border_bottom']} {$meta['menubar_border_left']};
                        border-style: {$meta['menubar_border_style']};
                        border-color: {$meta['menubar_border_color']};
            			border-radius: {$meta['menubar_border_radius_top_left']} {$meta['menubar_border_radius_top_right']} {$meta['menubar_border_radius_bottom_right']} {$meta['menubar_border_radius_bottom_left']};
                        background: {$meta['menubar_background_to_color']};
                        background: -webkit-gradient(linear, left top, left bottom, from({$meta['menubar_background_from_color']}), to({$meta['menubar_background_to_color']}));
                        background: -moz-linear-gradient(top, {$meta['menubar_background_from_color']}, {$meta['menubar_background_to_color']});
                        background: -ms-linear-gradient(top, {$meta['menubar_background_from_color']}, {$meta['menubar_background_to_color']});
                        background: -o-linear-gradient(top, {$meta['menubar_background_from_color']}, {$meta['menubar_background_to_color']});
                        background: linear-gradient(to bottom, {$meta['menubar_background_from_color']}, {$meta['menubar_background_to_color']});
                        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='" . $meta['menubar_background_from_color'] . "', endColorstr='" . $meta['menubar_background_to_color'] . "');
            			list-style-type: none;
            			position: relative;

            			ul, ol {
            				list-style-type: none;
            			}

            			ul {
            				float: none;
                            display: block;
            				border: 0;
            				padding: 0;
            				position: static;
            				&:before,
            				&:after {
            				    display: none;
            				}
            				li {
            					float: none;
            				    border: 0;
            				}
            			}

            			*, a, li {
            				&:hover,
            				&:focus,
            				&:active {
            					outline: none;
            				}
            			}

            			a,
                        .cmm-nav-link {
            	      		color: {$meta['general_link_color']};
                            font-size: {$meta['general_font_size']};
                            font-weight: {$meta['general_font_weight']};
                            line-height: {$meta['general_line_height']};
                            text-transform: {$meta['general_text_trasform']};
            	      		width: auto;
                            display: block;
                            -webkit-box-shadow: none;
                            box-shadow: none;
            				> .cmm-icon {
            					margin-right: 5px;
                                i {
                                    &.dashicons {
                                        vertical-align: sub;
                                    }
                                }
            				}
                        }
                        a {
            	      		&:hover,
            	      		&:active {
            	      			color: {$meta['general_link_hover_color']};
            	      		}
            	      	}

            	      	li {
                            height: auto;
            				background: none;
            				> a,
                            > .cmm-nav-link {
            					position: relative;;
            				}
            				> ul,
            				> .cmm-sub-container,
            				> .cmm-content-container {
            					position: absolute;
            					left: 100%;
            					top: 0;
            					text-align: left;
            					min-width: {$meta['flyout_width']};
                  				z-index: {$meta['general_z_index']};
                                visibility: hidden;
                                opacity: 0;
                                transition: all 0.3s ease-in;
            					.menu-item a,
            					.cmm-nav-link {
            						display: block;
            						padding: {$meta['flyout_item_padding_top']} {$meta['flyout_item_padding_right']} {$meta['flyout_item_padding_bottom']} {$meta['flyout_item_padding_left']};
            					}
            				}
                            .cmm-sub-container {
                                ul.sub-menu,
                                .cmm-sub-wrapper {
                                    width: auto !important;
                                    margin: 0;
                                    padding: {$meta['flyout_padding_top']} {$meta['flyout_padding_right']} {$meta['flyout_padding_bottom']} {$meta['flyout_padding_left']};
                                    border-width: {$meta['flyout_border_top']} {$meta['flyout_border_right']} {$meta['flyout_border_bottom']} {$meta['flyout_border_left']};
                                    border-style: {$meta['flyout_border_style']};
                                    border-color: {$meta['flyout_border_color']};
                                    border-radius: {$meta['flyout_border_radius_top_left']} {$meta['flyout_border_radius_top_right']} {$meta['flyout_border_radius_bottom_right']} {$meta['flyout_border_radius_bottom_left']};
                                    box-shadow: {$meta['flyout_menu_h_shadow']} {$meta['flyout_menu_v_shadow']} {$meta['flyout_menu_blur_shadow']} {$meta['flyout_menu_spread_shadow']} {$meta['flyout_menu_color_shadow']};
                                    background: {$meta['flyout_background_to_color']};
                                    background: -webkit-gradient(linear, left top, left bottom, from({$meta['flyout_background_from_color']}), to({$meta['flyout_background_to_color']}));
                                    background: -moz-linear-gradient(top, {$meta['flyout_background_from_color']}, {$meta['flyout_background_to_color']});
                                    background: -ms-linear-gradient(top, {$meta['flyout_background_from_color']}, {$meta['flyout_background_to_color']});
                                    background: -o-linear-gradient(top, {$meta['flyout_background_from_color']}, {$meta['flyout_background_to_color']});
                                    background: linear-gradient(to bottom, {$meta['flyout_background_from_color']}, {$meta['flyout_background_to_color']});
                                    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='" . $meta['flyout_background_from_color'] . "', endColorstr='" . $meta['flyout_background_to_color'] . "');
                                }
                            }

                            > .cmm-sub-container,
                            > .cmm-content-container {
                                background: none;
                            }

                            .cmm-sub-container > ul.sub-menu,
                            .cmm-sub-container .cmm-sub-wrapper {
                                position: static;
                                display: block !important;
                                opacity: 1 !important;
                            }

                            > .cmm-sub-container {
                                .sub-menu,
                                .cmm-sub-wrapper {
                                    li {
                                        position: relative;
                                        padding: 0;
                                        &:hover,
                                        &.focus {
                                            padding: 0;
                                            background: none;
                                        }
                                        > a,
                                        > .cmm-nav-link {
                                            border-width: {$meta['flyout_item_border_top']} {$meta['flyout_item_border_right']} {$meta['flyout_item_border_bottom']} {$meta['flyout_item_border_left']};
                                            border-style: {$meta['flyout_item_border_style']};
                                            border-color: {$meta['flyout_item_border_color']};
                                            color: {$meta['flyout_item_color']};
                                            background-color: {$meta['flyout_item_background_color']};
                                        }
                                        > a {
                                            &:hover {
                                                color: {$meta['flyout_item_hover_color']};
                                                border-style: {$meta['flyout_item_border_hover_style']};
                                                border-color: {$meta['flyout_item_border_hover_color']};
                                                background-color: {$meta['flyout_item_background_hover_color']};
                                            }
                                        }
                                        &.menu-item-has-children {
                                            > .cmm-dropdown-toggle {
                                                color: {$meta['flyout_item_color']};
                                            }
                                        }";
                                    if($meta['flyout_item_border_last_child'] === '1') {
                                        $scss .= "
                                        &:last-child {
                                            > a,
                                            > .cmm-nav-link {
                                                border-width: 0px;
                                            }
                                        }";
                                    }
                            $scss .= "
                                    }
                                }
                            }
                            > .cmm-content-container {
                                border: 0;
                                .cmm-content-wrapper {
                                    position: relative;
                                    left: auto;
                                    right: auto;
                                    padding: {$meta['mega_panel_padding_top']} {$meta['mega_panel_padding_right']} {$meta['mega_panel_padding_bottom']} {$meta['mega_panel_padding_left']};
                                    border-width: {$meta['mega_panel_border_top']} {$meta['mega_panel_border_right']} {$meta['mega_panel_border_bottom']} {$meta['mega_panel_border_left']};
                                    border-style: {$meta['mega_panel_border_style']};
                                    border-color: {$meta['mega_panel_border_color']};
                                    border-radius: {$meta['mega_panel_border_radius_top_left']} {$meta['mega_panel_border_radius_top_right']} {$meta['mega_panel_border_radius_bottom_right']} {$meta['mega_panel_border_radius_bottom_left']};
                                    box-shadow: {$meta['mega_menu_h_shadow']} {$meta['mega_menu_v_shadow']} {$meta['mega_menu_blur_shadow']} {$meta['mega_menu_spread_shadow']} {$meta['mega_menu_color_shadow']};
                                    background: {$meta['mega_panel_background_to_color']};
                                    background: -webkit-gradient(linear, left top, left bottom, from({$meta['mega_panel_background_from_color']}), to({$meta['mega_panel_background_to_color']}));
                                    background: -moz-linear-gradient(top, {$meta['mega_panel_background_from_color']}, {$meta['mega_panel_background_to_color']});
                                    background: -ms-linear-gradient(top, {$meta['mega_panel_background_from_color']}, {$meta['mega_panel_background_to_color']});
                                    background: -o-linear-gradient(top, {$meta['mega_panel_background_from_color']}, {$meta['mega_panel_background_to_color']});
                                    background: linear-gradient(to bottom, {$meta['mega_panel_background_from_color']}, {$meta['mega_panel_background_to_color']});
                                    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='" . $meta['mega_panel_background_from_color'] . "', endColorstr='" . $meta['mega_panel_background_to_color'] . "');
                                    .vc_row {
                                        position: relative;
                                        z-index: 1;
                                    }
                                    .cmm-panel-image {
                                        position: absolute;
                                        z-index: 0;
                                        right: 0;
                                        bottom: 0;
                                        max-height: 100%;
                                    }
                                    ul {
                                        left: auto;
                                    }
                                    .widget {
                                        ul.menu {
                                            li + li {
                                                margin: 0;
                                            }
                                            li {
                                                margin: 0;
                                                padding: 0;
                                                border: 0;
                                                a {
                                                    width: auto;
                                                }
                                                a:focus,
                                                a:hover {
                                                    box-shadow: none;
                                                }
                                                &:hover {
                                                    padding: 0;
                                                }
                                            }
                                        }
                                    }
                                    ul.sub-menu {
                                        left: 100%;
                                        margin: 0;
                                        padding: {$meta['mega_panel_second_padding_top']} {$meta['mega_panel_second_padding_right']} {$meta['mega_panel_second_padding_bottom']} {$meta['mega_panel_second_padding_left']};
                                        border-width: {$meta['mega_panel_second_border_top']} {$meta['mega_panel_second_border_right']} {$meta['mega_panel_second_border_bottom']} {$meta['mega_panel_second_border_left']};
                                        border-style: {$meta['mega_panel_second_border_style']};
                                        border-color: {$meta['mega_panel_second_border_color']};
                                        border-radius: {$meta['mega_panel_second_border_radius_top_left']} {$meta['mega_panel_second_border_radius_top_right']} {$meta['mega_panel_second_border_radius_bottom_right']} {$meta['mega_panel_second_border_radius_bottom_left']};
                                        box-shadow: {$meta['mega_panel_second_menu_h_shadow']} {$meta['mega_panel_second_menu_v_shadow']} {$meta['mega_panel_second_menu_blur_shadow']} {$meta['mega_panel_second_menu_spread_shadow']} {$meta['mega_panel_second_menu_color_shadow']};
                                        background: {$meta['mega_panel_second_background_to_color']};
                                        background: -webkit-gradient(linear, left top, left bottom, from({$meta['mega_panel_second_background_from_color']}), to({$meta['mega_panel_second_background_to_color']}));
                                        background: -moz-linear-gradient(top, {$meta['mega_panel_second_background_from_color']}, {$meta['mega_panel_second_background_to_color']});
                                        background: -ms-linear-gradient(top, {$meta['mega_panel_second_background_from_color']}, {$meta['mega_panel_second_background_to_color']});
                                        background: -o-linear-gradient(top, {$meta['mega_panel_second_background_from_color']}, {$meta['mega_panel_second_background_to_color']});
                                        background: linear-gradient(to bottom, {$meta['mega_panel_second_background_from_color']}, {$meta['mega_panel_second_background_to_color']});
                                        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='" . $meta['mega_panel_second_background_from_color'] . "', endColorstr='" . $meta['mega_panel_second_background_to_color'] . "');
                                    }
                                    ul.menu {
                                        opacity: 1;
                                        display: block;
                                        visibility: inherit;
                                        li {
                                            padding: 0;
                                            &:hover,
                                            &.focus {
                                                padding: 0;
                                                background: none;
                                            }
                                        }
                                        > li {
                                            > a,
                                            > .cmm-nav-link {
                                                padding: {$meta['mega_panel_item_padding_top']} {$meta['mega_panel_item_padding_right']} {$meta['mega_panel_item_padding_bottom']} {$meta['mega_panel_item_padding_left']};
                                                border-width: {$meta['mega_panel_item_border_top']} {$meta['mega_panel_item_border_right']} {$meta['mega_panel_item_border_bottom']} {$meta['mega_panel_item_border_left']};
                                                border-style: {$meta['mega_panel_item_border_style']};
                                                border-color: {$meta['mega_panel_item_border_color']};
                                                color: {$meta['mega_panel_item_color']};
                                                background-color: {$meta['mega_panel_item_background_color']};
                                            }
                                            > a {
                                                &:hover {
                                                    color: {$meta['mega_panel_item_hover_color']};
                                                    border-style: {$meta['mega_panel_item_border_hover_style']};
                                                    border-color: {$meta['mega_panel_item_border_hover_color']};
                                                    background-color: {$meta['mega_panel_item_background_hover_color']};
                                                }
                                            }";
                                        if($meta['mega_panel_item_border_last_child'] === '1') {
                                        $scss .= "
                                            &:last-child {
                                                > a,
                                                > .cmm-nav-link {
                                                    border-width: 0px;
                                                }
                                            }";
                                        }
                                $scss .= "
                                            li {
                                                a,
                                                > .cmm-nav-link {
                                                    padding: {$meta['mega_panel_second_item_padding_top']} {$meta['mega_panel_second_item_padding_right']} {$meta['mega_panel_second_item_padding_bottom']} {$meta['mega_panel_second_item_padding_left']};
                                                    border-width: {$meta['mega_panel_second_item_border_top']} {$meta['mega_panel_second_item_border_right']} {$meta['mega_panel_second_item_border_bottom']} {$meta['mega_panel_second_item_border_left']};
                                                    border-style: {$meta['mega_panel_second_item_border_style']};
                                                    border-color: {$meta['mega_panel_second_item_border_color']};
                                                    color: {$meta['mega_panel_second_item_color']};
                                                    background-color: {$meta['mega_panel_second_item_background_color']};
                                                }
                                                a {
                                                    &:hover {
                                                        color: {$meta['mega_panel_second_item_hover_color']};
                                                        border-color: {$meta['mega_panel_second_item_border_hover_color']};
                                                        border-style: {$meta['mega_panel_second_item_border_hover_style']};
                                                        background-color: {$meta['mega_panel_second_item_background_hover_color']};
                                                    }
                                                }
                                                &.menu-item-has-children {
                                                    > .cmm-dropdown-toggle {
                                                        color: {$meta['mega_panel_second_item_color']};
                                                    }
                                                }";
            if($meta['mega_panel_second_item_border_last_child'] === '1') {
                $scss .= "
                &:last-child {
                    > a,
                    > .cmm-nav-link {
                        border-width: 0px;
                    }
                }";
            }
            $scss .= "
                                            }
                                        }
                                    }
                                }
                            }
            				ul {
            					li {
            						border: 0;
            						&:hover {
            							> ul,
            							> .cmm-sub-container,
            							> .cmm-content-container {
            							    top: 0;
            							    left: 100%;
            								right: auto;
            							}
            						}
            					}
            				}
            				&.cmm-mega {
                                > .cmm-sub-container,
                                &:hover > .cmm-sub-container {
                                    display: none !important;
                                }
                                &.cmm-layout-left_edge_item {
                                    .cmm-content-container {
                                        left: 0;
                                        right: auto;
                                    }
                                }

                                &.cmm-layout-right_edge_item {
                                    .cmm-content-container {
                                        left: auto;
                                        right: 0;
                                    }
                                }
            					ul.menu {
            						border: 0;
            						box-shadow: none;
            						position: static;
            						> li {
            							border: 0;
            						}
            					}
            				}
            				&.menu-item-has-children {
            					> a,
                                > .cmm-nav-link {
            						&:after {
            							color: inherit;
            							font-size: 12px;
            							font-family: {$arrow_down_font};
                  				    	content: {$arrow_down};
            							line-height: 1;
            							position: absolute;
            							top: 50%;
            							right: 5px;
            							margin: -6px 0 0 0;
            							vertical-align: middle;
            							display: inline-block;
            							-webkit-transform: rotate(0);
            							-moz-transform: rotate(0);
            							-ms-transform: rotate(0);
            							transform: rotate(0);
            						}
            					}
            				}
                            .cmm-dropdown-toggle {
                                display: none;
                            }
                            &:hover {
            					> ul,
            					> .cmm-sub-container,
            					> .cmm-content-container {
                                    visibility: visible;
                                    opacity: 1;
                                    z-index: {$meta['general_z_index']} + 1;
            					}

                                > .cmm-sub-container {
                                    > ul.sub-menu,
                                    .cmm-sub-wrapper {
                                        visibility: visible !important;
                                        opacity: 1 !important;
                                    }
                                }

            					> a {
            	      				color: {$meta['general_link_hover_color']};
            	      			}
            				}
            			}

            			> li {
            				position: relative;
            				display: inline-block;
            				> a,
                            > .cmm-nav-link {
            					color: {$meta['menubar_item_text_color']};
                                border-width: {$meta['menubar_item_border_top']} {$meta['menubar_item_border_right']} {$meta['menubar_item_border_bottom']} {$meta['menubar_item_border_left']};
                                border-style: {$meta['menubar_item_border_style']};
                                border-color: {$meta['menubar_item_border_color']};
            	      			font-size: {$meta['menubar_item_text_font_size']};
                                font-weight: {$meta['menubar_item_text_font_weight']};
                                text-transform: {$meta['menubar_item_text_transform']};
                                height: {$meta['menubar_menu_height']};
            	      			line-height: {$meta['menubar_menu_height']};
                                margin: {$meta['menubar_item_margin_top']} {$meta['menubar_item_margin_right']} {$meta['menubar_item_margin_bottom']} {$meta['menubar_item_margin_left']};
            	      			padding: {$meta['menubar_item_padding_top']} {$meta['menubar_item_padding_right']} {$meta['menubar_item_padding_bottom']} {$meta['menubar_item_padding_left']};
            	      			background-color: {$meta['menubar_item_background_color']};
                            }
                            > a {
            	      			&:hover {
                                    border-style: {$meta['menubar_item_border_hover_style']};
                                    border-color: {$meta['menubar_item_border_hover_color']};
            	      				color: {$meta['menubar_item_text_hover_color']};
            	      				background-color: {$meta['menubar_item_background_hover_color']};
                                }
                                &:active,
                                &.active {
                                    background-color: {$meta['menubar_item_background_active_color']};
            	      			}
            				}
                            > .cmm-dropdown-toggle {
                                color: {$meta['menubar_item_text_color']};
                            }";
            if($meta['menubar_item_border_last_child'] === '1') {
            $scss .= "
                &:last-child {
                    > a,
                    > .cmm-nav-link {
                        border-width: 0px;
                    }
                }";
            }
            $scss .= "
            				> ul,
            				> .cmm-sub-container,
            				> .cmm-content-container {
            					top: 100%;
            					left: 0;
            				}
            				li {
            	      			&.menu-item-has-children {
            	      				> a,
                                    > .cmm-nav-link {
            	      					&:after {
            	                            font-family: {$arrow_right_font};
            	      					    content: {$arrow_right};
            	      					}
            	      				}
            	      			}
            	      		}

            				&:hover {
            					> ul,
            					> .cmm-sub-container,
            					> .cmm-content-container {
            					    top: 100%;
            					}
            				}

            				&:hover,
            	      		&.current-menu-item,
            	      		&.current-menu-ancestor {
            	      			> a {
            	      				color: {$meta['menubar_item_text_hover_color']};
            	      			}
            	      		}
            			}

            			.current-menu-item,
            	      	.current-menu-ancestor {
            	      		> a {
            	      			color: {$meta['general_link_hover_color']};
            	      		}
            	      	}

            	      	.widget {
            				border: 0;
            				padding: 0;
            				margin: 0;
            			}
            			.widgettitle,
            			.widget-title,
            			.wpb_heading,
            			.clever-custom-title {
            				font-size: {$meta['mega_panel_heading_font_size']};
                            font-weight: {$meta['mega_panel_heading_font_weight']};
            	      		color: {$meta['mega_panel_heading_color']};
            	            text-transform: {$meta['mega_panel_heading_style']};
            				padding: {$meta['mega_panel_heading_padding_top']} {$meta['mega_panel_heading_padding_right']} {$meta['mega_panel_heading_padding_bottom']} {$meta['mega_panel_heading_padding_left']};
            				margin: {$meta['mega_panel_heading_margin_top']} {$meta['mega_panel_heading_margin_right']} {$meta['mega_panel_heading_margin_bottom']} {$meta['mega_panel_heading_margin_left']};
                            border-radius: {$meta['mega_panel_heading_border_radius_top_left']} {$meta['mega_panel_heading_border_radius_top_right']} {$meta['mega_panel_heading_border_radius_bottom_right']} {$meta['mega_panel_heading_border_radius_bottom_left']};
                            border-width: {$meta['mega_panel_heading_border_top']} {$meta['mega_panel_heading_border_right']} {$meta['mega_panel_heading_border_bottom']} {$meta['mega_panel_heading_border_left']};
                                border-style: {$meta['mega_panel_heading_border_style']};
                                border-color: {$meta['mega_panel_heading_border_color']};
                                background: {$meta['mega_panel_heading_background_to_color']};
                                background: -webkit-gradient(linear, left top, left bottom, from({$meta['mega_panel_heading_background_from_color']}), to({$meta['mega_panel_heading_background_to_color']}));
                                background: -moz-linear-gradient(top, {$meta['mega_panel_heading_background_from_color']}, {$meta['mega_panel_heading_background_to_color']});
                                background: -ms-linear-gradient(top, {$meta['mega_panel_heading_background_from_color']}, {$meta['mega_panel_heading_background_to_color']});
                                background: -o-linear-gradient(top, {$meta['mega_panel_heading_background_from_color']}, {$meta['mega_panel_heading_background_to_color']});
                                background: linear-gradient(to bottom, {$meta['mega_panel_heading_background_from_color']}, {$meta['mega_panel_heading_background_to_color']});
                                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='" . $meta['mega_panel_heading_background_from_color'] . "', endColorstr='" . $meta['mega_panel_heading_background_to_color'] . "');
            			}
            			&.cmm-horizontal {
            				&.cmm-horizontal-align-left {
            					text-align: left;
            				}
            				&.cmm-horizontal-align-right {
            					text-align: right;
            				}
            				&.cmm-horizontal-align-center {
            					text-align: center;
            				}
            			}
                        &.cmm-menu-fade-up {
                            li.menu-item-has-children {
                                > ul.menu,
                                > .cmm-sub-container,
                                > .cmm-content-container {
                                    top: calc(100% + 40px);
                                }
                                &:hover {
                                    > ul.menu,
                                    > .cmm-sub-container,
                                    > .cmm-content-container {
                                        top: 0;
                                    }
                                }
                            }
                            > li.menu-item-has-children {
                                &:hover {
                                    > ul.menu,
                                    > .cmm-sub-container,
                                    > .cmm-content-container {
                                        top: 100%;
                                    }
                                }
                            }
                        }
                        &.cmm-no-effect {
                            li {
                                > ul,
                                > .cmm-sub-container,
                                > .cmm-content-container {
                                    -moz-transition: none;
                                    -webkit-transition: none;
                                    -o-transition: none;
                                    -ms-transition: none;
                                    transition: none;
                                }
                                &:hover {
                                    > ul,
                                    > .cmm-sub-container,
                                    > .cmm-content-container {
                                        -moz-transition: none;
                                        -webkit-transition: none;
                                        -o-transition: none;
                                        -ms-transition: none;
                                        transition: none;
                                    }
                                }
                            }
                        }
            		}
                }
                @media (max-width: {$meta['mobile_menu_responsive_breakpoint']}px) {
                    .cmm-toggle-wrapper {
                        display: block;
                        .cmm-toggle {
                            &.toggled-on {
                                .toggle-icon-close {
                                    display: inline-block;
                                }
                                .toggle-icon-open {
                                    display: none;
                                }
                            }
                        }
                    }
                    .cmm-container {
                        width: 100%;
                        clear: both;
                        .cmm.cmm-theme-{$post->post_name} {
                            color: {$meta['mobile_menu_item_color']};
                            display: none;
                            position: absolute;
                            padding: 0 20px;
                            background: {$meta['mobile_menu_background_to_color']};
                            background: -webkit-gradient(linear, left top, left bottom, from({$meta['mobile_menu_background_from_color']}), to({$meta['mobile_menu_background_to_color']}));
                            background: -moz-linear-gradient(top, {$meta['mobile_menu_background_from_color']}, {$meta['mobile_menu_background_to_color']});
                            background: -ms-linear-gradient(top, {$meta['mobile_menu_background_from_color']}, {$meta['mobile_menu_background_to_color']});
                            background: -o-linear-gradient(top, {$meta['mobile_menu_background_from_color']}, {$meta['mobile_menu_background_to_color']});
                            background: linear-gradient(to bottom, {$meta['mobile_menu_background_from_color']}, {$meta['mobile_menu_background_to_color']});
                            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='" . $meta['mobile_menu_background_from_color'] . "', endColorstr='" . $meta['mobile_menu_background_to_color'] . "');
                            a,
                            .cmm-nav-link {
                                color: {$meta['mobile_menu_item_color']};
                            }
                            a {
                                &:hover {
                                    color: {$meta['mobile_menu_item_hover_color']};
                                }
                            }
                            .cmm-panel-image {
                                display: none;
                            }
                            .vc_row .wpb_column {
                                width: 100%;
                            }
                            .vc_row.wpb_row {
                                background: none !important;
                            }
                            li,
                            > li {
                                width: 100%;
                                position: relative !important;
                            }
                            li {
                                border-bottom-width: 1px;
                                border-bottom-style: {$meta['mobile_menu_item_border_style']};
                                border-bottom-color: {$meta['mobile_menu_item_border_color']};
                                &:last-child {
                                    border-bottom: 0;
                                }
                                &.menu-item-has-children {
                                    > a,
                                    > .cmm-nav-link {
                                        &:before,
                                        &:after {
                                            display: none;
                                        }
                                    }
                                }
                                > ul,
                                > .cmm-sub-container,
                                > .cmm-content-container {
                                    width: auto !important;
                                    position: static;
                                    opacity: 1;
                                    visibility: visible;
                                    display: none;
                                    box-shadow: none;
                                    overflow: hidden;
                                    padding: 0!important;
                                    background: none;
                                    &.clever-toggled-on {
                                        display: block;
                                    }
                                }
                                > ul,
                                > .cmm-sub-container .cmm-sub-wrapper,
                                > .cmm-content-container .cmm-content-wrapper {
                                    padding: 0 0 0 20px !important;
                                    border-top-width: 1px;
                                    border-top-style: {$meta['mobile_menu_item_border_style']};
                                    border-top-color: {$meta['mobile_menu_item_border_color']};
                                    background: none;
                                    li {
                                        border-top-width: 1px;
                                        border-top-style: {$meta['mobile_menu_item_border_style']};
                                        border-top-color: {$meta['mobile_menu_item_border_color']};
                                        &:last-child {
                                            border-bottom: 0;
                                        }
                                    }
                                }
                                > .cmm-sub-container .cmm-sub-wrapper,
                                > .cmm-content-container .cmm-content-wrapper {
                                    position: relative;
                                    left: auto;
                                    right: auto;
                                    top: auto;
                                    opacity: 1;
                                    visibility: visible;
                                    display: block;
                                    box-shadow: none !important;
                                    .wpb_wrapper .wpb_content_element {
                                        margin: 0;
                                    }
                                    ul.menu,
                                    .widget ul.menu {
                                        background: none;
                                        .sub-menu {
                                            background: none;
                                            padding-left: 20px !important;
                                        }
                                        li a,
                                        li .cmm-nav-link,
                                        > li > a,
                                        > li > .cmm-nav-link {
                                            padding: 0;
                                        }
                                        li {
                                            border-bottom-width: 1px;
                                            border-bottom-style: {$meta['mobile_menu_item_border_style']};
                                            border-bottom-color: {$meta['mobile_menu_item_border_color']};
                                            a,
                                            .cmm-nav-link {
                                                line-height: 50px;
                                                border: 0;
                                            }
                                        }
                                        > li {
                                            > a {
                                                &:hover {
                                                    color: {$meta['mobile_menu_item_hover_color']};
                                                    background: none;
                                                }
                                            }
                                        }
                                    }
                                    .widgettitle,
                                    .widget-title,
                                    .wpb_heading,
                                    .clever-custom-title {
                                        color: {$meta['mobile_menu_item_color']};
                                        line-height: 50px;
                                        margin: 0;
                                        padding: 0;
                                        border-bottom-width: 1px;
                                        border-bottom-style: {$meta['mobile_menu_item_border_style']};
                                        border-bottom-color: {$meta['mobile_menu_item_border_color']};
                                        background: none;
                                    }
                                }
                                .cmm-sub-container {
                                    ul.sub-menu,
                                    .cmm-sub-wrapper {
                                        box-shadow: none;
                                        background: none;
                                        li {
                                            > a,
                                            > .cmm-nav-link {
                                                color: {$meta['mobile_menu_item_color']};
                                            }
                                            > a {
                                                &:hover {
                                                    color: {$meta['mobile_menu_item_hover_color']};
                                                }
                                            }
                                        }
                                        > li {
                                            padding: 0;
                                            &:hover {
                                                padding: 0;
                                            }
                                        }
                                    }
                                }
                                > .cmm-content-container {
                                    .cmm-content-wrapper {
                                        > .vc_row {
                                            padding: 10px 0;
                                        }
                                        ul.menu {
                                            > li {
                                                > a,
                                                > .cmm-nav-link {
                                                    color: {$meta['mobile_menu_item_color']};
                                                    background: none;
                                                }
                                                > a {
                                                    &:hover {
                                                        color: {$meta['mobile_menu_item_hover_color']};
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                > .cmm-sub-container .cmm-sub-wrapper,
                                > .cmm-content-container .cmm-content-wrapper {
                                    li {
                                        > a,
                                        > .cmm-nav-link {
                                            line-height: 50px;
                                            padding: 0;
                                        }
                                    }
                                }
                                .vc_column-inner {
                                    padding-top: 0 !important;
                                    padding-bottom: 0 !important;
                                }
                                &.menu-item-has-children > a:before,
                                &.menu-item-has-children > a:after {
                                    display: none;
                                }
                                .dropdown-toggle {
                                    display: none;
                                }
                                .cmm-dropdown-toggle {
                                    background-color: transparent;
                                    border: 0;
                                    -webkit-box-shadow: none;
                                    box-shadow: none;
                                    display: block;
                                    font-size: 16px;
                                    right: 0;
                                    line-height: 1.5;
                                    margin: 0 auto;
                                    padding: 13px 18px;
                                    position: absolute;
                                    text-shadow: none;
                                    top: 0;
                                    i {
                                        transition: all 0.3s;
                                    }
                                    &.clever-toggled-on {
                                        i {
                                            -ms-transform: rotate(-180deg);
                                            -webkit-transform: rotate(-180deg);
                                            transform: rotate(-180deg);
                                        }
                                    }
                                }
                            }
                            > li > a,
                            > li > .cmm-nav-link {
                                height: auto;
                                line-height: 50px;
                                padding: 0 !important;
                                border: none;
                                color: {$meta['mobile_menu_item_color']};
                            }
                            > li > a {
                                background: none !important;
                                &:hover {
                                    border: none;
                                    color: {$meta['mobile_menu_item_hover_color']};
                                    background: none !important;
                                }
                            }
                            > li:hover > a,
                            > li.current-menu-item > a,
                            > li.current-menu-ancestor > a {
                                color: {$meta['mobile_menu_item_hover_color']};
                            }
                            > li > .cmm-dropdown-toggle,
                            li > .cmm-sub-container .sub-menu li.menu-item-has-children > .cmm-dropdown-toggle,
                            li > .cmm-sub-container .cmm-sub-wrapper li.menu-item-has-children > .cmm-dropdown-toggle {
                                color: {$meta['mobile_menu_item_color']};
                            }
                            ul,
                            .widgettitle,
                            .widget-title,
                            .wpb_heading,
                            .clever-custom-title {
                                background: none;
                            }
                            &.cmm-horizontal {
                                &.cmm-horizontal-align-left {
                                    text-align: left;
                                }
                                &.cmm-horizontal-align-right {
                                    text-align: left;
                                }
                                &.cmm-horizontal-align-center {
                                    text-align: left;
                                }
                            }
                        }
                        &.toggled-on {
                            .cmm.cmm-theme-{$post->post_name} {
                                display: table;
                            }
                        }
                    }
                }
                @media (max-width: 768px) {
                    .cmm-container {
                        .cmm.cmm-theme-{$post->post_name} {
                            li {
                                &.menu-item-has-children {
                                    &.cmm-hide-sub-items {
                                        > ul.sub-menu,
                                        > clever-sub-menu-container,
                                        > .cmm-content-container,
                                        > .cmm-dropdown-toggle {
                                            display: none !important;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }";

        return $scss;
    }

    /**
     * Convert arrows' HTML class attribute to icon
     *
     * @param    string    $class    HTML class attribute
     *
     * @return    string
     */
    private function get_arrow_icon($class)
    {
        $valid_icons = array(
            'dashicons' => array(
                'none'                       => '',
                'dashicons-arrow-up'         => '\f142',
                'dashicons-arrow-up-alt'     => '\f342',
                'dashicons-arrow-up-alt2'    => '\f343',
                'dashicons-arrow-down'       => '\f140',
                'dashicons-arrow-down-alt'   => '\f347',
                'dashicons-arrow-down-alt2'  => '\f346',
                'dashicons-arrow-left'       => '\f141',
                'dashicons-arrow-left-alt'   => '\f341',
                'dashicons-arrow-left-alt2'  => '\f340',
                'dashicons-arrow-right'      => '\f139',
                'dashicons-arrow-right-alt'  => '\f345',
                'dashicons-arrow-right-alt2' => '\f344',
            )
        );

        $icon = explode(' ', trim($class));
        $type = trim($icon[0]);
        $icon = trim($icon[1]);

        return isset($valid_icons[$type][$icon]) ? "'" . $valid_icons[$type][$icon] . "'" : '';
    }

    /**
     * Get icon font family
     *
     * @param    string    $class    HTML class attribute
     *
     * @return    string
     */
    private function get_arrow_font($class)
    {
        if (false !== strpos($class, 'dashicons ')) {
            return 'Dashicons';
        }

        return 'inherit';
    }

    /**
     * Sanitize metadata
     *
     * @param    array    Raw metadata.
     *
     * @return    array    Sanitized metadata.
     */
    private function sanitize($meta)
    {
        $meta['mobile_menu_disable_toggle'] = isset($meta['mobile_menu_disable_toggle']) ? $meta['mobile_menu_disable_toggle'] : '0';
        $meta['menubar_item_border_last_child'] = isset($meta['menubar_item_border_last_child']) ? $meta['menubar_item_border_last_child'] : '0';
        $meta['flyout_item_border_last_child'] = isset($meta['flyout_item_border_last_child']) ? $meta['flyout_item_border_last_child'] : '0';
        $meta['mega_panel_item_border_last_child'] = isset($meta['mega_panel_item_border_last_child']) ? $meta['mega_panel_item_border_last_child'] : '0';
        $meta['mega_panel_second_item_border_last_child'] = isset($meta['mega_panel_second_item_border_last_child']) ? $meta['mega_panel_second_item_border_last_child'] : '0';

        foreach ($meta as $key => $value) {
            if ('' !== $value && null !== $value) {
                $meta[$key] = sanitize_text_field($value);
            } else {
                $meta[$key] = self::$fields[$key];
            }
        }

        return $meta;
    }

    /**
     * Get field ID
     *
     * @param    string    $name    Field name.
     *
     * @return    string   $field    Field's ID.
     */
    private function get_field($name)
    {
        $field = self::META_KEY . '[' . $name . ']';

        return $field;
    }

    /**
     * Get field value
     *
     * @param    string    $name    Field name.
     *
     * @return    mixed    $value    Field's value.
     */
    private function get_value($name)
    {
        $value = isset($this->values[$name]) ? $this->values[$name] : self::$fields[$name];

        return $value;
    }

    /**
     * Get color value in CSS format
     */
    private function get_color_value($value)
    {
        $value = preg_replace('/\s+/', '', $value);

        if (preg_match('/\#([A-Fa-f0-9]{3}){1,2}/', $value, $matches)) {
            return $matches[0];
        }

        if (preg_match('/rgba\([0-9,\.]+\)/', $value, $matches)) {
            return $matches[0];
        }

        return false;
    }
}
