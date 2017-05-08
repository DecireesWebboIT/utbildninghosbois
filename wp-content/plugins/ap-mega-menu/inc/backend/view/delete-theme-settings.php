<?php defined('ABSPATH') or die("No script kiddies please!");
global $wpdb;
$themeid = $_GET['theme_id'];
$table_name = $wpdb->prefix . "apmm_custom_theme";
$wpdb->delete( $table_name, array( 'theme_id' => $themeid ), array( '%d' ) );
$_SESSION['apmm_success'] = __('Custom Theme deleted successfully.',APMM_TD);
wp_redirect(admin_url().'admin.php?page=wpmm-theme-settings');
exit;