<?php
/**
 * Embeds feature - disable WordPress oEmbed.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling the oEmbed system.
 */
final class Embeds {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'embeds' ) ) {
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
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

		add_filter( 'embed_oembed_discover', '__return_false' );

		add_action( 'wp_footer', array( $this, 'deregister_embed_script' ) );
	}

	/**
	 * Deregister embed script.
	 *
	 * @return void
	 */
	public function deregister_embed_script(): void {
		wp_deregister_script( 'wp-embed' );
	}
}
