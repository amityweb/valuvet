<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

TF_SEEK_HELPER::print_all_not_form_hidden($form_id, array( TF_SEEK_HELPER::get_search_parameter('page'), TF_SEEK_HELPER::get_search_parameter('orderby'), TF_SEEK_HELPER::get_post_type() ));

?>
    <?php TF_SEEK_HELPER::print_form_item('location_slider'); ?>

    <?php TF_SEEK_HELPER::print_form_item('sale_type_slider'); ?>

    <div class="row selectField">
        <?php TF_SEEK_HELPER::print_form_item('bedrooms_select_slider'); ?>

        <?php TF_SEEK_HELPER::print_form_item('baths_select_slider'); ?>
    </div>

    <?php TF_SEEK_HELPER::print_form_item('price_range_slider'); ?>

    <div class="row submitField">
        <input type="submit" value="<?php print( esc_attr( sprintf(__('FIND %s'), mb_strtoupper(TF_SEEK_HELPER::get_option('seek_property_name_plural', 'PROPERTIES'), 'UTF-8') ) ) ); ?>" id="search_submit" class="btn_search">
    </div>

<script type="text/javascript" >
    jQuery(document).ready(function($) {
        // Switch Type
        $(".cb-enable").click(function(){
            var parent = $(this).parents('.switch');
            $(parent).removeClass('switch_off');
            $('.cb-disable',parent).removeClass('selected');
            $(this).addClass('selected');
        });
        $(".cb-disable").click(function(){
            var parent = $(this).parents('.switch');
            $(parent).addClass('switch_off');
            $('.cb-enable',parent).removeClass('selected');
            $(this).addClass('selected');
        });
    });
</script>