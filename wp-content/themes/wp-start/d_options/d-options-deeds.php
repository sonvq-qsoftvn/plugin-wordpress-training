<?php
//Create options array
global $themename, $shortname, $options;

$cats_array = get_categories('hide_empty=0');
$pages_array = get_pages('hide_empty=0');
$pages_number = count($pages_array);

$site_pages = array();
$site_cats = array();
$pages_ids = array();
$cats_ids = array();

if(!empty($pages_array)) {
	foreach ($pages_array as $pagg) {
		$site_pages[$pagg->ID] = htmlspecialchars($pagg->post_title);
		$pages_ids[] = $pagg->ID;
	}
}

if(!empty($cats_array)) {
	foreach ($cats_array as $categs) {
		$site_cats[$categs->cat_ID] = $categs->cat_name;
		$cats_ids[] = $categs->cat_ID;
	}
}
	

$shortname 	= esc_html($shortname.'-');
$pages_ids 	= array_map('intval', $pages_ids);
$cats_ids 	= array_map('intval', $cats_ids);

$product_cats_array = get_terms('product_cat', array('hide_empty' => 0));
if(!empty($product_cats_array)) {
	foreach ($product_cats_array as $key => $value) {
		$product_cats[$value->term_id] = $value->name;
		$product_cats_ids[] = $value->term_id;
	}
}
	
require_once('font.php');

$options = array(
	array(
		'name' => 'general',
		'type' => 'd-tab-start'
	),
		array(
			'name' => 'tab-click',
			'type' => 'tab-click-start'
		),
			array(
				'name' => 'basic',
				'type' => 'tab-chosen',
				'desc' => esc_html__('General', $themename),				
			),
			array(
				'name' => 'homepage',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Homepage', $themename)
			),
			array(
				'name' => 'homepage-subscribe',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Homepage Subscribe Box', $themename)
			),

		array(
			'type' => 'tab-click-end'
		),

		array(
			'name' => 'basic',
			'type' => 'tab-focus-start'
		),
			array(
				"name"   => esc_html__("Logo", $themename),
				"id"     => $shortname."site-logo",
				"type"   => "upload",
				"desc"   => esc_html__("Upload your logo or insert logo link. (Recommend: 150x90 px) ", $themename),
				"review" => true
			),
			array(
				"name"   => esc_html__("Favicon", $themename),
				"id"     => $shortname."site-favicon",
				"type"   => "upload",
				"desc"   => esc_html__("Upload your favicon.", $themename),
				"review" => true
			),
			array(
				"name" => esc_html__("Site name", $themename),
				"id"   => $shortname."site-name",
				"std"  => '',
				"type" => "text",
				"desc" => esc_html__("Enter your site name. ", $themename)
			),
			array(
				"name" => esc_html__("Site title", $themename),
				"id"   => $shortname."site-title",
				"std"  => '',
				"type" => "text",
				"desc" => esc_html__("Enter your site title. Exp: Best product for you", $themename)
			),
			array(
				"name" => esc_html__("Copyright text", $themename),
				"id"   => $shortname."copyright-text",
				"std"  => 'Copyright © 2013 ' . $themename,
				"type" => "text",
				'html' => true,
				"desc" => esc_html__("Enter your copyright text. Exp: Copyright © 2013 " . $themename, $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),

		array(
			'name' => 'homepage',
			'type' => 'tab-focus-start'
		),
			array(
				"name"         => esc_html__("Enable featured products", $themename),
				"id"           => $shortname."home-featured-products-enabled",
				"type"         => "checkbox-single",
				"desc"         => esc_html__("Enable featured products on hompage.",$themename),
				"std"          => 'on',
			),
			array(
				"name" => __('Featured products title', $themename),
				"id"   => $shortname."home-featured-products-title",
				"std"  => __('Featured products', $themename),
				"type" => "text",
				"desc" => esc_html__("The title of featured products. ", $themename)
			),
			array(
				"name"         => esc_html__("Number of featured products", $themename),
				"id"           => $shortname."home-featured-products-number",
				"type"         => "number",
				"desc"         => esc_html__("Enter the number of featured products on hompage.",$themename),
				"std"          => '12',
			),
			array(
				"name"        => esc_html__("Exclude featured products category", $themename),
				"id"          => $shortname."home-featured-products-cat-exclude",
				"type"        => "checkbox-multi",
				"options"	  => $product_cats,
				"list"	 	  => $product_cats_ids,
				"desc"        => esc_html__("Exclude featured products categories on hompage.",$themename),
			),
			array(
				"name"         => esc_html__("Enable recent products", $themename),
				"id"           => $shortname."home-recent-products-enabled",
				"type"         => "checkbox-single",
				"desc"         => esc_html__("Enable recent products on hompage.",$themename),
				"std"          => 'on',
			),
			array(
				"name" => __('Recent products title', $themename),
				"id"   => $shortname."home-recent-products-title",
				"std"  => __('Recent products', $themename),
				"type" => "text",
				"desc" => esc_html__("The title of recent products. ", $themename)
			),
			array(
				"name"         => esc_html__("Number of recent products", $themename),
				"id"           => $shortname."home-recent-products-number",
				"type"         => "number",
				"desc"         => esc_html__("Enter the number of recent products on hompage.",$themename),
				"std"          => '12',
			),
			array(
				"name"        => esc_html__("Exclude recent products category", $themename),
				"id"          => $shortname."home-recent-products-cat-exclude",
				"type"        => "checkbox-multi",
				"options"	  => $product_cats,
				"list"	 	  => $product_cats_ids,
				"desc"        => esc_html__("Exclude recent products categories on hompage.",$themename),
			),
			array(
				"name"         => esc_html__("Enable recent posts", $themename),
				"id"           => $shortname."home-recent-posts-enabled",
				"type"         => "checkbox-single",
				"desc"         => esc_html__("Enable recent posts on hompage.",$themename),
				"std"          => 'on',
				"mask-control" => true
			),
			array(
				"name" => __('Recent blog posts title', $themename),
				"id"   => $shortname."home-recent-posts-title",
				"std"  => __('From blog', $themename),
				"type" => "text",
				"desc" => esc_html__("The title of recent posts. ", $themename)
			),
			array(
				"name"        => esc_html__("Exclude recent posts from categories", $themename),
				"id"          => $shortname."home-recent-posts-categories-exclude",
				"type"        => "checkbox-multi",
				"options"	  => $site_cats,
				"list"	 	  => $cats_ids,
				"desc"        => esc_html__("Choose categories for recent posts.",$themename),
				"mask"        => $shortname."home-recent-posts-enabled"
			),
			array(
				"name"          => esc_html__("Enable about descriptions", $themename),
				"id"            => $shortname."home-about-enabled",
				"type"          => "checkbox-single",
				"desc"          => esc_html__("Enable about store on hompage.",$themename),
				"std" 		    => 'on',
				"mask-control" => true
			),
			array(
				"name" => __('About box title', $themename),
				"id"   => $shortname."home-about-title",
				"std"  => __('About us', $themename),
				"type" => "text",
				"desc" => esc_html__("The title of about box. ", $themename)
			),			
			array(
				"name" => esc_html__("About description", $themename),
				"id"   => $shortname."home-about-desc",
				"type" => "textarea",
				"desc" => esc_html__("Enter some descriptions to introduce your store.", $themename),
				"mask" => $shortname."home-about-enabled"
			),
		array(
			'type' => 'tab-focus-end'
		),
		array(
			'name' => 'homepage-subscribe',
			'type' => 'tab-focus-start'
		),
			array(
				"name"         => esc_html__("Enable subscribe box", $themename),
				"id"           => $shortname."home-subscribe-enabled",
				"type"         => "checkbox-single",
				"desc"         => esc_html__("Enable subscribe subscribe on hompage.",$themename),
				"std"          => 'on',
			),
			array(
				"name" => __('Subscribe box title', $themename),
				"id"   => $shortname."home-subscribe-title",
				"std"  => __('<i class="icon-envelope"></i> JOIN OUR NEWSLETTER!', $themename),
				"type" => "text",
				'html' => true,
				"desc" => esc_html__("Enter the title of subscribe box on homepage. ", $themename)
			),
			array(
				"name" => esc_html__("Subscribe description", $themename),
				"id"   => $shortname."home-subscribe-description",
				"type" => "textarea",
				"std"  => esc_html__('If you enjoy to get news and all notice about products from us, Please subscribe to our newsletter!', $themename),
				"desc" => esc_html__("Enter some descriptions in subscribe box.", $themename)
			),
			array(
				"name" => __('Subscribe box submit button', $themename),
				"id"   => $shortname."home-subscribe-submit",
				"std"  => esc_html__('Join us!', $themename),
				"type" => "text",
				"html" => true,
				"desc" => esc_html__("Enter the value of subscribe submit button on homepage. ", $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
	array(
		'type' => 'd-tab-end'
	),
	array(
		'name' => 'layout',
		'type' => 'd-tab-start'
	),
		array(
			'name' => 'tab-click',
			'type' => 'tab-click-start'
		),
			array(
				'name' => 'layout-basic',
				'type' => 'tab-chosen',
				'desc' => esc_html__('General settings', $themename)
			),
			array(
				'name' => 'layout-page',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Page & post layout', $themename)
			),
			array(
				'name' => 'layout-bg-colors',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Background colors', $themename)
			),
			array(
				'name' => 'layout-btn-colors',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Button colors', $themename)
			),

		array(
			'type' => 'tab-click-end'
		),

		array(
			'name' => 'layout-basic',
			'type' => 'tab-focus-start'
		),
			array(
				"name"        => esc_html__("Main layout", $themename),
				"id"          => $shortname."layout-type",
				"type"        => "radio",
				"std"		  => "with-sidebar",
				"options"	  => array(
					'with-sidebar' => '<i class="ico-layout-withsidebar"></i> ' . esc_html__('With sidebar', $themename),
					'no-sidebar' => '<i class="ico-layout-nosidebar"></i> ' . esc_html__('No sidebar', $themename)
				),
				//"list"	 	  => $cats_ids,
				"desc"        => esc_html__("Chose your layout type.", $themename)
			),
			array(
				"name"        => esc_html__("Sidebar position", $themename),
				"id"          => $shortname."layout-sidebar-position",
				"type"        => "radio",
				"std"		  => "right-sidebar",
				"options"	  => array(
					'left-sidebar'  => esc_html__('Sidebar on left', $themename),
					'right-sidebar' =>  esc_html__('Sidebar on right', $themename)
				),
				//"list"	 	  => $cats_ids,
				"desc"        => esc_html__("Chose your sidebar position.", $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
		array(
			'name' => 'layout-page',
			'type' => 'tab-focus-start'
		),
			array(
				"name"          => esc_html__("Display thumbs on page", $themename),
				"id"            => $shortname."display-thumbs-page",
				"type"          => "checkbox-single",
				'std'			=> 'on',
				"desc"          => esc_html__("Display thumbs on blog page.",$themename)
			),
			array(
				"name"          => esc_html__("Display thumbs on single page", $themename),
				"id"            => $shortname."display-thumbs-single-page",
				"type"          => "checkbox-single",
				'std'			=> 'on',
				"desc"          => esc_html__("Display thumbs on single page.",$themename)
			),
			array(
				"name"          => esc_html__("Display comments on single page", $themename),
				"id"            => $shortname."display-comments-single-page",
				"type"          => "checkbox-single",
				'std'			=> 'on',
				"desc"          => esc_html__("Display comments on single page or post.",$themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
		array(
			'name' => 'layout-bg-colors',
			'type' => 'tab-focus-start'
		),
			array(
				"name"          => esc_html__("Body background color", $themename),
				"id"            => $shortname."body-bg-color",
				"type"          => "colorpicker",
				"std"           => '#FFFFFF',
				"desc"        => esc_html__("Change the body background color (Default: #FFFFFF).", $themename)
			),
			array(
				"name"          => esc_html__("Header background color", $themename),
				"id"            => $shortname."header-bg-color",
				"type"          => "colorpicker",
				"std"           => '#FFFFFF',
				"desc"        => esc_html__("Change the background color of header (Default: #FFFFFF).", $themename)
			),
			array(
				"name"          => esc_html__("Top nav background current menu", $themename),
				"id"            => $shortname."top-nav-current-color",
				"type"          => "colorpicker",
				"std"           => '#FF5B6D',
				"desc"        => esc_html__("Background color of current menu item (Default: #FF5B6D).", $themename)
			),
			array(
				"name"          => esc_html__("Main nav background color", $themename),
				"id"            => $shortname."nav-bg-color",
				"type"          => "colorpicker",
				"std"           => '#FF5B6D',
				"desc"        => esc_html__("Background color of category navigation (Default: #FF5B6D).", $themename)
			),
			array(
				"name"          => esc_html__("Onsale background color", $themename),
				"id"            => $shortname."onsale-bg-color",
				"type"          => "colorpicker",
				"std"           => '#FF5B6D',
				"desc"        => esc_html__("Change the background color of onsale (Default: #FF5B6D).", $themename)
			),
			array(
				"name"          => esc_html__("Footer background color", $themename),
				"id"            => $shortname."footer-bg-color",
				"type"          => "colorpicker",
				"std"           => '#333333',
				"desc"        => esc_html__("Change the background color of footer (Default: #333333).", $themename)
			),
			array(
				"name"          => esc_html__("Footer copyright background color", $themename),
				"id"            => $shortname."footer-copyright-bg-color",
				"type"          => "colorpicker",
				"std"           => '#000000',
				"desc"        => esc_html__("Change the background color of footer copyright (Default: #000000).", $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
		array(
			'name' => 'layout-btn-colors',
			'type' => 'tab-focus-start'
		),
			array(
				"name"          => esc_html__("Button text color", $themename),
				"id"            => $shortname."button-text-color",
				"type"          => "colorpicker",
				"std"           => '#FFFFFF',
				"desc"        => esc_html__("Change the color of button value (Default: #FFFFFF).", $themename)
			),
			array(
				"name"          => esc_html__("Button default color", $themename),
				"id"            => $shortname."button-bg-color",
				"type"          => "colorpicker",
				"std"           => '#FF5B6D',
				"desc"        => esc_html__("Change the background color of button (Default: #FF5B6D).", $themename)
			),
			array(
				"name"          => esc_html__("Button boder default color", $themename),
				"id"            => $shortname."button-border-color",
				"type"          => "colorpicker",
				"std"           => '#FF5B6D',
				"desc"        => esc_html__("Change the border color of button (Default: #FF5B6D).", $themename)
			),
			array(
				"name"          => esc_html__("Button hover text color", $themename),
				"id"            => $shortname."button-text-color-hover",
				"type"          => "colorpicker",
				"std"           => '#FFFFFF',
				"desc"        => esc_html__("Change the color of button value when hover (Default: #FFFFFF).", $themename)
			),
			array(
				"name"          => esc_html__("Button on hover color", $themename),
				"id"            => $shortname."button-bg-color-hover",
				"type"          => "colorpicker",
				"std"           => '#FF7B89',
				"desc"        => esc_html__("Change the background color of button when hover(Default: #FF7B89).", $themename)
			),
			array(
				"name"          => esc_html__("Button boder on hover color", $themename),
				"id"            => $shortname."button-border-color-hover",
				"type"          => "colorpicker",
				"std"           => '#F22B41',
				"desc"        => esc_html__("Change the border color of button when hover (Default: #F22B41).", $themename)
			),
			
		array(
			'type' => 'tab-focus-end'
		),
	array(
		'type' => 'd-tab-end'
	),

	array(
		'name' => 'typo',
		'type' => 'd-tab-start'
	),
		array(
			'name' => 'tab-click',
			'type' => 'tab-click-start'
		),
			array(
				'name' => 'typo-basic',
				'type' => 'tab-chosen',
				'desc' => esc_html__('General typography', $themename)
			),
			array(
				'name' => 'typo-header',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Header typography', $themename)
			),
			array(
				'name' => 'typo-footer',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Footer typography', $themename)
			),

		array(
			'type' => 'tab-click-end'
		),

		array(
			'name' => 'typo-basic',
			'type' => 'tab-focus-start'
		),
			array(
				"name"        => esc_html__("Choose the subsets:", $themename),
				"id"          => $shortname."google-subsets",
				"type"        => "checkbox-multi",
				"options"	  => $google_subset,
				"desc"        => esc_html__("Choose the character sets of google font you want.",$themename),
			),
			array(
				"name"        => esc_html__("General font", $themename),
				"id"          => $shortname."general-font",
				"type"        => "typography",
				"std"		  => array(
									'size'  => '13',
									'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
									'style' => 'normal',
									'unit'  => 'px',
									'color' => '#4c4c4c',
									'transform' => ''
							    ),

				"desc"        => esc_html__('Change the general font type (Default: 13px, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, normal, #4c4c4c).', $themename)
			),

			array(
				"name"          => esc_html__("General links", $themename),
				"id"            => $shortname."general-links-color",
				"type"          => "colorpicker",
				"std"           => '#444444',
				"desc"        => esc_html__("Change the general link color (Default: #444444).", $themename)
			),
			array(
				"name"          => esc_html__("Links hover", $themename),
				"id"            => $shortname."general-links-color-hover",
				"type"          => "colorpicker",
				"std"           => '#FF5B6D',
				"desc"        => esc_html__("Change the general link color (Default: #FF5B6D).", $themename)
			),
			array(
				"name"          => esc_html__("Price color", $themename),
				"id"            => $shortname."general-price-color",
				"type"          => "colorpicker",
				"std"           => '#FF5B6D',
				"desc"        => esc_html__("Change the price color (Default: #FF5B6D).", $themename)
			),
			array(
				"name"        => esc_html__("Headings 1 font", $themename),
				"id"          => $shortname."h1-font",
				"type"        => "typography",
				"std"		  => array(
									'size'  => '24',
									'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
									'style' => 'normal',
									'unit'  => 'px',
									'color' => '#777777',
									'transform' => 'uppercase'
							    ),

				"desc"        => esc_html__('Change the headings 1 font type (Default: 24px, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, normal, #777777, uppercase).', $themename)
			),
			array(
				"name"        => esc_html__("Headings 2 font", $themename),
				"id"          => $shortname."h2-font",
				"type"        => "typography",
				"std"		  => array(
									'size'  => '18',
									'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
									'style' => 'normal',
									'unit'  => 'px',
									'color' => '#777777',
									'transform' => 'uppercase'
							    ),

				"desc"        => esc_html__('Change the headings 2 font type (Default: 17px, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, normal, #777777, uppercase).', $themename)
			),
			array(
				"name"        => esc_html__("Headings 3 font", $themename),
				"id"          => $shortname."h3-font",
				"type"        => "typography",
				"std"		  => array(
									'size'  => '16',
									'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
									'style' => 'normal',
									'unit'  => 'px',
									'color' => '#777777',
									'transform' => 'uppercase'
							    ),

				"desc"        => esc_html__('Change the headings 3 font type (Default: 16px, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, normal, #777777, uppercase).', $themename)
			),
			array(
				"name"        => esc_html__("Headings 4 font", $themename),
				"id"          => $shortname."h4-font",
				"type"        => "typography",
				"std"		  => array(
									'size'  => '14',
									'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
									'style' => 'normal',
									'unit'  => 'px',
									'color' => '#777777',
									'transform' => 'uppercase'
							    ),

				"desc"        => esc_html__('Change the headings 4 font type (Default: 14px, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, normal, #777777, uppercase).', $themename)
			),
			array(
				"name"        => esc_html__("Headings 5 font", $themename),
				"id"          => $shortname."h5-font",
				"type"        => "typography",
				"std"		  => array(
									'size'  => '13',
									'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
									'style' => 'normal',
									'unit'  => 'px',
									'color' => '#777777',
									'transform' => 'uppercase'
							    ),

				"desc"        => esc_html__('Change the headings 5 font type (Default: 12px, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, normal, #777777, uppercase).', $themename)
			),
			array(
				"name"        => esc_html__("Headings 6 font", $themename),
				"id"          => $shortname."h6-font",
				"type"        => "typography",
				"std"		  => array(
									'size'  => '11',
									'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
									'style' => 'normal',
									'unit'  => 'px',
									'color' => '#777777',
									'transform' => 'uppercase'
							    ),

				"desc"        => esc_html__('Change the headings 6 font type (Default: 11px, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, normal, #777777, uppercase).', $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
		array(
			'name' => 'typo-header',
			'type' => 'tab-focus-start'
		),
			array(
				"name"        => esc_html__("Logo font", $themename),
				"id"          => $shortname."logo-font",
				"type"        => "typography",
				"std"		  => array(
									'size'  => '30',
									'face'  => 'Berkshire Swash',
									'style' => 'normal',
									'unit'  => 'px',
									'color' => '#FF5B6D',
									'transform' => ''
							    ),

				"desc"        => esc_html__('Change the logo font type if you dont use image for logo(Default: 30px, Berkshire Swash, normal, #FF5B6D).', $themename)
			),
			array(
				"name" => esc_html__("Top navigation links style", $themename),
				"id"   => $shortname."nav-top-font",
				"type" => "typography",
				"std"  => array(
					'size'  => '13',
					'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
					'style' => 'bold',
					'unit'  => 'px',
					'color' => '#777777',
					'transform' => ''
			    ),
				"desc"        => esc_html__('Change the top navigation links style (Default: 13px, bold, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, #777777).', $themename)
			),
			array(
				"name" => esc_html__("Categories navigation links color", $themename),
				"id"   => $shortname."nav-cat-font",
				"type" => "typography",
				"std"  => array(
					'size'  => '13',
					'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
					'style' => 'bold',
					'unit'  => 'px',
					'color' => '#FFFFFF',
					'transform' => ''
			    ),
				"desc"        => esc_html__('Change the categories navigation links style (Default: 13px, bold, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, #FFFFFF).', $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),

		array(
			'name' => 'typo-footer',
			'type' => 'tab-focus-start'
		),
			array(
				"name" => esc_html__("Footer font style", $themename),
				"id"   => $shortname."footer-font",
				"type" => "typography",
				"std"		  => array(
					'size'  => '13',
					'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
					'style' => 'normal',
					'unit'  => 'px',
					'color' => '#DFDFDF',
					'transform' => ''
			    ),
				"desc"        => esc_html__('Change the footer links style (Default: 13px, normal, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, #DFDFDF).', $themename)
			),
			array(
				"name" => esc_html__("Footer links style", $themename),
				"id"   => $shortname."footer-links",
				"type" => "typography",
				"std"		  => array(
					'size'  => '13',
					'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
					'style' => 'normal',
					'unit'  => 'px',
					'color' => '#FFFFFF',
					'transform' => ''
			    ),
				"desc"        => esc_html__('Change the footer links style (Default: 13px, normal, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, #FFFFFF).', $themename)
			),
			array(
				"name" => esc_html__("Footer links hover color", $themename),
				"id"   => $shortname."footer-links-hover-color",
				"type" => "colorpicker",
				"std"  => '#999999',
				"desc" => esc_html__('Change the footer links hover color (Default: #999999).', $themename)
			),
			array(
				"name" => esc_html__("Footer widgets title font", $themename),
				"id"   => $shortname."footer-widgets-title",
				"type" => "typography",
				"std"		  => array(
					'size'  => '16',
					'face'  => '"Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif',
					'style' => 'bold',
					'unit'  => 'px',
					'color' => '#FFFFFF',
					'transform' => 'uppercase'
			    ),
				"desc"        => esc_html__('Change the footer wigets title style (Default: 16px, normal, "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif, #FFFFFF, uppercase).', $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
	array(
		'type' => 'd-tab-end'
	),

	array(
		'name' => 'social',
		'type' => 'd-tab-start'
	),
		array(
			'name' => 'tab-click',
			'type' => 'tab-click-start'
		),			
			array(
				'name' => 'social-connect',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Social connect', $themename)
			),
			array(
				'name' => 'facebook-api',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Facebook settings', $themename)
			),
		array(
			'type' => 'tab-click-end'
		),
		array(
			'name' => 'social-connect',
			'type' => 'tab-focus-start'
		),
			array(
				"name" => __('<i class="icon-facebook-sign"></i> Facebook page url', $themename),
				"id"   => $shortname."facebook-url",
				"std"  => '',
				"type" => "text",
				"desc" => esc_html__("Link to your Facebook fan page. ", $themename)
			),
			array(
				"name" => __('<i class="icon-twitter"></i> Twitter page url', $themename),
				"id"   => $shortname."twitter-url",
				"std"  => '',
				"type" => "text",
				"desc" => esc_html__("Link to your Twitter page. ", $themename)
			),
			array(
				"name" => __('<i class="icon-google-plus-sign"></i> Google + page url', $themename),
				"id"   => $shortname."google-plus-url",
				"std"  => '',
				"type" => "text",
				"desc" => esc_html__("Link to your google plus page. ", $themename)
			),
			array(
				"name" => __('<i class="icon-linkedin-sign"></i> Linkedin profile page url', $themename),
				"id"   => $shortname."linkedin-url",
				"std"  => '',
				"type" => "text",
				"desc" => esc_html__("Link to your Linkedin profile. ", $themename)
			),
			array(
				"name" => __('<i class="icon-youtube"></i> Youtube channel url', $themename),
				"id"   => $shortname."youtube-url",
				"std"  => '',
				"type" => "text",
				"desc" => esc_html__("Link to your Youtube channel. ", $themename)
			),
			array(
				"name" => __('<i class="icon-pinterest"></i> Pinterest page url', $themename),
				"id"   => $shortname."pinterest-url",
				"std"  => '',
				"type" => "text",
				"desc" => esc_html__("Link to your Pinterest page url. ", $themename)
			),
			
		array(
			'type' => 'tab-focus-end'
		),
		array(
			'name' => 'facebook-api',
			'type' => 'tab-focus-start'
		),
			array(
				"name" => __('Facebook API key', $themename),
				"id"   => $shortname."facebook-api-key",
				"std"  => '',
				"type" => "text",
				"desc" => esc_html__("The APPid of your facebook application. ", $themename)
			),
			array(
				"name" => __('Facebook like box enable', $themename),
				"id"   => $shortname."facebook-likebox-enabled",
				"std"  => 'on',
				"type" => "checkbox-single",
				"desc" => esc_html__("Enable the facebook likebox at the footer. ", $themename)
			),
			array(
				"name"          => esc_html__("Likebox background color", $themename),
				"id"            => $shortname."facebook-likebox-bg",
				"type"          => "colorpicker",
				"std"           => '#F2F2F2',
				"desc"        => esc_html__("Change the Likebox background color (Default: #F2F2F2).", $themename)
			),
			array(
				"name" => __('Likebox width', $themename),
				"id"   => $shortname."facebook-likebox-width",
				"std"  => '1080',
				"type" => "text",
				"desc" => esc_html__("Setting the width for likebox. ", $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
	array(
		'type' => 'd-tab-end'
	),
	array(
		'name' => 'custom-codes',
		'type' => 'd-tab-start'
	),
		array(
			'name' => 'tab-click',
			'type' => 'tab-click-start'
		),			
			array(
				'name' => 'custom-styles',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Custom style', $themename)
			),
			array(
				'name' => 'custom-scripts',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Custom script', $themename)
			),
			array(
				'name' => 'google-analytics-code',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Google Analytics code include script tag', $themename)
			),
		array(
			'type' => 'tab-click-end'
		),
		array(
			'name' => 'custom-styles',
			'type' => 'tab-focus-start'
		),
			array(
				"name" => esc_html__("Your additional style code", $themename),
				"id"   => $shortname."custom-style-code",
				"type" => "textarea",
				"desc" => esc_html__("Enter your own stylesheet code (Without <style> tag).", $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
		array(
			'name' => 'custom-scripts',
			'type' => 'tab-focus-start'
		),
			array(
				"name" => esc_html__("Your additional script code", $themename),
				"id"   => $shortname."custom-script-code",
				"type" => "textarea",
				"desc" => esc_html__("Enter your script code (Without <script> tag).", $themename)
			),			
		array(
			'type' => 'tab-focus-end'
		),
		array(
			'name' => 'google-analytics-code',
			'type' => 'tab-focus-start'
		),
			array(
				"name" => esc_html__("Your Google Analytics code", $themename),
				"id"   => $shortname."google-analytics-code",
				"type" => "textarea",
				"desc" => esc_html__("Enter all Google Analytics code.", $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
	array(
		'type' => 'd-tab-end'
	),
	array(
		'name' => 'contact',
		'type' => 'd-tab-start'
	),
		array(
			'name' => 'tab-click',
			'type' => 'tab-click-start'
		),			
			array(
				'name' => 'contact-address',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Contact Address', $themename)
			),
			array(
				'name' => 'contact-google-map',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Contact Google map', $themename)
			),
		array(
			'type' => 'tab-click-end'
		),
		array(
			'name' => 'contact-address',
			'type' => 'tab-focus-start'
		),
			array(
				"name" => esc_html__("Phone number", $themename),
				"id"   => $shortname."contact-phone",
				"type" => "text",
				"desc" => esc_html__("Enter your phone number.", $themename)
			),
			array(
				"name" => esc_html__("Fax number", $themename),
				"id"   => $shortname."contact-fax",
				"type" => "text",
				"desc" => esc_html__("Enter your fax number.", $themename)
			),
			array(
				"name" => esc_html__("Email address", $themename),
				"id"   => $shortname."contact-email",
				"type" => "text",
				"desc" => esc_html__("Enter your email address.", $themename)
			),
			array(
				"name" => esc_html__("Address", $themename),
				"id"   => $shortname."contact-address",
				"type" => "text",
				"desc" => esc_html__("Enter your address.", $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
		array(
			'name' => 'contact-google-map',
			'type' => 'tab-focus-start'
		),
			array(
				"name"          => esc_html__("Enable google map", $themename),
				"id"            => $shortname."enable-google-map",
				"type"          => "checkbox-single",
				"std"			=> 'on',
				"desc"          => esc_html__("Enable google map on contact page.",$themename),
			),
			array(
				"name" => esc_html__("Latitude", $themename),
				"id"   => $shortname."google-latitude",
				"type" => "text",
				"desc" => __('Enter your Latitude. <br>The latitude of your address. <br/> Get the latitude and longitude for your address <a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">here</a>', $themename)
			),
			array(
				"name" => esc_html__("Longitude", $themename),
				"id"   => $shortname."google-longtitude",
				"type" => "text",
				"desc" => __('Enter your Longitude.', $themename)
			),
			array(
				"name" => esc_html__("Info map title", $themename),
				"id"   => $shortname."google-info-title",
				"type" => "text",
				"desc" => esc_html__("The title of info window on map.", $themename)
			),
			array(
				"name" => esc_html__("Info map description", $themename),
				"id"   => $shortname."google-info-description",
				"type" => "textarea",
				"desc" => esc_html__("The description of info window on map.", $themename)
			),
		array(
			'type' => 'tab-focus-end'
		),
	array(
		'type' => 'd-tab-end'
	),
	array(
		'name' => 'wooshop',
		'type' => 'd-tab-start'
	),
		array(
			'name' => 'tab-click',
			'type' => 'tab-click-start'
		),			
			array(
				'name' => 'woo-general',
				'type' => 'tab-chosen',
				'desc' => esc_html__('General settings', $themename)
			),
			array(
				'name' => 'woo-layout',
				'type' => 'tab-chosen',
				'desc' => esc_html__('Layout settings', $themename)
			),
		array(
			'type' => 'tab-click-end'
		),
		array(
			'name' => 'woo-general',
			'type' => 'tab-focus-start'
		),
			array(
				"name"   => esc_html__("Shop banner image", $themename),
				"id"     => $shortname."shop-banner",
				"type"   => "upload",
				"desc"   => esc_html__("Upload your shop banner or insert banner link.", $themename),
				"review" => true
			),
			array(
				"name"          => esc_html__("Catalog mode", $themename),
				"id"            => $shortname."shop-catalog-mode",
				"type"          => "checkbox-single",
				"desc"          => esc_html__("Check to enable catalog mode (Disable add to cart button).", $themename)
			),
			array(
				"name"          => esc_html__("Hide price", $themename),
				"id"            => $shortname."shop-hide-price",
				"type"          => "checkbox-single",
				"desc"          => esc_html__("Check to hide the product's price in catalog mode.", $themename)
			),
			array(
				"name"          => esc_html__("Hide short description", $themename),
				"id"            => $shortname."shop-hide-desc",
				"type"          => "checkbox-single",
				"desc"          => esc_html__("Check to hide the product's short description on catalog page.", $themename)
			),
			array(
				"name"         => esc_html__("Show category navigation", $themename),
				"id"           => $shortname."shop-cat-nav-enabled",
				"type"         => "checkbox-single",
				"desc"         => esc_html__("Display category menu on header.",$themename),
				"std"          => 'on',
			),
		array(
			'type' => 'tab-focus-end'
		),

		array(
			'name' => 'woo-layout',
			'type' => 'tab-focus-start'
		),
			array(
				"name"          => esc_html__("Enable shop sidebar", $themename),
				"id"            => $shortname."shop-sidebar-enable",
				"type"          => "checkbox-single",
				"desc"          => esc_html__("Show sidebar on shop catalog page.", $themename)
			),
			array(
				"name"          => esc_html__("Shop single sidebar", $themename),
				"id"            => $shortname."shop-single-sidebar-enable",
				"type"          => "checkbox-single",
				"desc"          => esc_html__("Show sidebar on single page.", $themename)
			),
			array(
				"name"    => esc_html__("Shop columns", $themename),
				"id"      => $shortname."shop-columns",
				"type"    => "select",
				"options" => array(
					'2' => '2 Columns',
					'3' => '3 Columns',
					'4' => '4 Columns',
				),
				"desc"    => esc_html__("Select shop columns in catalog page.", $themename)
			),
			array(
				"name"    => esc_html__("Default view type", $themename),
				"id"      => $shortname."shop-default-view-type",
				"type"    => "select",
				"options" => array(
					'grid' => 'Grid',
					'list' => 'List'
				),
				"desc"    => esc_html__("Default view type on shop page (Grid | List).", $themename)
			),
			array(
				"name"          => esc_html__("Products per page", $themename),
				"id"            => $shortname."shop-product-per-page",
				"type"          => "text",
				"std"			=> 12,
				"desc"          => esc_html__("Number of products each page.", $themename)
			),

		array(
			'type' => 'tab-focus-end'
		),

	array(
		'type' => 'd-tab-end'
	),
)
?>