<?php
//New metaboxes
function wpp_extend_admin_init(){
	remove_submenu_page( 'edit.php?post_type=property', 'packages' );
    add_submenu_page('edit.php?post_type=property', 'System', 'System', 'administrator', 'packages','wpe_packages_metabox');
}


if ( is_admin() ) {
	if ( $_GET['page'] == 'packages' && isset($_POST['button-submit']) ){
		add_action('init', 'update_wppe_options' ); //Runs after WordPress has finished loading but before any headers are sent.
	} 
}


function update_wppe_options(){
	if( check_admin_referer('wppe_packages_save') ){	
		foreach( $_POST['plisting'] as $key => $value ){ 
			update_option( $key, $value );
		}
	}
}

function wpe_packages_metabox(){
	screen_icon();
	?>
	<div class="wrap">
		<h2><?php  echo  __('Properties','wpp'). ' ' . __('Packages','wpp') ?></h2>
        
      <form method="post" action="<?php echo admin_url('edit.php?post_type=property&page=packages'); ?>" />
      <?php wp_nonce_field('wppe_packages_save'); ?>

      <h3>Packages</h3>
        <table width="500" border="0">
  <tr>
  	<thead>
        <th>Name</th>
        <th>ID</th>
        <th>Price</th>
        <th>Images allow per package</th>
    </thead>
  </tr>
  <tr>
    <td>Package 1</td>
    <td>package_1</td>
    <td><input type="text" name="plisting[package_1]" maxlength="8" size="10" style="text-align:right;" value="<?php echo set_money_format( get_option('package_1', '0.00') );?>" /></td>
    <td align="center"><input type="text" name="plisting[package_1_img]" maxlength="2" size="4" style="text-align:right;" value="<?php echo  get_option('package_1_img', '0');?>" /></td>
  </tr>
  <tr>
    <td>Package 2</td>
    <td>package_2</td>
    <td><input type="text" name="plisting[package_2]" maxlength="8" size="10" style="text-align:right;" value="<?php echo set_money_format( get_option('package_2', '0.00') );?>" /></td>
    <td align="center"><input type="text" name="plisting[package_2_img]" maxlength="2" size="4" style="text-align:right;" value="<?php echo  get_option('package_2_img', '1');?>" /></td>
  </tr>
  <tr>
    <td>Package 3</td>
    <td>package_3</td>
    <td><input type="text" name="plisting[package_3]" maxlength="8" size="10" style="text-align:right;" value="<?php echo set_money_format( get_option('package_3', '0.00') );?>" /></td>
    <td align="center"><input type="text" name="plisting[package_3_img]" maxlength="2" size="4" style="text-align:right;" value="<?php echo  get_option('package_3_img', '6');?>" /></td>
  </tr>
</table>

      <h3>Property Listing Settings</h3>
      <table width="60%" border="0">
          <tr>
            <td>Listing valid for (No of days)</td>
            <td><input type="text" name="plisting[listing_validity]" maxlength="5" size="3" value="<?php echo get_option('listing_validity');?>" /></td>
          </tr>
          <tr>
            <td>1st notifications(Days before expire)</td>
            <td><input type="text" name="plisting[property_listing_notification_1]" maxlength="5" size="3" value="<?php echo get_option('property_listing_notification_1', 30);?>" /></td>
          </tr>
          <tr>
            <td>2nd notifications(Days before expire)</td>
            <td><input type="text" name="plisting[property_listing_notification_2]" maxlength="5" size="3" value="<?php echo get_option('property_listing_notification_2', 14);?>" /></td>
          </tr>
          <tr>
            <td>3rd notifications(Days before expire)</td>
            <td><input type="text" name="plisting[property_listing_notification_3]" maxlength="5" size="3" value="<?php echo get_option('property_listing_notification_3', 1);?>" /></td>
          </tr>   
          <tr>
            <td>Currency symbol</td>
            <td><input type="text" name="plisting[currency_symbol]" maxlength="5" size="3" value="<?php echo get_option('currency_symbol', '$');?>" /></td>
          </tr>          
        </table>
        
        

      <h3>Google Map Settings</h3>
      <table width="60%" border="0">
          <tr>
            <td>Map width</td>
            <td><input type="text" name="plisting[google_map_width]" maxlength="5" size="4" value="<?php echo get_option('google_map_width');?>" /></td>
          </tr>
          <tr>
            <td>Map height</td>
            <td><input type="text" name="plisting[google_map_height]" maxlength="5" size="4" value="<?php echo get_option('google_map_height');?>" /></td>
          </tr>
        </table>
        
        
        

      <h3>Paypal Details</h3>
      <table width="60%" border="0">
          <tr>
            <td>API Username</td>
            <td><input type="text" name="plisting[paypalemail]" maxlength="35" size="60" value="<?php echo get_option('paypalemail');?>" /></td>
          </tr>
          <tr>
            <td>Paypal Password</td>
            <td><input type="text" name="plisting[paypalpassword]" maxlength="35" size="60" value="<?php echo get_option('paypalpassword');?>" /></td>
          </tr>
          <tr>
            <td>Paypal API signature</td>
            <td><input type="text" name="plisting[paypalapi]" maxlength="75" size="80" value="<?php echo get_option('paypalapi');?>" /></td>
          </tr>
          <tr>
            <td>API Mode</td>
            <td>
            <?php $paypalapi_mode = get_option('paypalapi_mode', 'Test');?>
            <select name="plisting[paypalapi_mode]">
            	<option<?php if( $paypalapi_mode=='Test' ) echo ' selected="selected"';?>>Test</option>
            	<option<?php if( $paypalapi_mode=='Live' ) echo ' selected="selected"';?>>Live</option>
            </select>
            </td>
          </tr>
          <tr>
            <td>Payment success message</td>
            <td><input type="text" name="plisting[paymentsuccess_message]" size="60" value="<?php echo get_option('paymentsuccess_message');?>" /></td>
          </tr>
          
          
        </table>


      <h3>Property form</h3>
      <table width="60%" border="0">
          <tr>
            <td>Property form page</td>
            <td><input type="text" name="plisting[property_form_page]" maxlength="150" size="60" value="<?php echo get_option('property_form_page');?>" /></td>
          </tr>
          <tr>
            <td>Property form page ID</td>
            <td><input type="text" name="plisting[property_frm_pgid]" maxlength="3" size="10" value="<?php echo get_option('property_frm_pgid');?>" /></td>
          </tr>
          <tr>
            <td>Property overview page</td>
            <td><input type="text" name="plisting[property_overview_page]" maxlength="150" size="60" value="<?php echo get_option('property_overview_page');?>" /></td>
          </tr>
        </table>
        If property type is not selected. redirect user to property type selection page. Use [property_type_select_form] short code in the property type select page.


      <h3>Cron run</h3>
      <table width="60%" border="0">
        <tr>
          <td>Cron secure code</td>
          <td><input type="text" name="plisting[system_secure_cron]" maxlength="150" size="60" value="<?php echo get_option('system_secure_cron', md5(SECURE_AUTH_KEY) );?>" /></td>
        </tr>
      </table>
      
      <h3>Property package change page</h3>
      <table width="60%" border="0">
        <tr>
          <td>Package change page</td>
          <td><input type="text" name="plisting[property_package_change_url]" maxlength="150" size="60" value="<?php echo get_option('property_package_change_url' );?>" /><br />
          Used to upgrade or downgrade the property packages by user when renewing the package. Once they click on change package link. They will sent to this page. Once select package they will send to actual payment page(Property Page).
          Only works with Renew package is true;
          </td>
        </tr>
        <tr>
          <td>Change package explain page</td>
          <td><input type="text" name="plisting[property_package_change_explain]" maxlength="150" size="60" value="<?php echo get_option('property_package_change_explain' );?>" /><br />
          Explain the process of changing packages.
          </td>
        </tr>
        <tr>
        	<td>Package upgrade page</td>
          <td><input type="text" name="plisting[property_package_upgrade_url]" maxlength="150" size="60" value="<?php echo get_option('property_package_upgrade_url' );?>" /><br />
          Used to upgrade packages;
          </td>
        </tr>
      </table>
	<p class="wpp_save_changes_row">
	<input type="submit" value="<?php _e('Save Changes','wpp');?>" name="button-submit" class="button-primary" >
 	</p>
</form>
    </div>
    <?php
}
add_filter("admin_menu", 'wpp_extend_admin_init');

function get_allowed_images( $posttype ){
	if( $posttype=='package_3' ){
		return get_option('package_3_img' );
	} elseif( $posttype=='package_2' ){
		return get_option('package_2_img' );
	} else {
		return get_option('package_1_img' );
	}
}


function propertymeta_admin_init(){
	global $pagenow,$wp_properties, $post;
	global $wp_taxonomies;
	
	
	add_meta_box("property_images", "Image Gallery", "property_gallery_box", "property", "normal", "low");
	add_meta_box("author_details", "Listing Status", "property_author_box", "property", "side", "low");

	if( $pagenow == 'post.php' ){
	    wp_register_style( 'wp-property-extend-style', plugins_url('wp-property-extend/css/style-wp-property-extend.css') );
	    wp_enqueue_style( 'wp-property-extend-style' );
	}
	unset( $wp_taxonomies['property_feature']);
	unset( $wp_taxonomies['community_feature']);
}


function wppe_set_globals(){
	global $notify_data;
	$bloginfo = get_bloginfo( 'name' );
	$admin_email = get_bloginfo( 'admin_email' );
	$loginlink = 'wp-login.php';
	$myurl = site_url();

	$notify_data = array(
						 '{ADMIN_EMAIL}' => $admin_email,
						 '{BLOG_INFO}' => $bloginfo,
						 '{LOGIN_LINK}' => $myurl . '/wp-login.php',
						 '{SITE_URL}' => $myurl
						 );

}

function wppe_init(){
	global $post;
	global $notify_data;
	
	wppe_set_globals();
	cron_check();
	do_action('wppe_init_action');
/*	
	
	$rul = url_to_postid( $_SERVER['REQUEST_URI'] );
	$frmid = get_option('property_frm_pgid');
	if( isset( $rul ) && $rul==$frmid ){
		if( !isset($_POST['property_type']) ){
			header("Location:".get_option('property_type_selection_page') );
			exit();
		}
	}*/
}



function property_gallery_box(){
	global $post;
	//UPDATE ATTACHMENTS AUTHOR TO POST PARENT AUTHOR
	$custom = get_property( $post->ID );
	$images = &get_children( 'post_type=attachment&post_mime_type=image&post_parent='.$post->ID );
	if ($images) {
		foreach($images as $image) {
			$my_post = array();
			$my_post['ID'] = $image->ID;
			$my_post['post_author'] = $image->post_author;
			wp_update_post( $my_post );		
		}
	}
?>

<div class="form-wrap">
       <?php if( isset($custom['gallery']) ) property_image_gallery( $custom['gallery'], array( 'size' => 'thumbnail', 'skipfirst' => true, 'skiphelp' => false, 'add_description_field' => true, 'post_id' => $post->ID ) ); ?>

		<div style="clear:both;"></div>
        <?php 
			$count = count($custom['gallery']);
			$noofimages = get_option( $custom['property_type'].'_img' );
			if( $count<$noofimages ){ ?>
            	<?php while( $count<$noofimages){?>
                
                <div class="newfile_upload_entry">
            	<input type="file" name="newfileupload[]" />
            	<br />Title : <input type="text" name="new_file_description[]" maxlength="50" size="25" />
                </div>
            	<?php $count++;
					} ?>
                <div style="clear:both;"></div>
            <?php	}
		?>
        
</div>
	
<?php
}

add_action('save_post', 'save_property_image_uploads');
add_action('save_post', 'save_google_address');
add_action('post_edit_form_tag', 'wppe_post_edit_form_tag');
//save_property hook is in class_core.php in wp-property line 715
add_action('save_property', 'save_google_address');


function set_save_property_address(){
}

function save_google_address(){
	global $post;
	if( $post->post_type=='property' ){
		$business_address = get_post_custom_values('business_address', $post->ID );
		$suburb = get_post_custom_values('suburb', $post->ID );
		$post_code = get_post_custom_values('post_code', $post->ID );
		$practice_state = get_post_custom_values('practice_state', $post->ID );
		$address = $business_address[0] . ' ' .$suburb[0] .  ' ' .$post_code[0] . ' ' . $practice_state[0] . ' Australia';
		update_post_meta( $post->ID, 'google_address', $address );
		set_map_coordinates( $post->ID,  $address );
	}
}

function wppe_post_edit_form_tag(){
	echo ' enctype="multipart/form-data"';
}

function save_property_image_uploads(){
	global $post;
		if( isset( $_POST['file_description'] ) ){
			foreach( $_POST['file_description'] as $key => $value ){
				if( !empty( $key ) && ( $key>$post->ID ) ){
					$my_post = array();
					$my_post['ID'] = $key;
					$my_post['post_title'] = $value;
					wp_update_post( $my_post );
				}
			}
		}
		
	
		if( isset( $_POST['delete_image'] ) ){
			foreach( $_POST['delete_image'] as $key => $value ){
				wp_delete_attachment( $value );
			}
		}
		
		if( isset($_FILES['newfileupload']['name']) ){
			foreach( $_FILES['newfileupload']['name'] as $key => $value){
			$oldfilename = $_FILES['newfileupload']['name'][$key];
			$oldfile = $_FILES['newfileupload']['tmp_name'][$key];
				if( !empty( $oldfilename ) ){
					$chfilename = preg_replace('/[^a-zA-Z0-9._\-]/', '', $oldfilename); 
					$uploads = wp_upload_dir();
					$original_filename = basename ($oldfilename);
					$newfilename = wp_unique_filename( $uploads['path'], $chfilename);
					$new_file = $uploads['path'] . "/$newfilename";
					$file_data = wp_check_filetype_and_ext($oldfile, $oldfilename);
					$overrides = array( 'test_form' => false);
	
	
					if( move_uploaded_file($_FILES['newfileupload']['tmp_name'][$key], $new_file ) ){
						$attachment = array(
									  'post_parent' => $post->ID,
									  'post_author' => $post->post_author,
									  'post_mime_type' => $file_data['type'],
									  'guid' => $uploads['baseurl'] . _wp_relative_upload_path( $newfilename ),
									  'post_title' => trim( $_POST['new_file_description'][$key]),
									  'post_content' => '',
									);
						$attachment_id = wp_insert_attachment( $attachment, $new_file, $post->ID );
						wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $new_file));
						$property = get_property( $post->ID );
						if( $property["property_type"]=="package_2" ){
							set_post_thumbnail( $post->ID, $attachment_id );
						}
					}
				}
			}
		}
		
		if( isset( $_POST['set_featured'] ) && !empty($_POST['set_featured'])  ){
			set_post_thumbnail( $post->ID, (int)$_POST['set_featured'] );
		} 
}

function wpe_submit_property( $property_id ){
	global $notify_data;
	
	$post = get_post( $property_id  );
	$this_data = wppe_get_post_notification_data( $post );
	$note_data = array_merge( $notify_data, $this_data );
	$data = get_valuvet_notify_email_template( 'new_property_listing_submit_success', $note_data );
	$header =  "From: ".$notify_data['{BLOG_INFO}']."<".$notify_data['{ADMIN_EMAIL}'].">\n"; // header for php mail only
	wp_mail( $note_data['{AUTHOR_EMAIL}'], sprintf(__('%s '.$data['subject'] ), $notify_data['{BLOG_INFO}'] ), $data['message'], $header);
	
	$data = get_valuvet_notify_email_template( 'new_property_listing_submit_success_admin', $note_data );
	$header =  "From: ".$notify_data['{BLOG_INFO}']."<".$notify_data['{ADMIN_EMAIL}'].">\n"; // header for php mail only
	wp_mail( $notify_data['{ADMIN_EMAIL}'], sprintf(__('%s '.$data['subject'] ), $notify_data['{BLOG_INFO}'] ), $data['message'], $header);
}

function process_featured_uploads( $property_id, $user_id ){
	
	include_once  ABSPATH . 'wp-admin/includes/image.php';


		if( isset($_FILES['featured_image']['name']) ){
			$oldfilename = $_FILES['featured_image']['name'];
			$oldfile = $_FILES['featured_image']['tmp_name'];
			if( !empty( $oldfilename ) ){
	       		$chfilename = preg_replace('/[^a-zA-Z0-9._\-]/', '', $oldfilename); 
				$uploads = wp_upload_dir();
				$original_filename = basename ($oldfilename);
				$newfilename = wp_unique_filename( $uploads['path'], $chfilename);
				$new_file = $uploads['path'] . "/$newfilename";
				$file_data = wp_check_filetype_and_ext($oldfile, $oldfilename);
				$overrides = array( 'test_form' => false);


				if( move_uploaded_file($_FILES['featured_image']['tmp_name'], $new_file ) ){
					$attachment = array(
								  'post_parent' => $property_id,
								  'post_author' => $user_id,
								  'post_mime_type' => $file_data['type'],
								  'guid' => $uploads['baseurl'] . _wp_relative_upload_path( $newfilename ),
								  'post_title' => trim( $_POST['featured_image_description']),
								  'post_content' => '',
								);
					$attachment_id = wp_insert_attachment( $attachment, $new_file, $property_id );
					wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $new_file));
					set_post_thumbnail( $property_id, $attachment_id );
				}
			}
		}
}

function process_gallery_uploads( $property_id, $user_id ){
	include_once  ABSPATH . 'wp-admin/includes/image.php';
	if( isset($_FILES['moreuploads']['name']) ){
			foreach( $_FILES['moreuploads']['name'] as $key => $value){
			$oldfilename = $_FILES['moreuploads']['name'][$key];
			$oldfile = $_FILES['moreuploads']['tmp_name'][$key];
				if( !empty( $oldfilename ) ){
					$chfilename = preg_replace('/[^a-zA-Z0-9._\-]/', '', $oldfilename); 
					$uploads = wp_upload_dir();
					$original_filename = basename ($oldfilename);
					$newfilename = wp_unique_filename( $uploads['path'], $chfilename);
					$new_file = $uploads['path'] . "/$newfilename";
					$file_data = wp_check_filetype_and_ext($oldfile, $oldfilename);
					$overrides = array( 'test_form' => false);
					if( move_uploaded_file($_FILES['moreuploads']['tmp_name'][$key], $new_file ) ){
						$attachment = array(
									  'post_parent' => $property_id,
									  'post_author' => $user_id,
									  'post_mime_type' => $file_data['type'],
									  'guid' => $uploads['baseurl'] . _wp_relative_upload_path( $newfilename ),
									  'post_title' => trim( $_POST['more_upload_description'][$key] ),
									  'post_content' => '',
									);
						$attachment_id = wp_insert_attachment( $attachment, $new_file, $post->ID );
						wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $new_file));
					}
				}
			}
		}
		
		if( !isset($_FILES['moreuploads']['name']) && isset( $_POST['more_upload_description'])  ){
			$args = array(
				'post_type' => 'attachment',
				'numberposts' => null,
				'post_status' => null,
				'order'=> 'ASC', 
				'orderby' => 'ID',
				'post_parent' => $property_id
			);
			$attachments = get_posts($args);
			if ($attachments) {
				foreach ($attachments as $key => $attachment) {
					switch( $attachment->post_mime_type ){
						case 'image/jpeg':
								$mime = '.jpg';
							break;
						case 'image/gif':
								$mime = '.gif';
							break;
						case 'image/png':
								$mime = '.png';
							break;
						default:
								$mime = '.jpeg';
							break;
						
					}
					$postfile='';
					$tmp = explode(".", $_POST['featured'] );
					$posttitle = $attachment->post_title;
					if( isset( $_POST['featured'] ) && ( $_POST['featured']==$posttitle.$mime || eregi( $tmp[0].'[0-9]\.'.$tmp[1], $posttitle.$mime ) )  ){
						set_post_thumbnail( $property_id, $attachment->ID );
					}
					
					$found=false;
					foreach( $_POST['more_upload_description'] as $key => $value){
						$tmp = explode(".", $key );
						if( eregi( $tmp[0].'[0-9]\.'.$tmp[1], $posttitle.$mime ) || eregi( $tmp[0].'\.'.$tmp[1], $posttitle.$mime )  ){
							$postfile = $_POST['more_upload_description'][$key];
							$found=true;
						}
					}
					
					if( $found ){
						$my_post = array();
						$my_post['ID'] = $attachment->ID;
						$my_post['post_title'] = $postfile;
						wp_update_post( $my_post );
					}
				}
			}
		}
}



function property_author_box(){
	global $post;
	$custom = get_post_custom($post->ID);
	$author_email = get_the_author_meta( 'user_email' , $post->post_author);
	$author_link = get_author_posts_url( $post->post_author );
	$views = get_post_meta( $post->ID, 'property_views' , true );
	$renewdate = get_property_renew_date( $post->post_date );
	if( is_renew_old( $post->post_date ) ) update_post_meta( $post->ID, 'wpp_feps_pending_hash', md5( $post->ID.$post->post_author )  );
	
?>
<div class="form-wrap">
		Listing Views : <?php echo $views;?><br />
		Author Email : <a href="user-edit.php?user_id=<?=$post->post_author?>"><?php echo $author_email;?></a><br />
		Renewal Date : <?php echo $renewdate?>
        <?php $renewget_renewal_link = get_renewed_status_by_date( $post->post_date ); ?>
        <?php if( !empty( $renewget_renewal_link ) ) {?>
        <p style="float:right;"><a target="_blank" href="<?php echo get_option('property_package_change_url' );?>&package=<?=$post->ID?>">Change Package</a></p>
        <p><a target="_blank" href="<?php echo get_renewal_link( $post );?>">Renew listing</a></p>
        <?php } else { 
			$property = get_property( $post->ID );
			if( $property["property_type"]!="package_3" ){
				echo  '<p><a target="_blank" href="'.get_option('property_package_upgrade_url' ). '&package='.$post->ID.'">Upgrade Package</a></p>';
			}
		
		}
		?>
        
</div>
<?php
}

add_action("admin_init", "propertymeta_admin_init");


// hide "add new" on wp-admin menu
function wppe_add_box() {
  global $submenu,$user_level;
	if( $user_level<10  ){
	  unset($submenu['edit.php?post_type=property'][10]);
	  unset($submenu['upload.php']);
	}
	
	unset( $submenu["edit.php?post_type=property"][15] );
	unset( $submenu["edit.php?post_type=property"][16] );
}


	function wppe_add_buttons()
	{
	  global $current_screen;
	  if( $current_screen->id == 'property_page_all_properties' || $current_screen->id == 'properties' && !current_user_can('publish_pages')) {
		echo '<style>.add-new-h2{display: none;}</style>';  
	  }
	  // for posts the if statement would be:
	  // if($current_screen->id == 'edit-post' && !current_user_can('publish_posts'))
	}

add_action('admin_menu','wppe_add_box');
add_action('admin_head','wppe_add_buttons');

function featured_image($size='medium'){
	global $post;
	
	$thumb='';$large='';$title='';
	$proerty = WPP_F::get_property($post->ID);
	if( isset($proerty["gallery"]) && !empty($proerty["gallery"]) ){
		foreach($proerty["gallery"] as $gallery ){
			if( $gallery[$size] ){
				$thumb=$gallery[$size];
				$large=$gallery['large'];
				$title=$gallery['post_title'];
				break;
			}
		}
	}
	$thumb = ( !empty( $thumb ) )?$thumb:get_option('vv_default_thumb');
	echo '<div class="property_img_left"><div class="img-medium"><a id="fancybox-image" href="'.$large.'" onclick="return false;" title="'.$title.'"><img src="'.$thumb.'" alt=""></a></div></div>
			<div class="clear"></div>';			
}

function featured_overview_images( $featuredimage='', $postimages, $size='medium', $featured_title='' ){
	$thumb='';$large='';
	//CANT ADD FEATURE IMAGE DIRECT SINCE IT HAS NO SIZING
		if( is_array($postimages) ){
				if( !empty( $featuredimage ) ){
					$thumb=$postimages[$size];
					$large=$postimages['large'];
					$title=$postimages['post_title'];
				} 
			}
			
		if( isset($featuredimage) && empty($thumb) ) {
				$thumb=$featuredimage;
				$large=$featuredimage;
				$title=$featured_title;
		}
		
		
	$img_size = ( $size=='large')?'img-large':'img-medium';
	$thumb = ( !empty( $thumb ) )?$thumb:get_option('vv_default_thumb');
	echo '<div class="property_img_left"><div class="'.$img_size.'"><a id="fancybox-image" href="'.$large.'" onclick="return false;" title="'.$title.'"><img src="'.$thumb.'" alt=""></a></div></div>
			<div class="clear"></div>';
			
}

function package_1( $post=NULL ){
		global $post;
	?>
    
	<table id="listing" border="0" width="100%">
                    <tr>
                    <td colspan="2"><h1><?php echo $post->post_title;?></h1>
                    <hr/></td></tr>
                    
                    <tr><td>
                    
                    <p><em>Business Name:</em> <?php echo ucfirst( $post->practice_name );?></p>
					<p><em>Address:</em>  <?php echo $post->business_address;?>, <?php echo $post->suburb;?>, <?php echo $post->practice_state;?> <?php echo $post->post_code;?></p>
                    </td>
                    <td><h3>Contact</h3>
                    <p><?php get_further_info( 'title_name', $post, 'object' );?><br /><?php get_further_info('phone', $post, 'object'  );?></p>
                    
                    <p>Email: <script language=javascript>
                      <!--
                      var contact = "CLICK TO EMAIL";
                      var email<?php echo $post->ID; ?> = "<?php get_further_info( 'email', $post, 'object')?>";
                      var emailSubject<?php echo $post->ID; ?> = "<?php echo $post->post_title; ?>";
                      document.write('<a href="#contact_popup" id="cpopup_<?php echo $post->ID; ?>" class="fancybox-contact">' + contact + '</a>')
						jQuery(document).ready(function($) {
								jQuery('#cpopup_'+<?php echo $post->ID; ?>).click(function() { //start function when Random button is clicked
									$("#cform_msg").html(''); 
								  document.getElementById('myemail').value = email<?php echo $post->ID; ?>;
								  document.getElementById('mysubject').value = emailSubject<?php echo $post->ID; ?>;
								  document.getElementById('property_id').value = <?php echo $post->ID; ?>;
								  document.getElementById('mysubject_display').innerHTML = emailSubject<?php echo $post->ID; ?>;
							});
						});
                      //-->
                    </script></p>
                    </td>
                    </tr>
                    <tr>
                      <td>
                    <h2>Asking Price: <?php echo ( $post->show_asking_price=='Yes' )? make_askingprice( $post->property_value ):'POA';?></h2>
                    </td>
                      <td>&nbsp;</td>
                    </tr>
                    </table>
    <?php
}

function package_1_overview( $post ){
	
	$option = array( 'ID' => $post['ID'], 'property_type' => $post['property_type'], 'practice_state' => $post['practice_state'] );
	?>
                
<ul id="headline"><li><span class="button_left"><?php valuvet_property_state_full( $post['practice_state'] )?> - <?php valuvet_get_property_ID( $option  );?></span> <span class="button_right"><span class="post_date"><?php add_flag_items_to_property_title_header( $post['ID'] )?> Posted: <?php echo strtoupper( date("d M Y", strtotime($post['post_date'])) )?> | Updated: <?php echo strtoupper( date("d M Y", strtotime($post['post_modified'])) )?></span></span></li></ul>
                
                
	<table id="listing" border="0" width="100%">
                    <tr>
                    <td colspan="2"><h1><?php echo $post['post_title'];?></h1>
                    <hr/></td></tr>
                    
                    <tr><td>
                    
<p><em>Business Name:</em> <?php echo ucfirst( $post['practice_name'] );?></p>
<p><em>Address:</em>  <?php echo $post['business_address'];?>, <?php echo $post['suburb'];?>, <?php echo $post['practice_state'];?> <?php echo $post['post_code'];?></p>
<p><a class="fancybox-iframe" href="?gmap=<?php echo google_map_address($post);?>&property=<?=$post['ID']?>">Map Link</a></p>
                    </td>
                    <td><h3>Contact</h3>
                    <p><?php get_further_info( 'title_name', $post );?><br /><?php get_further_info('phone', $post );?></p>
                    
                    <p>Email: <script language=javascript>
                      <!--
                      var contact = "CLICK TO EMAIL";
                      var email<?php echo $post['ID']; ?> = "<?php get_further_info( 'email', $post)?>";
                      var emailSubject<?php echo $post['ID']; ?> = "<?php echo $post['post_title']; ?>";
                      document.write('<a href="#contact_popup" id="cpopup_<?php echo $post['ID']; ?>" class="fancybox-contact">' + contact + '</a>')
						jQuery(document).ready(function($) {
								jQuery('#cpopup_'+<?php echo $post['ID']; ?>).click(function() { //start function when Random button is clicked
								  $("#cform_msg").html(''); 
								  document.getElementById('myemail').value = email<?php echo $post['ID']; ?>;
								  document.getElementById('mysubject').value = emailSubject<?php echo $post['ID']; ?>;
								  document.getElementById('property_id').value = <?php echo $post['ID']; ?>;
								  document.getElementById('mysubject_display').innerHTML = emailSubject<?php echo $post['ID']; ?>;
							});
						});
                      //-->
                    </script></p>
                    </td>
                    </tr>
                    <tr>
                      <td>
                    <h2>Asking Price: <?php echo ( $post['show_asking_price']=='Yes' )? make_askingprice( $post['asking_price'] ):'POA';?></h2>
                    </td>
                      <td>&nbsp;</td>
                    </tr>
                    </table>
    <?php
}

function overview_extras( $post ){
	$show = false;
	
	$output = '<ul class="bullet_list">';
	if( !empty( $post->practice_is_for ) ) { $output .= '<li><span class="bull tri">Property is: '.$post->practice_is_for.'</span></li>' ; $show = true; }
	if( !empty( $post->practice_is_for ) && $post->practice_is_for!='For Sale' ) { $output .= '<li><span class="bull tri">Lease Details: '.$post->lease_details.'</span></li>' ; $show = true; }
	if( !empty( $post->real_estate_available_for_sale ) ) { $output .= '<li><span class="bull tri">Real Estate: '.$post->real_estate_available_for_sale.'</span></li>' ; $show = true; }
	if( !empty( $post->real_estate_available_for_sale ) && $post->real_estate_available_for_sale=='For Lease' ) { $output .= '<li><span class="bull tri">Lease Details: '.$post->real_estate_lease_details.'</span></li>' ; $show = true; }
	if( !empty( $post->equipments_on_sale )  ) { $output .= '<li><span class="bull tri">Equipment: '. ucfirst( $post->equipments_on_sale ).'</span></li>' ; $show = true; }
	if( !empty( $post->stock_on_sale ) ) { $output .= '<li><span class="bull tri">Stock: '.ucfirst( $post->stock_on_sale ).'</span></li>' ; $show = true; }
	if( !empty( $post->valuation_by_valuvet ) && $post->valuation_by_valuvet=='Yes' ) { $output .= '<li><span class="bull tri">ValuVet Valuation: Available</span></li>' ; $show = true; }
	if( !empty( $post->valuation_by_valuvet ) && $post->valuation_by_valuvet=='No' ) { $output .= '<li><span class="bull tri">ValuVet Valuation: Not Available</span></li>' ; $show = true; }
	if( !empty( $post->practice_report_by_valuvet ) && $post->practice_report_by_valuvet=='Yes' ) { $output .= '<li><span class="bull tri">Valuvet Report: Available</span></li>' ; $show = true; }
	if( !empty( $post->practice_report_by_valuvet ) && $post->practice_report_by_valuvet=='No' ) { $output .= '<li><span class="bull tri">Valuvet Report: Not Available</span></li>' ; $show = true; }
	$output .= '</ul><p>&nbsp;</p>';
	if(	$show ) echo $output;
}

function type_of_practice( $post ){
	$show = false;
	$output = '<ul id="headline"><li><span class="button_left">Type of Practice</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
	$output .= '<ul class="bullet_list">';
	if( !empty( $post->type_of_practice ) && $post->type_of_practice=='Other' )  { $output .= '<li><span class="bull tri">Type of Practice: '.$post->type_of_practice_other.'</span></li>' ; $show = true; }
	if( !empty( $post->type_of_practice ) && $post->type_of_practice!='Other' )  { $output .= '<li><span class="bull tri">Type of Practice: '.$post->type_of_practice.'</span></li>' ; $show = true; }
	if( !empty( $post->small_animal_precentage ) ) {
		$show = true;
		$first = false;
		$last = false;
			$output .= '<li><span class="bull tri">'.$post->small_animal_precentage.'% (' ;
			if( !empty( $post->canine ) ) { 
				$output .= 'Canine'; 
				if(!$first) {
					$first=true;
				} 
			}
			if( !empty( $post->feline ) ) { if($first) {$output .= ', ';} $output .= 'Feline'; if(!$first) {$first=true;} }
			if( !empty( $post->avian ) ) { if($first) {$output .= ', ';} $output .= 'Avian'; if(!$first) {$first=true;} }
			if( !empty( $post->exotics ) ) { if($first) {$output .= ', ';} $output .= 'Exotics'; if(!$first) {$first=true;} }
			if( !empty( $post->fauna ) ) { if($first) {$output .= ', ';} $output .= 'Fauna'; if(!$first) {$first=true;} }
			$output .= ')</span></li>';
	}
	
	if( !empty( $post->equine_presentage ) ) {
		$show = true;
		$first = false;
		$last = false;
			$output .= '<li><span class="bull tri">'.$post->equine_presentage.'% (' ;
			if( !empty( $post->pleasure ) ) { if($first) {$output .= ', ';} $output .= 'Pleasure'; if(!$first) {$first=true;} }
			if( !empty( $post->equine_stud ) ) { if($first) {$output .= ', ';} $output .= 'Stud'; if(!$first) {$first=true;} }
			if( !empty( $post->equine_stables ) ) { if($first) {$output .= ', ';} $output .= 'Stables'; if(!$first) {$first=true;} }
			$output .= ')</span></li>';
	}
	if( !empty( $post->bovine_presentage ) ) {
		$show = true;
		$first = false;
		$last = false;
			$output .= '<li><span class="bull tri">'.$post->bovine_presentage.'% (' ;
			if( !empty( $post->beef ) ) { if($first) {$output .= ', ';} $output .= 'Beef'; if(!$first) {$first=true;} }
			if( !empty( $post->dairy ) ) { if($first) {$output .= ', ';} $output .= 'Dairy'; if(!$first) {$first=true;} }
			if( !empty( $post->bovine_stud ) ) { if($first) {$output .= ', ';} $output .= 'Stud'; if(!$first) {$first=true;} }
			$output .= ')</span></li>';
	}
	if( !empty( $post->other_presentage ) ) {
		$show = true;
		$first = false;
		$last = false;
			$output .= '<li><span class="bull tri">'.$post->other_presentage.'% (' ;
			if( !empty( $post->porcine ) ) { if($first) {$output .= ', ';} $output .= 'Porcine'; if(!$first) {$first=true;} }
			if( !empty( $post->ovine ) ) { if($first) {$output .= ', ';} $output .= 'Ovine'; if(!$first) {$first=true;} }
			if( !empty( $post->caprine ) ) { if($first) {$output .= ', ';} $output .= 'Caprine'; if(!$first) {$first=true;}}
			if( !empty( $post->camelid ) ) { if($first) {$output .= ', ';} $output .= 'Camelid'; if(!$first) {$first=true;}}
			$output .= ')</span></li>';
	}
	if( !empty( $post->other_extra_details ) )  { $output .= '<li><span class="bull tri">Other: '.$post->other_extra_details.'</span></li>' ; $show = true; }
	$output .= '</ul><p>&nbsp;</p>';
	if(	$show ) echo $output;
}

function professional_services( $post ){
	$show = false;
	$output = '<ul id="headline"><li><span class="button_left">Professional Services</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
	$output .= '<ul class="bullet_list">';
		if( isset( $post->medicine ) )  { $output .= '<li><span class="bull tri">Medicine</span></li>' ; $show = true; }
		if( isset( $post->surgery ) )  { $output .= '<li><span class="bull tri">Surgery</span></li>' ; $show = true; }
		if( isset( $post->dentistry ) )  { $output .= '<li><span class="bull tri">Dentistry</span></li>' ; $show = true; }
		if( isset( $post->behaviour ) )  { $output .= '<li><span class="bull tri">Behaviour</span></li>' ; $show = true; }
		if( isset( $post->emergency_service ) )  { $output .= '<li><span class="bull tri">Emergency Service</span></li>' ; $show = true; }
		if( isset( $post->diagnostic_laboratory ) )  { $output .= '<li><span class="bull tri">Diagnostic Laboratory</span></li>' ; $show = true; }
		if( isset( $post->radiology ) )  { $output .= '<li><span class="bull tri">Radiology</span></li>' ; $show = true; }
		if( isset( $post->ultrasound ) )  { $output .= '<li><span class="bull tri">Ultrasound</span></li>' ; $show = true; }
		if( isset( $post->specialist ) )  { $output .= '<li><span class="bull tri">Specialist</span></li>' ; $show = true; }
		if( isset( $post->house_calls ) )  { $output .= '<li><span class="bull tri">House Calls</span></li>' ; $show = true; }
		if( isset( $post->endoscopy ) )  { $output .= '<li><span class="bull tri">Endoscopy</span></li>' ; $show = true; }
		if( !empty( $post->other_professional_services ) )  { $output .= '<li><span class="bull tri">Other: '.$post->other_professional_services.'</span></li>' ; $show = true; }
	$output .= '</ul><p>&nbsp;</p>';
	if(	$show ) echo $output;
}

function ancillary_services( $post ){
	$show = false;
	$output = '<ul id="headline"><li><span class="button_left">Ancillary Services</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
	$output .= '<ul class="bullet_list">';
		if( isset( $post->grooming ) )  { $output .= '<li><span class="bull tri">Grooming</span></li>' ; $show = true; }
		if( isset( $post->puppy_school ) )  { $output .= '<li><span class="bull tri">Puppy School</span></li>' ; $show = true; }
		if( isset( $post->boarding ) )  { $output .= '<li><span class="bull tri">Boarding</span></li>' ; $show = true; }
		if( isset( $post->merchandising ) )  { $output .= '<li><span class="bull tri">Merchandising</span></li>' ; $show = true; }
		if( isset( $post->export_certificate ) )  { $output .= '<li><span class="bull tri">Export Certificate</span></li>' ; $show = true; }
		
		if( !empty( $post->other_ancillary_services ) )  { $output .= '<li><span class="bull tri">Other: '.$post->other_ancillary_services.'</span></li>' ; $show = true; }
	$output .= '</ul><p>&nbsp;</p>';
	if(	$show ) echo $output;
}

function pack_facilities(){
	global $post;
	$show = false;

	$output = '<ul id="headline"><li><span class="button_left">Facilities</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
	$output .= '<ul class="bullet_list">';
	if( !empty( $post->building_type ) )  { $output .= '<li><span class="bull tri">Building Type: '.$post->building_type.'</span></li>'; $show = true; }
	if( !empty( $post->building_owndership ) && $post->building_owndership=='Building Owned' )  { $output .= '<li><span class="bull tri">Property: Owned</span></li>' ; $show = true; }
	if( !empty( $post->building_owndership ) && $post->building_owndership=='Building Rented' )  { $output .= '<li><span class="bull tri">Property: Rented</span></li>' ; $show = true; }
	if( !empty( $post->number_of_days_open_per_week ) )  { $output .= '<li><span class="bull tri">Opened: '.$post->number_of_days_open_per_week.' days</span></li>' ; $show = true; }
	
	
	if( $post->kennels=='Yes' || $post->stables=='Yes' )  { 
		$first = false;
		$last = false;
		$output .= '<li><span class="bull tri">Facilities include : '; 
			if( $post->kennels=='Yes' )  { if($first) {$output .= ', ';} $output .= ' Kennels';if(!$first) {$first=true;}  }
			if( $post->stables=='Yes' )  { if($first) {$output .= ', ';} $output .= ' Stables';if(!$first) {$first=true;}  }
		$output .= '</li>' ; $show = true; 
	}
	if( !empty( $post->number_of_branch_clinics ) )  { $output .= '<li><span class="bull tri">Branch Clinics: '.$post->number_of_branch_clinics.'</span></li>'; $show = true; }
	if( !empty( $post->off_street_parking ) && $post->off_street_parking=="Yes" )  { $output .= '<li><span class="bull tri">Number of Carparks: '.$post->no_of_off_street_cars.'</span></li>' ; $show = true; }
	if( !empty( $post->number_of_computer_terminals ) )  { $output .= '<li><span class="bull tri">Number of Computers: '.$post->number_of_computer_terminals.'</span></li>' ; $show = true; }
	if( !empty( $post->computer_software ) && $post->computer_software=='Other' ) { $output .= '<li><span class="bull tri">Software: '.$post->other_softwares.'</span></li>' ; $show = true; }
	if( !empty( $post->computer_software ) && $post->computer_software!='Other' ) { $output .= '<li><span class="bull tri">Software: '.$post->computer_software.'</span></li>' ; $show = true; }
	$output .= '</ul><p>&nbsp;</p>';
	if(	$show ) echo $output;
}

function pack_staff(){
	global $post;
	$show = false;

	$output = '<ul id="headline"><li><span class="button_left">Staff</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
	$output .= '<ul class="bullet_list">';
	if( !empty( $post->number_of_fulltime_vet_equivalents_40_hrs ) )  { $output .= '<li><span class="bull tri">Number of Full-time Vet: '.$post->number_of_fulltime_vet_equivalents_40_hrs.'</span></li>' ; $show = true; }
	if( !empty( $post->number_of_fulltime_nurse_equivalents_38_hrs_ ) )  { $output .= '<li><span class="bull tri">Number of Full-time Nurse: '.$post->number_of_fulltime_nurse_equivalents_38_hrs_.'</span></li>' ; $show = true; }
	if( !empty( $post->practice_manager ) )  { $output .= '<li><span class="bull tri">Practice Manager: '. $post->practice_manager.'</span></li>'; $show = true; }
	$output .= '</ul><p>&nbsp;</p>';
	if(	$show ) echo $output;
}

function package_2( $post=NULL ){
	if( !is_array($post) ){
		global $post;
	} else {
		$post = arrayToObject($post);
	}
	?>
                   <table id="listing" border="0" width="100%">
                    <tr><td rowspan="4" valign="top">
					
                     <?php featured_image();?>
                    <p class="txt_clickimage"><em>CLICK IMAGE FOR LARGER VIEW [+]</em></p>
                    </td>
                    <td colspan="2"><h1><?php echo $post->post_title;?></h1><hr/></td></tr>
                    <tr>
                    <td colspan="3" valign="top">
                    <h2>Overview</h2>
                    <?php echo $post->post_short_content;?>
                    </td>
                    </tr>
                    <tr><td colspan="2"><hr /></td></tr>
                    <tr><td>
                    <p></p>
                    <p><em>Business Name:</em> <?php echo ucfirst( $post->practice_name);?></p>
   					<p><em>Address:</em>  <?php echo $post->business_address;?>, <?php echo $post->suburb;?>, <?php echo $post->post_code;?> <?php echo $post->practice_state;?> </p>
                <?php if( $post->property_is_for=='For Lease' || $post->property_is_for=='For Sale/Lease' ){ ?>
                <h2>Leasing Price:</h2>
                <p>Commercial Property Lease (<?php echo $post->lease_details;?>)</p>
                <?php } else {?>
                <h2>Asking Price:<?php echo ( $post->show_asking_price=='Yes' )? make_askingprice( $post->property_value ) :'POA';?></h2>
                <?php } ?>
                    </td>
                    <td><h3>Contact</h3>
                    <p>Email: <script language=javascript>
                      <!--
                      var contact = "CLICK TO EMAIL";
                      var email<?php echo $post->ID; ?> = "<?php get_further_info( 'email', $post, 'object' )?>";
                      var emailSubject<?php echo $post->ID; ?> = "<?php echo $post->post_title; ?>";
                      document.write('<a href="#contact_popup" id="cpopup_<?php echo $post->ID; ?>" class="fancybox-contact">' + contact + '</a>')
						jQuery(document).ready(function($) {
								jQuery('#cpopup_'+<?php echo $post->ID; ?>).click(function() { //start function when Random button is clicked
									$("#cform_msg").html(''); 
								  document.getElementById('myemail').value = email<?php echo $post->ID; ?>;
								  document.getElementById('mysubject').value = emailSubject<?php echo $post->ID; ?>;
								  document.getElementById('property_id').value = <?php echo $post->ID; ?>;
								  document.getElementById('mysubject_display').innerHTML = emailSubject<?php echo $post->ID; ?>;
							});
						});
                      //-->
                    </script></p>
                    
                    </td>
                    </tr>
                    
                    </table>
    <?php
}

function package_2_overview( $post ){
	$option = array( 'ID' => $post['ID'], 'property_type' => $post['property_type'], 'practice_state' => $post['practice_state'] );
	?> 
				<ul id="headline"><li><span class="button_left"><?php valuvet_property_state_full( $post['practice_state'] )?> - <?php valuvet_get_property_ID( $option  );?></span> <span class="button_right"><span class="post_date"><?php add_flag_items_to_property_title_header( $post['ID'] )?>Posted: <?php echo strtoupper( date("d M Y", strtotime($post['post_date'])) )?> | Updated: <?php echo strtoupper( date("d M Y", strtotime($post['post_modified'])) )?></span></span></li></ul>
                
<table id="listing" border="0" width="100%">
                    <tr><td rowspan="4" valign="top">
					
                     <?php 
					 	featured_overview_images( $post['featured_image_url'], $post['images'], 'medium', $post['featured_image_title']);
					?>
                        
                    <p class="txt_clickimage"><em>CLICK IMAGE FOR LARGER VIEW [+]</em></p>
                    </td>
                    <td colspan="2"><h1><?php echo $post['post_title'];?></h1><hr/></td></tr>
                    <tr>
                    <td colspan="3" valign="top">
                    <h2>Overview</h2>
                    <?php echo $post['post_short_content'];?>
                    </td>
                    </tr>
                    <tr><td colspan="2"><hr /></td></tr>
                    <tr><td>
<p></p>
<p><em>Business Name:</em> <?php echo ucfirst( $post['practice_name']);?></p>
<p><em>Address:</em>  <?php echo $post['business_address'];?>, <?php echo $post['suburb'];?>, <?php echo $post['post_code'];?> <?php echo $post['practice_state'];?></p>
<p><a class="fancybox-iframe" href="?gmap=<?php echo google_map_address($post);?>&property=<?=$post['ID']?>">Map Link</a></p>
                
                
                <?php if( $post['property_is_for']=='For Lease' || $post['property_is_for']=='For Sale/Lease' ){ ?>
                <h2>Leasing Price:</h2>
                <p>Commercial Property Lease (<?php echo $post['lease_details'];?>)</p>
                <?php } else {?>
                <h2>Asking Price: <?php echo ( $post['show_asking_price']=='Yes' )? make_askingprice( $post['property_value'] ):'POA';?></h2>
                <?php } ?>
                    </td>
                    <td><h3>Contact</h3>
                    <p>Email: <script language=javascript>
                      <!--
                      var contact = "CLICK TO EMAIL";
                      var email<?php echo $post['ID']; ?> = "<?php get_further_info( 'email', $post )?>";
                      var emailSubject<?php echo $post['ID']; ?> = "<?php echo $post['post_title']; ?>";
                      document.write('<a href="#contact_popup" id="cpopup_<?php echo $post['ID']; ?>" class="fancybox-contact">' + contact + '</a>')
						jQuery(document).ready(function($) {
								jQuery('#cpopup_'+<?php echo $post['ID']; ?>).click(function() { //start function when Random button is clicked
									$("#cform_msg").html(''); 
								  document.getElementById('myemail').value = email<?php echo $post['ID']; ?>;
								  document.getElementById('mysubject').value = emailSubject<?php echo $post['ID']; ?>;
								  document.getElementById('property_id').value = <?php echo $post['ID']; ?>;
								  document.getElementById('mysubject_display').innerHTML = emailSubject<?php echo $post['ID']; ?>;
							});
						});
                      //-->
                    </script></p>
                    
                    </td>
                    </tr>
                    
                    </table>
    <?php
}

function package_3( $post=NULL ){
		global $post,$wp_properties;
		listing_views( $post->ID );
	?>
                <table id="listing" border="0" width="100%" class="post-<?php the_ID(); ?>">
                <tr>
                <td colspan="2"><h1><?php echo $post->post_title;?></h1>
                <hr/></td>
                </tr>
                <tr>
                <td colspan="1">
                <p></p>
                <p><em>Business name:</em>  <?php echo ucfirst( $post->practice_name );?></p>
				<p><em>Address:</em>  <?php echo map_address($post);?></p>
                <p><em>Asking price :  <?php echo ( $post->show_asking_price=='Yes' )? make_askingprice( $post->property_value ) :'POA';?> </em></p>
				<p><a class="fancybox-iframe" href="?gmap=<?php echo google_map_address($post);?>&property=<?=$post->ID?>">Map Link</a></p>
                <?php if( $post->property_is_for=='For Lease' || $post->property_is_for=='For Sale/Lease' ){ ?>
                <h2>Leasing Price:</h2>
                <p>Commercial Property Lease (Negotiable)</p>
                <?php } ?>
                </td>
                <td>
                <h3>For further information please contact</h3>
				<p><?php get_further_info( 'title_name', $post, 'object' );?><br /><?php get_further_info('phone', $post, 'object');?></p>
                    <p>Email: <script language=javascript>
                      <!--
                      var contact = "CLICK TO EMAIL";
                      var email<?php echo $post->ID; ?> = "<?php get_further_info( 'email', $post, 'object' )?>";
                      var emailSubject<?php echo $post->ID; ?> = "<?php echo $post->post_title; ?>";
                      document.write('<a href="#contact_popup" id="cpopup_<?php echo $post->ID; ?>" class="fancybox-contact">' + contact + '</a>')
						jQuery(document).ready(function($) {
								jQuery('#cpopup_'+<?php echo $post->ID; ?>).click(function() { //start function when Random button is clicked
									$("#cform_msg").html(''); 
								  document.getElementById('myemail').value = email<?php echo $post->ID; ?>;
								  document.getElementById('mysubject').value = emailSubject<?php echo $post->ID; ?>;
								  document.getElementById('property_id').value = <?php echo $post->ID; ?>;
									document.getElementById('mysubject_display').innerHTML = emailSubject<?php echo $post->ID; ?>;
							});
						});
                      //-->
                    </script></p>
                </td>
                </tr>
                <tr>
                <td colspan="1" class="property_desc" width="70%" valign="top">
                <?php featured_overview_images( $post->featured_image_url, $post->gallery, 'large' , $post->featured_image_title);?>
                <p>&nbsp;</p>
               <ul id="headline"><li><span class="button_left">Description</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>
               <?php if( !empty($post->the_business) ) { ?>
                <p><em>The Business:</em><br/>
				<p><?php echo $post->the_business;?></p>
                <?php } ?>         
               <?php if( !empty($post->the_opportunity) ) { ?>
                <p><em>The Opportunity:</em><br/>
				<p><?php echo $post->the_opportunity;?></p>
                <?php } ?>
               <?php if( !empty($post->the_location) ) { ?>
                <p><em>The Town:</em><br/>
				<p><?php echo $post->the_location;?></p>
                <?php } ?>
                </td>
                <td  valign="top">
                <ul id="headline"><li><span class="button_left">Overview</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>
                
                <p>
                <?php echo $post->post_short_content;?>
                <?php overview_extras( $post );?>
                
				<?php pack_facilities();?>
                <?php pack_staff();?>
				<?php type_of_practice( $post );?>
				<?php professional_services( $post );?>
                <?php ancillary_services( $post )?>
                
                </p>
                </td>
                </tr>
                <tr>
                <td colspan="2">
                <hr/>
                <p class="txt_clickimage"><em>CLICK IMAGE FOR LARGER VIEW [+]</em></p>
                <br/>
                <br/>
                <?php property_image_gallery( $post->gallery, array( 'size' => 'gallery-thumb-image', 'skipfirst' => true, 'skiphelp' => false ) );?>
                </td>
                </tr>
                <tr>
                <td colspan="2">&nbsp;
               
                </td>
                </tr>
                </table>
      <?php
}

function package_3_overview( $post ){
	set_cordinates( $post );
	$option = array( 'ID' => $post['ID'], 'property_type' => $post['property_type'], 'practice_state' => $post['practice_state'] );
	?>
<ul id="headline"><li><span class="button_left"><?php valuvet_property_state_full( $post['practice_state'] )?> - <?php valuvet_get_property_ID( $option  );?></span> <span class="button_right"><span class="post_date"><?php add_flag_items_to_property_title_header( $post['ID'] )?>Posted: <?php echo strtoupper( date("d M Y", strtotime($post['post_date'])) )?> | Updated: <?php echo strtoupper( date("d M Y", strtotime($post['post_modified'])) )?></span></span></li></ul>

<table id="listing" border="0" width="100%">
<tr><td rowspan="4" style="width: 250px;">
	<?php featured_overview_images( $post['featured_image_url'], $post['images'], 'medium', $post['featured_image_title']);?>
    <p class="txt_clickimage"><em>CLICK IMAGE FOR LARGER VIEW [+]</em></p>
</td>
<td colspan="2"><h1><?php echo $post['post_title'];?></h1><hr/></td></tr>
<tr><td colspan="1">
<h2>Overview</h2>
               <?php echo $post['post_short_content'];?>
</td>
<td width="250px">
<p>

<ul id="headline_black"><li style="width:160px;"><span class="button_left"><span class="button_right">&nbsp;&nbsp;&nbsp;<a href="<?php echo $post["permalink"] ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><span style="color:#FFF">More Info . .</span></a></span></span></li></ul></p>

</td></tr>
<tr><td colspan="2"><hr /></td></tr>
<tr><td>
<p></p>
<p><em>Business Name:</em> <?php echo ucfirst( $post['practice_name'] );?></p>
<p><em>Address:</em>  <?php echo $post['business_address'];?>, <?php echo $post['suburb'];?>, <?php echo $post['post_code'];?> <?php echo $post['practice_state'];?> </p>
<p><a class="fancybox-iframe" href="?gmap=<?php echo google_map_address($post);?>&property=<?=$post['ID']?>">Map Link</a></p>

                <?php if( $post['property_is_for']=='For Lease' || $post['property_is_for']=='For Sale/Lease' ){ ?>
                <h2>Leasing Price:</h2>
                <p>Commercial Property Lease (<?php echo $post['lease_details'];?>)</p>
                <?php } else {?>
                <h2>Asking Price : <?php echo ( $post['show_asking_price']=='Yes' )? make_askingprice( $post['property_value'] ):'POA';?></h2>
                <?php } ?>
</td>
<td>
<h3>For further information please contact</h3>
<p><?php get_further_info( 'title_name', $post );?><br /><?php get_further_info('phone', $post);?></p>
                    <p>Email: <script language=javascript>
                      <!--
                      var contact = "CLICK TO EMAIL"; 
                      var email<?php echo $post['ID']; ?> = "<?php get_further_info( 'email', $post )?>";
                      var emailSubject<?php echo $post['ID']; ?> = "<?php echo $post['post_title']; ?>";
                      document.write('<a href="#contact_popup" id="cpopup_<?php echo $post['ID']; ?>" class="fancybox-contact">' + contact + '</a>')
						jQuery(document).ready(function($) {
								jQuery('#cpopup_'+<?php echo $post['ID']; ?>).click(function() { //start function when Random button is clicked
									$("#cform_msg").html(''); 
								  document.getElementById('myemail').value = email<?php echo $post['ID']; ?>;
								  document.getElementById('mysubject').value = emailSubject<?php echo $post['ID']; ?>;
								  document.getElementById('property_id').value = <?php echo $post['ID']; ?>;
								  document.getElementById('mysubject_display').innerHTML = emailSubject<?php echo $post['ID'];?>;
							});
						});
                      //-->
                    </script></p>
</td>
</tr>
</table>
      <?php
}

function package_select($echo=true){
	global $post;
	
	if( $post->property_type=='package_3' ){
		package_3();
	} elseif( $post->property_type=='package_2' ){
		package_2();
	} else {
		package_1();
	}
}


function send_upgrade_notification( $postid ){
	global $notify_data;
	$post = get_post( $postid );
	$property = get_property( $post->ID );
	
	$author_email = get_the_author_meta( 'user_email' , $post->post_author);
	$first_name = get_the_author_meta( 'first_name' , $post->post_author);
	$last_name = get_the_author_meta( 'last_name' , $post->post_author);
	$myurl = site_url();
	$uppayment = get_post_meta($post->ID, 'upgrade_payment', true);
	$upgrade_package_from = get_post_meta($post->ID, 'upgrade_package_from', true);
	
	
	$pendinghash = get_post_custom_values('wpp_feps_pending_hash',$post->ID);
	$permlink = $myurl . '/?page_id='.$post->ID.'&wpp_front_end_action=wpp_view_pending&pending_hash='.$pendinghash[0];
	$renewdate = get_property_renew_date( $post->post_date );
	
	$note_data = array(
						 
						 '{AUTHOR_EMAIL}' => $author_email,
						 '{AUTHOR_FIRST_NAME}' => $first_name,
						 '{AUTHOR_LAST_NAME}' => $last_name,
						 '{POST_ID}' => $post->ID,
						 '{POST_LINK}' => $permlink,
						 '{RENEW_DATE}' => $renewdate,
						 '{UPGRADE_FROM}' => ucfirst( str_replace("_", " ", $upgrade_package_from ) ),
						 '{UPGRADE_TO}' => ( isset($_REQUEST['wpp_pkgupgrade']) )?ucfirst( str_replace("_", " ", $_REQUEST['wpp_pkgupgrade'] ) ):ucfirst( str_replace("_", " ", $property['property_type'] ) ),
						 '{AUTHOR_PROPERTY_TITLE}' => $post->post_title
						 );
	$data = get_valuvet_notify_email_template( 'notify_package_upgrade_for_customer', $note_data );
	$header =  "From: ".$notify_data['{BLOG_INFO}']."<".$notify_data['{ADMIN_EMAIL}'].">\n"; // header for php mail only
	wp_mail($author_email, sprintf(__('%s '.$data['subject'] ), $notify_data['{BLOG_INFO}'] ), $data['message'], $header);
/*	
	$data = get_valuvet_notify_email_template( 'notify_package_upgrade_for_admin', $notify_data );
	$header =  "From: $bloginfo <$admin_email>\n"; 
	wp_mail($author_email, sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header);*/
}


function change_property_package_form(){
	global $post;
   	global $current_user;
	$property_package_change_explain = get_option('property_package_change_explain' );
	?>
    <script>
    function show_alert(){
		return confirm('This operation may delete some of your data. Are you sure you need to do this.');
	}
    </script>
    <form action="<?php echo get_option('property_package_change_url' );?>&package=<?=$post->ID?>" method="post" onsubmit="return show_alert();">
<div class="paypal_container">
   

    <center>    
    <table style="">
			 <tr>
				<td class="field">Current Property Package:</td>
				<td>
					<?php
                    if( $post->property_type=='package_1' ) echo 'Package 1 - $'. set_money_format( get_option('package_1', '165.00') );
                    if( $post->property_type=='package_2' ) echo 'Package 2 - $'. set_money_format( get_option('package_2', '330.00') );
                    if( $post->property_type=='package_3' ) echo 'Package 3 - $'. set_money_format( get_option('package_3', '550.00') );
                    ?>
                </td>
			</tr>
			 <tr>
				<td class="field">Change Package To:</td>
				<td>
    <select name="wpp_newpackage" id="pkg_id" >
		<?php
		if( $post->property_type!='package_1' ) echo '<option value="package_1">Package 1 - $'. set_money_format( get_option('package_1', '165.00') ).'</option>';
		if( $post->property_type!='package_2' ) echo '<option value="package_2">Package 2 - $'. set_money_format( get_option('package_2', '330.00') ).'</option>';
		if( $post->property_type!='package_3' ) echo '<option value="package_3">Package 3 - $'. set_money_format( get_option('package_3', '550.00') ).'</option>';
		?>
    </select>
                </td>
			</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Change Package" /></td>
	</tr> 
    </table>
    <?php
    if( !empty($property_package_change_explain) ) echo '<a href="'.$property_package_change_explain.'" target="_blank">Changing Packages</a>';
	?>
    </center>
    </div>
    </form>
    <?php
}


function remove_images_onpackage_change( $newpackage ){
	global $post;
	if( isset( $post->gallery ) && isset($_REQUEST['wpp_newpackage']) ){
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		foreach( $post->gallery as $gallery ){
			if( $_REQUEST['wpp_newpackage']=='package_2' ){
				if( $gallery['attachment_id']!=$post_thumbnail_id ) wp_delete_attachment( $gallery['attachment_id'] );
			} elseif( $_REQUEST['wpp_newpackage']=='package_1' ){
				wp_delete_attachment( $gallery['attachment_id'] );
			} 
		}
	}
}


function change_property_package(){
	global $post;
	global $current_user;
	
	
	if( isset($_REQUEST['package']) && isset( $current_user->ID ) ){
		$postid = (integer)$_REQUEST['package'];
		$post = get_post( $_REQUEST['package'] );
		$renewget_renewal_link = get_renewed_status_by_date( $post->post_date );
		if( $post->post_author==$current_user->ID && $renewget_renewal_link ){
			$property = get_property( $post->ID );
			$post = (object) array_merge((array) $post, (array) $property);
			
			if( isset($_REQUEST['wpp_newpackage']) ) {
				update_post_meta($post->ID, 'property_type', $_REQUEST['wpp_newpackage'] );
				remove_images_onpackage_change($_REQUEST['wpp_newpackage']);
			} else {
				change_property_package_form();
			}
			
			if( $property["property_type"]=='package_3' ){
				package_3();
			} elseif( $property["property_type"]=='package_2' ){
				package_2();
			} else {
				package_1();
			}
		}
	}
}
add_shortcode('change_property', 'change_property_package' );

function upgrade_property_paypal_form(){
	global $post, $permlink ;
	$uppayment = get_post_meta($post->ID, 'upgrade_payment', true);
	$upgrade_package_from = get_post_meta($post->ID, 'upgrade_package_from', true);
	?>
    	<form action="<?php echo $permlink;?>" method="POST">
      <?php wp_nonce_field('wppe_paypal_init'); ?>
    <input type="hidden" name="return_URL" value="<?php echo  $permlink;?>&op=return" />
    <input type="hidden" name="cancel_URL" value="<?php echo  $permlink;?>&op=cancel" />
    <input type="hidden" name="OPID" value="<?php echo $post->ID;?>" />
    <input type="hidden" name="OPTYPE" value="property" />
    <input type="hidden" name="makepayment" value="true" />
    <input type="hidden" name="makeupgrade" value="true" />
	<input type="hidden" name="paymentType" value='Order' >
	<input type="hidden" name="currencyCodeType" value='AUD' >
	<input type="hidden" name="L_DESC0" value="<?php echo $post->post_type;?> upgrading fee" >
    
	<input type="hidden" name="L_AMT0" size="5" maxlength="32" value="<?php echo set_money_format( $uppayment )?>"  />
	<input type="hidden" size="30" maxlength="32" name="L_NAME0" value="Property sale upgrading to <?php echo $post->property_type_label;?>" /> 
                        
    <div class="paypal_container">
   
    <?php
		if( isset($_SESSION['reshash']) ){
			echo 'Payment error. ';
			$resArray=$_SESSION['reshash']; 
			echo  $resArray['L_SHORTMESSAGE0'] ;
			unset($_SESSION['reshash']);
		}
		
		if( isset( $_SESSION['makeupgrade'] ) && $_SESSION['makeupgrade']==true ) { 
					delete_post_meta($post->ID, 'upgrade_package_from' );
					delete_post_meta($post->ID, 'upgrade_payment' );
					unset( $_SESSION['makeupgrade'] );
		
		}
		?>
    <center>    
    <table style="">
        <th>Shopping cart Products:</th>
			 <tr>
				<td class="field">Upgrading Package to:</td>
				<td><?php echo ucfirst( str_replace("_", " ", $post->property_type) );?> From <?= ucfirst( str_replace("_", " ", $upgrade_package_from))?></td>
			</tr>
            <tr>
				<td>Upgrading Price</td>
			 	<td style="text-align:right;" class="dollar_sign"><input type="hidden" size="3" maxlength="32" name="L_QTY0" value="1" /><?php echo set_money_format( $uppayment );?></td>
			</tr>


	<tr>
		<td></td>
		<td><input type="image" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" /></td>

	</tr>
    </table>
    </center>
    </div>
    </form>
    <?php
}


function upgrade_property_package_form(){
	global $post, $permlink ;
   	global $current_user;
	$currentpackage_value = set_money_format( get_option( $post->property_type ) );
	?>
    <form action="<?php echo $permlink;?>" method="post" onsubmit="return check_upgrade();">
    <?php wp_nonce_field('wppe_upgrade_package'); ?>
<div class="paypal_container">
    <center>    
    <table style="">
			 <tr>
				<td class="field">Current Property Package:</td>
				<td>
					<?php
                    if( $post->property_type=='package_1' ) echo 'Package 1 - $'. set_money_format( get_option('package_1', '165.00') );
                    if( $post->property_type=='package_2' ) echo 'Package 2 - $'. set_money_format( get_option('package_2', '330.00') );
                    if( $post->property_type=='package_3' ) echo 'Package 3 - $'. set_money_format( get_option('package_3', '550.00') );
                    ?>
                </td>
			</tr>
			 <tr>
				<td class="field">Change Package To:</td>
				<td>
    <select name="wpp_pkgupgrade" id="pkg_id" >
    <option value="">Please select</option>
		<?php
                    if( $post->property_type=='package_1' ){
						echo '<option value="package_2">Package 2 - $'. set_money_format( get_option('package_2', '330.00') ).'</option>';
						echo '<option value="package_3">Package 3 - $'. set_money_format( get_option('package_3', '550.00') ).'</option>';
					}
                    if( $post->property_type=='package_2' ) {
						echo '<option value="package_3">Package 3 - $'. set_money_format( get_option('package_3', '550.00') ).'</option>';
					}
                    ?>
    </select>
                </td>
			</tr>
			<tr style="display:none;" id="show_dueamount">
				<td class="field">Payment</td>
				<td>
					<div id="ex_payment" class="dollar_sign"></div>
                </td>
			</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Upgrade Package" /></td>
	</tr> 
    </table>
  <script type="text/javascript">
		function check_upgrade(){
			if( jQuery("#pkg_id").val()=="" ){
				alert('Please select new package.');
				return false;
			} else {
				return confirm('Your listing will be marked as pending until our administrator approves it.');
			}
		}
		
    jQuery(document).ready(function() {
	
		jQuery('#pkg_id').change(function() {
			var pkgvalue = '';
			var current_pkg_value = <?=$currentpackage_value?>;
			if( jQuery('#pkg_id').val()=='package_2' ){
				jQuery("#show_dueamount").show();
				pkgvalue = <?php echo set_money_format( get_option('package_2', '330.00') ) ?> - current_pkg_value;
			} else if(jQuery('#pkg_id').val()=='package_3' ){
				pkgvalue = <?php echo set_money_format( get_option('package_3', '550.00') ) ?> - current_pkg_value;
				jQuery("#show_dueamount").show();
			} else {
				jQuery("#show_dueamount").hide();
			}
			jQuery("#ex_payment").html( pkgvalue.toFixed(2) );
		});	
	

	});
    </script>
    <?php
    if( !empty($property_package_change_explain) ) echo '<a href="'.$property_package_change_explain.'" target="_blank">Changing Packages</a>';
	?>
    </center>
    </div>
    </form>
    <?php
}

function upgrade_package_init(){
	
	if( isset($_REQUEST['wpp_pkgupgrade']) && !empty($_REQUEST['wpp_pkgupgrade']) && isset($_REQUEST['package']) && !empty($_REQUEST['package']) ) {
		if( check_admin_referer('wppe_upgrade_package') ){
			$post = get_post( $_REQUEST['package'] );
			$property = get_property( $post->ID );
			$post = (object) array_merge((array) $post, (array) $property);
			$my_post = array();
			$my_post['ID'] = $post->ID;
			$my_post['post_status'] = 'pending';
			wp_update_post( $my_post );
			$addtodo = array(
				'todo_title'       => 'Propert package upgrade for : ' . $post->ID,
				'todo_propertyid'  => $post->ID	);
			global $todo_class;
			$todo_class->insert_todo_item($addtodo);
			$currentpackage_value = set_money_format( get_option( $property["property_type"] ) );
			$newpackage_value = set_money_format( get_option( $_REQUEST['wpp_pkgupgrade'] ) );
			$upgrade_cost = $newpackage_value - $currentpackage_value;
			
			update_post_meta($post->ID, 'upgrade_package_from', $property["property_type"] );
			update_post_meta($post->ID, 'property_type', $_REQUEST['wpp_pkgupgrade'] );
			update_post_meta($post->ID, 'upgrade_payment', $upgrade_cost );
			update_post_meta($post->ID, 'payment_status', 'Not paid' );

			$post = get_post( $_REQUEST['package'] );
			$property = get_property( $post->ID );
			$post = (object) array_merge((array) $post, (array) $property);
			$permlink = get_option('property_package_upgrade_url' ) .'&package='. (int)$_REQUEST['package'];
			send_upgrade_notification($post->ID);
			wp_redirect( $permlink );
			die();
		}
	}
}
add_action('wppe_init_action', 'upgrade_package_init');

function upgrade_property_package_sc(){
	global $post, $permlink ;
   	global $current_user, $todo_class;

	$permlink = get_option('property_package_upgrade_url' ) .'&package='. (int)$_REQUEST['package'];
	if( isset($_REQUEST['package']) && isset( $current_user->ID ) ){
			$postid = (integer)$_REQUEST['package'];
			$post = get_post( $_REQUEST['package'] );
			$renewget_renewal_link = get_renewed_status_by_date( $post->post_date );
			if( $post->post_author==$current_user->ID  ){
				$property = get_property( $post->ID );
				$post = (object) array_merge((array) $post, (array) $property);
				if( $property["property_type"]=='package_1' ){
					delete_post_meta($post->ID, 'upgrade_package_from' );
					delete_post_meta($post->ID, 'upgrade_payment' );
				}
				unset($property, $post );
				$post = get_post( $_REQUEST['package'] );
				$property = get_property( $post->ID );
				$post = (object) array_merge((array) $post, (array) $property);
				
				$uppayment = get_post_meta($post->ID, 'upgrade_payment', true);
				if( $uppayment>0 ){
					upgrade_property_paypal_form();
				} else {
					upgrade_property_package_form();
				}
				

				if( $property["property_type"]=='package_3' ){
					package_3();
				} elseif( $property["property_type"]=='package_2' ){
					package_2();
				} else {
					package_1();
				}
		}
	}
	
	
	if( isset( $_SESSION['makeupgrade'] ) && $_SESSION['makeupgrade']==true && isset( $_GET['makeupgrade'] ) ) {
			delete_post_meta($post->ID, 'upgrade_package_from' );
			delete_post_meta($post->ID, 'upgrade_payment' );
	}
}
add_shortcode('upgrade_property_package', 'upgrade_property_package_sc' );