<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Cyon Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><div class="article-wrapper">
	
	<?php if(is_single()){ ?>
	<!-- For individual View -->
	<header class="page-header">
		<?php cyon_post_header_before(); ?>
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php cyon_post_header_after(); ?>
	</header>
	<div class="page-content">
		<?php cyon_post_content_before(); ?>
		<?php the_content(); ?>
		<?php cyon_post_content_after(); ?>
	</div>
	
	<?php }else{ ?>
	
	<!-- For category View -->
	<header class="entry-header">
		<?php cyon_post_header_before(); ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php cyon_post_header_after(); ?>
	</header>
	<div class="entry-content">
		<?php cyon_post_content_before(); ?>
		<?php if(of_get_option('content_blog_post')=='excerpt'){ ?>
		<?php the_excerpt(); ?>
		<?php }else{ ?>
		<?php the_content(); ?>
		<?php } ?>
		<?php cyon_post_content_after(); ?>
	</div>
	
	<?php } ?>

	<footer class="entry-meta">
		<?php cyon_post_footer(); ?>
		<?php edit_post_link( __( 'Edit', 'cyon' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</div></article>
