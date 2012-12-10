<?php get_header(); ?>

<?php $sidebar_position = tfuse_sidebar_position(); ?>
<?php global $post; ?>
<div <?php tfuse_class('middle'); ?>>

    <div class="container_12"<?php if ( TF_SEEK_HELPER::get_post_type() == get_post_type() ) echo ' style="padding-top:14px;"';?>>

        <?php if ($sidebar_position == 'left') : ?>
            <div class="grid_4 sidebar"<?php if ( TF_SEEK_HELPER::get_post_type() == get_post_type() ) echo ' style="padding-top:52px;"';?>>
                <?php get_sidebar(); ?>
            </div><!--/ .sidebar -->
        <?php endif; ?>

        <div <?php tfuse_class('content'); ?>>

            <?php while ( have_posts() ) : the_post(); ?>

                <?php

                    if ( TF_SEEK_HELPER::get_post_type() == get_post_type() ) :
                        get_template_part( 'content', 'property' );
                    else :
                        get_template_part( 'content', 'single' );
                        get_template_part( 'content', 'author' );
                    endif;

                ?>

                <?php if ('post' == get_post_type()) tfuse_comments(); ?>

            <?php endwhile; // end of the loop. ?>


        </div>
        <!--/ content -->

        <?php if ($sidebar_position == 'right') : ?>
            <div class="grid_4 sidebar"<?php if ( TF_SEEK_HELPER::get_post_type() == get_post_type() ) echo ' style="padding-top:52px;"';?>>
                <?php get_sidebar(); ?>
            </div><!--/ .sidebar -->
        <?php endif; ?>

        <div class="clear"></div>
    </div><!--/ .container_12 -->

</div><!--/ .middle -->

<?php if ( TF_SEEK_HELPER::get_post_type() == get_post_type() ) tfuse_header_content('after_content'); ?>

<?php get_footer(); ?>