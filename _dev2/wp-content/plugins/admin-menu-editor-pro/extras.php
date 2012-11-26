<?php

class wsMenuEditorExtras {
	private $framed_pages;
	private $ozhs_new_window_menus;
	protected $export_settings;
	
	private $slug = 'admin-menu-editor-pro';
	private $secret = '1kuh432KwnufZ891432uhg32';
	
  /**
   * Class constructor.
   *
   * @return void
   */
	function wsMenuEditorExtras(){
		//Allow the usage of shortcodes in the admin menu
		add_filter('custom_admin_menu', array(&$this, 'do_shortcodes'));
		add_filter('custom_admin_submenu', array(&$this, 'do_shortcodes'));
		
		//Add some extra shortcodes of our own
		$shortcode_callback = array(&$this, 'handle_shortcode');
		$info_shortcodes = array(
			'wp-wpurl',    //WordPress address (URI), as returned by get_bloginfo()
			'wp-siteurl',  //Blog address (URI)
			'wp-admin',    //Admin area URL (with a trailing slash)
			'wp-name',     //Weblog title
			'wp-version',  //Current WP version
		);
		foreach($info_shortcodes as $tag){
			add_shortcode($tag, $shortcode_callback);
		}
		
		//Flag menus that are set to open in a new window so that we can later find
		//and modify them with JS. This is necessary because there is no practical 
		//way to intercept and modify the menu HTML with PHP alone. 
		add_filter('custom_admin_menu', array(&$this, 'flag_new_window_menus'));
		add_filter('custom_admin_submenu', array(&$this, 'flag_new_window_menus'));
		//Output the menu-modification JS after the menu has been generated.
		//'admin_notices' is, AFAIK, the action that fires the soonest after menu
		//output has been completed, so we use that.
		add_action('admin_notices', array(&$this, 'fix_flagged_menus'));
		//A list of IDs for menu items output by Ozh's Admin Drop Down Menu
		//(those can't be modified the usual way because Ozh's plugin strips tags
		//from submenu titles).
		$this->ozhs_new_window_menus = array();
		
		//Handle pages that need to be displayed in a frame.
		$this->framed_pages = array();		
		add_filter('custom_admin_menu', array(&$this, 'create_framed_menu'));
		add_filter('custom_admin_submenu', array(&$this, 'create_framed_item'), 10, 2);
		
		//Import/export settings
		$this->export_settings = array(
		 	'max_file_size' => 1024*512,
		    'file_extension' => 'dat',
		    'format_string' => 'wsMenuEditor_ExportFile',
		);
		
		//Insert the import and export dialog HTML into the editor's page
		add_action('admin_menu_editor_footer', array(&$this, 'menu_editor_footer'));
		//Handle menu downloads and uploads
		add_action('admin_menu_editor_header', array(&$this, 'menu_editor_header'));
		//Handle export requests
		add_action( 'wp_ajax_export_custom_menu', array(&$this,'ajax_export_custom_menu') );
		//Add the "Import" and "Export" buttons
		add_action('admin_menu_editor_sidebar', array(&$this, 'add_extra_buttons'));
		
		//Allow usernames to be used in the "Required capability" field. Syntax : "user:user_login"
		add_filter('user_has_cap', array(&$this, 'hook_user_has_cap'), 10, 3); 
		
		add_filter('admin_menu_editor-self_page_title', array(&$this, 'pro_page_title'));
		add_filter('admin_menu_editor-self_menu_title', array(&$this, 'pro_menu_title'));
		
		//Tack on some extra validation data when querying our custom update API
		//add_filter('custom_plugins_api_options', array(&$this, 'custom_api_options'), 10, 3);
		
		add_filter('admin_menu_editor_is_pro', array(&$this, 'is_pro_version'));
	}
	
  /**
   * Process shortcodes in menu fields
   *
   * @param array $item
   * @return array
   */
	function do_shortcodes($item){
		foreach($item as $field => $value){
			if ( is_string($value) ){
				$item[$field] = do_shortcode($value);
			}
		}
		return $item;
	}
	
  /**
   * Get the value of one of our extra shortcodes
   *
   * @param array $atts Shortcode attributes (ignored)
   * @param string $content Content enclosed by the shortcode (ignored)
   * @param string $code 
   * @return string Shortcode will be replaced with this value
   */
	function handle_shortcode($atts, $content=null, $code=''){
		//The shortcode tag can be either $code or the zeroth member of the $atts array.
		if ( empty($code) ){
			$code = isset($atts[0])?$atts[0]:'';
		}
		
		$info = '['.$code.']'; //Default value
		switch($code){
			case 'wp-wpurl':
				$info = get_bloginfo('wpurl');
				break;
				
			case 'wp-siteurl':
				$info = get_bloginfo('url');
				break;
				
			case 'wp-admin':
				$info = admin_url();
				break;
				
			case 'wp-name':
				$info = get_bloginfo('name');
				break;
				
			case 'wp-version':
				$info = get_bloginfo('version');
				break;
		}
		
		return $info;
	}
	
	/**
	 * Flag menus (and menu items) that are set to open in a new window
	 * so that they can be identified later. 
	 * 
	 * Adds a <span class="ws-new-window-please"></span> element to the title
	 * of each detected menu.  
	 * 
	 * @param array $item
	 * @return array
	 */
	function flag_new_window_menus($item){
		global $wp_menu_editor;
		
		$open_in = $wp_menu_editor->get_menu_field($item, 'open_in', 'same_window');
		if ( $open_in == 'new_window' ){
			$old_title = $wp_menu_editor->get_menu_field($item, 'menu_title', '');
			$item['menu_title'] = $old_title . '<span class="ws-new-window-please" style="display:none;"></span>';
			
			//For compatibility with Ozh's Admin Drop Down menu, record the link ID that will be
			//assigned to this item. This lets us modify it later.
			if ( function_exists('wp_ozh_adminmenu_sanitize_id') ){
				$subid = 'oamsub_'.wp_ozh_adminmenu_sanitize_id(
					$wp_menu_editor->get_menu_field($item, 'file', '')
				); 
				$this->ozhs_new_window_menus[] = '#' . str_replace(
					array(':', '&'), 
					array('\\\\:', '\\\\&'), 
					$subid
				);
			}
		}
				
		return $item;	
	}
	
	/**
	 * Output a piece of JS that will find flagged menu links and make them 
	 * open in a new window. 
	 * 
	 * @return void
	 */
	function fix_flagged_menus(){
		?>
		<script type="text/javascript">
		(function($){
			$('#adminmenu span.ws-new-window-please, #ozhmenu span.ws-new-window-please').each(function(index){
				var marker = $(this);
				//Add target="_blank" to the enclosing link
				marker.parents('a').first().attr('target', '_blank');
				//And to the menu image link, too (only for top-level menus)
				marker.parent().parent().find('> .wp-menu-image a').attr('target', '_blank');
				//Get rid of the marker
				marker.remove();
			});
			
			<?php if ( !empty($this->ozhs_new_window_menus) ): ?>
			
			$('<?php echo implode(', ', $this->ozhs_new_window_menus); ?>').each(function(index){
				//Add target="_blank" to the link
				$(this).find('a').attr('target', '_blank');
			});
											
			<?php endif; ?>
		})(jQuery);
		</script>
		<?php
	}  
	
	/**
	 * Intercept menus that need to be displayed in an IFrame.
	 * 
	 * Here's how this works : each item that needs to be displayed in an IFrame 
	 * gets added as a new menu (or submenu) using the standard WP plugin API. 
	 * This ensures that the myriad undocumented data structures that WP employs 
	 * for menu generation get populated correctly. 
	 * 
	 * The reason why this doesn't lead to menu duplication is that the global $menu
	 * and $submenu arrays are thrown away and replaced with custom-generated ones 
	 * shortly afterwards. The modified menu entry returned by this function becomes 
	 * part of that custom menu.
	 * 
	 * All items added in this way have the same callback function - wsMenuEditorExtras::display_framed_page()
	 * 
	 * @param array $item
	 * @return array
	 */
	function create_framed_menu($item){
		global $wp_menu_editor;
		
		if ( $item['open_in'] == 'iframe' ){
			$slug = 'framed-menu-' . md5($item['file']);//MD5 should be unique enough
			$this->framed_pages[$slug] = $item; //Used by the callback function
			
			//Default to using menu title for page title, if no custom title specified 
			if ( empty($item['page_title']) ) {
				$item['page_title'] = $item['menu_title'];
			}
			
			//Add a virtual menu. The menu record created by add_menu_page will be
			//thrown away; what matters is that this populates other structures
			//like $_registered_pages.
			add_menu_page(
				$item['page_title'],
				$item['menu_title'],
				$item['access_level'],
				$slug,
				array(&$this, 'display_framed_page')
			);
			
			//Change the slug to our newly created page.
			$item['file'] = $slug;
		}
		
		return $item;
	}
	
	/**
	 * Intercept menu items that need to be displayed in an IFrame.
	 * 
	 * @see wsMenuEditorExtras::create_framed_menu()
	 * 
	 * @param array $item
	 * @param string $parent_file
	 * @return array
	 */
	function create_framed_item($item, $parent_file = null){
		global $wp_menu_editor;
		
		if ( ($item['open_in'] == 'iframe') && !empty($parent_file) ){
			
			$slug = 'framed-menu-item-' . md5($item['file'] . '|' . $parent_file);
			$this->framed_pages[$slug] = $item;
			
			if ( empty($item['page_title']) ) {
				$item['page_title'] = $item['menu_title'];
			}
			add_submenu_page(
				$parent_file,
				$item['page_title'],
				$item['menu_title'],
				$item['access_level'],
				$slug,
				array(&$this, 'display_framed_page')
			);
			
			$item['file'] = $slug;
		}
		
		return $item;
	}
	
	/**
	 * Display a page in an IFrame.
	 * This callback is used by all menu items that are set to open in a frame.
	 * 
	 * @return void
	 */
	function display_framed_page(){
		global $plugin_page;
		
		if ( isset($this->framed_pages[$plugin_page]) ){
			$item = $this->framed_pages[$plugin_page];
		} else {
			return;
		}
		
		if ( !current_user_can($item['access_level']) ){
			echo "You do not have sufficient permissions to view this page.";
			return;
		}
		
		$heading = !empty($item['page_title'])?$item['page_title']:$item['menu_title']; 
		?>
		<div class="wrap">
		<h2><?php echo $heading; ?></h2>
		<iframe 
			src="<?php echo esc_attr($item['file']); ?>" 
			style="border: none; width: 100%; min-height:300px;"
			id="ws-framed-page"
			frameborder="0" 
		></iframe>
		</div>
		<script>
		function wsResizeFrame(){
			var $ = jQuery;
			var footer = $('#footer');
			var frame = $('#ws-framed-page');
			frame.height( footer.offset().top - frame.offset().top - 10 );
		}
		
		jQuery(function($){
			wsResizeFrame();
			setTimeout(wsResizeFrame, 1000);
		});
		</script>		
		<?php
	}
	
	/**
	 * Output the HTML for import and export dialogs.
	 * Callback for the 'menu_editor_footer' action.
	 * 
	 * @return void
	 */
	function menu_editor_footer(){
		?>
		<div id="export_dialog" title="Export">
	<div class="ws_dialog_panel">
		<div id="export_progress_notice">
			<img src="<?php echo plugins_url('images/spinner.gif', __FILE__); ?>">
			Creating export file...
		</div>
		<div id="export_complete_notice">
			Click the "Download" button below to download the exported admin menu to your computer.
		</div>
	</div>
	<div class="ws_dialog_buttons">
		<a class="button-primary" id="download_menu_button" href="#">Download Export File</a>
		<input type="button" name="cancel" class="button" value="Close" id="ws_cancel_export">
	</div>
</div>

<div id="import_dialog" title="Import">
	<form id="import_menu_form" action="<?php echo esc_attr(admin_url('options-general.php?page=menu_editor&noheader=1')); ?>" method="post">
		<input type="hidden" name="action" value="upload_menu">
		
		<div class="ws_dialog_panel">
			<div id="import_progress_notice">
				<img src="<?php echo plugins_url('images/spinner.gif', __FILE__); ?>">
				Uploading file...
			</div>
			<div id="import_progress_notice2">
				<img src="<?php echo plugins_url('images/spinner.gif', __FILE__); ?>">
				Importing menu...
			</div>
			<div id="import_complete_notice">
				Import Complete!
			</div>
			
			
			<div class="hide-when-uploading">
				Choose an exported menu file (.<?php echo $this->export_settings['file_extension']; ?>) 
				to import: 
				
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo intval($this->export_settings['max_file_size']); ?>"> 
				<input type="file" name="menu" id="import_file_selector" size="35">
			</div>
		</div>
		
		<div class="ws_dialog_buttons">
			<input type="submit" name="upload" class="button-primary hide-when-uploading" value="Upload File" id="ws_start_import">
			<input type="button" name="cancel" class="button" value="Close" id="ws_cancel_import">
		</div>
	</form>
</div>

<script type="text/javascript">
window.wsMenuEditorPro = true;

var exportFormatString = '<?php echo esc_js($this->export_settings['format_string']); ?>';
var exportMenuNonce = "<?php echo esc_js(wp_create_nonce('export_custom_menu'));  ?>";
var menuUploadHandler = "<?php echo ('options-general.php?page=menu_editor&noheader=1'); ?>";
var importMenuNonce = "<?php echo esc_js(wp_create_nonce('import_custom_menu'));  ?>";
</script>
		<?php
	}
	
    /**
     * Prepare a custom menu for export. 
     *
     * Expects menu data to be in $_POST['menu'].
     * Outputs a JSON-encoded object with three fields : 
     * 	download_url - the URL that can be used to download the exported menu.
     *	filename - export file name.
     *	filesize - export file size (in bytes).
     *
     * If something goes wrong, the response object will contain an 'error' field with an error message.
     *
     * @return void
     */
	function ajax_export_custom_menu(){
		global $wp_menu_editor;
		
		if (!current_user_can('manage_options') || !check_ajax_referer('export_custom_menu', false, false)){
			die( $wp_menu_editor->json_encode( array(
				'error' => __("You're not allowed to do that!", 'admin-menu-editor') 
			)));
		}
		
		//Prepare the export record.
		$export = $this->get_exported_menu();
		$export['total']++;               //Export counter. Used to make download URLs unique.
		$export['menu'] = $_POST['data']; //Save the menu structure.
		
		//Include the blog's domain name in the export filename to make it easier to 
		//distinguish between multiple export files.
		$siteurl = get_bloginfo('url');
		$domain = @parse_url($siteurl);
		$domain = isset($domain['host']) ? ($domain['host'] . ' ') : '';
		
		$export['filename'] = sprintf(
			'%sadmin menu (%s).dat',
			$domain,
			date('Y-m-d')
		);
		
		//Store the modified export record. The plugin will need it when the user 
		//actually tries to download the menu. 
		$this->set_exported_menu($export);
		
		$download_url = sprintf(
			'options-general.php?page=menu_editor&noheader=1&action=download_menu&export_num=%d',
			$export['total']
		);
		$download_url = admin_url($download_url);
		
		$result = array(
			'download_url' => $download_url,
			'filename' => $export['filename'],
			'filesize' => strlen($export['menu']),
		);
		
		die($wp_menu_editor->json_encode($result));
	}
	
    /**
     * Get the current exported record
     *
     * @return array
     */
	function get_exported_menu(){
		$user = wp_get_current_user();
		$exports = get_metadata('user', $user->ID, 'custom_menu_export', true);
		
		$defaults = array(
			'total' => 0,
			'menu' => '',
			'filename' => '',
		);
		
		if ( !is_array($exports) ){
			$exports = array();
		}
		
		return array_merge($defaults, $exports);
	}
	
    /**
     * Store the export record.
     *
     * @param array $export
     * @return bool
     */
	function set_exported_menu($export){
		$user = wp_get_current_user();
		return update_metadata('user', $user->ID, 'custom_menu_export', $export);
	}
	
	/**
	 * Handle menu uploads and downloads.
	 * This is a callback for the 'admin_menu_editor_header' action.
	 * 
	 * @param string $action
	 * @return void
	 */
	function menu_editor_header($action = ''){
		global $wp_menu_editor;
		
		//Handle menu download requests
		if ( $action == 'download_menu' ){
			$export = $this->get_exported_menu();
			if ( empty($export['menu']) || empty($export['filename']) ){
				die("Exported data not found");
			}
			
			//Force file download
		    header("Content-Description: File Transfer");
		    header('Content-Disposition: attachment; filename="' . $export['filename'] . '"');
		    header("Content-Type: application/force-download");
		    header("Content-Transfer-Encoding: binary");
		    header("Content-Length: " . strlen($export['menu']));
		    
		     /* The three lines below basically make the download non-cacheable */
			header("Cache-control: private");
			header("Pragma: private");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		    
		    echo $export['menu'];
			
			die();
		
		//Handle menu uploads
		} elseif ( $action == 'upload_menu' ) {	
		    
		    header('Content-Type: text/html');
		    
		    if ( empty($_FILES['menu']) ){
				echo $wp_menu_editor->json_encode(array('error' => "No file specified"));
				die();
			}
			
			$file_data = $_FILES['menu'];
			if ( filesize($file_data['tmp_name']) > $this->export_settings['max_file_size'] ){
				echo '<textarea>', $wp_menu_editor->json_encode(array('error' => "File too big")), '</textarea>';
				die();
			}
			//TODO: Check extension
			
			$file_contents = file_get_contents($file_data['tmp_name']);
			
			//Check if this file could plausibly contain an exported menu 
			if ( strpos($file_contents, $this->export_settings['format_string']) === false ){
				echo '<textarea>', $wp_menu_editor->json_encode(array('error' => "Unknown file format")), '</textarea>';
				die();
			}
			//Try decoding it
			$menu = @$wp_menu_editor->json_decode($file_contents, true);
			//Run some basic (*very* basic) sanity-checks to make sure the menu is okay
			if ( !is_array($menu) || empty($menu['menu']) || !is_array($menu['menu']) ){
				echo '<textarea>', $wp_menu_editor->json_encode(array('error' => "Unknown file format or file damaged")), '</textarea>';
				die();
			}
			
			//Ensure the structure is up to date
			$menu['menu'] = $wp_menu_editor->upgrade_menu_structure($menu['menu']);			
			
			//Everything looks okay, send back the menu data
			$response = array(
				'menu' => $menu['menu'],
			);
			die ( '<textarea>' . ($wp_menu_editor->json_encode($response)) . '</textarea>' );
		}
	}
	
	/**
	 * Output the "Import" and "Export" buttons.
	 * Callback for the 'admin_menu_editor_sidebar' action.
	 * 
	 * @return void
	 */
	function add_extra_buttons(){
		?>
		<input type="button" id='ws_export_menu' value="Export" class="button ws_main_button" title="Export current menu" />
		<input type="button" id='ws_import_menu' value="Import" class="button ws_main_button" />
		<?php
	}
	
	function hook_user_has_cap($allcaps, $caps, $args){
		//Add "user:user_login" to the user's capabilities. This makes it possible to restrict
		//menu access on a per-user basis.
		
		//The second entry of the $args array should be the user ID
		if ( count($args) < 2 ){
			return $allcaps;
		}
		$id = intval($args[1]);
		
		//Get the username & add it as a valid cap
		$user = get_userdata($id);
		if ( $user && isset($user->user_login) && is_string($user->user_login) ){
			$allcaps['user:' . $user->user_login] = true;
		}
				
		return $allcaps;
	}
	
	function pro_page_title($default_title){
		return 'Menu Editor Pro';
	}
	
	function pro_menu_title($default_title){
		return 'Menu Editor Pro';
	}
	
	/**
	 * Add extra verification args to custom update API requests.
	 * 
	 * When checking for updates, send along the blog URL and a hash of that URL + a secret key.
	 * The API endpoint can use this info to verify that the request really came from a valid
	 * installation of the "Pro" version of the plugin. 
	 * 
	 * Admittedly, it would be easy to spoof. Better than nothing nevertheless ;)
	 * 
	 * @param array $options
	 * @param string $api
	 * @param string $resource
	 * @return array
	 */
	function custom_api_options($options, $api = '', $resource = ''){
		if ( isset($options['slug']) && ($options['slug'] == $this->slug) ){
			$extra_args = array(
				'blogurl' => get_bloginfo('url'),
				'secret_hash' => sha1(get_bloginfo('url') . '|' . $this->secret),
			);
			$options['query_args'] = array_merge(
				$options['query_args'],
				$extra_args
			);
		}
		
		return $options;
	}
	
  /**
   * Callback for the 'admin_menu_editor_is_pro' hook. Always returns True to indicate that
   * the Pro version extras are installed.
   *
   * @param bool $value
   * @return bool True
   */
	function is_pro_version($value){
		return true;
	}
}

//Initialize extras
$wsMenuEditorExtras = new wsMenuEditorExtras();

//Load the custom update checker (requires PHP 5)
if ( (version_compare(PHP_VERSION, '5.0.0', '>=')) && (is_admin() || (defined('DOING_CRON') && DOING_CRON)) && isset($wp_menu_editor) ){
	require 'plugin-updates/plugin-update-checker.php';
	$ameProUpdateChecker = new PluginUpdateChecker(
		'http://w-shadow.com/admin-menu-editor-pro/admin-menu-editor-pro.json', 
		$wp_menu_editor->plugin_file, //Note: This variable is set in the framework constructor
		'admin-menu-editor-pro',
		12,                        //check every 12 hours
		'ame_pro_external_updates' //store book-keeping info in this WP option
	);

	//Hack. See PluginUpdateChecker::installHooks().
	function wsDisableAmeCron(){
		wp_clear_scheduled_hook('check_plugin_updates-admin-menu-editor-pro');
	}
	register_deactivation_hook($wp_menu_editor->plugin_file, 'wsDisableAmeCron');
}

?>