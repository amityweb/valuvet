<?php
class TF_Widget_Contact extends WP_Widget
{

    function TF_Widget_Contact()
    {
        $widget_ops = array('classname' => 'widget_contact', 'description' => __( 'Add Contact in Sidebar','tfuse') );
        $this->WP_Widget('contact', __('TFuse Contact Widgets','tfuse'), $widget_ops);
    }

    function widget( $args, $instance )
    {
        extract($args);

        $template_directory = get_template_directory_uri();

        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        $before_widget = '<div class="widget-container widget_contact">';
        $after_widget = '</div>';
        $before_title = '<h3 class="widget-title">';
        $after_title = '</h3>';
        $tfuse_title = (!empty($title)) ? $before_title .tfuse_qtranslate($title) .$after_title : '';

        echo $before_widget;

        // echo widgets title
        echo $tfuse_title;
        ?>
            <div class="inner">
                <?php if (!empty($instance['adress'])) : ?><div class="contact-address"><?php echo $instance['adress']; ?></div><?php endif; ?>
                <?php if (!empty($instance['phone'])) : ?><div class="contact-phone"><span><?php _e('Phone', 'tfuse'); ?>:</span> <?php echo $instance['phone']; ?></div><?php endif; ?>
                <?php if (!empty($instance['email'])) : ?><div class="contact-mail"><span><?php _e('Email', 'tfuse'); ?>:</span> <?php echo $instance['email']; ?></div><?php endif; ?>
                <?php if (!empty($instance['extra1_title']) && !empty($instance['extra1_content'])) : ?><div class="contact-extra"><span><?php echo $instance['extra1_title'];?>:</span> <?php echo $instance['extra1_content'];?></div><?php endif; ?>
                <?php if (!empty($instance['extra2_title']) && !empty($instance['extra2_content'])) : ?><div class="contact-extra"><span><?php echo $instance['extra2_title'];?>:</span> <?php echo $instance['extra2_content'];?></div><?php endif; ?>

                <?php if (!empty($instance['skype']) || !empty($instance['twitter']) || !empty($instance['facebook'])) : ?>
                <div class="contact-social">
                    <?php if (!empty($instance['skype'])) : ?>
                    <div><strong><?php _e('Call us on', 'tfuse'); ?>:</strong> <br>
                        <a href="skype:<?php echo $instance['skype']; ?>?call"><img src="<?php echo $template_directory?>/images/social_skype.png" width="79" height="25" alt=""></a></div>
                    <?php endif; ?>
                    <?php if (!empty($instance['twitter'])) : ?>
                    <div><strong><?php _e('Follow on','tfuse'); ?>:</strong> <br>
                        <a href="<?php echo $instance['twitter']?>"><img src="<?php echo $template_directory?>/images/share_twitter.png" width="79" height="25" alt=""></a></div>
                    <?php endif; ?>
                    <?php if (!empty($instance['facebook'])) : ?>
                    <div><strong><?php _e('Join us on', 'tfuse'); ?>:</strong> <br>
                        <a href="<?php echo $instance['facebook']; ?>"><img src="<?php echo $template_directory?>/images/share_facebook.png" width="88" height="25" alt=""></a></div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </div>
                <?php endif; ?>
            </div>
        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $new_instance = wp_parse_args( (array) $new_instance, array( 'title'=>'', 'email' => '', 'adress' => '', 'phone' => '', 'extra1_title' => '', 'extra1_content' => '', 'extra2_title' => '', 'extra2_content' => '', 'skype' => '', 'twitter' => '', 'facebook' => '') );

        $instance['title']      = $new_instance['title'];
        $instance['adress']      = $new_instance['adress'];
        $instance['phone']      = $new_instance['phone'];
        $instance['email']      = $new_instance['email'];
        $instance['extra1_title']      = $new_instance['extra1_title'];
        $instance['extra1_content']      = $new_instance['extra1_content'];
        $instance['extra2_title']      = $new_instance['extra2_title'];
        $instance['extra2_content']      = $new_instance['extra2_content'];
        $instance['skype']      = $new_instance['skype'];
        $instance['twitter']      = $new_instance['twitter'];
        $instance['facebook']      = $new_instance['facebook'];

        return $instance;
    }

    function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, array( 'title'=>'', 'email' => '', 'adress' => '', 'phone' => '', 'extra1_title' => '', 'extra1_content' => '', 'extra2_title' => '', 'extra2_content' => '', 'skype' => '', 'twitter' => '', 'facebook' => '') );
        $title = $instance['title'];
?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','tfuse'); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('adress'); ?>"><?php _e('Adress:','tfuse'); ?></label><br/>
        <input class="widefat " id="<?php echo $this->get_field_id('adress'); ?>" name="<?php echo $this->get_field_name('adress'); ?>" type="text" value="<?php echo esc_attr($instance['adress']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:','tfuse'); ?></label><br/>
       <input class="widefat " id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo esc_attr($instance['phone']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:','tfuse'); ?></label><br/>
        <input class="widefat " id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo  esc_attr($instance['email']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('extra1_title'); ?>"><?php _e('Extra 1 Title:','tfuse'); ?></label><br/>
        <input class="widefat " id="<?php echo $this->get_field_id('extra1_title'); ?>" name="<?php echo $this->get_field_name('extra1_title'); ?>" type="text" value="<?php echo  esc_attr($instance['extra1_title']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('extra1_content'); ?>"><?php _e('Extra 1 Content:','tfuse'); ?></label><br/>
        <input class="widefat " id="<?php echo $this->get_field_id('extra1_content'); ?>" name="<?php echo $this->get_field_name('extra1_content'); ?>" type="text" value="<?php echo  esc_attr($instance['extra1_content']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('extra2_title'); ?>"><?php _e('Extra 2 Title:','tfuse'); ?></label><br/>
        <input class="widefat " id="<?php echo $this->get_field_id('extra2_title'); ?>" name="<?php echo $this->get_field_name('extra2_title'); ?>" type="text" value="<?php echo  esc_attr($instance['extra2_title']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('extra2_content'); ?>"><?php _e('Extra 2 Content:','tfuse'); ?></label><br/>
        <input class="widefat " id="<?php echo $this->get_field_id('extra2_content'); ?>" name="<?php echo $this->get_field_name('extra2_content'); ?>" type="text" value="<?php echo  esc_attr($instance['extra2_content']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('skype'); ?>"><?php _e('Skype ID:','tfuse'); ?></label><br/>
        <input class="widefat " id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" type="text" value="<?php echo  esc_attr($instance['skype']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:','tfuse'); ?></label><br/>
        <input class="widefat " id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo  esc_attr($instance['twitter']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:','tfuse'); ?></label><br/>
        <input class="widefat " id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo  esc_attr($instance['facebook']); ?>"  />
    </p>

    <?php
    }
}
register_widget('TF_Widget_Contact');
