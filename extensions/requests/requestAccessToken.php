<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

$url = sanitize_text_field($_POST["url"]);
$headers = sanitize_text_field($_POST["headers"]);
$body = sanitize_text_field($_POST["body"]);


$result = wp_remote_post($url, array(
    "headers" => $headers,
    "body" => $body
));

return $result['body'];
?>