<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

/* ----------------------------------------------------------------------------------- */
/* Initializes all the seek settings option fields. */
/* ----------------------------------------------------------------------------------- */

$options = array(
    'tabs' => array(
        array(
            'name'      => TF_SEEK_HELPER::get_option('seek_property_name_plural', 'Seek Posts'),
            'type'      => 'tab',
            'id'        => TF_THEME_PREFIX . '_seek_general',
            'headings'  => array(
                array(
                    'name'      => 'General Settings',
                    'options'   => array(
                        array(
                            'name'      => __('Property Name, singular', 'tfuse'),
                            'desc'      => __('The name of the property being sold. (i.e. property, house, automobile) in singular form.', 'tfuse'),
                            'id'        => 'seek_property_name_singular',
                            'value'     => 'Property',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __('Property Name, plural', 'tfuse'),
                            'desc'      => __('The name of the property being sold. (i.e. properties, houses, automobiles) in plural form.', 'tfuse'),
                            'id'        => 'seek_property_name_plural',
                            'value'     => 'Properties',
                            'type'      => 'text',
                            'divider'   => true
                        ),
                        array(
                            'name'      => __('Money Currency, singular', 'tfuse'),
                            'desc'      => __('The name of the currency being used. (i.e. Dollar, Euro, Pound) in singular form.', 'tfuse'),
                            'id'        => 'seek_property_currency_singular',
                            'value'     => 'Dollar',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __('Money Currency, plural', 'tfuse'),
                            'desc'      => __('The name of the currency being used. (i.e. Dollars, Euros, Pounds) in plural form.', 'tfuse'),
                            'id'        => 'seek_property_currency_plural',
                            'value'     => 'Dollars',
                            'type'      => 'text'
                        ),
                        array(
                            'name'      => __('Money Currency, symbol','tfuse'),
                            'desc'      => __('The symbol of the currency being used. (i.e. $, €, £) in singular form.', 'tfuse'),
                            'id'        => 'seek_property_currency_symbol',
                            'value'     => '$',
                            'type'      => 'text',
                            'divider'   => true
                        ),
                        array(
                            'name'      => __('Area','tfuse'),
                            'desc'      => __('Select unit of measure for area.', 'tfuse'),
                            'id'        => 'seek_property_area_type',
                            'value'     => 'feets',
                            'type'      => 'select',
                            'options'   => array('feets' => 'Feets', 'meters' => 'Meters'),
                            'divider'   => false
                        )
                    )
                ),
            )
        ),
    )
);