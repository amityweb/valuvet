<?php
class eqfs_frontend{
	function eqfs_frontend(){
	    add_action("eqfs_account_created", array('eqfs_frontend', 'account_created'), 10);
		
		eqfs_frontend::process_eqfs_form();
	}


	function fend_eqfs_form(){
		global $current_user, $args, $eqfs_message;
		
		do_action( 'eqfs_form_top' );
		if( !empty( $current_user ) ){
			$phonenumber = get_user_meta( $current_user->ID, 'contact_number', true); 
		}
		?>
        <?php if( !empty($eqfs_message['message']) ){?>
        <div id="show_message"><?php echo $eqfs_message['message'];?></div>
        <?php } ?>
	<form action="" method="post" enctype="multipart/form-data" id="container_form" class="eqfs_form_class wpp_feps_form">
		<?php wp_nonce_field('eqfs_form_submit'); ?>
        <input type="hidden" name="eqfs_action" value="eqfs_submit" />
		<div id="step_0">
                  <table cellpadding="0" cellspacing="2" width="100%">
                  <tr>
                    <td width="48%" class="alignmiddle">How did you hear about Vet's Practice Market Place</td>
                    <td width="52%" class="alignmiddle">
                            <select name="eqfs_fp_field_data[hear_from]" id="hear_from" class="step0p" style="width: 250px;">
                                <option value="">Please select an option</option>
                                <option value="Newsletter">ValuVet Newsletter</option>
                                <option value="Conference">Conference</option>
                                <option value="Referral by Colleague">Referral by Colleague</option>
                                <option value="Referred by a Purchaser">Referred by a Purchaser</option>
                                <option value="Valuvet Consultant">ValuVet Consultant</option>
                                <option value="Internet Search Engine">Internet Search Engine</option>
                                <option value="Advertisement">Magazine Advertisement</option>
                                <option value="Direct mail received">Direct Mail Received</option>
                                <option value="Other">Other</option>
                            </select>
                    </td>
                  </tr>
                  <tr id="ad_hereabout_other_tr" style="display:none;">
                    <td width="48%" class="alignmiddle"><label id="otherhear_text"> <span>Other</span></label></td>
                    <td width="52%" class="alignmiddle"><input type="text" id="ad_hearabout_other" name="eqfs_fp_field_data[here_about_other]" size="24" >
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="alignmiddle">Equipment sales Package</td>
                    <td class="alignmiddle">
                            <select name="eqfs_fp_data[equipment_type]" id="pkg_id" class="step0p">
                                      <option value="package_1">Package 1 - $<?php echo set_money_format( get_option('eqs_package_1', '19.95') );?>, <?php echo  get_option('eqs_package_1_months', '1');?> Months</option>
                                      <option value="package_2">Package 2 - $<?php echo set_money_format( get_option('eqs_package_2', '49.95') );?>, <?php echo  get_option('eqs_package_2_months', '3');?> Months</option>
                                      <option value="package_3">Package 3 - $<?php echo set_money_format( get_option('eqs_package_3', '69.95') );?>, <?php echo  get_option('eqs_package_3_months', '6');?> Months</option>
                            </select>
                            <input type="hidden" name="noofimages" id="get_noof_images" value="1" />
                            <div class="clear"></div>
                            <div style="display:block; float:left;">Prices include GST</div>
                    </td>
                  </tr>
                  </table>
                <input class="nextbtn" type="button" name="submit_0" id="submit_0" value="" style="float: right;" />

            </div>
            
		<div id="step_1" style="display:none;">
            	<h2>Your Contact Details</h2>
                <table cellpadding="0" border="0" cellspacing="2" width="100%">
                  <tr>
                    <td width="48%" class="alignmiddle">Title</td>
                    <td width="52%" class="alignmiddle">
                                        	<select name="eqfs_fp_field_data[user_title]" class="step1p" id="user_title">
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
                    <td width="52%" class="alignmiddle"><input class="step1p" type="text" name="eqfs_fp_data[first_name]" id="ad_firstname" value="<?php echo $current_user->first_name?>" ></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Surname<b>*</b></td>
                      <td class="alignmiddle"><input class="step1p" type="text" name="eqfs_fp_data[surname]" id="ad_surname" value="<?php echo $current_user->last_name?>" ></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Email<b>*</b></td>
                      <td class="alignmiddle"><input class="step1p" type="text" name="eqfs_fp_data[user_email]" id="ad_email"  value="<?php echo $current_user->user_email?>">
                      <div id="user_availability"></div>
                      </td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Contact Number<b>*</b><br /><span class="small_text">Area Code Phone Number OR<br />Mobile Number ( 10 digits no spaces)</span></td>
                      <td class="alignmiddle"><input class="step1p" type="text" name="eqfs_fp_data[contact_number]" id="ad_contactnumber" style="width:140px;" value="<?php echo str_replace(" ","", $phonenumber);?>"></td>

                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
                <input class="backbtn" type="button" name="step0" id="step0" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_1" id="submit_1" value="" style="float: right;" />
            </div>
            
<div id="step_2" style="display:none;">      
            	<h2>Equipment Location</h2>
                <table cellpadding="0" cellspacing="2" width="100%">
                  <tr>
                      <td class="alignmiddle">Business Address<b>*</b></td>
                      <td class="alignmiddle"><input type="text" name="eqfs_fp_field_data[business_address]" id="business_address" style="width:80%;" maxlength="60" class="step2p">
                      </td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Suburb<b>*</b></td>
                      <td class="alignmiddle"><input type="text" name="eqfs_fp_field_data[suburb]" id="suburb" maxlength="50" class="step2p">
                      </td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">Post Code<b>*</b></td>
                      <td class="alignmiddle"><input type="text" name="eqfs_fp_field_data[post_code]" id="post_code" style="width:80px;" maxlength="5" class="step2p">
                      </td>

                  </tr>
                  <tr>
                      <td class="alignmiddle">State<b>*</b></td>
                      <td class="alignmiddle">
                                        <select name="eqfs_fp_field_data[practice_state]" id="equipment_state" class="step2p">
                                            <option selected="" value="">Select --&gt;</option>
                                            <option>ACT</option>
                                            <option>NSW</option>
                                            <option>NT</option>
                                            <option>QLD</option>

                                            <option>SA</option>
                                            <option>TAS</option>
                                            <option>VIC</option>
                                            <option>WA</option>
                                         </select>
                      </td>
                  </tr>
                  <tr style="display: none;">
                      <td class="alignmiddle">Country<b>*</b></td>
                      <td class="alignmiddle"><input type="hidden" name="eqfs_fp_field_data[practice_country]" value="Australia" class="step2p" readonly="readonly"></td>
                  </tr>
                  </table>
                <input class="backbtn" type="button" name="step1" id="step1" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_2" id="submit_2" value="" style="float: right;" />
            </div>
            
            
<div id="step_3" style="display:none;">      
            	<h2>Equipment Details</h2>
                <table cellpadding="0" cellspacing="2" width="100%">
                  <tr>
                    <td width="48%" class="alignmiddle">Equipment Name<b>*</b></td>
                    <td width="52%" class="alignmiddle"><input type="text" name="eqfs_fp_data[post_title]" id="post_title" maxlength="80" class="step3p" ></td>
                  </tr>
                  <tr>
                    <td align="left" style="width:250px;" class="alignmiddle">Category</td>
                    <td align="left" class="alignmiddle">
     		<?php
		$terms = get_terms( 'equipment_category', 'orderby=count&hide_empty=0' );
		if($terms){
        ?>
                    	<select name="eqfs_fp_field_data[equipment_category]" id="equipment_category" class="step3p">
                            <option value="" selected>Select --></option>
							<?php
                                foreach ($terms as $term) {?>
                                    <option value="<?php echo $term->term_id;?>"><?php echo $term->name;?></option>
                            <?php }
                            ?>
                         </select>
                         <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" class="alignmiddle" style="width:250px;">Description</td>
                    <td align="left" class="alignmiddle"><textarea name="eqfs_fp_field_data[equipment_description]" id="equipment_description" class="step3p"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td width="48%" class="alignmiddle">Price of one Item<b>*</b> <br /></td>
                    <td width="52%" class="alignmiddle"><input type="text" name="eqfs_fp_field_data[equipment_price]" id="equipment_price" maxlength="10" size="12" class="step3p dollar_sign" value="0.00" onfocus="if(this.value=='0.00') this.value='';"></td>
                  </tr>
                  <tr>
                      <td class="alignmiddle">No of items<b>*</b></td>
                      <td class="alignmiddle"><input type="text" name="eqfs_fp_field_data[equipment_noof_items]" id="equipment_noof_items" maxlength="8" size="10" class="step3p">
                      </td>
                  </tr>
                  </table>
                <input class="backbtn" type="button" name="step2" id="step2" value="" style="float: left;" onclick="return false;" />
                <input class="nextbtn" type="button" name="submit_3" id="submit_3" value="" style="float: right;" />
            </div>
            
            
<div id="step_4" style="display:none;">      
            	<h2>Upload Image</h2>
                <table cellpadding="0" cellspacing="2" width="100%">
                  <tr>
                    <td width="48%" class="alignmiddle">Upload image<b>*</b></td>
                    <td width="52%" class="alignmiddle"><input type="file" name="equipment_file"  /></td>
                  </tr>
                  <tr>
                    <td width="48%" class="alignmiddle">Image description<b>*</b></td>
                    <td width="52%" class="alignmiddle"><input type="text" name="eqfs_fp_data[equ_image_description]" value="Image description goes here" size="45" maxlength="50" onfocus="if(this.value=='Image description goes here') this.value='';" /></td>
                  </tr>

                  </table>
                <input class="backbtn" type="button" name="step3" id="step3" value="" style="float: left;" onclick="return false;" />
				<input type="submit" tabindex="<?php echo $tabindex; ?>" class="wpp_feps_submit_form nextbtn" style="float: right;" value=""  />
            </div>
	</form>    
<script type="text/javascript">
    jQuery(document).ready(function() {
//CUSTOM JAVASCRIPTS START FROM HERE
<?php if( !isset($current_user->user_email) ){?>
    jQuery('#ad_email').blur(function(){
    var user_email = jQuery("#ad_email").val();
        jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", {
          action: "wpp_feps_user_lookup",
          user_email: user_email
        }, function(response) {
          if( response.user_exists == 'true') {
			  jQuery('#ad_email').removeClass('error').removeClass('valid');
              jQuery('#ad_email').addClass('error');
              jQuery('#ad_email').effect("shake", { times:3 }, 50);
              jQuery("#user_availability").html("<span class=\"error\"><?php _e('Email already registered. Please login.', 'wpp'); ?></span>");
          } else {
			  jQuery('#ad_email').removeClass('error').removeClass('valid');
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
								label: item.value,
								id: item.id,
								value: item.value
							}
						}));
					});
			},
			minLength: 2,
			select: function(event, ui) {
				jQuery("#suburb").val( ui.item.value );
				jQuery("#post_code").val( ui.item.id );
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
	
	function fend_eqfs_top_action(){
		include_once EQU_Path . 'templates/progressbar.php';
		add_action('wp_footer', array('eqfs_frontend', 'eqfs_js_script') );
	}
	
	function eqfs_js_script(){
    	wp_register_script( 'jquery-eqfs', plugins_url( 'js/jquery.eqfs.js' , dirname(__FILE__) ) );
	    wp_enqueue_script( 'jquery-eqfs' );
	}
	
	
	function process_eqfs_form(){
		global $eqfs_message;
		if('eqfs_submit' != $_REQUEST['eqfs_action']) {
		  return;
		}
		if( !check_admin_referer('eqfs_form_submit') ){	
		  return;
		}
		if( $result = eqfs_frontend::submit_eqfs_sale($_REQUEST['eqfs_fp_data']) ) {	
		  if(!empty($result['redirect_url'])) {
			//** After a property is submitted, redirect to front-end page */
			wp_redirect($result['redirect_url'].'&pending_hash='.$result['pending_hash'].'&eqfs_stat=eqfs_pending');
			die();
		  }
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

	  $bloginfo = get_bloginfo( 'name' );
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
       update_user_meta( $user_id, 'is_not_approved', 1 );

      //** Do not send notification if specifically disabled */
		$notify_data = array(
							   "{AUTHOR_EMAIL}" => $user_data['user_email'],
							   "{AUTHOR_FIRST_NAME}" => ( !empty($user_data['first_name']) ) ?$user_data['first_name']:$user_data['display_name'],
							   "{AUTHOR_LAST_NAME}" => $user_data['last_name'],
							   "{AUTHOR_USERNAME}" => $user_data['user_login'],
							   "{AUTHOR_PASSWORD}" => $new_user['user_pass']
							   );
		$data = get_valuvet_notify_email_template('eqfs_subscriber_account_created', $notify_data);
		$admin_email = get_bloginfo( 'admin_email' );
		$header =  "From: $bloginfo <$admin_email>\n"; // header for php mail only
        wp_mail( $user_data['user_email'], sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header );
		
		
		$data = get_valuvet_notify_email_template('eqfs_subscriber_account_created_admin', $notify_data);
		$admin_email = get_bloginfo( 'admin_email' );
		$header =  "From: $bloginfo <$admin_email>\n"; // header for php mail only
        wp_mail( $user_data['user_email'], sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header );
  }



	function submit_eqfs_sale( $data = false ){
		global $current_user, $args,$eqfs_message;
		 $form_data = array();
		 
		if(!$data) {
			return false;
		}

		if(is_user_logged_in()) {
			$r['credentials_verified'] = true;
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;
			
			if ( user_can( $user_id, 'publish_wpp_properties' ) ) {
			  $form_data['new_post_status'] = 'publish';
			} else {
			  $form_data['new_post_status'] = 'pending';
			}
		} 
		
		
		//** Verify user credentials if they are passed */
		if( !$r['credentials_verified'] && $data['user_email'] ) {
			$user_id = email_exists($data['user_email']);
			if( !$user_id ){
				$r['credentials_verified'] = false;
			} else {
				$eqfs_message['success'] = false;
				$eqfs_message['message'] = __('Your submission was not successful: Email already registered on our system. Please login', 'eqfs') ;
				return false;
			}
		}
		
		if( !$r['credentials_verified'] ) {
			//** We have a new user */
			$new_user['user_login'] = $data['user_email'];
			$new_user['role'] = get_option('eqfs_role' );
			$new_user['user_email'] = $data['user_email'];
			$new_user['first_name'] = $data['first_name'];
			$new_user['last_name'] = $data['surname'];
			$new_user['display_name'] = $data['first_name'];
			$new_user['user_pass'] = wp_generate_password();
			$user_id = wp_insert_user($new_user);
			
			if(is_wp_error($user_id)) {
			  $eqfs_message['success'] = false;
			  $eqfs_message['message'] = __('Your submission was not successful: ', 'eqfs') . $user_id->get_error_message();
			  return false;
			} else {
				$form_data['new_post_status'] = 'pending';
				update_usermeta( $user_id, 'contact_number', $data['contact_number'] );
			}
		}
		
		
		//** Setup essential post object information */
		$new_eqfs = array(
		  'post_content' => $data['equipment_description'],
		  'post_parent'  => 0,
		  // Prevent XSS. Wondered why WP did not do that inside of wp_insert_post();
		  'post_title'   => htmlspecialchars( strip_tags( $data['post_title'] ) ),
		  'post_author'  => $user_id,
		  'post_status'  => 'Pending',
		  'post_type'    => 'equipment_sale'
		);
	
		//** Commit basic equipment data to databse */
		$eqfs_id = wp_insert_post( $new_eqfs );
		//** Check for any issues inserting property */
		if(is_wp_error($eqfs_id)) {
			$eqfs_message['success'] = false;
			$eqfs_message['message'] = $eqfs_id->get_error_message();
			return false;
		}
		update_post_meta($eqfs_id, 'eqfs_pending_publish', true);
		//** Set property type */
		update_post_meta($eqfs_id, 'equipment_type', $data['equipment_type']);
		//** Set payment status */
		update_post_meta($eqfs_id, 'payment_status', 'Not paid' );
		
		
		foreach( $_REQUEST['eqfs_fp_field_data'] as $key => $value ){
			update_post_meta( $eqfs_id, $key ,  $value );
		}
		

		//** Set upload file */		
		if( isset($_FILES['equipment_file']['name']) ){
			 eqfs_frontend::process_eqfs_fileupload( $eqfs_id , $user_id, $data['equ_image_description'] );
		}
		
		$addtodo = array(
			'todo_title'	=> 'New equipment for sale submission',
			'todo_mode'		=> 'equipment',
			'todo_propertyid'  => $eqfs_id	);

		if( class_exists('todo_class') ) $todo_class = new todo_class();
		$todo_class->insert_todo_item($addtodo);
		
		//** Set pending hash */
		$return['pending_hash'] = md5($eqfs_id.$user_id);
		update_post_meta($eqfs_id, 'eqfs_pending_hash', $return['pending_hash']);
		
		// create new account
		if(!$r['credentials_verified']) {
			do_action( 'eqfs_account_created', array(
			  'user_id' => $user_id,
			  'new_user' => $new_user,
			  'form_data' => $form_data,
			  'equipment_id' => $eqfs_id
			));
		}
		delete_user_meta( $eqfs_id , 'is_not_approved' );
		
		$eqfs_message['success'] = false;
		$eqfs_message['message'] = __('Your equipment submited.', 'eqfs') ;
	
		return $return;
	}
	
	
	function process_eqfs_fileupload( $eqfs_id , $user_id, $image_description ){
		if( isset($_FILES['equipment_file']['name']) ){
			
			$oldfilename = $_FILES['equipment_file']['name'];
			$oldfile = $_FILES['equipment_file']['tmp_name'];
				if( !empty( $oldfilename ) ){
					$chfilename = preg_replace('/[^a-zA-Z0-9._\-]/', '', $oldfilename); 
					$uploads = wp_upload_dir();
					$original_filename = basename ($oldfilename);
					$newfilename = wp_unique_filename( $uploads['path'], $chfilename);
					$new_file = $uploads['path'] . "/$newfilename";
					$file_data = wp_check_filetype_and_ext($oldfile, $oldfilename);
					$overrides = array( 'test_form' => false);
	
	
					if( move_uploaded_file($_FILES['equipment_file']['tmp_name'], $new_file ) ){
						$attachment = array(
									  'post_parent' => $eqfs_id,
									  'post_author' => $user_id,
									  'post_mime_type' => $file_data['type'],
									  'guid' => $uploads['baseurl'] . _wp_relative_upload_path( $newfilename ),
									  'post_title' => trim( $image_description ),
									  'post_content' => '',
									);
						include_once  ABSPATH . 'wp-admin/includes/image.php';
						$attachment_id = wp_insert_attachment( $attachment, $new_file, $eqfs_id );
						wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $new_file));
						set_post_thumbnail( $eqfs_id, $attachment_id );
					}
				}
			}
	}
}

?>