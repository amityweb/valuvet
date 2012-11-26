<div class="clear"></div>

</div>

</div>

</div>

<!-- end page -->







    <div id="footer_shadow">&nbsp;</div>

	<div id="base_col_wrap">

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('newsletter-widget-area') ) : ?><?php endif; ?>

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('featureproperty-widget-area') ) : ?><?php endif; ?>

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('national-schedule-widget-area') ) : ?><?php endif; ?>

        <div class="clear"></div>

        <div style="padding-top:20px;">&nbsp;</div>

        


        <!--Part Footer-->

        <div id="footer2_bot">
        
        <?php valuvet_menu_set( array(
                        'container'       => 'ul', 
                        'menu_class'      => 'sf-menu', 
                        'menu_id'         => 'footer2_navigation',
                        'depth'           => 0,
						'echo'			=> false,
                        'theme_location' => 'footer_menu')  );?>


        </div>
        
    </div>
    
<?php wp_footer() ?>

</body>
</html>