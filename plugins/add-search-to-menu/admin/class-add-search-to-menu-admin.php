<?php

/**
 * The Add Search To Menu Admin defines all functionality for the dashboard
 * of the plugin.
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @package ASTM
 * @since    1.0.0
 */
class Add_Search_To_Menu_Admin {

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
	 * are we network activated?
	 */
	private $networkactive;

	/**
	 * Initializes this class and stores the current version of this plugin.
	 *
	 * @param    string    $version    The current version of this plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
		$this->options = get_option( 'add_search_to_menu' );
		$this->networkactive = ( is_multisite() && array_key_exists( plugin_basename( __FILE__ ), (array) get_site_option( 'active_sitewide_plugins' ) ) );
	}

	/**
	 * PHP 4 Compatible Constructor
	 *
	 */
	function Add_Search_To_Menu_Admin() {
		$this->__construct();
	}

	/**
	 * Loads plugin javascript and stylesheet files in the admin area
	 *
	 */
	function add_search_to_menu_load_admin_assets(){

		wp_register_script( 'add-search-to-menu-scripts', plugins_url( '/js/add-search-to-menu-admin.js', __FILE__ ), array( 'jquery' ), '1.0', true  );

		wp_localize_script( 'add-search-to-menu-scripts', 'add_search_to_menu', array(
			'ajax_url' => admin_url( 'admin-ajax.php' )
		) );

		// Enqueued script with localized data.
		wp_enqueue_script( 'add-search-to-menu-scripts' );
	}

	/**
	 * Add a link to the settings page to the plugins list
	 *
	 * @param array  $links array of links for the plugins, adapted when the current plugin is found.
	 * @param string $file  the filename for the current plugin, which the filter loops through.
	 *
	 * @return array $links
	 */
	function add_search_to_menu_settings_link( $links, $file ) {

		if ( false !== strpos( $file, 'add-search-to-menu' ) ) {
			$mylinks = array(
				'<a href="http://freewptp.com/forum/wordpress-plugins-forum/add-search-to-menu/">' . esc_html__( 'Get Support', 'add-search-to-menu' ) . '</a>',
				'<a href="options-general.php?page=add_search_to_menu">' . esc_html__( 'Settings', 'add-search-to-menu' ) . '</a>'
			);
			$links = array_merge( $mylinks, $links );
		}
		return $links;
	}

	/**
	 * Displays plugin configuration notice in admin area
	 *
	 */
	function add_search_to_menu_setup_notice(){

		if ( strpos( get_current_screen()->id, 'settings_page_add_search_to_menu' ) === 0 )
			return;

		$hascaps = $this->networkactive ? is_network_admin() && current_user_can( 'manage_network_plugins' ) : current_user_can( 'manage_options' );

		if ( $hascaps ) {
			$url = is_network_admin() ? network_site_url() : site_url( '/' );
			echo '<div class="notice notice-info is-dismissible add-search-to-menu"><p>' . sprintf( __( 'To configure <em>Add Search To Menu plugin</em> please visit its <a href="%1$s">configuration page</a> and to get plugin support contact us on <a href="%2$s" target="_blank">plugin support forum</a> or <a href="%3$s" target="_blank">contact us page</a>.', 'add-search-to-menu'), $url . 'wp-admin/options-general.php?page=add_search_to_menu', 'http://freewptp.com/forum/wordpress-plugins-forum/add-search-to-menu/', 'http://freewptp.com/contact/' ) . '</p></div>';
		}
	}

	/**
	 * Handles plugin notice dismiss functionality using AJAX
	 *
	 */
	function add_search_to_menu_notice_dismiss() {

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			$options = $this->options;
			$options['dismiss_admin_notices'] = 1;
			update_option( 'add_search_to_menu', $options );
		}
		die();
	}

	/* Registers menu item */
	function add_search_to_menu_admin_menu_setup(){
		add_submenu_page( 'options-general.php', __( 'Add Search To Menu Settings', 'add-search-to-menu' ), __( 'Add Search To Menu', 'add-search-to-menu' ), 'manage_options', 'add_search_to_menu', array( $this, 'add_search_to_menu_admin_page_screen' ) );
	}

	/* Displays plugin admin page content */
	function add_search_to_menu_admin_page_screen() { ?>
		<div class="wrap">
			<form id="add_search_to_menu_options" action="options.php" method="post">
				<?php
					settings_fields( 'add_search_to_menu' );
					do_settings_sections( 'add_search_to_menu' );
					submit_button( 'Save Options', 'primary', 'add_search_to_menu_options_submit' );
				?>
				<div id="after-submit">
					<p>
						<?php esc_html_e( 'Like Add Search To Menu?', 'add-search-to-menu' ); ?> <a href="https://wordpress.org/support/plugin/add-search-to-menu/reviews/?filter=5#new-post" target="_blank"><?php esc_html_e( 'Give us a rating', 'add-search-to-menu' ); ?></a>
					</p>
					<p>
						<?php esc_html_e( 'Need Help or Have Suggestions?', 'add-search-to-menu' ); ?> <?php esc_html_e( 'contact us on', 'add-search-to-menu' ); ?> <a href="http://freewptp.com/forum/wordpress-plugins-forum/add-search-to-menu/" target="_blank"><?php esc_html_e( 'Plugin support forum', 'add-search-to-menu' ); ?></a> <?php esc_html_e( 'or', 'add-search-to-menu' ); ?> <a href="http://freewptp.com/contact/" target="_blank"><?php esc_html_e( 'Contact us page', 'add-search-to-menu' ); ?></a>
					</p>
					<p>
						<?php esc_html_e( 'Access Plugin Documentation on', 'add-search-to-menu' ); ?> <a href="http://freewptp.com/plugins/add-search-to-menu/" target="_blank">http://freewptp.com/plugins/add-search-to-menu/</a>
					</p>
				</div>
			 </form>
		</div>
		<?php
	}

	/* Registers settings */
	function add_search_to_menu_settings_init(){

		add_settings_section( 'add_search_to_menu_section', __( 'Add Search To Menu Settings', 'add-search-to-menu' ),  array( $this, 'add_search_to_menu_section_desc'), 'add_search_to_menu' );

		add_settings_field( 'add_search_to_menu_locations', __( 'Add Search to Menu : ', 'add-search-to-menu' ),  array( $this, 'add_search_to_menu_locations' ), 'add_search_to_menu', 'add_search_to_menu_section' );
		add_settings_field( 'add_search_to_menu_style', __( 'Select Style : ', 'add-search-to-menu' ),  array( $this, 'add_search_to_menu_style' ), 'add_search_to_menu', 'add_search_to_menu_section' );
		add_settings_field( 'add_search_to_menu_title', __( 'Search Menu Title : ', 'add-search-to-menu' ),  array( $this, 'add_search_to_menu_title' ), 'add_search_to_menu', 'add_search_to_menu_section' );
		add_settings_field( 'add_search_to_menu_classes', __( 'Search Menu Classes : ', 'add-search-to-menu' ),  array( $this, 'add_search_to_menu_classes' ), 'add_search_to_menu', 'add_search_to_menu_section' );
		add_settings_field( 'do_not_load_plugin_files', __( 'Do not load plugin files : ', 'add-search-to-menu' ),  array( $this, 'do_not_load_plugin_files' ), 'add_search_to_menu', 'add_search_to_menu_section' );

		register_setting( 'add_search_to_menu', 'add_search_to_menu' );

	}

	/* Displays plugin description text */
	function add_search_to_menu_section_desc(){
		echo '<p>' . esc_html__( 'Configure the Add Search To Menu plugin settings here.', 'add-search-to-menu' ) . '</p>';
	}

	/* add search to menu choose locations field output */
	function add_search_to_menu_locations() {

		$options = $this->options;
		$html = '';
		$menus = get_registered_nav_menus();

		if ( ! empty( $menus ) ){

			if ( empty( $options ) ){
				$location = array_keys( $menus );
				$options['add_search_to_menu_locations'][ $location[0] ] = $location[0];

				update_option( 'add_search_to_menu', $options );
			}

			if ( isset( $options['add_search_to_menu_locations']['initial'] ) ){
				unset( $options['add_search_to_menu_locations']['initial'] );
				$location = array_keys( $menus );
				$options['add_search_to_menu_locations'][ $location[0] ] = $location[0];
				update_option( 'add_search_to_menu', $options );
			}

			foreach ( $menus as $location => $description ) {

				$check_value = isset( $options['add_search_to_menu_locations'][$location] ) ? $options['add_search_to_menu_locations'][ $location ] : 0;
				$html .= '<input type="checkbox" id="add_search_to_menu_locations' . esc_attr( $location ) . '" name="add_search_to_menu[add_search_to_menu_locations][' . esc_attr( $location ) . ']" value="' . esc_attr( $location ) . '" ' . checked( $location, $check_value, false ) . '/>';
				$html .= '<label for="add_search_to_menu_locations' . esc_attr( $location ) . '"> ' . esc_html( $description ) . '</label><br />';
			}
		} else {
			$html = __( 'No navigation menu registered on your site.', 'add-search-to-menu' );
		}
		echo $html;

	}

	/* add search to menu select style field output */
	function add_search_to_menu_style() {

		$options = $this->options;
		$styles = array(
			'default'	  => __( 'Default', 'add-search-to-menu' ),
			'dropdown'	  => __( 'Dropdown', 'add-search-to-menu' ),
			'sliding'	  => __( 'Sliding', 'add-search-to-menu' ),
			'full-width-menu' => __( 'Full Width', 'add-search-to-menu' )
		);

		if ( empty( $options ) || ! isset( $options['add_search_to_menu_style'] ) ) {
			$options['add_search_to_menu_style'] = 'default';
			update_option( 'add_search_to_menu', $options );
		}

		$html = '';
		$check_value = isset( $options['add_search_to_menu_style'] ) ? $options['add_search_to_menu_style'] : 'default';

		foreach ( $styles as $key => $style ) {

			$html .= '<input type="radio" id="add_search_to_menu_style' . esc_attr( $key ) . '" name="add_search_to_menu[add_search_to_menu_style]" value="' . esc_attr( $key ) . '" ' . checked( $key, $check_value, false ) . '/>';
			$html .= '<label for="add_search_to_menu_style' . esc_attr( $key ) . '"> ' . esc_html( $style ) . '</label><br />';
		}
		echo $html;
	}

	/* add search to menu title field output */
	function add_search_to_menu_title() {

		$options = $this->options;
		$options['add_search_to_menu_title'] = isset( $options['add_search_to_menu_title'] ) ? $options['add_search_to_menu_title'] : '';
		$html = '<input type="text" id="add_search_to_menu_title" name="add_search_to_menu[add_search_to_menu_title]" value="' . esc_attr( $options['add_search_to_menu_title'] ) . '" size="50" />';
		$html .= '<br /><label for="add_search_to_menu_title" style="font-size: 10px;">' . esc_html__( "If title field is not set then instead of title the search icon displays in navigation menu.", 'add-search-to-menu' ) . '</label>';
		echo $html;
	}

	/* add search to menu classes field output */
	function add_search_to_menu_classes() {

		$options = $this->options;
		$options['add_search_to_menu_classes'] = isset( $options['add_search_to_menu_classes'] ) ? $options['add_search_to_menu_classes'] : 'search-menu';
		$html = '<input type="text" id="add_search_to_menu_classes" name="add_search_to_menu[add_search_to_menu_classes]" value="' . esc_attr( $options['add_search_to_menu_classes'] ) . '" size="50" />';
		echo $html;
	}

	 /* add search to menu do not load plugin files field output */
	function do_not_load_plugin_files() {

		$options = $this->options;
		$styles = array(
			'plugin-css-file' => __( 'Plugin CSS File', 'add-search-to-menu' ),
			'plugin-js-file' => __( 'Plugin JavaScript File', 'add-search-to-menu' )

		);


		$html = '';
		foreach ( $styles as $key => $file ) {

			$check_value = isset( $options['do_not_load_plugin_files'][ $key] ) ? $options['do_not_load_plugin_files'][ $key ] : 0;
			$html .= '<input type="checkbox" id="do_not_load_plugin_files' . esc_attr( $key ) . '" name="add_search_to_menu[do_not_load_plugin_files][' . esc_attr( $key ) . ']" value="' . esc_attr( $key ) . '" ' . checked( $key, $check_value, false ) . '/>';
			$html .= '<label for="do_not_load_plugin_files' . esc_attr( $key ) . '"> ' . esc_html( $file ) . '</label>';

			if ( $key == 'plugin-css-file' ){
				$html .= '<br /><label for="add_search_to_menu_title" style="font-size: 10px;">' . esc_html__( 'If checked, you have to add following plugin file code into your theme CSS file.', 'add-search-to-menu' ) . '</label>';
				$html .= '<br /><a target="_blank" href="' . plugins_url( '/add-search-to-menu/public/js/add-search-to-menu.js' ) . '"/a>' . plugins_url( '/add-search-to-menu/public/js/add-search-to-menu.js' ) . '</a>';
				$html .= '<br /><br />';
			} else {
				$html .= '<br /><label for="add_search_to_menu_title" style="font-size: 10px;">' . esc_html__( "If checked, you have to add following plugin file code into your theme JavaScript file.", 'add-search-to-menu' ) . '</label>';
				$html .= '<br /><a target="_blank" href="' . plugins_url( '/add-search-to-menu/public/css/add-search-to-menu.css' ) . '"/a>' . plugins_url( '/add-search-to-menu/public/css/add-search-to-menu.css' ) . '</a>';
			}
		}
		echo $html;
	}

}