<?php
/**
 * WLW Manifest feature - remove Windows Live Writer link.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles removing WLW manifest link.
 */
final class WlwManifest {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'wlw_manifest' ) ) {
			return;
		}

		remove_action( 'wp_head', 'wlwmanifest_link' );
	}
}
