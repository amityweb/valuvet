<?php
/*
Name: Front End Property Submissions (FEPS)
Class: class_wpp_feps
Version: 1.3.2
Minimum Core Version: 1.35.0
Feature ID: 14
Description: Allow users to add properties from the front-end.
*/

add_action('wpp_pre_init', array('class_wpp_feps', 'wpp_pre_init'));
add_action('wpp_post_init', array('class_wpp_feps', 'wpp_post_init'));

class class_wpp_feps {

  /**
   * (custom) Capability to manage the current feature
   */
  static protected $capability = "manage_wpp_feps";

  /**
   * CRM Notification actions
   *
   * Available template tags you can use in WP CRM plugin for user natifications:
   *
   * For 'pending_property_approve':
   * - [user_email] Email where to send notification
   * - [display_name] User's name
   * - [url] Property url
   * - [title] Property title
   *
   * For 'pending_property_added':
   * - [user_email] Email where to send notification
   * - [pending_url] Pending Property url
   * - [title] Property title
   *
   * For 'pending_account_approved':
   * - [user_email] Email where to send notification
   * - [user_login] User's login
   * - [site_url] Current site url
   *
   */
  static protected $crm_notification_actions = array(
    'pending_property_approve' => 'FEPS: Pending Approval',
    'pending_property_added'   => 'FEPS: Property Submitted',
    'pending_account_approved' => 'FEPS: User Account Approved',
    'feps_use_account_created' => 'FEPS: User Account Created'
  );

  /**
   * Available property statuses
   * @var array
   */
  static protected $statuses = array( 'publish', 'pending', 'trash' );

  /**
   * Special functions that must be called prior to init
   *
   */
  function wpp_pre_init() {
    /** Add capability */
    add_filter("wpp_capabilities", array('class_wpp_feps', "add_capability"));

    /** Add CRM notification fire action */
    add_filter("wp_crm_notification_actions", array('class_wpp_feps', 'crm_custom_notification'));

    /** Register js/css for custom inputs design */
    wp_register_script('custom-inputs', WPP_URL . "third-party/customInputs/custom.inputs.js");
    wp_register_style ('custom-inputs', WPP_URL . "third-party/customInputs/custom.inputs.css");

    /** Register feps schedule events */
    self::feps_schedule_events();

  }

  /**
   * Primary feature function.  Ran an init level.
   *
   * @since 0.1
   */
  function wpp_post_init() {
    global $wp_properties;

    add_shortcode('wpp_feps_form', array('class_wpp_feps', 'wpp_feps_form'));

    /** Add FEPS shortcode form creation page under Properties nav menu */
    add_action("admin_menu", array("class_wpp_feps", "admin_menu"));

    add_filter("added_post_meta", array('class_wpp_feps', "handle_post_meta"), 10, 4);

    add_action("admin_init", array("class_wpp_feps", "admin_init"));

    add_action("template_redirect", array("class_wpp_feps", "template_redirect"));
    add_action("wpp_template_redirect", array("class_wpp_feps", "wpp_template_redirect"));

    //** Upload image */
    add_action("wp_ajax_wpp_feps_image_upload", array("class_wpp_feps", "ajax_feps_image_upload"));
    add_action("wp_ajax_nopriv_wpp_feps_image_upload", array("class_wpp_feps", "ajax_feps_image_upload"));
    
    //** Delete uploaded image */
    add_action("wp_ajax_wpp_feps_image_delete", array("class_wpp_feps", "ajax_feps_image_delete"));
    add_action("wp_ajax_nopriv_wpp_feps_image_delete", array("class_wpp_feps", "ajax_feps_image_delete"));

    add_action("wp_ajax_wpp_feps_email_lookup", create_function('', 'die(json_encode(class_wpp_feps::email_lookup($_REQUEST["user_email"],$_REQUEST["user_password"])));'));
    add_action("wp_ajax_nopriv_wpp_feps_email_lookup", create_function('', 'die(json_encode(class_wpp_feps::email_lookup($_REQUEST["user_email"],$_REQUEST["user_password"])));'));

    add_action("admin_enqueue_scripts", array('class_wpp_feps', "admin_enqueue_scripts"));

    add_action("post_updated", array('class_wpp_feps', "post_updated"), 10, 3);

    add_action("all_admin_notices", array('class_wpp_feps', "all_admin_notices"));

    //add_action( 'admin_bar_menu',  array('class_wpp_feps', "admin_bar_menu"), 100);

    add_filter("wpp_attribute_data", array('class_wpp_feps', "add_attribute_data"));

    add_filter("wpp_feps_input", array('class_wpp_feps', "wpp_feps_input"), 10, 2);

    add_filter("wpp_pending_template_query", array('class_wpp_feps', 'wpp_query_filter'), 10, 2);

    add_filter("authenticate", array('class_wpp_feps', 'authenticate'), 40, 3);

    add_filter("wpp_feps_property_statuses", array('class_wpp_feps', 'property_statuses'));

    add_action("wpp_feps_account_created", array('class_wpp_feps', 'account_created'), 10);

    /** Notifications */
    add_action("wpp_feps_submission_approved", array('class_wpp_feps', 'submission_approved'), 10, 2);
    add_action("wpp_feps_user_approved", array('class_wpp_feps', 'user_approved'));
    add_action("wpp_feps_submitted", array('class_wpp_feps', 'submission_notification'), 10, 2);

    add_filter("parse_query", array('class_wpp_feps', 'fix_404'));

    //** If WPP scripts being loaded globally, include FEPS scripts as well */
    if(!is_admin() && $wp_properties['configuration']['load_scripts_everywhere'] == 'true') {
      class_wpp_feps::feps_enqueue_scripts();
    }

  }

  /**
   * Handle pre-headers functions.
   *
   * @author potanin@ud
   */
  function admin_init() {

    if(wp_verify_nonce($_REQUEST['_wpnonce'], 'wpp_save_feps_page')) {
      //** Update settings and commit to DB */
      class_wpp_feps::save_feps_settings($_REQUEST['wpp_feps']);

      wp_redirect('edit.php?post_type=property&page=page_feps&message=updated');

    }

  }

  /**
   * Properly load FEPS required scripts
   * @author korotkov@ud
   */
  function feps_enqueue_scripts() {
    global $wp_properties, $wpp_runtime;

    if($wpp_runtime['feps']['scripts_loaded']) {
      return;
    }

    wp_enqueue_script('wp-property-global');
    wp_enqueue_script('jquery-validate');
    wp_enqueue_script('jquery-number-format');
    wp_enqueue_script('jquery-gmaps');
    wp_enqueue_script('jquery-ajaxupload');

    /** Use this only for FEPS with Denali installed */
    if ( strstr(get_option('template'), 'denali') ) {
      wp_enqueue_script('custom-inputs');
      wp_enqueue_style('custom-inputs');
    }

    wp_localize_script( 'jquery-ajaxupload', 'l10n', $wp_properties['l10n'] );

    $wpp_runtime['feps']['scripts_loaded'] = true;

  }

  /**
   * Ajax action to delete FEPS images
   * @author korotkov@ud
   */
  function ajax_feps_image_delete() {
    //** Get data from request */
    $session  = (int)$_REQUEST['session'];
    $filename = $_REQUEST['filename'];
    
    //** File location */
    $upload_dir = wp_upload_dir();
    $feps_session_files_dir = $upload_dir['basedir'] . '/feps_files/' . (string)$session . '/';
    
    //** Try to delete file */
    if ( unlink( $feps_session_files_dir.$filename ) )
      die( json_encode( array('success' => 1) ) );

    //** success - 0 if not deleted */
    die( json_encode( array('success' => 0) ) );
  }

  /**
   * Initialize FEPS schedule events
   *
   * @author korotkov@ud
   */
  function feps_schedule_events() {

    if ( !wp_next_scheduled( 'delete_feps_files' ) ) {
      wp_schedule_event( time(), 'hourly', 'delete_feps_files' );
    }

    add_action( 'delete_feps_files', array( 'class_wpp_feps', 'delete_feps_files' ) );

  }

  /**
   * Delete feps files if they are older then $seconds_old
   *
   * @param int $seconds_old
   * @return bool
   */
  function delete_feps_files( $seconds_old = 3600 ) {

    /** FEPS temp files dir */
    $uploads = wp_upload_dir();
    $feps_files_dir = $uploads['basedir'].'/feps_files/';

    /** Scan dir if it exists */
    if ( file_exists( $feps_files_dir ) && is_dir( $feps_files_dir ) ) {

     if ( $handle = opendir( $feps_files_dir ) ) {

       while (false !== ($file = readdir($handle))) {
         if ($file != "." && $file != "..") {

           $session_dir = $feps_files_dir.$file;
           /** If dir was modified more then 1 hour ago */
           if ( (int)(time() - filemtime( $session_dir )) > $seconds_old && is_dir( $session_dir ) ) {
             /** Delete it with files in it */
             WPP_F::delete_directory( $session_dir );
           }

         }
       }

       closedir($handle);
       return true;
     }

    } else {
     return false;
    }

  }


  /**
   * Ran after account created
   *
   * @param int $user_id
   * @param array $new_user
   * @param array $form_data
   * @author korotkov@ud
   */
  function account_created( $args = false ) {
    global $wp_post_statuses;

    extract( $args );

    //** If user data is not passsed, we get it now. $new_user should contain clear-text password */
    if( !$user_data && $user_id ) {
      $user_data = (array) get_userdata( $user_id );
      $user_data = (array) $user_data['data'];
    }

    if ( in_array( $form_data['new_post_status'], self::$statuses ) ) {
	  $bloginfo = get_bloginfo( 'name' );
	  $admin_email = get_bloginfo( 'admin_email' );
      $subject = $bloginfo. __(' - Account Created', 'wpp');



      switch( $form_data['new_post_status'] ) {
        default: break;
        case 'pending':
          update_user_meta( $user_id, 'is_not_approved', 1 );
          $message = sprintf( __('Hello.%1$s%1$sYour account on %2$s has been created and is waiting for approval.%1$s%1$sAccess data:%1$s%3$s / %4$s', 'wpp'), PHP_EOL, site_url(), $user_data['user_login'], $new_user['user_pass']);
          break;
        case 'trash':
          update_user_meta( $user_id, 'is_not_approved', 1 );
          $message = sprintf( __('Hello.%1$s%1$sYour account on %2$s has been created and is waiting for approval.%1$s%1$sAccess data:%1$s%3$s / %4$s', 'wpp'), PHP_EOL, site_url(), $user_data['user_login'], $new_user['user_pass']);
          break;
        case 'publish':
	         $message = sprintf( __('Hello.%1$s%1$sYour account on %2$s has been created.%1$s%1$sAccess data:%1$s%3$s / %4$s', 'wpp'), PHP_EOL, site_url(), $user_data['user_login'], $new_user['user_pass']);
          break;
	     }
	

      if ( function_exists('wp_crm_send_notification') ) {
        $notification_data = array();

        $post = get_post( $property_id );
        $notification_data['notification_type'] = __('User Account Created', 'wpp');
        $notification_data['user_email'] = $user_data['user_email'];
        $notification_data['display_name'] = ( !empty($user_data['first_name']) ) ?$user_data['first_name']:$user_data['display_name'];
        $notification_data['user_login'] = $new_user['user_login'];
        $notification_data['user_password'] = $new_user['user_pass'];

        $notification_data['system_message'] = $message;

        $notification_data['url'] = get_post_permalink( $property_id );
        $notification_data['title'] = $post->post_title;
        $notification_data['status'] = $wp_post_statuses[$form_data['new_post_status']]->label;

        wp_crm_send_notification( 'feps_use_account_created', $notification_data );

        //** Add message to user activity stream */
        wp_crm_add_to_user_log( $user_id, sprintf(__('User account created via FEPS property submission of (%1s).', 'wpp'), $post->post_title) );

      }

      //** Do not send notification if specifically disabled */
      if($form_data['notifications']['user_creation'] != 'disable') {
		  
		$notify_data = array(
							   "{AUTHOR_EMAIL}" => $user_data['user_email'],
							   "{AUTHOR_FIRST_NAME}" => ( !empty($user_data['first_name']) ) ?$user_data['first_name']:$user_data['display_name'],
							   "{AUTHOR_LAST_NAME}" => $user_data['last_name'],
							   "{AUTHOR_USERNAME}" => $user_data['user_login'],
							   "{AUTHOR_PASSWORD}" => $new_user['user_pass']
							   );
		$data = get_valuvet_notify_email_template('property_subscriber_account_created', $notify_data);
		$admin_email = get_bloginfo( 'admin_email' );
		$header =  "From: $bloginfo <$admin_email>\n"; // header for php mail only
        wp_mail( $user_data['user_email'], sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header );
		
		
		$data = get_valuvet_notify_email_template('property_subscriber_account_created_admin', $notify_data);
		$admin_email = get_bloginfo( 'admin_email' );
		$header =  "From: $bloginfo <$admin_email>\n"; // header for php mail only
        wp_mail( $admin_email, sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header );
      }

    }
  }

  /**
   * Set available property statuses
   * @param array $current
   * @return array
   * @author korotkov@ud
   */
  function property_statuses( $current ) {

    $return   = array();

    foreach( self::$statuses as $status_slug ) {
      $return[ $status_slug ] = $current[ $status_slug ];
    }

    ksort( $return );

    return $return;
  }

  /**
   * Run after submission approving
   * @param object $user
   * @param int $post_id
   * @author korotkov@ud
   */
  function submission_approved( $user, $post_id ) {
    global $wp_post_statuses;

    if ( function_exists('wp_crm_send_notification') ) {
      $notification_data = array();

      $post = get_post( $post_ID );

      $notification_data['notification_type'] = __('Submission Approved', 'wpp');
      $notification_data['user_email']   = $user->user_email;
      $notification_data['display_name'] = $user->display_name;
      $notification_data['url']          = get_post_permalink( $post_ID );
      $notification_data['title']        = $post->post_title;
      $notification_data['status'] = @$wp_post_statuses[get_post_status($post_id)]->label;

      wp_crm_send_notification( 'pending_property_approve', $notification_data );

      wp_crm_add_to_user_log( $user->ID, sprintf(__('User-submitted property (%1s) approved and published.', 'wpp') , $post->post_title) );

    }

  }

  /**
   * Run after user's account approving
   * @param object $user
   * @author korotkov@ud
   */
  function user_approved( $user ) {

    if ( function_exists('wp_crm_send_notification') ) {
      $notification_data = array();

      $post = get_post( $post_ID );

      $notification_data['notification_type'] = __('User Account Approved', 'wpp');
      $notification_data['user_email']   = $user->user_email;
      $notification_data['user_login'] = $user->user_login;
      $notification_data['site_url']     = site_url();

      wp_crm_send_notification( 'pending_account_approved', $notification_data );
    }

  }

  /**
   * Run after property added
   * @param int $user_id
   * @param array $return
   * @author korotkov@ud
   */
  function submission_notification( $return ) {
    global $wp_post_statuses;

    $user_id = $return['user_id'];

    if ( function_exists('wp_crm_send_notification') ) {
      $notification_data = array();

      $user = get_user_by('id', $user_id);

      $pending_hash = $return['status'] != 'publish' ? '&pending_hash='.$return['pending_hash'].'&wpp_front_end_action=wpp_view_pending' : '';

      $notification_data['notification_type'] = __('Submission Received', 'wpp');
      $notification_data['display_name'] = $user->display_name;
      $notification_data['user_email'] = $user->user_email;
      $notification_data['pending_url'] = $return['redirect_url'].$pending_hash;
      $notification_data['title'] = $return['post_title'];
      $notification_data['status'] = $wp_post_statuses[$return['status']]->label;

      wp_crm_send_notification( 'pending_property_added', $notification_data );
      wp_crm_add_to_user_log( $user_id, sprintf(__('User submitted property (%1s) using FEPS.', 'wpp'), $return['post_title']) );

    }

    return $return;

  }

  /**
   * Handles property actions when a property is saved
   *
   * @todo Check capabilities that current user has the authority to publish a FEPS post
   * @param type $post_ID
   * @param type $post_after
   * @param type $post_before
   */
  function post_updated($post_ID, $post_after, $post_before) {

    if( ( $post_before->post_status == 'pending' || $post_before->post_status == 'trash' )
      && $post_after->post_status == 'publish'
        && get_post_meta($post_ID, 'wpp_feps_property', true)) {

        //** FEPS property being changed from pending to publish */
        delete_post_meta($post_ID, 'wpp_feps_pending_publish');

        //** Remove pending_hash from post */
        delete_post_meta($post_ID, 'wpp_feps_pending_hash');

        //** Activate user account after submission approving */
        $user = get_userdata( $post_after->post_author );
        if ( !empty( $user->is_not_approved ) ) {
          delete_user_meta( $post_after->post_author, 'is_not_approved' );
          do_action('wpp_feps_user_approved', $user);
        }

        // Action on submission approving
        do_action('wpp_feps_submission_approved', $user, $post_ID);

    }

  }


  /**
   * Look up e-mail address
   * @global object $current_user
   * @param string $user_email
   * @param string $user_password
   * @return array
   */
  function email_lookup($user_email, $user_password) {
    global $current_user;

    if ( !empty( $current_user->ID ) ) {
      return array('email_exists' => 'true', 'credentials_verified' => 'true');
    }

    if(!empty($user_email) && $user_id = email_exists($user_email)) {

      //* If password is passed, verify */
      if(!empty($user_password)) {

      $userdata = get_user_by('id', $user_id);

      if(wp_check_password($user_password, $userdata->user_pass, $user_id)) {
        return array('email_exists' => 'true', 'credentials_verified' => 'true');
      } else {
        return array('email_exists' => 'true', 'invalid_credentials' => 'true');
      }

      } else {
        return array('email_exists' => 'true');
      }

    } else {
      return array('email_exists' => 'false');
    }

  }

  /**
   * Adds Custom capability to the current premium feature
   * @param array $capabilities
   * @author korotkov@ud
   * @return array
   */
  function add_capability($capabilities) {

    $capabilities[self::$capability] = __('Manage FEPS', 'wpp');

    return $capabilities;
  }

  /**
   * Displays notices on pending property pages on admin
   * @todo Just do it. Update curent_user_can when WPP specific capabilities are setup
   * @since 0.1
   */
  function admin_bar_menu($wp_admin_bar) {
    global $post;

    if($post->post_type = 'property' && $post->post_status = 'pending' && current_user_can('publish_pages')) {

    }
    $wp_admin_bar->add_menu( array(
      'id' => 'wpp_approve_property',
      'title' => __('Approve Listing', 'wpp'),
      'href' => get_permalink( $post->ID ) . '?wpp_approve_listing=true'
    ) );

  }

  /**
   * WPP template redirect.
   *
   * @todo Add a shortcode listener to wpp_template_redirect() in order detect if the current page has a FEPS form on it, if so, properly load the JS files. Also use wp_localize_script() so strings in fileuploader.js can be translated. - potanin@ud
   *
   * @global object $wp_query
   * @global object $post
   * @return null
   */
  function wpp_template_redirect() {
    global $wp_query, $post;

    if('wpp_view_pending' != $_REQUEST['wpp_front_end_action'] || !$wp_query->query_vars['p']) {
      return;
    }

    $maybe_post = WPP_F::get_property($wp_query->query_vars['p'], "return_object=true");

    if($_REQUEST['pending_hash'] != $maybe_post->wpp_feps_pending_hash) {
      return;
    }

    self::feps_enqueue_scripts();

    $post = $maybe_post;

    add_action("template_redirect_single_property", array("class_wpp_feps", "template_redirect_single_property"));

  }

  /**
   * Fix 404 error on pending property pages.
   *
   * @global object $query
   */
  function fix_404($query) {
    global $wp_query, $post;

    if('wpp_view_pending' != $_REQUEST['wpp_front_end_action'] || !$query->query_vars['p']) {
      return;
    }

    $maybe_post = WPP_F::get_property($wp_query->query_vars['p'], "return_object=true");

    if($_REQUEST['pending_hash'] != $maybe_post->wpp_feps_pending_hash) {
      return;
    }

    /** Set to override the 404 status */
    add_action('wp', create_function('', 'status_header( 200 );'));

    //** Prevent is_404() in template files from returning true */
    add_action('template_redirect', create_function('', ' global $wp_query; $wp_query->is_404 = false;'), 0, 10);

  }

  /**
   * Single Property template redirect
   *
   * Add all pending-property specific hooks and filters here.
   *
   * @global object $post
   * @global object $wp_query
   */
  function template_redirect_single_property() {
    global $post, $wp_query;

    add_action('wp_head', create_function('', "do_action('wp_head_single_property'); "));

    $wp_query = apply_filters( 'wpp_pending_template_query', $wp_query, $post );

    add_filter('the_title', array('class_wpp_feps', 'feps_the_title'), 0, 2);

    add_action('body_class', array('class_wpp_feps', 'feps_body_class'));

  }

  /**
   * Modify FEPS (unapproved property) title.
   *
   * @param string $title The current title of a property.
   * @param int $post_id The ID of the currently viewed property.
   * @return string
   */
  function feps_the_title( $title, $post_id = false) {
    global $post;

    //** Make sure only the globally displayed property */
    if($post->ID != $post_id) {
      return $title;
    }

    return $title . __(' (Pending Approval)', 'wpp');

  }

  /**
   * Add custom body class for feps pending properties
   *
   * @param array $classes
   * @return Array
   */
  function feps_body_class( $classes = array() ) {
    global $post;

    if($post_status = $post->post_status) {
      $classes[] = 'wpp_' . $post_status;
    }

    $classes[] = 'feps-pending';

    return $classes;

  }



/**
  * Main front-end function.
  *
  * Saves properties, and redirects user to pending page.
  *
  * @todo after a property is submitted, the submiter should be redirected to the property pending page on front-end. We need to generate some sort of nonce so a non-logged in user can view the property on front-end.
  * @todo do not recreate the template_functions because we may be excluding some files
  * @since 0.1
  */
  function template_redirect() {
    global $post;

    //** Detect if FEPS Page */
    if(WPP_F::detect_shortcode('wpp_feps_form')) {
      self::feps_enqueue_scripts();
    }

    if('wpp_submit_feps' != $_REQUEST['wpp_front_end_action']) {
      return;
    }

    if(!WPP_F::verify_nonce($_REQUEST['nonce'], 'submit_feps') ) {
      return;
    }

    if($result = class_wpp_feps::submit_property($_REQUEST['wpp_feps_data'])) {

      if ( $result['status'] == 'publish' ) {
        wp_redirect( $result['redirect_url'] );
        die();
      }

      if(!empty($result['redirect_url'])) {
        //** After a property is submitted, redirect to front-end page */
        wp_redirect($result['redirect_url'].'&pending_hash='.$result['pending_hash'].'&wpp_front_end_action=wpp_view_pending');
        die();
      }

    }


  }


/**
  * Saves the user submitted property
  *
  * @todo Currently user account is being created on submission with the role.  Not sure if this is correct, maybe it should be held until approval. - potanin@UD
  * @todo Add XSS and SQL-injection prevention
  *
  * @since 0.1
  */
  function submit_property($data = false) {
    global $current_user, $wp_properties, $wpp_feps_message;

    if(!$data) {
      return false;
    }

    //** Get form_ID */
    $forms = $wp_properties['configuration']['feature_settings']['feps']['forms'];

    //** Cycle through forms and match up with passed md5 hash */
    foreach($forms as $form_id => $form_data) {
      if(md5($form_id) == $data['form_id']) {
        $form_found = true;
        break;
      }
    }

    if(!$form_found) {
      $wpp_feps_message['success'] = false;
      $wpp_feps_message['message'] = __('An error occured, the form could not be found', 'wpp');
      return false;
    }

    if(is_user_logged_in()) {
      $r['credentials_verified'] = true;

      $current_user = wp_get_current_user();
      $user_id = $current_user->ID;

      if ( user_can( $user_id, 'publish_wpp_properties' ) ) {
        $form_data['new_post_status'] = 'publish';
      }

    }

    //** Verify user credentials if they are passed */
    if(!$r['credentials_verified'] && $data['user_email'] && $data['user_password']) {
      $user_id = email_exists($data['user_email']);
      if(wp_check_password($data['user_password'], get_user_by('email', $data['user_email'])->user_pass, $user_id)) {
        $r['credentials_verified'] = true;
      }
    }


    if(!$r['credentials_verified']) {

      //** We have a new user */
      $new_user['user_login'] = $data['user_email'];
      $new_user['role'] = $form_data['new_role'];
      $new_user['user_email'] = $data['user_email'];
      $new_user['first_name'] = $data['first_name'];
      $new_user['last_name'] = $data['surname'];
      $new_user['display_name'] = $data['first_name'];
      $new_user['user_pass'] = wp_generate_password();

      $user_id = wp_insert_user($new_user);

      if(is_wp_error($user_id)) {
        $wpp_feps_message['success'] = false;
        $wpp_feps_message['message'] = __('Your submission was not successful: ', 'wpp') . $user_id->get_error_message();
        return false;
      } else {
   		  update_usermeta( $user_id, 'contact_number', $data['contact_number'] );
		  update_usermeta( $user_id, 'add_enquery_phone', $data['advertisement_enquiry_contact_phone_number'] );
	  }

    }

    //** Setup essential post object information */
    $new_property = array(
      'post_content' => $data['post_content'],
      'post_parent'  => $data['parent_id'],
      // Prevent XSS. Wondered why WP did not do that inside of wp_insert_post();
      'post_title'   => htmlspecialchars( strip_tags( $data['post_title'] ) ),
      'post_author'  => $user_id,
      'post_status'  => $form_data['new_post_status'],
      'post_type'    => 'property'
    );

    //** Commit basic property data to databse */
    $property_id = wp_insert_post( $new_property );

    $return['status'] = $form_data['new_post_status'];

     //** Check for any issues inserting property */
    if(is_wp_error($property_id)) {
      $wpp_feps_message['success'] = false;
      $wpp_feps_message['message'] = $property_id->get_error_message();
      return false;
	}

    //** Mark property as FEPS */
    update_post_meta($property_id, 'wpp_feps_property', true);
    update_post_meta($property_id, 'wpp_feps_pending_publish', true);

    //** Set property type */
    update_post_meta($property_id, 'property_type', $data['property_type']);

    //** Set pending hash */
    $return['pending_hash'] = md5($property_id.$user_id);
    update_post_meta($property_id, 'wpp_feps_pending_hash', $return['pending_hash']);

    //** Cycle through attributes and commit them into appropriate place - i.e. meta to meta, images to uploads, etc.*/
    if ( !empty( $form_data['fields'] ) ) {
      foreach($form_data['fields'] as $attribute) {

        //** Check if an attribute has been passed */
        $attribute_data = WPP_F::get_attribute_data($attribute['attribute']);

        switch($attribute_data['storage_type']) {

          case 'meta_key':
            $value = $data[$attribute['attribute']];
            $meta_values[$attribute['attribute']] = $value;

            if($attribute_data['currency'] || $attribute_data['numeric']) {
              $value = str_replace(array("$", ","), '', $value);
            }

            if ( !is_array( $value ) ) {
              $value = strip_tags($value);
            }

            update_post_meta($property_id, $attribute['attribute'], $value);
          break;

          case 'post_table':
            //** Do nothing - already added by  wp_insert_post();
          break;

          case 'image_upload':

            //** Move over any uploaded images */
            $this_session = $data['this_session'];
            $upload_dir = wp_upload_dir();
            $feps_files_dir = $upload_dir['basedir'] . '/feps_files/' . $this_session;

            //** Check if a directory exists */
            if(is_dir($feps_files_dir)) {

              /** WordPress Image Administration API */
              require_once(ABSPATH . 'wp-admin/includes/image.php');

              /** WordPress Media Administration API */
              require_once(ABSPATH . 'wp-admin/includes/media.php');

              if ($handle = opendir($feps_files_dir)) {
                while (false !== ($file = readdir($handle))) {
                  if ($file != "." && $file != "..") {
                    if(file_is_valid_image($feps_files_dir . '/' . $file)) {
                      $moved_images[]  = class_wpp_feps::move_image($property_id, $feps_files_dir . '/' . $file);
                    }
                  }
                }

                //** Delete folder */
                unlink($feps_files_dir . '/index.php');
                rmdir($feps_files_dir);
              }

            }

          break;

          case 'taxonomy':
            //** Not yet supported - no UI for this */
            //wp_set_post_terms();
          break;

          default:
            do_action('wpp_feps_commit_attribute', $form_data);
          break;

        }
      }
    }


    if(!$r['credentials_verified']) {
      do_action( 'wpp_feps_account_created', array(
        'user_id' => $user_id,
        'new_user' => $new_user,
        'form_data' => $form_data,
        'property_id' => $property_id
      ));
    }

	$addtodo = array(
		'todo_title'       => 'New property submission',
		'todo_propertyid'  => $property_id	);
	global $todo_class;
	$todo_class->insert_todo_item($addtodo);
	wpe_submit_property( $property_id );
	process_featured_uploads($property_id, $user_id);
	process_gallery_uploads($property_id, $user_id);
	
	$user = get_userdata( $post_after->user_id );
    delete_user_meta( $user_id, 'is_not_approved' );
    do_action('wpp_feps_user_approved', $user);
			
    $return['redirect_url'] = get_permalink($property_id);
    $return['wpp_front_end_action'] = 'wpp_view_pending';
    $return['post_title'] = $data['post_title'];

    $return['form_id'] = $data['form_id'];
    $return['user_id'] = $user_id;
    $return['property_id'] = $property_id;

    $wpp_feps_submitted = apply_filters('wpp_feps_submitted', $return);

    if(!empty($wpp_feps_submitted)) {
      $return = $wpp_feps_submitted;
    }
	$post = get_post( $property_id );
	$address = google_map_address( $post );
	set_map_coordinates( $property_id,  $address );

	update_post_meta($property_id, 'random_945', $data['first_name'] );
	update_post_meta($property_id, 'random_420', $data['surname'] );
	update_post_meta($property_id, 'user_email', $data['user_email'] );

    return $return;

  }


/**
  * Moves images from temporary directory to real folder
  *
  * @since 0.1
  */
  function move_image($post_id, $old_path, $post_data = array()) {

    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    $uploads = wp_upload_dir($time);

    $original_filename = basename ($old_path);

    $filename = wp_unique_filename( $uploads['path'], $original_filename);

    $new_file = $uploads['path'] . "/$filename";

    $file_data = wp_check_filetype_and_ext($old_path, $original_filename);

    if(!rename($old_path, $new_file)) {
      return false;
    }

    // Set correct file permissions
    $stat = stat( dirname( $new_file ));
    $perms = $stat['mode'] & 0000666;
    @ chmod( $new_file, $perms );

    $moved_image = apply_filters( 'wpp_handle_upload', array(
      'file' => $new_file,
      'url' => $uploads['url'] . "/$filename",
      'type' => $file_data['type']
    ), 'upload' );


    // use image exif/iptc data for title and caption defaults if possible
    if ( $image_meta = @wp_read_image_metadata($new_file) ) {
      if ( trim( $image_meta['title'] ) && ! is_numeric( sanitize_title( $image_meta['title'] ) ) ) {
        $title = $image_meta['title'];
      }
      if ( trim( $image_meta['caption'] ) ) {
        $content = $image_meta['caption'];
      }
    }

    if(empty($image_meta['title'])) {
      $image_meta['title'] = preg_replace('/\.[^.]+$/', '', basename($new_file));
    }

    // Construct the attachment array
    $attachment = array_merge( array(
      'post_parent' => $post_id,
      'post_mime_type' => $file_data['type'],
      'guid' => $moved_image['url'],
      'post_title' => $image_meta['title'],
      'post_content' => $image_meta['caption'],
    ), $post_data );


    // Save the data
    $id = wp_insert_attachment($attachment, $new_file, $post_id);

    if ( !is_wp_error($id) ) {
      wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $new_file ) );
    }

    return $id;

  }

/**
  * Displays notices on pending property pages on admin
  *
  * @since 0.1
  */
  function all_admin_notices() {
    global $post, $user_level;

    if($post->post_type == 'property' && $post->post_status == 'pending') {
	if( $user_level<10 ){ ?>
		<div class="wpp_property_admin_notice">
		  <p>
		  <?php _e('This listing is pending approval.'); ?>
		  </p>
		</div>
    <?php
	} else {
		?>
		<script type="text/javascript">
		  jQuery(document).ready(function() {
			if ( jQuery('#publish').length > 0 ) {
			  jQuery('.wpp_property_admin_notice p').append( publish_now = document.createElement('a') );
			  jQuery( publish_now )
				.attr('href', 'javascript:void(0);')
				.text('<?php _e('Publish Now'); ?>')
				.click(function(){
				  jQuery(this).unbind('click');
				  jQuery('#publish').trigger('click');
				});
			}
		  });
		</script>
		<div class="wpp_property_admin_notice">
		  <p>
		  <?php _e('This listing is pending your approval.'); ?>
		  </p>
		</div>
	
		<?php
	}
    }

  }


/**
  * Handles ajax file uploads
  *
  * Uploads submitted file into a temporary directory.
  * Handles one file at a time.
  *
  * @todo consider using wp_handle_upload() for this
  * @since 0.1
  */
  function ajax_feps_image_upload() {

    $file_name = $_REQUEST['qqfile'];
    $this_session = $_REQUEST['this_session'];

    $upload_dir = wp_upload_dir();
    $feps_files_dir = $upload_dir['basedir'] . '/feps_files';
    $wpp_queue_dir = $feps_files_dir .  '/' . $this_session;
    $wpp_queue_url = $upload_dir['baseurl'] . '/feps_files/' . $this_session;

    if(!is_dir($feps_files_dir)) {
      mkdir($feps_files_dir, 0755);
    }

    if(!is_dir($wpp_queue_dir)) {
      mkdir($wpp_queue_dir, 0755);
      fopen($wpp_queue_dir . '/index.php', "w");
    }

    $path = $wpp_queue_dir . '/'. $file_name;

    if ( empty( $_FILES ) ) {



      $temp = tmpfile();
      $input = fopen("php://input", "r");
      $realSize = stream_copy_to_stream($input, $temp);
      fclose($input);
      $target = fopen($path, "w");
      fseek($temp, 0, SEEK_SET);
      stream_copy_to_stream($temp, $target);
      fclose($target);

    } else {
      // for IE!!!
      move_uploaded_file($_FILES['qqfile']['tmp_name'], $path);
    }

    /* if it is image */
    if ( getimagesize($path) ) {

      $return['success'] = 'true';

      //** Need to get thumb URL */
      $return['thumb_url'] = $wpp_queue_url . '/' . $file_name;

      $return['url'] = $wpp_queue_url . '/' . $file_name;

      die(htmlspecialchars(json_encode($return), ENT_NOQUOTES));

    } else {
      unlink($path);
    }

    die('false');

  }

/**
  * Adds scripts and styles to slideshow pages.
  * @since 0.1
  */
  function admin_menu() {
    $feps_page = add_submenu_page('edit.php?post_type=property', __('Property Forms','wpp'), __('Property Forms','wpp'), self::$capability, 'page_feps',array('class_wpp_feps', 'page_feps'));
  }

  /**
   * Load admin scripts
   * @global object $current_screen
   * @global array $wp_properties
   * @global object $wp_crm
   */
  function admin_enqueue_scripts() {
    global $current_screen, $wp_properties, $wp_crm;

    // Load scripts on specific pages
    switch($current_screen->id)  {

      case 'property_page_page_feps':
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-resizable');
        wp_enqueue_script('jquery-fancybox');
        wp_enqueue_style ('jquery-fancybox');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_style ('jquery-fancybox-css');

        $contextual_help['content'][] = '<h3>'.__('Settings', 'wpp').'</h3>';
        $contextual_help['content'][] = '<p>'.__('<b>New User Role:</b> Role to assign to users submitting properties if they do not already have an account.', 'wpp').'</p>';
        $contextual_help['content'][] = '<p>'.__('<b>Form Name:</b> For internal reference.', 'wpp').'</p>';
        $contextual_help['content'][] = '<p>'.__('<b>Shortcode:</b> Shortcode to render the form.', 'wpp').'</p>';
        $contextual_help['content'][] = '<p>'.__('<b>Property Status:</b> Status to assign to new properties after they are submitted.', 'wpp').'</p>';
        $contextual_help['content'][] = '<p>'.__('<b>Property Type:</b> Default property type of submitted properties.', 'wpp').'</p>';
        $contextual_help['content'][] = '<p>'.__('<b>Preview Thumbnail Size:</b> The size of the image to be used to display the thumbnail of an uploaded image.', 'wpp').'</p>';
        $contextual_help['content'][] = '<p>'.__('<b>Image Upload Limit:</b> The maximum number of images that can be uploaded per submission.', 'wpp').'</p>';

        $contextual_help['content'][] = '<h3>'.__('Notifications', 'wpp').'</h3>';
        $contextual_help['content'][] = '<p>'.__('Please install <a href="http://wordpress.org/extend/plugins/wp-crm/">WP-CRM</a> to setup notifications.', 'wpp').'</p>';

        $contextual_help = apply_filters('wpp_contextual_help', array('page' => $current_screen->id, 'content' => $contextual_help['content']));
        add_contextual_help($current_screen->id, implode("\n", $contextual_help['content']));
      break;
    }

  }

  /**

  * Used for returning the global slideshow via shortcode
  *
  * @since 0.1
  */
  function wpp_feps_form($atts = '') {
    global $post_id, $wp_properties, $post, $wpp_feps_message;

    $forms = $wp_properties['configuration']['feature_settings']['feps']['forms'];

    if(!is_array($forms)) {
      return;
    }

    $args = shortcode_atts( array(
      'detect_parent' => 'true',
      'parent_id' => '',
      'map_height' => '400',
      'template' => '',
      'not_found_text' => __('Requested FEPS form not found.','wpp'),
      'form' => '',
    ), $atts );


    foreach($args as $arg => $arg_v) {
      if(empty($arg_v)) {
        unset($args[$arg]);
      }
    }

    //** Check if requested form exists */
    foreach($forms as $form_id => $form) {
      if($form['slug'] == $args['form']) {
        $args['the_form'] = $form;
        $args['form_id'] = $form_id;
        break;
      }
    }

    //** Do nothing if requested form is not found */
    if(!$args['the_form']) {
      if(current_user_can('administrator')) {
        return $args['not_found_text'];
      } else {
        return;
      }
    }

    if( !is_array($args['the_form']['fields']) && !is_array($args['the_form']['required']) ) {
      if(current_user_can('administrator')) {
        return __('The requested form does not have any fields.','wpp');
      } else {
        return;
      }
    }


    if(!$wpp_feps_message['success'] && !empty($wpp_feps_message['message'])) {
      $args['show_error_message'] = $wpp_feps_message['message'];
    }


    if(empty($args['parent_id']) && $args['detect_parent'] == 'true' && $post->post_type == 'property') {
      $args['parent_id'] = $post->ID;
    }

    //** Unset arguments that are not needed later */
    unset($args['detect_parent']);

    ob_start();

    if($template && file_exists(STYLESHEETPATH . "/feps_{$template}.php")) {
      extract($args);
      include STYLESHEETPATH . "/feps_{$template}.php";
    } elseif($template && file_exists(TEMPLATEPATH . "/feps_{$template}.php")) {
      extract($args);
      include TEMPLATEPATH . "/feps_{$template}.php";
    } else {
      class_wpp_feps::default_form_template($args);
    }

    $contents = ob_get_contents();
    ob_end_clean();

    return $contents;

  }

/**
  * Displays default FEPS form
  *
  *
  * @todo Add propper JS validation.
  * @todo Will have issues with loading inherted values if user is allowed to select property_type, for now its fixed
  * @since 0.1
  */
  function default_form_template($args) {
    global $wpp_feps_message, $wp_properties;
	wp_property_extend_addons();
	global $current_user;

    $user_can_publish_properties = 'false';
    $form_id                     = rand(100000, 1000000);
    $this_session                = rand(100000, 1000000);
    $current_user                = wp_get_current_user();
    $nonce                       = WPP_F::generate_nonce('submit_feps');
    $thumbnail_size              = WPP_F::image_sizes($args['the_form']['thumbnail_size']);
    $property_type               = $args['the_form']['property_type'];
    $images_limit                = get_allowed_images( $_REQUEST['property_type'] );

    if(!empty($args['parent_id'])) {
      $parent_id = $args['parent_id'];
      $parent_property = get_property($parent_id);

      //** Get inherted data */
      if(is_array($wp_properties['property_inheritance'][$property_type])) {

        foreach($wp_properties['property_inheritance'][$property_type] as $attribute) {
          $property_data[$attribute] = $parent_property[$attribute];
        }
      }

    }

    if( is_user_logged_in() ) {
      $user_logged_in = true;
    }

    if ( user_can( $current_user, 'publish_wpp_properties' ) ) {
      $user_can_publish_properties = 'true';
    }

    /** Build element array from required fields. */
    if(is_array($args['the_form']['required'])) {
      foreach($args['the_form']['required'] as $attribute_data) {
        $this_field = WPP_F::get_attribute_data($attribute_data['attribute']);
        $this_field['required'] = 'on';
        $this_field['description'] = $attribute_data['description'];
        $this_field['title'] = $attribute_data['title'];
        $this_field['value'] = $property_data[$attribute_data['attribute']];

        $form_fields[rand(100,999)] = $this_field;
      }
    }

    /** Build element array from regular fields. */
    if(is_array($args['the_form']['fields'])) {
      foreach($args['the_form']['fields'] as $attribute_data) {
        $this_field = WPP_F::get_attribute_data($attribute_data['attribute']);
        $this_field['required'] = $attribute_data['required'];
        $this_field['description'] = $attribute_data['description'];
        $this_field['title'] = $attribute_data['title'];
        $this_field['value'] = ($property_data[$attribute_data['attribute']] ? $property_data[$attribute_data['attribute']] : false);

        $form_fields[rand(100,999)] = $this_field;
      }
    }

    $form_fields = stripslashes_deep($form_fields);


    ob_start(); ?>

  <script type="text/javascript">

    user_can_publish_properties = <?php echo $user_can_publish_properties; ?>;
    user_logged_in = <?php echo $user_logged_in?'true':'false'; ?>;

    jQuery(document).ready(function() {

      if(typeof wpp_format_currency == 'function') {
        wpp_format_currency(".wpp_feps_input_wrapper input.wpp_currency");
      }

      if(typeof wpp_format_number == 'function') {
        wpp_format_number(".wpp_feps_input_wrapper input.wpp_numeric");
      }

    });
  </script>
  <?php $output_js = ob_get_contents(); ob_end_clean(); echo WPP_F::minify_js($output_js);  ?>
  <style type="text/css">#wpp_feps_form_<?php echo $form_id; ?> .wpp_feps_preview_thumb {max-width: <?php echo $thumbnail_size['width']; ?>px !important;cursor:pointer; }</style>

  <?php if($args['show_error_message']) { ?>
    <div class="wpp_feps_message error"><?php echo $args['show_error_message']; ?></div>
  <?php } ?>
   <div class="wpp_feps_ajax_message"></div>
  <form action="" method="post" enctype="multipart/form-data" id="wpp_feps_form_<?php echo $form_id; ?>" class="wpp_feps_form">
  <div id="container_form">
    <input type="hidden" name="wpp_front_end_action" value="wpp_submit_feps" />
    <input type="hidden" name="nonce" value="<?php echo esc_attr($nonce); ?>" />
    <input type="hidden" name="wpp_feps_data[form_id]" value="<?php echo esc_attr(md5($args['form_id'])); ?>" />
    <input type="hidden" name="wpp_feps_data[this_session]" value="<?php echo esc_attr($this_session); ?>" />
	<?php if($parent_id) { ?>
    <input type="hidden" name="wpp_feps_data[property_type]" value="<?php echo $_POST['property_type']; ?>" />
    <input type="hidden" name="wpp_feps_data[hear_from]" value="<?php echo $_POST['hear_from']; ?>" />
    <?php }  ?>
  <?php if($parent_id) { ?>
    <input type="hidden" name="wpp_feps_data[parent_id]" value="<?php echo esc_attr($args['parent_id']); ?>" />
  <?php } ?>
			<!-- STEP 0 : PKGES-->
			<div id="step_0">
                  <table cellpadding="0" cellspacing="2" width="100%">
                  <tr>
                    <td width="48%" class="alignmiddle">How did you hear about Vet's Practice Market Place</td>
                    <td width="52%" class="alignmiddle">
                            <select name="wpp_feps_data[hear_from]" id="hear_from" class="step0p" style="width: 250px;">
                                <option value="">Please select an option</option>
                                <option value="ValuVet Newsletter">ValuVet Newsletter</option>
                                <option value="Conference">Conference</option>
                                <option value="Referral by Colleague">Referral by Colleague</option>
                                <option value="Referred by a Purchaser">Referred by a Purchaser</option>
                                <option value="ValuVet Consultant">ValuVet Consultant</option>
                                <option value="Internet Search Engine">Internet Search Engine</option>
                                <option value="Magazine Advertisement">Magazine Advertisement</option>
                                <option value="Direct mail received">Direct Mail Received</option>
                                <option value="Other">Other</option>
                            </select>
                    </td>
                  </tr>
                  <tr id="ad_hereabout_other_tr" style="display:none;">
                    <td width="48%" class="alignmiddle"><label id="otherhear_text"> <span>Other</span></label></td>
                    <td width="52%" class="alignmiddle"><input type="text" id="ad_hearabout_other" name="wpp_feps_data[here_about_other]" size="24" >
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="alignmiddle">Advertisement Package</td>
                    <td class="alignmiddle">
                            <select name="wpp_feps_data[property_type]" id="pkg_id" class="step0p" onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;">
                                <option selected="" value="">Select one</option>
                                <option value="package_1"<?php if( isset($_GET['property_type']) && $_GET['property_type']=='package_1' ) echo ' selected="selected"';?>>Package 1 - $<?php echo set_money_format( get_option('package_1', '165.00') );?></option>
                                <option value="package_2"<?php if( isset($_GET['property_type']) && $_GET['property_type']=='package_2' ) echo ' selected="selected"';?>>Package 2 - $<?php echo set_money_format( get_option('package_2', '330.00') );?></option>
                                <option value="package_3"<?php if( isset($_GET['property_type']) && $_GET['property_type']=='package_3' ) echo ' selected="selected"';?>>Package 3 - $<?php echo set_money_format( get_option('package_3', '550.00') );?></option>
                            </select>
                            <input type="hidden" name="noofimages" id="get_noof_images" value="1" />
                            <div class="clear"></div>
                            <div style="display:block; float:left;">Prices include GST</div>
                    </td>
                  </tr>
                  </table>
                <input class="nextbtn" type="button" name="submit_0" id="submit_0" value="" style="float: right;" />

            </div>  
			<!-- STEP 1 : USER INFORMATION ALL PKGES-->
			<div id="step_1" style="display:none;">
            	<h2>Your Contact Details</h2>
                <table cellpadding="0" border="0" cellspacing="2" width="100%">
                  <tr>
                    <td width="48%" class="alignmiddle">Title</td>
                    <td width="52%" class="alignmiddle">
                                        	<select name="wpp_feps_data[user_title]" class="step1p" id="user_title">
                                             <option selected="" value="">Select --&gt;</option>
                                             <option value="Mr">Mr</option>
                                             <option value="Mrs">Mrs</option>
                                             <option value="Miss">Miss</option>
                                             <option value="Ms">Ms</option>
                                             <option value="Dr">Dr</option>
                                             <option value="Proff">Proff</option>
                                             </select>
                    </td>
                  </tr>
                  <tr>
                    <td width="48%" class="alignmiddle">First Name<b>*</b></td>
                    <td width="52%" class="alignmiddle"><input class="step1p capitalize" type="text" name="wpp_feps_data[first_name]" id="ad_firstname" value="<?php echo $current_user->first_name?>" ></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Surname<b>*</b></td>
                      <td class="alignmiddle"><input class="step1p capitalize" type="text" name="wpp_feps_data[surname]" id="ad_surname" value="<?php echo $current_user->last_name?>" ></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Email<b>*</b></td>
                      <td class="alignmiddle"><input class="step1p" type="text" name="wpp_feps_data[user_email]" id="ad_email" <?php if( isset($current_user->user_email) && !empty($current_user->user_email) ) echo ' readonly="readonly"';?> value="<?php echo $current_user->user_email?>">
                      <div id="user_availability"></div>
                      </td>
                  </tr>
                  <tr>
                  <?php
				  		if( !empty( $current_user ) ){
							$phonenumber = get_user_meta( $current_user->ID, 'contact_number', true); 
						}
						?>
                      <td class="alignmiddle">Contact Number<b>*</b><br /><span class="small_text">Area Code Phone Number OR<br />Mobile Number ( 10 digits no spaces)</span></td>
                      <td class="alignmiddle"><input class="step1p" type="text" name="wpp_feps_data[contact_number]" id="ad_contactnumber" style="width:140px;"  value="<?php echo $phonenumber;?>" /></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Advertisement Enquiry Contact Phone Number<b>*</b> <br /><span class="small_text">Area Code Phone Number OR<br />Mobile Number ( 10 digits no spaces)</span></td>
                      <td class="alignmiddle"><input class="step1p" type="text" name="wpp_feps_data[advertisement_enquiry_contact_phone_number]" id="ad_advertisement" style="margin-top:2px; width:150px;" ></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
                  <input class="backbtn" type="button" name="step0" id="step0" value="" style="float: left;" />
                <input class="nextbtn" type="button" name="submit_1" id="submit_1" value="" style="float: right;" />
            </div>
   			<!-- STEP 2 : PRACTICE INFORMATION ALL PKGES-->
			<div id="step_2" style="display:none;">      
            	<h2>Practice Details</h2>
                <table cellpadding="0" cellspacing="2" width="100%">
                  <tr>
                    <td width="48%" class="alignmiddle">Practice Name<b>*</b></td>
                    <td width="52%" class="alignmiddle"><input type="text" name="wpp_feps_data[practice_name]" id="practice_name" maxlength="80" class="step2p capitalize" ></td>
                  </tr>
                  <tr>
                    <td align="left" style="width:250px;" class="alignmiddle">Type of Practice</td>
                    <td align="left" class="alignmiddle">
                    	<select name="wpp_feps_data[type_of_practice]" id="type_of_practice" class="step2p">
                            <option value="" selected>Select --></option>
                            <option>Small Animal</option>
                            <option>Large Animal</option>
                            <option>Mixed Animal</option>
                            <option>Specialist</option>
                            <option>Other</option>
                         </select>
                    </td>
                  </tr>
                  <tr id="show_type_of_practice_other" style="display:none;">
                    <td align="left" class="alignmiddle" style="width:250px;">Other</td>
                    <td align="left" class="alignmiddle"><input name="wpp_feps_data[type_of_practice_other]" id="type_of_practice_other" type="text" maxlength="20"  />
                    </td>
                  </tr>
                  <tr>
                    <td width="48%" class="alignmiddle">Practice Phone Number<b>*</b> <br />(10 digits no spaces)</td>
                    <td width="52%" class="alignmiddle"><input type="text" name="wpp_feps_data[practice_phone_number]" id="practice_phone_number" maxlength="12" class="step2p"></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Business Address<b>*</b></td>
                      <td class="alignmiddle"><input type="text" name="wpp_feps_data[business_address]" id="business_address" style="width:80%;" maxlength="60" class="step2p capitalize">
                      <input type="hidden" name="wpp_feps_data[street_name]" id="street_name capitalize">
                      </td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Suburb<b>*</b></td>
                      <td class="alignmiddle"><input type="text" name="wpp_feps_data[suburb]" id="suburb" maxlength="50" class="step2p capitalize">
                      <input type="hidden" name="wpp_feps_data[city]" id="city">
                      </td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Post Code<b>*</b></td>
                      <td class="alignmiddle"><input type="text" name="wpp_feps_data[post_code]" id="post_code" style="width:80px;" maxlength="5" class="step2p">
                      <input type="hidden" name="wpp_feps_data[zip_code]" id="zip_code">
                      </td>

                  </tr>
                  <tr>
                      <td class="alignmiddle">State<b>*</b></td>
                      <td class="alignmiddle">
                      <input type="text" name="wpp_feps_data[practice_state]" id="practice_state" class="step2p">
                      <input type="hidden" name="[state]" id="state">
                      </td>
                  </tr>
                  <tr style="display: none;">
                      <td class="alignmiddle">Country<b>*</b></td>
                      <td class="alignmiddle"><input type="hidden" name="wpp_feps_data[practice_country]" value="Australia" class="step2p" readonly="readonly"></td>
                  </tr>
                  </table>
                <input class="backbtn" type="button" name="step1" id="step1" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_2" id="submit_2" value="" style="float: right;" />
            </div>  
                       
            
   			<!-- STEP 3 : ASKING PRICE INFORMATION ALL PKGES, FOR PKG1 GO TO STEP 8-->
			<div id="step_3" style="display:none;" >
                            	<h2>Property Sales</h2>
				<table cellpadding="0" cellspacing="2" width="100%">     
                  <tr>
                      <td colspan="2" class="alignmiddle">Practice is for <b>*</b></td>
                      <td class="alignmiddle">
                            <select name="wpp_feps_data[practice_is_for]" id="property_is_for" class="step3p">
                                <option value="" selected>Select --></option>
                                <option>For Sale</option>
                                <option>For Lease</option>
                                <option>For Sale/Lease</option>
                             </select>
                             </td>
                  </tr>
                  <tr id="lease_details" style="display:none;">
                      <td colspan="2" class="alignmiddle">Lease Details</td>
                      <td class="alignmiddle"><input type="text" id="lease_details" name="wpp_feps_data[lease_details]" maxlength="30" class="wide"></td>
                  </tr>
                  <tr>
                      <td colspan="2" class="alignmiddle">Real estate<b>*</b></td>
                      <td class="alignmiddle">
                            <select name="wpp_feps_data[real_estate_available_for_sale]" id="real_estate_available_for_sale" class="step3p">
                                <option value="" selected>Select --></option>
                                <option>For Sale</option>
                                <option>For Lease</option>
                             </select>
                             </td>
                  </tr>
                  <tr id="realestate_lease_details" style="display:none;">
                      <td colspan="2" class="alignmiddle">Real Estate Lease Details</td>
                      <td class="alignmiddle"><input type="text" id="re_lease_details" name="wpp_feps_data[real_estate_lease_details]" maxlength="30" class="wide"></td>
                  </tr>
                  <tr>
                      <td colspan="2" class="alignmiddle"  style="width:250px;">Asking price <b>*</b></td>
                      <td class="alignmiddle"><input type="text" id="property_value" name="wpp_feps_data[property_value]" maxlength="12" class="step3p wide dollar_sign">
                      <div id="property_value_message"></div>
                      </td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Show the  "Asking Price"</td>
                      <td colspan="2">
                      		<table width="100%" border="0">
                              <tr>
                                <td width="33%" align="left" class="alignmiddle"><input name="wpp_feps_data[show_asking_price]" value="Yes" checked="checked" type="radio"> Yes&nbsp;&nbsp;OR</td>
                                <td class="alignmiddle"><input name="wpp_feps_data[show_asking_price]" value="No" type="radio"> P.O.A. (Price on Application)</td>
                              </tr>
                            </table>
						</td>
                  </tr>
            </table>
                 <hr />
                 	<h2>Price Breakdown</h2>
				<table cellpadding="0" cellspacing="2" width="100%">     
                
                  <tr id="realestate_value_hide" style="display:none;">
                      <td colspan="2" class="alignmiddle"  style="width:250px;">Property Real Estate Value <b>*</b></td>
                      <td class="alignmiddle"><input type="text" id="realestate_value" name="wpp_feps_data[realestate_value]" maxlength="12" class="wide dollar_sign"></td>
                  </tr>
                  <tr>
                      <td style="width:250px;" class="alignmiddle">Stock</td>
                      <td class="alignmiddle">
							<select name="wpp_feps_data[stock_on_sale]" id="stock_on_sale" class="form_req step3p">
                                <option value="" selected>Select --></option>
                                <option value="include">Include in asking price</option>
                                <option value="not include">Not include in asking price</option>
                             </select>
                      </td>
                      <td class="alignmiddle"><input type="text" id="stock" name="wpp_feps_data[stock]" maxlength="50" class="wide dollar_sign"></td>
                  </tr>
                  <tr>
                      <td style="width:250px;" class="alignmiddle">Equipment</td>
                      <td class="alignmiddle">
							<select name="wpp_feps_data[equipments_on_sale]" id="equipments_on_sale" class="form_req step3p">
                                <option value="" selected>Select --></option>
                                <option value="include">Include in asking price</option>
                                <option value="not include">Not include in asking price</option>
                             </select>
                      </td>
                      <td class="alignmiddle"><input type="text" id="equipments" name="wpp_feps_data[equipments]" maxlength="50" class="wide dollar_sign"></td>
                  </tr>
                  <tr>
                      <td colspan="2" style="width:250px;" class="alignmiddle">Goodwill</td>
                      <td class="alignmiddle"><input type="text" id="goodwill" name="wpp_feps_data[goodwill]" maxlength="50" class="wide dollar_sign"></td>
                  </tr>
                  </table>
                  <div id="pbreak" style="display:none; color:#900;"></div>
                  
                  <hr />
                            	<h2>Extra Details</h2>
				<table cellpadding="0" cellspacing="2" width="100%">
                  <tr>
                    <td align="left" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Valuation by ValuVet</td>
                      <td class="alignmiddle">
                    	<select name="wpp_feps_data[valuation_by_valuvet]" id="valuation_by_valuvet">
                            <option>Yes</option>
                            <option selected="selected">No</option>
                         </select>
                         </td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Practice Report by ValuVet</td>
                      <td class="alignmiddle">
                    	<select name="wpp_feps_data[practice_report_by_valuvet]" id="practice_report_by_valuvet">
                            <option>Yes</option>
                            <option selected="selected">No</option>
                         </select>
                         </td>
                  </tr>
			</table>
                <input class="backbtn" type="button" name="step2" id="step2" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_4" id="submit_4" value="" style="float: right;" />
            </div> 
            
            
   			<!-- STEP 8 : ADDITIONAL INFORMATION ALL PKGES-->
			<div id="step_4" style="display:none;">
            	<h2>Advertisement Information</h2>
				<table cellpadding="0" cellspacing="2" width="100%">
                  <tr>
                      <td class="alignmiddle">Headline<b>*</b></td>
                      <td class="alignmiddle"><div id="show_heading"></div><input type="text" name="wpp_feps_data[post_title]" id="post_title"></td>
                  </tr>
                  <tr id="pkg_short_description" style="display:none;">
                      <td class="alignmiddle">Short Description<b>*</b><br />(100 Words)<br />
						 Word Count: <span id="ad_short_desc_count" class="wordcounter"></span>
                      </p></td>
                      <td class="alignmiddle"><textarea name="wpp_feps_data[post_short_content]" id="ad_short_desc" rows="5" onkeyup="word_counter( 'ad_short_desc', 100, 'ad_short_desc_count' , '' );"></textarea>
                      </td>
                  </tr>
                  <tr id="the_business_tr" style="display:none;">
                      <td class="alignmiddle">The Business<b>*</b><br />(300 Words)
                           Word Count: <span id="the_business_count" class="wordcounter"></span>
                      </td>
                      <td class="alignmiddle"><textarea name="wpp_feps_data[the_business]" id="the_business" rows="5" onkeydown="word_counter( 'the_business', 300, 'the_business_count' , '' );"></textarea>
                      </td>
                  </tr>
                  
                  <tr id="the_opportunity_tr" style="display:none;">
                      <td class="alignmiddle">The Opportunity<b>*</b><br />(300 Words)
                           Word Count: <span id="the_opportunity_count" class="wordcounter"></span></td>
                      <td class="alignmiddle"><textarea name="wpp_feps_data[the_opportunity]" id="the_opportunity" rows="5" onkeydown="word_counter( 'the_opportunity', 300, 'the_opportunity_count' , '' );"></textarea>
                      </td>
                  </tr>
                  
                  <tr id="the_location_tr" style="display:none;">
                      <td class="alignmiddle">The Location<b>*</b><br />(300 Words)
                           Word Count: <span id="the_location_count" class="wordcounter"></span>
                      </td>
                      <td class="alignmiddle"><textarea name="wpp_feps_data[the_location]" id="the_location" rows="5" onkeydown="word_counter( 'the_location', 300, 'the_location_count' , '' );"></textarea>
                      </td>
                  </tr>
                 </table>
                <input class="backbtn" type="button" name="step3" id="step3" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_3" id="submit_3" value="" style="float: right;" />
            </div> 
            
            
            
			<div id="step_3_4" style="display:none;">
            	<h2>Upload Images</h2>
				<table cellpadding="0" cellspacing="2" width="100%">     
                  <tr id="img_upload" style="display:none;">
                      <td colspan="2">
                 		<table width="100%" border="0" id="formtable">
                              <tr>
                                <td class="alignmiddle" align="center">
              			<img class="wpp_feps_images_loading" src="<?php echo WPP_URL . 'images/ajax_loader.gif' ?>" style="visibility:hidden;" />
                      <div class="wpp_image_upload">
                      	<div class="ajax_uploader" ><?php _e('Featured Image', 'wpp'); ?></div>
                        <ul id="files"></ul></div>
                        <span id="status"></span>
                     				 <script type="text/javascript">
										jQuery(document).ready(function() {
									  //** Remove image handler - korotkov@ud */
							//** Remove image handler - korotkov@ud */
							jQuery('.wpp_feps_preview_thumb').live('click', function(){
							  //** turn on loader */
							  jQuery('.wpp_feps_images_loading').css({'visibility':'visible'});
							  //** init request data */
							  var image = jQuery(this);
							  var imgid = image.attr('rel');
							  var imgsrc = jQuery('img[rel='+imgid+']');
							  var data = {
								action: 'wpp_feps_image_delete',
								session: image.attr('session'),
								filename: image.attr('filename')
							  };
							  //** send  */
							  jQuery.post(
								'<?php echo admin_url('admin-ajax.php'); ?>', 
								data, 
								function(response) {
								  //** turn off loader */
								  jQuery('.wpp_feps_images_loading').css({'visibility':'hidden'});
								  //** if image removed */
								  if ( response.success ) {
									//** remove image (not it's parent li - important) from page */
									imgsrc.remove();
									//** increase images count and check if we can upload more images */
									if ( ++max_images > 0 ) {
										jQuery("#noofimages_can_upload").html('You can upload '+max_images+' images');
										jQuery('div.qq-upload-drop-area').show();
										jQuery('div.qq-upload-button input').show();
										jQuery('div.qq-upload-button').css({'visibility':'visible'});
										jQuery('#more_upload_description_'+imgid).hide();
										jQuery('.imgcap'+imgid).remove();
										jQuery('div[rel='+imgid+']').remove();
										jQuery("#prev_image"+imgid).html('');
										jQuery('#previewimg_'+imgid).remove();
										jQuery('#qq-bottom-line_'+imgid).remove();
										if(imgid<=0 ){
											jQuery("#imgcaptions").toggle();
											jQuery("#pkg2_featured").html('');
											jQuery("#pkg3_featured").html('');
											jQuery("#more_upload_description_"+imgid).val('');
										}
									}
								  }
								},
								'json'
							  );
							});
							if(typeof(qq) == 'undefined') {
							  return;
							}
										  var this_form = jQuery("#wpp_feps_form_<?php echo $form_id; ?>");
										  var uploader = new qq.FileUploader({
											element: jQuery('.wpp_image_upload .ajax_uploader', this_form)[0],
											action: '<?php echo admin_url('admin-ajax.php'); ?>',
											params: {
												action: 'wpp_feps_image_upload',
												this_session: '<?php echo $this_session; ?>'
											},
											name: 'wpp_feps_files',
											onComplete: function(id, fileName, responseJSON){
											  if ( responseJSON ) {
												max_images--;
												if ( max_images <= 0 ) {
												  jQuery('div.qq-upload-drop-area').hide();
												  jQuery('div.qq-upload-button input').hide();
												  jQuery('div.qq-upload-button').css({'visibility':'hidden'});
												}
												var thumb_url = responseJSON.thumb_url;
												if ( jQuery.browser.msie || jQuery.browser.opera ) {
												  id = String(id).substring(String(id).length, String(id).length-1);
												}
												if( id>=0 ){
													jQuery( '#show_titles' ).toggle();
												} 
												jQuery( jQuery("ul.qq-upload-list li").get(id) ).html('<img title="Click to Remove" rel="'+id+'" filename="'+fileName+'" session="<?php echo $this_session; ?>" class="wpp_feps_preview_thumb" src="' + thumb_url + '" style="float:left; width:180px;" /><di'+'v rel="'+id+'" class="imgcap'+id+'" style="float:left; text-align:left; margin-left:10px; padding-top:50px; width:125px; word-wrap: break-word; ">' + fileName + '</di'+'v><di'+'v rel="'+id+'" class="imgcap'+id+'" style="float:left; margin-left:5px;padding:50px 0 0 0;margin:0;  width: 200px;"><inp'+'ut type="text" id="more_upload_description_'+id+'" name="more_upload_description['+fileName+']" maxlength="50" size="15" onfocus="if( this.value==\'Image description\' ) this.value=\'\';" onblur="javascript:if( this.value==\'\' ) this.value=\'Image Description\';" value="Image description" style="vertical-align:top; padding:0 0 0 0;margin:0;" /></di'+'v><di'+'v rel="'+id+'" class="imgcap'+id+'" style="float:left; margin-left:10px; padding-top:50px; text-align:center; width: 75px;"><inp'+'ut type="radio" class="featured" name="featured" value="'+fileName+'" id="'+thumb_url+'" ><br>Featured</di'+'v><di'+'v rel="'+id+'" class="imgcap'+id+'" style="float:left; text-align:left; margin-left:20px; vertical-align:middle; padding-top:20px; width: 80px;"><img src="<?php echo bloginfo('template_directory');?>/images/Delete-icon.png" title="Click to Remove" rel="'+id+'" filename="'+fileName+'" session="<?php echo $this_session; ?>" class="wpp_feps_preview_thumb" width="75px"></di'+'v><di'+'v id="qq-bottom-line_'+id+'" class="qq-bottom-li"></di'+'v>' );
												jQuery("#more_upload_description_"+ id).show();
												if( id<1 ){
													jQuery("#imgcaptions").toggle();
												} 
												jQuery("#pkgimgpreview").append('<di'+'v class="property_img_left" id="previewimg_'+id+'"><di'+'v class="img-medium"><span id="prev_image'+id+'"><img filename="'+fileName+'"  src="' + thumb_url + '"/></span></di'+'v><span id="prev_image_desc'+id+'"></span></di'+'v>');
												jQuery("#noofimages_can_upload").html('You can upload '+max_images+' images');
											  }
											}
										  });
										});
									  </script>
                                      <div id="noofimages_can_upload"></div>
                                </td>
                                </tr>
                        </table>
                      </td>
                  </tr>
                  </table>
                <input class="backbtn" type="button" name="step2_3" id="step2_3" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_3_4" id="submit_3_4" value="" style="float: right;" />
            </div>
              
   			<!-- STEP 4 : FACILITIES INFORMATION PKGES 2 AND 3, FOR PKG1 GO TO STEP 8-->
			<div id="step_5" style="display:none;">
            	<h2>Facilities</h2>
				<table cellpadding="0" cellspacing="2" width="100%">
                  <tr>
                    <td align="left" class="alignmiddle" width="310px">
                    Building Type
                    </td>
                    <td class="alignmiddle">
							<select name="wpp_feps_data[building_type]" id="building_type" class="step5p">
                                <option value="" selected>Select --></option>
                                <option>Hospital (Large Building)</option>
                                <option>Clinic (Small Building)</option>
                                <option>Surgery (Room)</option>
                             </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" class="alignmiddle">
                   	Ownership
                    </td>
                    <td class="alignmiddle">
							<select name="wpp_feps_data[building_owndership]" id="building_ownership" class="step5p">
                                <option value="" selected>Select --></option>
                                <option>Building Owned</option>
                                <option>Building Rented</option>
                             </select>
                    </td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Building Area</td>
                      <td class="alignmiddle"><input type="text" name="wpp_feps_data[building_area_sqm]" class="step5p" size="10" maxlength="6" >  m&sup2;</td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Number of Branch Clinics</td>
                      <td class="alignmiddle"><input type="text" name="wpp_feps_data[number_of_branch_clinics]" id="number_of_branch_clinics" class="small"></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Number of Days Open per week</td>
                      <td class="alignmiddle"><input type="text" name="wpp_feps_data[number_of_days_open_per_week]" id="number_of_days_open_per_week" class="small"></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Do the facilities include:</td>
                      <td align="left" class="alignmiddle">
                      <table width="100%" border="0">
                          <tr>
                            <td class="alignmiddle leftalign">Kennels</td>
                            <td class="alignmiddle"><select name="wpp_feps_data[kennels]" id="kennels">
                                <option>Yes</option>
                                <option selected="selected">No</option>
                             </select></td>
                            <td class="alignmiddle leftalign">Stables</td>
                            <td class="alignmiddle"><select name="wpp_feps_data[stables]" id="stables">
                                <option>Yes</option>
                                <option selected="selected">No</option>
                             </select></td>
                          </tr>
                        </table>
                      </td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Off Street Parking</td>
                      <td class="alignmiddle">
							<select name="wpp_feps_data[off_street_parking]" id="off_street_parking">
                                <option>Yes</option>
                                <option selected="selected">No</option>
                             </select>
                      </td>
                  </tr>
                  <tr style="display:none;" id="show_offstreet_parking">
                      <td class="alignmiddle">How many Carparks</td>
                      <td class="alignmiddle">
						<input type="text" name="wpp_feps_data[no_of_off_street_cars]" id="no_of_off_street_cars" class="small">
                      </td>
                  </tr>
                  <tr>
                  	<td class="alignmiddle">Number of computer terminals</td>
                  	<td class="alignmiddle"><input type="text" name="wpp_feps_data[number_of_computer_terminals]" id="number_of_computer_terminals" class="small step5p"></td>
                   </tr>
                   <tr>
                            <td class="alignmiddle">Computer Software</td>
                            <td class="alignmiddle">
							<select name="wpp_feps_data[computer_software]" id="ad_software">
                                <option value="">Please select an option</option>
                                <option value="RxWorks">RxWorks</option>
                                <option value="Cornerstone">Cornerstone</option>
                                <option value="VetAid DOS">VetAid DOS</option>
                                <option value="VetAid Visual">VetAid Visual</option>
                                <option value="Netvet">Netvet</option>
                                <option value="Vetcare">Vetcare</option>
                                <option value="Vetware">Vetware</option>
                                <option value="Quickvet">Quickvet</option>
                                <option value="Custom built program">Custom built program</option>
                                <option value="Other">Other</option>
	                       	</select>
					</td>
                  </tr>
                  <tr id="other_software_display" style="display: none;">
                      <td class="alignmiddle">Other Software</td>
                      <td class="alignmiddle"><input type="text" name="wpp_feps_data[other_softwares]" id="other_software" maxlength="30" size="30" style="display: block;" ></td>
                  </tr>
                  </table>
                   <hr />
                 	<h2>Staff</h2>
                    
                    <table>
                  <tr>
                      <td class="alignmiddle">Number of Full-time Vet Equivalents (40 hrs)</td>
                      <td class="alignmiddle">
							<select name="wpp_feps_data[number_of_fulltime_vet_equivalents_40_hrs]" id="noof_vets" class="small step5p">
                                <option value="">Please select</option>
                                <option>1</option>
                                <option>1&ndash;2</option>
                                <option>2+</option>
                                <option>2&ndash;3</option>
                                <option>3+</option>
                                <option>3&ndash;4</option>
                                <option>4+</option>
	                       	</select>
					</td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Number of Full-time Nurse Equivalents (38 hrs)</td>
                      <td class="alignmiddle"><input type="text" name="wpp_feps_data[number_of_fulltime_nurse_equivalents_38_hrs_]" id="noof_nurse" class="small step5p" maxlength="4"></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Practice Manager</td>
                      <td class="alignmiddle">
							<select name="wpp_feps_data[practice_manager]" id="practice_manager" >
                                <option>Yes</option>
                                <option selected="selected">No</option>
                             </select>
                  </tr>

                  </table>
                <input class="backbtn" type="button" name="step4" id="step4" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_5" id="submit_5" value="" style="float: right;" />
            </div>               
   			<!-- STEP 5 : STAFF AND EXTRA PKGES 2 AND 3-->
			<div id="step_6" style="display:none;">
            <h2>Animal Treated</h2>
                      <div id="animal_treated_message" style="display:none;"></div>
	             <table cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                      <td valign="top">
                      <div class="from_list">
                          <ol>
                          <li><p><em>Small Animal %</em></p><input type="text" name="wpp_feps_data[small_animal_precentage]" id="small_animal_precentage" class="small" maxlength="3"></li>
                          <li><input type="checkbox" value="true" name="wpp_feps_data[canine]" id="canine">&nbsp; Canine</li>
                          <li><input type="checkbox" value="true" name="wpp_feps_data[feline]" id="feline">&nbsp; Feline</li>
                          <li><input type="checkbox" value="true" name="wpp_feps_data[avian]" id="avian">&nbsp; Avian</li>
                          <li><input type="checkbox" value="true" name="wpp_feps_data[exotics]" id="exotics">&nbsp; Exotics</li>
                          <li><input type="checkbox" value="true" name="wpp_feps_data[fauna]" id="fauna">&nbsp; Fauna</li>
                          </ol>

                          </div>
                      </td>
                      <td valign="top">
                      <div class="from_list">
                          <ol>
                              <li><p><em>Equine %</em></p><input type="text" name="wpp_feps_data[equine_presentage]" id="equine_presentage" class="small" maxlength="3"></li>
                              <li><input type="checkbox" value="true" name="wpp_feps_data[pleasure]" id="pleasure">&nbsp; Pleasure</li>

                              <li><input type="checkbox" value="true" name="wpp_feps_data[equine_stud]" id="equine_stud">&nbsp; Stud</li>
                              <li><input type="checkbox" value="true" name="wpp_feps_data[equine_stables]" id="equine_stables">&nbsp; Stables</li>
                         </ol>
                      </div>
                      </td>
                      <td valign="top">
                      <div class="from_list">
                          <ol>
                              <li><p><em>Bovine %</em></p><input type="text" name="wpp_feps_data[bovine_presentage]" id="bovine_presentage" class="small" maxlength="3"></li>
                              <li><input type="checkbox" value="true" name="wpp_feps_data[beef]" id="beef"> &nbsp;Beef</li>
                              <li><input type="checkbox" value="true" name="wpp_feps_data[dairy]" id="dairy"> &nbsp;Dairy</li>
                              <li><input type="checkbox" value="true" name="wpp_feps_data[bovine_stud]" id="bovine_stud"> &nbsp;Stud</li>
                          </ol>
                      </div>
                      </td>
                      <td valign="top">
                          <div class="from_list">

                          <ol>
                          <li><p><em>Other %</em></p><input type="text" name="wpp_feps_data[other_presentage]" id="other_presentage" class="small" maxlength="3"></li>
                          <li><input type="checkbox" value="true" name="wpp_feps_data[porcine]" id="porcine">&nbsp; Porcine</li>
                          <li><input type="checkbox" value="true" name="wpp_feps_data[ovine]" id="ovine">&nbsp; Ovine</li>
                          <li><input type="checkbox" value="true" name="wpp_feps_data[caprine]" id="caprine">&nbsp; Caprine</li>
                          <li><input type="checkbox" value="true" name="wpp_feps_data[camelid]" id="camelid">&nbsp; Camelid</li>
                          </ol>
                      </div>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="4">
                           Other Cont..<br />

                           <textarea name="wpp_feps_data[other_extra_details]" id="other_extra_details" rows="5" ></textarea>
                      </td>
                  </tr>
              </table>
                <input class="backbtn" type="button" name="step5" id="step5" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_6" id="submit_6" value="" style="float: right;" />
            </div>               
   			<!-- STEP 6 : PROFESSIONAL & ANCILLARYSERVICES PKGES 2 AND 3-->
			<div id="step_7" style="display:none;">
            <h2>Professional Services</h2>
            <table width="100%" border="0">
              <tr>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[medicine]" id="medicine">&nbsp; Medicine</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[surgery]" id="surgery">&nbsp; Surgery</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[dentistry]" id="dentistry">&nbsp; Dentistry</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[behaviour]" id="behaviour">&nbsp; Behaviour</td>
              </tr>
              <tr>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[emergency_service]" id="emergency_service">&nbsp; Emergency Service</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[diagnostic_laboratory]" id="diagnostic_laboratory">&nbsp; Diagnostic Laboratory</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[radiology]" id="radiology">&nbsp; Radiology</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[ultrasound]" id="ultrasound">&nbsp; Ultrasound</td>
              </tr>
              <tr>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[specialist]" id="specialist">&nbsp; Specialist</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[house_calls]" id="house_calls">&nbsp; House Calls</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[endoscopy]" id="endoscopy">&nbsp; Endoscopy</td>
                <td class="alignmiddle">&nbsp;</td>
              </tr>
              <tr>
                <td class="alignmiddle">Other</td>
                <td colspan="2"><textarea name="wpp_feps_data[other_professional_services]" id="other_professional_services" rows="5" style="width:100%;"></textarea></td>
              </tr>
            </table>
            <h2>Ancillary Services</h2>
            <table width="100%" border="0">
              <tr>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[grooming]" id="grooming">&nbsp; Grooming</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[puppy_school]" id="puppy_school">&nbsp;Puppy School</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[boarding]" id="boarding">&nbsp; Boarding</td>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[merchandising]" id="merchandising">&nbsp; Merchandising</td>
              </tr>
              <tr>
                <td class="alignmiddle"><input type="checkbox" value="true" name="wpp_feps_data[export_certificate]" id="export_certificate">&nbsp; Export Certificate</td>
                <td class="alignmiddle">&nbsp;</td>
                <td class="alignmiddle">&nbsp;</td>
              </tr>
              <tr>
                <td class="alignmiddle">Other</td>
                <td colspan="2"><textarea name="wpp_feps_data[other_ancillary_services]" id="other_ancillary_services" rows="5" style="width:100%;"></textarea></td>
              </tr>
            </table>
                <input class="backbtn" type="button" name="step6" id="step6" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_7" id="submit_7" value="" style="float: right;" />
            </div>
      
              
   			<!-- STEP 9 : PREVIEWS GOES HERE-->
			<div id="step_8" style="display:none;">
            	<h2>Preview</h2>
                
                <div id="pkg1_preview" style="display:none;">
                        <div id="pkg1data">
                        <table id="listing" width="100%" border="0">
                        <tbody>
                        <tr>
                        <td colspan="2">
                        <h1><span id="pkg1_title"></span></h1>
                        <hr />
                        </td>
                        </tr>
                        <tr>
                        <td>
                    
                            <p><em>Business Name:</em> <span id="pkg1_business_name"></span>
                            <p><em>Address:</em> <span id="pkg1_business_address"></span>

                        <td>
                        <h3>Contact</h3>
                        <p><span id="pkg1_contact_name"></span><br /><span id="pkg1_contact_phone"></span>
                        </tr>
                        <tr>
                        <td>
                        <h2>Asking Price: <span id="pkg1_askingprice"></span></h2>
                        </td>
                        <td></td>
                        </tr>
                        </tbody>
                        </table>
                        </div>

                </div>
                <div id="pkg2_preview" style="display:none;">
						<div id="pkg1data">
                            <table id="listing" border="0" width="100%">
                            <tr>
                            <td rowspan="4" valign="top">
                            <div class="property_img_left">
                            <div id="pkg2_featured" class="img-medium"><img src="http://valuvet.com.au/_dev2/wp-content/uploads/2012/04/default.jpg" alt=""></div>
                            </div>
                            <div class="clear"></div>
                            <p class="txt_clickimage"><em>CLICK IMAGE FOR LARGER VIEW [+]</em></p>
                            </td>
                            <td colspan="2">
                            <h1><span id="pkg2_title"></span></h1>
                            <hr/></td>
                            </tr>
                            <tr>
                            <td colspan="3" valign="top">
                            <h2>Overview</h2>
                            <p><span id="pkg2_overview"></span></td>
                            </tr>
                            <tr>
                            <td colspan="2">
                            <hr /></td>
                            </tr>
                            <tr>
                            <td>
                            <p><em>Business Name:</em> 	<span id="pkg2_business_name"></span>
                            <p><em>Address:</em>  <span id="pkg2_business_address"></span>, Australia</p>
                            <h2>Asking Price:<span id="pkg2_askingprice"></span></h2>
                            </td>
                            <td>
                            <h3>Contact</h3>
                            <p>Email: CLICK TO EMAIL</p>
                            </td>
                            </tr>
                            </table>
                		</div>
                
                
                </div>
                <div id="pkg3_preview" style="display:none;">
                <table id="listing" border="0" width="100%" class="post-150">
                <tr>
                <td colspan="2"><h1><span id="pkg3_title"></span></h1>
                <hr/></td>
                </tr>
                <tr>
                <td colspan="1">
                            <p><em>Business Name:</em> 	<span id="pkg3_business_name"></span>
                            <p><em>Address:</em>  <span id="pkg3_business_address"></span>, Australia</p>
                            <h2>Asking Price:<span id="pkg3_askingprice"></span></h2>
                                </td>
                <td>
                <h3>For further information please contact</h3>
				<p><span id="pkg3_contact_name"></span><br /><span id="pkg3_contact_phone"></span></p>
                <p>Email: CLICK TO EMAIL</p>
                </td>
                </tr>
                <tr>
                <td colspan="1" class="property_desc" width="70%" valign="top">
                <div id="pkg3_featured" class="img-large"></div>
				<div class="clear"></div> 
                           <p>&nbsp;</p>
               <ul id="headline"><li><span class="button_left">Description</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>
               <p><em>The Business:</em><br/>
                <p><span id="pkg3_business"></span></p>
                <p><em>The Opportunity:</em><br/>
                <p><span id="pkg3_opportunity"></span></p>
                <p><em>The Town:</em><br/>
                <p><span id="pkg3_location"></span></p>
                        
                                              </td>
                <td  valign="top">
                <ul id="headline"><li><span class="button_left">Overview</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>
                <div id="pkg3_shortdescription"></div>
                
                <div id="pkg3_overview"></div>
                <div id="pkg3_facilities"></div>
                <div id="pkg3_staff"></div>
                <div id="pkg3_practice"></div>
                <div id="pkg3_pro_service"></div>
                <div id="pkg3_anc_services"></div>

                </td>
                </tr>
                <tr>
                <td colspan="2">
                <hr/>
                <p class="txt_clickimage"><em>CLICK IMAGE FOR LARGER VIEW [+]</em></p>
                <br/>
                <br/>
                <div id="pkgimgpreview"></div>
                </td>
                </tr>
                </table>
                
                </div>

                <input class="backbtn" type="button" name="step7" id="step7" value="" style="float: left;" onclick="return false;" />
				<input type="submit" tabindex="<?php echo $tabindex; ?>" class="wpp_feps_submit_form nextbtn" style="float: right;" value=""  />
            </div>               
  			<!-- STEP 8 : SUBMIT ORDER, SHOW PACKAGE, SHOW PAYPAL-->
      
   
<div class="wpp_feps_input_wrapper" style="display:none;">
<div class="wpp_feps_input_content">
<input tabindex="107" type="password" id="<?=$this_session?>_user_password" name="wpp_feps_data[user_password]"  class="wpp_feps_user_password" />
        </div>
</div> 
   </div>    <!-- /div id container_form --> 

  </form>
  <script type="text/javascript">
    jQuery(document).ready(function() {
     var this_form = jQuery("#wpp_feps_form_<?php echo $form_id; ?>");
      jQuery(this_form).submit(function(event) {
        if(jQuery(".wpp_feps_submit_form", this_form).attr("wpp_feps_disabled") == "true") {
          event.preventDefault();
          return false;
        }
      });
      if(typeof jQuery.fn.validate == 'function') {
        jQuery(this_form).validate({
          submitHandler: function(form){
            wpp_feps_lookup_email(form);
          },
          errorPlacement: function(error, element) {
            return;
            var wrapper = element.parents(".wpp_feps_row_wrapper");
            var description_wrapper = jQuery(".wpp_feps_description_wrapper", wrapper);
            description_wrapper.prepend(error);
          },
          errorElement: false,
          errorClass: "wpp_feps_input_error",
          rules: {
            'wpp_feps_data[user_email]':{
              required: true,
              email: true
            }
          }
        });
      }
      function wpp_feps_lookup_email(this_form) {
        var user_email = jQuery("#ad_email", this_form).val();
        var user_password = jQuery(".wpp_feps_user_password", this_form).val();
        if ( user_logged_in ) {
          this_form.submit();
          return;
        }
        if(user_email == "") {
           jQuery(".wpp_feps_ajax_message", this_form).text("<?php _e('Please type in your e-mail address.', 'wpp'); ?>");
           jQuery(".wpp_feps_user_email", this_form).focus();
           return;
        }
        /* Disable submit button while checking e-mail */
        jQuery(".wpp_feps_submit_form", this_form).attr("wpp_feps_disabled", true);
        jQuery(".wpp_feps_submit_form", this_form).attr("wpp_feps_processing", true);
        if(user_password == "") {
          jQuery(".wpp_feps_ajax_message", this_form).text("<?php _e('Checking if account exists.', 'wpp'); ?>");
          jQuery(".wpp_feps_row_wrapper.user_password", this_form).hide();
        } else {
          jQuery(".wpp_feps_ajax_message", this_form).text("<?php _e('Checking your credentials.', 'wpp'); ?>");
        }
        jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
          action: "wpp_feps_email_lookup",
          user_email: user_email,
          user_password: user_password
        }, function(response) {
          jQuery(".wpp_feps_submit_form", this_form).attr("wpp_feps_processing", false);
          if(response.email_exists == 'true') {
            if(response.credentials_verified == "true") {
              /* Email exists AND user credentials were verified */
              jQuery(".wpp_feps_ajax_message", this_form).text("<?php _e('Your credentials have been verified.', 'wpp'); ?>");
              jQuery(".wpp_feps_row_wrapper.user_password", this_form).show(); /* In case it was hidden but prefilled by auto-complete in browser */
              jQuery(".wpp_feps_submit_form", this_form).attr("wpp_feps_disabled", false);
              this_form.submit();
            } else if(response.invalid_credentials == "true") {
              /* Login failed. */
               jQuery(".wpp_feps_ajax_message", this_form).text("<?php _e('Your login credentials are not correct.', 'wpp'); ?>");
            } else {
              /* Email Exists, still need to check password. */
              jQuery(".wpp_feps_row_wrapper.user_password", this_form).show();
              jQuery(".wpp_feps_ajax_message", this_form).text("<?php _e('Account found, please type in your password.', 'wpp'); ?>");
            }
          } else {
            /* New Account */
            jQuery(".wpp_feps_row_wrapper.user_password", this_form).hide();
            jQuery(".wpp_feps_ajax_message", this_form).text("<?php _e('Your account will be setup after your submission is approved.', 'wpp'); ?>");
            jQuery(".wpp_feps_submit_form", this_form).attr("wpp_feps_disabled", false);
            this_form.submit();
          }
        }, "json");
      }
//CUSTOM JAVASCRIPTS START FROM HERE
<?php if( !isset($current_user->user_email) ){?>
    jQuery('#ad_email').blur(function(){
    var user_email = jQuery("#ad_email", this_form).val();
        jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
          action: "wpp_feps_user_lookup",
          user_email: user_email
        }, function(response) {
          if( response.user_exists == 'true') {
			  jQuery('#ad_email', this_form).removeClass('error').removeClass('valid');
              jQuery('#ad_email', this_form).addClass('error');
              jQuery('#ad_email', this_form).effect("shake", { times:3 }, 50);
              jQuery("#user_availability").html("<span class=\"error\"><?php _e('Email already registered.', 'wpp'); ?></span>");
          } else {
			  jQuery('#ad_email', this_form).removeClass('error').removeClass('valid');
			  jQuery("#user_availability").html('');
		  }
        }, "json");
    });
<?php } ?>
		jQuery( "#suburb" ).autocomplete({
			source: function( request, response ) {
				jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", { 
					action: 'wppe_show_suburblist',
					suburb :  jQuery("#suburb").val()
					},
					function(data){
						eval("response_data="+ data);
						response( jQuery.map( response_data, function( item ) {
							return {
								label: item.value + ", " + item.state +", " + item.id,
								id: item.id,
								state: item.state,
								value: item.value
							}
						}));
					});
			},
			minLength: 2,
			select: function(event, ui) {
				jQuery("#suburb").val( ui.item.value );
				jQuery("#post_code").val( ui.item.id );
				jQuery("#practice_state").val( ui.item.state );
			},
			open: function() {
				jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
    });
  </script>
<?php
  }
/**
  * Renders the UI for form creation
  *
  * @since 0.1
  */
  function page_feps() {
    global $wp_properties, $wp_post_statuses;

    $wp_post_statuses = apply_filters( 'wpp_feps_property_statuses', $wp_post_statuses );

    if( empty($wp_properties['configuration']['feature_settings']['feps']) ) {
      //** Load default settings into global variable */
      class_wpp_feps::load_defaults();
    }

    if(isset($_REQUEST['message'])) {

      switch($_REQUEST['message']) {

        case 'updated':
        $wp_messages['notice'][] = __("FEPS forms updated.", 'wpp');
        break;
      }
    }

    $feps_forms = $wp_properties['configuration']['feature_settings']['feps']['forms'];

    $general_attributes['General']['post_content'] = __('Property Content', 'wpp');

    $other_attributes = WPP_F::get_total_attribute_array('use_optgroups=true',
      array(
        'image_upload' => __('Image Upload', 'wpp')
       )
     );

     $available_attributes = $general_attributes + $other_attributes;


    ?>

    <script type="text/javascript">

    jQuery(document).ready(function() {

      var new_tab_href_id = 0;

      var index = jQuery('#save_form').attr('action').indexOf("#");
      var url   = jQuery('#save_form').attr('action').substring(0, index);

      jQuery(".wpp_feps_tabs").bind( "tabsselect", function(event, ui) {
        index = jQuery('#save_form').attr('action').indexOf("#");
        url   = jQuery('#save_form').attr('action').substring(0, index);
        jQuery('#save_form').attr( 'action', url+'#feps_form_'+jQuery( ui.panel ).attr('feps_form_id') );
      });

      jQuery(".wpp_feps_tabs").bind( "tabscreate", function(event, ui) {
        jQuery('#save_form').attr( 'action', url+window.location.hash );
      });

      jQuery(".wpp_feps_tabs").tabs({
        add: function(event, ui) {

					jQuery(ui.panel).addClass('wpp_feps_form').attr('feps_form_id', new_tab_href_id);
					jQuery(ui.tab).parent().attr('feps_form_id', new_tab_href_id);

					jQuery('.wpp_feps_form div:first').clone().appendTo( ui.panel );

					feps_init_close_btn();
					feps_set_default_field_values( ui.panel );

					jQuery( 'input[name*="wpp_feps[forms]"], select[name*="wpp_feps[forms]"], textarea[name*="wpp_feps[forms]"]', ui.panel ).each(function(key, value){
						jQuery( value ).attr( 'name', String(jQuery( value ).attr('name')).replace(/wpp_feps\[forms\]\[\d.+?\]/, 'wpp_feps[forms]['+new_tab_href_id+']') );
					});

					feps_update_dom();

        }
      });

      feps_init_close_btn();

      jQuery(".wpp_add_tab").click(function() {

        /** Next commented code works! */
        new_tab_href_id = parseInt(Math.random()*1000000);
        jQuery(".wpp_feps_tabs").tabs( "add", "#feps_form_"+new_tab_href_id, "<?php _e('Unnamed Form', 'wpp'); ?>" );
        jQuery(".wpp_feps_tabs").tabs( "select", jQuery(".wpp_feps_tabs").tabs( 'length' )-1 );

      });

      jQuery(".wpp_dynamic_table_row").each(function() {
        /* A bit of  hack, but we want users to be able to change rows around as much as they need */
        jQuery(this).attr("new_row", "true");
      });


      jQuery(".wpp_feps_new_attribute").live("change", function() {
        var parent = jQuery(this).parents(".wpp_dynamic_table_row");
        var title = jQuery("option:selected", this).text();
        jQuery("input.title", parent).val(title);

      });

      /* On form name change */
      jQuery(".wpp_feps_form .form_title").live("change", function() {

        var title = jQuery(this).val();

        if(title == "") {
          return;
        }

        var slug = wpp_create_slug(title);
        var this_form = jQuery(this).parents(".wpp_feps_form");
        var form_id = jQuery(this_form).attr("feps_form_id");

        /* Update tab title */
        jQuery(".wpp_feps_tabs .tabs li[feps_form_id="+form_id+"] a span").text(title);

        /* Update shortcode */
        jQuery("input.shortcode", this_form).val("[wpp_feps_form form=" + slug + "]");

        /* Update Slug */
        jQuery("input.slug", this_form).val(slug);

      });

      jQuery("a.wpp_forms_remove_attribute").live('click', function(){
        var row_to_be_removed = jQuery(this).attr("row");
				var context           = jQuery(this).parents("div.wpp_padded_tab_content");
        jQuery(".wpp_feps_sortable tr.wpp_dynamic_table_row", context).each(function(k, v){
          if ( jQuery(v).attr("random_row_id") == row_to_be_removed ) {
            jQuery(v).remove();
          }
        });
        feps_update_dom();
      });

      jQuery("select.wpp_feps_new_attribute").live('change', function(){
        feps_update_dom();
      });

      jQuery("input.imageslimit").live('change', function(){
        if ( jQuery(this).val() < 1 ) jQuery(this).val(1);
      });

      feps_update_dom();

    });

		/** Render Close button on tabs */
    function feps_init_close_btn(){

      // Add remove button for tabs
      jQuery('ul.tabs li.ui-state-default:not(:first):not(:has(a.remove-tab))')
        .append('<a href="javascript:void(0);" class="remove-tab">x</a>')
        .mouseenter(function(){
          jQuery('a.remove-tab', this).show('fast');
        })
        .mouseleave(function(){
          jQuery('a.remove-tab', this).hide('fast');
        });

      // On remove tab button click
      jQuery('ul.tabs li a.remove-tab').unbind('click');
      jQuery('ul.tabs li a.remove-tab').click(function(e){
        jQuery(".wpp_feps_tabs").tabs('remove', jQuery(this).parent().index());
      });

    }

		/** Set default field values after adding new tab */
		function feps_set_default_field_values( context ) {
			jQuery("input.form_title", context).val('Unnamed Form').trigger('change');
			jQuery("input.shortcode", context).val('[wpp_feps_form form='+wpp_create_slug('Unnamed Form '+jQuery(context).attr('feps_form_id'))+']');
			jQuery("input.slug", context).val(wpp_create_slug('Unnamed Form '+jQuery(context).attr('feps_form_id')));
			jQuery(".ud_ui_dynamic_table tr.wpp_dynamic_table_row", context)
				.find("textarea.description").val('');
			jQuery(".ud_ui_dynamic_table tr.wpp_dynamic_table_row:not(.required):not(:first)", context)
				.remove();
		}

		/** Update dom after changes */
    function feps_update_dom() {

      jQuery('input.imageslimit').parent().hide();

      jQuery(".wpp_feps_sortable tbody").sortable( { items: 'tr.wpp_dynamic_table_row:not(.required)' } );

      jQuery(".wpp_feps_sortable tr.wpp_dynamic_table_row").live("mouseover", function() {
        jQuery(this).addClass("wpp_draggable_handle_show");
      });

      jQuery(".wpp_feps_sortable tr.wpp_dynamic_table_row").live("mouseout", function() {
        jQuery(this).removeClass("wpp_draggable_handle_show");
      });

      jQuery(".wpp_feps_sortable tr.wpp_dynamic_table_row").each(function(k, v){
        var random_row_id = jQuery(v).attr("random_row_id");
        jQuery(v).find("a.wpp_forms_remove_attribute").attr("row", random_row_id);
      });

      jQuery("select.wpp_feps_new_attribute option:selected").each(function(k, v){
        if ( jQuery(v).val() == 'image_upload' ) {
          jQuery(this).parents('div.wpp_padded_tab_content').find('input.imageslimit').parent().show();
        }
      });

    }

    /* Ran after a row is added */
    function wpp_feps_added_row(added_row) {
      /* Set the title */
      feps_update_dom();
    }
    </script>

    <div class="wrap wpp_feps_wrapper">
      <h2><?php _e('Front End Property Submissions', 'wpp'); ?>
      <span class="wpp_add_tab add-new-h2"><?php _e('Add New', 'wpp'); ?></span>
      </h2>

      <?php if(isset($wp_messages['error']) && $wp_messages['error']): ?>
      <div class="error">
        <?php foreach($wp_messages['error'] as $error_message): ?>
          <p><?php echo $error_message; ?>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <?php if(isset($wp_messages['notice']) && $wp_messages['notice']): ?>
      <div class="updated fade">
        <?php foreach($wp_messages['notice'] as $notice_message): ?>
          <p><?php echo $notice_message; ?>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <form id="save_form" action="<?php echo admin_url('edit.php?post_type=property&page=page_feps&message=updated'); ?>" method="POST">
        <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('wpp_save_feps_page'); ?>" />
        <input class="current_tab" type="hidden" name="current_tab" value="" />

      <div class="wpp_feps_tabs wpp_tabs">

        <ul class="tabs">
          <?php foreach($feps_forms as $form_id => $form) { ?>
            <li feps_form_id="<?php echo esc_attr($form_id); ?>"><a href="#feps_form_<?php echo $form_id; ?>"><span><?php echo $form['title']; ?></span></a></li>
          <?php } ?>
        </ul>
        <?php foreach($feps_forms as $form_id => $form) {
          // Fill out one default field if 'fields' is empty
          if ( empty( $form['fields'] ) ) {
            $form['fields'] = class_wpp_feps::load_default_field();
          }
        ?>
        <div id="feps_form_<?php echo $form_id; ?>" class="wpp_feps_form" feps_form_id="<?php echo esc_attr($form_id); ?>">
         <div class="wpp_padded_tab_content">

          <ul class="feps_form_info wpp_first">
            <li>
              <label><?php _e('Form Name:', 'wpp'); ?></label>
              <input class="form_title" type="text" name="wpp_feps[forms][<?php echo $form_id; ?>][title]" value="<?php echo esc_attr($form['title']); ?>" />
              <input type="hidden" class="slug" name="wpp_feps[forms][<?php echo $form_id; ?>][slug]" value="<?php echo esc_attr($form['slug']); ?>" />
            </li>

            <li>
              <label><?php _e('Shortcode:', 'wpp'); ?></label>
              <input class="shortcode" type="text" readonly="true" value="[wpp_feps_form form=<?php echo esc_attr($form['slug']); ?>]" />
            </li>
            <li>
              <label><?php _e('Property Status:', 'wpp'); ?></label>
              <select name="wpp_feps[forms][<?php echo $form_id; ?>][new_post_status]">
              <?php foreach($wp_post_statuses as $post_status => $post_status_data) { ?>
                <option <?php selected($post_status, $form['new_post_status']); ?> value="<?php echo esc_attr($post_status); ?>"><?php echo $post_status_data->label; ?></option>
              <?php } ?>
              </select>
            </li>
            <li>
              <label><?php _e('Property Type:', 'wpp'); ?></label>
               <select name="wpp_feps[forms][<?php echo $form_id; ?>][property_type]">
              <?php foreach($wp_properties['property_types'] as $pt_slug => $pt_label) {  ?>
                <option <?php selected($pt_slug, $form['property_type']); ?> value="<?php echo esc_attr($pt_slug); ?>"><?php echo $pt_label; ?></option>
              <?php } ?>
              </select>
            </li>
           <li>
              <label><?php _e('Preview Thumbnail Size:', 'wpp'); ?></label>
              <?php WPP_F::image_sizes_dropdown("name=wpp_feps[forms][{$form_id}][thumbnail_size]&selected={$form['thumbnail_size']}"); ?>
            </li>

            <li>
              <label><?php _e('Image Upload Limit:', 'wpp'); ?></label>
              <input class="imageslimit wpp_number" name="wpp_feps[forms][<?php echo $form_id; ?>][images_limit]" type="text" value="<?php echo esc_attr(abs((int)$form['images_limit'])); ?>" />
            </li>

            <?php /*
            <li class="wpp_checkbox_field_wrapper">
              <input type="checkbox" name="wpp_feps[forms][<?php echo $form_id; ?>][submitter_as_agent]" <?php checked('true', $form['submitter_as_agent']); ?> value="true"  />
              <label><?php _e('Add submitter as an agent to the property.', 'wpp'); ?></label>
            </li>
            */ ?>

          </ul>

          <ul class="feps_form_info">

            <li>
              <label><?php _e('New User Role:', 'wpp'); ?></label>
              <select class="wp_crm_role" name="wpp_feps[forms][<?php echo $form_id; ?>][new_role]">
                <option value=""></option>
                <?php wp_dropdown_roles($form['new_role']); ?>
              </select>
            </li>

            <li>
              <label><?php _e('Other Settings:', 'wpp'); ?></label>
              <label class="wpp_feps_right_label">
                <input type="checkbox" name="wpp_feps[forms][<?php echo $form_id; ?>][notifications][user_creation]" <?php checked('disable', $form['notifications']['user_creation']); ?> value="disable">
                <?php _e('Disable new user account creation notification.', 'wpp'); ?>
              </label>

            </li>

          </ul>


          <table class="ud_ui_dynamic_table widefat wpp_feps_sortable" use_random_row_id="true">
            <thead>
              <tr>
                <th></th>
                <th><?php _e('Main', 'wpp'); ?></th>
                <th><?php _e('Description', 'wpp'); ?></th>
              </tr>
            </thead>
            <tbody>
              <tr class="wpp_dynamic_table_row required" random_row_id="post_title">
                <td class="wpp_draggable_handle"></td>
                <td class="main_feps">
                  <ul>
                    <li>
                      <label><?php _e('Attribute', 'wpp'); ?></label>
                      <input type="hidden" name="wpp_feps[forms][<?php echo $form_id; ?>][required][post_title][attribute]" value="post_title" />
                      <select disabled="disabled" class="wpp_feps_new_attribute">
                        <option><?php _e('Property Title', 'wpp'); ?></option>
                      </select>
                    </li>
                    <li class="wpp_development_advanced_option">
                      <label><?php _e('Title', 'wpp'); ?></label>
                      <input type="text" class="title" name="wpp_feps[forms][<?php echo $form_id; ?>][required][post_title][title]" value="<?php echo $form['required']['post_title']['title'] ?>" />
                    </li>
                    <li>
                      <span class="wpp_show_advanced"><?php _e('Toggle Advanced Settings', 'wpp'); ?></span>
                    </li>
                  </ul>
                </td>
                <td>
                  <textarea class="description wpp_full_width" name="wpp_feps[forms][<?php echo $form_id; ?>][required][post_title][description]"><?php echo $form['required']['post_title']['description'] ?></textarea>
                </td>
              </tr>
            <?php if ( !empty( $form['fields'] ) ) {
              foreach($form['fields'] as $row_id => $field_data) { $field_data = stripslashes_deep($field_data); ?>
              <tr class="wpp_dynamic_table_row" random_row_id="<?php echo $row_id; ?>">
                <td class="wpp_draggable_handle"></td>
                <td class="main_feps">
                <ul>
                  <li>
                    <label><?php _e('Attribute', 'wpp'); ?></label>
                    <select  name="wpp_feps[forms][<?php echo $form_id; ?>][fields][<?php echo $row_id; ?>][attribute]"  class="wpp_feps_new_attribute">
                      <option></option>
                      <?php foreach($available_attributes as $group_label => $opt_group) { ?>
                        <optgroup label="<?php echo esc_attr($group_label); ?>">
                        <?php foreach($opt_group as $attribute => $label) { ?>
                        <option <?php selected($field_data['attribute'], $attribute); ?> value="<?php echo esc_attr($attribute); ?>"><?php echo esc_attr($label); ?></option>
                        <?php } ?>
                        </optgroup>
                      <?php } ?>
                    </select>
                  </li>
                  <li class="wpp_development_advanced_option">
                    <label><?php _e('Title', 'wpp'); ?></label>
                    <input type="text" class="title" name="wpp_feps[forms][<?php echo $form_id; ?>][fields][<?php echo $row_id; ?>][title]" value="<?php echo $field_data['title']; ?>" />
                  </li>
                  <li class="wpp_development_advanced_option">
                    <input type="checkbox" name="wpp_feps[forms][<?php echo $form_id; ?>][fields][<?php echo $row_id; ?>][required]" <?php checked('on', $field_data['required']); ?> />
                    <label><?php _e('Required'); ?></label>
                  </li>
                  <li class="wpp_development_advanced_option">
                    <a class="wpp_forms_remove_attribute" row="<?php echo $row_id; ?>" href="javascript:void(0);">Remove attribute</a>
                  </li>
                  <li>
                    <span class="wpp_show_advanced"><?php _e('Toggle Advanced Settings', 'wpp'); ?></span>
                  </li>
                </ul>
              </td>

              <td>
                <textarea class="description wpp_full_width" name="wpp_feps[forms][<?php echo $form_id; ?>][fields][<?php echo $row_id; ?>][description]"><?php echo $field_data['description']; ?></textarea>
              </td>
            </tr>
            <?php }
            }
              ?>
            </tbody>

            <tfoot>
              <tr><td colspan="3">
                <input type="button" callback_function="wpp_feps_added_row" class="wpp_add_row button-secondary" value="<?php _e('Add Row','wpp') ?>" />
              </td></tr>
            </tfoot>
          </table>
          </div>
        </div>
        <?php } ?>
      </div>

      <br class="cb" />
      <p class="wpp_save_changes_row">
      <input type="submit"  value="<?php _e('Save Changes','wpp');?>" class="button-primary" name="Submit">
      </p>

    </div>

    <?php
  }


/**
  * Save USP settings
  *
  * @since 0.1
  */
  function save_feps_settings($settings) {
    global $wp_properties;

    if ( !empty( $settings['forms'] ) ) {
      foreach( $settings['forms'] as $form_k=>$form ) {
        if ( !empty( $form['fields'] ) ) {
          foreach ( $form['fields'] as $f_key => $f_val ) {
            if ( empty( $f_val['attribute'] ) ) {
              unset( $settings['forms'][$form_k]['fields'][$f_key] );
            }
          }
        }
      }
    }

    $wp_properties['configuration']['feature_settings']['feps'] = $settings;
    update_option('wpp_settings', $wp_properties);
    return $wp_properties;
  }


/**
  * Modifies the way input fields are renderd
  *
  * $data array includes:
  * - this_session - FEPS form settings
  * - att_data - data about the attribute
  * - row_id - unique ID of row
  * - args - FEPS form settings
  * - property_data - array of property data (if exists)
  *
  * $data['att_data'] includes:
  * - slug
  * - value
  * - required
  * - ui_class
  * - title
  * - description
  * - input_type
  * - storage_type
  * - is_meta
  *
  * @since 0.1
  *
  */
  function wpp_feps_input($data) {
    global $wp_properties;

    $form_dom_id = $data['form_dom_id'];
    $row_id = $data['row_id'];
    $att_data = $data['att_data'];
    $this_session = $data['this_session'];
    $field = $data['field'];
    $images_limit = $data['images_limit'];
    $styled = '';

    /** Use this only for FEPS with Denali installed */
    if ( strstr(get_option('template'), 'denali') ) {
      $styled = ' styled';
    }

    //** Try to get data input type first, then user regular (search) input type */
    $input_type = ($att_data['data_input_type'] ? $att_data['data_input_type']: $att_data['input_type']);


    //** If dropdown, load predefined values */
    if($input_type == 'dropdown') {

      if ( !empty( $att_data['predefined_values'] ) ) {
        $values = explode(',', $att_data['predefined_values']);
      } else {
        $values = array();
      }

    }

    ob_start();
    switch($input_type) {
      case 'dropdown': ?>
        <select class="<?php echo $att_data['required']=='on'?'required ':' '; echo $att_data['ui_class'].$styled; ?>" tabindex="<?php echo $att_data['tabindex'] ?>" id="wpp_<?php echo $row_id; ?>_select" name="wpp_feps_data[<?php echo $att_data['slug']; ?>]">
            <option value=""></option>
          <?php foreach( $values as $value ) { ?>
            <option value="<?php echo $value; ?>"><?php echo  apply_filters('wpp_stat_filter_' . $att_data['slug'], $value); ?></option>
          <?php } ?>
        </select>
        <?php
      break;
      case 'checkbox': ?>
        <input tabindex="<?php echo $att_data['tabindex'] ?>" type="checkbox" id="wpp_<?php echo $row_id; ?>_input"  name="wpp_feps_data[<?php echo $att_data['slug']; ?>]" class="<?php echo $att_data['required']=='on'?'required ':' '; echo $att_data['ui_class'].$styled; ?>" value="true" />
      <?php
      break;
      case 'textarea':
        ?>
        <textarea tabindex="<?php echo $att_data['tabindex'] ?>"  id="wpp_<?php echo $row_id; ?>_input" name="wpp_feps_data[<?php echo $att_data['slug']; ?>]" class="<?php echo $att_data['ui_class']; ?>"></textarea>
      <?php
      break;
      case 'image_upload':
        ?><img class="wpp_feps_images_loading" src="<?php echo WPP_URL . 'images/ajax_loader.gif' ?>" style="visibility:hidden;" />
        <div class="wpp_image_upload">
          <div class="ajax_uploader" ><?php _e('Upload', 'wpp'); ?></div>
          <span id="status" ></span>
          <ul id="files"></ul></div>
        <?php if($images_limit > 0) { ?>
        <span class="images_limit"><?php printf(__('No more than %1d image(s). Click image to delete it.', 'wpp'), $images_limit); ?></span>
        <?php } ?>
        <?php ob_start(); ?>
        <script type="text/javascript">
          jQuery(document).ready(function() {
            //** Remove image handler - korotkov@ud */
            jQuery('img.wpp_feps_preview_thumb').live('click', function(){
              //** turn on loader */
              jQuery('.wpp_feps_images_loading').css({'visibility':'visible'});
              //** init request data */
              var image = jQuery(this);
              var data = {
                action: 'wpp_feps_image_delete',
                session: image.attr('session'),
                filename: image.attr('filename')
              };
              //** send  */
              jQuery.post(
                '<?php echo admin_url('admin-ajax.php'); ?>', 
                data, 
                function(response) {
                  //** turn off loader */
                  jQuery('.wpp_feps_images_loading').css({'visibility':'hidden'});
                  //** if image removed */
                  if ( response.success ) {
                    //** remove image (not it's parent li - important) from page */
                    image.remove();
                    //** increase images count and check if we can upload more images */
                    if ( ++max_images > 0 ) {
                      jQuery('div.qq-upload-drop-area').show();
                      jQuery('div.qq-upload-button input').show();
                      jQuery('div.qq-upload-button').css({'visibility':'visible'});
                    }
                  }
                },
                'json'
              );
            });
            if(typeof(qq) == 'undefined') {
              return;
            }
            var max_images = <?php echo $images_limit; ?>;
            var this_form = jQuery("#<?php echo $form_dom_id; ?>");
            var uploader = new qq.FileUploader({
              element: jQuery('.wpp_image_upload .ajax_uploader', this_form)[0],
              action: '<?php echo admin_url('admin-ajax.php'); ?>',
              params: {
                  action: 'wpp_feps_image_upload',
                  this_session: '<?php echo $this_session; ?>'
              },
              name: 'wpp_feps_files',
              onComplete: function(id, fileName, responseJSON){
                if ( responseJSON ) {
                  max_images--;
                  if ( max_images <= 0 ) {
                    jQuery('div.qq-upload-drop-area').hide();
                    jQuery('div.qq-upload-button input').hide();
                    jQuery('div.qq-upload-button').css({'visibility':'hidden'});
                  }
                  var thumb_url = responseJSON.thumb_url;
                  if ( jQuery.browser.msie || jQuery.browser.opera ) {
                    id = String(id).substring(String(id).length, String(id).length-1);
                  }
                  jQuery( jQuery("ul.qq-upload-list li").get(id) ).html('<img title="Click to Remove" filename="'+fileName+'" session="<?php echo $this_session; ?>" class="wpp_feps_preview_thumb" src="' + thumb_url + '"/>');
                }
              }
            });
          });
        </script>
        <?php
          $output_js = ob_get_contents();
          ob_end_clean();
          echo WPP_F::minify_js($output_js);
      break;
      default:
        ?>
        <input tabindex="<?php echo $att_data['tabindex']; ?>"  id="wpp_<?php echo $row_id; ?>_input"  name="wpp_feps_data[<?php echo $att_data['slug']; ?>]" value="<?php echo $att_data['value']; ?>" type="text" class="<?php echo ($att_data['required']=='on'?'required ':'') . $att_data['ui_class']; ?>" />
        <?php
      break;
    }


    if($att_data['is_address_attribute'] && empty($att_data['property_data'][$att_data['slug']])) {

      //** Load coordinates from existing property (parent) or default */
      if($data['property_data']['latitude'] && $data['property_data']['longitude']) {
        $map_coords['latitude'] = $data['property_data']['latitude'];
        $map_coords['longitude'] = $data['property_data']['longitude'];
      } else {
        $default_coords = $wp_properties['default_coords'];
      }

      self::render_location_map_input( $row_id, $default_coords, $data['args'] );
    }

    $content = ob_get_contents();
    ob_end_clean();

    if(!empty($content)) {
      return $content;
    }

    return $default;

  }



/**
  * Adds meta data to attributes
  *
  * @since 0.1
  */
  function add_attribute_data($data) {

    switch ($data['slug']) {

      case 'post_content':
        $data['input_type'] = 'textarea';
        $data['data_input_type'] = 'textarea';
        $data['is_wp_core'] = true;
        $data['ui_class'] = $data['ui_class'] . ' required';
        return $data;
      break;

      case 'image_upload':

        $data['label'] = __('Image Upload', 'wpp');
        $data['is_wp_core'] = true;
        $data['input_type'] = 'image_upload';
        $data['data_input_type'] = 'image_upload';
        $data['storage_type'] = 'image_upload';
        return $data;

      break;
    }

    return $data;

  }

  /**
   * Load default settings
   * @global array $wp_properties
   */
  function load_defaults() {
    global $wp_properties;

    $random_id = rand(100000,1000000);
    $row_id = rand(100,1000);

    $defaults['forms'][$random_id]['title'] = 'Sample Form';
    $defaults['forms'][$random_id]['new_role'] = 'subscriber';
    $defaults['forms'][$random_id]['slug'] = 'sample_form';
    $defaults['forms'][$random_id]['new_post_status'] = 'pending';
    $defaults['forms'][$random_id]['images_limit'] = 6;

    $defaults['forms'][$random_id]['required']['post_title']['title'] = 'Property Title';
    $defaults['forms'][$random_id]['required']['post_title']['attribute'] = 'post_title';

    /*$defaults['forms'][$random_id]['fields'][$row_id]['title'] = 'Bedrooms';
    $defaults['forms'][$random_id]['fields'][$row_id]['attribute'] = 'bedrooms';
    $defaults['forms'][$random_id]['fields'][$row_id]['required'] = 'true';*/

    $wp_properties['configuration']['feature_settings']['feps'] = $defaults;

  }

  /**
   * Load default (first) field if there is no any fields
   * @global array $wp_properties
   * @author Anton Korotkov
   * @return array
   */
  function load_default_field() {
    global $wp_properties;

    if ( !empty( $wp_properties['property_stats'] ) ) {
      $attribute = key( $wp_properties['property_stats'] );

      $field = array();
      $row_id = rand(100,1000);

      $field[$row_id]['title'] = $wp_properties['property_stats'][ $attribute ];
      $field[$row_id]['attribute'] = $attribute;
      $field[$row_id]['required'] = 'false';
    } else {
      $field[$row_id]['title'] = '';
      $field[$row_id]['attribute'] = '';
      $field[$row_id]['required'] = 'false';
    }

    return $field;

  }

  /**
   * Handle adding post meta value
   * @global array $wp_properties
   * @param int $meta_id
   * @param int $object_id
   * @param string $meta_key
   * @author Anton Korotkov
   * @param string $meta_value
   */
  function handle_post_meta( $meta_id, $object_id, $meta_key, $meta_value ) {
    global $wp_properties;

    switch( $meta_key ) {

      default: break;

      case $wp_properties['configuration']['address_attribute']:

        $geo_data = UD_F::geo_locate_address($meta_value, $wp_properties['configuration']['google_maps_localization'], true);

        if(!empty($geo_data->formatted_address)) {
          update_post_meta($object_id, 'address_is_formatted', true);

          if(!empty($wp_properties['configuration']['address_attribute'])) {
            update_post_meta($object_id, $wp_properties['configuration']['address_attribute'], WPP_F::encode_mysql_input( $geo_data->formatted_address, $wp_properties['configuration']['address_attribute']));
          }

          foreach($geo_data as $geo_type => $this_data) {
            update_post_meta($object_id, $geo_type, WPP_F::encode_mysql_input( $this_data, $geo_type));
          }

        } else {
          // Try to figure out why it failed
          update_post_meta($object_id, 'address_is_formatted', false);
        }

        break;

    }

  }

  /**
   * Filter CRM actions list
   * @param array $current
   * @author Anton Korotkov
   * @return array
   */
  function crm_custom_notification($current) {

    foreach( self::$crm_notification_actions as $action_key => $action_name ) {
      $current[$action_key] = $action_name;
    }

    return $current;
  }

  /**
   * Filter query to allow view of pending posts
   * @param object $wp_query
   * @param object $post
   * @author korotkov@ud
   * @return object
   */
  function wpp_query_filter( $wp_query, $post ) {

    $wp_query->is_404 = false;
    $wp_query->is_single = 1;
    $wp_query->is_preview = 1;
    $wp_query->is_singular = 1;
    $wp_query->post_count = 1;
    $wp_query->posts[0] = $post;
    $wp_query->post = $post;

    return $wp_query;
  }

  /**
   * Prevent auth of inactive user
   * @param unknown $nothing
   * @param string $username
   * @param string $password
   * @author Anton Korotkov
   * @return WP_Error || null
   */
  function authenticate( $nothing, $username, $password ) {

    $user = get_userdatabylogin( $username );
    if ( !empty( $user->is_not_approved ) ) {
      $user_error = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Account is not approved.', 'wpp'));
      return $user_error;
    }
    return $nothing;

  }

  /**
   * Renders location input map
   *
   * @param int $row_id
   * @param array $default_coords
   * @param array $args
   * @author korotkov@ud
   */
  function render_location_map_input( $row_id, $default_coords, $args ) { ?>

      <div id="wpp_feps_map_<?php echo $row_id; ?>" class="wpp_feps_map" style="width: 100%; height: <?php echo $args['map_height']; ?>px;"><?php _e('There is a JavaScript error on this page preventing it from displaying the dynamic map.', 'wpp'); ?></div>

      <?php ob_start(); ?>
      <script type="text/javascript">

        function empty( mixed_var ) {
          return ( mixed_var === "" || mixed_var === 0   || mixed_var === "0" || mixed_var === null  || mixed_var === false );
        }

        jQuery(function() {

          /* Check if Google Maps is loaded */
          if(typeof google.maps !== 'object' || typeof qq == 'undefined') {
            return;
          }

          jQuery('#wpp_feps_map_<?php echo $row_id; ?>').gmap({'zoom':10, 'center': new google.maps.LatLng(<?php echo $default_coords['latitude'] ?>,<?php echo $default_coords['longitude'] ?>)});
          jQuery("<?php echo "#wpp_{$row_id}_input"; ?>").change(function() {
            var location_string = jQuery.trim( jQuery(this).val() );
            jQuery('div.location_result_<?php echo $row_id; ?>').hide();
            if ( !empty(location_string) ) {
              jQuery('#wpp_feps_map_<?php echo $row_id; ?>').gmap('search', { 'address': location_string  }, function(isFound,results) {
                if (isFound){
                  jQuery('#wpp_feps_map_<?php echo $row_id; ?>').gmap('getMap').panTo(results[0].geometry.location);
                  jQuery('#wpp_feps_map_<?php echo $row_id; ?>').gmap('clearMarkers');
                  jQuery('#wpp_feps_map_<?php echo $row_id; ?>').gmap('addMarker', {'title':results[0].formatted_address, 'position': new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()) } );
                  jQuery("#wpp_feps_map_<?php echo $row_id; ?>").show();
                  jQuery('div.location_result_<?php echo $row_id; ?>').text("<?php _e('Your location has been successfully found by Google Maps.', 'wpp'); ?>").addClass('wpp_feps_loc_found').removeClass('wpp_feps_loc_not_found').show();
                } else {
                  jQuery("<?php echo "#wpp_{$row_id}_input"; ?>").val('');
                  jQuery('div.location_result_<?php echo $row_id; ?>').text("<?php _e('Your address could not be found, please try again.', 'wpp'); ?>").addClass('wpp_feps_loc_not_found').removeClass('wpp_feps_loc_found').show();
                }
              });
            }
          });
        });
      </script>
    <?php $output_js = ob_get_contents(); ob_end_clean(); echo WPP_F::minify_js($output_js);?>
    <div class="location_result_<?php echo $row_id; ?>"></div>
    <?php
  }
}
