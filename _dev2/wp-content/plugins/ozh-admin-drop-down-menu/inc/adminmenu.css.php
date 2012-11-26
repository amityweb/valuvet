<?php
/*
Part of Plugin: Ozh' Admin Drop Down Menu
http://planetozh.com/blog/my-projects/wordpress-admin-menu-drop-down-css/
*/

function make_link_relative( $link ) {
	return preg_replace('|https?://[^/]+(/.*)|i', '$1', $link );
}

function wp_ozh_adminmenu_sanitize_id($url) {
	$url = preg_replace('/(&|&amp;|&#038;)?_wpnonce=([^&]+)/', '', $url);
	return str_replace(array('.php','.','/','?','='),array('','_','_','_','_'),$url);
}

function wp_ozh_adminmenu_color($col) {
	return '#'.str_replace('#', '', urldecode($col)); // Make sure there's always a # prefixing color code
}

function wp_ozh_adminmenu_true_if_set( $param ) {
	return ( ( isset( $_GET[ $param ] ) && $_GET[ $param ] == 1 ) ? true : false );
}

// Get vars & needed links, make them relative to be sure no one will be leeching icons or anything from somewhere else
$plugin      = isset( $_GET['p'] ) ? make_link_relative( $_GET['p'] ) : '';
$admin       = isset( $_GET['a'] ) ? make_link_relative( $_GET['a'] ) : '';
$icons       = wp_ozh_adminmenu_true_if_set( 'i' );
$wpicons     = wp_ozh_adminmenu_true_if_set( 'w' );
$compact     = wp_ozh_adminmenu_true_if_set( 'c' );
$minimode    = wp_ozh_adminmenu_true_if_set( 'm' );
$hidebubble  = wp_ozh_adminmenu_true_if_set( 'h' );
$display_fav = wp_ozh_adminmenu_true_if_set( 'f' );
$nograd      = wp_ozh_adminmenu_true_if_set( 'n' );
$dir         = ( isset( $_GET['d'] ) && $_GET['d'] == 'right' ) ? 'right' : 'left' ; // text direction
$opdir       = ( isset( $_GET['r'] ) && $_GET['r'] == 'right' ) ? 'left' : 'right' ; // OPposite DIRection
$grad        = ( isset( $_GET['g'] ) ) ? wp_ozh_adminmenu_color($_GET['g']) : '#676768' ;

header('Content-type:text/css');

?>

/* Style for Ozh's Admin Drop Down Menu */
/* Restyle or hide original items */


/* IE conditional inline CSS HACKS */
/*  ^  this targets all IE, including 7. It must go first */
/*  _  this targets >= IE6 */
/*  *  this targets IE6 & 7 */


#adminmenu 					{display:none;}
#wpbody, div.folded #wpbody {margin-<?php echo $dir; ?>:0px}

#wpbody-content .wrap {margin-<?php echo $dir; ?>:15px}

#media-upload-header #sidemenu li {
	display:auto;
}
#screen-meta {
	display:none; /* hidden in case we have no JS to move it */
}
/* added for WP 3.2 */
#adminmenuback, #adminmenuwrap, #adminmenu,
.folded #adminmenu .wp-submenu.sub-open, .folded #adminmenu .wp-submenu-wrap,
.folded #adminmenuback, .folded #adminmenuwrap, .folded #adminmenu, .folded #adminmenu li.menu-top,
.js.folded #adminmenuback, .js.folded #adminmenuwrap, .js.folded #adminmenu, .js.folded #adminmenu li.menu-top {
    width: 0;
}
#wpcontent, #footer, .folded #wpcontent, .folded #footer, .js.folded #wpcontent, .js.folded #footer {
    margin-left: 0px;
	margin-right:0px;
}
#wphead {
	background:#D1E5EE;
	margin-right:0px;
	margin-left:0px;
	padding-right:15px;
	padding-left:18px;
}
#footer-left, #footer-ozh-oam {
	padding-left:15px;
	display:none;
	display:hidden;
}
#footer-upgrade {
	padding-right:15px;
}
/* Styles for our new menu */
#ozhmenu_wrap {
	z-index:43000;
	overflow:hidden;
	width:100%;
	clear:both;

}
#ozhmenu { /* our new ul */
	font-size:12px;
	<?php echo $dir; ?>:0px;
	list-style-image:none;
	list-style-position:outside;
	list-style-type:none;
	margin:0pt;
	margin-bottom:1px;
	padding-<?php echo $dir; ?>:8px;
	padding-top:5px;
	top:0px;
	width:100%; /* width required for -wtf?- dropping li elements to be 100% wide in their containing ul */
	overflow:hidden;
	z-index:1000;
    *background: #555 url('<?php echo $plugin; ?>/images/ie_grad_bgknd.png') repeat-x bottom; /* dark-grey-theme IE 7 */

/* toplevel-gradient-dark-grey-theme*/	
/**/	background-image: -moz-linear-gradient(center top, #555 30%, #222 70%);
	background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0.3,#555),color-stop(0.7,#222));
/**/

/* toplevel-gradient-light-grey-theme */	
/** background-image: -moz-linear-gradient(center top, #EEE 30%, #CCC 70%);
	background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0.3,#EEE),color-stop(0.7,#CCC));
/**/

}

#ozhmenu li { /* all list items */
	display:inline;
	line-height:200% !important;
	list-style-image:none;
	list-style-position:outside;
	list-style-type:none;
	margin:0 6px;
	padding:0px;
	white-space:nowrap;
	float: <?php echo $dir; ?>;
	width: 1*; /* maybe needed for some Opera ? */
	text-align:center;
}

#ozhmenu a { /* all links */
	text-decoration:none;
	
	/* dark-grey-theme */
	/**/color:#bbb;/**/
	
	/* light-grey-theme */
	/** color:#666;/**/
	
	line-height:220%;
	padding:0px 10px;
	display:block;
	width:1*;  /* maybe needed for some Opera ? */

}

#ozhmenu li:hover,
#ozhmenu li.ozhmenu_over,
#ozhmenu li .wp-has-current-submenu {

	/* dark-grey-theme */
	/**/color:#fff;/**/
	
	/* light-grey-theme */
	/** color:#1F88C2;/**/


/* MENU ICON BACKGROUND ROUNDED CORNERS */
/* ------------------------------------ */
	-moz-border-radius-topleft: 11px;
	-moz-border-radius-topright: 11px;
	-webkit-border-top-left-radius:11;
	-webkit-border-top-right-radius:11;	
	border-top-left-radius:11px;
	border-top-right-radius:11px;

/* MENU ICON BACKGROUND GRADIENT COLOURS */
/* ------------------------------------- */

/* toplevel-gradient-dark-grey-theme */	
/**/ background-image: -moz-linear-gradient(center top, #444 30%, #222 70%);
	background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0.3,#444),color-stop(0.7,#222));
/**/

/* dark-grey-theme IE 7 */
*background: transparent url('<?php echo $plugin; ?>/images/ie_toplevel_bkgnd.png') repeat-x bottom; 


/* ------------------------------------- */
/* toplevel-gradient-light-grey-theme */	
/** background-image: -moz-linear-gradient(center top, #CCC 30%, #EEE 70%);
	background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0.3,#CCC),color-stop(0.7,#EEE));
/**/
/* ------------------------------------- */
/* toplevel-gradient-dark-to-light */	
/** background-image: -moz-linear-gradient(center top, #222 30%, #444 70%);
	background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0.3,#222),color-stop(0.7,#444));
/**/
/* ------------------------------------- */
/* toplevel-gradient-blue-to-white */	
/** background-image: -moz-linear-gradient(center top, #fff 30%, #1F88C2 70%);
	background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0.3,#fff),color-stop(0.7,#1F88C2));
/**/
/* ------------------------------------- */

/* degraded old OZH elements */
/**	background: <?php echo $grad; ?> <?php if (!$nograd) { ?>url(<?php echo $plugin; ?>images/grad-trans.png) repeat-x <?php echo $dir; ?> -5px<?php } ?>;/**/
/**	background: <?php echo $grad; ?> <?php if (!$nograd) { ?>url(<?php echo $plugin; ?>images/ie_grad_bgknd.png) repeat-x <?php echo $dir; ?> bottom<?php } ?>;/**/


/* MENU ICON BACKGROUND HOVER GLOW */
/* ------------------------------- */

/* toplevel-grey-glow */		
/**
-moz-box-shadow: 0px -1px 2px 2px #666; 
-webkit-box-shadow: 0px -1px 2px 2px #666; 
box-shadow: 0px -1px 2px 2px #666; 
/**/
/* ------------------------------- */
/* toplevel-white-glow */		
/**
-moz-box-shadow: 0px -1px 2px 2px #fff; 
-webkit-box-shadow: 0px -1px 2px 2px #fff; 
box-shadow: 0px -1px 2px 2px #fff; 
/**/
/* ------------------------------- */
/* toplevel-blue-glow */	
/**
-moz-box-shadow: 0px -1px 2px 2px #1F88C2; 
-webkit-box-shadow: 0px -1px 2px 2px #1F88C2; 
box-shadow: 0px -1px 2px 2px #1F88C2; 
/**/	
/* ------------------------------- */
/* toplevel-black-glow */		
/**/
-moz-box-shadow: 0px -1px 2px 2px #000; 
-webkit-box-shadow: 0px -1px 2px 2px #000; 
box-shadow: 0px -1px 2px 2px #000; 
/**/
/* ------------------------------- */
}



#ozhmenu .ozhmenu_sublevel { line-height: 100%; margin: 0; } /* IE8 fix. Die, IE8 */
#ozhmenu .ozhmenu_sublevel a:hover,
#ozhmenu .ozhmenu_sublevel a.current,
#ozhmenu .ozhmenu_sublevel a.current:hover {

	-moz-border-radius-topleft: 11px;
	-moz-border-radius-topright: 11px;
	-webkit-border-top-left-radius:11;
	-webkit-border-top-right-radius:11;
	border-top-left-radius:0;
	border-top-right-radius:0;
	
	color: #fff;            /*drop down menu list hover text colour */
	background-color: #222; /*drop down menu list hover background colour */
}

#ozhmenu li ul { /* drop down lists */
	padding: 0 0 5px 0px;
	margin: 0;
	list-style: none;
	position: absolute;
	background: #333;
	*margin-left:2px; /* for IE 7 */
	
	background-image: -moz-linear-gradient(center top, #666 30%, #333 70%);
	background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0.3,#666),color-stop(0.7,#333));

	-moz-box-shadow: 2px 2px 2px rgba(0,0,0,0.25);
	-webkit-box-shadow: 2px 2px 2px rgba(0,0,0,0.25);
	box-shadow: 2px 2px 2px rgba(0,0,0,0.25);

	opacity:0.95;
	filter:alpha(opacity=95);

	border-left:1px solid #ccc ;
	border-right:1px solid #ccc ;
	border-bottom:1px solid #c6d9e9 ;
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-bottomright:5px;
	-webkit-border-bottom-left-radius:5px;
	-webkit-border-bottom-right-radius:5px;
	border-bottom-left-radius:5px;
	border-bottom-right-radius:5px;

	width: 1*;  /* maybe needed for some Opera ? */
	zmin-width:10em;
	<?php echo $dir; ?>: -999em; /* using left instead of display to hide menus because display: none isn't read by screen readers */
	list-style-position:auto;
	list-style-type:auto;
	z-index:1001;
}

#ozhmenu li ul li { /* dropped down lists item */
	background:transparent !important;
	float:none;
	text-align:<?php echo $dir; ?>;
	overflow:hidden;
}

#ozhmenu li ul li a { /* links in dropped down list items*/
	margin:0px;
	/* color:#666;*/
	    color:#fff;
		border-bottom:1px solid #464646;
        border-top:1px solid #565656;        
}

/* required to remove/hide GLOW on sublevel hover menu items */
#ozhmenu li ul li:hover {
	border-top-left-radius:0;
	border-top-right-radius:0;
	-moz-box-shadow: none; 
	-webkit-box-shadow: none; 
	box-shadow: none;
}

#ozhmenu li:hover ul, #ozhmenu li.ozhmenu_over ul { /* lists dropped down under hovered list items */
	<?php echo $dir; ?>: auto;
	z-index:999999;
}

#ozhmenu li a #awaiting-mod, #ozhmenu li a .update-plugins {
	position: absolute;
	margin-<?php echo $dir; ?>: 0.1em;
	font-size: 0.8em;
	background-image: url(<?php echo $plugin; ?>images/comment-stalk-<?php echo ($dir == 'left' ? 'fresh' : 'rtl'); ?>.gif);
	background-repeat: no-repeat;
	background-position: <?php echo ($dir == 'left' ? '-243' : '-67'); ?>px bottom;
	height: 1.7em;
	width: 1em;
}
#ozhmenu li.ozhmenu_over a #awaiting-mod, #ozhmenu li a:hover #awaiting-mod, #ozhmenu li.ozhmenu_over a .update-plugins, #ozhmenu li a:hover .update-plugins {
	background-position: <?php echo ($dir == 'left' ? '-83' : '-67' /* '-2' : '-307'*/); ?>px bottom;
}
#ozhmenu li a #awaiting-mod span, #ozhmenu li a .update-plugins span {
	color: #444;
	top: -0.4em;
	<?php echo $opdir; ?>: -0.5em;
	position: absolute;
	display: block;
	height: 1.3em;
	line-height: 1.4em;
	padding: 0 0.8em;
	background-color: #bbb;#2583AD;
	-moz-border-radius: 4px;
	-khtml-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
}
#ozhmenu li.ozhmenu_over a #awaiting-mod span, #ozhmenu li a:hover #awaiting-mod span, #ozhmenu li.ozhmenu_over a .update-plugins span, #ozhmenu li a:hover .update-plugins span {
	background-color:#1F88C2/*#D54E21*/;
}
#ozhmenu .current {
	border:0px; /* MSIE insists on having this */
}
#ozhmenu li ul li a.current:before {
	content: "\00BB \0020";
	color:#1F88C2/*#d54e21*/;
}

/* Top level icons */
.ozhmenu_toplevel div.wp-menu-image {
	/*float:<?php echo $dir; ?>;*/
	position:relative;
	height:96px;
	width:96px;
	overflow:hidden;

}



<?php if ($wpicons) { ?>
#ozhmenu .ozhmenu_toplevel a.menu-top {
	padding:<?php echo ($dir == 'left' ? '0 5px 0 1px' : '0 1px 0 5px'); ?>; /* override #ozhmenu a's padding:0 10 */
}
<?php } ?>

#ozhmenu li.ozhmenu_toplevel ul li.toplevel_label, #ozhmenu li.ozhmenu_toplevel ul li.toplevel_label:hover {
	color:#444;
	background:#222 /* #e4f2fd*/ !important;
	padding:0px 10px;
	margin:0px;
	display:block;
	border-bottom:1px solid #c6d9e9;
	width:1*;  /* maybe needed for some Opera ? */
	cursor:default;
	<?php if (!$compact) { ?>
	display:none;
	<?php } ?>
}
#ozhmenu li.ozhmenu_toplevel ul li.toplevel_label span.update-plugins,
#ozhmenu li.ozhmenu_toplevel ul li.toplevel_label span.pending-count {display:none;}
/**
#oam_menu-site div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -363px -35px no-repeat;}
#oam_menu-site:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -363px -3px no-repeat;}
#oam_menu-dashboard div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -61px -35px no-repeat;}
#oam_menu-dashboard:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -61px -3px no-repeat;}
#oam_menu-posts div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -272px -35px no-repeat;}
#oam_menu-posts:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -272px -3px no-repeat;}
#oam_menu-media div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -121px -35px no-repeat;}
#oam_menu-media:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -121px -3px no-repeat;}
#oam_menu-links div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -91px -35px no-repeat;}
#oam_menu-links:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -91px -3px no-repeat;}
#oam_menu-pages div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -151px -35px no-repeat;}
#oam_menu-pages:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -151px -3px no-repeat;}
#oam_menu-comments div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -31px -35px no-repeat;}
#oam_menu-comments:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -31px -3px no-repeat;}
#oam_menu-appearance div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -1px -35px no-repeat;}
#oam_menu-appearance:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -1px -3px no-repeat;}
#oam_menu-plugins div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -181px -35px no-repeat;}
#oam_menu-plugins:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -181px -3px no-repeat;}
#oam_menu-users div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -301px -35px no-repeat;}
#oam_menu-users:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -301px -3px no-repeat;}
#oam_menu-tools div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -211px -35px no-repeat;}
#oam_menu-tools:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -211px -3px no-repeat;}
#oam_menu-update div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -211px -35px no-repeat;}
#oam_menu-update:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -211px -3px no-repeat;}
#oam_menu-settings div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -241px -35px no-repeat;}
#oam_menu-settings:hover div.wp-menu-image {background:transparent url(<?php echo $admin; ?>images/menu.png) -241px -3px no-repeat;}
#ozhmenu img.wp-menu-image {float:<?php echo $dir; ?>;opacity:0.6;padding:5px 1px 0;filter:alpha(opacity=60);}
#ozhmenu .ozhmenu_toplevel:hover img.wp-menu-image {opacity:1;filter:alpha(opacity=100);}
/**/

#oam_custom_menu_buyers div.wp-menu-image {background:transparent url(images/property_buyers_icon.png) 0px 0px no-repeat;}
#oam_custom_menu_buyers:hover div.wp-menu-image {background:transparent url(images/property_buyers_icon.png) 0px -90px no-repeat;}

#oam_menu-posts-property div.wp-menu-image {background:transparent url(images/property_sales_icon.png) 0px 0px no-repeat;}
#oam_menu-posts-property:hover div.wp-menu-image {background:transparent url(images/property_sales_icon.png) 0px -90px no-repeat;}

#oam_menu-posts-equipment_sale div.wp-menu-image {background:transparent url(images/equipment_icon.png) 0px 0px no-repeat;}
#oam_menu-posts-equipment_sale :hover div.wp-menu-image {background:transparent url(images/equipment_icon.png) 0px -90px no-repeat;}

#oam_custom_menu_careers div.wp-menu-image {background:transparent url(images/careers_icon.png) 0px 0px no-repeat;}
#oam_custom_menu_careers:hover div.wp-menu-image {background:transparent url(images/careers_icon.png) 0px -90px no-repeat;}

#oam_custom_menu_newsletter div.wp-menu-image {background:transparent url(images/news_icon.png) 0px 0px no-repeat;}
#oam_custom_menu_newsletter:hover div.wp-menu-image {background:transparent url(images/news_icon.png) 0px -90px no-repeat;}

#oam_custom_menu_events div.wp-menu-image {background:transparent url(images/events_icon.png) 0px 0px no-repeat;}
#oam_custom_menu_events:hover div.wp-menu-image {background:transparent url(images/events_icon.png) 0px -90px no-repeat;}

#oam_custom_menu_schedule div.wp-menu-image {background:transparent url(images/schedule_icon.png) 0px 0px no-repeat;}
#oam_custom_menu_schedule:hover div.wp-menu-image {background:transparent url(images/schedule_icon.png) 0px -90px no-repeat;}



#oam_menu-posts-email-template div.wp-menu-image {background:transparent url(images/email_notifications_icon.png) 0px 0px no-repeat;}
#oam_menu-posts-email-template:hover div.wp-menu-image {background:transparent url(images/email_notifications_icon.png) 0px -90px no-repeat;}

#oam_menu-posts-qa_faqs div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_menu-posts-qa_faqs:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}

#oam_toplevel_page_nextgen-gallery div.wp-menu-image {background:transparent url(images/gallery_icon.png) 0px 0px no-repeat;}
#oam_toplevel_page_nextgen-gallery:hover div.wp-menu-image {background:transparent url(images/gallery_icon.png) 0px -90px no-repeat;}

#oam_toplevel_page_testimonials-widget div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;} 
#oam_toplevel_page_testimonials-widget:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}

#oam_toplevel_page_optionsframework div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_toplevel_page_optionsframework:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}

#oam_toplevel_page_cleverness-to-do-list div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_toplevel_page_cleverness-to-do-list:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}

#oam_toplevel_page_ezpz_ocb div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_toplevel_page_ezpz_ocb:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}

#oam_toplevel_page_jetpack div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_toplevel_page_jetpack:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}

#oam_toplevel_page_ud_log div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_toplevel_page_ud_log:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}



#oam_menu-site div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_menu-site:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}
#oam_menu-dashboard div.wp-menu-image {background:transparent url(images/dashboard_icon.png) 0px 0px no-repeat;}
#oam_menu-dashboard:hover div.wp-menu-image {background:transparent url(images/dashboard_icon.png) 0px -90px no-repeat;}
#oam_menu-posts-news div.wp-menu-image {background:transparent url(images/blog_icon.png) 0px 0px no-repeat;}
#oam_menu-posts-news:hover div.wp-menu-image {background:transparent url(images/blog_icon.png) 0px -90px no-repeat;}
#oam_menu-media div.wp-menu-image {background:transparent url(images/media_icon.png) 0px 0px no-repeat;}
#oam_menu-media:hover div.wp-menu-image {background:transparent url(images/media_icon.png) 0px -90px no-repeat;}
#oam_menu-links div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_menu-links:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}
#oam_menu-pages div.wp-menu-image {background:transparent url(images/pages_icon.png) 0px 0px no-repeat;}
#oam_menu-pages:hover div.wp-menu-image {background:transparent url(images/pages_icon.png) 0px -90px no-repeat;}
#oam_menu-comments div.wp-menu-image {background:transparent url(images/comments_icon.png) 0px 0px no-repeat;}
#oam_menu-comments:hover div.wp-menu-image {background:transparent url(images/comments_icon.png) 0px -90px no-repeat;}
#oam_menu-appearance div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_menu-appearance:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}
#oam_menu-plugins div.wp-menu-image {background:transparent url(images/plugins_icon.png) 0px 0px no-repeat;}
#oam_menu-plugins:hover div.wp-menu-image {background:transparent url(images/plugins_icon.png) 0px -90px no-repeat;}
#oam_menu-users div.wp-menu-image {background:transparent url(images/users_icon.png) 0px 0px no-repeat;}
#oam_menu-users:hover div.wp-menu-image {background:transparent url(images/users_icon.png) 0px -90px no-repeat;}
#oam_menu-tools div.wp-menu-image {background:transparent url(images/tools_icon.png) 0px 0px no-repeat;}
#oam_menu-tools:hover div.wp-menu-image {background:transparent url(images/tools_icon.png) 0px -90px no-repeat;}
#oam_menu-update div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px 0px no-repeat;}
#oam_menu-update:hover div.wp-menu-image {background:transparent url(images/menu_default_icon.png) 0px -90px no-repeat;}
#oam_menu-settings div.wp-menu-image {background:transparent url(images/settings_icon.png) 0px 0px no-repeat;}
#oam_menu-settings:hover div.wp-menu-image {background:transparent url(images/settings_icon.png) 0px -90px no-repeat;}

/**
#ozhmenu img.wp-menu-image {float:<?php echo $dir; ?>;opacity:0.6;padding:5px 1px 0;filter:alpha(opacity=60);}/**/

#ozhmenu .ozhmenu_toplevel:hover img.wp-menu-image {opacity:1;filter:alpha(opacity=100);}

/**/



/* Mu Specific */
#ozhmumenu_head {
	color:#bbb;
	font-weight:bolder;
}
#ozhmumenu_head #all-my-blogs {
	position:relative;
	top:0px;
	background:#ffa;
	color:#000;
}
#ozhmenu #oam_bloglink a {
	font-weight:bolder;
	color:#fff;
}
/* Just for IE7 */
#wphead {
	#border-top-width: 31px;
}
#media-upload-header #sidemenu { display: block; }


<?php if (!$display_fav) { ?>
/* Hide favorite actions */
#favorite-actions {display:none;}
<?php } ?>

<?php if ($minimode) { ?>
/* Hide all header */
#wphead {display:none;}
<?php } ?>

<?php if ($hidebubble) { ?>
/* Hide "0" bubbles */
span.count-0 {display:none;}
<?php } ?>

<?php if ($icons) {
	require(dirname(__FILE__).'/icons.php');
?>
/* Icons */
#ozhmenu .ozhmenu_sublevel a {
	padding-<?php echo $dir; ?>:22px;
	background-repeat:no-repeat;
	background-position:<?php echo ($dir == 'left' ? '3px' : '97%'); ?> center;
}
.oam_plugin a {
	background-image:url(<?php echo $plugin; ?>images/cog.png);
}
#ozhmumenu .ozhmenu_sublevel a {background:#f60; /*background-image:url(<?php echo $plugin; ?>images/world_link.png);*/}
<?php
	foreach($wp_ozh_adminmenu['icon_names'] as $link=>$icon) {
		$link = wp_ozh_adminmenu_sanitize_id($link);
		$link = str_replace(array('.php','.','/'),array('','_','_'),$link);
		echo "#oamsub_$link a {background-image:url($plugin/images/$icon.png);}\n";
	}

} else { ?>
#ozhmenu .ozhmenu_sublevel a {padding-<?php echo $dir; ?>:5px;}
<?php } ?>


/**/