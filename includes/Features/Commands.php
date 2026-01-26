<?php
/**
 * Commands feature - disable admin command palette.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling the admin command palette.
 */
final class Commands {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'maybe_disable' ) );
	}

	/**
	 * Disable command palette if option enabled.
	 *
	 * @return void
	 */
	public function maybe_disable(): void {
		if ( ! Options::get( 'commands' ) ) {
			return;
		}

		wp_deregister_script( 'wp-commands' );
	}
}
