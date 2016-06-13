<?php
/** Team **/
add_action( 'init', 'create_team' );
function create_team() {
    global $themename;
    $labels = array(
        'name'               => __('Team', $themename),
        'singular_name'      => __('Team', $themename),
        'add_new'            => __('Add New', $themename),
        'add_new_item'       => __('Add New Team Member', $themename),
        'edit_item'          => __('Edit Team Member', $themename),
        'new_item'           => __('New Team Member', $themename),
        'view_item'          => __('View Team Member', $themename),
        'search_items'       => __('Search Team Member', $themename),
        'not_found'          => __('No Team Member found', $themename),
        'not_found_in_trash' => __('No Team Member in the trash', $themename),
        'parent_item_colon'  => '',
    );
 
    register_post_type( 'team', array(
        'labels'            => $labels,  
        'public'            => true,  
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => false,
        'rewrite'           => false,
        'supports'          => array('title', 'editor', 'thumbnail')
    ) );
}
?>