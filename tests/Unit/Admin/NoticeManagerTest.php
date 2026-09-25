<?php
/**
 * NoticeManager unit tests.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Tests\Unit\Admin;

use Brain\Monkey\Functions;
use LightweightPlugins\Disable\Admin\NoticeManager;
use LightweightPlugins\Disable\Tests\Unit\MonkeyTestCase;

final class NoticeManagerTest extends MonkeyTestCase {

	protected function tearDown(): void {
		unset( $GLOBALS['plugin_page'], $GLOBALS['wp_filter'] );
		parent::tearDown();
	}

	/**
	 * @return array<string, array{0: mixed, 1: bool}>
	 */
	public static function callback_provider(): array {
		return array(
			'LW static method string' => array( 'LightweightPlugins\\Disable\\Admin\\AdminNotice::render', true ),
			'LW class array'          => array( array( 'LightweightPlugins\\SEO\\Admin\\NoticeManager', 'open_wrap' ), true ),
			'LW object array'         => array( array( new NoticeManagerTestOwn(), 'render' ), true ),
			'LW closure'              => array( static function (): void {}, true ),
			'core function'           => array( 'wp_admin_notice', false ),
			'theme class array'       => array( array( 'TGM_Plugin_Activation', 'notices' ), false ),
			'theme object array'      => array( array( new \ArrayObject(), 'count' ), false ),
			'global closure'          => array( eval( 'return static function (): void {};' ), false ), // phpcs:ignore Squiz.PHP.Eval.Discouraged -- a closure declared outside any namespace.
			'look-alike namespace'    => array( 'LightweightPluginsFake\\Notice::render', false ),
		);
	}

	/**
	 * @dataProvider callback_provider
	 *
	 * @param mixed $callback Hook callback.
	 * @param bool  $expected Whether it is an LW callback.
	 */
	public function test_tells_lw_callbacks_from_the_rest( $callback, bool $expected ): void {
		$this->assertSame( $expected, NoticeManager::is_own( $callback ) );
	}

	public function test_removes_only_foreign_callbacks_on_lw_pages(): void {
		$this->on_lw_page();
		$foreign             = array( 'TGM_Plugin_Activation', 'notices' );
		$GLOBALS['wp_filter'] = array(
			'admin_notices'     => (object) array(
				'callbacks' => array(
					10 => array(
						'a' => array( 'function' => $foreign ),
						'b' => array( 'function' => 'LightweightPlugins\\Disable\\Admin\\AdminNotice::render' ),
					),
				),
			),
			'all_admin_notices' => (object) array( 'callbacks' => array( 5 => array( 'c' => array( 'function' => 'brooklyn_purchase_notice' ) ) ) ),
		);

		Functions\expect( 'remove_action' )->once()->with( 'admin_notices', $foreign, 10 );
		Functions\expect( 'remove_action' )->once()->with( 'all_admin_notices', 'brooklyn_purchase_notice', 5 );

		NoticeManager::isolate();
	}

	public function test_leaves_other_admin_pages_alone(): void {
		$GLOBALS['plugin_page'] = 'woocommerce';
		Functions\when( 'get_admin_page_parent' )->justReturn( 'woocommerce' );
		$GLOBALS['wp_filter'] = array( 'admin_notices' => (object) array( 'callbacks' => array( 10 => array( 'a' => array( 'function' => 'brooklyn_purchase_notice' ) ) ) ) );

		Functions\expect( 'remove_action' )->never();

		NoticeManager::isolate();
	}

	public function test_recognises_the_lw_plugins_overview_page(): void {
		$GLOBALS['plugin_page'] = 'lw-plugins';
		Functions\when( 'get_admin_page_parent' )->justReturn( '' );

		$this->assertTrue( NoticeManager::is_lw_page() );
	}

	public function test_adds_the_body_class_once(): void {
		$this->on_lw_page();

		$this->assertSame( 'a lw-plugins-admin-page', NoticeManager::body_class( NoticeManager::body_class( 'a' ) ) );
	}

	private function on_lw_page(): void {
		$GLOBALS['plugin_page'] = 'lw-disable';
		Functions\when( 'get_admin_page_parent' )->justReturn( 'lw-plugins' );
	}
}

/**
 * An object whose class lives in the LW namespace.
 */
final class NoticeManagerTestOwn {

	public function render(): void {}
}
