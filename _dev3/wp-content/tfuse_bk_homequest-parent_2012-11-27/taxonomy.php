<?php get_header();
global $wp_query;
$defoult = $wp_query;
$sidebar_position = tfuse_sidebar_position();

if(!empty($_GET['order_by'])) $order_by = $_GET['order_by']; else $order_by = 'date';
if(!empty($_GET['order'])) $order = $_GET['order']; else $order = 'DESC';
if(!empty($_GET['page'])) $page = $_GET['page']; else $page = 0;
$sel = 1;
if($order_by == 'date' && $order == 'desc')
    $sel = 1;
elseif($order_by == 'price' && $order == 'DESC')
    $sel = 2;
elseif($order_by == 'price' && $order == 'ASC')
    $sel = 3;
elseif($order_by == 'title' && $order == 'ASC')
    $sel = 4;
elseif($order_by == 'title' && $order == 'DESC')
    $sel = 5;

$get_order_by = $order_by;
$posts_per_page = $wp_query->query_vars['posts_per_page'];
if ($get_order_by == 'price') $posts_per_page = -1;

if($order_by!= 'date' && $order_by != 'title') $order_by = 'date';
$args = array(
    'order_by'          => $order_by,
    'order'             => $order,
    'paged'             => $page,
    'posts_per_page'    => $posts_per_page
);
$args = array_merge($wp_query->query,$args);
$posts = query_posts($args);
$tag = $wp_query->get_queried_object();
$num_pages = $wp_query->max_num_pages;
$prop_array = $posts;
foreach ($posts as $key => $value) :
    $prop_array [$key] = get_object_vars($value);
    $prop_array [$key]['price']  = TF_SEEK_HELPER::get_post_option(TF_SEEK_HELPER::get_post_type() . '_price', '-', $value->ID);
    $prop_array [$key]['full_price']  = TF_SEEK_HELPER::get_post_option(TF_SEEK_HELPER::get_post_type() . '_price', null, $value->ID);
    endforeach;
$total_properties = $tag->count;
if ($get_order_by == 'price')
{
    if(!is_numeric($page)) $page = 0;
    $count = tfuse_get_count_properties_by_taxonomy_id($tag->term_id);
    $total_properties = (int)$count[0]['count'];
    $num_pages = (int)($count[0]['count'] / $defoult->query_vars['posts_per_page']);
    if ((($count[0]['count']) % $defoult->query_vars['posts_per_page']) != 0)  $num_pages++;
    $page = intval($page);
    $start = $defoult->query_vars['posts_per_page'] * ($page - 1);
    if( $page == 1 || $page == 0) $start = 0;
    $final = $start + ($defoult->query_vars['posts_per_page']);
    if ($start != 0) $final--;
    if ($order == 'DESC')
        $obj = tfuse_get_properties_by_taxonomy_id($tag->term_id, true, $start, $final);
    else
        $obj =  tfuse_get_properties_by_taxonomy_id($tag->term_id, false, $start, $final);
    $prop_array = array();
    foreach($obj as $key => $prop)
    {
        $prop_array[$key]['ID'] = $prop['post_id'];
        $prop_array [$key]['price']  = $prop['seek_property_price'];
        $prop_array [$key]['full_price']  = TF_SEEK_HELPER::get_post_option(TF_SEEK_HELPER::get_post_type() . '_price', null, $prop['post_id']);
        $prop_array[$key]['post_content'] = $prop['post_content'];
        $prop_array[$key]['post_title'] = $prop['post_title'];
    }
}
?>
<input type="hidden" id="tax_permalink" value="<?php echo get_term_link( $tag->slug, $tag->taxonomy );?>">
<input type="hidden" id="tax_results" page="<?php print $page ?>" num_pages="<?php print $num_pages ?>" get_order="<?php print $order; ?>" get_order_by="<?php print $get_order_by; ?>">
<div <?php tfuse_class('middle'); ?>>

    <div class="container_12">

        <?php if ($sidebar_position == 'left') : ?>
        <div class="grid_4 sidebar">
            <?php get_sidebar(); ?>
        </div><!--/ .sidebar -->
        <?php endif; ?>

		<!-- content -->
        <div <?php tfuse_class('content'); ?>>

            <div class="title_small">
                <?php if ( $tag->count > 0 ) : ?>
                <h1><?php print mb_strtoupper(TF_SEEK_HELPER::get_option('seek_property_name_plural'), 'UTF-8'); print ' ';  _e ('FOR', 'tfuse'); ?> <?php print mb_strtoupper($tag->name, 'UTF-8'); ?>  <span>(<?php  print $total_properties; print ($total_properties > 1) ? ' OFFERS' : ' OFFER'; ?>)</span></h1>
                <?php endif; ?>
            </div>

            <!-- sorting, pages -->
            <div class="block_hr list_manage">
                <div class="inner">
                    <form action="#" method="post" class="form_sort">
                        <span class="manage_title"><?php _e('Sort by', 'tfuse'); ?>:</span>
                        <select class="select_styled white_select" name="sort_list" id="sort_list">
                            <option value="1"<?php if ($sel == 1) echo ' selected';?>><?php _e('Latest Added', 'tfuse'); ?></option>
                            <option value="2"<?php if ($sel == 2) echo ' selected';?>><?php _e('Price High - Low', 'tfuse'); ?></option>
                            <option value="3"<?php if ($sel == 3) echo ' selected';?>><?php _e('Price Low - Hight', 'tfuse'); ?></option>
                            <option value="4"<?php if ($sel == 4) echo ' selected';?>><?php _e('Names A-Z','tfuse'); ?></option>
                            <option value="5"<?php if ($sel == 5) echo ' selected';?>><?php _e('Names Z-A', 'tfuse'); ?></option>
                        </select>
                    </form>

                    <div class="pages_jump">
                        <span class="manage_title"><?php _e('Jump to page', 'tfuse'); ?>:</span>
                        <form action="#" method="post">
                            <input type="text" name="jumptopage" value="<?php print $num_pages ?>" class="inputSmall" id="jumptopage"><input id="jumptopage_submit" type="submit" class="btn-arrow" value="Go">
                        </form>
                    </div>

                    <div class="pages">
                        <span class="manage_title"><?php _e('Page', 'tfuse'); ?>: &nbsp;<strong><?php if ($page == 0) echo $page + 1 . ' ' ; else echo $page . ' '; _e('of', 'tfuse');  echo ' ' . $num_pages; ?></strong></span> <a href="#" <?php if ($page == 0 || $page == 1) echo 'rel="first" style="opacity:0.4;"'; ?> class="link_prev"><?php _e('Previous', 'tfuse'); ?></a><a href="#" <?php if($page == $num_pages) echo 'rel="last" style="opacity:0.4;"'; ?> class="link_next"><?php _e('Next', 'tfuse'); ?></a>
                    </div>

                    <div class="clear"></div>
                </div>
            </div>
            <!--/ sorting, pages -->




            <!-- real estate list -->
            <div class="re-list">
                <?php if (count($prop_array)): ?>
                    <?php  foreach($prop_array as $property): ?>
                        <div class="re-item">
                            <div class="re-image"><a href="<?php print(get_permalink($property['ID'])); ?>"><?php tfuse_media($property['ID']);?></a></div>
                            <div class="re-short">
                                <div class="re-top">
                                    <h2><a href="<?php print(get_permalink($property['ID'])); ?>"><?php print(esc_attr($property['post_title'])); ?></a></h2>
                                    <span class="re-price"><?php if(is_numeric($property['full_price']))
                                    {
                                        print( TF_SEEK_HELPER::get_option('seek_property_currency_symbol','$'));
                                        print( number_format( $property['price']) );
                                    } elseif(($property['price'] != '-') && (!empty($property['price'])))
                                    {
                                        print( TF_SEEK_HELPER::get_option('seek_property_currency_symbol','$'));
                                        echo number_format(intval($property['price']));

                                        $int_price = (string)$property['price'];
                                        echo str_replace($int_price,'',$property['full_price']);
                                    }
                                    else
                                    {
                                        echo '-';
                                    }
                                        ?></span>
                                </div>
                                <div class="re-descr">
                                    <?php echo tfuse_get_short_text($property['post_content'], 40); ?>
                                </div>
                                <div class="re-bot">
                                    <a href="<?php print(get_permalink($property['ID'])); ?>" class="link-more"><?php _e('View Details', 'tfuse'); ?></a>
                                    <?php tfuse_view_property_on_the_map($property['ID']);?>
                                    <?php tfuse_get_property_images($property['ID']);?>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php  endforeach; ?>
                <?php endif;    ?>
                <?php if (($page > $num_pages) || (!count($prop_array))) :
                        echo '<p>' . __('Page not found.', 'tfuse') . '</p>';
                        echo '<p>' . __('The page you were looking for doesn&rsquo;t seem to exist.', 'tfuse') . '</p>';
                      endif;
                ?>
            </div>
            <!--/ real estate list -->
            <!-- sorting, pages -->
            <div class="block_hr list_manage">
                <div class="inner">
                    <form action="#" method="post" class="form_sort">
                        <span class="manage_title"><?php _e('Sort by', 'tfuse'); ?>:</span>
                        <select class="select_styled white_select" name="sort_list" id="sort_list2">
                            <option value="1"<?php if ($sel == 1) echo ' selected';?>><?php _e('Latest Added', 'tfuse'); ?></option>
                            <option value="2"<?php if ($sel == 2) echo ' selected';?>><?php _e('Price High - Low', 'tfuse'); ?></option>
                            <option value="3"<?php if ($sel == 3) echo ' selected';?>><?php _e('Price Low - Hight', 'tfuse'); ?></option>
                            <option value="4"<?php if ($sel == 4) echo ' selected';?>><?php _e('Names A-Z','tfuse'); ?></option>
                            <option value="5"<?php if ($sel == 5) echo ' selected';?>><?php _e('Names Z-A', 'tfuse'); ?></option>
                        </select>
                    </form>

                    <div class="pages_jump">
                        <span class="manage_title"><?php _e('Jump to page', 'tfuse'); ?>:</span>
                        <form action="#" method="post">
                            <input type="text" name="jumptopage" value="<?php print $num_pages ?>" class="inputSmall" id="jumptopage2"><input id="jumptopage_submit2" type="submit" class="btn-arrow" value="Go">
                        </form>
                    </div>

                    <div class="pages">
                        <span class="manage_title"><?php _e('Page', 'tfuse'); ?>: &nbsp;<strong><?php if ($page == 0) echo $page + 1 . ' ' ; else echo $page . ' '; _e('of', 'tfuse');  echo ' ' . $num_pages; ?></strong></span> <a href="#" <?php if ($page == 0 || $page == 1) echo 'rel="first" style="opacity:0.4;"'; ?> class="link_prev"><?php _e('Previous', 'tfuse'); ?></a><a href="#" <?php if($page == $num_pages) echo 'rel="last" style="opacity:0.4;"'; ?> class="link_next"><?php _e('Next', 'tfuse'); ?></a>
                    </div>

                    <div class="clear"></div>
                </div>
            </div>
            <!--/ sorting, pages -->

        </div><!--/ .content -->

        <?php if ($sidebar_position == 'right') : ?>
        <div class="grid_4 sidebar">
            <?php get_sidebar(); ?>
        </div><!--/ .sidebar -->
        <?php endif; ?>

        <div class="clear"></div>

    </div><!--/ .container_12 -->

</div><!--/ .middle -->

<div class="middle_bot"></div>

<?php get_footer(); ?>
