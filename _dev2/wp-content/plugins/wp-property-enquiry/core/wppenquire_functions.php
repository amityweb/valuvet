<?php
	
	function add_flag_items_to_property_title_header( $propertyid ){?>
		<span class="bulk_enquiry" id="flag_<?php  echo $propertyid;?>" style="cursor:pointer; width:10px;">+ Add Enquiry</span> |
<?php	}

	function wpea_btton_enquiries(){?>
			<div id="enquiery_btn"><div id="openclose_02" class="acc_con" style="height: 205px; opacity: 1; display: none;">Form Will come Here</div>
			<div class="heading_buysell">
			<ul>
			<li><a href="#bulk_contact_popup" id="bulk_enquiery_alert"><span id="heading_03">Request a Practice Valuation</span></a></li>
			</ul>
			</div></div>
<?php	
	echo enquiry_button_output();
}


		function wppe_init_method() {
			// Hook onto print styles action for edit-pages page only
			add_action('admin_print_styles-edit.php','hide_quick_edit_css');
		}
		function hide_quick_edit_css() {
			?>
			<style type="text/css">
			span.inline {display:none!important}
			</style>
			<?php
		}


	function wppe_do_metabox(){
		global $pagenow;
		if( $pagenow == 'post.php' || $pagenow == 'post-new.php' ){
			remove_meta_box( 'submitdiv', 'property_enquiries', 'side' );
		}
	}
	
	
	function wppenquire_init(){
	global $pagenow,$wp_properties, $post;
		$wppenquire['labels'] = apply_filters('property_enquiries', array(
		  'name' => __('Property Enquiries', 'eqfs'),
		  'all_items' =>  __( 'All Enquiries', 'eqfs'),
		  'singular_name' => __('Enquiries', 'eqfs'),
		  'add_new' => __('Add Enquiries', 'eqfs'),
		  'add_new_item' => __('New Enquiry','eqfs'),
		  'edit_item' => __('Edit Enquiry','eqfs'),
		  'new_item' => __('New Enquiry','eqfs'),
		  'view_item' => __('View  Enquiry','eqfs'),
		  'search_items' => __('Search Enquiries','eqfs'),
		  'not_found' =>  __('No Enquiries found','eqfs'),
		  'not_found_in_trash' => __('No Enquiries found in Trash','eqfs'),
		  'parent_item_colon' => ''
		));
		
		$args = array(
		  'labels' => $wppenquire['labels'],
			'singular_label' => __('Enquiries'),
			'public' => true,
			'has_archive' => true,
			'show_ui' => true,
			'hierarchical' => false,
			'rewrite' => true,
			'supports' => array('title' )
		);
		register_post_type( 'property_enquiries' , $args );
		register_post_status( 'enquiry', array(
			'label'       => _x( 'Enquiry', 'property_enquiries' ),
			'protected'   => true,
			'_builtin'    => true, /* internal use only. */
			'label_count' => _n_noop( 'Enquiry <span class="count">(%s)</span>', 'Enquiry <span class="count">(%s)</span>' ),
		) );
		register_post_status( 'sent', array(
			'label'       => _x( 'Contact sent', 'property_enquiries' ),
			'protected'   => true,
			'_builtin'    => true, /* internal use only. */
			'label_count' => _n_noop( 'Contact sent <span class="count">(%s)</span>', 'Contact sent <span class="count">(%s)</span>' ),
		) );
		register_post_status( 'received', array(
			'label'       => _x( 'Contract Received', 'property_enquiries' ),
			'protected'   => true,
			'_builtin'    => true, /* internal use only. */
			'label_count' => _n_noop( 'Contract Received <span class="count">(%s)</span>', 'Contract Received <span class="count">(%s)</span>' ),
		) );
		register_post_status( 'active', array(
			'label'       => _x( 'Active', 'property_enquiries' ),
			'protected'   => true,
			'_builtin'    => true, /* internal use only. */
			'label_count' => _n_noop( 'Active <span class="count">(%s)</span>', 'Active <span class="count">(%s)</span>' ),
		) );
		register_post_status( 'hold', array(
			'label'       => _x( 'Hold', 'property_enquiries' ),
			'protected'   => true,
			'_builtin'    => true, /* internal use only. */
			'label_count' => _n_noop( 'Hold <span class="count">(%s)</span>', 'Hold <span class="count">(%s)</span>' ),
		) );
		register_post_status( 'archive', array(
			'label'       => _x( 'Archive', 'property_enquiries' ),
			'protected'   => true,
			'_builtin'    => true, /* internal use only. */
			'label_count' => _n_noop( 'Archive <span class="count">(%s)</span>', 'Archive <span class="count">(%s)</span>' ),
		) );
		wppe_init_method();
	}
	

	function wpea_metabox_functions(){
		add_action('save_post', 'save_wppe_data');
		
		add_meta_box("enquire_custom", "Enquiry Details", 'enquire_details_metabox' , "property_enquiries", "normal", "low");
		add_meta_box("enquire_submit", "Enquiry Submit", 'enquire_submit_metabox' , "property_enquiries", "side", "low");
	}
	
	function save_wppe_data(){
		global $post, $wpdb;

		if( isset($_POST['wppe_status']) && !empty($_POST['wppe_status']) && 
			($_POST['wppe_status']=='enquiry' || $_POST['wppe_status']=='sent' || $_POST['wppe_status']=='received' || $_POST['wppe_status']=='active'
			|| $_POST['wppe_status']=='hold' || $_POST['wppe_status']=='archive'	) ){
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_status = '%s' WHERE ID = '%d'", $_POST['wppe_status'] , $post->ID ) );
			foreach( $_POST['postdata'] as $key => $value ){
				if( is_array( $value )){
					$newvalue = implode("," , $value );
					update_post_meta( $post->ID, $key, $newvalue );
				} else {
					update_post_meta( $post->ID, $key, $value );
				}
			}
		}
	}
	
	function enquire_submit_metabox(){
		global $post;?>
        
        <?php if( $post->post_status!='auto-draft' ) { ?>
        Status : <?php echo ucfirst($post->post_status)?><br  />
        Change to 
        <?php } ?>
        <select name="wppe_status">
        	<option value="enquiry"<?php if( $post->post_status=='enquiry' ) echo ' selected="selected"'?>>Enquiry</option>
        	<option value="sent"<?php if( $post->post_status=='sent' ) echo ' selected="selected"'?>>Contract Sent</option>
        	<option value="received"<?php if( $post->post_status=="received" ) echo ' selected="selected"'?>>Contract Received</option>
        	<option value="active"<?php if( $post->post_status=='active' ) echo ' selected="selected"'?>>Active</option>
        	<option value="hold"<?php if( $post->post_status=='hold' ) echo ' selected="selected"'?>>Hold</option>
        	<option value="archive"<?php if( $post->post_status=='archive' ) echo ' selected="selected"'?>>Archive</option>                        
        </select>
        <input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="Update" />
        <?php
		
	}
	
	function wppe_set_status(){
		if( isset($_REQUEST['status']) && isset($_REQUEST['post']) && !empty($_REQUEST['status']) && 
			($_REQUEST['status']=='enquiry' || $_REQUEST['status']=='sent' || $_REQUEST['status']=='received' || $_REQUEST['status']=='active'
			|| $_REQUEST['status']=='hold' || $_REQUEST['status']=='archive'	) ){
			  wp_update_post( array('ID' => $_REQUEST['post'] , 'post_status' => $_REQUEST['status'] )  );
		}
	}
	wppe_set_status();
	
	function enquire_details_metabox(){
		global $post;

		$userdata = get_userdata( $post->post_author );
		
		$phone = get_post_custom_values('contact_number', $post->ID);
		$pen_state = get_post_custom_values('pen_state', $post->ID);
		$pen_city = get_post_custom_values('pen_city', $post->ID);
		$pen_vets = get_post_custom_values('pen_vets', $post->ID);
		$pen_property_ids = get_post_custom_values('pen_property_ids', $post->ID);
		$pen_properties_intersted = get_post_custom_values('pen_properties_intersted', $post->ID);
		$permalink = get_permalink( $post->ID );
		$states = explode(",", $pen_state[0]);
		$vets = explode(",", $pen_vets[0]);
		$properties = explode(",", $pen_properties_intersted[0]);
		if( empty($pen_property_ids) ) $pen_property_ids[0]=$pen_properties_intersted[0];
		?>
			<table border="0" width="100%">
              <tr>
                <td>Name</td>
                <td><input type="text" id="bulk_yourname" name="postdata[yourname]" maxlength="30" size="35" value="<?php echo $userdata->first_name?>" /></td>
              </tr>
              <tr>
                <td>User Email</td>
                <td><a href="user-edit.php?user_id=<?=$post->post_author?>"><?php echo $userdata->user_email;?></a></td>
              </tr>
              <tr>
                <td>Phone</td>
                <td><input type="text" id="bulk_yourphone" name="postdata[yourphone]" maxlength="25" size="35" value="<?php echo $phone?>" /></td>
              </tr>
              <tr>
                <td>Interested properties</td>
                <td>
                <?php
				if( $properties ) {
					$first = true; $output = '';
					foreach( $properties as $property) {
						if( $property ){
							if( !$first )  $output .= ",";
							$first = false;
							$p = get_post($property);	
							$permalink = get_permalink( $p->ID );
							$output .= '<a href="'.$permalink.'" target="_blank">'.$p->post_title.'</a> ';
						}
					}
					echo $output;
				}
				?>
                
                </td>
              </tr>
              <tr>
                <td>Cities</td>
                <td><input type="text" id="bulk_pen_city" name="postdata[pen_city]" maxlength="25" size="35" value="<?php echo $pen_city[0]?>" /></td>
              </tr>
              <tr>
                <td>Interested States</td>
                <td>
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><input type="checkbox" name="postdata[pen_state][]" class="bulk_states"<?php if( in_array('NSW', $states) ) echo ' checked="checked"';?> value="NSW" />NSW</td>
                        <td><input type="checkbox" name="postdata[pen_state][]" class="bulk_states"<?php if( in_array('SA', $states) ) echo ' checked="checked"';?> value="SA" />SA</td>
                        <td><input type="checkbox" name="postdata[pen_state][]" class="bulk_states"<?php if( in_array('NT', $states) ) echo ' checked="checked"';?> value="NT" />NT</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="postdata[pen_state][]" class="bulk_states"<?php if( in_array('ACT', $states) ) echo ' checked="checked"';?> value="ACT" />ACT</td>
                        <td><input type="checkbox" name="postdata[pen_state][]" class="bulk_states"<?php if( in_array('WA', $states) ) echo ' checked="checked"';?> value="WA" />WA</td>
                        <td><input type="checkbox" name="postdata[pen_state][]" class="bulk_states"<?php if( in_array('QLD', $states) ) echo ' checked="checked"';?> value="QLD" />QLD</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="postdata[pen_state][]" class="bulk_states"<?php if( in_array('VIC', $states) ) echo ' checked="checked"';?> value="VIC" />VIC</td>
                        <td><input type="checkbox" name="postdata[pen_state][]" class="bulk_states"<?php if( in_array('TAS', $states) ) echo ' checked="checked"';?> value="TAS" />TAS</td>
                        <td></td>
                      </tr>
                    </table>
                </td>
              </tr>
              <tr>
                <td>Interested Cities</td>
                <td><input type="text" id="yourcities" name="yourcities" maxlength="60" size="35" value="" /></td>
              </tr>
		<tr>
                <td>Interested No of vets<br />(range)</td>
                <td>
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><input type="checkbox" name="postdata[pen_vets][]" class="yourvets" value="1"<?php if( in_array('1', $vets) ) echo ' checked="checked"';?> />1</td>
                        <td><input type="checkbox" name="postdata[pen_vets][]" class="yourvets" value="1-2"<?php if( in_array('1-2', $vets) ) echo ' checked="checked"';?> />1-2</td>
                        <td><input type="checkbox" name="postdata[pen_vets][]" class="yourvets" value="2"<?php if( in_array('2', $vets) ) echo ' checked="checked"';?> />2</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="postdata[pen_vets][]" class="yourvets" value="2-3"<?php if( in_array('2-3', $vets) ) echo ' checked="checked"';?> />2-3</td>
                        <td><input type="checkbox" name="postdata[pen_vets][]" class="yourvets" value="3"<?php if( in_array('3', $vets) ) echo ' checked="checked"';?> />3</td>
                        <td><input type="checkbox" name="postdata[pen_vets][]" class="yourvets" value="3-4"<?php if( in_array('3-4', $vets) ) echo ' checked="checked"';?> />3-4</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="postdata[pen_vets][]" value="4"<?php if( in_array('4', $vets) ) echo ' checked="checked"';?> />4</td>
                        <td></td>
                        <td></td>
                      </tr>
                    </table>
                </td>
              </tr>
            </table>
        <?php
	}


	function prefix_ajax_process_bulk_enquiry(){
		global $current_user, $user_level;
		  check_ajax_referer( "bulk_enquire_form" );
		  $process=true;
		  $credentials_verified = false;
		  
		  if( empty($_POST['yourname']) ){
			  $msg .= 'Please enter your name <br />';
			  $process = false;
		  }
		  if( empty($_POST['youremail']) ){
			  $msg .= 'Please enter your email <br />';
			  $process = false;
		  }
		  if( empty($_POST['yourphone']) ){
			  $msg .= 'Please enter your enquiry <br />';
			  $process = false;
		  }
		  if( empty($_POST['bulk_properties']) ){
			  $msg .= 'Please enter your property list.  <br />';
			  $process = false;
		  }
		  
		  if( !checkEmail($_POST['youremail']) ){
			  $msg .= 'Please enter correct email<br />';
			  $process = false;
		  }
		  
			if( is_user_logged_in()) {
				$credentials_verified = true;
				$current_user = wp_get_current_user();
				$user_id = $current_user->ID;
				$user_email = $current_user->user_email;
				
				if( $user_level<10 ){
					if( $current_user->user_email!=$_POST['youremail'] ){
					  $msg .= 'Please enter you email used to login<br />';
					  $process = false;
					}
				}
			} 

			// Verify user credentials if they are passed
			if( !$credentials_verified && $_POST['youremail'] ) {
				$user_id = email_exists($_POST['youremail']);
				if( !$user_id ){
					$credentials_verified = false;	//register new user for role
				} else {
					$credentials_verified = true;	//user exists. and got the user id
					$userdata = get_userdata( $user_id );
				}
			}
			if( !$credentials_verified ) {
				$new_user['user_email'] = $_POST['youremail'];
				$new_user['role'] = get_option('eqfs_role' );
				$new_user['first_name'] = $_POST['yourname'];
				$new_user['user_pass'] = wp_generate_password();
				$user_id = wp_insert_user($new_user);
				if(is_wp_error($user_id)) {
					  $msg .= 'Coulden\'t add your enquiry. Please try again or contact site support<br />';
					  $process = false;
				} else {
					update_user_meta( $user_id, 'contact_number', $_POST['yourphone']);
			        update_user_meta( $user_id, 'is_not_approved', 1 );
				}
			}
			
			
		  if( $process ){
			  $message='';
			  $admin_email = get_bloginfo( 'admin_email' );
			  $blogname = get_bloginfo( 'name' );
			  $admin_email = get_bloginfo( 'admin_email' );
			  
			  $username = ( isset($userdata->first_name) )?$userdata->first_name:strip_tags( $_POST['yourname'] );
			  $useremail = ( isset($userdata->user_email ) )?$userdata->user_email :strip_tags( $_POST['youremail'] );
			  $properties = explode(",", strip_tags( trim($_POST['bulk_properties']) ) );
			  $message = 'Name : ' . $username . " \n" ;
			  $message .= 'Email : ' . $useremail . " \n" ;
			  $message .= 'Phone : ' . strip_tags( $_POST['yourphone'] ) . " \n" ;
			  $header =  "From: $blogname <$admin_email>\n"; // header for php mail only
			
				// add new enquiry
			  $new_enquiry = array(
				'post_title'   => 'Enquiry',
				'post_status'  => 'enquiry',
				'post_type'    => 'property_enquiries'
			  );
		  
			  //** Commit basic property data to databse */
			  $enquiry_id = wp_insert_post( $new_enquiry );
			  $my_post = array();
			  $my_post['ID'] = $enquiry_id;
			  $my_post['post_author'] = $user_id;
			  $my_post['post_title'] = 'Enquiry ID: '. $enquiry_id.". By " . strip_tags( $_POST['yourname'] );
			  wp_update_post( $my_post );
			  $state = implode(",", $_POST['states'] );
			  $vets = implode(",", $_POST['yourvets'] );
			  update_user_meta($enquiry_id, 'contact_number', strip_tags( $_POST['yourphone'] ) );
			  update_post_meta($enquiry_id, 'pen_enquiry', true );
			  update_post_meta($enquiry_id, 'pen_properties_intersted', strip_tags( $_POST['bulk_properties'] ));
			  update_post_meta($enquiry_id, 'pen_property_ids', strip_tags( $_POST['pen_property_ids'] ));
			  update_post_meta($enquiry_id, 'pen_state', $state );					
			  update_post_meta($enquiry_id, 'pen_city', strip_tags( $_POST['yourcities'] ));
			  update_post_meta($enquiry_id, 'pen_vets', $vets );
			
			  foreach( $properties as $propertid ) {
				  $post = get_post( $propertid );
				  $post_author = get_userdata( $post->post_author );
				  $author_email = $post_author->user_email;
				  $subject = 'Enquiry about your property listing';
					$addtodo = array(
						'todo_title'       => 'New property contact message By : '. strip_tags( $_POST['yourname'] ) .'('. strip_tags( $_POST['youremail'] ) .')',
						'todo_propertyid'  => $post->ID	);
					global $todo_class;
					$todo_class->insert_todo_item($addtodo);
					$logmessage = nl2br($message);
					$log = array( 'log_title' => $logmessage, 'log_propertyid' => $post->ID, 'log_by' => 0, 
								 'log_mode' => 'enquiry', 'log_extra_id' => $enquiry_id );
					$todo_class->insert_todo_log( $log );
					//** Send User email */
			  }
  		      wp_mail( $admin_email, $subject, $message, $header );
			  die('success');
		  } else {
			  $nmsg = 'Please fill out all the inputs <br />' . $msg;
			  die($nmsg);
		  }
	}
		
	function enquiry_button_output(){
		$siteurl =  get_option( 'siteurl' );
		$successmessage ='Your message is sent to publisher.';
		$nonce = wp_create_nonce( 'bulk_enquire_form' );
		$bloginfo = get_bloginfo('stylesheet_directory');
	$output = '
	<div style="display:none;">
        <div id="bulk_contact_popup"  class="form_openclose acc_con">
    <script>
		jQuery(document).ready(function($) {
			var ajaxurl = \''.$siteurl.'/wp-admin/admin-ajax.php\';
			var makesuccess = \''.$successmessage.'\';
			$(\'#sendbuklbtn\').click(function() { //start function when Random button is clicked
				var bulkstates = [];
				var bulkvets = [];
					$(".bulk_states:checked").each(function() {
					  bulkstates.push($(this).val());
					});
					$(".yourvets:checked").each(function() {
					  bulkvets.push($(this).val());
					});
				$.ajax({
					type: "post",url: ajaxurl ,data: 
						{ 
						yourname: $(\'#bulk_yourname\').val(),
						youremail: $(\'#bulk_youremail\').val(),
						yourphone: $(\'#bulk_yourphone\').val(),
						yourcities: $(\'#yourcities\').val(),
						pen_property_ids : $(\'#bulk_property_ids\').val(),
						states: bulkstates,
						yourvets: bulkvets,
						bulk_properties: $(\'#bulk_properties\').val(),
						action: \'process_bulk_enquiry\',
						_ajax_nonce: \''.$nonce.'\' 
						},
					beforeSend: function() {
						$("#bulk_cform_content").hide();
						$("#bulk_cform_msg").show();
						}, //show loading just when link is clicked
					complete: function() { $("#cform_content").show();}, //stop showing loading when the process is complete
					success: function(html){ //so, if data is retrieved, store it in html
						if( html==\'success\' ){
							$("#bulk_cform_msg").html(makesuccess); //show the html inside helloworld div
							$("#bulk_cform_content").hide(); //animation
						} else {
							$("#bulk_cform_msg").html(html); //show the html inside helloworld div
							$("#bulk_cform_content").show(); //show the html inside helloworld div
						}
					}
				}); //close jQuery.ajax(
				return false;
			});
		});
    </script>
	<div id="bulk_cform_msg" style="display:none;"><img src="'.$bloginfo.'/images/social-small/loader.gif" border="0" align="absmiddle" /> Processing. . . Please wait.</div>
    <div id="bulk_cform_content">
        	<form action="" name="">
            <input type="hidden" id="bulk_properties" name="bulk_properties" />
            <input type="hidden" id="bulk_property_ids" name="bulk_property_ids" />

           <table width="550px" border="0">
              <tr>
                <td>Subject</td>
                <td><div id="bulk_mysubject_display"></div></td>
              </tr>
              <tr>
                <td>Your Name</td>
                <td><input type="text" id="bulk_yourname" name="yourname" maxlength="30" size="35" value="" /></td>
              </tr>
              <tr>
                <td>Your Email</td>
                <td><input type="text" id="bulk_youremail" name="youremail" maxlength="30" size="35" value="" /></td>
              </tr>
              <tr>
                <td>Your Phone</td>
                <td><input type="text" id="bulk_yourphone" name="yourphone" maxlength="25" size="35" value="" /></td>
              </tr>
              <tr>
                <td>Interested States</td>
                <td>
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><input type="checkbox" name="states[]" class="bulk_states" value="NSW" />NSW</td>
                        <td><input type="checkbox" name="states[]" class="bulk_states" value="SA" />SA</td>
                        <td><input type="checkbox" name="states[]" class="bulk_states" value="NT" />NT</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="states[]" class="bulk_states" value="ACT" />ACT</td>
                        <td><input type="checkbox" name="states[]" class="bulk_states" value="WA" />WA</td>
                        <td><input type="checkbox" name="states[]" class="bulk_states" value="QLD" />QLD</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="states[]" class="bulk_states" value="VIC" />VIC</td>
                        <td><input type="checkbox" name="states[]" class="bulk_states" value="TAS" />TAS</td>
                        <td></td>
                      </tr>
                    </table>
                </td>
              </tr>
              <tr>
                <td>Interested Cities</td>
                <td><input type="text" id="yourcities" name="yourcities" maxlength="60" size="35" value="" /></td>
              </tr>
		<tr>
                <td>Interested No of vets<br />(range)</td>
                <td>
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><input type="checkbox" name="yourvets[]" class="yourvets" value="1" />1</td>
                        <td><input type="checkbox" name="yourvets[]" class="yourvets" value="1-2" />1-2</td>
                        <td><input type="checkbox" name="yourvets[]" class="yourvets" value="2" />2</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="yourvets[]" class="yourvets" value="2-3" />2-3</td>
                        <td><input type="checkbox" name="yourvets[]" class="yourvets" value="3" />3</td>
                        <td><input type="checkbox" name="yourvets[]" class="yourvets" value="3-4" />3-4</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="yourvets[]" value="4" />4</td>
                        <td></td>
                        <td></td>
                      </tr>
                    </table>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" id="sendbuklbtn" class="tbutton_contact sendbuklbtn" name="bulk_contact" value="SEND"></td>
              </tr>
            </table>
			</form>
	</div>
        </div>
    </div>
		';
		return $output;
	}

	function prefix_ajax_wpa_property_evaluvation(){

		 global $wpdb;
		  check_ajax_referer( "property_evaluvation" );
		  $process=true;
		  if( empty($_POST['yourname']) ){
			  $msg = 'Please enter the * marked fields <br />';
			  $process = false;
		  }
		  if( empty($_POST['youremail']) ){
			  $msg = 'Please enter the * marked fields <br />';
			  $process = false;
		  }
		  
		  if( !is_email(trim($_POST['youremail'])) ){
			  $msg = 'Incorrect email account <br />';
			  $process = false;
		  }
		
	
		  if( $process ){
			global $wpdb;
			$yourname = strip_tags( trim($_POST['yourname']) );
			$youremail = strip_tags( trim($_POST['youremail']) );

			$secureid = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM ".WPEA_ALERTS." WHERE email='%s'", $youremail  ) );
			if( $secureid->id ) {
				if( isset($_POST['unsubscribe']) && $_POST['unsubscribe']=='checked' ){
					 $wpdb->query( "DELETE FROM ".WPEA_ALERTS." WHERE id = '".$secureid->id."'" );
					 $msg = 'Your email is unsubscribed';
				} else {
					$msg = 'Already subscribed.';
				}
			} else {
			  //CREATE SECURE KEY, INSERT DATA AND SEND VALIDATION EMAIL
			  $secure = md5( WPEA_ALERTS_SECURE. $name , $email );
//			  $sql = $wpdb->prepare( "INSERT INTO ".WPEA_ALERTS."(`name` ,`email` ,`status` ,`secure`)
//														VALUES ( '%s', '%s', 'false', '%s');", 
//														$yourname, $youremail , $secure   );echo $sql;
//			  $secureid = $wpdb->query( $sql );
			  $wpdb->insert( WPEA_ALERTS ,
							array( 'name' => $yourname, 'email' => $youremail, 'secure' => $secure ), 
							array( '%s', '%s', '%s' ) );
			  send_confirm_alert_email($yourname, $youremail, $secure);
			}
		  }
		  if( empty($msg) ){  
			 die('success');
		  } else {
		  	die( '<h4 class="hed_tugle">'.$msg.'</h4>' ); 
		 }
	 
	}
	 
	function request_property_evaluvation(){
		$siteurl =  get_option( 'siteurl' );
		$successmessage ='Your message is sent to site administrator.';
		$nonce = wp_create_nonce( 'property_evaluvation' );
		$output = 
		'<div id="openclose_02" class="acc_con" style="height: 205px; opacity: 1; display: none;">Form Will come Here</div>
			<div class="heading_buysell">
			<ul>
			<li><a href="#bulk_contact_popup" id="bulk_enquiery_alert"><span id="heading_03">Request a Practice Valuation</span></a></li>
			</ul>
			</div>
		';
		$output .= enquiry_button_output();
		return $output;
	}
