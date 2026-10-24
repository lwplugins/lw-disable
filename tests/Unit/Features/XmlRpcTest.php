<?php
/**
 * Tests for the XML-RPC feature.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Tests\Unit\Features;

use Brain\Monkey\Functions;
use LightweightPlugins\Disable\Features\XmlRpc;
use LightweightPlugins\Disable\Options;
use LightweightPlugins\Disable\Tests\Unit\MonkeyTestCase;

/**
 * @covers \LightweightPlugins\Disable\Features\XmlRpc
 */
final class XmlRpcTest extends MonkeyTestCase {

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

	public function test_enabled_option_removes_all_xmlrpc_methods(): void {
		Functions\when( 'get_option' )->justReturn( array( 'xmlrpc' => true ) );

		$feature  = new XmlRpc();
		$priority = has_filter( 'xmlrpc_methods', array( $feature, 'remove_methods' ) );

		$this->assertSame( PHP_INT_MAX, $priority );
		$this->assertNotFalse( has_filter( 'xmlrpc_enabled', '__return_false' ) );

		$methods = array(
			'pingback.ping'                    => 'this:pingback_ping',
			'pingback.extensions.getPingbacks' => 'this:pingback_extensions_getPingbacks',
			'system.multicall'                 => 'this:multiCall',
			'wp.getUsersBlogs'                 => 'this:wp_getUsersBlogs',
		);

		$filtered = $feature->remove_methods( $methods );

		$this->assertSame( array(), $filtered );
	}

	public function test_disabled_option_registers_no_filters(): void {
		Functions\when( 'get_option' )->justReturn( array( 'xmlrpc' => false ) );

		$feature = new XmlRpc();

		$this->assertFalse( has_filter( 'xmlrpc_methods', array( $feature, 'remove_methods' ) ) );
		$this->assertFalse( has_filter( 'xmlrpc_methods' ) );
		$this->assertFalse( has_filter( 'xmlrpc_enabled', '__return_false' ) );
	}
}
