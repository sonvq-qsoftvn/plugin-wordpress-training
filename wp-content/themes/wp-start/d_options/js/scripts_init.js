/* Script init d-options */
var saving_text  = d_variable.d_saving_text;
var saved_text = d_variable.d_saved_text;
var d_tm;
jQuery(document).ready(function(){
	//Hiding the tab
	jQuery('.d-tab, .tab-focus').each(function(){
		if(!jQuery(this).hasClass('active'))
			jQuery(this).css('display', 'none');
	});
	//script for tab click
	jQuery('.d-nav li').click(function(){
		var elem = jQuery(this);
		if (elem.hasClass('active'))
			return false;
		var target_wrap = elem.children().attr('href');
		var focus_default = jQuery(target_wrap).find('ul li:first a').attr('href');

		jQuery('.d-nav li').removeClass('active');
		elem.addClass('active');

		jQuery('.d-tab').hide();
		jQuery(target_wrap).fadeIn(200);
		jQuery('ul.tab-click li').removeClass('active');
		jQuery('.tab-focus').hide();
		jQuery('.tab-focus.active').show();
		jQuery(target_wrap).find('ul li:first').addClass('active');
		jQuery(focus_default).addClass('active').show();
		
		return false;
	});
	jQuery('ul.tab-click li a').click(function(){
		var elem = jQuery(this);
		if (elem.parent().hasClass('active'))
			return false;
		var target_wrap = elem.attr('href');

		jQuery('ul.tab-click li').removeClass('active');
		elem.parent().addClass('active');

		jQuery('.tab-focus').hide();
		jQuery(target_wrap).fadeIn(200);
		
		return false;
	});
	//ajax save theme options 

	jQuery('.d-save-button').click(function(){
		var elem = jQuery(this);
		if(elem.hasClass('disabled'))
			return false;

		var data = jQuery('#dform').serialize()+'&_ajax_nonce='+d_variable.d_nonce;
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: data,
			beforeSend: function ( xhr ){
				elem.addClass('disabled');
				jQuery('.loading-element').removeClass('saved');
				jQuery('.loading-element').html(saving_text).show();
			},
			success: function(response){
				elem.removeClass('disabled');
				jQuery('.loading-element').addClass('saved');
				jQuery('.loading-element').html(saved_text).delay(1000).fadeOut(500);
			}
		});

		return false;
	});
	jQuery('.remove-logo').click(function(){
		var elem = jQuery(this);
		elem.parent().hide();
		elem.parent().prev().prev().find('input').val('');
		return false;
	});
	jQuery('.mask-control').click(function(){
		var elem = jQuery(this);
		if(elem.find('input[type="checkbox"]').is(':checked'))
			elem.parent().parent().next().find('.box-mask').addClass('hide');
		else
			elem.parent().parent().next().find('.box-mask').removeClass('hide');
	});

	//color picker
	jQuery('.typography-box, .colorpicker-box').each(function(){
		var elem         = jQuery(this);
		var target_bg    = elem.find('.d-colorpicker').attr('id');
		var target_input = elem.find('.typo-color').attr('id');

		jQuery('#'+target_bg).ColorPicker({
			color: jQuery('#' + target_input).val(),
			onShow: function (colpkr) {
				jQuery(colpkr).show();
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).hide();
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery('#' + target_bg).children().css('backgroundColor', '#' + hex);
				jQuery('#' + target_input).val('#' + hex);
			}
		});
	});
	
	//preview typography
	jQuery('.preview-typo').click(function(){
		var elem        = jQuery(this);

		elem.children().addClass('icon-refresh');
		elem.children().removeClass('icon-search');
		var style = '';
		var font_face;

		//font face case
		var font_select_elem = elem.parent().find('.typo-face').find('option:selected');
		var font_type        = font_select_elem.parent().attr('label');

		font_face = elem.parent().find('.typo-face').val();
		if(font_type == 'Web fonts') {
			style    += 'font-family: ' + font_face + ';';
		} else if(font_type == 'Google fonts') {
			WebFontConfig = {
                google: { 
                	families: [font_select_elem.text()] },
                    fontactive: function(font_face, fvd) {
                    	elem.next().css('opacity', '1');
                       //elem.next().css('font-family', font_face);
                    }
            };
            
            (function() {
                var wf = document.createElement('script');
                    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                             '://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js';
                    wf.type = 'text/javascript';
                    wf.id = 'google-font-script';
                    wf.async = 'true';
                
                if(document.getElementById('google-font-script') === null) {
                	var s = document.getElementsByTagName('script')[0];
	                    s.parentNode.insertBefore(wf, s);
                }
	                
            })();

			style    += "font-family: '" + font_face + "', sans-serif;";
		}

		var font_size      = elem.parent().find('.typo-size').val();
		var font_unit      = elem.parent().find('.typo-unit').val();
		var font_style     = elem.parent().find('.typo-style').val();
		var font_color     = elem.parent().find('.typo-color').val();
		var font_transform = elem.parent().find('.typo-transform').val();

		var line_height = (parseInt(font_size)  / 2) + parseInt(font_size);
		if (font_unit == 'em')
			line_height = 1.5;

		style += 'line-height: ' + line_height + font_unit + ';';
		style += 'font-size: ' + parseFloat(font_size) + font_unit + ';';

		if(font_transform != '')
			style += 'text-transform: ' + font_transform + ';';

		if(font_style == 'bold' || font_style == 'normal' || font_style == 'extra-bold') {
			style += 'font-weight: ' + font_style + ';';
		} else if (font_style == 'bold-italic') {
			style += 'font-weight: bold; font-style: italic;';
		} else if (font_style == 'italic') {
			style += 'font-style: italic;';
		}
		style += 'color: ' + font_color + ';';
		console.log(style);

		elem.next().attr('style', style).addClass('active');

		return false;
	});

	//hide the preview
	jQuery('.hide-preview-typo').click(function(){
		jQuery(this).parent().hide();
		return false;
	});

	//plus and minus btn
	jQuery('.number-button').click(function(){
		var elem = jQuery(this);
		var target_input = elem.parent().find('input');
		console.log(target_input);
		if(elem.hasClass('btn-plus')) {
			target_input.val(parseInt(target_input.val())+1);
		} else if(elem.hasClass('btn-minus')) {
			if(target_input.val() == 1)
				return false;
			target_input.val(parseInt(target_input.val())-1);
		}

		return false;
	});

	//mailchimp select list 
	jQuery('#dmc-list-id').change(function(){
		var elem = jQuery(this);
		if(elem.val() != '')
			elem.next().val(elem.find('option:selected').data('name'));
		return false;
	});
	//Reset the theme options
	jQuery('.d-reset-button').click(function(){
		var elem = jQuery(this);
		var r    = confirm("Are you sure?");
		var data = jQuery('#dform').serialize()+'&_ajax_nonce='+d_variable.d_nonce+'&_reset_nonce='+d_variable.reset_nonce;
		if (r == true) {
		  	jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data: data+'&reset=1',
				beforeSend: function ( xhr ){
					window.clearTimeout(d_tm);
					elem.addClass('disabled');
					jQuery('.loading-element').removeClass('saved');
					jQuery('.loading-element').html(saving_text).show();
				},
				success: function(response){
					elem.removeClass('disabled');
					jQuery('.loading-element').addClass('saved');
					jQuery('.loading-element').html(saved_text).delay(1000).fadeOut(500);
					d_tm = window.setTimeout(function() {
						window.location.reload();
					}, 500);

				}
			});
		}
		else {
			return false;
		}
		return false;
	});
});