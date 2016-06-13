<?php
define('WOOCOMMERCE_USE_CSS', false);

function deeds_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;
	
	$title .= get_bloginfo( 'name' );
	
	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = $title . ' ' . $sep . ' ' . $site_description;
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', $themename ), max( $paged, $page ) );
	return $title;
}
add_filter( 'wp_title', 'deeds_wp_title', 10, 2 );

/*
Script and style register
*/

//DISABLE WOOCOMMERCE PRETTY PHOTO STYLE
add_action( 'wp_print_styles', 'deregister_styles', 100 );

if(!function_exists('deregister_styles')) {
	function deregister_styles() {
		wp_deregister_style( 'woocommerce_prettyPhoto_css' );
	}
}

//DISABLE WOOCOMMERCE PRETTY PHOTO SCRIPTS
add_action( 'wp_print_scripts', 'deregister_javascript', 100 );

if(!function_exists('deregister_javascript')) {
	function deregister_javascript() {
		wp_deregister_script( 'prettyPhoto-init' );
		//wp_deregister_script( 'prettyPhoto' );
	}
}

function deeds_scripts_styles() {
	//Add google font
	global $themename, $woocommerce;

	$font_query = '';
	$gg_font_list = get_option('google_font_list');
	if(!empty($gg_font_list)) {
		foreach (get_option('google_font_list') as $key => $value) {
			if($key > 0)
				$font_query .= '|';
			$font_query .= str_replace(' ', '+', $value);
		}
		$protocol = is_ssl() ? 'https' : 'http';
		$query_args_google = array(
			'family' => $font_query,
			'subset' => print_option('google-subsets') ? implode(',', print_option('google-subsets')) : null
		);

		wp_enqueue_style( $themename.'-fonts', add_query_arg( $query_args_google, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}
	//end add google font

	wp_enqueue_style( $themename.'-main', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'deeds_scripts_styles' );

/** SIDEBAR REGISTER **/
function deeds_widgets_init() {
	global $themename;

	register_sidebar( array(
		'name' => __( 'Sidebar widgets', $themename ),
		'id' => 'sidebar-widgets',
		'description' => __( 'Sidebar widgets', $themename ),
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="widget-content">',
	) );
	register_sidebar( array(
		'name' => __( 'Left sidebar widgets', $themename ),
		'id' => 'sidebar-widgets-left',
		'description' => __( 'Sidebar widgets on left', $themename ),
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="widget-content">',
	) );

	register_sidebar( array(
		'name' => __( 'Top footer widgets', $themename ),
		'id' => 'footer-ex-widgets',
		'description' => __( 'The top footer widgets', $themename ),
		'before_widget' => '<div id="%1$s" class="large-3 columns footer-ex-widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="widget-ex-content">',
	) );

	register_sidebar( array(
		'name' => __( 'Footer widgets', $themename ),
		'id' => 'footer-widgets',
		'description' => __( 'Footer widgets', $themename ),
		'before_widget' => '<div id="%1$s" class="large-3 columns footer-widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="widget-content">',
	) );
}
add_action( 'widgets_init', 'deeds_widgets_init' );
/** NAVIGATION **/
if ( function_exists( 'wp_nav_menu') ) {
	add_theme_support( 'nav-menus' );

	register_nav_menus( array( 'top-menu' => __( 'Top Menu', $themename ) ) );
	register_nav_menus( array( 'cat-menu' => __( 'Category Menu', $themename ) ) );
	register_nav_menus( array( 'bot-menu' => __( 'Bottom Menu', $themename ) ) );
}

function deeds_post_nav() {
	global $post, $themename;
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if (!$next && !$previous)
		return;
	?>
	<nav class="post-navigation fix">
		<div class="nav-links">
			<?php previous_post_link('%link', _x('<i class="icon-angle-left"></i> %title', 'Previous post link', $themename)); ?>
			<?php next_post_link('%link', _x('%title <i class="icon-angle-right"></i>', 'Next post link', $themename)); ?>

		</div>
	</nav>
	<?php
}
function deeds_pagination() {
	global $wp_query, $themename;

	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="post-navigation fix">
		<div class="nav-links">
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous">
			<?php next_posts_link( __( 'Older posts <i class="icon-angle-right"></i>', $themename ) ); ?>
			</div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next">
			<?php previous_posts_link( __( '<i class="icon-angle-left"></i> Newer posts', $themename ) ); ?>
			</div>
			<?php endif; ?>
		</div>
	</nav>
	<?php
}
/** POST THUMBNAILS **/
add_theme_support( 'post-thumbnails' );

add_image_size( 'blog-thumb', 720, 380, true );
add_image_size( 'archive-thumb', 480, 310, true );
add_image_size( 'single-thumb', 960, 480, true );
add_image_size( 'testimonial-thumb', 80, 80, true );
add_image_size( 'team-thumb', 400, 400, true );
add_image_size( 'client-thumb', 170, 60, true );

if ( ! function_exists( 'd_entry_meta' ) ) :
	function d_entry_meta() {
		$categories_list = get_the_category_list( __( ', ', $themename ) );
		$tag_list = get_the_tag_list( '', __( ', ', $themename ) );
		$date = sprintf( '<span><time class="entry-date" datetime="%1$s">%2$s</time></span>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'fivehit' ), get_the_author() ) ),
			get_the_author()
		);
	
		
		if ( $tag_list ) {
			$utility_text = __( '<i class="icon-folder-open"></i> Posted in %1$s and %3$s', $themename );
		} elseif ( $categories_list ) {
			$utility_text = __( '<i class="icon-folder-open"></i> Posted in %1$s %3$s', $themename );
		} else {
			$utility_text = __( '<i class="icon-folder-open"></i> Posted on %3$s', $themename );
		}
		printf(
			//$utility_text,
			//$categories_list,
			//$tag_list,
			$date
			//$author
		);
	}
endif;

if(!function_exists('shop_banner')) {
	function shop_banner() {
	    if(is_product_category()){
		    global $wp_query;
			$cat          = $wp_query->get_queried_object();
			$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image        = wp_get_attachment_url( $thumbnail_id );
		    if($image) {
			    $shop_banner = '<img src="' . $image . '" alt="" />';
			}
		} else {
			$shop_banner = print_option('shop-banner');
			if($shop_banner != '') {
				$shop_banner = '<img src="' . $shop_banner . '" alt="" />';
			}
		}
		echo $shop_banner;
	}
}

function embed_youtube($url, $width = 640, $height = 480) {	
	$tube_query = parse_str( parse_url( $url, PHP_URL_QUERY ), $tube );
							
	return '<iframe width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$tube['v'].'?wmode=transparent" frameborder="0" allowfullscreen wmode="Opaque"></iframe>';			
}
	
function embed_vimeo($url, $width = 640, $height = 480) {
	//preg_match('/http:\/\/vimeo.com\/(\d+)$/', $url, $video_id);	
	$video_id = (int) substr(parse_url($url, PHP_URL_PATH), 1);
	return '<iframe itemprop="video" src="http://player.vimeo.com/video/'. $video_id .'?title=0&amp;byline=0&amp;portrait=0?wmode=transparent" width="'. $width .'" height="'. $height .'"></iframe>';
	
}

//add social link for user
function deeds_user_social_profile( $contactmethods ) {
	$contactmethods['google_profile']   = 'Google Profile URL';
	$contactmethods['twitter_profile']  = 'Twitter Profile URL';
	$contactmethods['facebook_profile'] = 'Facebook Profile URL';
	$contactmethods['linkedin_profile'] = 'Linkedin Profile URL';
	$contactmethods['tumblr_profile']   = 'Tumblr Profile URL';
	
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'deeds_user_social_profile', 10, 1);

function comment_list_fucntion($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);
		$add_below = 'div-comment';
?>
	<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
			<div class="comment-author vcard">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			
			</div>
			<div class="comment-content">
				<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?> - 
				
				<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
					?>
				</div>
				<?php if ($comment->comment_approved == '0') : ?>
					<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
					<br />
				<?php endif; ?>

				<?php comment_text() ?>

				<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>		
			</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
}
/** Use shortcode for text widget **/
add_filter('widget_text', 'do_shortcode');

/** WOO TEMPLATE **/

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment( $fragments ) 
{
    global $woocommerce;
    ob_start();

    $cart_total = $woocommerce->cart->get_cart_total();
	$cart_count = $woocommerce->cart->cart_contents_count;
?>
	<div class="top-cart right">
		<div class="mini-cart-overview">
			<a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>">
				<span class="cart-icon"><i class="icon-shopping-bag"></i> <?php echo $cart_count; ?></span>
				<?php echo $cart_total; ?>
			</a>
		</div>
		<div class="sub-cart">
			<?php if ( sizeof($woocommerce->cart->cart_contents)>0 ) { ?>
			<ul class="cart-items">
			<?php foreach ($woocommerce->cart->cart_contents as $key => $value) { ?>
			<?php if ($value['data']->exists() && $value['quantity']>0) { ?>
				<li class="fix">
					<figure>
						<a href="<?php echo get_permalink($value['product_id']); ?>">
							<?php echo $value['data']->get_image(); ?>
						</a>
					</figure>
					<div class="item-detail">
						<p><a href="<?php echo get_permalink($value['product_id']); ?>" title="<?php echo $value['data']->get_title(); ?>"><?php echo text_truncate($value['data']->get_title(), 20); ?></a></p>
						<p><?php echo __('Quantity:', $themename) . $value['quantity']; ?> | <a href="<?php echo esc_url( $woocommerce->cart->get_remove_url( $key )); ?>" class="mini-cart-remove" title="<?php echo esc_html('Remove from cart', $themename); ?>"><i class="icon-remove"></i></a></p>
						<span class="item-price"><?php echo woocommerce_price($value['data']->get_price()); ?></span>
					</div>
				</li>
			<?php } ?>
			<?php } ?>
			</ul>
			<div class="mini-cart-total">
				<?php _e('Cart subtotal', $themename); ?> <?php echo $cart_total; ?>								</div>
			<div class="mini-cart-button">
				<?php echo '<a class="button" href="'.esc_url( $woocommerce->cart->get_cart_url() ).'">'.__('View shopping bag', $themename).'</a>'; ?>
				<?php echo '<a class="button orange" href="'.esc_url( $woocommerce->cart->get_checkout_url() ).'">'.__('Proceed to checkout', $themename).'</a>'; ?>
			</div>
			<?php } else { ?>
			<span class="mini-cart-empty"><?php echo __('Your cart is currently empty.', $themename); ?></span>
			<?php } ?>
		</div>
	</div>
    <?php
    $fragments['.top-cart'] = ob_get_clean();
    return $fragments;
}

//Setting wooaction mode
	
if(print_option('shop-catalog-mode') == 'on') {
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);	
}
if(print_option('shop-hide-price') == 'on') {
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);	
}
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);