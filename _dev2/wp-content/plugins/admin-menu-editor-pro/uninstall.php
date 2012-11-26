<?php

/**
 * @author W-Shadow 
 * @copyright 2009
 *
 * The uninstallation script.
 */

if( defined( 'ABSPATH') && defined('WP_UNINSTALL_PLUGIN') ) {

	//Remove the plugin's settings
	delete_option('ws_menu_editor_pro');
	if ( function_exists('delete_site_option') ){
		delete_site_option('ws_menu_editor_pro');
	}
	//Remove update metadata
	delete_option('ame_pro_external_updates');
	
}

?>