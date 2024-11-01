<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function gastrofix_menu_plugin_menu() {
	// Menu Variables
	$menu_title = 'GASTROFIX Menu Plugin';
	$page_title = 'GASTROFIX Menu Plugin';
	$capability = 'manage_options';
	$main_slug = 'vendomat-gastrofix-menu';
	$icon_url = plugins_url('gf_logo.png', __FILE__);

	// Main menu
	add_menu_page($menu_title, $page_title, 'manage_options', $main_slug, 'gastrofix_menu_p_plugin_description', $icon_url);

	// Submenus for GASTROFIX API Keys
	add_submenu_page($main_slug, $menu_title, 'API Einrichtung', $capability, $main_slug . '-api-settings', 'gastrofix_menu_p_api_settings');
	add_submenu_page($main_slug, $menu_title, 'Artikelgruppen', $capability, $main_slug . '-presentation', 'gastrofix_menu_p_menu_presentation');
	add_submenu_page($main_slug, $menu_title, 'Artikelliste', $capability, $main_slug . '-articlelist', 'gastrofix_menu_p_articlelist');
}

// Option pages
$option_pages = [
	'api_settings' => plugin_dir_path( __FILE__ ) . 'option_pages/api_settings.php',
	'menu_presentation' => plugin_dir_path( __FILE__ ) . 'option_pages/menu_presentation.php',
	'articlelist' => plugin_dir_path( __FILE__ ) . 'option_pages/articlelist.php',
	'plugin_description' => plugin_dir_path( __FILE__ ) . 'option_pages/plugin_description.php'
];

// Shortcodes
require_once plugin_dir_path( __FILE__ ) . 'shortcodes.php';

// Callable Pages
function gastrofix_menu_p_api_settings() {
	if(!current_user_can('manage_options')) {
		wp_die( __('Fehlende Berichtigung!') );
	}

	global $option_pages;
	require_once $option_pages["api_settings"];
}

function gastrofix_menu_p_menu_presentation() {
	if(!current_user_can('manage_options')) {
		wp_die( __('Fehlende Berichtigung!') );
	}
	
	// Adding Scripts and Stylesheets
	wp_enqueue_style("gastrofix_menu_jquery.dataTables.min.css", plugins_url("/stylesheets/jquery.dataTables.min.css", __FILE__));
	wp_enqueue_script("gastrofix_menu_jquery.dataTables.min.js", plugins_url("/javascripts/jquery.dataTables.min.js", __FILE__));
	
	global $option_pages;
	require_once $option_pages["menu_presentation"];
}

function gastrofix_menu_p_articlelist() {
	if(!current_user_can('manage_options')) {
		wp_die( __('Fehlende Berichtigung!') );
	}
	
	// Adding Scripts and Stylesheets
	wp_enqueue_style("gastrofix_menu_jquery.dataTables.min.css", plugins_url("/stylesheets/jquery.dataTables.min.css", __FILE__));
	wp_enqueue_script("gastrofix_menu_jquery.dataTables.min.js", plugins_url("/javascripts/jquery.dataTables.min.js", __FILE__));

	global $option_pages;
	require_once $option_pages["articlelist"];
}

function gastrofix_menu_p_plugin_description() {
	if(!current_user_can('manage_options')) {
		wp_die( __('Fehlende Berichtigung!') );
	}

	global $option_pages;
	require_once $option_pages["plugin_description"];
}

?>
