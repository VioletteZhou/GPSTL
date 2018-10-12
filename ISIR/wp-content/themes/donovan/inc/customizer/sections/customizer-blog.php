<?php
/**
 * Blog Settings
 *
 * Register Blog Settings section, settings and controls for Theme Customizer
 *
 * @package Donovan
 */

/**
 * Adds blog settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function donovan_customize_register_blog_settings( $wp_customize ) {

	// Add Sections for Post Settings.
	$wp_customize->add_section( 'donovan_section_blog', array(
		'title'    => esc_html__( 'Blog Settings', 'donovan' ),
		'priority' => 30,
		'panel' => 'donovan_options_panel',
	) );

	// Add Blog Title setting and control.
	$wp_customize->add_setting( 'donovan_theme_options[blog_title]', array(
		'default'           => '',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'donovan_theme_options[blog_title]', array(
		'label'    => esc_html__( 'Blog Title', 'donovan' ),
		'section'  => 'donovan_section_blog',
		'settings' => 'donovan_theme_options[blog_title]',
		'type'     => 'text',
		'priority' => 10,
	) );

	$wp_customize->selective_refresh->add_partial( 'donovan_theme_options[blog_title]', array(
		'selector'         => '.blog-header .blog-title',
		'render_callback'  => 'donovan_customize_partial_blog_title',
		'fallback_refresh' => false,
	) );

	// Add Blog Description setting and control.
	$wp_customize->add_setting( 'donovan_theme_options[blog_description]', array(
		'default'           => '',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'donovan_theme_options[blog_description]', array(
		'label'    => esc_html__( 'Blog Description', 'donovan' ),
		'section'  => 'donovan_section_blog',
		'settings' => 'donovan_theme_options[blog_description]',
		'type'     => 'textarea',
		'priority' => 20,
	) );

	$wp_customize->selective_refresh->add_partial( 'donovan_theme_options[blog_description]', array(
		'selector'         => '.blog-header .blog-description',
		'render_callback'  => 'donovan_customize_partial_blog_description',
		'fallback_refresh' => false,
	) );

	// Add Settings and Controls for blog layout.
	$wp_customize->add_setting( 'donovan_theme_options[blog_layout]', array(
		'default'           => 'grid',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'donovan_sanitize_select',
	) );

	$wp_customize->add_control( 'donovan_theme_options[blog_layout]', array(
		'label'    => esc_html__( 'Blog Layout', 'donovan' ),
		'section'  => 'donovan_section_blog',
		'settings' => 'donovan_theme_options[blog_layout]',
		'type'     => 'select',
		'priority' => 30,
		'choices'  => array(
			'large' => esc_html__( 'Large Posts', 'donovan' ),
			'list'  => esc_html__( 'Post List', 'donovan' ),
			'grid'  => esc_html__( 'Post Grid', 'donovan' ),
		),
	) );

	// Add Settings and Controls for blog content.
	$wp_customize->add_setting( 'donovan_theme_options[blog_content]', array(
		'default'           => 'excerpt',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'donovan_sanitize_select',
	) );

	$wp_customize->add_control( 'donovan_theme_options[blog_content]', array(
		'label'    => esc_html__( 'Blog Content', 'donovan' ),
		'section'  => 'donovan_section_blog',
		'settings' => 'donovan_theme_options[blog_content]',
		'type'     => 'radio',
		'priority' => 40,
		'choices'  => array(
			'index'   => esc_html__( 'Full post', 'donovan' ),
			'excerpt' => esc_html__( 'Post excerpt', 'donovan' ),
		),
	) );

	// Add Setting and Control for Excerpt Length.
	$wp_customize->add_setting( 'donovan_theme_options[excerpt_length]', array(
		'default'           => 20,
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'donovan_theme_options[excerpt_length]', array(
		'label'    => esc_html__( 'Excerpt Length', 'donovan' ),
		'section'  => 'donovan_section_blog',
		'settings' => 'donovan_theme_options[excerpt_length]',
		'type'     => 'text',
		'priority' => 50,
	) );

	// Add Partial for Blog Layout and Excerpt Length.
	$wp_customize->selective_refresh->add_partial( 'donovan_blog_content_partial', array(
		'selector'         => '.site-main .post-wrapper',
		'settings'         => array(
			'donovan_theme_options[blog_layout]',
			'donovan_theme_options[blog_content]',
			'donovan_theme_options[excerpt_length]',
		),
		'render_callback'  => 'donovan_customize_partial_blog_content',
		'fallback_refresh' => false,
	) );

	// Add Setting and Control for Read More Text.
	$wp_customize->add_setting( 'donovan_theme_options[read_more_text]', array(
		'default'           => esc_html__( 'Continue reading', 'donovan' ),
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'donovan_theme_options[read_more_text]', array(
		'label'    => esc_html__( 'Read More Text', 'donovan' ),
		'section'  => 'donovan_section_blog',
		'settings' => 'donovan_theme_options[read_more_text]',
		'type'     => 'text',
		'priority' => 60,
	) );
}
add_action( 'customize_register', 'donovan_customize_register_blog_settings' );

/**
 * Render the blog title for the selective refresh partial.
 */
function donovan_customize_partial_blog_title() {
	echo wp_kses_post( donovan_get_option( 'blog_title' ) );
}

/**
 * Render the blog description for the selective refresh partial.
 */
function donovan_customize_partial_blog_description() {
	echo wp_kses_post( donovan_get_option( 'blog_description' ) );
}

/**
 * Render the blog content for the selective refresh partial.
 */
function donovan_customize_partial_blog_content() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', esc_attr( donovan_get_option( 'blog_content' ) ) );
	}
}
