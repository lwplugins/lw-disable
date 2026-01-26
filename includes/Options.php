<?php
/**
 * Options management class.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable;

/**
 * Handles plugin options.
 */
final class Options {

	/**
	 * Option name in database.
	 */
	public const OPTION_NAME = 'lw_disable';

	/**
	 * Cached options.
	 *
	 * @var array<string, mixed>|null
	 */
	private static ?array $options = null;

	/**
	 * Get default options.
	 *
	 * @return array<string, bool>
	 */
	public static function get_defaults(): array {
		return array(
			'commands' => false,
			'comments' => false,
		);
	}

	/**
	 * Get all options.
	 *
	 * @return array<string, mixed>
	 */
	public static function get_all(): array {
		if ( null === self::$options ) {
			$saved         = get_option( self::OPTION_NAME, array() );
			self::$options = wp_parse_args( $saved, self::get_defaults() );
		}

		return self::$options;
	}

	/**
	 * Get a single option.
	 *
	 * @param string $key Option key.
	 * @return mixed
	 */
	public static function get( string $key ): mixed {
		$options = self::get_all();
		return $options[ $key ] ?? self::get_defaults()[ $key ] ?? null;
	}

	/**
	 * Save options.
	 *
	 * @param array<string, mixed> $options Options to save.
	 * @return bool
	 */
	public static function save( array $options ): bool {
		self::$options = $options;
		return update_option( self::OPTION_NAME, $options );
	}
}
