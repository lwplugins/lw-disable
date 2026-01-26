<?php
/**
 * Settings fields data.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Admin\Settings;

/**
 * Contains settings field definitions.
 */
final class FieldsData {

	/**
	 * Get sections configuration.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function get_sections(): array {
		return array(
			'general'      => array(
				'title'  => __( 'General', 'lw-disable' ),
				'fields' => array(
					'commands' => __( 'Commands', 'lw-disable' ),
					'comments' => __( 'Comments', 'lw-disable' ),
				),
			),
			'performance'  => array(
				'title'  => __( 'Performance', 'lw-disable' ),
				'fields' => array(
					'emojis'        => __( 'Emojis', 'lw-disable' ),
					'embeds'        => __( 'Embeds', 'lw-disable' ),
					'heartbeat'     => __( 'Heartbeat', 'lw-disable' ),
					'block_library' => __( 'Block Library', 'lw-disable' ),
				),
			),
			'security'     => array(
				'title'  => __( 'Security', 'lw-disable' ),
				'fields' => array(
					'xmlrpc'                => __( 'XML-RPC', 'lw-disable' ),
					'rest_api'              => __( 'REST API', 'lw-disable' ),
					'application_passwords' => __( 'App Passwords', 'lw-disable' ),
					'generator'             => __( 'Generator', 'lw-disable' ),
				),
			),
			'head_cleanup' => array(
				'title'  => __( 'Head Cleanup', 'lw-disable' ),
				'fields' => array(
					'shortlink'       => __( 'Shortlink', 'lw-disable' ),
					'rsd_link'        => __( 'RSD Link', 'lw-disable' ),
					'wlw_manifest'    => __( 'WLW Manifest', 'lw-disable' ),
					'version_strings' => __( 'Version Strings', 'lw-disable' ),
					'adjacent_posts'  => __( 'Adjacent Posts', 'lw-disable' ),
				),
			),
			'content'      => array(
				'title'  => __( 'Content', 'lw-disable' ),
				'fields' => array(
					'feeds' => __( 'RSS Feeds', 'lw-disable' ),
				),
			),
		);
	}

	/**
	 * Get field descriptions.
	 *
	 * @return array<string, string>
	 */
	public static function get_descriptions(): array {
		return array(
			'commands'              => __( 'Disable admin command palette (Cmd/Ctrl+K)', 'lw-disable' ),
			'comments'              => __( 'Disable comments completely', 'lw-disable' ),
			'emojis'                => __( 'Disable WordPress emoji scripts and styles', 'lw-disable' ),
			'embeds'                => __( 'Disable oEmbed discovery and scripts', 'lw-disable' ),
			'heartbeat'             => __( 'Disable WordPress heartbeat API', 'lw-disable' ),
			'block_library'         => __( 'Disable Gutenberg block CSS on frontend', 'lw-disable' ),
			'xmlrpc'                => __( 'Disable XML-RPC protocol', 'lw-disable' ),
			'rest_api'              => __( 'Restrict REST API to logged-in users', 'lw-disable' ),
			'application_passwords' => __( 'Disable application passwords', 'lw-disable' ),
			'generator'             => __( 'Remove WordPress version meta tag', 'lw-disable' ),
			'shortlink'             => __( 'Remove shortlink from head', 'lw-disable' ),
			'rsd_link'              => __( 'Remove Really Simple Discovery link', 'lw-disable' ),
			'wlw_manifest'          => __( 'Remove Windows Live Writer link', 'lw-disable' ),
			'version_strings'       => __( 'Remove ?ver= query strings from assets', 'lw-disable' ),
			'adjacent_posts'        => __( 'Remove prev/next post links from head', 'lw-disable' ),
			'feeds'                 => __( 'Disable RSS feeds completely', 'lw-disable' ),
		);
	}
}
