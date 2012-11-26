<?php

/* These are functions specific to the included option settings and this theme */

/*-----------------------------------------------------------------------------------*/
/* Theme Header Output - wp_head() */
/*-----------------------------------------------------------------------------------*/

// This sets up the layouts and styles selected from the options panel

if (!function_exists('optionsframework_wp_head')) {
	function optionsframework_wp_head() { 
		$shortname =  get_option('of_shortname');
	    
		//Styles
		 if(!isset($_REQUEST['style']))
		 	$style = ''; 
		 else 
	     	$style = $_REQUEST['style'];
	     if ($style != '') {
			  $GLOBALS['stylesheet'] = $style;
	          echo '<link href="'. OF_DIRECTORY .'/css/skins/'. $GLOBALS['stylesheet'] . '.css" rel="stylesheet" type="text/css" />'."\n"; 
	     } else { 
	          $GLOBALS['stylesheet'] = get_option('of_alt_stylesheet');
	          if($GLOBALS['stylesheet'] != '')
	               echo '<link href="'. OF_DIRECTORY .'/css/skins/'. $GLOBALS['stylesheet'] .'" rel="stylesheet" type="text/css" />'."\n";         
	          else
	               echo '<link href="'. OF_DIRECTORY .'/css/skins/default.css" rel="stylesheet" type="text/css" />'."\n";         		  
	     }       
			

	}
}

add_action('wp_head', 'optionsframework_wp_head');


/*-----------------------------------------------------------------------------------*/
/* Add Favicon
/*-----------------------------------------------------------------------------------*/

function childtheme_favicon() {
		$shortname =  get_option('of_shortname'); 
		if (get_option($shortname . '_custom_favicon') != '') {
	        echo '<link rel="shortcut icon" href="'.  get_option('of_custom_favicon')  .'"/>'."\n";
	    }
		else { ?>
	<link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory') ?>/images/favicon.ico" />
<?php }
}

add_action('wp_head', 'childtheme_favicon');

/*-----------------------------------------------------------------------------------*/
/* Show analytics code in footer */
/*-----------------------------------------------------------------------------------*/

function childtheme_analytics(){
	$shortname =  get_option('of_shortname');
	$output = get_option($shortname . '_google_analytics');
	if ( $output <> "" ) 
		echo stripslashes($output) . "\n";
}
add_action('wp_footer','childtheme_analytics');

?>
