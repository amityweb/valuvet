<?php get_header(); ?>

<div id="content">
    
   <div id="main_content">
        	<?php
		$page_id = 8;
		$page_data = get_page( $page_id );
		$content = apply_filters('the_content', $page_data->post_content); 
		echo $content;
		
		edit_post_link( 'Edit this entry', '', '', 8 ); 
		?>
     
       	</div>
</div>
<?php /*?><?php get_sidebar(); ?><?php */?>

<?php get_footer(); ?>
