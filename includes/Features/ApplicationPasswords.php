<?php
/**
 * Application Passwords feature - disable application passwords.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling application passwords.
 */
final class ApplicationPasswords {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'application_passwords' ) ) {
			return;
		}

		add_filter( 'wp_is_application_passwords_available', '__return_false' );
	}
}
