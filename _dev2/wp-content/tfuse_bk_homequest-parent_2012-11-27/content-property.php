<?php
/**
 * The template for displaying content in the single.php for doctor template.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since HomeQuest 1.0
 */
?>



    <div class="re-full">
        <?php tfuse_custom_title(); ?>

        <div class="block_hr">
            <div class="inner">
                <div class="re-price"><strong><?php print( TF_SEEK_HELPER::get_option('seek_property_currency_symbol','$')); ?><?php $stored_price = TF_SEEK_HELPER::get_post_option(TF_SEEK_HELPER::get_post_type() . '_price', null, $post->ID); $int_price = intval($stored_price); print number_format($int_price); echo str_replace((string)$int_price,'',$stored_price); ?></strong></div>
                <?php print( TF_SEEK_HELPER::print_zone('header') ); ?>
            </div>
        </div>

        <?php get_template_part('property', 'sl_content');?>

        <div class="re-description">
            <h2><?php print( sprintf( __('About this %s'), TF_SEEK_HELPER::get_option('seek_property_name_singular','Property') ) ); ?>:</h2>
            <p><?php the_content(); ?></p>
        </div>


        <div class="block_hr re-meta-bot until_first_update">
            <div class="inner">
                <a href="javascript:history.go(-1)" class="link-back">&lt; <?php _e('Back to Properties Listing', 'tfuse'); ?></a>
            </div>
        </div>

    </div>


