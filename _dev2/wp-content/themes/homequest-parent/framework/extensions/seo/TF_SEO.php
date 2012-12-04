<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

class TF_SEO extends TF_TFUSE {

    public $_standalone = TRUE;
    public $_the_class_name = 'SEO';

    function __construct() {
        parent::__construct();
    }

    function __init() {
        $this->load->ext_helper($this->_the_class_name, 'SEO');

        add_filter('tfuse_options_filter', array(&$this, 'filter_options'), 10, 2);
    }

    public function filter_options($options, $type){
        
        static $once = array(); // prevent multiple run
        
        if ( isset( $once[$type] ) ) {
            return $options; 
        } else {
            $once[$type] = true;
        }
        
        if ( tfuse_options('disable_tfuse_seo_tab') ){
            return $options;
        }

        switch( $type ){
            case 'admin':
                return $this->append_admin_seo_options($options);
            break;
            default:
                if( in_array($type, get_post_types()) ){
                    return $this->append_seo_options($options);
                } else {
                    return $options;
                }
        }
    }

    private function append_admin_seo_options($options){
        /* SEO Tab */

        $cache = array(
            'get_post_types'    => get_post_types(),
            'get_taxonomies'    => get_taxonomies(),
        );

        // Build meta options for Post Types
        $options_post_types = array(
            'name'      => 'Post Types META',
            'options'   => array()
            );
        $t_get_post_types         = $cache['get_post_types'];
        foreach ($t_get_post_types as $posttype) {

            if ( in_array($posttype, array('revision', 'nav_menu_item', 'attachment') ) )
                continue;
            if (isset($options['redirectattachment']) && $options['redirectattachment'] && $posttype == 'attachment')
                continue;

            $Posttype = ucwords($posttype);

            $options_post_types['options'][] = array(
                'name'      => sprintf( __('Title for %s', 'tfuse' ), $Posttype),
                'desc'      => sprintf( __('Enter custom title for %s. These settings may be overridden for individual %s.', 'tfuse' ), $Posttype, $posttype),
                'id'        => TF_THEME_PREFIX . '_seo_post_type_' . $posttype . '_title',
                'value'     => '%%title%% | %%sitedesc%%',
                'type'      => 'text'
            );

            $options_post_types['options'][] = array(
                'name'      => sprintf( __('Description for %s', 'tfuse' ), $Posttype ),
                'desc'      => sprintf( __('Enter custom description for %s. These settings may be overridden for individual %s.', 'tfuse' ), $Posttype, $posttype ),
                'id'        => TF_THEME_PREFIX . '_seo_post_type_' . $posttype . '_description',
                'value'     => '',
                'type'      => 'textarea',
                'divider'   => ( tfuse_options( 'seo_use_meta_keywords', false ) ? false : true)
            );

            if ( tfuse_options( 'seo_use_meta_keywords', false ) ) {
                $options_post_types['options'][] = array(
                    'name'      => sprintf( __('Keywords for %s', 'tfuse' ), $Posttype ),
                    'desc'      => sprintf( __('Enter custom meta keywords for %s. These settings may be overridden for individual %s.', 'tfuse' ), $Posttype, $posttype ),
                    'id'        => TF_THEME_PREFIX . '_seo_post_type_' . $posttype . '_keywords',
                    'value'     => '',
                    'type'      => 'textarea',
                    'divider'   => true
                );
            }
        }
        if(isset($options_post_types['options'])){
            $last_element = &array_pop($options_post_types['options']);
            $last_element['divider'] = false;
            $options_post_types['options'][] = $last_element;
        }

        // Buld meta options for taxonomies
        $options_taxonomy = array(
            'name'      => 'Taxonomies META',
            'options'   => array()
            );
        $t_get_taxonomies         = $cache['get_taxonomies'];
        foreach ($t_get_taxonomies as $taxonomy) {

            if ( in_array( $taxonomy, array('nav_menu','link_category','post_format') ) )
                continue;

            $tax = get_taxonomy($taxonomy);
            if ( ! ( isset( $tax->labels->name ) && trim($tax->labels->name) != '' ) )
                continue;

            $options_taxonomy['options'][] = array(
                'name'      => sprintf( __('Title for %s', 'tfuse' ), $tax->labels->name),
                'desc'      => sprintf( __('Enter custom title for %s. These settings may be overridden for individual %s.', 'tfuse' ), $tax->labels->name, $tax->labels->name ),
                'id'        => TF_THEME_PREFIX . '_seo_taxonomy_' . $taxonomy . '_title',
                'value'     => '%%tag%% | %%sitedesc%%',
                'type'      => 'text'
            );

            $options_taxonomy['options'][] = array(
                'name'      => sprintf( __('Description for %s', 'tfuse' ), $tax->labels->name ),
                'desc'      => sprintf( __('Enter custom description for %s. These settings may be overridden for individual %s.', 'tfuse' ), $tax->labels->name, $tax->labels->name ),
                'id'        => TF_THEME_PREFIX . '_seo_taxonomy_' . $taxonomy . '_description',
                'value'     => '',
                'type'      => 'textarea'
            );

            if ( tfuse_options( 'seo_use_meta_keywords', false ) ) {
                $options_taxonomy['options'][] = array(
                    'name'      => sprintf( __('Keywords for %s', 'tfuse' ), $tax->labels->name ),
                    'desc'      => sprintf( __('Enter custom meta keywords for %s. These settings may be overridden for individual %s.', 'tfuse' ), $tax->labels->name, $tax->labels->name ),
                    'id'        => TF_THEME_PREFIX . '_seo_taxonomy_' . $taxonomy . '_keywords',
                    'value'     => '',
                    'type'      => 'textarea'
                );
            }

            $options_taxonomy['options'][] = array(
                'name'      => sprintf( __('Use noindex for %s', 'tfuse' ), $tax->labels->name ),
                'desc'      => sprintf( __('Enable or disable using of noindex for %s', 'tfuse' ), $tax->labels->name ),
                'id'        => TF_THEME_PREFIX . '_seo_taxonomy_' . $taxonomy . '_noindex',
                'value'     => '',
                'type'      => 'checkbox',
                'divider'   => true
            );
        }
        if(isset($options_taxonomy['options'])){
            $last_element = &array_pop($options_taxonomy['options']);
            $last_element['divider'] = false;
            $options_taxonomy['options'][] = $last_element;
        }

        // XMLS Options
        $options_xmls = array(
            'name'      => __('XML Sitemaps', 'tfuse' ),
            'options'   => array(
                array(
                    'name'      => __('Enable XML Sitemaps', 'tfuse'),
                    'desc'      => __('Enable or disable XML Sitemaps. Sitemap will be generated when a new content will be added.', 'tfuse'),
                    'id'        => TF_THEME_PREFIX . '_seo_xmls_enabled',
                    'value'     => 'false',
                    'type'      => 'checkbox',
                    'divider'   => true
                )
            )
        );
        // Buld checkboxes for xml-sitemaps exclude post types
        $options_xmls['options'][] = array(
            'name'      => '',
            'desc'      => '',
            'id'        => TF_THEME_PREFIX . '_seo_excludeposttype_description',
            'value'     => '',
            'type'      => 'raw',
            'html'      => '<div class="desc" style="margin:0;">'.__( 'Please check the appropriate box below if there\'s a post type that you do <b>NOT</b> want to include in your sitemap', 'tfuse' ).'</div>',
        );
        $t_get_post_types         = $cache['get_post_types'];
        $t_get_post_types_size    = sizeof($t_get_post_types); 
        $t_counter                = 0;
        foreach ($t_get_post_types as $post_type) {
            $t_counter++;

            if ( !in_array( $post_type, array('revision','nav_menu_item','attachment') ) ) {
                $pt = get_post_type_object($post_type);

                $options_xmls['options'][] = array(
                    'name'      => sprintf( __('Exclude %s', 'tfuse' ), $pt->labels->name ),
                    'id'        => TF_THEME_PREFIX . '_seo_xmls_exclude_posttype_' . $post_type,
                    'value'     => '',
                    'type'      => 'checkbox',
                    'divider'   => ( ( $t_counter >= $t_get_post_types_size ) ? true : false )
                );
            }
        }
        // Build exclude taxonomies
        $options_xmls['options'][] = array(
            'name'      => '',
            'desc'      => '',
            'id'        => TF_THEME_PREFIX . '_seo_excludetaxonomy_description',
            'value'     => '',
            'type'      => 'raw',
            'html'      => '<div class="desc" style="margin:0;">'.__( 'Please check the appropriate box below if there\'s a taxonomy that you do <b>NOT</b> want to include in your sitemap', 'tfuse' ).'</div>',
        );
        $t_get_taxonomies         = $cache['get_taxonomies'];
        $t_get_taxonomies_size    = sizeof($t_get_taxonomies); 
        $t_counter                = 0;
        foreach ($t_get_taxonomies as $taxonomy) {
            if ( !in_array( $taxonomy, array('nav_menu','link_category','post_format') ) ) {
                $tax = get_taxonomy($taxonomy);
                if ( isset( $tax->labels->name ) && trim($tax->labels->name) != '' )
                {

                    $options_xmls['options'][] = array(
                        'name'      => sprintf( __('Exclude %s', 'tfuse' ), $tax->labels->name ),
                        'id'        => TF_THEME_PREFIX . '_seo_xmls_exclude_taxonomy_' . $taxonomy,
                        'value'     => '',
                        'type'      => 'checkbox',
                        'divider'   => ( ( $t_counter >= $t_get_taxonomies_size ) ? true : false )
                    );
                }
            }
        }

        $admin_options = array(
            'name'      => 'SEO',
            'id'        => TF_THEME_PREFIX . '_seo',
            'headings'  => array(
                array(
                    'name'      => 'General Settings',
                    'options'   => array(
                        array(
                            'name'      => __('Use META keywords', 'tfuse' ),
                            'desc'      => __('Use META keywords.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_use_meta_keywords',
                            'value'     => '',
                            'type'      => 'checkbox',
                            'divider'   => true
                        ),
                        array(
                            'name'      => __('Use Canonical URLs', 'tfuse' ),
                            'desc'      => __('Use Canonical URLs.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_use_canonical_url',
                            'value'     => '',
                            'type'      => 'checkbox',
                            'divider'   => true
                        ),
                        array(
                            'name'      => __('Title separator', 'tfuse' ),
                            'desc'      => __('Title separator. Will be used by default to generate titles if some titles are not set', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_title_separator',
                            'value'     => ' | ',
                            'type'      => 'text'
                        )
                    )
                ),
                array(
                    'name'      => __('General META', 'tfuse' ),
                    'options'   => array(
                        array(
                            'name'      => __( 'General Description', 'tfuse' ),
                            'desc'      => __( 'Enter general description for all the pages (categories, arhives,  posts, etc)', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_general_description',
                            'value'     => '',
                            'type'      => 'textarea',
                            ( tfuse_options( 'seo_use_meta_keywords', false ) ? 'null' : 'divider' ) => true
                        ),
                        ( tfuse_options( 'seo_use_meta_keywords', false )
                            ? array(
                                'name'      => __( 'General Keywords', 'tfuse' ),
                                'desc'      => __( 'Enter general keywords for all the pages (categories, arhives,  posts, etc)', 'tfuse' ),
                                'id'        => TF_THEME_PREFIX . '_seo_general_keywords',
                                'value'     => '',
                                'type'      => 'textarea',
                                'divider'   => true
                            )
                            : array()
                        ),
                        // Homepage
                        array(
                            'name'      => __( 'Title for Homepage', 'tfuse' ),
                            'desc'      => __( 'Enter custom title for Homepage.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_homepage_title',
                            'value'     => '%%sitename%% | %%sitedesc%%',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __( 'Description for Homepage', 'tfuse' ),
                            'desc'      => __( 'Enter custom description for Homepage.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_homepage_description',
                            'value'     => '',
                            'type'      => 'textarea',
                            ( tfuse_options( 'seo_use_meta_keywords', false ) ? 'null' : 'divider' ) => true
                        ),
                        ( tfuse_options( 'seo_use_meta_keywords', false )
                            ? array(
                                'name'      => __( 'Keywords for Homepage', 'tfuse' ),
                                'desc'      => __( 'Enter custom keywords for Homepage.', 'tfuse' ),
                                'id'        => TF_THEME_PREFIX . '_seo_homepage_keywords',
                                'value'     => '',
                                'type'      => 'textarea',
                                'divider'   => true
                            )
                            : array()
                        ),
                        // Archive
                        array(
                            'name'      => __( 'Title for Archives', 'tfuse' ),
                            'desc'      => __( 'Enter custom title for Archives. This title may be overridden by other specific archives (tags, categories, etc)', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_archive_title',
                            'value'     => '',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __( 'Description for Archives', 'tfuse' ),
                            'desc'      => __( 'Enter custom description for Archives. This description may be overridden by other specific archives (tags, categories, etc)', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_archive_description',
                            'value'     => '',
                            'type'      => 'textarea'
                        ),
                        ( tfuse_options( 'seo_use_meta_keywords', false )
                            ? array(
                                'name'      => __( 'Keywords for Archives', 'tfuse' ),
                                'desc'      => __( 'Enter custom keywords for Archives. This keywords may be overridden by other specific archives (tags, categories, etc)', 'tfuse' ),
                                'id'        => TF_THEME_PREFIX . '_seo_archive_keywords',
                                'value'     => '',
                                'type'      => 'textarea'
                            )
                            : array()
                        ),
                        array(
                            'name'      => __('Use noindex for Archive', 'tfuse' ),
                            'desc'      => __('Enable or disable using of noindex for Archives.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_archive_noindex',
                            'value'     => '',
                            'type'      => 'checkbox',
                            'divider'   => true
                        ),
                        // Author
                        array(
                            'name'      => __( 'Title for Author', 'tfuse' ),
                            'desc'      => __( 'Enter custom title for Author Archives.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_author_title',
                            'value'     => '%%name%% | Author Archive | %%sitedesc%%',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __( 'Description for Author', 'tfuse' ),
                            'desc'      => __( 'Enter custom description for Author Archives.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_author_description',
                            'value'     => '',
                            'type'      => 'textarea'
                        ),
                        ( tfuse_options( 'seo_use_meta_keywords', false )
                            ? array(
                                'name'      => __( 'Keywords for Author', 'tfuse' ),
                                'desc'      => __( 'Enter custom keywords for Author Archives.', 'tfuse' ),
                                'id'        => TF_THEME_PREFIX . '_seo_author_keywords',
                                'value'     => '',
                                'type'      => 'textarea'
                            )
                            : array()
                        ),
                        array(
                            'name'      => __('Use noindex for Author', 'tfuse' ),
                            'desc'      => __('Enable or disable using of noindex for Author Archives.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_author_noindex',
                            'value'     => '',
                            'type'      => 'checkbox',
                            'divider'   => true
                        ),
                        // Date
                        array(
                            'name'      => __( 'Title for Date', 'tfuse' ),
                            'desc'      => __( 'Enter custom title for Date Archives.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_date_title',
                            'value'     => '%%date%% | Date Archive | %%sitedesc%%',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __( 'Description for Date', 'tfuse' ),
                            'desc'      => __( 'Enter custom description for Date Archives.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_date_description',
                            'value'     => '',
                            'type'      => 'textarea'
                        ),
                        ( tfuse_options( 'seo_use_meta_keywords', false )
                            ? array(
                                'name'      => __( 'Keywords for Date', 'tfuse' ),
                                'desc'      => __( 'Enter custom keywords for Date Archives.', 'tfuse' ),
                                'id'        => TF_THEME_PREFIX . '_seo_date_keywords',
                                'value'     => '',
                                'type'      => 'textarea'
                            )
                            : array()
                        ),
                        array(
                            'name'      => __('Use noindex for Date', 'tfuse' ),
                            'desc'      => __('Enable or disable using of noindex for Date Archives.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_date_noindex',
                            'value'     => '',
                            'type'      => 'checkbox',
                            'divider'   => true
                        ),
                        // Attachment
                        array(
                            'name'      => __( 'Title for Attachment', 'tfuse' ),
                            'desc'      => __( 'Enter custom title for Attachment.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_attachment_title',
                            'value'     => '%%title%% | Attachment | %%sitedesc%%',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __( 'Description for Attachment', 'tfuse' ),
                            'desc'      => __( 'Enter custom description for Attachment.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_attachment_description',
                            'value'     => '',
                            'type'      => 'textarea',
                            ( tfuse_options( 'seo_use_meta_keywords', false ) ? 'null' : 'divider' ) => true
                        ),
                        ( tfuse_options( 'seo_use_meta_keywords', false )
                            ? array(
                                'name'      => __( 'Keywords for Attachment', 'tfuse' ),
                                'desc'      => __( 'Enter custom keywords for Attachment.', 'tfuse' ),
                                'id'        => TF_THEME_PREFIX . '_seo_attachment_keywords',
                                'value'     => '',
                                'type'      => 'textarea',
                                'divider'   => true
                            )
                            : array()
                        ),
                        // Search
                        array(
                            'name'      => __( 'Title for Search', 'tfuse' ),
                            'desc'      => __( 'Enter custom title for Search.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_search_title',
                            'value'     => 'Search results for: %%searchphrase%% | %%sitename%%',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __( 'Description for Search', 'tfuse' ),
                            'desc'      => __( 'Enter custom description for Search.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_search_description',
                            'value'     => '',
                            'type'      => 'textarea'
                        ),
                        ( tfuse_options( 'seo_use_meta_keywords', false )
                            ? array(
                                'name'      => __( 'Keywords for Search', 'tfuse' ),
                                'desc'      => __( 'Enter custom keywords for Search.', 'tfuse' ),
                                'id'        => TF_THEME_PREFIX . '_seo_search_keywords',
                                'value'     => '',
                                'type'      => 'textarea'
                            )
                            : array()
                        ),
                        array(
                            'name'      => __('Use noindex for Search', 'tfuse' ),
                            'desc'      => __('Enable or disable using of noindex for Search.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_search_noindex',
                            'value'     => '',
                            'type'      => 'checkbox',
                            'divider'   => true
                        ),
                        // 404
                        array(
                            'name'      => __( 'Title for 404', 'tfuse' ),
                            'desc'      => __( 'Enter custom title for 404.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_404_title',
                            'value'     => 'Page Not Found | %%sitename%% | %%sitedesc%%',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __( 'Description for 404', 'tfuse' ),
                            'desc'      => __( 'Enter custom description for 404.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_404_description',
                            'value'     => '',
                            'type'      => 'textarea',
                            ( tfuse_options( 'seo_use_meta_keywords', false ) ? 'null' : 'divider' ) => true
                        ),
                        ( tfuse_options( 'seo_use_meta_keywords', false )
                            ? array(
                                'name'      => __( 'Keywords for 404', 'tfuse' ),
                                'desc'      => __( 'Enter custom keywords for 404.', 'tfuse' ),
                                'id'        => TF_THEME_PREFIX . '_seo_404_keywords',
                                'value'     => '',
                                'type'      => 'textarea',
                                'divider'   => true
                            )
                            : array()
                        ),
                        // Paged
                        array(
                            'name'      => __( 'Title for Paged', 'tfuse' ),
                            'desc'      => __( 'Enter custom title suffix for Paged.', 'tfuse' ),
                            'id'        => TF_THEME_PREFIX . '_seo_paged_title',
                            'value'     => ' | %%page%% ',
                            'type'      => 'text'
                        )
                    )
                ),
                ( sizeof($options_post_types['options']) 
                    ? $options_post_types
                    : array()
                ),
                ( sizeof($options_taxonomy['options']) 
                    ? $options_taxonomy
                    : array()
                ),
                ( 
                    $options_xmls 
                ),
                array(
                    'name'      => __('Help', 'tfuse' ),
                    'options'   => array(
                        array(
                            'id'        => TF_THEME_PREFIX . '_seo_help_replacements',
                            'type'      => 'raw',
                            'name'      => '',
                            'html'      => '
                                <p>'.__( 'These tags can be included and will be replaced when a page is displayed.', 'tfuse' ).'</p>
                                    <table class="yoast_help">
                                        <tr>
                                            <th>%%date%%</th>
                                            <td>'.__( 'Replaced with the date of the post/page', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%title%%</th>
                                            <td>'.__('Replaced with the title of the post/page', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%sitename%%</th>
                                            <td>'.__('The site\'s name', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%sitedesc%%</th>
                                            <td>'.__('The site\'s tagline / description', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%excerpt%%</th>
                                            <td>'.__('Replaced with the post/page excerpt (or auto-generated if it does not exist)', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%excerpt_only%%</th>
                                            <td>'.__('Replaced with the post/page excerpt (without auto-generation)', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%tag%%</th>
                                            <td>'.__('Replaced with the current tag/tags', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%category%%</th>
                                            <td>'.__('Replaced with the post categories (comma separated)', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%category_description%%</th>
                                            <td>'.__('Replaced with the category description', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%tag_description%%</th>
                                            <td>'.__('Replaced with the tag description', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%term_description%%</th>
                                            <td>'.__('Replaced with the term description', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%term_title%%</th>
                                            <td>'.__('Replaced with the term name', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%modified%%</th>
                                            <td>'.__('Replaced with the post/page modified time', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%id%%</th>
                                            <td>'.__('Replaced with the post/page ID', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%name%%</th>
                                            <td>'.__('Replaced with the post/page author\'s \'nicename\'', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%userid%%</th>
                                            <td>'.__('Replaced with the post/page author\'s userid', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%searchphrase%%</th>
                                            <td>'.__('Replaced with the current search phrase', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%currenttime%%</th>
                                            <td>'.__('Replaced with the current time', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%currentdate%%</th>
                                            <td>'.__('Replaced with the current date', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%currentmonth%%</th>
                                            <td>'.__('Replaced with the current month', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%currentyear%%</th>
                                            <td>'.__('Replaced with the current year', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%page%%</th>
                                            <td>'.__('Replaced with the current page number (i.e. page 2 of 4)', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%pagetotal%%</th>
                                            <td>'.__('Replaced with the current page total', 'tfuse' ).'</td>
                                        </tr>
                                        <tr class="alt">
                                            <th>%%pagenumber%%</th>
                                            <td>'.__('Replaced with the current page number', 'tfuse' ).'</td>
                                        </tr>
                                        <tr>
                                            <th>%%caption%%</th>
                                            <td>'.__('Attachment caption', 'tfuse' ).'</td>
                                        </tr>
                                    </table>'
                        ),
                    )
                )
            )
        );

        // Clear empty options like array()
        foreach( $admin_options[ 'headings' ] as $key=>$val ){
            foreach( $admin_options[ 'headings' ][ $key ] as $key2=>$val2 ){

                if( is_array( $admin_options[ 'headings' ][ $key ][ $key2 ] ) ){
                    foreach( $admin_options[ 'headings' ][ $key ][ $key2 ] as $key3=>$val3 ){

                        if( empty( $admin_options[ 'headings' ][ $key ][ $key2 ][ $key3 ] ) ){
                            unset( $admin_options[ 'headings' ][ $key ][ $key2 ][ $key3 ] );
                        }
                    }
                }
            }
        }

        $options['tabs'][] = $admin_options;

        return $options;
    }

    private function append_seo_options($options){

        $seo_options = array(
            array(
                'name'      => __('SEO', 'tfuse'),
                'id'        => TF_THEME_PREFIX . '_seo',
                'type'      => 'metabox',
                'context'   => 'normal'
            ),
            array(
                'name'      => __('Page Title', 'tfuse'),
                'desc'      => __('Enter your prefered custom title or leave blank for deafault value.', 'tfuse'),
                'id'        => TF_THEME_PREFIX . '_seo_title',
                'value'     => '',
                'type'      => 'text'
            ),
            array(
                'name'      => __('Page Description', 'tfuse'),
                'desc'      => __('Enter your prefered custom description or leave blank for deafault value.', 'tfuse'),
                'id'        => TF_THEME_PREFIX . '_seo_description',
                'value'     => '',
                'type'      => 'textarea'
            ),
            ( tfuse_options( 'seo_use_meta_keywords', false )
                ? array(
                    'name'  => __('Page Keywords', 'tfuse'),
                    'desc'  => __('Enter your prefered custom keywords or leave blank for deafault value.', 'tfuse'),
                    'id'    => TF_THEME_PREFIX . '_seo_keywords',
                    'value' => '',
                    'type'  => 'textarea'
                )
                : array()
            )
        );

        // Clean empty options like array()
        foreach( $seo_options as $key=>$val ){
            if( empty($seo_options[$key]) ){
                unset( $seo_options[$key] );
            }
        }

        $options = array_merge($options, $seo_options);
        
        return $options;
    }
}

