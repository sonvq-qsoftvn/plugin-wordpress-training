<?php
/** Testimonials **/
add_action( 'init', 'create_testimonials' );
function create_testimonials() {
    global $themename;
    $labels = array(
        'name'               => __('Testimonials', $themename),
        'singular_name'      => __('Testimonial', $themename),
        'add_new'            => __('Add New', $themename),
        'add_new_item'       => __('Add New Testimonial', $themename),
        'edit_item'          => __('Edit Testimonial', $themename),
        'new_item'           => __('New Testimonial', $themename),
        'view_item'          => __('View Testimonial', $themename),
        'search_items'       => __('Search Testimonials', $themename),
        'not_found'          => __('No Testimonials found', $themename),
        'not_found_in_trash' => __('No Testimonials in the trash', $themename),
        'parent_item_colon'  => '',
    );
 
    register_post_type( 'testimonials', array(
        'labels'            => $labels,  
        'public'            => true,  
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => false,
        'rewrite'           => false,
        'supports'          => array('title', 'editor')
    ) );
}
?>