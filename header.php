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
<title><?php wp_title(''); ?></title>
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

		<!-- Body -->
		<div id="main" class="<?php echo CYON_PAGE_LAYOUT; ?>">
			<div class="wrapper">
			
				<?php cyon_before_body_wrapper(); ?>
