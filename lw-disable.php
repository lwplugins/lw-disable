<?php
/**
 * Plugin Name:       LW Disable
 * Plugin URI:        https://github.com/lwplugins/lw-disable
 * Description:       Lightweight disable — turn off comments, emojis, embeds, and more.
 * Version:           1.3.5
 * Requires at least: 6.0
 * Requires PHP:      8.1
 * Author:            LW Plugins
 * Author URI:        https://lwplugins.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       lw-disable
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LW_DISABLE_VERSION', '1.3.5' );
define( 'LW_DISABLE_FILE', __FILE__ );
define( 'LW_DISABLE_PATH', plugin_dir_path( __FILE__ ) );
define( 'LW_DISABLE_URL', plugin_dir_url( __FILE__ ) );

// Autoloader: local vendor (standalone/ZIP) or root Composer (dependency install).
if ( file_exists( LW_DISABLE_PATH . 'vendor/autoload.php' ) ) {
	require_once LW_DISABLE_PATH . 'vendor/autoload.php';
} elseif ( ! class_exists( Plugin::class ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			printf(
				'<div class="notice notice-error"><p><strong>LW Disable:</strong> %s</p></div>',
				esc_html__( 'Autoloader not found. Please run "composer install" in the plugin directory, or re-install the plugin from a release ZIP.', 'lw-disable' )
			);
		}
	);
	return;
}

/**
 * Initialize plugin.
 *
 * @return Plugin
 */
function lw_disable(): Plugin {
	static $instance = null;

	if ( null === $instance ) {
		$instance = new Plugin();
	}

	return $instance;
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\\lw_disable' );
