<?php
/**
 * Header template.
 *
 * @package th-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$site_name = get_bloginfo( 'name' );
if ( '' === $site_name ) {
	$site_name = 'Than Htike';
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>
		<div class="noise" aria-hidden="true"></div>
		<header class="site-header">
			<div class="brand"><?php echo esc_html( $site_name ); ?></div>
			<nav class="nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'th-theme' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'nav-list',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					?>
					<ul class="nav-list">
						<li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>">About</a></li>
						<li><a href="<?php echo esc_url( home_url( '/#work' ) ); ?>">Work</a></li>
						<li><a href="<?php echo esc_url( home_url( '/#skills' ) ); ?>">Skills</a></li>
						<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Contact</a></li>
					</ul>
					<?php
				}
				?>
			</nav>
			<div class="header-actions">
				<button class="theme-toggle" type="button" aria-label="Toggle color theme">
					<span class="toggle-track">
						<span class="toggle-icon sun">☀</span>
						<span class="toggle-icon moon">🌙</span>
						<span class="toggle-knob"></span>
					</span>
				</button>
				<a class="cta" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Let's build</a>
			</div>
		</header>
