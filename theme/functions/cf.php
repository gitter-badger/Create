<?php 

if(!class_exists('Fields')):

class Fields {

    function __construct() {
        add_action('init', array($this, 'init'), 1);
    }

    function init() {
        register_post_type('custom_field', array(
            // 'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            '_builtin' =>  false,
            'capability_type' => 'page',
            'hierarchical' => true,
            'rewrite' => false,
            'query_var' => "custom_field",
            'supports' => array(
                'title',
            ),
            'show_in_menu'  => true,
        ));
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