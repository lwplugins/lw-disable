<?php
/**
 * Shortlink feature - remove shortlink from head.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles removing shortlink.
 */
final class Shortlink {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'shortlink' ) ) {
			return;
		}

		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
	}
}
