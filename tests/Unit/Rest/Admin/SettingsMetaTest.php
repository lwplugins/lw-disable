<?php
/**
 * SettingsMeta unit tests.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Tests\Unit\Rest\Admin;

use Brain\Monkey\Functions;
use LightweightPlugins\Disable\Options;
use LightweightPlugins\Disable\Rest\Admin\SettingsMeta;
use LightweightPlugins\Disable\Tests\Unit\MonkeyTestCase;

/**
 * @covers \LightweightPlugins\Disable\Rest\Admin\SettingsMeta
 */
final class SettingsMetaTest extends MonkeyTestCase {

	public function test_sections_become_an_ordered_list_with_descriptions(): void {
		$sections = array(
			'general' => array(
				'title'  => 'General',
				'icon'   => 'dashicons-admin-settings',
				'fields' => array(
					'comments' => 'Comments',
					'other'    => 'Other',
				),
			),
		);

		$result = SettingsMeta::sections( $sections, array( 'comments' => 'Disable comments completely' ) );

		$this->assertSame(
			array(
				array(
					'key'    => 'general',
					'title'  => 'General',
					'icon'   => 'dashicons-admin-settings',
					'fields' => array(
						array(
							'key'         => 'comments',
							'label'       => 'Comments',
							'description' => 'Disable comments completely',
						),
						array(
							'key'         => 'other',
							'label'       => 'Other',
							'description' => '',
						),
					),
				),
			),
			$result
		);
	}

	public function test_build_lists_every_option_exactly_once(): void {
		Functions\when( '__' )->returnArg();

		$keys = array();
		foreach ( SettingsMeta::build()['sections'] as $section ) {
			foreach ( $section['fields'] as $field ) {
				$keys[] = $field['key'];
			}
		}

		$this->assertSame( array_keys( Options::get_defaults() ), $keys );
	}
}
