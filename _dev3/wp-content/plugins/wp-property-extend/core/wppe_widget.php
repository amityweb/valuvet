<?php
/* Content Posts */
add_action( 'widgets_init', 'wppe_widget' );


function wppe_widget() {
	register_widget( 'Featured_Property_Widget' );
}


class Featured_Property_Widget extends WP_Widget {

	function Featured_Property_Widget() {
		$widget_ops = array( 'classname' => 'featured_property', 'description' => __('A widget for featured properties', 'featured_property') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'featured-property-widget' );
		$this->WP_Widget( 'featured-property-widget', __('Featured Property', 'featured_property'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );

		echo $before_widget . "\n";
?>
            	<div class="col_width">

                	<div class="headingmenu" style="margin-bottom:7px; text-align:center;">

                    <ul>

                        <li><a style="cursor: pointer;"><span class="headingmenu10">Feature Property - FOR SALE</span></a></li>

                    </ul>

                    </div>
<div id="feature_property" class="feature_property_con" >
                    <?php
						$querystr = "
						  SELECT PO.ID,PO.post_title
						  FROM $wpdb->posts AS PO 
						  LEFT JOIN $wpdb->postmeta AS PM
						  ON PO.ID = PM.post_id 
						  WHERE 
						  PO.post_status = 'publish' 
						  AND PO.post_type = 'property'
						  AND PM.meta_key='property_type'
						  AND PM.meta_value='package_3'
						  GROUP BY PO.ID
						  ORDER BY PO.post_date DESC
						  LIMIT 0, 10;";
						$page_contents = $wpdb->get_results($querystr, OBJECT);
						if ($page_contents):
							foreach ($page_contents as $post):
							$permalink = get_permalink( $post->ID );
							$custom_fields = get_post_custom( $post->ID );
							$default_attr = array(
										'alt'	=> trim(strip_tags( $attachment->post_title )),
										'title'	=> trim(strip_tags( $attachment->post_title )),
									);
							?>
                            <div>
                                <a href="<?=$permalink?>"><span class="img-featured"><?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?></span></a>
                                <H1><?php echo $post->post_title?></H1>
                                <a href="<?=$permalink?>" target="_parent">view more...</a>
                             </div>
<?php						endforeach;
						endif;
					?>
                </div>
</div>          
			<?php 
		echo "\n" . $after_widget;
	}
	
	
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
	global $wpdb;

	}
}

