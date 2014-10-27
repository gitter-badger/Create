<?php 

class Blox {

    public $path;
    public $tpath;

    public function __construct() {
        $this->path = get_template_directory() . '/functions/blox/';
        $this->tpath = $this->path . 'templates/';
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'), 1);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'create-blox',
            __('Blox', 'create'),
            array($this, 'display_blox'),
            'page',
            'normal',
            'high'
        );
    }

    public function display_blox() {
        // Display the base template for blox.
        echo 'TEST';
    }

}