<?php
/**
 * Portfolio meta box service.
 *
 * @package th-theme
 */

namespace THTheme\Services;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use THTheme\Contracts\Hookable;

final class PortfolioMetaBox implements Hookable {
	/**
	 * Custom field key for live website URL.
	 */
	private const META_KEY = 'live_website_url';

	/**
	 * Register hooks.
	 */
	public function register_hooks(): void {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );
		add_action( 'save_post_portfolio', array( $this, 'save_meta' ) );
	}

	/**
	 * Register the "Live website" meta box.
	 */
	public function register_meta_box(): void {
		add_meta_box(
			'th-theme-live-website',
			__( 'Live Website', 'th-theme' ),
			array( $this, 'render_meta_box' ),
			'portfolio',
			'side',
			'default'
		);
	}

	/**
	 * Render the input field.
	 *
	 * @param \WP_Post $post Portfolio post object.
	 */
	public function render_meta_box( \WP_Post $post ): void {
		wp_nonce_field( 'th_theme_live_website_nonce_action', 'th_theme_live_website_nonce' );

		$value = get_post_meta( $post->ID, self::META_KEY, true );
		?>
		<p>
			<label for="th-theme-live-website-url"><?php esc_html_e( 'Project URL', 'th-theme' ); ?></label>
		</p>
		<p>
			<input
				type="url"
				id="th-theme-live-website-url"
				name="th_theme_live_website_url"
				value="<?php echo esc_attr( (string) $value ); ?>"
				placeholder="https://example.com"
				style="width:100%;"
			/>
		</p>
		<p style="font-size:12px;color:#666;">
			<?php esc_html_e( 'This URL powers the "Go to live website" button on the single portfolio page.', 'th-theme' ); ?>
		</p>
		<?php
	}

	/**
	 * Save the field value.
	 *
	 * @param int $post_id Post ID.
	 */
	public function save_meta( int $post_id ): void {
		if ( ! isset( $_POST['th_theme_live_website_nonce'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			return;
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST['th_theme_live_website_nonce'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing

		if ( ! wp_verify_nonce( $nonce, 'th_theme_live_website_nonce_action' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$raw_url = '';

		if ( isset( $_POST['th_theme_live_website_url'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$raw_url = sanitize_text_field( wp_unslash( $_POST['th_theme_live_website_url'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		}

		$url = esc_url_raw( trim( $raw_url ) );

		if ( '' === $url ) {
			delete_post_meta( $post_id, self::META_KEY );
			return;
		}

		update_post_meta( $post_id, self::META_KEY, $url );
	}
}
