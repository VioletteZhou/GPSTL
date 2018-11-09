<?php
function taleem_customize_register( $wp_customize ) {

		$wp_customize->add_setting('taleem_theme_options[header_bgcolor]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'header_bgcolor', array(
			'label'    => __('Header Background Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[header_bgcolor]',
		)));	
				
		$wp_customize->add_setting('taleem_theme_options[link_color]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'link_color', array(
			'label'    => __('Hyperlink Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[link_color]',
		)));	
		
		$wp_customize->add_setting('taleem_theme_options[link_hover_color]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'link_hover_color', array(
			'label'    => __('Hyperlink Hover Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[link_hover_color]',
		)));			
					
		$wp_customize->add_setting('taleem_theme_options[bars_bgcolor]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'bars_bgcolor', array(
			'label'    => __('Bars Background Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[bars_bgcolor]',
		)));	

		$wp_customize->add_setting('taleem_theme_options[pagination_bgcolor]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'pagination_bgcolor', array(
			'label'    => __('Pagination Background Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[pagination_bgcolor]',
		)));	
		
		$wp_customize->add_setting('taleem_theme_options[pagination_color]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'pagination_color', array(
			'label'    => __('Pagination Text Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[pagination_color]',
		)));
		
		$wp_customize->add_setting('taleem_theme_options[buttons_bgcolor]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'buttons_bgcolor', array(
			'label'    => __('Button Background Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[buttons_bgcolor]',
		)));	
		
		$wp_customize->add_setting('taleem_theme_options[buttons_color]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'buttons_color', array(
			'label'    => __('Button Text Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[buttons_color]',
		)));
		
		$wp_customize->add_setting('taleem_theme_options[menu_bgcolor]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'menu_bgcolor', array(
			'label'    => __('Menu Background Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[menu_bgcolor]',
		)));	
		
		$wp_customize->add_setting('taleem_theme_options[menu_text_color]', array(
			'default'           => '000',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'type'           => 'option',
		));
		$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'menu_text_color', array(
			'label'    => __('Menu Text Color', 'taleem'),
			'section'  => 'colors',
			'settings' => 'taleem_theme_options[menu_text_color]',
		)));					
											
		
	}
	
	add_action( 'customize_register', 'taleem_customize_register' );