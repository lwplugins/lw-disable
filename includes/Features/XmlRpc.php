<?php
/**
 * XML-RPC feature - disable XML-RPC protocol.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling XML-RPC.
 */
final class XmlRpc {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'xmlrpc' ) ) {
			return;
		}

		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @return void
	 */
	private function init_hooks(): void {
		add_filter( 'xmlrpc_enabled', '__return_false' );
		add_filter( 'xmlrpc_methods', array( $this, 'remove_methods' ), PHP_INT_MAX );
		add_filter( 'wp_headers', array( $this, 'remove_pingback_header' ) );
		remove_action( 'wp_head', 'rsd_link' );
	}

	/**
	 * Remove every XML-RPC method, so no endpoint stays available.
	 *
	 * @param array<string, mixed> $methods Registered XML-RPC methods.
	 * @return array<string, mixed>
	 */
	public function remove_methods( array $methods ): array {
		unset( $methods );
		return array();
	}

	/**
	 * Remove X-Pingback header.
	 *
	 * @param array<string, string> $headers HTTP headers.
	 * @return array<string, string>
	 */
	public function remove_pingback_header( array $headers ): array {
		unset( $headers['X-Pingback'] );
		return $headers;
	}
}
