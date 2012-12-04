<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');


/**
 * User defined custom taxonomies
 */
global $seek_post_type;
$post_type = TF_SEEK_HELPER::get_post_type();
$seek_post_type = $post_type;
register_taxonomy($post_type . '_category', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Categories','tfuse'),
        'singular_name'             => __('Category','tfuse'),
        'search_items'              => __('Search Categories','tfuse'),
        'all_items'                 => __('All Categories','tfuse'),
        'parent_item'               => __('Parent Category','tfuse'),
        'parent_item_colon'         => __('Parent Category:','tfuse'),
        'edit_item'                 => __('Edit Category','tfuse'),
        'update_item'               => __('Update Category','tfuse'),
        'add_new_item'              => __('Add New Category','tfuse'),
        'new_item_name'             => __('New Category Name','tfuse'),
        'choose_from_most_used'     => __('Choose from the most used categories','tfuse'),
        'separate_items_with_commas'=> __('Separate categories with commas','tfuse')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
add_action( $post_type . '_category_add_form', 'tfuse_taxonomy_redirect_note_form_3',10);
register_taxonomy($post_type . '_locations', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Locations','tfuse'),
        'singular_name'             => __('Location','tfuse'),
        'search_items'              => __('Search Locations','tfuse'),
        'all_items'                 => __('All Locations','tfuse'),
        'parent_item'               => __('Parent Location','tfuse'),
        'parent_item_colon'         => __('Parent Location:','tfuse'),
        'edit_item'                 => __('Edit Location','tfuse'),
        'update_item'               => __('Update Location','tfuse'),
        'add_new_item'              => __('Add New Location','tfuse'),
        'new_item_name'             => __('New Location Name','tfuse'),
        'choose_from_most_used'     => __('Choose from the most used locations','tfuse'),
        'separate_items_with_commas'=> __('Separate location with commas','tfuse')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
add_action( $post_type . '_locations_add_form', 'tfuse_taxonomy_redirect_note_form_1',10);
register_taxonomy($post_type . '_rooms', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Rooms','tfuse'),
        'singular_name'             => __('Room','tfuse'),
        'search_items'              => __('Search Rooms','tfuse'),
        'all_items'                 => __('All Rooms','tfuse'),
        'parent_item'               => __('Parent Room','tfuse'),
        'parent_item_colon'         => __('Parent Room:','tfuse'),
        'edit_item'                 => __('Edit Room','tfuse'),
        'update_item'               => __('Update Room','tfuse'),
        'add_new_item'              => __('Add New Room','tfuse'),
        'new_item_name'             => __('New Room Name','tfuse'),
        'choose_from_most_used'     => __('Choose from the most used rooms','tfuse'),
        'separate_items_with_commas'=> __('Separate rooms with commas','tfuse')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
add_action( $post_type . '_rooms_add_form', 'tfuse_taxonomy_redirect_note_form_1',10);
register_taxonomy($post_type . '_amenities', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Amenities','tfuse'),
        'singular_name'             => __('Amenity','tfuse'),
        'search_items'              => __('Search Amenities','tfuse'),
        'all_items'                 => __('All Amenities','tfuse'),
        'parent_item'               => __('Parent Amenity','tfuse'),
        'parent_item_colon'         => __('Parent Amenity:','tfuse'),
        'edit_item'                 => __('Edit Amenity','tfuse'),
        'update_item'               => __('Update Amenity','tfuse'),
        'add_new_item'              => __('Add New Amenity','tfuse'),
        'new_item_name'             => __('New Amenity Name','tfuse'),
        'choose_from_most_used'     => __('Choose from the most used amenities','tfuse'),
        'separate_items_with_commas'=> __('Separate amenities with commas','tfuse')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
add_action( $post_type . '_amenities_add_form', 'tfuse_taxonomy_redirect_note_form_2',10);
register_taxonomy($post_type . '_agents', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Agents','tfuse'),
        'singular_name'             => __('Agent','tfuse'),
        'search_items'              => __('Search Agents','tfuse'),
        'all_items'                 => __('All Agents','tfuse'),
        'parent_item'               => __('Parent Agent','tfuse'),
        'parent_item_colon'         => __('Parent Agent:','tfuse'),
        'edit_item'                 => __('Edit Agent','tfuse'),
        'update_item'               => __('Update Agent','tfuse'),
        'add_new_item'              => __('Add New Agent','tfuse'),
        'new_item_name'             => __('New Agent Name','tfuse'),
        'choose_from_most_used'     => __('Choose from the most used agents','tfuse'),
        'separate_items_with_commas'=> __('Separate agents with commas','tfuse')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
add_action( $post_type . '_agents_add_form', 'tfuse_taxonomy_redirect_note_form_1',10);
register_taxonomy($post_type . '_styles', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Styles','tfuse'),
        'singular_name'             => __('Style','tfuse'),
        'search_items'              => __('Search Styles','tfuse'),
        'all_items'                 => __('All Styles','tfuse'),
        'parent_item'               => __('Parent Style','tfuse'),
        'parent_item_colon'         => __('Parent Style:','tfuse'),
        'edit_item'                 => __('Edit Style','tfuse'),
        'update_item'               => __('Update Style','tfuse'),
        'add_new_item'              => __('Add New Style','tfuse'),
        'new_item_name'             => __('New Style Name','tfuse'),
        'choose_from_most_used'     => __('Choose from the most used styles','tfuse'),
        'separate_items_with_commas'=> __('Separate styles with commas','tfuse')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
add_action( $post_type . '_styles_add_form', 'tfuse_taxonomy_redirect_note_form_1',10);
register_taxonomy($post_type . '_features', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Features','tfuse'),
        'singular_name'             => __('Feature','tfuse'),
        'search_items'              => __('Search Features','tfuse'),
        'all_items'                 => __('All Features','tfuse'),
        'parent_item'               => __('Parent Feature','tfuse'),
        'parent_item_colon'         => __('Parent Feature:','tfuse'),
        'edit_item'                 => __('Edit Feature','tfuse'),
        'update_item'               => __('Update Feature','tfuse'),
        'add_new_item'              => __('Add New Feature','tfuse'),
        'new_item_name'             => __('New Feature Name','tfuse'),
        'choose_from_most_used'     => __('Choose from the most used features','tfuse'),
        'separate_items_with_commas'=> __('Separate features with commas','tfuse')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
add_action( $post_type . '_features_add_form', 'tfuse_taxonomy_redirect_note_form_1',10);
function tfuse_taxonomy_redirect_note_form_1($taxonomy){
    global $seek_post_type;
    $taxonomy = str_replace($seek_post_type . '_','',$taxonomy);
    $taxonomy = substr_replace($taxonomy ,"",-1);
    $taxonomy = mb_ucfirst($taxonomy);
    echo '<p><strong>Note:</strong> More options are available after you add the '.$taxonomy.'. <br />
        Click on the Edit button under the '.$taxonomy.' name.</p>';
}
function tfuse_taxonomy_redirect_note_form_2($taxonomy){
    global $seek_post_type;
    $taxonomy = str_replace($seek_post_type . '_','',$taxonomy);
    $taxonomy = substr_replace($taxonomy ,"",-3);
    $taxonomy .= 'y';
    $taxonomy = mb_ucfirst($taxonomy);
    echo '<p><strong>Note:</strong> More options are available after you add the '.$taxonomy.'. <br />
        Click on the Edit button under the '.$taxonomy.' name.</p>';
}
function tfuse_taxonomy_redirect_note_form_3($taxonomy){
    global $seek_post_type;
    $taxonomy = str_replace($seek_post_type . '_','',$taxonomy);
    $taxonomy = mb_ucfirst($taxonomy);
    echo '<p><strong>Note:</strong> More options are available after you add the '.$taxonomy.'. <br />
        Click on the Edit button under the '.$taxonomy.' name.</p>';
}