<?php
/**
 * The template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Cyon Theme
 */

get_header(); ?>

				<!-- Center -->
				<div id="primary">
					<?php cyon_primary_before(); ?>
					<div id="content" role="main">
						<?php while ( have_posts() ) : the_post(); ?>
		
							<?php get_template_part( 'content', 'single' ); ?>
		
						<?php endwhile; ?>
					</div>
					<?php cyon_primary_after(); ?>
				</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>