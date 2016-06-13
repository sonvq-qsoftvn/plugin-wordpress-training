<?php
if ( ! function_exists( 'load_d_options' ) ) {
	function load_d_options() {
		global $shortname;
		require_once( get_template_directory() . esc_attr( "/d_options/d-options-{$shortname}.php" ) );
	}
}

if ( ! function_exists( 'd_save_option' ) ){
	function d_save_option( $option_name, $new_value ){
		if ( get_option( $option_name ) != $new_value ) {
		    update_option( $option_name, $new_value );
		}
	}
}
if ( ! function_exists( 'print_option' ) ){
	function print_option( $option_name = '', $default = ''){
		global $shortname;
		if($option_name == '')
			return false;

		$option_name  = $shortname.'-'.$option_name;
		$option_value = get_option($option_name);

		return $option_value ? $option_value : $default;
	}
}
if ( ! function_exists( 'product_cat_nav' ) ){
	function product_cat_nav($show_count = false){
		$args = array(
			'taxonomy'     => 'product_cat',
			'hierarchical' => true,
			'title_li'     => '',
			'hide_empty'   => false
		);
		return wp_list_categories( $args );
	}
}
if ( ! function_exists( 'text_truncate' ) ){
	function text_truncate($string, $limit = 195, $break=" ", $pad="...") {
	    if(strlen($string) <= $limit)
	    	return strip_tags($string);

	    if(false !== ($breakpoint = strpos($string, $break, $limit))) {
	        if($breakpoint < strlen($string) - 1) {
	            $string = substr($string, 0, $breakpoint) . $pad;
	        }
	    }
	    return strip_tags($string);
	}
}
?>