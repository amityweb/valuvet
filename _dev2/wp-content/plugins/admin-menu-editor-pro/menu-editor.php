<?php
/*
Plugin Name: Admin Menu Editor Pro
Plugin URI: http://wpplugins.com/plugin/146/admin-menu-editor-pro
Description: Lets you directly edit the WordPress admin menu. You can re-order, hide or rename existing menus, add custom menus and more. 
Version: 1.16
Author: Janis Elsts
Author URI: http://w-shadow.com/blog/
Slug: admin-menu-editor-pro
PluginAPI: http://w-shadow.com/custom-plugin-api/
*/

//Are we running in the Dashboard?
if ( is_admin() || (defined('DOING_CRON') && constant('DOING_CRON')) ) {

    //Load the plugin
    require 'includes/menu-editor-core.php';
    $wp_menu_editor = new WPMenuEditor(__FILE__, 'ws_menu_editor_pro');
    
    //Load Pro version extras
	$ws_me_extras_file = dirname(__FILE__).'/extras.php';
	if ( file_exists($ws_me_extras_file) ){
		include $ws_me_extras_file;
	}

}//is_admin()
?>