<?php

class Customize_Number_Control extends WP_Customize_Control {

    public $type = 'number';

    public function render_content() {
        $this_default = $this->setting->default;
        $default_attr = '';
        ?>
            <label>
                <?php if(!empty($this->label)): ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                <input type="number" value="<?php echo esc_attr($this->value()); ?>" <?php echo $this->link; ?> name="<?php echo $name; ?>">
                <?php if(!empty($this->description)): ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>
            </label>
        <?
    }

}

class Customize_TextArea_Control extends WP_Customize_Control {

    public $type = 'textarea';

    public function render_content() {

        ?>
        <label>
            <?php if(!empty($this->label)): ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php endif; ?>
            <textarea rows="5" style="width:100%;" <?php echo $this->link; ?>><?php echo esc_textarea($this->value()); ?></textarea>
            <?php if(!empty($this->description)): ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
        </label>
        <?
    }

}

class Customize_Image_Control extends WP_Customize_Image_Control {

    public function tab_uploaded() {
        $images = get_posts( array(
            'post_type'  => 'attachment',
            'meta_key'   => '_wp_attachment_context',
            'meta_value' => $this->context,
            'orderby'    => 'none',
            'nopaging'   => true,
        ) );

        ?><div class="uploaded-target"></div><?php

        if ( empty( $images ) ) {
            return;
        }

        foreach ( (array) $images as $image ) {
            $thumbnail_url = wp_get_attachment_image_src( $image->ID, 'medium' );
            $this->print_tab_image( esc_url_raw( $image->guid ), esc_url_raw( $thumbnail_url[0] ) );
        }
    }

}