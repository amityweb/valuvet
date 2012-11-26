<?php
class todo_class{
	
	function todo_class(){
		add_action( 'admin_init', array($this, 'todo_admin_init') );
	}
	
	function todo_admin_init(){
		global $user_level;
		if( $user_level>=10 ){
			add_action('wp_dashboard_setup',  array($this, 'add_dashboard_widgets') );
			$this->load_todo_javascript();
		} else {
			if( current_user_can('propertysubscriber') || current_user_can( get_option('eqfs_role') ) || current_user_can('registereduser') ){
				add_action('wp_dashboard_setup',  array($this, 'property_subscriber_dashboard') );
				$this->load_ps_javascript();
			}
		}
	}
	
	function insert_todo_item( $itemsarray ){
		global $wpdb;
		$blogtime = current_time('timestamp');
		$defaults = array('todo_title' => '', 'todo_propertyid' => '', 'todo_date' => $blogtime, 'todo_status' => 'pending', 'todo_mode' => 'property');
		$todo = wp_parse_args($itemsarray, $defaults);
		$wpdb->update( TODO_ITEMS, array( 'todo_status' => 'closed'	), array('todo_propertyid' => $todo['todo_propertyid'])  );
		$wpdb->insert( TODO_ITEMS , 
					  array( 'todo_title' => $todo['todo_title'], 'todo_propertyid' => $todo['todo_propertyid'],
							'todo_date' => $todo['todo_date'], 'todo_status' => $todo['todo_status'] 
							), 
					  array( '%s','%d','%s','%s' ) );
	}
	
	function insert_todo_log( $itemsarray ){
		global $wpdb;
		$blogtime = current_time('timestamp');
		$defaults = array('log_title' => '', 'log_propertyid' => '', 'log_date' => $blogtime, 'log_mode' => 'property', 
						  'log_status' => 'pending', 'log_by'=>'0', 'log_extra_id' => 0);
		$todo = wp_parse_args($itemsarray, $defaults);
		$wpdb->update( TODO_ITEMS, array( 'todo_status' => 'closed'	), array('todo_propertyid' => $todo['todo_propertyid'])  );
		$wpdb->insert( TODO_LOG , 
					  array( 'log_title' => $todo['log_title'], 'log_propertyid' => $todo['log_propertyid'],
							'log_date' => $todo['log_date'], 'log_mode' => $todo['log_mode'], 
							'log_status' => $todo['log_status'], 'log_by' => $todo['log_by'],
							'log_extra_id' => $todo['log_extra_id'] ), 
					  array( '%s','%d','%s','%s','%s' ) );
	}
	
	
	
	function update_todo_item( $data=array(), $where, $format = NULL, $where_format = NULL){
		global $wpdb; 
		return $wpdb->update( TODO_ITEMS, $data, $where, $format = null, $where_format = null ); 
	}
	
	
	function get_todo_row( $id ){
		global $wpdb;
		return $wpdb->get_row("SELECT * FROM ".TODO_ITEMS." WHERE todo_id = '".$id."'");
	}
	
	function admin_dashboard_functions(){
    	wp_enqueue_script( 'todo-general', plugins_url( 'js/todo-general.js' , dirname(__FILE__) ) );
	}

	
	function load_todo_javascript(){
		add_action('admin_enqueue_scripts',  array($this, 'admin_dashboard_functions') );
	}
	
	
	function user_dashboard_functions(){
    	wp_enqueue_script( 'todo-general', plugins_url( 'js/todo-ps.js' , dirname(__FILE__) ) );
	}

	function load_ps_javascript(){
		add_action('admin_enqueue_scripts',  array($this, 'user_dashboard_functions') );
	}
	
	
	function dashboard_updates(){
		global $wpdb;
		if( check_admin_referer('to-do-general') ){	
			if( isset( $_POST['todo_postid'] ) ){
				foreach( $_POST['todo_postid'] as $key => $value ){
					$myrow = $this->get_todo_row( $value );
					$ppstid = ( !empty($myrow->todo_propertyid) )?$myrow->todo_propertyid:0;
					$my_post = array();
					$my_post['ID'] = $ppstid;
					$thisuser = get_current_user_id();
					switch( $_POST['operation'] ){
						case 'Archived':
								$my_post['post_status'] = 'Archived';
								$addtodo = array(
									'todo_title'       => 'Property listing Archived.',
									'todo_propertyid'  => $ppstid );
								$this->insert_todo_item($addtodo);
								delete_post_meta( $ppstid, 'post_sold' );
							break;
						case 'Being review':
								$my_post['post_status'] = 'Reviewing';
							break;
						case 'sold':
								update_post_meta( $ppstid, 'post_sold', 'Yes' );
								$addtodo = array(
									'todo_title'       => 'Property listing marked as sold.',
									'todo_propertyid'  => $ppstid );
								$this->insert_todo_item($addtodo);
							break;
						case 'rmsold':
								$my_post['post_status'] = 'Sold';
							break;
						case 'Publish':
								$my_post['post_status'] = 'publish';
								$addtodo = array(
									'todo_title'       => 'Property listing published.',
									'todo_propertyid'  => $ppstid );
								$this->insert_todo_item($addtodo);
								delete_post_meta( $ppstid, 'post_sold' );
							break;
						case 'Remove from dashboard':
								if( !$this->update_todo_item( array('todo_status'=>'closed') , array( 'todo_id' => $value ), array( '%d' )  ) ){
									$todo_message = 'Error when update';
									add_action('admin_notices', array($this, 'show_todo_message'));
								}
							break;
						case 'Info Required':
								if( !empty( $_POST['admininfo_require_text'][$myrow->todo_propertyid] ) ){
									$postinfo = get_post( $myrow->todo_propertyid ); 
									$log = array( 'log_title' => $_POST['admininfo_require_text'][$myrow->todo_propertyid], 'log_propertyid' => $myrow->todo_propertyid, 'log_by' => $thisuser );
									$this->insert_todo_log( $log );	
									$author_email = get_the_author_meta( 'user_email' , $postinfo->post_author);
									$first_name = get_the_author_meta( 'first_name' , $postinfo->post_author);
									$last_name = get_the_author_meta( 'last_name' , $postinfo->post_author);
									$bloginfo = get_bloginfo( 'name' );
									$admin_email = get_bloginfo( 'admin_email' );
									$notify_data = array(
														 '{AUTHOR_EMAIL}' => $author_email,
														 '{AUTHOR_FIRST_NAME}' => $first_name,
														 '{AUTHOR_LAST_NAME}' => $last_name,
														 '{MESSAGE}' => $_POST['admininfo_require_text'][$myrow->todo_propertyid],
														 '{AUTHOR_PROPERTY_TITLE}' => $postinfo->post_title
														 );
									$data = get_valuvet_notify_email_template('notify_customer_info_required', $notify_data);
									$header =  "From: $bloginfo <$admin_email>\n"; // header for php mail only
									wp_mail($author_email, sprintf(__('%s '.$data['subject'] ), $bloginfo), $data['message'], $header);
								}
							break;
						default:
								$my_post['post_status'] = 'pending';
							break;
					}
					wp_update_post( $my_post );
				}
			}
		}
	}

	
	function ps_dashboard_updates(){
		global $wpdb;
		if( check_admin_referer('to-do-property_subscriber') ){	
			if( isset( $_POST['log_id'] ) ){
				$thisuser = get_current_user_id();
				foreach( $_POST['log_id'] as $key => $value ){;
					$log = array( 'log_title' => $_POST['info_require_text'][$value], 'log_propertyid' => $_POST['propertyid'][$value], 'log_by' => $thisuser );
					$this->insert_todo_log( $log );	
				}
			}
		}
	}
	
	
	function show_todo_message(){
		global $todo_message;
		if( isset($todo_message) ) {
			echo '<div id="message" class="updated fade">';
			echo "<p><strong>".$todo_message."</strong></p></div>";
		}
	}


	//Administrator dashboard
	function dashboard_widget_function() {
		global $wpdb,$wp_properties;
		?>
		
        <form action="" method="post" onsubmit="return validate_selection();">
        <input type="hidden" name="todo-process" value="todo-process-update" />
        <?php wp_nonce_field('to-do-general');?>
        <select name="operation" id="todo_operation" style="padding:3px 3px 3px 3px; height: 30px;">
        	<option value="Archived">Archived</option>
        	<option value="sold">Sold</option>
        	<option value="Pending">Pending Review</option>
        	<option>Published</option>
        	<option>Being review</option>
            <option>Info Required</option>
        	<option>Remove from dashboard</option>
        </select>
        
        <input type="submit" name="action" value="Action" />

        <table width="100%" border="0" id="dotolist_table">
          <tr>
            <th width="2%">&nbsp;</th>
            <th width="40%">Title</th>
            <th width="18%">ID</th>
            <th width="13%">Status</th>
            <th width="11%">Package</th>
            <th width="16%">Date</th>
          </tr>
          <?php 
		  	$todolisting = $wpdb->get_results(  "SELECT * FROM ".TODO_ITEMS." AS todo
												LEFT JOIN $wpdb->posts AS PO 
												ON PO.ID = todo.todo_propertyid 
												LEFT JOIN $wpdb->postmeta AS PM
												ON PM.post_id=todo.todo_propertyid 
											  WHERE todo_status='pending'
											  AND PO.post_type = 'property'
											  GROUP BY todo.todo_propertyid
											  ORDER BY todo.todo_date DESC
											  " ); 
		  	foreach ( $todolisting as $todolist ){
				if( $todolist->post_type=='property') {
					$pmeta = get_post_meta($todolist->todo_propertyid, 'property_type', true);
					$pkg = $wp_properties['property_types'][$pmeta];
				} else {
					$pkg = '&nbsp;';
				}

		  ?>
          <?php  $clr=( $todolist->post_status=='publish' ) ?'#060':'#F03';?>
          <tr>
            <td><input type="checkbox" name="todo_postid[]" class="todopid" id="checkbox" value="<?php echo $todolist->todo_id;?>" /></td>
            <td><?php echo $todolist->todo_title;?> ( <?php echo 'Title :'. $todolist->post_title ?> )</td>
            <td align="right">
			<?php echo $todolist->todo_propertyid;?>
            ( <a href="<?php echo $todolist->guid;?>" target="_blank">view</a> | 
            <a href="<?php echo get_edit_post_link( $todolist->todo_propertyid ); ?>" target="_blank">edit</a>  
			<?php 
			$chklog = $this->check_logs($todolist->todo_propertyid);
			if( $chklog ) {?>) | <a href="#"  onclick="return false;" id="<?php echo $todolist->todo_id;?>" class="showlog">log</a><?php } ?> )
            
            </td>
            <td align="center"><span style="color:<?php echo $clr;?>"><?php echo ucfirst( $todolist->post_status );?></span>
            <?php 
			$ptmp = get_renewed_status_by_date( $todolist->post_date);
			if( $ptmp )	echo '(About to Expire)';
			?>
			</td>
            <td align="center"><?php echo $pkg;?></td>
            <td align="center"><?php echo gmdate("d m Y h:i:s", $todolist->todo_date);?></td>
          </tr>
          <tr id="inforequired_<?php echo $todolist->todo_id;?>" style="display: none;" class="inforequired">
            <td>&nbsp;</td>
            <td colspan="5">
            	Send Message to publisher : <br />
                <textarea name="admininfo_require_text[<?php echo $todolist->todo_propertyid;?>]" style="width: 98%;"></textarea>
            </td>
          </tr>
          <?php if( $chklog ) { ?>
          <tr id="log_<?php echo $todolist->todo_id;?>" style="display: none;" class="log">
            <td colspan="6" style="padding:10px;">
            	<?php $this->get_log_function($todolist->todo_propertyid); ?>
            </td>
          </tr>
          <?php }
		  } ?>
        </table>
		</form>
        <?php
	} 
	
	//Subscribers dashboard
	function property_subscriber_log_list() {
		global $wpdb,$wp_properties;
		$thisuser = get_current_user_id();
		?>
        <form action="" method="post">
        <input type="hidden" name="pslog-process" value="log-process-update" />
        <?php wp_nonce_field('to-do-property_subscriber');?>
        <select name="operation" id="todo_operation" style="padding:3px 3px 3px 3px; height: 30px;">
        	<option>Reply</option>
        </select>
        <input type="submit" name="action" value="Action" />
        <table width="100%" border="0" id="dotolist_table" bgcolor="#FFFFFF";>
        <thead>
          <tr>
            <th width="2%">&nbsp;</th>
            <th width="40%">Title</th>
            <th width="13%">Status</th>
            <th width="10%">Listing</th>
            <th width="10%">By</th>
            <th width="10%">Date</th>
            <th width="8%">ID</th>
          </tr>
          </thead>
          <?php 
		  	$loglisting = $wpdb->get_results(  "SELECT * FROM ".TODO_LOG." AS log
												LEFT JOIN $wpdb->posts AS PO 
													ON ( log.log_propertyid=PO.ID ) 
											  WHERE PO.post_author='".$thisuser."'
											  GROUP BY PO.ID
											  ORDER BY log.log_date DESC" ); 
		  	foreach ( $loglisting as $loglist ){
				if( $loglist->post_type=='property') {
					$pmeta = get_post_meta($loglist->log_propertyid, 'property_type', true);
					$pkg = $wp_properties['property_types'][$pmeta];
				} else {
					$pkg = '&nbsp;';
				}
		  ?>
          <tr>
            <th width="2%">
            <input name="propertyid[<?php echo $loglist->log_id;?>]" type="hidden" value="<?php echo $loglist->log_propertyid;?>">
            <input type="checkbox" name="log_id[]" class="log_id" id="checkbox" value="<?php echo $loglist->log_id;?>" /></th>
            <td><?php echo $loglist->log_title;?> </td>
            <td align="center"><?php echo ucfirst( $loglist->post_status );?></td>
            <td align="center"></td>
            <td align="center"><?php if( $loglist->log_by>0 ) { $user_info = get_userdata( $loglist->log_by ); echo $user_info->first_name; } else { echo "Visitor";}?></td>
            <td align="center"><?php echo gmdate("d m Y h:i:s", $loglist->log_date);?></td>
            <td align="center"><?php echo $loglist->log_propertyid;?></td>
          </tr>
          <tr id="logreply_<?php echo $loglist->log_id;?>" style="display: none;" class="logreply">
            <td colspan="5">
            	Reply : <br />
                <textarea name="info_require_text[<?php echo $loglist->log_id;?>]" style="width: 98%;"></textarea>
            </td>
          </tr>
          <?php } ?>
        </table>
		</form>
        <?php
		
	} 
	
	function check_logs( $propertyid ){
		global $wpdb,$wp_properties;
		$loglisting = $wpdb->get_results(  "SELECT * FROM ".TODO_LOG." AS log
											LEFT JOIN $wpdb->posts AS PO 
											ON PO.ID = log.log_propertyid 
											LEFT JOIN $wpdb->postmeta AS PM
											ON PM.post_id=log.log_propertyid 
										  WHERE log_status='pending'
										  GROUP BY log.log_id
										  ORDER BY log.log_date DESC
										  " );
		return ( $loglisting )?true:false;
	}

	function get_log_function( $propertyid ) {
		global $wpdb,$wp_properties;
		?>
        <table width="100%" border="1" id="dotolist_table" bgcolor="#FFFFFF" cellspacing="1" cellpadding="1" bordercolor="#FFFFFF">
          <tr>
            <th width="40%">Title</th>
            <th width="5%">Status</th>
            <th width="5%">By</th>
            <th width="5%">Type</th>
            <th width="5%">Date</th>
            <th width="40%">ID</th>
          </tr>
          <?php 
		  	$loglisting = $wpdb->get_results(  "SELECT * FROM ".TODO_LOG." AS log
												LEFT JOIN $wpdb->posts AS PO 
												ON PO.ID = log.log_propertyid 
												LEFT JOIN $wpdb->postmeta AS PM
												ON PM.post_id=log.log_propertyid 
											  WHERE log_status='pending'
											  AND PO.ID='".$propertyid."'
											  GROUP BY log.log_id
											  ORDER BY log.log_date DESC
											  " ); 
		  	foreach ( $loglisting as $loglist ){
				if( $loglist->post_type=='property') {
					$pmeta = get_post_meta($loglist->log_propertyid, 'property_type', true);
					$pkg = $wp_properties['property_types'][$pmeta];
				} else {
					$pkg = '&nbsp;';
				}
				if( $loglist->log_mode=='enquiry'){ 
				$enq = get_post( $loglist->log_extra_id );
				$userdata = get_userdata( $enq->post_author );
				?>
          <tr>
            <td><?php echo $loglist->log_title;?></td>
            <td align="center"><strong><?php echo ucfirst( $enq->post_status );?></strong></td>
            <td align="center"><a href="user-edit.php?user_id=<?=$enq->post_author?>"><?=$userdata->first_name?></a> Enquiry</td>
            <th width="5%"><?php echo ucfirst($loglist->log_mode);?></th>
            <td align="center"><?php echo gmdate("d m Y h:i:s", $loglist->log_date);?></td>
			<td align="center">
            	Property <?php echo $loglist->log_propertyid;?> | <a href="<?php echo get_edit_post_link( $loglist->log_extra_id)?>">View Enquiry</a> <br />
                Change To Status to:
            	<a href="<?php echo get_edit_post_link( $loglist->log_extra_id)?>&status=enquire">Enquiry</a> |
            	<a href="<?php echo get_edit_post_link( $loglist->log_extra_id)?>&status=sent">Contract sent</a> |
            	<a href="<?php echo get_edit_post_link( $loglist->log_extra_id)?>&status=received">Contract received</a> |
            	<a href="<?php echo get_edit_post_link( $loglist->log_extra_id)?>&status=active">Active</a> |
            	<a href="<?php echo get_edit_post_link( $loglist->log_extra_id)?>&status=hold">Hold</a> |
            	<a href="<?php echo get_edit_post_link( $loglist->log_extra_id)?>&status=archive">Archive</a> |
            </td>
          </tr>
		<?php  } else {
			$property = get_post( $loglist->log_propertyid );
		  ?>
          <tr>
            <td><?php echo $loglist->log_title;?></td>
            <td align="center"><?php echo ucfirst( $loglist->post_status );?></td>
            <td align="center"><?php if( $loglist->log_by>0 ) { $user_info = get_userdata( $loglist->log_by ); echo $user_info->first_name; } else { echo "Visitor";}?></td>
            <th width="5%"><?php echo ucfirst($loglist->log_mode);?></th>
            <td align="center"><?php echo gmdate("d m Y h:i:s", $loglist->log_date);?></td>
			<td align="center">Property <?php echo $loglist->log_propertyid;?></td>
          </tr>
          <tr id="inforequired_<?php echo $loglist->log_id;?>" style="display: none;" class="inforequired">
            <td colspan="5">
            	Description : <br />
                <textarea name="info_require_text[<?=$propertyid?>]" style="width: 98%;"></textarea>
            </td>
          </tr>
          <?php 
		}
		  } ?>
        </table>
        <?php
	} 

	function add_dashboard_widgets() {
		//wp_add_dashboard_widget('todo_general_widget', 'To-Do', array($this, 'dashboard_widget_function'));	
		add_meta_box( 'todo_general_widget', 'To-Do', array($this, 'dashboard_widget_function'), 'dashboard', 'side', 'high' );
	} 
	
	function property_subscriber_dashboard(){
		wp_add_dashboard_widget('todo_property_subscriber_widget', 'Your Log', array($this, 'property_subscriber_log_list'));	
	}
	
	/**
	 * Install plugin on plugin activation
	 */
	function install() {
		global $wpdb;
	
		if( $wpdb->get_var("SHOW TABLES LIKE '".TODO_ITEMS."'") != TODO_ITEMS ) {
			$sql = "CREATE TABLE ". TODO_ITEMS ." (
					todo_id bigint(20) unsigned NOT NULL auto_increment,
					todo_title varchar(100) NOT NULL,
					todo_propertyid INT NOT NULL,
					todo_date varchar(15) NOT NULL,
					todo_mode ENUM('property','events','equipment') NOT NULL,
					todo_status ENUM('pending','success','closed') NOT NULL,
					PRIMARY KEY (todo_id),
					UNIQUE ( `todo_id`  )
					);";
			$wpdb->query($sql);
		} 
		
		if( $wpdb->get_var("SHOW TABLES LIKE '".TODO_LOG."'") != TODO_LOG ) {
			$sql = "CREATE TABLE ". TODO_LOG ." (
					log_id bigint(20) unsigned NOT NULL auto_increment,
					log_title text NOT NULL,
					log_propertyid INT NOT NULL,
					log_date varchar(15) NOT NULL,
					log_mode ENUM('property','events','equipment','enquiry') NOT NULL,
					log_status ENUM('pending','success','closed') NOT NULL,
					log_by INT(11) NOT NULL,
					log_extra_id INT NULL,
					PRIMARY KEY (log_id),
					UNIQUE ( `log_id`  )
					);";
			$wpdb->query($sql);
		} 
	}


	/**
	 * Uninstall plugin on plugin activation
	 */
	function uninstall() {
		global $wpdb;
		if($wpdb->get_var("SHOW TABLES LIKE '".TODO_ITEMS."'") == TODO_ITEMS ) {
			$sql = "DROP TABLE ". TODO_ITEMS ." ";
			$wpdb->query($sql);
		} 
		if($wpdb->get_var("SHOW TABLES LIKE '".TODO_LOG."'") == TODO_LOG ) {
			$sql = "DROP TABLE ". TODO_LOG ." ";
			$wpdb->query($sql);
		} 
	}


}

?>