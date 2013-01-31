<?php get_header(); ?>
    <section id="primary">
        <div id="content" role="main">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <?php // Slider
				$fpsliderids = ot_get_option('front_page_slider');
				$fpslides = get_posts(array('numberposts'=>-1, 'include'=>$fpsliderids));
				if ($fpslides) {
					echo '<div id="fpslider"><div id="fpslider-in">';
					foreach ($fpslides as $fpslide) { ?>
						<a class="fpslide" href="<?php echo get_permalink($fpslide->ID); ?>">
							<?php $fpslideimg = get_the_post_thumbnail($fpslide->ID,'thumb_590x390');
							$fpslideimg = ($fpslideimg) ? $fpslideimg : '<img src="'.get_template_directory_uri().'/images/default-590x390.png">';
							echo $fpslideimg; ?>
							<h4><?php echo $fpslide->post_title; ?><span>阅读更多</span></h4>
						</a>
					<?php } 
					echo '</div></div>';
				} ?>

				<h3><span class="titlewrap">最新发表<span class="subtitle">RECENT POSTS</span></span></h3>
                <?php //$recent = get_posts(array('numberposts'=>8, 'exclude'=>$fpsliderids)); $cc = 0;
                 $recent = get_posts(array('numberposts'=>14)); $cc = 0;
				foreach ($recent as $rpost) { ?>
                	<?php if ($cc) { $alt = 'even'; $cc = 0; } else { $alt = 'odd'; $cc = 1; } ?>
					<a href="<?php echo get_permalink($rpost->ID); ?>" class="postthumb postthumb-<?php echo $alt; ?>" title="<?php echo $rpost->post_title; ?>">
						<?php $rpthumb = get_the_post_thumbnail($rpost->ID,'thumb_282x187');
						$rpthumb = ($rpthumb) ? $rpthumb : '<img src="'.get_template_directory_uri().'/images/default-282x187.png" alt="'.$rpost->post_title.'">';
						echo $rpthumb; ?>
                        <h4><?php echo $rpost->post_title; ?></h4>
                    </a>
				<?php } ?>
				<div class="readmore"><a href="/blog/?offset=8&exclude=<?php echo $fpsliderids; ?>">查看更多</a></div>
            </article>
        
        <?php endwhile; ?>
        </div>
    </section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>