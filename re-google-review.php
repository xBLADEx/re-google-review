<?php
/**
 * Plugin Name: RE Google Review
 * Plugin URI: http://www.richedmunds.com
 * Description: Leave a Google review.
 * Author: Rich Edmunds
 * Author URI: http://www.richedmunds.com
 * Version: 1.0
 *
 * @package RE Google Review
 */

// http://codex.wordpress.org/Function_Reference/plugin_dir_url.
// This plugin_dir_url includes the trailing slash.
define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Enqueue Scripts.
if ( ! is_admin() ) {
	wp_enqueue_style( 're-google-review', PLUGIN_URL . 'assets/css/review.css', '', '1.0' );
	wp_enqueue_script( 're-google-review', PLUGIN_URL . 'assets/js/review.js', array( 'jquery' ), '1.0', true );
}
