<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');


/**
 * User defined custom taxonomies
 */

$post_type = TF_SEEK_HELPER::get_post_type();

register_taxonomy($post_type . '_category', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Categories'),
        'singular_name'             => __('Category'),
        'search_items'              => __('Search Categories'),
        'all_items'                 => __('All Categories'),
        'parent_item'               => __('Parent Category'),
        'parent_item_colon'         => __('Parent Category:'),
        'edit_item'                 => __('Edit Category'),
        'update_item'               => __('Update Category'),
        'add_new_item'              => __('Add New Category'),
        'new_item_name'             => __('New Category Name'),
        'choose_from_most_used'     => __('Choose from the most used categories'),
        'separate_items_with_commas'=> __('Separate categories with commas')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
register_taxonomy($post_type . '_locations', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Locations'),
        'singular_name'             => __('Location'),
        'search_items'              => __('Search Locations'),
        'all_items'                 => __('All Locations'),
        'parent_item'               => __('Parent Location'),
        'parent_item_colon'         => __('Parent Location:'),
        'edit_item'                 => __('Edit Location'),
        'update_item'               => __('Update Location'),
        'add_new_item'              => __('Add New Location'),
        'new_item_name'             => __('New Location Name'),
        'choose_from_most_used'     => __('Choose from the most used locations'),
        'separate_items_with_commas'=> __('Separate location with commas')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
register_taxonomy($post_type . '_rooms', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Rooms'),
        'singular_name'             => __('Room'),
        'search_items'              => __('Search Rooms'),
        'all_items'                 => __('All Rooms'),
        'parent_item'               => __('Parent Room'),
        'parent_item_colon'         => __('Parent Room:'),
        'edit_item'                 => __('Edit Room'),
        'update_item'               => __('Update Room'),
        'add_new_item'              => __('Add New Room'),
        'new_item_name'             => __('New Room Name'),
        'choose_from_most_used'     => __('Choose from the most used rooms'),
        'separate_items_with_commas'=> __('Separate rooms with commas')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
register_taxonomy($post_type . '_amenities', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Amenities'),
        'singular_name'             => __('Room'),
        'search_items'              => __('Search Amenities'),
        'all_items'                 => __('All Amenities'),
        'parent_item'               => __('Parent Room'),
        'parent_item_colon'         => __('Parent Room:'),
        'edit_item'                 => __('Edit Room'),
        'update_item'               => __('Update Room'),
        'add_new_item'              => __('Add New Room'),
        'new_item_name'             => __('New Room Name'),
        'choose_from_most_used'     => __('Choose from the most used amenities'),
        'separate_items_with_commas'=> __('Separate amenities with commas')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
register_taxonomy($post_type . '_agents', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Agents'),
        'singular_name'             => __('Agent'),
        'search_items'              => __('Search Agents'),
        'all_items'                 => __('All Agents'),
        'parent_item'               => __('Parent Agent'),
        'parent_item_colon'         => __('Parent Agent:'),
        'edit_item'                 => __('Edit Agent'),
        'update_item'               => __('Update Agent'),
        'add_new_item'              => __('Add New Agent'),
        'new_item_name'             => __('New Agent Name'),
        'choose_from_most_used'     => __('Choose from the most used agents'),
        'separate_items_with_commas'=> __('Separate agents with commas')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
register_taxonomy($post_type . '_styles', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Styles'),
        'singular_name'             => __('Style'),
        'search_items'              => __('Search Styles'),
        'all_items'                 => __('All Styles'),
        'parent_item'               => __('Parent Style'),
        'parent_item_colon'         => __('Parent Style:'),
        'edit_item'                 => __('Edit Style'),
        'update_item'               => __('Update Style'),
        'add_new_item'              => __('Add New Style'),
        'new_item_name'             => __('New Style Name'),
        'choose_from_most_used'     => __('Choose from the most used styles'),
        'separate_items_with_commas'=> __('Separate styles with commas')
    ),
    'show_ui'       => true,
    'query_var'     => true
));
register_taxonomy($post_type . '_features', array($post_type), array(
    'hierarchical'  => true,
    'labels'        => array(
        'name'                      => __('Features'),
        'singular_name'             => __('Feature'),
        'search_items'              => __('Search Features'),
        'all_items'                 => __('All Features'),
        'parent_item'               => __('Parent Feature'),
        'parent_item_colon'         => __('Parent Feature:'),
        'edit_item'                 => __('Edit Feature'),
        'update_item'               => __('Update Feature'),
        'add_new_item'              => __('Add New Feature'),
        'new_item_name'             => __('New Feature Name'),
        'choose_from_most_used'     => __('Choose from the most used features'),
        'separate_items_with_commas'=> __('Separate features with commas')
    ),
    'show_ui'       => true,
    'query_var'     => true
));