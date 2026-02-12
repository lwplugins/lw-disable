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
		add_action( 'admin_init', array( $this, 'maybe_save' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
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
	 * Enqueue admin assets.
	 *
	 * @param string $hook Current admin page.
	 * @return void
	 */
	public function enqueue_assets( string $hook ): void {
		$valid_hooks = array(
			'toplevel_page_' . ParentPage::SLUG,
			ParentPage::SLUG . '_page_' . self::SLUG,
		);

		if ( ! in_array( $hook, $valid_hooks, true ) ) {
			return;
		}

		wp_enqueue_style(
			'lw-disable-admin',
			LW_DISABLE_URL . 'assets/css/admin.css',
			array(),
			LW_DISABLE_VERSION
		);

		wp_enqueue_script(
			'lw-disable-admin',
			LW_DISABLE_URL . 'assets/js/admin.js',
			array(),
			LW_DISABLE_VERSION,
			true
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

		$options      = Options::get_all();
		$sections     = FieldsData::get_sections();
		$descriptions = FieldsData::get_descriptions();

		?>
		<div class="wrap">
			<h1>
				<img src="<?php echo esc_url( LW_DISABLE_URL . 'assets/img/title-icon.svg' ); ?>" alt="" class="lw-title-icon" />
				<?php esc_html_e( 'Lightweight Disable', 'lw-disable' ); ?>
				<span style="font-size: 13px; font-weight: 400; color: #888;">(<?php echo esc_html( LW_DISABLE_VERSION ); ?>)</span>
			</h1>

			<?php if ( isset( $_GET['saved'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
				<div class="notice notice-success is-dismissible">
					<p><?php esc_html_e( 'Settings saved.', 'lw-disable' ); ?></p>
				</div>
			<?php endif; ?>

			<form method="post">
				<?php wp_nonce_field( 'lw_disable_save', 'lw_disable_nonce' ); ?>
				<input type="hidden" name="lw_disable_active_tab" value="" />

				<div class="lw-disable-settings">
					<?php $this->render_tabs_nav( $sections ); ?>

					<div class="lw-disable-tab-content">
						<?php $this->render_tabs_content( $sections, $options, $descriptions ); ?>
						<?php submit_button(); ?>
					</div>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Render tab navigation.
	 *
	 * @param array $sections Sections data.
	 * @return void
	 */
	private function render_tabs_nav( array $sections ): void {
		$first = true;
		?>
		<ul class="lw-disable-tabs">
			<?php foreach ( $sections as $slug => $section ) : ?>
				<li>
					<a href="#<?php echo esc_attr( $slug ); ?>" <?php echo $first ? 'class="active"' : ''; ?>>
						<span class="dashicons <?php echo esc_attr( $section['icon'] ); ?>"></span>
						<?php echo esc_html( $section['title'] ); ?>
					</a>
				</li>
				<?php $first = false; ?>
			<?php endforeach; ?>
		</ul>
		<?php
	}

	/**
	 * Render tab content panels.
	 *
	 * @param array $sections     Sections data.
	 * @param array $options      Current options.
	 * @param array $descriptions Field descriptions.
	 * @return void
	 */
	private function render_tabs_content( array $sections, array $options, array $descriptions ): void {
		$first = true;

		foreach ( $sections as $slug => $section ) {
			$active = $first ? ' active' : '';
			printf( '<div id="tab-%s" class="lw-disable-tab-panel%s">', esc_attr( $slug ), esc_attr( $active ) );
			printf( '<h2>%s</h2>', esc_html( $section['title'] ) );
			echo '<table class="form-table">';

			foreach ( $section['fields'] as $key => $label ) {
				printf(
					'<tr><th scope="row">%s</th><td><label><input type="checkbox" name="lw_disable[%s]" value="1" %s> %s</label></td></tr>',
					esc_html( $label ),
					esc_attr( $key ),
					checked( $options[ $key ] ?? false, true, false ),
					esc_html( $descriptions[ $key ] ?? '' )
				);
			}

			echo '</table></div>';
			$first = false;
		}
	}

	/**
	 * Save settings if posted.
	 *
	 * @return void
	 */
	public function maybe_save(): void {
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

		$tab  = isset( $_POST['lw_disable_active_tab'] ) ? sanitize_text_field( wp_unslash( $_POST['lw_disable_active_tab'] ) ) : '';
		$hash = $tab ? '#' . $tab : '';

		wp_safe_redirect( admin_url( 'admin.php?page=' . self::SLUG . '&saved=1' . $hash ) );
		exit;
	}
}
