<?php
/*
Template Name: Home
*/

get_header();

$sidebar_position = tfuse_sidebar_position();

global $wp_query;

?>

<div <?php tfuse_class('middle'); ?>>

    <div class="container_12">
        <?php tfuse_page_content('before', $wp_query->query_vars['page_id']); ?>
        <?php if ($sidebar_position == 'left') : ?>
        <div class="grid_4 sidebar">
            <?php get_sidebar(); ?>
        </div><!--/ .sidebar -->
        <?php endif; ?>



        <div <?php tfuse_class('content'); ?>>

                <?php tfuse_custom_title($wp_query->query_vars['page_id']); ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                    <?php the_content(); ?>

                    <?php tfuse_comments(); ?>

                    <?php endwhile; // end of the loop. ?>

        </div><!--/ .content -->

        <?php if ($sidebar_position == 'right') : ?>
        <div class="grid_4 sidebar">
            <?php get_sidebar(); ?>
        </div><!--/ .sidebar -->
        <?php endif; ?>

        <?php if ($sidebar_position != 'full')
        echo '<div class="clear"></div>'; ?>

    </div><!--/ .container_12 -->

</div><!--/ .middle -->

<div class="middle_bot"></div>

<?php get_footer(); ?>