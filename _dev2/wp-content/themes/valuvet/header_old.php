<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/menu3.css">
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/toggle.css">
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/viewer.css">
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/cmxform.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fadeslideshow.js"></script>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery(".headingmenu10").click(function () {
	jQuery(".form_openclose").slideToggle("slow");
	});
});

jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery("#heading_01").click(function () {
	jQuery("#openclose_01").slideToggle("slow");
	});
});

jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery("#heading_02").click(function () {
	jQuery("#openclose_02").slideToggle("slow");
	});
});

jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery("#heading_03").click(function () {
	jQuery("#openclose_03").slideToggle("slow");
	});
});

jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery("#heading_policy").click(function () {
	jQuery("#openclose_policy").slideToggle("slow");
	});
});
</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/menu/mootools-1_002.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/menu/viewer.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/menu/morphlist_1.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/menu/dropMenu2.js"></script>

<script type="text/javascript">

var mygallery=new fadeSlideShow({
	wrapperid: "fadeshow1", //ID of blank DIV on page to house Slideshow
	dimensions: [346, 100], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
		["wp-content/themes/valuvet/images/banner_01.jpg", "", "", ""],
		["wp-content/themes/valuvet/images/banner_02.jpg", "#", "_new", ""],
		["wp-content/themes/valuvet/images/banner_03.jpg"],
		["wp-content/themes/valuvet/images/banner_04.jpg"],
		["wp-content/themes/valuvet/images/banner_05.jpg"],
		["wp-content/themes/valuvet/images/banner_06.jpg"],
		["wp-content/themes/valuvet/images/banner_07.jpg", "", "", ""] //<--no trailing comma after very last image element!
	],
	displaymode: {type:'auto', pause:2500, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 500, //transition duration (milliseconds)
	descreveal: "ondemand",
	togglerid: ""
});
</script>

<script type="text/javascript">
//<![CDATA[
var site_root='/';

window.addEvent('load', function(){
  if ($('feature_property')) new viewer($('feature_property').getChildren(),{mode:'bottom', interval:8000}).play(true);
  new viewer($('header-slide').getChildren(),{mode:'alpha', interval:4000}).play(true);

SqueezeBox.assign($$('a[rel=boxed]'), {size: {x: 650, y: 400},ajaxOptions: {method: 'get'}});
});

//]]>
</script>

<script type="text/javascript">
//<![CDATA[
var site_root='/';

window.addEvent('load', function(){
  if ($('feature_property2')) new viewer($('feature_property2').getChildren(),{mode:'bottom', interval:8000}).play(true);
  new viewer($('header-slide').getChildren(),{mode:'alpha', interval:4000}).play(true);

SqueezeBox.assign($$('a[rel=boxed]'), {size: {x: 650, y: 400},ajaxOptions: {method: 'get'}});
});

//]]>
</script>




<script type="text/javascript">
window.addEvent('domready',function(){
var menu = new DropMenu('navmenu-h');

var follow = new MorphList($('navmenu-h'), {
    transition: Fx.Transitions.backOut,
    duration: 700
    /*onClick: function(ev, item) { ev.stop(); } */
});
});

</script>

</head>
<body>
<div id="container">
<div id="header">
	<div style="height:102px; text-align:left; width:983px;">
    	<div id="logo_main"><a href="./"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="Logo" /></a></div>
        <div id="top_banner">
        	<div id="fadeshow1"></div>
       	</div>
        <div class="clear"></div>	
    </div>

		<div id="menu-container">
        <div id="menu_center">
		<?php wp_nav_menu( array('menu' => 'main_menu', 'menu_id' => 'navmenu-h',  'menu_class' => 'mainmenu' )); ?>
        </div></div>

		<div id="header-phone">
            <p class="hp-line1">Please call us on</p>
            <h2 class="hp-line2">07 <b>3831 5555</b></h2>
        </div> 

</div>


  
<!--Search-->

<!--End Search-->

<!-- start page -->
<div id="page">
<div id="page-bgtop">