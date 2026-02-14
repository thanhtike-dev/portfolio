<?php
/**
 * Single portfolio template.
 *
 * @package th-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main>
	<section class="portfolio-single">
		<div class="sec-wrap">
			<?php
			while ( have_posts() ) :
				the_post();

				$type_terms = get_the_terms( get_the_ID(), 'portfolio_type' );
				$top_tag    = __( 'Portfolio', 'th-theme' );
				$tags       = get_the_terms( get_the_ID(), 'post_tag' );
				$year       = get_the_date( 'Y' );
				$excerpt    = get_the_excerpt();
				$back_url   = home_url( '/#work' );
				$live_url   = get_post_meta( get_the_ID(), 'live_website_url', true );
				$prev_post  = get_adjacent_post( false, '', true, 'portfolio_type' );
				$next_post  = get_adjacent_post( false, '', false, 'portfolio_type' );

				if ( ! is_wp_error( $type_terms ) && ! empty( $type_terms ) ) {
					$top_tag = $type_terms[0]->name;
				}

				if ( '' === trim( $excerpt ) ) {
					$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 26, '...' );
				}
				?>
				<article class="portfolio-single-card">
					<header class="portfolio-single-hero">
						<div class="portfolio-single-head">
							<div class="portfolio-single-top">
								<span class="tag"><?php echo esc_html( $top_tag ); ?></span>
								<span class="year"><?php echo esc_html( $year ); ?></span>
							</div>
							<h1><?php the_title(); ?></h1>
							<p class="portfolio-single-lead"><?php echo esc_html( $excerpt ); ?></p>
						</div>
						<?php if ( has_post_thumbnail() ) : ?>
							<figure class="portfolio-single-media">
								<img
									class="portfolio-single-image"
									src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>"
									alt="<?php echo esc_attr( get_the_title() ); ?>"
									loading="eager"
									decoding="async"
								/>
							</figure>
						<?php endif; ?>
					</header>
					<div class="portfolio-single-grid">
						<aside class="portfolio-single-side">
							<h2><?php esc_html_e( 'Project details', 'th-theme' ); ?></h2>
							<ul class="portfolio-single-facts">
								<li><span><?php esc_html_e( 'Type', 'th-theme' ); ?></span><strong><?php echo esc_html( $top_tag ); ?></strong></li>
								<li><span><?php esc_html_e( 'Year', 'th-theme' ); ?></span><strong><?php echo esc_html( $year ); ?></strong></li>
								<li><span><?php esc_html_e( 'Status', 'th-theme' ); ?></span><strong><?php esc_html_e( 'Completed', 'th-theme' ); ?></strong></li>
							</ul>
							<?php if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) : ?>
								<div class="project-meta">
									<?php foreach ( $tags as $tag ) : ?>
										<span><?php echo esc_html( $tag->name ); ?></span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<?php if ( ! empty( $live_url ) ) : ?>
								<p>
									<a
										class="btn primary"
										href="<?php echo esc_url( $live_url ); ?>"
										target="_blank"
										rel="noopener noreferrer"
									>
										<?php esc_html_e( 'Go to live website', 'th-theme' ); ?>
									</a>
								</p>
							<?php endif; ?>
						</aside>
						<div class="portfolio-single-content">
							<?php the_content(); ?>
						</div>
					</div>
					<div class="portfolio-single-nav">
						<a class="work-see-all" href="<?php echo esc_url( home_url( 'portfolios' ) ); ?>"><?php esc_html_e( 'All portfolios', 'th-theme' ); ?></a>
						<div class="portfolio-single-links">
							<?php if ( $prev_post instanceof \WP_Post ) : ?>
								<a class="work-see-all" href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>">&larr; <?php esc_html_e( 'Previous', 'th-theme' ); ?></a>
							<?php endif; ?>
							<?php if ( $next_post instanceof \WP_Post ) : ?>
								<a class="work-see-all" href="<?php echo esc_url( get_permalink( $next_post ) ); ?>"><?php esc_html_e( 'Next', 'th-theme' ); ?> &rarr;</a>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
	</section>
</main>

<?php
get_footer();
