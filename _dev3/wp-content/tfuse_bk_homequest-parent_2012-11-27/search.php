<?php
/**
 * The template for displaying Search Results pages.
 *
 * @since HomeQuest 1.0
 */

// Hack search <title>
$get_s_backup   = @$_GET['s'];
$_GET['s']      = __( TF_SEEK_HELPER::get_option('seek_property_name_plural','RealEstate'), 'tfuse');

get_header();

$_GET['s']      = $get_s_backup;
unset($get_s_backup);
/// ^end-back

$sidebar_position   = tfuse_sidebar_position();

// Seek search

$orderby_options    = array(
    'latest'        => array(
        'label'     => __('Latest Added', 'tfuse'),
        'sql'       => 'p.post_date DESC',
    ),
    'price-high-low'    => array(
        'label'     => __('Price High - Low', 'tfuse'),
        'sql'       => 'options.seek_property_price DESC',
    ),
    'price-low-high'    => array(
        'label'     => __('Price Low - High', 'tfuse'),
        'sql'       => 'options.seek_property_price ASC',
    ),
    'names-a-z'    => array(
        'label'     => __('Names A - Z', 'tfuse'),
        'sql'       => 'p.post_title ASC',
    ),
    'names-z-a'    => array(
        'label'     => __('Names Z - A', 'tfuse'),
        'sql'       => 'p.post_title DESC',
    ),
);


$search_params      = array(
    'return_type'       => ARRAY_A,
    'posts_per_page'    => get_option('posts_per_page',5),
    'orderby_options'   => $orderby_options,
    'debug'             => false,
);
$search_results     = TF_SEEK_HELPER::get_search_results($search_params);
?>

<div class="middle">
<div class="container_12">

    <?php if ($sidebar_position == 'left') : ?>
    <div class="grid_4 sidebar">
        <?php get_sidebar(); ?>
    </div><!--/ .sidebar -->
    <?php endif; ?>

<!-- content -->
<div class="grid_8 content">

    <div class="title_small">
        <?php if (!empty($_GET['properties'])) {if($search_results['total'] > 1) $span_content = $search_results['total'] . ' ' .  __('OFFERS','tfuse'); elseif($search_results['total'] == 1) $span_content = $search_results['total'] . ' ' .  __('OFFER','tfuse'); else $span_content = $search_results['total'] . ' ' .  __(' OFFERS','tfuse'); echo '<h1>' . __('PROPERTIES', 'tfuse') . ' <span>(' . $span_content.  ')</span></h1>'; } else { ?>
        <h1><?php _e('SEARCH RESULTS','tfuse'); ?>  <span>(<?php print($search_results['total']); ?> <?php print( mb_strtoupper( TF_SEEK_HELPER::get_option( ( intval($search_results['total'])==1 ? 'seek_property_name_singular' : 'seek_property_name_plural'),'OFFERS'), 'UTF-8')); ?>)</span></h1>
            <?php } ?>
    </div>

    <!-- sorting, pages -->
    <div class="block_hr list_manage">
        <div class="inner">
            <?php
                TF_SEEK_CUSTOM_FUNCTIONS::orderby( $orderby_options, array('select_id'=>'sort_list') );
            ?>

            <?php
                TF_SEEK_CUSTOM_FUNCTIONS::html_jump_to_page(array(
                    'curr_page'         => $search_results['curr_page'],
                    'max_pages'         => $search_results['max_pages'],
                ));
            ?>

            <?php
                TF_SEEK_CUSTOM_FUNCTIONS::html_paging(array(
                    'curr_page'         => $search_results['curr_page'],
                    'max_pages'         => $search_results['max_pages'],
                ));
            ?>

            <div class="clear"></div>
        </div>
    </div>
    <!--/ sorting, pages -->

    <!-- real estate list -->
    <div class="re-list">

        <?php $slist = $search_results['rows'];?>
        <?php if(sizeof($slist)): ?>
            <?php  foreach($slist as $spost): ?>
                <div class="re-item">
                    <div class="re-image">
                        <a href="<?php print(get_permalink($spost['ID'])); ?>"><?php tfuse_media($spost['ID']);?></a>
                    </div>
                    <div class="re-short">
                        <div class="re-top">
                            <h2><a href="<?php print(get_permalink($spost['ID'])); ?>"><?php print(esc_attr($spost['post_title'])); ?></a></h2>
                            <span class="re-price"><?php echo TF_SEEK_HELPER::get_option('seek_property_currency_symbol','$'); ?><?php echo number_format($spost['seek_property_price']); $stored_price = TF_SEEK_HELPER::get_post_option(TF_SEEK_HELPER::get_post_type() . '_price', null, $spost['ID']);echo str_replace((string)$spost['seek_property_price'],'',$stored_price); ?></span>
                        </div>
                        <div class="re-descr">
                            <?php echo tfuse_get_short_text($spost['post_content'],40); ?>
                        </div>
                        <div class="re-bot">
                            <a href="<?php print(get_permalink($spost['ID'])); ?>" class="link-more"><?php _e('View Details', 'tfuse'); ?></a> <a href="#" class="link-save tooltip" rel="<?php print($spost['ID']); ?>" title="<?php _e('Save Offer', 'tfuse'); ?>"><?php _e('Save Offer', 'tfuse'); ?></a>
                            <a href="<?php print(get_permalink($spost['ID'])); ?>" class="link-viewmap tooltip" title="<?php _e('View on Map', 'tfuse'); ?>"><?php _e('View on Map', 'tfuse'); ?></a><?php tfuse_get_property_images($spost['ID']);?>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php
                if($search_results['total']<1){
                    _e( 'Sorry, but nothing matched your search criteria.', 'tfuse' );
                } else {
                    // Wrong page
                }
            ?>
        <?php endif; ?>

    </div>
    <!--/ real estate list -->


    <!-- sorting, pages -->
    <div class="block_hr list_manage">
        <div class="inner">
            <?php
                TF_SEEK_CUSTOM_FUNCTIONS::orderby($orderby_options, array('select_id'=>'sort_list2'));
            ?>

            <?php
                TF_SEEK_CUSTOM_FUNCTIONS::html_jump_to_page(array(
                    'curr_page'         => $search_results['curr_page'],
                    'max_pages'         => $search_results['max_pages'],
                ));
            ?>

            <?php
                TF_SEEK_CUSTOM_FUNCTIONS::html_paging(array(
                    'curr_page'         => $search_results['curr_page'],
                    'max_pages'         => $search_results['max_pages'],
                ));
            ?>

            <div class="clear"></div>
        </div>
    </div>
    <!--/ sorting, pages -->



</div>
<!--/ content -->

    <?php if ($sidebar_position == 'right') : ?>
    <div class="grid_4 sidebar">
        <?php get_sidebar(); ?>
    </div><!--/ .sidebar -->
    <?php endif; ?>

<div class="clear"></div>


</div>
</div>
<!--/ middle -->

<?php get_footer(); ?>