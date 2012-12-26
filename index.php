<?php
/**
 * The homepage template file.
 *
 * @package WordPress
 * @subpackage Cyon Theme
 */

get_header(); ?>

				<!-- Center -->
				<div id="primary">
					<?php cyon_primary_before(); ?>
					<div id="content" role="main"<?php if (CYON_BLOG_LIST_LAYOUT!=1  && CYON_BLOG_LIST_MASONRY==0 ) { echo ' class="row-fluid"'; } ?>>
					<?php if ( have_posts() ) { ?>
						<?php if ( is_archive() ) { ?>
								<header class="category-header">
									<h1 class="category-title">
										<?php if ( is_day() ) : ?>
											<?php printf( __( 'Daily Archives: %s', 'cyon' ), '<span>' . get_the_date() . '</span>' ); ?>
										<?php elseif ( is_month() ) : ?>
											<?php printf( __( 'Monthly Archives: %s', 'cyon' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'cyon' ) ) . '</span>' ); ?>
										<?php elseif ( is_year() ) : ?>
											<?php printf( __( 'Yearly Archives: %s', 'cyon' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'cyon' ) ) . '</span>' ); ?>
										<?php elseif ( is_author() ) : ?>
											<?php if ( have_posts() ) : ?>
												<?php the_post(); ?>
											<?php endif; ?>
											<?php printf( __( 'Author Archives: %s', 'cyon' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?>
											<?php rewind_posts(); ?>
										<?php elseif ( is_tag() ) : ?>
											<?php printf( __( 'Posts Tagged: %s', 'cyon' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'cyon' ) ) . '</span>' ); ?>
										<?php else : ?>
											<?php printf( __( 'Category Archives: %s', 'cyon' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
										<?php endif; ?>
									</h1>
									<?php
										$category_meta = '';
										$category_image = get_tax_meta(CYON_TERM_ID,'cyon_cat_image');
										if ( ! empty( $category_image['id'] ) )
											$category_meta .= apply_filters( 'category_archive_image', wp_get_attachment_image( $category_image['id'], 'large' ) );
										$category_description = category_description();
										if ( ! empty( $category_description ) )
											$category_meta .= apply_filters( 'category_archive_meta', $category_description );
										if( !empty($category_meta))
											echo '<div class="category-archive-meta">'.$category_meta.'</div>';
									?>
								</header>
						<?php } ?>
						<?php if ( is_search() ) { ?>
								<header class="category-header">
									<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'cyon' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
								</header>
						<?php } ?>
						<?php echo CYON_BLOG_LIST_MASONRY==1 ? '<div class="masonry">' : ''; ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php $format = get_post_format(); if ( false === $format ) $format = 'single'; ?>
							<?php get_template_part( 'content', $format ); ?>
						<?php endwhile; ?>
						<?php echo CYON_BLOG_LIST_MASONRY==1 ? '</div>' : ''; ?>
						<?php cyon_content_nav(); ?>
						
					<?php }else{ ?>
		
						<article id="post-0" class="post no-results not-found">
							<header class="page-header">
								<h1 class="page-title"><?php _e( 'Nothing Found', 'cyon' ); ?></h1>
							</header>
		
							<div class="entry-content">
								<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'cyon' ); ?></p>
								<?php get_search_form(); ?>
							</div>
						</article>
		
					<?php } ?>
		
					</div>
					<?php cyon_primary_after(); ?>
				</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>