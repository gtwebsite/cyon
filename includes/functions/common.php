<?php

/* =Includes
----------------------------------------------- */
require_once (CYON_FILEPATH . '/includes/functions/slides.php');			// Slides

/* =Breadcrumbs
----------------------------------------------- */

function cyon_breadcrumb() {
	if (!is_front_page() && of_get_option('breadcrumbs')==1) {
		if(function_exists('bcn_display')){
			// Support for Breacrumb NavXT
			?> <div id="breadcrumb"> <?php
			if(function_exists('bcn_display')){
				bcn_display();
			}
			?> </div> <?php
		}else{
			echo '<dl id="breadcrumb"  itemprop="breadcrumb">';
			echo '<dt>'.__('You are here').':</dt>';
			echo '<dd><a href="'.get_option('home').'">'.__('Home').'</a></dd>';
			if (is_category() || is_single()) {
				$cat_title = get_the_category('title_li=');
				if(is_category()){
					echo '<dd>&raquo; '.$cat_title[0]->cat_name.'</dd>';
				}else{
					echo '<dd>&raquo; <a href="'.get_category_link( $cat_title[0]->cat_ID).'">'.$cat_title[0]->cat_name.'</a></dd>';
				}
				if (is_single()) {
					echo '<dd>&raquo; '.get_the_title().'</dd>';
				}
			} elseif (is_page()) {
				$page=get_page_by_title(get_the_title());
				if($page->post_parent!=0){
					$parent_id  = $page->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
						$spage = get_page($parent_id);
						$breadcrumbs[] = '<dd>&raquo; <a href="' . get_permalink($spage->ID) . '">' . get_the_title($spage->ID) . '</a></dd>';
						$parent_id  = $spage->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					for ($i = 0; $i < count($breadcrumbs); $i++) {
						echo $breadcrumbs[$i];
					}
					//echo '<dd>&raquo; <a href="'.get_permalink($page->post_parent).'">'.get_the_title($page->post_parent).'</a></dd>';
				}
				echo '<dd>&raquo; '.get_the_title().'</dd>';
			}elseif (is_home()){
				echo '<dd>&raquo; '.get_the_title(get_option('page_for_posts', true)).'</dd>';
			}elseif (is_search()){
				echo '<dd>&raquo; Search results for: '.get_search_query().'</dd>';
			}elseif (is_day()){
				echo '<dd>&raquo; <a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></dd>';
				echo '<dd>&raquo; <a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></dd>';
				echo '<dd>&raquo; '.get_the_time('d').'</dd>';
			}elseif (is_month()){
				echo '<dd>&raquo; <a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></dd>';
				echo '<dd>&raquo; '.get_the_time('F').'</dd>';
			}elseif (is_year()){
				echo '<dd>&raquo; '.get_the_time('Y').'</dd>';
			}elseif (is_author()){
				global $author;
				$userdata = get_userdata($author);
				echo '<dd>&raquo; '.__('Articles posted by').': '.$userdata->display_name.'</dd>';
			}elseif (is_tag()){
				echo '<dd>&raquo; '.__('Posts tagged').': '.single_tag_title('', false).'</dd>';
			}elseif (is_404()){
				echo '<dd>&raquo; '.__('Error 404').'</dd>';
			}
			echo '</dl>';
		}
	}
}


/* =Register Footer JS and CSS
----------------------------------------------- */

function cyon_common_scripts(){
	wp_enqueue_script('modernizr');
	
	/* Lazy Load */	
	if(of_get_option('lazyload')==1){
		wp_enqueue_script('lazyload');
	}
	
	/* Twitter */
	if(is_front_page() && of_get_option('homepage_middle')=='twitter'){
		wp_enqueue_script('twitter_blogger_js');
		wp_enqueue_script('twitter_user_timeline_js');
	}

	/* Fancy Box */
	if(of_get_option('lightbox_activate')==1){
		wp_enqueue_script('mousewheel');
		wp_enqueue_script('fancybox');
		wp_enqueue_script('fancybox_media');
		wp_enqueue_style('fancybox_css');

		if(of_get_option('lightbox_gallery_style')=='thumbnails'){
			wp_enqueue_script('fancybox_thumbs');
			wp_enqueue_style('fancybox_thumbs_css');
		}

		if(of_get_option('lightbox_gallery_style')=='buttons'){
			wp_enqueue_script('fancybox_buttons');
			wp_enqueue_style('fancybox_buttons_css');
		}
	}

	
	/* Supersized */
	if(of_get_option('background_style')=='full'){
		wp_enqueue_script('supersized');
		wp_enqueue_style('supersized_css');
	}

	/* Tubular */
	if(of_get_option('background_style')=='youtube' && of_get_option('background_style_youtube')<>''){
		wp_enqueue_script('tubular');
	}

	/* Uniform */
	wp_enqueue_script('uniform');
	wp_enqueue_style('uniform_css');

	/* Poshytip */
	wp_enqueue_script('poshytip');

	/* Media Element */
	wp_enqueue_script('mediaelement');
	wp_enqueue_style('mediaelement_css'); 

	/* Icons */
	wp_enqueue_style('icons_css'); 

	/* Custom */
	wp_enqueue_script('cyon_custom');

}
add_action('wp_enqueue_scripts', 'cyon_common_scripts',100);

/* Check page layout */
function cyon_check_page_layout(){
	global $post;
	if(is_front_page()) {
		$page_layout = of_get_option('homepage_layout');
	}elseif(is_home() && get_post_meta(get_option('page_for_posts', true),'cyon_layout',true)!='default'){
		$page_layout = get_post_meta(get_option('page_for_posts', true),'cyon_layout',true);
	}elseif(is_category() && get_tax_meta(CYON_TERM_ID,'cyon_cat_layout')!='default' && get_tax_meta(CYON_TERM_ID,'cyon_cat_layout')!=''){
		$page_layout = get_tax_meta(CYON_TERM_ID,'cyon_cat_layout');
	}elseif( get_post_meta($post->ID,'cyon_layout',true)=='default' || !get_post_meta($post->ID,'cyon_layout',true) ){
		$page_layout = of_get_option('general_layout');
	}else{
		$page_layout = get_post_meta($post->ID,'cyon_layout',true);
	}
	define('CYON_PAGE_LAYOUT',$page_layout);
}
add_action('wp_head','cyon_check_page_layout',30);

/* Check page background */
function cyon_check_page_bg(){
	global $post;
	if(is_home() && get_post_meta(get_option('page_for_posts', true),'cyon_background',true)!=''){
		$image_attributes = wp_get_attachment_image_src( get_post_meta(get_option('page_for_posts', true),'cyon_background',true),'full' );
		$page_bg = $image_attributes[0];
	}elseif(is_category() && is_array(get_tax_meta(CYON_TERM_ID,'cyon_cat_background'))){
		$image_id = get_tax_meta(CYON_TERM_ID,'cyon_cat_background');
		$image_attributes = wp_get_attachment_image_src( $image_id['id'],'full' );
		$page_bg = $image_attributes[0];
	}elseif(get_post_meta($post->ID,'cyon_background',true)!=''){
		$image_attributes = wp_get_attachment_image_src( get_post_meta($post->ID,'cyon_background',true),'full' );
		$page_bg = $image_attributes[0];
	}else{
		$page_bg = of_get_option('background_style_image');
	}
	define('CYON_PAGE_BG_IMAGE',$page_bg);
}
add_action('wp_head','cyon_check_page_bg',30);

/* Hook JS/CSS script Header */
function cyon_header_js_css_hook(){ ?>
	<?php if(of_get_option('responsive')==1){ wp_enqueue_style('responsive_css'); } ?>
	<?php if(of_get_option('iosicon')!=''){ ?><link rel="apple-touch-icon" href="<?php echo of_get_option('iosicon'); ?>" /><?php } ?>
	<?php if(of_get_option('favicon')!=''){ ?><link rel="shortcut icon" href="<?php echo of_get_option('favicon'); ?>" /><?php } ?>
	
	<!--[if gte IE 9]>
	  <style type="text/css">
		input.input-text, input[type=text], input[type=email], input[type=phone], input[type=submit], input[type=button], textarea, select, button, .button, .btn, .toggle h3, .accordion h3, .tabs .tab_nav li a, table.table thead th, table.table tfoot td, .onsale  {
		   filter: none!important;
		}
	  </style>
	<![endif]-->
	<!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/style-ie8.css" />
	<![endif]-->
	<!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/style-ie7.css" />
	<![endif]-->

	<style type="text/css">
		body {
			background:<?php echo of_get_option('background_color'); ?>
			<?php if(CYON_PAGE_BG_IMAGE!='' && of_get_option('background_style')=='pattern'){ ?>
			url(<?php echo CYON_PAGE_BG_IMAGE; ?>)
			<?php echo of_get_option('background_style_pattern_position'); ?> <?php echo of_get_option('background_style_pattern_repeat'); ?>
			<?php } ?>
	</style>


	<?php if(of_get_option('primary_font')=='google'){ ?>
	<!-- Google Fonts -->	
	<link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=<?php echo of_get_option('primary_font_google'); ?>" />
	<style type="text/css">
		body { font-family:<?php echo of_get_option('primary_font_google'); ?>; }
	</style>
	<?php }elseif(of_get_option('primary_font')!='default' && of_get_option('primary_font')!='google'){ ?>
	<style type="text/css">
		body { font-family:<?php echo of_get_option('primary_font'); ?>; }
	</style>
	<?php } ?>

	<?php if(of_get_option('secondary_font')=='google'){ ?>
	<!-- Google Fonts -->	
	<link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=<?php echo of_get_option('secondary_font_google'); ?>" />
	<style type="text/css">
		.page-header h1, .category-header h1, article h2, .widget h3, #branding hgroup h1, #slider h3, .entry-header h1, .page-header h1, .page-content h2, .page-content h3, .page-content h4, .products h2 { font-family:<?php echo of_get_option('secondary_font_google'); ?>; }
	</style>
	<?php }elseif(of_get_option('secondary_font')!='default' && of_get_option('secondary_font')!='google'){ ?>
	<style type="text/css">
		.page-header h1, .category-header h1, article h2, .widget h3, #branding hgroup h1, #slider h3, .entry-header h1, .page-header h1, .page-content h2, .page-content h3, .page-content h4, .products h2 { font-family:<?php echo of_get_option('secondary_font'); ?>; }
	</style>
	<?php } ?>


	<script type="text/javascript">
		jQuery(document).ready(function(){
			
			// Only load content if jquery is loaded
			setTimeout(jQuery('#page').fadeIn(), 3000);

			// Uniform Support
			jQuery('.cyonform input[type=radio], .cyonform input[type=checkbox], .cyonform input[type=file], .cyonform select:not(#rating)').uniform();
				<?php if (is_plugin_active('woocommerce/woocommerce.php')) { ?>
				// Check woocommerce
				jQuery('.payment_methods input.input-radio').live('click', function() {
					jQuery('.checkout input[type=radio], .checkout input[type=checkbox], .checkout input[type=file], .checkout select:not(#rating)').uniform();
				});
				<?php } ?>
				<?php if (is_plugin_active('gravityforms/gravityforms.php')) { ?>
				// Check gravity form
				jQuery(document).bind('gform_post_render', function(){
					jQuery('.cyonform input[type=radio], .cyonform input[type=checkbox], .cyonform input[type=file], .cyonform select:not(#rating)').uniform();
				});
				<?php } ?>

			<?php if(of_get_option('lazyload')==1){ ?>
			// Lazy Load Support
			jQuery("img").lazyload({ 
				effect : "fadeIn",
				skip_invisible : false
			});
			<?php } ?>

			<?php if(of_get_option('background_style')=='full' && CYON_PAGE_BG_IMAGE<>''){ ?>
			// Supersized Support
			jQuery.supersized({ 
				slides  :  	[ {image : '<?php echo CYON_PAGE_BG_IMAGE ?>', title : ''} ]
			});
			<?php } ?>

			<?php if(of_get_option('background_style')=='youtube' && of_get_option('background_style_youtube')<>''){ ?>
			// Tubular Support
			jQuery('body').tubular('<?php echo of_get_option('background_style_youtube') ?>','wrapper');
			<?php } ?>

			<?php if ( of_get_option('footer_backtotop') ){ ?>
			// Back to Top
			jQuery('#backtotop a').click(function() {
				jQuery('body,html').animate({scrollTop:0},'slow');
			});	
			checkheight();
			jQuery(window).scroll(function(){
				checkheight();
			});
			function checkheight(){
				if(jQuery(document).height() == jQuery(this).height()) {
					jQuery('#backtotop').hide();
				}else{
					jQuery('#backtotop').fadeIn();
				}
			}
			<?php } ?>
			<?php if(CYON_BLOG_LIST_MASONRY==1){ ?>
			jQuery('.masonry').masonry({
				itemSelector: 'article',
				columnWidth: function( containerWidth ) {
					return containerWidth / <?php echo CYON_BLOG_LIST_LAYOUT; ?>;
				}
			});
			<?php } ?>

			<?php if(of_get_option('lightbox_activate')==1){ ?>
			// Fancy Box Support
			jQuery('a img.size-medium, a img.size-thumbnail, a img.size-large').parent().addClass("fancybox");
			jQuery('.gallery a').attr('rel', 'group');
			jQuery('.fancybox-media').fancybox({
				openEffect	: 'none',
				closeEffect	: 'none',
				helpers : {
					media : { }
				}
			});
			jQuery('.fancybox').fancybox({
				openEffect	: 'elastic',
				closeEffect	: 'elastic',
				helpers : {
					title : {
						type : 'over'
					}
				}
			});
			jQuery('.iframe').fancybox({
				type		: 'iframe'
			});
			jQuery('.gallery a').filter(function() {
				return jQuery(this).attr('href').match(/\.(jpg|jpeg|png|gif|bmp|JPG|JPEG|PNG|GIF|BMP)/);
			}).addClass("fancybox-group");
			<?php if(of_get_option('lightbox_gallery_style')=='buttons'){ ?>
			jQuery(".fancybox-group").fancybox({
				openEffect	: 'elastic',
				closeEffect	: 'elastic',
				prevEffect : 'none',
				nextEffect : 'none',
				closeBtn  : false,
				helpers : {
					title : {
						type : 'over'
					},
					buttons	: {}
				},
				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});
			<?php }elseif(of_get_option('lightbox_gallery_style')=='thumbnails'){ ?>
			jQuery(".fancybox-group").fancybox({
				openEffect	: 'elastic',
				closeEffect	: 'elastic',
				prevEffect : 'none',
				nextEffect : 'none',
				closeBtn  : false,
				arrows    : false,
				nextClick : true,
				helpers : {
					title : {
						type : 'over'
					},
					thumbs	: {
						width	: 50,
						height	: 50
					}
				}
			});
			<?php }else{ ?>
			jQuery(".fancybox-group").fancybox({
				openEffect	: 'elastic',
				closeEffect	: 'elastic',
				helpers : {
					title : {
						type : 'over'
					}
				}
			});
			<?php } ?>
			<?php } ?>
	
			<?php if(CYON_BLOG_LIST_LAYOUT!=1 || CYON_BLOG_LIST_MASONRY=='no'){ ?>
			// Post list columns
			jQuery('.row-fluid > article:nth-of-type(<?php echo CYON_BLOG_LIST_LAYOUT; ?>n+1)').addClass('first-child');
			<?php } ?>
			
			// Dropdown select menu for mobile
			jQuery('#drop-nav').change(function(){
				window.location.href = this.value;
			});
			
		});
	</script> 
<?php
 	echo of_get_option('header_scripts');
}
add_action ( 'wp_head', 'cyon_header_js_css_hook',100);

function cyon_header_dark(){ ?>
	<?php if(of_get_option('theme_color')=='dark'){ ?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/assets/css/theme-dark.css" />
	<?php } ?>
<?php }
add_action ( 'wp_head', 'cyon_header_dark',200);

/* Hook JS/CSS script Footer */
function cyon_footer_js_css_hook(){
	echo of_get_option('footer_scripts_hook'); ?>
<?php }
add_action ( 'wp_footer', 'cyon_footer_js_css_hook', 100);


/* =SEO hooks
----------------------------------------------- */
/* Page Title */
function cyon_wp_title($title){
	global $post;

	$BLOGTITLE = get_bloginfo( 'name' );
	$BLOGTAGLINE = get_bloginfo( 'description' );
	if(of_get_option('seo_activate')==1){
		if(is_page() || is_single()){
			if(get_post_meta($post->ID,'cyon_meta_title',true)!=''){
				$PAGETITLE = get_post_meta($post->ID,'cyon_meta_title',true);
			}else{
				$PAGETITLE = get_the_title($post->ID);
			}
		}else{
			$PAGETITLE = $title;
		}
		$filtered_title = preg_replace('/\{([A-Z]+)\}/e', '$$1', of_get_option('seo_title_format'));
	}else{
		if(is_home() || is_front_page()){
			$filtered_title = $BLOGTITLE.' | '.$BLOGTAGLINE;
		}else{
			$filtered_title = $title.' | '.$BLOGTITLE;
		}
	}
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) ) : '';
	return $filtered_title;
}
add_filter( 'wp_title', 'cyon_wp_title' );

/* Meta */
function cyon_header_meta(){
	global $post;
	if(of_get_option('seo_activate')==1 && (is_page() || is_single())){
		echo get_post_meta($post->ID,'cyon_meta_desc',true)!='' ? '<meta name="description" content="'.get_post_meta($post->ID,'cyon_meta_desc',true).'" />' : '';
		echo get_post_meta($post->ID,'cyon_meta_keywords',true)!='' ? '<meta name="keywords" content="'.get_post_meta($post->ID,'cyon_meta_keywords',true).'" />' : '';
		if(get_post_meta($post->ID,'cyon_robot',true)){
			add_action('wp_head','wp_no_robots');
		}
	}
}
add_action('wp_head','cyon_header_meta',1);

/* =Header hooks
----------------------------------------------- */

/* Top Columns */
function cyon_header_columns_hook(){
	if(of_get_option('top_left_content') || of_get_option('top_right_content')){ ?>
	<!-- Top Contents -->
	<div id="top" class="row-fluid">
		<?php if(of_get_option('top_left_content')){ ?>
		<div class="span6">
			<p><?php echo do_shortcode(of_get_option('top_left_content', true)); ?></p>
		</div>
		<?php } ?>
		<?php if(of_get_option('top_right_content')){ ?>
		<div class="span6 right">
			<p><?php echo do_shortcode(of_get_option('top_right_content', true)); ?></p>
		</div>
		<?php } ?>
	</div>
	<?php }
}
add_action('cyon_header','cyon_header_columns_hook',10);


/* Logo / Sitename */
function cyon_header_logo_hook(){ ?>
	<!-- Logo / Site Name -->
	<hgroup>
		<?php if(of_get_option('header_logo')!=''){ ?>
		<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo of_get_option('header_logo'); ?>" /></a></span></h1>
		<?php }else{ ?>
		<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
		<?php } ?>
		<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
	</hgroup> <?php
}
add_action('cyon_header','cyon_header_logo_hook',20);


/* Logo / Sitename */
function cyon_header_mainnav_hook(){ ?>
	<!-- Main Menu -->
	<nav id="access" role="navigation">
		<h3 class="assistive-text"><?php _e( 'Main menu', 'cyon' ); ?></h3>
		<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
		<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'items_wrap' => '<select id="drop-nav"><option value="">Select a page...</option>%3$s</select>', 'show_description' => false, 'container' => false, 'walker'  => new Walker_Nav_Menu_Dropdown() ) ); ?>
	</nav> <?php
}
add_action('cyon_header','cyon_header_mainnav_hook',30);

class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
    function start_lvl(&$output, $depth){
      $indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
    }

    function end_lvl(&$output, $depth){
      $indent = str_repeat("\t", $depth); // don't output children closing tag
    }

    function start_el(&$output, $item, $depth, $args){
      // add spacing to the title based on the depth
      $item->title = str_repeat("&nbsp;", $depth * 4).$item->title;



       // $output .= $indent . ' id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';  
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';  
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';  
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';  
        $attributes .= ! empty( $item->url )        ? ' value="'   . esc_attr( $item->url        ) .'"' : '';  
        
        $item_output .= '<option'. $attributes .'>';  
        $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );  
        $item_output .= '</option>';  
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );  



      // no point redefining this method too, we just replace the li tag...
      $output = str_replace('<li', '<option', $output);
    }

    function end_el(&$output, $item, $depth){
      $output .= "</option>\n"; // replace closing </li> with the option tag
    }
}

/* =Before Body hooks
----------------------------------------------- */

/* =After Body hooks
----------------------------------------------- */

/* =Before Body Wrapper hooks
----------------------------------------------- */
/* Breadcrumb */
function cyon_breadcrumb_hook(){
	cyon_breadcrumb();
}
add_action('cyon_before_body_wrapper','cyon_breadcrumb_hook',10);


/* =After Body Wrapper hooks
----------------------------------------------- */

/* =Before Primary hooks
----------------------------------------------- */

/* =After Primary hooks
----------------------------------------------- */
/* Comments */
function cyon_comments_hook(){
	if(of_get_option('content_comment')=='enable' && (is_home() || is_front_page() || is_page() || is_single())) {
		comments_template( '', true );
	}
}
add_action('cyon_primary_after','cyon_comments_hook',10);

/* =Before Content Header hooks
----------------------------------------------- */

/* =After Content Header hooks
----------------------------------------------- */

/* =Before Content Post hooks
----------------------------------------------- */
/* Featured image on Posts/Pages */
function cyon_post_content_featured_image_content(){
	$pages = of_get_option('content_featured_image' ); ?>
	<?php if(has_post_thumbnail() && (is_single() && $pages['posts']==1) || (is_page() && $pages['pages']==1)){ ?>
		<div class="entry-featured-image">
			<?php the_post_thumbnail('large');?>
		</div>
	<?php }elseif(has_post_thumbnail() && (is_category() || is_archive() || is_home()) && $pages['listings']==1 ){ ?>
		<div class="entry-featured-image">
			<?php if(has_post_format('video')){ ?>
				<?php
				$video = '';
				$file = pathinfo(rwmb_meta( 'cyon_video_url' ));
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
					add_action('wp_footer','cyon_video_audio_js_css',20);
					?>
					<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
					<video width="100%" height="100%" controls preload="none" poster="<?php echo $large_image_url[0]; ?>">
						<source type="video/<?php echo $type; ?>" src="<?php echo rwmb_meta( 'cyon_video_url' ); ?>" />
					<?php if($type=='mp4' || $type=='m4v' || $type=='mov' || $type=='flv'){ ?>
						<object width="100%" height="auto" type="application/x-shockwave-flash" data="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.flashmediaelement.swf"><param name="movie" value="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.flashmediaelement.swf" /><param name="flashvars" value="controls=true&poster=<?php echo $large_image_url[0]; ?>&file=<?php echo rwmb_meta( 'cyon_video_url' ); ?>" /></object>
					<?php } ?>
					</video>
				<?php }else{
				$icon = 'facetime_video';
					?>
				<a href="<?php echo rwmb_meta( 'cyon_video_url' ); ?>" <?php if(of_get_option('lightbox_activate')==1){ ?>class="fancybox-media"<?php }else{ ?>target="_blank"<?php } ?>><?php the_post_thumbnail( of_get_option('content_thumbnail_size') ); ?><span class="status-box"><span class="icon-box icon2x-<?php echo $icon; ?>"></span></span></a>
				<?php }	?>
			<?php }elseif(has_post_format('image')){
				$icon = 'zoom_in';
				?>
				<?php $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); ?>
				<a href="<?php echo $image_attributes[0]; ?>" <?php if(of_get_option('lightbox_activate')==1){ ?>class="fancybox"<?php }else{ ?>target="_blank"<?php } ?>><?php the_post_thumbnail( of_get_option('content_thumbnail_size') ); ?><span class="status-box"><span class="icon-box icon2x-<?php echo $icon; ?>"></span></span></a>
			<?php }else{ ?>
				<?php 
				if(has_post_format('link')){
					$url = rwmb_meta( 'cyon_link_url' );
					$icon = 'share';
				}else{
					$url = get_permalink();
					$icon = 'circle_info';
				}
				?>
				<a href="<?php echo $url; ?>"><?php the_post_thumbnail( of_get_option('content_thumbnail_size') ); ?><span class="status-box"><span class="icon-box icon2x-<?php echo $icon; ?>"></span></span></a>
				<?php if(has_post_format('audio')){ ?>
					<?php
					add_action('wp_footer','cyon_video_audio_js_css',20);
					$file = pathinfo(rwmb_meta( 'cyon_audio_url' )); ?>
					<audio width="100%" src="<?php echo rwmb_meta( 'cyon_audio_url' ) ?>" type="audio/<?php echo $file['extension']; ?>" controls preload="none">
					<?php if($file['extension']=='mp4' || $file['extension']=='mpeg' || $file['extension']=='m4a' || $file['extension']=='flv'){ ?>
						<object width="100%" height="30" type="application/x-shockwave-flash" data="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.flashmediaelement.swf"><param name="movie" value="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.flashmediaelement.swf" /><param name="flashvars" value="controls=true&file=<?php echo rwmb_meta( 'cyon_audio_url' ) ?>" /><?php _e('No video playback capabilities','cyon'); ?>" /></object>
					<?php } ?>
					</audio>				
				<?php } ?>
			<?php } ?>
		</div>
	<?php } ?>
<?php }
add_action('cyon_post_content_before','cyon_post_content_featured_image_content',10);


/* =After Content Post hooks
----------------------------------------------- */
/* Social bookmarks */
function cyon_socialshare_hook() {
	$social = of_get_option('socialshare' );
	$socialb = of_get_option('socialshareboxes' );
	$socialboxes = '';
	if($socialb['facebook']==1){
		$socialboxes .= '<span class="st_facebook_hcount" displayText="Facebook"></span>';
	}
	if($socialb['twitter']==1){
		$socialboxes .= '<span class="st_twitter_hcount" displayText="Tweet"></span>';
	}
	if($socialb['plus']==1){
		$socialboxes .= '<span class="st_googleplus_hcount" displayText="Google +"></span>';
	}
	if($socialb['pinterest']==1){
		$socialboxes .= '<span class="st_pinterest_hcount" displayText="Pinterest"></span>';
	}
	if($socialb['mail']==1){
		$socialboxes .= '<span class="st_email_hcount" displayText="Email"></span>';
	}
	if($socialb['sharethis']==1){
		$socialboxes .= '<span class="st_sharethis_hcount" displayText="ShareThis"></span>';
	}
	if(($social['posts']==1 && (is_single())) || ($social['listings']==1 && (is_category() || is_home() || is_archive()))){
		echo '<div class="share">'.$socialboxes.'</div>';
		add_action ('wp_footer','cyon_social_js',10);
	}
}
add_action ('cyon_post_content_after','cyon_socialshare_hook',20);

function cyon_social_js(){ ?>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "32ae9ff6-93e1-4428-9772-72735858587d"});</script>
<?php }

/* Read more */
function cyon_readmore() {
	if((is_archive() || is_home()) && of_get_option('content_blog_post')=='excerpt'){
	 ?>
		<p class="readmore"><a href="<?php the_permalink(); ?>"><?php _e('Read more','cyon'); ?></a></p>
<?php	}
}
add_action ('cyon_post_content_after','cyon_readmore',10);


/* =Footer Post hooks
----------------------------------------------- */
function cyon_author_hook(){
	if(of_get_option('content_author')=='enable' && is_single()) { 
		if ( get_the_author_meta( 'description' ) && ( ! function_exists( 'is_multi_author' ) || is_multi_author() ) ) { // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
		<div id="author-info">
			<div id="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), '68' ); ?>
			</div>
			<div id="author-description">
				<h2><?php printf( __( 'About %s', 'cion' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<div id="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" class="button">
						<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'cion' ), get_the_author() ); ?>
					</a>
				</div>
			</div>
		</div>
		<?php }
	}
}
add_action ('cyon_post_footer','cyon_author_hook',10);

/* =Inside Homepage Body hooks
----------------------------------------------- */
/* Middle Block */
function cyon_homepage_middle_block_hook(){
	if ( of_get_option('homepage_middle')=='twitter' && is_front_page()){ ?>
		<!-- Middle Content - Twitter -->
		<div id="middle" class="<?php echo of_get_option('homepage_middle'); ?>">
		   <ul id="twitter_update_list"><li>Loading tweet...</li></ul>
		</div>
	<?php }elseif(of_get_option('homepage_middle_block') && is_front_page()){ ?>
		<!-- Middle Content - Intro Text -->
		<div id="middle" class="<?php echo of_get_option('homepage_middle'); ?>">
			<?php echo do_shortcode(of_get_option('homepage_middle_block',true)); ?>
		</div>
	<?php }
}
add_action('cyon_home_content','cyon_homepage_middle_block_hook',20);

/* Widgets Columns */
function cyon_homepage_columns_hook(){
	if ( is_active_sidebar( 'home-columns' ) && is_front_page() ){ ?>
		<!-- Homepage Buckets -->
		<div id="home-buckets" class="row-fluid">
			<?php dynamic_sidebar( 'home-columns' ); ?>
		</div>
	<?php }
}
add_action('cyon_home_content','cyon_homepage_columns_hook',30);

/* Homepage Content */
function cyon_homepage_content_hook(){
	if ( is_front_page() && of_get_option('homepage_page_content')==1 ){ ?>
						<!-- Homepage Content -->
						<?php get_template_part( 'content', 'page' ); ?>
						<?php comments_template( '', true ); ?>
	<?php }
}
add_action('cyon_home_content','cyon_homepage_content_hook',40);


/* =Footer hooks
----------------------------------------------- */

/* Widgets Columns */
function cyon_footer_columns_hook(){
	if ( ! is_404() && is_active_sidebar( 'footer-columns' ) ){ ?>
	<!-- Footer Columns -->
	<div id="footer-buckets" role="complementary" class="row-fluid">
		<?php dynamic_sidebar( 'footer-columns' ); ?>
	</div>
	<?php }
}
add_action('cyon_footer','cyon_footer_columns_hook',10);

/* Copyright */
function cyon_footer_copyright_hook(){ ?>
	<!-- Copyright -->
	<div id="bottom" class="row-fluid">
		<?php echo of_get_option('footer_copyright') != '' ? '<div class="copyright span6"><p>'.do_shortcode(of_get_option('footer_copyright')).'</p></div>' : ''; ?>
		<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'depth' => '1', 'container_id' => 'access2', 'container_class' => 'span6', 'fallback_cb' => false ) ); ?>
	</div><?php
}
add_action('cyon_footer','cyon_footer_copyright_hook',20);

/* Subfooter */
function cyon_footer_subfooter_hook(){
	if ( of_get_option('footer_sub') ){ ?>
	<!-- Sub Footer -->
	<div id="subfooter">
		<?php echo do_shortcode(of_get_option('footer_sub')); ?>
	</div>
	<?php }
}
add_action('cyon_footer','cyon_footer_subfooter_hook',30);

/* Back to Top */
function cyon_footer_backtotop_hook(){
	if ( of_get_option('footer_backtotop') ){ ?>
	<!-- Back to Top -->
	<div id="backtotop">
		<p><a href="#"><?php _e('Back to Top'); ?> </a></p>
	</div>
	<?php }
}
add_action('cyon_footer','cyon_footer_backtotop_hook',40);


/* =Replace Login logo
----------------------------------------------- */
function my_login_head() { ?>
	<style>
	body.login { background-color:<?php echo of_get_option('admin_login_bgcolor'); ?>; }
	body.login #login h1 a {
		<?php if(of_get_option('header_logo')!=''){ ?>
		background: url('<?php echo of_get_option('header_logo'); ?>') no-repeat scroll 50% transparent;
		height:150px;
		margin-bottom:10px;
		<?php }else{ ?>
		text-indent:0;
		background:none;
		<?php } ?>
		text-align:center;
		text-decoration:none;
		line-height:30px;
		font-size:30px;
	}
	body.login #login { padding-top:50px; }
	</style>
<?php }
add_action("login_head", "my_login_head");
add_filter('login_headerurl', create_function(false,"return '".get_bloginfo('wpurl')."';"));
add_filter('login_headertitle', create_function(false,"return 'Back to ".esc_attr( get_bloginfo( 'name', 'display' ) )."';"));


/* =Remove Gallery Style
----------------------------------------------- */
add_filter( 'use_default_gallery_style', '__return_false' );


/* =Add Ancestor Body CSS
----------------------------------------------- */
function cyon_get_ancestor_class($classes) {
	global $post;
	if(!is_404()){
		if(!is_404() || !is_front_page()){
			$parents = array_reverse(get_post_ancestors( $post->ID ));
			if( is_page() && $parents[0]<>'' ) { 
				$classes[] = 'page-ancestor-'.$parents[0];
			}
		}
		if(is_archive() || is_home()){
			$classes[] = 'blog-list-'.CYON_BLOG_LIST_LAYOUT;
		}
	}
	return $classes;
}
add_filter('body_class','cyon_get_ancestor_class');


/* =Add CSS for Blog listing if multiple columns
----------------------------------------------- */
function cyon_post_layout_class($classes) {
	global $post;
	if(CYON_BLOG_LIST_LAYOUT==2){
		$classes[] = 'span6';
	}elseif(CYON_BLOG_LIST_LAYOUT==3){
		$classes[] = 'span4';
	}elseif(CYON_BLOG_LIST_LAYOUT==4){
		$classes[] = 'span3';
	}
	return $classes;
}

add_filter('post_class','cyon_post_layout_class');

function cyon_check_list_layout(){
	$cols = 1;
	if(is_category()){
		if(get_tax_meta(CYON_TERM_ID,'cyon_cat_layout_listing')=='list-1column'){
			$cols = '1';
		}elseif(get_tax_meta(CYON_TERM_ID,'cyon_cat_layout_listing')=='list-2columns'){
			$cols = '2';
		}elseif(get_tax_meta(CYON_TERM_ID,'cyon_cat_layout_listing')=='list-3columns'){
			$cols = '3';
		}elseif(get_tax_meta(CYON_TERM_ID,'cyon_cat_layout_listing')=='list-4columns'){
			$cols = '4';
		}else{
			if(of_get_option('blog_list_layout')=='list-2columns'){
				$cols = '2';
			}elseif(of_get_option('blog_list_layout')=='list-3columns'){
				$cols = '3';
			}elseif(of_get_option('blog_list_layout')=='list-4columns'){
				$cols = '4';
			}
		}
	}elseif(is_front_page() || is_home() || is_archive() || is_category() && of_get_option('blog_list_layout')!='list-1column'){
		if(of_get_option('blog_list_layout')=='list-2columns'){
			$cols = '2';
		}elseif(of_get_option('blog_list_layout')=='list-3columns'){
			$cols = '3';
		}elseif(of_get_option('blog_list_layout')=='list-4columns'){
			$cols = '4';
		}
	}
	define('CYON_BLOG_LIST_LAYOUT',$cols);

	$masonry = '';
	if(is_category() && CYON_BLOG_LIST_LAYOUT!='1'){
		if(get_tax_meta(CYON_TERM_ID,'cyon_cat_masonry')=='yes'){
			$masonry = 1;
		}elseif(get_tax_meta(CYON_TERM_ID,'cat_masonry')=='no'){
			$masonry = 0;
		}else{
			$masonry = of_get_option('blog_list_masonry');
		}
	}elseif(is_front_page() || is_home() || is_archive() && of_get_option('blog_list_layout')!='list-1column'){
		$masonry = of_get_option('blog_list_masonry');
	}
	define('CYON_BLOG_LIST_MASONRY',$masonry);
	if(CYON_BLOG_LIST_MASONRY==1){
		wp_enqueue_script('jquery-masonry');
	}
}
add_action('wp_head','cyon_check_list_layout',20);

/* =Register new widgets
----------------------------------------------- */
function cyon_custom_widgets_init(){

	/* Register Widget 1 */
	if(strlen(of_get_option('widget_1_name'))>0){
		register_sidebar( array(
			'name' => __( of_get_option('widget_1_name'), 'cyon' ),
			'id' => 'cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_1_name'))),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}

	/* Register Widget 2 */
	if(strlen(of_get_option('widget_2_name'))>0){
		register_sidebar( array(
			'name' => __( of_get_option('widget_2_name'), 'cyon' ),
			'id' => 'cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_2_name'))),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}

	/* Register Widget 2 */
	if(strlen(of_get_option('widget_2_name'))>0){
		register_sidebar( array(
			'name' => __( of_get_option('widget_2_name'), 'cyon' ),
			'id' => 'cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_2_name'))),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}

	/* Register Widget 3 */
	if(strlen(of_get_option('widget_3_name'))>0){
		register_sidebar( array(
			'name' => __( of_get_option('widget_3_name'), 'cyon' ),
			'id' => 'cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_3_name'))),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'cyon_custom_widgets_init' );

/* Hook widgets */
function cyon_custom_widget_hooks() {
	if(strlen(of_get_option('widget_1_name'))>0){
		add_action(of_get_option('widget_1_location'), 'cyon_widget_1', (int)of_get_option('widget_1_order'));
	}
	if(strlen(of_get_option('widget_2_name'))>0){
		add_action(of_get_option('widget_2_location'), 'cyon_widget_2', (int)of_get_option('widget_2_order'));
	}
	if(strlen(of_get_option('widget_3_name'))>0){
		add_action(of_get_option('widget_3_location'), 'cyon_widget_3', (int)of_get_option('widget_3_order'));
	}
}
add_action('init','cyon_custom_widget_hooks');

function cyon_widget_1(){
	echo '<div class="widget-custom" id="cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_1_name'))).'" role="complimentary"><div class="widget-wrapper">'; dynamic_sidebar('cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_1_name')))); echo '</div></div>';
}
function cyon_widget_2(){
	echo '<div class="widget-custom" id="cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_2_name'))).'" role="complimentary"><div class="widget-wrapper">'; dynamic_sidebar('cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_2_name')))); echo '</div></div>';
}
function cyon_widget_3(){
	echo '<div class="widget-custom" id="cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_3_name'))).'" role="complimentary"><div class="widget-wrapper">'; dynamic_sidebar('cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_3_name')))); echo '</div></div>';
}