<?php
/**
 * Single Re Google Review
 *
 * @package Google Review
 */

?>
<?php get_header(); ?>
<?php
$google_review = get_post_meta( $post->ID, 're-google-review-google-place-id', true );
?>
<div class="open-review">
	<h2>Use <span>Google</span><br>to leave your review?</h2>
	<a href="http://search.google.com/local/writereview?placeid=<?php echo esc_html( $google_review ); ?>" class="button">Yes</a>
</div>
<?php get_footer(); ?>
