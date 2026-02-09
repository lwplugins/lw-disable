<?php
/**
 * Plugin Name:       Lightweight Disable
 * Plugin URI:        https://github.com/lwplugins/lw-disable
 * Description:       Disable WordPress features: comments, emojis, embeds, and more.
 * Version:           1.2.8
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

define( 'LW_DISABLE_VERSION', '1.2.8' );
define( 'LW_DISABLE_FILE', __FILE__ );
define( 'LW_DISABLE_PATH', plugin_dir_path( __FILE__ ) );
define( 'LW_DISABLE_URL', plugin_dir_url( __FILE__ ) );

// Autoloader.
if ( file_exists( LW_DISABLE_PATH . 'vendor/autoload.php' ) ) {
	require_once LW_DISABLE_PATH . 'vendor/autoload.php';
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
