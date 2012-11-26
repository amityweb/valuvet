<?php if ( ! is_user_logged_in() ) { header("Location: http://valuvet.com.au/"); } ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/menu3.css">
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/toggle.css">
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/viewer.css">
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/cmxform.css">

<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/style.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/custom.css" media="all" />
<!-- Javascript Functionality -->
<?php wp_enqueue_script("valuvet_header_scripts"); ?>
<?php wp_head(); ?>


<script type="text/javascript">
jQuery.noConflict();
</script>
</head>
<body>
<div id="container">
<div id="header">
	<div style="height:102px; text-align:left; width:983px;">
    	<div id="logo_main"><a href="<?php echo home_url( '/' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="Logo" /></a></div>
        <div id="top_banner">
        		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('header-middle-widget-area') ) : ?><?php endif; ?>
       	</div>
        <div class="clear"></div>	
    </div>

		<div id="menu-container">
        <div id="menu_center">
		<?php wp_nav_menu( array('menu' => 'main_menu', 'menu_id' => 'navmenu-h',  'menu_class' => 'mainmenu', 'theme_location' => 'header_menu' )); ?>
        </div>
        </div>

		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('header-right-widget-area') ) : ?><?php endif; ?>


</div>

<!--Search-->

<!--End Search-->

<!-- start page -->
<div id="page">
<div id="page-bgtop">