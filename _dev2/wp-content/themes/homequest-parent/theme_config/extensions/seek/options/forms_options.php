<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');


/**
 * Define forms
 */

/*- Help -*/
array(
    // Optins structure
    '<id>'   => array(
        'items'         => array( '<item-id>', '<item-id>', '...' ),
        'template'      => '<template-name>', // Located in views/forms/ (without '.php')
        'template_vars' => array('foo'=>'bar'), // Some $vars accesibile from template (ex: $vars['foo'])
        'attributes'    => array(
            'class'     => 'foo',
            'onsubmit'  => 'bar',
        ), // <form class="foo" onsubmit="bar" >
    ),
);
/*---*/
global $search;
$options = array(

    'main_search'   => array(
        'items'         => array(
            'location_select',
            'price_header',
            'bedrooms_select',
            'baths_select',
            'sale_type',
            'square_header',
            'favorites',
            'category_uni'
        ),
        'template'      => 'header-form',
        'template_vars' => array(
            'expanded_search' => ($search['type'] == 'closed')
        ),
        'attributes'    => array(
            'class'     => 'form_search'
        ),
    ),

    'filter_search' => array(
        'items'         => array(
            'filter_location_select',
            'price_filter',
            'bedrooms_checkboxes',
            'baths_checkboxes',
            'sale_type_filter',
            'squares_checkboxes',
            'favorites',
            'category_uni',
            'tax_ids_category'
        ),
        'template'      => 'filter-form',
        'template_vars' => array(),
        'attributes'    => array(
            'class'     => 'form_white'
        ),
    ),

    'slider_search' => array(
        'items'         => array(
            'location_slider',
            'sale_type_slider',
            'bedrooms_select_slider',
            'baths_select_slider',
            'price_range_slider'
        ),
        'template'      => 'slider-form',
        'template_vars' => array(),
        'attributes'    => array(
            'class'     => 'form_search'
        ),
    ),
);