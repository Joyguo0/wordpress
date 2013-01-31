<?php get_header(); ?>
<?php if (is_home()) {
	$qarg = array();
	if (!empty($_GET['exclude'])) { $qarg['post__not_in'] = explode(',',$_GET['exclude']); }
	if (!empty($_GET['offset'])) { $qarg['offset'] = $_GET['offset']; }
	query_posts($qarg);
} ?>

    <section id="primary">
        <div id="content" role="main">
        <?php if ( have_posts() ) : ?>

            <?php dbd_archive_header();	?>

            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'loop', 'index' );	?>
            <?php endwhile; ?>
        <?php else : ?>
            <article id="post-0" class="post no-results not-found">
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found' ); ?></h1>
                </header>

                <div class="entry-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.' ); ?></p>
                    <?php get_search_form(); ?>
                    <script type="text/javascript">
                        // focus on search field after it has loaded
                        document.getElementById('s') && document.getElementById('s').focus();
                    </script>
                </div>
            </article>
        <?php endif; ?>

        </div><!-- #content -->
    </section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>