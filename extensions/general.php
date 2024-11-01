<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function gastrofix_menu_parseHTML($filePath) {
	$file = fopen($filePath, 'r');
	$file_content = fread($file, filesize($filePath));

	return $file_content;
}

function gastrofix_menu_registerMultipleSettings($arrSettings) {
	foreach ($arrSettings as $key => $value) {
		$group_name = $key;

		foreach ($value as $setting) {
			register_setting($group_name, $setting);
		}
	}
}

?>