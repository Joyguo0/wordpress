<?php /* Template Name: Contributor Page */
get_header(); ?>

    <section id="primary" class="fullwidth">
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
            <div id="author-list">
            <?php 
            global $wpdb;
            $authquery = "SELECT ID, user_nicename from $wpdb->users ORDER BY ID";
            $author_ids = $wpdb->get_results($authquery);
            foreach ($author_ids as $authid) { ?>
                <div class="author-list-item" id="c<?php echo $authid->ID; ?>">
                    <div class="author-left">
                        <?php 
                        echo get_avatar( get_the_author_meta( 'user_email', $authid->ID ), 140 );
                        echo get_the_author_meta('display_name', $authid->ID);
                        ?>
                    </div>
                    <div class="author-center">
                        <?php
                        echo wpautop(get_the_author_meta('description', $authid->ID));
						// echo '<p><a href="http://e.weibo.com/'. get_the_author_meta( 'weibo', $authid->ID ) .'" target="_blank">@'.get_the_author_meta( 'weibo', $authid->ID ).'</a><br />';
                        echo '<p><a href="'. get_the_author_meta( 'weibo_link', $authid->ID ) .'" target="_blank">@'.get_the_author_meta( 'weibo' ,$authid->ID ).'</a><br />';
                        
						echo '<a href="'.get_the_author_meta('user_url', $authid->ID).'" target="_blank">'.get_the_author_meta('user_url', $authid->ID).'</a></p>';
                        ?>
                    </div>
                    <div class="author-right">
                    <?php $authposts = get_posts(array('numberposts'=>2, 'author'=>$authid->ID));
                    foreach ($authposts as $authpost) { ?>
                        <a href="<?php echo get_permalink($authpost->ID); ?>" class="postthumb postthumb-sml">
                            <?php $apthumb = get_the_post_thumbnail($authpost->ID,'thumb_282x187');
                            $apthumb = ($apthumb) ? $apthumb : '<img src="'.get_template_directory_uri().'/images/default-282x187.png">';
                            echo $apthumb; ?>
                            <h4><?php echo $authpost->post_title; ?></h4>
                        </a>
                    <?php } ?>
                    </div>
    			</div>
            <?php } ?>
            </div>

        </div>
    </section>

<?php get_footer(); ?>