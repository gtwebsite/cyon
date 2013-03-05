<?php
/**
 * The template for displaying all Woocommerce pages.
 *
 * @package WordPress
 * @subpackage Cyon Theme
 */

get_header(); ?>

				<!-- Center -->
				<div id="primary">
					<?php cyon_primary_before(); ?>
					<div id="content" role="main">		
						<?php woocommerce_content(); ?>
					</div>
					<?php cyon_primary_after(); ?>
				</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>