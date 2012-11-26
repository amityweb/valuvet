<?php
/*
Plugin Name: Aus_Codes
Version: 3.0.0
Description: Manage australian post codes  for your system. Ideal for programmers
Author: D.N.N  Udugala
*/

define('AUSCODE_DB', 'geo_pcode_au');
require_once( 'includes/auscode_class.php' );
define('AUSCODE_Path', plugin_dir_path( __FILE__ ));

register_activation_hook( __FILE__, 'aus_code_install' );
register_deactivation_hook( __FILE__, 'aus_code_uninstall' );
function aus_code_install(){
	if( class_exists('auscode_class') ) $auscode_class = new auscode_class();
	$auscode_class->install();
}

function aus_code_uninstall(){
	if( class_exists('auscode_class') ) $auscode_class = new auscode_class();
	$auscode_class->uninstall();
}


add_action( 'init', 'auscode_loader' );
function auscode_loader(){
	global $auscode_class;
	if( class_exists('auscode_class') ) $auscode_class = new auscode_class();
}



?>