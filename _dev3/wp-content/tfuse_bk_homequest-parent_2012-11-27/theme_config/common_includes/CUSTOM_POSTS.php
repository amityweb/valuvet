<?php
/**
 * Create custom posts types
 *
 * @since HomeQuest 1.0
 */

if ( !function_exists('tfuse_create_custom_post_types') ) :
    /**
     * Retrieve the requested data of the author of the current post.
     *
     * @param array $fields first_name,last_name,email,url,aim,yim,jabber,facebook,twitter etc.
     * @return null|array The author's spefified fields from the current author's DB object.
     */
    function tfuse_create_custom_post_types()
    {
        // TESTIMONIALS
        $labels = array(
            'name' => _x('Testimonials', 'post type general name', 'tfuse'),
            'singular_name' => _x('Testimonial', 'post type singular name', 'tfuse'),
            'add_new' => __('Add New', 'tfuse'),
            'add_new_item' => __('Add New Testimonial', 'tfuse'),
            'edit_item' => __('Edit Testimonial', 'tfuse'),
            'new_item' => __('New Testimonial', 'tfuse'),
            'all_items' => __('All Testimonials', 'tfuse'),
            'view_item' => __('View Testimonial', 'tfuse'),
            'search_items' => __('Search Testimonials', 'tfuse'),
            'not_found' =>  __('Nothing found', 'tfuse'),
            'not_found_in_trash' => __('Nothing found in Trash', 'tfuse'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'query_var' => true,
            //'menu_icon' => get_template_directory_uri() . '/images/icons/testimonials.png',
            'rewrite' => true,
            'menu_position' => 5,
            'supports' => array('title','editor')
        );

        register_post_type( 'testimonials' , $args );

    }
    tfuse_create_custom_post_types();

endif;

function taxonomy_redirect_note($taxonomy){
    echo '<p><strong>Note:</strong> More options are available after you add the '.$taxonomy.'. <br />
        Click on the Edit button under the '.$taxonomy.' name.</p>';
}
