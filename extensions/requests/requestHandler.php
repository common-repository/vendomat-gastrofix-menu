<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly


function gastrofix_menu_send_request() {
	check_ajax_referer('38f58a1c-264e-4b96-8acf-f0ec1ba17bdc', 'security' );

	$result;
	$req_args = array();


	$type = sanitize_text_field($_POST["type"]);
	$url = sanitize_text_field($_POST["url"]);
	$headers = $_POST["headers"];
	$body = $_POST["body"];

	/* Sanitize JSON inputs $headers, $body */
	$sanitized_json = array();
	foreach(array("header"=>$headers,"body"=>$body) as $json_key=>$json_value) {
		foreach($json_value as $key => $value) {
			$sanitized_json[$json_key][$key] = sanitize_text_field($value);
		}
	}

	// Add Body if it's defined
	if($body) {
		$req_args['body'] = $sanitized_json["body"];
	}

	// Define method of request
	if($type === "POST") {
		$result = wp_remote_post($url, array(
			'method' => "POST",
			'headers' => $sanitized_json["header"],
			'body' => $sanitized_json["body"]
		));
	} elseif ($type === "GET") {
		$result = wp_remote_get($url, array(
			'method' => "GET",
			'headers' => $sanitized_json["header"],
			'body' => $sanitized_json["body"]
		));
	};

	echo($result["body"]);
	exit;
}
?>