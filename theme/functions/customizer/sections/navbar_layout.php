<?php

function create_customizer_navbar_layout($wp_customize, $section_id) {

    $sprefixer = $section_id . '-';
    $cprefixer = $section_id . '_';

    $wp_customize->add_setting(
        $sprefixer . 'layout',
        array(
            'default' => '',
            'type' => 'theme_mod'
        )
    );

    $wp_customize->add_control(
        $cprefixer . 'layout',
        array(
            'label' => __('Layout', 'create'),
            'section' => $section_id,
            'settings' => $sprefixer . 'layout',
            'type' => 'select',
            'choices' => array(
                '' => __('Default', 'create'),
                'navbar-fixed-top' => __('Fixed Top', 'create'),
                'navbar-fixed-bottom' => __('Fixed Bottom', 'create'),
                'navbar-static-top' => __('Static Top', 'create'),
                'navbar-inverse' => __('Inverse', 'create')
            )
        )
    );

    $wp_customize->add_setting(
        $sprefixer . 'border-radius',
        array(
            'default' => '4px',
            'type' => 'theme_mod'
        )
    );

    $wp_customize->add_control(
        $cprefixer . 'border_radius',
        array(
            'label' => __('Border Radius', 'create'),
            'description' => __('4px is the default.', 'create'),
            'section' => $section_id,
            'settings' => $sprefixer . 'border-radius',
            'type' => 'text'
        )
    );

}