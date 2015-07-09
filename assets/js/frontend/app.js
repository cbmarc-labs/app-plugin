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
	
	// handles the carousel thumbnails
	$('[id^=carousel-selector-]').click( function( event ){
		event.preventDefault();
		
		var id_selector = $(this).attr("id");
		var id = id_selector.substr(id_selector.length -1);
		
		id = parseInt(id);
		
		$('#property-carousel').carousel(id);
		$('[id^=carousel-selector-]').css('opacity', '1');
		
		$(this).css('opacity', '0.5');
	});
	
	// when the carousel slides, auto update
	$('#property-carousel').bind('slid.bs.carousel', function (e) {
		var id = $('.item.active').data('slide-number');
		
		id = parseInt(id);
		
		$('[id^=carousel-selector-]').css('opacity', '1');
		$('[id=carousel-selector-'+id+']').css('opacity', '0.5');
	});
	
	$("#property-sort-select").change(function() {
		$("#sortby").val(this.value);
		
		$('#property-form-filter').submit();
	});

});