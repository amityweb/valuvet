<?php get_header(); ?>

	<div id="content">
		<div id="content_left">
		<?php if (have_posts()) : ?>
    
            <h1 class="pagetitle">Search Results</h1>
    
            <?php while (have_posts()) : the_post(); ?>
    
                <div class="post" id="post-<?php the_ID(); ?>">
                    <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry">
                        <?php the_content('Read the rest of this entry &raquo;'); ?>
                    </div>
                    <p class="meta">Posted on <?php the_time('F jS, Y') ?> by <?php the_author() ?> &nbsp;|&nbsp; <?php edit_post_link('Edit', '', ' &nbsp;|&nbsp; '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
                </div>
    
            <?php endwhile; ?>
    
            <div class="navigation">
                <div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
                <div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
            </div>
    
        <?php else : ?>
    
            <h2 class="center">No posts found. Try a different search?</h2>
            <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    
        <?php endif; ?>
	</div>
	
    <div id="content_right">
		<?php get_sidebar(); ?>
	</div>
    <div class="clear"></div>
</div> 
<?php get_footer(); ?>