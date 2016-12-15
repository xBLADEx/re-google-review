<?php
/**
 * Single Re Google Review
 *
 * @package Google Review
 */

?>
<?php get_header(); ?>
<?php
$place_id = get_option( 're_google_review_place_id' );
?>
<div class="open-review">
	<h2>Use <span>Google</span><br>to leave your review?</h2>
	<a href="http://search.google.com/local/writereview?placeid=<?php echo esc_attr( $place_id ); ?>" class="button">Yes</a>
</div>
<?php get_footer(); ?>
