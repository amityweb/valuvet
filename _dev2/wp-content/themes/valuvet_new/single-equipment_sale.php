<?php get_header(); ?>

	<div id="content">
		<div id="main_content">
        <div id="content_allpage">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
            <div class="post" id="post-<?php the_ID(); ?>">
                    <?php /*?><h2 class="title"><?php the_title(); ?></h2><?php */?>
    
                <div class="entry">
                    <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
    
                    <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                    <?php the_tags( '<p><strong>Tags</strong>: ', ', ', '</p>'); ?>
    				<?php edit_post_link( $link, $before, $after, $id ); ?>
                </div>
            </div>
    
        <?php /*?><?php comments_template(); ?><?php */?>
    
        <?php endwhile; else: ?>
    
            <p>Sorry, no posts matched your criteria.</p>
    
    <?php endif; ?>
		</div>

        <div class="clear"></div>
	</div>
    </div></div>
    
<?php get_footer(); ?>
