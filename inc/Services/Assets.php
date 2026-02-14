<?php
/**
 * Theme asset enqueue service.
 *
 * @package th-theme
 */

namespace THTheme\Services;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use THTheme\Contracts\Hookable;

final class Assets implements Hookable {
	/**
	 * Register asset hooks.
	 */
	public function register_hooks(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Enqueue front-end styles and scripts.
	 */
	public function enqueue(): void {
		$theme_dir      = get_template_directory();
		$theme_uri      = get_template_directory_uri();
		$styles_version = $this->get_asset_timestamp( $theme_dir . '/styles.css' );
		$script_version = $this->get_asset_timestamp( $theme_dir . '/script.js' );

		wp_enqueue_style(
			'th-theme-google-fonts',
			'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Space+Grotesk:wght@400;500;600;700&display=swap',
			array(),
			null
		);

		wp_enqueue_style(
			'th-theme-main',
			$theme_uri . '/styles.css',
			array( 'th-theme-google-fonts' ),
			$styles_version
		);

		wp_enqueue_script(
			'th-theme-gsap',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
			array(),
			'3.12.5',
			true
		);

		wp_enqueue_script(
			'th-theme-main',
			$theme_uri . '/script.js',
			array( 'th-theme-gsap' ),
			$script_version,
			true
		);
	}

	/**
	 * Resolve file modification timestamp for cache busting.
	 *
	 * @param string $file_path Absolute file path.
	 * @return string
	 */
	private function get_asset_timestamp( string $file_path ): string {
		if ( file_exists( $file_path ) ) {
			$modified = filemtime( $file_path );

			if ( false !== $modified ) {
				return (string) $modified;
			}
		}

		return '1.0.0';
	}
}
