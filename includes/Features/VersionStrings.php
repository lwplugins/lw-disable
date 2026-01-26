<?php
/**
 * Version Strings feature - remove version query strings from assets.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles removing version query strings.
 */
final class VersionStrings {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'version_strings' ) ) {
			return;
		}

		add_filter( 'script_loader_src', array( $this, 'remove_version' ), 15 );
		add_filter( 'style_loader_src', array( $this, 'remove_version' ), 15 );
	}

	/**
	 * Remove version query string.
	 *
	 * @param string $src Asset source URL.
	 * @return string
	 */
	public function remove_version( string $src ): string {
		return remove_query_arg( 'ver', $src );
	}
}
