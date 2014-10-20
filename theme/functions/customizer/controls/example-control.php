<?php

/**
 * Just the basics of creating a custom control with
 * the WP_Customizer.
 *
 * Basic example and real-live Color control example.
 */


if(!class_exists('Create_Customize_Misc_Control')):
class Create_Customize_Misc_Control extends WP_Customize_Control {

    public $settings = 'blogname';

    public $setting  = 'default';

    public $description = '';

    public $group = '';

    public function render_content() {
        // render the control html here.
    }

}
endif;


if(!class_exists('Create_Customize_Color_Control')):
class Create_Customize_Color_Control extends WP_Customize_Control {

    public $type = 'color';
    public $statuses;

    public function __contruct($manager, $id, $args = array()) {
        $this->statuses = array('' => __('Default'));
        parent::__construct($manager, $id, $args);
    }

    public function enqueue() {
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');
    }

    public function render_content() {
        $this_default = $this->setting->default;
        $default_attr = '';

        if($this_default) {
            if(false === strpos($this_default, '#'))
                $this_default = '#' . $this_default;
            $default_attr = ' data-default-color="' . esc_attr($this_default) . '"';
        }
    }

}
endif;