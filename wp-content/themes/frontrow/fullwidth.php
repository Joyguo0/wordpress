<?php /* Template Name: Full Width - no sidebar */
get_header(); ?>

    <section id="primary">
        <div id="content" role="main">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                <?php if ( is_front_page() ) { ?>
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                <?php } else { ?>	
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                <?php } ?>				
                </header>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '' . __( 'Pages:' ), 'after' => '' ) ); ?>
                </div>
            </article>
        
        <?php endwhile; ?>
        </div>
    </section>

<?php get_footer(); ?>