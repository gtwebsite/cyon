<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}


/* JS callback */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
	var checkbgoption = function() {
		var bgvalue = jQuery('#section-backgroundoptions select').val();
		if(bgvalue=='presets'){
			jQuery('#section-backgroundpreset').show();
			jQuery('#section-backgroundcustom').fadeOut();
		}else if(bgvalue=='custom'){
			jQuery('#section-backgroundpreset').fadeOut();
			jQuery('#section-backgroundcustom').show();
		}
	}

	jQuery(document).ready(checkbgoption);
	jQuery('#section-backgroundoptions select').change(checkbgoption);
	

	var checkstaticblock = function() {
		var svalue = jQuery('#section-homepage_middle input[type=radio]:checked').val();
		if(svalue=='staticblock'){
			jQuery('#section-homepage_middle_block').show();
		}else{
			jQuery('#section-homepage_middle_block').fadeOut();
		}
	}
	
	jQuery(document).ready(checkstaticblock);
	jQuery('#section-homepage_middle input[type=radio]').click(checkstaticblock);


	var checkslidershowcaption = function() {
		var scvalue = jQuery('#section-homepage_slider_caption input[type=radio]:checked').val();
		if(scvalue=='1'){
			jQuery('#section-homepage_slider_caption_layout').show();
			jQuery('#section-homepage_slider_caption_width').show();
		}else{
			jQuery('#section-homepage_slider_caption_layout').fadeOut();
			jQuery('#section-homepage_slider_caption_width').fadeOut();
		}
	}
	
	jQuery(document).ready(checkslidershowcaption);
	jQuery('#section-homepage_slider_caption input[type=radio]').click(checkslidershowcaption);

	var checkslidershowpaginate = function() {
		var spvalue = jQuery('#section-homepage_slider_pagination input[type=radio]:checked').val();
		if(spvalue=='1'){
			jQuery('#section-homepage_slider_pagination_layout').show();
		}else{
			jQuery('#section-homepage_slider_pagination_layout').fadeOut();
		}
	}
	
	jQuery(document).ready(checkslidershowpaginate);
	jQuery('#section-homepage_slider_pagination input[type=radio]').click(checkslidershowpaginate);

	
	var sampletext = '<p class="sampletext" style="clear:both; font-size:18px; padding:5px; background:#fff; margin:0 0 10px 0;">Grumpy wizards make toxic brew for the evil Queen and Jack.</p>';
	jQuery('#section-secondary_font_google').append(sampletext)
	
	var checkprimaryfont = function() {
		var pfvalue = jQuery('#section-primary_font option:selected').val();
		if(pfvalue=='google'){
			jQuery('#section-primary_font_google').show();
		}else{
			jQuery('#section-primary_font_google').fadeOut();
		}
	}

	jQuery(document).ready(checkprimaryfont);
	jQuery('#section-primary_font select').change(checkprimaryfont);

	jQuery('#section-primary_font_google').append(sampletext)

	var checksecondaryfont = function() {
		var pfvalue = jQuery('#section-secondary_font option:selected').val();
		if(pfvalue=='google'){
			jQuery('#section-secondary_font_google').show();
		}else{
			jQuery('#section-secondary_font_google').fadeOut();
		}
	}

	jQuery(document).ready(checksecondaryfont);
	jQuery('#section-secondary_font select').change(checksecondaryfont);

	jQuery('.googlefont').each(function(index){
		jQuery('head').append('<link href="http://fonts.googleapis.com/css?family=' + jQuery(this).find('input').val() +'" rel="stylesheet" class="font'+ index +'" type="text/css" />');
		jQuery(this).find('.sampletext').css('font-family',jQuery(this).find('input').val());
		jQuery(this).find('input').change(function(){
			jQuery(this).parent().parent().parent().find('.sampletext').css('font-family',jQuery(this).val());
			jQuery('head').find('link.font'+index).attr('href','http://fonts.googleapis.com/css?family=' + jQuery(this).val());
		});
	});

	var checkbackgroundstyle = function() {
		var bsvalue = jQuery('#section-background_style option:selected').val();
		if(bsvalue=='full'){
			jQuery('#section-background_style_youtube').fadeOut();
			jQuery('#section-background_style_image').show();
			jQuery('#section-background_style_pattern_repeat').fadeOut();
			jQuery('#section-background_style_pattern_position').fadeOut();
			jQuery('#section-background_style_image').append('<div id="addition"><input type="button" class="button" value="Add image" /></div>');
		}else if(bsvalue=='youtube'){
			jQuery('#section-background_style_youtube').show();
			jQuery('#section-background_style_image').fadeOut();
			jQuery('#section-background_style_pattern_repeat').fadeOut();
			jQuery('#section-background_style_pattern_position').fadeOut();
			jQuery('#addition').remove();
		}else{
			jQuery('#section-background_style_youtube').fadeOut();
			jQuery('#section-background_style_image').show();
			jQuery('#section-background_style_pattern_repeat').show();
			jQuery('#section-background_style_pattern_position').show();
			jQuery('#addition').remove();
		}
	}

	jQuery(document).ready(checkbackgroundstyle);
	jQuery('#section-background_style select').change(checkbackgroundstyle);

	var checkbanner = function() {
		var bavalue = jQuery('#section-homepage_slider input[type=radio]:checked').val();
		if(bavalue=='singleimage'){
			jQuery('#section-homepage_slider_image_file').show();
			jQuery('#section-homepage_slider_image_url').show();
			jQuery('#section-homepage_slider_animation').fadeOut();
			jQuery('#section-homepage_slider_caption').fadeOut();
			jQuery('#section-homepage_slider_caption_layout').fadeOut();
			jQuery('#section-homepage_slider_caption_width').fadeOut();
			jQuery('#section-homepage_slider_arrows').fadeOut();
			jQuery('#section-homepage_slider_pagination').fadeOut();
			jQuery('#section-homepage_slider_pagination_layout').fadeOut();
		}else if(bavalue=='flexslider'){
			jQuery('#section-homepage_slider_image_file').fadeOut();
			jQuery('#section-homepage_slider_image_url').fadeOut();
			jQuery('#section-homepage_slider_animation').show();
			jQuery('#section-homepage_slider_caption').show();
			jQuery('#section-homepage_slider_caption_layout').show();
			jQuery('#section-homepage_slider_caption_width').show();
			jQuery('#section-homepage_slider_arrows').show();
			jQuery('#section-homepage_slider_pagination').show();
			jQuery('#section-homepage_slider_pagination_layout').show();
		}else{
			jQuery('#section-homepage_slider_image_file').fadeOut();
			jQuery('#section-homepage_slider_image_url').fadeOut();
			jQuery('#section-homepage_slider_animation').fadeOut();
			jQuery('#section-homepage_slider_caption').fadeOut();
			jQuery('#section-homepage_slider_caption_layout').fadeOut();
			jQuery('#section-homepage_slider_caption_width').fadeOut();
			jQuery('#section-homepage_slider_arrows').fadeOut();
			jQuery('#section-homepage_slider_pagination').fadeOut();
			jQuery('#section-homepage_slider_pagination_layout').fadeOut();
		}
	}

	jQuery(document).ready(checkbanner);
	jQuery('#section-homepage_slider input[type=radio]').each(function(){
		jQuery(this).click(checkbanner);
	});
	
	jQuery('#section-socialmedia input[type=checkbox]:checked').each(function(){
		jQuery(this).parent('span').parent('.item').addClass('selected');
	});
	
	jQuery('#section-socialmedia input[type=checkbox]').each(function(){
		jQuery(this).click(function() {
			if(jQuery(this).is(':checked')){
				jQuery(this).parent('span').parent('.item').find('input[type=text]').show();
				jQuery(this).parent('span').parent('.item').addClass('selected');
			}else{
				jQuery(this).parent('span').parent('.item').find('input[type=text]').fadeOut();
				jQuery(this).parent('span').parent('.item').removeClass('selected');
			}
		});
	});

});
</script>
 
<?php
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Social Share Pages
	$socialshare_array = array('posts' => __( 'Blog Posts' ), 'listings' => __( 'Blog Listings' ), 'pages' => __( 'Pages' ));
	
	// Social Share Pages Defaults
	$socialshare_defaults = array('posts' => '1');

	// Social Boxes
	$socialshareboxes_array = array('facebook' => __( 'Facebook' ), 'twitter' => __( 'Twitter' ), 'plus' => __( 'Google+' ), 'pinterest' => __( 'Pinterest' ), 'mail' => __( 'Email' ), 'sharethis' => __( 'ShareThis' ));
	
	// Social Boxes Defaults
	$socialshareboxes_defaults = array('facebook' => '1','twitter' => '1','plus' => '1');

	// Homepage Sliders (codaslider, nivoslider)
	$sliders_array =  array('default' => __( 'Use Page\'s Default' ),'flexslider' => 'Flexslider','singleimage' => __( 'Single Image' ));
	
	// Homepage Middle
	$homepage_middle =  array('staticblock' => __( 'Static Block' ),'twitter' => __( 'Twitter Updates' ));

	// Color Themes
	$color_theme =  array('light' => __( 'Light' ),'dark' => __( 'Dark' ));
	
	// Custom Fonts
	$custom_fonts = array('default'=>__('Default'),'google'=>'Google Fonts','Arial'=>'Arial','Tahoma'=>'Tahoma','Verdana'=>'Verdana','Helvetica'=>'Helvetica','"Lucida Grande", "Lucida Sans Unicode"'=>'Lucida Grande','Trebuchet MS'=>'Trebuchet MS','Myriad Pro'=>'Myriad Pro','Georgia'=>'Georgia','"Times New Roman"'=>'Times New Roman');

	// Background Option
	$background_options = array('presets' => __( 'Presets' ), 'custom' => __( 'Custom' ));

	// Background
	$background_defaults = array('color' => '#555555', 'image' => '', 'repeat' => 'no-repeat','position' => 'top center','attachment'=>'scroll');

	// Lightbox
	$lightbox_gallery_style = array('none' => __( 'None' ), 'buttons' => __( 'Buttons' ), 'thumbnails' => __( 'Thumbnails' ));

	// Widget locations
	$widget_locations = array(
		'' => __('- None -'),
		'cyon_before_header' => __('Header Before'),
		'cyon_header' => __('Header'),
		'cyon_before_body' => __('Body Before'),
		'cyon_after_body' => __('Body After'),
		'cyon_before_body_wrapper' => __('Body Wrapper Before'),
		'cyon_after_body_wrapper' => __('Body Wrapper After'),
		'cyon_primary_before' => __('Primary Content Before'),
		'cyon_primary_after' => __('Primary Content After'),
		'cyon_sidebar_before' => __('Sidebar Before'),
		'cyon_sidebar_after' => __('Sidebar After'),
		'cyon_post_header_before' => __('Post Header Before'),
		'cyon_post_header_after' => __('Post Header After'),
		'cyon_post_content_before' => __('Post Content Before'),
		'cyon_post_content_after' => __('Post Content After'),
		'cyon_post_footer' => __('Post Footer'),
		'cyon_home_content' => __('Homepage Content'),
		'cyon_footer' => __('Footer'),
		'cyon_after_footer' => __('Footer After')
	);

	// Menu Options
	/*
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	$menuitems = array('0' => 'Use Default - Show Published Pages');
	foreach ( $menus as $menu ) {
		$menuitems[$menu->term_id] = $menu->name;
	}
	$menu_array = $menuitems;
	*/
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  CYON_DIRECTORY . '/assets/images/';
		
	$options = array();
		
	$options[] = array( 'name'		=> __( 'Styling' ),
						'type' 		=> 'heading');

	$options[] = array( 'name' 		=> __( 'Logo and Icons' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name'		=> __( 'Logo File' ),
						'id' 		=> 'header_logo',
						'std' 		=> '',
						'desc'		=> __('This will replace the website name text and use the image instead. Also replace the admin logo.'),
						'type' 		=> 'upload');

	$options[] = array( 'name'		=> __( 'Favicon File' ),
						'id' 		=> 'favicon',
						'std' 		=> '',
						'desc'		=> __('Use 16 x 16 size of ico file.'),
						'type' 		=> 'upload');

	$options[] = array( 'name'		=> __( 'iOS Icon File' ),
						'id' 		=> 'iosicon',
						'std' 		=> '',
						'desc'		=> __('Minimum is 57 x 57 at 72dpi of png file. For retina display, maximum is 114 x 114.'),
						'type' 		=> 'upload');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Theme Selection' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Color'),
						'desc' 		=> '',
						'id' 		=> 'theme_color',
						'std'		=> 'light',
						'type' 		=> 'select',
						'options' 	=> array('light'=>__('Light'), 'dark'=>__('Dark')));			

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Typography' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Primary Font'),
						'desc' 		=> __('Font use to the whole site'),
						'id' 		=> 'primary_font',
						'std'		=> 'default',
						'type' 		=> 'select',
						'options' 	=> $custom_fonts);			

	$options[] = array( 'name'		=> __( 'Google Font as Primary' ),
						'id' 		=> 'primary_font_google',
						'desc'		=> __('Fill only the name of the font from <a href="http://www.google.com/webfonts" target="_blank">http://www.google.com/webfonts</a>'),
						'std' 		=> 'Droid Sans',
						'class'		=> 'hidden googlefont',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __('Secondary Font'),
						'desc' 		=> __('Font use for Headers'),
						'id' 		=> 'secondary_font',
						'std'		=> 'default',
						'type' 		=> 'select',
						'options' 	=> $custom_fonts);			

	$options[] = array( 'name'		=> __( 'Google Font as Secondary' ),
						'id' 		=> 'secondary_font_google',
						'desc'		=> __('Fill only the name of the font from <a href="http://www.google.com/webfonts" target="_blank">http://www.google.com/webfonts</a>'),
						'std' 		=> 'Droid Sans',
						'class'		=> 'hidden googlefont',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Background' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Style'),
						'desc' 		=> '',
						'id' 		=> 'background_style',
						'std'		=> 'default',
						'type' 		=> 'select',
						'options' 	=> array('pattern'=>__('Pattern'), 'full'=>__('Full Screen Image'), 'youtube'=>__('Youtube Video')));			

	$options[] = array( 'name'		=> __('Color'),
						'desc'		=> '',
						'id' 		=> 'background_color',
						'std' 		=> '#ffffff',
						'type' 		=> 'color');

	$options[] = array( 'name'		=> __( 'Image File' ),
						'id' 		=> 'background_style_image',
						'std' 		=> '',
						'desc'		=> '',
						'type' 		=> 'upload');

	$options[] = array( 'name' 		=> __('Repeat'),
						'desc' 		=> '',
						'id' 		=> 'background_style_pattern_repeat',
						'class'		=> 'hidden',
						'std'		=> 'repeat',
						'type' 		=> 'select',
						'options' 	=> array('repeat'=>__('Repeat'), 'no-repeat'=>__('No Repeat'), 'repeat-x'=>__('Repeat Horizontally'), 'repeat-y'=>__('Repeat Vertically')));			

	$options[] = array( 'name' 		=> __('Position'),
						'desc' 		=> __( 'This is horizontal-vertical and can also use top, left, center, bottom, right' ),
						'id' 		=> 'background_style_pattern_position',
						'class'		=> 'hidden',
						'std'		=> '50% 0',
						'type' 		=> 'text');			

	$options[] = array( 'name' 		=> __('Youtube ID'),
						'desc' 		=> __( 'This doesnt work on mobile phones or iPad' ),
						'id' 		=> 'background_style_youtube',
						'class'		=> 'hidden',
						'std'		=> '_VKW_M_uVjw',
						'type' 		=> 'text');			

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Layout' ),
						'type' 		=> 'heading');

	$options[] = array( 'name' 		=> __( 'General Layout' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' => __( 'Default layout of the website' ),
						'desc' => '',
						'id' => 'general_layout',
						'std' => 'general-2right',
						'type' => 'images',
						'options' => array(
							'general-1column' => $imagepath . '1col.gif',
							'general-2left' => $imagepath . '2col-left.gif',
							'general-2right' => $imagepath . '2col-right.gif')
						);

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Header' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Top Left Content' ),
						'id' 		=> 'top_left_content',
						'std' 		=> '',
						'desc'		=> __('This will show at the very top of the page on the left side corner.'),
						'type' 		=> 'texthtml'); 

	$options[] = array( 'name' 		=> __( 'Top Right Content' ),
						'id' 		=> 'top_right_content',
						'std' 		=> '',
						'desc'		=> __('This will show at the very top of the page on the right side corner.'),
						'type' 		=> 'texthtml'); 

	$options[] = array( 'name' => __( 'Logo/Menu Layout' ),
						'desc' => '',
						'id' => 'header_layout',
						'std' => 'logo-left',
						'type' => 'images',
						'options' => array(
							'logo-left' => $imagepath . 'logo-left.gif',
							'logo-center' => $imagepath . 'logo-center.gif',
							'logo-right' => $imagepath . 'logo-right.gif',
							'logo-left-menu' => $imagepath . 'logo-left-menu.gif',
							'logo-right-menu' => $imagepath . 'logo-right-menu.gif')
						);

	$options[] = array( 'name' 		=> __( 'Breadcrumbs' ),
						'desc' 		=> __( 'Yes, use breadcrumbs on inner pages. If you are runnig Woocommerce, this will be ignored.' ),
						'id' 		=> 'breadcrumbs',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Content' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Display author'),
						'desc' 		=> '',
						'id' 		=> 'content_author',
						'std'		=> 'disable',
						'type' 		=> 'radio',
						'options' 	=> array('disable'=>__('Disable'), 'enable'=>__('Enable')));			

	$options[] = array( 'name' 		=> __('Commenting to all Post/Page'),
						'desc' 		=> '',
						'id' 		=> 'content_comment',
						'std'		=> 'disable',
						'type' 		=> 'radio',
						'options' 	=> array('disable'=>__('Disable'), 'enable'=>__('Enable')));			

	$options[] = array( 'name' 		=> __('Featured image display'),
						'desc' 		=> '',
						'id' 		=> 'content_featured_image',
						'std' 		=> $socialshare_defaults, // These items get checked by default
						'type' 		=> 'multicheck',
						'options' 	=> $socialshare_array);

	$options[] = array( 'name' 		=> __( 'Gallery' ),
						'desc' 		=> __( 'Allow to override default WP Gallery' ),
						'id' 		=> 'content_gallery',
						'std'		=> 'default',
						'type' 		=> 'radio',
						'options' 	=> array('default'=>__('Use default'), 'slider_only'=>__('Slider only'), 'slider_carousel'=>__('Slider with carousel')));			

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Blog List Display' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Content display'),
						'desc' 		=> '',
						'id' 		=> 'content_blog_post',
						'std'		=> 'excerpt',
						'type' 		=> 'radio',
						'options' 	=> array('excerpt'=>__('Excerpt only'), 'full'=>__('Full content')));			

	$options[] = array( 'name' 		=> __( 'List layout' ),
						'desc' 		=> __(''),
						'id' 		=> 'blog_list_layout',
						'std' 		=> 'list-1column',
						'type' 		=> 'images',
						'options' => array(
							'list-1column' => $imagepath . 'bucket-1col.gif',
							'list-2columns' => $imagepath . 'bucket-2col.gif',
							'list-3columns' => $imagepath . 'bucket-3col.gif',
							'list-4columns' => $imagepath . 'bucket-4col.gif')
						);

	$options[] = array( 'name' 		=> __('Thumbnail size'),
						'desc' 		=> '',
						'id' 		=> 'content_thumbnail_size',
						'std'		=> 'large',
						'type' 		=> 'radio',
						'options' 	=> array('small'=>__('Small'), 'medium'=>__('Medium'), 'large'=>__('Large'), 'full'=>__('Full')));			

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Footer' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Footer Columns' ),
						'desc' 		=> __('Shows number of footer columns to be used. Check the <a href="'. get_bloginfo('wpurl') .'/wp-admin/widgets.php">widget area</a> and look for the Footer Buckets section'),
						'id' 		=> 'footer_bucket_layout',
						'std' 		=> 'bucket-4columns',
						'type' 		=> 'images',
						'options' => array(
							'bucket-1column' => $imagepath . 'bucket-1col.gif',
							'bucket-2columns' => $imagepath . 'bucket-2col.gif',
							'bucket-3columns' => $imagepath . 'bucket-3col.gif',
							'bucket-4columns' => $imagepath . 'bucket-4col.gif')
						);

	$options[] = array( 'name' 		=> __( 'Copyright' ),
						'id' 		=> 'footer_copyright',
						'std' 		=> __('&copy; '. date('Y') .' MyCompany.com. All Rights Reserved.'),
						'type' 		=> 'texthtml'); 

	$options[] = array( 'name' 		=> __( 'Sub Footer' ),
						'id' 		=> 'footer_sub',
						'desc'		=> __('This will show at the very bottom of the page.'),
						'std' 		=> '',
						'type' 		=> 'texthtml'); 

	$options[] = array( 'name' 		=> __( 'Back to Top Button' ),

						'desc' 		=> __( 'Shows back to top button in all pages' ),
						'id' 		=> 'footer_backtotop',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Homepage' ),
						'type' 		=> 'heading');

	$options[] = array( 'name' 		=> __( 'Layout' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' => __( 'Default layout of Homepage' ),
						'desc' => __('This will override the default layout'),
						'id' => 'homepage_layout',
						'std' => 'general-1column',
						'type' => 'images',
						'options' => array(
							'general-1column' => $imagepath . '1col.gif',
							'general-2left' => $imagepath . '2col-left.gif',
							'general-2right' => $imagepath . '2col-right.gif')
						);

	$options[] = array( 'name' 		=> __( 'Show Page Content' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_page_content',
						'std' 		=> '0',
						'type' 		=> 'radio',
						'options' 	=> array('1'=>'Yes', '0'=>'No'));

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Middle Buckets' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' => __( 'Number of Columns' ),
						'desc' => __('Shows number of bucket columns to be used. Check the <a href="'. get_bloginfo('wpurl') .'/wp-admin/widgets.php">widget area</a> and look for the Homepage Buckets section'),
						'id' => 'homepage_bucket_layout',
						'std' => 'bucket-3columns',
						'type' => 'images',
						'options' => array(
							'bucket-1column' => $imagepath . 'bucket-1col.gif',
							'bucket-2columns' => $imagepath . 'bucket-2col.gif',
							'bucket-3columns' => $imagepath . 'bucket-3col.gif',
							'bucket-4columns' => $imagepath . 'bucket-4col.gif')
						);

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Slider' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Type of Slider to be used' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider',
						'std' 		=> 'default',
						'type' 		=> 'radio',
						'options' 	=> $sliders_array);

	$options[] = array( 'name'		=> __( 'Single Image File' ),
						'id' 		=> 'homepage_slider_image_file',
						'std' 		=> '',
						'class'		=> 'hidden',
						'type' 		=> 'upload');

	$options[] = array( 'name'		=> __( 'Single Image URL when clicked' ),
						'id' 		=> 'homepage_slider_image_url',
						'desc'		=> __('Leave empty if not applicable.'),
						'std' 		=> '',
						'class'		=> 'hidden',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Animation Style' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_animation',
						'std' 		=> '0',
						'type' 		=> 'radio',
						'class'		=> 'hidden',
						'options' 	=> array('0'=>'Fade', '1'=>'Slide Horizontal', '2'=>'Slide Vertical'));

	$options[] = array( 'name' 		=> __( 'Show caption' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_caption',
						'std' 		=> '1',
						'type' 		=> 'radio',
						'class'		=> 'hidden',
						'options' 	=> array('1'=>'Yes', '0'=>'No'));

	$options[] = array( 'name' 		=> __( 'Caption Layout' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_caption_layout',
						'std' 		=> 'bottom-left',
						'type' 		=> 'select',
						'options' 	=> array('top-left'=>'Top Left', 'top-right'=>'Top Right', 'bottom-left'=>'Bottom Left', 'bottom-right'=>'Bottom Right'));

	$options[] = array( 'name' 		=> __( 'Caption Width' ),
						'desc' 		=> 'Use percentage',
						'id' 		=> 'homepage_slider_caption_width',
						'std' 		=> '100%',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Show navigation arrow' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_arrows',
						'std' 		=> '1',
						'type' 		=> 'radio',
						'class'		=> 'hidden',
						'options' 	=> array('1'=>'Yes', '0'=>'No'));

	$options[] = array( 'name' 		=> __( 'Show pagination' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_pagination',
						'std' 		=> '1',
						'type' 		=> 'radio',
						'class'		=> 'hidden',
						'options' 	=> array('1'=>'Yes', '0'=>'No'));

	$options[] = array( 'name' 		=> __( 'Pagination Layout' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_pagination_layout',
						'std' 		=> 'top-right',
						'type' 		=> 'select',
						'options' 	=> array('top-left'=>'Top Left', 'top-right'=>'Top Right', 'bottom-left'=>'Bottom Left', 'bottom-right'=>'Bottom Right'));

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Middle Content' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Content' ),
						'id' 		=> 'homepage_middle',
						'desc' 		=> __('This will show above the middle buckets.'),
						'std'		=> 'staticblock',
						'type'		=> 'radio',
						'options'	=> $homepage_middle);
						
	$options[] = array( 'name' 		=> __( 'Static Block' ),
						'id' 		=> 'homepage_middle_block',
						'std' 		=> '',
						'class'		=> 'hidden',
						'type' 		=> 'texthtml'); 

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Widgets' ),
						'type' 		=> 'heading');

	$options[] = array( 'name' 		=> __( 'Widget 1' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Name' ),
						'desc' 		=> 'ID: cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_1_name'))),
						'id' 		=> 'widget_1_name',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Description' ),
						'desc' 		=> '',
						'id' 		=> 'widget_1_description',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Location' ),
						'desc' 		=> '',
						'id' 		=> 'widget_1_location',
						'std' 		=> '',
						'type' 		=> 'select',
						'options' 	=> $widget_locations);

	$options[] = array( 'name' 		=> __( 'Order Number' ),
						'desc' 		=> '',
						'id' 		=> 'widget_1_order',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Widget 2' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Name' ),
						'desc' 		=> 'ID: cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_2_name'))),
						'id' 		=> 'widget_2_name',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Description' ),
						'desc' 		=> '',
						'id' 		=> 'widget_2_description',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Location' ),
						'desc' 		=> '',
						'id' 		=> 'widget_2_location',
						'std' 		=> '',
						'type' 		=> 'select',
						'options' 	=> $widget_locations);

	$options[] = array( 'name' 		=> __( 'Order Number' ),
						'desc' 		=> '',
						'id' 		=> 'widget_2_order',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Widget 3' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Name' ),
						'desc' 		=> 'ID: cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_3_name'))),
						'id' 		=> 'widget_3_name',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Description' ),
						'desc' 		=> '',
						'id' 		=> 'widget_3_description',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Location' ),
						'desc' 		=> '',
						'id' 		=> 'widget_3_location',
						'std' 		=> '',
						'type' 		=> 'select',
						'options' 	=> $widget_locations);

	$options[] = array( 'name' 		=> __( 'Order Number' ),
						'desc' 		=> '',
						'id' 		=> 'widget_3_order',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Configuration' ),
						'type' 		=> 'heading');
						
	$options[] = array( 'name' 		=> __( 'Social Settings' ),
						'type' 		=> 'section_start');
						
	$options[] = array( 'name'		=> __( 'Pages to appear the social boxes' ),
						'desc'		=> __( '' ),
						'id' 		=> 'socialshare',
						'std' 		=> $socialshare_defaults, // These items get checked by default
						'type' 		=> 'multicheck',
						'options' 	=> $socialshare_array);

	$options[] = array( 'name'		=> __( 'Social Boxes' ),
						'desc'		=> __( '' ),
						'id' 		=> 'socialshareboxes',
						'std' 		=> $socialshareboxes_defaults,
						'type' 		=> 'multicheck',
						'options' 	=> $socialshareboxes_array);

	$options[] = array( 'name'		=> __( 'Twitter ID' ),
						'id' 		=> 'social_twitter',
						'desc'		=> __(''),
						'std' 		=> 'twitter',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'SEO' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Activate SEO' ),
						'desc' 		=> __( 'Activates SEO options to all pages and posts.' ),
						'id' 		=> 'seo_activate',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'name'		=> __( 'Page Title Format' ),
						'id' 		=> 'seo_title_format',
						'desc' 		=> __('Accepts').': {PAGETITLE}, {BLOGTITLE}, {BLOGTAGLINE}',
						'std' 		=> '{PAGETITLE} | {BLOGTITLE}',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Lightbox' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Activate Lightbox' ),
						'desc' 		=> __( 'Activates lightbox in all linked to images, this includes WP Gallery. Supports jpg, png, gif, and bmp.' ),
						'id' 		=> 'lightbox_activate',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'name' 		=> __( 'Gallery Style' ),
						'id' 		=> 'lightbox_gallery_style',
						'desc' 		=> '',
						'std'		=> 'none',
						'type'		=> 'radio',
						'options'	=> $lightbox_gallery_style);

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Scripts Support' ),
						'type' 		=> 'section_start');
						
	$options[] = array( 'name' 		=> __( 'Responsiveness' ),
						'desc' 		=> __( 'Allow special styles mobile devices' ),
						'id' 		=> 'responsive',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'name' 		=> __( 'LazyLoad' ),
						'desc' 		=> __( 'Activates LazyLoad in all images' ),
						'id' 		=> 'lazyload',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'name' 		=> __( 'Header Scripts' ),
						'desc' 		=> __( 'Scripts and Links placed inside the head tag. Can include &lt;script&gt;, &lt;link&gt; and other tags. Can have Google Analytics here. ' ),
						'id' 		=> 'header_scripts',
						'std' 		=> '',
						'type' 		=> 'texthtml');

	$options[] = array( 'name' 		=> __( 'Footer Scripts' ),
						'desc' 		=> __( 'Scripts placed below the footer just before the end body tag. Can include &lt;script&gt;, &lt;link&gt; and other tags. ' ),
						'id' 		=> 'footer_scripts',
						'std' 		=> '',
						'type' 		=> 'texthtml');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Admin' ),
						'type' 		=> 'heading');
						
	$options[] = array( 'name' 		=> __( 'Login' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name'		=> __('Background Color'),
						'desc'		=> '',
						'id' 		=> 'admin_login_bgcolor',
						'std' 		=> '#fbfbfb',
						'type' 		=> 'color');
						
	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Updates' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Remove Core Updates' ),
						'desc' 		=> __( 'Yes, remove updates and notification' ),
						'id' 		=> 'admin_core_updates',
						'std' 		=> '',
						'type' 		=> 'checkbox');
						
	$options[] = array( 'name' 		=> __( 'Remove Plugin Updates' ),
						'desc' 		=> __( 'Yes, remove updates and notification' ),
						'id' 		=> 'admin_plugin_updates',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'type'		=> 'section_end'); 

	return $options;
}