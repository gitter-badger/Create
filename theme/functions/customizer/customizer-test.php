<?php

class CreateCustomizer {

    public $css_maker;
    public $path;
    public $creator;

    public function __construct() {
        $this->path = get_template_directory() . '/functions/customizer/';
        $this->creator = $this->path . 'creator.json';
    }

    public function makeCustomizer() {
        $creator = file_get_contents($this->creator);
        $json = json_decode($creator);
        $prefix = 'create_';

        $panels   = $json['panels'];
        $sections = $json['sections'];
        $settings = $json['settings'];
        $controls = $json['controls'];

        foreach ($panels as $panel => $d1) {
            $panel_id = "{$prefix}{$panel}";
            $wp_customize->add_panel($panel_id, $d1);
            foreach ($sections as $section => $d2) {
                $section_id = "{$panel_id}_{$section}"
                $wp_customize->add_section($section_id, $d2);
                foreach ($settings as $setting => $d3) {
                    # code...
                }
                foreach ($controls as $control => $d4) {
                    # code...
                }
            }
        }
    }


}