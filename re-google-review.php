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

/**
 * Options Page Displays Under Settings
 */
function re_google_review_options_page() {
	add_options_page( 'Google Review Place ID', 'Google Review', 'manage_options', 'google-review', 're_google_review_page' );
}

/**
 * Google Review Place ID Field
 */
function re_google_review_page() {
	?>
	<div class="wrap">
		<h1>Google Review</h1>
		<form method="post" action="options.php">
			<?php
			// The add_settings_section callback displays here.
			settings_fields( 're_google_review_options_group' ); // Get from 1st @param register_setting().
			// The add_settings_field callback displays here.
			do_settings_sections( 'google-review' );
			// Submit button.
			submit_button();
			?>
		</form>
	</div>
	<?php
}

add_action( 'admin_menu', 're_google_review_options_page' );

/**
 * Register Google Review Settings
 */
function re_google_review_form_settings() {
	// Section Name, Title, Function, Page.
	add_settings_section( 're_google_review_attr_id', 'General Settings', 're_google_review_callback_optional', 'google-review' );
	// Attribute, Title, Function, Section Name 1st @param add_settings_section.
	add_settings_field( 're_google_review_place_id', 'Google Place ID', 're_google_review_callback_field', 'google-review', 're_google_review_attr_id' );
	// Section Name, Form Element Name, Sanitize Function.
	register_setting( 're_google_review_options_group', 're_google_review_place_id', 're_google_review_sanitize_option' );
}

add_action( 'admin_init', 're_google_review_form_settings' );

/**
 * Optional Settings Section Callback
 */
function re_google_review_callback_optional() {
	// Optional area.
}

/**
 * Input Field
 */
function re_google_review_callback_field() {
	?>
	<input type="text" name="re_google_review_place_id" id="re_google_review_place_id" value="<?php echo esc_attr( get_option( 're_google_review_place_id' ) ); ?>">
	<?php
}

/**
 * Create Shortcode [google_review].
 *
 * @return string HTML link for Google review.
 */
function re_google_review_shortcode() {
	$place_id = get_option( 're_google_review_place_id' );
	return '<a href="http://search.google.com/local/writereview?placeid=' . esc_attr( $place_id ) . '" class="write-a-review" data-place-id="' . esc_attr( $place_id ) . '">' . esc_html( 'Write a review', 'googlereview' ) . '</a>';
}

add_shortcode( 'google_review', 're_google_review_shortcode' );
