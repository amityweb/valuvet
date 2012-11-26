<?php
/*
Plugin Name: To Do general
Version: 3.0.0
Description: Manage to do list 
Author: D.N Udugala
*/

define('TODO_ITEMS', 'todo_items_table');
define('TODO_LOG', 'todo_log_table');
require_once( 'includes/to-do-class.php' );


register_activation_hook( __FILE__, 'todo_general_install' );
register_deactivation_hook( __FILE__, 'todo_general_uninstall' );
function todo_general_install(){
	if( class_exists('todo_class') ) $todo_class = new todo_class();
	$todo_class->install();
}

function todo_general_uninstall(){
	if( class_exists('todo_class') ) $todo_class = new todo_class();
	$todo_class->uninstall();
}


add_action( 'init', 'todo_loader' );
function todo_loader(){
global $current_user, $args,$eqfs_message;
	global $todo_class;
	if( class_exists('todo_class') ) $todo_class = new todo_class();
	if( isset($_POST['todo-process']) && $_POST['todo-process']=='todo-process-update' ){
		$todo_class->dashboard_updates();
	}
	if( isset($_POST['pslog-process']) && $_POST['pslog-process']=='log-process-update' ){
		$todo_class->ps_dashboard_updates();
	}
}



?>