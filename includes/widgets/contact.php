<?php

class CyonContactWidget extends WP_Widget {

	// Creating your widget
	function CyonContactWidget(){
		$widget_ops = array('classname' => 'cyon-contact', 'description' => __('Displays contact information') );
		$this->WP_Widget('CyonContactWidget', __('Cyon Contact'), $widget_ops);
	}
 
 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> 'Contact Info',
			'address'		=> '',
			'phone'			=> '',
			'fax'			=> '',
			'email'			=> '',
			'website'		=> ''
		) );
		$title = $instance['title'];
		$address = $instance['address'];
		$phone = $instance['phone'];
		$fax = $instance['fax'];
		$email = $instance['email'];
		$website = $instance['website'];

		?>
		  <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		  <p><label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address') ?>: <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo attribute_escape($address); ?>" /></label></p>
		  <p><label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone') ?>: <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo attribute_escape($phone); ?>" /></label></p>
		  <p><label for="<?php echo $this->get_field_id('fax'); ?>"><?php _e('Fax') ?>: <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" type="text" value="<?php echo attribute_escape($fax); ?>" /></label></p>
		  <p><label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email') ?>: <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo attribute_escape($email); ?>" /></label></p>
		  <p><label for="<?php echo $this->get_field_id('website'); ?>"><?php _e('Website') ?>: <input class="widefat" id="<?php echo $this->get_field_id('website'); ?>" name="<?php echo $this->get_field_name('website'); ?>" type="text" value="<?php echo attribute_escape($website); ?>" /></label></p>
		<?php
	}

	// Saving your widget form
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		// Override new values of each fields
		$instance['title'] = $new_instance['title'];
		$instance['address'] = $new_instance['address'];
		$instance['phone'] = $new_instance['phone'];
		$instance['fax'] = $new_instance['fax'];
		$instance['email'] = $new_instance['email'];
		$instance['website'] = $new_instance['website'];
		return $instance;
	}

	// Displays your widget on the front-end
	function widget($args, $instance){
		extract($args, EXTR_SKIP);
		
		// Start widget
		echo $before_widget;
		$html = ''; 
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$html .= empty($instance['address']) ? '' : '<address class="has-icon"><span class="icon-map-marker"></span>'.$instance['address'].'</address>';
		$html .= empty($instance['phone']) ? '' : '<address class="has-icon"><span class="icon-phone"></span>'.$instance['phone'].'</address>';
		$html .= empty($instance['fax']) ? '' : '<address class="has-icon"><span class="icon-print"></span>'.$instance['fax'].'</address>';
		$html .= empty($instance['email']) ? '' : '<address class="has-icon"><a href="mailto:'.$instance['email'].'"><span class="icon-envelope"></span>'.$instance['email'].'</a></address>';
		$html .= empty($instance['website']) ? '' : '<address class="has-icon"><a href="http://'.$instance['website'].'"><span class="icon-globe"></span>'.$instance['website'].'</a></address>';
		
		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		echo '<div class="widget-content">';
		
    	// Widget code here
		echo $html;
 
		// End widget
		echo '</div>';
		echo $after_widget;
	}

}

// Adding your widget to WordPress
add_action( 'widgets_init', create_function('', 'return register_widget("CyonContactWidget");') );