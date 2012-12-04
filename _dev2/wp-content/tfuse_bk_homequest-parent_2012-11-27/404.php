<?php get_header(); ?>

<?php $sidebar_position = tfuse_sidebar_position(); ?>

<div <?php tfuse_class('middle'); ?>>

    <div class="container_12">

        <?php if ($sidebar_position == 'left') : ?>
        <div class="grid_4 sidebar">
            <?php get_sidebar(); ?>
        </div><!--/ .sidebar -->
        <?php endif; ?>

        <div <?php tfuse_class('content'); ?>>
            <div class="post-item">
                <div class="entry">
                    <h2><?php _e('Page not found', 'tfuse') ?></h2>
                    <p><?php _e('The page you were looking for doesn&rsquo;t seem to exist', 'tfuse') ?>.</p>
                </div><!--/ .entry -->
            </div><!--/ .post-item -->
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