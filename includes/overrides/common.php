<?php
if ( !defined('ABSPATH') )
	die('-1');

/* =Includes
----------------------------------------------- */
if (is_plugin_active('woocommerce/woocommerce.php')) {
	require_once (CYON_FILEPATH . '/includes/overrides/woocommerce.php');	// Woocommerce
}

