<?php
/**
 * Named constant definitions.
 * 
 * @since 1.4.0 Removed option group.
 * @since 1.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Definitions
 */

if (!defined('ABSPATH')) exit;

/**
 * Plugin token.
 * 
 * @since 1.2.0 Renamed definition.
 * @since 1.0.0
 * 
 * @var string
 */
define('NMM_TOKEN', 'noakes_menu_manager');

/**
 * Plugin version.
 * 
 * @since 1.2.0 Renamed definition.
 * @since 1.0.0
 * 
 * @var string
 */
define('NMM_VERSION', '1.4.2');

/**
 * Plugin version option name.
 * 
 * @since 1.2.0 Renamed definition.
 * @since 1.0.0
 * 
 * @var string
 */
define('NMM_OPTION_VERSION', NMM_TOKEN . '_version');

/**
 * Plugin settings option name.
 * 
 * @since 1.2.0 Renamed definition.
 * @since 1.0.0
 * 
 * @var string
 */
define('NMM_OPTION_SETTINGS', NMM_TOKEN . '_settings');

/**
 * Setting name for preserving options.
 * 
 * @since 1.2.0 Renamed definition.
 * @since 1.0.0
 * 
 * @var string
 */
define('NMM_SETTING_PRESERVE_OPTIONS', 'preserve_options');

/**
 * Setting name for removing post meta.
 * 
 * @since 1.2.0 Renamed definition.
 * @since 1.0.0
 * 
 * @var string
 */
define('NMM_SETTING_PRESERVE_POST_META', 'preserve_post_meta');

/**
 * Plugin settings option name.
 * 
 * @since 1.4.0
 * 
 * @var string
 */
define('NMM_OPTION_GENERATOR', NMM_TOKEN . '_generator');

/**
 * Menu widget ID.
 * 
 * @since 1.4.0
 * 
 * @var string
 */
define('NMM_WIDGET_ID_MENU', 'noakes_menu');
