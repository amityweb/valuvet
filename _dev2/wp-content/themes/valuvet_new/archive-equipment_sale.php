<?php get_header(); ?>
			<?php if ( have_posts() ) : the_post();?>
            <?php if( !isset( $equipment_class ) ) $equipment_class = new equipment_class(); ?>
				<?php while ( have_posts() ) : the_post(); ?>
                <?php var_dump( $post ); ?>ll
				<ul id="headline"><li><span class="button_left"><?php valuvet_property_state_full($post->practice_state)?> - <?php echo $equipment_class->get_equipment_ID( $post->ID );?></span> <span class="button_right"><?=valuvet_posted_on()?></span></li></ul>
                
                
					<table id="listing" border="0" width="100%">
                    <tr>
                    <td colspan="2"><h1><?php echo $post->post_title; ?></h1>
                    <hr/></td></tr>
                    
                    <tr><td>
                     <?php 
					 if( has_post_thumbnail( $post->ID ) ){
						$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
						echo '<div class="property_img_left"><div class="img-medium"><a id="fancybox-image" href="'.$large_image_url[0].'" onclick="return false;" title="'.$post->post_title.'">'. get_the_post_thumbnail($post->ID, 'thumbnail', $default_attr) .'</a></div></div>';
					 }
					?>
                    </td>
                    <td><h3>Contact</h3>
                    <p><?php get_further_info( 'title_name', (array)$post );?><br /><?php get_further_info('phone', (array)$post );?></p>
                    
                    <p>Email: <script language=javascript>
                      <!--
                      var contact = "CLICK TO EMAIL";
                      var email<?php echo $post->ID; ?> = "<?php get_further_info( 'email', (array)$post)?>";
                      var emailSubject<?php echo $post->ID; ?> = "<?php echo $post->post_title; ?>";
                      document.write('<a href="#contact_popup" id="cpopup_<?php echo $post->ID; ?>" class="fancybox-contact">' + contact + '</a>')
						jQuery(document).ready(function($) {
								jQuery('#cpopup_'+<?php echo $post->ID; ?>).click(function() { //start function when Random button is clicked
									$("#cform_msg").html(''); 
								  document.getElementById('myemail').value = email<?php echo $post->ID; ?>;
								  document.getElementById('mysubject').value = emailSubject<?php echo $post->ID; ?>;
							});
						});
                      //-->
                    </script></p>
                    </td>
                    </tr>
                    <tr>
                      <td>
                    <h2>Asking Price: AUS $ <?php echo $equipment_class->get_eqfs_postmeta_value( (array)$post, 'equipment_price');?></h2>
                    </td>
                      <td>&nbsp;</td>
                    </tr>
                    </table>
                
				<?php endwhile; // End the loop. Whew. ?>
                
                <?php valuvet_page_nav('bottom');?>
                <?php include_once('property_contact_form.php')?>
			<?php else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
            
<?php get_footer(); ?>