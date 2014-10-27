<?php
/**
 * Create functions and definitions
 *
 * @package Create
 */

// Setup
require get_template_directory() . '/functions/setup.php';

// Add scripts
require get_template_directory() . '/functions/scripts.php';

// Create widget areas
require get_template_directory() . '/functions/widget-areas.php';

// Custom template tags
require get_template_directory() . '/functions/template-tags.php';

// Extra things
require get_template_directory() . '/functions/extras.php';

// Add jetpack support
require get_template_directory() . '/functions/jetpack.php';

// WP Nav Walker for bootstrap
require get_template_directory() . '/functions/walker.php';

// WP Customizer setup
// require get_template_directory() . '/functions/customizer/customizer.php';
// new CreateCustomizer;

// WP Meta Boxes
require get_template_directory() . '/functions/blox/blox.php';
new Blox;

function create_body_container() {
    echo 'container';
}