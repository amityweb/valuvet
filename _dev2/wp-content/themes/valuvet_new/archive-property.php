<?php get_header(); ?>
			<?php 
			if ( have_posts() ) : the_post();
				global $user_level; 
				
				if( isset( $_GET['wpp_front_end_action'] ) && $_GET['wpp_front_end_action']=='wpp_view_pending' && $post->payment_status ) load_paypal();
				?>
				<?php if( $user_level>='10' && $post->post_status!='publish' )	valuvet_show_admin_info();?>
                
				<ul id="headline"><li><span class="button_left"><?php valuvet_property_state_full($post->practice_state)?> - <?php valuvet_get_property_ID();?></span> <span class="button_right"><?=valuvet_posted_on()?></span></li></ul>
                
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