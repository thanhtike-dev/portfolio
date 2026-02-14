<?php
/**
 * Theme menu registration service.
 *
 * @package th-theme
 */

namespace THTheme\Services;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use THTheme\Contracts\Hookable;

final class Menus implements Hookable {
	/**
	 * Register hooks for menu setup.
	 */
	public function register_hooks(): void {
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
	}

	/**
	 * Register theme menu locations.
	 */
	public function register_menus(): void {
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'th-theme' ),
			)
		);
	}
}
