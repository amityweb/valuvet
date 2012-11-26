<?php 
	if(isset($_POST) && $_POST['formtype']=="enewsletter_subscribe" && $_POST['s_email'] !='')
	{
		if($_POST['newsletter_unsubscribe'] != 'un_subscribe'){
		$date = date("Y-m-d H:i:s");
		 $confkey =md5(uniqid(rand().rand().rand(),1));
		$datas = array("email" => $_POST['s_email'],
                              "name" => $_POST['s_fullname'],
                              "id_categoria" => 1,
                              "direction" => false,
                              "enterprise" => null,
                              "country"=>null,
                              "direction" => null,
                              "state" => 2,
							  "confkey" => $confkey,
                              "joined" => $date);
							  
		$wpdb->insert( 'wp_meenewsusers', $datas);
		}else{
			
			$wpdb->update( 'wp_meenewsusers', array( 'state' => 1 ),
            array( 'email' => $_POST['s_email'] ) );
			}
	}
	
	?>
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
<?php get_footer(); ?>
