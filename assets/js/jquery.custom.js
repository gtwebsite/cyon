jQuery(document).ready(function(){

	/* Menu */
	jQuery('#access li').hover(function(){
		jQuery(this).find('> ul').fadeIn();
	},function(){
		jQuery(this).find('> ul').fadeOut();
	});

	// Box Close Support
	jQuery('.box .btn-close').click(function(){
		jQuery(this).parent().parent().fadeOut();
	});

	// Poshytip Support
	jQuery('.hastip, dfn, abbr').poshytip({
		className: 'tooltip',
		alignTo: 'target',
		alignX: 'center'
	});

});