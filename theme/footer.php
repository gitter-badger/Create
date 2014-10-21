<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Create
 */
?>
		</div> <!-- #content -->
	</div>

	<div class="container">

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="row">
				<div class="col-md-6">
					<?php
					if(has_nav_menu('footer')):
						wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => 'footer-menu'));
					endif;
					?>
				</div>
				<div class="col-md-6">
					<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'create' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'create' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'create' ), 'Create', '<a href="http://thecreate.com" rel="designer">Thecreate</a>' ); ?>
				</div>
			</div>
		</footer>

	</div>

	<!-- <div class="container">
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'create' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'create' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'create' ), 'Create', '<a href="http://thecreate.com" rel="designer">Thecreate</a>' ); ?>
			</div>
		</footer>
	</div> -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
