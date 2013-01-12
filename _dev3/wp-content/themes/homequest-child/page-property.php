<?php
/*
Template Name: Property loop
*/
?>

<?php







$fav_saved = array();
if (!empty($_COOKIE['favorite_posts'])) $fav_saved = explode(',', $_COOKIE['favorite_posts']);
?>

<?php
    get_header();
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $query_params = array(
        'post_type'         => 'property',
        'posts_per_page'    => 5,
        'paged'             => $paged    
        );
    $the_query = new WP_Query($query_params);
    if (array_key_exists("sortby", $_GET) === true)
    {
        $the_query = sortIt($_GET['sortby']);
    }
    $sidebar_position = tfuse_sidebar_position();

?>

 
<div <?php tfuse_class('middle'); ?>>

    <div class="container_12">

        <?php if ($sidebar_position == 'left') : ?>
        <div class="grid_4 sidebar">
            <?php get_sidebar(); ?>
        </div><!--/ .sidebar -->
        <?php endif; ?>



        <!-- content -->
        <div <?php tfuse_class('content'); ?>>

            <!-- sorting, pages -->
            <div class="block_hr list_manage">
                <div class="inner">
                    <div class="form_sort">
                        <span class="manage_title">Sort by:</span>
                        <span class="default_caption">Choose</span>
                        <div class="cusel select_styled white_select  cuselScrollArrows" id="cuselFrame-cuSel-3" style="width:158px" tabindex="0">
                            <div class="cusel-scroll-pane" id="cusel-scroll-cuSel-3">
                                <a href="?sortby=latest">Latest Added</a>
                                <a href="?sortby=price-high-low">Price High - Low</a>
                                <a href="?sortby=price-low-high">Price Low - High</a>
                                <a href="?sortby=names-a-z">Names A - Z</a>
                                <a href="?sortby=names-z-a">Names Z - A</a>
                            </div>
                        </div>
                    </div>



                    <div class="pages_jump">
                        <span class="manage_title"><?php _e('Jump to page:','tfuse'); ?></span>
                            <input type="text" name="<?php print($paged); ?>" value="<?php print($paged); ?>" class="inputSmall">
                            <a href="<?php echo '?paged=' . ($paged); //jump to page ?>" class="btn-arrow">Next</a>
                    </div>

                    <div class="pages">
                        <span class="manage_title">Page: &nbsp;<strong><?php echo $paged; ?> of <?php echo $the_query->max_num_pages; ?></strong></span>
                        
                        <?php if($the_query->max_num_pages == 1) { ?>
                            <span class="link_prev">Previous</span>
                            <span class="link_next">Next</span>
                        <?php } 
                        else { ?>
                            <?php if($paged == '1') {?>
                                <span class="link_prev">Previous</span>
                                <a href="<?php echo '?paged=' . ($paged + 1); //next link ?>" class="link_next">Next</a>
                            <?php } 
                            elseif($paged == $the_query->max_num_pages) { ?>
                                <a href="<?php echo '?paged=' . ($paged -1); //prev link ?>" class="link_prev">Previous</a>
                                <span class="link_next">Next</span>
                            <?php }
                            else { ?>
                                <a href="<?php echo '?paged=' . ($paged -1); //prev link ?>" class="link_prev">Previous</a>
                                <a href="<?php echo '?paged=' . ($paged + 1); //next link ?>" class="link_next">Next</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <!--/ sorting, pages -->

            <div class="post-list">

            

            <?php if ($the_query->have_posts()) : $count = 0; ?>

            <?php while ($the_query->have_posts()) : $the_query->the_post(); $count++; ?>


                <div class="post-item">
                    <div class="block_hr">   
                        <span class="re-price"><strong><?php if(get_meta('show_asking_price') != '') { echo '$ '.number_format(get_meta('property_value')); } else { echo 'P. O. A'; }?></strong></span>    
                    </div>
                    <div class="post-title"><h2><a href="<?php the_permalink(); ?>"><?php meta('practice_is_for'); ?> - <?php the_title(); ?> - <?php meta('suburb'); ?>, <?php meta('practice_state'); ?></a></h2></div>
                    <div class="re-image">
                        <a href="<?php print(get_permalink()); ?>"><?php tfuse_media(get_the_ID());?></a>
                    </div>
                    <div class="post-short">
                        
                        <div class="post-descr">
                            <p><?php if ( tfuse_options('post_content') == 'content' ) the_content(''); else the_excerpt(); ?></p>
                        </div>
                        <div class="re-bot">
                            <a href="<?php print(get_permalink()); ?>" class="link-more"><?php _e('View Details', 'tfuse'); ?></a>
                            <?php $this_saved = in_array($spost['ID'], $fav_saved); ?>
                            <span class="meta-date"><?php echo get_the_date('D, M j, y'); ?></span>
                            <?php if ($this_saved) { ?>
                            <a href="#" class="tooltip link-saved" rel="<?php echo $spost['ID']; ?>" title="<?php _e('Remove Offer','tfuse'); ?>"><?php _e('Remove Offer','tfuse'); ?></a>
                            <?php } else {?>
                            <a href="#" class="link-save tooltip" rel="<?php echo $spost['ID']; ?>" title="<?php _e('Add to Fav','tfuse'); ?>"><?php _e('Add to Fav','tfuse'); ?></a>
                            <?php } ?>
                            <a href="<?php print(get_permalink($spost['ID'])); ?>" class="link-viewmap tooltip" title="<?php _e('View on Map', 'tfuse'); ?>"><?php _e('View on Map', 'tfuse'); ?></a>
                            <?php tfuse_get_property_images(get_the_ID());?>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>

                <?php endwhile; else: ?>

            <h5><?php _e('Sorry, no posts matched your criteria.', 'tfuse') ?></h5>



            <?php endif; ?>
            </div>
            

            <?php tfuse_pagination(); ?>

            <!-- sorting, pages -->
            <div class="block_hr list_manage">
                <div class="inner">
                    <div class="form_sort">
                        <span class="manage_title">Sort by:</span>
                        <span class="default_caption">Choose</span>
                        <div class="cusel select_styled white_select  cuselScrollArrows" id="cuselFrame-sort_list2" style="width:158px" tabindex="0">
                            
                            <div class="cusel-scroll-pane" id="cusel-scroll-sort_list2">
                                <a href="?sortby=latest">Latest Added</a>
                                <a href="?sortby=price-high-low">Price High - Low</a>
                                <a href="?sortby=price-low-high">Price Low - High</a>
                                <a href="?sortby=names-a-z">Names A - Z</a>
                                <a href="?sortby=names-z-a">Names Z - A</a>
                            </div>
                        </div>
                    </div>

                


                    <?php
                        TF_SEEK_CUSTOM_FUNCTIONS::html_jump_to_page(array(
                            'curr_page'         => $search_results['curr_page'],
                            'max_pages'         => $search_results['max_pages'],
                        ));
                    ?>

                    <div class="pages">
                        <span class="manage_title">Page: &nbsp;<strong><?php echo $paged; ?> of <?php echo $the_query->max_num_pages; ?></strong></span>
                        
                        <?php if($the_query->max_num_pages == 1) { ?>
                            <span class="link_prev">Previous</span>
                            <span class="link_next">Next</span>
                        <?php } 
                        else { ?>
                            <?php if($paged == '1') {?>
                                <span class="link_prev">Previous</span>
                                <a href="<?php echo '?paged=' . ($paged + 1); //next link ?>" class="link_next">Next</a>
                            <?php } 
                            elseif($paged == $the_query->max_num_pages) { ?>
                                <a href="<?php echo '?paged=' . ($paged -1); //prev link ?>" class="link_prev">Previous</a>
                                <span class="link_next">Next</span>
                            <?php }
                            else { ?>
                                <a href="<?php echo '?paged=' . ($paged -1); //prev link ?>" class="link_prev">Previous</a>
                                <a href="<?php echo '?paged=' . ($paged + 1); //next link ?>" class="link_next">Next</a>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <div class="clear"></div>
                </div>
            </div>
            <!--/ sorting, pages -->

        </div>
        <!--/ content -->

        <?php if ($sidebar_position == 'right') : ?>
        <div class="grid_4 sidebar">
            <?php  get_sidebar(); ?>
        </div><!--/ .sidebar -->
        <?php endif; ?>

        <div class="clear"></div>


    </div>
</div>
<!--/ middle -->

<?php get_footer(); ?>
