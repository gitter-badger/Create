<?php
if(!class_exists('CSSMaker')):
class CSSMaker {

    public $data = array();
    public $lend = '';
    public $tab  = '';
    public $path = '';
    public $creator = '';

    function __construct() {
        if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG === true) {
            $this->lend = "\n";
            $this->tab  = "\t";
        }

        $this->path = get_template_directory() . '/functions/customizer/';
        $this->creator = $this->path . 'creator.json';
    }

    /**
     * Creates the CSS string of all rules in array.
     * @return string parsed CSS
     */
    public function build() {
        if(empty($this->data)) {
            return '';
        }

        $n = $this->lend;

        if(isset($this->data['all']) && count($this->data) > 1) {
            $all = array('all' => $this->data['all']);
            unset($this->data['all']);
            $this->data = array_merge($all, $this->data);
        }

        $output = '';

        foreach ($this->data as $query => $ruleset) {
            $t = '';

            if($query !== 'all') {
                $output .= "\n@media " . $query . '{' . $n;
                $t = $this->tab;
            }

            foreach ($ruleset as $rule) {
                $output .= $this->parse_selectors($rule['selectors'], $t) . '{' . $n;
                $output .= $this->parse_declarations($rule['declarations'], $t);
                $output .= $t . '}' . $n;
            }

            if($query !== 'all') {
                $output .= '}' . $n;
            }
        }

        return $output;
    }

    /**
     * Adds CSS sel/properties to the $data array.
     * @param array $data array of rule
     */
    public function add($data) {
        if(!isset($data['selectors']) || !isset($data['declarations'])) return;

        $entry = array();
        $data = apply_filters('create_css_add', $data);

        $entry['selectors'] = array_map('trim', (array) $data['selectors']);
        $entry['selectors'] = array_unique($entry['selectors']);
        $entry['declarations'] = array_map('trim', (array) $data['declarations']);

        if(isset($data['media'])) {
            $media = $data['media'];
        }else{
            $media = 'all';
        }

        if(!isset($this->data[$media]) || !is_array($this->data[$media])) {
            $this->data[$media] = array();
        }

        $match = false;
        foreach ($this->data[$media] as $key => $rule) {
            $diff1 = array_diff($rule['selectors'], $entry['selectors']);
            $diff2 = array_diff($entry['selectors'], $rule['selectors']);
            if(empty($diff1) && empty($diff2)) {
                $match = $key;
                break;
            }
        }

        if($match === false) {
            $this->data[$media][] = $entry;
        }else{
            $this->data[$media][$match]['declarations'] = array_merge($this->data[$media][$match]['declarations'], $entry['declarations']);
        }
    }

    /**
     * Generate CSS of defined selectors in rule.
     * @param  array  $selectors  array of selectors
     * @param  string $tab        tab
     * @return string             parsed output
     */
    public function parse_selectors($selectors, $tab='') {
        $n = $this->lend;
        $output = $tab . implode(",{$n}{$tab}", $selectors);
        return $output;
    }

    /**
     * Generate CSS of defined properties in rule.
     * @param  array  $declarations array of declarations
     * @param  string $tab           tab
     * @return string                parsed output
     */
    public function parse_declarations($declarations, $tab='') {
        $n = $this->lend;
        $t = $this->tab . $tab;

        $output = '';
        foreach ($declarations as $property => $value) {
            $parsed = "{$t}{$property}:{$value};$n";
            $output .= apply_filters('create_parse_declaration', $parsed, $property, $value, $t, $n);
        }

        return apply_filters('create_parse_declrarations', $output, $declarations, $tab);
    }

    /**
     * Adds all custom CSS selectors and declarations to the array.
     * This is all done dynamically based on creator.json.
     */
    public function add_rules() {
        $mods = get_theme_mods();
        $creator = file_get_contents($this->creator);
        $panels = json_decode($creator);
        var_dump($panels);
        var_dump($mods);

        foreach ($mods as $mod => $data) {

            $name = explode('_', $mod);
            $name_setting = explode('-', trim($name[2]));
            $name_setting_slice = array_slice($name_setting, 1);
            $panel = $name[1];
            $section = $name_setting[0];
            $setting = implode('-', $name_setting_slice);

            $setting_array = $panels[$panel]['sections'][$section]['settings'][$setting];
            if($setting_array) {
                $css = $setting_array['changes'];
                $theme_mod = get_theme_mod("create_{$panel}_{$section}-{$setting}");
                $property = $css['property'];

                $this->add(array(
                    'selectors' => $css['selectors'],
                    'declarations' => array(
                        $property => $theme_mod
                    )
                ));
            }

        }
    }

}
endif;

if(!function_exists('create_get_css')):
function create_get_css() {
    return new CSSMaker;
}
endif;

add_action('init', 'create_get_css', 1);