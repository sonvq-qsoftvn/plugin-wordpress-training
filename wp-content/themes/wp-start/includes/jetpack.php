<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package deeds
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function deeds_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'deeds_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function deeds_jetpack_setup
add_action( 'after_setup_theme', 'deeds_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function deeds_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function deeds_infinite_scroll_render
