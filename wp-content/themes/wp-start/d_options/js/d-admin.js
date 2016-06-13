jQuery(function() {
	var wrap_image  = jQuery('#'+d_init_var.d_shortname+'_post_type_image_description').parent().parent();
	var wrap_video  = jQuery('#'+d_init_var.d_shortname+'_post_type_video_url_description').parent().parent();
	var wrap_slider = jQuery('#'+d_init_var.d_shortname+'_post_type_slider_description').parent().parent();
	var wrap_custom = jQuery('#'+d_init_var.d_shortname+'_post_type_custom_description').parent().parent();

	//hide all post type
	wrap_image.hide();
	wrap_video.hide();
	wrap_slider.hide();
	wrap_custom.hide();

	change_post_type(jQuery('#'+d_init_var.d_shortname+'_post_type').val());

	//post type select
	jQuery('#'+d_init_var.d_shortname+'_post_type').change(function() {
		var elem  = jQuery(this);
		var value = elem.val();

		change_post_type(value);
	});
	function change_post_type(value) {
		switch(value) {
			case 'normal':
				wrap_image.hide();
				wrap_video.hide();
				wrap_slider.hide();
				wrap_custom.hide();
			break;

			case 'image':
				wrap_image.show();
				wrap_video.hide();
				wrap_slider.hide();
				wrap_custom.hide();
			break;

			case 'video':
				wrap_image.hide();
				wrap_video.show();
				wrap_slider.hide();
				wrap_custom.hide();
			break;

			case 'slider':
				wrap_image.hide();
				wrap_video.hide();
				wrap_slider.show();
				wrap_custom.hide();
			break;

			case 'custom':
				wrap_image.hide();
				wrap_video.hide();
				wrap_slider.hide();
				wrap_custom.show();
			break;
		}
	}
});