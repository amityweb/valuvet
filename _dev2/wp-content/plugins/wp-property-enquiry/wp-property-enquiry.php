<?php
/*
Plugin Name: WP-Property-Enquiry
Author: Nuwinda Udugala
Description: Extention for WP-Property plugin and WP-Property-Extend for propert enquiry
Version: 1.0.0
*/
define('WPPENQUIRE_DB', 'property_enquiry');

require_once( 'core/wppenquire_functions.php' );
/** Get Directory - not always wp-property */
define('WPA_Directory', dirname(plugin_basename( __FILE__ )));

register_activation_hook( __FILE__, 'wppenquire_install' );
register_deactivation_hook( __FILE__, 'wppenquire_uninstall' );

add_action('init' , 'wppenquire_init' );
add_action('admin_init' , 'wpea_metabox_functions' );
add_action('do_meta_boxes' , 'wppe_do_metabox' );

function wppe_valuvet_header_scripts() {
    wp_register_script( 'wppe_plugin', plugin_dir_url(__FILE__) . '/js/script.js' );
    wp_enqueue_script( 'wppe_plugin' );
}  

add_action( 'wp_enqueue_scripts', 'wppe_valuvet_header_scripts');
add_action( 'wp_ajax_process_bulk_enquiry', 'prefix_ajax_process_bulk_enquiry' );
add_action( 'wp_ajax_nopriv_process_bulk_enquiry', 'prefix_ajax_process_bulk_enquiry' );

//this is short code button
add_shortcode('request_property_evaluvation', 'request_property_evaluvation' );
add_action( 'wp_ajax_wpa_property_evaluvation', 'prefix_ajax_process_bulk_enquiry' );
add_action( 'wp_ajax_nopriv_property_evaluvation', 'prefix_ajax_process_bulk_enquiry' );