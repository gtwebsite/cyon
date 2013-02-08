<?php

if ( !defined('ABSPATH') )
	die('-1');

class CyonAdsWidget extends WP_Widget {
	
	// Creating your widget
	function CyonAdsWidget(){
		$widget_ops = array('classname' => 'cyon-ads', 'description' => __('Displays advertising images/urls') );
		$control_ops = array( 'id_base' => 'widget_cyon_ad' );
		$this->WP_Widget('CyonAdsWidget', __('Cyon Ads'), $widget_ops);
		add_action( 'admin_init', array( $this, 'admin_setup' ) );
	}
	function admin_setup(){
		global $pagenow;
		if ( 'widgets.php' == $pagenow ) {
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
		}elseif ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
			add_filter( 'image_send_to_editor', array( $this,'image_send_to_editor'), 1, 8 );
			add_filter( 'gettext', array( $this, 'replace_text_in_thickbox' ), 1, 3 );
			add_filter( 'media_upload_tabs', array( $this, 'media_upload_tabs' ) );
			add_filter( 'image_widget_image_url', array( $this, 'https_cleanup' ) );
		}
	}

 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> __('Sponsors'),
			'ad_img_1'	=> '',
			'ad_url_1'	=> 'http://',
			'ad_name_1'	=> '',
			'ad_img_2'	=> '',
			'ad_url_2'	=> 'http://',
			'ad_name_2'	=> '',
			'ad_img_3'	=> '',
			'ad_url_3'	=> 'http://',
			'ad_name_3'	=> '',
			'ad_img_4'	=> '',
			'ad_url_4'	=> 'http://',
			'ad_name_4'	=> '',
			'ad_img_5'	=> '',
			'ad_url_5'	=> 'http://',
			'ad_name_5'	=> '',
			'ad_img_6'	=> '',
			'ad_url_6'	=> 'http://',
			'ad_name_6'	=> '',
			'ad_img_7'	=> '',
			'ad_url_7'	=> 'http://',
			'ad_name_7'	=> '',
			'ad_img_8'	=> '',
			'ad_url_8'	=> 'http://',
			'ad_name_8'	=> '',
			'ad_img_9'	=> '',
			'ad_url_9'	=> 'http://',
			'ad_name_9'	=> '',
			'ad_img_10'	=> '',
			'ad_url_10'	=> 'http://',
			'ad_name_10'=> '',
			'cols'		=> 1,
			'num'		=> 1,
			'open'		=> 'true'
		) );
		$title = $instance['title'];
		$open = $instance['open'];
		$cols = $instance['cols'];
		$num = (int)$instance['num'];

		$media_upload_iframe_src = 'media-upload.php?type=image&post_id=0&widget_id='.$this->id; //NOTE #1: the widget id is added here to allow uploader to only return array if this is used with image widget so that all other uploads are not harmed.
		$image_upload_iframe_src = apply_filters('image_upload_iframe_src', $media_upload_iframe_src);
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
		<?php $image_title = __(($instance['ad_img_'.$i] ? 'Change' : 'Add Image'), 'cyon'); ?>
		<fieldset>
			<legend><?php echo __('Ad','cyon').' #'.$i ?>:</legend>
			<p>
				<input id="<?php echo $this->get_field_id('ad_img_'.$i); ?>" name="<?php echo $this->get_field_name('ad_img_'.$i); ?>" type="text" value="<?php echo attribute_escape($instance['ad_img_'.$i]); ?>" placeholder="<?php _e('Image URL'); ?>" />
				<a href="<?php echo $image_upload_iframe_src; ?>&TB_iframe=true" id="add_image-<?php echo $this->get_field_id('ad_img_'.$i); ?>" class="thickbox-image-widget" title='<?php echo $image_title; ?>' onClick="imageWidget.setActiveWidget('<?php echo $this->id; ?>',<?php echo $i; ?>);return false;" style="text-decoration:none"><img src='images/media-button-image.gif' alt='<?php echo $image_title; ?>' align="absmiddle" /> <?php echo $image_title; ?></a>
			</p>
			<!--
			<p><label for="<?php echo $this->get_field_id('ad_img_'.$i); ?>"><?php _e('Ad'); echo ' #'.$i ?>: <input class="widefat" id="<?php echo $this->get_field_id('ad_img_'.$i); ?>" name="<?php echo $this->get_field_name('ad_img_'.$i); ?>" type="text" value="<?php echo attribute_escape($instance['ad_img_'.$i]); ?>" placeholder="<?php _e('Image URL'); ?>" /></label></p>
			-->
			<p><input class="widefat" id="<?php echo $this->get_field_id('ad_url_'.$i); ?>" name="<?php echo $this->get_field_name('ad_url_'.$i); ?>" type="text" value="<?php echo attribute_escape($instance['ad_url_'.$i]); ?>" placeholder="<?php _e('Target URL'); ?>" /></label></p>
			<p><input class="widefat" id="<?php echo $this->get_field_id('ad_name_'.$i); ?>" name="<?php echo $this->get_field_name('ad_name_'.$i); ?>" type="text" value="<?php echo attribute_escape($instance['ad_name_'.$i]); ?>" placeholder="<?php _e('Name'); ?>" /></label></p>
		</fieldset>
		<?php } 
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
			$name = '';
			if(!empty($instance['ad_name_'.$i])){
				$name = ' <span>'.$instance['ad_name_'.$i].'</span>';
			}
			if(!empty($instance['ad_url_'.$i])){
				$domain = parse_url(strtolower($instance['ad_url_'.$i]));
				if($domain['host']=='www.youtube.com' || $domain['host']=='youtube.com'){
					$href = 'http://www.youtube.com/embed/'.get_youtube_id($instance['ad_url_'.$i]).'?showinfo=0&amp;autoplay=1';
					$target .= ' class="iframe"';
				}else{
					$href = $instance['ad_url_'.$i];
				}
				$html .= empty($instance['ad_img_1']) ? '' : '<li'.$class_li.'><a href="'.$href.'"'.$target.'><img src="'.$instance['ad_img_'.$i].'" alt="'.$instance['ad_name_'.$i].'" />'.$name.'</a></li>';
			}else{
				$html .= empty($instance['ad_img_1']) ? '' : '<li'.$class_li.'><img src="'.$instance['ad_img_'.$i].'" alt="'.$instance['ad_name_'.$i].'" />'.$name.'</li>';
			}
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

	function is_cyon_widget_context() {
		if ( isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],$this->id_base) !== false ) {
			return true;
		} elseif ( isset($_REQUEST['_wp_http_referer']) && strpos($_REQUEST['_wp_http_referer'],$this->id_base) !== false ) {
			return true;
		} elseif ( isset($_REQUEST['widget_id']) && strpos($_REQUEST['widget_id'],$this->id_base) !== false ) {
			return true;
		}
		return false;
	}
	
	function image_send_to_editor( $html, $id, $caption, $title, $align, $url, $size, $alt = '' ) {
		if ( $this->is_cyon_widget_context() ) {
			if ($alt=='') $alt = $title;
			?>
			<script type="text/javascript">
				// send image variables back to opener
				var win = window.dialogArguments || opener || parent || top;
				win.cyon_ad_html = '<?php echo addslashes($html); ?>';
				win.cyon_ad_img_id = '<?php echo $id; ?>';
				win.cyon_ad_alt = '<?php echo addslashes($alt); ?>';
				win.cyon_ad_caption = '<?php echo addslashes($caption); ?>';
				win.cyon_ad_title = '<?php echo addslashes($title); ?>';
				win.cyon_ad_align = '<?php echo esc_attr($align); ?>';
				win.cyon_ad_url = '<?php echo esc_url($url); ?>';
				win.cyon_ad_size = '<?php echo esc_attr($size); ?>';
			</script>
			<?php
		}
		return $html;
	}

	function replace_text_in_thickbox($translated_text, $source_text, $domain) {
		if ('Insert into Post' == $source_text) {
			return __('Insert Into Widget', 'cyon' );
		}
		return $translated_text;
	}

	function media_upload_tabs($tabs) {
		if ( $this->is_cyon_widget_context() ) {
			unset($tabs['type_url']);
		}
		return $tabs;
	}

	function https_cleanup( $imageurl = '' ) {
		if( isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ) {
			$imageurl = str_replace('http://', 'https://', $imageurl);
		} else {
			$imageurl = str_replace('https://', 'http://', $imageurl);
		}
		return $imageurl;
	}
}

// Adding your widget to WordPress
add_action( 'widgets_init', create_function('', 'return register_widget("CyonAdsWidget");') );

if (!function_exists('get_youtube_id')){
	function get_youtube_id($content) {
	
		// find the youtube-based URL in the post
		$urls = array();
		preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $urls);
		$youtube_url = $urls[0][0];
	
		// next, locate the youtube video id
		$youtube_id = '';
		if(strlen(trim($youtube_url)) > 0) {
			parse_str( parse_url( $youtube_url, PHP_URL_QUERY ) );
			$youtube_id = $v;
		} // end if
	
		return $youtube_id; 
	
	} // end get_youtube_id
}
