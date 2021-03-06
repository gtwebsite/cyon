<?php
if ( !defined('ABSPATH') )
	die('-1');

/* =Includes
----------------------------------------------- */
/* Meta Box */
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/includes/admin/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( CYON_FILEPATH . '/includes/admin/meta-box' ) );
require_once (RWMB_DIR . 'meta-box.php');

/* Tax Meta Class */
require_once( CYON_FILEPATH .'/includes/admin/tax-meta-class/Tax-meta-class.php' );

/* Widget Image Field */
//require_once( CYON_FILEPATH .'/includes/admin/widget-image-field/widget-image-field.php' );

/* Hook for some js and css files not working on localhost */

add_action('init', 'optionsframework_rolescheck2' );
function optionsframework_rolescheck2 () {
	remove_action( 'admin_menu', 'optionsframework_add_page');
}

add_action('admin_menu','optionsframework_add_page2');
function optionsframework_add_page2() {

	// Inline scripts from options-interface.php
	add_action('admin_head', 'of_admin_head');

	// Adds theme menu
	add_menu_page(__('About Cyon Theme'), __('Cyon Theme'), 'edit_theme_options', 'gtw-theme','cyon_about_page','',500);
	$of_page = add_submenu_page('gtw-theme', __('Theme Settings'), __('Theme Settings'), 'edit_theme_options', 'gtw-theme-settings', 'optionsframework_page');
		
	// Adds actions to hook in the required css and javascript
	//add_action('admin_enqueue_scripts', 'optionsframework_load_scripts');
	add_action( 'admin_print_styles-' . $of_page, 'optionsframework_load_styles' );
	add_action( 'admin_print_styles-' . $of_page, 'optionsframework_load_styles_update' );
	add_action( 'admin_enqueue_scripts', 'optionsframework_load_scripts2' );
	
}

/* Enqueue scripts for file uploader */
if ( ! function_exists( 'optionsframework_media_scripts' ) ){
	add_action( 'admin_enqueue_scripts', 'optionsframework_media_scripts' );
	function optionsframework_media_scripts() {
		if ( function_exists( 'wp_enqueue_media' ) )
			wp_enqueue_media();
		wp_register_script( 'of-media-uploader', OPTIONS_FRAMEWORK_DIRECTORY .'js/media-uploader.js', array( 'jquery' ) );
		wp_enqueue_script( 'of-media-uploader' );
		wp_localize_script( 'of-media-uploader', 'optionsframework_l10n', array(
			'upload' => __( 'Upload', 'optionsframework' ),
			'remove' => __( 'Remove', 'optionsframework' )
		) );
	}
}

/* Loads the javascript */
function optionsframework_load_scripts2($hook) {
	if ( 'cyon-theme_page_gtw-theme-settings' != $hook )
        return;
	
	// Enqueued scripts
	//wp_register_script( 'of-medialibrary-uploader', OPTIONS_FRAMEWORK_DIRECTORY .'js/media-uploader.js', array( 'jquery' ) );
	//wp_enqueue_script( 'of-medialibrary-uploader' );

	if ( !wp_script_is( 'wp-color-picker', 'registered' ) ) {
		wp_register_script( 'iris', OPTIONS_FRAMEWORK_DIRECTORY . 'js/iris.min.js', array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
		wp_register_script( 'wp-color-picker', OPTIONS_FRAMEWORK_DIRECTORY . 'js/color-picker.min.js', array( 'jquery', 'iris' ) );
		$colorpicker_l10n = array(
			'clear' => __( 'Clear' ),
			'defaultString' => __( 'Default' ),
			'pick' => __( 'Select Color' )
		);
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );
	}
	
	// Enqueue custom option panel JS
	wp_enqueue_script( 'options-custom', OPTIONS_FRAMEWORK_DIRECTORY . 'js/options-custom.js', array( 'jquery','wp-color-picker' ) );

}

/* Loads the CSS */
function optionsframework_load_styles_update() {
	wp_enqueue_style( 'cyontheme', CYON_DIRECTORY.'/assets/css/admin-style.css');
	wp_enqueue_style( 'optionsframework', OPTIONS_FRAMEWORK_DIRECTORY.'css/optionsframework.css' );
	$_html = '';
	$_html .= '<link rel="stylesheet" href="' . site_url() . '/' . WPINC . '/js/thickbox/thickbox.css" type="text/css" media="screen" />' . "\n";
	$_html .= '<script type="text/javascript">
	var tb_pathToImage = "' . site_url() . '/' . WPINC . '/js/thickbox/loadingAnimation.gif";
	var tb_closeImage = "' . site_url() . '/' . WPINC . '/js/thickbox/tb-close.png";
	</script>' . "\n";
	
	echo $_html;
}	


/* = About WTG Theme
----------------------------------------------- */
function cyon_about_page(){ ?>
	<div class="wrap">
		<div id="icon-index" class="icon32"><br></div>
		<h2><?php _e('About') ?> Cyon Theme</h2>
		<p>Cyon was created for WordPress developers and designers and not intended to be used for front-end users.</p>
		<h3>Credit goes to respective people/projects:</h3>
		<ul>
			<li>Options Framework Theme</li>
			<li>Metaboxes script by Rilwis</a></li>
			<li>Tax Meta Class script</a></li>
			<li>FlexSlider</li>
			<li>FancyBox</li>
			<li>LazyLoad</li>
			<li>jQuery Cycle</li>
			<li>CloudZoom</li>
			<li>Gmap</li>
			<li>Media Element JS</li>
			<li>Supersized</li>
			<li>Tubular</li>
			<li>Uniform</li>
			<li>Poshytip</li>
		</ul>
		<p>And to a handful of random tutorials from the web.</p>
	</div>
<?php }


/* = Registering all custom jQuery and CSS
----------------------------------------------- */
wp_register_script('cyon_custom',get_template_directory_uri().'/assets/js/jquery.custom.js',array('jquery'),'1.0.0');
wp_register_script('modernizr', get_template_directory_uri().'/assets/js/modernizr.js',array(),'2.6.1');
wp_register_script('lazyload', get_template_directory_uri().'/assets/js/jquery.lazyload.min.js',array('jquery'),'1.7.2');
wp_register_script('twitter_blogger_js','http://twitter.com/javascripts/blogger.js','','',true);
wp_register_script('twitter_user_timeline_js','http://api.twitter.com/1/statuses/user_timeline.json?screen_name='.of_get_option('social_twitter').'&include_rts=1&callback=twitterCallback2&count=1','','',true);
wp_register_script('fancybox', get_template_directory_uri().'/assets/js/jquery.fancybox.pack.js',array('jquery'),'2.0.6'); 
wp_register_script('fancybox_thumbs', get_template_directory_uri().'/assets/js/jquery.fancybox-thumbs.js',array('fancybox'),'1.0.4');
wp_register_script('fancybox_media', get_template_directory_uri().'/assets/js/jquery.fancybox-media.js',array('fancybox'),'1.0.0');
wp_register_script('fancybox_buttons', get_template_directory_uri().'/assets/js/jquery.fancybox-buttons.js',array('fancybox'),'1.0.2');
wp_register_script('mousewheel', get_template_directory_uri().'/assets/js/jquery.mousewheel-3.0.6.pack.js',array('jquery'),'3.0.6');
wp_register_script('easing', get_template_directory_uri().'/assets/js/jquery.easing.js',array('jquery'),'1.3');
wp_register_script('flexislider',get_template_directory_uri().'/assets/js/jquery.flexslider-min.js',array('jquery'),'2.1',false);
wp_register_script('supersized',get_template_directory_uri().'/assets/js/jquery.supersized.min.js',array('jquery'),'3.2.7',false);
wp_register_script('tubular',get_template_directory_uri().'/assets/js/jquery.tubular.js',array('jquery'),'0.2.1',false);
wp_register_script('cloud_zoom',get_template_directory_uri().'/assets/js/jquery.cloudzoom.js',array('jquery'),'2.0.0',false);
wp_register_script('uniform',get_template_directory_uri().'/assets/js/jquery.uniform.min.js',array('jquery'),'1.8.0',false);
wp_register_script('poshytip',get_template_directory_uri().'/assets/js/jquery.poshytip.min.js',array('jquery'),'1.1.0',false);
wp_register_script('mediaelement',get_template_directory_uri().'/assets/js/jquery.mediaelement.min.js',array('jquery'),'2.10.0',false);
wp_register_script('gmap_api','http://maps.google.com/maps/api/js?sensor=false',array('jquery'),'1.0.0',false);
wp_register_script('gmap',get_template_directory_uri().'/assets/js/jquery.gmap.min.js',array('gmap_api'),'3.3.0',false);
wp_register_script('jquery_cycle',get_template_directory_uri().'/assets/js/jquery.cycle.all.js',array('jquery'),'2.9999.5',false);

wp_register_style('responsive_css', get_template_directory_uri().'/assets/css/responsive.css',array(),'1.0.0');
wp_register_style('fancybox_css', get_template_directory_uri().'/assets/css/jquery.fancybox.css',array(),'2.0.6');
wp_register_style('fancybox_thumbs_css', get_template_directory_uri().'/assets/css/jquery.fancybox-thumbs.css',array(),'1.0.4');
wp_register_style('fancybox_buttons_css', get_template_directory_uri().'/assets/css/jquery.fancybox-buttons.css',array(),'1.0.2');
wp_register_style('flexislider_css',get_template_directory_uri().'/assets/css/flexslider.css',array(),'2.1',false);
wp_register_style('supersized_css',get_template_directory_uri().'/assets/css/supersized.css',array(),'3.2.7',false);
wp_register_style('cloud_zoom_css',get_template_directory_uri().'/assets/css/cloudzoom.css',array(),'2.0.0',false);
wp_register_style('uniform_css',get_template_directory_uri().'/assets/css/uniform.css',array(),'1.6.0',false);
wp_register_style('mediaelement_css',get_template_directory_uri().'/assets/css/mediaelementplayer.css',array(),'1.0.0',false);
wp_register_style('icons_css',get_template_directory_uri().'/assets/css/icons.css',array(),'1.0.0',false);

function cyon_admin_scripts_styles() {
	wp_enqueue_script('cyon_custom_admin_script',  get_template_directory_uri() . '/assets/js/jquery.admin.js', array('jquery'));
	wp_enqueue_style( 'cyon_custom_admin_style',  get_template_directory_uri() . '/assets/css/admin-style.css' );
}

add_action( 'admin_enqueue_scripts', 'cyon_admin_scripts_styles' );


/* =Remove core and plugin updates
----------------------------------------------- */
if(of_get_option('admin_core_updates')==1){
	/* 2.3 to 2.7 */
	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
	
	/* 2.8 to 3.0 */
	remove_action( 'wp_version_check', 'wp_version_check' );
	remove_action( 'admin_init', '_maybe_update_core' );
	add_filter( 'pre_transient_update_core', create_function( '$a', "return null;" ) );
	
	/* 3.0 */
	add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
}
if(of_get_option('admin_plugin_updates')==1){
	/* 2.3 to 2.7 */
	add_action( 'admin_menu', create_function( '$a', "remove_action( 'load-plugins.php', 'wp_update_plugins' );") );
	add_action( 'admin_init', create_function( '$a', "remove_action( 'admin_init', 'wp_update_plugins' );"), 2 );
	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_update_plugins' );"), 2 );
	add_filter( 'pre_option_update_plugins', create_function( '$a', "return null;" ) );
	
	/* 2.8 to 3.0 */
	remove_action( 'load-plugins.php', 'wp_update_plugins' );
	remove_action( 'load-update.php', 'wp_update_plugins' );
	remove_action( 'admin_init', '_maybe_update_plugins' );
	remove_action( 'wp_update_plugins', 'wp_update_plugins' );
	add_filter( 'pre_transient_update_plugins', create_function( '$a', "return null;" ) );
	
	/* 3.0 */
	remove_action( 'load-update-core.php', 'wp_update_plugins' );
	add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
}

/* =Adding Meta Boxes
----------------------------------------------- */
global $cyon_meta_boxes;

$prefix = 'cyon_';
$cyon_meta_boxes = array();

$cyon_meta_boxes[] = array(
	// Page Settings
	'id' => 'settings',
	'title' => __('Page Settings'),
	'pages' => array('post','page'), // multiple post types, accept custom post types
	'context' => 'normal', // normal, advanced, side (optional)
	'fields' => array(
		array(
			'name' => __('Layout'),
			'id' => $prefix .'layout',
			'type' => 'radio',
			'std' => 'default', 
			'options' => array( // array of name, value pairs for radio options
				'default' => __('Default'),
				'general-1column' => __('1 Column'),
				'general-2left' => __('2 Columns Left'),
				'general-2right' => __('2 Columns Right')
			)
		),
		array(
			'name' => __('Background Image'),
			'id' => $prefix .'background',
			'type' => 'thickbox_image',
			'std' => ''
		)
	)
);

$cyon_meta_boxes[] = array(
	// Post Format - Link
	'id' => 'gallery-settings',
	'title' => __('Gallery Settings'),
	'pages' => array('post'), // multiple post types, accept custom post types
	'context' => 'normal', // normal, advanced, side (optional)
	'fields' => array(
		array(
			'name' => __('Images Excerpt'),
			'id' => $prefix .'gallery_images',
			'type' => 'thickbox_image',
			'std' => ''
		)
	)
);

$cyon_meta_boxes[] = array(
	// Post Format - Link
	'id' => 'link-settings',
	'title' => __('Link Settings'),
	'pages' => array('post'), // multiple post types, accept custom post types
	'context' => 'normal', // normal, advanced, side (optional)
	'fields' => array(
		array(
			'name' => __('URL'),
			'id' => $prefix .'link_url',
			'type' => 'text',
			'std' => ''
		)
	)
);

$cyon_meta_boxes[] = array(
	// Post Format - Quote
	'id' => 'quote-settings',
	'title' => __('Quote Settings'),
	'pages' => array('post'), // multiple post types, accept custom post types
	'context' => 'normal', // normal, advanced, side (optional)
	'fields' => array(
		array(
			'name' => __('Author'),
			'id' => $prefix .'quote_author',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Position / Company'),
			'id' => $prefix .'quote_title',
			'type' => 'text',
			'std' => ''
		)
	)
);

$cyon_meta_boxes[] = array(
	// Post Format - Audio
	'id' => 'audio-settings',
	'title' => __('Audio Settings'),
	'pages' => array('post'), // multiple post types, accept custom post types
	'context' => 'normal', // normal, advanced, side (optional)
	'fields' => array(
		array(
			'name' => __('URL'),
			'id' => $prefix .'audio_url',
			'type' => 'text',
			'std' => ''
		)
	)
);

$cyon_meta_boxes[] = array(
	// Post Format - Video
	'id' => 'video-settings',
	'title' => __('Video Settings'),
	'pages' => array('post'), // multiple post types, accept custom post types
	'context' => 'normal', // normal, advanced, side (optional)
	'fields' => array(
		array(
			'name' => __('URL'),
			'id' => $prefix .'video_url',
			'type' => 'text',
			'desc' => __('Supports Youtube, Vimeo, Metacafe, Dailymotion, Twitvid and local video files such as mp4, m4v, mov, wmv, flv, webm, ogv'),
			'std' => ''
			)
	)
);

if(of_get_option('seo_activate')==1){
	$cyon_meta_boxes[] = array(
		// SEO
		'id' => 'seo',
		'title' => __('SEO Options'),
		'pages' => array('post','page'), // multiple post types, accept custom post types
		'context' => 'normal', // normal, advanced, side (optional)
		'fields' => array(
			array(
				'name' => __('Page Title'),
				'id' => $prefix .'meta_title',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => __('Description'),
				'id' => $prefix .'meta_desc',
				'type' => 'textarea',
				'std' => ''
			),
			array(
				'name' => __('Keywords'),
				'id' => $prefix .'meta_keywords',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => __('Hide from search engines'),
				'id' => $prefix .'robot',
				'type' => 'checkbox'
			)
		)
	);
}

function cyon_register_meta_boxes(){
	global $cyon_meta_boxes;
	if ( class_exists( 'RW_Meta_Box' ) ){
		foreach ( $cyon_meta_boxes as $cyon_meta_box ){
			new RW_Meta_Box( $cyon_meta_box );
		}
	}
}
add_action( 'admin_init', 'cyon_register_meta_boxes' );

/* =Adding Taxonomy Meta boxes on Post Categories
----------------------------------------------- */
function hide_category_description() {
    global $current_screen;
	if ( $current_screen->id == 'edit-category' ) { ?>
		<script type="text/javascript">
			jQuery(function($) {
				$('textarea#description:not(.at-wysiwyg)').attr('id','').closest('tr.form-field').hide();
			}); 
		</script> <?php
	} 
} 


if (is_admin()){
	if ( class_exists( 'Tax_Meta_Class' ) ){
		$prefix = 'cyon_';
		$config = array(
			'id' => 'tax_meta_category',         
			'title' => 'Category Meta Box',       
			'pages' => array('category'), 
			'context' => 'normal',        
			'fields' => array(),          
			'local_images' => false,    
			'use_with_theme' => false 
		);
		$new_cat_meta = new Tax_Meta_Class($config);

/*		if ( $_GET['action'] == 'edit' && $_GET['taxonomy'] == 'category' ) { 
			remove_filter( 'pre_term_description', 'wp_filter_kses' );
			remove_filter( 'term_description', 'wp_kses_data' );
			add_action('admin_head', 'hide_category_description'); 
			$new_cat_meta->addWysiwyg( 'description',
							array(
									'name' => __('Description', 'cyon'),
									'desc'=> __('The description is not prominent by default; however, some themes may show it.', 'cyon')
							));
		}
*/
		$new_cat_meta->addSelect( $prefix.'cat_layout',
						array(
								'default' 			=> __('Default', 'cyon'),
								'general-1column'	=> __('1 Column', 'cyon'),
								'general-2left'		=> __('2 Columns Left', 'cyon'),
								'general-2right'	=> __('2 Columns Right', 'cyon')
						),
						array(
								'name' => __('Page Layout', 'cyon'),
								'std'=> array('default')
						));

		$new_cat_meta->addSelect( $prefix.'cat_layout_listing',
						array(
								'default' 			=> __('Default', 'cyon'),
								'list-1column'		=> __('1 Column', 'cyon'),
								'list-2columns'		=> __('2 Columns', 'cyon'),
								'list-3columns'		=> __('3 Columns', 'cyon'),
								'list-4columns'		=> __('4 Columns', 'cyon')
						),
						array(
								'name' => __('Listing Layout', 'cyon'),
								'std'=> array('default')
						));

		$new_cat_meta->addSelect( $prefix.'cat_masonry',
						array(
								'default' 			=> __('Default', 'cyon'),
								'yes'				=> __('Yes', 'cyon'),
								'no'				=> __('No', 'cyon')
						),
						array(
								'name' => __('Use Masonry', 'cyon'),
								'std'=> array('default')
						));
						
		$new_cat_meta->addImage( $prefix.'cat_image', 
						array('name'=> 'Image Banner' ));

		$new_cat_meta->addImage( $prefix.'cat_background', 
						array('name'=> 'Background Image' ));
					
		$new_cat_meta->Finish();
	}
}
// Get Term ID
function cyon_term_id(){
	$current_cat = get_query_var('cat');
	$term_slug = get_category ($current_cat);
	$current_term = get_term_by( 'slug', $term_slug->slug, 'category' );
	define( 'CYON_TERM_ID', $current_term->term_id );
}
add_action ( 'wp_head', 'cyon_term_id',10);

/* =Adding MCE button
----------------------------------------------- */
function cyon_add_mce_button() {
// Don't bother doing this stuff if the current user lacks permissions	
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "cyon_add_mce_button_plugin");
     add_filter('mce_buttons', 'cyon_add_mce_button_register');
   }

	function cyon_add_mce_button_register($buttons) {
	   array_push($buttons, "separator", "cyon_plugin");
	   return $buttons;
	}
	 
	// Load the TinyMCE plugin
	function cyon_add_mce_button_plugin($plugin_array) {
	   $plugin_array['cyon_plugin'] = get_template_directory_uri().'/assets/js/mce/editor_plugin.js';
	   return $plugin_array;
	}
}
add_action('init', 'cyon_add_mce_button');

/* =Custom Hooks
----------------------------------------------- */
function cyon_before_header() {
    do_action('cyon_before_header');
}
function cyon_header() {
    do_action('cyon_header');
}
function cyon_footer() {
    do_action('cyon_footer');
}
function cyon_before_body() {
    do_action('cyon_before_body');
}
function cyon_after_body() {
    do_action('cyon_after_body');
}
function cyon_before_body_wrapper() {
    do_action('cyon_before_body_wrapper');
}
function cyon_after_body_wrapper() {
    do_action('cyon_after_body_wrapper');
}
function cyon_primary_before() {
    do_action('cyon_primary_before');
}
function cyon_primary_after() {
    do_action('cyon_primary_after');
}
function cyon_sidebar_before() {
    do_action('cyon_sidebar_before');
}
function cyon_sidebar_after() {
    do_action('cyon_sidebar_after');
}
function cyon_post_header_before() {
    do_action('cyon_post_header_before');
}
function cyon_post_header_after() {
    do_action('cyon_post_header_after');
}
function cyon_home_content() {
    do_action('cyon_home_content');
}
function cyon_post_content_before() {
    do_action('cyon_post_content_before');
}
function cyon_post_content_after() {
    do_action('cyon_post_content_after');
}
function cyon_post_footer() {
    do_action('cyon_post_footer');
}
function cyon_after_footer() {
    do_action('cyon_after_footer');
}