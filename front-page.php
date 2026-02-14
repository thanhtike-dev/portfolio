<?php
/**
 * Front page template.
 *
 * @package th-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portfolio_query = new \WP_Query(
	array(
		'post_type'           => 'portfolio',
		'post_status'         => 'publish',
		'posts_per_page'      => 5,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$portfolio_items       = $portfolio_query->posts;
$featured_portfolio    = array_shift( $portfolio_items );
$portfolio_archive_url = get_post_type_archive_link( 'portfolio' );
$media_fallbacks       = array(
	'project-media--featured',
	'project-media--zenpoint',
	'project-media--saint',
	'project-media--studio',
	'project-media--estate',
);

get_header();
?>
<main>
	<section class="hero" id="top">
		<div class="sec-wrap">
			<div class="hero-inner">
				<div class="hero-copy">
					<p class="hero-availability"><span class="dot"></span>Available on Upwork &bull; WordPress custom themes</p>
					<h1>
						Hi, I'm <span>Than Htike</span><br />
						Building Fast, High-Performance WordPress Themes
					</h1>
					<p class="lede">
						Fast, clean corporate websites for Japanese and global clients&mdash;built with custom PHP templates, lightweight front-end, and performance-first setup.
					</p>
					<div class="hero-signals">
						<span>Custom themes (no bloat)</span>
						<span>Performance + Core Web Vitals</span>
						<span>SEO-friendly builds</span>
						<span>Japanese/English communication</span>
					</div>
					<div class="hero-actions">
						<a class="btn primary" href="#contact">Start Your WordPress Project</a>
						<a class="btn ghost" href="#work">View WordPress Work</a>
					</div>
				</div>
				<div class="hero-showcase">
					<article class="hero-card hero-profile" aria-label="Profile portrait">
						<div class="hero-portrait"></div>
					</article>
					<article class="hero-card hero-info">
						<p>WordPress Custom Theme Developer</p>
						<div class="hero-tags">
							<span>WordPress</span>
							<span>Custom Themes</span>
							<span>PHP</span>
							<span>ACF</span>
							<span>HTML/CSS</span>
							<span>JavaScript</span>
						</div>
						<div class="hero-meter" aria-hidden="true">
							<div></div>
						</div>
					</article>
					<article class="hero-card hero-brands" aria-label="Brands and platforms">
						<p>Tools I use for WordPress builds</p>
						<div>
							<span>Figma</span>
							<span>GitHub</span>
							<span>WP-CLI</span>
							<span>LiteSpeed</span>
						</div>
					</article>
				</div>
			</div>
		</div>
	</section>

	<section class="about" id="about">
		<div class="sec-wrap">
			<div class="section-title">
				<h2>About</h2>
				<p>
					I'm a WordPress custom theme developer with a strong technical and international background. I studied web design and front-end development in Japan for 3 years and passed JLPT N1, the highest level of Japanese proficiency. I currently work as a Deputy Manager at VFS Global, while building high-quality custom WordPress themes for corporate clients and Upwork projects.
				</p>
			</div>
			<div class="about-cards">
				<article>
					<div class="card-icon" aria-hidden="true">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
							<rect x="3" y="4" width="18" height="16" rx="2" />
							<path d="M3 9h18" />
						</svg>
					</div>
					<h3>What I do</h3>
					<p>
						I build bespoke WordPress themes (HTML/CSS/JS/PHP), convert Figma/XD designs into pixel-perfect pages, and create flexible components with ACF.
					</p>
				</article>
				<article>
					<div class="card-icon" aria-hidden="true">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
							<circle cx="12" cy="12" r="9" />
							<path d="M12 7v5l3 3" />
						</svg>
					</div>
					<h3>How I work</h3>
					<p>
						Clear milestones, clean code, and fast communication. I ship responsive pages, optimize performance, and keep everything easy to hand over.
					</p>
				</article>
				<article>
					<div class="card-icon" aria-hidden="true">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
							<path d="M12 21s-6-4.35-6-10a6 6 0 0 1 12 0c0 5.65-6 10-6 10z" />
						</svg>
					</div>
					<h3>What I value</h3>
					<p>
						Speed, reliability, and business clarity. Your site should load fast, look trustworthy, and be simple to update&mdash;without plugin overload.
					</p>
				</article>
				<article>
					<div class="card-icon" aria-hidden="true">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
							<path d="M3 7l9-4 9 4-9 4-9-4z" />
							<path d="M21 10v6" />
							<path d="M7 12v4c3 2 7 2 10 0v-4" />
						</svg>
					</div>
					<h3>Education &amp; Experience</h3>
					<p>
						Studied Web Design in Japan (2017-2020) and earned JLPT N1 certification. Currently Deputy Manager at VFS Global, with leadership experience and 20+ corporate WordPress projects delivered.
					</p>
				</article>
			</div>
		</div>
	</section>

	<section class="work" id="work">
		<div class="sec-wrap work-shell">
			<div class="work-intro-col">
				<div class="section-title">
					<h2>Selected work</h2>
					<p>
						A few recent WordPress builds. I can share more live links and details on request.
					</p>
				</div>
				<?php if ( $portfolio_archive_url ) : ?>
					<a class="work-see-all" href="<?php echo esc_url( $portfolio_archive_url ); ?>">See all</a>
				<?php else : ?>
					<a class="work-see-all" href="#contact">See all</a>
				<?php endif; ?>
			</div>
			<div class="work-cards-viewport">
				<div class="work-track">
					<?php if ( $featured_portfolio instanceof \WP_Post ) : ?>
						<?php
						get_template_part(
							'template-parts/portfolio-card',
							null,
							array(
								'portfolio'       => $featured_portfolio,
								'is_featured'     => true,
								'fallback_class'  => $media_fallbacks[0],
								'image_size'      => 'large',
							)
						);
						?>
					<?php endif; ?>
					<div class="work-grid">
						<?php if ( ! empty( $portfolio_items ) ) : ?>
							<?php foreach ( array_values( $portfolio_items ) as $index => $portfolio_item ) : ?>
								<?php
								$fallback_class  = $media_fallbacks[ min( count( $media_fallbacks ) - 1, $index + 1 ) ];
								get_template_part(
									'template-parts/portfolio-card',
									null,
									array(
										'portfolio'      => $portfolio_item,
										'is_featured'    => false,
										'fallback_class' => $fallback_class,
										'image_size'     => 'medium_large',
									)
								);
								?>
							<?php endforeach; ?>
						<?php else : ?>
							<article class="project project-small">
								<div class="project-media project-media--zenpoint" aria-hidden="true"></div>
								<div class="project-body">
									<div class="project-top">
										<span class="tag"><?php esc_html_e( 'Portfolio', 'th-theme' ); ?></span>
										<span class="year"><?php echo esc_html( gmdate( 'Y' ) ); ?></span>
									</div>
									<h3><?php esc_html_e( 'Add your first portfolio item', 'th-theme' ); ?></h3>
									<p><?php esc_html_e( 'Create items from the Portfolios menu in WordPress admin to populate this section automatically.', 'th-theme' ); ?></p>
									<div class="project-meta">
										<span><?php esc_html_e( 'Admin', 'th-theme' ); ?></span>
										<span><?php esc_html_e( 'Portfolios', 'th-theme' ); ?></span>
									</div>
								</div>
							</article>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="skills" id="skills">
		<div class="sec-wrap">
			<div class="section-title">
				<h2>Skills</h2>
				<p>
					WordPress-focused skills for building custom themes, fast templates, and maintainable business websites.
				</p>
			</div>
			<div class="skills-grid">
				<div class="skill-block">
					<h3>Core</h3>
					<ul>
						<li>WordPress theme development</li>
						<li>PHP templating (WP loop)</li>
						<li>HTML / CSS (BEM) / JavaScript</li>
						<li>ACF flexible components</li>
					</ul>
				</div>
				<div class="skill-block">
					<h3>Frameworks</h3>
					<ul>
						<li>Custom themes (from scratch)</li>
						<li>Gutenberg blocks (basic)</li>
						<li>WooCommerce (theme support)</li>
						<li>GSAP / Lottie integration</li>
					</ul>
				</div>
				<div class="skill-block">
					<h3>Workflow</h3>
					<ul>
						<li>Figma/XD -&gt; WordPress build</li>
						<li>Performance optimization</li>
						<li>SEO-ready structure</li>
						<li>Deployment &amp; handover</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="contact" id="contact">
		<div class="sec-wrap">
			<div class="contact-card">
				<div>
					<h2>Need a fast, custom WordPress site?</h2>
					<p>
						Send me your design (or references), pages you need, and timeline. I'll build a custom WordPress theme with clean code, responsive layout, and performance-first setup&mdash;ideal for Upwork projects.
					</p>
				</div>
				<div class="contact-actions">
					<a class="btn primary" href="mailto:contact@thanhtike.com" target="_blank">contact@thanhtike.com</a>
					<a class="btn ghost" href="https://www.upwork.com/freelancers/~011e2ccd17b4181d09?mp_source=share" target="_blank">Upwork Profile</a>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
