<?php
/**
 * Settings Page class.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Admin;

use LightweightPlugins\Disable\Rest\Admin\Routes;

/**
 * The settings screen: a mount point for the React admin (build/index),
 * which reads and writes through the lw-disable/v1 REST routes.
 */
final class SettingsPage {

	/**
	 * Page slug.
	 */
	public const SLUG = 'lw-disable';

	/**
	 * Script and style handle.
	 */
	private const HANDLE = 'lw-disable-admin-app';

	/**
	 * Documentation URL.
	 */
	private const DOCS_URL = 'https://lwplugins.com/docs/lw-disable/';

	/**
	 * Hook suffix returned by add_submenu_page().
	 *
	 * @var string
	 */
	private string $hook_suffix = '';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_filter( 'admin_body_class', array( $this, 'body_class' ) );
	}

	/**
	 * Add menu page.
	 *
	 * @return void
	 */
	public function add_menu(): void {
		ParentPage::maybe_register();

		$hook = add_submenu_page(
			ParentPage::SLUG,
			__( 'Disable', 'lw-disable' ),
			__( 'Disable', 'lw-disable' ),
			'manage_options',
			self::SLUG,
			array( $this, 'render' )
		);

		$this->hook_suffix = is_string( $hook ) ? $hook : '';
	}

	/**
	 * Enqueue the React app on the settings screen.
	 *
	 * @param string $hook Current admin page.
	 * @return void
	 */
	public function enqueue_assets( string $hook ): void {
		if ( '' === $this->hook_suffix || $hook !== $this->hook_suffix ) {
			return;
		}

		if ( ! BuildAssets::enqueue( 'index', self::HANDLE ) ) {
			return;
		}

		wp_add_inline_script(
			self::HANDLE,
			'window.lwDisable = ' . wp_json_encode(
				array(
					'version'   => LW_DISABLE_VERSION,
					'namespace' => Routes::NAMESPACE,
					'docsUrl'   => self::DOCS_URL,
				)
			) . ';',
			'before'
		);
	}

	/**
	 * Mark the settings screen body for the app's styles.
	 *
	 * @param string $classes Space-separated body classes.
	 * @return string
	 */
	public function body_class( string $classes ): string {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

		if ( '' === $this->hook_suffix || ! $screen || $screen->id !== $this->hook_suffix ) {
			return $classes;
		}

		return $classes . ' lw-disable-screen';
	}

	/**
	 * Render the mount point (or a notice when the build is missing).
	 *
	 * The notice carries `lw-notice` so NoticeManager does not hide it.
	 *
	 * @return void
	 */
	public function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! BuildAssets::exists( 'index' ) ) {
			printf(
				'<div class="wrap"><h1>%s</h1><div class="notice notice-error lw-notice"><p>%s</p></div></div>',
				esc_html__( 'LW Disable', 'lw-disable' ),
				esc_html__( 'The settings screen files are missing. Re-install the plugin from a release ZIP, or run "npm install && npm run build" in the plugin directory.', 'lw-disable' )
			);
			return;
		}

		echo '<div id="lw-disable-root" class="lw-disable-root"></div>';
	}
}
