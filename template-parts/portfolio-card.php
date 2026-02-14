<?php
/**
 * Reusable portfolio card template part.
 *
 * @package th-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'portfolio'      => null,
		'is_featured'    => false,
		'fallback_class' => 'project-media--featured',
		'image_size'     => 'medium_large',
	)
);

if ( ! ( $args['portfolio'] instanceof \WP_Post ) ) {
	return;
}

$portfolio      = $args['portfolio'];
$is_featured    = (bool) $args['is_featured'];
$fallback_class = (string) $args['fallback_class'];
$image_size     = (string) $args['image_size'];

$type_terms = get_the_terms( $portfolio, 'portfolio_type' );
$top_tag    = __( 'Portfolio', 'th-theme' );

if ( ! is_wp_error( $type_terms ) && ! empty( $type_terms ) ) {
	$top_tag = $type_terms[0]->name;
}

$summary = get_the_excerpt( $portfolio );

if ( '' === trim( $summary ) ) {
	$summary = wp_trim_words(
		wp_strip_all_tags( (string) $portfolio->post_content ),
		22,
		'...'
	);
}

$chips     = array();
$tag_terms = get_the_terms( $portfolio, 'post_tag' );

if ( ! is_wp_error( $tag_terms ) && ! empty( $tag_terms ) ) {
	$chips = wp_list_pluck( array_slice( $tag_terms, 0, 3 ), 'name' );
}

if ( empty( $chips ) ) {
	$chips = array( __( 'WordPress', 'th-theme' ) );
}

$image_url     = get_the_post_thumbnail_url( $portfolio, $image_size );
$media_classes = 'project-media ' . $fallback_class;
$image_alt     = get_post_meta( get_post_thumbnail_id( $portfolio ), '_wp_attachment_image_alt', true );

if ( '' === trim( (string) $image_alt ) ) {
	$image_alt = get_the_title( $portfolio );
}
?>
<article class="project <?php echo $is_featured ? 'project-featured' : 'project-small'; ?>">
	<a class="project-card-link" href="<?php echo esc_url( get_permalink( $portfolio ) ); ?>">
		<div class="<?php echo esc_attr( $media_classes ); ?>" aria-hidden="true">
			<?php if ( $image_url ) : ?>
				<img
					class="project-image"
					src="<?php echo esc_url( $image_url ); ?>"
					alt="<?php echo esc_attr( $image_alt ); ?>"
					loading="lazy"
					decoding="async"
				/>
			<?php endif; ?>
		</div>
		<div class="project-body">
			<div class="project-top">
				<span class="tag"><?php echo esc_html( $top_tag ); ?></span>
				<span class="year"><?php echo esc_html( get_the_date( 'Y', $portfolio ) ); ?></span>
			</div>
			<h3><?php echo esc_html( get_the_title( $portfolio ) ); ?></h3>
			<p><?php echo esc_html( $summary ); ?></p>
			<div class="project-meta">
				<?php foreach ( $chips as $chip ) : ?>
					<span><?php echo esc_html( $chip ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	</a>
</article>
