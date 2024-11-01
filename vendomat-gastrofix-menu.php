<?php
/*
Plugin Name:  Vendomat GASTROFIX Menu Plugin
Description:  Digitale Speisekarte direkt aus der GASTROFIX Kasse
Version:      1.0.1
Author:       GASTROFIX Schweiz
Author URI:   https://vendomat.ch
License:      GPL2
*/

defined( 'ABSPATH' ) or die();

require_once(plugin_dir_path( __FILE__ ) . 'plugin_settings.php');
require_once(plugin_dir_path( __FILE__ ) . 'extensions/general.php');
require_once(plugin_dir_path( __FILE__ ) . 'extensions/requests/licenseHandler.php');
require_once(plugin_dir_path( __FILE__ ) . 'extensions/requests/requestHandler.php');
require_once(plugin_dir_path( __FILE__ ) . 'admin_menu.php');

// WP enqeue
add_action('admin_enqueue_scripts', 'gastrofix_menu_wp_enqeue', 1);

// Attach menu to administration panel
add_action('admin_menu', 'gastrofix_menu_plugin_menu', 2);

// Add register settings to plugin
add_action('admin_init', 'gastrofix_menu_register_plugin_settings', 3);

// Ajax Handler
add_action('wp_ajax_gastrofix_menu_send_request', 'gastrofix_menu_send_request');
add_action('wp_ajax_nopriv_gastrofix_menu_send_request', 'gastrofix_menu_send_request');
?>