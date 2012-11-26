<?php
// INCLUDE IMPORTANT FILES
if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('VV_FILEPATH', TEMPLATEPATH);
	define('OF_DIRECTORY', get_bloginfo('template_directory'));
} else {
	define('VV_FILEPATH', STYLESHEETPATH);
	define('OF_DIRECTORY', get_bloginfo('stylesheet_directory'));
}





require_once (VV_FILEPATH . '/functions/myshortcodes.php');
require_once (VV_FILEPATH . '/functions/custom-posts.php');
require_once (VV_FILEPATH . '/functions/sidebar.php');
require_once (VV_FILEPATH . '/functions/tinymce/shortcode_button.php');
require_once (VV_FILEPATH . '/functions/mywidgets.php');
require_once (VV_FILEPATH . '/functions/theme-admin/admin-functions.php');
require_once (VV_FILEPATH . '/functions/theme-admin/admin-interface.php');
require_once (VV_FILEPATH . '/functions/theme-admin/theme-options.php');
require_once (VV_FILEPATH . '/functions/theme-admin/theme-functions.php');


// REMOVE JUNK FROM HEAD
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'recent_comments');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_footer', 'rsd_link');
	
function excerpt($limit) {
	  $excerpt = explode(' ', get_the_excerpt(), $limit);
	  if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	  } else {
		$excerpt = implode(" ",$excerpt);
	  }	
	  //$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  //$content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
 //$content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

function new_excerpt_length($length) {
	return 150;
}
add_filter('excerpt_length', 'new_excerpt_length');

if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
	
	if ( function_exists( 'add_image_size' ) ) {
    	add_image_size('gallery-thumb-image', 200, 150 );
    	add_image_size('page-main-image', 959, 356, true);
	}
} 


// custom menu support
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'header_menu' => 'Header Menu',
		  'footer_menu' => 'Footer Menu'
		)
	);
}




add_filter( 'nav_menu_css_class', 'additional_active_item_classes', 10, 2 );

function additional_active_item_classes($classes = array(), $menu_item = false){

if(in_array('current_page_item', $menu_item->classes)){
$classes[] = 'current_page_item current';
}
if(in_array('current-menu-parent', $menu_item->classes)){
$classes[] = 'current-menu-parent current';
}
return $classes;
}




function valuvet_menu_set( $array ){
	$my_menu = wp_nav_menu( $array );
	$item = preg_replace('/<a>(.*)<\/a>/','$1',$my_menu);
	echo $item;
}

function valuvet_header_scripts() {
//    wp_deregister_script( 'jquery' );
    wp_enqueue_script( 'jquery' );

    wp_register_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js' );
    wp_enqueue_script( 'jquery-validate' );
	
    wp_register_script( 'jquery-inputfocus', get_template_directory_uri() . '/js/jquery.inputfocus-0.9.min.js' );
    wp_enqueue_script( 'jquery-inputfocus' );

	wp_enqueue_style('fancybox-style', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css');
	wp_enqueue_style('buttons-style', get_template_directory_uri() . '/css/button.css');
	
	wp_register_script( 'fadeslideshow', get_template_directory_uri() . '/js/fadeslideshow.js' );
    wp_enqueue_script( 'fadeslideshow' );
        
    wp_register_script( 'fadeslideshow-setup', get_template_directory_uri() . '/js/fadeslideshow_setup.js' );
    wp_enqueue_script( 'fadeslideshow-setup' );
}  
add_action('wp_enqueue_scripts', 'valuvet_header_scripts');


function footer_script(){

    wp_register_script( 'mootool-core', get_template_directory_uri() . '/menu/mootools-1.3-core.js' );
    wp_enqueue_script( 'mootool-core' );
    wp_register_script( 'mootool-more', get_template_directory_uri() . '/menu/mootools-1.3-more.js' );
    wp_enqueue_script( 'mootool-more' );
    wp_register_script( 'dropMenu2', get_template_directory_uri() . '/menu/dropMenu2.js' );
    wp_enqueue_script( 'dropMenu2' );
    wp_register_script( 'morphlist', get_template_directory_uri() . '/menu/morphlist_1.2.js' );
    wp_enqueue_script( 'morphlist' );
    wp_register_script( 'viewer', get_template_directory_uri() . '/menu/viewer.js' );
    wp_enqueue_script( 'viewer' );
	
    wp_register_script( 'messages', get_template_directory_uri() . '/js/messages.js' );
    wp_enqueue_script( 'messages' );
    wp_register_script( 'site', get_template_directory_uri() . '/js/site.js' );
    wp_enqueue_script( 'site' );
    wp_register_script( 'toogle', get_template_directory_uri() . '/menu/toogle.js' );
    wp_enqueue_script( 'toogle' );
	
    wp_register_script( 'fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.js' );
    wp_enqueue_script( 'fancybox' );
	
    wp_register_script( 'common-script', get_template_directory_uri() . '/js/common_script.js' );
    wp_enqueue_script( 'common-script' );
    
    

    
}


add_action('wp_footer', 'footer_script');

// remove all dashboard items
function remove_dashboard_widgets(){
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


function array_init( $array, $options ){
	foreach( $array as $key => $value ){
		if( !array_key_exists( $key, $options ) ){
			$options[$key] = $value;
		}
	}
	return $options;
}


function set_money_format( $number, $options=array() ){
	$optarray = array('echo' => false, 'currency' => 'en_US', 'showcurrencty' => false );
	$options = array_init($optarray, $options );
	
	setlocale(LC_MONETARY, $options['currency'] );
	$showcurrency = ( $options['showcurrencty'] ) ? '' : '!';
	if( function_exists( 'money_format' ) ){
		$return = money_format('%'.$showcurrency.'i' , $number);
	} else {
		$return = number_format( $number, 2, ".", '' );
	}
	if( $options['echo'] ) {
		echo $return;
	} else {
		return $return;
	}
}



if ( ! function_exists( 'valuvet_posted_on' ) ) :
/**

 */
function valuvet_posted_on() {
	printf( __( '<span class="post_date">Posted : %1$s | Updated : %2$s </span>', 'valuvet' ),
		strtoupper( get_the_modified_date('d M Y') ),
		strtoupper( get_the_modified_date('d M Y') )
	);
}
endif;


function valuvet_show_admin_info(){
	global $post;
	echo '
	<div class="admin_information">
		<div class="admin_info"><strong>Administrator Information</strong></div>
		<strong>Package Type : </strong>'.$post->property_type_label.'<br />
		<strong>Property Status : </strong>'. ucfirst( $post->post_status ).'
	</div>';
}

function valuvet_property_state_full( $state, $echo=true ){
	$statelabel = '';
	switch( $state ){
		case 'NT':
			$statelabel = 'Northern Territory';
			break;
		case 'VIC':
			$statelabel = 'Victoria';
			break;
		case 'ACT':
			$statelabel = 'Australian Capital Territory';
			break;
		case 'NSW':
			$statelabel = 'New South Wales';
			break;
		case 'QLD':
			$statelabel = 'Queensland';
			break;
		case 'SA':
			$statelabel = 'South Australia';
			break;
		case 'TAS':
			$statelabel = 'Tasmania';
			break;
		default:
			$statelabel = 'Western Australia';
			break;
	}
	
	if( $echo ) {
		echo $statelabel;
	} else {
		return $statelabel;
	}
}

function valuvet_get_property_ID( $property, $echo=true){
	$defaults = array( 'ID' => '', 'property_type' => 'package_1', 'practice_state' => '' );
	$todo = wp_parse_args($property, $defaults);
		
		
	if( $todo['property_type']=='package_3' ) {
	  $propertyid = 'S'.$todo['ID'];
	} else {
	  $propertyid = 'S'.$todo['ID'];
	}
	if( $echo ) {
		echo $propertyid;
	} else {
		return $propertyid;
	}
}

//Manage Your Media Only. and remove the Media link 
function valuvet_query_useronly( $wp_query ) {
  	global $pagenow;
    if ( $pagenow=='upload.php' || $pagenow=='media-upload.php' ) {
        if ( current_user_can( 'propertysubscriber' ) || current_user_can( 'registereduser' ) ) {
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
        }
    }

}
add_filter('parse_query', 'valuvet_query_useronly' );





function valuvet_initialize(){

}
add_action('init', 'valuvet_initialize');


function process_valuvet_shortcode( $content, $notify_data ){
	foreach($notify_data as $key => $value){
		if( strstr($content,$key ) ){
			$content = str_replace(  $key, $value, $content );
		}
	}
	return $content;
}

function checkEmail($email) {
  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
    list($username,$domain)=split('@',$email);
    return true;
  }
  return false;
}



function get_valuvet_notify_email_template( $templage, $notify_data ){
	$template = get_category_by_slug( $templage );	
	$post = get_post( $template->cat_name );
	$pcontent['message'] = process_valuvet_shortcode( $post->post_content,$notify_data );
	$pcontent['subject'] = $post->post_title;
	return $pcontent;
}


function get_valuvet_notify_email_template_byid( $id, $notify_data ){
	$post = get_post( $id );
	$pcontent['message'] = process_valuvet_shortcode( $post->post_content,$notify_data );
	$pcontent['subject'] = $post->post_title;
	return $pcontent;
}



//AJAX CALL FOR PAGE CONTACT US  FORM
function prefix_ajax_process_contact_us() {
  check_ajax_referer( "contact_property_form" );
  $process=true;
  if( empty($_POST['yourname']) ){
	  $msg .= 'Please enter your name <br />';
	  $process = false;
  }
  if( empty($_POST['youremail']) ){
	  $msg .= 'Please enter your email <br />';
	  $process = false;
  }
  if( empty($_POST['enquiry']) ){
	  $msg .= 'Please enter your enquiry <br />';
	  $process = false;
  }
  
  if( !checkEmail($_POST['youremail']) ){
	  $msg .= 'Please enter correct email<br />';
	  $process = false;
  }

  if( $process ){
	  $feedbackemail = get_option('vv_feedback_email');
	  $admin_email = get_bloginfo( 'admin_email' );
	  $blogname = get_bloginfo( 'name' );
	  $admin_email = get_bloginfo( 'admin_email' );
	  $to = ( !empty( $_POST['myemail'] ) ) ?$_POST['myemail']:$admin_email;
	  $subject = get_bloginfo( 'name' ) .'ValuVet Property Lisiting Enquiry' ;
	  $message = 'Name : ' . strip_tags( $_POST['yourname'] ) . " \n" ;
	  $message .= 'Email : ' . strip_tags( $_POST['youremail'] ) . " \n" ;
	  $property_id = $_POST['property_id'];
//	  if( isset($_POST['cnumber']) ) $message .= '<br />Contact Number : ' . strip_tags( $_POST['cnumber'] );
	  $message .= 'Enquiry : ' . strip_tags( $_POST['enquiry'] ) . " \n" ;
		$header =  "From: $blogname <$admin_email>\n"; // header for php mail only
		$addtodo = array(
			'todo_title'       => 'New property contact message By : '. strip_tags( $_POST['yourname'] ) .'('. strip_tags( $_POST['youremail'] ) .')',
			'todo_propertyid'  => $property_id	);
		global $todo_class;
		$todo_class->insert_todo_item($addtodo);
		$logmessage = nl2br($message);
		$log = array( 'log_title' => $logmessage, 'log_propertyid' => $property_id, 'log_by' => 0 );
		$todo_class->insert_todo_log( $log );	
					
	  wp_mail( $to, $subject, $message, $header );
	  die('success');
  } else {
	  $nmsg = 'Please fill out all the inputs <br />' . $msg;
	  die($nmsg);
  }
}
 
add_action( 'wp_ajax_nopriv_process_contact_us', 'prefix_ajax_process_contact_us' );
add_action( 'wp_ajax_process_contact_us', 'prefix_ajax_process_contact_us' );


function valuvet_page_nav( $nav_id='topn' ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
?>