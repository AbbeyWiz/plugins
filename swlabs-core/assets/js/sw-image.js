jQuery(document).ready(function($) {
	"use strict";
	// Instantiates the variable that holds the media library frame.
	var shw_upload_frame;
	var shw_btn_upload;

	// Runs when the image button is clicked.
	$('.shw-btn-upload').live('click', function(e){

		// Prevents the default action from occuring.
		e.preventDefault();

		shw_btn_upload = $(this);
		// If the frame already exists, re-open it.
		if ( shw_upload_frame ) {
			shw_upload_frame.open();
			return;
		}

		// Sets up the media library frame
		shw_upload_frame = wp.media.frames.meta_image_frame = wp.media({
			title: shw_meta_image.title,
			button: { text:  shw_meta_image.button },
			library: { type: 'image' },
		});

		// Runs when an image is selected.
		shw_upload_frame.on('select', function(){

			// Grabs the attachment selection and creates a JSON representation of the model.
			var media_attachment = shw_upload_frame.state().get('selection').first().toJSON();

			// Container
			var rel = shw_btn_upload.attr('data-rel');
			var self_parent = shw_btn_upload.parent();

			// Sends the attachment URL to our custom image input field.
			$('#' + rel + '_name').val(media_attachment.url);
			$('#' + rel + '_id').val(media_attachment.id);
			self_parent.find('img').attr('src', media_attachment.url);
			self_parent.find('div').removeClass('hide');
			shw_btn_upload.next().removeClass('hide');
		});

		// Opens the media library frame.
		shw_upload_frame.open();
	});
	$('.shw-btn-remove').live('click', function(e) {
		// Prevents the default action from occuring.
		e.preventDefault();

		var self = $(this);
		var rel = self.attr('data-rel');
		var self_parent = self.parent();

		$('#' + rel + '_name').val('');
		$('#' + rel + '_id').val('');
		self_parent.find('div').addClass('hide');
		self.addClass('hide');
	});
});