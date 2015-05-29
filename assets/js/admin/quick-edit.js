/*global inlineEditPost */
jQuery(function( $ ) {
	$( '#the-list' ).on( 'click', '.editinline', function() {

		var post_id = $( this ).closest( 'tr' ).attr( 'id' );

		post_id = post_id.replace( 'post-', '' );

		var $wc_inline_data = $( '#app_inline_' + post_id );

		var rooms = $wc_inline_data.find( '.property_rooms' ).text();

		$( 'input[name="_property_rooms"]', '.inline-edit-row' ).val( rooms );
	});
});
