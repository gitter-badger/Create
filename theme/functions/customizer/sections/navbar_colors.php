<?php

function create_customizer_navbar_colors($wp_customize, $section_id) {

	$sprefixer = $section_id . '-';
	$cprefixer = $section_id . '_';

	$wp_customize->add_setting(
		$sprefixer . 'link-primary',
		array(
			'default' => '#777777',
			'type' => 'theme_mod'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$cprefixer . 'link_primary',
			array(
				'settings' => $sprefixer . 'link-primary',
				'section' => $section_id,
				'label' => __('Primary Link Color', 'create'),
				'priority' => 30.456
			)
		)
	);

	$wp_customize->add_setting(
		$sprefixer . 'bg-color',
		array(
			'default' => '#F8F8F8',
			'type' => 'theme_mod'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$cprefixer . 'bg_color',
			array(
				'settings' => $sprefixer . 'bg-color',
				'section' => $section_id,
				'label' => __('Background Color', 'create'),
				'priority' => 30.556
			)
		)
	);

	$wp_customize->add_setting(
		$sprefixer . 'border-color',
		array(
			'default' => '#e7e7e7',
			'type' => 'theme_mod'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$cprefixer . 'border_color',
			array(
				'settings' => $sprefixer . 'border-color',
				'section' => $section_id,
				'label' => __('Border Color', 'create'),
				'priority' => 30.656
			)
		)
	);

	$wp_customize->add_setting(
		$sprefixer . 'link-primary-hover',
		array(
			'default' => '#333',
			'type' => 'theme_mod'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$cprefixer . 'link_primary_hover',
			array(
				'settings' => $sprefixer . 'link-primary-hover',
				'section' => $section_id,
				'label' => __('Link Hover Color', 'create'),
				'priority' => 30.756
			)
		)
	);

	$wp_customize->add_setting(
		$sprefixer . 'link-primary-hover-bg',
		array(
			'default' => '#F8F8F8',
			'type' => 'theme_mod'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$cprefixer . 'link_primary_hover_bg',
			array(
				'settings' => $sprefixer . 'link-primary-hover-bg',
				'section' => $section_id,
				'label' => __('Link Hover BG Color', 'create'),
				'priority' => 30.856
			)
		)
	);

}