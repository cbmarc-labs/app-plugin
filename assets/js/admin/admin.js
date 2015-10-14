jQuery( function( $ ){
	
	var app_widget_slider_frame;
	
	$('.app-widget-slider').on( 'click', function( event ) {
		
		var $this = $(this),
			button = $this.data('editor'),
			gallerysc = $('#'+button).val();
		
		// open modal - bind this to your button
	    if ( typeof wp !== 'undefined' && wp.media && wp.media.editor )
	        wp.media.editor.open( this );

	// backup of original send function
	   original_send = wp.media.editor.send.attachment;

	// new send function
	   wp.media.editor.send.attachment = function( a, b) {
		   $('#'+button).val("att "+b.id);
	       console.log("----> " + b.id); // b has all informations about the attachment
	       // or whatever you want to do with the data at this point
	       // original function makes an ajax call to retrieve the image html tag and does a little more
	    };

	// wp.media.send.to.editor will automatically trigger window.send_to_editor for backwards compatibility

	// backup original window.send_to_editor
	   window.original_send_to_editor = window.send_to_editor; 

	// override window.send_to_editor
	   window.send_to_editor = function(html) {
		   console.log(html);
		   $('#'+button).val("html"+html);
	       // html argument might not be useful in this case
	       // use the data from var b (attachment) here to make your own ajax call or use data from b and send it back to your defined input fields etc.
	   }
		
		/*var $this = $(this),
			button = $this.data('editor'),
			gallerysc = $('#'+button).val();

		
		var _custom_media = true;
		wp.media.editor.send.attachment = function(props, attachment){
			console.log(attachment.id);
			$('#'+button).val(attachment.id);
		};
		
	// Check that the input field contains a shortcode and Open the gallery with the shortcode
	if ( gallerysc !== 'undefined' )
		wp.media.gallery.edit( gallerysc );
		
		wp.media.editor.insert = function( html ) {
			console.log(button);
			$('#'+button).val(html);
		};
	      wp.media.editor.open();
	      return false;*/
		
	});
	
});