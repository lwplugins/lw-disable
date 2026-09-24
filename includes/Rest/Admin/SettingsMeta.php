<?php
/**
 * Read-only context for the settings screen.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Rest\Admin;

use LightweightPlugins\Disable\Admin\Settings\FieldsData;

/**
 * Builds the `meta` block of the settings response: the translated sections
 * and fields, in FieldsData order.
 */
final class SettingsMeta {

	/**
	 * Build the meta block.
	 *
	 * @return array{sections: array<int, array<string, mixed>>}
	 */
	public static function build(): array {
		return array(
			'sections' => self::sections( FieldsData::get_sections(), FieldsData::get_descriptions() ),
		);
	}

	/**
	 * Sections as a list: key, title, icon (dashicon class) and fields.
	 *
	 * @param array<string, array<string, mixed>> $sections     Sections keyed by slug.
	 * @param array<string, string>               $descriptions Field descriptions keyed by option.
	 * @return array<int, array{key: string, title: string, icon: string, fields: array<int, array{key: string, label: string, description: string}>}>
	 */
	public static function sections( array $sections, array $descriptions ): array {
		$list = array();

		foreach ( $sections as $slug => $section ) {
			$fields = array();

			foreach ( (array) ( $section['fields'] ?? array() ) as $key => $label ) {
				$fields[] = array(
					'key'         => (string) $key,
					'label'       => (string) $label,
					'description' => $descriptions[ $key ] ?? '',
				);
			}

			$list[] = array(
				'key'    => (string) $slug,
				'title'  => (string) ( $section['title'] ?? '' ),
				'icon'   => (string) ( $section['icon'] ?? '' ),
				'fields' => $fields,
			);
		}

		return $list;
	}
}
