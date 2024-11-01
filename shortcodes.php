<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function gf_menucard_shortcode( $atts, $content = null ) {
	return require_once plugin_dir_path( __FILE__ ) . '/templates/basic.php';
}
add_shortcode( 'gf_menucard', 'gf_menucard_shortcode' );
?>
