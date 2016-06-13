jQuery(document).ready(function() {
	var input_field;
	var upload_field_name;
	var interval_value;
	var review_element;

	jQuery('.d_upload_button').click(function() {
		var elem          = jQuery(this);
		
		input_field       = elem.prev();
		upload_field_name = elem.parent().prev().text();
		review_element    = elem.parent().next().next();
		interval_value    = setInterval( function() {
			jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Insert ' + upload_field_name);
		}, 2000 );

		post_id = jQuery('#post_ID').val();
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});

	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html){
		if (input_field) {
			clearInterval(interval_value);
			fileurl = jQuery('img',html).attr('src');
			
			input_field.val(fileurl);
			review_element.find('img').attr('src', fileurl);
			review_element.addClass('active').show();
			tb_remove();
		} else {
			window.original_send_to_editor(html);
		}
	};

});