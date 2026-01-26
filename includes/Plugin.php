<?php
/**
 * Main Plugin class.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable;

use LightweightPlugins\Disable\Admin\SettingsPage;
use LightweightPlugins\Disable\Features\Commands;
use LightweightPlugins\Disable\Features\Comments;

/**
 * Main plugin class.
 */
final class Plugin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init_hooks();
		$this->init_features();
		$this->init_admin();
	}

	/**
	 * Initialize hooks.
	 *
	 * @return void
	 */
	private function init_hooks(): void {
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_filter(
			'plugin_action_links_' . plugin_basename( LW_DISABLE_FILE ),
			array( $this, 'add_settings_link' )
		);
	}

	/**
	 * Initialize features.
	 *
	 * @return void
	 */
	private function init_features(): void {
		new Commands();
		new Comments();
	}

	/**
	 * Initialize admin.
	 *
	 * @return void
	 */
	private function init_admin(): void {
		if ( is_admin() ) {
			new SettingsPage();
		}
	}

	/**
	 * Load textdomain.
	 *
	 * @return void
	 */
	public function load_textdomain(): void {
		load_plugin_textdomain(
			'lw-disable',
			false,
			dirname( plugin_basename( LW_DISABLE_FILE ) ) . '/languages'
		);
	}

	/**
	 * Add settings link.
	 *
	 * @param array<string> $links Plugin links.
	 * @return array<string>
	 */
	public function add_settings_link( array $links ): array {
		$url  = admin_url( 'admin.php?page=' . SettingsPage::SLUG );
		$link = '<a href="' . esc_url( $url ) . '">' . __( 'Settings', 'lw-disable' ) . '</a>';
		array_unshift( $links, $link );
		return $links;
	}
}
