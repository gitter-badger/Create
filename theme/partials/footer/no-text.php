<div class="col-md-6">
    <?php
    if(has_nav_menu('footer')):
        wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => 'footer-menu'));
    endif;
    ?>
</div>