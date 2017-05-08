<?php
/**
 * Clever_Mega_Menu_Theme_Post_Type
 *
 * @package    Clever_Mega_Menu
 */
final class Clever_Mega_Menu_Theme_Post_Type
{
    /**
     * Post type
     *
     * @var    object
     *
     * @see    https://developer.wordpress.org/reference/functions/register_post_type/
     */
    public $post_type;

    /**
     * Settings
     *
     * @see    Clever_Mega_Menu::$settings
     *
     * @var    array
     */
    private $settings;

    /**
     * Constructor
     */
    function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Register portfolio post type
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _register()
    {
        $labels = array(
            'name'          => esc_html__('Menu Themes', 'clever-mega-menu'),
            'singular_name' => esc_html__('Menu Theme', 'clever-mega-menu'),
            'all_items'     => esc_html__('Menu Themes', 'clever-mega-menu'),
            'add_new'       => esc_html__('Add New Menu Theme', 'clever-mega-menu'),
            'add_new_item'  => esc_html__('Add New Menu Theme', 'clever-mega-menu'),
            'edit_item'     => esc_html__('Edit Menu Theme', 'clever-mega-menu')
        );

        $args = array(
            'labels'        => $labels,
            'public'        => false,
            'show_ui'       => true,
            'show_in_menu'  => 'class-clever-mega-menu-dashboard.php',
            'supports'      => array('title')
        );

        $this->post_type = register_post_type('clever_menu_theme', $args);
    }

    /**
     * Do notification
     *
     * @internal  Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see  https://developer.wordpress.org/reference/hooks/post_updated_messages/
     */
    function _notify($messages)
    {
        $messages['clever_menu_theme'] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => esc_html__('Menu theme updated.', 'clever-mega-menu'),
            2  => esc_html__('Custom field updated.', 'clever-mega-menu'),
            3  => esc_html__('Custom field deleted.', 'clever-mega-menu'),
            4  => esc_html__('Menu theme updated.', 'clever-mega-menu'),
            5  => isset($_GET['revision']) ? esc_html__('Menu theme restored to revision from', 'clever-mega-menu') . ' ' . wp_post_revision_title(absint($_GET['revision'])) : false,
            6  => esc_html__('Menu theme published.', 'clever-mega-menu'),
            7  => esc_html__('Menu theme saved.', 'clever-mega-menu'),
            8  => esc_html__('Menu theme submitted.', 'clever-mega-menu'),
            9  => esc_html__('Menu theme scheduled.', 'clever-mega-menu'),
            10 => esc_html__('Menu theme draft updated.', 'clever-mega-menu')
        );

        return $messages;
    }

    /**
     * Disable quick edit
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     *
     * @see    https://developer.wordpress.org/reference/hooks/post_row_actions-5/
     */
    function _remove_quick_edit($actions, WP_Post $post)
    {
        if ('clever_menu_theme' !== $post->post_type) {
            return $actions;
        }

        unset($actions['inline hide-if-no-js']);

        return $actions;
    }
}
