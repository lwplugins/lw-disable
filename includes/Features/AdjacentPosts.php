<?php
/**
 * Adjacent Posts feature - remove prev/next post links from head.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles removing adjacent posts links.
 */
final class AdjacentPosts {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'adjacent_posts' ) ) {
			return;
		}

		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
	}
}
