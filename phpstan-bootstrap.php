<?php
/**
 * PHPStan-only bootstrap.
 *
 * The main plugin file defines these constants at runtime with dynamic
 * values (`plugin_dir_path()` / `plugin_dir_url()`), which static analysis
 * cannot resolve. Declaring them here — with representative string values —
 * lets PHPStan type them as strings wherever they are used, without running
 * any plugin code. Loaded via `bootstrapFiles`.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

define( 'LW_DISABLE_VERSION', '1.3.7' );
define( 'LW_DISABLE_FILE', __DIR__ . '/lw-disable.php' );
define( 'LW_DISABLE_PATH', __DIR__ . '/' );
define( 'LW_DISABLE_URL', 'https://example.test/wp-content/plugins/lw-disable/' );
