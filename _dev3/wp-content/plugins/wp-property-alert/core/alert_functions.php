<?php
//New metaboxes
	function wpa_admin_init(){
		remove_submenu_page( 'edit.php?post_type=property', 'packages' );
		add_submenu_page('edit.php?post_type=property', 'Alerts subscriptions', 'Alerts subscriptions', 'administrator', 'alert_subscriptions','wpa_subscriptions_metabox');
		add_submenu_page('edit.php?post_type=property', 'Alert Settings', 'Alert Settings', 'administrator', 'alert_settings','wpa_settings_metabox');
	}



	

	function wpa_init(){
		global $wpdb;
		if( isset( $_GET['ps']) ){
			$secureid = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM ".WPEA_ALERTS." WHERE secure='%s'", strip_tags(trim($_GET['ps']))  ) );
			if( $secureid ) {
				$wpdb->query( "UPDATE ".WPEA_ALERTS." SET status = 'true' WHERE id = '$secureid' " );
				$permlink =  get_option('confirm_property_alert_subscription_success');
			} else {
				$permlink =  get_option('confirm_property_alert_subscription_fail');
			}
			wp_redirect( $permlink );
			die();
		}
		
		if( isset( $_GET['wpa_subscribe']) && $_GET['wpa_subscribe']=='alert' ){
			wpa_send_alert();
		}
	}
	
		function my_filter_where( $where = '' ) {
		
			global $wp_query;
		
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('now')) . "'";
			return $where;
		}
		
		
	function wpa_send_subscriber_alert( $name, $email, $alertlist ){
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
		
		$siteurl =  get_option( 'siteurl' );
		$note_data = array(
							 '{SUBSCRIBER_EMAIL}' => $email,
							 '{SUBSCRIBER_NAME}' => $name,
							 '{PROPERTY_LIST}' => $alertlist
							 );
		$data = get_valuvet_notify_email_template( 'subscribe_alert_email', $note_data );
		$header =  "From: ".$notify_data['{BLOG_INFO}']."<".$notify_data['{ADMIN_EMAIL}'].">\n"; // header for php mail only
		wp_mail($email, sprintf(__('%s '.$data['subject'] ), $notify_data['{BLOG_INFO}'] ), $data['message'], $header);	
	}

	function wpa_send_alert(){
		global $wpdb;
			$args = array(
				'post_type'=> 'property',
				'post_status' => 'publish'
			);
			
			$today = date('Y-m-d');
			$cdate_chk = get_option('wpa_cron_date' );
			
			if( $cdate_chk!=$today ) {
				add_filter( 'posts_where', 'my_filter_where' );
				$posts = query_posts( $args );
				$subscriptions = $wpdb->get_results( "SELECT name,email FROM ".WPEA_ALERTS." WHERE 1");				
				$output = '';
				foreach( $posts as $post ){
					$permalink = get_permalink( $post->ID );
					$output .= '<p><a href="'.$permalink.'">'.$post->post_title.'</a><br >
	
					</p>
					
					';
				}
				foreach( $subscriptions as $subscriber ){
					wpa_send_subscriber_alert( $subscriber->name, $subscriber->email, $output );
				}
				update_option( 'wpa_cron_date', $today );
			}
	}
	
	function update_wpa_settings_metabox(){
		if( check_admin_referer('wpa_settings_save') ){	
			foreach( $_POST['palert'] as $key => $value ){ 
				update_option( $key, $value );
			}
		}
	}
	
	
	function wpe_show_message(){
		global $message, $class;
		echo '<div class="'.$class.'">
		   <p>'.$message.'</p>
		</div>';
	}
	
	
	function wpa_admin_notice(){
		wpe_show_message();
	}


	function update_wpa_subscriptions_metabox(){
		global $message, $class,$wpdb;
		if( check_admin_referer('wpa_subscripber_management') ){	
			foreach( $_POST['subscriber'] as $key => $value ){ 
				if( $_POST['action']=='Delete' ) $wpdb->query( "DELETE FROM ".WPEA_ALERTS." WHERE id = '$value'" );
				if( $_POST['action']=='Active' ) $wpdb->query( "UPDATE ".WPEA_ALERTS." SET status = 'true' WHERE id = '$value' " );
				if( $_POST['action']=='Disable' ) $wpdb->query( "UPDATE ".WPEA_ALERTS." SET status = 'false' WHERE id = '$value' " ); 
			}
			$message = 'Data saved'; $class= 'updated';
		}
	}


	function wpa_settings_metabox(){
		screen_icon();
	?>
	<div class="wrap">
		<h2><?php  echo  __('Properties subscription alert ','wpp'). ' ' . __('Settings','wpp') ?></h2>
        
        <h3>Cron Url : <?php echo site_url()?>/index.php?wpa_subscribe=alert</h3> Run cron for every day
      <form method="post" action="<?php echo admin_url('edit.php?post_type=property&page=alert_settings'); ?>" />
      <?php wp_nonce_field('wpa_settings_save'); ?>
    
      
      <h3>Property package change page</h3>
      <table width="60%" border="0">
        <tr>
        	<td>Subsription confirm success page</td>
          <td><input type="text" name="palert[confirm_property_alert_subscription_success]" maxlength="150" size="60" value="<?php echo get_option('confirm_property_alert_subscription_success' );?>" />
          </td>
        </tr>
        <tr>
        	<td>Subsription confirm fail page</td>
          <td><input type="text" name="palert[confirm_property_alert_subscription_fail]" maxlength="150" size="60" value="<?php echo get_option('confirm_property_alert_subscription_fail' );?>" />
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
	
	
	function wpa_subscriptions_metabox(){
		global  $wpdb;
		screen_icon();

        $paged = ( isset($_GET['paged']) )?$_GET['paged']:1;
		$limit = 50;
		$offset=($paged==1)?0:( $limit*($paged - 1 ) );
		$total = $wpdb->get_results( "SELECT COUNT(*) as counts FROM ".WPEA_ALERTS." WHERE 1");
		$totalpages = ceil( $total[0]->counts/$limit );
		$subscriptions = $wpdb->get_results( "SELECT * FROM ".WPEA_ALERTS." WHERE 1 ORDER BY id DESC LIMIT $offset, $limit");
	?>
	<div class="wrap">
		<h2><?php  echo  __('Properties subscriptions','wpp') ?></h2>
        <?php if( $subscriptions ){ ?>
        
        <form action="<?php echo admin_url('edit.php?post_type=property&page=alert_subscriptions'); ?>" method="post">
        <select name="action">
        	<option>Delete</option>
        	<option value="Active">Change Status Active</option>
        	<option value="Disable">Change Status Disable</option>
        </select>
         <?php wp_nonce_field('wpa_subscripber_management'); ?>
				<table width="100%" class="wp-list-table widefat fixed posts" cellspacing="0" border="0">
		  <tr>
			<thead>
				<th width="10"></th>
				<th>Name</th>
				<th>Email</th>
				<th>Status</th>
				<th>Secure code</th>
			</thead>
		  </tr>
          <?php
		  foreach( $subscriptions as $subscriber ){
		  ?>
		  <tr>
			<td><input type="checkbox" name="subscriber[]" value="<?php echo $subscriber->id ?>" /></td>
			<td><?php echo $subscriber->name ?></td>
			<td><?php echo $subscriber->email ?></td>
			<td><?php echo $subscriber->status ?></td>
			<td><?php echo $subscriber->secure ?></td>
		  </tr>
		<?php } ?>
		</table>
        
        <?php $adminurl = admin_url('edit.php?post_type=property&page=alert_subscriptions');?>
        	<?php if( $paged > 1 ) {?>
	        <a href="<?php echo $adminurl?>&paged=<?php echo $paged - 1;?>">Prev</a>
            <?php } ?>
        	<?php if( $totalpages>1 ) {?>
        	<a href="<?php echo $adminurl;?>&paged=<?php echo $paged + 1;?>">Next</a>
            <?php } ?>
            
	<p class="wpp_save_changes_row">
	<input type="submit" value="<?php _e('Save Changes','wpp');?>" name="button-submit" class="button-primary" >
 	</p>
        </form>
        <?php } else {
			echo 'No subscriptions yet.';
			}
			?>
    </div>
        <?php
	}

	function send_confirm_alert_email( $name, $email, $secure ){
		
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
		
		$siteurl =  get_option( 'siteurl' );
		$note_data = array(
							 '{SITE_URL}' => $siteurl,
							 '{SUBSCRIBER_EMAIL}' => $email,
							 '{SUBSCRIBER_NAME}' => $name,
							 '{SUBSCRIBER_SECURE_LINK}' => $siteurl . '?ps='. $secure
							 );
		$data = get_valuvet_notify_email_template( 'confirm_property_subscribe_alert_email', $note_data );
		$header =  "From: ".$notify_data['{BLOG_INFO}']."<".$notify_data['{ADMIN_EMAIL}'].">\n"; // header for php mail only
		wp_mail( $email, sprintf(__('%s '.$data['subject'] ), $notify_data['{BLOG_INFO}'] ), $data['message'], $header);	
	}
	
	//AJAX CALL FOR SUBSCRIPTION FORM
	 function prefix_ajax_wpa_subscribe_alerts() {
		 global $wpdb;
		  check_ajax_referer( "subscribe_property_alert" );
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
	 
	 
	function link_subscribe_property_alert(){
		$siteurl =  get_option( 'siteurl' );
		$successmessage ='Your message is sent to publisher.';
		$nonce = wp_create_nonce( 'subscribe_property_alert' );
		$output = 
			'<div id="openclose_02" class="acc_con" style="height: 205px; opacity: 1; display: none;">Form Will come Here</div>
			<div class="heading_buysell">
			<ul>
			<li><a href="#propert_alert_box" class="property_alert"><span id="heading_03">Subscribe to our Property Alert</span></a></li>
			</ul>
			</div>
			<div style="display:none;">
				<div id="propert_alert_box" class="form_openclose acc_con">
					<div id="wpa_alert_msg"></div>
					<div id="wpa_form">
                     <form id="" method="post" action="" class="cmxform">
                          <fieldset>
                            <h4 class="hed_tugle">Mandatory fields marked <em>*</em></h4>
                           <ol>
                            <li>
                              <label for="s_fullname">Your Name <em>*</em></label>
                              <input class="wide form_req" name="yourname" id="yourname">
                            </li>
                            <li>
                              <label for="s_email">Email <em>*</em></label>
                              <input name="youremail" id="youremail">
                            </li>
                        <li>
                        <input name="palert_unsubscribe" id="palert_unsubscribe" value="un_subscribe" type="checkbox">&nbsp;&nbsp;Click here to un-subscribe
                        </li>
                          </ol>
                          </fieldset>
                            <input id="sendbtn" value="Submit" type="submit">  
                        </form>
						</div>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
				  var ajaxurl = \''. $siteurl .'/wp-admin/admin-ajax.php\';
				  jQuery(\'#sendbtn\').click(function() { //start function when Random button is clicked
					  jQuery("#wpa_form").hide();
					  jQuery("#wpa_alert_msg").html(\'Processing . . Please wait.\');
					  if( $(\'#palert_unsubscribe\').is(":checked")  ){
					  	datac = \'checked\';
					  } else {
					  	datac = \'unchecked\';
					  }
					  $.ajax({
						  type: "post",url: ajaxurl ,data: 
							  { 
							  yourname: $(\'#yourname\').val(),
							  youremail: $(\'#youremail\').val(),
							  action: \'wpa_subscribe_alerts\',
							  unsubscribe : datac,
							  _ajax_nonce: \''. $nonce .'\'
							  },
						  beforeSend: function() {
							  }, //show loading just when link is clicked
						  complete: function() { }, 
						  success: function(html){ //so, if data is retrieved, store it in html
							  if( html==\'success\' ){
								   $("#wpa_form").hide();
								  $("#wpa_alert_msg").html(\'You subscription was saved. Please confirm your subscription by clicking the link on your confirmation email.\');
							  } else {
  								  $("#wpa_alert_msg").html(html);
								  jQuery("#wpa_form").show();
							  }
						  }
					  }); //close jQuery.ajax(
					  return false;
					});	//close click
				  jQuery("a.property_alert").fancybox({
						\'scrolling\': \'auto\',
						\'hideOnContentClick\': false,
						\'onStart\'		: function() {
						   jQuery("#wpa_form").show();
						  jQuery("#wpa_alert_msg").html(\'\');  
						},
						\'onClosed\'		: function() {
						  jQuery("#wpa_alert_msg").html(\'\');  
						}
				  });
			  });
				</script>
		';
		return $output;
	}