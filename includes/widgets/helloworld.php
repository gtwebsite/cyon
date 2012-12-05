<?php

class HelloWorldWidget extends WP_Widget {

	// Declare widget-wide variable
	protected $var1, $var2;

	// Creating your widget
	function HelloWorldWidget(){
		$widget_ops = array('classname' => 'hello-world', 'description' => __('Displays a "Hello World"') );
		$this->WP_Widget('HelloWorldWidget', __('Cyon Says "Hello World"'), $widget_ops);
		// Available hooks
		add_action('wp_enqueue_scripts', array(&$this, 'cion_helloworld_js_head'));
		add_action('wp_footer', array(&$this, 'cion_helloworld_js'));
	}
 
 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> 'My Header',
			'text'			=> 'Hello world!'
		) );
		$title = $instance['title'];
		$text = $instance['text'];

		?>
		  <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		  <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text') ?>: <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo attribute_escape($text); ?>" /></label></p>
		<?php
	}

	// Saving your widget form
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		// Override new values of each fields
		$instance['title'] = $new_instance['title'];
		$instance['text'] = $new_instance['text'];
		return $instance;
	}

	// Displays your widget on the front-end
	function widget($args, $instance){
		extract($args, EXTR_SKIP);
		
		$this->var1 = $instance['title'];
		$this->var2 = $instance['text'];

		// Start widget
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		
		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		echo '<div class="widget-content">';
		
    	// Widget code here
		echo '<p>'.$instance['text'].'</p>';
 
		// End widget
		echo '</div>';
		echo $after_widget;
	}

	// Add new custom script
	function cion_helloworld_js_head() {
		wp_enqueue_script('jquery_custom_name','http://your.custom.js');
	}

	function cion_helloworld_js() {
		wp_enqueue_script('new_name_js','http://domain.com/'.$this->var1.'/file.js?variable='.$this->var2,'','',true);            
	}
}

// Adding your widget to WordPress
add_action( 'widgets_init', create_function('', 'return register_widget("HelloWorldWidget");') );