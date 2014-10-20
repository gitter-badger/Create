<?php

if(!class_exists('CreateCustomizer')):
class CreateCustomizer {

    public $css_maker;

    var $path,
        $section_path,
        $panels,
        $sections;

    function __construct() {
        // Path setup so we know where we are.
        $this->path = get_template_directory() . '/functions/customizer/';
        $this->section_path = $this->path . 'sections/';

        require_once($path . 'helpers-css.php');
        $this->css_maker = new CSSMaker;
        add_action('create_css', array($this->css_maker, 'add_rules'));

        // Build the sections details and information here.
        $this->sections = array(
            'navbar_colors' => array('title' => __('Navbar Colors', 'create'), 'priority' => 35.10, 'panel' => 'header', 'path' => $this->section_path),
            'navbar_layout' => array('title' => __('Navbar Layout', 'create'), 'priority' => 35.12, 'panel' => 'header', 'path' => $this->section_path)
        );

        // Build the panels details and information here.
        $this->panels = array(
            'general' => array('title' => __('General', 'create'), 'priority' => 5.10),
            'typography' => array('title' => __('Typography', 'create'), 'priority' => 5.20),
            'color_scheme' => array('title' => __('Color Scheme', 'create'), 'priority' => 5.30),
            'header' => array('title' => __('Header', 'create'), 'priority' => 5.40),
            'content_layout' => array('title' => __('Content & Layout', 'create'), 'priority' => 5.50),
            'footer' => array('title' => __('Footer', 'create'), 'priority' => 5.60)
        );

        // Add methods to customize_register
        // if($this->panel_support()) {
        //     add_action('customize_register', array($this, 'add_panels'));
        // }

        add_action('customize_register', array($this, 'add_panels'));
        add_action('customize_register', array($this, 'add_sections'));
        add_action('wp_head', array($this, 'display_css'), 11);
    }

    function panel_support() {
        return ( class_exists( 'WP_Customize_Manager' ) && method_exists( 'WP_Customize_Manager', 'add_panel' ) ) || function_exists( 'wp_validate_boolean' );
    }

    public function add_panels() {
        global $wp_customize;
        $panels = $this->panels;

        foreach($panels as $panel => $data) {
            $wp_customize->add_panel($panel,
                array(
                    'title' => $data['title'],
                    'priority' => $data['priority']
                )
            );
        }

        // Rename and setup the existing panels.
        if ( ! isset( $wp_customize->get_panel( 'widgets' )->title ) ) {
            $wp_customize->add_panel( 'widgets' );
        }

        $wp_customize->get_panel('widgets')->priority = 5.70;
        $wp_customize->get_panel('widgets')->title = __('Sidebars & Widgets', 'create');
    }

    public function add_sections() {
        global $wp_customize;
        $sections = $this->sections;

        foreach($sections as $section => $data) {
            $file = trailingslashit($data['path']) . $section . '.php';
            if(file_exists($file)) {
                require_once($file);
                $section_callback = 'create_customizer_' . $section;
                if(function_exists($section_callback)) {
                    $section_id = 'create_' . $section;
                    $wp_customize->add_section(
                        $section_id,
                        array(
                            'title' => $data['title'],
                            'priority' => $data['priority'],
                            'panel' => $data['panel']
                        )
                    );

                    call_user_func_array($section_callback, array($wp_customize, $section_id));
                }
            }
        }

        $wp_customize->get_section('title_tagline')->panel = 'general';
        $wp_customize->get_section('background_image')->panel = 'general';
        $wp_customize->get_section('static_front_page')->panel = 'general';
        $wp_customize->get_section('nav')->panel = 'header';
        $wp_customize->remove_section('colors');
    }

    public function add_transport() {}

    public function display_css() {
        do_action('create_css');
        $css = $this->css_maker->build();

        if(!empty($css)) {
            echo '<!-- Create Custom CSS -->';
            echo '<style type="text/css" id="create-custom-css">';
            echo $css;
            echo '</style>';
            echo '<!-- End Create Custom CSS -->';
        }
    }

}
endif;

new CreateCustomizer;