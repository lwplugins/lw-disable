<?php
/**
 * Emojis feature - disable WordPress emoji scripts.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling emoji scripts and styles.
 */
final class Emojis {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'emojis' ) ) {
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
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		add_filter( 'tiny_mce_plugins', array( $this, 'disable_tinymce_emoji' ) );
		add_filter( 'wp_resource_hints', array( $this, 'remove_dns_prefetch' ), 10, 2 );
	}

	/**
	 * Remove emoji from TinyMCE.
	 *
	 * @param array<string> $plugins TinyMCE plugins.
	 * @return array<string>
	 */
	public function disable_tinymce_emoji( array $plugins ): array {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}

	/**
	 * Remove emoji DNS prefetch.
	 *
	 * @param array<string> $urls          URLs to print.
	 * @param string        $relation_type Relation type.
	 * @return array<string>
	 */
	public function remove_dns_prefetch( array $urls, string $relation_type ): array {
		if ( 'dns-prefetch' !== $relation_type ) {
			return $urls;
		}

		return array_filter(
			$urls,
			static function ( $url ) {
				return ! str_contains( (string) $url, 's.w.org' );
			}
		);
	}
}
