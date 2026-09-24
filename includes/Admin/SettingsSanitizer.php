<?php
/**
 * Settings sanitizer.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Admin;

/**
 * Sanitizes submitted switch values. Every option is a bool; a value that
 * cannot be read as one (array, object) keeps the current value.
 */
final class SettingsSanitizer {

	/**
	 * Sanitize the submitted keys.
	 *
	 * @param array<string, mixed> $submitted Submitted values (known keys only).
	 * @param array<string, bool>  $current   Current values of every key.
	 * @return array<string, bool> Sanitized values for the submitted keys.
	 */
	public static function sanitize( array $submitted, array $current ): array {
		$sanitized = array();

		foreach ( $submitted as $key => $value ) {
			$key = (string) $key;

			if ( ! array_key_exists( $key, $current ) ) {
				continue;
			}

			$sanitized[ $key ] = is_scalar( $value ) || null === $value
				? filter_var( $value, FILTER_VALIDATE_BOOLEAN )
				: $current[ $key ];
		}

		return $sanitized;
	}
}
