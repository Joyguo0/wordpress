<?php /* Template Name: Press Room */
get_header(); ?>

    <section id="primary">
        <div id="content" role="main">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>

		<?php 
		$pargs = array('post_type'=>'press-room','posts_per_page'=>10, 'paged' => $paged);
		$wptemp = $wp_query;  
		$wp_query = null;
		$wp_query = new WP_Query($pargs); 
		$cc = 0;
        if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <?php if ($cc) { $alt = 'even'; $cc = 0; } else { $alt = 'odd'; $cc = 1; } ?>
            <a href="<?php echo the_permalink(); ?>" class="postthumb postthumb-<?php echo $alt; ?>">
                <?php $ppthumb = get_the_post_thumbnail(get_the_ID(),'thumb_282x187');
                $ppthumb = ($ppthumb) ? $ppthumb : '<img src="'.get_template_directory_uri().'/images/default-282x187.png">';
                echo $ppthumb; ?>
                <h4><?php the_title(); ?></h4>
            </a>
        <?php endwhile; ?>
		
		<?php dbd_pagination(); ?>
        <?php $wp_query = $wptemp; ?>
        </div>
    </section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>