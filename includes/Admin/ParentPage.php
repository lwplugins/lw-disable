<?php
/**
 * LW Plugins Parent Page.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Admin;

/**
 * Handles the LW Plugins parent menu page.
 */
final class ParentPage {

	/**
	 * Menu slug.
	 */
	public const SLUG = 'lw-plugins';

	/**
	 * Get plugins registry.
	 *
	 * @return array<string, array<string, string>>
	 */
	public static function get_registry(): array {
		return array(
			'lw-seo'          => array(
				'name'        => 'LW SEO',
				'description' => __( 'Essential SEO features without the bloat.', 'lw-disable' ),
				'icon'        => 'dashicons-search',
				'icon_color'  => '#2271b1',
				'constant'    => 'LW_SEO_VERSION',
				'settings'    => 'lw-seo',
				'github'      => 'https://github.com/lwplugins/lw-seo',
			),
			'lw-disable'      => array(
				'name'        => 'LW Disable',
				'description' => __( 'Disable WordPress features like comments and admin commands.', 'lw-disable' ),
				'icon'        => 'dashicons-dismiss',
				'icon_color'  => '#d63638',
				'constant'    => 'LW_DISABLE_VERSION',
				'settings'    => 'lw-disable',
				'github'      => 'https://github.com/lwplugins/lw-disable',
			),
			'lw-site-manager' => array(
				'name'        => 'LW Site Manager',
				'description' => __( 'Site maintenance via AI/REST using Abilities API.', 'lw-disable' ),
				'icon'        => 'dashicons-admin-tools',
				'icon_color'  => '#135e96',
				'constant'    => 'LW_SITE_MANAGER_VERSION',
				'settings'    => 'lw-site-manager',
				'github'      => 'https://github.com/lwplugins/lw-site-manager',
			),
		);
	}

	/**
	 * Register parent menu if not exists.
	 *
	 * @return void
	 */
	public static function maybe_register(): void {
		global $admin_page_hooks;

		if ( ! empty( $admin_page_hooks[ self::SLUG ] ) ) {
			return;
		}

		add_menu_page(
			'LW Plugins',
			'LW Plugins',
			'manage_options',
			self::SLUG,
			array( self::class, 'render' ),
			'dashicons-superhero-alt',
			80
		);
	}

	/**
	 * Render parent page.
	 *
	 * @return void
	 */
	public static function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		?>
		<div class="wrap">
			<h1>LW Plugins</h1>
			<p><?php esc_html_e( 'Lightweight plugins for WordPress.', 'lw-disable' ); ?></p>

			<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
				<?php
				foreach ( self::get_registry() as $plugin ) {
					self::render_card( $plugin );
				}
				?>
			</div>

			<p style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ccd0d4;">
				<a href="https://github.com/lwplugins" target="_blank">GitHub</a> |
				<a href="https://lwplugins.com" target="_blank">Website</a>
			</p>
		</div>
		<?php
	}

	/**
	 * Render plugin card.
	 *
	 * @param array<string, string> $plugin Plugin data.
	 * @return void
	 */
	private static function render_card( array $plugin ): void {
		$is_active = defined( $plugin['constant'] );

		?>
		<div style="background: #fff; border: 1px solid #ccd0d4; border-radius: 4px; padding: 20px; width: 300px;">
			<h2 style="margin-top: 0;">
				<span class="dashicons <?php echo esc_attr( $plugin['icon'] ); ?>" style="color: <?php echo esc_attr( $plugin['icon_color'] ); ?>;"></span>
				<?php echo esc_html( $plugin['name'] ); ?>
				<?php if ( $is_active ) : ?>
					<span style="background: #00a32a; color: #fff; font-size: 11px; padding: 2px 6px; border-radius: 3px; margin-left: 8px;">Active</span>
				<?php endif; ?>
			</h2>
			<p><?php echo esc_html( $plugin['description'] ); ?></p>
			<p>
				<?php if ( $is_active ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . $plugin['settings'] ) ); ?>" class="button button-primary">Settings</a>
				<?php else : ?>
					<a href="<?php echo esc_url( $plugin['github'] ); ?>" class="button" target="_blank">Get Plugin</a>
				<?php endif; ?>
			</p>
		</div>
		<?php
	}
}
