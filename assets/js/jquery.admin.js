jQuery(document).ready(function(){

	/* Post Format */
	var checkpostformat = function() {
		var pfvalue = jQuery('#post-formats-select input[type=radio]:checked').val();
		if(pfvalue=='video'){
			jQuery('#video-settings').show();
			jQuery('#audio-settings').fadeOut();
			jQuery('#quote-settings').fadeOut();
			jQuery('#link-settings').fadeOut();
			jQuery('#gallery-settings').fadeOut();
		}else if(pfvalue=='audio'){
			jQuery('#audio-settings').show();
			jQuery('#video-settings').fadeOut();
			jQuery('#quote-settings').fadeOut();
			jQuery('#link-settings').fadeOut();
			jQuery('#gallery-settings').fadeOut();
		}else if(pfvalue=='quote'){
			jQuery('#quote-settings').show();
			jQuery('#audio-settings').fadeOut();
			jQuery('#video-settings').fadeOut();
			jQuery('#link-settings').fadeOut();
			jQuery('#gallery-settings').fadeOut();
		}else if(pfvalue=='link'){
			jQuery('#link-settings').show();
			jQuery('#quote-settings').fadeOut();
			jQuery('#audio-settings').fadeOut();
			jQuery('#video-settings').fadeOut();
			jQuery('#gallery-settings').fadeOut();
		}else if(pfvalue=='gallery'){
			jQuery('#gallery-settings').show();
			jQuery('#link-settings').fadeOut();
			jQuery('#quote-settings').fadeOut();
			jQuery('#audio-settings').fadeOut();
			jQuery('#video-settings').fadeOut();
		}else{
			jQuery('#link-settings').fadeOut();
			jQuery('#quote-settings').fadeOut();
			jQuery('#video-settings').fadeOut();
			jQuery('#audio-settings').fadeOut();
			jQuery('#gallery-settings').fadeOut();
		}
	}
	
	jQuery(document).ready(checkpostformat);
	jQuery('#post-formats-select input[type=radio]').click(checkpostformat);

});