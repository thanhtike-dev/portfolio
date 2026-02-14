<?php
/**
 * Main fallback template.
 *
 * @package th-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main>
	<section class="about">
		<div class="sec-wrap">
			<?php if ( have_posts() ) : ?>
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article class="contact-card">
						<h1><?php the_title(); ?></h1>
						<div>
							<?php the_content(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			<?php else : ?>
				<article class="contact-card">
					<h1><?php esc_html_e( 'Nothing Found', 'th-theme' ); ?></h1>
					<p><?php esc_html_e( 'There is no content to display right now.', 'th-theme' ); ?></p>
				</article>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
