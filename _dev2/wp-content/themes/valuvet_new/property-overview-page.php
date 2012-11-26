<?php
/**
 * The default page for property overview page.
 *
 * Used when no WordPress page is setup to display overview via shortcode.
 * Will be rendered as a 404 not-found, but still can display properties.
 *
 * @package WP-Property
 */
 global $post, $wp_properties;
 global $wp_query;
get_header(); ?>
		<div id="container">
			<div id="content" role="main">
 

				<div id="wpp_default_overview_page" >


					<div class="entry-content">
					
					<?php if(is_404()): ?>
					<p><?php _e('Sorry, we could not find what you were looking for.  Since you are here, take a look at some of our properties.','wpp') ?></p>
					<?php endif; ?>
					<?php 
						if($wp_properties[configuration][do_not_override_search_result_page] == 'true')
							echo $content = apply_filters('the_content', $post->post_content); 
					?>					
					<div class="all-properties">
						<?php  echo WPP_Core::shortcode_property_overview(); ?>	
		<nav id="<?php echo $nav_id; ?>"><?php // var_dump($wp_query);?>
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
		</nav><!-- #nav-above -->

					</div>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->
 

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
