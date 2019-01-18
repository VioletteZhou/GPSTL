<?php  /**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 ?>


<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<?php wp_head(); ?>
	<script type="text/javascript" src="/ISIR/wp-content/plugins/hal/includes/hal_researcher.js"></script>

</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class(); ?>>
	<?php do_action( 'body_top' ); ?>
	<a class="skip-content" href="#main"><?php _e( 'Skip to content', 'author' ); ?></a>
		<div id="overflow-container" class="overflow-container">
			<div class="max-width">
				<div id="main-sidebar" class="main-sidebar">
					<?php do_action( 'before_main_sidebar' ); ?>
					<header class="site-header" id="site-header" role="banner">
						<div id="title-container" class="title-container">
							<?php
							$avatar_method = get_theme_mod( 'avatar_method' );
							$avatar        = get_theme_mod( 'avatar' );
							if ( $avatar_method == 'gravatar' || ( $avatar_method == 'upload' && ! empty( $avatar ) ) ) { ?>
								<div id="site-avatar" class="site-avatar"
								     style="background-image: url('<?php echo esc_url( ct_author_output_avatar() ); ?>')"
								     title="<?php echo esc_html( get_bloginfo( 'title' ) ) . ' ' . esc_html__( 'avatar', 'author' ); ?>"></div>
							<?php } ?>
							<div class="container">
								<?php get_template_part( 'logo' ) ?>
								<?php
								 ?>
							</div>
						</div>
						<button id="toggle-navigation" class="toggle-navigation" aria-expanded="false">
							<span class="screen-reader-text"><?php _e( 'open primary menu', 'author' ); ?></span>
							<i class="fas fa-bars"></i>
						</button>
						<hr>
						<!-- Menu Toggle -->
						<?php

						$page1 = get_category_by_slug("Textes");
						$page2 = get_page_by_title("Videos");
						$page3 = get_page_by_title("Publications");
						$page4 = get_category_by_slug("Photos");
						$page5 = get_page_by_title("Codes Sources");
						$page9 = get_page_by_title("Videos live");

						?>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

						<ul class="nav navbar-nav navbar-right" style="list-style-type: none; ">
							<li id=" menu-item-0 " style ="margin: 0 0 10px 0;"><a style ="color: white;" href="<?php echo get_category_link($page1->term_id); ?>" title="Textes">Textes</a></li>

<?php if ( is_plugin_active( 'add-video/add-video.php' ) ) {  ?>
							<li id=" menu-item-1 " style ="margin: 0 0 10px 0;" ><a style ="color: white;" href="<?php echo get_permalink( $page2->ID ); ?>">Videos</a></li>
<?php } ?>

<?php if ( is_plugin_active( 'hal/hal.php' ) ) {  ?>

<li id=" menu-item-2 " style ="margin: 0 0 10px 0;" ><a style ="color: white;" href="<?php echo get_permalink( $page3->ID ); ?>">Publications</a></li>
<?php } ?>


							<li id=" menu-item-3 " style ="margin: 0 0 10px 0;" ><a style ="color: white;" href="<?php echo get_category_link($page4->term_id); ?>">Photos</a></li>

<?php if ( is_plugin_active( 'add-code-source/add-code-source.php' ) ) {  ?>

							<li id=" menu-item-4 " style ="margin: 0 0 10px 0;" ><a style ="color: white;" href="<?php echo get_permalink( $page5->ID ); ?>">Codes Sources</a></li>


<?php } ?>

<?php if ( is_plugin_active( 'youtube-live/youtube-live.php' ) ) {  ?>
							<li id=" menu-item-8 " style ="margin: 0 0 10px 0;" ><a style ="color: white;" href="<?php echo get_permalink( $page9->ID ); ?>">Videos live</a></li>
<?php } ?>


						</ul>

						</div>
						<!-- Menu Toggle -->
					</header>

				</div>
				<?php do_action( 'before_main' ); ?>
				<section id="main" class="main" role="main">
					<?php do_action( 'main_top' );
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
					}
