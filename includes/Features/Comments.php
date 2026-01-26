<?php
/**
 * Comments feature - disable comments completely.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Features;

use LightweightPlugins\Disable\Options;

/**
 * Handles disabling comments.
 */
final class Comments {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! Options::get( 'comments' ) ) {
			return;
		}

		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @return void
	 */
	private function init_hooks(): void {
		add_action( 'init', array( $this, 'remove_support' ) );
		add_action( 'admin_menu', array( $this, 'remove_menu' ), 999 );
		add_action( 'admin_init', array( $this, 'redirect_page' ) );
		add_action( 'admin_bar_menu', array( $this, 'remove_admin_bar' ), 999 );
		add_action( 'wp_dashboard_setup', array( $this, 'remove_dashboard' ) );

		add_filter( 'comments_open', '__return_false', 20 );
		add_filter( 'pings_open', '__return_false', 20 );
		add_filter( 'comments_array', '__return_empty_array', 10 );
		add_filter( 'get_comments_number', '__return_zero' );
	}

	/**
	 * Remove comment support from post types.
	 *
	 * @return void
	 */
	public function remove_support(): void {
		$post_types = get_post_types( array( 'public' => true ), 'names' );

		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	}

	/**
	 * Remove comments menu.
	 *
	 * @return void
	 */
	public function remove_menu(): void {
		remove_menu_page( 'edit-comments.php' );
	}

	/**
	 * Redirect comments page.
	 *
	 * @return void
	 */
	public function redirect_page(): void {
		global $pagenow;

		if ( 'edit-comments.php' === $pagenow ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
	}

	/**
	 * Remove comments from admin bar.
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar Admin bar instance.
	 * @return void
	 */
	public function remove_admin_bar( \WP_Admin_Bar $wp_admin_bar ): void {
		$wp_admin_bar->remove_node( 'comments' );
	}

	/**
	 * Remove comments dashboard widget.
	 *
	 * @return void
	 */
	public function remove_dashboard(): void {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}
}
