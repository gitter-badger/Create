<?php 
if(!class_exists('CreateCustomizer')):
class CreateCustomizer {

    public $prefixer;
    public $path;
    public $section_path;

    function __construct() {
        $this->prefixer = 'create_';
        $this->path     = get_template_directory() . '/functions/customizer/';
        $this->section_path = $this->path . 'sections/';

        if($this->panel_support()) {
            add_action('customize_register', array($this, 'add_panels'));
        }

        add_action('customize_register', array($this, 'add_sections'));
    }

    /**
     * Sets up the panel information and applies filter to $panels.
     * 
     * @return array
     */
    public function get_panels() {
        $panels = array(
            'navigation' => array(
                'title'  => __('Header & Navigation', 'create'),
                'description' => __('Change the look of your header and navigation.', 'create'),
                'priority' => 100
            ),

            'colors' => array(
                'title' => __('Colors', 'create'),
                'description' => __('Color settings and styles.', 'create'),
                'priority' => 110
            )
        );

        return apply_filters('create_customizer_panels', $panels);
    }

    /**
     * Sets up the section information and applies filter to $sections.
     * @return array
     */
    public function get_sections() {
        $sections = array(
            'navbar' => array(
                'title' => __('Navbar', 'create'),
                'description' => __('Navigation bar settings.', 'create'),
                'panel' => 'navigation',
                'path'  => $this->section_path
            ),

            'header' => array(
                'title' => __('Header', 'create'),
                'description' => __('Header colors and settings.', 'create'),
                'panel' => 'navigation',
                'path'  => $this->section_path
            )
        );

        return apply_filters('create_customizer_sections', $sections);
    }

    /**
     * Creates the panels.
     */
    public function add_panels() {
        global $wp_customize;
        $panels = $this->get_panels();

        foreach ($panels as $panel => $data) {
            $panel_id = $this->prefixer . $panel;
            $wp_customize->add_panel(
                $panel_id,
                array(
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'priority' => $data['priority']
                )
            );
        }
    }

    public function add_sections() {
        global $wp_customize;
        $sections = $this->get_sections();

        foreach ($sections as $section => $data) {
            $section_id = $this->prefixer . (isset($data['panel']) ? "{$data['panel']}_" : false) . $section
            $section_file = trailingslashit($data['path']) . $section . '.php';
            $section_callback = $this->prefixer . 'customizer_' . $section;
            if(file_exists($section_file)) {
                require_once($section_file);
                if(function_exists($section_callback)) {
                    $wp_customize->add_section(
                        $section_id,
                        array(
                            'title' => $data['title'],
                            'priority' => $data['priority']
                        )
                    );

                    call_user_func_array($section_callback, array(
                        $wp_customize,
                        $section_id
                    ));

                    if(isset($data['panel'])) {
                        $wp_customize->get_section($section_id)->panel = $data['panel'];
                    }

                    if(isset($data['description'])) {
                        $wp_customize->get_section($section_id)->description = $data['description'];
                    }
                }
            }
        }
    }

    public function add_section_options($section_id) {}

    /**
     * Checks if the current WP installation supports panels
     * in the customizer.
     * 
     * @return boolean
     */
    function panel_support() {
        return(class_exists('WP_Customize_Manager') && method_exists('WP_Customize_Manager', 'add_panel')) || function_exists('wp_validate_boolean');
    }

}
endif;

new CreateCustomizer;