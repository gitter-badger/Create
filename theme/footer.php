<?php $layout = get_theme_mod('create_footer_layout-layout'); ?>

		</div> <!-- #content -->
	</div>

	<div class="container">
		<footer id="colophon" class="site-footer" role="contentinfo">
			
			<?php if($layout === '' || $layout === 'nav-left'): ?>
				<?php get_template_part('partials/footer/nav-left'); ?>
			<?php elseif($layout === 'no-nav'): ?>
				<?php get_template_part('partials/footer/no-nav'); ?>
			<?php elseif($layout === 'no-text'): ?>
				<?php get_template_part('partials/footer/no-text'); ?>
			<?php elseif($layout === 'nav-right'): ?>
				<?php get_template_part('partials/footer/nav-right'); ?>
			<?php endif; ?>
		</footer><!-- #colophon -->
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>