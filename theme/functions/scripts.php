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
	//STYLESHEETS
	//Compiled and Minified Theme Styles
	wp_enqueue_style( 'app_css', get_template_directory_uri() . '/assets/css/app.min.css' );

	//SCRIPTS
	if (!is_admin()) {
		//Grab Google CDN's latest jQuery with a protocol relative URL.
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', ( '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js' ), false, null, true );
		wp_enqueue_script( 'jquery' );
	}
	if (is_single() && comments_open() && get_option('thread_comments')) {
		//Loads the default WordPress comment reply script if needed.
		wp_enqueue_script('comment-reply');
	}
	//Compiled and Minified Theme Script
	wp_enqueue_script('create_js', get_template_directory_uri() . '/assets/js/app.min.js', array(), null, true);

}
add_action('wp_enqueue_scripts', 'create_scripts', 100);

function create_admin_scripts() {
  //wp_enqueue_style( 'create_admin_css' , get_template_directory_uri() . '/assets/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'create_admin_scripts' );

function add_conditional_scripts() {
	echo '<!--[if lt IE 9]>';
	echo '<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>';
	echo '<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>';
	echo '<![endif]-->';
}
add_action('wp_head', 'add_conditional_scripts', 101);