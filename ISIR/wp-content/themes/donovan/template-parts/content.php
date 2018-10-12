<?php
/**
 * The template for displaying articles in the loop with full content
 *
 * @package Donovan
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php donovan_post_image_archives(); ?>

	<div class="post-content">

		<header class="entry-header">

			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php donovan_entry_meta(); ?>

		</header><!-- .entry-header -->

		<div class="entry-content clearfix">

			<?php the_content( esc_html( donovan_get_option( 'read_more_text' ) ) ); ?>

			<?php wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'donovan' ),
				'after'  => '</div>',
			) ); ?>

		</div><!-- .entry-content -->

	</div>

	<footer class="entry-footer post-details">
		<?php donovan_entry_footer(); ?>
	</footer><!-- .entry-footer -->

</article>
