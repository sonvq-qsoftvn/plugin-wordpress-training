<?php
global $meta_boxes;
$meta_boxes = array();

$prefix = $shortname.'_';

/** Metabox service link **/
$meta_boxes[] = array(
	'id'      => 'service_meta_link',
	'title'   => 'Service link',
	'pages'   => array( 'service' ),
	'context' => 'normal',
	'fields'  => array(
		array(
			'name' => __('Link caption', $themename),
			'id'   => "{$prefix}portfolio_meta_title",
			'type' => 'text',
			'desc' => __('Enter the caption for the button', $themename),
			'std'  => 'Visit site'
		),
		array(
			'name' => __('Link address', $themename),
			'id'   => "{$prefix}portfolio_meta_author",
			'type' => 'text',
			'desc'     => __('Enter the link address', $themename),
			'std' =>'http://'
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
