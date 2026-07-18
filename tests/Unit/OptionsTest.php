<?php
/**
 * Characterization tests for Options.
 *
 * Pins down the current option-resolution behaviour (see .claude/rules/tests.md).
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Tests\Unit;

use Brain\Monkey\Functions;
use LightweightPlugins\Disable\Options;

/**
 * @covers \LightweightPlugins\Disable\Options
 */
final class OptionsTest extends MonkeyTestCase {

	protected function setUp(): void {
		parent::setUp();
		Options::clear_cache();

		Functions\when( 'wp_parse_args' )->alias(
			static fn( $args, $defaults = array() ) => array_merge( (array) $defaults, (array) $args )
		);
	}

	protected function tearDown(): void {
		Options::clear_cache();
		parent::tearDown();
	}

	public function test_defaults_are_all_disabled(): void {
		$defaults = Options::get_defaults();

		$this->assertNotEmpty( $defaults );
		$this->assertSame( array( false ), array_values( array_unique( $defaults ) ) );
	}

	public function test_get_returns_default_when_nothing_saved(): void {
		Functions\when( 'get_option' )->justReturn( array() );

		$this->assertFalse( Options::get( 'comments' ) );
	}

	public function test_get_returns_saved_value_over_default(): void {
		Functions\when( 'get_option' )->justReturn( array( 'comments' => true ) );

		$this->assertTrue( Options::get( 'comments' ) );
	}

	public function test_get_returns_null_for_an_unknown_key(): void {
		Functions\when( 'get_option' )->justReturn( array() );

		$this->assertNull( Options::get( 'not_a_real_option' ) );
	}

	public function test_get_all_merges_saved_over_defaults(): void {
		Functions\when( 'get_option' )->justReturn( array( 'xmlrpc' => true ) );

		$all = Options::get_all();

		$this->assertTrue( $all['xmlrpc'] );        // Saved override.
		$this->assertFalse( $all['comments'] );      // Untouched default.
		$this->assertArrayHasKey( 'feeds', $all );   // Default key present.
	}

	public function test_get_all_is_cached(): void {
		Functions\when( 'get_option' )->justReturn( array( 'emojis' => true ) );
		$first = Options::get_all();

		// A different backing value must NOT be seen until the cache is cleared.
		Functions\when( 'get_option' )->justReturn( array( 'emojis' => false ) );
		$this->assertSame( $first, Options::get_all() );

		Options::clear_cache();
		$this->assertFalse( Options::get_all()['emojis'] );
	}
}
