jQuery( function( $ ) {

	// app_params is required to continue, ensure the object exists
	if ( typeof app_params === 'undefined' ) {
		return false;
	}
	
	$('.app_button_test_ajax').click(function() {
		var data = {
				action: 'app_test',
				security: app_params.app_params_nonce
			};
		
		$.ajax({
			type: 'POST',
			url: app_params.ajax_url,
			data: data,
			success: function( result ) {
				console.log( result );
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				console.log( "Error: " + jqXHR.responseText );
			}
		});
	});

});