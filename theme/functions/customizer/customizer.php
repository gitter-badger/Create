<?php

if(!class_exists('CreateCustomizer')):
class CreateCustomizer {

    var $path,
        $section_path,
        $panels,
        $sections;

    function __construct() {
        // Path setup so we know where we are.
        $this->path = get_template_directory() . '/functions/customizer/';
        $this->section_path = $this->path . 'sections/';

        // Build the sections details and information here.
        $this->sections = array(
            'navbar' => array('title' => __('Navbar', 'create'), 'priority' => 35.10, 'path' => $this->section_path),
        );

        // Build the panels details and information here.
        $this->panels = array(
            ''
        );

        // Add methods to customize_register
        if($this->panel_support()) {
            add_action('customize_register', array($this, 'add_panels'));
        }

        add_action('customize_register', array($this, 'add_sections'));
    }

    function panel_support() {
        return ( class_exists( 'WP_Customize_Manager' ) && method_exists( 'WP_Customize_Manager', 'add_panel' ) ) || function_exists( 'wp_validate_boolean' );
    }

    public function add_panels() {
        global $wp_customize;
        $panels = array();

        foreach($panels as $panel => $data) {
        }

        // Rename and setup the existing panels.
        if ( ! isset( $wp_customize->get_panel( 'widgets' )->title ) ) {
            $wp_customize->add_panel( 'widgets' );
        }

        $wp_customize->get_panel( 'widgets' )->title = __( 'Sidebars & Widgets', 'make' );
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
                            'priority' => $data['priority']
                        )
                    );

                    call_user_func_array($section_callback, array($wp_customize, $section_id));
                }
            }
        }
    }

    public function add_transport() {}

}
endif;

new CreateCustomizer;

// if(!class_exists('CreateCustomizer')):
// class CreateCustomizer {

//     public $prefixer;
//     public $path;
//     public $section_path;

//     function __construct() {
//         $this->prefixer = 'create_';
//         $this->path     = get_template_directory() . '/functions/customizer/';
//         $this->section_path = $this->path . 'sections/';

//         if($this->panel_support()) {
//             add_action('customize_register', array($this, 'add_panels'));
//         }

//         add_action('customize_register', array($this, 'add_sections'));
//     }

//     /**
//      * Sets up the panel information and applies filter to $panels.
//      * 
//      * @return array
//      */
//     public function get_panels() {
//         $panels = array(
//             'navbar' => array(
//                 'title'  => __('Header & Navigation', 'create'),
//                 'description' => __('Change the look of your header and navigation.', 'create'),
//                 'priority' => 100
//             )
//         );

//         return apply_filters('create_customizer_panels', $panels);
//     }

//     /**
//      * Sets up the section information and applies filter to $sections.
//      * @return array
//      */
//     public function get_sections() {
//         $sections = array(
//             'navbar' => array(
//                 'title' => __('Navbar', 'create'),
//                 'description' => __('Navigation bar settings.', 'create'),
//                 'panel' => 'navbar',
//                 'path'  => $this->section_path
//             ),

//             'header' => array(
//                 'title' => __('Header', 'create'),
//                 'description' => __('Header colors and settings.', 'create'),
//                 'panel' => 'navbar',
//                 'path'  => $this->section_path
//             )
//         );

//         return apply_filters('create_customizer_sections', $sections);
//     }

//     /**
//      * Creates the panels.
//      */
//     public function add_panels() {
//         global $wp_customize;
//         $panels = $this->get_panels();

//         foreach ($panels as $panel => $data) {
//             $panel_id = $this->prefixer . $panel;
//             $wp_customize->add_panel(
//                 $panel_id,
//                 array(
//                     'title' => $data['title'],
//                     'description' => $data['description'],
//                     'priority' => $data['priority']
//                 )
//             );
//         }
//     }

//     /**
//      * Creates the sections.
//      */
//     public function add_sections() {
//         global $wp_customize;
//         $sections = $this->get_sections();

//         foreach ($sections as $section => $data) {
//             $section_id = $this->prefixer . (isset($data['panel']) ? "{$data['panel']}_" : false) . $section;
//             $section_file = trailingslashit($data['path']) . $section . '.php';
//             $section_callback = $this->prefixer . 'customizer_' . $section;
//             if(file_exists($section_file)) {
//                 require_once($section_file);
//                 if(function_exists($section_callback)) {
//                     $wp_customize->add_section(
//                         $section_id,
//                         array(
//                             'title' => $data['title'],
//                             'priority' => $data['priority'],
//                             'panel' => $data['panel']
//                         )
//                     );

//                     call_user_func_array($section_callback, array(
//                         $wp_customize,
//                         $section_id
//                     ));

//                     // if(isset($data['panel'])) {
//                     //     $wp_customize->get_section($section_id)->panel = $data['panel'];
//                     // }

//                     // if(isset($data['description'])) {
//                     //     $wp_customize->get_section($section_id)->description = $data['description'];
//                     // }
//                 }
//             }
//         }
//     }

//     public function add_section_options($section_id) {}

//     /**
//      * Checks if the current WP installation supports panels
//      * in the customizer.
//      * 
//      * @return boolean
//      */
//     function panel_support() {
//         return(class_exists('WP_Customize_Manager') && method_exists('WP_Customize_Manager', 'add_panel')) || function_exists('wp_validate_boolean');
//     }

// }
// endif;

// new CreateCustomizer;

// add_action('customize_register', array('CreateCustomizer', 'init'));

// function create_customize_register() {
//     global $wp_customize;
//     $path = get_template_directory() . '/functions/customizer/';
//     $section_path = $path . 'sections/';

    // $sections = array(
    //     'navbar' => array('title' => __('Navbar', 'create'), 'priority' => 35.10, 'path' => $section_path)
    // );

//     foreach ($sections as $section => $data) {
//         $file = trailingslashit($data['path']) . $section . '.php';
//         if(file_exists($file)) {
//             require_once($file);
//             $section_callback = 'create_customizer_' . $section;
//             if(function_exists($section_callback)) {
//                 $section_id = 'create_' . $section;

//                 $wp_customize->add_section(
//                     $section_id,
//                     array(
//                         'title' => $data['title'],
//                         'priority' => $data['priority'],
//                         'panel' => 'navbar_options'
//                     )
//                 );

//                 call_user_func_array($section_callback, 
//                     array(
//                         $wp_customize,
//                         $section_id
//                     )
//                 );
//             }
//         }

//     }
// }

// function create_customize_panels() {
//     global $wp_customize;

//     $wp_customize->add_panel('navbar_options', array(
//         'title' => __('Navbar Options', 'create'),
//         'priority' => 20
//     ));

//     if ( ! isset( $wp_customize->get_panel( 'widgets' )->priority ) ) {
//         $wp_customize->add_panel( 'widgets' );
//     }

//     $wp_customize->get_panel( 'widgets' )->priority = 500;
//     $wp_customize->get_panel( 'widgets' )->title = __( 'Sidebars & Widgets', 'create' );
// }

// add_action('customize_register', 'create_customize_panels');
// add_action('customize_register', 'create_customize_register');