<?php
/**
 * Portfolio archive template.
 *
 * @package th-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_type = '';
$current_year = 0;

if ( isset( $_GET['portfolio_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$current_type = sanitize_title( wp_unslash( $_GET['portfolio_type'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}
if ( isset( $_GET['portfolio_year'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$current_year = absint( wp_unslash( $_GET['portfolio_year'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

$paged = max( 1, get_query_var( 'paged', 1 ) );

$query_args = array(
	'post_type'           => 'portfolio',
	'post_status'         => 'publish',
	'posts_per_page'      => 10,
	'paged'               => $paged,
	'orderby'             => 'date',
	'order'               => 'DESC',
	'ignore_sticky_posts' => true,
);

if ( '' !== $current_type ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'portfolio_type',
			'field'    => 'slug',
			'terms'    => $current_type,
		),
	);
}
if ( $current_year > 0 ) {
	$query_args['date_query'] = array(
		array(
			'year' => $current_year,
		),
	);
}

$portfolio_query = new \WP_Query( $query_args );
$type_terms      = get_terms(
	array(
		'taxonomy'   => 'portfolio_type',
		'hide_empty' => true,
	)
);
$years_query     = new \WP_Query(
	array(
		'post_type'           => 'portfolio',
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'fields'              => 'ids',
	)
);
$available_years = array();

if ( ! empty( $years_query->posts ) ) {
	foreach ( $years_query->posts as $portfolio_id ) {
		$year = (int) get_the_date( 'Y', $portfolio_id );
		if ( $year > 0 ) {
			$available_years[ $year ] = $year;
		}
	}
	krsort( $available_years );
}
$media_fallbacks = array(
	'project-media--featured',
	'project-media--zenpoint',
	'project-media--saint',
	'project-media--studio',
	'project-media--estate',
);

get_header();
?>
<main>
	<section class="portfolio-archive work">
		<div class="sec-wrap">
			<div class="section-title">
				<h1><?php esc_html_e( 'All portfolios', 'th-theme' ); ?></h1>
				<p><?php esc_html_e( 'Browse project case studies, filter by type, and open each portfolio for full details.', 'th-theme' ); ?></p>
			</div>

			<div class="portfolio-filter-bar">
				<div class="portfolio-filters">
					<a class="portfolio-filter<?php echo '' === $current_type ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>">
						<?php esc_html_e( 'All', 'th-theme' ); ?>
					</a>
					<?php if ( ! is_wp_error( $type_terms ) && ! empty( $type_terms ) ) : ?>
						<?php foreach ( $type_terms as $term ) : ?>
							<a
								class="portfolio-filter<?php echo $current_type === $term->slug ? ' is-active' : ''; ?>"
								href="<?php echo esc_url( add_query_arg( 'portfolio_type', $term->slug, get_post_type_archive_link( 'portfolio' ) ) ); ?>"
							>
								<?php echo esc_html( $term->name ); ?>
							</a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

				<form class="portfolio-year-form" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>">
					<?php if ( '' !== $current_type ) : ?>
						<input type="hidden" name="portfolio_type" value="<?php echo esc_attr( $current_type ); ?>" />
					<?php endif; ?>
					<label class="portfolio-year-label" for="portfolio-year-select"><?php esc_html_e( 'Year', 'th-theme' ); ?></label>
					<select id="portfolio-year-select" class="portfolio-year-select" name="portfolio_year" onchange="this.form.submit()">
						<option value=""><?php esc_html_e( 'All years', 'th-theme' ); ?></option>
						<?php foreach ( $available_years as $year ) : ?>
							<option value="<?php echo esc_attr( (string) $year ); ?>" <?php selected( (int) $current_year, (int) $year ); ?>>
								<?php echo esc_html( (string) $year ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</form>
			</div>

			<?php if ( $portfolio_query->have_posts() ) : ?>
				<div class="work-grid portfolio-archive-grid">
					<?php
					$card_index = 0;
					while ( $portfolio_query->have_posts() ) :
						$portfolio_query->the_post();
						$fallback_class = $media_fallbacks[ $card_index % count( $media_fallbacks ) ];
						get_template_part(
							'template-parts/portfolio-card',
							null,
							array(
								'portfolio'      => get_post(),
								'is_featured'    => false,
								'fallback_class' => $fallback_class,
								'image_size'     => 'medium_large',
							)
						);
						$card_index++;
					endwhile;
					?>
				</div>

				<?php
				$pagination_base = get_pagenum_link( 1 );
				$pagination_base = add_query_arg(
					array(
						'portfolio_type' => $current_type,
						'portfolio_year' => $current_year > 0 ? $current_year : '',
					),
					$pagination_base
				);

				echo wp_kses_post(
					paginate_links(
						array(
							'base'      => trailingslashit( $pagination_base ) . '%_%',
							'format'    => user_trailingslashit( 'page/%#%/', 'paged' ),
							'current'   => $paged,
							'total'     => max( 1, (int) $portfolio_query->max_num_pages ),
							'prev_text' => '&larr; ' . __( 'Previous', 'th-theme' ),
							'next_text' => __( 'Next', 'th-theme' ) . ' &rarr;',
							'type'      => 'list',
						)
					)
				);
				?>
			<?php else : ?>
				<article class="project project-small">
					<div class="project-body">
						<h2><?php esc_html_e( 'No portfolios found', 'th-theme' ); ?></h2>
						<p><?php esc_html_e( 'Try a different filter or add new portfolio items from WordPress admin.', 'th-theme' ); ?></p>
					</div>
				</article>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</section>
</main>

<?php
get_footer();
