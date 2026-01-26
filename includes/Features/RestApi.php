<?php
/**
 * REST API feature - restrict REST API to logged-in users.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;
use WP_Error;

/**
 * Handles restricting REST API access.
 */
final class RestApi {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'rest_api' ) ) {
			return;
		}

		add_filter( 'rest_authentication_errors', array( $this, 'restrict_access' ) );
	}

	/**
	 * Restrict REST API access to logged-in users.
	 *
	 * @param WP_Error|true|null $result Authentication result.
	 * @return WP_Error|true|null
	 */
	public function restrict_access( $result ) {
		if ( is_user_logged_in() ) {
			return $result;
		}

		return new WP_Error(
			'rest_not_logged_in',
			__( 'REST API restricted to authenticated users.', 'lw-disable' ),
			array( 'status' => 401 )
		);
	}
}
