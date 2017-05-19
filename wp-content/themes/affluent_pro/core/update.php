<?php


//Create settings page
add_action('admin_menu', 'cpotheme_license');
function cpotheme_license(){
	add_options_page(__('CPOThemes License', 'cpotheme'), __('CPOThemes License', 'cpotheme'), 'manage_options', 'cpotheme_license', 'cpotheme_license_page');
}

//Render settings page
function cpotheme_license_page(){
	echo '<div class="wrap">';
	echo '<h2>'.__('CPOThemes License', 'cpotheme').'</h2>';
	//settings_errors();
	echo '<form method="post" action="options.php">';
    settings_fields('license_'.CPOTHEME_ID);
    do_settings_sections('license_'.CPOTHEME_ID);          
    submit_button(__('Activate Your License', 'cpotheme'));
    echo '</form>';
	echo '</div>';
}


//Create settings fields
add_action('admin_init', 'cpotheme_license_fields');
function cpotheme_license_fields(){
	$option_values = get_option('license_'.CPOTHEME_ID);
	
	//Register new setting
	register_setting('license_'.CPOTHEME_ID, 'license_'.CPOTHEME_ID, 'cpotheme_license_activate');
	
	//Add sections to the settings page
	add_settings_section('license_'.CPOTHEME_ID, '', 'cpotheme_license_section', 'license_'.CPOTHEME_ID);
	
	//Add settings & controls
	$settings = cpotheme_license_metadata();
	foreach($settings as $setting_id => $setting_data){
		$setting_data['id'] = $setting_id;
		$setting_data['value'] = $option_values;
		add_settings_field($setting_id, $setting_data['label'], 'cpotheme_license_field', 'license_'.CPOTHEME_ID, 'license_'.CPOTHEME_ID, $setting_data);
	}
}

//Print section heading and create message
function cpotheme_license_section($args){
	$current_license = get_option('license_'.CPOTHEME_ID);
	$current_license_status = cpotheme_get_option('license_'.CPOTHEME_ID.'_status');

	echo '<div class="cpotheme-notice">';
	if($current_license != false && $current_license != ''){
		if($current_license_status == 'invalid'){
			echo '<div class="cpotheme-message cpotheme-message-error">';
			echo __('The theme license you entered is invalid.', 'cpotheme');
			echo '</div>';
		}elseif($current_license_status == 'valid'){
			echo '<div class="cpotheme-message cpotheme-message-success">';
			echo __('Your license key has been activated.', 'cpotheme');
			echo '</div>';
		}
	}
	printf(__('Please add your CPOThemes license key in order to get automatic theme updates for %s directly from your WordPress site.', 'cpotheme'), CPOTHEME_NAME);
	echo '<br>';
	echo '<a target="_blank" href="//www.cpothemes.com/dashboard/purchase-history">'.__('Obtain the license key at CPOThemes', 'cpotheme').'</a>';
	
	echo '<div class="cpotheme-wizard-clear"></div>';
	echo '</div>';
}


function cpotheme_license_field($args){ 
	if(!isset($args['class'])) $args['class'] = '';
	if(!isset($args['placeholder'])) $args['placeholder'] = '';
	switch($args['type']){
		case 'text': 
		echo '<input name="license_'.CPOTHEME_ID.'" type="text" id="'.$args['id'].'" value="'.$args['value'].'" placeholder="'.$args['placeholder'].'" class="regular-text '.$args['class'].'"/>';
		break;
	}
}


//Settings
function cpotheme_license_metadata(){
	$data = array();
	
	$data['license'] = array(
	'label' => __('License Key', 'cpotheme'),
	'description' => __('Add your theme license key to enable automatic updates from the dashboard.', 'cpotheme').'<br><a href="http://www.cpothemes.com/dashboard/purchase-history" target="_blank">'.__('Get Your License Key.', 'cpotheme').'</a>',
	'section' => 'cpotheme_license',
	'type' => 'text',
	'width' => '350px');
	
	return $data;
}

	
//Theme licenses
if(!function_exists('cpotheme_license_setup')){
	add_action('admin_init', 'cpotheme_license_setup');
	function cpotheme_license_setup(){
		$license = trim(cpotheme_get_option('license_'.CPOTHEME_ID));
		$updater = new CPOTheme_Core_Updater(array(
			'remote_api_url'=> CPOCORE_STORE,
			'author'	=> CPOCORE_AUTHOR,
			'version' => CPOTHEME_VERSION,
			'item_name' => CPOTHEME_NAME,
			'license' => $license,
			'url' => home_url())
		);
	}
}


//Manage license activation
function cpotheme_license_activate($new_license){
	$current_license = get_option('license_'.CPOTHEME_ID);
	$license_status = cpotheme_get_option('license_'.CPOTHEME_ID.'_status');

	//Check license if not currently active, or if not empty and different from current one
	if($new_license != '' && ($license_status != 'valid' || $new_license != $current_license)){
		$args = array(
		'edd_action' => 'activate_license', 
		'license' => urlencode($new_license), 
		'item_name' => urlencode(CPOTHEME_NAME));
		$response = wp_remote_get(add_query_arg($args, CPOCORE_STORE), array('timeout' => 15, 'sslverify' => false));

		if(!is_wp_error($response)){
			$license_data = json_decode(wp_remote_retrieve_body($response));
			cpotheme_update_option('license_'.CPOTHEME_ID.'_status', $license_data->license);
		}
	}elseif($new_license == ''){
		cpotheme_update_option('license_'.CPOTHEME_ID.'_status', '');		
	}
	return urlencode($new_license);
}


//Manage license activation
if(!function_exists('cpotheme_license_notice')){
	add_action('admin_notices', 'cpotheme_license_notice');
	function cpotheme_license_notice(){
		$current_license_dismissed = trim(cpotheme_get_option(CPOTHEME_ID.'_license', 'cpotheme_settings', false));
		
		//If notice hasn't been explicitly dismissed, display it
		if(current_user_can('manage_options')){
			if($current_license_dismissed != 'dismissed'){
				$current_license = get_option('license_'.CPOTHEME_ID);
				$current_license_status = trim(cpotheme_get_option('license_'.CPOTHEME_ID.'_status', 'cpotheme_settings', false));

				if($current_license_status != 'valid'){
					$core_path = defined('CPOTHEME_CORE_URL') ? CPOTHEME_CORE_URL : get_template_directory_uri().'/core/';
					echo '<div id="message" class="updated">';
					echo '<div class="cpotheme-notice">';
					echo '<img class="cpotheme-notice-image" src="'.$core_path.'images/ct-icon.png">';
					echo '<a href="'.add_query_arg('ctdismiss', CPOTHEME_ID.'_license').'" class="cpothemes-notice-dismiss">'.__('Dismiss This Notice', 'cpotheme').'</a>';
					if($current_license_status == 'invalid' && $current_license != ''){
						echo '<span style="color:red;">';
						echo __('The theme license you entered is invalid!', 'cpotheme');
						echo '<br></span>';
					}
					echo __('Please add your CPOThemes license key in order to get automatic theme updates from your dashboard.', 'cpotheme');
					echo '<br>';
					echo '<b><a href="options-general.php?page=cpotheme_license">'.__('Enter License Key', 'cpotheme').'</a></b>';
					echo ' | ';
					echo '<a target="_blank" href="//www.cpothemes.com/dashboard/purchase-history">'.__('Obtain the license key at CPOThemes', 'cpotheme').'</a>';
					
					echo '<div class="cpotheme-wizard-clear"></div>';
					echo '</div>';
					echo '</div>';
				}
			}
		}
	}
}