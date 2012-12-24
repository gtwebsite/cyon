<?php

/* Load Options Framework Theme */

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/' );
	require_once dirname( __FILE__ ) . '/framework/options-framework.php';
}

/* Set Constants */

define('CYON_FILEPATH', TEMPLATEPATH);
define('CYON_DIRECTORY', get_bloginfo('template_directory'));


/* Setup WP first */

if ( ! function_exists( 'cyon_setup' ) ){
	function cyon_setup() {
		
		// Languages
		load_theme_textdomain( 'cyon', get_template_directory() . '/lang' );
		$locale = get_locale();
		$locale_file = get_template_directory() . "/lang/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		/* These files build out the options interface.  Likely won't need to edit these. */
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		require_once (CYON_FILEPATH . '/includes/admin/init.php');				// Framework
		require_once (CYON_FILEPATH . '/includes/functions/common.php');		// Common Fuctions
		require_once (CYON_FILEPATH . '/includes/shortcodes/common.php');		// Common Shortcodes
		require_once (CYON_FILEPATH . '/includes/widgets/common.php');			// Common Widgets
		require_once (CYON_FILEPATH . '/includes/overrides/common.php');		// Overrides
		
		add_filter('widget_text', 'shortcode_unautop');
		add_filter('widget_text', 'do_shortcode');
		
		// Add default posts and comments RSS feed links to <head>.
		add_theme_support( 'automatic-feed-links' );

		// This theme supports a variety of post formats. , 'link', 'quote', 'video', 'audio', 'gallery'
		add_theme_support( 'post-formats', array( 'aside', 'image' ) );

		// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
		add_theme_support( 'post-thumbnails' );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'main-menu' => __( 'Main Menu', 'cyon' ),
			'footer-menu' => __( 'Footer Menu', 'cyon' ),
		) );

		// Add Excerpt on Pages.
		add_post_type_support( 'page', 'excerpt' );

	}
}
add_action( 'after_setup_theme', 'cyon_setup' );

/* Register Widgets */

function cyon_widgets_init() {

	/* Check home bucket columns */
	if(of_get_option('homepage_bucket_layout')=='bucket-4columns'){
		$homeclass = ' span3';
	}elseif(of_get_option('homepage_bucket_layout')=='bucket-3columns'){
		$homeclass = ' span4';
	}elseif(of_get_option('homepage_bucket_layout')=='bucket-2columns'){
		$homeclass = ' span6';
	}else{
		$homeclass = ' span12';
	}

	/* Check footer bucket columns */
	if(of_get_option('footer_bucket_layout')=='bucket-4columns'){
		$footclass = ' span3';
	}elseif(of_get_option('footer_bucket_layout')=='bucket-3columns'){
		$footclass = ' span4';
	}elseif(of_get_option('footer_bucket_layout')=='bucket-2columns'){
		$footclass = ' span6';
	}else{
		$footclass = ' span12';
	}

	register_sidebar( array(
		'name' => __( 'Homepage Buckets', 'cyon' ),
		'id' => 'home-columns',
		'before_widget' => '<aside id="%1$s" class="widget %2$s'.$homeclass.'">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Left Sidebar', 'cyon' ),
		'id' => 'left-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Right Sidebar', 'cyon' ),
		'id' => 'right-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Buckets', 'cyon' ),
		'id' => 'footer-columns',
		'before_widget' => '<aside id="%1$s" class="widget %2$s'.$footclass.'">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'widgets_init', 'cyon_widgets_init' );

/* Category navigation */
function cyon_content_nav() {
	global $wp_query;
	if(function_exists( 'wp_pagenavi' )){
		wp_pagenavi();
	}else{
		if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav class="navigation">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'cyon' ); ?></h3>
				<div class="alignleft"><?php next_posts_link( __( '&laquo; Older Posts', 'cyon' ) ); ?></div>
				<div class="alignright"><?php previous_posts_link( __( 'Newer Posts &raquo;', 'cyon' ) ); ?></div>
			</nav>
		<?php endif;
	}
}

/* Meta tags on Single Posts */
function cyon_post_header_single_meta_hook(){
	if(is_single() || is_category() || is_home() || is_archive() ){
		echo '<p class="meta">';
			echo '<span class="posted-date">';
				echo '<span class="posted-day">'.esc_html( get_the_time('d') ).'</span> ';
				echo '<span class="posted-month">'.esc_html( get_the_time('M') ).'</span> ';
				echo '<span class="posted-year">'.esc_html( get_the_time('Y') ).'</span>';
			echo '</span> ';
			echo '<span class="posted-by">'.__('by').' <a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'">'.get_the_author().'</a></span> ';
			if(count(get_the_category())>1){
				$catps = 'ies';
			}else{
				$catps = 'y';
			}
			echo '<span class="categories-links">'.__('in categor'.$catps).' '.get_the_category_list( __( ', ', 'cyon' ) ).'</span> ';
			if(get_the_tag_list()){
				echo '<span class="tag-links">'.__('and tagged').' '.get_the_tag_list( '', __( ', ', 'cyon' ) ).'</span> ';
			}
			if(of_get_option('content_comment')=='enable') {
				$comments = wp_count_comments(get_the_ID());
				if($comments->approved==0){
					echo '<span class="comments"> | '.__('Be the first to').' <a href="'.get_permalink().'#respond">'.__('comment here').'</a>.</span>';
				}elseif($comments->approved==1){
					echo '<span class="comments">with <a href="'.get_permalink().'#comments">'.$comments->approved.' '.__('comment').'</a></span>';
				}else{
					echo '<span class="comments">with <a href="'.get_permalink().'#comments">'.$comments->approved.' '.__('comments)').'</a></span>';
				}
			}
		echo '</p>';
	}
}
add_action('cyon_post_header_after','cyon_post_header_single_meta_hook',10);

/* Comments */
function cyon_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'cyon' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'cyon' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'cyon' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'cyon' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'cyon' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'cyon' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'cyon' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}

/* Sample Unhook Actions */
function unhook_cyon_functions() {
	global $post;
	/* Change the order of the hook  */
	// remove_action('cyon_header','cyon_header_mainnav_hook',30);
	// add_action('cyon_header','cyon_header_mainnav_hook',10);
	add_filter('loop_shop_per_page', create_function('$cols', 'return 8;'));
}
add_action('init','unhook_cyon_functions');

