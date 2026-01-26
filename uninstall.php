<?php
/**
 * Uninstall script.
 *
 * @package LWDisable
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'lw_disable' );
