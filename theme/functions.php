<?php
/**
 * Create functions and definitions
 *
 * @package Create
 */

/**
 * Custom template tags for this theme.
 */ 
require get_template_directory() . '/functions/setup.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/functions/scripts.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/functions/widget-areas.php';

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/functions/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/functions/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/functions/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/functions/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/functions/jetpack.php';

/**
 * Add custom nav
 */
require get_template_directory() . '/functions/walker.php';

//comppile later
function create_body_container() {
	echo 'container';
}

//add walker support
function is_element_empty($element) {
  $element = trim($element);
  return !empty($element);
 }