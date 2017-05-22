<?php if(!isset($content_width)) $content_width = 640;
define('CPOTHEME_ID', 'affluentpro');
define('CPOTHEME_NAME', 'Affluent Pro');
define('CPOTHEME_VERSION', '2.2.0');
//Other constants
define('CPOTHEME_LOGO_WIDTH', '175');
define('CPOTHEME_USE_SLIDES', true);
define('CPOTHEME_USE_FEATURES', true);
define('CPOTHEME_USE_PORTFOLIO', true);
define('CPOTHEME_USE_TESTIMONIALS', true);

//Load Core; check existing core or load development core
$core_path = get_template_directory().'/core/';
if(defined('CPOTHEME_CORE')) $core_path = CPOTHEME_CORE;
require_once $core_path.'init.php';

$include_path = get_template_directory().'/includes/';

//Main components
require_once($include_path.'setup.php');

// Add welcome screen
require get_template_directory() . '/core/welcome-screen/welcome-page-setup.php';