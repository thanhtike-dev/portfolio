<?php
/**
 * Main theme application class.
 *
 * @package th-theme
 */

namespace THTheme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use THTheme\Contracts\Hookable;
use THTheme\Services\Assets;
use THTheme\Services\Menus;
use THTheme\Services\Setup;

final class Theme {
	/**
	 * Singleton instance.
	 *
	 * @var Theme|null
	 */
	private static ?Theme $instance = null;

	/**
	 * Registered service objects.
	 *
	 * @var Hookable[]
	 */
	private array $services = array();

	/**
	 * Build the service container.
	 */
	private function __construct() {
		$this->services = array(
			new Setup(),
			new Menus(),
			new Assets(),
		);
	}

	/**
	 * Boot the theme once.
	 *
	 * @return Theme
	 */
	public static function boot(): Theme {
		if ( null === self::$instance ) {
			self::$instance = new self();
			self::$instance->register_services();
		}

		return self::$instance;
	}

	/**
	 * Register hooks for each service.
	 */
	private function register_services(): void {
		foreach ( $this->services as $service ) {
			$service->register_hooks();
		}
	}
}
