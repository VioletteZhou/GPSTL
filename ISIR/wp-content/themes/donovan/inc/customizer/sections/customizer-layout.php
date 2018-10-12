<?php
/**
 * Layout Settings
 *
 * Register Layout section, settings and controls for Theme Customizer
 *
 * @package Donovan
 */

/**
 * Adds all layout settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function donovan_customize_register_layout_settings( $wp_customize ) {

	// Add Section for Theme Options.
	$wp_customize->add_section( 'donovan_section_layout', array(
		'title'    => esc_html__( 'Layout Settings', 'donovan' ),
		'priority' => 10,
		'panel'    => 'donovan_options_panel',
	) );

	// Add Settings and Controls for theme layout.
	$wp_customize->add_setting( 'donovan_theme_options[theme_layout]', array(
		'default'           => 'wide',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'donovan_sanitize_select',
	) );

	$wp_customize->add_control( 'donovan_theme_options[theme_layout]', array(
		'label'    => esc_html__( 'Theme Layout', 'donovan' ),
		'section'  => 'donovan_section_layout',
		'settings' => 'donovan_theme_options[theme_layout]',
		'type'     => 'select',
		'priority' => 10,
		'choices'  => array(
			'wide'     => esc_html__( 'Wide Layout', 'donovan' ),
			'centered' => esc_html__( 'Centered Layout', 'donovan' ),
			'boxed'    => esc_html__( 'Boxed Layout', 'donovan' ),
		),
	) );

	// Add Settings and Controls for Layout.
	$wp_customize->add_setting( 'donovan_theme_options[sidebar_position]', array(
		'default'           => 'right-sidebar',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'donovan_sanitize_select',
	) );

	$wp_customize->add_control( 'donovan_theme_options[sidebar_position]', array(
		'label'    => esc_html__( 'Sidebar Position', 'donovan' ),
		'section'  => 'donovan_section_layout',
		'settings' => 'donovan_theme_options[sidebar_position]',
		'type'     => 'radio',
		'priority' => 20,
		'choices'  => array(
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'donovan' ),
			'right-sidebar' => esc_html__( 'Right Sidebar', 'donovan' ),
		),
	) );
}
add_action( 'customize_register', 'donovan_customize_register_layout_settings' );
