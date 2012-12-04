<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');


/**
 * Define form items
 */

array(
/**
 * Option Structure:
 */
'<id>' => array( // id used as form item name in html and for TF_SEEK_HELPER::print_form_item('<id>'), please use only safe characters [a-z0-9_]
    'parameter_name'        => '<some-name>',
        // $_GET parameter name. Accessible from template and sql_generator as $parameter_name
        // make sure if the value of this parameter is unique within one form items
        // if you want to change that, make sure and search in all files if this value is not used hardcoded somewhere else
    'template'              => '<template-file-name>',
        // without .php, located in ../views/items/
        // if empty ('') , print function filters and actions within it will be executed but no template will be included
    'template_vars'         => array('foo'=>'bar'),
        // accessible from template as $vars['foo']
    'settings'              => array('foo'=>'bar'),
        // item settings accessible from template as $settings['foo'] and from <sql_generator> as third parameter
    'sql_generator'         => '<function-name>',
        // public static function from object located in ../includes/sql_generators.php
    'sql_generator_options' => array(
        // second parameter for sql_generator function
        'search_on'         => '<options>/<taxonomy>',
            // search in options or taxonomy
        'search_on_id'      => 'seek_property_price',
            // if 'search_on'='option': need to match id from ./<post_type>_options.php where 'searchable'=> TRUE,
            // if 'search_on'='taxonomy': need to match taxonomy name registered in ../register_custom_taxonomies.php
         '...something...'  => '...else...',
        ),
    )
);

$options = array(

    'location'  => array(
        'parameter_name'        => 'location',
        'template'              => 'location-header',
        'template_vars'         => array(
            'label'             => __('City / Town', 'tfuse'),
        ),
        'settings'              => array(),
        'sql_generator'         => 'taxonomy_multivalue',
        'sql_generator_options' => array(
            'search_on'         => 'taxonomy',
            'search_on_id'      => TF_SEEK_HELPER::get_post_type().'_locations',
        ),
    ),

    'location_select'  => array(
        'parameter_name'        => 'location_id',
        'template'              => 'taxonomy-select-parent',
        'template_vars'         => array(
            'label'             => __('Location', 'tfuse'),
            'default_option'    => __('All locations', 'tfuse'),
            'select_class'      => 'tf-seek-long-select-form-item-header',
        ),
        'settings'              => array(
            'select_parent'     => 0 // term_id
        ),
        'sql_generator'         => 'taxonomy_parent',
        'sql_generator_options' => array(
            'search_on'         => 'taxonomy',
            'search_on_id'      => TF_SEEK_HELPER::get_post_type().'_locations',
        ),
    ),

    'location_filter'  => array(
        'parameter_name'        => 'location',
        'template'              => 'location-filter',
        'template_vars'         => array(
            'label'             => __('Location', 'tfuse'),
            'placeholder'       => __( 'Add NEW Location', 'tfuse'),
        ),
        'settings'              => array(),
        'sql_generator'         => 'taxonomy_multivalue',
        'sql_generator_options' => array(
            'search_on'         => 'taxonomy',
            'search_on_id'      => TF_SEEK_HELPER::get_post_type().'_locations',
        ),
    ),

    'location_slider'  => array(
        'parameter_name'        => 'location_id',
        'template'              => 'taxonomy-select-parent',
        'template_vars'         => array(
            'label'             => __('Location', 'tfuse'),
            'default_option'    => __('All locations', 'tfuse'),
            'select_class'      => 'tf-seek-select-form-item-slider',
        ),
        'settings'              => array(
            'select_parent'     => 0 // term_id
        ),
        'sql_generator'         => 'taxonomy_parent',
        'sql_generator_options' => array(
            'search_on'         => 'taxonomy',
            'search_on_id'      => TF_SEEK_HELPER::get_post_type().'_locations',
        ),
    ),

    'filter_location_select'  => array(
        'parameter_name'        => 'location_ids',
        'template'              => 'filter-checkbox-taxonomy-select-parent',
        'template_vars'         => array(
            'listen_form_id'        => 'main_search',
            'show_counts'           => true,
            'counts_label_singular' => '',
            'counts_label_plural'   => '',
        ),
        'settings'              => array(
            'parent_item_id'    => 'location_select'
        ),
        'sql_generator'         => 'taxonomy_parent',
        'sql_generator_options' => array(
            'search_on'         => 'taxonomy',
            'search_on_id'      => TF_SEEK_HELPER::get_post_type().'_locations',
        ),
    ),

    'price_header'     => array(
        'parameter_name'        => 'price',
        'template'              => 'range-slider',
        'template_vars'         => array(
            'label'             => __('Price Range', 'tfuse'),
            'row'               => true,
            'listen_checkbox_id'=> 'sale_type'
        ),
        'settings'              => array(
            'from'              => 0,
            'to'                => 3000000,
            'scale'             => array(0, '|', '250'.__('k', 'tfuse'), '|', '500'.__('k', 'tfuse'), '|', '750'.__('k', 'tfuse'), '|', '1,25'.__('Mil', 'tfuse'), '|', '2'.__('Mil', 'tfuse'), '|', '>3'.__('Mil', 'tfuse')),
            'limits'            => FALSE,
            'step'              => 1000,
            'smooth'            => TRUE,
            'dimension'         => '&nbsp;'.(TF_SEEK_HELPER::get_option('seek_property_currency_symbol')),
            'skin'              => "round_gold",

            'auto_options'      => true,
            'auto_steps'        => 7
        ),
        'sql_generator'         => 'range_slider',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_price',
        ),
    ),

    'bedrooms_select'  => array(
        'parameter_name'        => 'bedrooms',
        'template'              => 'select',
        'template_vars'         => array(
            'label'             => __('No of rooms', 'tfuse'),
            'min_prefix'        => '',
            'max_prefix'        => '+ ',
            'title'             => __('Beds', 'tfuse')
        ),
        'settings'              => array(
            'min'               => 0,
            'max'               => 5,
        ),
        'sql_generator'         => 'option_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_bedrooms',
            'relation'          => '>=', // option >= input_value
        ),
    ),

    'baths_select'  => array(
        'parameter_name'        => 'baths',
        'template'              => 'select',
        'template_vars'         => array(
            'label'             => __('No of Baths', 'tfuse'),
            'min_prefix'        => '',
            'max_prefix'        => '+ ',
            'title'             => __('Baths', 'tfuse')
        ),
        'settings'              => array(
            'min'               => 0,
            'max'               => 5,
        ),
        'sql_generator'         => 'option_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_baths',
            'relation'          => '>=', // option >= input_value
        ),
    ),

    'sale_type'  => array(
        'parameter_name'        => 'stype',
        'template'              => 'switch-sale-type',
        'template_vars'         => array(
        ),
        'settings'              => array(
            'min'               => 1,
            'max'               => 2,
            'transaction_type'  => (TF_SEEK_HELPER::get_option('seek_form_transaction_type','sale') == 'sale') ? 0 : 4
        ),
        'sql_generator'         => 'option_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_sale_type',
            'relation'          => '=',
        ),
    ),

    'square_header'     => array(
        'parameter_name'        => 'square',
        'template'              => 'range-slider',
        'template_vars'         => array(
            'label'             => TF_SEEK_HELPER::get_option('seek_property_area_type') == 'feets' ? __('Square feet', 'tfuse') : __('Sq. meters','tfuse'),
            'exclude_sopt_div'  => true
        ),
        'settings'              => array(
            'from'              => 0,
            'to'                => 10000,
            'scale'             => array('0','1000','2000','3000','5000','7500','>10000'),
            'heterogeneity'     => array('50/3000'),
            'limits'            => FALSE,
            'step'              => 100,
            'smooth'            => TRUE,
            'skin'              => "round_gold",

            'auto_options'      => true,
            'auto_steps'        => 7
        ),
        'sql_generator'         => 'range_slider',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_square',
        ),
    ),

    'price_filter'     => array(
        'parameter_name'        => 'price',
        'template'              => 'price-filter',
        'template_vars'         => array(
            'label'             => sprintf( __('Price(%s)', 'tfuse'), (TF_SEEK_HELPER::get_option('seek_property_currency_symbol')) ),
        ),
        'settings'              => array(
            'from'              => 0,
            'to'                => 3000000,

            'auto_options'      => true,
        ),
        'sql_generator'         => 'range_slider',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_price',
        ),
    ),

    'bedrooms_checkboxes'  => array(
        'parameter_name'        => 'beds_counts',
        'template'              => 'checkboxes-counts',
        'template_vars'         => array(
            'label'             => __('Bedrooms', 'tfuse'),

            'listen_form_id'    => 'main_search',
            'show_counts'       => true,
            'counts_label_singular' => ' '.__('offer', 'tfuse'),
            'counts_label_plural'   => ' '.__('offers', 'tfuse'),
        ),
        'settings'              => array(
            'min'               => 1,
            'max'               => 4,
        ),
        'sql_generator'         => 'options_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_bedrooms',
            'relation'          => '=',
            'relation_max'      => '>=',
        ),
    ),

    'baths_checkboxes'  => array(
        'parameter_name'        => 'baths_counts',
        'template'              => 'checkboxes-counts',
        'template_vars'         => array(
            'label'             => __('Baths', 'tfuse'),

            'listen_form_id'    => 'main_search',
            'show_counts'       => true,
            'counts_label_singular' => ' '.__('offer', 'tfuse'),
            'counts_label_plural'   => ' '.__('offers', 'tfuse'),
        ),
        'settings'              => array(
            'min'               => 1,
            'max'               => 4,
        ),
        'sql_generator'         => 'options_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_baths',
            'relation'          => '=',
            'relation_max'      => '>=',
        ),
    ),

    'squares_checkboxes'  => array(
        'parameter_name'        => 'squares',
        'template'              => 'checkboxes-intervals-counts',
        'template_vars'         => array(
            'label'             => (TF_SEEK_HELPER::get_option('seek_property_area_type') == 'feets') ? __('Square Ft', 'tfuse') : __('Square M', 'tfuse'),

            'listen_form_id'    => 'main_search',
            'show_counts'       => true,
            'counts_label_singular' => ' '.__('offer', 'tfuse'),
            'counts_label_plural'   => ' '.__('offers', 'tfuse'),
        ),
        'settings'              => array(
            'max_steps'         => 4,
            'start'             => 1000,
            'step'              => 500,
            'max_unlimited'     => true,
        ),
        'sql_generator'         => 'intervals_options_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_square',
        ),
    ),

    'sale_type_slider'  => array(
        'parameter_name'        => 'stype',
        'template'              => 'switch-sale-type',
        'template_vars'         => array(
            'label'             => __('Transaction','tfuse')
        ),
        'settings'              => array(
            'min'               => 1,
            'max'               => 2,
            'transaction_type'  => (TF_SEEK_HELPER::get_option('seek_form_transaction_type','sale') == 'sale') ? 0 : 4
        ),
        'sql_generator'         => 'option_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_sale_type',
            'relation'          => '=',
        ),
    ),

    'bedrooms_select_slider'  => array(
        'parameter_name'        => 'bedrooms',
        'template'              => 'select',
        'template_vars'         => array(
            'label'             => __('No. of rooms', 'tfuse'),
            'option_name'       => 'Beds',
            'hide_option_name'  => true,
            'max_prefix'        => '+',
            'title'             => __('Beds', 'tfuse'),
            'id'                => 'search_no_beds'
        ),
        'settings'              => array(
            'min'               => 0,
            'max'               => 5,
        ),
        'sql_generator'         => 'option_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_bedrooms',
            'relation'          => '>=', // option >= input_value
            'skip_zero'         => true,
        ),
    ),

    'baths_select_slider'  => array(
        'parameter_name'        => 'baths',
        'template'              => 'select',
        'template_vars'         => array(
            'option_name'       => 'Baths',
            'hide_option_name'  => true,
            'max_prefix'        => '+',
            'title'             => __('Baths', 'tfuse')
        ),
        'settings'              => array(
            'min'               => 0,
            'max'               => 5,
        ),
        'sql_generator'         => 'option_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_baths',
            'relation'          => '>=', // option >= input_value
        ),
    ),

    'price_range_slider'     => array(
        'parameter_name'        => 'price',
        'template'              => 'range-slider',
        'template_vars'         => array(
            'row'               => true,
            'listen_checkbox_id'=> 'sale_type'
        ),
        'settings'              => array(
            'from'              => 0,
            'to'                => 3000000,
            'scale'             => array(0, '|', '250'.__('k', 'tfuse'), '|', '500'.__('k', 'tfuse'), '|', '750'.__('k', 'tfuse'), '|', '1,25'.__('Mil', 'tfuse'), '|', '2'.__('Mil', 'tfuse'), '|', '>3'.__('Mil', 'tfuse')),
            'limits'            => FALSE,
            'step'              => 1000,
            'smooth'            => TRUE,
            'dimension'         => '&nbsp;'.(TF_SEEK_HELPER::get_option('seek_property_currency_symbol')),
            'skin'              => "round_gold",

            'auto_options'      => true,
            'auto_steps'        => 5
        ),
        'sql_generator'         => 'range_slider',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_price',
        ),
    ),

    'favorites'     => array(
        'parameter_name'        => 'favorites',
        'template'              => 'hidden-input',
        'template_vars'         => array(
            'no_output'         => !isset($_GET['favorites'])
        ),
        'settings'              => array(),
        'sql_generator'         => 'favorites',
        'sql_generator_options' => array(
            'search_on'         => '',
            'search_on_id'      => '',
        ),
    ),

    'category_uni'  => array(
        'parameter_name'        => 'tfescategory',
        'template'              => '',
        'template_vars'         => array(),
        'settings'              => array(),
        'sql_generator'         => 'taxonomy_univalue',
        'sql_generator_options' => array(
            'search_on'         => 'taxonomy',
            'search_on_id'      => TF_SEEK_HELPER::get_post_type().'_category',
        ),
    ),

    'tax_ids_category'  => array(
        'parameter_name'        => 'category_ids',
        'template'              => 'taxonomy-checkboxes',
        'template_vars'         => array(
            'label'             => __('Category', 'tfuse'),
            'get_terms_args'    => '&orderby=count&order=desc',

            'listen_form_id'        => 'main_search',
            'show_counts'           => true,
            'counts_label_singular' => '',
            'counts_label_plural'   => '',
        ),
        'settings'              => array(),
        'sql_generator'         => 'taxonomy_multi_ids',
        'sql_generator_options' => array(
            'search_on'         => 'taxonomy',
            'search_on_id'      => TF_SEEK_HELPER::get_post_type().'_category',
        ),
    ),

    'sale_type_filter'  => array(
        'parameter_name'        => 'stype',
        'template'              => '',
        'template_vars'         => array(
        ),
        'settings'              => array(
            'min'               => 1,
            'max'               => 2,
            'persistent_parameter_name' => true
        ),
        'sql_generator'         => 'option_int',
        'sql_generator_options' => array(
            'search_on'         => 'options',
            'search_on_id'      => 'seek_property_sale_type',
            'relation'          => '=',
        ),
    ),
);