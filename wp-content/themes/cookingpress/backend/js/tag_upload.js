jQuery(document).ready(function(){

	 
	 var header_clicked = false;
	 if(jQuery('input#tag_image').val() == '') {
            jQuery("img#tag-image").hide();
            jQuery('.remove-image').hide();
        }
	
	jQuery('.upload-image').click(function() {
		header_clicked = true;
		formfield = jQuery('input#tag_image');
		preview = jQuery(this).prev('img');
		tb_show('', 'media-upload.php?type=image&amp;post_id=0&amp;TB_iframe=true');
		return false;
	});
	
	
	// Store original function
	window.original_send_to_editor = window.send_to_editor;
	
	
	window.send_to_editor = function(html) {
		if (header_clicked) {
			imgurl = jQuery('img',html).attr('src');
                     
			jQuery(formfield).val(imgurl);
                        jQuery('.remove-image').show();
                        jQuery("img#tag-image").show().attr("src", jQuery('input#tag_image').val());

			jQuery(preview).attr('src' , imgurl);
			tb_remove();
			header_clicked = false;
		} else {
			window.original_send_to_editor(html);
		}
	}
	
	jQuery('.remove-image').click(function(){
		
		jQuery('input#tag_image').val('');
		jQuery('img#tag-image').fadeOut('slow');
		jQuery(this).fadeOut('slow');
		
	});
});