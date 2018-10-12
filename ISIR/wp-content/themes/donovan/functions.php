<?php
/**
 * Donovan functions and definitions
 *
 * @package Donovan
 */

/**
 * Donovan only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


if ( ! function_exists( 'donovan_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function donovan_setup() {

		// Make theme available for translation. Translations can be filed at https://translate.wordpress.org/projects/wp-themes/donovan
		load_theme_textdomain( 'donovan', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Set detfault Post Thumbnail size.
		set_post_thumbnail_size( 1360, 765, true );

		// Register Navigation Menus.
		register_nav_menus( array(
			'primary' => esc_html__( 'Main Navigation', 'donovan' ),
			'social'  => esc_html__( 'Social Icons', 'donovan' ),
		) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'donovan_custom_background_args', array(
			'default-color' => 'cccccc',
		) ) );

		// Set up the WordPress core custom logo feature.
		add_theme_support( 'custom-logo', apply_filters( 'donovan_custom_logo_args', array(
			'height' => 60,
			'width' => 300,
			'flex-height' => true,
			'flex-width' => true,
		) ) );

		// Set up the WordPress core custom header feature.
		add_theme_support( 'custom-header', apply_filters( 'donovan_custom_header_args', array(
			'header-text' => false,
			'width'	      => 2560,
			'height'      => 500,
			'flex-width'  => true,
			'flex-height' => true,
		) ) );

		// Add extra theme styling to the visual editor.
		add_editor_style( array( 'css/editor-style.css', get_template_directory_uri() . '/assets/css/custom-fonts.css' ) );

		// Add Theme Support for Selective Refresh in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'donovan_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function donovan_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'donovan_content_width', 910 );
}
add_action( 'after_setup_theme', 'donovan_content_width', 0 );


/**
 * Register widget areas and custom widgets.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function donovan_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'donovan' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html_x( 'Sidebar will appear on posts and pages, except with the full width template.', 'widget area description', 'donovan' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'donovan_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function donovan_scripts() {

	// Get Theme Version.
	$theme_version = wp_get_theme()->get( 'Version' );

	// Register and Enqueue Stylesheet.
	wp_enqueue_style( 'donovan-stylesheet', get_stylesheet_uri(), array(), $theme_version );

	// Register and enqueue navigation.js.
	wp_enqueue_script( 'donovan-jquery-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '20171005' );

	// Passing Parameters to navigation.js.
	wp_localize_script( 'donovan-jquery-navigation', 'donovan_menu_title', donovan_get_svg( 'menu' ) . esc_html__( 'Menu', 'donovan' ) );

	// Enqueue svgxuse to support external SVG Sprites in Internet Explorer.
	wp_enqueue_script( 'svgxuse', get_theme_file_uri( '/assets/js/svgxuse.min.js' ), array(), '1.2.4' );

	// Register Comment Reply Script for Threaded Comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'donovan_scripts' );


/**
 * Enqueue custom fonts.
 */
function donovan_custom_fonts() {

	// Register and Enqueue Theme Fonts.
	wp_enqueue_style( 'donovan-custom-fonts', get_template_directory_uri() . '/assets/css/custom-fonts.css', array(), '20180413' );

}
add_action( 'wp_enqueue_scripts', 'donovan_custom_fonts', 1 );


/**
 * Add custom sizes for featured images
 */
function donovan_add_image_sizes() {

	add_image_size( 'donovan-list-post', 600, 450, true );

}
add_action( 'after_setup_theme', 'donovan_add_image_sizes' );


/**
 * Add pingback url on single posts
 */
function donovan_pingback_url() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'donovan_pingback_url' );


/**
 * Include Files
 */

// Include Theme Info page.
require get_template_directory() . '/inc/theme-info.php';

// Include Theme Customizer Options.
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/default-options.php';

// Include SVG Icon Functions.
require get_template_directory() . '/inc/icons.php';

// Include Template Functions.
require get_template_directory() . '/inc/template-functions.php';

// Include Template Tags.
require get_template_directory() . '/inc/template-tags.php';

// Include support functions for Theme Addons.
require get_template_directory() . '/inc/addons.php';
