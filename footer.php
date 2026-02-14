<?php
/**
 * Footer template.
 *
 * @package th-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="footer">
	<div class="sec-wrap">
		<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> Than Htike. WordPress custom themes, built with care.</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
