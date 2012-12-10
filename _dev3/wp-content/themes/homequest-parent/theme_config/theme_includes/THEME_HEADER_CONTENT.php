<?php

if ( ! function_exists( 'tfuse_header_content' ) ):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * To override tfuse_slider_type() in a child theme, add your own tfuse_slider_type to your child theme's
     * functions.php file.
     */

    function tfuse_header_content($location = false)
    {
        global $wp_query,$is_tf_front_page,$TFUSE,$post, $search, $header_element,$before_content_element, $latest_added_nr,$is_tf_blog_page;
        $posts = $header_element = $header_image = $before_content_element = $slider = null;

        if (!$location) return;
        switch ($location)
        {
            case 'header' :
                if ($is_tf_blog_page)
                {
                    $header_element = tfuse_options('header_element_blog', null);

                    if ( 'search' == $header_element )
                    {
                        $search['type'] = tfuse_options('search_type_blog', null);
                    }
                    elseif ( 'search_slider' == $header_element )
                    {
                        $slider = tfuse_options('select_search_slider_blog', null);
                    }
                    elseif ( 'slider' == $header_element)
                    {
                        $slider = tfuse_options('select_slider_blog', null);
                    }
                    else
                    {
                        return;
                    }
                }
                elseif ($is_tf_front_page)
                {
                    if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page'){
                        $ID = tfuse_options('home_page');
                        $header_element = tfuse_page_options('header_element', null, $ID);
                        if( 'none' == $header_element)
                        {
                            return;
                        }
                        elseif ( 'search' == $header_element )
                        {
                            $search['type'] = tfuse_page_options('search_type', null, $ID);
                        }
                        elseif ( 'search_slider' == $header_element )
                        {
                            $slider = tfuse_page_options('select_search_slider', null, $ID);
                        }
                        elseif ( 'slider' == $header_element)
                        {
                            $slider = tfuse_page_options('select_slider', null, $ID);
                        }
                    }
                    else{
                        $header_element = tfuse_options('header_element', null);

                        if ( 'search' == $header_element )
                        {
                            $search['type'] = tfuse_options('search_type', null);
                        }
                        elseif ( 'search_slider' == $header_element )
                        {
                            $slider = tfuse_options('select_search_slider', null);
                        }
                        elseif ( 'slider' == $header_element)
                        {
                            $slider = tfuse_options('select_slider', null);
                        }
                        else
                        {
                            return;
                        }
                    }
                }
                elseif(is_search())
                {
                    $header_element = tfuse_options('header_element_search', null);

                    if ( 'search' == $header_element )
                    {
                        $search['type'] = tfuse_options('search_type_search', null);
                    }
                    elseif ( 'search_slider' == $header_element )
                    {
                        $slider = tfuse_options('select_search_slider_search', null);
                    }
                    elseif ( 'slider' == $header_element)
                    {
                        $slider = tfuse_options('select_slider_search', null);
                    }
                    else
                    {
                        return;
                    }
                }
                elseif(is_404())
                {
                    $header_element = tfuse_options('header_element_404', null);

                    if ( 'search' == $header_element )
                    {
                        $search['type'] = tfuse_options('search_type_404', null);
                    }
                    elseif ( 'search_slider' == $header_element )
                    {
                        $slider = tfuse_options('select_search_slider_404', null);
                    }
                    elseif ( 'slider' == $header_element)
                    {
                        $slider = tfuse_options('select_slider_404', null);
                    }
                    else
                    {
                        return;
                    }
                }
                elseif(is_author())
                {
                    $header_element = tfuse_options('header_element_author', null);

                    if ( 'search' == $header_element )
                    {
                        $search['type'] = tfuse_options('search_type_author', null);
                    }
                    elseif ( 'search_slider' == $header_element )
                    {
                        $slider = tfuse_options('select_search_slider_author', null);
                    }
                    elseif ( 'slider' == $header_element)
                    {
                        $slider = tfuse_options('select_slider_author', null);
                    }
                    else
                    {
                        return;
                    }
                }
                elseif(is_tag())
                {
                    $header_element = tfuse_options('header_element_tag', null);

                    if ( 'search' == $header_element )
                    {
                        $search['type'] = tfuse_options('search_type_tag', null);
                    }
                    elseif ( 'search_slider' == $header_element )
                    {
                        $slider = tfuse_options('select_search_slider_tag', null);
                    }
                    elseif ( 'slider' == $header_element)
                    {
                        $slider = tfuse_options('select_slider_tag', null);
                    }
                    else
                    {
                        return;
                    }
                }
                elseif (is_tax())
                {
                    global $wp_query;
                    $tag = $wp_query->get_queried_object();
                    $ID = $tag->term_id;

                    $header_element = tfuse_options('header_element', null, $ID);
                    if ( 'search' == $header_element )
                    {
                        $search['type'] = tfuse_options('search_type', null, $ID);
                    }
                    elseif ( 'search_slider' == $header_element )
                    {
                        $slider = tfuse_options('select_search_slider', null, $ID);
                    }
                    elseif ( 'slider' == $header_element)
                    {
                        $slider = tfuse_options('select_slider', null, $ID);
                    }
                    else
                    {
                        return;
                    }
                }
                elseif ( is_singular() )
                {
                    $ID = $wp_query->post->ID;
                    $header_element = tfuse_page_options('header_element', null, $ID);
                    if( 'none' == $header_element)
                    {
                        return;
                    }
                    elseif ( 'search' == $header_element )
                    {
                        $search['type'] = tfuse_page_options('search_type', null, $ID);
                    }
                    elseif ( 'search_slider' == $header_element )
                    {
                        $slider = tfuse_page_options('select_search_slider', null, $ID);
                    }
                    elseif ( 'slider' == $header_element)
                    {
                        $slider = tfuse_page_options('select_slider', null, $ID);
                    }

                }
                elseif ( is_category() )
                {
                    $ID = get_query_var('cat');
                    $header_element = tfuse_options('header_element', null, $ID);
                    if ( 'search' == $header_element )
                    {
                        $search['type'] = tfuse_options('search_type', null, $ID);
                    }
                    elseif ( 'search_slider' == $header_element )
                    {
                        $slider = tfuse_options('select_search_slider', null, $ID);
                    }
                    elseif ( 'slider' == $header_element)
                    {
                        $slider = tfuse_options('select_slider', null, $ID);
                    }
                    else
                    {
                        return;
                    }
                }


                break;

            case 'before_content' :
                if ($is_tf_blog_page)
                {
                    $before_content_element = tfuse_options('before_content_element_blog', null);
                    if ( 'none' == $before_content_element )
                    {
                        return;
                    }
                    elseif ( 'slider' == $before_content_element )
                    {
                        $slider = tfuse_options('before_content_select_slider_blog', null);
                    }
                    elseif ( 'map' == $before_content_element )
                    {
                        get_template_part( 'content', 'map' );
                        return;
                    }
                    elseif('latest_added')
                    {
                        $latest_added_nr = tfuse_options('properties_number_blog', 8);
                        get_template_part( 'latest', 'added' );
                        return;
                    }
                    else
                    {
                        return;
                    }
                }
                elseif ($is_tf_front_page)
                {
                    if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page'){
                        $ID = tfuse_options('home_page');
                        $before_content_element = tfuse_page_options('before_content_element', null, $ID);
                        if( 'none' == $before_content_element)
                        {
                            return;
                        }
                        elseif ( 'slider' == $before_content_element )
                        {
                            $slider = tfuse_page_options('before_content_select_slider',null,$ID);
                        }
                        elseif ( 'map' == $before_content_element )
                        {
                            get_template_part( 'content', 'map' );
                            return;
                        }
                        elseif('latest_added')
                        {
                            $latest_added_nr = tfuse_page_options('properties_number', 8 ,$ID);
                            get_template_part( 'latest', 'added' );
                            return;
                        }
                        else
                        {
                            return;
                        }
                    }
                    else{
                        $before_content_element = tfuse_options('before_content_element', null);
                        if ( 'none' == $before_content_element )
                        {
                            return;
                        }
                        elseif ( 'slider' == $before_content_element )
                        {
                            $slider = tfuse_options('before_content_select_slider', null);
                        }
                        elseif ( 'map' == $before_content_element )
                        {
                            get_template_part( 'content', 'map' );
                            return;
                        }
                        elseif('latest_added')
                        {
                            $latest_added_nr = tfuse_options('properties_number', 8);
                            get_template_part( 'latest', 'added' );
                            return;
                        }
                        else
                        {
                            return;
                        }
                    }
                }
                elseif(is_search())
                {
                    $before_content_element = tfuse_options('before_content_element_search', null);
                    if ( 'none' == $before_content_element )
                    {
                        return;
                    }
                    elseif ( 'slider' == $before_content_element )
                    {
                        $slider = tfuse_options('before_content_select_slider_search', null);
                    }
                    elseif ( 'map' == $before_content_element )
                    {
                        get_template_part( 'content', 'map' );
                        return;
                    }
                    elseif('latest_added')
                    {
                        $latest_added_nr = tfuse_options('properties_number_search', 8);
                        get_template_part( 'latest', 'added' );
                        return;
                    }
                    else
                    {
                        return;
                    }
                }
                elseif(is_404())
                {
                    $before_content_element = tfuse_options('before_content_element_404', null);
                    if ( 'none' == $before_content_element )
                    {
                        return;
                    }
                    elseif ( 'slider' == $before_content_element )
                    {
                        $slider = tfuse_options('before_content_select_slider_404', null);
                    }
                    elseif ( 'map' == $before_content_element )
                    {
                        get_template_part( 'content', 'map' );
                        return;
                    }
                    elseif('latest_added')
                    {
                        $latest_added_nr = tfuse_options('properties_number_404', 8);
                        get_template_part( 'latest', 'added' );
                        return;
                    }
                    else
                    {
                        return;
                    }
                }
                elseif(is_tag())
                {
                    $before_content_element = tfuse_options('before_content_element_tag', null);
                    if ( 'none' == $before_content_element )
                    {
                        return;
                    }
                    elseif ( 'slider' == $before_content_element )
                    {
                        $slider = tfuse_options('before_content_select_slider_tag', null);
                    }
                    elseif ( 'map' == $before_content_element )
                    {
                        get_template_part( 'content', 'map' );
                        return;
                    }
                    elseif('latest_added')
                    {
                        $latest_added_nr = tfuse_options('properties_number_tag', 8);
                        get_template_part( 'latest', 'added' );
                        return;
                    }
                    else
                    {
                        return;
                    }
                }
                elseif(is_author())
                {
                    $before_content_element = tfuse_options('before_content_element_author', null);
                    if ( 'none' == $before_content_element )
                    {
                        return;
                    }
                    elseif ( 'slider' == $before_content_element )
                    {
                        $slider = tfuse_options('before_content_select_slider_author', null);
                    }
                    elseif ( 'map' == $before_content_element )
                    {
                        get_template_part( 'content', 'map' );
                        return;
                    }
                    elseif('latest_added')
                    {
                        $latest_added_nr = tfuse_options('properties_number_author', 8);
                        get_template_part( 'latest', 'added' );
                        return;
                    }
                    else
                    {
                        return;
                    }
                }
                elseif (is_tax())
                {
                    global $wp_query;
                    $tag = $wp_query->get_queried_object();
                    $ID = $tag->term_id;

                    $before_content_element = tfuse_options('before_content_element', null, $ID);
                    if ( 'none' == $before_content_element )
                    {
                        return;
                    }
                    elseif ( 'slider' == $before_content_element )
                    {
                        $slider = tfuse_options('before_content_select_slider', null ,$ID);
                    }
                    elseif ( 'map' == $before_content_element )
                    {
                        get_template_part( 'content', 'map' );
                        return;
                    }
                    elseif('latest_added')
                    {
                        $latest_added_nr = tfuse_options('properties_number', -1 ,$ID);
                        get_template_part( 'latest', 'added' );
                        return;
                    }
                    else
                    {
                        return;
                    }
                }
                elseif ( is_singular() )
                {
                    $ID = $wp_query->post->ID;
                    $before_content_element = tfuse_page_options('before_content_element', null, $ID);
                    if( 'none' == $before_content_element)
                    {
                        return;
                    }
                    elseif ( 'slider' == $before_content_element )
                    {
                        $slider = tfuse_page_options('before_content_select_slider',null,$ID);
                    }
                    elseif ( 'map' == $before_content_element )
                    {
                        get_template_part( 'content', 'map' );
                        return;
                    }
                    elseif('latest_added')
                    {
                        $latest_added_nr = tfuse_page_options('properties_number', 8 ,$ID);
                        get_template_part( 'latest', 'added' );
                        return;
                    }
                    else
                    {
                        return;
                    }
                }
                elseif( is_category())
                {
                    $ID = get_query_var('cat');
                    $before_content_element = tfuse_options('before_content_element', null, $ID);
                    if ( 'none' == $before_content_element )
                    {
                        return;
                    }
                    elseif ( 'slider' == $before_content_element )
                    {
                        $slider = tfuse_options('before_content_select_slider', null ,$ID);
                    }
                    elseif ( 'map' == $before_content_element )
                    {
                        get_template_part( 'content', 'map' );
                        return;
                    }
                    elseif('latest_added')
                    {
                        $latest_added_nr = tfuse_options('properties_number', -1 ,$ID);
                        get_template_part( 'latest', 'added' );
                        return;
                    }
                    else
                    {
                        return;
                    }
                }
                break;

            case 'after_content' :
                if ( (is_singular()) && (TF_SEEK_HELPER::get_post_type() == get_post_type()))
                {
                    $ID = $wp_query->post->ID;
                    $after_content_element = tfuse_page_options('after_content_element', '', $ID);
                    if ( 'similar_properties' == $after_content_element )
                    {
                        get_template_part('footer','jcarousel');
                    }
                }

                break;

        }

        if ( $header_element == 'search' )
        {
            get_template_part( 'header', 'search' );
            return;
        }
        elseif( $header_element == 'search_slider')
        {
            echo '<div class="header_bot">';
            get_template_part( 'header', 'search_narrow');
        }
        elseif ( !$slider )
            return;

        $slider = $TFUSE->ext->slider->model->get_slider($slider);
        if(!isset($slider['general'])) return;

        $slider['location'] = $location;
        if(!isset($ID) || empty($ID)) $ID = rand(100,1000);
        switch ($slider['type']):

            case 'custom':

                if ( is_array($slider['slides']) ) :
                    $slider_image_resize = ( isset($slider['general']['slider_image_resize']) && $slider['general']['slider_image_resize'] == 'true' ) ? true : false;
                    foreach ($slider['slides'] as $k => $slide) :
                        $image = new TF_GET_IMAGE();
                        $slider['slides'][$k]['slide_src'] = $image->width(960)->height(444)->src($slide['slide_src'])->resize($slider_image_resize)->get_src();
                    endforeach;
                endif;

                break;

            case 'posts':
               /* $args = array( 'post__in' => explode(',',$slider['general']['posts_select']) );

                $args = apply_filters('tfuse_slider_posts_args', $args, $slider);
                $args = apply_filters('tfuse_slider_posts_args_'.$ID, $args, $slider);
                $posts = get_posts($args);
                break;*/
                $posts_id = explode(',',$slider['general']['posts_select']);
                $args = array(
                    'post_type' =>array('post',TF_SEEK_HELPER::get_post_type()),
                    'numberposts' => -1,
                    'post__in' => $posts_id);
                $args = apply_filters('tfuse_slider_posts_args', $args, $slider);
                $args = apply_filters('tfuse_slider_posts_args_'.$ID, $args, $slider);
                $posts = get_posts($args);
                $temp = array();
                foreach($posts as $post)
                {
                    $key = array_search($post->ID, $posts_id);
                    $temp[$key] = $post;
                }
                ksort($temp);
                $posts = $temp;
                unset($temp);
                break;

            case 'tags':
                $args = array( 'tag__in' => explode(',',$slider['general']['tags_select']) );

                $args = apply_filters('tfuse_slider_tags_args', $args, $slider);
                $args = apply_filters('tfuse_slider_tags_args_'.$ID, $args, $slider);
                $posts = get_posts($args);
                break;

            case 'categories':
                $args = 'cat='.$slider['general']['categories_select'].
                    '&posts_per_page='.$slider['general']['sliders_posts_number'];

                $args = apply_filters('tfuse_slider_categories_args', $args, $slider);
                $args = apply_filters('tfuse_slider_categories_args_'.$ID, $args, $slider);
                $posts = get_posts($args);
                break;

        endswitch;

        if ( is_array($posts) ) :
                $slider['slides'] = tfuse_get_slides_from_posts($posts,$slider);
        endif;

        if ( !is_array($slider['slides']) ) return;

        include(locate_template( '/theme_config/extensions/slider/designs/'.$slider['design'].'/template.php' ));
        if( $header_element == 'search_slider')
        {
            echo '</div>';
        }
    }

endif;



if ( ! function_exists( 'tfuse_get_slides_from_posts' ) ):
/**
 * aici se schimba pentru fiecare tema spefica de unde ia imaginea, titlul, linkl siderului etc.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override tfuse_slider_type() in a child theme, add your own tfuse_slider_type to your child theme's
 * functions.php file.
 */
    function tfuse_get_slides_from_posts( $posts=array(), $slider = array() )
    {
        global $post;

        $slides = array();
        $slider_image_resize = ( isset($slider['general']['slider_image_resize']) && $slider['general']['slider_image_resize'] == 'true' ) ? $slider['general']['slider_image_resize'] : false;

        foreach ($posts as $k => $post) :

            setup_postdata( $post );
            $post->post_type;



            if ($post->post_type == 'post')
            {
                $tfuse_image = $image = null;
                if ( !$single_image = tfuse_page_options('single_image') ) continue;

                $image = new TF_GET_IMAGE();

                $img_width = 645;
                $img_height = 407;

                $tfuse_image = $image->width($img_width)->height($img_height)->src($single_image)->resize($slider_image_resize)->get_src();


                $title = get_the_title();
                if (mb_strlen($title, 'UTF-8') > 32)  $title = substr($title, 0 ,32) . '...';
                $slides[$k]['slide_title'] = $title;
                $slides[$k]['slide_src'] = $tfuse_image;
                $slides[$k]['slide_link_url'] = get_permalink();
                $slides[$k]['slide_link_target'] = '_self';

            }
            elseif ($post->post_type == TF_SEEK_HELPER::get_post_type())
            {
                $tfuse_image = $image = $single_image = null;
                $title = tfuse_custom_title($post->ID, true);
                $temp_title  = false;
                if ($slider['design'] == 'slidesjs')
                {

                    $temp_title = (tfuse_page_options('title_for_slider', false, $post->ID)) ? $title . ' - ' . tfuse_page_options('title_for_slider', '', $post->ID) : $title;
                    $single_image = tfuse_get_main_attachement($post->ID);
                }
                elseif($slider['design'] == 'jcarousel')
                {
                    $temp_title = tfuse_page_options('title_for_slider', get_the_title($post->ID), $post->ID);
                    $single_image = tfuse_get_property_thumbnail($post->ID);
                }

                if((!$single_image) || (!$temp_title)) continue;

                $slides[$k]['slide_title'] = $temp_title;

                $image = new TF_GET_IMAGE();

                $img_width = 645;
                $img_height = 407;

                $tfuse_image = $image->width($img_width)->height($img_height)->src($single_image)->resize($slider_image_resize)->get_src();



                $slides[$k]['slide_src'] = $tfuse_image;
                $slides[$k]['slide_link_url'] = get_permalink($post->ID);
                $slides[$k]['slide_link_target'] = '_self';

            }

        endforeach;
        wp_reset_query();
        return $slides;
    }
endif;
