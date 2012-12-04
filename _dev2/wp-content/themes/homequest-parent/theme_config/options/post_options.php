<?php

/* ----------------------------------------------------------------------------------- */
/* Initializes all the theme settings option fields for posts area. */
/* ----------------------------------------------------------------------------------- */

$options = array(
    /* ----------------------------------------------------------------------------------- */
    /* Sidebar */
    /* ----------------------------------------------------------------------------------- */

    /* Single Post */
    array('name' => 'Single Post',
        'id' => TF_THEME_PREFIX . '_side_media',
        'type' => 'metabox',
        'context' => 'side',
        'priority' => 'low' /* high/low */
    ),
    // Disable Single Post Image
    array('name' => 'Disable Image',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_image',
        'value' => tfuse_options('disable_image','false'),
        'type' => 'checkbox'
    ),
    // Disable Single Post Video
    array('name' => 'Disable Video',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_video',
        'value' => tfuse_options('disable_video','false'),
        'type' => 'checkbox'
    ),
    // Disable Single Post Comments
    array('name' => 'Disable Comments',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_comments',
        'value' => tfuse_options('disable_posts_comments','false'),
        'type' => 'checkbox',
        'divider' => true
    ),
    // Author Info
    array('name' => 'Disable Author Info',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_author_info',
        'value' => tfuse_options('disable_author_info','false'),
        'type' => 'checkbox'
    ),
    // Post Meta
    array('name' => 'Disable Meta',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_post_meta',
        'value' => tfuse_options('disable_post_meta','false'),
        'type' => 'checkbox'
    ),
    // Published Date
    array('name' => 'Disable Published Date',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_published_date',
        'value' => tfuse_options('disable_published_date','false'),
        'type' => 'checkbox'
    ),
    // Share Buttons
    array('name' => 'Disable Share Buttons',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_share_buttons',
        'value' => tfuse_options('_disable_share_buttons','false'),
        'type' => 'checkbox'
    ),
    
    /* ----------------------------------------------------------------------------------- */
    /* After Textarea */
    /* ----------------------------------------------------------------------------------- */

    /* Post Media */
    array('name' => 'Media',
        'id' => TF_THEME_PREFIX . '_media',
        'type' => 'metabox',
        'context' => 'normal'
    ),
    // Single Image
    array('name' => 'Image',
        'desc' => 'This is the main image for your post. Upload one from your computer, or specify an online address for your image (Ex: http://yoursite.com/image.png).',
        'id' => TF_THEME_PREFIX . '_single_image',
        'value' => '',
        'type' => 'upload'
    ),
    // Single Image Dimensions
    array('name' => 'Image Resize (px)',
        'desc' => 'These are the default width and height values. If you want to resize the image change the values with your own. If you input only one, the image will get resized with constrained proportions based on the one you specified.',
        'id' => TF_THEME_PREFIX . '_single_img_dimensions',
        'value' => tfuse_options('single_image_dimensions'),
        'type' => 'textarray'
    ),
    // Single Image Position
    array('name' => 'Image Position',
        'desc' => 'Select your preferred image  alignment',
        'id' => TF_THEME_PREFIX . '_single_img_position',
        'value' => tfuse_options('single_image_position'),
        'options' => array(
            'noalign' => array($url . 'full_width.png', 'Don\'t apply an alignment'),
            'alignleft' => array($url . 'left_off.png', 'Align to the left'),
            'alignright' => array($url . 'right_off.png', 'Align to the right')
            ),
        'type' => 'images',
        'divider' => true
    ),    
    // Thumbnail Image
    array('name' => 'Thumbnail',
        'desc' => 'This is the thumbnail for your post. Upload one from your computer, or specify an online address for your image (Ex: http://yoursite.com/image.png).',
        'id' => TF_THEME_PREFIX . '_thumbnail_image',
        'value' => '',
        'type' => 'upload'
    ),
    // Posts Thumbnail Dimensions
    array('name' => 'Thumbnail Dimension (px)',
        'desc' => 'These are the default width and height values. If you want to resize the thumbnail change the values with your own. If you input only one, the thumbnail will get resized with constrained proportions based on the one you specified.',
        'id' => TF_THEME_PREFIX . '_thumbnail_dimensions',
        'value' => tfuse_options('thumbnail_dimensions'),
        'type' => 'textarray'
    ),
    // Thumbnail Position
    array('name' => 'Thumbnail Position',
        'desc' => 'Select your preferred thumbnail alignment',
        'id' => TF_THEME_PREFIX . '_thumbnail_position',
        'value' => tfuse_options('thumbnail_position'),
        'options' => array(
            'noalign' => array($url . 'full_width.png', 'Don\'t apply an alignment'),
            'alignleft' => array($url . 'left_off.png', 'Align to the left'),
            'alignright' => array($url . 'right_off.png', 'Align to the right')
            ),
        'type' => 'images',
        'divider' => true
    ),
    // Custom Post Video
    array('name' => 'Video',
        'desc' => 'Copy paste the video URL or embed code. The video URL works only for Vimeo and YouTube videos. Read <a target="_blank" href="http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/">prettyPhoto documentation</a>
                    for more info on how to add video or flash in this text area
                    ',
        'id' => TF_THEME_PREFIX . '_video_link',
        'value' => '',
        'type' => 'textarea'
    ),
    // Video Dimensions
    array('name' => 'Video Size (px)',
        'desc' => 'These are the default width and height values. If you want to resize the video change the values with your own. If you input only one, the video will get resized with constrained proportions based on the one you specified.',
        'id' => TF_THEME_PREFIX . '_video_dimensions',

        'value' => tfuse_options('video_dimensions'),

        'type' => 'textarray'
    ),
    // Video Position
    array('name' => 'Video Position',
        'desc' => 'Select your preferred video alignment',
        'id' => TF_THEME_PREFIX . '_video_position',

        'value' => tfuse_options('video_position'),

        'options' => array(
            '' => array($url . 'full_width.png', 'Don\'t apply an alignment'),
            'alignleft' => array($url . 'left_off.png', 'Align to the left'),
            'alignright' => array($url . 'right_off.png', 'Align to the right')
            ),
        'type' => 'images'
    ),   
    /* Header Options */
    array('name' => 'Page elements',
        'id' => TF_THEME_PREFIX . '_header_option',
        'type' => 'metabox',
        'context' => 'normal'
    ),
    // Element of Hedear
    array('name' => 'Hedear Element',
        'desc' => 'Select what do you want in your post header',
        'id' => TF_THEME_PREFIX . '_header_element',
        'value' => 'search',
        'options' => array('none' => 'Without Element', 'search' => 'Search', 'slider' => 'Slider', 'search_slider' => 'Search and Slider', ),
        'type' => 'select',
    ),
    array(
        'name' => 'Search Type',
        'desc' => 'Do you want your search to be Collapsed or Expanded when the page loads?',
        'id' => TF_THEME_PREFIX . '_search_type',
        'value' => 'closed',
        'options' =>  array('closed' => 'Collapsed', 'expanded' => 'Expanded'),
        'type' => 'select'
    ),
    // Select Search Slider
    $this->ext->slider->model->has_sliders() ?
        array(
            'name' => 'Slider',
            'desc' => 'Select a slider for your post. The sliders are created on the <a href="' . admin_url( 'admin.php?page=tf_slider_list' ) . '" target="_blank">Sliders page</a>.',
            'id' => TF_THEME_PREFIX . '_select_search_slider',
            'value' => '',
            'options' => $TFUSE->ext->slider->get_sliders_dropdown('slidesjs'),
            'type' => 'select'
        ) :
        array(
            'name' => 'Slider',
            'desc' => '',
            'id' => TF_THEME_PREFIX . '_select_search_slider',
            'value' => '',
            'html' => 'No sliders created yet. You can start creating one <a href="' . admin_url('admin.php?page=tf_slider_list') . '">here</a>.',
            'type' => 'raw'
        ),
    // Select Slider
    $this->ext->slider->model->has_sliders() ?
        array(
            'name' => 'Slider',
            'desc' => 'Select a slider for your post. The sliders are created on the <a href="' . admin_url( 'admin.php?page=tf_slider_list' ) . '" target="_blank">Sliders page</a>.',
            'id' => TF_THEME_PREFIX . '_select_slider',
            'value' => '',
            'options' => $TFUSE->ext->slider->get_sliders_dropdown('jcarousel'),
            'type' => 'select'
        ) :
        array(
            'name' => 'Slider',
            'desc' => '',
            'id' => TF_THEME_PREFIX . '_select_slider',
            'value' => '',
            'html' => 'No sliders created yet. You can start creating one <a href="' . admin_url('admin.php?page=tf_slider_list') . '">here</a>.',
            'type' => 'raw'
        ),
    // Before Content Element
    array('name' => 'Before Content Element',
        'desc' => 'Select type of element before content.',
        'id' => TF_THEME_PREFIX . '_before_content_element',
        'value' => 'none',
        'options' => array( 'none' => 'Without Element', 'map' => 'Map', 'slider' => 'Slider', 'latest_added' => 'Latest Added ' . __( TF_SEEK_HELPER::get_option('seek_property_name_plural',''), 'tfuse')),
        'type' => 'select',
    ),
    // Select Slider
    $this->ext->slider->model->has_sliders() ?
        array(
            'name' => 'Slider',
            'desc' => 'Select a slider for your post. The sliders are created on the <a href="' . admin_url( 'admin.php?page=tf_slider_list' ) . '" target="_blank">Sliders page</a>.',
            'id' => TF_THEME_PREFIX . '_before_content_select_slider',
            'value' => '',
            'options' => $TFUSE->ext->slider->get_sliders_dropdown('jcarousel'),
            'type' => 'select'
        ) :
        array(
            'name' => 'Slider',
            'desc' => '',
            'id' => TF_THEME_PREFIX . '_before_content_select_slider',
            'value' => '',
            'html' => 'No sliders created yet. You can start creating one <a href="' . admin_url('admin.php?page=tf_slider_list') . '">here</a>.',
            'type' => 'raw'
        ),
    array(
        'name' => 'Map position',
        'desc' => 'Choose your map location',
        'id' => TF_THEME_PREFIX . '_page_map',
        'value' => '',
        'type' => 'maps'
    ),
    array(
        'name' => 'Number of properties to show',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_properties_number',
        'value' => '8',
        'type' => 'text'
    ),
);

?>