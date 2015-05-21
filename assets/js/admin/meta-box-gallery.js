jQuery(function($) {
	
	$('#app_meta_box_gallery_select').on('click', function(event){
		event.preventDefault();
		
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			
			return;
		}
		
		// Create the media frame.
		var file_frame = wp.media.frame = wp.media({
			
			frame: "post",
			state: "gallery-library",
			library : { type : 'image'},
			multiple: true
			
		}).on('open', function() {
			
			var selection = file_frame.state().get('selection');
			var library = file_frame.state('gallery-edit').get('library');
			var ids = $('#_gallery_ids').val();
			
			if (ids) {
				idsArray = ids.split(',');
				idsArray.forEach(function(id) {
					attachment = wp.media.attachment(id);
					attachment.fetch();
					selection.add( attachment ? [ attachment ] : [] );
				});
				
				file_frame.setState('gallery-edit');
				
				idsArray.forEach(function(id) {
					attachment = wp.media.attachment(id);
					attachment.fetch();
					library.add( attachment ? [ attachment ] : [] );
				});
			}
			
		}).on('update', function() {
			
			// When an image is selected, run a callback.
			var imageIDArray = [];
			var imageHTML = '';
			var metadataString = '';
			
			images = file_frame.state().get('library');
			images.each(function(attachment) {
				imageIDArray.push(attachment.attributes.id);
				imageHTML += '<img src="' + attachment.attributes.url + '" style="width:100px;margin:10px;">';
			});
			
			metadataString = imageIDArray.join(",");
			
			if (metadataString) {
				$("#_gallery_ids").val( metadataString );
				$("#_gallery_img").html( imageHTML );
			}
			
		});
		 
		// Finally, open the modal
		file_frame.open();

	});

	$('#app_meta_box_gallery_removeall').on('click', function(event){
		event.preventDefault();

		$("#_gallery_ids").val("");
		$("#_gallery_img").html("");
	});

});