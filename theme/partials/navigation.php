<?php
$nav_width  = get_theme_mod('create_navbar_layout-width');
$nav_layout = get_theme_mod('create_navbar_layout-layout');
$nav_pos    = get_theme_mod('create_navbar_layout-nav-pos');
$logo       = get_theme_mod('create_navbar_layout-logo');
?>

<?php

if($nav_layout !== 'navbar-static-top') {
  echo '<div class="container">';
}elseif(($nav_layout === 'navbar-static-top' || $nav_layout === 'navbar-fixed-top' || $nav_layout === 'navbar-fixed-bottom') && ($nav_width === 'full')){
  echo '<div class="container-full">';
}else {
  echo '<div>';
}

?>

  <header class="navbar navbar-default <?php echo $nav_layout; ?>" role="navigation">
      <?php if ($nav_width !== 'full'): ?>
      <div class="<?php echo ($nav_layout == 'navbar-static-top' ? 'container' : 'container-fluid'); ?>">
      <?php endif ?>
      <div class="navbar-header">
        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" type="button">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <?php if($logo === ""): ?>
          <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand"><?php bloginfo('name'); ?></a>
        <?php else: ?>
          <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><img src="<?php echo $logo; ?>"></a>
        <?php endif; ?>
      </div>

      <nav class="collapse navbar-collapse" role="navigation">
      <?php

      if(($nav_layout === 'navbar-static-top' || $nav_layout === 'navbar-fixed-top' || $nav_layout === 'navbar-fixed-bottom') && ($nav_width === 'full')){
        echo '<div class="container-fluid">';
      }else {
        echo '<div>';
      }
      ?>
        <?php
        if(has_nav_menu('primary')):
          $nav_class = 'nav navbar-nav ' . $nav_pos;
          wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => $nav_class));
        endif;
        ?>

      </div>
      </nav>
    <?php if ($nav_width !== 'full'): ?>
    </div>
    <?php endif; ?>
  </header>

</div>

<?php echo ($nav_layout !== 'navbar-static-top' ? '</div>' : ''); ?>