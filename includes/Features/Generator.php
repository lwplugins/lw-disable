<?php
/**
 * Generator feature - remove WordPress version meta tag.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles removing WordPress version disclosure.
 */
final class Generator {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'generator' ) ) {
			return;
		}

		remove_action( 'wp_head', 'wp_generator' );
		add_filter( 'the_generator', '__return_empty_string' );
	}
}
