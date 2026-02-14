<?php
/**
 * Portfolio custom post type service.
 *
 * @package th-theme
 */

namespace THTheme\Services;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use THTheme\Contracts\Hookable;

final class Portfolios implements Hookable {
	/**
	 * Register hooks.
	 */
	public function register_hooks(): void {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
	}

	/**
	 * Register portfolio post type.
	 */
	public function register_post_type(): void {
		register_post_type(
			'portfolio',
			array(
				'labels'       => array(
					'name'               => __( 'Portfolios', 'th-theme' ),
					'singular_name'      => __( 'Portfolio', 'th-theme' ),
					'add_new_item'       => __( 'Add New Portfolio', 'th-theme' ),
					'edit_item'          => __( 'Edit Portfolio', 'th-theme' ),
					'new_item'           => __( 'New Portfolio', 'th-theme' ),
					'view_item'          => __( 'View Portfolio', 'th-theme' ),
					'search_items'       => __( 'Search Portfolios', 'th-theme' ),
					'not_found'          => __( 'No portfolios found.', 'th-theme' ),
					'not_found_in_trash' => __( 'No portfolios found in Trash.', 'th-theme' ),
					'menu_name'          => __( 'Portfolios', 'th-theme' ),
				),
				'public'       => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-portfolio',
				'has_archive'  => true,
				'rewrite'      => array(
					'slug'       => 'portfolios',
					'with_front' => false,
				),
				'supports'     => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
					'revisions',
				),
				'taxonomies'   => array(
					'post_tag',
				),
			)
		);
	}

	/**
	 * Register taxonomy for portfolio labels.
	 */
	public function register_taxonomy(): void {
		register_taxonomy(
			'portfolio_type',
			array( 'portfolio' ),
			array(
				'labels'       => array(
					'name'          => __( 'Portfolio Types', 'th-theme' ),
					'singular_name' => __( 'Portfolio Type', 'th-theme' ),
					'menu_name'     => __( 'Portfolio Types', 'th-theme' ),
				),
				'public'       => true,
				'show_in_rest' => true,
				'hierarchical' => false,
				'rewrite'      => array(
					'slug'       => 'portfolio-type',
					'with_front' => false,
				),
			)
		);
	}
}
