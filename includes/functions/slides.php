<?php

/* =Homepage Banner Slider
----------------------------------------------- */

// Adding Banners
if ( ! function_exists( 'cyon_banner_init' ) ){
	function cyon_banner_init(){
		$labels = array(
			'name' 					=> __('Cyon Banners'),
			'singular_name'			=> __('Banner'),
			'add_new' 				=> __( 'Add New Banner' ),
			'add_new_item' 			=> __( 'Add New Banner' ),
			'edit_item'				=> __( 'Edit Banner' ),
			'new_item' 				=> __( 'Add New Banner' ),
			'view_item' 			=> __( 'View Banner' ),
			'search_items' 			=> __( 'Search Banner' ),
			'not_found' 			=> __( 'No banner found' ),
			'not_found_in_trash' 	=> __( 'No banner found in trash' ),
			'menu_name' 			=> __('Banners')
		);
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> false,
			'show_ui' 				=> true,
			'menu_position'			=> 510,
			'hierarchical'			=> false,
			'supports' 				=> array('title','editor','thumbnail')
		);
		register_post_type('cyon_banner',$args);
	}
}
add_action( 'init', 'cyon_banner_init' );

// Modifying listing columns
function cyon_banner_columns($columns){
	$columns = array(
        'cb' 						=> '<input type="checkbox" />',
        'title' 					=> __('Title'),
		'cyon_banner_url'			=> __('URL'),
		'cyon_banner_sort'			=> __('Sort')
     );
    return $columns;
}
add_filter('manage_edit-cyon_banner_columns', 'cyon_banner_columns');

function cyon_banner_custom_columns( $column, $post_id ) {
    switch ( $column ) {

      case 'cyon_banner_sort':
        echo get_post_meta( $post_id , 'cyon_banner_sort' , true ); 
        break;

      case 'cyon_banner_url':
        echo get_post_meta( $post_id , 'cyon_banner_url' , true ); 
        break;

    }
}
add_action( 'manage_cyon_banner_posts_custom_column' , 'cyon_banner_custom_columns', 10, 2 );

$prefix = 'cyon_banner_';
$cyon_meta_boxes[] = array(
	'id' => 'settings',
	'title' => __('Settings'),
	'pages' => array('cyon_banner'), // multiple post types, accept custom post types
	'context' => 'normal', // normal, advanced, side (optional)
	'priority' => 'high', // high, low (optional)
	'fields' => array(
		array(
			'name' => __('URL'),
			'id' => $prefix .'url',
			'type' => 'text',
			'size' => '70',
			'desc' => __('Example').': http://www.website.com/'
		),
		array(
			'name' => __('Sort'),
			'id' => $prefix .'sort',
			'type' => 'text',
			'size' => '10'
		)
	)
);


/* Register header JS and CSS */
if ( ! function_exists( 'cyon_header_banner_js_css' ) ){
	function cyon_header_banner_js_css(){
		wp_enqueue_script('flexislider');
		wp_enqueue_style('flexislider_css');
	}
}
if ( ! function_exists( 'cyon_footer_banner_common_hook' ) ){
	function cyon_footer_banner_common_hook(){ ?>
		<script type="text/javascript">
			// Flexslider List
			jQuery(window).load(function() {
				jQuery('.flexslider').flexslider({
					controlNav: false,
					animation: 'slide'
				});
			});
		</script> 
	<?php }
}

if ( ! function_exists( 'cyon_flexslider' ) ){
	function cyon_flexslider(){
		$args = array(
					'posts_per_page' => -1,
					'post_type' => 'cyon_banner',
					'meta_key' => 'cyon_banner_sort',
					'order' => 'ASC',
					'orderby' => 'meta_value'
				);
		$query = new WP_Query($args);
		add_action ( 'wp_footer', 'cyon_header_banner_js_css');
		add_action ( 'wp_footer', 'cyon_footer_banner_hook',100);
	?>
	
		<ul class="slides">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<li>
				<?php $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); ?>
				<?php echo get_post_meta(get_the_ID(), 'cyon_banner_url', true) ? '<a href="'.get_post_meta(get_the_ID(), 'cyon_banner_url', true).'">' : '' ?>
					<img src="<?php echo $image_url[0]; ?>" title="<?php the_title(); ?>" />
				<?php echo get_post_meta(get_the_ID(), 'cyon_banner_url', true) ? '</a>' : '' ?>
				<?php if(of_get_option('homepage_slider_caption')==1){ ?>
				<?php
					$ctop = 'auto';
					$cleft = 'auto';
					$cright = 'auto';
					$cbottom = 'auto';
					if(of_get_option('homepage_slider_caption_layout')=='top-right'){
						$ctop = '0';
						$cright = '0';
					}
					if(of_get_option('homepage_slider_caption_layout')=='top-left'){
						$ctop = '0';
					}
					if(of_get_option('homepage_slider_caption_layout')=='bottom-left'){
						$cbottom = '0';
					}
					if(of_get_option('homepage_slider_caption_layout')=='bottom-right'){
						$cbottom = '0';
						$cright = '0';
					}
					$ptop = 'auto';
					$pleft = 'auto';
					$pright = 'auto';
					$pbottom = 'auto';
					$pwidth = '100%';
					$palign = 'center';
					if(of_get_option('homepage_slider_pagination_layout')=='top-center'){
						$ptop = '10px';
					}
					if(of_get_option('homepage_slider_pagination_layout')=='top-right'){
						$ptop = '10px';
						$pright = '10px';
						$pwidth = 'auto';
						$palign = 'right';
					}
					if(of_get_option('homepage_slider_pagination_layout')=='top-left'){
						$ptop = '10px';
						$pleft = '10px';
						$pwidth = 'auto';
						$palign = 'left';
					}
					if(of_get_option('homepage_slider_pagination_layout')=='bottom-center'){
						$pbottom = '10px';
					}
					if(of_get_option('homepage_slider_pagination_layout')=='bottom-left'){
						$pbottom = '10px';
						$pleft = '10px';
						$pwidth = 'auto';
						$palign = 'left';
					}
					if(of_get_option('homepage_slider_pagination_layout')=='bottom-right'){
						$pbottom = '10px';
						$pright = '10px';
						$pwidth = 'auto';
						$palign = 'right';
					}
				?>
				<?php if(of_get_option('homepage_slider_animation')==0){ ?>
				<div class="flex-caption" style="width:<?php echo of_get_option('homepage_slider_caption_width')-6; ?>%; top:<?php echo $ctop; ?>; left:<?php echo $cleft; ?>; right:<?php echo $cright; ?>; bottom:<?php echo $cbottom; ?>;">
					<h3 class="flex-title"><?php the_title(); ?></h3>
					<div class="flex-content">
						<?php the_content(); ?>
					</div>
					<?php if ( get_post_meta(get_the_ID(), 'cyon_banner_url', true) ){ ?>
					<p class="readmore"><a href="<?php echo get_post_meta(get_the_ID(), 'cyon_banner_url', true); ?>"><?php _e('Read more'); ?></a></p>
					<?php } ?>
				</div>
				<?php } } ?>
			</li>
			<?php endwhile; ?>
		</ul>
		<?php if(of_get_option('homepage_slider_pagination')==1){ ?>
			<style type="text/css" media="screen">
				.flexslider .flex-control-nav { top:<?php echo $ptop; ?>; left:<?php echo $pleft; ?>; right:<?php echo $pright; ?>; bottom:<?php echo $pbottom; ?>; width:<?php echo $pwidth; ?>; text-align:<?php echo $palign; ?>; }
			</style>
		<?php } ?>
	<?php
		wp_reset_query();
	}
}

function cyon_footer_banner_hook(){ ?>
	<script type="text/javascript">
		// Flexslider
		jQuery(window).load(function() {
			jQuery('#slider').flexslider({
				<?php if(of_get_option('homepage_slider_arrows')==0){ ?>
				directionNav: false,<?php } ?>
				<?php if(of_get_option('homepage_slider_pagination')==0){ ?>
				controlNav: false,<?php } ?>
				<?php if(of_get_option('homepage_slider_animation')>0){ ?>
				animation: "slide",
				direction: "<?php echo of_get_option('homepage_slider_animation')==1 ? 'horizontal' : 'vertical'; ?>"<?php }else{ ?>
				animation: "fade"<?php } ?>
				
			});
		});
	</script> 
	<?php
}


/* Homepage Slider Hook */
function cyon_banner_hook(){
	if ( of_get_option('homepage_slider')!='default' && (is_front_page()) ){ ?>
		<!-- Banner -->
		<div id="slider" class="<?php echo of_get_option('homepage_slider'); ?> captionlocation<?php echo of_get_option('homepage_slider_animation'); ?>">
			<?php if(of_get_option('homepage_slider')=='flexslider'){ 
				cyon_flexslider();
			}else{ ?>
				<?php if(of_get_option('homepage_slider_image_url')==''){ ?>
			<img src="<?php echo of_get_option('homepage_slider_image_file'); ?>" alt="Banner image" />
				<?php }else{ ?>
			<a href="<?php echo of_get_option('homepage_slider_image_url'); ?>"><img src="<?php echo of_get_option('homepage_slider_image_file'); ?>" alt="Banner image" /></a>
				<?php } ?>
			<?php } ?>
		</div>
	<?php }elseif(of_get_option('homepage_slider')=='default' && has_post_thumbnail() && (is_home() || is_front_page())){ ?>
		<!-- Banner -->
		<div id="slider" class="singleimage">
			<?php the_post_thumbnail( $post->ID, 'post-thumbnail' ); ?>
		</div>
	<?php }
}
add_action('cyon_home_content','cyon_banner_hook',10);


/* =Gallery Slider
----------------------------------------------- */
if(of_get_option('content_gallery')!='default'){
	remove_shortcode('gallery', 'gallery_shortcode');
	add_shortcode('gallery', 'cyon_gallery_shortcode');
}

function cyon_gallery_shortcode($attr){
	global $post;

	static $instance = 0;
	$instance++;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'size'       => 'large',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	if(of_get_option('content_gallery')=='slider_carousel'){
		$selector = "carousel-{$instance}";
		$output .= '<div id="'.$selector.'" class="flexslider carousel flexslider-'.$id.'">';
		$output .= '<ul class="slides">';
		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			$link = wp_get_attachment_image($id, $size, false, false);
			$output .= '<li>'.$link.'</li>';
		}
		$output .= '</ul></div>';
	}

	$selector = "flexslider-{$instance}";
	$output .= '<div id="'.$selector.'" class="flexslider wpslider flexslider-'.$id.'">';
	$output .= '<ul class="slides">';
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = wp_get_attachment_image($id, $size, false, false);
		$output .= '<li style="max-height:'.$attr['maxheight'].'px;">'.$link.'<div class="flex-caption"><h3 style="margin:0!important;">' . wptexturize($attachment->post_title) . '</h3>';
		if ( trim($attachment->post_excerpt) ) {
			$output .= '<div class="flex-content"><p style="margin:4px 0 0 0!important;">' . wptexturize($attachment->post_excerpt) . '</p></div>';
		}
		$output .= '</div></li>';
	}
	$output .= '</ul></div>';

	$output .= '<script type="text/javascript">
		jQuery(window).load(function() {
			jQuery(\'#flexslider-'.$instance.'\').flexslider({
				animation: "fade",
				directionNav: false, 
				smoothHeight: true,
				animationLoop: false, 
				slideshow: false';
	if(of_get_option('content_gallery')=='slider_carousel'){
	$output .= ',controlNav: false,
				sync: \'#carousel-'.$instance.'\'
			});
			jQuery(\'#carousel-'.$instance.'\').flexslider({
				animation: "slide",
				controlNav: false,
				slideshow: false, 
				itemWidth: 120,
				minItems: 2,
				maxItems: 5,
				animationLoop: false, 
				asNavFor: \'#flexslider-'.$instance.'\'
			';
	}
	$output .= '});});
	</script>';
	add_action ( 'wp_footer', 'cyon_header_banner_js_css');
	return $output;
}

