<?php
/**
 * Block Library feature - disable Gutenberg CSS on frontend.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling Gutenberg block library CSS.
 */
final class BlockLibrary {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'block_library' ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'disable_styles' ), 100 );
	}

	/**
	 * Disable block library styles.
	 *
	 * @return void
	 */
	public function disable_styles(): void {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wc-blocks-style' );
		wp_dequeue_style( 'global-styles' );
	}
}
