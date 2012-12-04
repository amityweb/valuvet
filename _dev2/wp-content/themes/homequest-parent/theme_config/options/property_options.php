<?php

$options = array(

    /* Single Page */
    array('name' => 'Single Page',
        'id' => TF_THEME_PREFIX . '_side_media',
        'type' => 'metabox',
        'context' => 'side',
        'priority' => 'low' /* high/low */
    ),
    // Page Title
    array('name' => 'Page Title',
        'desc' => 'Select your preferred Page Title.',
        'id' => TF_THEME_PREFIX . '_page_title',
        'value' => 'default_title',
        'options' => array('hide_title' => 'Hide Page Title', 'default_title' => 'Default Title', 'custom_title' => 'Custom Title'),
        'type' => 'select'
    ),
    // Custom Title
    array('name' => 'Custom Title',
        'desc' => 'Enter your custom title for this page.',
        'id' => TF_THEME_PREFIX . '_custom_title',
        'value' => '',
        'type' => 'text'
    ),

    /* ----------------------------------------------------------------------------------- */
    /* After Textarea */
    /* ----------------------------------------------------------------------------------- */
    /* Header Options */
    array('name' => 'Page elements',
        'id' => TF_THEME_PREFIX . '_header_option',
        'type' => 'metabox',
        'context' => 'normal'
    ),
    // Element of Hedear
    array('name' => 'Hedear Element',
        'desc' => 'Select what do you want in your property page header',
        'id' => TF_THEME_PREFIX . '_header_element',
        'value' => 'search',
        'options' => array('none' => 'Without Element', 'search' => 'Search', 'slider' => 'Slider', 'search_slider' => 'Search and Slider'),
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
        'value' => 'map',
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
        'name' => 'Number of properties to show',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_properties_number',
        'value' => '8',
        'type' => 'text'
    ),
    // After Content Element
    array('name' => 'After Content Element',
        'desc' => 'Select type of element after content.',
        'id' => TF_THEME_PREFIX . '_after_content_element',
        'value' => 'similar_properties',
        'options' => array('none' => 'Without Element', 'similar_properties' => 'SIMILAR PROPERTIES'),
        'type' => 'select',
    )
);
