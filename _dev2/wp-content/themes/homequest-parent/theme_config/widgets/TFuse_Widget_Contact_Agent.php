<?php

// =============================== Flickr widget ======================================

class TFuse_Contact_The_Agent extends WP_Widget {

	function TFuse_Contact_The_Agent() {
            $widget_ops = array('description' => '' );
            parent::WP_Widget(false, __('TFuse - Contact The Agent', 'tfuse'),$widget_ops);
	}

	function widget($args, $instance) {
            extract( $args );
            $title = esc_attr($instance['title']);
            if($title  == '') $title = 'CONTACT THE AGENT:';
            $phone = esc_attr($instance['phone']);
            global $wp_query;
            $property_title = '';
            $property_title = @$wp_query-> queried_object -> post_title;
            wp_enqueue_script( 'contactform' );
            ?>
    <!-- contact agent -->
    <div class="widget-container widget_adv_filter">
        <h3 class="widget-title"><?php _e($title, 'tfuse'); ?></h3>

        <form action="#" method="get" class="form_white agent_form" id="agent_form">

            <div class="row">
                <label class="label_title"><?php _e('First Name', 'tfuse'); ?>:</label>
                <input type="text" id="first_name" name="first_name" class="inputField" value="<?php _e('enter your first name','tfuse'); ?>" onfocus="if (this.value == <?php _e('enter your first name','tfuse'); ?>) {this.value = '';}" onblur="if (this.value == '') {this.value = <?php _e('enter your first name','tfuse'); ?>}">
            </div>

            <div class="row">
                <label class="label_title"><?php _e('Last Name', 'tfuse'); ?>:</label>
                <input type="text" id="last_name" name="last_name" class="inputField required" value="<?php _e('enter your last name','tfuse'); ?>" onfocus="if (this.value == <?php _e('enter your last name','tfuse'); ?>) {this.value = '';}" onblur="if (this.value == '') {this.value = <?php _e('enter your last name','tfuse'); ?>}">
            </div>

            <div class="row input_styled inlinelist">
                <label class="label_title"><?php _e('How should we contact you', 'tfuse'); ?>:</label><br>
                <input type="radio" class="contact_type" name="contact_type" value="ct_email" id="ct_email" checked> <label for="ct_email"><?php _e('by Email', 'tfuse'); ?></label>
                <input type="radio" class="contact_type" name="contact_type" value="ct_phone" id="ct_phone"> <label for="ct_phone"><?php _e('by Phone', 'tfuse'); ?></label>
                <input type="radio" class="contact_type" name="contact_type" value="ct_both" id="ct_both"> <label for="ct_both"><?php _e('both','tfuse'); ?></label>
            </div>

            <div class="row">
                <label class="label_title"><?php _e('Your Email', 'tfuse'); ?>*:</label>
                <input type="text" id="email" name="email" class="inputField required" value="<?php _e('enter your email','tfuse'); ?>" onfocus="if (this.value == <?php _e('enter your email','tfuse'); ?>) {this.value = '';}" onblur="if (this.value == '') {this.value = <?php _e('enter your email','tfuse'); ?>}">
            </div>

            <div class="row">
                <label class="label_title"><?php _e('Your Phone', 'tfuse');?>:</label>
                <input type="text" id="phone" name="phone" class="inputField" value="<?php _e('enter your phone','tfuse'); ?>" onfocus="if (this.value == <?php _e('enter your phone','tfuse'); ?>) {this.value = '';}" onblur="if (this.value == '') {this.value = <?php _e('enter your phone','tfuse'); ?>;}">
            </div>

            <div class="row">
                <label class="label_title"><?php _e('Message', 'tfuse');?>*:</label>
                <textarea rows="4" cols="5" id="message" name="message" class="textareaField required"><?php if ($property_title) { _e('I would like to inquire about  the property at', 'tfuse'); echo ' ' . $property_title; } ?></textarea>
            </div>

            <div class="row input_styled rowCheck">

                <input type="checkbox" name="newsletter_subscribe" id="newsletter_subscribe" value="1" checked> <label for="newsletter_subscribe"><?php _e("I&rsquo;d like to receive", "tfuse"); ?> <a href="<?php bloginfo('url');?>"><?php bloginfo('name'); ?></a> <?php _e("newsletter", "tfuse"); ?></label>

                <input type="submit" value="CONTACT AGENT" rel="<?php echo @$wp_query-> queried_object -> ID?>" id="submit_to_agent" class="btn-submit">
                <label style="margin-left: 35px; color: #23ad14; display: none;" class="contact_agent_success"><?php _e('Your message has been sent.','tfuse'); ?></label>
                <label style="margin-left: 35px; color: #ff0000; display: none;" class="contact_agent_error"><?php _e('Oops something went wrong.','tfuse'); ?></label>
                <label style="margin-left: 35px; color: #ff0000; display: none;" class="contact_agent_error"><?php _e('Please try again later','tfuse'); ?></label>
            </div>

        </form>

        <?php if ($phone != '') : ?>
            <div class="agent_phone">
                <span><?php _e('OR CALL US RIGHT NOW', 'tfuse'); ?></span>
                <p><strong><?php echo $phone; ?></strong></p>
            </div>
        <?php endif; ?>
    </div>
    <!--/ contact agent -->
	   <?php
   }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['phone'] = $new_instance['phone'];

        return $instance;
    }
   function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(  'title' => '', 'phone' => '') );
		$title = esc_attr($instance['title']);
		$phone = esc_attr($instance['phone']);
		?>
        <p>
            <label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Title:','tfuse'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Contact Phone','tfuse'); ?>:</label>
            <input type="text" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo $phone; ?>" class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" />
        </p>
		<?php
	}
}
register_widget('TFuse_Contact_The_Agent');
