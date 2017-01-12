<?php
/**
 * Single Re Google Review
 *
 * @package Google Review
 */

?>
<?php get_header(); ?>
<?php
$google_review   = get_post_meta( $post->ID, 're-google-review-google-place-id', true );
$facebook_review = get_post_meta( $post->ID, 're-google-review-facebook', true );
?>
<div class="open-review">
	<h2>Use <span>Google</span><br>to leave your review?</h2>
	<a href="http://search.google.com/local/writereview?placeid=<?php echo esc_html( $google_review ); ?>" class="button"><?php esc_html_e( 'Yes', 'domain' ); ?></a>
	<?php if ( $facebook_review ) { ?>
		<p><?php esc_html_e( '- OR -', 'domain' ); ?></p>
		<a href="<?php echo esc_url( $facebook_review ); ?>" class="button"><?php esc_html_e( 'Facebook', 'domain' ); ?></a>
	<?php } ?>
</div>
<?php get_footer(); ?>
