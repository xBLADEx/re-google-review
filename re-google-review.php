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

// Base file.
define( 'RE_BASE_FILE', __FILE__ );
define( 'RE_BASE_DIR', dirname( RE_BASE_FILE ) );

// http://codex.wordpress.org/Function_Reference/plugin_dir_url.
// This plugin_dir_url includes the trailing slash.
define( 'RE_PLUGIN_URL', plugin_dir_url( RE_BASE_FILE ) );

// Enqueue Scripts.
if ( ! is_admin() ) {
	wp_enqueue_style( 're-google-review', RE_PLUGIN_URL . 'assets/css/review.css', '', '1.0' );
	wp_enqueue_script( 're-google-review', RE_PLUGIN_URL . 'assets/js/review.js', array( 'jquery' ), '1.0', true );
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
	?>
	<h4>Instructions</h4>
	<ol>
		<li>Find your Place ID by searching for your company name or address here: <a href="https://developers.google.com/places/place-id" target="_blank">https://developers.google.com/places/place-id</a></li>
		<li>Copy the Place ID. Example: <code>ChIJ-UfrxMVEyoARTDzoXZg72ig</code></li>
		<li>Enter Place ID below and save</li>
		<li>Use the shortcode in your Page or Post: <code>[google_review]</code></li>
	</ol>
	<?php
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

/**
 * Register Google Review Post Type
 *
 * See: https://code.tutsplus.com/articles/plugin-templating-within-wordpress--wp-31088.
 */
function re_google_review_setup_post_type() {

	// Custom Post Type Labels.
	$labels = array(
		'name'               => esc_html__( 'Google Review', 'googlereview' ),
		'singular_name'      => esc_html__( 'Google Review', 'googlereview' ),
		'add_new'            => esc_html__( 'Add New', 'googlereview' ),
		'add_new_item'       => esc_html__( 'Add New Google Review', 'googlereview' ),
		'edit_item'          => esc_html__( 'Edit Google Review', 'googlereview' ),
		'new_item'           => esc_html__( 'New Google Review', 'googlereview' ),
		'view_item'          => esc_html__( 'View Google Review', 'googlereview' ),
		'search_items'       => esc_html__( 'Search Google Review', 'googlereview' ),
		'not_found'          => esc_html__( 'No Google Review found', 'googlereview' ),
		'not_found_in_trash' => esc_html__( 'No Google Review found in trash', 'googlereview' ),
		'parent_item_colon'  => '',
	);

	// Supports.
	$supports = array( 'title' );

	// Custom Post Type Supports.
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => true,
		'can_export'         => true,
		'rewrite'            => array( 'slug' => 're-google-reviews', 'with_front' => true ),
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => 25,
		'supports'           => $supports,
	);

	// Register the re-reviews custom post type.
	register_post_type( 're-google-reviews' , $args );
}

add_action( 'init', 're_google_review_setup_post_type' );

/**
 * Get Template
 *
 * @param  string $template File name.
 * @return string           File.
 */
function re_google_review_get_template_hierarchy( $template ) {

	// Get the template slug.
	$template_slug = rtrim( $template, '.php' );
	$template = $template_slug . '.php';

	// Check if a custom template exists in the theme folder, if not, load the plugin template file.
	if ( $theme_file = locate_template( array( 'plugin_template/' . $template ) ) ) {
		$file = $theme_file;
	} else {
		$file = RE_BASE_DIR . '/assets/template/' . $template;
	}

	return apply_filters( 're_google_review_template_' . $template, $file );
}

/**
 * Select Template
 *
 * @param  sting $template Template name.
 * @return sting           Template.
 */
function re_google_review_template_select( $template ) {

	// Post ID.
	$post_id = get_the_ID();

	// For all other CPT.
	if ( get_post_type( $post_id ) !== 're-google-reviews' ) {
		return $template;
	}

	// Else use custom template.
	if ( is_single() ) {
		return re_google_review_get_template_hierarchy( 'single' );
	}

}

add_filter( 'template_include', 're_google_review_template_select' );

// Meta box variables.
// See http://www.deluxeblogtips.com/how-to-create-meta-box-wordpress-post/.
$prefix = 're-google-review-';

$meta_box = array(
	'id'       => 're-google-review-meta-box',
	'title'    => __( 'Company Review Links', 'domain' ),
	'page'     => 're-google-reviews',
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
		array(
			'name' => __( 'Google Place ID', 'domain' ),
			'desc' => __( 'Enter Google Place ID.', 'domain' ),
			'id'   => $prefix . 'google-place-id',
			'type' => 'text',
			'std'  => '',
		),
		array(
			'name' => __( 'Facebook', 'domain' ),
			'desc' => __( 'Enter URL to Facebook review page.', 'domain' ),
			'id'   => $prefix . 'facebook',
			'type' => 'text',
			'std'  => '',
		),
		array(
			'name' => __( 'Healthy Hearing', 'domain' ),
			'desc' => __( 'Enter URL to Healthy Hearing review page.', 'domain' ),
			'id'   => $prefix . 'healthy-hearing',
			'type' => 'text',
			'std'  => '',
		),
	),
);

/**
 * Add Meta Box
 * Add meta box on re-google-reviews post type.
 */
function re_google_review_add_meta_box() {
	global $meta_box;

	add_meta_box( $meta_box['id'], $meta_box['title'], 're_google_review_meta_box_fields', $meta_box['page'], $meta_box['context'], $meta_box['priority'] );
}

add_action( 'admin_menu', 're_google_review_add_meta_box' );

/**
 * Show Meta Box Fields
 */
function re_google_review_meta_box_fields() {
	global $meta_box, $post;

	// Use nonce for verification.
	echo '<input type="hidden" name="re_google_review_meta_box_nonce" value="', wp_create_nonce( basename( RE_BASE_FILE ) ), '">';

	echo '<table class="form-table">';

	foreach ( $meta_box['fields'] as $field ) {
		// Get current post meta data.
		$meta = get_post_meta( $post->ID, $field['id'], true );

		echo '<tr>';
		echo '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>';
		echo '<td>';
		switch ( $field['type'] ) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="50">', '<br>', $field['desc'];
				break;
			case 'textarea':
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
				break;
			case 'select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ( $field['options'] as $option ) {
					echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo '</select>';
				break;
			case 'radio':
				foreach ( $field['options'] as $option ) {
					echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
				break;
		}
		echo '</td><td>',
		'</td></tr>';
	}

	echo '</table>';
}

/**
 * Save Meta Box
 * Save data from meta box.
 *
 * @param  integer $post_id Post ID.
 */
function re_google_review_save_meta_data( $post_id ) {
	global $meta_box;

	// Verify nonce.
	if ( ! wp_verify_nonce( $_POST['re_google_review_meta_box_nonce'], basename( RE_BASE_FILE ) ) ) {
		return $post_id;
	}

	// Check autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// Check permissions.
	if ( 'post' === $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	foreach ( $meta_box['fields'] as $field ) {
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = $_POST[$field['id']];

		if ( $new && $new !== $old ) {
			update_post_meta( $post_id, $field['id'], $new );
		} elseif ( '' === $new && $old ) {
			delete_post_meta( $post_id, $field['id'], $old );
		}
	}
}

add_action( 'save_post', 're_google_review_save_meta_data' );
