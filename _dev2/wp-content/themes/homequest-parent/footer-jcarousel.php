<?php

    function get_post_from_location($category, $location, $exclude, $prop_num = 8)
    {
        global $post;
        $exclude = array_merge(array($post->ID),$exclude);
        $args = array(
            'post_type'     => TF_SEEK_HELPER::get_post_type(),
            'post_status'   =>'publish',
            'post__not_in'       =>$exclude,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => $category->taxonomy,
                    'field' => 'slug',
                    'terms' => array( $category->slug ),
                    'operator'  =>'IN'
                ),
                array(
                    'taxonomy' => $location->taxonomy,
                    'field' => 'slug',
                    'terms' => array( $location->slug ),
                    'operator'  =>'IN'
                )
            ),
            'orderby'   => 'DATE',
            'order'     =>  'DESC',
            'showposts' => $prop_num

        );

        $the_query =  new WP_Query( $args );
        $properties = $the_query->get_posts();
        return $properties;
    }

    function tfuse_get_simalar_properties ( $category, $hierarchy, $prop_num = 8)
    {
        global $post;

        $category = wp_get_object_terms($post->ID, $category, array());
        if(!empty($category[0])) $category = $category[0]; else return;

        $locations =  wp_get_object_terms($post->ID, $hierarchy ,array('orderby' => 'term_group'));
        $locations = array_reverse($locations);
        if(empty($locations[0]))  return;

        $properties = array();
        while ((sizeof($properties) <= $prop_num) && $locations)
        {
            $exclude = array();
            foreach($properties as $property) $exclude[] = $property->ID;
            $properties = array_merge($properties, get_post_from_location($category, $locations[0], $exclude, $prop_num));
            unset($locations[0]);
            $locations = array_values($locations);
        }

        if(sizeof($properties)>$prop_num)
        {
            $properties = array_slice($properties, 0, $prop_num);
        }
        elseif(sizeof($properties)<$prop_num)
        {
            $exclude = array();
            foreach($properties as $property) $exclude[] = $property->ID;
            $exclude[] = $post->ID;
            $args = array(
                'post_type'     => TF_SEEK_HELPER::get_post_type(),
                'post_status'   =>'publish',
                'post__not_in'       => $exclude,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => $category->taxonomy,
                        'field' => 'slug',
                        'terms' => array( $category->slug ),
                        'operator'  =>'IN'
                    )
                ),
                'orderby'   => 'DATE',
                'order'     =>  'DESC',
                'showposts' => $prop_num - sizeof($properties)

            );

            $the_query =  new WP_Query( $args );
            $properties = array_merge($properties, $the_query->get_posts());

            //Properties in another category, if necessary remove
            if (sizeof($properties)<$prop_num)
            {
                $exclude = array();
                foreach($properties as $property) $exclude[] = $property->ID;
                $exclude[] = $post->ID;
                $args = array(
                    'post_type'     => TF_SEEK_HELPER::get_post_type(),
                    'post_status'   =>'publish',
                    'post__not_in'       => $exclude,
                    'orderby'   => 'DATE',
                    'order'     =>  'DESC',
                    'showposts' => $prop_num - sizeof($properties)

                );

                $the_query =  new WP_Query( $args );
                $properties = array_merge($properties, $the_query->get_posts());
            }
        }

        $slides = sizeof($properties);
        if($slides) :
            wp_enqueue_script( 'jquery.jcarousel' );
            ?>
        <!-- carousel after content -->
        <div class="before_content after_content">
            <div class="container_12">
                <strong class="carusel_title"><?php _e('SIMILAR PROPERTIES', 'tfuse'); ?></strong>

                <div class="carusel_list carusel_small">
                    <ul id="similar_properties" class="jcarousel-skin-tango">
                        <?php foreach ($properties as $property) : ?>
                        <?php
                        $img_out = '';
                        $title_out = tfuse_page_options('title_for_slider', tfuse_custom_title($property->ID,true), $property->ID);
                        $image = new TF_GET_IMAGE();
                        $src = tfuse_get_property_thumbnail($property->ID);
                        $img_out .=  $image->width(218)->height(125)->src($src)->get_img();
                        ?>
                        <li>
                            <div class="item_image">
                                <a href="<?php print get_permalink($property->ID); ?>"><?php echo $img_out; ?></a>
                            </div>
                            <div class="item_name">
                                <a href="<?php print get_permalink($property->ID); ?>"><?php echo $title_out; ?></a>
                            </div>
                        </li>
                        <?php endforeach; ?>
                        <?php wp_reset_query(); ?>
                    </ul>
                </div>

                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $('#similar_properties').jcarousel({
                            <?php
                            if($slides <=4 ) :
                                echo 'buttonNextHTML: null,';
                                echo 'buttonPrevHTML: null,';
                            endif;
                            ?>
                            easing: 'easeOutBack',
                            animation: 600,
                            scroll: 1
                        });
                    });
                </script>

            </div>
        </div>
        <!--/ carousel after content -->
        <?php endif;
    }
    tfuse_get_simalar_properties(TF_SEEK_HELPER::get_post_type() . '_category', TF_SEEK_HELPER::get_post_type() . '_locations');
?>