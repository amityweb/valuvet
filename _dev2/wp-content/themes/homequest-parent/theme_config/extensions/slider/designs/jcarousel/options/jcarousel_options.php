<?php

/**
 * JCarousel slider's configurations
 *
 * @since HomeQuest 1.0
 */

$options = array(
    'tabs' => array(
        array(
            'name' => 'Slider Settings',
            'id' => 'slider_settings', #do no t change this ID
            'headings' => array(
                array(
                    'name' => 'Slider Settings',
                    'options' => array(
                        array('name' => 'Slider Title',
                            'desc' => 'Change the title of your slider. Only for internal use (Ex: Homepage)',
                            'id' => 'slider_title',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true),
                        array(
                            'name' => 'Speed animation',
                            'desc' => 'The speed of the scroll animation as string in jQuery terms (<code>"slow"</code>
          or <code>"fast"</code>) or milliseconds as integer
           (See <a href="http://docs.jquery.com/effects/animate" target="_blank">jQuery Documentation</a>).
            If set to 0, animation is turned off.',
                            'id' => 'slider_animation',
                            'value' => '600',
                            'type' => 'text',
                            'required' => TRUE
                        ),
                        array(
                            'name' => 'Animation style',
                            'desc' => 'The name of the easing effect that you want to use (See <a href="http://docs.jquery.com/effects/animate" target="_blank">jQuery Documentation</a>).',
                            'id' => 'slider_easing',
                            'value' => 'easeOutBack',
                            'options' => array('linear' => 'Linear', 'swing' => 'Swing', 'easeInQuad' => 'EaseInQuad', 'easeOutQuad' => 'EaseOutQuad',
                                'easeInOutQuad' => 'EaseInOutQuad', 'easeInCubic' => 'EaseInCubic', 'easeOutCubic' => 'EaseOutCubic', 'easeInOutCubic' => 'EaseInOutCubic',
                                'easeInQuart' => 'EaseInQuart', 'easeOutQuart' => 'EaseOutQuart', 'easeInOutQuart' => 'EaseInOutQuart', 'easeInQuint' => 'EaseInQuint',
                                'easeOutQuint' => 'EaseOutQuint', 'easeInOutQuint' => 'EaseInOutQuint', 'easeInSine' => 'EaseInSine', 'easeOutSine' => 'EaseOutSine',
                                'easeInOutSine' => 'EaseInOutSine', 'easeInExpo' => 'EaseInExpo', 'easeOutExpo' => 'EaseOutExpo', 'easeInOutExpo' => 'EaseInOutExpo',
                                'easeInCirc' => 'EaseInCirc', 'easeOutCirc' => 'EaseOutCirc', 'easeInOutCirc' => 'EaseInOutCirc', 'easeInElastic' => 'EaseInElastic',
                                'easeOutElastic' => 'EaseOutElastic', 'easeInOutElastic' => 'EaseInOutElastic', 'easeInBack' => 'EaseInBack', 'easeOutBack' => 'EaseOutBack',
                                'easeInOutBack' => 'EaseInOutBack', 'easeInBounce' => 'EaseInBounce', 'easeOutBounce' => 'EaseOutBounce', 'easeInOutBounce' => 'EaseInOutBounce' ),
                            'type' => 'select',
                            'required' => TRUE
                        ),
                        array(
                            'name' => 'Scroll',
                            'desc' => 'The number of items to scroll by.',
                            'id' => 'slider_scroll',
                            'value' => '1',
                            'type' => 'text',
                            'proprieters' => array("maxlength" => 2),
                            'required' => TRUE
                        ),
                        array(
                            'name' => 'Auto',
                            'desc' => 'Specifies how many seconds to periodically autoscroll the content. If set to 0 (default) then autoscrolling is turned off.',
                            'id' => 'slider_auto',
                            'value' => '0',
                            'type' => 'text',
                            'required' => TRUE
                        ),
                        /*array(
                            'name' => 'Right-To-Left',
                            'desc' => 'Specifies wether the carousel appears in RTL (Right-To-Left) mode.',
                            'id' => 'slider_rtl',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'required' => TRUE
                        ),*/
                        array('name' => 'Resize images?',
                            'desc' => 'Want to let our script to resize the images for you? Or do you want to have total control and upload images with the exact slider image size?',
                            'id' => 'slider_image_resize',
                            'value' => 'false',
                            'type' => 'checkbox')
                    )
                )
            )
        ),
        array(
            'name' => 'Add/Edit Slides',
            'id' => 'slider_setup', #do not change ID
            'headings' => array(
                array(
                    'name' => 'Add New Slide', #do not change
                    'options' => array(
                        array('name' => 'Title',
                            'desc' => ' The Title is displayed on the image and will be visible by the users',
                            'id' => 'slide_title',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true),
                        array('name' => 'Link',
                            'desc' => 'Set the slide link URL.',
                            'id' => 'slide_link_url',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true),
                        array('name' => 'Link Target',
                            'desc' => '',
                            'id' => 'slide_link_target',
                            'value' => '',
                            'options' => array('_self' => 'Self', '_blank' => 'Blank'),
                            'type' => 'select',
                            'divider' => true),
                        // Custom Favicon Option
                        array('name' => 'Image <br />(218px × 125px)',
                            'desc' => 'You can upload an image from your hard drive or use one that was already uploaded by pressing  "Insert into Post" button from the image uploader plugin.',
                            'id' => 'slide_src',
                            'value' => '',
                            'type' => 'upload',
                            'media' => 'image',
                            'required' => TRUE)
                    )
                )
            )
        ),
        array(
            'name' => 'Category Setup',
            'id' => 'slider_type_categories',
            'headings' => array(
                array(
                    'name' => 'Category options',
                    'options' => array(
                        array(
                            'name' => 'Select specific categories',
                            'desc' => 'Pick one or more 
categories by starting to type the category name. If you leave blank the slider will fetch images 
from all <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=category">Categories</a>.',
                            'id' => 'categories_select',
                            'type' => 'multi',
                            'subtype' => 'category'
                        ),
                        array(
                            'name' => 'Number of images in the slider',
                            'desc' => 'How many images do you want in the slider?',
                            'id' => 'sliders_posts_number',
                            'value' => 6,
                            'type' => 'text'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Posts Setup',
            'id' => 'slider_type_posts',
            'headings' => array(
                array(
                    'name' => 'Posts options',
                    'options' => array(
                        array(
                            'name' => 'Select specific Posts',
                            'desc' => 'Pick one or more <a target="_new" href="' . get_admin_url() . 'edit.php">posts</a> by starting to type the Post name. The slider will be populated with images from the posts 
you selected.',
                            'id' => 'posts_select',
                            'type' => 'multi',
                            'subtype' => 'post,'.TF_SEEK_HELPER::get_post_type()
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Tags Setup',
            'id' => 'slider_type_tags',
            'headings' => array(
                array(
                    'name' => 'Tags options',
                    'options' => array(
                        array(
                            'name' => 'Select specific tags',
                            'desc' => 'Pick one or more <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=post_tag">tags</a> by starting to type the tag name. The slider will be populated with images from posts 
that have the selected tags.',
                            'id' => 'tags_select',
                            'type' => 'multi',
                            'subtype' => 'post_tag'
                        )
                    )
                )
            )
        )
    )
);
$options['extra_options'] = array();
?>