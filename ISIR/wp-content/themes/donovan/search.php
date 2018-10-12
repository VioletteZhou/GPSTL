<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Donovan
 */

get_header(); ?>

	<div id="primary" class="content-archive content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="archive-header">

				<h1 class="archive-title"><?php printf( esc_html__( 'Search Results for: %s', 'donovan' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php get_search_form(); ?>

			</header><!-- .archive-header -->

			<div id="post-wrapper" class="post-wrapper">

			<?php while ( have_posts() ) : the_post();

				if ( 'post' === get_post_type() ) :

					get_template_part( 'template-parts/content', esc_attr( donovan_get_option( 'blog_content' ) ) );

				else :

					get_template_part( 'template-parts/content', 'search' );

				endif;

			endwhile; ?>

			</div>

			<?php
			donovan_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
