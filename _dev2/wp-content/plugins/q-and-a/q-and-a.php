<?php
/*
Plugin Name: Q and A
Description: Add FAQs using custom posts & a shortcode, reorder faqs by category 
Author: Raygun
Author URI: http://madebyraygun.com
Plugin URI: http://madebyraygun.com/wordpress/plugins/q-and-a/
Version: 0.2.5
*/ 

require_once(dirname(__FILE__).'/reorder.php');

$qa_version = "0.2.5";
// add our default options if they're not already there:
if (get_option('qa_version')  != $qa_version) {
    update_option('qa_version', $qa_version);}
   
// now let's grab the options table data
$qa_version = get_option('qa_version');

add_action( 'init', 'create_qa_post_types' );
function create_qa_post_types() {
	 $labels = array(
		'name' => _x( 'FAQ Categories', 'taxonomy general name' ),
		'singular_name' => _x( 'FAQ Category', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search FAQ Categories' ),
		'all_items' => __( 'All FAQ Categories' ),
		'parent_item' => __( 'Parent FAQ Category' ),
		'parent_item_colon' => __( 'Parent FAQ Category:' ),
		'edit_item' => __( 'Edit FAQ Category' ), 
		'update_item' => __( 'Update FAQ Category' ),
		'add_new_item' => __( 'Add New FAQ Category' ),
		'new_item_name' => __( 'New FAQ Category Name' ),
  ); 	
  	register_taxonomy('faq_category',array('qa_faqs'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'faq-category' ),
  ));
	register_post_type( 'qa_faqs',
		array(
			'labels' => array(
				'name' => __( 'FAQs' ),
				'singular_name' => __( 'FAQ' ),
				'edit_item'	=>	__( 'Edit FAQ'),
				'add_new_item'	=>	__( 'Add FAQ')
			),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => 'faq', 'with_front' => false ),
			'taxonomies' => array( 'FAQs '),
			'supports' => array('title','editor','revisions')	
		)
	);
}	


add_action('restrict_manage_posts','restrict_listings_by_categories');
function restrict_listings_by_categories() {
    global $typenow;
    global $wp_query;
    if ($typenow=='qa_faqs') {
        
		$tax_slug = 'faq_category';
        
		// retrieve the taxonomy object
		$tax_obj = get_taxonomy($tax_slug);
		$tax_name = $tax_obj->labels->name;
		// retrieve array of term objects per taxonomy
		$terms = get_terms($tax_slug);

		// output html for taxonomy dropdown filter
		echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
		echo "<option value=''>Show All $tax_name</option>";
		foreach ($terms as $term) {
			// output each select option line, check against the last $_GET to show the current option selected
			echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
		}
		echo "</select>";
    }
}

add_shortcode('qa', 'qa_shortcode');
// define the shortcode function
function qa_shortcode($atts) {
	extract(shortcode_atts(array(
		'cat'	=> '', 
		'id'	=> ''
	), $atts));
		
	// stuff that loads when the shortcode is called goes here
		
		if (!empty($id)) { 
			$qa_faqs = get_posts( array(
			'order'          => 'ASC',
			'orderby' 		 => 'menu_order ID',
			'p'	 			=> $id,
			'post_type'      => 'qa_faqs',
			'post_status'    => null,
			'numberposts'    => -1) );
		} else {		
			$qa_faqs = get_posts( array(
			'order'          => 'ASC',
			'orderby' 		 => 'menu_order ID',
			'faq_category'	 => $cat,
			'post_type'      => 'qa_faqs',
			'post_status'    => null,
			'numberposts'    => -1) );
		} 
		
		global $wpdb; $catname = $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE slug = '$cat'");
		
		if (!empty($cat)) {$qa_shortcode .= '<p class="faq-catname">'.$catname.'</p>';}	
		
		if ($qa_faqs) {
		foreach ($qa_faqs as $qa_faq) {
		
		$postslug = $qa_faq->post_name;
		$title = $qa_faq->post_title;
		$answer = wpautop($qa_faq->post_content);
					
		$qa_shortcode .= '<div class="faq-title"><a href="'.get_bloginfo('wpurl').'?qa_faqs='.$postslug.'">'.$title.'</a></div>';
		$qa_shortcode .= '<div class="faq-answer">'.$answer.'</div>';

		}}  // end slideshow loop
	
	$qa_shortcode = do_shortcode( $qa_shortcode );
	return (__($qa_shortcode));
}//ends the qa_shortcode function

add_filter('manage_edit-qa_faqs_columns', 'qa_columns');
function qa_columns($columns) {
    $columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Question' ),
		'faq_category' => __( 'Categories' ),
		'date' => __( 'Date' )
	);
    return $columns;
}

add_action('manage_posts_custom_column',  'qa_show_columns');
function qa_show_columns($name) {
    global $post;
    switch ($name) {
        case 'faq_category':
            $faq_cats = get_the_terms(0, "faq_category");
			$cats_html = array();
			if(is_array($faq_cats)){
				foreach ($faq_cats as $term)
						array_push($cats_html, '<a href="edit.php?post_type=qa_faqs&faq_category='.$term->slug.'">' . $term->name . '</a>');

				echo implode($cats_html, ", ");
			}
			break;
		default :
			break;	
	}
}

add_shortcode('search-qa', 'qasearch_shortcode');
// define the shortcode function
function qasearch_shortcode($atts) {

		$qasearch_shortcode .= '<form role="search" method="get" id="searchform" action="';
		$qasearch_shortcode .= get_bloginfo ( 'siteurl' ); 
		$qasearch_shortcode .='">
    <div><label class="screen-reader-text" for="s">Search FAQs:</label>
        <input type="text" value="" name="s" id="s" />
        <input type="hidden" name="post_type" value="qa_faqs" />
        <input type="submit" id="searchsubmit" value="Search" />
    </div>
</form>';
		
	return $qasearch_shortcode;
}//ends the qa-search_shortcode function

// scripts to go in the header and/or footer
if( !is_admin()){
	wp_enqueue_script('jquery');
}  // load jQuery.

   wp_register_script('qa',  plugins_url('js/qa.js', __FILE__), false, '0.1.4', true); 
   wp_enqueue_script('qa');

function qa_head() {
	echo '
<!-- loaded by Q and A plugin-->
<link rel="stylesheet" type="text/css" href="' .  get_bloginfo('wpurl') . '/wp-content/plugins/q-and-a/q-and-a.css" />
<!-- end Q and A -->
';
} // ends qa_head function
add_action('wp_head', 'qa_head');

// create the admin menu
// hook in the action for the admin options page
add_action('admin_menu', 'add_qa_option_page');

function add_qa_option_page() {
	// hook in the options page function
	add_options_page('Q and A', 'Q and A', 6, __FILE__, 'qa_options_page');
}

function qa_options_page() { 	// Output the options page
	global $qa_version ?>
	<div class="wrap" style="width:500px">
	<?php screen_icon(); ?>
		<h2>Plugin Reference</h2>
		<p>Use shortcode <code>[qa]</code> to insert your FAQs into a page.</p>
		
		<p>If you want to sort your FAQs into categories, you can optionally use the <code>cat="category-slug"</code> attribute. Example: <code>[qa cat="cheese"]</code> will return only FAQs in the "Cheese" category. You can find the category slug in the <a href="<?php bloginfo('wpurl');?>/wp-admin/edit-tags.php?taxonomy=faq_category&post_type=qa_faqs">FAQ Categories page</a>.
		
		<p>You can also insert a single FAQ with the format <code>[qa id="1234"]</code> where 1234 is the post ID.</p>
		<p>Note: the cat & the id attributes are mutually exclusive. Don't use both in the same shortcode.</p>
		
		<p>Use the shortcode [search-qa] to insert a search form that will search only your FAQs.</p>
		
		
		<p>You're using Q and A v. <?php echo $qa_version;?> by <a href="http://madebyraygun.com">Raygun</a>.
	</div><!--//wrap div-->
<?php } ?>