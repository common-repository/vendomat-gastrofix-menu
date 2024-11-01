<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

    function gastrofix_menu_pluginIsActivated($license_key) {
        // Define general variables
        $url = 'http://212.237.211.45:3000/api/v1/validate_license?';
        $headers = array(
            "Content-Type:" . "application/x-www-form-urlencoded",
            "Accept: application/json",
        );

        $query = http_build_query([license_key=>$license_key]);

        $result = wp_remote_get($url.$query, array(
            "headers" => $headers
        ));

        return json_decode($result['body'], true)['valid'];
    }
?>