<?php

if(!class_exists('CreateCustomizer')):
class CreateCustomizer {

    public $css_maker;
    public $path;
    public $creator;

    function __construct() {
        // Path setup so we know where we are.
        $this->path = get_template_directory() . '/functions/customizer/';
        $this->creator = $this->path . 'creator.json';

        require_once($path . 'helpers-css.php');
        $this->css_maker = new CSSMaker;
        add_action('create_css', array($this->css_maker, 'add_rules'));

        add_action('customize_register', array($this, 'the_customizer'));
        add_action('wp_head', array($this, 'display_css'), 11);

        if(is_customize_preview()) {
            add_action('wp_footer', array($this, 'live_preview_script'), 21);
        }
    }

    public function the_customizer() {
        global $wp_customize;
        $creator = file_get_contents($this->creator);
        $panels = json_decode($creator, true);
        $prefix = 'create_';

        foreach ($panels as $panel => $data) {
            $panel_id = $prefix . $panel;
            $wp_customize->add_panel($panel_id, array(
                'title' => $data['title'],
                'description' => $data['description'],
                'priority' => $data['priority']
            ));

            $sections = $data['sections'];
            foreach ($sections as $section => $data) {
                $section_id = $panel_id . '_' . $section;
                $wp_customize->add_section($section_id, array(
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'priority' => $data['priority'],
                    'panel' => $panel_id
                ));

                $settings = $data['settings'];
                foreach ($settings as $setting => $data) {
                    $setting_id = $section_id . '-' . $setting;

                    $transport = 'refresh';
                    if($data['transport']) {
                        $transport = $data['transport'];
                    }

                    $wp_customize->add_setting($setting_id, array(
                        'default' => $data['default'],
                        'type' => $data['type'],
                        'transport' => $transport
                    ));

                    $control_id = $section_id . '_' . $setting;
                    $control = $data['control'];
                    $this->create_control($control_id, $data, $setting_id, $section_id, $wp_customize);
                }
            }
        }
    }

    public function cleanup($wp_customize) {
        $wp_customize->get_panel('widgets')->priority = 5.70;
        $wp_customize->get_panel('widgets')->title = __("Sidebars & Widgets", 'create');
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

            case 'number':
                $wp_customize->add_control(
                    new Customize_Number_Control(
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

            case 'textarea':
                $wp_customize->add_control(
                    new Customize_TextArea_Control(
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

    // public function add_sections() {
    //     global $wp_customize;
    //     $sections = $this->sections;

    //     foreach($sections as $section => $data) {
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
    //                         'panel' => $data['panel']
    //                     )
    //                 );

    //                 call_user_func_array($section_callback, array($wp_customize, $section_id));
    //             }
    //         }
    //     }

    //     $wp_customize->get_section('title_tagline')->panel = 'general';
    //     $wp_customize->get_section('background_image')->panel = 'general';
    //     $wp_customize->get_section('static_front_page')->panel = 'general';
    //     $wp_customize->get_section('nav')->panel = 'header';
    //     $wp_customize->remove_section('colors');
    // }

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

    public function live_preview_script() {
        $mods = get_theme_mods();
        $creator = file_get_contents($this->creator);
        $panels = json_decode($creator, true);

        echo '<script type="text/javascript"> (function($) {';
        foreach ($mods as $mod => $data) {
            $name = explode('_', $mod);
            $name_section = explode('-', trim($name[2]));
            $n_section = array_slice($name_section, 1);
            $panel = $name[1];
            $section = $name_section[0];
            $setting = implode("-", $n_section);

            $setting_string = "create_{$panel}_{$section}-{$setting}";
            $setting_array = $panels[$panel]['sections'][$section]['settings'][$setting];
            if($setting_array) {
                $css = $setting_array['changes'];
                if($css) {
                    $theme_mod = get_theme_mod("create_{$panel}_{$section}-{$setting}");
                    $selectors = "";
                    foreach ($css['selectors'] as $selector) {
                        $selectors .= $selector . ' ';
                    }
                    $property = $css['property'];

                    ?>

                    wp.customize('<?php echo $setting_string; ?>', function(value) {
                        value.bind(function(to) {
                            $('<?php echo $selectors; ?>').css('<?php echo $css["property"]; ?>', to);
                        });
                    });

                    <?
                }

            }
        }
        echo '})(jQuery)</script>';
    }

}
endif;

new CreateCustomizer;