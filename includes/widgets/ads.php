<?php

class CyonAdsWidget extends WP_Widget {
	
	// Creating your widget
	function CyonAdsWidget(){
		$widget_ops = array('classname' => 'cyon-ads', 'description' => __('Displays advertising images/urls') );
		$this->WP_Widget('CyonAdsWidget', __('Cyon Ads'), $widget_ops);
	}

 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> __('Sponsors'),
			'ad_img_1'	=> '',
			'ad_url_1'	=> '',
			'ad_name_1'	=> '',
			'ad_img_2'	=> '',
			'ad_url_2'	=> '',
			'ad_name_2'	=> '',
			'ad_img_3'	=> '',
			'ad_url_3'	=> '',
			'ad_name_3'	=> '',
			'ad_img_4'	=> '',
			'ad_url_4'	=> '',
			'ad_name_4'	=> '',
			'ad_img_5'	=> '',
			'ad_url_5'	=> '',
			'ad_name_5'	=> '',
			'ad_img_6'	=> '',
			'ad_url_6'	=> '',
			'ad_name_6'	=> '',
			'ad_img_7'	=> '',
			'ad_url_7'	=> '',
			'ad_name_7'	=> '',
			'ad_img_8'	=> '',
			'ad_url_8'	=> '',
			'ad_name_8'	=> '',
			'ad_img_9'	=> '',
			'ad_url_9'	=> '',
			'ad_name_9'	=> '',
			'ad_img_10'	=> '',
			'ad_url_10'	=> '',
			'ad_name_10'=> '',
			'cols'		=> '',
			'num'		=> 1,
			'open'		=> 'true'
		) );
		$title = $instance['title'];
		$open = $instance['open'];
		$cols = $instance['cols'];
		$num = (int)$instance['num'];
		
		?>
		  <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		  <p><label for="<?php echo $this->get_field_id('cols'); ?>"><?php _e('Columns') ?>: <input class="widefat" id="<?php echo $this->get_field_id('cols'); ?>" name="<?php echo $this->get_field_name('cols'); ?>" type="text" value="<?php echo attribute_escape($cols); ?>" /></label></p>
		  <p><input type="checkbox" name="<?php echo $this->get_field_name('open'); ?>" id="<?php echo $this->get_field_id('open'); ?>" value="1" <?php echo ($open == "true" ? "checked='checked'" : ""); ?> /> <label for="<?php echo $this->get_field_id('open'); ?>"><?php _e('Open in new window') ?></label></p>
		  <p><label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of Ads') ?>:</label>
		  	<select id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>">
			  <?php for($n=1;$n<=10;$n++){ ?>
			  <option<?php echo $num==$n ? ' selected="selected"' : ''; ?>><?php echo $n; ?></option>
			   <?php } ?>
			</select>
		  </p>
		  <?php for($i=1;$i<=$num;$i++){ ?>
		  <p><label for="<?php echo $this->get_field_id('ad_img_'.$i); ?>"><?php _e('Ad'); echo ' #'.$i ?>: <input class="widefat" id="<?php echo $this->get_field_id('ad_img_'.$i); ?>" name="<?php echo $this->get_field_name('ad_img_'.$i); ?>" type="text" value="<?php echo attribute_escape($instance['ad_img_'.$i]); ?>" placeholder="<?php _e('Image URL'); ?>" /></label></p>
		  <p><input class="widefat" id="<?php echo $this->get_field_id('ad_url_'.$i); ?>" name="<?php echo $this->get_field_name('ad_url_'.$i); ?>" type="text" value="<?php echo attribute_escape($instance['ad_url_'.$i]); ?>" placeholder="<?php _e('Target URL'); ?>" /></label></p>
		  <p><input class="widefat" id="<?php echo $this->get_field_id('ad_name_'.$i); ?>" name="<?php echo $this->get_field_name('ad_name_'.$i); ?>" type="text" value="<?php echo attribute_escape($instance['ad_name_'.$i]); ?>" placeholder="<?php _e('Name'); ?>" /></label></p>
		  <?php } ?>
		<?php
	}

	// Saving your widget form
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		// Override new values of each fields
		$instance['title'] = $new_instance['title'];
		$instance['open'] = (bool)$new_instance['open'];
		$instance['cols'] = $new_instance['cols'];
		$instance['num'] = $new_instance['num'];
		for($i=1;$i<=$instance['num'];$i++){
			$instance['ad_img_'.$i] = $new_instance['ad_img_'.$i];
			$instance['ad_url_'.$i] = $new_instance['ad_url_'.$i];
			$instance['ad_name_'.$i] = $new_instance['ad_name_'.$i];
		}
		return $instance;
	}

	// Displays your widget on the front-end
	function widget($args, $instance){
		extract($args, EXTR_SKIP);
		
		// Start widget
		echo $before_widget;
		$html = ''; 
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$open = $instance['open'];
		$num = $instance['num'];
		$cols = $instance['cols'];
		$target = '';
		if ($cols>1){
			$class = ' row-fluid';
			$cols = (int) 12 / $instance['cols'];
		}
		if($open==true){
			$target = ' target="_blank"';
		}
		$count = 0;
		for($i=1;$i<=$num;$i++){
			if ($cols>1){
				$count++;
				if($count==1){
					$margin = ' no-margin';
				}elseif($count >= $instance['cols']){
					$count = 0;
				}
				$class_li = ' class="span'.$cols.$margin.'"';
			}
			$html .= empty($instance['ad_img_1']) ? '' : '<li'.$class_li.'><a href="'.$instance['ad_url_'.$i].'"'.$target.'><img src="'.$instance['ad_img_'.$i].'" alt="'.$instance['ad_name_'.$i].'" /> <span>'.$instance['ad_name_'.$i].'</span></a></li>';
			$margin = '';
		}
		
		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		echo '<ul class="widget-content'.$class.'">';
		
    	// Widget code here
		echo $html;
 
		// End widget
		echo '</ul>';
		echo $after_widget;
	}

}

// Adding your widget to WordPress
add_action( 'widgets_init', create_function('', 'return register_widget("CyonAdsWidget");') );