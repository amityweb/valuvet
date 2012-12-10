<?php

/**
 * To this zones in admin panel is attached seek property options
 * via helper function you can get all property options attached on particular zone id and print it in template
 */

$options = array(
    'header'    => array( // zone_id coincide with template name located in ../views/zones/
        'label' => __('Header', 'tfuse'),
    ),
    'content'   => array( // First is default for all taxonomies
        'label' => __('Content','tfuse'),
    ),
);