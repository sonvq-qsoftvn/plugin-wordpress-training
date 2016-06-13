<?php

$args = array(
    "label"                         => "Portfolio Categories", 
    "singular_label"                => "Portfolio Category", 
    'public'                        => true,
    'hierarchical'                  => true,
    'show_ui'                       => true,
    'show_in_nav_menus'             => false,
    'args'                          => array( 'orderby' => 'term_order' ),
    'rewrite'                       => false,
    'query_var'                     => true
);

register_taxonomy( 'portfolio-category', 'portfolio', $args );

    
add_action('init', 'portfolio_register');  
  
function portfolio_register() {  
    global $themename;
    $labels = array(
        'name'               => __('Portfolio', 'post type general name', $themename),
        'singular_name'      => __('Portfolio Item', 'post type singular name', $themename),
        'add_new'            => __('Add New', 'portfolio item', $themename),
        'add_new_item'       => __('Add New Portfolio Item', $themename),
        'edit_item'          => __('Edit Portfolio Item', $themename),
        'new_item'           => __('New Portfolio Item', $themename),
        'view_item'          => __('View Portfolio Item', $themename),
        'search_items'       => __('Search Portfolio', $themename),
        'not_found'          =>  __('No portfolio items have been added yet', $themename),
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
        'taxonomies'        => array('portfolio-category')
       );  
  
    register_post_type( 'portfolio' , $args );  
}

?>