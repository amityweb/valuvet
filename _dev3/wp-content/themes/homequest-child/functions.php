<?php

/**
 * WARNING: This file is part of the core ThemeFuse Framework. It is not recommended to edit this section
 *
 * @package ThemeFuse
 * @since 2.0
 */
require_once(TEMPLATEPATH . '/framework/BootsTrap.php');
require_once(TEMPLATEPATH . '/theme_config/theme_includes/AJAX_CALLBACKS.php');


function sortIt($sortType) {

    if (strcmp($sortType, 'latest') == 0 )
    {
        $the_query = new WP_Query( array( 'post_type' => 'property', 'posts_per_page' => 5, 'paged' => $paged ) );

    }

    if (strcmp($sortType, 'price-high-low') == 0 )
    {
        $the_query = new WP_Query( array( 'post_type' => 'property', 'posts_per_page' => 5, 'paged' => $paged, 'orderby' => 'meta_value_num', 'meta_key' => 'property_value', 'order'=> 'DESC') );
    }

    if (strcmp($sortType, 'price-low-high') == 0 )
    {
        $the_query = new WP_Query( array( 'post_type' => 'property', 'posts_per_page' => 5, 'paged' => $paged, 'orderby' => 'meta_value_num', 'meta_key' => 'property_value', 'order'=> 'ASC') );
    }

    return $the_query;
}