<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage Cyon Theme
 */

?>
			<?php if(CYON_PAGE_LAYOUT!='general-1column'){ ?>
				<!-- Sidebars -->
				<div id="secondary" class="widget-area" role="complementary">
					<?php cyon_sidebar_before(); ?>
					<?php if(CYON_PAGE_LAYOUT=='general-2right'){ ?>
						<?php dynamic_sidebar( 'right-sidebar' ); ?>
					<?php }elseif(CYON_PAGE_LAYOUT=='general-2left'){ ?>
						<?php dynamic_sidebar( 'left-sidebar' ); ?>
					<?php } ?>
					<?php cyon_sidebar_after(); ?>
				</div>
			<?php } ?>
