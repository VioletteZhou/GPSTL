<?php
/**
 * The template for displaying articles in the loop with post excerpts
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

		<div class="entry-content entry-excerpt clearfix">
			<?php the_excerpt(); ?>
			<?php donovan_more_link(); ?>
		</div><!-- .entry-content -->

	</div>

	<footer class="entry-footer post-details">
		<?php donovan_entry_footer(); ?>
	</footer><!-- .entry-footer -->

</article>
