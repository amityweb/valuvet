<?php
/*
Plugin Name: WP-Property-Alert
Author: Nuwinda Udugala
Description: Extention for WP-Property plugin and WP-Property-Extend for propert alerts
Version: 1.0.0
*/

/** This Version  */
define('WPA_Version', '1.0.0');
define('WPEA_ALERTS', 'wp_property_alert');
define('WP_ALERTS_SECURE', 'nv34ksj');


/** Get Directory - not always wp-property */
define('WPA_Directory', dirname(plugin_basename( __FILE__ )));

/** Path for Includes */
define('WPA_Path', plugin_dir_path( __FILE__ ));

/** Path for front-end links */
define('WPA_URL', plugin_dir_url( __FILE__ ));

// Global metabox Functions
include_once WPA_Path . 'core/alert_functions.php';


register_activation_hook( __FILE__, 'wpa_install' );
register_deactivation_hook( __FILE__, 'wpa_uninstall' );


add_action("init", 'wpa_init');
add_action("admin_menu", 'wpa_admin_init');
add_shortcode('link_subscribe_property_alert', 'link_subscribe_property_alert' );
add_action( 'wp_ajax_wpa_subscribe_alerts', 'prefix_ajax_wpa_subscribe_alerts' );
add_action( 'wp_ajax_nopriv_wpa_subscribe_alerts', 'prefix_ajax_wpa_subscribe_alerts' );


if ( is_admin() ) {
	if ( $_GET['page'] == 'alert_settings' && isset($_POST['button-submit']) ){
		add_action('admin_init', 'update_wpa_settings_metabox' ); //Runs after WordPress has finished loading but before any headers are sent.
	} 
	if ( $_GET['page'] == 'alert_subscriptions' && isset($_POST['button-submit']) ){
		add_action('admin_init', 'update_wpa_subscriptions_metabox' ); //Runs after WordPress has finished loading but before any headers are sent.
	} 
}



	/**
	 * Install plugin on plugin activation
	 */
	function wpa_install() {
		global $wpdb;
			if( $wpdb->get_var("SHOW TABLES LIKE '".WPEA_ALERTS."'") != WPEA_ALERTS ) {
				$sql ="CREATE TABLE ".WPEA_ALERTS." (
							id INT NOT NULL AUTO_INCREMENT,
							name VARCHAR( 60 ) NOT NULL ,
							email VARCHAR( 100 ) NOT NULL ,
							status ENUM( 'true', 'false' ) NOT NULL DEFAULT 'false',
							secure varchar(64) DEFAULT NULL,
							PRIMARY KEY (id),
							UNIQUE KEY (id) );";
				$wpdb->query($sql);
			}
	}
	
	

	/**
	 * Uninstall plugin on plugin activation
	 */
	function wpa_uninstall() {
		global $wpdb;
		if($wpdb->get_var("SHOW TABLES LIKE '".WPEA_ALERTS."'") == WPEA_ALERTS ) {
			$sql = "DROP TABLE ". WPEA_ALERTS ." ";
			$wpdb->query($sql);
		}
	}
	

