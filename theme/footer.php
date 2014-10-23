<?php

$layout = get_theme_mod('create_footer_layout-layout');
$text_content = get_theme_mod('create_footer_layout-text-content');

?>
		</div> <!-- #content -->
	</div>

	<div class="container">
		<footer id="colophon" class="site-footer" role="contentinfo">

			<?php if($layout === '' || $layout === 'nav-left'): ?>
			<div class="row">
				<div class="col-md-6">
					<?php
					if(has_nav_menu('footer')):
						wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => 'footer-menu'));
					endif;
					?>
				</div>
				<div class="col-md-6">
					<?php echo '<span class="text-content">' . $text_content . '</span>'; ?>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'create' ), 'Create', '<a href="http://thecreate.com" rel="designer">Thecreate</a>' ); ?>
				</div>
			</div>
			<?php elseif($layout === 'no-nav'): ?>
			<div class="row">
				<div class="col-md-6 col-md-push-6">
					<?php echo '<span class="text-content">' . $text_content . '</span>'; ?>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'create' ), 'Create', '<a href="http://thecreate.com" rel="designer">Thecreate</a>' ); ?>
				</div>
			</div>
			<?php elseif($layout === 'no-text'): ?>
			<div class="col-md-6">
				<?php
				if(has_nav_menu('footer')):
					wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => 'footer-menu'));
				endif;
				?>
			</div>
			<?php elseif($layout === 'nav-right'): ?>
			<div class="row">
				<div class="col-md-6">
					<?php echo '<span class="text-content">' . $text_content . '</span>'; ?>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'create' ), 'Create', '<a href="http://thecreate.com" rel="designer">Thecreate</a>' ); ?>
				</div>
				<div class="col-md-6">
					<?php
					if(has_nav_menu('footer')):
						wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => 'footer-menu'));
					endif;
					?>
				</div>
			</div>
			<?php endif; ?>
		</footer><!-- #colophon -->
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>