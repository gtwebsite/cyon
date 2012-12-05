<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Cyon Theme
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="<?php if(of_get_option('responsive')==1){ echo 'width=device-width, initial-scale=1.0'; }else{ echo 'width=1024'; } ?>">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7, IE=9" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'cyon' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	wp_head();
?>

</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed">

		<?php cyon_before_header(); ?>
	
		<!-- Header -->
		<header id="branding" role="banner" class="<?php echo of_get_option('header_layout'); ?>">
			<div class="wrapper">

				<!-- Screen Readers -->
				<ul class="skip-link">
					<li><a href="#primary" title="<?php esc_attr_e( 'Skip to primary content', 'cyon' ); ?>"><?php _e( 'Skip to primary content', 'cyon' ); ?></a></li>
					<li><a href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'cyon' ); ?>"><?php _e( 'Skip to secondary content', 'cyon' ); ?></a></li>
				</ul>
				
				<?php cyon_header(); ?>
				
			</div>
		</header>

		<?php cyon_before_body(); ?>
		<?php
			// Getting current category term
			$current_cat = get_query_var('cat');
			$term_slug = get_category ($current_cat);
			$current_term = get_term_by( 'slug', $term_slug->slug, 'category' );
			$term_id = $current_term->term_id;
		?>
		
		<!-- Body -->
		<div id="main" class="<?php if(is_front_page()) { echo of_get_option('homepage_layout'); }elseif(is_home() && get_post_meta(get_option('page_for_posts', true),'cyon_layout',true)!='default'){ echo get_post_meta(get_option('page_for_posts', true),'cyon_layout',true); }elseif(is_category() && get_tax_meta($term_id,'cyon_cat_layout')!='default' && get_tax_meta($term_id,'cyon_cat_layout')!=''){ echo get_tax_meta($term_id,'cyon_cat_layout'); }elseif( get_post_meta($post->ID,'cyon_layout',true)=='default' || !get_post_meta($post->ID,'cyon_layout',true) ){ echo of_get_option('general_layout'); }else{  echo get_post_meta($post->ID,'cyon_layout',true); } ?>">
			<div class="wrapper">
			
				<?php cyon_before_body_wrapper(); ?>
