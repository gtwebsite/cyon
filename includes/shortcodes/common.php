<?php

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
			jQuery('.tabs .tab_nav li:first-child').addClass('active');
			jQuery(jQuery('.tab_nav li.active a').attr('href')).show();
			jQuery('.tab_nav li a').click(function(){
				var prev = jQuery(this).parent().parent().find('li.active a').attr('href');
				if (!jQuery(this).parent().hasClass('active')) {
					jQuery(this).parent().parent().find('li.active').removeClass('active');
					jQuery(this).parent().addClass('active');
				}
				var current = jQuery(this).attr('href');
				if(jQuery(jQuery(this).attr('href')).is(':hidden')){
					jQuery(prev).slideUp('slow', function(){
						jQuery(current).slideDown(500);
					});
				}
				event.preventDefault();
			});
		});
	</script> 
<?php }

/* =Show Subpages
use [subpages excerpt='yes']
----------------------------------------------- */
function cyon_subpages( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			excerpt => 'yes',
			id 		=> get_the_ID()
		), $atts);
	$args = array(
		'sort_order' 	=> 'ASC',
		'sort_column' 	=> 'menu_order',
		'child_of' 		=> $atts['id'],
		'parent'		=>  $atts['id']
	);
	$subpages = get_pages($args);
	$result = '';
	foreach ( $subpages as $page ) {
		$result .= '<li>';
		$result .= '<h3><a href="' . get_page_link( $page->ID ) . '">' . $page->post_title . '</a></h3>';
		if($atts['excerpt']=='yes'){
			$result .= do_shortcode($page->post_excerpt);
		}
		$result .= '</li>';
		echo $option;
	}
	return '<ul class="subpages">'.$result.'</ul>';
}
add_shortcode('subpages','cyon_subpages'); 

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
use [iframe width='100%' height='350' scroll='yes' url='http://localhost/']
----------------------------------------------- */
function cyon_iframe( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			width		=> '100%',
			height		=> '350',
			scroll		=> 'yes',
			url			=> 'http://localhost/'
		), $atts);
	return '<iframe width="'.$atts['width'].'" height="'.$atts['height'].'" frameborder="0" scrolling="'.$atts['scroll'].'" marginheight="0" marginwidth="0" src="'.$atts['url'].'"></iframe>';
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
		if($domain['host']=='www.youtube.com' || $domain['host']=='youtube.com'){
			$html .= '<video width="'.$atts['width'].'" height="'.$atts['height'].'" type="video/youtube" src="'.$atts['src'].'" preload="none"'.$style.' />';
		}elseif($domain['host']=='www.vimeo.com' || $domain['host']=='vimeo.com'){
			$html .= '<video width="'.$atts['width'].'" height="'.$atts['height'].'" type="video/vimeo" src="'.$atts['src'].'" preload="none"'.$style.' />';
		}elseif($domain['scheme']=='rtmp'){
			$html .= '<video width="'.$atts['width'].'" height="'.$atts['height'].'" type="video/flv" src="'.$atts['src'].'" autoplay'.$style.' />';
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
	}else{
		$html = __('No video source specified.');
	}
	return $html;
}
add_shortcode('video','cyon_video'); 

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
use [icon element='' icon='' classname='' title='' url=''] xxx [/icon]
----------------------------------------------- */
function cyon_inline_icon( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			element		=> 'span',
			classname	=> '',
			url			=> '',
			title		=> '',
			icon		=> ''
		), $atts);
	$classname = '';
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	$title = '';
	if($atts['title']){
		$classname .= ' hastip';
		$title = ' title="'. $atts['title'] . '"';
	}
	$url = '';
	if($atts['url'] && $atts['element']=='a'){
		$url = ' href="'. $atts['url'] . '"';
	}
	if($atts['icon']=='' && $atts['element']=='a'){
		$icon = 'icon-share';
	}elseif($atts['icon']==''){
		$icon = 'icon-question-sign';
	}else{
		$icon = 'icon-'.$atts['icon'];
	}
	$html = '<'.$atts['element'].' class="has-icon'.$classname.'"'.$title.$url.'><span class="'.$icon.'"></span> ' . $content . '</'.$atts['element'].'>';
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
			color		=> ''
		), $atts);
	$classname = '';
	if($atts['color']!=''){
		$classname .= 'data-'.$atts['color'];
	}
	if($atts['classname']){
		$classname .= ' '.$atts['classname'];
	}
	if($classname!=''){
		$class = ' class="'.$classname.'"';
	}
	$data_content = array('<td'.$class.'>'. do_shortcode($content) .'</td>');
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
		$style .= ' style="width:'. $width .'px"';
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
