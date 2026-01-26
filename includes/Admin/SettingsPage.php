<?php
/**
 * Settings Page class.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Admin;

use LightweightPlugins\Disable\Options;

/**
 * Handles the settings page.
 */
final class SettingsPage {

	/**
	 * Page slug.
	 */
	public const SLUG = 'lw-disable';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	/**
	 * Add menu page.
	 *
	 * @return void
	 */
	public function add_menu(): void {
		ParentPage::maybe_register();

		add_submenu_page(
			ParentPage::SLUG,
			__( 'Disable', 'lw-disable' ),
			__( 'Disable', 'lw-disable' ),
			'manage_options',
			self::SLUG,
			array( $this, 'render' )
		);
	}

	/**
	 * Render settings page.
	 *
	 * @return void
	 */
	public function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$this->maybe_save();
		$options = Options::get_all();

		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'LW Disable', 'lw-disable' ); ?></h1>
			<p><?php esc_html_e( 'Disable WordPress features you don\'t need.', 'lw-disable' ); ?></p>

			<form method="post">
				<?php wp_nonce_field( 'lw_disable_save', 'lw_disable_nonce' ); ?>
				<table class="form-table">
					<tr>
						<th scope="row"><?php esc_html_e( 'Commands', 'lw-disable' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="lw_disable[commands]" value="1" <?php checked( $options['commands'] ); ?>>
								<?php esc_html_e( 'Disable admin command palette (Cmd/Ctrl+K)', 'lw-disable' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Comments', 'lw-disable' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="lw_disable[comments]" value="1" <?php checked( $options['comments'] ); ?>>
								<?php esc_html_e( 'Disable comments completely', 'lw-disable' ); ?>
							</label>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Save settings if posted.
	 *
	 * @return void
	 */
	private function maybe_save(): void {
		if ( ! isset( $_POST['lw_disable_nonce'] ) ) {
			return;
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST['lw_disable_nonce'] ) );

		if ( ! wp_verify_nonce( $nonce, 'lw_disable_save' ) ) {
			return;
		}

		$options = array(
			'commands' => ! empty( $_POST['lw_disable']['commands'] ),
			'comments' => ! empty( $_POST['lw_disable']['comments'] ),
		);

		Options::save( $options );

		echo '<div class="notice notice-success"><p>';
		esc_html_e( 'Settings saved.', 'lw-disable' );
		echo '</p></div>';
	}
}
