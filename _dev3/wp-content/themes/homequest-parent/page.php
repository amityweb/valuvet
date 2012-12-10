<?php
    global $is_tf_blog_page,$post,$is_tf_front_page;
    $id_post = $post->ID;
    if(tfuse_options('blog_page') != 0 && $id_post == tfuse_options('blog_page')) $is_tf_blog_page = true;
    get_header();
    if ($is_tf_blog_page)die;
    if ( (tfuse_options('template')=='home' && $is_tf_front_page && !tfuse_options('use_page_options') ) || tfuse_get_template_name()=='template-home') {load_template(TEMPLATEPATH . '/template-home.php');die();}
    $sidebar_position = tfuse_sidebar_position();
    global $wp_query;
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

            <div class="post-detail">

                <?php tfuse_custom_title(); ?>

                <div class="entry">

                    <?php while ( have_posts() ) : the_post(); ?>
                            <?php the_content(); ?>
                            <?php tfuse_comments();
                             break; ?>
                    <?php endwhile; // end of the loop. ?>

                    <div class="clear"></div>
                </div><!--/ .entry -->

                <?php tfuse_shortcode_content('after'); ?>

            </div><!--/ .post-item -->

        </div><!--/ content -->

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