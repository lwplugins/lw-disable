<?php
/**
 * SettingsStore unit tests.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Tests\Unit\Admin;

use Brain\Monkey\Functions;
use LightweightPlugins\Disable\Admin\SettingsStore;
use LightweightPlugins\Disable\Options;
use LightweightPlugins\Disable\Tests\Unit\MonkeyTestCase;

/**
 * @covers \LightweightPlugins\Disable\Admin\SettingsStore
 * @covers \LightweightPlugins\Disable\Admin\SettingsSanitizer
 */
final class SettingsStoreTest extends MonkeyTestCase {

	private const DEFAULTS = array(
		'comments' => false,
		'emojis'   => false,
		'feeds'    => false,
	);

	protected function tearDown(): void {
		Options::clear_cache();
		parent::tearDown();
	}

	public function test_merge_keeps_stored_values_for_absent_keys(): void {
		$stored = array(
			'comments' => true,
			'feeds'    => true,
		);

		$result = SettingsStore::merge( array( 'emojis' => true ), $stored, self::DEFAULTS );

		$this->assertSame(
			array(
				'comments' => true,
				'emojis'   => true,
				'feeds'    => true,
			),
			$result
		);
	}

	public function test_merge_applies_submitted_false(): void {
		$result = SettingsStore::merge( array( 'comments' => false ), array( 'comments' => true ), self::DEFAULTS );

		$this->assertFalse( $result['comments'] );
	}

	public function test_merge_drops_unknown_submitted_and_stored_keys(): void {
		$result = SettingsStore::merge(
			array(
				'evil'    => true,
				'_locale' => 'user',
			),
			array( 'legacy' => true ),
			self::DEFAULTS
		);

		$this->assertSame( self::DEFAULTS, $result );
	}

	/**
	 * @return array<string, array{0: mixed, 1: bool}>
	 */
	public static function bool_provider(): array {
		return array(
			'true'           => array( true, true ),
			'false'          => array( false, false ),
			'int one'        => array( 1, true ),
			'int zero'       => array( 0, false ),
			'string one'     => array( '1', true ),
			'string true'    => array( 'true', true ),
			'string false'   => array( 'false', false ),
			'empty string'   => array( '', false ),
			'garbage string' => array( 'yes please', false ),
			'null'           => array( null, false ),
			'array keeps'    => array( array( true ), true ),
		);
	}

	/**
	 * @dataProvider bool_provider
	 *
	 * @param mixed $submitted Submitted value.
	 * @param bool  $expected  Stored value.
	 */
	public function test_merge_casts_submitted_values_to_bool( $submitted, bool $expected ): void {
		$result = SettingsStore::merge( array( 'emojis' => $submitted ), array( 'emojis' => true ), self::DEFAULTS );

		$this->assertSame( $expected, $result['emojis'] );
	}

	public function test_merge_treats_a_non_array_stored_value_as_empty(): void {
		$this->assertSame( self::DEFAULTS, SettingsStore::merge( array(), false, self::DEFAULTS ) );
	}

	public function test_typed_casts_stored_values_to_bool(): void {
		$result = SettingsStore::typed(
			array(
				'comments' => '1',
				'emojis'   => 0,
			),
			self::DEFAULTS
		);

		$this->assertSame(
			array(
				'comments' => true,
				'emojis'   => false,
				'feeds'    => false,
			),
			$result
		);
	}

	public function test_save_writes_every_default_key_and_returns_current(): void {
		$written = null;
		Functions\when( 'get_option' )->justReturn( array( 'feeds' => true ) );
		Functions\when( 'wp_parse_args' )->alias(
			static fn( $args, $defaults = array() ) => array_merge( (array) $defaults, (array) $args )
		);
		Functions\when( 'update_option' )->alias(
			static function ( $name, $value ) use ( &$written ): bool {
				$written = array( $name, $value );
				return true;
			}
		);

		$result = SettingsStore::save( array( 'comments' => true ) );

		$expected = array_merge(
			array_fill_keys( array_keys( Options::get_defaults() ), false ),
			array(
				'comments' => true,
				'feeds'    => true,
			)
		);
		$this->assertSame( array( Options::OPTION_NAME, $expected ), $written );
		$this->assertTrue( $result['feeds'] );
	}
}
