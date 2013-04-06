<?php
if ( !defined('ABSPATH') )
	die('-1');

/* =Includes
----------------------------------------------- */
require_once (CYON_FILEPATH . '/includes/shortcodes/columns.php');			// Up to 6 columns
require_once (CYON_FILEPATH . '/includes/shortcodes/price-grid.php');		// Price Grid

/* =Sample Short Code
use [cyon_hello]
----------------------------------------------- */

function cyon_hello() {
	return "Hello World!";
}

add_shortcode( 'sayhello', 'cyon_hello' );


/* =Toggle
use [toggle title='title'] xxx [/accordion]
----------------------------------------------- */
function cyon_toggle( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			title => 'Title Here'
		), $atts);
		
	$toggle_content .= '<div class="toggle"><h3 class="toggle-title">' . $atts['title'] . '</h3><div class="toggle-content">'. $content . '</div></div>';

	ob_start();
        add_action('wp_footer','cyon_toggle_js_css',10);
    ob_get_clean();
	
	return $toggle_content;
}
add_shortcode('toggle','cyon_toggle');

function cyon_toggle_js_css(){
	wp_enqueue_script('jquery');
?>
	<script type="text/javascript">
		// Toggle
		jQuery(document).ready(function(){
			jQuery('.toggle h3').click(function(){
				if(jQuery(this).parent().find('.toggle-content').is(":hidden")) {
					jQuery(this).parent().find('.toggle-content').slideDown(500);
					jQuery(this).addClass('toggle-active');
				} else {
					jQuery(this).parent().find('.toggle-content').slideUp(500);
					jQuery(this).removeClass('toggle-active');
				}
			});
			jQuery('.accordion .cyon-accordion-content').css('display','none');
		});
	</script> 
<?php }


/* =Accordion
use [accordion title='title'] xxx [/accordion]
----------------------------------------------- */
function cyon_accordion( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			title => 'Title Here'
		), $atts);
	$accordion_content = array('<div class="accordion"> <h3 class="accordion-title">' . $atts['title'] . '</h3><div class="accordion-content">'. $content . '</div></div>');
	ob_start();
        add_action('wp_footer','cyon_accordion_js_css',10);
    ob_get_clean();
	foreach ($accordion_content as $value){
		return $value ;
	}
}
add_shortcode('accordion','cyon_accordion'); 

function cyon_accordion_js_css(){
	wp_enqueue_script('jquery');
?>
	<script type="text/javascript">
		// Accordion
		jQuery(document).ready(function(){
			jQuery('.accordion h3').click(function(){
				if (jQuery(this).parent().find('.accordion-content').is(":hidden")) {
					jQuery('.accordion .accordion-content').slideUp(500);
					jQuery('.accordion h3').removeClass('accordion-active');
					jQuery(this).parent().find('.accordion-content').slideDown(500);
					jQuery(this).addClass('accordion-active');
				} else {
					jQuery('.accordion .accordion-content').slideUp(500);
					jQuery(this).removeClass('accordion-active');
				}
			});

		});
	</script> 
<?php }


/* =Tabs
use [tabs] [tab title=''] xxx [/tab] [/tabs]
----------------------------------------------- */
$tab_nav = array();
function cyon_tabs( $atts, $content = null ) {
	$GLOBALS['tab_count'] = 0;
	do_shortcode($content);
	$html = '<div class="tabs"><ul class="tab_nav">';
	foreach( $GLOBALS['tabs'] as $tab ){
		$html .= '<li><a href="#tab_'.$tab['index'].'">'.$tab['title'].'</a></li>';
	}
	$html .= '</ul>';
	foreach( $GLOBALS['tabs'] as $tab ){
		$html .= '<div id="tab_'.$tab['index'].'" class="panel"><h3>'.$tab['title'].'</h3>'.$tab['content'].'</div>';
	}
	$html .= '</div>';
	ob_start();
        add_action('wp_footer','cyon_tabs_js_css',10);
    ob_get_clean();
	return $html;
}
add_shortcode('tabs','cyon_tabs'); 

function cyon_tab( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			title => 'Title Name',
			active => false
		), $atts);
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title'=> $atts['title'], 'content' =>  do_shortcode($content), 'index' => $x );
	$GLOBALS['tab_count']++;
}
add_shortcode('tab','cyon_tab'); 

function cyon_tabs_js_css(){
	wp_enqueue_script('jquery');
?>
	<script type="text/javascript">
		// Tabs
		jQuery(document).ready(function(){
			jQuery('.tabs').each(function(){
				jQuery(this).find('.tab_nav li:first-child').addClass('active');
				jQuery(jQuery(this).find('.tab_nav li.active a').attr('href')).show();
				jQuery(this).find('.tab_nav li a').click(function(){
					var prev = jQuery(this).parent().parent().find('li.active a').attr('href');
					if (!jQuery(this).parent().hasClass('active')) {
						jQuery(this).parent().parent().find('li.active').removeClass('active');
						jQuery(this).parent().addClass('active');
					}
					var current = jQuery(this).attr('href');
					if(jQuery(jQuery(this).attr('href')).is(':hidden')){
						jQuery(prev).stop().slideUp('slow', function(){
							jQuery(current).stop().slideDown(500);
						});
					}
					event.preventDefault();
				});
			});
		});
	</script> 
<?php }

/* =Show Subpages
use [subpages excerpt='yes' thumbnail='no' id='' cols='' classname='']
----------------------------------------------- */
function cyon_subpages( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			excerpt 	=> 'yes',
			thumbnail 	=> 'no',
			classname 	=> '',
			cols	 	=> '',
			id 			=> get_the_ID()
		), $atts);
	$args = array(
		'sort_order' 	=> 'ASC',
		'sort_column' 	=> 'menu_order',
		'child_of' 		=> $atts['id'],
		'parent'		=>  $atts['id']
	);
	$subpages = get_pages($args);
	$result = '';
	if($atts['cols']>1){
		global $subpage_cols;
		$subpage_cols = $atts['cols'];
		$cols = 12 / $atts['cols'];
		$classli = ' class="span'.$cols.'"';
	}
	foreach ( $subpages as $page ) {
		$result .= '<li'.$classli.'>';
		if($atts['thumbnail']=='yes'){
			$result .= '<div class="page-thumb"><a href="' . get_page_link( $page->ID ) . '">'.get_the_post_thumbnail( $page->ID, 'thumbnail' ).'</a></div>';
		}
		$result .= '<h4><a href="' . get_page_link( $page->ID ) . '">' . $page->post_title . '</a></h4>';
		if($atts['excerpt']=='yes'){
			$result .= do_shortcode($page->post_excerpt);
		}
		$result .= '</li>';
		echo $option;
	}
	$class = 'subpages';
	if($atts['classname']){
		$class .= ' '.$atts['classname'];
	}
	if($atts['cols']>1){
		$class .= ' row-fluid';
		ob_start();
			add_action('wp_footer','cyon_cyon_subpages_js_css',10);
		ob_get_clean();
	}
	return '<ul class="'.$class.'">'.$result.'</ul>';
}
add_shortcode('subpages','cyon_subpages'); 

function cyon_cyon_subpages_js_css(){
		global $subpage_cols;
?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.subpages > li:nth-of-type(<?php echo $subpage_cols; ?>n+1)').addClass('first-child');
			});
		</script>
<?php }

/* =Show Blog
use [blog excerpt="yes" thumbnail="yes" cols="" items="4" cat_id="1" classname=""]
----------------------------------------------- */
function cyon_blog( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			excerpt 	=> 'yes',
			thumbnail 	=> 'yes',
			items 		=> 4,
			classname 	=> '',
			cols	 	=> '',
			cat_id 		=> 1
		), $atts);
	$args = array(
		'numberposts' 	=> $atts['items'],
		'category' 		=> $atts['cat_id']
	);
	$posts = get_posts($args);
	$result = '';
	if($atts['cols']>1){
		global $blog_cols;
		$blog_cols = $atts['cols'];
		$cols = 12 / $atts['cols'];
		$classli = ' class="span'.$cols.'"';
	}
	foreach ( $posts as $post ) {
		setup_postdata($post);
		$result .= '<li'.$classli.'>';
		if($atts['thumbnail']=='yes'){
			$result .= '<div class="entry-featured-image"><a href="' . get_page_link( $post->ID ) . '">'.get_the_post_thumbnail( $post->ID, of_get_option('content_thumbnail_size' ) ).'</a></div>';
		}
		$result .= '<h4><a href="' . get_page_link( $post->ID ) . '">' . $post->post_title . '</a></h4>';
		if($atts['excerpt']=='yes'){
			if($post->post_excerpt){
				$result .= $post->post_excerpt;
			}else{
				$result .= get_the_excerpt();
			}
		}
		$result .= '</li>';
		echo $option;
	}
	$class = 'postlist';
	if($atts['classname']){
		$class .= ' '.$atts['classname'];
	}
	if($atts['cols']>1){
		$class .= ' row-fluid';
		ob_start();
			add_action('wp_footer','cyon_cyon_blog_js_css',10);
		ob_get_clean();
	}
	wp_reset_query();
	return '<ul class="'.$class.'">'.$result.'</ul>';
}
add_shortcode('blog','cyon_blog'); 

function cyon_cyon_blog_js_css(){
		global $blog_cols;
?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.postlist > li:nth-of-type(<?php echo $blog_cols; ?>n+1)').addClass('first-child');
			});
		</script>
<?php }

/* =Map
use [map width='' height='350' zoom='14' long='' lat='' address='New York, USA'] xxx [/map]
----------------------------------------------- */
function cyon_map( $atts, $content = null, $id ) {
	$atts = shortcode_atts(
		array(
			width		=> '',
			height		=> '350',
			zoom		=> '14',
			lat			=> '',
			long		=> '',
			address		=> 'New York, USA'
		), $atts);
	ob_start();
		wp_enqueue_script('gmap');
	ob_get_clean();
	return '<div class="gmap" data-address="'.$atts['address'].'" data-lat="'.$atts['lat'].'" data-long="'.$atts['long'].'" data-zoom="'.$atts['zoom'].'" style="max-width: '.$atts['width'].'; height: '.$atts['height'].'px;">'. $content .'</div>';
}
add_shortcode('map','cyon_map'); 

/* =IFrame
use [iframe width='500' height='350' scroll='yes' url='http://localhost/']
----------------------------------------------- */
function cyon_iframe( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			width		=> '500',
			height		=> '350',
			scroll		=> 'yes',
			url			=> 'http://localhost/'
		), $atts);
	return '<div style="width:'.$atts['width'].'px; max-width:100%; height:'.$atts['height'].'px; overflow:visible;"><iframe style="max-width:100%;" width="'.$atts['width'].'" height="'.$atts['height'].'" frameborder="0" scrolling="'.$atts['scroll'].'" marginheight="0" marginwidth="0" src="'.$atts['url'].'"></iframe></div>';
}
add_shortcode('iframe','cyon_iframe'); 


/* =Video
use [video width='480' height='270' src='' poster='' subtitles='' chapters='']
----------------------------------------------- */
function cyon_video( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			width		=> '480',
			height		=> '270',
			poster		=> '',
			src			=> '',
			subtitles	=> '',
			chapters	=> ''
		), $atts);
	$html = '';
	if($atts['src']!=''){
		if(of_get_option('responsive')==1){ $style=' style="width:100%; height:100%;"'; }
		$domain = parse_url(strtolower($atts['src']));
		if($domain['host']=='www.youtube.com' || $domain['host']=='youtube.com' || $domain['host']=='youtu.be'){
			//$html .= '<video width="'.$atts['width'].'" height="'.$atts['height'].'" type="video/youtube" src="'.$atts['src'].'" preload="none"'.$style.' />';
			if(of_get_option('responsive')==1){ $html .= '<div class="flex-video">'; }
			$html .= '<iframe width="'.$atts['width'].'" height="'.$atts['height'].'" src="http://www.youtube.com/embed/'.get_youtube_id($atts['src']).'?showinfo=0" frameborder="0" allowfullscreen></iframe>';
			if(of_get_option('responsive')==1){ $html .= '</div>'; }
		}elseif($domain['host']=='www.vimeo.com' || $domain['host']=='vimeo.com'){
			//$html .= '<video width="'.$atts['width'].'" height="'.$atts['height'].'" type="video/vimeo" src="'.$atts['src'].'" preload="none"'.$style.' />';
			if(of_get_option('responsive')==1){ $html .= '<div class="flex-video flex-video-vimeo">'; }
			$html .= '<iframe src="http://player.vimeo.com/video/'.get_vimeo_id($atts['src']).'" width="'.$atts['width'].'" height="'.$atts['height'].'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			if(of_get_option('responsive')==1){ $html .= '</div>'; }
		}elseif($domain['scheme']=='rtmp'){
			$html .= '<video width="'.$atts['width'].'" height="'.$atts['height'].'" type="video/flv" src="'.$atts['src'].'" autoplay'.$style.' /></video>';
			ob_start();
				add_action('wp_footer','cyon_video_audio_js_css',20);
			ob_get_clean();
		}else{
			$type = '';
			$sources = explode(",", $atts['src']);
			$html .= '<video width="'.$atts['width'].'" height="'.$atts['height'].'" poster="'.$atts['poster'].'" controls="controls" preload="none"'.$style.'>';
			for($i=0; $i<count($sources); $i++){
				$file = pathinfo($sources[$i]);
				if ($file['extension'] == 'mp4'){
					$type = 'mp4';
				}elseif($file['extension'] == 'm4v'){
					$type = 'm4v';
				}elseif($file['extension'] == 'mov'){
					$type = 'mov';
				}elseif($file['extension'] == 'wmv'){
					$type = 'wmv';
				}elseif($file['extension'] == 'flv'){
					$type = 'flv';
				}elseif($file['extension'] == 'webm'){
					$type = 'webm';
				}elseif($file['extension'] == 'ogv'){
					$type = 'ogg';
				}
				if($type!=''){
					$html .= '<source type="video/'.$type.'" src="'.$sources[$i].'" />';
				}
				if($type=='mp4' || $type=='m4v' || $type=='mov' || $type=='flv'){
					$html .= '<object width="'.$atts['width'].'" height="'.$atts['height'].'" type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/assets/js/jquery.flashmediaelement.swf"><param name="movie" value="'.get_template_directory_uri().'/assets/js/jquery.flashmediaelement.swf" /><param name="flashvars" value="controls=true&poster='.$atts['poster'].'&file='.$sources[$i].'" /><img src="'.$atts['poster'].'" width="'.$atts['width'].'" height="'.$atts['height'].'" title="'.__('No video playback capabilities').'" /></object>';
				}
				if($atts['subtitles']!=''){
					$html .= '<track kind="subtitles" src="'.$atts['subtitles'].'" srclang="en" />';
				}
				if($atts['chapters']!=''){
					$html .= '<track kind="chapters" src="'.$atts['chapters'].'" srclang="en" />';
				}
				$html .= '</video>';
			}
			ob_start();
				add_action('wp_footer','cyon_video_audio_js_css',20);
			ob_get_clean();
		}
	}else{
		$html = __('No video source specified.');
	}
	return $html;
}
add_shortcode('video','cyon_video'); 

if (!function_exists('get_youtube_id')){
	function get_youtube_id($url) {
	
		// find the youtube-based URL in the post
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
			return $match[1];
		}	
	
	} // end get_youtube_id
}
if (!function_exists('get_vimeo_id')){
	function get_vimeo_id($content) {
	
		return (int) substr(parse_url($content, PHP_URL_PATH), 1);; 
	
	} 
}

/* =Audio
use [audio width='480' src='']
----------------------------------------------- */
function cyon_audio( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			width		=> '480',
			height		=> '30',
			src			=> ''
		), $atts);
	$html = '';
	if($atts['src']!=''){
		if(of_get_option('responsive')==1){ $style=' style="width:100%;"'; }
		$file = pathinfo($atts['src']);
		$html .= '<audio width="'.$atts['width'].'" src="'.$atts['src'].'" type="audio/'.$file['extension'].'" controls="controls" preload="none"'.$style.'>';
		if($file['extension']=='mp4' || $file['extension']=='mpeg' || $file['extension']=='m4a' || $file['extension']=='flv'){
			$html .= '<object width="'.$atts['width'].'" height="'.$atts['height'].'" type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/assets/js/jquery.flashmediaelement.swf"><param name="movie" value="'.get_template_directory_uri().'/assets/js/jquery.flashmediaelement.swf" /><param name="flashvars" value="controls=true&file='.$atts['src'].'" />'.__('No video playback capabilities').'" /></object>';
		}
		$html .= '</audio>';
		ob_start();
			add_action('wp_footer','cyon_video_audio_js_css',20);
		ob_get_clean();
	}else{
		$html = __('No audio source specified.');
	}
	return $html;
}
add_shortcode('audio','cyon_audio'); 

function cyon_video_audio_js_css(){
?>
	<script type="text/javascript">
		// Audio/Video
		jQuery(document).ready(function(){
			jQuery('video,audio').mediaelementplayer({
				success: function(player, node) {
					jQuery('#' + node.id + '-mode').html('mode: ' + player.pluginType);
				}
			});
		});
	</script>
<?php }

/* =Buttons
use [button color='' size='' icon='' url='' title='' classname=''] xxx [/button]
----------------------------------------------- */
function cyon_button( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			color		=> '',
			size		=> '',
			icon		=> '',
			url			=> '#',
			classname	=> '',
			title		=> ''
		), $atts);
	$classname = '';
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	if($atts['color']){
		$classname .= ' btn-'.$atts['color'];
	}
	if($atts['size']){
		$classname .= ' btn-'.$atts['size'];
	}
	$icon = '';
	if($atts['icon']){
		if($atts['size']=='large'){
			$classname .= ' has-icon2x';
			$icon = '<span class="icon2x-'.$atts['icon'].'"></span>';
		}else{
			$classname .= ' has-icon';
			$icon = '<span class="icon-'.$atts['icon'].'"></span>';
		}
	}
	$title = '';
	if($atts['title']){
		$classname .= ' hastip';
		$title = ' title="'. $atts['title'] . '"';
	}
	$html = '<a href="'. $atts['url'] . '" class="btn'.$classname.'"'.$title.'>'. $icon . $content . '</a>';
	return $html;
}
add_shortcode('button','cyon_button'); 

/* =Header Icons
use [header size='' icon='' classname=''] xxx [/header]
----------------------------------------------- */
function cyon_header_style( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			size		=> '2',
			classname	=> '',
			icon		=> 'right_arrow'
		), $atts);
	if($atts['size']==''){
		$atts['size'] = '2';
	}
	if($atts['icon']==''){
		$atts['icon'] = 'right_arrow';
	}
	$size = 'h'.$atts['size'];
	$classname = '';
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	$classname .= 'has-icon2x';
	$icon = '<span class="icon2x-'.$atts['icon'].'"></span>';
	$icon_content = array('<'.$size.' class="'.$classname.'">'. $icon . $content . '</'.$size.'>');
	foreach ($icon_content as $value){
		return $value ;
	}
}
add_shortcode('header','cyon_header_style'); 

/* =Inline Icons
use [icon element='' icon='' classname='' title='' url='' size=''] xxx [/icon]
----------------------------------------------- */
function cyon_inline_icon( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			element		=> 'span',
			classname	=> '',
			url			=> '',
			title		=> '',
			icon		=> '',
			size		=> ''
		), $atts);
	$classname = '';
	if($atts['size']=='large'){
		$classname .= 'has-icon2x';
		$iconsize = '2x';
	}else{
		$classname .= 'has-icon';
		$iconsize = '';
	}
	$element = $atts['element'];
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	$title = '';
	if($atts['title']){
		$classname .= ' hastip';
		$title = ' title="'. $atts['title'] . '"';
	}
	$url = '';
	if($atts['url'] || $atts['element']=='a'){
		$url = ' href="'. $atts['url'] . '"';
		$element = 'a';
	}
	if($atts['icon']=='' && ($atts['url'] || $atts['element']=='a')){
		$icon = 'icon'.$iconsize.'-share';
		$element = 'a';
	}elseif($atts['icon']==''){
		$icon = 'icon'.$iconsize.'-question-sign';
	}else{
		$icon = 'icon'.$iconsize.'-'.$atts['icon'];
	}
	$html = '<'.$element.' class="'.$classname.'"'.$title.$url.'><span class="'.$icon.'"></span> ' . $content . '</'.$element.'>';
	return $html;
}
add_shortcode('icon','cyon_inline_icon'); 

/* =Bulleted List
use [lists icon='' size="large" classname='' cols=''] [list icon=''] xxx [/list] [/lists]
----------------------------------------------- */
function cyon_bulleted_lists( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			icon		=> '',
			classname	=> '',
			size		=> '',
			cols		=> ''
		), $atts);
	$classname = '';
	if($atts['cols']){
		$classname .= ' cols'.$atts['cols'];
	}
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	if($atts['size']=='large'){
		$classname .= ' has-icon2x-list';
		$iconsize = '2x';
	}else{
		$classname .= ' has-icon-list';
		$iconsize = '';
	}
	if($atts['icon']==''){
		$icon = 'icon'.$iconsize.'-ok';
	}else{
		$icon = 'icon'.$iconsize.'-'.$atts['icon'];
	}
	$GLOBALS['iconlist'] = $icon;
	$GLOBALS['iconlist-size'] = $iconsize;
	$list_content = array('<ul class="clearfix'.$classname.'">'. do_shortcode($content) .'</ul>');
	foreach ($list_content as $value){
		return $value ;
	}
}
add_shortcode('lists','cyon_bulleted_lists'); 
function cyon_bulleted_list( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			icon		=> '',
			classname	=> ''
		), $atts);
	if($atts['icon']==''){
		$icon = $GLOBALS['iconlist'];
	}else{
		$icon = 'icon'.$GLOBALS['iconlist-size'].'-'.$atts['icon'];
	}
	$classname = '';
	if($atts['classname']){
		$classname = ' '.$atts['classname'];
	}
	$list_content = array('<li class="has-icon'.$GLOBALS['iconlist-size'].$classname.'"><span class="'.$icon.'"></span>'. do_shortcode($content) .'</li>');
	foreach ($list_content as $value){
		return $value ;
	}
}
add_shortcode('list','cyon_bulleted_list'); 

/* =Table
use [table caption='' headers='' footers=''] [/table]
----------------------------------------------- */
function cyon_table( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			classname	=> '',
			caption		=> '',
			headers		=> '',
			footers		=> ''
		), $atts);
	$classname = '';
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	$html = '<table class="table'.$classname.'">';
	if($atts['caption']){
		$html .= '<caption>'.$atts['caption'].'</caption>';
	}
	if($atts['headers']){
		$headers = explode('|',$atts['headers']);
		$html .= '<thead><tr>';
		for($i=0;$i<count($headers);$i++){
			$width = explode('%%',$headers[$i]);
			if(count($width)>0){
				$setwidth = ' style="width:'.$width[1].'%"';
				$html .= '<th'.$setwidth.'>'.$width[0].'</th>';
			}else{
				$html .= '<th'.$setwidth.'>'.$headers[$i].'</th>';
			}
		}
		$html .= '</tr></thead>';
	}
	if($atts['footers']){
		$footers = explode('|',$atts['footers']);
		$html .= '<tfoot><tr>';
		for($i=0;$i<count($footers);$i++){
			$html .= '<td>'.$footers[$i].'</td>';
		}
		$html .= '</tr></tfoot>';
	}
	$html .= '<tbody>'. do_shortcode($content).'</tbody>';
	$html .= '</table>';
	return $html;
}
add_shortcode('table','cyon_table'); 

function cyon_table_row( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			classname	=> '',
			color		=> ''
		), $atts);
	$classname = '';
	if($atts['color']!=''){
		$classname .= 'row-'.$atts['color'];
	}
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	if($classname!=''){
		$class = ' class="'.$classname.'"';
	}
	$row_content = array('<tr'.$class.'>'. do_shortcode($content) .'</tr>');
	foreach ($row_content as $value){
		return $value ;
	}
}
add_shortcode('row','cyon_table_row'); 

function cyon_table_data( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			classname	=> '',
			rows		=> '',
			cols		=> '',
			color		=> ''
		), $atts);
	$classname = '';
	$attributes = '';
	if($atts['color']!=''){
		$classname .= 'data-'.$atts['color'];
	}
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	if($atts['rows']){
		$attributes .= ' colspan="'.$atts['rows'].'"';
	}
	if($atts['cols']){
		$attributes .= ' colspan="'.$atts['cols'].'"';
	}
	if($classname!=''){
		$class = ' class="'.$classname.'"';
	}
	$data_content = array('<td'.$class.$attributes.'>'. do_shortcode($content) .'</td>');
	foreach ($data_content as $value){
		return $value ;
	}
}
add_shortcode('data','cyon_table_data'); 

/* =Box
use [box icon='' color='' close='no' classname='' title='' width='' align='' quote='no'] xxx [/box]
----------------------------------------------- */
function cyon_box( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			color		=> '',
			width		=> '',
			align		=> '',
			close		=> 'no',
			quote		=> 'no',
			classname	=> '',
			title		=> '',
			icon		=> ''
		), $atts);
	$style = '';
	if($atts['width']!=''){
		$width = (int)$atts['width'] - 60;
		$style .= ' style="width:'. $width .'px;  max-width:90%;"';
	}
	$classname = 'box';
	if($atts['color']!=''){
		$classname .= ' box-'.$atts['color'];
	}
	if($atts['align']){
		$classname .= ' align'.$atts['align'];
	}
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	if($atts['icon']!=''){
		$icon = '<span class="icon-box icon2x-'.$atts['icon'].'"></span>';
		$classname .= ' has-icon-box';
	}
	$close = '';
	if($atts['close']=='yes'){
		$close = '<a class="btn btn-close"><span class="icon-remove"></span></a>';
	}
	$quote = '';
	if($atts['quote']=='yes'){
		$quote = 'blockquote';
	}else{
		$quote = 'div';
	}
	$title = '';
	if($atts['title']!=''){
		$title = '<h3>'.$atts['title'].'</h3>';
	}
	if($classname!=''){
		$class = ' class="'.$classname.'"';
	}
	$html = '<'.$quote.$class.$style.'>'. $icon . $title . do_shortcode($content) . $close .'</'.$quote.'>';
	return $html;
}
add_shortcode('box','cyon_box'); 

/* =Code
use [code inline="yes"] xxx [/code]
----------------------------------------------- */
function cyon_code( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			inline		=> 'yes'
		), $atts);
	if($atts['inline']=='yes'){
		$code = 'code';
	}else{
		$code = 'pre';
	}
	$html = '<'.$code.'>'. html_entity_decode($content) .'</'.$code.'>';
	return $html;
}
add_shortcode('code','cyon_code'); 

/* =Tooltip
use [tip text="This has a tooltip"] xxx [/tip]
----------------------------------------------- */
function cyon_tip( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			text	=> ''
		), $atts);
	$html = '<span class="hastip" title="'.$atts['text'].'">'. $content .'</span>';
	return $html;
}
add_shortcode('tip','cyon_tip'); 

/* =Horizontal Line
use [line style=""]
----------------------------------------------- */
function cyon_line( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			style	=> ''
		), $atts);
	$style = '';
	if($atts['style']){
		$style = ' class="'.$atts['style'].'"';
	}
	$html = '<hr'.$style.' />';
	return $html;
}
add_shortcode('line','cyon_line'); 

/* =Back to Top
use [backtotop style='' classname='']
----------------------------------------------- */
function cyon_backtotop( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			style	=> '',
			classname	=> ''
		), $atts);
	$style = '';
	if($atts['style']){
		$style = ' class="'.$atts['style'].' '.$atts['classname'].'"';
	}
	$html = '<div class="backtotop-line"><hr'.$style.' /><a href="#" class="backtotop">'.__('Back to top','cyon').'</a></div>';
	return $html;
}
add_shortcode('backtotop','cyon_backtotop'); 


/* =Newsletter
use [newsletter email="" name="no"] xxx [/newsletter]
----------------------------------------------- */
function cyon_newsletter( $atts, $content = null ) {
	$nonce = wp_create_nonce('cyon_newsletter_nonce');
	$atts = shortcode_atts(
		array(
			email	=> get_bloginfo('admin_email'),
			name	=> 'no',
			classname => ''
		), $atts);
	$html = '<div class="cyon-newsletter newsletter-shortcode '.$atts['classname'].'"><form action="" method="post" class="cyonform">';
	$html .= '<fieldset>';
	if($content!=''){
		$html .= '<legend>'.$content.'</legend>';
	}
	$html .= '<div class="box"></div><input type="hidden" class="nonce" name="nonce" value="'.$nonce.'" /><input type="hidden" class="emailto" name="emailto" value="'.$atts['email'].'" />';
	if($atts['name']=='yes'){
		$html .= '<p><label for="newsletter_name">'.__('Name').':</label> <input type="text" id="newsletter_name" name="name" placeholder="'.__('Name').'" /></p>';
	}
	$html .= '<p><label for="newsletter_email">'.__('Email').':</label> <input type="email" id="newsletter_email" name="email" placeholder="'.__('Email').'" /></p>';
	$html .= '<button type="submit" name="newsletter_submit">'.__('Submit').'</button>';
	$html .= '</fieldset>';
	$html .= '</form></div>';
	ob_start();
		add_action('wp_footer','cyon_newsletter_ajax');
		add_action('wp_ajax_cyon_newsletter_action', 'cyon_newsletter_email');
		add_action('wp_ajax_nopriv_cyon_newsletter_action', 'cyon_newsletter_email');
	ob_get_clean();
	return $html;
}
add_shortcode('newsletter','cyon_newsletter'); 

if(!function_exists('cyon_newsletter_ajax')) {
function cyon_newsletter_ajax(){ ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.cyon-newsletter form').each(function(){
					jQuery(this).submit(function(){
						if(jQuery(this).find('input[type=email]').val()=='') {
							jQuery(this).find('.box').addClass('box-red').removeClass('box-green').text('<?php _e('Please enter your email address.'); ?>');
							jQuery(this).find('input[type=email]').addClass('error');
							return false;
						} else {
							var emailto = jQuery(this).find('input.emailto').val();
							var name = jQuery(this).find('input[type=text]').val();
							var email = jQuery(this).find('input[type=email]').val();
							var nonce = jQuery(this).find('input.nonce').val();
							if(email.indexOf("@") == -1 || email.indexOf(".") == -1) {
								jQuery(this).find('.box').addClass('box-red').removeClass('box-green').text('<?php _e('Please enter a valid email address.'); ?>');
								jQuery(this).find('input[type=email]').addClass('error');
								return false;
							} else {
								var data = {
									action: 'cyon_newsletter_action',
									emailto: emailto,
									nonce: nonce,
									name: name,
									email: email
								};
								jQuery(this).find('button').hide();
								jQuery(this).addClass('form-sending');
								jQuery.ajax({
									url		: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
									type	: 'POST',
									data	: data,
									success	: function( results ) {
										jQuery('.cyon-newsletter form').removeClass('form-sending');
										jQuery('.cyon-newsletter button').show();
										if(results==1){
											jQuery('.cyon-newsletter .box').removeClass('box-red').addClass('box-green').text('<?php _e('Your email has been subscribed to our mailing list.'); ?>');
										}else{
											jQuery('.cyon-newsletter .box').addClass('box-red').text('<?php _e('There was a problem in the server. Please try again later.'); ?>');
										}
										jQuery('.cyon-newsletter input[type=email]').removeClass('error');
										jQuery('.cyon-newsletter input[type=email]').val('');
										jQuery('.cyon-newsletter input[type=text]').val('');
									}
			
								});
								return false;
							}
						} 
					});
				});
			});
		</script>
<?php } }
if(!function_exists('cyon_newsletter_email')) {
function cyon_newsletter_email() {
	if (! wp_verify_nonce($_REQUEST['nonce'], 'cyon_newsletter_nonce') ) die(__('Security check')); 
	if(isset($_REQUEST['nonce']) && isset($_REQUEST['email'])) {
		$subject = __('New subscriber from').' '.get_bloginfo('name');
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$_REQUEST['name'].' <'.$_REQUEST['email'].'>' . "\r\n";
		$body = __('Name').': <b>'.$_REQUEST['name'].'</b><br>';
		$body .= __('Email').': <b>'.$_REQUEST['email'].'</b><br>';
		if( mail($_REQUEST['emailto'], $subject, $body) ) {
			echo 1;
		} else {
			echo 0;
		}
	}
	die();
} }

/* =Contact Form
use [contact email=""] xxx [/contact]
----------------------------------------------- */
function cyon_contact_form( $atts, $content = null ) {
	$nonce = wp_create_nonce('cyon_contact_nonce');
	$atts = shortcode_atts(
		array(
			email	=> get_bloginfo('admin_email'),
			classname => ''
		), $atts);
	$html = '<div class="cyon-contact-form contact-form-shortcode '.$atts['classname'].'"><form action="" method="post" class="cyonform">';
	$html .= '<fieldset>';
	if($content!=''){
		$html .= '<legend>'.$content.'</legend>';
	}
	$html .= '<div class="box"></div><input type="hidden" class="nonce" name="nonce" value="'.$nonce.'" /><input type="hidden" class="emailto" name="emailto" value="'.$atts['email'].'" />';
	$html .= '<dl class="field"><dt class="label"><label for="contact_name">'.__('Name').':</label></dt><dd class="inputs"><input type="text" id="contact_name" name="name" class="medium" /></dd></dl>';
	$html .= '<dl class="field"><dt class="label"><label for="contact_email">'.__('Email').':</label></dt><dd class="inputs"><input type="email" id="contact_email" name="email" class="medium" /></dd></dl>';
	$html .= '<dl class="field"><dt class="label"><label for="contact_phone">'.__('Phone').':</label></dt><dd class="inputs"><input type="phone" id="contact_phone" name="phone" class="medium" /></dd></dl>';
	$html .= '<dl class="field"><dt class="label"><label for="contact_message">'.__('Messsage').':</label></dt><dd class="inputs"><textarea id="contact_message" name="message" class="medium"></textarea></dd></dl>';
	$html .= '<p class="submit"><button type="submit" name="contact_submit">'.__('Submit').'</button></p>';
	$html .= '</fieldset>';
	$html .= '</form></div>';
	ob_start();
		add_action('wp_footer','cyon_contact_ajax');
		add_action('wp_ajax_cyon_contact_action', 'cyon_contact_email');
		add_action('wp_ajax_nopriv_cyon_contact_action', 'cyon_contact_email');
	ob_get_clean();
	return $html;
}
add_shortcode('contact','cyon_contact_form'); 

if(!function_exists('cyon_contact_ajax')) {
function cyon_contact_ajax(){ ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.cyon-contact-form form').each(function(){
					jQuery(this).submit(function(){
						var success = true;
						if(jQuery(this).find('input[type=email]').val()=='') {
							jQuery(this).find('input[type=email]').addClass('error');
							success = false;
						}else{
							jQuery(this).find('input[type=email]').removeClass('error');
						}
						if(jQuery(this).find('textarea').val()=='') {
							jQuery(this).find('textarea').addClass('error');
							success = false;
						}else{
							jQuery(this).find('textarea').removeClass('error');
						}
						if(success){
							var emailto = jQuery(this).find('input.emailto').val();
							var name = jQuery(this).find('#contact_name').val();
							var phone = jQuery(this).find('input[type=phone]').val();
							var message = jQuery(this).find('textarea').val();
							var email = jQuery(this).find('input[type=email]').val();
							var nonce = jQuery(this).find('input.nonce').val();
							if(email.indexOf("@") == -1 || email.indexOf(".") == -1) {
								jQuery(this).find('.box').addClass('box-red').removeClass('box-green').text('<?php _e('Please enter a valid email address.'); ?>');
								jQuery(this).find('input[type=email]').addClass('error');
								return false;
							} else {
								var data = {
									action: 'cyon_contact_action',
									emailto: emailto,
									nonce: nonce,
									name: name,
									phone: phone,
									message: message,
									email: email
								};
								jQuery(this).find('button').hide();
								jQuery(this).addClass('form-sending');
								jQuery.ajax({
									url		: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
									type	: 'POST',
									data	: data,
									success	: function( results ) {
										jQuery('.cyon-contact-form form').removeClass('form-sending');
										jQuery('.cyon-contact-form button').show();
										if(results==1){
											jQuery('.cyon-contact-form .box').removeClass('box-red').addClass('box-green').text('<?php _e('Your inquiry has been sent. We will get back to you shortly'); ?>');
										}else{
											jQuery('.cyon-contact-form .box').addClass('box-red').text('<?php _e('There was a problem in the server. Please try again later.'); ?>');
										}
										jQuery('.cyon-contact-form input[type=email]').removeClass('error');
										jQuery('.cyon-contact-form input[type=text]').val('');
										jQuery('.cyon-contact-form input[type=email]').val('');
										jQuery('.cyon-contact-form input[type=phone]').val('');
										jQuery('.cyon-contact-form textarea').val('');
									}
			
								});
								return false;
							}
						} else {
							jQuery(this).find('.box').addClass('box-red').removeClass('box-green').text('<?php _e('Empty field(s) required.'); ?>');
							return false;
						} 
					});
				});
			});
		</script>
<?php } }
if(!function_exists('cyon_contact_email')) {
function cyon_contact_email() {
	if (! wp_verify_nonce($_REQUEST['nonce'], 'cyon_contact_nonce') ) die(__('Security check')); 
	if(isset($_REQUEST['nonce']) && isset($_REQUEST['email'])) {
		$subject = __('New inquiry from').' '.get_bloginfo('name');
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$_REQUEST['name'].' <'.$_REQUEST['email'].'>' . "\r\n";
		$body = __('Name').': <b>'.$_REQUEST['name'].'</b><br>';
		$body .= __('Email').': <b>'.$_REQUEST['email'].'</b><br>';
		$body .= __('Phone').': <b>'.$_REQUEST['phone'].'</b><br>';
		$body .= __('Message').': <b>'.$_REQUEST['message'].'</b>';
		if( mail($_REQUEST['emailto'], $subject, $body) ) {
			echo 1;
		} else {
			echo 0;
		}
	}
	die();
} }

/* =Custom Form
For viewing purpose only, no actual function
----------------------------------------------- */
function cyon_custom_form($atts, $content = null){
	$html = '<form action="" method="post" class="cyonform">
				<fieldset>
					<legend>Simple Fields</legend>
					<dl class="field">
						<dt class="label"><label for="formtext">Text</label></dt>
						<dd class="inputs">
							<input type="text" id="formtext" name="formtext" value="" class="medium" />
							<div class="description">This is a description</div>
						</dd>
					</dl>
					<dl class="field">
						<dt class="label"><label for="formemail">Email</label></dt>
						<dd class="inputs"><input type="email" id="formemail" name="formemail" value="" class="medium" /></dd>
					</dl>
					<dl class="field">
						<dt class="label"><label for="formphone">Phone</label></dt>
						<dd class="inputs"><input type="text" id="formphone" name="formphone" value="" class="medium" /></dd>
					</dl>
					<dl class="field">
						<dt class="label"><label for="formfile">File</label></dt>
						<dd class="inputs"><input type="file" id="formfile" name="formfile" value="" /></dd>
					</dl>
					<dl class="field">
						<dt class="label"><label for="formerror">Error <span class="required">*</span></label></dt>
						<dd class="inputs"><input type="text" id="formerror" name="formerror" class="medium error" value="" /></dd>
					</dl>
					<dl class="field">
						<dt class="label"><label>Multiple</label></dt>
						<dd class="inputs"><input type="text" name="multi1" class="small" value="" placeholder="Field 1" /> <input type="text" name="multi2" class="small" value="" placeholder="Field 2" /> <input type="text" name="multi3" class="small" value="" placeholder="Field 3" /></dd>
					</dl>
					<dl class="field">
						<dt class="label"><label for="formselect">Select</label></dt>
						<dd class="inputs">
							<select name="formselect" id="formselect">
								<option value="">- Please select -</option>
								<option>Option 1</option>
								<option>Option 2</option>
								<option>Option 3</option>
							</select>
						</dd>
					</dl>
					<dl class="field">
						<dt class="label"><label>Checkboxes</label></dt>
						<dd class="inputs">
							<ul class="selection">
								<li>
									<input type="checkbox" name="formcheckbox[]" id="formcheck1" /> <label for="formcheck1">Checkbox 1</label>
								</li>
								<li>
									<input type="checkbox" name="formcheckbox[]" id="formcheck2" /> <label for="formcheck2">Checkbox 2</label>
								</li>
								<li>
									<input type="checkbox" name="formcheckbox[]" id="formcheck3" /> <label for="formcheck3">Checkbox 3</label>
								</li>
							</ul>
						</dd>
					</dl>
					<dl class="field">
						<dt class="label"><label>Radio Buttons</label></dt>
						<dd class="inputs">
							<ul class="selection">
								<li>
									<input type="radio" name="formradio[]" id="formradio1" /> <label for="formradio1">Radio 1</label>
								</li>
								<li>
									<input type="radio" name="formradio[]" id="formradio2" /> <label for="formradio2">Radio 2</label>
								</li>
								<li>
									<input type="radio" name="formradio[]" id="formradio3" /> <label for="formradio3">Radio 3</label>
								</li>
							</ul>
						</dd>
					</dl>
					<dl class="field">
						<dt class="label"><label for="formtextarea">Textarea</label></dt>
						<dd class="inputs"><textarea id="formtextarea" name="formtextarea" rows="5" class="large"></textarea></dd>
					</dl>
				</fieldset>
				<p class="submit"><button type="submit" class="button">'.__('Submit Form').'</submit></p>
			</form>';
	return $html;
}
add_shortcode('custom_form','cyon_custom_form'); 

/* =Sitemap
use [sitemap]
----------------------------------------------- */
function cyon_sitemap( $atts, $content = null ) {
	$html = '<div class="cyon-sitemap row-fluid">';
	$locations = get_nav_menu_locations();
	$footer_id = wp_get_nav_menu_object( $locations['footer-menu'] );
	$footer_items = wp_get_nav_menu_items( $footer_id->term_id );
	$header_id = wp_get_nav_menu_object( $locations['main-menu'] );
	$header_items = wp_get_nav_menu_items( $header_id->term_id );
	$html .= '<div class="span4">';
			if($header_id->term_id!=''){
				$html .= '<h3>'.__('Main Menu').':</h3><ul class="menu">'.wp_nav_menu(array('menu'=>$header_id->term_id,'container'=>'','echo'=>false)).'</ul>';
			}else{
				$html .= '<h3>'.__('Pages').':</h3><ul class="menu">'.wp_list_pages(array('title_li'=>'','echo'=>false)).'</ul>';
			}
			if($footer_id->term_id!='' && $header_id->term_id!=''){
				$html .= '<h3>'.__('Footer Menu').':</h3><ul class="menu">';
				foreach ( (array) $footer_items as $key => $footer_item ) {
					$html .= '<li><a href="'.$footer_item->url.'" title="'.$footer_item->title.'">'.$footer_item->title.'</a></li>';
				}
				$html .= '</ul>';
			}
	$html .= '</div>';
	$html .= '<div class="span4">
				<h3>'.__('Blog Categories').':</h3><ul class="menu">'.wp_list_categories(array('show_count'=>1,'echo'=>false,'title_li'=>'','feed'=>_('feed'))).'</ul>
				<h3>'.__('Blog Archives').':</h3><ul class="menu">'.wp_get_archives(array('show_post_count'=>true,'echo'=>false)).'</ul>';
			if (is_plugin_active('woocommerce/woocommerce.php')) {
				$html .= '<h3>'.__('Product Categories').':</h3><ul class="menu">'.wp_list_categories(array('show_count'=>1,'echo'=>false,'taxonomy'=>'product_cat','title_li'=>'','feed'=>_('feed'))).'</ul>';
			}
	$recent_posts = wp_get_recent_posts(array('numberposts'=>50));
	$html .= '</div><div class="span4">
				<h3>'.__('Blog Posts').':</h3><ul class="menu">';
				foreach( $recent_posts as $recent ){
					$html .= '<li><a href="'.get_permalink($recent['ID']).'" title="'.esc_attr($recent['post_title']).'">'.$recent['post_title'].'</a></li>';
				}
	$html .= '</ul></div>';
	$html .= '</div>';
	return $html;
}
add_shortcode('sitemap','cyon_sitemap'); 
