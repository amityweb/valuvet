<?php
/*
Plugin Name: Navayan CSV Export
Plugin URI: http://blog.navayan.com/
Description: Navayan CSV Export to export all your table data in CSV (Comma Separate Value) format. You can save an exported CSV file of any table in 'table_name_YYYYMMDD_Hi.csv' format
Version: 1.0.5
Author: Amol Nirmala Waman
Author URI: http://www.navayan.com/
*/

/* ADD MENU TO TOOLS */
if(!function_exists('ny_csv_menu')){
    function ny_csv_menu() {
        if ( function_exists('add_submenu_page') ){
            add_management_page( __('Navayan CSV Export','navayan-csv-export'), __('Navayan CSV Export','navayan-csv-export'), 'manage_options', '', 'fn_ny_csv_ui');
        }
    }
}
add_action('admin_menu', 'ny_csv_menu');

/* GENERATE USER INTERFACE */
if(!function_exists('fn_ny_csv_ui')){
    function fn_ny_csv_ui(){
        if(file_exists(WP_PLUGIN_DIR.'/navayan-csv-export/ny-csv-ui.php')){
            include_once(WP_PLUGIN_DIR.'/navayan-csv-export/ny-csv-ui.php');
        }
    }
}

/* GET CSV DATA */
if(!function_exists('fn_ny_csv_export')){
    function fn_ny_csv_export(){        
        include_once(WP_PLUGIN_DIR . "/navayan-csv-export/ny-csv-generate.php");
        $req_table = isset($_REQUEST['nycsv']) ? $_REQUEST['nycsv'] : '';
        if ($req_table){          
            echo fn_ny_csv_gen($req_table);
            exit;
        }
    }
}
add_action('init', 'fn_ny_csv_export');
?>