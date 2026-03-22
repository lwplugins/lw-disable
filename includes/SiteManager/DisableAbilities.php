<?php
/**
 * Disable Ability Definitions for LW Site Manager.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\SiteManager;

/**
 * Registers Disable-specific abilities with the WordPress Abilities API.
 */
final class DisableAbilities {

	/**
	 * Register all Disable abilities.
	 *
	 * @param object $permissions Permission manager instance.
	 * @return void
	 */
	public static function register( object $permissions ): void {
		self::register_get_options( $permissions );
		self::register_set_options( $permissions );
	}

	/**
	 * Register get-options ability.
	 *
	 * @param object $permissions Permission manager instance.
	 * @return void
	 */
	private static function register_get_options( object $permissions ): void {
		wp_register_ability(
			'lw-disable/get-options',
			array(
				'label'               => __( 'Get Disable Options', 'lw-disable' ),
				'description'         => __( 'Get all LW Disable feature settings.', 'lw-disable' ),
				'category'            => 'disable',
				'execute_callback'    => array( DisableService::class, 'get_options' ),
				'permission_callback' => $permissions->callback( 'can_manage_options' ),
				'input_schema'        => array(
					'type'    => 'object',
					'default' => array(),
				),
				'output_schema'       => array(
					'type'       => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'options' => array( 'type' => 'object' ),
					),
				),
				'meta'                => self::readonly_meta(),
			)
		);
	}

	/**
	 * Register set-options ability.
	 *
	 * @param object $permissions Permission manager instance.
	 * @return void
	 */
	private static function register_set_options( object $permissions ): void {
		wp_register_ability(
			'lw-disable/set-options',
			array(
				'label'               => __( 'Set Disable Options', 'lw-disable' ),
				'description'         => __( 'Enable or disable WordPress features managed by LW Disable.', 'lw-disable' ),
				'category'            => 'disable',
				'execute_callback'    => array( DisableService::class, 'set_options' ),
				'permission_callback' => $permissions->callback( 'can_manage_options' ),
				'input_schema'        => array(
					'type'       => 'object',
					'required'   => array( 'options' ),
					'properties' => array(
						'options' => array(
							'type'        => 'object',
							'description' => __(
								'Feature flags to update. Keys: comments, admin_new_user_email, emojis, embeds, heartbeat, block_library, xmlrpc, rest_api, application_passwords, generator, shortlink, rsd_link, wlw_manifest, version_strings, adjacent_posts, feeds.',
								'lw-disable'
							),
						),
					),
				),
				'output_schema'       => array(
					'type'       => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
						'updated' => array(
							'type'  => 'array',
							'items' => array( 'type' => 'string' ),
						),
					),
				),
				'meta'                => self::write_meta(),
			)
		);
	}

	/**
	 * Read-only ability metadata.
	 *
	 * @return array<string, mixed>
	 */
	private static function readonly_meta(): array {
		return array(
			'show_in_rest' => true,
			'annotations'  => array(
				'readonly'    => true,
				'destructive' => false,
				'idempotent'  => true,
			),
		);
	}

	/**
	 * Write ability metadata.
	 *
	 * @return array<string, mixed>
	 */
	private static function write_meta(): array {
		return array(
			'show_in_rest' => true,
			'annotations'  => array(
				'readonly'    => false,
				'destructive' => false,
				'idempotent'  => true,
			),
		);
	}
}
