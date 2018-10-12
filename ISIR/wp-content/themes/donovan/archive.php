<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Donovan
 */

get_header(); ?>

	<div id="primary" class="content-archive content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="archive-header">

				<?php the_archive_title( '<h1 class="archive-title">', '</h1>' ); ?>
				<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>

			</header><!-- .archive-header -->

			<div id="post-wrapper" class="post-wrapper">

			<?php while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', esc_attr( donovan_get_option( 'blog_content' ) ) );

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
