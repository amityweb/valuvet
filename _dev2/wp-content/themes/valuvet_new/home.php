<?php /* Template Name: HomePage
*/ ?>
<?php get_header(); ?>
	

<div id="content">
    
   <div id="main_content">
        	<?php
		$page_id = get_option('vv_home_page_content_id');
		$page_data = get_page( $page_id );
		$content = apply_filters('the_content', $page_data->post_content); 
		echo $content;
		edit_post_link( 'Edit this entry', '', '', 8 ); 
		?>
     
       	</div>
</div>

<?php get_footer(); ?>