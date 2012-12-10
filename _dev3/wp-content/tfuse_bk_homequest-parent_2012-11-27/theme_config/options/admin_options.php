<?php

/* ----------------------------------------------------------------------------------- */
/* Initializes all the theme settings option fields for admin area. */
/* ----------------------------------------------------------------------------------- */
global $is_tf_front_page;

$options = array(
    'tabs' => array(
        array(
            'name' => 'General',
            'type' => 'tab',
            'id' => TF_THEME_PREFIX . '_general',
            'headings' => array(
                array(
                    'name' => 'General Settings',
                    'options' => array(/* 1 */
                        // Custom Logo Option
                        array(
                            'name' => 'Custom Logo',
                            'desc' => 'Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)',
                            'id' => TF_THEME_PREFIX . '_logo',
                            'value' => '',
                            'type' => 'upload'
                        ),
                        // Custom Favicon Option
                        array(
                            'name' => 'Custom Favicon <br /> (16px x 16px)',
                            'desc' => 'Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.',
                            'id' => TF_THEME_PREFIX . '_favicon',
                            'value' => '',
                            'type' => 'upload',
                            'divider' => true
                        ),
                        // Adress Box Text
                        array(
                            'name' => 'Header Contact Info',
                            'desc' => 'This contact info appears on the right side in the header of the theme',
                            'id' => TF_THEME_PREFIX . '_header_text_box',
                            'value' => '',
                            'type' => 'textarea',
                            'divider' => true
                        ),
                        // Search Box Text
                        array(
                            'name' => 'Search Box text',
                            'desc' => 'Enter your Search Box text',
                            'id' => TF_THEME_PREFIX . '_search_box_text',
                            'value' => 'enter keywords',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Tracking Code Option
                        array(
                            'name' => 'Tracking Code',
                            'desc' => 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.',
                            'id' => TF_THEME_PREFIX . '_google_analytics',
                            'value' => '',
                            'type' => 'textarea',
                            'divider' => true
                        ),
                        // Custom CSS Option
                        array(
                            'name' => 'Custom CSS',
                            'desc' => 'Quickly add some CSS to your theme by adding it to this block.',
                            'id' => TF_THEME_PREFIX . '_custom_css',
                            'value' => '',
                            'type' => 'textarea'
                        )
                    ) /* E1 */
                ),
                array(
                    'name' => 'Social',
                    'options' => array(
                        // RSS URL Option
                        array('name' => 'RSS URL',
                            'desc' => 'Enter your preferred RSS URL. (Feedburner or other)',
                            'id' => TF_THEME_PREFIX . '_feedburner_url',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // E-Mail URL Option
                        array('name' => 'E-Mail URL',
                            'desc' => 'Enter your preferred E-mail subscription URL. (Feedburner or other)',
                            'id' => TF_THEME_PREFIX . '_feedburner_id',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Facebook URL
                        array('name' => 'Facebook URL',
                            'desc' => 'Enter Facebook URL',
                            'id' => TF_THEME_PREFIX . '_facebook',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Twitter URL
                        array('name' => 'Twitter URL',
                            'desc' => 'Enter Twitter URL',
                            'id' => TF_THEME_PREFIX . '_twitter',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Twitter URL
                        array('name' => 'Devian Art URL',
                            'desc' => 'Enter Devian Art URL',
                            'id' => TF_THEME_PREFIX . '_devian',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Twitter URL
                        array('name' => 'Flickr URL',
                            'desc' => 'Enter Flickr URL',
                            'id' => TF_THEME_PREFIX . '_flickr',
                            'value' => '',
                            'type' => 'text'
                        )
                    )
                ),
                array(
                    'name' => 'Disable Theme settings',
                    'options' => array(
                        // Disable Image for All Single Posts
                        array('name' => 'Image on Single Post',
                            'desc' => 'Disable Image on All Single Posts? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_image',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Video for All Single Posts
                        array('name' => 'Video on Single Post',
                            'desc' => 'Disable Video on All Single Posts? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_video',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Comments for All Posts
                        array('name' => 'Post Comments',
                            'desc' => 'Disable Comments for All Posts? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_posts_comments',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Comments for All Pages
                        array('name' => 'Page Comments',
                            'desc' => 'Disable Comments for All Pages? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_pages_comments',
                            'value' => 'true',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Author Info
                        array('name' => 'Author Info',
                            'desc' => 'Disable Author Info? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_author_info',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Post Meta
                        array('name' => 'Post meta',
                            'desc' => 'Disable Post meta? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_post_meta',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Post Published Date
                        array('name' => 'Post Published Date',
                            'desc' => 'Disable Post Published Date? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_published_date',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable posts lightbox (prettyPhoto) Option
                        array('name' => 'prettyPhoto on Categories',
                            'desc' => 'Disable opening image and attachemnts in prettyPhoto on Categories listings? If YES, image link go to post.',
                            'id' => TF_THEME_PREFIX . '_disable_listing_lightbox',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable posts lightbox (prettyPhoto) Option
                        array('name' => 'prettyPhoto on Single Post',
                            'desc' => 'Disable opening image and attachemnts in prettyPhoto on Single Post?',
                            'id' => TF_THEME_PREFIX . '_disable_single_lightbox',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable preloadCssImages plugin
                        array('name' => 'preloadCssImages',
                            'desc' => 'Disable jQuery-Plugin "preloadCssImages"? Acest plugin inacrca automat toate imaginile din css.
                                        Daca doriti performanta (mai putine requesturi) dezactivati acest plugin.',
                            'id' => TF_THEME_PREFIX . '_disable_preload_css',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'on_update' => 'reload_page',
                            'divider' => true
                        ),
                        // Disable SEO
                        array('name' => 'SEO Tab',
                            'desc' => 'Disable SEO option?',
                            'id' => TF_THEME_PREFIX . '_disable_tfuse_seo_tab',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'on_update' => 'reload_page',
                            'divider' => true
                        ),
                        // Enable Dynamic Image Resizer Option
                        array('name' => 'Dynamic Image Resizer',
                            'desc' => 'This will Disable the thumb.php script that dynamicaly resizes images on your site. We recommend you keep this enabled, however note that for this to work you need to have "GD Library" installed on your server. This should be done by your hosting server administrator.',
                            'id' => TF_THEME_PREFIX . '_disable_resize',
                            'value' => 'false',
                            'type' => 'checkbox'
                        ),
                        // Remove wordpress versions for security reasons
                        array(
                            'name' => 'Remove Wordpress Versions',
                            'desc' => 'Remove Wordpress versions from the source code, for security reasons.',
                            'id' => TF_THEME_PREFIX . '_remove_wp_versions',
                            'value' => FALSE,
                            'type' => 'checkbox'
                        )
                    )
                ),
                array(
                    'name' => 'WordPress Admin Style',
                    'options' => array(
                        // Disable Themefuse Style
                        array('name' => 'Disable Themefuse Style',
                            'desc' => 'Disable Themefuse Style',
                            'id' => TF_THEME_PREFIX . '_deactivate_tfuse_style',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'on_update' => 'reload_page'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Blog',
            'id' => TF_THEME_PREFIX . '_blogpage',
            'headings' => array(
                array(
                    'name' => 'Blog page',
                    'options' => array(
                        array('name' => 'Blog Category',
                            'desc' => ' Select which category to display on homepage. More over you can choose to load a specific page or change the number of posts on the homepage from <a target="_blank" href="' . network_admin_url('options-reading.php') . '">here</a>',
                            'id' => TF_THEME_PREFIX . '_blogpage_category',
                            'value' => '',
                            'options' => tfuse_select_taxonomies_for_homepage(),
                            'type' => 'select',
                            'install' => 'cat',
                            'divider'   =>true
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
                    )

                )
            )
        ),
        array(
            'name' => 'Posts',
            'id' => TF_THEME_PREFIX . '_posts',
            'headings' => array(
                array(
                    'name' => 'Default Post Options',
                    'options' => array(
                        // Post Content
                        array('name' => 'Post Content',
                            'desc' => 'Select if you want to show the full content (use <em>more</em> tag) or the excerpt on posts listings (categories).',
                            'id' => TF_THEME_PREFIX . '_post_content',
                            'value' => 'excerpt',
                            'options' => array('excerpt' => 'The Excerpt', 'content' => 'Full Content'),
                            'type' => 'select',
                            'divider' => true
                        ),
                        // Single Image Position
                        array('name' => 'Image Position',
                            'desc' => 'Select your preferred image alignment',
                            'id' => TF_THEME_PREFIX . '_single_image_position',
                            'value' => 'alignleft',
                            'type' => 'images',
                            'options' => array('noalign' => array($url . 'full_width.png', 'Don\'t apply an alignment'),'alignleft' => array($url . 'left_off.png', 'Align to the left'), 'alignright' => array($url . 'right_off.png', 'Align to the right'))
                        ),
                        // Single Image Dimensions
                        array('name' => 'Image Resize (px)',
                            'desc' => 'These are the default width and height values. If you want to resize the image change the values with your own. If you input only one, the image will get resized with constrained proportions based on the one you specified.',
                            'id' => TF_THEME_PREFIX . '_single_image_dimensions',
                            'value' => array(620, 340),
                            'type' => 'textarray',
                            'divider' => true
                        ),
                        // Thumbnail Posts Position
                        array('name' => 'Thumbnail Position',
                            'desc' => 'Select your preferred thumbnail alignment',
                            'id' => TF_THEME_PREFIX . '_thumbnail_position',
                            'value' => 'alignleft',
                            'type' => 'images',
                            'options' => array('alignleft' => array($url . 'left_off.png', 'Align to the left'), 'alignright' => array($url . 'right_off.png', 'Align to the right'))
                        ),
                        // Posts Thumbnail Dimensions
                        array('name' => 'Thumbnail Resize (px)',
                            'desc' => 'These are the default width and height values. If you want to resize the thumbnail change the values with your own. If you input only one, the thumbnail will get resized with constrained proportions based on the one you specified.',
                            'id' => TF_THEME_PREFIX . '_thumbnail_dimensions',
                            'value' => array(219, 156),
                            'type' => 'textarray',
                            'divider' => true
                        ),
                        // Video Position
                        array('name' => 'Video Position',
                            'desc' => 'Select your preferred video alignment',
                            'id' => TF_THEME_PREFIX . '_video_position',
                            'value' => 'alignleft',
                            'type' => 'images',
                            'options' => array('alignleft' => array($url . 'left_off.png', 'Align to the left'), 'alignright' => array($url . 'right_off.png', 'Align to the right'))
                        ),
                        // Video Dimensions
                        array('name' => 'Video Resize (px)',
                            'desc' => 'These are the default width and height values. If you want to resize the video change the values with your own. If you input only one, the video will get resized with constrained proportions based on the one you specified.',
                            'id' => TF_THEME_PREFIX . '_video_dimensions',
                            'value' => array(620, 340),
                            'type' => 'textarray'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Style',
            'id' => TF_THEME_PREFIX . '_style',
            'headings' => array(
                array(
                    'name' => 'Color Scheme',
                    'options' => array(
                        // Enable Footer Shortcodes
                        array('name' => 'Color Scheme',
                            'desc' => 'Choose your preferred color style',
                            'id' => TF_THEME_PREFIX . '_color_scheme',
                            'value' => 'yellowblack',
                            'options' => array('greenpink' => array(get_template_directory_uri() . '/images/icons/green_pink.png','GreenPink'), 'orangeblue' => array(get_template_directory_uri() . '/images/icons/orange_blue.png', 'OrangeBlue'), 'turquoisered' => array(get_template_directory_uri() . '/images/icons/turquiose_red.png', 'TurquoiseRed'), 'yellowblack' => array(get_template_directory_uri() . '/images/icons/yellow_black.png', 'YellowBlack')),
                            'type' => 'images'
                        )
                    )
                ),
                array(
                    'name' => 'Header',
                    'options' => array(
                            array('name' => 'Default Header Images',
                            'desc' => 'Choose an image pattern for your header',
                            'id' => TF_THEME_PREFIX . '_default_header_image',
                            'value' => 'header_default.jpg',
                            'options' => array('header_default.jpg' => array( get_template_directory_uri() . '/images/icons/gray_with_blueprint_pattern.png', 'Gray with Blueprint Pattern'), 'header_default_2.jpg' => array( get_template_directory_uri() . '/images/icons/gray.png', 'Gray'), 'header_grass_sky.jpg' => array( get_template_directory_uri() . '/images/icons/grass_and_sky.png', 'Grass & Sky'), 'header_wood.jpg' => array( get_template_directory_uri() . '/images/icons/wood.png', 'Wood'), 'header_pattern_1.png' => array( get_template_directory_uri() . '/images/icons/paper_texture.png', 'Paper Texture'), 'header_pattern_8.png' => array( get_template_directory_uri() . '/images/icons/honeycomb_texture.png', 'Honeycomb Texture')),
                            'type' => 'images',
                            'divider' => true
                        ),
                        array('name' => 'Custom Header Image',
                            'desc' => 'Upload an image pattern for your header. Note that this option will overwrite the Default Image Header above',
                            'id' => TF_THEME_PREFIX . '_custom_header_image',
                            'value' => '',
                            'type' => 'upload',
                            'divider' => true
                        ),
                        array('name' => 'Background Color',
                            'desc' => 'Choose a solid background color for your header',
                            'id' => TF_THEME_PREFIX . '_header_color',
                            'value' => '',
                            'type' => 'colorpicker'
                        ),
                    )
                ),
            )
        ),
        array(
            'name' => 'Footer',
            'id' => TF_THEME_PREFIX . '_footer',
            'headings' => array(
                array(
                    'name' => 'Footer Content',
                    'options' => array(
                        // Enable Footer Shortcodes
                        array('name' => 'Enable Footer Shortcodes',
                            'desc' => 'This will enable footer shortcodes.',
                            'id' => TF_THEME_PREFIX . '_enable_footer_shortcodes',
                            'value' => '',
                            'type' => 'checkbox'
                        ),
                        // Footer Shortcodes
                        array('name' => 'Footer Shortcodes',
                            'desc' => 'In this textarea you can input your prefered custom shotcodes. Go to our <a href="' . admin_url( 'admin.php?page=tf_sh_generator' ) . '" target="_blanck">Shortcodes generator page</a> where you can find all the shortcodes that can be used',
                            'id' => TF_THEME_PREFIX . '_footer_shortcodes',
                            'value' => '',
                            'type' => 'textarea'
                        )
                    )
                )
            )
        )
    )
);

?>