<?php

class CyonMediaWidget extends WP_Widget {

	// Creating your widget
	function CyonMediaWidget(){
		$widget_ops = array('classname' => 'cyon-media-player', 'description' => __('Displays Video/Audio player') );
		$this->WP_Widget('CyonMediaWidget', __('Cyon Media Player'), $widget_ops);
	}
 
 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> 'Media Player',
			'text'			=> ''
		) );
		$title = $instance['title'];
		$text = $instance['text'];
		?>
		  <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		  <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Media URLs (comma separated for alternative files)') ?>: <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text"><?php echo attribute_escape($text); ?></textarea></label></p>
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
		
		// Start widget
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		
		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		echo '<div class="widget-content">';
    	// Widget code here
		$domain = parse_url(strtolower($instance['text']));
		if($domain['host']=='www.youtube.com' || $domain['host']=='youtube.com'){
			echo '<video type="video/youtube" src="'.$instance['text'].'" preload="none" style="width:100%; height:100%;" />';
		}elseif($domain['host']=='www.vimeo.com' || $domain['host']=='vimeo.com'){
			echo '<video type="video/vimeo" src="'.$instance['text'].'" preload="none" style="width:100%; height:100%;" />';
		}elseif($domain['scheme']=='rtmp'){
			echo '<video type="video/flv" src="'.$instance['text'].'" autoplay style="width:100%; height:100%;" />';
		}else{
			$file = pathinfo($instance['text']);
			$sources = explode(",", $instance['text']);
			if(count($sources)==1 && $file['extension'] != 'mp4'){
				echo '<audio src="'.$instance['text'].'" type="audio/'.$file['extension'].'" controls="controls" preload="none" style="width:100%; height:100%;">';
				if($file['extension']=='mp4' || $file['extension']=='mpeg' || $file['extension']=='m4a' || $file['extension']=='flv'){
					echo '<object type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/assets/js/jquery.flashmediaelement.swf"><param name="movie" value="'.get_template_directory_uri().'/assets/js/jquery.flashmediaelement.swf" /><param name="flashvars" value="controls=true&file='.$instance['text'].'" />'.__('No video playback capabilities').'" /></object>';
				}
				echo '</audio>';
			}else{
				$type = '';
				echo '<video controls="controls" preload="none" style="width:100%; height:100%;">';
				for($i=0; $i<count($sources); $i++){
					$file = pathinfo($sources[$i]);
					if ($file['extension'] == 'mp4'){
						$type = 'mp4';
					}elseif($file['extension'] == 'm4v'){
						$type = 'm4v';
					}elseif($file['extension'] == 'mov'){
						$type = 'mov';
					}elseif($file['extension'] == 'wmv'){
						$type = 'wmv';
					}elseif($file['extension'] == 'flv'){
						$type = 'flv';
					}elseif($file['extension'] == 'webm'){
						$type = 'webm';
					}elseif($file['extension'] == 'ogv'){
						$type = 'ogg';
					}
					if($type!=''){
						echo '<source type="video/'.$type.'" src="'.$sources[$i].'" />';
					}
					if($type=='mp4' || $type=='m4v' || $type=='mov' || $type=='flv'){
						$html .= '<object type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/assets/js/jquery.flashmediaelement.swf"><param name="movie" value="'.get_template_directory_uri().'/assets/js/jquery.flashmediaelement.swf" /><param name="flashvars" value="controls=true&file='.$sources[$i].'" />'.__('No video playback capabilities').'</object>';
					}
				}
			}
		}
		// End widget
		echo '</div>';
		echo $after_widget;
		add_action('wp_footer','cyon_video_audio_js_css',20);
	}
}

// Adding your widget to WordPress
add_action( 'widgets_init', create_function('', 'return register_widget("CyonMediaWidget");') );