<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=960">

<title><?php
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );
?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="icon" type="image/png" href="<?php bloginfo( 'url' ); ?>/favicon.ico">
<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	wp_head();
?>

<!--[if lte IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->

<!--[if lte IE 7]><link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url');?>/style-ie7.css"/><![endif]-->
<!--[if lte IE 6]><link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url');?>/style-ie6.css"/><![endif]-->

<!-- BEGIN GOOGLE ANALYTICS CODE -->
<meta name="google-site-verification" content="Gj8PHYUkyLstwXrCxz6-C1U4em8ZfG4N5pwGjf2zV6M" />
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-34814560-1']);
_gaq.push(['_addOrganic', 'soso', 'w']);
_gaq.push(['_addOrganic', 'sogou', 'query']);
_gaq.push(['_addOrganic', 'youdao', 'q']);
_gaq.push(['_addOrganic', 'baidu', 'word',true]);
_gaq.push(['_addOrganic', 'baidu', 'wd',true]);
_gaq.push(['_addOrganic', 'ucweb', 'keyword']);
_gaq.push(['_addOrganic', 'ucweb', 'word']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<!-- END GOOGLE ANALYTICS CODE -->

</head>
<?php $exclass = ''; if (is_page_template('fullwidth.php') || is_page_template('tpl-contributors.php')) { $exclass = 'fullwidth'; } ?>
<body <?php body_class($exclass); ?>>
    <header id="header" role="banner"><div class="wrap">
        <?php $titledesc = ($titledesc = get_bloginfo('description','display')) ? ': '.$titledesc : ''; ?>
        <?php if (is_front_page()) : ?>
            <h1 id="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr(get_bloginfo('name','display')).$titledesc; ?>" rel="home"></a></h1>
        <?php else : ?>	
            <h3 id="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr(get_bloginfo('name','display')).$titledesc; ?>" rel="home"></a></h3>
        <?php endif; ?>
        

        <nav id="primary-nav" role="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class'=>'sf-menu','walker' => new nm_ga_nav_walker() ) ); ?>
        </nav>
		<?php include('searchform.php'); ?>
    </div></header>


	<div id="wrap">

		<div id="main">