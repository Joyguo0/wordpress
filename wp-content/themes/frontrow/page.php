<?php get_header(); ?>
    <section id="primary">
        <div id="content" role="main">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '' . __( 'Pages:' ), 'after' => '' ) ); ?>
                </div>
            </article>
        
        <?php endwhile; ?>
        </div>
    </section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>