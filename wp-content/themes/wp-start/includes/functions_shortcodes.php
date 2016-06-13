<?php
//Register mce plugins
add_action('init', 'd_sc_mce'); 
	
function d_sc_mce() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'add_tinymce_plugin');  
     add_filter('mce_buttons', 'register_button');  
   }  
} 

function register_button($button) {  
    array_push($button, 'd_shortcode' );  
    return $button;  
}

function add_tinymce_plugin($plugins) {  
    $plugins['d_shortcode'] = get_template_directory_uri() . '/includes/custom_shortcodes/d.editor.plugin.js';  
    return $plugins;  
}

/**========================================**/
/** RENDER SHORTCODE ======================**/
/**========================================**/
global $vi, $i, $vt;

/** Alert shortcode **/
function d_sc_alert( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"type" => "info"
	), $atts));
   return '<div class="alert-box '. $type .'">' . remove_wpautop($content) . '</div>';
}
add_shortcode('alert', 'd_sc_alert');

/** Dropcap **/
function d_sc_dropcap( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"type" => ""
	), $atts));
   return '<span class="dropcap '. $type .'">' . remove_wpautop($content) . '</span>';
}
add_shortcode('dropcap', 'd_sc_dropcap');

/** Button **/
function d_sc_button($atts, $content = null) {
	extract(shortcode_atts(array(
		"size"        => "medium",
		"color"       => "",
		"type"        => "",
		"link"        => "#",
		"target"      => '_self'
	), $atts));
	
	return '<a href="'.$link.'" class="button '.$size.' '.$color.' '.$type.'" target="'.$target.'" >'.remove_wpautop($content).'</a>';
}
add_shortcode('button', 'd_sc_button');

/** Divider **/
function d_sc_divider($atts, $content = null) {
	extract(shortcode_atts(array(
		"type"        => ""
	), $atts));

	if ($type == 'to-top')
   		return '<div class="hr-divider"><a href="#" title="'.__('Go to top', $themename).'"><i class="icon-arrow-up"></i></a></div>';
   	else
   		return '<div class="hr-divider"> </div>';
}
add_shortcode("hr", "d_sc_divider");

/** Featured product slider **/
function d_sc_featured_products($atts, $content = null) {
	global $woocommerce_loop;
	extract(shortcode_atts(array(
		"show"     => "4",
		"per_page" => "12",
		"title"    => esc_html__('Featured products', $themename)
	), $atts));
	ob_start();
	$cols = $show ? $show : 4;
	$args = array(
		'post_type'	=> 'product',
		'post_status' => 'publish',
		'ignore_sticky_posts'	=> 1,
		'posts_per_page' => $per_page,
		'orderby' => 'date',
		'order' => 'DESC',
		'meta_query' => array(
			array(
				'key' => '_visibility',
				'value' => array('catalog', 'visible'),
				'compare' => 'IN'
			),
			array(
				'key' => '_featured',
				'value' => 'yes'
			)
		)
	);
    
    $products = new WP_Query( $args );
?>
	<div class="row">
		<div class="block block-products recent fix">
			<h2 class="block-title"><?php echo $title ?></h2>
			<div class="<?php if($products->post_count > 4) echo 'carousel owl-carousel'; ?>" data-item-num="<?php echo $cols; ?>">
                <?php                
                if ( $products->have_posts() ) : ?>                            
                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>                
                        <?php woocommerce_get_template_part( 'content', 'product' ); ?>            
                    <?php endwhile; // end of the loop. ?>                    
                <?php                
                endif; 
                wp_reset_postdata();
                
                ?>
            </div>
		</div>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode("d_featured_products", "d_sc_featured_products");

/** Recent products slider **/
function d_sc_recent_products($atts, $content = null) {
	extract(shortcode_atts(array(
		"show"        => "4",
		"per_page" => "12",
		"title" => esc_html__('Recent products', $themename)
	), $atts));

	ob_start();
	$cols = $show ? $show : 4;
	$args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => $per_page,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => print_option('home-recent-products-cat-exclude'),
				'operator' => 'NOT IN'
			)
		),
		'meta_query'          => array(
			array(
				'key'     => '_visibility',
				'value'   => array('catalog', 'visible'),
				'compare' => 'IN'
			)
		)
	);
    
    $products = new WP_Query( $args );
?>
	<div class="row">
		<div class="block block-products recent fix">
			<h2 class="block-title"><?php echo $title ?></h2>
			<div class="<?php if($products->post_count > 4) echo 'carousel owl-carousel'; ?>" data-item-num="<?php echo $cols; ?>">
                <?php
                if ( $products->have_posts() ) : ?>                            
                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>                
                        <?php woocommerce_get_template_part( 'content', 'product' ); ?>            
                    <?php endwhile; // end of the loop. ?>                    
                <?php                
                endif; 
                wp_reset_postdata();                
                ?>
            </div>
		</div>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode("d_recent_products", "d_sc_recent_products");

/** Accordion **/
function d_accordion_wrap($atts, $content = null) {
		
	return '<div class="section-container accordion">'. remove_wpautop($content) .'</div>';
}
add_shortcode("accordion", "d_accordion_wrap");

function d_accordion_tab($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => '',
		"type" => ''// open or not
	), $atts));

	return '<section class="'.$type.'"><p class="title"><a href="#">'.$title.'</a></p><div class="content"><p>'.remove_wpautop($content).'</p></div></section>';
}
add_shortcode("accordion_tab", "d_accordion_tab");

/** Tabs **/

$vi = 0;
function d_tabs( $atts, $content = null ) {
	global $vi;
	extract(shortcode_atts(array(
		"type" => ''// vertical & normal
	), $atts));
	if($type == '') {
		$output = '<div class="dtabs">'.remove_wpautop($content).'</div>';
	} elseif ($type == 'vertical') {
		$output = '<div class="dtabs-vertical">';
		$output .= '<div class="dtabs-left">';
		$i = 0;
		foreach ($atts as $key => $tab) {
			$active = '';
			if($key != 'type') {
				$tab_num = $vi++;
				if($i == 0) {
					$active = 'active';
				}
				$output .= '<a href="#vtab-' . $tab_num . '" class="title '.$active.'">' .$tab. '</a>';
				$i++;
			}				
		}
		$output .= '</div><div class="dtabs-right">';
		$output .= remove_wpautop($content) .'</div></div>';
	}		
	
	return $output;
}
add_shortcode('tabs', 'd_tabs');

$i = 0;
function d_tab( $atts, $content = null ) {
	global $i;
	extract(shortcode_atts(array(
		'title' => '',
		'type' => '' //active & inactive
	), $atts));

	$tab_num = $i++;

	$output = '<a href="#tab-'.$tab_num.'" class="title '.$type.'">'.$title.'</a><div class="content" id="tab-'.$tab_num.'">'.remove_wpautop($content).'</div>';
	
	return $output;
}
add_shortcode('tab', 'd_tab');

$vt = 0;
function d_vtab( $atts, $content = null ) {
	global $vt;
	extract(shortcode_atts(array(
		'type' => '' //active & inactive
	), $atts));

	$tab_num = $vt++;

	$output = '<div class="content" id="vtab-'.$tab_num.'">'.remove_wpautop($content).'</div>';
	
	return $output;
}
add_shortcode('vtab', 'd_vtab');

/** COLUMNS & ROW **/
function d_sc_row($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
	
	return '<div class="row">'.remove_wpautop($content).'</div>';
}
add_shortcode('row', 'd_sc_row');

function d_sc_col($atts, $content = null) {
	extract(shortcode_atts(array(
		'num' => 12
	), $atts));
	
	return '<div class="large-'.$num.' columns">'.remove_wpautop($content).'</div>';
}
add_shortcode('col', 'd_sc_col');

/** Hightlight **/
function d_sc_highlight($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
	return '<span class="label">'.remove_wpautop($content).'</span>';
}
add_shortcode('highlight', 'd_sc_highlight');

/** Quote **/
function d_sc_quote($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
	return '<blockquote>'.remove_wpautop($content).'</blockquote>';
}
add_shortcode('blockquote', 'd_sc_quote');

/** Testimonials slider **/
function d_sc_testimonials($atts, $content = null) {
	global $shortname;

	extract(shortcode_atts(array(
		"show"        => "1",
		"per_page" => "12",
		"title" => esc_html__('Recent products', $themename)
	), $atts));

	ob_start();
	$cols = $show ? $show : 1;
	$args = array(
		'post_type'           => 'testimonials',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => $per_page,
		'orderby'             => 'date',
		'order'               => 'DESC'
	);
	$temp     = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query($args);
?>
	<div class="row">
		<div class="block fix">
			<?php if($title != '') { ?>
			<h2 class="block-title"><?php echo $title ?></h2>
			<?php } ?>
			<div class="carousel owl-carousel" data-item-num="<?php echo $cols; ?>">
			<?php
			if ( $wp_query->have_posts() ) {
				while ($wp_query->have_posts()) : $wp_query->the_post();

				$src = rwmb_meta($shortname.'_testimonial_author_image', 'type=image&size=testimonial-thumb');
			?>
				<div class="large-12 columns testimonial-item">
					<div class="testimonial-image">
						<?php foreach ($src as $key => $value): ?>
						<?php echo "<img src='{$value['url']}' width='{$value['width']}' height='{$value['height']}' alt='{$value['alt']}' />"; ?>
						<?php endforeach; ?>
					</div>
					<div class="testimonial-content">
						<span class="testimonial-text">
							<?php echo get_the_content(); ?>
						</span>
						<span class="testimonial-author">
							<?php echo get_post_meta(get_the_ID(), $shortname.'_testimonial_author_name', true); ?>
						</span>
						<span class="testimonial-company">
							<?php echo get_post_meta(get_the_ID(), $shortname.'_testimonial_author_company', true); ?>
						</span>
					</div>								
				</div>
			<?php
				endwhile;
			}
		 	wp_reset_postdata(); $wp_query = null; $wp_query = $temp;             
            ?>
            </div>
		</div>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('testimonials', 'd_sc_testimonials');

/** Panel box **/
function d_sc_panel($atts, $content = null) {
	extract(shortcode_atts(array(
		'type' => 1
	), $atts));
	if($type == 1) {
		return '<div class="panel">'.remove_wpautop($content).'</div>';
	} else {
		return '<div class="panel callout">'.remove_wpautop($content).'</div>';
	}
}
add_shortcode('panel', 'd_sc_panel');

/** Progress **/
function d_sc_progress($atts, $content = null) {
	extract(shortcode_atts(array(
		'title'       => '',
		'value_title' => '',
		'value'       => 80
	), $atts));

	$value_title = $value_title ? strip_tags($value_title) : $value.'%';

	return '<div class="radius progress"><span class="meter" style="width: '.$value.'%"><i class="title">'.$title.'</i><i class="value">'.$value_title.'</i></span></div>';
}
add_shortcode('progress', 'd_sc_progress');

/** Featured box **/
function d_sc_featured_box($atts, $content = null) {
	extract(shortcode_atts(array(
		'type' => 1,
		'icon' => '',
		'title' => ''
	), $atts));

	$type = $type ? $type : 1;

	if(filter_var($icon, FILTER_VALIDATE_URL)) {
		$image = '<img src="'.$icon.'" />';
	} else {
		$image = '<i class="icon-'.$icon.'"></i>';
	}

	if($type == 1) {
		return '<div class="featured-box text-center"><span class="featured-box-img">'.$image.'</span>
		<h2>'.$title.'</h2><div class="content">'.remove_wpautop($content).'</div></div>';
	} elseif ($type == 2) {
		return '<div class="featured-box left-img"><span class="featured-box-img">'.$image.'</span>
		<h2>'.$title.'</h2><div class="content">'.remove_wpautop($content).'</div></div>';
	};
}
add_shortcode('featured_box', 'd_sc_featured_box');

/** Team **/
function d_sc_team($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'per_page' => 12
	), $atts));
	global $shortname;

	$per_page = $per_page ? $per_page : -1;

	ob_start();
?>
	<div class="row">
		<?php
		$args = array (
			'post_type'           => 'team',
			'post_status'         => 'publish',
			'paged'               => $paged,
			'posts_per_page'      => $per_page,
			'ignore_sticky_posts' => 1
		);
		$temp     = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query($args);
		?>
		<?php if ( $wp_query->have_posts() ) : ?>
		<?php while ($wp_query->have_posts()) : $wp_query->the_post();?>
		<div class="large-3 columns">
			<div <?php post_class('team-member'); ?>>
				<?php if(has_post_thumbnail()): ?>
				<figure class="team-img">
					<?php the_post_thumbnail('team-thumb'); ?>
					<h3><?php echo get_the_title(); ?></h3>
				</figure>
				<?php else: ?>
				<h3><?php echo get_the_title(); ?></h3>
				<?php endif; ?>
				<div class="team-description">
					<p class="position"><?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_position', true); ?></p>
					<div class="team-contact">
						<span><i class="icon-envelope"></i> <a href="mailto:<?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_email', true); ?>"><?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_email', true); ?></a></span><span><i class="icon-phone"></i> <a href="tel:<?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_phone', true); ?>"><?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_phone', true); ?></a></span>
					</div>
					<div class="team-bio">
					<?php echo text_truncate(strip_tags(get_the_content(), 200)); ?>
					</div>
					<div class="team-connect">
						<ul class="inline-list fix">
						<?php if(get_post_meta(get_the_ID(), $shortname.'_team_info_fb', true) != ''): ?>
							<li><a href="<?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_fb', true) ;?>"><i class="icon-facebook"></i></a></li>
						<?php endif; ?>
						<?php if(get_post_meta(get_the_ID(), $shortname.'_team_info_twitter', true)): ?>
							<li><a href="<?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_twitter', true) ;?>"><i class="icon-twitter"></i></a></li>
						<?php endif; ?>
						<?php if(get_post_meta(get_the_ID(), $shortname.'_team_info_gg', true)): ?>
							<li><a href="<?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_gg', true) ;?>"><i class="icon-google-plus"></i></a></li>
						<?php endif; ?>
						<?php if(get_post_meta(get_the_ID(), $shortname.'_team_info_instagram', true)): ?>
							<li><a href="<?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_instagram', true) ;?>"><i class="icon-instagram"></i></a></li>
						<?php endif; ?>
						<?php if(get_post_meta(get_the_ID(), $shortname.'_team_info_linkedin', true)): ?>
							<li><a href="<?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_linkedin', true) ;?>"><i class="icon-linkedin"></i></a></li>
						<?php endif; ?>
						<?php if(get_post_meta(get_the_ID(), $shortname.'_team_info_skype', true)): ?>
							<li><a href="<?php echo get_post_meta(get_the_ID(), $shortname.'_team_info_skype', true); ?>"><i class="icon-skype"></i></a></li>
						<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; endif; ?>
		<?php wp_reset_postdata(); $wp_query = null; $wp_query = $temp;?>
	</div>
<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('team', 'd_sc_team');

/** Blog posts slider **/
function d_sc_recent_posts($atts, $content = null) {
	global $themename;
	extract(shortcode_atts(array(
		"show"        => "3",
		"per_page" => "12",
		"title" => esc_html__('From our blog', $themename)
	), $atts));

	ob_start();
	$cols = $show ? $show : 3;
	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => $per_page,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'category__not_in '   => print_option('home-recent-posts-categories-exclude')
	);
	$wp_query = null;
	$wp_query = new WP_Query($args);
	$temp     = $wp_query;
?>
	<div class="row">
		<div class="block block-recent-post fix">
			<h2 class="block-title"><?php echo $title; ?></h2>
			<div class="<?php if($wp_query->post_count > 3) echo 'carousel owl-carousel'; ?>" data-item-num="<?php echo $cols; ?>">
			<?php
			if ( $wp_query->have_posts() ) :
			while ($wp_query->have_posts()) : $wp_query->the_post();
			?>
				<article class="<?php if($wp_query->post_count > 3) {echo 'large-12';}else {echo 'large-4';} ?> columns">
					<div class="block-blog-content">
						<figure>
							<a href="<?php the_permalink(); ?>" class="blog-img"><?php the_post_thumbnail('blog-thumb'); ?></a>
						</figure>
						<div class="post-detail">
							<h4 class="blog-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo text_truncate(get_the_title(), 50); ?></a>
							</h4>
							<div class="blog-meta">
								<?php
								printf(sprintf( 'Posted in %1$s on %2$s',
									get_the_category_list( __( ', ', $themename ) ),
									get_the_date()
								));
								?>
							</div>
							<p class="blog-description">
								<?php echo text_truncate(get_the_excerpt(), 100); ?>
							</p>
							<div class="blog-act fix">
								<a href="<?php echo esc_url( the_permalink() . '#respond' ); ?>" title="<?php echo esc_html__('Leave a reply'); ?>" class="reply-link"><?php echo esc_html__('Leave a reply'); ?></a>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="read-more"><?php echo esc_html__('Read more &rarr;'); ?></a>
							</div>
						</div>
					</div>
				</article>
			<?php endwhile;endif; wp_reset_postdata(); $wp_query = null; $wp_query = $temp;?>
			</div>
		</div>
	</div>
<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('recent_posts', 'd_sc_recent_posts');

/** Google maps **/
function d_sc_map($atts, $content = null) {
	extract(shortcode_atts(array(
		"address" => "",
		"lat"     => "",
		"lng"     => "",
		"zoom"    => "16",
		"width"   => "100%",
		"height"  => "380px"
	), $atts));

	wp_enqueue_script($themename.'-google-map', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), '', true);
	wp_enqueue_script($themename.'-d-maps', get_template_directory_uri().'/js/maps.js', array(), '', true);

	$html = '<div class="gmap-wrap">
	<div class="map-canvas" style="width: '.$width.'; height: '.$height.'; overflow: hidden; position: relative;" data-lat="'.$lat.'" data-lng="'.$lng.'" data-zoom="'.$zoom.'" data-address="'.$address.'"></div>';
	if($content != '') {
		$html .= '<div class="map-info">'.remove_wpautop($content).'</div>';
	}
	$html .= '</div>';

	return $html;
}
add_shortcode('map', 'd_sc_map');

/** Social sharing & follow **/
function d_sc_share($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => ''
	), $atts));

	$link      = get_permalink();
	$thumb_id  = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src($thumb_id, '', true);

	if($title != '') {
		$share_title .= '<span class="share-title">'.$title.'</span>';
	}

	return '<div class="social-sharing">'.$share_title.'
	<ul class="inline-list">
	    <li><a href="http://www.facebook.com/sharer.php?u='.$link.'" target="_blank"><i class="icon-facebook"></i></a></li>
	    <li><a href="https://twitter.com/share?url='.$link.'" target="_blank"><i class="icon-twitter"></i></a></li>   
	    <li><a href="https://plus.google.com/share?url='.$link.'" onclick="javascript:window.open(this.href,
	      \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"><i class="icon-google-plus"></i></a></li>
	    <li><a href="http://pinterest.com/pin/create/button/?url='.$link.'&amp;media='.$thumb_url[0].'&amp;description='.$link.'" target="_blank"><i class="icon-pinterest"></i></a></li>
		<li><a href="mailto:?subject=&amp;body='.$link.'"><i class="icon-envelope"></i></a></li>
	</ul>
	</div>';
}
add_shortcode('share', 'd_sc_share');

function d_sc_follow($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => ''
	), $atts));
	$facebook_url    = print_option('facebook-url');
	$twitter_url     = print_option('twitter-url');
	$google_plus_url = print_option('google-plus-url');
	$linkedin_url    = print_option('linkedin-url');
	$youtube_url     = print_option('youtube-url');
	$pinterest_url   = print_option('pinterest-url');

	$html = '<div class="social-sharing">';

	if($title != '') {
		$html .= '<span class="share-title">'.$title.'</span>';
	}
	
	$html .= '<ul class="inline-list">';
	
	if($facebook_url) {
		$html .= '<li><a href="'.$facebook_url.'" target="_blank"><i class="icon-facebook"></i></a></li>';
	}
	if($twitter_url) {
		$html .= '<li><a href="'.$twitter_url.'" target="_blank"><i class="icon-twitter"></i></a></li>';
	}
	if($google_plus_url) {
		$html .= '<li><a href="'.$google_plus_url.'" target="_blank"><i class="icon-google-plus"></i></a></li>';
	}
	if($linkedin_url) {
		$html .= '<li><a href="'.$linkedin_url.'" target="_blank"><i class="icon-linkedin"></i></a></li>';
	}
	if($youtube_url) {
		$html .= '<li><a href="'.$youtube_url.'" target="_blank"><i class="icon-youtube"></i></a></li>';
	}
	if($pinterest_url) {
		$html .= '<li><a href="'.$pinterest_url.'" target="_blank"><i class="icon-pinterest"></i></a></li>';
	}

	$html .= '</ul></div>';

	return $html;
}
add_shortcode('follow', 'd_sc_follow');

/* Clients shortcode */
function d_sc_clients($atts, $content = null) {
	global $shortname;
	extract(shortcode_atts(array(
		'title' => '',
		'show' => 6,
		'per_page' => 12
	), $atts));

	ob_start();
	$cols = $show ? $show : 6;
	$args = array(
		'post_type'           => 'clients',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => $per_page,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'category__not_in '   => print_option('home-recent-posts-categories-exclude')
	);
	$temp     = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query($args);
	?>
	<div class="clients fix">
		<div class="<?php if($wp_query->post_count > 6) echo 'carousel owl-carousel'; ?>" data-item-num="<?php echo $cols; ?>">
		<?php
		if ( $wp_query->have_posts() ) :
		while ($wp_query->have_posts()) : $wp_query->the_post();
		?>
			<div class="<?php if($wp_query->post_count > 6) {echo 'large-12';}else {echo 'large-2';} ?> columns">
				<figure>
					<a href="<?php echo get_post_meta(get_the_ID(), $shortname.'_client_link', true); ?>"><?php the_post_thumbnail('client-thumb'); ?></a>
				</figure>
			</div>
		<?php endwhile;endif; wp_reset_postdata(); $wp_query = null; $wp_query = $temp;?>
		</div>
	</div>
	<?php		
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('clients', 'd_sc_clients');

/* Raw */
function d_sc_raw($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
	return '<code class="raw">'.preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content ).'</code>';
}
add_shortcode('raw', 'd_sc_raw');

//remove breakline on shortcode
function remove_wpautop($content) {
    $content = do_shortcode( shortcode_unautop($content) );
    $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
    return $content;
}
/*
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);*/
?>