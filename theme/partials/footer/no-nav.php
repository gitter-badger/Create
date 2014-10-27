<?php $text_content = get_theme_mod('create_footer_layout-text-content'); ?>

<div class="row">
    <div class="col-md-6 col-md-push-6">
        <?php echo '<span class="text-content">' . $text_content . '</span>'; ?>
        <span class="sep"> | </span>
        <?php printf( __( 'Theme: %1$s by %2$s.', 'create' ), 'Create', '<a href="http://thecreate.com" rel="designer">Thecreate</a>' ); ?>
    </div>
</div>