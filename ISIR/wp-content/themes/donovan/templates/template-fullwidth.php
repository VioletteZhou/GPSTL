<?php
/**
 * Template Name: Full-width Layout
 * Template Post Type: post, page
 *
 * Description: A custom template for displaying a fullwidth layout with no sidebar.
 *
 * @package Donovan
 */

get_header(); ?>

	<div id="primary" class="content-single content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();

				if ( 'post' === get_post_type() ) :

					get_template_part( 'template-parts/content', 'single' );

				else :

					get_template_part( 'template-parts/content', 'page' );

				endif;

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
