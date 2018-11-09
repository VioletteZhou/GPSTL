<?php get_header(); ?>
		<div id="content-box" class="row">
			<main id="content" class="col-sm-9">
				<div class="article border"><h2><?php _e('Search results for:', 'blogkori'); ?> <em>"<?php echo the_search_query(); ?>"</em></h2></div>
				<?php if(have_posts()): while(have_posts()): the_post(); ?>
					<article <?php post_class('article border'); ?>>
						<h2 id="post-<?php the_ID(); ?>" class="post-title">
							<a href="<?php the_permalink(); ?>" title="<?php _e( 'Permanent link to', 'blogkori' );?> <?php the_title(); ?>"><?php the_title(); ?></a>
						</h2>
						<p class="post-meta"><em><?php _e( 'by', 'blogkori' );?></em> <?php the_author(); ?> <em><?php _e( 'on', 'blogkori' );?></em> <?php the_date(); ?></p>
						<div class="post-content">
							<div class="alignright"><?php if(has_post_thumbnail()) the_post_thumbnail(array(200,200)); ?></div>
							<?php the_content(esc_html__('[Continue reading...]', 'blogkori')); ?>
						</div>
						<p class="post-tags">
							<?php the_tags(esc_html__('Tagged as: ', 'blogkori')); ?>
						</p>
						<p class="to-comments">{ <?php comments_popup_link(esc_html__('Add a Comment', 'blogkori'), esc_html__('1 Comment', 'blogkori'), esc_html__('% Comments', 'blogkori'), 'to-comments', esc_html('Comments are closed', 'blogkori')); ?> }</p>
					</article>
				<?php endwhile; ?>
			<?php else: ?>
				<!-- No posts found -->
			<?php endif; ?>
				<div class="prev-next">
						<?php the_posts_pagination($next_args); ?>
				</div>
			</main>
			<?php get_sidebar(); ?>
		</div>
<?php get_footer(); ?>
