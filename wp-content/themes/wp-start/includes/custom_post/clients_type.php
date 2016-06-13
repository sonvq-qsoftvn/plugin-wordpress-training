<?php
/** Testimonials **/
add_action( 'init', 'create_clients' );
function create_clients() {
    global $themename;
    $labels = array(
        'name'               => __('Client', $themename),
        'singular_name'      => __('Client', $themename),
        'add_new'            => __('Add New', $themename),
        'add_new_item'       => __('Add New Client', $themename),
        'edit_item'          => __('Edit Client', $themename),
        'new_item'           => __('New Client', $themename),
        'view_item'          => __('View Client', $themename),
        'search_items'       => __('Search Clients', $themename),
        'not_found'          => __('No Clients found', $themename),
        'not_found_in_trash' => __('No Clients in the trash', $themename),
        'parent_item_colon'  => '',
    );
 
    register_post_type( 'clients', array(
        'labels'            => $labels,  
        'public'            => true,  
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => false,
        'rewrite'           => false,
        'supports'          => array('title', 'thumbnail')
    ) );
}
?>