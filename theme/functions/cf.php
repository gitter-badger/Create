<?php 

if(!class_exists('Fields')):

class Fields {

    function __construct() {
        add_action('init', array($this, 'init'), 1);
    }

    function init() {
        // Creates the post type
        $labels = array(
            'name' => __( 'Field&nbsp;Groups', 'cf' ),
            'singular_name' => __( 'Custom Fields', 'cf' ),
            'add_new' => __( 'Add New' , 'cf' ),
            'add_new_item' => __( 'Add New Field Group' , 'cf' ),
            'edit_item' =>  __( 'Edit Field Group' , 'cf' ),
            'new_item' => __( 'New Field Group' , 'cf' ),
            'view_item' => __('View Field Group', 'cf'),
            'search_items' => __('Search Field Groups', 'cf'),
            'not_found' =>  __('No Field Groups found', 'cf'),
            'not_found_in_trash' => __('No Field Groups found in Trash', 'cf'), 
        );

        register_post_type('cf', array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            '_builtin' =>  false,
            'capability_type' => 'page',
            'hierarchical' => true,
            'rewrite' => false,
            'query_var' => "cf",
            'supports' => array(
                'title',
            ),
            'show_in_menu'  => false,
        ));

        if (is_admin()) {
            add_action('admin_menu', array($this, 'admin_menu'));
        }
    }

    function admin_menu() {
        add_menu_page(__("Custom Fields", 'cf'), __("Custom Fields", 'cf'), 'manage_options', 'edit.php?post_type=cf', false, false, '80');
    }

}

function fields() {
    global $fields;
    if(!isset($fields)) {
        $fields = new Fields();
    }
    return $fields;
}

// Initialize the custom fields class.
fields();

endif;

?>