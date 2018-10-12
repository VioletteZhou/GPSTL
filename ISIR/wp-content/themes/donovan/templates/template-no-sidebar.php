<?php
/**
 * Template Name: No Sidebar
 * Template Post Type: post, page
 *
 * Description: A custom template for displaying a single post without sidebar.
 *
 * @package Donovan
 */

get_header(); ?>

	<div id="primary" class="content-area content-no-sidebar">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) : the_post();

			if ( 'post' === get_post_type() ) :

				get_template_part( 'template-parts/content', 'single' );

			else :

				get_template_part( 'template-parts/content', 'page' );

			endif;

			donovan_post_navigation();

			donovan_related_posts();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
