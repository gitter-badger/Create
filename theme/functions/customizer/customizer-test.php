<?php

class CreateCustomizer {

    public $css_maker;
    public $path;
    public $creator;

    public function __construct() {
        $this->path = get_template_directory() . '/functions/customizer/';
        $this->creator = $this->path . 'creator.json';

        add_action('customize_register', array($this, 'the_customizer'));
    }

    public function the_customizer() {
        global $wp_customize;
        $creator = file_get_contents($this->creator);
        $panels = json_decode($creator, true);
        $prefix = 'create_';

        foreach ($panels as $panel => $data) {
            // Create the panels
            $panel_id = $prefix . $panel;
            $wp_customize->add_panel($panel_id, array(
                'title' => $data['title'],
                'description' => $data['description'],
                'priority' => $data['priority']
            ));

            $sections = $data['sections'];
            foreach ($sections as $section => $data) {
                // Create the sections of the panels.
                $section_id = $panel_id . '_' . $section;
                $wp_customize->add_section($section_id, array(
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'priority' => $data['priority'],
                    'panel' => $panel_id
                ));

                $settings = $data['settings'];
                foreach ($settings as $setting => $data) {
                    // Create the settings.
                    $setting_id = $section_id . '-' . $setting;
                    $wp_customize->add_setting($setting_id, array(
                        'default' => $data['default'],
                        'type' => $data['type']
                    ));

                    $control_id = $section_id . '_' . $setting;
                    $control = $data['control'];
                    $this->create_control($control_id, $control, $setting_id, $section_id, $wp_customize);
                    // $wp_customize->add_control($control_id, array(
                    //     'label' => $control['label'],
                    //     'settings' => $setting_id,
                    //     'section' => $section_id,
                    //     'type' => $control['type']
                    // ));
                }
            }
        }

    }

    public function create_control($id, $data, $setting, $section, $wp_customize) {
        require_once('controls.php');
        switch($data['type']) {

            default:
                $wp_customize->add_control($id, array(
                    'label' => $data['label'],
                    'settings' => $setting,
                    'section' => $section,
                    'priority' => $data['priority']
                ));
                break;

            case 'color':
                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize,
                        $id,
                        array(
                            'label' => $data['label'],
                            'settings' => $setting,
                            'section' => $section,
                            'priority' => $data['priority']
                        )
                    )
                );
                break;

            case 'select':
                $wp_customize->add_control($id, array(
                    'label' => $data['label'],
                    'settings' => $setting,
                    'section' => $section,
                    'type' => 'select',
                    'choices' => $data['choices']
                ));
                break;

            case 'radio':
                $wp_customize->add_control($id, array(
                    'label' => $data['label'],
                    'settings' => $setting,
                    'section' => $section,
                    'type' => 'radio',
                    'choices' => $data['choices']
                ));
                break;

            case 'page-dropdown':
                $wp_customize->add_control($id, array(
                    'label' => $data['label'],
                    'settings' => $setting,
                    'section' => $section,
                    'type' => 'page-dropdown'
                ));
                break;

            case 'checkbox':
                $wp_customize->add_control($id, array(
                    'label' => $data['label'],
                    'settings' => $setting,
                    'section' => $section,
                    'type' => $checkbox
                ));
                break;

            case 'image':
                $wp_customize->add_control(
                    new Customize_Image_Control(
                        $wp_customize,
                        $id,
                        array(
                            'label' => $data['label'],
                            'settings' => $setting,
                            'section' => $section,
                            'priority' => $data['priority']
                        )
                    )
                );
                break; 
        }
    }

}

new CreateCustomizer;