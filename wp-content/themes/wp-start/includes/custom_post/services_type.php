<?php
/** Services **/
    
add_action('init', 'services_register');  
  
function services_register() {  
    global $themename;
    $labels = array(
        'name'               => __('Services', 'post type general name', $themename),
        'singular_name'      => __('Service', 'post type singular name', $themename),
        'add_new'            => __('Add New', 'service', $themename),
        'add_new_item'       => __('Add New Service', $themename),
        'edit_item'          => __('Edit Service', $themename),
        'new_item'           => __('New Service', $themename),
        'view_item'          => __('View Service', $themename),
        'search_items'       => __('Search Portfolio', $themename),
        'not_found'          =>  __('No services have been added yet', $themename),
        'not_found_in_trash' => __('Nothing found in Trash', $themename),
        'parent_item_colon'  => ''
    );

    $args = array(  
        'labels'            => $labels,  
        'public'            => true,  
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => false,
        'rewrite'           => false,
        'supports'          => array('title', 'editor', 'thumbnail'),
        'has_archive'       => true,
        'menu_icon'         => 'dashicons-awards'
       );  
  
    register_post_type( 'service' , $args );  
}

?>