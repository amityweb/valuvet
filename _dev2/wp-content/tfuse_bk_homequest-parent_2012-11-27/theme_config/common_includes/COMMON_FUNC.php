<?php
/**
 * Functions to select homepage category
 *
 * @since HomeQuest 1.0
 */


if (!function_exists('tfuse_get_property_terms')) :
    /**
     *
     *
     * To override tfuse_get_property_terms() in a child theme, add your own tfuse_get_property_terms()
     * to your child theme's file.
     */

    function tfuse_get_property_terms( $taxonomy) {

        global $wpdb;
        $SQL = "SELECT $wpdb->terms.term_id, $wpdb->terms.name
            FROM  $wpdb->terms INNER JOIN $wpdb->term_taxonomy ON $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id
            WHERE $wpdb->term_taxonomy.taxonomy = '" . $taxonomy ."'";

        $results =  $wpdb->get_results($SQL);
        return $results;

    }
endif;


if (!function_exists('tfuse_select_taxonomies_for_homepage')) :

    function tfuse_select_taxonomies_for_homepage()
    {
        $categories = get_terms('category', array('hide_empty' => 0));
        $output[0] = __('Default Reading Settings','tfuse');
        $output[-1] = '--' . __('CATEGORIES','tfuse') . '--';
        foreach ( $categories as $cat )
        {
            $output[$cat->slug] = $cat->name;
        }

       /* $terms = tfuse_get_property_terms('property_category');
        $output[-2] = '--' . ucfirst(TF_SEEK_HELPER::get_post_type()) . ' ' . __('Categories','tfuse') . '--';
        foreach ( $terms as $term )
        {
            $output[$term->term_id] = $term->name;
        }

        $terms = tfuse_get_property_terms('property_features');
        $output[-3] = '--' . ucfirst(TF_SEEK_HELPER::get_post_type()) . ' ' . __('Features','tfuse') . '--';
        foreach ( $terms as $term )
        {
            $output[$term->term_id] = $term->name;
        }

        $terms = tfuse_get_property_terms('property_agents');
        $output[-4] = '--' . ucfirst(TF_SEEK_HELPER::get_post_type()) . ' ' . __('Agents','tfuse') . '--';
        foreach ( $terms as $term )
        {
            $output[$term->term_id] = $term->name;
        }

        $terms = tfuse_get_property_terms('property_locations');
        $output[-5] = '--' . ucfirst(TF_SEEK_HELPER::get_post_type()) . ' ' . __('Locations','tfuse') . '--';
        foreach ( $terms as $term )
        {
            $output[$term->term_id] = $term->name;
        }*/
        return $output;
    }

// End function tfuse_select_taxonomies_for_homepage()
endif;
