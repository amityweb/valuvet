<?php get_header(); ?>
			<?php 
			if ( have_posts() ) : the_post();
				global $user_level; 
				$current_user = wp_get_current_user();
				$renew_status = get_post_meta( $post->ID, 'renew_status' , true );
				if( isset($_SESSION['paypal_message']) ){
					echo '<div class="paypal_container">';
					echo $_SESSION['paypal_message'];
					echo '</div>';
					unset( $_SESSION['paypal_message'] );
				}
				
				$renew_status_bydate = get_renewed_status_by_date( $post->post_date );
				$pendinghash = get_post_custom_values('wpp_feps_pending_hash',$post->ID);
				
				if( ( ( ( !$post->payment_status || $post->payment_status=='Not paid' && isset( $_REQUEST['wpp_front_end_action'] ) ) || ( $post->payment_status=='Paid' && get_renewed_status_by_date( $post->post_date ) && $renew_status!='Yes' ) ) && is_user_logged_in() &&  $current_user->ID==$post->author) || ( $post->payment_status!='Paid' && isset($_REQUEST['wpp_front_end_action'])  && $renew_status!='Yes' && $_REQUEST['wpp_front_end_action']=='wpp_view_pending' ) || (  isset($_REQUEST['wpp_front_end_action'])  && $_REQUEST['wpp_front_end_action']=='wpp_view_pending' && $renew_status_bydate && isset($_REQUEST['pending_hash']) && $_REQUEST['pending_hash']==$pendinghash[0] )  ) {
					load_paypal();
				}
				?>

                <?php $option = array( 'ID' => $post->ID, 'property_type' => $post->property_type, 'practice_state' => $post->practice_state );?>
                
    			<?php include_once('property_contact_form.php')?>                
				<ul id="headline"><li><span class="button_left"><?php valuvet_property_state_full($post->practice_state)?> - <?php valuvet_get_property_ID( $option );?></span> <span class="button_right"><?=valuvet_posted_on()?></span></li></ul>
                
            <?php if( $post->property_type=='package_3'  ){
					package_3();
				} elseif( $post->property_type=='package_2'  ) {
					package_2();
				} else { 
					package_1();
				}  
				?>
			<?php else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
            
<?php get_footer(); ?>