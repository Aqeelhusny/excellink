<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Excellink
 */

get_header();
?>

	<main id="primary" class="site-main container pt-5">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'excellink-store' ); ?></h1>
			</header><!-- .page-header -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
