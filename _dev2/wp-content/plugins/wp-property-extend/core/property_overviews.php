<?php
function wppe_convert( $property, $data ){
	switch( $data ){
		case 'gallery':
			return ( isset($property->gallery) )?$property->gallery:$property->images;
			break;
		default:
			break;
	}
}


function arrayToObject($array) {
    if(!is_array($array)) {
        return $array;
    }
    
    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
      foreach ($array as $name=>$value) {
         $name = strtolower(trim($name));
         if (!empty($name)) {
            $object->$name = arrayToObject($value);
         }
      }
      return $object;
    }
    else {
      return FALSE;
    }
}


function make_askingprice( $price ){
	if( !strstr( (string)$price, "$" ) ){
		return get_option('currency_symbol', '$'). ' ' .(string)$price;
	} else {
		return (string)$price;
	}
}

function featured_image_overview($gallery, $size='medium'){
	global $property;
	$thumb='';$large='';$title='';
		if( $gallery[$size] ){
			$thumb=$gallery[$size];
			$large=$gallery['large'];
			$title=$gallery['post_title'];
		}
	$thumb = ( !empty( $thumb ) )?$thumb:get_option('vv_default_thumb');
	echo '<div class="property_img_left"><div class="img-medium"><a id="fancybox-image" href="'.$large.'" onclick="return false;" title="'.$title.'"><img src="'.$thumb.'" alt=""></a></div></div>
			<div class="clear"></div>';
			
}


function property_image_gallery($gallery, $options = array() ){
	global $post;
//	$pendinghash = get_post_custom_values('wpp_feps_pending_hash',$post->ID);	
//	$myurl = site_url();
//	$permlink = $myurl . '/?post_type=property&p='.$post->ID.'&wpp_front_end_action=wpp_view_pending&pending_hash='.$pendinghash[0];
//	echo $permlink;


	$thumb='';$large='';
	$optarray = array('echo' => false, 'size' => 'thumbnail', 'skipfirst' => true, 'skiphelp' => true, 'add_description_field' => false, 'post_id' => 0  );
	$options = array_init($optarray, $options );

	$post_thumbnail_id = get_post_thumbnail_id( $options['post_id'] );
	if( isset($gallery ) && !empty($gallery) ){
		if( $options['skiphelp'] ) echo '<p class="txt_clickimage"><em>CLICK IMAGE FOR LARGER VIEW [+]</em></p><br />';
		$c=0;
		foreach($gallery as $image ){
				$large=$image['large'];
				$thumb=$image[$options['size']];
				$thumb = ( !empty( $thumb ) )?$thumb:get_option('vv_default_thumb');
				if( is_admin() ) echo '<div class="image_container">';
				echo '<div class="property_img_left"><div class="img-medium"><a rel="fancybox-valuvet" class="fancybox-image" href="'.$large.'" onclick="return false;" title="'.$image['post_title'].'"><img src="'.$thumb.'" alt=""></a></div>';
				if( !empty( $image["post_title"] ) ) echo $image["post_title"];
				echo '</div>';
				if( $options['add_description_field'] ){
					echo '<br />Title : <input type="text" name="file_description['.$image["attachment_id"].']" maxlength="50" size="20" value="'.$image["post_title"].'"/>';
					echo '<br /><input type="checkbox" name="delete_image[]" value="'.$image["attachment_id"].'" /> Delete';
					echo '<br /><input type="radio" name="set_featured" ';
					if($post_thumbnail_id==$image["attachment_id"] ) echo ' checked="checked"' ;
					echo ' value="'.$image["attachment_id"].'" /> Set as featured image';
				}
				if( is_admin() ) echo '</div>';
			$c++;
		}
	}
}


function pack1_overview(){
	global $post;
	$output = $post->type_of_practice ;
	if( !empty( $post->type_of_practice_other ) )  $output .= $post->type_of_practice_other ;
}

function google_map_address( $post ){
	$post=(array)$post;
	$business_address = get_post_custom_values('business_address', $post['ID']);
	$suburb = get_post_custom_values('suburb', $post['ID']);
	$post_code = get_post_custom_values('post_code', $post['ID']);
	$practice_state = get_post_custom_values('practice_state', $post['ID']);
	return $business_address[0] . ' ' .$suburb[0] .  ' ' .$practice_state[0] . ' ' .$post_code[0]  . ' Australia';
}


function map_address( $post ){
	$post=(array)$post;
	$business_address = get_post_custom_values('business_address', $post['ID']);
	$suburb = get_post_custom_values('suburb', $post['ID']);
	$post_code = get_post_custom_values('post_code', $post['ID']);
	$practice_state = get_post_custom_values('practice_state', $post['ID']);
	return $business_address[0] . ' ' .$suburb[0] .  ' ' .$post_code[0] . ' ' . $practice_state[0] ;
}

function set_map_coordinates( $postid,  $address ){
    $url = str_replace(" ", "+" ,"http://maps.google.com/maps/api/geocode/json?address={$address}&sensor=false");
    $obj = (json_decode(wp_remote_fopen($url)));
   	$results = $obj->results;
    $results_object = $results[0];
	$geo = $results_object->geometry;
	$cordinate = $geo->location;
	
    update_post_meta($postid, 'latitude', $cordinate->lat );
    update_post_meta($postid, 'longitude', $cordinate->lng );
}

function set_cordinates( $post=NULL ){
	global $post;
	$address = google_map_address($post);
	set_map_coordinates( $post->ID,  $address );
}
add_action('save_post', 'set_cordinates');


function google_map_popup( $post ){
	?>
	<div style="display:none;">
    	<div id="google_map">
        </div>
    </div>
    <?php
}


function listing_views( $post_id ){
	$views = get_post_meta( $post_id, 'property_views' , true );
	if( !$views ) $views=0;
	(int)$views++;
	update_post_meta( $post_id , 'property_views', $views );
}


function property_cron_run(){
	$s = get_option('system_secure_cron');
	if( isset($_GET['s']) && $_GET['s']==$s ){
		
	}
}

function get_property_renew_date( $post_date ){
	$list_until = get_option('listing_validity');
	$renewdate =  date( 'Y-m-d H:i:s', strtotime( $post_date . " + ".$list_until." days" ) );
	return $renewdate;
}

function get_renewed_status_by_date( $post_date ){
	$list_until = get_option('listing_validity');
	$notify=get_option('property_listing_notification_1');
	$today = strtotime( date('Y-m-d H:i:s' ) );
	$end = strtotime( $post_date );
	$days_between = ceil(abs($today - $end) / 86400);
	if( $days_between>( 365-$notify) ) return true;
	return false;
}

function get_renewal_link( $post ){
//	delete_post_meta( $post->ID, 'renew_status' );
	$renew_status = get_post_meta( $post->ID, 'renew_status' , true );
	$renew_status_bydate = get_renewed_status_by_date( $post->post_date );
	$permlink = '';
	if(	$renew_status!='Yes' && $renew_status_bydate ){
		$myurl = site_url();
		$pendinghash = get_post_custom_values('wpp_feps_pending_hash',$post->ID);
		$permlink = $myurl . '/?page_id='.$post->ID.'&wpp_front_end_action=wpp_view_pending&pending_hash='.$pendinghash[0];
	 }
	return $permlink;
}

function send_renew_initiate_email( $postid ){
	$post = get_post( $postid );
	$author_email = get_the_author_meta( 'user_email' , $post->post_author);
	$first_name = get_the_author_meta( 'first_name' , $post->post_author);
	$last_name = get_the_author_meta( 'last_name' , $post->post_author);
	$myurl = site_url();
	$pendinghash = get_post_custom_values('wpp_feps_pending_hash',$post->ID);
	$permlink = $myurl . '/?page_id='.$post->ID.'&wpp_front_end_action=wpp_view_pending&pending_hash='.$pendinghash[0];
	$renewdate = get_property_renew_date( $post->post_date );

	$notify_data = array(
						 '{AUTHOR_EMAIL}' => $author_email,
						 '{AUTHOR_FIRST_NAME}' => $first_name,
						 '{AUTHOR_LAST_NAME}' => $last_name,
						 '{POST_ID}' => $post->ID,
						 '{POST_LINK}' => $permlink,
						 '{RENEW_DATE}' => $renewdate,
						 '{AUTHOR_PROPERTY_TITLE}' => $post->post_title
						 );
	$data = get_valuvet_notify_email_template( 'notify_renewal_for_customer', $notify_data );
	$header =  "From: $bloginfo <$admin_email>\n"; 
	wp_mail($author_email, sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header);
	
	$data = get_valuvet_notify_email_template( 'notify_renewal_for_admin', $notify_data );
	$header =  "From: $bloginfo <$admin_email>\n"; 
	wp_mail($author_email, sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header);
}


function get_post_for_notification( $where ){
    global $wpdb,$datehigher, $datelower;
    $where .= $wpdb->prepare( " AND post_date > %s AND post_date <= %s ", $datelower, $datehigher  );
    return $where;
}


function wpe_send_emails( $notification, $author_email,  $notify_data  ){
	$bloginfo = get_bloginfo( 'name' );
	$admin_email = get_bloginfo( 'admin_email' );
	
	
	$data = get_valuvet_notify_email_template( $notification, $notify_data );
	$header =  "From: $bloginfo <$admin_email>\n"; // header for php mail only
	wp_mail($author_email, sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header);
}


function wppe_get_post_notification_data( $post ){
	$author_email = get_the_author_meta( 'user_email' , $post->post_author);
	$first_name = get_the_author_meta( 'first_name' , $post->post_author);
	$last_name = get_the_author_meta( 'last_name' , $post->post_author);
	$myurl = site_url();
	$pendinghash = get_post_custom_values('wpp_feps_pending_hash',$post->ID);
	$permlink = $myurl . '/?page_id='.$post->ID.'&wpp_front_end_action=wpp_view_pending&pending_hash='.$pendinghash[0];

	$data = array(
						 '{AUTHOR_EMAIL}' => $author_email,
						 '{AUTHOR_FIRST_NAME}' => $first_name,
						 '{AUTHOR_LAST_NAME}' => $last_name,
						 '{RENEW_LISTING_LINK}' => $permlink,
						 '{POST_ID}' => $post->ID,
						 '{POST_LINK}' => $permlink,
						 '{AUTHOR_PROPERTY_TITLE}' => $post->post_title
						 );
	return $data;
}


function send_expire_notification( $notification, $post, $options){
	global $wpdb;
	global $notify_data;

	$defaults = array( '{EXPIRE_IN}' => '' );
	$options = wp_parse_args($options, $defaults);
		
	$this_data = wppe_get_post_notification_data( $post );
	$note_data = array_merge( $this_data, $options );
	$data = get_valuvet_notify_email_template( $notification, $note_data );
	$header =  "From: ".$notify_data['{BLOG_INFO}']."<".$notify_data['{ADMIN_EMAIL}'].">\n"; // header for php mail only
	wp_mail( $this_data['{AUTHOR_EMAIL}'], sprintf(__('%s '.$data['subject'] ), $notify_data['{BLOG_INFO}'] ), $data['message'], $header);
}

function cron_check(){
	global $datehigher, $datelower;

	//MAKE SURE CRON URL HAVE ?s=s ON IT
	if( isset($_REQUEST['s'] ) ) {
		//check 1st notification
		$list_until = get_option('listing_validity');
		$notify[0]=get_option('property_listing_notification_3');
		$notify[1]=get_option('property_listing_notification_2');
		$notify[2]=get_option('property_listing_notification_1');
		$today=date('Y-m-d H:i:s');

		foreach( $notify as $key => $value ){
			$chkdate = $list_until - $value;
			$next = ( $key>0 ) ? ( $notify[$key-1] ) : 0 ;
			$lowervalue = $list_until - $next ;
			$datehigher = date( 'Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s' ) . " - ".$chkdate." day" ) );
			$datelower =  date( 'Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s' ) . " - ".$lowervalue." day" ) );
			$args = $args = array(
				'numberposts'     => -1,
				'orderby'         => 'post_date',
				'order'           => 'DESC',
				'post_type'       => 'property',
				'suppress_filters' => false,
				'post_status'     => 'publish' ); 
			add_filter( 'posts_where', 'get_post_for_notification' );
			$posts_array = get_posts( $args );
			// Important to avoid modifying other queries
			remove_filter( 'posts_where', 'get_post_for_notification' );
			
			foreach( $posts_array as $post ){
				$renew_status = get_post_meta( $post->ID, 'renew_status' , true );
				if( $renew_status!='Yes' ){
					$lastnotification=get_post_meta( $post->ID, 'expire_notification' , true );
					switch ( $key ){
						case 0:
							update_post_meta( $post->ID, 'expire_notification', '3' );
							if( $lastnotification!=3 ){
								send_expire_notification('third_expire_notification', $post, array( "{EXPIRE_IN}" => $value) );
							}
							break;
						case 1:
							update_post_meta( $post->ID, 'expire_notification', '2' );
							if( $lastnotification!=2 ){
								send_expire_notification('second_expire_notification', $post, array( "{EXPIRE_IN}" => $value));
							}
							break;
						default:
							update_post_meta( $post->ID, 'expire_notification', '1' );
							if( $lastnotification!=1 ){
								send_expire_notification('first_expire_notification', $post, array( "{EXPIRE_IN}" => $value));
							}
							break;
					}
				}
			}
		}
		suspend_account();
	}
}

function get_post_for_suspend( $where ){
    global $wpdb,$suspenddate;
    $where .= $wpdb->prepare( " AND post_date < %s", $suspenddate  );
    return $where;
}



function suspend_account(){
	global $suspenddate, $todo_class;
	
	$list_until = get_option('listing_validity');
	$suspenddate = date( 'Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s' ) . " - ".$list_until." day" ) );
	$args = $args = array(
		'numberposts'     => -1,
		'orderby'         => 'post_date',
		'order'           => 'DESC',
		'post_type'       => 'property',
		'suppress_filters' => false,
		'post_status'     => 'publish' );
	add_filter( 'posts_where', 'get_post_for_suspend' );
	$posts_array = get_posts( $args );
	remove_filter( 'posts_where', 'get_post_for_suspend' );
	foreach( $posts_array as $post ){
		$renew_status = get_post_meta( $post->ID, 'renew_status' , true );
		$author_email = get_the_author_meta( 'user_email' , $post->post_author);
		$first_name = get_the_author_meta( 'first_name' , $post->post_author);
		$last_name = get_the_author_meta( 'last_name' , $post->post_author);
		$myurl = site_url();
		$pendinghash = get_post_custom_values('wpp_feps_pending_hash',$post->ID);
		$permlink = $myurl . '/?post_type=property&p='.$post->ID.'&wpp_front_end_action=wpp_view_pending&pending_hash='.md5( $post->ID.$post->post_author );
	
		$notify_data = array(
							 '{AUTHOR_EMAIL}' => $author_email,
							 '{AUTHOR_FIRST_NAME}' => $first_name,
							 '{AUTHOR_LAST_NAME}' => $last_name,
							 '{RENEW_LISTING_LINK}' => $permlink,
							 '{POST_ID}' => $post->ID,
							 '{POST_LINK}' => $permlink,
							 '{AUTHOR_PROPERTY_TITLE}' => $post->post_title
							 );
		if( $renew_status!='Yes' ){
			suspend_property( $post->ID );
			$addtodo = array(
				'todo_title'       => 'Property listing canceled.( Not renewed ) ',
				'todo_propertyid'  => $post->ID );
			$todo_class->insert_todo_item($addtodo);
			$notification = 'property_listing_cancelation_email';
		} else {
			renew_property_submition( $post->ID );
			delete_post_meta( $post->ID, 'renew_status' );
			$addtodo = array(
				'todo_title'       => 'Property listing renewed.',
				'todo_propertyid'  => $post->ID );
			$todo_class->insert_todo_item($addtodo);
			$notification = 'property_listing_renew_email';
		}
		wpe_send_emails( $notification , $author_email,  $notify_data  );
	}
}

function renew_property_submition( $propertyid ){
	$my_post = array();
	$my_post['ID'] = $propertyid;
	$my_post['post_status'] = 'publish';
	$my_post['post_date'] = date('Y-m-d H:i:s');
	wp_update_post( $my_post );	
	$renew_status = get_post_meta( $propertyid, 'renew_status' , true );
	if( !empty($renew_status) )	delete_post_meta( $propertyid, 'renew_status' );
}

function suspend_property( $propertyid ){
	$my_post = array();
	$my_post['ID'] = $propertyid;
	$my_post['post_status'] = 'Archived';
	wp_update_post( $my_post );
	delete_post_meta( $propertyid, 'PAYPAL_TOKEN' );
	$renew_status = get_post_meta( $propertyid, 'renew_status' , true );
	update_post_meta( $propertyid, 'payment_status', 'Not paid' );
	if( !empty($renew_status) )	delete_post_meta( $propertyid, 'renew_status' );
}


add_action("init", "wppe_init");



function wppe_show_suburbs(){
	global $wpdb, $auscode_class;
	$suburb = $_POST["suburb"];
	$found = array();
	if ( is_string($suburb) ){
		$found = $auscode_class->get_locality_list( $suburb );
		die( json_encode( $found ) );
	} 
	die();
}

add_action("wp_ajax_wppe_show_suburblist", 'wppe_show_suburbs' );
add_action("wp_ajax_nopriv_wppe_show_suburblist", 'wppe_show_suburbs' );

function convert_to_object($array_to_convert){
	$myObject = (object) $array_to_convert;
	return $myObject;
}

function show_google_map(){
	global $post,$wp_properties;
	$property = WPP_F::get_property( $_GET["property"] );
	$post=convert_to_object($property);?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Google Maps</title>
	<script type='text/javascript' src='<?php bloginfo('url')?>/wp-includes/js/jquery/jquery.js?ver=1.7.1'></script>
	<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=true&#038;ver=3.3.1'></script>
    <link href="<?php bloginfo('url')?>/wp-content/plugins/wp-property/templates/wp_properties.css" type="text/css" rel="stylesheet">
    <link href="<?php bloginfo('template_directory'); ?>/style.css" type="text/css" rel="stylesheet">
  </head>
  <body>
					<?php if(WPP_F::get_coordinates()): ?>
                    	<div id="property_map_link">
                    		<div id="property_map" style="width:100%; height:500px;"></div>
                        </div>
                    <?php endif; ?>
<script type="text/javascript">
                var map;
                var marker;
                var infowindow;
                jQuery(document).ready(function() {
                  if(typeof jQuery.fn.fancybox == 'function') {
                    jQuery("a.fancybox_image, .gallery-item a").fancybox({
                      'transitionIn'  :  'elastic',
                      'transitionOut'  :  'elastic',
                      'speedIn'    :  600,
                      'speedOut'    :  200,
                      'overlayShow'  :  false
                    });
                  }
                  if(typeof google == 'object') {
                    initialize_this_map();
                  } else {
                    jQuery("#property_map").hide();
                  }
                });
              function initialize_this_map() {
                <?php if($coords = WPP_F::get_coordinates()): ?>
                var myLatlng = new google.maps.LatLng(<?php echo $coords['latitude']; ?>,<?php echo $coords['longitude']; ?>);
                var myOptions = {
                  zoom: <?php echo (!empty($wp_properties['configuration']['gm_zoom_level']) ? $wp_properties['configuration']['gm_zoom_level'] : 13); ?>,
                  center: myLatlng,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("property_map"), myOptions);
                infowindow = new google.maps.InfoWindow({
                  content: '<?php echo WPP_F::google_maps_infobox((array)$post); ?>',
                  maxWidth: 500
                });
                 marker = new google.maps.Marker({
                  position: myLatlng,
                  map: map,
                  title: '<?php echo addslashes($post->post_title); ?>',
                  icon: '<?php echo apply_filters('wpp_supermap_marker', '', $post->ID); ?>'
                });
                google.maps.event.addListener(infowindow, 'domready', function() {
                document.getElementById('infowindow').parentNode.style.overflow='hidden';
                document.getElementById('infowindow').parentNode.parentNode.style.overflow='hidden';
               });
               setTimeout("infowindow.open(map,marker);",1000);
                <?php endif; ?>
              }
              </script>
  </body>
</html>    <?php
	die();
	exit();
}


function display_map(){
	if( isset( $_GET['gmap'] ) && !empty( $_GET['gmap'] ) ){
		show_google_map();
	}
}
add_action("template_redirect", "display_map");



function wppe_draw_pagination( $settings = '' ){
    global $wpp_query, $wp_properties;

    if(is_array($wpp_query) || is_object($wpp_query)) {
      extract($wpp_query);
    }

    //** Do not show pagination on ajax requests */
    if($wpp_query['ajax_call']) {
      return;
    }

    if($pagination == 'off' && $hide_count) {
      return;
    }
    if($properties['total'] > $per_page && $pagination != 'off') {
      $use_pagination = true;
    }

    if ( $properties['total'] < 2 || $sorter_type == 'none') {
      $sortable_attrs = false;
    }
    ob_start(); ?>
    <div class="properties_pagination <?php echo $settings['class']; ?> wpp_slider_pagination" id="properties_pagination_<?php echo $unique_hash; ?>">
      <div class="wpp_pagination_slider_status">
        <?php if($hide_count != 'true') { ?>
          <span class="wpp_property_results"><?php echo ($properties['total'] > 0 ? WPP_F::format_numeric($properties['total']) : __('None', 'wpp')); ?></span>
          <?php _e(' found.', 'wpp'); ?>
        <?php } ?>
        <?php if($use_pagination) { ?>
        <?php _e('Viewing page', 'wpp'); ?> <span class="wpp_current_page_count"><?php echo $wpp_query["current_page"]?></span> <?php _e('of', 'wpp'); ?> <span class="wpp_total_page_count"><?php echo $pages; ?></span>.
        <?php } ?>
      </div>
      <div class="wpp_pagination_search">
      <form action="<?php echo get_option('property_overview_page')?>" method="get" id="searchform">
      
      <?php	  $practice_state = $wpp_query["query"]["practice_state"]; ?>
      <input type="hidden" name="wpp_search[pagination]" value="on" >
      <input type="hidden" name="p" value="property" >
		Sort By : No of vets 
      <select name="wpp_search[number_of_fulltime_vet_equivalents_40_hrs]" id="noof_vets" class="small step5p" onChange="document.getElementById('searchform').submit();">
			<option selected="selected" value="">Select --&gt;</option>
          <option value="1"<?php if( isset($wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]) && $wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]=='1' )  echo '  selected="selected"' ?>>1</option>
          <option value="1-2"<?php if( isset($wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]) && $wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]=='1-2' )  echo '  selected="selected"' ?>>1-2</option>
          <option value="2+"<?php if( isset($wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]) && $wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]=='2+' )  echo '  selected="selected"' ?>>2+</option>
          <option value="2-3"<?php if( isset($wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]) && $wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]=='2-3' )  echo '  selected="selected"' ?>>2-3</option>
          <option value="3+"<?php if( isset($wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]) && $wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]=='3+' )  echo '  selected="selected"' ?>>3+</option>
          <option value="3-4"<?php if( isset($wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]) && $wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]=='3-4' )  echo '  selected="selected"' ?>>3-4</option>
          <option value="4+"<?php if( isset($wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]) && $wpp_query["query"]["number_of_fulltime_vet_equivalents_40_hrs"]=='4+' )  echo '  selected="selected"' ?>>4+</option>
      </select>
      &nbsp;&nbsp;&nbsp;&nbsp; State : &nbsp;&nbsp;
                                        <select name="wpp_search[practice_state]" id="practice_state" onChange="document.getElementById('searchform').submit();">
                                            <option<?php if( isset($wpp_query["query"]["practice_state"]) && $wpp_query["query"]["practice_state"]=='' )  echo '  selected="selected"' ?> value="">View All</option>
                                            <option<?php if( isset($wpp_query["query"]["practice_state"]) && $wpp_query["query"]["practice_state"]=='ACT' )  echo '  selected="selected"' ?>>ACT</option>
                                            <option<?php if( isset($wpp_query["query"]["practice_state"]) && $wpp_query["query"]["practice_state"]=='NSW' )  echo '  selected="selected"' ?>>NSW</option>
                                            <option<?php if( isset($wpp_query["query"]["practice_state"]) && $wpp_query["query"]["practice_state"]=='NT' )  echo '  selected="selected"' ?>>NT</option>
                                            <option<?php if( isset($wpp_query["query"]["practice_state"]) && $wpp_query["query"]["practice_state"]=='QLD' )  echo '  selected="selected"' ?>>QLD</option>

                                            <option<?php if( isset($wpp_query["query"]["practice_state"]) && $wpp_query["query"]["practice_state"]=='SA' )  echo '  selected="selected"' ?>>SA</option>
                                            <option<?php if( isset($wpp_query["query"]["practice_state"]) && $wpp_query["query"]["practice_state"]=='TAS' )  echo '  selected="selected"' ?>>TAS</option>
                                            <option<?php if( isset($wpp_query["query"]["practice_state"]) && $wpp_query["query"]["practice_state"]=='VIC' )  echo '  selected="selected"' ?>>VIC</option>
                                            <option<?php if( isset($wpp_query["query"]["practice_state"]) && $wpp_query["query"]["practice_state"]=='WA' )  echo '  selected="selected"' ?>>WA</option>
                                         </select>
      </form>
      </div>
       <div class="clear"></div>
      
      <?php if($use_pagination) { ?>
      <div class="wpp_pagination_slider_wrapper">
		<?php if( $wpp_query["current_page"]>1 ){
			$pre_query = ( strstr( $_SERVER['QUERY_STRING'], 'wpp_search[requested_page]='.$wpp_query["current_page"] ) ) ? str_replace('wpp_search[requested_page]='.$wpp_query["current_page"], 'wpp_search[requested_page]='.( $wpp_query["current_page"]-1),$_SERVER['QUERY_STRING'] ) : $_SERVER['QUERY_STRING'].'&wpp_search[requested_page]='.($wpp_query["current_page"]-1);
			?>
        <a href="<?php echo bloginfo('url') .'/?'. $pre_query; ?>"><div class="wpp_pagination_back wpp_pagination_button"><?php _e('Prev', 'wpp'); ?></div></a>
        <?php } ?>
		<?php if( $wpp_query["current_page"]<$wpp_query["pages"] ){ 
			$pre_query = ( strstr( $_SERVER['QUERY_STRING'], 'wpp_search[requested_page]='.$wpp_query["current_page"] ) ) ? str_replace('wpp_search[requested_page]='.$wpp_query["current_page"], 'wpp_search[requested_page]='.( $wpp_query["current_page"]+1),$_SERVER['QUERY_STRING'] ) : $_SERVER['QUERY_STRING'].'&wpp_search[requested_page]='.($wpp_query["current_page"]+1);
		?>
        <a href="<?php echo bloginfo('url') .'/?'. $pre_query; ?>"><div class="wpp_pagination_forward wpp_pagination_button"><?php _e('Next', 'wpp'); ?></div></a>
        <?php } ?>
      </div>
             <div class="clear"></div>
      <?php } ?>
    </div>
    <?php
    $html_result = ob_get_contents();
    ob_end_clean();

    //** Combine JS (after minification) with HTML results */
    $js_result = WPP_F::minify_js($js_result);
    $result = $js_result . $html_result;

    if($settings['return'] == 'true') {
      return $result;
    }
    echo $result;
}

function create_property_title( $post ){
	$pst = ( is_object( $post ) )?(array)$post:$post;
	return $pst["practice_is_for"].' '. $pst["type_of_practice"] .' '. $pst["suburb"];
}

function wppe_wpp_get_search_filters( $values ){
	global $user_level;
	if( $user_level<10 ){
		unset( $values["post_author"] );
		foreach( $values["post_status"]["values"] as $key => $value ){
			$tmp = explode( " ", $value );
			$values["post_status"]["values"][$key] = $tmp[0];
		}
	}
	return $values;
}


function wpe_alter_package_on_renewal(){
	
}