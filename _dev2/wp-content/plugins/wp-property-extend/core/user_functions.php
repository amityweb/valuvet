<?php
/**
 * WP-Property-Extend General Functions
 *
 */


// action function for above hook
function wpe_property_menu() {
    add_submenu_page(__('Test Toplevel','menu-test'), __('Test Toplevel','menu-test'), 'manage_options', 'mt-top-level-handle', 'mt_toplevel_page' );
}

// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function mt_toplevel_page() {
    echo "<h2>" . __( 'Test Toplevel', 'menu-test' ) . "</h2>";
}

// Hook for adding propery listing in admin menus
add_action('user_admin_menu', 'wpe_property_menu');


add_filter( 'map_meta_cap', 'wpe_map_meta_cap', 10, 4 );
function wpe_map_meta_cap( $caps, $cap, $user_id, $args ) {
   	global $current_user;

	/* If editing, deleting, or reading a property, get the post and post type object. */
	if ( 'edit_wpp_property' == $cap || 'edit_wpp_properties' == $cap || 'read_wpp_properties' == $cap || 'read_wpp_property' == $cap ) {
		$post = get_post( $args[0] );
		$post_type = get_post_type_object( $post->post_type );

		/* Set an empty array for the caps. */
		$caps = array();
	}

	/* If editing a property, assign the required capability. */
	if ( 'edit_wpp_property' == $cap ) {
		if ( $user_id == $post->post_author ){
			$caps[] = $post_type->cap->edit_posts;
		} else {
			$caps[] = $post_type->cap->edit_others_posts;
		}

	}
	/* If reading a private property, assign the required capability. */
	elseif ( 'read_wpp_property' == $cap ) {

		if ( 'private' != $post->post_status )
			$caps[] = 'read';
		elseif ( $user_id == $post->post_author )
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
			
			
	/* If reading a private property, assign the required capability. */
	} elseif ( 'read_wpp_properties' == $cap ) {

		if ( current_user_can( 'propertysubscriber' ) ||  current_user_can( 'registereduser' )  && ( $user_id == $post->post_author ) ){
				$caps[] = 'read';
		} else {
			if ( 'private' != $post->post_status )
				$caps[] = 'read';
			elseif ( $user_id == $post->post_author )
				$caps[] = 'read';
			else
				$caps[] = $post_type->cap->read_private_posts;
		}
			
	} elseif(  'view_wpp_property' == $cap  ){
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->view_post;
		else
			$caps[] = $post_type->cap->view_post;
	}

	/* Return the capabilities required by the user. */
	return $caps;
}


function wpp_extend_js_script(){
    wp_register_script( 'jquery-validator', get_template_directory_uri() . '/js/jquery.validate.min.js' );
    wp_enqueue_script( 'jquery-validator' );
    wp_register_script( 'jquery-main', get_template_directory_uri() . '/js/jquery.main.js' );
    wp_enqueue_script( 'jquery-main' );
    wp_register_script( 'jquery-money-format', get_template_directory_uri() . '/js/jquery.price_format.min.js' );
    wp_enqueue_script( 'jquery-money-format' );
    wp_register_script( 'jquery-inputfocus', get_template_directory_uri() . '/js/jquery.inputfocus-0.9.min.js' );
    wp_enqueue_script( 'jquery-inputfocus' );
}


function wpp_extend_header_js(){
    wp_register_script( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js' );
    wp_enqueue_script( 'jquery-ui' );
    wp_enqueue_style( 'jquery-ui-style',  get_template_directory_uri() . '/js/jquery.ui/css/humanity/jquery-ui-1.8.19.custom.css' );
}

function wp_property_extend_addons(){
	include_once WPE_Path . 'templates/property-progressbar.php';
	add_action('wp_footer', 'wpp_extend_js_script');
}

add_action( 'wp_enqueue_scripts', 'wpp_extend_header_js');
add_action( 'show_user_profile', 'wppe_extra_profile_fields' );
add_action( 'edit_user_profile', 'wppe_extra_profile_fields' );

function wppe_extra_profile_fields( $user ) { 
	  delete_user_meta( $user->ID , 'is_not_approved' );
?>

	<h3>Administrator Contact Information</h3>

	<table class="form-table">

		<tr>
			<th><label for="contact_number">Contact number</label></th>

			<td>
				<input type="text" name="contact_number" id="contact_number" value="<?php echo esc_attr( get_the_author_meta( 'contact_number', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
        
		<tr>
			<th><label for="add_enquery_phone">Advertisement Enquiry Contact Phone Number</label></th>

			<td>
				<input type="text" name="add_enquery_phone" id="add_enquery_phone" value="<?php echo esc_attr( get_the_author_meta( 'add_enquery_phone', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>

	</table>
<?php }

add_action( 'personal_options_update', 'wppe_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'wppe_save_extra_profile_fields' );

function wppe_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'contact_number', $_POST['contact_number'] );
	update_usermeta( $user_id, 'add_enquery_phone', $_POST['add_enquery_phone'] );
}


function get_further_info( $mode='title_name', $post, $type='class' , $echo=true ){ 
	$author = ( $type=='class' )?$post['post_author']:$post->post_author;
	$user_title = ( $type=='class' )?$post['user_title']:$post->user_title;

	$userdata = get_userdata( $author );
	if( $mode=='title_name' ){
		$firstname = get_the_author_meta( 'first_name', $author );
		$lastname = get_the_author_meta( 'last_name', $author );
		$output =  $user_title . ' ' . ucfirst($firstname) . ' ' . ucfirst($lastname); 
	} elseif( $mode=='phone' ){
		$output = get_the_author_meta( 'add_enquery_phone', $author );
	} elseif( $mode=='email' ){
		$output = get_the_author_meta( 'email', $author );
	}
	
	
	if( $echo ){
		echo $output;
	} else {
		return $output;
	}
}

function load_paypal(){
	global $post, $ack;
	
	$price=get_option( $post->property_type );
	if( !empty($ack) && $ack=="SUCCESS" ){
			echo 'Payment success';
			unset($_SESSION['reshash']);
	} else  {

	?>

	<form action="<?php echo get_permalink( $post->ID );?>" method="POST">
      <?php wp_nonce_field('wppe_paypal_init'); ?>
    <input type="hidden" name="return_URL" value="<?php echo get_permalink( $post->ID );?>" />
    <input type="hidden" name="cancel_URL" value="<?php echo get_permalink( $post->ID );?>" />
    <input type="hidden" name="OPID" value="<?php echo $post->ID;?>" />
    <input type="hidden" name="OPTYPE" value="property" />
    <input type="hidden" name="makepayment" value="true" />
	<input type="hidden" name="paymentType" value='Order' >
	<input type="hidden" name="currencyCodeType" value='AUD' >
	<input type="hidden" name="L_DESC0" value="<?php echo $post->post_type;?>" >
    
	<input type="hidden" name="L_AMT0" size="5" maxlength="32" value="<?php echo set_money_format( $price )?>"  />
	<input type="hidden" size="30" maxlength="32" name="L_NAME0" value="Property sale - <?php echo $post->property_type_label;?>" /> 
                        
    <div class="paypal_container">
    <?php
	if(isset($_SESSION['curl_error_no'])) { 
			$errorCode= $_SESSION['curl_error_no'] ;
			$errorMessage=$_SESSION['curl_error_msg'] ;	
			session_unset();	?>
            
    <div class='error'>
    	<p>Error on paypal transaction initialization please contact site administrator</p>
    	<p>Error Message : <?php echo $errorMessage; ?></p>
    </div>

	<?php } ?>
    
    <?php
		if( isset($_SESSION['reshash']) ){
			echo 'Payment error. ';
			$resArray=$_SESSION['reshash']; 
			echo $resArray['CHECKOUTSTATUS'];
			unset($_SESSION['reshash']);
		}
		?>
    <center>    
    <table style="">
        <th>Shopping cart Products:</th>
			 <tr>
				<td class="field">Property Package:</td>
				<td><?php echo $post->property_type_label;?></td>
			</tr>
            <tr>
				<td>Price</td>
			 	<td><input type="hidden" size="3" maxlength="32" name="L_QTY0" value="1" /><?php echo set_money_format( $price );?></td>
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
}

function valuevet_admin_notice_post_locked() {
	global $post;
	$lock = explode( ':', get_post_meta( $post->ID, '_edit_lock', true ) );
	$user = isset( $lock[1] ) ? $lock[1] : get_post_meta( $post->ID, '_edit_last', true );
	$last_user = get_userdata( $user );
	$last_user_name = $last_user ? $last_user->display_name : __('Somebody');
	$message = __( 'Warning: %s is currently reviewing this.' );


	$message = sprintf( $message, esc_html( $last_user_name ) );
	echo "<div class='error'><p>$message</p></div>";
}

function lockpost(){
	global $post;
	$lock = get_post_meta( $post->ID, '_edit_lock', true );
}
add_action('wp_head', 'lockpost' );




function is_renew_old( $postid ){
	$post = get_post( $postid );
	$list_until = (int)get_option('property_listing_notification_1');
	$end = date( 'Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s' ) . " - ".$list_until." day" ) );
	$start = strtotime( $post->post_date );
	$end = strtotime( date('Y-m-d H:i:s' ) );
	$days_between = ceil(abs($end - $start) / 86400);
	if( $days_between>(365-$list_until) ){
		return true;
	}
	return false;
}


function paypal_init(){
	if( isset($_SESSION['OPID']) && $_SESSION['OPTYPE'] && $_SESSION['reshash'] && $_GET["token"]==$_SESSION['reshash']["TOKEN"] && !empty($_GET["PayerID"]) ){
		if( $_SESSION['reshash']["ACK"]=='Success' ){
			
			if( isset( $_SESSION['makeupgrade'] ) && $_SESSION['makeupgrade']==true ) {
					delete_post_meta($_SESSION['OPID'], 'upgrade_package_from' );
					delete_post_meta($_SESSION['OPID'], 'upgrade_payment' );
					unset( $_SESSION['makeupgrade'] );
			}
			update_post_meta( $_SESSION['OPID'], 'payment_status', 'Paid' );
			$_SESSION['paypal_message'] = 'Payment success. Thank you for your payment.';
			$renewold = is_renew_old( $_SESSION['OPID'] );
			if( $renewold )	{
				update_post_meta( $_SESSION['OPID'], 'renew_status', 'Yes' );
			}
			update_post_meta( $_SESSION['OPID'], 'PAYPAL_TOKEN', $_SESSION['reshash']["TOKEN"] );
			$pendinghash = get_post_custom_values('wpp_feps_pending_hash',$_SESSION['OPID'] );	
			$myurl = site_url();
			$permlink = $myurl . '/?post_type=property&p='.$_SESSION['OPID'].'&wpp_front_end_action=wpp_view_pending&pending_hash='.$pendinghash[0];
			unset( $_SESSION['OPID'] );
			unset( $_SESSION['OPTYPE'] );
			wp_redirect( $permlink );
			die();
		}
	}
	
	if( isset( $_POST['makepayment'] ) && $_POST['makepayment']=='true' ){
		if( check_admin_referer('wppe_paypal_init') ){
			
			$paypalapi_mode = get_option('paypalapi_mode', 'Test');
			if( $paypalapi_mode=='Test' ){
				define('API_ENDPOINT', "https://api-3t.sandbox.paypal.com/nvp" );
				define('PAYPAL_URL', "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=");
			} else {
				define('API_ENDPOINT', "https://api-3t.paypal.com/nvp" );
				define('PAYPAL_URL', "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=");
			}
			
			if( isset( $_POST['makeupgrade'] ) ) $_SESSION['makeupgrade']=true;
	
			define('API_USERNAME', get_option( 'paypalemail') );
			define('API_PASSWORD', get_option( 'paypalpassword') );
			define('API_SIGNATURE', get_option( 'paypalapi') );
			define('SUBJECT','');
			define('USE_PROXY',FALSE);
			define('PROXY_HOST', '127.0.0.1');
			define('PROXY_PORT', '808');
			define('VERSION', '65.1');
			define('ACK_SUCCESS', 'SUCCESS');
			define('ACK_SUCCESS_WITH_WARNING', 'SUCCESSWITHWARNING');
			require_once( WPE_Path . 'core/ReviewOrder.php');
		}
	}
}
add_action('init', 'paypal_init' );


function wppe_check_username(){
	$useremail = $_REQUEST["user_email"];
	$hasemail = email_exists( $useremail );
	if( $hasemail ){
		$op = array('user_exists' => 'true');
	} else {
		$op = array('user_exists' => 'false');
	}
	die( json_encode( $op ) );
}

add_action("wp_ajax_wpp_feps_user_lookup", 'wppe_check_username' );
add_action("wp_ajax_nopriv_wpp_feps_user_lookup", 'wppe_check_username' );