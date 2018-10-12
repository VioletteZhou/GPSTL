<?php
/**
 * The template for displaying the blog index (latest posts)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Donovan
 */

get_header(); ?>

	<div id="primary" class="content-archive content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			donovan_blog_title();

			echo '<div id="post-wrapper" class="post-wrapper">';

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', esc_attr( donovan_get_option( 'blog_content' ) ) );

			endwhile;

			echo '</div>';

			donovan_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
