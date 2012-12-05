<?php

/* =Includes
----------------------------------------------- */
/* Meta Box */
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/includes/admin/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( CYON_FILEPATH . '/includes/admin/meta-box' ) );
require_once (RWMB_DIR . 'meta-box.php');

/* Tax Meta Class */
require_once( CYON_FILEPATH .'/includes/admin/tax-meta-class/Tax-meta-class.php' );


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
	add_menu_page(__('About Cyon Theme'), __('Cyon Theme'), 'edit_theme_options', 'gtw-theme','cyon_about_page', CYON_DIRECTORY.'/assets/images/ico-settings.png');
	$of_page = add_submenu_page('gtw-theme', __('Theme Settings'), __('Theme Settings'), 'edit_theme_options', 'gtw-theme-settings', 'optionsframework_page');
		
	// Adds actions to hook in the required css and javascript
	//add_action('admin_enqueue_scripts', 'optionsframework_load_scripts');
	add_action( 'admin_print_styles-' . $of_page, 'optionsframework_load_styles' );
	add_action( 'admin_print_styles-' . $of_page, 'optionsframework_load_styles_update' );
	add_action( 'admin_enqueue_scripts', 'optionsframework_load_scripts2' );
	
}

/* Loads the javascript */
function optionsframework_load_scripts2($hook) {
	if ( 'cyon-theme_page_gtw-theme-settings' != $hook )
        return;
	
	// Enqueued scripts
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('color-picker', OPTIONS_FRAMEWORK_DIRECTORY.'js/colorpicker.js', array('jquery'));
	wp_enqueue_script('options-custom', OPTIONS_FRAMEWORK_DIRECTORY.'js/options-custom.js', array('jquery'));
	wp_register_script( 'of-medialibrary-uploader', OPTIONS_FRAMEWORK_DIRECTORY .'js/of-medialibrary-uploader.js', array( 'jquery', 'thickbox' ) );
	wp_enqueue_script( 'of-medialibrary-uploader' );
	wp_enqueue_script( 'media-upload' );
	
}

/* Loads the CSS */
function optionsframework_load_styles_update() {
	wp_enqueue_style('cyontheme', CYON_DIRECTORY.'/assets/css/admin.css');
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
		<h2><?php _e('About Cyon Theme') ?></h2>
		<p>Cyon was created for WordPress developers and designers and not intended to be used for front-end users.</p>
		<h3>Thanks to:</h3>
		<ul>
			<li>WPTheming.com for <a href="http://wptheming.com/options-framework-theme/" target="_blank">Options Framework Theme</a></li>
			<li>Rilwis for <a href="http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html" target="_blank">metaboxes script</a></li>
			<li>WooThemes for <a href="http://www.woothemes.com/flexslider/" target="_blank">FlexSlider</a></li>
			<li>Fancyapps.com for <a href="http://fancyapps.com/fancybox/" target="_blank">fancyBox</a></li>
			<li>Mika Tuupola for <a href="http://www.appelsiini.net/projects/lazyload" target="_blank">LazyLoad</a></li>
			<li><a href="http://gtwebsite.com" target="_blank">Greater Than Website</a> for making this all possible</li>
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
wp_register_script('flexislider',get_template_directory_uri().'/assets/js/jquery.flexslider-min.js',array('jquery'),'2.1',false);
wp_register_script('supersized',get_template_directory_uri().'/assets/js/jquery.supersized.min.js',array('jquery'),'3.2.1',false);
wp_register_script('tubular',get_template_directory_uri().'/assets/js/jquery.tubular.js',array('jquery'),'0.2.1',false);
wp_register_script('cloud_zoom',get_template_directory_uri().'/assets/js/jquery.cloudzoom.js',array('jquery'),'2.0.0',false);
wp_register_script('uniform',get_template_directory_uri().'/assets/js/jquery.uniform.min.js',array('jquery'),'1.8.0',false);
wp_register_script('poshytip',get_template_directory_uri().'/assets/js/jquery.poshytip.min.js',array('jquery'),'1.1.0',false);
wp_register_script('mediaelement',get_template_directory_uri().'/assets/js/jquery.mediaelement.min.js',array('jquery'),'2.10.0',false);
wp_register_script('gmap_api','http://maps.google.com/maps/api/js?sensor=false',array('jquery'),'1.0.0',false);
wp_register_script('gmap',get_template_directory_uri().'/assets/js/jquery.gmap.min.js',array('gmap_api'),'3.3.0',false);

wp_register_style('responsive_css', get_template_directory_uri().'/assets/css/responsive.css',array(),'1.0.0');
wp_register_style('fancybox_css', get_template_directory_uri().'/assets/css/jquery.fancybox.css',array(),'2.0.6');
wp_register_style('fancybox_thumbs_css', get_template_directory_uri().'/assets/css/jquery.fancybox-thumbs.css',array(),'1.0.4');
wp_register_style('fancybox_buttons_css', get_template_directory_uri().'/assets/css/jquery.fancybox-buttons.css',array(),'1.0.2');
wp_register_style('flexislider_css',get_template_directory_uri().'/assets/css/flexslider.css',array(),'2.1',false);
wp_register_style('supersized_css',get_template_directory_uri().'/assets/css/supersized.css',array(),'3.2.1',false);
wp_register_style('cloud_zoom_css',get_template_directory_uri().'/assets/css/cloudzoom.css',array(),'2.0.0',false);
wp_register_style('uniform_css',get_template_directory_uri().'/assets/css/uniform.css',array(),'1.6.0',false);
wp_register_style('mediaelement_css',get_template_directory_uri().'/assets/css/mediaelementplayer.css',array(),'1.0.0',false);
wp_register_style('icons_css',get_template_directory_uri().'/assets/css/icons.css',array(),'1.0.0',false);

function cyon_admin_menu_styles() {
	wp_register_style( 'cyon_admin_menu_styles', get_template_directory_uri() . '/assets/css/menu.css' );
	wp_enqueue_style( 'cyon_admin_menu_styles' );
}

add_action( 'admin_enqueue_scripts', 'cyon_admin_menu_styles' );


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

/* =Create sample page
----------------------------------------------- */
if (isset($_GET['activated']) && is_admin()){
        $new_page_title = 'Hide this page';
        $new_page_content = '
You can create some beautiful content by using some simple HTML elements. The Warp theme framework offers some neat styles for all HTML elements and a great set of CSS classes to style your content. Basic HTML is very easy to learn and this small guide shows you how to use all styles provided by the Warp framework.
<h2>Basic HTML Elements</h2>
Here is a short demonstration of text-level semanticts. The &lt;p&gt; element creates a new paragraph. It will have some space before and after itself. To turn your text into hypertext just use the <a href="#">&lt;a&gt; element</a>.
<h3>Text-Level Semantics</h3>
You can emphasize text using the <em>&lt;em&gt; element</em> or to imply any extra importance the <strong>&lt;strong&gt; element</strong>. Highlight text with no semantic meaning using the <mark>&lt;mark&gt; element</mark>. Markup document changes like inserted or deleted text with the <del>&lt;del&gt; element</del> or <ins>&lt;ins&gt; element</ins>. To define an abbreviation use the <abbr title="Abbreviation Element">&lt;abbr&gt; element</abbr> and to define a definition term use the <dfn title="Defines a definition term">&lt;dfn&gt; element</dfn>.
<h3>Short List with Links</h3>
<ul>
	<li><a href="http://www.yootheme.com" target="_blank">YOOtheme</a> – Premium Joomla Templates and WordPress Themes</li>
	<li><a href="http://www.yootheme.com/warp" target="_blank">Warp Framework</a> – Fast and Slick Theme Framework</li>
	<li><a href="http://www.yootheme.com/zoo" target="_blank">ZOO</a> – Content Application Builder</li>
	<li><a href="http://www.yootheme.com/icons" target="_blank">Stock Icons</a> – For Web and Print Projects</li>
</ul>
<h3>Quotations and Code</h3>
Inline quotations can be defined by using the <q>&lt;q&gt; element</q>.
<blockquote>The &lt;blockquote&gt; element defines a long quotation which also creates a new block by inserting white space before and after the blockquote element.</blockquote>
To define a short inline computer code use the <code>&lt;code&gt; element</code>. For a larger code snippet use the &lt;pre&gt; element which defines preformatted text. It creates a new text block which preserves both spaces and line breaks.
<pre>pre {
    margin: 15px 0;
    padding: 10px;
    font-family: "Courier New", Courier, monospace;
    font-size: 12px;
    line-height: 18px;
    white-space: pre-wrap;
}</pre>
<small>Use the &lt;small&gt; element for side comments and small print.</small>

<hr />

<h2>Useful CSS Classes</h2>
Here is a short demonstration of all style related CSS classes provided by the Warp framework.
<h3>Highlight Content</h3>
<p class="dropcap">Drop caps are the first letter of a paragraph which are displayed bigger than the rest of the text. You can create a drop cap using the CSS class <code>dropcap</code>. To emphasize text with some small boxes use <em class="box">&lt;em&gt; element</em> with the CSS class <code>box</code>.</p>

<div class="box-content">This simple box is intended to group large parts of your content using the CSS class <code>box-content</code>.</div>
<div class="box-note">This is a simple box to highlight some text using the CSS class <code>box-note</code>.</div>
<div class="box-info">This is a simple box with useful information using the CSS class <code>box-info</code>.</div>
<div class="box-warning">This is a simple box with important notes and warnings using the CSS class <code>box-warning</code>.</div>
<div class="box-hint">This is a simple box with additional hints using the CSS class <code>box-hint</code>.</div>
<div class="box-download">This is a simple box with download information using the CSS class <code>box-download</code>.</div>
Use the CSS class <code>dashed</code> to create a dashed horizontal rule.

<hr class="dashed" />

<h3>Tables</h3>
Create a zebra stripped table using using the CSS class <code>zebra</code>.
<table class="zebra"><caption>Table caption</caption>
<thead>
<tr>
<th>Table Heading</th>
<th>Table Heading</th>
<th class="center">Table Heading</th>
</tr>
</thead>
<tfoot>
<tr>
<td>Table Footer</td>
<td>Table Footer</td>
<td class="center">Table Footer</td>
</tr>
</tfoot>
<tbody>
<tr class="odd">
<td>Table Data</td>
<td>Table Data</td>
<td class="center">Data Centered</td>
</tr>
<tr>
<td class="bold">Data Bold</td>
<td>Table Data</td>
<td class="center">Data Centered</td>
</tr>
<tr class="odd">
<td>Table Data</td>
<td>Table Data</td>
<td class="center">Data Centered</td>
</tr>
</tbody>
</table>
<h3>Definition Lists</h3>
Create a nice looking definition list separated with a line by using the CSS class <code>separator</code>.

<dl class="separator"><dt>Definition List</dt><dd>A definition list is a list of terms and corresponding definitions. To create a definition list use the &lt;dl&gt; element in conjunction with &lt;dt&gt; to define the definition term and &lt;dd&gt; to define the definition description.</dd><dt>Definition Term</dt><dd>This is a definition description.</dd><dt>Definition Term</dt><dd>This is a definition description.</dd><dd>This is another definition description.</dd></dl>
<h2>Gallery Style</h2>
Use <code>gallery</code> same as the default to get this effect below:
[gallery link="file" columns="4"]
<h2>Toggle Sample</h2>
[toggle]Wow! is pretty amazing[/toggle]
[toggle title="This is sparta"]Im loving this[/toggle]
[toggle title="I want more"]
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
[/toggle]
<h2>Accordion Sample</h2>
[accordion]Wow! is pretty amazing[/accordion]

[accordion title="This is sparta"]Im loving this[/accordion]

[accordion title="I want more"]

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

[/accordion]
[pricegrid labels="Setup,Updates,Disk Space,Traffic" columns="4" bgcolor="#03BCEE"]
[gridcolumn title="Starter" price="$49.90" period="Yearly" link_url="http://"]
[gridoption text="$599.00" tooltip_title="Setup and Design" tooltip_text="Website com design configurado e básico. Designs mais complexos e/ou mídias podem aumentar o custo." /]
[gridoption checked="no" /]
[gridoption text="500MB" /]
[gridoption text="500GB" /]
[/gridcolumn][gridcolumn highlighted="yes" title="Personal" best_value="Preço Melhor!" price="$99.90" period="Yearly" link_url="http://"]
[gridoption text="$599.00" tooltip_title="Setup and Design" tooltip_text=" Website com design configurado e básico. Designs mais complexos e/ou mídias podem aumentar o custo."]
[gridoption checked="yes"]
[gridoption text="1GB"]
[gridoption text="1000GB"]
[/gridcolumn][gridcolumn title="Professional" price="$159.90" period="Yearly" link_url="http://"][gridoption text="$599.00" tooltip_title="Setup and Design" tooltip_text=" Website com design configurado e básico. Designs mais complexos e/ou mídias podem aumentar o custo."][gridoption checked="yes"]
[gridoption text="2Gb"]
[gridoption text="2000GB"]
[/gridcolumn][gridcolumn title="Enterprise" price="$499.90" period="Yearly" link_url="http://"]
[gridoption text="$599.00" tooltip_title="Setup and Design" tooltip_text=" Website com design configurado e básico. Designs mais complexos e/ou mídias podem aumentar o custo."]
[gridoption checked="yes"]
[gridoption text="10Gb"]
[gridoption text="Ilimitado"]
[/gridcolumn][/pricegrid]
';
        $new_page_template = ''; 
        $page_check = get_page_by_title($new_page_title);
        $new_page = array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
                'post_author' => 1,
        );
        if(!isset($page_check->ID)){
                $new_page_id = wp_insert_post($new_page);
                if(!empty($new_page_template)){
                        update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
                }
        }
}


/* =Adding Meta Boxes
----------------------------------------------- */
global $cyon_meta_boxes;

$prefix = 'cyon_';
$cyon_meta_boxes = array();

$cyon_meta_boxes[] = array(
	'id' => 'settings',
	'title' => 'Settings',
	'pages' => array('post','page'), // multiple post types, accept custom post types
	'context' => 'normal', // normal, advanced, side (optional)
	'priority' => 'high', // high, low (optional)
	'fields' => array(
		array(
			'name' => 'Layout',
			'id' => $prefix .'layout',
			'type' => 'radio',
			'std' => 'default', 
			'options' => array( // array of name, value pairs for radio options
				'default' => 'Default',
				'general-1column' => '1 Column',
				'general-2left' => '2 Columns Left',
				'general-2right' => '2 Columns Right'
			)
		)
	)
);


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
if (is_admin()){
	if ( class_exists( 'Tax_Meta_Class' ) ){
		$prefix = 'cyon_';
		$config = array(
			'id' => 'tax_meta_category',         
			'title' => 'Demo Meta Box',       
			'pages' => array('category'), 
			'context' => 'normal',        
			'fields' => array(),          
			'local_images' => false,    
			'use_with_theme' => false 
		);
		$new_cat_meta = new Tax_Meta_Class($config);
		
		$new_cat_meta->addSelect( $prefix.'cat_layout',
						array(
								'default' 			=> __('Default', 'cyon'),
								'general-1column'	=> __('1 Column', 'cyon'),
								'general-2left'		=> __('2 Columns Left', 'cyon'),
								'general-2right'	=> __('2 Columns Right', 'cyon')
						),
						array(
								'name' => __('Layout', 'cyon'),
								'std'=> array('default')
						));
						
		$new_cat_meta->Finish();
	}
}
//add_action( 'admin_init', 'cyon_register_tax_meta' );

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