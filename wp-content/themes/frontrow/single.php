<?php get_header(); ?>
<?php $enable_comments = get_option('enable_comments'); print $enable_comments; ?>
    <section id="primary">
        <div id="content" role="main">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta entry-byline">
                        <?php dbd_posted_on(); ?>
        
                        <?php if ( comments_open() && ! post_password_required() && $enable_comments  ) : ?>
                        <div class="comments-link">
                            <?php comments_popup_link( __('Leave a comment'), __('1 Comment'), __('% Comments') ); ?>
                        </div>
                        <?php endif; ?>    
                    </div><!-- .entry-meta -->
                </header><!-- .entry-header -->
                
                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:' ) . '</span>', 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
                    
				<footer class="entry-meta entry-taxonomy">
                	<?php dbd_posted_in(true); ?>
				</footer>        
            </article>
            <div class="navigation">
                <?php
                previous_post_link('<span class="navigation-next">%link</span>', '上一页');
				next_post_link('<span class="navigation-prev">%link</span>', '下一页'); ?>
            </div>
            <?php if ($enable_comments) { comments_template( '', true ); } ?>
        
        <?php endwhile; ?>
        </div><!-- #content -->
    </section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>