<?php

class CyonTwitterWidget extends WP_Widget {
	
	protected $count, $style;
	
	// Creating your widget
	function CyonTwitterWidget(){
		$widget_ops = array('classname' => 'cyon-twitter', 'description' => __('Displays Twitter Updates') );
		$this->WP_Widget('CyonTwitterWidget', __('Cyon Twitter Widget'), $widget_ops);
	}
 
 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> 'Twitter Updates',
			'count'			=> '3',
			'style'			=> 'List',
			'link'			=> 'true'
		) );
		$title = $instance['title'];
		$count = $instance['count'];
		$style = $instance['style'];
		$link = $instance['link'];
		?>
		  <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  		  <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of tweets') ?>: <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo attribute_escape($count); ?>" /></label></p>
			<?php $options = array( 1=>__('List'), __('Fade'));
			?>
  		  <p><label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('View Style') ?>: <select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
				<?php foreach ( $options as $i=>$opt ) : ?>
					<option value="<?php echo $i?>" <?php echo $i == $instance['style'] ? 'selected' : ''?>><?php echo $opt ?></option>
				<?php endforeach; ?>
		  </select></label></p>		  
		  <p><input type="checkbox" name="<?php echo $this->get_field_name('link'); ?>" id="<?php echo $this->get_field_id('link'); ?>" value="1" <?php echo ($link == "true" ? "checked='checked'" : ""); ?> /> <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Show Link') ?></label></p>
		<?php
	}
	// Saving your widget form
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		// Override new values of each fields
		$instance['title'] = $new_instance['title'];
		$instance['text'] = $new_instance['text'];
		$instance['count'] = $new_instance['count'];
		$instance['style'] = $new_instance['style'];
		$instance['link'] = (bool)$new_instance['link'];
		return $instance;
	}
		
	// Displays your widget on the front-end
	function widget($args, $instance){
		extract($args, EXTR_SKIP);
		$this->count = $instance['count'];
		$this->style = $instance['style'];

		// Start widget
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			if (!empty($title)){
			echo $before_title . $title . $after_title;
		}

    	// Widget code here
		echo '<div class="widget-content"><ul id="twitter_update_list">';
		echo '<li>Twitter Feed Loading...';
		echo '</ul>';
 		if($instance['link']==true){
			echo '<p><a href="https://twitter.com/'.of_get_option('social_twitter').'" target="_blank">'.__('Follow us on').' Twitter</a></p>';
		}
		echo '</div>';
		// End widget
		echo $after_widget;
		add_action('wp_footer', array(&$this, 'cion_twitter_js'));
	}
	
	function cion_twitter_js() {
		wp_enqueue_script('twitter_blogger_js');  
		wp_deregister_script( 'twitter_user_timeline_js' );          
		wp_register_script('twitter_user_timeline_js','http://api.twitter.com/1/statuses/user_timeline.json?screen_name='.of_get_option('social_twitter').'&include_rts=1&callback=twitterCallback2&count='.$this->count,'','',true);
		wp_enqueue_script( 'twitter_user_timeline_js' );
		if ($this->style==2){
			wp_enqueue_script('jquery_cycle');
			?>
			<script type="text/javascript">	
				jQuery(document).ready(function(){
					jQuery('#twitter_update_list').cycle({ 
							fx:      'fade', 
							speed:    1000, 
							timeout:  4000, 
							fit: 1,
							height:   'auto',
							pause: 1,
							sync:	1, 
							after: onAfter
					});
					function onAfter(curr, next, opts, fwd) {
						var $ht = jQuery(this).height() + 20;
						//set the container's height to that of the current slide
						jQuery(this).parent().animate({height: $ht});
					}
				});
			</script>
		<?php }
	}    

}

// Adding your widget to WordPress
add_action( 'widgets_init', create_function('', 'return register_widget("CyonTwitterWidget");') );
