<?php
/**
 * LW Site Manager Integration.
 *
 * Registers Disable abilities when LW Site Manager is active.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\SiteManager;

/**
 * Hooks into LW Site Manager to register Disable abilities.
 */
final class Integration {

	/**
	 * Initialize hooks. Safe to call even if Site Manager is not active.
	 *
	 * @return void
	 */
	public static function init(): void {
		add_action( 'lw_site_manager_register_categories', array( self::class, 'register_category' ) );
		add_action( 'lw_site_manager_register_abilities', array( self::class, 'register_abilities' ) );
	}

	/**
	 * Register the Disable ability category.
	 *
	 * @return void
	 */
	public static function register_category(): void {
		wp_register_ability_category(
			'disable',
			array(
				'label'       => __( 'Disable', 'lw-disable' ),
				'description' => __( 'WordPress feature disabling abilities', 'lw-disable' ),
			)
		);
	}

	/**
	 * Register Disable abilities.
	 *
	 * @param object $permissions Permission manager from Site Manager.
	 * @return void
	 */
	public static function register_abilities( object $permissions ): void {
		DisableAbilities::register( $permissions );
	}
}
