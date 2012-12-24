<?php
/**
 * The template for displaying content in the page.php template
 *
 * @package WordPress
 * @subpackage Cyon Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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

	<footer class="entry-meta">
		<?php cyon_post_footer(); ?>
		<?php edit_post_link( __( 'Edit', 'cyon' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
