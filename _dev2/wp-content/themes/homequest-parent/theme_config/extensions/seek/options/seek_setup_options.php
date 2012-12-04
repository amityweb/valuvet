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
                            'divider'   => true
                        ),
                        array(
                            'name'      => __('Contact Agent','tfuse'),
                            'desc'      => __('When the users will submit the Contact the agent form for a property, do you want the email to go to the agent that property belongs to? If you select No the email will go to the administrator of the website.', 'tfuse'),
                            'id' => TF_THEME_PREFIX . '_contact_agent',
                            'value'     => 'true',
                            'type'      => 'checkbox',
                            'divider'   => true
                        ),
                        array(
                            'name'      => __('Default transaction type','tfuse'),
                            'desc'      => __('Select default transaction type for your header search forms.', 'tfuse'),
                            'id'        => 'seek_form_transaction_type',
                            'value'     => 'sale',
                            'type'      => 'select',
                            'options'   => array('sale' => 'Sale', 'rent' => 'Rent'),
                            'divider'   => true
                        ),
                        array(
                            'name'      => __('Send to friend subject','tfuse'),
                            'desc'      => __('When the users will choose to send a specific property link to a friend this will be the subject of that email. Note that you can use the [title] short code to bring in the title of that property.', 'tfuse'),
                            'id' => TF_THEME_PREFIX . '_sent_to_friend_subject',
                            'value'     => 'A new offer [title]',
                            'type'      => 'text',
                            'divider'   => true
                        ),
                        array(
                            'name'      => __('Send to friend email body','tfuse'),
                            'desc'      => __('This is the email body the friend will receive. Use the [link] short code to incorporate a link for that specific property.', 'tfuse'),
                            'id' => TF_THEME_PREFIX . '_sent_to_friend_message',
                            'value'     => 'Hi, I\'ve run into this offer and I thought it might interest you. Check it out: [title] - [link]',
                            'type'      => 'textarea',
                            'divider'   => false
                        )
                    )
                ),
            )
        ),
    )
);