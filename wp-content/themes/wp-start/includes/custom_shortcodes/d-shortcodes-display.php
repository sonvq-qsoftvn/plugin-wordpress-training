<?php
$wp_load = "../wp-load.php";
$i = 0;

while (!file_exists($wp_load) && $i++ < 10) {
	$wp_load = "../$wp_load";
}

require($wp_load);

if ( !is_user_logged_in() || !current_user_can('edit_posts') ) wp_die(__('OOPS! You are not allowed to access this page', $themename));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<base target="_self" />
	<link href="<?php echo get_template_directory_uri() ?>/includes/custom_shortcodes/style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo get_template_directory_uri() ?>/includes/custom_shortcodes/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/jquery/jquery.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/includes/custom_shortcodes/d-shortcodes.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<title><?php _e('D Shortcodes', $themename);?></title>

</head>
<body onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" id="link" >
	<center><h4><?php _e('D Shortcodes', $themename);?></h4></center>
	<hr />
	<div class="container">
		<div id="shortcode_panel" class="row current">
			<form action="#" name="d_shortcodes_form" id="d_shortcodes_form" class="form-horizontal current" role="form">
				<div class="form-group">
				    <label for="shortcode_select" class="col-xs-4 control-label"><?php _e('Select shortcode', $themename); ?></label>
				    <div class="col-xs-8">
						<select name="shortcode_select" id="shortcode_select" class="form-control">
							<option value=""><?php _e('Choose shortcode type', $themename); ?></option>
							<option value="shortcode-alert"><?php _e('Alert', $themename); ?></option>
							<option value="shortcode-dropcap"><?php _e('Dropcap', $themename); ?></option>
							<option value="shortcode-button"><?php _e('Button', $themename); ?></option>
							<option value="shortcode-divider"><?php _e('Divider', $themename); ?></option>
							<option value="shortcode-featured-products"><?php _e('Featured products', $themename); ?></option>
							<option value="shortcode-recent-products"><?php _e('Recent products', $themename); ?></option>
							<option value="shortcode-recent-posts"><?php _e('Recent posts', $themename); ?></option>
							<option value="shortcode-social"><?php _e('Social icons', $themename); ?></option>
							<option value="shortcode-map"><?php _e('Google map', $themename); ?></option>
							<option value="shortcode-accordion"><?php _e('Accordion', $themename); ?></option>
							<option value="shortcode-tabs"><?php _e('Tabs', $themename); ?></option>
							<option value="shortcode-columns"><?php _e('Columns', $themename); ?></option>
							<option value="shortcode-highlight"><?php _e('Highlight text', $themename); ?></option>
							<option value="shortcode-quote"><?php _e('Quote', $themename); ?></option>
							<option value="shortcode-testimonials"><?php _e('Testimonials', $themename); ?></option>
							<option value="shortcode-panel"><?php _e('Panel', $themename); ?></option>
							<option value="shortcode-progress"><?php _e('Progress bar', $themename); ?></option>
							<option value="shortcode-featured-box"><?php _e('Featured box', $themename); ?></option>
							<option value="shortcode-team-members"><?php _e('Team members', $themename); ?></option>
						</select>
				    </div>
				    <div style="clear: both;"></div>
				    <hr />
				</div>
				
				<div class="shortcode-tab" id="shortcode-alert">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Alert', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_alert_type" class="col-xs-4 control-label"><?php _e('Type', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_alert_type" id="shortcode_alert_type" class="form-control">
										<option value="success"><?php _e('Success', $themename); ?></option>
										<option value="info"><?php _e('Info', $themename); ?></option>
										<option value="alert"><?php _e('Error', $themename); ?></option>
										<option value="warning"><?php _e('Warning', $themename); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_alert_content" class="col-xs-4 control-label"><?php _e('Content', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_alert_content" id="shortcode_alert_content" class="form-control" type="text">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="shortcode-tab" id="shortcode-dropcap">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Dropcap', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_dropcap_type" class="col-xs-4 control-label"><?php _e('Type', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_dropcap_type" id="shortcode_dropcap_type" class="form-control">
										<option value=""><?php _e('Normal', $themename); ?></option>
										<option value="sign"><?php _e('Sign', $themename); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_dropcap_content" class="col-xs-4 control-label"><?php _e('Character', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_dropcap_content" id="shortcode_dropcap_content" class="form-control" type="text">
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-button">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Button', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_button_size" class="col-xs-4 control-label"><?php _e('Size', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_button_size" id="shortcode_button_size" class="form-control">
										<option value=""><?php _e('Normal', $themename); ?></option>
										<option value="large"><?php _e('Large', $themename); ?></option>
										<option value="small"><?php _e('Small', $themename); ?></option>
										<option value="tiny"><?php _e('Tiny', $themename); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_button_type" class="col-xs-4 control-label"><?php _e('Type', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_button_type" id="shortcode_button_type" class="form-control">
										<option value=""><?php _e('Normal', $themename); ?></option>
										<option value="arrow"><?php _e('Normal with arrow', $themename); ?></option>
										<option value="radius"><?php _e('Round', $themename); ?></option>
										<option value="radius arrow"><?php _e('Round with arrow', $themename); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_button_color" class="col-xs-4 control-label"><?php _e('Color', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_button_color" id="shortcode_button_color" class="form-control">
								    	<option value=""><?php _e('Choose background color', $themename); ?></option>
								    	<option value="blue"><?php _e('Blue', $themename); ?></option>
										<option value="pink"><?php _e('Pink', $themename); ?></option>
										<option value="orange"><?php _e('Orange', $themename); ?></option>
										<option value="black"><?php _e('Black', $themename); ?></option>
										<option value="green"><?php _e('Green', $themename); ?></option>
										<option value="purple"><?php _e('Purple', $themename); ?></option>
										<option value="grey"><?php _e('Grey', $themename); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_button_content" class="col-xs-4 control-label"><?php _e('Content', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_button_content" id="shortcode_button_content" class="form-control" type="text" placeholder="<?php _e('Enter the button caption', $themename); ?>">
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_button_link" class="col-xs-4 control-label"><?php _e('Link', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_button_link" id="shortcode_button_link" class="form-control" type="text" placeholder="<?php _e('Enter the button url', $themename); ?>">
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_button_target" class="col-xs-4 control-label"><?php _e('Open in new window', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_button_target" id="shortcode_button_target" class="form-control" type="checkbox" value="_blank">
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-divider">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Divider', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_divider_type" class="col-xs-4 control-label"><?php _e('Type', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_divider_type" id="shortcode_divider_type" class="form-control">
										<option value=""><?php _e('Normal', $themename); ?></option>
										<option value="to-top"><?php _e('With to top link', $themename); ?></option>
									</select>
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-featured-products">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Featured products', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_featured_products_title" class="col-xs-4 control-label"><?php _e('Heading', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_featured_products_title" id="shortcode_featured_products_title" class="form-control" type="text" value="Featured products">
								    <p class="help-block"><?php _e('Heading title', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_featured_products_num" class="col-xs-4 control-label"><?php _e('Items showing', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_featured_products_num" id="shortcode_featured_products_num" class="form-control" type="number" value="4">
								    <p class="help-block"><?php _e('The number of visible products will show on slider', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_featured_products_per_page" class="col-xs-4 control-label"><?php _e('Items per page', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_featured_products_per_page" id="shortcode_featured_products_per_page" class="form-control" type="number" value="12">
								    <p class="help-block"><?php _e('Total number of products', $themename); ?></p>
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-recent-products">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Recent products', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_recent_products_title" class="col-xs-4 control-label"><?php _e('Heading', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_recent_products_title" id="shortcode_recent_products_title" class="form-control" type="text" value="Recent products">
								    <p class="help-block"><?php _e('Heading title', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_recent_products_num" class="col-xs-4 control-label"><?php _e('Items showing', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_recent_products_num" id="shortcode_recent_products_num" class="form-control" type="number" value="4">
								    <p class="help-block"><?php _e('The number of visible products will show on slider', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_recent_products_per_page" class="col-xs-4 control-label"><?php _e('Items per page', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_recent_products_per_page" id="shortcode_recent_products_per_page" class="form-control" type="number" value="12">
								    <p class="help-block"><?php _e('Total number of products', $themename); ?></p>
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-recent-posts">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Recent posts', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_recent_posts_title" class="col-xs-4 control-label"><?php _e('Heading', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_recent_posts_title" id="shortcode_recent_posts_title" class="form-control" type="text" value="From blog">
								    <p class="help-block"><?php _e('Heading title', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_recent_posts_num" class="col-xs-4 control-label"><?php _e('Items showing', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_recent_posts_num" id="shortcode_recent_posts_num" class="form-control" type="number" value="3">
								    <p class="help-block"><?php _e('The number of visible posts will show on slider', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_recent_posts_per_page" class="col-xs-4 control-label"><?php _e('Items per page', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_recent_posts_per_page" id="shortcode_recent_posts_per_page" class="form-control" type="number" value="12">
								    <p class="help-block"><?php _e('Number of posts limit', $themename); ?></p>
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-tabs">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Tabs', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_tabs_type" class="col-xs-4 control-label"><?php _e('Type', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_tabs_type" id="shortcode_tabs_type" class="form-control">
										<option value=""><?php _e('Normal', $themename); ?></option>
										<option value="vertical"><?php _e('Vertical', $themename); ?></option>
									</select>
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-social">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Social icons', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_social_type" class="col-xs-4 control-label"><?php _e('Type', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_social_type" id="shortcode_social_type" class="form-control">
										<option value="share"><?php _e('Share', $themename); ?></option>
										<option value="follow"><?php _e('Follow', $themename); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_social_title" class="col-xs-4 control-label"><?php _e('Title', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_social_title" id="shortcode_social_title" class="form-control" value="">
								    <p class="help-block"><?php _e('Can leave blank', $themename); ?></p>
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-map">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Google map', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_map_zoom" class="col-xs-4 control-label"><?php _e('Zoom', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_map_zoom" id="shortcode_map_zoom" class="form-control" type="number" value="16">
								    <p class="help-block"><?php _e('Enter zoom value (Default zoom is 16)', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_map_lat" class="col-xs-4 control-label"><?php _e('Latitude', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_map_lat" id="shortcode_map_lat" class="form-control" type="text">
								    <p class="help-block"><?php _e('The latitude of your address. <br/> Get the latitude and longitude for your address <a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">here</a>', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_map_lng" class="col-xs-4 control-label"><?php _e('Longitude', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_map_lng" id="shortcode_map_lng" class="form-control" type="text">
								    <p class="help-block"><?php _e('The longitude of your address', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_map_address" class="col-xs-4 control-label"><?php _e('Address', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_map_address" id="shortcode_map_address" class="form-control" type="text">
								    <p class="help-block"><?php _e('Enter your address', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_map_height" class="col-xs-4 control-label"><?php _e('Map height', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_map_height" id="shortcode_map_height" class="form-control" type="text">
								    <p class="help-block"><?php _e('Enter height of map (Default: 380px)', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_map_width" class="col-xs-4 control-label"><?php _e('Map width', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_map_width" id="shortcode_map_width" class="form-control" type="text">
								    <p class="help-block"><?php _e('Enter width of map (Default: 100%, but you can set is like: 700px)', $themename); ?></p>
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-testimonials">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Testimonials slider', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_testimonials_title" class="col-xs-4 control-label"><?php _e('Heading', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_testimonials_title" id="shortcode_testimonials_title" class="form-control" type="text" value="Testimonials">
								    <p class="help-block"><?php _e('Heading title', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_testimonials_num" class="col-xs-4 control-label"><?php _e('Items showing', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_testimonials_num" id="shortcode_testimonials_num" class="form-control" type="number" value="1">
								    <p class="help-block"><?php _e('The number of visible testimonials will show on slider', $themename); ?></p>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_testimonials_per_page" class="col-xs-4 control-label"><?php _e('Items per page', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_testimonials_per_page" id="shortcode_testimonials_per_page" class="form-control" type="number" value="12">
								    <p class="help-block"><?php _e('Total number of testimonials', $themename); ?></p>
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-panel">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Panel', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_panel_type" class="col-xs-4 control-label"><?php _e('Type', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_panel_type" id="shortcode_panel_type" class="form-control">
										<option value="1"><?php _e('Style 1', $themename); ?></option>
										<option value="2"><?php _e('Style 2', $themename); ?></option>
									</select>
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-progress">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Progress bar', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_progress_title" class="col-xs-4 control-label"><?php _e('Title', $themename); ?></label>
							    <div class="col-xs-8">
								     <input name="shortcode_progress_title" id="shortcode_progress_title" class="form-control" type="text">
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_progress_value" class="col-xs-4 control-label"><?php _e('Percent', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_progress_value" id="shortcode_progress_value" class="form-control" type="number">
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_progress_value_title" class="col-xs-4 control-label"><?php _e('Title for value', $themename); ?></label>
							    <div class="col-xs-8">
								    <input name="shortcode_progress_value_title" id="shortcode_progress_value_title" class="form-control" type="text">
								    <p class="help-block"><?php _e('Such as: 7/10, 2 days', $themename); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="shortcode-tab" id="shortcode-featured-box">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Featured box', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_featured_box_type" class="col-xs-4 control-label"><?php _e('Type', $themename); ?></label>
							    <div class="col-xs-8">
								    <select name="shortcode_featured_box_type" id="shortcode_featured_box_type" class="form-control">
										<option value="1"><?php _e('Normal', $themename); ?></option>
										<option value="2"><?php _e('Image left', $themename); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_featured_box_icon" class="col-xs-4 control-label"><?php _e('Icon', $themename); ?></label>
							    <div class="col-xs-8">
								    <input type="text" name="shortcode_featured_box_icon" id="shortcode_featured_box_icon" class="form-control">
								</div>
							</div>
							<div class="form-group">
							    <label for="shortcode_featured_box_title" class="col-xs-4 control-label"><?php _e('Title', $themename); ?></label>
							    <div class="col-xs-8">
								    <input type="text" name="shortcode_featured_box_title" id="shortcode_featured_box_title" class="form-control">
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="shortcode-tab" id="shortcode-team-members">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4><?php _e('Team members', $themename); ?></h4>
							<div class="form-group">
							    <label for="shortcode_team_member_per_page" class="col-xs-4 control-label"><?php _e('Per page', $themename); ?></label>
							    <div class="col-xs-8">
								    <input type="text" name="shortcode_team_member_per_page" id="shortcode_team_member_per_page" class="form-control">
								</div>
							</div>
						</div>
					</div>							
				</div>
				<div class="form-group">
			        <div class="col-lg-offset-4 col-xs-8">
			          	<button type="submit" class="btn btn-default" id="btn-insert-shortcode"><?php _e('Insert shortcode', $themename); ?></button>
			        </div>
			    </div>
			</form>
		</div>
	</div>
</body>
</html>