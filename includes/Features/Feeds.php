<?php
/**
 * Feeds feature - disable RSS feeds.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling RSS feeds.
 */
final class Feeds {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'feeds' ) ) {
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
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		add_action( 'do_feed', array( $this, 'redirect_feed' ), 1 );
		add_action( 'do_feed_rdf', array( $this, 'redirect_feed' ), 1 );
		add_action( 'do_feed_rss', array( $this, 'redirect_feed' ), 1 );
		add_action( 'do_feed_rss2', array( $this, 'redirect_feed' ), 1 );
		add_action( 'do_feed_atom', array( $this, 'redirect_feed' ), 1 );
	}

	/**
	 * Redirect feed requests to homepage.
	 *
	 * @return void
	 */
	public function redirect_feed(): void {
		wp_safe_redirect( home_url() );
		exit;
	}
}
