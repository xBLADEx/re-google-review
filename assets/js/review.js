( function( $ ) {

	'use strict';

	$( function() {

		var body         = $( 'body' ),
			writeReview  = $( '.write-a-review' ),
			singleReview = $( '.single-re-google-reviews' );

		// If review link exists.
		if ( writeReview.length ) {

			// On click trigger review window.
			writeReview.on( 'click', function( e ) {

				// Prevent default browser action.
				e.preventDefault();

				// Get URL for Reivew.
				var urlReview = $(this).prop( 'href' );

				// Add layout styles.
				body.prepend( '<div class="open-review" />' );

				$( '.open-review' ).prepend( '<h2>Use <span>Google</span><br>to leave your review?</h2>' );
				$( '.open-review' ).append( '<a href="' + urlReview + '" class="button">Yes</a>' );
				$( '.open-review' ).append( '<a href="#" class="close">Close</a>' );

				// Close review.
				$( '.close' ).on( 'click', function( e ) {

					// Prevent default browser action.
					e.preventDefault();

					// Review review overlay.
					$( '.open-review' ).remove();

				} );

			} );

		}

		// If single custom post type.
		if ( singleReview.length ) {
			$( '.open-review' ).prependTo( body );
		}

	} );

}( jQuery ) );
