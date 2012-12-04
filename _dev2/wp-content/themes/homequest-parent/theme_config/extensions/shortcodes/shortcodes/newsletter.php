<?php

/**
 * Newsletter
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * title: e.g. Newsletter signup
 * text: e.g. Thank you for your subscribtion.
 * action: URL where to send the form data.
 * rss_feed:
 */

function tfuse_newsletter($atts, $content = null)
{
    extract(shortcode_atts(array('title' => '', 'text' => '', 'rss_feed' => '','sendtitle' => 'Send'), $atts));

    if (empty($title))
        $title = __('Newsletter', 'tfuse');
   /* if (empty($text))
        $text = __('Sign up for our weekly newsletter to receive updates, news, and promos:', 'tfuse');*/

    $out = '<div class="widget-container newsletter_subscription_box newsletterBox">
    <div class="inner">
        <h3>' . $title . '</h3>

        <div class="newsletter_subscription_messages before-text">

            <div class="newsletter_subscription_message_success">' . __('Thank you for your subscribtion.','tfuse') . '</div>
            <div class="newsletter_subscription_message_wrong_email" style="padding-left: 25px;">' . __('Your email format is wrong!','tfuse') . '</div>
            <div class="newsletter_subscription_message_failed">' . __('Sad, but we couldn\'t add you to our mailing list ATM.','tfuse') . '</div>
        </div>

        <form action="#" method="post" class="newsletter_subscription_form">';
            $out .= '<input type="text" value="' . __('Enter your email address','tfuse') . '" ';
            $out .= 'onfocus="if (this.value == \'' . __('Enter your email address','tfuse') . '\') {this.value = \'\';}" ';
            $out .= 'onblur="if (this.value == \'\') {this.value = \'' . __('Enter your email address','tfuse') . '\';}" ';
            $out .= 'name="newsletter" class="newsletter_subscription_email inputField" />';
            $out .= '<input type="submit" value="' . $sendtitle . '" class="btn-arrow newsletter_subscription_submit" />';
            if ( $rss_feed == 'true' )
                $out .= '<div class="newsletter_text"><a href="' . tfuse_options('feedburner_url', get_bloginfo_rss('rss2_url')) . '" class="link-news-rss">' . __('You can also ', 'tfuse') . ' <span>' . __('Subscribe to our RSS', 'tfuse') . '</span></a></div>';
        $out .= '</form><div class="newsletter_subscription_ajax">'. __('Loading','tfuse').'...</div>';
    $out .= '</div></div>';

    return $out;
}

$atts = array(
    'name' => 'Newsletter',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Enter the title of the Newsletter form',
            'id' => 'tf_shc_newsletter_title',
            'value' => 'SUBSCRIBE TO NEWSLETTER:',
            'type' => 'text'
        ),
        array(
            'name' => 'RSS Feed',
            'desc' => 'Show RSS Feed link?',
            'id' => 'tf_shc_newsletter_rss_feed',
            'value' => 'false',
            'type' => 'checkbox'
        ),
        array(
            'name' => 'Send Title',
            'desc' => 'Title for send button',
            'id' => 'tf_shc_newsletter_sendtitle',
            'value' => 'Send',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('newsletter', 'tfuse_newsletter', $atts);
