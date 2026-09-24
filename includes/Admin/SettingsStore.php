<?php
/**
 * Settings store for the admin API.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Admin;

use LightweightPlugins\Disable\Options;

/**
 * Reads the settings as booleans and applies partial updates.
 *
 * A partial update merges the submitted keys onto the stored options, so a
 * key the client did not send keeps its stored value (never "absent = off").
 * Unknown keys are dropped. Like the classic form, the write goes through
 * Options::save(), so the option always holds every default key as a bool.
 */
final class SettingsStore {

	/**
	 * Current settings, every default key as a bool.
	 *
	 * @return array<string, bool>
	 */
	public static function current(): array {
		Options::clear_cache();

		return self::typed( Options::get_all(), Options::get_defaults() );
	}

	/**
	 * Apply a partial update and return the new settings.
	 *
	 * @param array<string, mixed> $body Submitted option keys.
	 * @return array<string, bool>
	 */
	public static function save( array $body ): array {
		$merged = self::merge(
			$body,
			get_option( Options::OPTION_NAME, array() ),
			Options::get_defaults()
		);

		Options::save( $merged );
		Options::clear_cache();

		return self::current();
	}

	/**
	 * Merge submitted keys onto the stored options.
	 *
	 * @param array<string, mixed> $body     Submitted option keys.
	 * @param mixed                $stored   Stored option value.
	 * @param array<string, bool>  $defaults Option defaults.
	 * @return array<string, bool>
	 */
	public static function merge( array $body, mixed $stored, array $defaults ): array {
		$current   = self::typed( is_array( $stored ) ? $stored : array(), $defaults );
		$submitted = array_intersect_key( $body, $defaults );

		return array_merge( $current, SettingsSanitizer::sanitize( $submitted, $current ) );
	}

	/**
	 * Every default key cast to bool, missing keys filled with the default.
	 *
	 * @param array<string, mixed> $values   Option values.
	 * @param array<string, bool>  $defaults Option defaults.
	 * @return array<string, bool>
	 */
	public static function typed( array $values, array $defaults ): array {
		$typed = array();

		foreach ( $defaults as $key => $default ) {
			$typed[ $key ] = (bool) ( array_key_exists( $key, $values ) ? $values[ $key ] : $default );
		}

		return $typed;
	}
}
