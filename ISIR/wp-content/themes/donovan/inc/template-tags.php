<?php
/**
 * Template Tags
 *
 * This file contains several template functions which are used to print out specific HTML markup
 * in the theme. You can override these template functions within your child theme.
 *
 * @package Donovan
 */

if ( ! function_exists( 'donovan_site_logo' ) ) :
	/**
	 * Displays the site logo in the header area
	 */
	function donovan_site_logo() {

		if ( function_exists( 'the_custom_logo' ) ) {

			the_custom_logo();

		}
	}
endif;


if ( ! function_exists( 'donovan_site_title' ) ) :
	/**
	 * Displays the site title in the header area
	 */
	function donovan_site_title() {

		if ( is_home() ) : ?>

			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

		<?php else : ?>

			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'donovan_site_description' ) ) :
	/**
	 * Displays the site description in the header area
	 */
	function donovan_site_description() {

		$description = get_bloginfo( 'description', 'display' ); /* WPCS: xss ok. */

		if ( $description || is_customize_preview() ) : ?>

			<p class="site-description"><?php echo $description; ?></p>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'donovan_header_image' ) ) :
	/**
	 * Displays the custom header image below the navigation menu
	 */
	function donovan_header_image() {

		if ( has_header_image() ) : ?>

			<div id="headimg" class="header-image">

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id, 'full' ) ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				</a>

			</div>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'donovan_blog_title' ) ) :
	/**
	 * Displays the archive title and archive description for the blog index
	 */
	function donovan_blog_title() {

		// Get blog title and descripton from database.
		$blog_title = donovan_get_option( 'blog_title' );
		$blog_description = donovan_get_option( 'blog_description' );

		// Display Blog Title.
		if ( '' !== $blog_title || '' !== $blog_description || is_customize_preview() ) : ?>

			<header class="archive-header blog-header clearfix">

				<?php // Display Blog Title.
				if ( '' !== $blog_title || is_customize_preview() ) : ?>

					<h3 class="archive-title blog-title"><?php echo wp_kses_post( $blog_title ); ?></h3>

				<?php endif;

				// Display Blog Description.
				if ( '' !== $blog_description || is_customize_preview() ) : ?>

					<p class="blog-description"><?php echo wp_kses_post( $blog_description ); ?></p>

				<?php endif; ?>

			</header>

		<?php endif;
	}
endif;


if ( ! function_exists( 'donovan_post_image_archives' ) ) :
	/**
	 * Displays the featured image on archive posts.
	 */
	function donovan_post_image_archives() {

		// Set image size.
		$image_size = ( 'list' === donovan_get_option( 'blog_layout' ) ) ? 'donovan-list-post' : 'post-thumbnail';

		// Display Post Thumbnail if activated.
		if ( true === donovan_get_option( 'post_image_archives' ) && has_post_thumbnail() ) : ?>

			<div class="post-image">
				<a class="wp-post-image-link" href="<?php the_permalink(); ?>" rel="bookmark">
					<?php the_post_thumbnail( $image_size ); ?>
				</a>
			</div>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'donovan_post_image_single' ) ) :
	/**
	 * Displays the featured image on single posts
	 */
	function donovan_post_image_single() {

		// Display Post Thumbnail if activated.
		if ( true === donovan_get_option( 'post_image_single' ) ) : ?>

			<div class="post-image">
				<?php the_post_thumbnail(); ?>
			</div>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'donovan_entry_meta' ) ) :
	/**
	 * Displays the date and author of a post
	 */
	function donovan_entry_meta() {

		$postmeta  = donovan_entry_date();
		$postmeta .= donovan_entry_author();

		echo '<div class="entry-meta post-details">' . $postmeta . '</div>';
	}
endif;


if ( ! function_exists( 'donovan_entry_date' ) ) :
	/**
	 * Returns the post date
	 */
	function donovan_entry_date() {

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'donovan' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		return '<span class="posted-on meta-date">' . $posted_on . '</span>';
	}
endif;


if ( ! function_exists( 'donovan_entry_author' ) ) :
	/**
	 * Returns the post author
	 */
	function donovan_entry_author() {

		$author_string = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( esc_html__( 'View all posts by %s', 'donovan' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);

		$posted_by = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'donovan' ),
			$author_string
		);

		return '<span class="posted-by meta-author"> ' . $posted_by . '</span>';
	}
endif;


if ( ! function_exists( 'donovan_entry_footer' ) ) :
	/**
	 * Displays the categories, tags and comments of a post
	 */
	function donovan_entry_footer() {

		// Display categories.
		echo donovan_entry_categories();

		if( is_singular() ) {
			// Display Tags only on single posts.
			donovan_entry_tags();
		} else {
			// Display comments only on blog index and archives.
			echo donovan_entry_comments();
		}
	}
endif;


if ( ! function_exists( 'donovan_entry_categories' ) ) :
	/**
	 * Displays the post categories
	 */
	function donovan_entry_categories() {

		// Return early if post has no category.
		if ( ! has_category() ) {
			return;
		}

		$posted_in = donovan_get_svg( 'category' ) . get_the_category_list( ', ' );

		return '<div class="entry-categories"> ' . $posted_in . '</div>';
	}
endif;


if ( ! function_exists( 'donovan_entry_tags' ) ) :
	/**
	 * Displays the post tags on single post view
	 */
	function donovan_entry_tags() {

		// Get tags.
		$tag_list = get_the_tag_list( '', ', ' );

		// Display tags.
		if ( $tag_list ) : ?>

			<div class="entry-tags clearfix">
				<?php echo donovan_get_svg( 'tag' ); ?>
				<?php echo $tag_list; ?>
			</div><!-- .entry-tags -->

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'donovan_entry_comments' ) ) :
	/**
	 * Displays the post comments
	 */
	function donovan_entry_comments() {

		// Check if comments are open or we have at least one comment.
		if ( comments_open() || get_comments_number() ) : ?>

			<div class="entry-comments">

				<?php
				// Display Comments.
				echo donovan_get_svg( 'mail' );
				comments_popup_link(
					esc_html__( 'Leave a comment', 'donovan' ),
					esc_html__( 'One comment', 'donovan' ),
					esc_html__( '% comments', 'donovan' )
				);
				?>

			</div>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'donovan_more_link' ) ) :
	/**
	 * Displays the more link on posts
	 */
	function donovan_more_link() {

		// Get Read More Text.
		$read_more = donovan_get_option( 'read_more_text' );

		if ( '' !== $read_more || is_customize_preview() ) :
		?>

			<a href="<?php echo esc_url( get_permalink() ) ?>" class="more-link"><?php echo esc_html( $read_more ); ?></a>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'donovan_post_navigation' ) ) :
	/**
	 * Displays Single Post Navigation
	 */
	function donovan_post_navigation() {

		if ( true === donovan_get_option( 'post_navigation' ) || is_customize_preview() ) {

			the_post_navigation( array(
				'prev_text' => '<span class="nav-link-text">' . esc_html_x( 'Previous Post', 'post navigation', 'donovan' ) . '</span><h3 class="entry-title">%title</h3>',
				'next_text' => '<span class="nav-link-text">' . esc_html_x( 'Next Post', 'post navigation', 'donovan' ) . '</span><h3 class="entry-title">%title</h3>',
			) );

		}
	}
endif;


if ( ! function_exists( 'donovan_breadcrumbs' ) ) :
	/**
	 * Displays ThemeZee Breadcrumbs plugin
	 */
	function donovan_breadcrumbs() {

		if ( function_exists( 'themezee_breadcrumbs' ) ) {

			themezee_breadcrumbs( array(
				'before' => '<div class="breadcrumbs-container container clearfix">',
				'after' => '</div>',
			) );

		}
	}
endif;


if ( ! function_exists( 'donovan_related_posts' ) ) :
	/**
	 * Displays ThemeZee Related Posts plugin
	 */
	function donovan_related_posts() {

		if ( function_exists( 'themezee_related_posts' ) ) {

			themezee_related_posts( array(
				'class' => 'related-posts type-page',
				'before_title' => '<h2 class="archive-title related-posts-title">',
				'after_title' => '</h2>',
			) );

		}
	}
endif;


if ( ! function_exists( 'donovan_pagination' ) ) :
	/**
	 * Displays pagination on archive pages
	 */
	function donovan_pagination() {

		the_posts_pagination( array(
			'mid_size'  => 2,
			'prev_text' => '&laquo<span class="screen-reader-text">' . esc_html_x( 'Previous Posts', 'pagination', 'donovan' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next Posts', 'pagination', 'donovan' ) . '</span>&raquo;',
		) );

	}
endif;


/**
 * Displays credit link on footer line
 */
function donovan_credit_link() {
	?>

	<span class="credit-link">
		<?php printf( esc_html__( 'Powered by %1$s and %2$s.', 'donovan' ),
			'<a href="' . esc_url( __( 'http://wordpress.org', 'donovan' ) ) . '" title="WordPress">WordPress</a>',
			'<a href="https://themezee.com/themes/donovan/" title="Donovan WordPress Theme">Donovan</a>'
		); ?>
	</span>

	<?php
}
