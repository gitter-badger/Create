<?php

if(!class_exists('CreateCustomizer')):
class CreateCustomizer {

    public $path;

    // Get everything setup.
    function __construct($wp_customize) {
        $this->path = get_template_directory() . '/functions/customizer/';
        add_action('customize_register', array($this, 'register', $wp_customize), 30);
    }

    public function register($wp_customize) {
        require_once($this->path . 'sections/background.php');
        add_action('customize_register', array($this, 'create_sections', $wp_customize), 30);
    }

    public function create_sections($wp_customize) {
        $section_path = $this->path . 'sections/';
        $sections = array(
            'header' => array('title' => __('Header', 'create'), 'priority' => 35, 'path' => $section_path),
            'navbar' => array('title' => __('Navbar', 'create'), 'priority' => 35.10, 'path' => $section_path),
            'components' => array('title' => __('Components', 'create'), 'priority' => 35.12, 'path' => $section_path),
            'colors'    => array('title' => __('Colors', 'create'), 'priority' => 35.14, 'path' => $section_path)
        );

        foreach ($sections as $section => $data) {
            $file = trailingslashit($data['path']) . $section . '.php';
            if (file_exists($file)) {
                require_once($file);
                $section_cb = 'create_customizer_' . $section;
                if(function_exists($section_cb)) {
                    $section_id = 'create_customizer_' . esc_attr($section);

                    $wp_customize->add_section(
                        $section_id,
                        array(
                            'title' => $data['title'],
                            'priority' => $data['priority'],
                        )
                    );

                }
            }
        }
    }

}
endif;

global $wp_customize;
$customizer = new CreateCustomizer($wp_customize);