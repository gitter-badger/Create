<?php

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function create_widgets_init() {

	register_sidebar(array(
		'name'			=> __('Footer 1', 'create'),
		'id'			=> 'footer-1',
		'description'	=> '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'	=> ''
	));

	register_sidebar( array(
		'name'          => __( 'Sidebar', 'create' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'create_widgets_init' );