<?php
/**
 * Theme setup service.
 *
 * @package th-theme
 */

namespace THTheme\Services;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use THTheme\Contracts\Hookable;

final class Setup implements Hookable {
	/**
	 * Register setup hooks.
	 */
	public function register_hooks(): void {
		add_action( 'after_setup_theme', array( $this, 'configure_theme' ) );
	}

	/**
	 * Configure default theme support.
	 */
	public function configure_theme(): void {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
	}
}
