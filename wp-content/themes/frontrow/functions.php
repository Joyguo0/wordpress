<?php 

add_filter( 'sanitize_user', 'ys_sanitize_user',3,3);


function ys_sanitize_user($username, $raw_username, $strict){
	$username = $raw_username;
	$username = strip_tags($username);
	// Kill octets
	$username = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);
	$username = preg_replace('/&.+?;/', '', $username); // Kill entities

	// If strict, reduce to ASCII and chinese for max portability.
	if ( $strict )
		$username = preg_replace('|[^a-z0-9 _.\-@\x80-\xFF]|i', '', $username);

	// Consolidate contiguous whitespace
	$username = preg_replace('|\s+|', ' ', $username);

	return $username;
}
add_filter('user_contactmethods','my_user_contactmethods');
function my_user_contactmethods($user_contactmethods ){
	$user_contactmethods ['weibo_link'] = '微博链接';
	return $user_contactmethods ;
}
function dbd_setup() {
	include('cpt-include.php');
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus( array(
		'primary' => __('Primary Navigation'),
	) );
	add_image_size('thumb_282x187', 282, 187, true);
	//add_image_size('thumb_269x178', 269, 178, true);
	add_image_size('thumb_590x390', 590, 390, true);
	add_image_size('thumb_140x176', 140, 176, true);
}
add_action( 'after_setup_theme', 'dbd_setup' );

function dbd_init() {
	//wp_enqueue_style('fontface', get_bloginfo('template_url').'/font/stylesheet.css');
	wp_enqueue_style('superfish', get_bloginfo('template_url').'/js/superfish/superfish.css');
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('superfish', get_bloginfo('template_url').'/js/superfish/superfish.js','', '', false);
	wp_enqueue_script('hoverintent', get_bloginfo('template_url').'/js/superfish/hoverIntent.js','', '', false);	
	wp_enqueue_script('jqcycle', get_bloginfo('template_url').'/js/jquery.cycle.all.js','', '', false);	
	wp_enqueue_script('scripts', get_bloginfo('template_url').'/js/scripts.js', '', '', false);
}
if (!is_admin()) { add_action('init', 'dbd_init'); }

// Adds ID to admin columns
add_filter('manage_posts_columns', 'posts_columns_id', 5);
add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'posts_columns_id', 5);
add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2);
function posts_columns_id($defaults){
	$defaults['wps_post_id'] = __('ID');
	return $defaults;
}
function posts_custom_id_columns($column_name, $id){
	if($column_name === 'wps_post_id'){
		echo $id;
	}
}

/** Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link. */
function dbd_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'dbd_page_menu_args' );

/** Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and dbd_continue_reading_link(). */
function dbd_auto_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'dbd_auto_excerpt_more' );

/** Remove inline styles printed when the gallery shortcode is used. */
function dbd_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'dbd_remove_gallery_css' );

// Modifies the comment submission form.
function daoCommentFormFields($fields) {
	$commenter = wp_get_current_commenter();
	$cfoutput = array(
		'author' => '<div id="commentform-left"><p class="comment-form-author">' .
					'<input id="author" name="author" type="text" value="' .
					(esc_attr($commenter['comment_author']) ? esc_attr($commenter['comment_author']) : __('Name')) . '" size="30" tabindex="1"' . $aria_req . ' onblur="if (this.value == \'\') {this.value = \''.__('Name').'\';}" onfocus="if (this.value == \''.__('Name').'\') {this.value = \'\';}" />' .
					'<span class="required">*</span></p><!-- #form-section-author .form-section -->',
		'email'  => '<p class="comment-form-email">' .
					'<input id="email" name="email" type="text" value="' .
					(esc_attr($commenter['comment_author_email']) ? esc_attr($commenter['comment_author_email']) : __('E-mail')) . '" size="30" tabindex="2"' . $aria_req . ' onblur="if (this.value == \'\') {this.value = \''.__('E-mail').'\';}" onfocus="if (this.value == \''.__('E-mail').'\') {this.value = \'\';}" />' .
					'<span class="required">*</span></p><!-- #form-section-email .form-section -->',
		'url'    => '<p class="comment-form-url">' .
					'<input id="url" name="url" type="text" value="' .
					(esc_attr($commenter['comment_author_url']) ? esc_attr($commenter['comment_author_url']) : __('Website')) . '" size="30" tabindex="3" onblur="if (this.value == \'\') {this.value = \''.__('Website').'\';}" onfocus="if (this.value == \''.__('Website').'\') {this.value = \'\';}" />' .
					'</p></div><!-- #form-section-url .form-section -->');
	return $cfoutput;
}
add_filter( 'comment_form_default_fields', 'daoCommentFormFields' );

// Callback for re-formatting comments and pingbacks
if ( ! function_exists( 'dbd_comment' ) ) :
function dbd_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>">
			<?php echo get_avatar( $comment, 60 ); ?>
			<div class="comment-right">
				<footer class="comment-top">
					<div class="comment-author">
						<?php printf( __('%s <span class="says">says:</span>'), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div>
					<div class="comment-meta"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __('(Edit)'), ' ' ); ?>
					</div>
				</footer>
		
				<div class="comment-body">
					<?php if ( $comment->comment_approved == '0' ) : ?>
                        <p><strong><em><?php _e('Your comment is awaiting moderation.'); ?></em></strong></p>
                    <?php endif; ?>

					<?php comment_text(); ?>
					<div class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
				</div>
			</div>
		</article>

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e('Pingback:'); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)'), ' ' ); ?></p>

	<?php
			break;
	endswitch;
}

endif;

/* Register widgetized areas, including two sidebars and four widget-ready columns in the footer. */
function dbd_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __('Primary Widget Area'),
		'id' => 'primary-widget-area',
		'description' => __('The primary widget area'),
		'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span class="titlewrap">',
		'after_title' => '</span></h3>',
	) );
}
add_action( 'widgets_init', 'dbd_widgets_init' );

/** Removes the default styles that are packaged with the Recent Comments widget. */
function dbd_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'dbd_remove_recent_comments_style' );

/** Posted On formatting - dateline */
if ( ! function_exists( 'dbd_posted_on' ) ) :
function dbd_posted_on() {
	echo '<div class="dateline">';
	printf( __( '<span class="%1$s">发布于</span> %2$s <span class="meta-sep">by</span> %3$s'),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date('d.m.y')
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_permalink(74).'#c'.get_the_author_meta( 'ID' ),	//get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__('View all posts by %s'), get_the_author() ),
			get_the_author()
		)
	);
	echo '</div>';
}
endif;

/** Posted In meta data */
if ( ! function_exists( 'dbd_posted_in' ) ) :
function dbd_posted_in($tags = false) {
	if ($tags) { $tag_list = get_the_tag_list( '', ', ' );}
	if ( $tag_list ) {
		$posted_in = __('%1$s.<br />TAGS: %2$s.');
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __('%1$s.');
	}
	printf( $posted_in, get_the_category_list( ', ' ), $tag_list );
}
endif;

// Generates pagination
function dbd_pagination($pages = '', $range = 4) {
	$showitems = ($range * 2)+1;  
	global $paged;
	if (empty($paged)) $paged = 1;
	if ($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if (!$pages) {
			$pages = 1;
		}
	}   

	if (1 != $pages) {
		echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>« First</a>";
		if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>‹ Previous</a>";
		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
			}
		}
		
		if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next ›</a>";
		
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last »</a>";
		echo "</div>\n";
	}
}

function dbd_archive_header() {
	// Is Taxonomy
	the_post();
	$pagetitle = ''; $archive_meta = '';
	if (is_category()) :
		$pagetitle = sprintf( __( '%s' ), '<span>' . single_cat_title( '', false ) . '</span>' );
		$category_description = category_description();
		if ( ! empty( $category_description ) ) :
			$archive_meta = apply_filters( 'category_archive_meta', '<div class="archive-meta category-archive-meta">' . $category_description . '</div>' );
		endif;
	elseif (is_tag()) :
		$pagetitle = sprintf( __( '%s' ), '<span>' . single_tag_title( '', false ) . '</span>' );
		$tag_description = tag_description();
		if ( ! empty( $tag_description ) ) :
			$archive_meta = apply_filters( 'tag_archive_meta', '<div class="archive-meta tag-archive-meta">' . $tag_description . '</div>' );
		endif;

	// Is Author
	elseif (is_author()) :
		$pagetitle = sprintf( __( '%s' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
		if ( get_the_author_meta( 'description' ) ) :
        $archive_meta = '<div class="entry-author-info archive-meta">';
		$archive_meta .= get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'dbd_author_bio_avatar_size', 60 ) );
        $archive_meta .= '<h4>'. sprintf( esc_attr__('About %s'), get_the_author() ). '</h4>';
        $archive_meta .= get_the_author_meta( 'description' );
        $archive_meta .= '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.sprintf( __('View all posts by %s &rarr;'), get_the_author() ).'</a></div>';
        endif;

	// Is Date Archive
	elseif ( is_day() ) :
		$pagetitle = sprintf( __( '%s' ), '<span>' . get_the_date() . '</span>' );
	elseif ( is_month() ) :
		$pagetitle = sprintf( __( '%s' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format' ) ) . '</span>' );
	elseif ( is_year() ) :
		$pagetitle = sprintf( __( '%s' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format' ) ) . '</span>' );
	
	// Is Search
	elseif ( is_search() ) :
		$pagetitle = sprintf( __( 'Search Results for %s' ), '<span>' . get_search_query() . '</span>' );

	// Nada
	else :
		$pagetitle = '';//__( 'Blog Archives' );
	endif;
	
	if ($pagetitle) : ?>
    
    
    <header class="page-header">
        <h1 class="page-title archive-title"><?php echo $pagetitle; ?></h1>

        <?php echo $archive_meta; ?>
    </header>
	
	<?php endif;
	rewind_posts();
}

function dbd_excerpt($length = '200', $cpost = array(), $ender = '&hellip;', $autop = false) {
    global $post;
    $cpost = ($cpost) ? $cpost : $post;
	$morepos = mb_strpos($cpost->post_content,'<!--more-->');
    if(!empty($cpost->post_excerpt)) {
        $output = $cpost->post_excerpt;
	} elseif (!empty($cpost->post_content) && $morepos > 0) {
		$output = wpautop(mb_substr($cpost->post_content, 0, $morepos));
	} else {
        $output = mb_substr(strip_tags($cpost->post_content), 0, $length).$ender;
    }
	$output = ($autop) ? wpautop($output) : $output;
	return do_shortcode($output);
}

// Change [subtitle] to <span class="subtitle"> in widgets
add_filter('widget_title', 'nm_change_title');
function nm_change_title($title) {
    $title = str_replace('[subtitle]', '<span class="subtitle">', $title);
    $title = str_replace('[/subtitle]', '</span>', $title);
	return $title;
}

function nm_bestsellers($banid = 64) {
	if ( $images = get_children(array('post_parent' => $banid,'post_type' => 'attachment','posts_per_page' => -1,'order'=>'ASC','orderby' => 'menu_order','post_mime_type' => 'image',))) {
		echo '<div id="nm-slides"><div id="nm-slides-in">';
		foreach( $images as $image ) {
			$img_src = wp_get_attachment_image_src($image->ID,'thumb_140x176');
			echo '<a href="'.$image->post_content.'" class="nm-slide" title="'.$image->post_title.'">
				<img src="'.$img_src[0].'" alt="'.$image->post_title.'" class="nm-slideimg" />
			</a>';
		}
		echo '</div></div>';
	}
}

function nm_recommended() {
	$recids = ot_get_option('recommended_posts');
	$recposts = get_posts(array('numberposts'=>-1, 'include'=>$recids));
	if ($recposts) {
		echo '<div id="recommended-posts">';
		foreach ($recposts as $recpost) { ?>
			<?php $recpostthumb = wp_get_attachment_image_src(get_post_thumbnail_id($recpost->ID),'thumb_282x187');
            $recpostthumb = ($recpostthumb[0]) ? $recpostthumb[0] : get_template_directory_uri().'/images/default-269x178.png'; ?>
            <a href="<?php echo get_permalink($recpost->ID); ?>" title="<?php echo $recpost->post_title; ?>" class="recpost-item">
                <img src="<?php echo $recpostthumb; ?>" width="140" height="96">
                <h4>
                    <?php if (strlen($recpost->post_title) >= 70) {
                        echo mb_substr($recpost->post_title,0,70).'&hellip;';
                    } else {
                        echo $recpost->post_title;	
                    }?>
                </h4>
            </a>
		<?php } 
		echo '</div>';
	}
}

function nm_authorinfo() {
	global $posts;
	echo '<div class="entry-author-info">';
	echo get_avatar( get_the_author_meta( 'user_email' ),110 ); 
	echo '<h4>'.sprintf( esc_attr__('%s'), get_the_author() ).'</h4>';
    echo '<p>'.mb_substr(get_the_author_meta( 'description' ),0,80).'&hellip;</p>';
	echo '<div class="author-info-biolink"><a href="'. get_permalink(74).'#c'.get_the_author_meta( 'ID' ).'">'. sprintf( __('阅读资料Read Contributor\'s Full Bio »'), get_the_author() ).'</a></div>';
	echo '<div class="author-info-weibo">微博: <a href="'. get_the_author_meta( 'weibo_link' ) .'">@'.get_the_author_meta( 'weibo' ).'</a></div>';
	//echo '<div class="author-info-weibo">微博: <a href="http://e.weibo.com/'. get_the_author_meta( 'weibo' ) .'">@NeimanMarcus尼曼</a></div>';
	echo '</div>';	
}


// remove aim, jabber, yim 
function nm_hide_profile_fields( $contactmethods ) {
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	return $contactmethods;
}

function nm_contactmethods( $contactmethods ) {
	$contactmethods['weibo'] = '微博';
	return $contactmethods;
}
add_filter('user_contactmethods','nm_contactmethods',10,1);
add_filter('user_contactmethods','nm_hide_profile_fields',10,1);

// Scrolling Gallery
function shortcode_nmgallery($attr) {
	global $post;
	if ( $images = get_children(array('post_parent' => $post->ID,'post_type' => 'attachment','posts_per_page' => -1,'order'=>'ASC','orderby' => 'menu_order','post_mime_type' => 'image'))) {
		$output2 = '<div class="nm-gallery-wrap">';
		$output = '<div class="nm-gallery scrollable"><div class="nm-gallery-in scrollable-items">';
		$gcnt = 1;$grow = 1;
		$output .= '<div class="nm-gallery-row-'.$grow.' nm-gallery-row">';
		foreach( $images as $image ) {
			if ($gcnt == 1) { 
				$img_src_590 = wp_get_attachment_image_src($image->ID,'large');
				$output2 .= '<div class="nm-gallery-main"><img src="'.$img_src_590[0].'" alt="'.$image->post_title.'" class="aligncenter"></div>';
			}
			if ($gcnt == 6) { $grow++;$gcnt=1; $output .= '</div><div class="nm-gallery-row-'.$grow.' nm-gallery-row">'; }
			$img_src = wp_get_attachment_image_src($image->ID,'thumb_140x176');
			$img_src_full = wp_get_attachment_image_src($image->ID,'large');
			$output .= '<a href="'.$img_src_full[0].'" class="nm-gallery-item nm-gallery-item-'.$gcnt.'" title="'.$image->post_title.'">
				<img src="'.$img_src[0].'" alt="'.$image->post_title.'" class="nm-gallery-image" />
			</a>';
			$gcnt++;
		}
		$output .= '</div>';
		$output .= '</div></div></div>';
		echo $output2;
		echo $output;
	}
}
add_shortcode( 'nmgallery', 'shortcode_nmgallery' );

// Modifies main navigation to add GA event tracking code.
class nm_ga_nav_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';
		
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' onclick="_gaq.push([\'_trackEvent\', \'NavigationBar_'.str_replace(array(' ','\'','\"'),'-',$item->title).'\', \'click\',\'\']);"';
		
		if($depth == 0) {
			// Leaving this in just in case it's needed...
		}
		
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}