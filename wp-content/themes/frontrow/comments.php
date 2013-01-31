<div id="comments">

<?php if ( post_password_required() ) : ?>
	<p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.'); ?></p>
<?php return; endif; ?>


<?php if ( have_comments() ) : ?>
	<h3><?php printf( _n('One Response to %2$s', '%1$s Responses to %2$s', get_comments_number()), number_format_i18n(get_comments_number()), '<em>'.get_the_title().'</em>'); ?></h3>

	<ol id="commentlist">
		<?php wp_list_comments( array( 'callback' => 'dbd_comment' ) ); ?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    <nav id="comment-nav">
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;' ) ); ?></div>
    </nav>
    <?php endif; ?>

<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :	?>
		<p class="nocomments"><?php _e( 'Comments are closed.' ); ?></p>

<?php endif;  ?>

<?php comment_form(); ?>
</div>