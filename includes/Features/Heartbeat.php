<?php
/**
 * Heartbeat feature - disable WordPress heartbeat API.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling the heartbeat API.
 */
final class Heartbeat {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'heartbeat' ) ) {
			return;
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'disable_heartbeat' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'disable_heartbeat' ) );
	}

	/**
	 * Disable heartbeat script.
	 *
	 * @return void
	 */
	public function disable_heartbeat(): void {
		wp_deregister_script( 'heartbeat' );
	}
}
