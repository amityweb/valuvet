<?php

/* Content Posts */
add_action( 'widgets_init', 'newsletter_widget' );


function newsletter_widget() {
	register_widget( 'Newsletter_Widget' );
}


class Newsletter_Widget extends WP_Widget {

	function Newsletter_Widget() {
		$widget_ops = array( 'classname' => 'newsletter_subscribers', 'description' => __('A widget to subscribe for newsletter', 'newsletter_subscribers') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'newsletter-subscribe-widget' );
		$this->WP_Widget( 'newsletter-subscribe-widget', __('Newsletter subscribe', 'newsletter_subscribers'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget . "\n";
?>

            	<div class="col_width">

                	<div class="headingmenu" style="margin-bottom:7px;">

                    <ul>

                        <li><a style="cursor: pointer;" href="#newsletter_popup" class="newsletter_popup_link"><span class="headingmenu10">Subscribe to our Newsletter</span></a></li>

                    </ul>

                    </div>


					<div style="display:none;">
                    <div id="newsletter_popup" class="form_openclose acc_con">

<?php

         $front = new FrontMeeNews();
         echo "<ul style='border:0px;padding:2px;overflow:hidden' ><li>";
         echo  $front->showFront();
        echo "<br></li></ul>";
		 
		 ?>
                    </div>
                    </div>

                    <div><img src="<?php bloginfo('stylesheet_directory'); ?>/images/vv_news_autumn_2011.jpg" alt="" /></div>

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


?>