<?php
/*- Add currency -*/
add_theme_support( 'woocommerce' );
add_filter( 'woocommerce_currencies', 'add_currency_vnd' );
 
function add_currency_vnd( $currencies ) {
     $currencies['VND'] = __( 'Việt Nam Đồng', 'deeds' );
     return $currencies;
}
 
add_filter('woocommerce_currency_symbol', 'add_currency_vnd_symbol', 10, 2);
 
function add_currency_vnd_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'VND': $currency_symbol = ' <sup>đ</sup>'; break;
     }
     return $currency_symbol;
}

/*- Add language support -*/
load_theme_textdomain( 'deeds', get_template_directory() . '/languages' );

add_action( 'admin_enqueue_scripts', 'd_admin_script' );

function d_admin_script() {
	global $shortname;
	wp_enqueue_script('d-admin-scripts', get_template_directory_uri().'/d_options/js/d-admin.js', array(), '', true);
	wp_localize_script('d-admin-scripts', 'd_init_var', array(
		'd_shortname' => $shortname
	));
}

require_once('custom_post/services_type.php');

require_once('meta-box/meta-box.php');
require_once('functions_meta_box.php');

/*require_once('custom_post/testimonials_type.php');
require_once('custom_post/portfolio_type.php');
require_once('custom_post/team_type.php');
require_once('custom_post/clients_type.php');
require_once('custom_widgets/contact.php');
require_once('meta-box/meta-box.php');
require_once('functions_meta_box.php');*/