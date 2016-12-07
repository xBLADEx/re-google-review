( function( $ ) {

	'use strict';

	$( function() {

		var body        = $( 'body' ),
			writeReview = $( '.write-a-review' );

		// If review link exists.
		if ( writeReview.length ) {

			// On click trigger review window.
			writeReview.on( 'click', function( e ) {

				// Prevent default browser action.
				e.preventDefault();
				// Add layout styles.
				body.prepend( '<div class="open-review" />' );

				$( '.open-review' ).prepend( '<h2>Use <span>Google</span><br>to leave your review?</h2>' );
				$( '.open-review' ).append( '<a href="" class="button">Yes</a>' );

			} );

		}

	} );

}( jQuery ) );
