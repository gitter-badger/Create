<?php

if(!function_exists('create_customizer_navbar')):

function create_customizer_navbar() {
    global $wp_customize;
    
    $section = $wp_customize->get_section('navbar');
}

endif;

add_action('customize_register', 'create_customizer_navbar');