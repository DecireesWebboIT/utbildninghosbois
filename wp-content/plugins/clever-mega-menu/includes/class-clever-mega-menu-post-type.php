<?php
/**
 * Clever_Mega_Menu_Post_Type
 *
 * @package    Clever_Mega_Menu
 */
final class Clever_Mega_Menu_Post_Type
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
            'name'          => esc_html__('Clever Mega Menu Items', 'clever-mega-menu'),
            'singular_name' => esc_html__('Clever Mega Menu Item', 'clever-mega-menu'),
            'all_items'     => esc_html__('All Menu Items', 'clever-mega-menu'),
        );

        $args = array(
            'labels'       => $labels,
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => false,
            'supports'     => array('title', 'editor')
        );

        $this->post_type = register_post_type('clever_menu', $args);
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
        $messages['clever_menu'] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => esc_html__('Clever menu updated.', 'clever-mega-menu'),
            2  => esc_html__('Custom field updated.', 'clever-mega-menu'),
            3  => esc_html__('Custom field deleted.', 'clever-mega-menu'),
            4  => esc_html__('Clever menu updated.', 'clever-mega-menu'),
            5  => isset($_GET['revision']) ? esc_html__('Clever menu restored to revision from', 'clever-mega-menu') . ' ' . wp_post_revision_title(absint($_GET['revision'])) : false,
            6  => esc_html__('Clever menu published.', 'clever-mega-menu'),
            7  => esc_html__('Clever menu saved.', 'clever-mega-menu'),
            8  => esc_html__('Clever menu submitted.', 'clever-mega-menu'),
            9  => esc_html__('Clever menu scheduled.', 'clever-mega-menu'),
            10 => esc_html__('Clever menu draft updated.', 'clever-mega-menu')
        );

        return $messages;
    }

    /**
     * Filter VC js status
     *
     * @internal    Used as a callback. PLEASE DO NOT RECALL THIS METHOD DIRECTLY!
     */
    function _filter_cs_js_status($status)
    {
        if ($GLOBALS['post']->post_type === 'clever_menu') {
            return 'true'; // String only!
        }

        return $status;
    }
}
