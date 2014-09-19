<?php
/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. Application
 * 2. Theme Override
 *
 * Enqueue scripts in the following order:
 * 1. jQuery via Google CDN
 * 2. Modernizer
 * 3. Bootstrap
 * 4. Application
 *
 */
function create_scripts() {
	//STYLESHEETS
	wp_enqueue_style( 'app_css', get_template_directory_uri() . '/assets/css/app.min.css' );
	wp_enqueue_style( 'create_css', get_stylesheet_uri() );

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
	wp_enqueue_script('modernizr_js', get_template_directory_uri() . '/assets/js/modernizer-2.8.3/modernizr.min.js', array(), null, false);
	wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/assets/js/bootstrap-3.2.0/bootstrap.min.js', array(), null, true);
	wp_enqueue_script('create_js', get_template_directory_uri() . '/assets/js/app.js', array(), null, true);

}
add_action('wp_enqueue_scripts', 'create_scripts', 100);

function create_admin_scripts() {
        wp_enqueue_style( 'create_admin_css' , get_template_directory_uri() . 'assets/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'create_admin_scripts' );