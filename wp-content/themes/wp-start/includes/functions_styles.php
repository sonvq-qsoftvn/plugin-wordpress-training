<?php
function custom_stylesheet() {
	$nav_bg_color		  = print_option('nav-bg-color');
	$general_font         = print_option('general-font');
	$nav_top_font         = print_option('nav-top-font');
	$nav_cat_font         = print_option('nav-cat-font');
	$footer_font          = print_option('footer-font');
	$footer_widgets_title = print_option('footer-widgets-title');
	$footer_links_font    = print_option('footer-links');
	$logo_font            = print_option('logo-font');
	$h1_font              = print_option('h1-font');
	$h2_font              = print_option('h2-font');
	$h3_font              = print_option('h3-font');
	$h4_font              = print_option('h4-font');
	$h5_font              = print_option('h5-font');
	$h6_font              = print_option('h6-font');
?>
<style>
<?php if(!empty($general_font)): ?>
body {
	font-family: <?php echo $general_font['face']; ?> ;
	font-weight: <?php echo $general_font['style']; ?>;
	font-size: <?php echo $general_font['size'].$general_font['unit']; ?>;
	color: <?php echo $general_font['color']; ?>;
	text-transform: <?php echo $general_font['transform']; ?>;
	background-color: <?php echo print_option('body-bg-color'); ?>
}
.panel h1, .panel h2, .panel h3, .panel h4, .panel h5, .panel h6, .panel p {
	color: <?php echo $general_font['color'] ? $general_font['color'] : '#777'; ?>;
}
<?php endif; ?>
header.top-head {
	background-color: <?php echo print_option('header-bg-color'); ?>
}
nav#top-nav > ul > li:hover, nav#top-nav > ul > li.current-menu-item, #top-nav > ul > li.current_page_item {
	background-color: <?php echo print_option('top-nav-current-color'); ?>;
}
.wrap-cat-nav {
	background-color: <?php echo $nav_bg_color; ?>;
}
#cat-nav > ul > li:hover a, #cat-nav > ul > li.current-menu-item a {
	color: <?php echo $nav_bg_color; ?>;
}
.woocommerce-tabs ul.tabs li.active a, .woocommerce-tabs ul.tabs li:hover a {
	color: <?php echo print_option('button-bg-color');?>;
	border-color: <?php echo print_option('button-bg-color');?>;
}
.amount {
	color: <?php echo print_option('general-price-color'); ?>
}
.block-content span.onsale, .images-wrap span.onsale {
	background-color: <?php echo print_option('onsale-bg-color'); ?>
}
.footer-widgets {
	background-color: <?php echo print_option('footer-bg-color'); ?>
}
.footer-copyright {
	background-color: <?php echo print_option('footer-bg-copyright-color'); ?>
}
a {
	color: <?php echo print_option('general-links-color');?>;
}
a:hover {
	color: <?php echo print_option('general-links-color-hover');?>;
}
button, .button, input[type="submit"], .widget_price_filter .ui-slider .ui-slider-range, .woocommerce form.cart .yith-wcwl-add-to-wishlist a, .progress .meter {
	color: <?php echo print_option('button-text-color');?>;
	background-color: <?php echo print_option('button-bg-color');?>;
	border-color: <?php echo print_option('button-border-color');?>;
}
button:hover, button:focus, .button:hover, .button:focus, input[type="submit"]:hover, input[type="submit"]:focus, .yith-wcwl-add-to-wishlist a:hover, .woocommerce form.cart .yith-wcwl-add-to-wishlist a:hover {
	color: <?php echo print_option('button-text-color-hover', '#FFF');?> !important;
	background-color: <?php echo print_option('button-bg-color-hover');?>;
	border-color: <?php echo print_option('button-border-color-hover');?>;
}
.woocommerce form.cart .add_to_wishlist.loading {
	border-color: <?php echo print_option('button-border-color');?>
}
.block-title {
	font-size: 16px;
	border-color: <?php echo print_option('button-border-color');?>;
}
.widget_price_filter .ui-slider .ui-slider-handle {
	border-color: <?php echo print_option('button-border-color');?>;
}
<?php if(!empty($logo_font)): ?>
h1#top-logo a {
	font-family: <?php echo $logo_font['face']; ?> ;
	font-weight: <?php echo $logo_font['style']; ?>;
	font-size: <?php echo $logo_font['size'].$logo_font['unit']; ?>;
	color: <?php echo $logo_font['color']; ?>;
	text-transform: <?php echo $logo_font['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($nav_top_font)): ?>
nav#top-nav > ul > li > a {
	font-family: <?php echo $nav_top_font['face']; ?> ;
	font-weight: <?php echo $nav_top_font['style']; ?>;
	font-size: <?php echo $nav_top_font['size'].$nav_top_font['unit']; ?>;
	color: <?php echo $nav_top_font['color']; ?>;
	text-transform: <?php echo $nav_top_font['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($nav_cat_font)): ?>
nav#cat-nav > ul > li > a {
	font-family: <?php echo $nav_cat_font['face']; ?> ;
	font-weight: <?php echo $nav_cat_font['style']; ?>;
	font-size: <?php echo $nav_cat_font['size'].$nav_cat_font['unit']; ?>;
	color: <?php echo $nav_cat_font['color']; ?>;
	text-transform: <?php echo $nav_cat_font['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($footer_font)): ?>
.footer-widget .widget-content {
	font-family: <?php echo $footer_font['face']; ?> ;
	font-weight: <?php echo $footer_font['style']; ?>;
	font-size: <?php echo $footer_font['size'].$footer_font['unit']; ?>;
	color: <?php echo $footer_font['color']; ?>;
	text-transform: <?php echo $footer_font['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($footer_links_font)): ?>
.footer-widget .widget-content a {
	font-family: <?php echo $footer_links_font['face']; ?> ;
	font-weight: <?php echo $footer_links_font['style']; ?>;
	font-size: <?php echo $footer_links_font['size'].$footer_links_font['unit']; ?>;
	color: <?php echo $footer_links_font['color']; ?>;
	text-transform: <?php echo $footer_links_font['transform']; ?>;
}
<?php endif; ?>
.footer-widget a:hover {
	color: <?php echo print_option('footer-links-hover-color'); ?>
}
<?php if(!empty($footer_widgets_title)): ?>
.footer-widget h3 {
	font-family: <?php echo $footer_widgets_title['face']; ?> ;
	font-weight: <?php echo $footer_widgets_title['style']; ?>;
	font-size: <?php echo $footer_widgets_title['size'].$footer_widgets_title['unit']; ?>;
	color: <?php echo $footer_widgets_title['color']; ?>;
	text-transform: <?php echo $footer_widgets_title['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($h1_font)): ?>
h1 {
	font-family: <?php echo $h1_font['face']; ?> ;
	font-weight: <?php echo $h1_font['style']; ?>;
	font-size: <?php echo $h1_font['size'].$h1_font['unit']; ?>;
	color: <?php echo $h1_font['color']; ?>;
	text-transform: <?php echo $h1_font['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($h2_font)): ?>
h2 {
	font-family: <?php echo $h2_font['face']; ?> ;
	font-weight: <?php echo $h2_font['style']; ?>;
	font-size: <?php echo $h2_font['size'].$h2_font['unit']; ?>;
	color: <?php echo $h2_font['color']; ?>;
	text-transform: <?php echo $h2_font['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($h3_font)): ?>
h3 {
	font-family: <?php echo $h3_font['face']; ?> ;
	font-weight: <?php echo $h3_font['style']; ?>;
	font-size: <?php echo $h3_font['size'].$h3_font['unit']; ?>;
	color: <?php echo $h3_font['color']; ?>;
	text-transform: <?php echo $h3_font['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($h4_font)): ?>
h4 {
	font-family: <?php echo $h4_font['face']; ?> ;
	font-weight: <?php echo $h4_font['style']; ?>;
	font-size: <?php echo $h4_font['size'].$h4_font['unit']; ?>;
	color: <?php echo $h4_font['color']; ?>;
	text-transform: <?php echo $h4_font['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($h5_font)): ?>
h5 {
	font-family: <?php echo $h5_font['face']; ?> ;
	font-weight: <?php echo $h5_font['style']; ?>;
	font-size: <?php echo $h5_font['size'].$h5_font['unit']; ?>;
	color: <?php echo $h5_font['color']; ?>;
	text-transform: <?php echo $h5_font['transform']; ?>;
}
<?php endif; ?>
<?php if(!empty($h6_font)): ?>
h6 {
	font-family: <?php echo $h6_font['face']; ?> ;
	font-weight: <?php echo $h6_font['style']; ?>;
	font-size: <?php echo $h6_font['size'].$h6_font['unit']; ?>;
	color: <?php echo $h6_font['color']; ?>;
	text-transform: <?php echo $h6_font['transform']; ?>;
}
<?php endif; ?>
<?php if(print_option('shop-hide-price') == 'on') : ?>
span.onsale {
	display: none !important;
}
<?php endif; ?>
</style>
<!-- Custom styles & scripts-->
<?php if(print_option('custom-style-code') != ''): ?>
<style>
<?php echo print_option('custom-style-code'); ?>
</style>
<?php endif; ?>

<?php if(print_option('custom-script-code') != ''): ?>
<script>
<?php echo print_option('custom-script-code'); ?>
</script>
<?php endif; ?>

<?php
}
add_action('wp_head', 'custom_stylesheet', 50);
?>
