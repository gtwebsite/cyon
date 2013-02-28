<?php

/* =Homepage Testimonial Slider
----------------------------------------------- */

// Adding Testimonials
if ( ! function_exists( 'cyon_testimonial_init' ) ){
	function cyon_testimonial_init(){
		$labels = array(
			'name' 					=> __('Cyon Testimonials'),
			'singular_name'			=> __('Testimonial'),
			'add_new' 				=> __( 'Add New Testimonial' ),
			'add_new_item' 			=> __( 'Add New Testimonial' ),
			'edit_item'				=> __( 'Edit Testimonial' ),
			'new_item' 				=> __( 'Add New Testimonial' ),
			'view_item' 			=> __( 'View Testimonial' ),
			'search_items' 			=> __( 'Search Testimonial' ),
			'not_found' 			=> __( 'No testimonial found' ),
			'not_found_in_trash' 	=> __( 'No testimonial found in trash' ),
			'menu_name' 			=> __('Testimonials')
		);
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> false,
			'show_ui' 				=> true,
			'menu_position'			=> 520,
			'hierarchical'			=> false,
			'supports' 				=> array('title','editor','thumbnail')
		);
		register_post_type('cyon_testimonial',$args);
	}
}
add_action( 'init', 'cyon_testimonial_init' );

// Modifying listing columns
function cyon_testimonial_columns($columns){
	$columns = array(
        'cb' 						=> '<input type="checkbox" />',
        'title' 					=> __('Title'),
		'cyon_testimonial_sort'			=> __('Sort')
     );
    return $columns;
}
add_filter('manage_edit-cyon_testimonial_columns', 'cyon_testimonial_columns');

function cyon_testimonial_custom_columns( $column, $post_id ) {
    switch ( $column ) {

      case 'cyon_testimonial_sort':
        echo get_post_meta( $post_id , 'cyon_testimonial_sort' , true ); 
        break;

    }
}
add_action( 'manage_cyon_testimonial_posts_custom_column' , 'cyon_testimonial_custom_columns', 10, 2 );

$prefix = 'cyon_testimonial_';
$cyon_meta_boxes[] = array(
	'id' => 'settings',
	'title' => 'Settings',
	'pages' => array('cyon_testimonial'), // multiple post types, accept custom post types
	'context' => 'normal', // normal, advanced, side (optional)
	'priority' => 'high', // high, low (optional)
	'fields' => array(
		array(
			'name' => __('Position/Company'),
			'id' => $prefix .'company',
			'type' => 'text',
			'size' => '70'
		),
		array(
			'name' => __('Sort'),
			'id' => $prefix .'sort',
			'type' => 'text',
			'size' => '10'
		)
	)
);

/* Shortcode
use [testimonials id='' style='' classname=''] */
function cyon_testimonial( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			id		=> '',
			classname => '',
			style	=> 'list' // list, fade
		), $atts);
	if(!empty($atts['id'])){
		$args = array(
				'post__in' => array($atts['id']),
				'posts_per_page' => -1,
				'post_type' => 'cyon_testimonial',
				'meta_key' => 'cyon_testimonial_sort',
				'order' => 'ASC',
				'orderby' => 'meta_value'
			);
	}else{
		$args = array(
				'posts_per_page' => -1,
				'post_type' => 'cyon_testimonial',
				'meta_key' => 'cyon_testimonial_sort',
				'order' => 'ASC',
				'orderby' => 'meta_value'
			);
	}
	$query = new WP_Query($args);
	$html = '<ul class="testimonials testimonials-'.$atts['style'].' '.$atts['classname'].'">';
	while ( $query->have_posts() ) : $query->the_post();
	$html .= '
			<li>
				<div class="name">
					'.get_the_post_thumbnail($post->ID,'thumbnail').'
					<h4>'.get_the_title().'</h4>
					<p>'.rwmb_meta('cyon_testimonial_company').'</p>
				</div>
				<blockquote>
					'.get_the_content().'
				</blockquote>
			</li>';
	endwhile;
	$html .= '</ul>';
	if($atts['style']=='fade'){
		ob_start();
			add_action('wp_footer', 'cion_testimonial_js',20);
			wp_enqueue_script('jquery_cycle');
		ob_get_clean();
	}
	wp_reset_query();
	return $html;
}
add_shortcode('testimonials','cyon_testimonial'); 

/* Register header JS and CSS */
if ( ! function_exists( 'cion_testimonial_js' ) ){
	function cion_testimonial_js() {
			?>
			<script type="text/javascript">	
				jQuery(document).ready(function(){
					jQuery('.testimonials-fade').cycle({ 
							fx:      'fade', 
							speed:    1000, 
							timeout:  4000, 
							fit: 1,
							height:   'auto',
							sync:	1 ,
							pause: 1,
							after: onAfter
					});
					function onAfter(curr, next, opts, fwd) {
						var $ht = jQuery(this).height() + 20;
						//set the container's height to that of the current slide
						jQuery(this).parent().animate({height: $ht});
					}
				});
			</script>
<?php }  }  

/* Widget */
class CyonTestimonialWidget extends WP_Widget {
	
	// Creating your widget
	function CyonTestimonialWidget(){
		$widget_ops = array('classname' => 'cyon-testimonial', 'description' => __('Displays Testimonials') );
		$this->WP_Widget('CyonTestimonialWidget', __('Cyon Testimonial'), $widget_ops);
	}
 
 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'id' 			=> '',
			'title' 		=> 'Testimonials',
			'style'			=> 'List',
		) );
		$title = $instance['title'];
		$style = $instance['style'];
		$id = $instance['id'];
		?>
		  <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  		  <p><label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('ID(s), comman separated') ?>: <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo attribute_escape($id); ?>" /></label></p>
			<?php $options = array( 'list'=>'List', 'fade'=>'Fade');
			?>
  		  <p><label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('View Style') ?>: <select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="text">
				<?php foreach ( $options as $i=>$opt ) : ?>
					<option value="<?php echo $i?>" <?php echo $i == $instance['style'] ? 'selected' : ''?>><?php echo $opt ?></option>
				<?php endforeach; ?>
		  </select></label></p>		  
		<?php
	}
	// Saving your widget form
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		// Override new values of each fields
		$instance['title'] = $new_instance['title'];
		$instance['id'] = $new_instance['id'];
		$instance['style'] = $new_instance['style'];
		return $instance;
	}
		
	// Displays your widget on the front-end
	function widget($args, $instance){
		extract($args, EXTR_SKIP);

		// Start widget
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			if (!empty($title)){
			echo $before_title . $title . $after_title;
		}
    	// Widget code here
		if(!empty($instance['id'])){
			$args = array(
					'post__in' => array($instance['id']),
					'posts_per_page' => -1,
					'post_type' => 'cyon_testimonial',
					'meta_key' => 'cyon_testimonial_sort',
					'order' => 'ASC',
					'orderby' => 'meta_value'
				);
		}else{
			$args = array(
					'posts_per_page' => -1,
					'post_type' => 'cyon_testimonial',
					'meta_key' => 'cyon_testimonial_sort',
					'order' => 'ASC',
					'orderby' => 'meta_value'
				);
		}
		$query = new WP_Query($args);
		echo '<ul class="widget-content testimonials-'.$instance['style'].'">';
		while ( $query->have_posts() ) : $query->the_post();
		echo '
				<li>
					<blockquote>
						'.get_the_content().'
					</blockquote>
					<div class="name">
						'.get_the_post_thumbnail($post->ID,'thumbnail').'
						<h4>'.get_the_title().'</h4>
						<p>'.rwmb_meta('cyon_testimonial_company').'</p>
					</div>
				</li>';
		endwhile;
		echo '</ul>';
		if($instance['style']=='fade'){
			add_action('wp_footer', 'cion_testimonial_js',20);
			wp_enqueue_script('jquery_cycle');
		}
		// End widget
		echo $after_widget;
		//add_action('wp_footer', 'cion_testimonial_js'));
	}
	
}

add_action( 'widgets_init', create_function('', 'return register_widget("CyonTestimonialWidget");') );
