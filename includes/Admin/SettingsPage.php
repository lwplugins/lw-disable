<?php
/**
 * Settings Page class.
 *
 * @package LightweightPlugins\Disable
 */

declare(strict_types=1);

namespace LightweightPlugins\Disable\Admin;

use LightweightPlugins\Disable\Admin\Settings\FieldsData;
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
		$options      = Options::get_all();
		$sections     = FieldsData::get_sections();
		$descriptions = FieldsData::get_descriptions();

		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'LW Disable', 'lw-disable' ); ?></h1>
			<p><?php esc_html_e( 'Disable WordPress features you don\'t need.', 'lw-disable' ); ?></p>

			<form method="post">
				<?php wp_nonce_field( 'lw_disable_save', 'lw_disable_nonce' ); ?>
				<?php foreach ( $sections as $section ) : ?>
					<h2><?php echo esc_html( $section['title'] ); ?></h2>
					<table class="form-table">
						<?php foreach ( $section['fields'] as $key => $label ) : ?>
							<tr>
								<th scope="row"><?php echo esc_html( $label ); ?></th>
								<td>
									<label>
										<input type="checkbox" name="lw_disable[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( $options[ $key ] ?? false ); ?>>
										<?php echo esc_html( $descriptions[ $key ] ?? '' ); ?>
									</label>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php endforeach; ?>
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

		$defaults = Options::get_defaults();
		$options  = array();

		foreach ( array_keys( $defaults ) as $key ) {
			$options[ $key ] = ! empty( $_POST['lw_disable'][ $key ] );
		}

		Options::save( $options );

		echo '<div class="notice notice-success"><p>';
		esc_html_e( 'Settings saved.', 'lw-disable' );
		echo '</p></div>';
	}
}
