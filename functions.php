<?php
/**
 * Theme bootstrap file.
 *
 * @package th-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

spl_autoload_register(
	static function ( $class ) {
		$prefix = 'THTheme\\';

		if ( 0 !== strpos( $class, $prefix ) ) {
			return;
		}

		$relative_class = substr( $class, strlen( $prefix ) );
		$relative_path  = str_replace( '\\', '/', $relative_class );
		$file           = get_template_directory() . '/inc/' . $relative_path . '.php';

		if ( is_readable( $file ) ) {
			require_once $file;
		}
	}
);

THTheme\Theme::boot();
