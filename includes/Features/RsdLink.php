<?php
/**
 * RSD Link feature - remove Really Simple Discovery link.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles removing RSD link.
 */
final class RsdLink {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'rsd_link' ) ) {
			return;
		}

		remove_action( 'wp_head', 'rsd_link' );
	}
}
