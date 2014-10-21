<?php


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