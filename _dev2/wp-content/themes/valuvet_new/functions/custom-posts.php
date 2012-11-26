<?php

//		CUSTOM POST TYPE
/*add_action('init', 'area_contents');
function area_contents() {
   	$args = array(
       	'label' => __('Area content'),
       	'singular_label' => __('area_content'),
       	'public' => false,
       	'show_ui' => true,
       	'capability_type' => 'post',
       	'hierarchical' => false,
       	'rewrite' => true,
       	'supports' => array('title', 'editor', 'thumbnail' )
	);
	register_post_type( 'area-contents' , $args );
}

*/

//		CUSTOM POST TYPE
add_action('init', 'email_template');
function email_template() {
    $wp_properties['labels'] = apply_filters('email_templates_labels', array(
      'name' => __('Email Template', 'valuvet'),
      'all_items' =>  __( 'All Templates', 'valuvet'),
      'singular_name' => __('Email_Templates', 'valuvet'),
      'add_new' => __('Add Template', 'valuvet'),
      'add_new_item' => __('Add New Template','valuvet'),
      'edit_item' => __('Edit Template','valuvet'),
      'new_item' => __('New Template','valuvet'),
      'view_item' => __('View Template','valuvet'),
      'search_items' => __('Search Templates','valuvet'),
      'not_found' =>  __('No templates found','valuvet'),
      'not_found_in_trash' => __('No templates found in Trash','valuvet'),
      'parent_item_colon' => ''
    ));
	
   	$args = array(
      'labels' => $wp_properties['labels'],
       	'singular_label' => __('email_templates'),
       	'public' => false,
       	'show_ui' => true,
       	'capability_type' => 'post',
       	'hierarchical' => false,
       	'rewrite' => true,
       	'supports' => array('title', 'editor' )
	);
	register_post_type( 'email-template' , $args );
}

function valuvet_post_meta_admin_menu_init(){
//New metaboxes
    add_submenu_page('edit.php?post_type=email-template', 'Assign Template', 'Assign Template', 'administrator', 'email-template','custom_post_metabox');
}



function get_email_templates(){
	global $wpdb;
	$querystr = "
	  SELECT PO.ID,PO.post_title
	  FROM $wpdb->posts AS PO 
	  LEFT JOIN $wpdb->postmeta AS PM
	  ON PO.ID = PM.post_id 
	  WHERE PO.post_type = 'email-template'
	  GROUP BY PO.ID
	  ORDER BY PO.post_date DESC
	";
	$pageposts = $wpdb->get_results($querystr, OBJECT);
	return $pageposts;
} 



function custom_post_metabox(){
	?>
	<div class="wrap">
    <?php 
		if( isset( $_GET['action'] ) && ( $_GET['action']=='delete' ) && isset( $_GET['id'] )  ){
			wp_delete_category( $_GET['id'] );
			$valuvet_message = '<div id="message" class="message">Notification is deleted.</div>';
			echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Notification Deleted.</strong></p></div>';
		}
	?>
   
		<h2><?php  echo  __('Assign template to notification emails.','valuvet') ?></h2>
        <?php   echo  __('<strong>WARRNING:</strong>Change these settings only if you know what you are doing');?>
        <?php $ntemail_list = get_category_by_slug( 'email_notifications' );
		if( $ntemail_list ){
		?>
        <table width="80%" border="0" style="border:1px solid #999;">
  <tr>
        <th width="255">Notification Email</th>
        <th width="208">Template</th>
        <th width="270">Description</th>
        <th width="47">&nbsp;</th>
  </tr>
  <?php
       $ntemail_list = get_category_by_slug( 'email_notifications' );
		$category_ids = get_all_category_ids();
		foreach($category_ids as $cat_id) {
			if( cat_is_ancestor_of( $ntemail_list->cat_ID, $cat_id ) ){
				$thisCat = get_category( $cat_id );
  ?>
  <tr>
    <td style="padding: 8px 0 8px 0;"><?php echo $thisCat->slug;?></td>
    <td style="padding: 8px 0 8px 0;">
	<?php 
	$mypost = get_post($thisCat->cat_name);
	echo $mypost->post_title;?></td>
    <td style="padding: 8px 0 8px 0;"><?php echo $thisCat->description;?></td>
    <td style="padding: 8px 0 8px 0;"><a href="edit.php?post_type=email-template&page=email-template&action=delete&id=<?=$thisCat->cat_ID?>" onclick="return confirm('Are you sure you need to delete this email notification. This operation can not undo.');">Delete</a></td>
    </tr>
  <?php 
			}
  	} ?>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>

</table>

      <?php  echo  __('To edit template assign. Enter location id, description and select email template to that location','valuvet') ?>
	<?php } ?>

        
<div class="wrap">
		<h2><?php  echo  __('Assign template to notification emails','valuvet') ?></h2>
        
<form id="form1" name="form1" method="post" action="">
     <?php wp_nonce_field('et_management'); ?>
<table width="666" border="0">
  <tr>
    <td width="353">Location ID (If new, must be unique )</td>
    <td colspan="2">
      <label>
        <input type="text" name="locationid" id="locationid" size="35" maxlength="50" />
      </label>
     EX:notify_customer_info_required
    </td>
    </tr>
  <tr>
    <td width="353">Location Description</td>
    <td colspan="2">
      <label>
        <textarea name="location_description" rows="5" cols="60"></textarea>
      </label>
  
    </td>
    </tr>
  <tr>
    <td>Template</td>
    <td width="79">
    <?php 			$et_contents = get_email_templates();?>
    <select name="email_template">
    	<?php 
			if ($et_contents):
				foreach ($et_contents as $post):
		?>    
    	<option value="<?=$post->ID;?>"><?=$post->post_title;?></option>
        <?php
				endforeach;
			endif;
		?>
    </select>
    
    </td>
    <td width="220">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<input type="submit" name="sumbit-notify" class="" value="Save Data" />
</form>

  </div>
    <?php
}


function send_test_email_templates(){
	global $post;	
	?>
<table width="100%" border="0">
  <tr>
    <td width="40%">Send test email</td>
    <td><input type="checkbox" name="sendtestemail" value="send" /></td>
  </tr>
  <tr>
    <td>Test email will sent to</td>
    <td><?php echo get_bloginfo( 'admin_email' );?></td>
  </tr>
  <tr>
    <td>You can use following codes to insert users and system variables. </td>
    <td>"{AUTHOR_EMAIL} : Post Author email<br />
							   "{AUTHOR_FIRST_NAME}" : Author First name<br />
							   "{AUTHOR_LAST_NAME}"  : Author Last name<br />
							   "{AUTHOR_USERNAME}"  : Author Username<br />
							   "{AUTHOR_PASSWORD}"  : Author Password<br />
                               
                               </td>
  </tr>

</table>

	
    <?php
}

function save_send_test_email(){
	global $post;
	if( isset( $_REQUEST['sendtestemail'] ) ){
	  $bloginfo = get_bloginfo( 'name' );
	  $admin_email = get_bloginfo( 'admin_email' );
	  	$userby = get_user_by('email', $admin_email);
		$user_data = get_userdata( $userby->ID );
		$notify_data = array(
		   "{AUTHOR_EMAIL}" => $user_data->user_email,
		   "{AUTHOR_FIRST_NAME}" => ( !empty($user_data->first_name ) ) ?$user_data->first_name :$user_data->display_name ,
		   "{AUTHOR_LAST_NAME}" => $user_data->last_name ,
		   "{AUTHOR_USERNAME}" => $user_data->user_login ,
		   "{AUTHOR_PASSWORD}" => $new_user['user_pass']
	   );
		$data = get_valuvet_notify_email_template_byid( $post->ID, $notify_data);
		$admin_email = get_bloginfo( 'admin_email' );
		$header =  "From: $bloginfo <$admin_email>\n"; // header for php mail only
        wp_mail( $user_data->user_email , sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header );
	}
}

//add email template selector metabox
add_filter("admin_menu", 'valuvet_post_meta_admin_menu_init');
add_action( 'admin_init', 'et_add_notification' );
function et_add_notification(){
	global $todo_class;
	
	add_action('save_post','save_send_test_email' );
	add_meta_box("send_test_email", "Send test email", 'send_test_email_templates' , "email-template", "normal", "low");

	
	if( isset($_POST['sumbit-notify']) && $_POST['sumbit-notify']=='Save Data' ){
		et_notify_update();
	}
}


function show_valuvet_message(){
	global $valuvet_message;
	if( isset($valuvet_message) ) {
		echo '<div id="message" class="updated fade">';
		echo "<p><strong>".$valuvet_message."</strong></p></div>";
	}
}

function et_notify_update(){
		global $wpdb;
		global $valuvet_message;
		
		if( check_admin_referer('et_management') ){	
			if( isset($_POST['email_template']) && !empty($_POST['email_template']) ){
				$ntemail_cat = get_category_by_slug( 'email_notifications' );
				$templateid = str_replace(" ","_",$_POST['email_template']); 
				if( !$ntemail_cat ){			//runs only one time to create parent category for notifications
					$cat_defaults = array(
					  'cat_name' => 'Email notifications' ,
					  'cat_slug' => 'email_notifications' ,
					  'category_description' => 'Category will save all the templates and notifications relationships.',
					  'category_nicename' => 'email_notifications' ,
					  'category_parent' =>  0);
					$my_cat_id = wp_insert_category($cat_defaults);
					$notification = array(
					  'cat_name' => trim( $templateid ) ,		//unique id for notification
					  'cat_slug' => trim( $_POST['locationid'] ) ,		//
					  'category_description' => trim( $_POST['location_description'] ),
					  'category_nicename' => trim( $_POST['locationid'] ) ,
					  'category_parent' =>  $my_cat_id );
					wp_insert_category($notification);
					$valuvet_message ='<div id="message" class="message">Notification is created.</div>';
				} else {
					$notification = array(
					  'cat_name' => trim( $templateid ) ,		//unique id for notification
					  'cat_slug' => trim( $_POST['locationid'] ) ,		//
					  'category_description' => trim( $_POST['location_description'] ),
					  'category_nicename' => trim( $_POST['locationid'] ) ,
					  'category_parent' =>  $ntemail_cat->cat_ID );
					wp_insert_category($notification);
					$valuvet_message ='<div id="message" class="message">Notification is created.</div>';
				}
				add_action('admin_notices', 'show_valuvet_message');
			}
		}
}