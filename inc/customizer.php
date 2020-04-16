<?php
/**
 * Bloggy Theme Customizer
 *
 * @package Bloggy
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bloggy_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'bloggy_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'bloggy_customize_partial_blogdescription',
			)
		);
	}

	// Additional Theme Settings.

	$wp_customize->add_setting( 
		'main_color', 
		array(
			'default' => 'yellow',
		) 
	);

	$wp_customize->add_control( 
		'main_color', 
		array(
			'type'            => 'select',
			'priority'        => 10, // Within the section.
			'section'         => 'colors', // Required, core or custom.
			'label'           => __( 'Main Color', 'bloggy' ),
			'description'     => __( 'Choose theme main color.', 'bloggy' ),
			'active_callback' => 'is_front_page',
			'choices'         => array(
				'yellow' => __( 'Yellow', 'bloggy' ),
				'red'    => __( 'Red', 'bloggy' ),
				'blue'   => __( 'Blue', 'bloggy' ),
				'green'  => __( 'Green', 'bloggy' ),
			),
		)
	);
}
add_action( 'customize_register', 'bloggy_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function bloggy_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function bloggy_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bloggy_customize_preview_js() {
	wp_enqueue_script( 'bloggy-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'bloggy_customize_preview_js' );
