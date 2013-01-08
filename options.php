<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}


/* JS callback */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
	var checkbgoption = function() {
		var bgvalue = jQuery('#section-backgroundoptions select').val();
		if(bgvalue=='presets'){
			jQuery('#section-backgroundpreset').show();
			jQuery('#section-backgroundcustom').fadeOut();
		}else if(bgvalue=='custom'){
			jQuery('#section-backgroundpreset').fadeOut();
			jQuery('#section-backgroundcustom').show();
		}
	}

	jQuery(document).ready(checkbgoption);
	jQuery('#section-backgroundoptions select').change(checkbgoption);
	

	var checkstaticblock = function() {
		var svalue = jQuery('#section-homepage_middle input[type=radio]:checked').val();
		if(svalue=='staticblock'){
			jQuery('#section-homepage_middle_block').show();
		}else{
			jQuery('#section-homepage_middle_block').fadeOut();
		}
	}
	
	jQuery(document).ready(checkstaticblock);
	jQuery('#section-homepage_middle input[type=radio]').click(checkstaticblock);


	var checkslidershowcaption = function() {
		var scvalue = jQuery('#section-homepage_slider_caption input[type=radio]:checked').val();
		if(scvalue=='1'){
			jQuery('#section-homepage_slider_caption_layout').show();
			jQuery('#section-homepage_slider_caption_width').show();
		}else{
			jQuery('#section-homepage_slider_caption_layout').fadeOut();
			jQuery('#section-homepage_slider_caption_width').fadeOut();
		}
	}
	
	jQuery(document).ready(checkslidershowcaption);
	jQuery('#section-homepage_slider_caption input[type=radio]').click(checkslidershowcaption);

	var checkslidershowpaginate = function() {
		var spvalue = jQuery('#section-homepage_slider_pagination input[type=radio]:checked').val();
		if(spvalue=='1'){
			jQuery('#section-homepage_slider_pagination_layout').show();
		}else{
			jQuery('#section-homepage_slider_pagination_layout').fadeOut();
		}
	}
	
	jQuery(document).ready(checkslidershowpaginate);
	jQuery('#section-homepage_slider_pagination input[type=radio]').click(checkslidershowpaginate);

	
	var sampletext = '<p class="sampletext" style="clear:both; font-size:18px; padding:5px; background:#fff; margin:0 0 10px 0;">Grumpy wizards make toxic brew for the evil Queen and Jack.</p>';
	jQuery('#section-secondary_font_google').append(sampletext)
	
	var checkprimaryfont = function() {
		var pfvalue = jQuery('#section-primary_font option:selected').val();
		if(pfvalue=='google'){
			jQuery('#section-primary_font_google').show();
		}else{
			jQuery('#section-primary_font_google').fadeOut();
		}
	}

	jQuery(document).ready(checkprimaryfont);
	jQuery('#section-primary_font select').change(checkprimaryfont);

	jQuery('#section-primary_font_google').append(sampletext)

	var checksecondaryfont = function() {
		var pfvalue = jQuery('#section-secondary_font option:selected').val();
		if(pfvalue=='google'){
			jQuery('#section-secondary_font_google').show();
		}else{
			jQuery('#section-secondary_font_google').fadeOut();
		}
	}

	jQuery(document).ready(checksecondaryfont);
	jQuery('#section-secondary_font select').change(checksecondaryfont);

	jQuery('.googlefont').each(function(index){
		jQuery('head').append('<link href="http://fonts.googleapis.com/css?family=' + jQuery(this).find('select option:selected').text() +'" rel="stylesheet" class="font'+ index +'" type="text/css" />');
		jQuery(this).find('.sampletext').css('font-family',jQuery(this).find('select option:selected').text());
		jQuery(this).find('select').change(function(){
			jQuery(this).parent().parent().parent().find('.sampletext').css('font-family',jQuery(this).find('option:selected').text());
			jQuery('head').find('link.font'+index).attr('href','http://fonts.googleapis.com/css?family=' + jQuery(this).find('option:selected').text());
		});
	});

	var checkbackgroundstyle = function() {
		var bsvalue = jQuery('#section-background_style option:selected').val();
		if(bsvalue=='full'){
			jQuery('#section-background_style_youtube').fadeOut();
			jQuery('#section-background_style_image').show();
			jQuery('#section-background_style_pattern_repeat').fadeOut();
			jQuery('#section-background_style_pattern_position').fadeOut();
			jQuery('#section-background_style_image').append('<div id="addition"><input type="button" class="button" value="Add image" /></div>');
		}else if(bsvalue=='youtube'){
			jQuery('#section-background_style_youtube').show();
			jQuery('#section-background_style_image').fadeOut();
			jQuery('#section-background_style_pattern_repeat').fadeOut();
			jQuery('#section-background_style_pattern_position').fadeOut();
			jQuery('#addition').remove();
		}else{
			jQuery('#section-background_style_youtube').fadeOut();
			jQuery('#section-background_style_image').show();
			jQuery('#section-background_style_pattern_repeat').show();
			jQuery('#section-background_style_pattern_position').show();
			jQuery('#addition').remove();
		}
	}

	jQuery(document).ready(checkbackgroundstyle);
	jQuery('#section-background_style select').change(checkbackgroundstyle);

	var checkbanner = function() {
		var bavalue = jQuery('#section-homepage_slider input[type=radio]:checked').val();
		if(bavalue=='singleimage'){
			jQuery('#section-homepage_slider_image_file').show();
			jQuery('#section-homepage_slider_image_url').show();
			jQuery('#section-homepage_slider_animation').fadeOut();
			jQuery('#section-homepage_slider_caption').fadeOut();
			jQuery('#section-homepage_slider_caption_layout').fadeOut();
			jQuery('#section-homepage_slider_caption_width').fadeOut();
			jQuery('#section-homepage_slider_arrows').fadeOut();
			jQuery('#section-homepage_slider_pagination').fadeOut();
			jQuery('#section-homepage_slider_pagination_layout').fadeOut();
		}else if(bavalue=='flexslider'){
			jQuery('#section-homepage_slider_image_file').fadeOut();
			jQuery('#section-homepage_slider_image_url').fadeOut();
			jQuery('#section-homepage_slider_animation').show();
			jQuery('#section-homepage_slider_caption').show();
			jQuery('#section-homepage_slider_caption_layout').show();
			jQuery('#section-homepage_slider_caption_width').show();
			jQuery('#section-homepage_slider_arrows').show();
			jQuery('#section-homepage_slider_pagination').show();
			jQuery('#section-homepage_slider_pagination_layout').show();
		}else{
			jQuery('#section-homepage_slider_image_file').fadeOut();
			jQuery('#section-homepage_slider_image_url').fadeOut();
			jQuery('#section-homepage_slider_animation').fadeOut();
			jQuery('#section-homepage_slider_caption').fadeOut();
			jQuery('#section-homepage_slider_caption_layout').fadeOut();
			jQuery('#section-homepage_slider_caption_width').fadeOut();
			jQuery('#section-homepage_slider_arrows').fadeOut();
			jQuery('#section-homepage_slider_pagination').fadeOut();
			jQuery('#section-homepage_slider_pagination_layout').fadeOut();
		}
	}

	jQuery(document).ready(checkbanner);
	jQuery('#section-homepage_slider input[type=radio]').each(function(){
		jQuery(this).click(checkbanner);
	});
	
	var checkslideranimationstyle = function() {
		var asvalue = jQuery('#section-homepage_slider_animation input[type=radio]:checked').val();
		if(asvalue=='0'){
			jQuery('#section-homepage_slider_caption').show();
			jQuery('#section-homepage_slider_caption_layout').show();
			jQuery('#section-homepage_slider_caption_width').show();
		}else{
			jQuery('#section-homepage_slider_caption').fadeOut();
			jQuery('#section-homepage_slider_caption_layout').fadeOut();
			jQuery('#section-homepage_slider_caption_width').fadeOut();
		}
	}
	
	jQuery(document).ready(checkslideranimationstyle);
	jQuery('#section-homepage_slider_animation input[type=radio]').click(checkslideranimationstyle);

	jQuery('#section-socialmedia input[type=checkbox]:checked').each(function(){
		jQuery(this).parent('span').parent('.item').addClass('selected');
	});
	
	jQuery('#section-socialmedia input[type=checkbox]').each(function(){
		jQuery(this).click(function() {
			if(jQuery(this).is(':checked')){
				jQuery(this).parent('span').parent('.item').find('input[type=text]').show();
				jQuery(this).parent('span').parent('.item').addClass('selected');
			}else{
				jQuery(this).parent('span').parent('.item').find('input[type=text]').fadeOut();
				jQuery(this).parent('span').parent('.item').removeClass('selected');
			}
		});
	});

});
</script>
 
<?php
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Social Share Pages
	$socialshare_array = array('posts' => __( 'Blog Posts','cyon' ), 'listings' => __( 'Blog Listings','cyon' ), 'pages' => __( 'Pages','cyon' ));
	
	// Social Share Pages Defaults
	$socialshare_defaults = array('posts' => '1');

	// Social Boxes
	$socialshareboxes_array = array('facebook' => __( 'Facebook','cyon' ), 'twitter' => __( 'Twitter','cyon' ), 'plus' => __( 'Google+','cyon' ), 'pinterest' => __( 'Pinterest','cyon' ), 'mail' => __( 'Email','cyon' ), 'sharethis' => __( 'ShareThis','cyon' ));
	
	// Social Boxes Defaults
	$socialshareboxes_defaults = array('facebook' => '1','twitter' => '1','plus' => '1');

	// Homepage Sliders (codaslider, nivoslider)
	$sliders_array =  array('default' => __( 'Use Page\'s Default','cyon' ),'flexslider' => 'Flexslider','singleimage' => __( 'Single Image','cyon' ));
	
	// Homepage Middle
	$homepage_middle =  array('staticblock' => __( 'Static Block','cyon' ),'twitter' => __( 'Twitter Updates','cyon' ));

	// Color Themes
	$color_theme =  array('light' => __( 'Light','cyon' ),'dark' => __( 'Dark','cyon' ));
	
	// Custom Fonts
	$custom_fonts = array('default'=>__('Default','cyon'),'google'=>'Google Fonts','Arial'=>'Arial','Tahoma'=>'Tahoma','Verdana'=>'Verdana','Helvetica'=>'Helvetica','"Lucida Grande", "Lucida Sans Unicode"'=>'Lucida Grande','Trebuchet MS'=>'Trebuchet MS','Myriad Pro'=>'Myriad Pro','Georgia'=>'Georgia','"Times New Roman"'=>'Times New Roman');

	// Google Fonts
	$google_fonts_array = array('ABeeZee'=>'ABeeZee','Abel'=>'Abel','Abril Fatface'=>'Abril Fatface','Aclonica'=>'Aclonica','Acme'=>'Acme','Actor'=>'Actor','Adamina'=>'Adamina','Advent Pro'=>'Advent Pro','Aguafina Script'=>'Aguafina Script','Akronim'=>'Akronim','Aladin'=>'Aladin','Aldrich'=>'Aldrich','Alegreya'=>'Alegreya','Alegreya SC'=>'Alegreya SC','Alex Brush'=>'Alex Brush','Alfa Slab One'=>'Alfa Slab One','Alice'=>'Alice','Alike'=>'Alike','Alike Angular'=>'Alike Angular','Allan'=>'Allan','Allerta'=>'Allerta','Allerta Stencil'=>'Allerta Stencil','Allura'=>'Allura','Almendra'=>'Almendra','Almendra Display'=>'Almendra Display','Almendra SC'=>'Almendra SC','Amarante'=>'Amarante','Amaranth'=>'Amaranth','Amatic SC'=>'Amatic SC','Amethysta'=>'Amethysta','Anaheim'=>'Anaheim','Andada'=>'Andada','Andika'=>'Andika','Angkor'=>'Angkor','Annie Use Your Telescope'=>'Annie Use Your Telescope','Anonymous Pro'=>'Anonymous Pro','Antic'=>'Antic','Antic Didone'=>'Antic Didone','Antic Slab'=>'Antic Slab','Anton'=>'Anton','Arapey'=>'Arapey','Arbutus'=>'Arbutus','Arbutus Slab'=>'Arbutus Slab','Architects Daughter'=>'Architects Daughter','Archivo Black'=>'Archivo Black','Archivo Narrow'=>'Archivo Narrow','Arimo'=>'Arimo','Arizonia'=>'Arizonia','Armata'=>'Armata','Artifika'=>'Artifika','Arvo'=>'Arvo','Asap'=>'Asap','Asset'=>'Asset','Astloch'=>'Astloch','Asul'=>'Asul','Atomic Age'=>'Atomic Age','Aubrey'=>'Aubrey','Audiowide'=>'Audiowide','Autour One'=>'Autour One','Average'=>'Average','Average Sans'=>'Average Sans','Averia Gruesa Libre'=>'Averia Gruesa Libre','Averia Libre'=>'Averia Libre','Averia Sans Libre'=>'Averia Sans Libre','Averia Serif Libre'=>'Averia Serif Libre','Bad Script'=>'Bad Script','Balthazar'=>'Balthazar','Bangers'=>'Bangers','Basic'=>'Basic','Battambang'=>'Battambang','Baumans'=>'Baumans','Bayon'=>'Bayon','Belgrano'=>'Belgrano','Belleza'=>'Belleza','BenchNine'=>'BenchNine','Bentham'=>'Bentham','Berkshire Swash'=>'Berkshire Swash','Bevan'=>'Bevan','Bigelow Rules'=>'Bigelow Rules','Bigshot One'=>'Bigshot One','Bilbo'=>'Bilbo','Bilbo Swash Caps'=>'Bilbo Swash Caps','Bitter'=>'Bitter','Black Ops One'=>'Black Ops One','Bokor'=>'Bokor','Bonbon'=>'Bonbon','Boogaloo'=>'Boogaloo','Bowlby One'=>'Bowlby One','Bowlby One SC'=>'Bowlby One SC','Brawler'=>'Brawler','Bree Serif'=>'Bree Serif','Bubblegum Sans'=>'Bubblegum Sans','Bubbler One'=>'Bubbler One','Buda'=>'Buda','Buenard'=>'Buenard','Butcherman'=>'Butcherman','Butterfly Kids'=>'Butterfly Kids','Cabin'=>'Cabin','Cabin Condensed'=>'Cabin Condensed','Cabin Sketch'=>'Cabin Sketch','Caesar Dressing'=>'Caesar Dressing','Cagliostro'=>'Cagliostro','Calligraffitti'=>'Calligraffitti','Cambo'=>'Cambo','Candal'=>'Candal','Cantarell'=>'Cantarell','Cantata One'=>'Cantata One','Cantora One'=>'Cantora One','Capriola'=>'Capriola','Cardo'=>'Cardo','Carme'=>'Carme','Carrois Gothic'=>'Carrois Gothic','Carrois Gothic SC'=>'Carrois Gothic SC','Carter One'=>'Carter One','Caudex'=>'Caudex','Cedarville Cursive'=>'Cedarville Cursive','Ceviche One'=>'Ceviche One','Changa One'=>'Changa One','Chango'=>'Chango','Chau Philomene One'=>'Chau Philomene One','Chela One'=>'Chela One','Chelsea Market'=>'Chelsea Market','Chenla'=>'Chenla','Cherry Cream Soda'=>'Cherry Cream Soda','Cherry Swash'=>'Cherry Swash','Chewy'=>'Chewy','Chicle'=>'Chicle','Chivo'=>'Chivo','Cinzel'=>'Cinzel','Cinzel Decorative'=>'Cinzel Decorative','Clicker Script'=>'Clicker Script','Coda'=>'Coda','Coda Caption'=>'Coda Caption','Codystar'=>'Codystar','Combo'=>'Combo','Comfortaa'=>'Comfortaa','Coming Soon'=>'Coming Soon','Concert One'=>'Concert One','Condiment'=>'Condiment','Content'=>'Content','Contrail One'=>'Contrail One','Convergence'=>'Convergence','Cookie'=>'Cookie','Copse'=>'Copse','Corben'=>'Corben','Courgette'=>'Courgette','Cousine'=>'Cousine','Coustard'=>'Coustard','Covered By Your Grace'=>'Covered By Your Grace','Crafty Girls'=>'Crafty Girls','Creepster'=>'Creepster','Crete Round'=>'Crete Round','Crimson Text'=>'Crimson Text','Croissant One'=>'Croissant One','Crushed'=>'Crushed','Cuprum'=>'Cuprum','Cutive'=>'Cutive','Cutive Mono'=>'Cutive Mono','Damion'=>'Damion','Dancing Script'=>'Dancing Script','Dangrek'=>'Dangrek','Dawning of a New Day'=>'Dawning of a New Day','Days One'=>'Days One','Delius'=>'Delius','Delius Swash Caps'=>'Delius Swash Caps','Delius Unicase'=>'Delius Unicase','Della Respira'=>'Della Respira','Denk One'=>'Denk One','Devonshire'=>'Devonshire','Didact Gothic'=>'Didact Gothic','Diplomata'=>'Diplomata','Diplomata SC'=>'Diplomata SC','Domine'=>'Domine','Donegal One'=>'Donegal One','Doppio One'=>'Doppio One','Dorsa'=>'Dorsa','Dosis'=>'Dosis','Dr Sugiyama'=>'Dr Sugiyama','Droid Sans'=>'Droid Sans','Droid Sans Mono'=>'Droid Sans Mono','Droid Serif'=>'Droid Serif','Duru Sans'=>'Duru Sans','Dynalight'=>'Dynalight','EB Garamond'=>'EB Garamond','Eagle Lake'=>'Eagle Lake','Eater'=>'Eater','Economica'=>'Economica','Electrolize'=>'Electrolize','Elsie'=>'Elsie','Elsie Swash Caps'=>'Elsie Swash Caps','Emblema One'=>'Emblema One','Emilys Candy'=>'Emilys Candy','Engagement'=>'Engagement','Englebert'=>'Englebert','Enriqueta'=>'Enriqueta','Erica One'=>'Erica One','Esteban'=>'Esteban','Euphoria Script'=>'Euphoria Script','Ewert'=>'Ewert','Exo'=>'Exo','Expletus Sans'=>'Expletus Sans','Fanwood Text'=>'Fanwood Text','Fascinate'=>'Fascinate','Fascinate Inline'=>'Fascinate Inline','Faster One'=>'Faster One','Fasthand'=>'Fasthand','Federant'=>'Federant','Federo'=>'Federo','Felipa'=>'Felipa','Fenix'=>'Fenix','Finger Paint'=>'Finger Paint','Fjalla One'=>'Fjalla One','Fjord One'=>'Fjord One','Flamenco'=>'Flamenco','Flavors'=>'Flavors','Fondamento'=>'Fondamento','Fontdiner Swanky'=>'Fontdiner Swanky','Forum'=>'Forum','Francois One'=>'Francois One','Freckle Face'=>'Freckle Face','Fredericka the Great'=>'Fredericka the Great','Fredoka One'=>'Fredoka One','Freehand'=>'Freehand','Fresca'=>'Fresca','Frijole'=>'Frijole','Fugaz One'=>'Fugaz One','GFS Didot'=>'GFS Didot','GFS Neohellenic'=>'GFS Neohellenic','Gafata'=>'Gafata','Galdeano'=>'Galdeano','Galindo'=>'Galindo','Gentium Basic'=>'Gentium Basic','Gentium Book Basic'=>'Gentium Book Basic','Geo'=>'Geo','Geostar'=>'Geostar','Geostar Fill'=>'Geostar Fill','Germania One'=>'Germania One','Gilda Display'=>'Gilda Display','Give You Glory'=>'Give You Glory','Glass Antiqua'=>'Glass Antiqua','Glegoo'=>'Glegoo','Gloria Hallelujah'=>'Gloria Hallelujah','Goblin One'=>'Goblin One','Gochi Hand'=>'Gochi Hand','Gorditas'=>'Gorditas','Goudy Bookletter 1911'=>'Goudy Bookletter 1911','Graduate'=>'Graduate','Grand Hotel'=>'Grand Hotel','Gravitas One'=>'Gravitas One','Great Vibes'=>'Great Vibes','Griffy'=>'Griffy','Gruppo'=>'Gruppo','Gudea'=>'Gudea','Habibi'=>'Habibi','Hammersmith One'=>'Hammersmith One','Hanalei'=>'Hanalei','Hanalei Fill'=>'Hanalei Fill','Handlee'=>'Handlee','Hanuman'=>'Hanuman','Happy Monkey'=>'Happy Monkey','Headland One'=>'Headland One','Henny Penny'=>'Henny Penny','Herr Von Muellerhoff'=>'Herr Von Muellerhoff','Holtwood One SC'=>'Holtwood One SC','Homemade Apple'=>'Homemade Apple','Homenaje'=>'Homenaje','IM Fell DW Pica'=>'IM Fell DW Pica','IM Fell DW Pica SC'=>'IM Fell DW Pica SC','IM Fell Double Pica'=>'IM Fell Double Pica','IM Fell Double Pica SC'=>'IM Fell Double Pica SC','IM Fell English'=>'IM Fell English','IM Fell English SC'=>'IM Fell English SC','IM Fell French Canon'=>'IM Fell French Canon','IM Fell French Canon SC'=>'IM Fell French Canon SC','IM Fell Great Primer'=>'IM Fell Great Primer','IM Fell Great Primer SC'=>'IM Fell Great Primer SC','Iceberg'=>'Iceberg','Iceland'=>'Iceland','Imprima'=>'Imprima','Inconsolata'=>'Inconsolata','Inder'=>'Inder','Indie Flower'=>'Indie Flower','Inika'=>'Inika','Irish Grover'=>'Irish Grover','Istok Web'=>'Istok Web','Italiana'=>'Italiana','Italianno'=>'Italianno','Jacques Francois'=>'Jacques Francois','Jacques Francois Shadow'=>'Jacques Francois Shadow','Jim Nightshade'=>'Jim Nightshade','Jockey One'=>'Jockey One','Jolly Lodger'=>'Jolly Lodger','Josefin Sans'=>'Josefin Sans','Josefin Slab'=>'Josefin Slab','Joti One'=>'Joti One','Judson'=>'Judson','Julee'=>'Julee','Julius Sans One'=>'Julius Sans One','Junge'=>'Junge','Jura'=>'Jura','Just Another Hand'=>'Just Another Hand','Just Me Again Down Here'=>'Just Me Again Down Here','Kameron'=>'Kameron','Karla'=>'Karla','Kaushan Script'=>'Kaushan Script','Keania One'=>'Keania One','Kelly Slab'=>'Kelly Slab','Kenia'=>'Kenia','Khmer'=>'Khmer','Kite One'=>'Kite One','Knewave'=>'Knewave','Kotta One'=>'Kotta One','Koulen'=>'Koulen','Kranky'=>'Kranky','Kreon'=>'Kreon','Kristi'=>'Kristi','Krona One'=>'Krona One','La Belle Aurore'=>'La Belle Aurore','Lancelot'=>'Lancelot','Lato'=>'Lato','League Script'=>'League Script','Leckerli One'=>'Leckerli One','Ledger'=>'Ledger','Lekton'=>'Lekton','Lemon'=>'Lemon','Libre Baskerville'=>'Libre Baskerville','Life Savers'=>'Life Savers','Lilita One'=>'Lilita One','Limelight'=>'Limelight','Linden Hill'=>'Linden Hill','Lobster'=>'Lobster','Lobster Two'=>'Lobster Two','Londrina Outline'=>'Londrina Outline','Londrina Shadow'=>'Londrina Shadow','Londrina Sketch'=>'Londrina Sketch','Londrina Solid'=>'Londrina Solid','Lora'=>'Lora','Love Ya Like A Sister'=>'Love Ya Like A Sister','Loved by the King'=>'Loved by the King','Lovers Quarrel'=>'Lovers Quarrel','Luckiest Guy'=>'Luckiest Guy','Lusitana'=>'Lusitana','Lustria'=>'Lustria','Macondo'=>'Macondo','Macondo Swash Caps'=>'Macondo Swash Caps','Magra'=>'Magra','Maiden Orange'=>'Maiden Orange','Mako'=>'Mako','Marcellus'=>'Marcellus','Marcellus SC'=>'Marcellus SC','Marck Script'=>'Marck Script','Margarine'=>'Margarine','Marko One'=>'Marko One','Marmelad'=>'Marmelad','Marvel'=>'Marvel','Mate'=>'Mate','Mate SC'=>'Mate SC','Maven Pro'=>'Maven Pro','McLaren'=>'McLaren','Meddon'=>'Meddon','MedievalSharp'=>'MedievalSharp','Medula One'=>'Medula One','Megrim'=>'Megrim','Meie Script'=>'Meie Script','Merienda'=>'Merienda','Merienda One'=>'Merienda One','Merriweather'=>'Merriweather','Metal'=>'Metal','Metal Mania'=>'Metal Mania','Metamorphous'=>'Metamorphous','Metrophobic'=>'Metrophobic','Michroma'=>'Michroma','Milonga'=>'Milonga','Miltonian'=>'Miltonian','Miltonian Tattoo'=>'Miltonian Tattoo','Miniver'=>'Miniver','Miss Fajardose'=>'Miss Fajardose','Modern Antiqua'=>'Modern Antiqua','Molengo'=>'Molengo','Molle'=>'Molle','Monda'=>'Monda','Monofett'=>'Monofett','Monoton'=>'Monoton','Monsieur La Doulaise'=>'Monsieur La Doulaise','Montaga'=>'Montaga','Montez'=>'Montez','Montserrat'=>'Montserrat','Montserrat Alternates'=>'Montserrat Alternates','Montserrat Subrayada'=>'Montserrat Subrayada','Moul'=>'Moul','Moulpali'=>'Moulpali','Mountains of Christmas'=>'Mountains of Christmas','Mouse Memoirs'=>'Mouse Memoirs','Mr Bedfort'=>'Mr Bedfort','Mr Dafoe'=>'Mr Dafoe','Mr De Haviland'=>'Mr De Haviland','Mrs Saint Delafield'=>'Mrs Saint Delafield','Mrs Sheppards'=>'Mrs Sheppards','Muli'=>'Muli','Mystery Quest'=>'Mystery Quest','Neucha'=>'Neucha','Neuton'=>'Neuton','New Rocker'=>'New Rocker','News Cycle'=>'News Cycle','Niconne'=>'Niconne','Nixie One'=>'Nixie One','Nobile'=>'Nobile','Nokora'=>'Nokora','Norican'=>'Norican','Nosifer'=>'Nosifer','Nothing You Could Do'=>'Nothing You Could Do','Noticia Text'=>'Noticia Text','Nova Cut'=>'Nova Cut','Nova Flat'=>'Nova Flat','Nova Mono'=>'Nova Mono','Nova Oval'=>'Nova Oval','Nova Round'=>'Nova Round','Nova Script'=>'Nova Script','Nova Slim'=>'Nova Slim','Nova Square'=>'Nova Square','Numans'=>'Numans','Nunito'=>'Nunito','Odor Mean Chey'=>'Odor Mean Chey','Offside'=>'Offside','Old Standard TT'=>'Old Standard TT','Oldenburg'=>'Oldenburg','Oleo Script'=>'Oleo Script','Oleo Script Swash Caps'=>'Oleo Script Swash Caps','Open Sans'=>'Open Sans','Open Sans Condensed'=>'Open Sans Condensed','Oranienbaum'=>'Oranienbaum','Orbitron'=>'Orbitron','Oregano'=>'Oregano','Orienta'=>'Orienta','Original Surfer'=>'Original Surfer','Oswald'=>'Oswald','Over the Rainbow'=>'Over the Rainbow','Overlock'=>'Overlock','Overlock SC'=>'Overlock SC','Ovo'=>'Ovo','Oxygen'=>'Oxygen','Oxygen Mono'=>'Oxygen Mono','PT Mono'=>'PT Mono','PT Sans'=>'PT Sans','PT Sans Caption'=>'PT Sans Caption','PT Sans Narrow'=>'PT Sans Narrow','PT Serif'=>'PT Serif','PT Serif Caption'=>'PT Serif Caption','Pacifico'=>'Pacifico','Paprika'=>'Paprika','Parisienne'=>'Parisienne','Passero One'=>'Passero One','Passion One'=>'Passion One','Patrick Hand'=>'Patrick Hand','Patua One'=>'Patua One','Paytone One'=>'Paytone One','Peralta'=>'Peralta','Permanent Marker'=>'Permanent Marker','Petit Formal Script'=>'Petit Formal Script','Petrona'=>'Petrona','Philosopher'=>'Philosopher','Piedra'=>'Piedra','Pinyon Script'=>'Pinyon Script','Pirata One'=>'Pirata One','Plaster'=>'Plaster','Play'=>'Play','Playball'=>'Playball','Playfair Display'=>'Playfair Display','Playfair Display SC'=>'Playfair Display SC','Podkova'=>'Podkova','Poiret One'=>'Poiret One','Poller One'=>'Poller One','Poly'=>'Poly','Pompiere'=>'Pompiere','Pontano Sans'=>'Pontano Sans','Port Lligat Sans'=>'Port Lligat Sans','Port Lligat Slab'=>'Port Lligat Slab','Prata'=>'Prata','Preahvihear'=>'Preahvihear','Press Start 2P'=>'Press Start 2P','Princess Sofia'=>'Princess Sofia','Prociono'=>'Prociono','Prosto One'=>'Prosto One','Puritan'=>'Puritan','Purple Purse'=>'Purple Purse','Quando'=>'Quando','Quantico'=>'Quantico','Quattrocento'=>'Quattrocento','Quattrocento Sans'=>'Quattrocento Sans','Questrial'=>'Questrial','Quicksand'=>'Quicksand','Quintessential'=>'Quintessential','Qwigley'=>'Qwigley','Racing Sans One'=>'Racing Sans One','Radley'=>'Radley','Raleway'=>'Raleway','Raleway Dots'=>'Raleway Dots','Rambla'=>'Rambla','Rammetto One'=>'Rammetto One','Ranchers'=>'Ranchers','Rancho'=>'Rancho','Rationale'=>'Rationale','Redressed'=>'Redressed','Reenie Beanie'=>'Reenie Beanie','Revalia'=>'Revalia','Ribeye'=>'Ribeye','Ribeye Marrow'=>'Ribeye Marrow','Righteous'=>'Righteous','Risque'=>'Risque','Rochester'=>'Rochester','Rock Salt'=>'Rock Salt','Rokkitt'=>'Rokkitt','Romanesco'=>'Romanesco','Ropa Sans'=>'Ropa Sans','Rosario'=>'Rosario','Rosarivo'=>'Rosarivo','Rouge Script'=>'Rouge Script','Ruda'=>'Ruda','Rufina'=>'Rufina','Ruge Boogie'=>'Ruge Boogie','Ruluko'=>'Ruluko','Rum Raisin'=>'Rum Raisin','Ruslan Display'=>'Ruslan Display','Russo One'=>'Russo One','Ruthie'=>'Ruthie','Rye'=>'Rye','Sacramento'=>'Sacramento','Sail'=>'Sail','Salsa'=>'Salsa','Sanchez'=>'Sanchez','Sancreek'=>'Sancreek','Sansita One'=>'Sansita One','Sarina'=>'Sarina','Satisfy'=>'Satisfy','Scada'=>'Scada','Schoolbell'=>'Schoolbell','Seaweed Script'=>'Seaweed Script','Sevillana'=>'Sevillana','Seymour One'=>'Seymour One','Shadows Into Light'=>'Shadows Into Light','Shadows Into Light Two'=>'Shadows Into Light Two','Shanti'=>'Shanti','Share'=>'Share','Share Tech'=>'Share Tech','Share Tech Mono'=>'Share Tech Mono','Shojumaru'=>'Shojumaru','Short Stack'=>'Short Stack','Siemreap'=>'Siemreap','Sigmar One'=>'Sigmar One','Signika'=>'Signika','Signika Negative'=>'Signika Negative','Simonetta'=>'Simonetta','Sirin Stencil'=>'Sirin Stencil','Six Caps'=>'Six Caps','Skranji'=>'Skranji','Slackey'=>'Slackey','Smokum'=>'Smokum','Smythe'=>'Smythe','Sniglet'=>'Sniglet','Snippet'=>'Snippet','Snowburst One'=>'Snowburst One','Sofadi One'=>'Sofadi One','Sofia'=>'Sofia','Sonsie One'=>'Sonsie One','Sorts Mill Goudy'=>'Sorts Mill Goudy','Source Code Pro'=>'Source Code Pro','Source Sans Pro'=>'Source Sans Pro','Special Elite'=>'Special Elite','Spicy Rice'=>'Spicy Rice','Spinnaker'=>'Spinnaker','Spirax'=>'Spirax','Squada One'=>'Squada One','Stalemate'=>'Stalemate','Stalinist One'=>'Stalinist One','Stardos Stencil'=>'Stardos Stencil','Stint Ultra Condensed'=>'Stint Ultra Condensed','Stint Ultra Expanded'=>'Stint Ultra Expanded','Stoke'=>'Stoke','Strait'=>'Strait','Sue Ellen Francisco'=>'Sue Ellen Francisco','Sunshiney'=>'Sunshiney','Supermercado One'=>'Supermercado One','Suwannaphum'=>'Suwannaphum','Swanky and Moo Moo'=>'Swanky and Moo Moo','Syncopate'=>'Syncopate','Tangerine'=>'Tangerine','Taprom'=>'Taprom','Telex'=>'Telex','Tenor Sans'=>'Tenor Sans','Text Me One'=>'Text Me One','The Girl Next Door'=>'The Girl Next Door','Tienne'=>'Tienne','Tinos'=>'Tinos','Titan One'=>'Titan One','Titillium Web'=>'Titillium Web','Trade Winds'=>'Trade Winds','Trocchi'=>'Trocchi','Trochut'=>'Trochut','Trykker'=>'Trykker','Tulpen One'=>'Tulpen One','Ubuntu'=>'Ubuntu','Ubuntu Condensed'=>'Ubuntu Condensed','Ubuntu Mono'=>'Ubuntu Mono','Ultra'=>'Ultra','Uncial Antiqua'=>'Uncial Antiqua','Underdog'=>'Underdog','Unica One'=>'Unica One','UnifrakturCook'=>'UnifrakturCook','UnifrakturMaguntia'=>'UnifrakturMaguntia','Unkempt'=>'Unkempt','Unlock'=>'Unlock','Unna'=>'Unna','VT323'=>'VT323','Vampiro One'=>'Vampiro One','Varela'=>'Varela','Varela Round'=>'Varela Round','Vast Shadow'=>'Vast Shadow','Vibur'=>'Vibur','Vidaloka'=>'Vidaloka','Viga'=>'Viga','Voces'=>'Voces','Volkhov'=>'Volkhov','Vollkorn'=>'Vollkorn','Voltaire'=>'Voltaire','Waiting for the Sunrise'=>'Waiting for the Sunrise','Wallpoet'=>'Wallpoet','Walter Turncoat'=>'Walter Turncoat','Warnes'=>'Warnes','Wellfleet'=>'Wellfleet','Wendy One'=>'Wendy One','Wire One'=>'Wire One','Yanone Kaffeesatz'=>'Yanone Kaffeesatz','Yellowtail'=>'Yellowtail','Yeseva One'=>'Yeseva One','Yesteryear'=>'Yesteryear','Zeyada'=>'Zeyada');

	// Background Option
	$background_options = array('presets' => __( 'Presets','cyon' ), 'custom' => __( 'Custom','cyon' ));

	// Background
	$background_defaults = array('color' => '#555555', 'image' => '', 'repeat' => 'no-repeat','position' => 'top center','attachment'=>'scroll');

	// Lightbox
	$lightbox_gallery_style = array('none' => __( 'None','cyon' ), 'buttons' => __( 'Buttons','cyon' ), 'thumbnails' => __( 'Thumbnails','cyon' ));

	// Widget locations
	$widget_locations = array(
		'' => __('- None -','cyon'),
		'cyon_before_header' => __('Header Before','cyon'),
		'cyon_header' => __('Header','cyon'),
		'cyon_before_body' => __('Body Before','cyon'),
		'cyon_after_body' => __('Body After','cyon'),
		'cyon_before_body_wrapper' => __('Body Wrapper Before','cyon'),
		'cyon_after_body_wrapper' => __('Body Wrapper After','cyon'),
		'cyon_primary_before' => __('Primary Content Before','cyon'),
		'cyon_primary_after' => __('Primary Content After','cyon'),
		'cyon_sidebar_before' => __('Sidebar Before','cyon'),
		'cyon_sidebar_after' => __('Sidebar After','cyon'),
		'cyon_post_header_before' => __('Post Header Before','cyon'),
		'cyon_post_header_after' => __('Post Header After','cyon'),
		'cyon_post_content_before' => __('Post Content Before','cyon'),
		'cyon_post_content_after' => __('Post Content After','cyon'),
		'cyon_post_footer' => __('Post Footer','cyon'),
		'cyon_home_content' => __('Homepage Content','cyon'),
		'cyon_footer' => __('Footer','cyon'),
		'cyon_after_footer' => __('Footer After','cyon')
	);

	// Menu Options
	/*
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	$menuitems = array('0' => 'Use Default - Show Published Pages');
	foreach ( $menus as $menu ) {
		$menuitems[$menu->term_id] = $menu->name;
	}
	$menu_array = $menuitems;
	*/
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __('Select a page:','cyon');
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  CYON_DIRECTORY . '/assets/images/';
		
	$options = array();
		
	$options[] = array( 'name'		=> __( 'Styling','cyon' ),
						'type' 		=> 'heading');

	$options[] = array( 'name' 		=> __( 'Logo and Icons','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name'		=> __( 'Logo File','cyon' ),
						'id' 		=> 'header_logo',
						'std' 		=> '',
						'desc'		=> __('This will replace the website name text and use the image instead. Also replace the admin logo.','cyon'),
						'type' 		=> 'upload');

	$options[] = array( 'name'		=> __( 'Favicon File','cyon' ),
						'id' 		=> 'favicon',
						'std' 		=> '',
						'desc'		=> __('Use 16 x 16 size of ico file.','cyon'),
						'type' 		=> 'upload');

	$options[] = array( 'name'		=> __( 'iOS Icon File','cyon' ),
						'id' 		=> 'iosicon',
						'std' 		=> '',
						'desc'		=> __('Minimum is 57 x 57 at 72dpi of png file. For retina display, maximum is 114 x 114.','cyon'),
						'type' 		=> 'upload');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Theme Selection','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Color','cyon'),
						'desc' 		=> '',
						'id' 		=> 'theme_color',
						'std'		=> 'light',
						'type' 		=> 'select',
						'options' 	=> array('light'=>__('Light','cyon'), 'dark'=>__('Dark','cyon')));			

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Typography','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Primary Font','cyon'),
						'desc' 		=> __('Font use to the whole site','cyon'),
						'id' 		=> 'primary_font',
						'std'		=> 'default',
						'type' 		=> 'select',
						'options' 	=> $custom_fonts);			

	$options[] = array( 'name'		=> __( 'Google Font as Primary','cyon' ),
						'id' 		=> 'primary_font_google',
						'desc'		=> '',
						'std' 		=> 'Droid Sans',
						'class'		=> 'hidden googlefont',
						'type' 		=> 'select',
						'options'	=> $google_fonts_array);

	$options[] = array( 'name' 		=> __('Secondary Font','cyon'),
						'desc' 		=> __('Font use for Headers','cyon'),
						'id' 		=> 'secondary_font',
						'std'		=> 'default',
						'type' 		=> 'select',
						'options' 	=> $custom_fonts);			

	$options[] = array( 'name'		=> __( 'Google Font as Secondary','cyon' ),
						'id' 		=> 'secondary_font_google',
						'desc'		=> '',
						'std' 		=> 'Droid Sans',
						'class'		=> 'hidden googlefont',
						'type' 		=> 'select',
						'options'	=> $google_fonts_array);

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Background','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Style','cyon'),
						'desc' 		=> '',
						'id' 		=> 'background_style',
						'std'		=> 'default',
						'type' 		=> 'select',
						'options' 	=> array('pattern'=>__('Pattern','cyon'), 'full'=>__('Full Screen Image','cyon'), 'youtube'=>__('Youtube Video','cyon')));			

	$options[] = array( 'name'		=> __('Color','cyon'),
						'desc'		=> '',
						'id' 		=> 'background_color',
						'std' 		=> '#ffffff',
						'type' 		=> 'color');

	$options[] = array( 'name'		=> __( 'Image File','cyon' ),
						'id' 		=> 'background_style_image',
						'std' 		=> '',
						'desc'		=> '',
						'type' 		=> 'upload');

	$options[] = array( 'name' 		=> __('Repeat','cyon'),
						'desc' 		=> '',
						'id' 		=> 'background_style_pattern_repeat',
						'class'		=> 'hidden',
						'std'		=> 'repeat',
						'type' 		=> 'select',
						'options' 	=> array('repeat'=>__('Repeat','cyon'), 'no-repeat'=>__('No Repeat','cyon'), 'repeat-x'=>__('Repeat Horizontally','cyon'), 'repeat-y'=>__('Repeat Vertically','cyon')));			

	$options[] = array( 'name' 		=> __('Position','cyon'),
						'desc' 		=> __( 'This is horizontal-vertical and can also use top, left, center, bottom, right','cyon' ),
						'id' 		=> 'background_style_pattern_position',
						'class'		=> 'hidden',
						'std'		=> '50% 0',
						'type' 		=> 'text');			

	$options[] = array( 'name' 		=> __('Youtube ID','cyon'),
						'desc' 		=> __( 'This doesnt work on mobile phones or iPad','cyon' ),
						'id' 		=> 'background_style_youtube',
						'class'		=> 'hidden',
						'std'		=> '_VKW_M_uVjw',
						'type' 		=> 'text');			

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Layout','cyon' ),
						'type' 		=> 'heading');

	$options[] = array( 'name' 		=> __( 'General Layout','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' => __( 'Default layout of the website','cyon' ),
						'desc' => '',
						'id' => 'general_layout',
						'std' => 'general-2right',
						'type' => 'images',
						'options' => array(
							'general-1column' => $imagepath . '1col.gif',
							'general-2left' => $imagepath . '2col-left.gif',
							'general-2right' => $imagepath . '2col-right.gif')
						);

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Header','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Top Left Content','cyon' ),
						'id' 		=> 'top_left_content',
						'std' 		=> '',
						'desc'		=> __('This will show at the very top of the page on the left side corner.','cyon'),
						'type' 		=> 'texthtml'); 

	$options[] = array( 'name' 		=> __( 'Top Right Content','cyon' ),
						'id' 		=> 'top_right_content',
						'std' 		=> '',
						'desc'		=> __('This will show at the very top of the page on the right side corner.','cyon'),
						'type' 		=> 'texthtml'); 

	$options[] = array( 'name' => __( 'Logo/Menu Layout','cyon' ),
						'desc' => '',
						'id' => 'header_layout',
						'std' => 'logo-left',
						'type' => 'images',
						'options' => array(
							'logo-left' => $imagepath . 'logo-left.gif',
							'logo-center' => $imagepath . 'logo-center.gif',
							'logo-right' => $imagepath . 'logo-right.gif',
							'logo-left-menu' => $imagepath . 'logo-left-menu.gif',
							'logo-right-menu' => $imagepath . 'logo-right-menu.gif')
						);

	$options[] = array( 'name' 		=> __( 'Breadcrumbs','cyon' ),
						'desc' 		=> __( 'Yes, use breadcrumbs on inner pages. If you are runnig Woocommerce, this will be ignored.','cyon' ),
						'id' 		=> 'breadcrumbs',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Content','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Display author','cyon'),
						'desc' 		=> '',
						'id' 		=> 'content_author',
						'std'		=> 'disable',
						'type' 		=> 'radio',
						'options' 	=> array('disable'=>__('Disable','cyon'), 'enable'=>__('Enable','cyon')));			

	$options[] = array( 'name' 		=> __('Commenting to all Post/Page','cyon'),
						'desc' 		=> '',
						'id' 		=> 'content_comment',
						'std'		=> 'disable',
						'type' 		=> 'radio',
						'options' 	=> array('disable'=>__('Disable','cyon'), 'enable'=>__('Enable','cyon')));			

	$options[] = array( 'name' 		=> __('Featured image display','cyon'),
						'desc' 		=> '',
						'id' 		=> 'content_featured_image',
						'std' 		=> $socialshare_defaults, // These items get checked by default
						'type' 		=> 'multicheck',
						'options' 	=> $socialshare_array);

	$options[] = array( 'name' 		=> __( 'Gallery','cyon' ),
						'desc' 		=> __( 'Allow to override default WP Gallery','cyon' ),
						'id' 		=> 'content_gallery',
						'std'		=> 'default',
						'type' 		=> 'radio',
						'options' 	=> array('default'=>__('Use default','cyon'), 'slider_only'=>__('Slider only','cyon'), 'slider_carousel'=>__('Slider with carousel','cyon')));			

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Blog List Display','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __('Content display','cyon'),
						'desc' 		=> '',
						'id' 		=> 'content_blog_post',
						'std'		=> 'excerpt',
						'type' 		=> 'radio',
						'options' 	=> array('excerpt'=>__('Excerpt only','cyon'), 'full'=>__('Full content','cyon')));			

	$options[] = array( 'name' 		=> __( 'List layout','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'blog_list_layout',
						'std' 		=> 'list-1column',
						'type' 		=> 'images',
						'options' => array(
							'list-1column' => $imagepath . 'bucket-1col.gif',
							'list-2columns' => $imagepath . 'bucket-2col.gif',
							'list-3columns' => $imagepath . 'bucket-3col.gif',
							'list-4columns' => $imagepath . 'bucket-4col.gif')
						);

	$options[] = array( 'name' 		=> __('Use Masonry (a dynamic grid layout)','cyon'),
						'desc' 		=> __('Yes, use Masonry as default layout','cyon'),
						'id' 		=> 'blog_list_masonry',
						'std' 		=> '0',
						'type' 		=> 'checkbox');

	$options[] = array( 'name' 		=> __('Thumbnail size','cyon'),
						'desc' 		=> '',
						'id' 		=> 'content_thumbnail_size',
						'std'		=> 'large',
						'type' 		=> 'radio',
						'options' 	=> array('small'=>__('Small','cyon'), 'medium'=>__('Medium','cyon'), 'large'=>__('Large','cyon'), 'full'=>__('Full','cyon')));			

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Footer','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Footer Columns','cyon' ),
						'desc' 		=> __('Shows number of footer columns to be used. Check the <a href="'. get_bloginfo('wpurl') .'/wp-admin/widgets.php">widget area</a> and look for the Footer Buckets section','cyon'),
						'id' 		=> 'footer_bucket_layout',
						'std' 		=> 'bucket-4columns',
						'type' 		=> 'images',
						'options' => array(
							'bucket-1column' => $imagepath . 'bucket-1col.gif',
							'bucket-2columns' => $imagepath . 'bucket-2col.gif',
							'bucket-3columns' => $imagepath . 'bucket-3col.gif',
							'bucket-4columns' => $imagepath . 'bucket-4col.gif')
						);

	$options[] = array( 'name' 		=> __( 'Copyright','cyon' ),
						'id' 		=> 'footer_copyright',
						'std' 		=> __('&copy; '. date('Y') .' MyCompany.com. All Rights Reserved.','cyon'),
						'type' 		=> 'texthtml'); 

	$options[] = array( 'name' 		=> __( 'Sub Footer','cyon' ),
						'id' 		=> 'footer_sub',
						'desc'		=> __('This will show at the very bottom of the page.','cyon'),
						'std' 		=> '',
						'type' 		=> 'texthtml'); 

	$options[] = array( 'name' 		=> __( 'Back to Top Button','cyon' ),

						'desc' 		=> __( 'Shows back to top button in all pages','cyon' ),
						'id' 		=> 'footer_backtotop',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Homepage','cyon' ),
						'type' 		=> 'heading');

	$options[] = array( 'name' 		=> __( 'Layout','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' => __( 'Default layout of Homepage','cyon' ),
						'desc' => __('This will override the default layout','cyon'),
						'id' => 'homepage_layout',
						'std' => 'general-1column',
						'type' => 'images',
						'options' => array(
							'general-1column' => $imagepath . '1col.gif',
							'general-2left' => $imagepath . '2col-left.gif',
							'general-2right' => $imagepath . '2col-right.gif')
						);

	$options[] = array( 'name' 		=> __( 'Show Page Content','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_page_content',
						'std' 		=> '0',
						'type' 		=> 'radio',
						'options' 	=> array('1'=>__('Yes','cyon'), '0'=>__('No','cyon')));

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Middle Buckets','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' => __( 'Number of Columns','cyon' ),
						'desc' => __('Shows number of bucket columns to be used. Check the <a href="'. get_bloginfo('wpurl') .'/wp-admin/widgets.php">widget area</a> and look for the Homepage Buckets section','cyon'),
						'id' => 'homepage_bucket_layout',
						'std' => 'bucket-3columns',
						'type' => 'images',
						'options' => array(
							'bucket-1column' => $imagepath . 'bucket-1col.gif',
							'bucket-2columns' => $imagepath . 'bucket-2col.gif',
							'bucket-3columns' => $imagepath . 'bucket-3col.gif',
							'bucket-4columns' => $imagepath . 'bucket-4col.gif')
						);

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Slider','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Type of Slider to be used','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider',
						'std' 		=> 'default',
						'type' 		=> 'radio',
						'options' 	=> $sliders_array);

	$options[] = array( 'name'		=> __( 'Single Image File','cyon' ),
						'id' 		=> 'homepage_slider_image_file',
						'std' 		=> '',
						'class'		=> 'hidden',
						'type' 		=> 'upload');

	$options[] = array( 'name'		=> __( 'Single Image URL when clicked','cyon' ),
						'id' 		=> 'homepage_slider_image_url',
						'desc'		=> __('Leave empty if not applicable.','cyon'),
						'std' 		=> '',
						'class'		=> 'hidden',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Animation Style','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_animation',
						'std' 		=> '0',
						'type' 		=> 'radio',
						'class'		=> 'hidden',
						'options' 	=> array('0'=>__('Fade','cyon'), '1'=>__('Slide Horizontal','cyon'), '2'=>__('Slide Vertical','cyon')));

	$options[] = array( 'name' 		=> __( 'Show caption','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_caption',
						'std' 		=> '1',
						'type' 		=> 'radio',
						'class'		=> 'hidden',
						'options' 	=> array('1'=>__('Yes','cyon'), '0'=>__('No','cyon')));

	$options[] = array( 'name' 		=> __( 'Caption Layout','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_caption_layout',
						'std' 		=> 'bottom-left',
						'type' 		=> 'select',
						'options' 	=> array('top-left'=>__('Top Left','cyon'), 'top-right'=>__('Top Right','cyon'), 'bottom-left'=>__('Bottom Left','cyon'), 'bottom-right'=>__('Bottom Right','cyon')));

	$options[] = array( 'name' 		=> __( 'Caption Width','cyon' ),
						'desc' 		=> __('Use percentage','cyon'),
						'id' 		=> 'homepage_slider_caption_width',
						'std' 		=> '100%',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Show navigation arrow','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_arrows',
						'std' 		=> '1',
						'type' 		=> 'radio',
						'class'		=> 'hidden',
						'options' 	=> array('1'=>__('Yes','cyon'), '0'=>__('No','cyon')));

	$options[] = array( 'name' 		=> __( 'Show pagination','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_pagination',
						'std' 		=> '1',
						'type' 		=> 'radio',
						'class'		=> 'hidden',
						'options' 	=> array('1'=>__('Yes','cyon'), '0'=>__('No','cyon')));

	$options[] = array( 'name' 		=> __( 'Pagination Layout','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'homepage_slider_pagination_layout',
						'std' 		=> 'top-right',
						'type' 		=> 'select',
						'options' 	=> array('top-center'=>__('Top Center','cyon'), 'top-left'=>__('Top Left','cyon'), 'top-right'=>__('Top Right','cyon'), 'bottom-center'=>__('Bottom Center','cyon'), 'bottom-left'=>__('Bottom Left','cyon'), 'bottom-right'=>__('Bottom Right','cyon')));

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Middle Content','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Content','cyon' ),
						'id' 		=> 'homepage_middle',
						'desc' 		=> __('This will show above the middle buckets.','cyon'),
						'std'		=> 'staticblock',
						'type'		=> 'radio',
						'options'	=> $homepage_middle);
						
	$options[] = array( 'name' 		=> __( 'Static Block','cyon' ),
						'id' 		=> 'homepage_middle_block',
						'std' 		=> '',
						'class'		=> 'hidden',
						'type' 		=> 'texthtml'); 

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Widgets','cyon' ),
						'type' 		=> 'heading');

	$options[] = array( 'name' 		=> __( 'Widget 1','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Name','cyon' ),
						'desc' 		=> 'ID: cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_1_name'))),
						'id' 		=> 'widget_1_name',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Description','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'widget_1_description',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Location','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'widget_1_location',
						'std' 		=> '',
						'type' 		=> 'select',
						'options' 	=> $widget_locations);

	$options[] = array( 'name' 		=> __( 'Order Number','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'widget_1_order',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Widget 2','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Name','cyon' ),
						'desc' 		=> 'ID: cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_2_name'))),
						'id' 		=> 'widget_2_name',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Description','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'widget_2_description',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Location','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'widget_2_location',
						'std' 		=> '',
						'type' 		=> 'select',
						'options' 	=> $widget_locations);

	$options[] = array( 'name' 		=> __( 'Order Number','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'widget_2_order',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Widget 3','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Name','cyon' ),
						'desc' 		=> 'ID: cyon-'.str_replace(' ', '-', strtolower(of_get_option('widget_3_name'))),
						'id' 		=> 'widget_3_name',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Description','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'widget_3_description',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'name' 		=> __( 'Location','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'widget_3_location',
						'std' 		=> '',
						'type' 		=> 'select',
						'options' 	=> $widget_locations);

	$options[] = array( 'name' 		=> __( 'Order Number','cyon' ),
						'desc' 		=> '',
						'id' 		=> 'widget_3_order',
						'std' 		=> '',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Configuration','cyon' ),
						'type' 		=> 'heading');
						
	$options[] = array( 'name' 		=> __( 'Social Settings','cyon' ),
						'type' 		=> 'section_start');
						
	$options[] = array( 'name'		=> __( 'Pages to appear the social boxes','cyon' ),
						'desc'		=> '',
						'id' 		=> 'socialshare',
						'std' 		=> $socialshare_defaults, // These items get checked by default
						'type' 		=> 'multicheck',
						'options' 	=> $socialshare_array);

	$options[] = array( 'name'		=> __( 'Social Boxes','cyon' ),
						'desc'		=> '',
						'id' 		=> 'socialshareboxes',
						'std' 		=> $socialshareboxes_defaults,
						'type' 		=> 'multicheck',
						'options' 	=> $socialshareboxes_array);

	$options[] = array( 'name'		=> __( 'Twitter ID','cyon' ),
						'id' 		=> 'social_twitter',
						'desc'		=> '',
						'std' 		=> 'twitter',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'SEO','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Activate SEO','cyon' ),
						'desc' 		=> __( 'Activates SEO options to all pages and posts.','cyon' ),
						'id' 		=> 'seo_activate',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'name'		=> __( 'Page Title Format','cyon' ),
						'id' 		=> 'seo_title_format',
						'desc' 		=> __('Accepts','cyon').': {PAGETITLE}, {BLOGTITLE}, {BLOGTAGLINE}',
						'std' 		=> '{PAGETITLE} | {BLOGTITLE}',
						'type' 		=> 'text');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Lightbox','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Activate Lightbox','cyon' ),
						'desc' 		=> __( 'Activates lightbox in all linked to images, this includes WP Gallery. Supports jpg, png, gif, and bmp.','cyon' ),
						'id' 		=> 'lightbox_activate',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'name' 		=> __( 'Gallery Style','cyon' ),
						'id' 		=> 'lightbox_gallery_style',
						'desc' 		=> '',
						'std'		=> 'none',
						'type'		=> 'radio',
						'options'	=> $lightbox_gallery_style);

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Scripts Support','cyon' ),
						'type' 		=> 'section_start');
						
	$options[] = array( 'name' 		=> __( 'Responsiveness','cyon' ),
						'desc' 		=> __( 'Allow special styles mobile devices','cyon' ),
						'id' 		=> 'responsive',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'name' 		=> __( 'LazyLoad','cyon' ),
						'desc' 		=> __( 'Activates LazyLoad in all images','cyon' ),
						'id' 		=> 'lazyload',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'name' 		=> __( 'Header Scripts','cyon' ),
						'desc' 		=> __( 'Scripts and Links placed inside the head tag. Can include &lt;script&gt;, &lt;link&gt; and other tags. Can have Google Analytics here.','cyon' ),
						'id' 		=> 'header_scripts',
						'std' 		=> '',
						'type' 		=> 'texthtml');

	$options[] = array( 'name' 		=> __( 'Footer Scripts','cyon' ),
						'desc' 		=> __( 'Scripts placed below the footer just before the end body tag. Can include &lt;script&gt;, &lt;link&gt; and other tags.','cyon' ),
						'id' 		=> 'footer_scripts',
						'std' 		=> '',
						'type' 		=> 'texthtml');

	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name'		=> __( 'Admin','cyon' ),
						'type' 		=> 'heading');
						
	$options[] = array( 'name' 		=> __( 'Login','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name'		=> __('Background Color','cyon'),
						'desc'		=> '',
						'id' 		=> 'admin_login_bgcolor',
						'std' 		=> '#fbfbfb',
						'type' 		=> 'color');
						
	$options[] = array( 'type'		=> 'section_end'); 

	$options[] = array( 'name' 		=> __( 'Updates','cyon' ),
						'type' 		=> 'section_start');

	$options[] = array( 'name' 		=> __( 'Remove Core Updates','cyon' ),
						'desc' 		=> __( 'Yes, remove updates and notification','cyon' ),
						'id' 		=> 'admin_core_updates',
						'std' 		=> '',
						'type' 		=> 'checkbox');
						
	$options[] = array( 'name' 		=> __( 'Remove Plugin Updates','cyon' ),
						'desc' 		=> __( 'Yes, remove updates and notification','cyon' ),
						'id' 		=> 'admin_plugin_updates',
						'std' 		=> '1',
						'type' 		=> 'checkbox');

	$options[] = array( 'type'		=> 'section_end'); 

	return $options;
}