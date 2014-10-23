<?php
/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. Application
 *
 * Enqueue scripts in the following order:
 * 1. jQuery via Google CDN
 * 2. Theme
 *
 */

function create_scripts() {

    // Stylesheets
    wp_enqueue_style('app_css', get_template_directory_uri() . '/assets/css/app.min.css');

    // Scripts
    if(!is_admin()){
        wp_deregister_script('jquery');
        wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', false, null, true);
        wp_enqueue_script('jquery');
    }

    if(is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('create_js', get_template_directory_uri() . '/assets/js/app.min.js', array(), null, true);
    wp_enqueue_script('customize', get_template_directory_uri() . '/assets/js/customizer/wp-customizer.js', array(), null, true);

}
add_action('wp_enqueue_scripts', 'create_scripts', 100);

function create_admin_scripts() {
    wp_enqueue_style('create_admin_css', get_template_directory_uri() . '/assets/css/admin.min.css');
}
add_action('admin_enqueue_scripts', 'create_admin_scripts');

function add_conditional_scripts() {
    echo '<!--[if lt IE 9]>';
    echo '<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>';
    echo '<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>';
    echo '<![endif]-->';
}
add_action('wp_head', 'add_conditional_scripts', 101);