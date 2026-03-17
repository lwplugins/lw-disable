<?php
/**
 * Admin Emails feature - disable admin notification emails.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling admin notification emails.
 */
final class AdminEmails {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'admin_new_user_email' ) ) {
			return;
		}

		add_filter( 'wp_new_user_notification_email_admin', '__return_false' );
	}
}
