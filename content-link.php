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
		<p><a href="<?php echo get_the_content(); ?>" class="has-icon" target="_blank"><span class="icon-share"></span> <?php echo get_the_content(); ?></a></p>
		<?php the_excerpt(); ?>
		<?php cyon_post_content_after(); ?>
	</div>
	
	<?php }else{ ?>
	
	<!-- For category View -->
	<header class="entry-header">
		<?php cyon_post_header_before(); ?>
		<h1 class="entry-title"><a href="<?php echo get_the_content(); ?>" target="_blank"><?php the_title(); ?></a></h1>
		<?php cyon_post_header_after(); ?>
	</header>
	<div class="entry-content">
		<?php cyon_post_content_before(); ?>
		<?php the_excerpt(); ?>
		<?php cyon_post_content_after(); ?>
	</div>
	
	<?php } ?>

	<footer class="entry-meta">
		<?php cyon_post_footer(); ?>
		<?php edit_post_link( __( 'Edit', 'cyon' ), '<span class="edit-link">', '</span>' ); ?>

	</footer>
</div></article>
