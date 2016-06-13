jQuery(function($) {
	//show the tab for shortcode type
	$('#shortcode_select').change(function(){
		var elem = $(this);
		var target = '#'+elem.val();

		$('.shortcode-tab').hide();
		$(target).fadeIn(200);
	});

	$('#btn-insert-shortcode').click(function(){
		var shortcode_panel = document.getElementById('shortcode_panel');
		var current_shortcode = shortcode_panel.className.indexOf('current');

		if (current_shortcode != -1) {
			var shortcode_type = $('#shortcode_select').val();

			//assign shortcode type variable
			var render_html;
			/* ALERT */
			var alert_type    = $('#shortcode_alert_type').val();
			var alert_content = $('#shortcode_alert_content').val();

			/* Dropcap */
			var dropcap_type    = $('#shortcode_dropcap_type').val();
			var dropcap_content = $('#shortcode_dropcap_content').val();

			/* Button */
			var button_size    = $('#shortcode_button_size').val();
			var button_type    = $('#shortcode_button_type').val();
			var button_color   = $('#shortcode_button_color').val();
			var button_content = $('#shortcode_button_content').val() ? $('#shortcode_button_content').val() : 'Go';
			var button_link    = $('#shortcode_button_link').val() ? $('#shortcode_button_link').val() : '#';
			var button_target  = $('#shortcode_button_target:checked').val() ? $('#shortcode_button_target:checked').val() : '_self';

			/** Divider **/
			var divider_type = $('#shortcode_divider_type').val();

			/** Featured products **/
			var featured_products_num      = $('#shortcode_featured_products_num').val();
			var featured_products_per_page = $('#shortcode_featured_products_per_page').val();
			var featured_products_title    = $('#shortcode_featured_products_title').val();

			/** Featured products **/
			var recent_products_num      = $('#shortcode_recent_products_num').val();
			var recent_products_per_page = $('#shortcode_recent_products_per_page').val();
			var recent_products_title    = $('#shortcode_recent_products_title').val();

			/** Featured products **/
			var testimonials_num      = $('#shortcode_testimonials_num').val();
			var testimonials_per_page = $('#shortcode_testimonials_per_page').val();
			var testimonials_title    = $('#shortcode_testimonials_title').val();

			/** Recent posts **/
			var recent_posts_num      = $('#shortcode_recent_posts_num').val();
			var recent_posts_per_page = $('#shortcode_recent_posts_per_page').val();
			var recent_posts_title    = $('#shortcode_recent_posts_title').val();

			/** Tabs **/
			var tabs_type = $('#shortcode_tabs_type').val();

			/** Panel **/
			var panel_type = $('#shortcode_panel_type').val();

			/** Progress bar **/
			var progress_title       = $('#shortcode_progress_title').val();
			var progress_value       = $('#shortcode_progress_value').val();
			var progress_value_title = $('#shortcode_progress_value_title').val();

			/** Featured box **/
			var featured_box_title = $('#shortcode_featured_box_title').val();
			var featured_box_type  = $('#shortcode_featured_box_type').val();
			var featured_box_icon  = $('#shortcode_featured_box_icon').val();

			/** Team member **/
			var team_member_per_page = $('#shortcode_team_member_per_page').val();

			/** Google map **/
			var map_lat     = $('#shortcode_map_lat').val();
			var map_lng     = $('#shortcode_map_lng').val();
			var map_zoom    = $('#shortcode_map_zoom').val();
			var map_address = $('#shortcode_map_address').val();
			var map_width   = $('#shortcode_map_width').val();
			var map_height  = $('#shortcode_map_height').val();

			/** Social **/
			var social_title = $('#shortcode_social_title').val();
			var social_type  = $('#shortcode_social_type').val();

			switch(shortcode_type) {
				case 'shortcode-alert':
				render_html = '[alert type="'+alert_type+'"]'+alert_content+'[/alert]';
				break;

				case 'shortcode-dropcap':
				render_html = '[dropcap type="'+dropcap_type+'"]'+dropcap_content+'[/dropcap]';
				break;

				case 'shortcode-button':
				render_html = '[button type="'+button_type+'" size="'+button_size+'" color="'+button_color+'" link="'+button_link+'" target="'+button_target+'"]'+button_content+'[/button]';
				break;

				case 'shortcode-divider':
				if(divider_type == '')
					render_html = '[hr]';
				else
					render_html = '[hr type="'+divider_type+'"]';
				break;

				case 'shortcode-featured-products':
					render_html = '[d_featured_products per_page="'+featured_products_per_page+'" show="'+featured_products_num+'" title="'+featured_products_title+'"]';
				break;

				case 'shortcode-recent-products':
					render_html = '[d_recent_products per_page="'+recent_products_per_page+'" show="'+recent_products_num+'" title="'+recent_products_title+'"]';
				break;

				case 'shortcode-recent-posts':
					render_html = '[recent_posts per_page="'+recent_posts_per_page+'" show="'+recent_posts_num+'" title="'+recent_posts_title+'"]';
				break;

				case 'shortcode-accordion':
					render_html = '[accordion][accordion_tab title="Title #1" type="active"]Content #1[/accordion_tab][accordion_tab title="Title #2"]Content #2[/accordion_tab][/accordion]';
				break;

				case 'shortcode-tabs':
					if(tabs_type == '')
						render_html = '[tabs][tab title="Title #1" type="active"]Content #1[/tab][tab title="Title #2"]Content #2[/tab][/tabs]';
					else if(tabs_type == 'vertical')
						render_html = '[tabs type="vertical" tab1="Tab #1" tab2="Tab #2"][vtab]Content #1[/vtab][vtab]Content #2[/vtab][/tabs]';
				break;

				case 'shortcode-columns':
					render_html = '[row][col num="9"]Column #1[/col][col num="3"]Column #2[/col][/row]';
				break;

				case 'shortcode-highlight':
					render_html = '[highlight]Text[/highlight]';
				break;

				case 'shortcode-quote':
					render_html = '[blockquote]Quote[/blockquote]';
				break;

				case 'shortcode-testimonials':
					render_html = '[testimonials per_page="'+testimonials_per_page+'" show="'+testimonials_num+'" title="'+testimonials_title+'"]';
				break;

				case 'shortcode-panel':
					render_html = '[panel type="'+panel_type+'"][/panel]';
				break;

				case 'shortcode-progress':
					render_html = '[progress title="'+progress_title+'" value="'+progress_value+'" value_title="'+progress_value_title+'"]';
				break;

				case 'shortcode-featured-box':
					render_html = '[featured_box title="'+featured_box_title+'" icon="'+featured_box_icon+'" type="'+featured_box_type+'"][/featured_box]';
				break;

				case 'shortcode-team-members':
					render_html = '[team per_page="'+team_member_per_page+'"]';
				break;

				case 'shortcode-map':
					render_html = '[map lat="'+map_lat+'" lng="'+map_lng+'" address="'+map_address+'" zoom="'+map_zoom+'" height="'+map_height+'" width="'+map_width+'"][/map]';
				break;
				case 'shortcode-social':
					if(social_type == 'share') 
						render_html = '[share title="'+social_title+'"]';
					else
						render_html = '[follow title="'+social_title+'"]';
				break;
			}
		}

		//insert shortcode to editor
		if (current_shortcode != -1) {
			activeEditor = window.tinyMCE.activeEditor.id;
			//window.tinyMCE.execInstanceCommand(activeEditor, 'mceInsertContent', false, render_html);
			window.tinyMCE.execCommand('mceInsertContent', false, render_html);
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		} else {
			tinyMCEPopup.close();		
		}

		return;
	});

});