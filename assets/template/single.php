<?php
/**
 * Single Re Google Review
 *
 * @package Google Review
 */

get_header();

$google_review          = get_post_meta( $post->ID, 're-google-review-google-place-id', true );
$facebook_review        = get_post_meta( $post->ID, 're-google-review-facebook', true );
$healthy_hearing_review = get_post_meta( $post->ID, 're-google-review-healthy-hearing', true );

$review_options         = [
	'google'   => $google_review,
	'facebook' => $facebook_review,
	'healthy'  => $healthy_hearing_review,
];
?>

<div class="open-review">
	<?php
	foreach ( $review_options as $key => $review ) :
		// If our review is empty, skip and continue on.
		if ( empty( $review ) ) {
			continue;
		}
		?>
		<div class="review-container">
			<h2 id="review-heading">Use <span><?php echo esc_html( $key ); ?></span><br>to leave your review?</h2>
		</div>
		<?php
	endforeach;
	?>

	<a href="http://search.google.com/local/writereview?placeid=<?php echo esc_html( $google_review ); ?>" class="button"><?php esc_html_e( 'Yes', 'domain' ); ?></a>

	<p><?php esc_html_e( '- OR -', 'domain' ); ?></p>

	<button class="button"><?php esc_html_e( 'Other Review Options', 'domain' ); ?></button>
</div>

<?php get_footer(); ?>
