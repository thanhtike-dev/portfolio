<?php
/**
 * Hookable contract for theme services.
 *
 * @package th-theme
 */

namespace THTheme\Contracts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Hookable {
	/**
	 * Register WordPress hooks.
	 */
	public function register_hooks(): void;
}
