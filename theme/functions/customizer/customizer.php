<?php

if(!class_exists('CreateCustomizer')):
endif;


function create_customize_register() {
    global $wp_customize;
    $path = get_template_directory() . '/functions/customizer/';
    $section_path = $path . 'sections/';

    $sections = array(
        'navbar' => array('title' => __('Navbar', 'create'), 'priority' => 35.10, 'path' => $section_path)
    );

    foreach ($sections as $section => $data) {
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
                        'panel' => 'navbar_options'
                    )
                );

                call_user_func_array($section_callback, 
                    array(
                        $wp_customize,
                        $section_id
                    )
                );
            }
        }
    }
}

function create_customize_panels() {
    global $wp_customize;

    $wp_customize->add_panel('navbar_options', array(
        'title' => __('Navbar Options', 'create'),
        'priority' => 20
    ));

    if ( ! isset( $wp_customize->get_panel( 'widgets' )->priority ) ) {
        $wp_customize->add_panel( 'widgets' );
    }

    $wp_customize->get_panel( 'widgets' )->priority = 500;
    $wp_customize->get_panel( 'widgets' )->title = __( 'Sidebars & Widgets', 'create' );
}

add_action('customize_register', 'create_customize_panels');
add_action('customize_register', 'create_customize_register');

// if(!class_exists('CreateCustomizer')):
// class CreateCustomizer {

//     public $path;

//     // Get everything setup.
//     function __construct($wp_customize) {
//         $this->path = get_template_directory() . '/functions/customizer/';
//         add_action('customize_register', array($this, 'register', $wp_customize), 30);
//     }

//     public function register($wp_customize) {
//         require_once($this->path . 'sections/background.php');
//         add_action('customize_register', array($this, 'create_sections', $wp_customize), 30);
//     }

//     public function create_sections($wp_customize) {
//         $section_path = $this->path . 'sections/';
//         $sections = array(
//             'navbar' => array('title' => __('Navbar', 'create'), 'priority' => 35.10, 'path' => $section_path)
//         );

//         $wp_customize->add_section(
//             'navbar',
//             array(
//                 'title' => 'Navbar',
//                 'priority' => 30.50
//             )
//         );

//         foreach ($sections as $section => $data) {
//             $file = trailingslashit($data['path']) . $section . '.php';
//             if (file_exists($file)) {
//                 require_once($file);
//                 $section_cb = 'create_customizer_navbar';
//                 if(function_exists($section_cb)) {
//                     $section_id = 'create_customizer_navbar';

//                     $wp_customize->add_section(
//                         $section_id,
//                         array(
//                             'title' => $data['title'],
//                             'priority' => $data['priority'],
//                         )
//                     );
//                 }
//             }
//         }
//     }

// }
// endif;

// $customizer = new CreateCustomizer($wp_customize);