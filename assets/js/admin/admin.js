jQuery( function( $ ){
	
	var app_widget_slider_frame;
	
	$('.app-widget-slider').on( 'click', function( event ) {
		//alert($(this).data('ids'));
		
		event.preventDefault();
		
		// If the media frame already exists, reopen it.
		if ( app_widget_slider_frame ) {
			app_widget_slider_frame.open();
			return;
		}
		
		// Create the media frame.
		app_widget_slider_frame = wp.media.frames.property_gallery = wp.media({
			// Set the title of the modal.
			title: 'Select',
			button: {
				text: 'Use this media',
			},
			library : { type : 'image'},
			multiple: true,
			/*states : [
				new wp.media.controller.Library({
					title: $el.data('choose'),
					filterable :	'all',
					multiple: true,
				})
			]*/
		});
		
		// Finally, open the modal.
		app_widget_slider_frame.open();
		
	});
	
});