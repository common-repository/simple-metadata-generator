var $ = jQuery.noConflict();

$(document).ready(function($) {

//Delete image
	$("#delete").on('click', function() {
		$('#smg-meta-image-default').removeAttr('src');
		$('#smg-meta-image').removeAttr('value');
		$('#smg-meta-image-display').hide();
		$(this).hide();
	});
     
//Send image
	var smg_meta_image;

    $('#smg-meta-image-button').on('click', function(e){
        e.preventDefault();

		if( smg_meta_image ){
			smg_meta_image.open();
			return;
		}

            smg_meta_image = wp.media.frames.file_frame = wp.media({
                title: 'Metadata Image',
				button: {text: meta_image.button},
					library: {type: 'image'},
					multiple: false
            });

            smg_meta_image.on('select', function(){
                var media_attachment = smg_meta_image.state().get('selection').first().toJSON();
				var url = '';

                $('#smg-meta-image').val(media_attachment.url);
				$('#smg-meta-image-default').removeAttr('src');
				$('#smg-meta-image-default').attr('src', media_attachment.url);
				$('#smg-meta-image-display').show();
				$('#delete').show();
            });

        smg_meta_image.open();
    });
	
});