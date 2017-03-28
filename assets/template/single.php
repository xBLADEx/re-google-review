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
	'google'          => $google_review,
	'facebook'        => $facebook_review,
	'healthy hearing' => $healthy_hearing_review,
];
?>

<div class="open-review">
	<?php
	$count   = 0;
	$reviews = count( $review_options ) - count( empty( $review_options ) );

	foreach ( $review_options as $key => $review ) :
		// If our review is empty, skip and continue on.
		if ( empty( $review ) ) {
			continue;
		}

		// Set our link.
		$link = $review;

		// If Google create full URL.
		if ( 'google' === $key ) {
			$link = 'http://search.google.com/local/writereview?placeid=' . esc_html( $link );
		}
		?>
		<div class="review-container">
			<h2><?php esc_html_e( 'Use', 'domain' ); ?> <span><?php echo esc_html( $key ); ?></span><br><?php esc_html_e( 'to leave your review?', 'domain' ); ?></h2>

			<a href="<?php echo esc_url( $link ); ?>" class="button"><?php esc_html_e( 'Yes', 'domain' ); ?></a>

			<?php if ( $count < $reviews - 1 ) : // Do not show on last review. ?>
				<p class="or"><?php esc_html_e( '- OR -', 'domain' ); ?></p>

				<button class="button next-review"><?php esc_html_e( 'Other Review Options', 'domain' ); ?></button>
			<?php endif; ?>
		</div>
		<?php
		$count++;
	endforeach;
	?>
</div>

<?php get_footer(); ?>
