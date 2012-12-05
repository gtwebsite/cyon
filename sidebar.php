<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage Cyon Theme
 */

// Getting current category term
$current_cat = get_query_var('cat');
$term_slug = get_category ($current_cat);
$current_term = get_term_by( 'slug', $term_slug->slug, 'category' );
$term_id = $current_term->term_id;

?>
			<?php if(is_front_page()){ ?>
				<?php if(of_get_option('homepage_layout')!='general-1column'){ ?>
					<!-- Sidebars -->
					<div id="secondary" class="widget-area" role="complementary">
						<?php cyon_sidebar_before(); ?>
						<?php if(of_get_option('homepage_layout')=='general-2right'){ ?>
							<?php dynamic_sidebar( 'right-sidebar' ); ?>
						<?php }elseif(of_get_option('homepage_layout')=='general-2left'){ ?>
							<?php dynamic_sidebar( 'left-sidebar' ); ?>
						<?php } ?>
						<?php cyon_sidebar_after(); ?>
					</div>
				<?php } ?>
			<?php }elseif(is_home() && get_post_meta(get_option('page_for_posts', true),'cyon_layout',true)!='default'){ ?>
				<!-- Sidebars -->
				<div id="secondary" class="widget-area" role="complementary">
					<?php cyon_sidebar_before(); ?>
					<?php if(get_post_meta(get_option('page_for_posts', true),'cyon_layout',true)=='general-2right'){ ?>
						<?php dynamic_sidebar( 'right-sidebar' ); ?>
					<?php }elseif(get_post_meta(get_option('page_for_posts', true),'cyon_layout',true)=='general-2left'){ ?>
						<?php dynamic_sidebar( 'left-sidebar' ); ?>
					<?php } ?>
					<?php cyon_sidebar_after(); ?>
				</div>
			<?php }elseif( is_category() && get_tax_meta($term_id,'cyon_cat_layout')!='default' && get_tax_meta($term_id,'cyon_cat_layout')!='' ){ ?>
				<!-- Sidebars -->
				<div id="secondary" class="widget-area" role="complementary">
					<?php cyon_sidebar_before(); ?>
					<?php if(get_tax_meta($term_id,'cyon_cat_layout')=='general-2right'){ ?>
						<?php dynamic_sidebar( 'right-sidebar' ); ?>
					<?php }elseif(get_tax_meta($term_id,'cyon_cat_layout')=='general-2left'){ ?>
						<?php dynamic_sidebar( 'left-sidebar' ); ?>
					<?php } ?>
					<?php cyon_sidebar_after(); ?>
				</div>
			<?php }elseif( get_post_meta($post->ID,'cyon_layout',true)=='default' || !get_post_meta($post->ID,'cyon_layout',true) ){ ?>
				<!-- Sidebars -->
				<div id="secondary" class="widget-area" role="complementary">
					<?php cyon_sidebar_before(); ?>
					<?php if(of_get_option('general_layout')=='general-2right'){ ?>
						<?php dynamic_sidebar( 'right-sidebar' ); ?>
					<?php }elseif(of_get_option('general_layout')=='general-2left'){ ?>
						<?php dynamic_sidebar( 'left-sidebar' ); ?>
					<?php } ?>
					<?php cyon_sidebar_after(); ?>
				</div>
			<?php }else{ ?>
				<!-- Sidebars -->
				<div id="secondary" class="widget-area" role="complementary">
					<?php cyon_sidebar_before(); ?>
					<?php if(get_post_meta($post->ID,'cyon_layout',true)=='general-2right'){ ?>
						<?php dynamic_sidebar( 'right-sidebar' ); ?>
					<?php }elseif(get_post_meta($post->ID,'cyon_layout',true)=='general-2left'){ ?>
						<?php dynamic_sidebar( 'left-sidebar' ); ?>
					<?php } ?>
					<?php cyon_sidebar_after(); ?>
				</div>
			<?php } ?>
