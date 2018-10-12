<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Donovan
 */

get_header(); ?>

	<div id="primary" class="content-single content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found type-page">

				<header class="entry-header">

					<h1 class="entry-title page-title"><?php esc_html_e( '404: Page not found', 'donovan' ); ?></h1>

				</header><!-- .entry-header -->

				<div class="entry-content clearfix">
					<p><?php esc_html_e( 'Looks like nothing was found at this location. Maybe you can try a search or follow one of the links below?', 'donovan' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php the_widget( 'WP_Widget_Archives', 'dropdown=1' ); ?>

					<?php the_widget( 'WP_Widget_Categories', 'dropdown=1' ); ?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

					<?php the_widget( 'WP_Widget_Pages' ); ?>

				</div>

			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
