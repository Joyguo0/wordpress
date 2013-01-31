<section id="secondary" class="widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>		
		<aside id="search" class="widget-container widget_search" role="search">
			<?php get_search_form(); ?>
		</aside>
	
		<aside id="archives" class="widget-container">
			<h3 class="widget-title"><?php _e('Archives'); ?></h3>
			<ul>
				<?php wp_get_archives( 'type=monthly' ); ?>
			</ul>
		</aside>
	<?php endif; ?>
</section>