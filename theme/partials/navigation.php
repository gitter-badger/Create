<?php 

$nav_layout = get_theme_mod('create_navbar_layout-layout');

?>

<?php echo ($nav_layout !== 'navbar-static-top' ? '<div class="container">' : ''); ?>
  
  <header class="navbar navbar-default <?php echo $nav_layout; ?>" role="navigation">
    <div class="<?php echo ($nav_layout == 'navbar-static-top' ? 'container' : 'container-fluid'); ?>">
      <div class="navbar-header">
        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" type="button">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand"><?php bloginfo('name'); ?></a>
      </div>

      <nav class="collapse navbar-collapse" role="navigation">
        <?php
        if(has_nav_menu('primary')):
          wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav navbar-nav'));
        endif;
        ?>
      </nav>
    </div>
  </header>

<?php echo ($nav_layout !== 'navbar-static-top' ? '</div>' : ''); ?>