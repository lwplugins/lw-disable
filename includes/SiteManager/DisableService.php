<?php
/**
 * Disable Service for LW Site Manager abilities.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\SiteManager;

use LightweightPlugins\Disable\Options;

/**
 * Executes Disable abilities for the Site Manager.
 */
final class DisableService {

	/**
	 * Valid option keys accepted by set-options.
	 */
	private const VALID_KEYS = array(
		'comments',
		'admin_new_user_email',
		'emojis',
		'embeds',
		'heartbeat',
		'block_library',
		'xmlrpc',
		'rest_api',
		'application_passwords',
		'generator',
		'shortlink',
		'rsd_link',
		'wlw_manifest',
		'version_strings',
		'adjacent_posts',
		'feeds',
	);

	/**
	 * Get all LW Disable options.
	 *
	 * @param array<string, mixed> $input Input parameters (unused).
	 * @return array<string, mixed>
	 */
	public static function get_options( array $input ): array { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found -- Required by ability callback interface.
		return array(
			'success' => true,
			'options' => Options::get_all(),
		);
	}

	/**
	 * Set LW Disable options.
	 *
	 * @param array<string, mixed> $input Input parameters.
	 * @return array<string, mixed>|\WP_Error
	 */
	public static function set_options( array $input ): array|\WP_Error {
		$incoming = $input['options'] ?? array();

		if ( ! is_array( $incoming ) || empty( $incoming ) ) {
			return new \WP_Error(
				'invalid_input',
				__( 'Provide an options object with at least one key.', 'lw-disable' ),
				array( 'status' => 400 )
			);
		}

		$current = Options::get_all();
		$updated = array();

		foreach ( $incoming as $key => $value ) {
			if ( ! in_array( $key, self::VALID_KEYS, true ) ) {
				continue;
			}

			$current[ $key ] = (bool) $value;
			$updated[]       = $key;
		}

		if ( empty( $updated ) ) {
			return new \WP_Error(
				'no_valid_keys',
				__( 'No valid option keys provided.', 'lw-disable' ),
				array( 'status' => 400 )
			);
		}

		Options::save( $current );

		return array(
			'success' => true,
			'message' => sprintf(
				/* translators: %d: number of options updated */
				__( '%d option(s) updated.', 'lw-disable' ),
				count( $updated )
			),
			'updated' => $updated,
		);
	}
}
