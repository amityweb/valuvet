<?php

class equipment_class{
	function equipment_class(){
	}

	function equipment_ini_class(){
		global $wp_roles,$submenu;
	  // Add new taxonomy, make it hierarchical (like categories)
	  $labels = array(
		'name' => _x( 'Equipment category', 'Equipment Category' ),
		'singular_name' => _x( 'Equipment Category', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search equipment category' ),
		'all_items' => __( 'All equipment categories' ),
		'parent_item' => __( 'Parent category' ),
		'parent_item_colon' => __( 'Parent category:' ),
		'edit_item' => __( 'Edit category' ), 
		'update_item' => __( 'Update category' ),
		'add_new_item' => __( 'Add New category' ),
		'new_item_name' => __( 'New Category' ),
		'menu_name' => __( 'Categories' ),
	  ); 	
	
	  register_taxonomy('equipment_category',array('equipment_sale'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
        'capabilities' => array('manage_terms' => 'manage_equipment_category'),
		'rewrite' => array( 'slug' => 'equipment_category' ),
	  ));
		

		$equpments['labels'] = apply_filters('Equipment sales', array(
		  'name' => __('Equipment sales', 'eqfs'),
		  'all_items' =>  __( 'All Equipments', 'eqfs'),
		  'singular_name' => __('Equipments_for_sale', 'eqfs'),
		  'add_new' => __('Add Equipment Sale', 'eqfs'),
		  'add_new_item' => __('New Equipment Sale','eqfs'),
		  'edit_item' => __('Edit Equipment Sale','eqfs'),
		  'new_item' => __('New Equipment Sale','eqfs'),
		  'view_item' => __('View  Equipment Sale','eqfs'),
		  'search_items' => __('Search Equipment Sale','eqfs'),
		  'not_found' =>  __('No Equipment Sales found','eqfs'),
		  'not_found_in_trash' => __('No Equipment Sales found in Trash','eqfs'),
		  'parent_item_colon' => ''
		));
		
		$args = array(
		  'labels' => $equpments['labels'],
			'singular_label' => __('Equipment sales'),
			'public' => true,
			'has_archive' => true,
			'show_ui' => true,
			'menu_icon' => EQU_URL . 'images/equipments-icon.png',
			'hierarchical' => false,
			'capability_type' => 'equipment_sale',
			'capabilities' =>	array(
								  'edit_equipment_sales' => true,
								  'edit_others_equipment_sales' => true,
								  'publish_equipment_sales' => true,
								  'publish_equipment_sale' => true,
								  'read_private_equipment_sales' => true,
								  'read_private_equipment_sale' => true, 
								  'read_equipment_sales' => true, 
								  'read_equipment_sale' => true, 
								  'edit_published_equipment_sales' => true, 
								  'delete_others_equipment_sales' => true , 
								  'delete_published_equipment_sales' => true, 
								  'delete_others_equipment_sales' => true
								),
			'rewrite' => true,
//			'taxonomy' => array('equipment_category'),
			'supports' => array('title', 'thumbnail' )
		);
		register_post_type( 'equipment_sale' , $args );
		equipment_class::set_capabilities();
		equipment_class::set_capabilities_commonsubscriber();
	}
	
	
	function eqfs_map_meta_cap( $caps, $cap, $user_id, $args ) {
   	global $current_user;
		/* If editing, deleting, or reading a equipment, get the post and post type object. */
		if ( 'edit_equipment_sale' == $cap || 'read_equipment_sale' == $cap  ) {
			$post = get_post( $args[0] );
			$post_type = get_post_type_object( $post->post_type );
			/* Set an empty array for the caps. */
			$caps = array();
		}

	   if ( 'edit_equipment_sales' == $cap || 'edit_equipment_sales' == $cap ) {
			
			if ( $user_id == $post->post_author ) {
				$caps[] = $post_type->cap->edit_posts;
				$caps[] = $post_type->cap->edit_post;
			}
				
		} elseif ( 'read_equipment_sale' == $cap ) {
	
			if ( 'private' != $post->post_status )
				$caps[] = 'read';
			elseif ( $user_id == $post->post_author )
				$caps[] = 'read';
			else
				$caps[] = $post_type->cap->read_private_posts;
				
		}  elseif(  'view_equipment_sale' == $cap  ){
			if ( $user_id == $post->post_author )
				$caps[] = $post_type->cap->view_post;
			else
				$caps[] = $post_type->cap->view_post;
		}
	
		/* Return the capabilities required by the user. */
		return $caps;
	}
	
  function set_capabilities() {
    global $eqfs_capabilities;

    //* Get Administrator role for adding custom capabilities */
    $role =& get_role('administrator');
    //* General WPP capabilities */
    $eqfs_capabilities = array(
      'edit_equipment_sales' => true,
      'edit_others_equipment_sales' => true,
	  'publish_equipment_sales' => true,
	  'read_private_equipment_sales' => true,
	  'read_equipment_sales' => true,
	  'read_equipment_sale' => true,
	  'edit_published_equipment_sales' => true, 
	  'edit_published_equipment_sale' => true,
	  'delete_others_equipment_sales' => true , 
	  'delete_published_equipment_sales' => true, 
	  'delete_others_equipment_sales' => true,
	  'manage_equipment_settings'  => true,  
	  'manage_equipment_category' => true
    );

    if(!is_object($role)) {
      return;
    }
    foreach($eqfs_capabilities as $cap => $value){
      if ( empty($role->capabilities[$cap]) ) {
        $role->add_cap($cap);
      }
    }

  }
  
  function set_capabilities_commonsubscriber () {
    global $eqfs_capabilities;

    //* Get Administrator role for adding custom capabilities */
    $role =& get_role( get_option('eqfs_role') );
    //* General WPP capabilities */
    $eqfs_capabilities = array(
      'edit_equipment_sale' => true,
	  'read_private_equipment_sales' => true,
	  'read_private_equipment_sale' => true,
	  'read_equipment_sales' => true,
	  'read_equipment_sale' => true
    );

    //* Adds Premium Feature Capabilities */
//    $eqfs_capabilities = apply_filters('eqfs_capabilities', $eqfs_capabilities);

    if(!is_object($role)) {
      return;
    }
    foreach($eqfs_capabilities as $cap => $value){
      if ( empty($role->capabilities[$cap]) ) {
        $role->add_cap($cap);
      }
    }

  }
  
	function hide_buttons()
	{
	  global $current_screen;
	  if( $user_level<5 ){
		  if( $current_screen->id == 'edit-equipment_sale' || $current_screen->id == 'equipment_sale' && !current_user_can('publish_pages')) {
			echo '<style>.add-new-h2,.subsubsub, #post-status-select, .edit-post-status, .actions{display: none;} </style>';  
	  	}
	  }
	  // for posts the if statement would be:
	  // if($current_screen->id == 'edit-post' && !current_user_can('publish_posts'))
	}

	function equipment_sale_admin_menu(){
		global $submenu,$user_level;
		if( $user_level<10 ){
		  unset($submenu['edit.php?post_type=equipment_sale'][10][0]);
		  unset($submenu['edit.php?post_type=equipment_sale'][10][2]);
		}
	    add_submenu_page('edit.php?post_type=equipment_sale', 'Settings', 'Settings', 'administrator', 'equipment_settings', array('equipment_class', 'equipment_settings') );
	}
	
	
	function admin_ini() {
	  global $current_screen,$user_level;
  
	  if ( file_exists( EQU_Path . 'css/equipment-admin.css') ) {
		wp_register_style('equ-admin-styles', EQU_URL . 'css/equipment-admin.css');
		wp_enqueue_style( 'equ-admin-styles');
	  }
	  
		add_action('save_post', array('equipment_class', 'save_equipment_details'));
		add_action('save_post', array('equipment_class', 'save_equipment_image'));
		
		if( $user_level>=10 ){
			add_meta_box("equipment_hearabout", "Here about us", array('equipment_class', 'equipment_hereabout') , "equipment_sale", "normal", "low");
		}
		add_meta_box("equipment_description", "Equipment Details", array('equipment_class', 'equipment_sale_description') , "equipment_sale", "normal", "low");
		add_meta_box("equipment_location", "Equipment Location", array('equipment_class', 'equipment_sale_location') , "equipment_sale", "normal", "low");
		add_meta_box("equipment_image", "Equipment Image", array('equipment_class', 'equipment_sale_image') , "equipment_sale", "normal", "low");
		add_meta_box("equipment_status", "Listing Status", array('equipment_class', 'equipment_author_box') , "equipment_sale", "side", "low");
		
		if( $user_level>=10 ){
			add_filter('parse_query', array('equipment_class', 'equ_sale_useronly') );			
		}
	}
	

	
	function equipment_author_box(){
		global $post;
		$custom = get_post_custom($post->ID);
		$author_email = get_the_author_meta( 'user_email' , $post->post_author);
		$author_link = get_author_posts_url( $post->post_author );
		$views = get_post_meta( $post->ID, 'equipment_views' , true );
	?>
	
	<div class="form-wrap">
			Listing views : <?php echo $views;?><br />
			Author Email : <a href="user-edit.php?user_id=<?=$post->post_author?>"><?php echo $author_email;?></a>
	</div>
		
	<?php
	}

	//Manage Your Media Only. and remove the Media link 
	function equ_sale_useronly( $wp_query ) {
		global $pagenow;
		if ( $pagenow=='upload.php' || $pagenow=='media-upload.php' ) {
			if ( current_user_can( get_option('eqfs_role') ) ) {
				global $current_user;
				$wp_query->set( 'author', $current_user->id );
			}
		}
	
	}

	function update_eqfs_options(){
		if( check_admin_referer('wppe_packages_save') ){	
			foreach( $_POST['eqplisting'] as $key => $value ){ 
				update_option( $key, $value );
			}
		}
	}


	function equipment_settings(){
	screen_icon();
	?>
	<div class="wrap">
		<h2><?php  echo  __('Equipment for sale settings','equ') ?></h2>
        
      <form method="post" action="<?php echo admin_url('edit.php?post_type=equipment_sale&page=equipment_settings'); ?>" />
      <?php wp_nonce_field('wppe_packages_save'); ?>

      <h3>Packages</h3>
        <table width="500" border="0">
  <tr>
  	<thead>
        <th>Name</th>
        <th>ID</th>
        <th>Price</th>
        <th>Months effected</th>
    </thead>
  </tr>
  <tr>
    <td>Package 1</td>
    <td>package_1</td>
    <td><input type="text" name="eqplisting[package_1]" maxlength="8" size="10" style="text-align:right;" value="<?php echo set_money_format( get_option('eqs_package_1', '19.95') );?>" /></td>
    <td align="center"><input type="text" name="eqplisting[package_1_months]" maxlength="2" size="4" style="text-align:right;" value="<?php echo  get_option('eqs_package_1_months', '1');?>" /></td>
  </tr>
  <tr>
    <td>Package 2</td>
    <td>package_2</td>
    <td><input type="text" name="eqplisting[package_2]" maxlength="8" size="10" style="text-align:right;" value="<?php echo set_money_format( get_option('eqs_package_2', '49.95') );?>" /></td>
    <td align="center"><input type="text" name="eqplisting[package_2_months]" maxlength="2" size="4" style="text-align:right;" value="<?php echo  get_option('eqs_package_2_months', '3');?>" /></td>
  </tr>
  <tr>
    <td>Package 3</td>
    <td>package_3</td>
    <td><input type="text" name="eqplisting[package_3]" maxlength="8" size="10" style="text-align:right;" value="<?php echo set_money_format( get_option('eqs_package_3', '69.95') );?>" /></td>
    <td align="center"><input type="text" name="eqplisting[package_3_months]" maxlength="2" size="4" style="text-align:right;" value="<?php echo  get_option('eqs_package_3_months', '6');?>" /></td>
  </tr>
</table>



      <h3>Role</h3>
      <table>
          <tr>
            <td>Default role to assign</td>
            <td><input type="text" name="eqplisting[eqfs_role]" maxlength="30" size="35" value="<?php echo get_option('eqfs_role');?>" /></td>
          </tr>
      </table>
      

      
      
	<p class="wpp_save_changes_row">
	<input type="submit" value="<?php _e('Save Changes','wpp');?>" name="button-submit" class="button-primary" >
 	</p>

</form>

    </div>
    <?php
	}
	
	function do_metabox(){
		global $pagenow;
		if( $pagenow == 'post.php' || $pagenow == 'post-new.php' ){
			remove_meta_box( 'postimagediv', 'equipment_sale', 'side' );
			remove_meta_box( 'equipment_categorydiv', 'equipment_sale', 'side' );
		}
	}
	
	
	function get_equ_post_custom( $post ){
		$pst = (array)$post;
		$postcustom = get_post_custom($pst['ID']);
		foreach( $postcustom as $key => $value ){
			$equipments[$key]=$value[0];
		}
		return (array)$equipments;
	}
	
	function equipment_sale_description(){
		global $user_level, $post;
		$equipments= equipment_class::get_equ_post_custom($post);
		?>
<table width="100%" border="0">
  <tr>
    <td width="20%">Payment status</td>
    <td class="table_right">
        <?php if( $user_level>=10 ) {?>
          <?php //* Get property types */ ?>
          <select id="equipment_payment_status" name="eq_sale[payment_status]">
            <option<?php if($equipments['payment_status']=='Paid') echo ' selected="selected"';?>>Paid</option>
            <option<?php if($equipments['payment_status']=='Not paid') echo ' selected="selected"';?>>Not paid</option>
          </select>
        <?php } else { 
		echo ( !empty($equipments['payment_status']) )?$equipments['payment_status']:'Not paid';
		?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td>Package type</td>
    <td class="table_right">
      <select name="eq_sale[equipment_type]" i>
          <option selected="" value="">Select one</option>
          <option value="package_1"<?php if( isset($equipments['equipment_type']) && $equipments['equipment_type']=='package_1' ) echo ' selected="selected"';?>>Package 1 - $<?php echo set_money_format( get_option('eqs_package_1', '19.95') );?>, <?php echo  get_option('eqs_package_1_months', '1');?> Months</option>
          <option value="package_2"<?php if( isset($equipments['equipment_type']) && $equipments['equipment_type']=='package_2' ) echo ' selected="selected"';?>>Package 2 - $<?php echo set_money_format( get_option('eqs_package_2', '49.95') );?>, <?php echo  get_option('eqs_package_2_months', '3');?> Months</option>
          <option value="package_3"<?php if( isset($equipments['equipment_type']) && $equipments['equipment_type']=='package_3' ) echo ' selected="selected"';?>>Package 3 - $<?php echo set_money_format( get_option('eqs_package_3', '69.95') );?>, <?php echo  get_option('eqs_package_3_months', '6');?> Months</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Equipment Category</td>
    <td class="table_right">
		<?php
		$terms = get_terms( 'equipment_category', 'orderby=count&hide_empty=0' );
        ?>
		<select name="eq_sale[equipment_category]" class="withpadding">
        <?php
		if($terms){
			foreach ($terms as $term) {?>
				<option<?php if( $equipments['equipment_category']==$term->term_id ) echo ' selected="selected"';?>  value="<?php echo $term->term_id;?>"><?php echo $term->name;?></option>
		<?php }
		}
        ?>
		</select>
    </td>
  </tr>
  <tr>
    <td>Equipment Description</td>
    <td class="table_right"><textarea name="eq_sale[equipment_description]" cols="100" rows="8"><?=$equipments['equipment_description']?></textarea></td>
  </tr>  
  <tr>
    <td>Equipment Price</td>
    <td class="table_right"><input type="text" name="eq_sale[equipment_price]" class="dollar_sign withpadding" value="<?=$equipments['equipment_price']?>" /></td>
  </tr>  
  <tr>
    <td>No of items</td>
    <td class="table_right"><input type="text" name="eq_sale[equipment_noof_items]" class="text_right" maxlength="8" value="<?=$equipments['equipment_noof_items']?>" /></td>
  </tr>  
</table>
        <?php
	}
	
	function equipment_hereabout(){
		global $user_level, $post;
		$equipments= equipment_class::get_equ_post_custom($post);
		?>
<table width="100%" border="0">
  <tr>
    <td width="20%">Hear about <?php echo bloginfo('name');?></td>
    <td class="table_right">
        <?php if( $equipments['hear_from']=='Other' ) { echo $equipments['here_about_other']; } else { echo $equipments['hear_from'];}?>
    </td>
  </tr>
 </table>
        <?php
	}
	
	function save_equipment_details(){
		global $post;
		if( isset($_REQUEST['eq_sale']) ){
			foreach( $_REQUEST['eq_sale'] as $key => $value ){
				update_post_meta($post->ID, $key , $value );
			}
		}
	}
	
	
	function save_equipment_image(){
		global $post, $current_user;
		if( isset( $_POST['equ_image_description'] ) ){
			$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
			if( $post_thumbnail_id ){
				$my_post = array();
				$my_post['ID'] = $post_thumbnail_id;
				$my_post['post_title'] = $_POST['equ_image_description'];
				wp_update_post( $my_post );
			}
		}
		
		if( isset( $_POST['delete_equ_image'] ) ){
			wp_delete_attachment( $_POST['delete_equ_image'] );
		}
		
		if( isset($_FILES['equipment_file']['name']) ){
			$oldfilename = $_FILES['equipment_file']['name'];
			$oldfile = $_FILES['equipment_file']['tmp_name'];
				if( !empty( $oldfilename ) ){
					$chfilename = preg_replace('/[^a-zA-Z0-9._\-]/', '', $oldfilename); 
					$uploads = wp_upload_dir();
					$original_filename = basename ($oldfilename);
					$newfilename = wp_unique_filename( $uploads['path'], $chfilename);
					$new_file = $uploads['path'] . "/$newfilename";
					$file_data = wp_check_filetype_and_ext($oldfile, $oldfilename);
					$overrides = array( 'test_form' => false);
	
	
					if( move_uploaded_file($_FILES['equipment_file']['tmp_name'], $new_file ) ){
						$attachment = array(
									  'post_parent' => $post->ID,
									  'post_author' => $post->post_author,
									  'post_mime_type' => $file_data['type'],
									  'guid' => $uploads['baseurl'] . _wp_relative_upload_path( $newfilename ),
									  'post_title' => trim( $_POST['equ_image_description']),
									  'post_content' => '',
									);
						$attachment_id = wp_insert_attachment( $attachment, $new_file, $post->ID );
						wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $new_file));
						set_post_thumbnail( $post->ID, $attachment_id );
					}
				}
			}
	}
	
	function equipment_sale_image(){
		global $post;
		?>
        <table width="100%" border="0">
          <tr>
            <td width="20%">Featured Image</td>
            <td class="table_right">
                <?php 
				if( has_post_thumbnail( $post_id ) ){
					$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
					$title=get_the_title($post_thumbnail_id);
					echo get_the_post_thumbnail($post->ID, 'thumbnail');
					echo '<input type="checkbox" name="delete_equ_image[]" value="'.$post_thumbnail_id.'" /> Delete';
					echo 'Description : <input type="text" name="equ_image_description" value="'.$title.'" size="60" maxlength="50" />';
				} else {
				?>
                <input type="file" name="equipment_file" />
                Description : <input type="text" name="equ_image_description" value="Image description goes here" size="60" maxlength="50" onfocus="if(this.value=='Image description goes here') this.value='';" />
                <?php } ?>
            </td>
          </tr>
         
        </table>
        <?php
	}
	
	function save_equipment_sale_location(){
		global $post, $current_user;
		if( isset( $_POST['equ_image_description'] ) ){
			$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
			if( $post_thumbnail_id ){
				$my_post = array();
				$my_post['ID'] = $post_thumbnail_id;
				$my_post['post_title'] = $_POST['equ_image_description'];
				wp_update_post( $my_post );
			}
		}
		
		if( isset( $_POST['delete_equ_image'] ) ){
			wp_delete_attachment( $_POST['delete_equ_image'] );
		}
		
		if( isset($_FILES['equipment_file']['name']) ){
			$oldfilename = $_FILES['equipment_file']['name'];
			$oldfile = $_FILES['equipment_file']['tmp_name'];
				if( !empty( $oldfilename ) ){
					$chfilename = preg_replace('/[^a-zA-Z0-9._\-]/', '', $oldfilename); 
					$uploads = wp_upload_dir();
					$original_filename = basename ($oldfilename);
					$newfilename = wp_unique_filename( $uploads['path'], $chfilename);
					$new_file = $uploads['path'] . "/$newfilename";
					$file_data = wp_check_filetype_and_ext($oldfile, $oldfilename);
					$overrides = array( 'test_form' => false);
	
	
					if( move_uploaded_file($_FILES['equipment_file']['tmp_name'], $new_file ) ){
						$attachment = array(
									  'post_parent' => $post->ID,
									  'post_author' => $post->post_author,
									  'post_mime_type' => $file_data['type'],
									  'guid' => $uploads['baseurl'] . _wp_relative_upload_path( $newfilename ),
									  'post_title' => trim( $_POST['equ_image_description']),
									  'post_content' => '',
									);
						$attachment_id = wp_insert_attachment( $attachment, $new_file, $post->ID );
						wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $new_file));
						set_post_thumbnail( $post->ID, $attachment_id );
					}
				}
			}
	}
	
	function get_eqfs_postmeta_value( $post, $custom ){ 
		$equipments = equipment_class::get_equ_post_custom($post);
		foreach( $equipments as $key => $value ){
			if( $custom==$key ) return $value;
		}
	}
	
	function equipment_sale_location(){
		global $post;
		$equipments = equipment_class::get_equ_post_custom($post);
		?>
        <table width="100%" border="0">
          <tr>
            <td width="20%">Business Address</td>
            <td class="table_right"><input type="text" name="eqfs_fp_field_data[business_address]" id="business_address" size="65" maxlength="60" class="step2p" value="<?php echo $equipments['business_address'];?>"></td>
          </tr>
          <tr>
            <td width="20%">Suburb</td>
            <td class="table_right"><input type="text" name="eqfs_fp_field_data[suburb]" id="suburb" size="55" maxlength="50" class="step2p" value="<?php echo $equipments['suburb'];?>"></td>
          </tr>
          <tr>
            <td width="20%">Post code</td>
            <td class="table_right"><input type="text" name="eqfs_fp_field_data[post_code]" id="post_code" size="8" maxlength="5" class="step2p" value="<?php echo $equipments['post_code'];?>"></td>
          </tr>
          <tr>
            <td width="20%">State</td>
            <td class="table_right">
				<select name="eqfs_fp_field_data[practice_state]" id="equipment_state" class="step2p">
                    <option selected="" value="">Select --&gt;</option>
                    <option<?php if( $equipments['practice_state']=='ACT') echo ' selected="selected"';?>>ACT</option>
                    <option<?php if( $equipments['practice_state']=='NSW') echo ' selected="selected"';?>>NSW</option>
                    <option<?php if( $equipments['practice_state']=='NT') echo ' selected="selected"';?>>NT</option>
                    <option<?php if( $equipments['practice_state']=='QLD') echo ' selected="selected"';?>>QLD</option>
                    <option<?php if( $equipments['practice_state']=='SA') echo ' selected="selected"';?>>SA</option>
                    <option<?php if( $equipments['practice_state']=='TAS') echo ' selected="selected"';?>>TAS</option>
                    <option<?php if( $equipments['practice_state']=='VIC') echo ' selected="selected"';?>>VIC</option>
                    <option<?php if( $equipments['practice_state']=='WA') echo ' selected="selected"';?>>WA</option>
                 </select>
            </td>
          </tr>
        </table>
<script type="text/javascript">
    jQuery(document).ready(function() {
//CUSTOM JAVASCRIPTS START FROM HERE
		jQuery( "#suburb" ).autocomplete({
			source: function( request, response ) {
				jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", { 
					action: 'wppe_show_suburblist',
					suburb :  jQuery("#suburb").val()
					},
					function(data){
						eval("response_data="+ data);
						response( jQuery.map( response_data, function( item ) {
							return {
								label: item.value,
								id: item.id,
								value: item.value
							}
						}));
					});
			},
			minLength: 2,
			select: function(event, ui) {
				jQuery("#suburb").val( ui.item.value );
				jQuery("#post_code").val( ui.item.id );
			},
			open: function() {
				jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
    });
  </script>
        <?php
	}
	
	function get_equipment_ID( $id ){
		return "EQ-". $id ;
	}
	
	function install(){
		global $wpdb;
		
		$sql = "ALTER TABLE ".TODO_ITEMS." CHANGE `log_mode` `log_mode` ENUM( 'property', 'events', 'equipment' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
		$wpdb->query($sql);
	}

}