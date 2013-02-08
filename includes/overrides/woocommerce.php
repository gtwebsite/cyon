<?php

/* Add own CSS and JS */
function cyon_woo_header_js_css_hook(){ ?>
	<?php if(get_option('woocommerce_frontend_css') == 'no'){ ?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/woocommerce.css" />
		<?php if(of_get_option('responsive')==1){ ?><link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/woocommerce-responsive.css" /><?php } ?>
	<?php } ?>
	<?php if(get_option('woocommerce_frontend_css') == 'no'){  ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			<?php if(is_product()){  ?>
			CloudZoom.quickStart();
			jQuery('.woocommerce_tabs').addClass('tabs');
			jQuery('.woocommerce_tabs .tabs').addClass('tab_nav');
			jQuery('.woocommerce_tabs').removeClass('woocommerce_tabs');
			jQuery('.tabs .tabs').removeClass('tabs');
			jQuery('.tabs .tab_nav li:first-child').addClass('active');
			jQuery(jQuery('.tab_nav li.active a').attr('href')).show();
			jQuery('.tab_nav li a').click(function(){
				var prev = jQuery(this).parent().parent().find('li.active a').attr('href');
				if (!jQuery(this).parent().hasClass('active')) {
					jQuery(this).parent().parent().find('li.active').removeClass('active');
					jQuery(this).parent().addClass('active');
				}
				var current = jQuery(this).attr('href');
				if(jQuery(jQuery(this).attr('href')).is(':hidden')){
					jQuery(prev).slideUp('slow', function(){
						jQuery(current).slideDown(500);
					});
				}
				event.preventDefault();
			});
			<?php } ?>
			jQuery('.woocommerce_ordering select, .variations_form select, .shipping_calculator select, .checkout select, .checkout input[type=radio], .checkout input[type=checkbox], #billing_country, #shipping_country').uniform();
		});
	</script>
	<style media="all" type="text/css">
		.blockOverlay {
			background:<?php echo of_get_option('background_color'); ?>!important;
		}

	</style>
	<?php } ?>
<?php }
add_action ( 'wp_head', 'cyon_woo_header_js_css_hook',100);

function cyon_woo_common_scripts(){
	wp_enqueue_script('cloud_zoom');
	wp_enqueue_style('cloud_zoom_css');
}

function cyon_woo_init(){
	if(is_product() && get_option('woocommerce_frontend_css') == 'no'){
		add_action('wp_enqueue_scripts', 'cyon_woo_common_scripts',100);
	}
}
add_action( 'wp', 'cyon_woo_init' );

/* Override default breadcrumb */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',20);
remove_action( 'cyon_before_body_wrapper', 'cyon_breadcrumb_hook' , 10 );
add_action( 'cyon_before_body_wrapper', 'woocommerce_breadcrumb', 20, 0 );


/* Override Single Product Image */
function cyon_show_product_images(){
	global $post, $woocommerce; ?>

	<div class="images">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php
			$image_attributes_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
			$image_attributes_large = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
			?>
			<img class="cloudzoom" id="zoom-gallery" src="<?php echo $image_attributes_thumb[0]; ?>" data-cloudzoom ='{"zoomImage":"<?php echo $image_attributes_large[0]; ?>","zoomSizeMode":"image"}' />
		<?php else : ?>
			<img src="<?php echo woocommerce_placeholder_img_src(); ?>" alt="Placeholder" />
		<?php endif; ?>
		<div class="thumbnails"><?php
		$attachments = get_posts( array(
			'post_type' 	=> 'attachment',
			'numberposts' 	=> -1,
			'post_status' 	=> null,
			'post_parent' 	=> $post->ID,
			'post_mime_type'=> 'image',
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC'
		) );
		if ($attachments) {
			$loop = 0;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
			foreach ( $attachments as $key => $attachment ) {
	
				if ( get_post_meta( $attachment->ID, '_woocommerce_exclude_image', true ) == 1 )
					continue;
				$classes = array( 'zoom' );
				if ( $loop == 0 || $loop % $columns == 0 )
					$classes[] = 'first';
	
				if ( ( $loop + 1 ) % $columns == 0 )
					$classes[] = 'last';
				$image_attributes_thumb = wp_get_attachment_image_src( $attachment->ID, 'medium' );
				$image_attributes_large = wp_get_attachment_image_src( $attachment->ID, 'large' );
				echo '<a href="#" class="cloudzoom-gallery" data-cloudzoom = \'{"useZoom":"#zoom-gallery","image":"'.$image_attributes_thumb[0].'","zoomImage":"'.$image_attributes_large[0].'"}\'>'.wp_get_attachment_image( $attachment->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) ).'</a>';				
				$loop++;
			}
		}
	?></div>
	</div>
<?php }
if(get_option('woocommerce_frontend_css') == 'no'){
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	add_action( 'woocommerce_before_single_product_summary', 'cyon_show_product_images', 20 );
}
/* Override Related Products */
function cyon_woocommerce_output_related_products(){
	woocommerce_related_products( 4, 4 );
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action( 'woocommerce_after_single_product_summary', 'cyon_woocommerce_output_related_products', 20, 0 );

/* Display 24 products per page */
add_filter('loop_shop_per_page', create_function('$cols', 'return 24;'));

/* Total Cart Widget */
class CyonWoocommerceTotalCartWidget extends WP_Widget {

	// Creating your widget
	function CyonWoocommerceTotalCartWidget(){
		$widget_ops = array('classname' => 'cyon-woo-total-cart', 'description' => __('Displays a total cart') );
		$this->WP_Widget('CyonWoocommerceTotalCartWidget', __('Cyon WooCommerce Total Cart'), $widget_ops);
	}
 
 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> __('My Cart'),
		) );
		$title = $instance['title'];

		?>
		  <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<?php
	}

	// Saving your widget form
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		// Override new values of each fields
		$instance['title'] = $new_instance['title'];
		return $instance;
	}

	// Displays your widget on the front-end
	function widget($args, $instance){
		extract($args, EXTR_SKIP);
		global $woocommerce;
		
		// Start widget
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		
		if (!empty($title)){
			echo $before_title . $title . $after_title;
		}
		echo '<div class="widget-content">';
		
    	// Widget code here
		echo '<p><a class="cart-contents" href="'.$woocommerce->cart->get_cart_url().'" title="'.__('View your shopping cart', 'woothemes').'">'.sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count).' ('.$woocommerce->cart->get_cart_total().') - '.__('View Cart').'</a></p>';
 
		// End widget
		echo '</div>';
		echo $after_widget;
	}
	
	
}

// Adding your widget to WordPress
add_action( 'widgets_init', create_function('', 'return register_widget("CyonWoocommerceTotalCartWidget");') );


/* Total Cart Shortcode
use [woocart]
----------------------------------------------- */
function cyon_woocart( $atts, $content = null ) {
	global $woocommerce;
	return '<a class="cart-contents" href="'.$woocommerce->cart->get_cart_url().'" title="'.__('View your shopping cart', 'woothemes').'">'.sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count).' ('.$woocommerce->cart->get_cart_total().') - '.__('View Cart').'</a>';
}
add_shortcode('woocart','cyon_woocart');


/* Categories Widget */
class CyonWoocommerceCategoriesWidget extends WP_Widget {

	var $cat_ancestors;
	var $current_cat;

	// Creating your widget
	function CyonWoocommerceCategoriesWidget(){
		$widget_ops = array('classname' => 'CyonWoocommerceCategoriesWidget', 'description' => __('Displays a categories with images/description') );
		$this->WP_Widget('CyonWoocommerceCategoriesWidget', __('Cyon WooCommerce Categories'), $widget_ops);
	}
 
 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> __('Categories'),
			'orderby' 		=> '',
			'image' 		=> true,
			'image_size'	=> 'thumbnail',
			'description'	=> true,
			'count' 		=> ''
		) );
		$title = $instance['title'];
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'order';
		$image_size = isset( $instance['image_size'] ) ? $instance['image_size'] : 'thumbnail';
		$image = isset($instance['image']) ? (bool) $instance['image'] :false;
		$description = isset($instance['description']) ? (bool) $instance['description'] :false;
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;

		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order by:', 'woocommerce') ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id('orderby') ); ?>" name="<?php echo esc_attr( $this->get_field_name('orderby') ); ?>">
				<option value="order" <?php selected($orderby, 'order'); ?>><?php _e('Category Order', 'woocommerce'); ?></option>
				<option value="name" <?php selected($orderby, 'name'); ?>><?php _e('Name', 'woocommerce'); ?></option>
			</select></p>
			<p>
				<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('image') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image') ); ?>"<?php checked( $image ); ?> /> <label for="<?php echo $this->get_field_id('image'); ?>"><?php _e( 'Show image' ); ?></label><br />
				<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('description') ); ?>" name="<?php echo esc_attr( $this->get_field_name('description') ); ?>"<?php checked( $description ); ?> /> <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e( 'Show Description' ); ?></label><br />
				<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('count') ); ?>" name="<?php echo esc_attr( $this->get_field_name('count') ); ?>"<?php checked( $count ); ?> /> <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts', 'woocommerce' ); ?></label>
			</p>
			<p><label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Image Size:') ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id('image_size') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image_size') ); ?>">
				<option value="thumbnail" <?php selected($image_size, 'thumbnail'); ?>><?php _e('Thumbnail'); ?></option>
				<option value="medium" <?php selected($image_size, 'medium'); ?>><?php _e('Medium'); ?></option>
				<option value="large" <?php selected($image_size, 'large'); ?>><?php _e('Large'); ?></option>
			</select></p>
		<?php
	}

	// Saving your widget form
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		// Override new values of each fields
		$instance['title'] = $new_instance['title'];
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		$instance['image'] = !empty($new_instance['image']) ? 1 : 0;
		$instance['image_size'] = strip_tags($new_instance['image_size']);
		$instance['description'] = !empty($new_instance['description']) ? 1 : 0;
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		return $instance;
	}

	// Displays your widget on the front-end
	function widget($args, $instance){
		extract($args, EXTR_SKIP);
		global $wp_query, $post, $woocommerce;

		// Start widget
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$orderby = isset($instance['orderby']) ? $instance['orderby'] : 'order';
		$image = $instance['image'] ? '1' : '0';
		$image_size = isset($instance['image_size']) ? $instance['image_size'] : 'thumbnail';
		$description = $instance['description'] ? '1' : '0';
		$count = $instance['count'] ? '1' : '0';
	
		$this->current_cat = false;
		$this->cat_ancestors = array();
		
		$cat_args = array('show_count' => $count, 'hierarchical' => 0, 'taxonomy' => 'product_cat');
		if ( $orderby == 'order' ) {
			$cat_args['menu_order'] = 'asc';
		} else {
			$cat_args['orderby'] = 'title';
		}
	
		if (!empty($title)){
			echo $before_title . $title . $after_title;
		}

		include_once( 'class-product-cat-list-walker.php' );

		$cat_args['walker'] 			= new Cyon_WC_Product_Cat_List_Walker;
		$cat_args['title_li'] 			= '';
		$cat_args['show_children_only']	= 1;
		$cat_args['pad_counts'] 		= 1;
		$cat_args['image'] 				= $image;
		$cat_args['description'] 		= $description;
		$cat_args['image_size'] 		= $image_size;
		$cat_args['show_option_none'] 	= __('No product categories exist.', 'woocommerce');
		$cat_args['current_category']	= ( $this->current_cat ) ? $this->current_cat->term_id : '';
		$cat_args['current_category_ancestors']	= $this->cat_ancestors;

		echo '<ul class="cyon-product-categories size-'.$image_size.'">';

    	// Widget code here
		wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $cat_args ) );
 
		// End widget
		echo '</ul>';
		echo $after_widget;
	}
	
	
}

// Adding your widget to WordPress
add_action( 'widgets_init', create_function('', 'return register_widget("CyonWoocommerceCategoriesWidget");') );


/* Total Cart Widget AJAX */
function cyon_woocommerce_header_add_to_cart_fragment($fragments){
	global $woocommerce;
	ob_start();
	?>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}
add_filter('add_to_cart_fragments', 'cyon_woocommerce_header_add_to_cart_fragment');


/* Replace Pagination */
function unhook_cyon_woocommerce() {
	if(function_exists( 'wp_pagenavi' )){
		remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );
		add_action( 'woocommerce_pagination', 'wp_pagenavi', 10 );
	}
}
add_action('init','unhook_cyon_woocommerce');
