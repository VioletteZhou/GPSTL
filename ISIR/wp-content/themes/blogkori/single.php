<?php get_header(); ?>
		<div id="content-box" class="row">
			<main id="content" class="col-sm-9">
				<?php if(have_posts()): while(have_posts()): the_post(); ?>
					<article <?php post_class('article'); ?>>
					<h2 id="post-<?php the_ID(); ?>" class="post-title"><?php the_title(); ?></h2>
					<p class="post-meta"><em><?php _e( 'by', 'blogkori' );?></em> <?php the_author(); ?> <em><?php _e( 'on', 'blogkori' );?></em> <?php the_date(); ?></p>
					<div class="post-content">
					<div class="alignright"><?php if(has_post_thumbnail()) the_post_thumbnail('blogkori-category-thumb'); ?></div>
					<?php the_content(); ?>
					</div>
					<div class="post-tags">
						<?php wp_link_pages( $blogkori_pg_defaults ); ?>
					</div>

					<p class="post-tags">
						<?php the_tags(esc_html__('Tagged as: ', 'blogkori')); ?>
					</p>
					</article>

					<aside id="comments">
					<div class="single-comment">
						<?php if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif; ?>
					</div>
					</aside>

				<?php endwhile; ?>

			<?php else: ?>
				<!-- No posts found -->

			<?php endif; ?>
			</main>
			<?php get_sidebar(); ?>
		</div>
	<?php get_footer(); ?>
