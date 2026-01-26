<?php
/**
 * WP-CLI Commands.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\CLI;

use LightweightPlugins\Disable\Options;
use WP_CLI;

/**
 * Manage LW Disable settings via WP-CLI.
 */
final class Commands {

	/**
	 * List all features and their status.
	 *
	 * ## EXAMPLES
	 *
	 *     wp lw-disable list
	 *
	 * @subcommand list
	 */
	public function list_features(): void {
		$options  = Options::get_all();
		$defaults = Options::get_defaults();

		$items = array();
		foreach ( array_keys( $defaults ) as $key ) {
			$items[] = array(
				'feature' => $key,
				'status'  => $options[ $key ] ? 'enabled' : 'disabled',
			);
		}

		WP_CLI\Utils\format_items( 'table', $items, array( 'feature', 'status' ) );
	}

	/**
	 * Enable a feature.
	 *
	 * ## OPTIONS
	 *
	 * <feature>
	 * : The feature to enable.
	 *
	 * ## EXAMPLES
	 *
	 *     wp lw-disable enable emojis
	 *     wp lw-disable enable comments
	 *
	 * @param array<string> $args Positional arguments.
	 */
	public function enable( array $args ): void {
		$this->set_feature( $args[0], true );
	}

	/**
	 * Disable a feature.
	 *
	 * ## OPTIONS
	 *
	 * <feature>
	 * : The feature to disable.
	 *
	 * ## EXAMPLES
	 *
	 *     wp lw-disable disable emojis
	 *     wp lw-disable disable comments
	 *
	 * @param array<string> $args Positional arguments.
	 */
	public function disable( array $args ): void {
		$this->set_feature( $args[0], false );
	}

	/**
	 * Enable all features.
	 *
	 * ## EXAMPLES
	 *
	 *     wp lw-disable enable-all
	 *
	 * @subcommand enable-all
	 */
	public function enable_all(): void {
		$options = Options::get_all();

		foreach ( array_keys( $options ) as $key ) {
			$options[ $key ] = true;
		}

		Options::save( $options );
		WP_CLI::success( 'All features enabled.' );
	}

	/**
	 * Disable all features.
	 *
	 * ## EXAMPLES
	 *
	 *     wp lw-disable disable-all
	 *
	 * @subcommand disable-all
	 */
	public function disable_all(): void {
		$options = Options::get_all();

		foreach ( array_keys( $options ) as $key ) {
			$options[ $key ] = false;
		}

		Options::save( $options );
		WP_CLI::success( 'All features disabled.' );
	}

	/**
	 * Set feature status.
	 *
	 * @param string $feature Feature key.
	 * @param bool   $status  Enable or disable.
	 */
	private function set_feature( string $feature, bool $status ): void {
		$options  = Options::get_all();
		$defaults = Options::get_defaults();

		if ( ! array_key_exists( $feature, $defaults ) ) {
			WP_CLI::error( "Unknown feature: {$feature}" );
		}

		$options[ $feature ] = $status;
		Options::save( $options );

		$action = $status ? 'enabled' : 'disabled';
		WP_CLI::success( "Feature '{$feature}' {$action}." );
	}
}
