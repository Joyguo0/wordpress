<?php $enable_comments = get_option('enable_comments'); print $enable_comments; ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<div class="entry-meta entry-byline">
				<?php dbd_posted_on(); ?>

				<?php if ( comments_open() && ! post_password_required() && $enable_comments ) : ?>
                <div class="comments-link">
                	<?php comments_popup_link( __('Leave a comment'), __('1 Comment'), __('% Comments') ); ?>
                </div>
                <?php endif; ?>

			</div><!-- .entry-meta -->

		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php echo dbd_excerpt(); ?>
		</div><!-- .entry-summary -->
		
        <div class="readmore"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">阅读更多</a></div>
	</article><!-- #post-<?php the_ID(); ?> -->