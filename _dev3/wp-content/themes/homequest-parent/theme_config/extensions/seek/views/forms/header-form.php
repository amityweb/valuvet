<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

    TF_SEEK_HELPER::print_all_not_form_hidden( array($form_id, 'filter_search'), array( TF_SEEK_HELPER::get_search_parameter('page'), TF_SEEK_HELPER::get_search_parameter('orderby'), TF_SEEK_HELPER::get_post_type(), 'favorites' ));

    $is_expanded_search = false;
    if(isset($vars['expanded_search']) && $vars['expanded_search'] == 'expanded') $is_expanded_search = true;
    if((isset($_GET['price']))) $is_expanded_search = true;
    global $search; if (isset($search['type'])  && $search['type'] == 'expanded' ){$is_expanded_search = true;}

?>

<div class="search_col_1">
    <p class="search_title"><strong><?php _e('SEARCHING FOR', 'tfuse'); ?>:</strong></p>

    <div class="row">
        <label class="label_title"><?php _e('Advanced', 'tfuse'); ?>:</label>
        <div class="on-off"><a href="javascript:void(0)" id="search_advanced"><?php _e('ON', 'tfuse'); ?> &nbsp; &nbsp;&nbsp; &nbsp; <?php _e('OFF', 'tfuse'); ?></a></div>
        <input type="hidden" name="search_advanced" value="<?php print( $is_expanded_search ? '1' : '0'); ?>"/>
    </div>

</div>

<div class="search_col_2">
    <?php TF_SEEK_HELPER::print_form_item('location_select'); ?>

    <?php TF_SEEK_HELPER::print_form_item('price_header'); ?>

    <div class="row selectField rowHide">

        <?php TF_SEEK_HELPER::print_form_item('bedrooms_select'); ?>

        <?php TF_SEEK_HELPER::print_form_item('baths_select'); ?>
    </div>

    <div class="row rangeField rowHide">
        <?php TF_SEEK_HELPER::print_form_item('square_header'); ?>
    </div>

</div>

<div class="search_col_3">

    <?php TF_SEEK_HELPER::print_form_item('sale_type'); ?>

    <div class="row submitField">
        <input type="submit" value="<?php _e('Search','tfuse'); ?>" id="search_submit" class="btn_search">
    </div>

</div>

</form>

<script type="text/javascript">
    jQuery(document).ready(function($) {

        // Search Advanced
//        $(".search_main").css({'overflow':'inherit'});
//        if (!$(".search_main").hasClass("search_open")) {
//            $(".search_main .rowHide").hide();
//        }
//        $("#search_advanced").click(function(){
//            if ($(this).closest(".search_main").hasClass("search_open")) {
//                $(".search_main, .search_col_1, .search_col_2, .search_col_3").stop().animate({height:'155px'},{queue:false, duration:350, easing: 'easeInQuad'});
//                $(".search_main .rowHide").slideUp(300);
//                $('input[name=search_advanced]').val('0')
//            } else {
//                $(".search_main, .search_col_1, .search_col_2, .search_col_3").stop().animate({height:'300px'},{queue:false, duration:350, easing: 'easeOutQuad'});
//                $(".search_main .rowHide").slideDown(300);
//                $('input[name=search_advanced]').val('1')
//            }
//            $(this).closest(".search_main").toggleClass("search_open");
//        });
//        if( !parseInt($('input[name=search_advanced]').val()) ){
//            // $(".search_main, .search_col_1, .search_col_2, .search_col_3").css('height','155px');
//            $(".search_main .rowHide").css('opacity','0').slideUp(function(){ $(this).css('opacity','1'); });
//            $('input[name=search_advanced]').closest(".search_main").toggleClass("search_open");
//        }

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
