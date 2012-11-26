<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){

// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "vv";

// Populate OptionsFramework option in array for use in theme
global $of_options;
$of_options = get_option('of_options');

$GLOBALS['template_path'] = OF_DIRECTORY;

//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
$categories_tmp = array_unshift($of_categories, "Select a category:");

//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('sort_column=post_parent,menu_order');
foreach ($of_pages_obj as $of_page) {
    $of_pages[$of_page->ID] = $of_page->post_name; }
$of_pages_tmp = array_unshift($of_pages, "Select a page:");

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center");

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post");

//Testing
$options_select = array("one","two","three","four","five");
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");

//Stylesheets Reader
$alt_stylesheet_path = VV_FILEPATH . '/css/skins/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');

function get_content_page_posts_array(){
	global $wpdb;
	$querystr = "
	  SELECT PO.ID,PO.post_title
	  FROM $wpdb->posts AS PO 
	  LEFT JOIN $wpdb->postmeta AS PM
	  ON PO.ID = PM.post_id 
	  WHERE 
	  PO.post_status = 'publish' 
	  AND PO.post_type = 'page'
	  AND PO.post_date < NOW()
	  GROUP BY PO.ID
	  ORDER BY PO.post_date DESC
	";

	return $wpdb->get_results($querystr, OBJECT);
}



$dataarray=array();


	$page_contents = get_content_page_posts_array();
	if ($page_contents):
		foreach ($page_contents as $post):
			$dataarray[$post->ID] = $post->post_title;
		endforeach;
	endif;

	
// Set the Options Array
$options = array(); 
$options[] = array( "name" => "General",
                    "type" => "heading");
					

$options[] = array( "name" => "Home page content post type ID",
					"desc" => "Select home page content page id. ",
					"id" => $shortname."_home_page_content_id",
					"std" => "",
					"type" => "select2",
					"options" => $dataarray);
				
$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px ico image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload");


$options[] = array( "name" => "Javascript Code / Google Analytics",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");
					
					
$options[] = array( "name" => "Styling",
                    "type" => "heading");


$options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");
					

					
$options[] = array( "name" => "Google Maps",
                    "type" => "heading");
					

$options[] = array( "name" => "Google map address for contact us page",
					"desc" => "Google map address ",
					"id" => $shortname."_gmap_address_contact",
					"std" => "",
					"type" => "textarea");


$options[] = array( "name" => "Contact Us",
                    "type" => "heading");
					
$options[] = array( "name" => "Pages contact us content",
					"desc" => "Located at contact us on every page",
					"id" => $shortname."_pcontactus_id",
					"std" => "1",
					"type" => "select2",
					"options" => $dataarray);


$options[] = array( "name" => "Contact us page content",
					"desc" => "Located in contact us page middle left side. Before the contact us form",
					"id" => $shortname."_contactus_id",
					"std" => "1",
					"type" => "select2",
					"options" => $dataarray);


$options[] = array( "name" => "Contact us success message for property listing",
					"desc" => "Success message for property listing contact us",
					"id" => $shortname."_propertylisting_contact_sucess_message",
					"std" => "Thank you for your feedback.",
					"type" => "textarea");


$options[] = array( "name" => "Send property contact to",
					"desc" => "Email all the property contacts to this email (also sends email to property owner)",
					"id" => $shortname."_feedback_email",
					"std" => "",
					"type" => "text");


$options[] = array( "name" => "Property Options",
                    "type" => "heading");
					
$options[] = array( "name" => "Maximum number of images",
					"desc" => "Located at contact us on every page",
					"id" => $shortname."_max_images_uploads",
					"std" => "1",
					"type" => "text");


$options[] = array( "name" => "Property type select page",
					"desc" => "Upload using media, copy and paste the link",
					"id" => $shortname."_property_type_select_page",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Default property thumb image",
					"desc" => "Upload using media, copy and paste the link",
					"id" => $shortname."_default_thumb",
					"std" => "",
					"type" => "text");



						


update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>