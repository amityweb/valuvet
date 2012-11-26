<?php get_header(); ?>
	
			<?php 
			
			if ( have_posts() ) : the_post(); 
			
			?>    
           
           	<div id="center_content_top"></div>
            <div id="center_content">
                        	
            	<p>
                <?php echo the_content();?>
                </p>
            
            </div>
       	  	<div id="center_content_bottom"></div>
            <?php edit_post_link();?>
			<?php else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
            

<?php get_footer(); ?>