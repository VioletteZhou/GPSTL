<?php
	if ( post_password_required() )
	return;
?>

<aside id="comments">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">Comments:</h3>
		<ul class="media-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
					'short_ping'  => true,
					'avatar_size' => 74,
					'callback' => 'blogkori_comments_callback'
				) );
			?>
		</ul><!-- .comment-list -->

		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h3 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'blogkori' ); ?></h3>
			<div class="nav-previous col-xs-6"><?php previous_comments_link( __( '&larr; Older Comments', 'blogkori' ) ); ?></div>
			<div class="nav-next col-xs-6"><?php next_comments_link( __( 'Newer Comments &rarr;', 'blogkori' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'blogkori' ); ?></p>
		<?php endif; ?>
	<?php endif; // have_comments() ?>
	<?php comment_form(); ?>			
</aside><!-- #comments -->