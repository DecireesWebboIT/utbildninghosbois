<?php defined( 'ABSPATH' ) OR exit;
/*
Plugin Name: Post State Tags
Plugin URI: http://wordpress.org/plugins/post-state-tags/
Description: Make your WordPress post state list stand out with colors and color tags (draft, pending, sticky, etc)
Version: 1.1.6
Author: BRANDbrilliance
Author URI: http://www.brandbrilliance.co.za
License: GPLv2 or later
Text Domain: post-state-tags
Domain Path: /languages

Copyright 2016  BRANDbrilliance  (email : code@brandbrilliance.co.za)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

require_once('libraries/colorhsl.php');

const VERSION = '1.1.6';

const TEXT_DOMAIN = 'post-state-tags';
const ADMIN_PAGE_OPTIONS = 'bb_pst_admin_options';
const OPTION_INSTALLED = 'bb_pst_installed';
const OPTION_VERSION	= 'bb_pst_version';

const SETTINGS_ERRORS = 'bb_pst_settings_errors';
const SETTINGS_SECTION_GENERAL = 'bb_pst_settings_section_general';
const SETTINGS_SECTION_COLORS_DEFAULT = 'bb_pst_settings_section_colors_default';
const SETTINGS_SECTION_COLORS_SPECIAL = 'bb_pst_settings_section_colors_special';
const SETTINGS_SECTION_COLORS_CUSTOM = 'bb_pst_settings_section_colors_custom';
const SETTINGS_SECTION_RESET = 'bb_pst_settings_section_reset';
const SETTING_COLORS_PFX = 'bb-pst-color-';
const SETTINGS_PAGE_DEFAULT = 'bb_pst_settings_page_default';
const SETTINGS_PAGE_RESET = 'bb_pst_settings_page_reset';
const SETTING_ENABLED = 'bb_pst_setting_enabled';
const SETTING_ICONS = 'bb_pst_setting_icons';


$GLOBALS['SETTINGS']['post']['stati'] = array (
	'defaults' => array('publish', 'draft', 'pending', 'private', 'future', 'trash'),
	'special' => array('protected', 'sticky', 'page_on_front', 'page_for_posts'),
	'colors' => array(
		'publish'				=> '',
		'draft'					=> '#2ea2cc',
		'pending'				=> '#7ad03a',
		'private'				=> '#ffba00',
		'future'				=> '#aaaaaa',
		'trash'					=> '',
		'protected'			=> '#d54e21',
		'sticky'				=> '#9859b9',
		'page_on_front'	=> '#000000', // WP 4.2 
		'page_for_posts'=> '#000000', // WP 4.2
		'archive' 			=> '#a67c52', // Custom Plugin
	),
	'lightvalue' => 0.97, 
	'icons' => array (
		'publish' 			=> '',
		'draft' 				=> 'dashicons-edit',
		'pending' 			=> 'dashicons-format-chat',
		'private' 			=> 'dashicons-lock',
		'future' 				=> 'dashicons-calendar-alt', // not yet supported by wordpress
		'trash' 				=> 'dashicons-trash',
		'protected' 		=> 'dashicons-admin-network',
		'sticky' 				=> 'dashicons-star-filled',
		'page_on_front'	=> 'dashicons-admin-home', // WP 4.2
		'page_for_posts'=> 'dashicons-admin-post', // WP 4.2
		'archive' 			=> 'dashicons-archive', // Custom Plugin
	),
);


/**
 *  Load plugin text domain
 *
 *  @since    1.1.0
 *  @created  2015-05-23
 */
load_plugin_textdomain(TEXT_DOMAIN, false, basename( dirname( __FILE__ ) ) . '/languages' );

/**
 *  Load plugin text domain
 *
 *  @since    1.1.0
 *  @created  2015-05-23
 */
function bb_pst_reset_colors() 
{
	// Default Statuses
	$default_post_statuses = bb_pst_get_post_statuses_default();
	foreach ($default_post_statuses as $custom_post_status)
	{
    $handle = $custom_post_status['option_handle'];
    $name = $custom_post_status['name'];
    update_option($handle, $GLOBALS['SETTINGS']['post']['stati']['colors'][$name]);
    update_option($handle.'-icon', $GLOBALS['SETTINGS']['post']['stati']['icons'][$name]);
	}

	// Special Statuses
  $custom_post_statuses = bb_pst_get_post_statuses_special();
	foreach ($custom_post_statuses as $custom_post_status)
	{
    $handle = $custom_post_status['option_handle'];
		$name = $custom_post_status['name'];
	  update_option($handle, $GLOBALS['SETTINGS']['post']['stati']['colors'][$name]);
    update_option($handle.'-icon', $GLOBALS['SETTINGS']['post']['stati']['icons'][$name]);
	}	  

	// Custom Statuses
  $custom_post_statuses = bb_pst_get_post_statuses_custom();
  if (sizeof($custom_post_statuses) > 0)
  {
		foreach ($custom_post_statuses as $custom_post_status)
		{
	    $handle = $custom_post_status['option_handle'];
			$name = $custom_post_status['name'];
		  update_option($handle, $GLOBALS['SETTINGS']['post']['stati']['colors'][$name]);
			update_option($handle.'-icon', $GLOBALS['SETTINGS']['post']['stati']['icons'][$name]);
		}	  
  }
}
if (isset($_POST["bb-pst-submit-reset"]))
{
	add_action( 'admin_init', 'bb_pst_reset_colors' );
}


/**
 *  bb_pst_admin_enqueue_scripts
 *
 *  @since    1.1.0
 *  @created  2015-05-23
 */
function bb_pst_admin_enqueue_scripts($hook) {

		// Add Color styles for any page or posts page, using edit.php
		// hook: edit
    if ( 'edit.php' == $hook ) {
			// add as inline styles appended to dummy stylesheet
	    wp_enqueue_style( 'poststates', plugin_dir_url( __FILE__ ) . 'css/poststates.css' );
	    wp_add_inline_style( 'poststates', bb_pst_get_css_poststates () );
    }

		// Add Color pickers and custom styles, scripts for plugin settings page
		// hook: settings_page_bb_pst_admin_options
		if ( 'settings_page_' . ADMIN_PAGE_OPTIONS == $hook) {
			// color picker
		  wp_enqueue_style('wp-color-picker');
		  wp_enqueue_script('wp-color-picker');

			// enqueue support scripts
		  wp_enqueue_script('pst-settings-color',  plugin_dir_url( __FILE__ ) . 'js/settings.js' , array('jquery', 'wp-color-picker'));
		  wp_enqueue_script('pst-settings-dashicons',  plugin_dir_url( __FILE__ ) . 'js/dashicons-picker.js' , array('jquery'));

			// additional support styles
			wp_enqueue_style('pst-settings', plugin_dir_url( __FILE__ ) . 'css/admin.css');	
			wp_enqueue_style('pst-settings-dashicons', plugin_dir_url( __FILE__ ) . 'css/dashicons-picker.css');	
		}

}
add_action( 'admin_enqueue_scripts', 'bb_pst_admin_enqueue_scripts' );

// Generate post state classes
function bb_pst_get_css_poststates () {
	//$bold_headlines = get_theme_mod( 'headline-font-weight' ); // let's say its value is "bold"
	//$css = '.headline { font-weight: ' . $bold_headlines . '; }';

	if (get_option(SETTING_ENABLED) != 1)
		return;	

	// Background Colors
	$css = "";

	$css .= "/* Post Status Tags */
.post-state .states {
		font-size:10px;
		padding:3px 8px 3px 8px;
		-moz-border-radius:2px;
		-webkit-border-radius:2px;
		border-radius:2px;
		background:#999; /* default colors */
		color:#fff;
		white-space: nowrap;
}
/* Post Status Tags Icons */
.post-state .states .dashicons {
	width: inherit;
	height: inherit;
	font-size: inherit;
	vertical-align: -1px;
	margin-right:3px;
}

";
  
	// Default Statuses
	$default_post_statuses = bb_pst_get_post_statuses_default();
	foreach ($default_post_statuses as $custom_post_status)
	{
    $handle = $custom_post_status['option_handle'];
    $name = $custom_post_status['name'];
    $option = get_option($handle);
    $css .= bb_pst_color_builder($name, $option);
    $icon = get_option($handle.'-icon');
    $css .= bb_pst_tag_builder($name, $option, $icon);
	}

	// Special Statuses
  $custom_post_statuses = bb_pst_get_post_statuses_special();
	foreach ($custom_post_statuses as $custom_post_status)
	{
    $handle = $custom_post_status['option_handle'];
		$name = $custom_post_status['name'];
    $option = get_option($handle);
    $css .= bb_pst_color_builder($name, $option);
    $icon = get_option($handle.'-icon');
    $css .= bb_pst_tag_builder($name, $option, $icon);
	}	  

	// Custom Statuses
  $custom_post_statuses = bb_pst_get_post_statuses_custom();
  if (sizeof($custom_post_statuses) > 0)
  {
		foreach ($custom_post_statuses as $custom_post_status)
		{
	    $handle = $custom_post_status['option_handle'];
			$name = $custom_post_status['name'];
	    $option = get_option($handle);
	    $css .= bb_pst_color_builder($name, $option);
	    $icon = get_option($handle.'-icon');
	    $css .= bb_pst_tag_builder($name, $option, $icon);
		}	  
  }
	return $css;

}
function bb_pst_color_builder($status, $color) {

	// no color setup
  if ($status == '' || $color == '' || $color == 'transparent')
		return;

	// sticky is only a tag
  if ($status == 'sticky')
		return;

  $style = '';

	// map status values to classes (wordpress does this)
	switch ($status)
	{
		case 'protected':
			$class = ".post-password-required";
			break;	
		
		default: 
			$class = ".status-$status";
	}

	// use filter to modify light color
	$lightvalue = $GLOBALS['SETTINGS']['post']['stati']['lightvalue'];
	$lightvalue = apply_filters( 'bb_pst_lightvalue', $lightvalue);
	$lightcolor = get_light_color(str_replace('#', '', $color), $lightvalue);
	if ($lightcolor)
	{
		$lightcolor = "#$lightcolor";
	}
  $style .= "#the-list $class th.check-column { border-left:4px solid $color; }\n";
  $style .= "#the-list $class th.check-column input { margin-left:4px; }\n";
  $style .= "#the-list $class th, #the-list $class td { background-color:$lightcolor; }\n";

  return $style;
}
function bb_pst_tag_builder($status, $color, $icon = '') {
	// no tag needed
  if ($status == '' || $color !='' && $color == 'transparent')
		return;

	// map status values to classes (wordpress does this)
	switch ($status)
	{
		case 'future':
			$class = 'scheduled';
			break;	
		
		default: 
			$class = $status;
	}

  $style = ".post-state .$class {background:$color;color:#fff;}\n";

  return $style;
}


// Custom tag styling of post state, including removal of seperators
function bb_pst_display_post_states ( $post_states ) {

	if (get_option(SETTING_ENABLED) != 1)
		return $post_states;	

	if ( !empty($post_states) ) {
		foreach ( $post_states as $key=>&$state ) {

			// get icon
			if (get_option(SETTING_ICONS) == 1) {

				// map status values to classes (wordpress does this)
				switch ($key)
				{
					case 'scheduled':
						$lkey = 'future';
						break;	
					
					default: 
						$lkey = $key;
				}
		    $iconname = get_option(SETTING_COLORS_PFX . sanitize_key($lkey) . '-icon');
			}

			// add tag
			$state = '<span class="'. $key.' states">'. ($iconname ? '<span class="dashicons '.$iconname.'"></span>' : '') . $state . '</span>'; // strtolower( $state )
		}
		echo ' <span class="post-state">'. implode('</span> <span class="post-state">', $post_states) . '</span>';
	}
}
add_filter( 'display_post_states', 'bb_pst_display_post_states' );


/**
 *  bb_pst_register_settings
 *
 *  Register plugin settings
 *
 *  @since    1.1.0
 *  @created  2015-05-23
 */
function bb_pst_register_settings() {

		// General Options
    add_settings_section(SETTINGS_SECTION_GENERAL, __('General', TEXT_DOMAIN), 'bb_pst_settings_general_callback', SETTINGS_PAGE_DEFAULT);

    add_settings_field(SETTING_ENABLED, __('Enabled', TEXT_DOMAIN), 'bb_pst_setting_enabled_callback', SETTINGS_PAGE_DEFAULT, SETTINGS_SECTION_GENERAL);
    register_setting(SETTINGS_PAGE_DEFAULT, SETTING_ENABLED, 'bb_pst_setting_enabled_validate');

    add_settings_field(SETTING_ICONS, __('Show icons', TEXT_DOMAIN), 'bb_pst_setting_icons_callback', SETTINGS_PAGE_DEFAULT, SETTINGS_SECTION_GENERAL);
    register_setting(SETTINGS_PAGE_DEFAULT, SETTING_ICONS, 'bb_pst_setting_icons_validate');

		// Default Post Status Color Options
    add_settings_section(SETTINGS_SECTION_COLORS_DEFAULT, __('Default Post Statuses', TEXT_DOMAIN), 'bb_pst_settings_section_colors_default_callback', SETTINGS_PAGE_DEFAULT);

    $default_post_statuses = bb_pst_get_post_statuses_default();
    foreach ($default_post_statuses as $custom_post_status) 
    {
			// color
      $handle = $custom_post_status['option_handle'];
      $args = array(
          'handle' => $handle
      );
      add_settings_field($handle, __($custom_post_status['label']), 'bb_pst_setting_color_callback', SETTINGS_PAGE_DEFAULT, SETTINGS_SECTION_COLORS_DEFAULT, $args);
      register_setting(SETTINGS_PAGE_DEFAULT, $handle, 'bb_pst_setting_color_validate');

			// dashicon
      $handle = $handle . '-icon';
      $args = array(
          'handle' => $handle
      );
      add_settings_field($handle, __($custom_post_status['label']) .' '. __('Icon', TEXT_DOMAIN), 'bb_pst_setting_dashicons_callback', SETTINGS_PAGE_DEFAULT, SETTINGS_SECTION_COLORS_DEFAULT, $args);
      register_setting(SETTINGS_PAGE_DEFAULT, $handle, 'bb_pst_setting_dashicons_validate');
    }

		// Special Post Status Color Options
    add_settings_section(SETTINGS_SECTION_COLORS_SPECIAL, __('Special Post Statuses', TEXT_DOMAIN), 'bb_pst_settings_section_colors_special_callback', SETTINGS_PAGE_DEFAULT);

		$special_post_statuses = bb_pst_get_post_statuses_special();
    foreach ($special_post_statuses as $custom_post_status)
    {
			// color
      $handle = $custom_post_status['option_handle'];
      $args = array(
          'handle' => $handle
      );
      add_settings_field($handle, __($custom_post_status['label']), 'bb_pst_setting_color_callback', SETTINGS_PAGE_DEFAULT, SETTINGS_SECTION_COLORS_SPECIAL, $args);
      register_setting(SETTINGS_PAGE_DEFAULT, $handle, 'bb_pst_setting_color_validate');

			// dashicon
      $handle = $handle . '-icon';
      $args = array(
          'handle' => $handle
      );
      add_settings_field($handle, __($custom_post_status['label']) .' '. __('Icon', TEXT_DOMAIN), 'bb_pst_setting_dashicons_callback', SETTINGS_PAGE_DEFAULT, SETTINGS_SECTION_COLORS_SPECIAL, $args);
      register_setting(SETTINGS_PAGE_DEFAULT, $handle, 'bb_pst_setting_dashicons_validate');

    }

		// Add Custom Post Status Color Options
    $custom_post_statuses = bb_pst_get_post_statuses_custom();
    if (sizeof($custom_post_statuses) > 0)
    {
      add_settings_section(SETTINGS_SECTION_COLORS_CUSTOM, __('Custom Post Statuses', TEXT_DOMAIN), 'bb_pst_settings_section_colors_custom_callback', SETTINGS_PAGE_DEFAULT);
    }
    foreach ($custom_post_statuses as $custom_post_status)
    {
      // color
      $handle = $custom_post_status['option_handle'];
      $args = array(
          'handle' => $handle
      );
      add_settings_field($handle, __($custom_post_status['label']), 'bb_pst_setting_color_callback', SETTINGS_PAGE_DEFAULT, SETTINGS_SECTION_COLORS_CUSTOM, $args);
      register_setting(SETTINGS_PAGE_DEFAULT, $handle, 'bb_pst_setting_color_validate');

			// dashicon
      $handle = $handle . '-icon';
      $args = array(
          'handle' => $handle
      );
      add_settings_field($handle, __($custom_post_status['label']) .' '. __('Icon', TEXT_DOMAIN), 'bb_pst_setting_dashicons_callback', SETTINGS_PAGE_DEFAULT, SETTINGS_SECTION_COLORS_CUSTOM, $args);
      register_setting(SETTINGS_PAGE_DEFAULT, $handle, 'bb_pst_setting_dashicons_validate');

    }
}
add_action( 'admin_init', 'bb_pst_register_settings' );


function bb_pst_settings_general_callback ( array $arg ) {
	echo __('General settings of the plugin', TEXT_DOMAIN);
}
function bb_pst_settings_section_colors_default_callback ( array $arg ) {
	echo __('Sets the individual default post status colors and icons. Some colors and icons may not be used or visible.', TEXT_DOMAIN);
}
function bb_pst_settings_section_colors_special_callback ( array $arg ) {
	echo __('Sets the individual special post status colors and icons. Some colors and icons may not be used or visible.', TEXT_DOMAIN);
}
function bb_pst_settings_section_colors_custom_callback ( array $arg ) {
	echo __('Sets the individual custom post status colors and icons. Some colors and icons may not be used or visible.', TEXT_DOMAIN);
}
function bb_pst_setting_enabled_callback( array $arg ) {
    $checked = checked(get_option(SETTING_ENABLED, false), true, false);
    echo '<input type="checkbox" name="' . SETTING_ENABLED . '" value="1"' . $checked . '  />';
}
function bb_pst_setting_enabled_validate($input) {
    return $input;
}
function bb_pst_setting_icons_callback( array $arg ) {
    $checked = checked(get_option(SETTING_ICONS, false), true, false);
    echo '<input type="checkbox" name="' . SETTING_ICONS . '" value="1"' . $checked . '  />';
}
function bb_pst_setting_icons_validate($input) {
    return $input;
}
function bb_pst_setting_color_callback(array $args) {
    $handle = $args['handle'];
    $setting = get_option($handle);
    echo '<input class="bb-pst-wp-color-picker" type="text" id="' . $handle . '" name="' . $handle . '" value="' . $setting . '" />';
}
function bb_pst_setting_color_validate($input) {
    $valid = filter_var($input, FILTER_SANITIZE_STRING);

    if (!empty($valid) && bb_pst_validate_html_color($valid) == false):
        add_settings_error(SETTINGS_ERRORS, 666, __("Invalid Color", TEXT_DOMAIN), 'error');
        return false;
    endif;

    return $valid;
}
function bb_pst_validate_html_color($color) {
    if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
        return $color;
    } else if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
        $color = '#' . $color;
        return $color;
    }

    return false;
}

function bb_pst_setting_dashicons_callback(array $args) {
    $handle = $args['handle'];
    $setting = esc_attr(get_option($handle));
    echo '<input class="bb-pst-dashicons-picker" type="text" id="'.$handle.'" name="'.$handle.'" value="'.$setting .'"/>';
		echo '<input type="button" data-target="#'.$handle.'" class="button dashicons-picker" value="Choose Icon" />';
}
function bb_pst_setting_dashicons_validate($input) {
    return $input;
}


/**
 *  bb_pst_get_post_statuses, bb_pst_get_post_statuses, bb_pst_get_post_statuses
 *
 *  Get post status options, defaults and custom
 *
 *  @since    1.1.0
 *  @created  2015-05-23
 */
function bb_pst_get_post_statuses_default() {
    return bb_pst_get_post_statuses($GLOBALS['SETTINGS']['post']['stati']['defaults']);
}
function bb_pst_get_post_statuses_custom() {
    return bb_pst_get_post_statuses(array(), $GLOBALS['SETTINGS']['post']['stati']['defaults']);
}
function bb_pst_get_post_statuses($include = array(), $exclude = array()) {
  $post_stati = get_post_stati($post_stati = array(), "objects");

  $custom_post_statuses = array();

  foreach ($post_stati as $post_status) 
  {
    if ($post_status->show_in_admin_status_list === false || (sizeof($include) > 0 && !in_array($post_status->name, $include)) || in_array($post_status->name, $exclude)) 
        continue;

    $handle = SETTING_COLORS_PFX . sanitize_key($post_status->name);
    $custom_post_statuses[$post_status->name] = array("option_handle" => $handle, "label" => $post_status->label, "name" => $post_status->name);
  }

  //ksort($custom_post_statuses);
  return $custom_post_statuses;
}
// special treatment for special statuses
function bb_pst_get_post_statuses_special() {

  $custom_post_statuses = array();

  foreach ($GLOBALS['SETTINGS']['post']['stati']['special'] as $post_status)
  {
    $handle = SETTING_COLORS_PFX . sanitize_key($post_status);
		$name = $post_status;
		$label = get_special_post_label($post_status);
    $custom_post_statuses[$name] = array("option_handle" => $handle, "label" => $label, "name" => $name);
  }

  return $custom_post_statuses;
}

function get_special_post_label($post_status) {
	switch ($post_status) {
		case 'protected':
			$label = __('Password protected');
			break;

		case 'sticky':
			$label = __('Sticky');
			break;

		case 'page_on_front':
			$label = __('Front Page');
			break;

		case 'page_for_posts':
			$label = __('Posts Page');
			break;
			
		default:
			$label = __(ucfirst($post_status));
	}

	return $label;
}	

/**
 *  bb_pst_admin_menu
 *
 *  Add plugin settings page
 *
 *  @since    1.1.0
 *  @created  2015-05-23
 */
function bb_pst_admin_menu() 
{
	add_options_page( 
		__('Post State Tags Settings', TEXT_DOMAIN), //page_title
		__('Post State Tags', TEXT_DOMAIN), //menu_title
		'manage_options', //capability
		ADMIN_PAGE_OPTIONS, //page
		'bb_pst_view_settings' //callback
	);
}
add_action('admin_menu', 'bb_pst_admin_menu');


/**
 *  bb_pst_print_options
 *
 *  Print plugin options page
 *
 *  @type     callback function
 *  @since    1.1.0
 *  @created  2015-05-23
 */

function bb_pst_view_settings() 
{
	global $bb_pst_version;

	?>  
    
	<div id="post-state-tags-settings-wrap" class="wrap">    
		<?php screen_icon(); ?>
		<h2><?php esc_html_e('Post State Tags Settings', TEXT_DOMAIN); ?></h2>

		<?php settings_errors(); ?>
        
		<div id="poststuff">
		
			<div id="post-body" class="metabox-holder columns-2">

				<div id="postbox-container-2" class="postbox-container">
				
					<div class="postbox">

						<div class="inside">
							<form method="post" action="options.php">
								<?php settings_fields( SETTINGS_PAGE_DEFAULT ); ?>
								<?php do_settings_sections( SETTINGS_PAGE_DEFAULT ); ?>
								<?php submit_button(); ?>
							</form>
							<form method="post" action="<?php echo admin_url('options-general.php?page=bb_pst_admin_options') ?>" id="bb-pst-form-reset-to-defaults">
				        <?php submit_button(__('Reset Settings', TEXT_DOMAIN), 'delete', 'bb-pst-submit-reset', true, array('id' => 'bb-pst-button-reset-to-defaults', 'data-message' => __('Are you sure?', TEXT_DOMAIN))); ?>
							</form>

						</div>
					</div>
					
				</div>
                
				<div id="postbox-container-1" class="postbox-container">
				
					<div class="postbox" id="bb-credit">
                        
						<h3>Post State Tags <?php echo VERSION; ?></h3>
                        
						<div class="inside">
                        
							<h4>Changelog</h4>
							<p>What's new in <a href="http://wordpress.org/plugins/post-state-tags/changelog/" target="_blank">version <?php echo VERSION; ?></a>.</p>
							
							<h4>Support</h4>
							<p>Feel free to ask for support on the <a href="http://wordpress.org/support/plugin/post-state-tags/" target="_blank">Support Forum</a>.</p>
							
							<h4>Plugin Rating</h4>
							<p>Please <a href="http://wordpress.org/support/view/plugin-reviews/post-state-tags/" target="_blank">vote for the plugin</a>. Thanks!</p>
							                            
							<div class="author">
								Copyright &copy; <?php echo date('Y'); ?> <img src="http://www.brandbrilliance.co.za/favicon-16.png" style="vertical-align: -3px; margin-right:3px;" /><a href="http://www.brandbrilliance.co.za/" target="_blank">BRANDbrilliance</a>
							</div>
                        
						</div>
    
					</div>
					
				</div>
            
			</div>
			
		</div>
		
	</div>
 
	<?php

}


/**
 *  bb_pst_settings_links
 *
 *  Add settings link to the plugin action links
 *
 *  @since    1.1.0
 *  @created  2015-05-23
 */ 
 
function bb_pst_settings_links( $links )
{
	return array_merge(
		array(
			'settings' => '<a href="' . admin_url( 'options-general.php?page='.ADMIN_PAGE_OPTIONS). '">' . __('Settings', TEXT_DOMAIN) . '</a>'
		),
		$links
	);
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'bb_pst_settings_links' );



/**
 *  bb_pst_on_activation
 *
 *  Set default value for plugin settings during plugin activation
 *
 *  @since    1.1.0
 *  @created  15/07/13
 */ 

function bb_pst_on_activation() 
{

	if (!get_option(OPTION_INSTALLED)) 
	{
	    update_option(OPTION_INSTALLED, '1');
	    update_option(OPTION_VERSION, VERSION);
	
	    update_option(SETTING_ENABLED, '1');
	    update_option(SETTING_ICONS, '1');

			// Default Statuses
			$default_post_statuses = bb_pst_get_post_statuses_default();
			foreach ($default_post_statuses as $custom_post_status)
			{
		    $handle = $custom_post_status['option_handle'];
		    $name = $custom_post_status['name'];
				if (false === get_option($handle))
			    update_option($handle, $GLOBALS['SETTINGS']['post']['stati']['colors'][$name]);
				if (false === get_option($handle.'-icon') )
			    update_option($handle.'-icon', $GLOBALS['SETTINGS']['post']['stati']['icons'][$name]);
			}
		
			// Special Statuses
		  $custom_post_statuses = bb_pst_get_post_statuses_special();
			foreach ($custom_post_statuses as $custom_post_status)
			{
		    $handle = $custom_post_status['option_handle'];
				$name = $custom_post_status['name'];
				if ( false === get_option($handle) )
			    update_option($handle, $GLOBALS['SETTINGS']['post']['stati']['colors'][$name]);
				if ( false === get_option($handle.'-icon') )
			    update_option($handle.'-icon', $GLOBALS['SETTINGS']['post']['stati']['icons'][$name]);
			}	  
		
			// Custom Statuses
		  $custom_post_statuses = bb_pst_get_post_statuses_custom();
		  if (sizeof($custom_post_statuses) > 0)
		  {
				foreach ($custom_post_statuses as $custom_post_status)
				{
			    $handle = $custom_post_status['option_handle'];
					$name = $custom_post_status['name'];
					if ( false === get_option($handle) )
				    update_option($handle, $GLOBALS['SETTINGS']['post']['stati']['colors'][$name]);
					if ( false === get_option($handle.'-icon') )
				    update_option($handle.'-icon', $GLOBALS['SETTINGS']['post']['stati']['icons'][$name]);
				}	  
		  }
	}
}
register_activation_hook( __FILE__, 'bb_pst_on_activation' );

// Todo 
//register_deactivation_hook( __FILE__, 'bb_pst_on_deactivation' );
//register_uninstall_hook( __FILE__, 'bb_pst_on_uninstall' );

?>
