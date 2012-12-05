<?php

/* Adds Submenu */
add_action('admin_menu','cyon_add_portfolio_menu');
function cyon_add_portfolio_menu() {
	add_menu_page(__('Portfolio'), __('Portfolio'), 'edit_theme_options', 'gtw-portfolio', 'cyon_portfolio_page', OPTIONS_FRAMEWORK_DIRECTORY.'images/ico-portfolio.png',35);
	add_submenu_page('gtw-portfolio', __('Add New Portfolio'), __('Add New'), 'edit_theme_options', 'gtw-portfolio-add-page', 'cyon_portfolio_add_page');
	add_submenu_page('gtw-portfolio', __('Add New Portfolio'), __('Categories'), 'edit_theme_options', 'gtw-portfolio-categories-page', 'cyon_portfolio_categories_page');
}

function cyon_portfolio_page() { ?>
	<div class="wrap">
		<div id="icon-edit" class="icon32"><br></div>
		<h2><?php _e('Portfolio') ?></h2>
	</div>
<?php }

function cyon_portfolio_add_page() { ?>
	<div class="wrap">
		<div id="icon-edit" class="icon32"><br></div>
		<h2><?php _e('Add New Portfolio') ?></h2>
	</div>
<?php }

function cyon_portfolio_categories_page() { ?>
	<div class="wrap">
		<div id="icon-edit" class="icon32"><br></div>
		<h2><?php _e('Categories') ?></h2>
	</div>
<?php }