<?php

/**
 * The Add Search To Menu Public defines all functionality of plugin
 * for the site front
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @package ASTM
 * @since    1.0.0
 */
class Add_Search_To_Menu_Public {

	/**
	 * Global plugin option.
	 */
	 public $options;

	/**
	 * A reference to the version of the plugin that is passed to this class from the caller.
	 *
	 * @access private
	 * @var    string    $version    The current version of the plugin.
	 */
	private $version;

	/**
	 * Initializes this class and stores the current version of this plugin.
	 *
	 * @param    string    $version    The current version of this plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
		$this->options = get_option( 'add_search_to_menu' );
	}

	/**
	 * PHP 4 Compatible Constructor
	 *
	 */
	function Add_Search_To_Menu_Public() {
		$this->__construct();
	}

	/* Enqueues search menu style and script files */
	function add_search_to_menu_script_style(){

		$options = $this->options;

		if ( ! isset( $options['do_not_load_plugin_files']['plugin-css-file'] ) ){
			wp_enqueue_style( 'add-search-to-menu-styles', plugins_url( '/css/add-search-to-menu.css', __FILE__ )  );
		}

		if ( ! isset( $options['do_not_load_plugin_files']['plugin-js-file'] ) && ( isset( $options['add_search_to_menu_style'] ) && $options['add_search_to_menu_style'] != 'default' ) ) {
			wp_enqueue_script( 'add-search-to-menu-scripts', plugins_url( '/js/add-search-to-menu.js', __FILE__ ), array( 'jquery' ), '1.0', true  );
		}
	}

	/* Adds search in the navigation bar in the front end of site */
	function add_search_to_menu_items( $items, $args ){

		$options = $this->options;

		if ( isset( $options['add_search_to_menu_locations'] ) ) {

			if ( isset( $options['add_search_to_menu_locations']['initial'] ) ) {
				unset( $options['add_search_to_menu_locations']['initial'] );
				$options['add_search_to_menu_locations'][$args->theme_location] = $args->theme_location;
				update_option( 'add_search_to_menu', $options );
			}

			if ( isset( $options['add_search_to_menu_locations'][$args->theme_location] ) ) {

				$search_class = isset( $options['add_search_to_menu_classes'] ) ? $options['add_search_to_menu_classes'].' search-menu ' : 'search-menu ';
				$search_class .= isset( $options['add_search_to_menu_style'] ) ? $options['add_search_to_menu_style'] : 'default';
				$title = isset( $options['add_search_to_menu_title'] ) ? $options['add_search_to_menu_title'] : '';
				$items .= '<li class="' . esc_attr( $search_class ) . '"><a title="' . esc_attr( $title ) . '" href="#">';

				if ( $options['add_search_to_menu_style'] != 'default' ){
					if ( $title == '' ) {
						$items .= '<svg width="20" height="20" class="search-icon" role="img">
						<path class="search-icon-path" d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>';
					} else {
						$items .= $title;
					}
				}
				$items .= get_search_form( false ) . '</a></li>';

				$items .= '</li>';
			}
		}
		return $items;
	}

}