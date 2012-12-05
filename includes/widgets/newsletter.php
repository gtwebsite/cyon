<?php

class CyonNewsletterWidget extends WP_Widget {

	protected $nonce;
	protected $emailto;

	// Creating your widget
	function CyonNewsletterWidget(){
		$widget_ops = array('classname' => 'cyon-newsletter', 'description' => __('Displays Newsletter Form') );
		$this->WP_Widget('CyonNewsletterWidget', __('Cyon Newsletter'), $widget_ops);
	}
 
 	// Widget form in WP Admin
	function form($instance){
		// Start adding your fields here
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> __('Newsletter Signup'),
			'email'			=> get_bloginfo('admin_email')
		) );
		$title = $instance['title'];
		$showname = $instance['showname'];
		$email = $instance['email'];

		?>
		  <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title') ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		  <p><label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email') ?>: <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo attribute_escape($email); ?>" /></label></p>
		  <p><input type="checkbox" name="<?php echo $this->get_field_name('showname'); ?>" id="<?php echo $this->get_field_id('showname'); ?>" value="1" <?php echo ($showname == "true" ? "checked='checked'" : ""); ?> /> <label for="<?php echo $this->get_field_id('showname'); ?>"><?php _e('Show Name') ?></label></p>
		<?php
	}

	// Saving your widget form
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		// Override new values of each fields
		$instance['title'] = $new_instance['title'];
		$instance['email'] = $new_instance['email'];
		$instance['showname'] = (bool)$new_instance['showname'];
		return $instance;
	}

	// Displays your widget on the front-end
	function widget($args, $instance){
		extract($args, EXTR_SKIP);
		
		// Start widget
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$this->emailto = $instance['email'];
		$showname = $instance['showname'];
		$this->nonce = wp_create_nonce('cyon_newsletter_nonce');
		
		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		echo '<form action="" method="post" class="widget-content">';
		
    	// Widget code here
		echo '<fieldset><div class="box"></div><input type="hidden" class="nonce" name="nonce" value="'.$this->nonce.'" /><input type="hidden" class="emailto" name="emailto" value="'.$this->emailto.'" />';
		if($showname=='true'){
		echo '<p><label for="newsletter_name">'.__('Name').':</label> <input type="text" id="newsletter_name" name="name" placeholder="'.__('Name').'" /></p>';
		}
		echo '<p><label for="newsletter_email">'.__('Email').':</label> <input type="email" id="newsletter_email" name="email" placeholder="'.__('Email').'" /></p>';
		echo '<button type="submit" name="newsletter_submit">'.__('Submit').'</button>';
		echo '</fieldset>';
 
		// End widget
		echo '</form>';
		echo $after_widget;
		add_action('wp_footer', array(&$this, 'cyon_newsletter_ajax'));
	}
	
	/* Ajax */
	function cyon_newsletter_ajax(){ ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.cyon-newsletter form').each(function(){
					jQuery(this).submit(function(){
						if(jQuery(this).find('input[type=email]').val()=='') {
							jQuery(this).find('.box').addClass('box-red').removeClass('box-green').text('<?php _e('Please enter your email address.'); ?>');
							jQuery(this).find('input[type=email]').addClass('error');
							return false;
						} else {
							var emailto = jQuery(this).find('input.emailto').val();
							var name = jQuery(this).find('input[type=text]').val();
							var email = jQuery(this).find('input[type=email]').val();
							var nonce = jQuery(this).find('input.nonce').val();
							if(email.indexOf("@") == -1 || email.indexOf(".") == -1) {
								jQuery(this).find('.box').addClass('box-red').removeClass('box-green').text('<?php _e('Please enter a valid email address.'); ?>');
								jQuery(this).find('input[type=email]').addClass('error');
								return false;
							} else {
								var data = {
									action: 'cyon_newsletter_action',
									emailto: emailto,
									nonce: nonce,
									name: name,
									email: email
								};
								jQuery(this).find('button').hide();
								jQuery(this).addClass('form-sending');
								jQuery.ajax({
									url		: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
									type	: 'POST',
									data	: data,
									success	: function( results ) {
										jQuery('.cyon-newsletter form').removeClass('form-sending');
										jQuery('.cyon-newsletter button').show();
										jQuery('.cyon-newsletter .box').removeClass('box-red').addClass('box-green').text(results);
										jQuery('.cyon-newsletter input[type=email]').removeClass('error');
									}
			
								});
								return false;
							}
						} 
					});
				});
			});
		</script>
	<?php }
}

// Adding your widget to WordPress
add_action( 'widgets_init', create_function('', 'return register_widget("CyonNewsletterWidget");') );

// Sending email
add_action('wp_ajax_cyon_newsletter_action', 'cyon_newsletter_email');
add_action('wp_ajax_nopriv_cyon_newsletter_action', 'cyon_newsletter_email');
function cyon_newsletter_email() {
	if (! wp_verify_nonce($_REQUEST['nonce'], 'cyon_newsletter_nonce') ) die(__('Security check')); 
	if(isset($_REQUEST['nonce']) && isset($_REQUEST['email'])) {
		$subject = __('New subscriber from').' '.get_bloginfo('name');
		$body = __('Name').': '.$_REQUEST['email'];
		$body .= __('Email').': '.$_REQUEST['email'];
		$success = mail($_REQUEST['emailto'], $subject, $body);
		if(!empty($success)) {
			echo __('Your email is subscribed to our mailing list.');
		} else {
			echo __('There was a problem. Please try again.');
		}
	}
	die();
}

