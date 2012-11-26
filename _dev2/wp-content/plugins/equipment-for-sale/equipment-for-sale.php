<?php
/*
Plugin Name: Equipments for sale
Version: 1.0.0
Description: Manage eqipments for sale
Author: D.N Udugala
*/

/** Path for Includes */
define('EQU_Path', plugin_dir_path( __FILE__ ));

/** Path for front-end links */
define('EQU_URL', plugin_dir_url( __FILE__ ));
require_once( 'includes/equipment-class.php' );
require_once( 'includes/frontend-class.php' );

// Initiate the plugin
if( class_exists('equipment_class') ) $equipment_class = new equipment_class();
add_action('init' , array('equipment_class', 'equipment_ini_class') );
add_action('admin_init' , array('equipment_class', 'equipment_ini_class') );
add_action("after_setup_theme", create_function('', 'new eqfs_frontend;'));
add_action("admin_menu", array('equipment_class', 'equipment_sale_admin_menu'));
add_action("admin_init", array('equipment_class', 'admin_ini'));
add_action('do_meta_boxes' , array('equipment_class', 'do_metabox') );
add_action('admin_enqueue_scripts', 'wpp_extend_header_js');
add_filter('map_meta_cap', array('equipment_class', 'eqfs_map_meta_cap'), 10, 4 );
add_action('admin_head', array('equipment_class', 'hide_buttons'));
		
//codes are in frontend-class.php
add_shortcode('equipment_for_sale_form', array('eqfs_frontend', 'fend_eqfs_form') );
add_action( 'eqfs_form_top' , array('eqfs_frontend', 'fend_eqfs_top_action'));


if ( is_admin() ) {
	if ( $_GET['page'] == 'equipment_settings' && isset($_POST['button-submit']) ){
		add_action('admin_init', array('equipment_class', 'update_eqfs_options') ); //Runs after WordPress has finished loading but before any headers are sent.
	} 
}
?>