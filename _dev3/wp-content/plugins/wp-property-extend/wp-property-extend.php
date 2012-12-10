<?php
/*
Plugin Name: WP-Property-Extend
Author: Nuwinda Udugala
Description: Extention for WP-Property plugin. WP-Property-Extend contains subscribers access to property listings and management
Version: 1.0.0
*/

/** This Version  */
define('WPE_Version', '1.0.0');

/** Get Directory - not always wp-property */
define('WPE_Directory', dirname(plugin_basename( __FILE__ )));

/** Path for Includes */
define('WPE_Path', plugin_dir_path( __FILE__ ));

/** Path for front-end links */
define('WPE_URL', plugin_dir_url( __FILE__ ));

/** Directory path for includes of template files  */
define('WPE_Templates', WPE_Path . 'templates');

// Global Usability Dynamics Functions
include_once WPE_Path . 'core/user_functions.php';

// Global user menu Functions
include_once WPE_Path . 'core/user-menu.php';

// Global metabox Functions
include_once WPE_Path . 'core/property_metaboxes.php';

// Property images overview
include_once WPE_Path . 'core/property_overviews.php';
// Property images overview
include_once WPE_Path . 'core/wppe_widget.php';


add_action("admin_init", 'wpp_extend_admin_init');

//REMOVE FEATURED IMAGE FROM SIDEBAR TO CENTER
function featuredimage_box_shift(){
	global $pagenow, $_wp_theme_features;
	if( $pagenow == 'post.php' || $pagenow == 'post-new.php' ){
		remove_meta_box( 'postimagediv', 'property', 'side' );
		remove_meta_box( 'content-permissions-meta-box', 'property', 'advanced' );
	}
}
add_action( 'do_meta_boxes' , 'featuredimage_box_shift' );
add_filter( 'wpp_get_search_filters' , 'wppe_wpp_get_search_filters' );
