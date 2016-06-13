<?php
/**
 * @package WordPress
 * @subpackage Deeds theme
 * @since deeds 1.0
 */

add_action( 'after_setup_theme', 'deeds_start_setup' );

if ( ! function_exists( 'deeds_start_setup' ) ) {
	function deeds_start_setup() {
		global $themename, $shortname, $options, $theme_path, $theme_uri;
		$themename  = 'Deeds theme';
		$shortname  = 'deeds';
		
		$theme_path = get_template_directory();
		$theme_uri  = get_template_directory_uri();
		
		require_once( $theme_path . '/includes/install_plugins.php' );
		require_once( $theme_path . '/d_options/d-display.php' );
		require_once( $theme_path . '/d_options/d-custom.php' );
		require_once( $theme_path . '/d_options/inc/mailchimp/d-mailchimp.php' );
		require_once( $theme_path . '/includes/functions_frontend.php' );
		require_once( $theme_path . '/includes/functions_init.php' );
		require_once( $theme_path . '/includes/functions_styles.php' );
		require_once( $theme_path . '/includes/functions_shortcodes.php' );
		require_once( $theme_path . '/includes/custom-header.php' );
		require_once( $theme_path . '/includes/template-tags.php' );
		require_once( $theme_path . '/includes/extras.php' );
		require_once( $theme_path . '/includes/customizer.php' );
		require_once( $theme_path . '/includes/jetpack.php' );

		load_theme_textdomain( 'deeds', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );
		add_theme_support( 'custom-background', apply_filters( 'deeds_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
}

