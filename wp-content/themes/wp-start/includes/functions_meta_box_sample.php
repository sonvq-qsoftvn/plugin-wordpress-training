<?php
global $meta_boxes;
$meta_boxes = array();

$prefix = $shortname.'_';

$meta_boxes[] = array(
	'id'      => 'post_thumbnail_options',
	'title'   => 'Post thumbnail options',
	'pages'   => array( 'post', 'portfolio' ),
	'context' => 'normal',
	'fields'  => array(
		array(
			'name' => __('Post detail type', $themename),
			'id'   => "{$prefix}post_type",
			'type' => 'select',
			'options' => array(
				'normal'       => 'Normal',
				'image'        => 'Image',
				'video'        => 'Video',
				'slider'       => 'Slider'
			),
			'multiple' => false,
			'std'      => 'image',
			'desc'     => __('Choose post type.', $themename),
		),

		array(
			'name'             => __('Post detail image', $themename),
			'desc'             => __('The image that will be used as the post detail image.', $themename),
			'id'               => "{$prefix}post_type_image",
			'type'             => 'image_advanced',
			'max_file_uploads' => 1
		),
		
		array(
			'name'  => __('Post detail video URL', $themename),
			'id'    => $prefix . 'post_type_video_url',
			'desc'  => __('Enter the video url from Vimeo & YouTube.', $themename),
			'clone' => false,
			'type'  => 'text',
			'std'   => '',
		),
		
		array(
			'name'             => __('Post detail slider', $themename),
			'desc'             => __('The images that will be used in the post detail slider.', $themename),
			'id'               => "{$prefix}post_type_slider",
			'type'             => 'image_advanced',
			'max_file_uploads' => 50,
		)
	)
);

$meta_boxes[] = array(
	'id'      => 'portfolio_meta',
	'title'   => 'Project detail',
	'pages'   => array( 'portfolio' ),
	'context' => 'normal',
	'fields'  => array(
		array(
			'name' => __('Project caption', $themename),
			'id'   => "{$prefix}portfolio_meta_title",
			'type' => 'text',
			'desc'     => __('Enter the caption for project title', $themename)
		),
		array(
			'name' => __('Project author', $themename),
			'id'   => "{$prefix}portfolio_meta_author",
			'type' => 'text',
			'desc'     => __('Enter the author name', $themename)
		),
		array(
			'name' => __('Project link', $themename),
			'id'   => "{$prefix}portfolio_meta_url",
			'type' => 'text',
			'desc'     => __('Enter the url of the project', $themename)
		)
	)
);

$meta_boxes[] = array(
	'id'      => 'post_layout_option',
	'title'   => 'Post layout options',
	'pages'   => array( 'portfolio' ),
	'context' => 'normal',
	'fields'  => array(
		array(
			'name' => __('Choose the layout for this post', $themename),
			'id'   => "{$prefix}post_layout",
			'type' => 'select',
			'options' => array(
				'no-sidebar'    => 'No sidebar',
				'left-sidebar'  => 'Left sidebar',
				'right-sidebar' => 'Right sidebar'
			),
			'multiple' => false,
			'std'      => 'right-sidebar',
			'desc'     => __('Choose the post layout.', $themename)
		)
	)
);

$meta_boxes[] = array(
	'id'      => 'testimonial_info',
	'title'   => 'Testimonial info',
	'pages'   => array( 'testimonials' ),
	'context' => 'normal',
	'fields'  => array(
		array(
			'name'             => __('Author image', $themename),
			'desc'             => 'The avatar of author.',
			'id'               => "{$prefix}testimonial_author_image",
			'type'             => 'image_advanced',
			'max_file_uploads' => 1
		),
		array(
			'name' => __('Author name', $themename),
			'id'   => "{$prefix}testimonial_author_name",
			'type' => 'text',
			'desc'     => __('Author name', $themename)
		),
		array(
			'name' => __('Author company', $themename),
			'id'   => "{$prefix}testimonial_author_company",
			'type' => 'text',
			'desc'     => __('Company name', $themename)
		)
	)
);

$meta_boxes[] = array(
	'id'      => 'team_info',
	'title'   => 'Team member\'s info',
	'pages'   => array( 'team' ),
	'context' => 'normal',
	'fields'  => array(
		array(
			'name'             => __('Position', $themename),
			'desc'             => 'The team member\'s position.',
			'id'               => "{$prefix}team_info_position",
			'type'             => 'text'
		),
		array(
			'name' => __('Phone number', $themename),
			'id'   => "{$prefix}team_info_phone",
			'type' => 'text',
			'desc'     => __('The contact phone number.', $themename)
		),
		array(
			'name' => __('Email', $themename),
			'id'   => "{$prefix}team_info_email",
			'type' => 'text',
			'desc'     => __('The contact email.', $themename)
		),
		array(
			'name' => __('Facebook', $themename),
			'id'   => "{$prefix}team_info_fb",
			'type' => 'text',
			'desc'     => __('The facebook url of team member.', $themename)
		),
		array(
			'name' => __('Twitter', $themename),
			'id'   => "{$prefix}team_info_twitter",
			'type' => 'text',
			'desc'     => __('The Twitter url of team member.', $themename)
		),
		array(
			'name' => __('Google +', $themename),
			'id'   => "{$prefix}team_info_gg",
			'type' => 'text',
			'desc'     => __('The google plus url of team member.', $themename)
		),
		array(
			'name' => __('LinkedIn', $themename),
			'id'   => "{$prefix}team_info_linkedin",
			'type' => 'text',
			'desc'     => __('The linkedin url of team member.', $themename)
		),
		array(
			'name' => __('Skype', $themename),
			'id'   => "{$prefix}team_info_skype",
			'type' => 'text',
			'desc'     => __('The skype ID of team member.', $themename)
		),
		array(
			'name' => __('Instagram', $themename),
			'id'   => "{$prefix}team_info_instagram",
			'type' => 'text',
			'desc'     => __('The Instagram url of team member.', $themename)
		)
	)
);

$meta_boxes[] = array(
		'id'    => 'client_meta_box',
		'title' => 'Client Meta',
		'pages' => array( 'clients' ),
		'fields' => array(
			
			// CLIENT IMAGE LINK
			array(
				'name' => 'Client Link',
				'id' => $prefix . 'client_link',
				'desc' => __('Enter the link for the client.', $themename),
				'clone' => false,
				'type'  => 'text',
				'std' => ''
			)
		)	
	);

function deeds_register_meta_boxes() {
	global $meta_boxes;

	if ( class_exists( 'RW_Meta_Box' ) ) {
		foreach ( $meta_boxes as $meta_box ) {
			new RW_Meta_Box( $meta_box );
		}
	}
}
add_action( 'admin_init', 'deeds_register_meta_boxes' );
?>
