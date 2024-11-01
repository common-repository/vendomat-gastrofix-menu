<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function gastrofix_menu_register_plugin_settings() {
	$optionFields = [
		"api_licensing_group" => [
			"license_key"
		],
		"api_settings_group" => [
			"cloud_nr", "consumer_key", "secret_key", "username", "password"
		],
		"api_load_group" => [
			"gf_datas",
			"gf_last_sync"
		],
		"articlelist_store_group" => [
			"store_articles"
		]
	];

	gastrofix_menu_registerMultipleSettings($optionFields);
}

function gastrofix_menu_wp_enqeue() {
	// General JS
	wp_enqueue_script('gastrofix_menu_general_functions-script', plugins_url('/javascripts/general_functions.js', __FILE__ ), array('jquery'), false, false);
	// js classes
	wp_enqueue_script('gastrofix_menu_wpTabs-class-script', plugins_url('/javascripts/classes/wpTabs.js', __FILE__ ), array('jquery'), false, false);
	// js modules
	wp_enqueue_script('gastrofix_menu_gastrofix_loader-module-script', plugins_url('/javascripts/modules/gastrofix_loader.js', __FILE__ ), array('jquery'), false, false);
	// main.js
	wp_enqueue_script('gastrofix_menu_main-script', plugins_url('/javascripts/main.js', __FILE__ ), array('jquery'), false, false);
	// Scaffolds CSS
	wp_enqueue_style('gastrofix_menu_scaffolds-style', plugins_url('/stylesheets/scaffolds.css', __FILE__), array(), false, 'all');


	$gf_options = array(
		"cloud_nr" => get_option('cloud_nr'),
		"consumer_key" => get_option('consumer_key'),
		"secret_key" => get_option('secret_key'),
		"username" => get_option('username'),
		"password" => get_option('password')
	);
	
	wp_localize_script('gastrofix_menu_gastrofix_loader-module-script', 'gf_option', $gf_options);

	$params = array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'ajax_nonce' => wp_create_nonce('38f58a1c-264e-4b96-8acf-f0ec1ba17bdc'),
	);
	wp_localize_script( 'gastrofix_menu_general_functions-script', 'ajax_object', $params );
}

?>