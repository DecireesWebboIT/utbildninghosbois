<?php 

add_action('wp_head', 'cpotheme_styling_custom', 19);
function cpotheme_styling_custom(){
	$primary_color = cpotheme_get_option('primary_color'); ?>
	<style type="text/css">
		<?php if($primary_color != ''): ?>
		<?php $faded_primary_color = cpotheme_alter_brightness($primary_color, -30); ?>
		.button, 
		.button:link, 
		.button:visited, 
		input[type=submit] { background:<?php echo $primary_color; ?>; box-shadow:3px 3px 0 0 <?php echo $faded_primary_color; ?> }
		.menu-main .current_page_ancestor > a,
		.menu-main .current-menu-item > a { color:<?php echo $primary_color; ?>; }
		.menu-portfolio .current-cat a,
		.pagination .current { background-color:<?php echo $primary_color; ?>; }
		<?php endif; ?>
    </style>
	<?php
}


//set settings defaults
add_filter('cpotheme_customizer_controls', 'cpotheme_customizer_controls');
function cpotheme_customizer_controls($data){ 
	//Layout
	$data['home_order']['default'] = 'slider,tagline,features,portfolio,testimonials,content';
	$data['slider_height']['default'] = 430;
	$data['features_columns']['default'] = 2;
	$data['portfolio_columns']['default'] = 3;
	//Content
	$data['home_features']['default'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
	//Typography
	$data['type_headings']['default'] = 'Average+Sans';
	$data['type_nav']['default'] = 'Open+Sans:700';
	$data['type_body']['default'] = 'Open+Sans';
	//Colors
	$data['primary_color']['default'] = '#9fc748';
	$data['secondary_color']['default'] = '#9fc748';
	$data['type_headings_color']['default'] = '#33333a';
	$data['type_widgets_color']['default'] = '#33333a';
	$data['type_nav_color']['default'] = '#77777f';
	$data['type_body_color']['default'] = '#77777f';
	$data['type_link_color']['default'] = '#7ea329';
	
	return $data;
}


add_filter('cpotheme_background_args', 'cpotheme_background_args');
function cpotheme_background_args($data){ 
	$data = array('default-color' => 'f0f0f8');
	return $data;
}