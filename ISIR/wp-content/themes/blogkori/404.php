<?php get_header(); ?>
		<div id="content-box" class="row">
			<main id="content" class="col-sm-9">
					<article <?php post_class('article'); ?>>
					<h2 id="post-<?php the_ID(); ?>" class="post-title">
						<?php _e('Nothing Found!', 'blogkori');?>
					</h2>
					
					<div class="post-content">
                        <p><?php _e('Sorry the page does not exists, please go back and try again.', 'blogkori'); ?></p>
					</div>
					</article>
			</main>
			<?php get_sidebar(); ?>
		</div>
	<?php get_footer(); ?>+-