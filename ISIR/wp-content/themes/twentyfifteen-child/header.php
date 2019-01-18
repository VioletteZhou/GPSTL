<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<script type="text/javascript" src="/ISIR/wp-content/plugins/hal/includes/hal_team.js"></script>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyfifteen' ); ?></a>

	<div id="sidebar" class="sidebar">
		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<?php
					twentyfifteen_the_custom_logo();

					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif;

					$description = get_bloginfo( 'description', 'display' );

					if ( $description || is_customize_preview() ) : ?>

					<?php endif;
				?>

					<?php

					$page2 = get_page_by_title("Team Members");
					$page5 = get_page_by_title("Team Publications");
					$page7 = get_page_by_title("Team videos");
					$page8 = get_page_by_title("Team videos live");
					$page9 = get_category_by_slug("Team textes");
					$page10 = get_category_by_slug("Team photos");
					$page11 = get_page_by_title("Codes Sources");

					?>
				<button class="secondary-toggle"><?php _e( 'Menu and widgets', 'twentyfifteen' ); ?></button>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_category_link($page9->term_id); ?>">Textes</a><div>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_category_link($page10->term_id); ?>">Photos</a><div>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page2->ID ); ?>">Members</a><div>

<?php if ( is_plugin_active( 'hal/hal.php' ) ) {  ?>
        		<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page5->ID ); ?>">Publications</a><div>
<?php } ?>


<?php if ( is_plugin_active( 'add-code-source/add-code-source.php' ) ) {  ?>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page11->ID ); ?>">Git projects</a><div>
<?php } ?>

<?php if ( is_plugin_active( 'add-video/add-video.php' ) ) {  ?>
			<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page7->ID ); ?>">Videos</a><div>
<?php } ?>

<?php if ( is_plugin_active( 'youtube-live/youtube-live.php' ) ) {  ?>
			<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page8->ID ); ?>">Videos live</a><div>
<?php } ?>
			</div><!-- .site-branding -->
		</header><!-- .site-header -->

	</div><!-- .sidebar -->

	<div id="content" class="site-content">
