<?php

if(!function_exists('create_customizer_navbar')):
function create_customizer_navbar($wp_customize, $section) {
	// Basic Navbar color settings.
	// Primary Link color.
	$wp_customize->add_setting('navbar-link-primary',
		array('default' => '#EEEEEE', 'type' => 'theme_mod')
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'create_navbar-link-primary',
			array(
				'settings' => 'navbar-link-primary',
				'section' => $section,
				'label' => __('Primary Link Color', 'create'),
				'priority' => 30.456
			)
		)
	);
}
endif;