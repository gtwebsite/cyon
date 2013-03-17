<?php
if ( !defined('ABSPATH') )
	die('-1');

/* =Includes
----------------------------------------------- */
if ( class_exists( 'Woocommerce' ) ) {
	require_once (CYON_FILEPATH . '/includes/overrides/woocommerce.php');	// Woocommerce
}

