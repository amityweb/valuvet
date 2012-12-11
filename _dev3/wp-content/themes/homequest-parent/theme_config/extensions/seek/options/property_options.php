<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');


if( !function_exists('tf_seek_post_type_options__html_script_google_maps_input') ):
    function tf_seek_post_type_options__html_script_google_maps_input($map_id, $input_id_lat, $input_id_lng){
        ob_start();

        ?>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false"></script>

    <div style="height:500px;width:500px;" id="<?php print $map_id; ?>"></div>

    <script type="text/javascript">
        jQuery(document).ready(function($){

            new (function(){
                this.map            = null;
                this.lat_element    = $('input#<?php print $input_id_lat; ?>');
                this.lng_element    = $('input#<?php print $input_id_lng; ?>');
                this.mapDiv         = $('#<?php print $map_id; ?>');
                this.marker         = null;

                this.__construct = function(){

                    if(This.map !== null){
                        return;
                    }

                    var getFloatVal = function(value){
                        value = parseFloat(value);

                        if(String(value) == 'NaN'){
                            value = 0;
                        }

                        return value;
                    }

                    // ------------

                    var coods   = {
                        lat:    getFloatVal( This.lat_element.val() ),
                        lng:    getFloatVal( This.lng_element.val() )
                    }

                    var myLatlng    = new google.maps.LatLng( coods.lat, coods.lng);
                    var myOptions   = {
                        zoom: 4,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        streetViewControl: false
                    }
                    This.map = new google.maps.Map(document.getElementById("<?php print $map_id; ?>"), myOptions);

                    This.marker = new google.maps.Marker({
                        position: myLatlng,
                        map: This.map,
                        icon: new google.maps.MarkerImage('<?php bloginfo('template_directory'); ?>/images/gmap_marker.png',
                            new google.maps.Size(34, 40),
                            new google.maps.Point(0,0),
                            new google.maps.Point(16, 40)
                        ),
                        draggable: true,
                        animation: google.maps.Animation.DROP
                    });

                    // ------------

                    var placeMarker = function(position, noUpdateInputs) {
                        if(noUpdateInputs === undefined){
                            noUpdateInputs = false;
                        }

                        coods.lat = position.lat();
                        coods.lng = position.lng();

                        if(!noUpdateInputs){
                            This.lat_element.val( String( coods.lat ) );
                            This.lng_element.val( String( coods.lng ) );
                        }

                        This.marker.setPosition(position);
                        // This.map.setCenter(position);
                    }
                    google.maps.event.addListener(This.map, 'click', function(event) {
                        placeMarker(event.latLng);
                    });
                    google.maps.event.addListener(This.marker, 'dragend', function(event) {
                        placeMarker(event.latLng);
                    });


                    // ------------
                    var change_input = function(){
                        coods   = {
                            lat:    getFloatVal( This.lat_element.val() ),
                            lng:    getFloatVal( This.lng_element.val() )
                        }

                        var newLatlng    = new google.maps.LatLng( coods.lat, coods.lng);

                        placeMarker(newLatlng, true);
                        This.map.setCenter(newLatlng);
                    }
                    This.lat_element.bind('blur change keyup', change_input);
                    This.lng_element.bind('blur change keyup', change_input);
                };

                // -----------------
                var This = this;

                $('#seek_property_maps_has_position').bind('change', function(){

                    if( $(this).is(':checked') ){
                        This.lat_element.removeAttr('disabled').closest('.option').fadeIn();
                        This.lng_element.removeAttr('disabled').closest('.option').fadeIn();
                        This.mapDiv.closest('.option').fadeIn();
                    } else {
                        This.lat_element.attr('disabled', 'disabled').closest('.option').fadeOut();
                        This.lng_element.attr('disabled', 'disabled').closest('.option').fadeOut();
                        This.mapDiv.closest('.option').fadeOut();
                    }
                }).trigger('change');

                if(This.mapDiv.is(":visible")){
                    This.__construct();
                }

                (function(){ // Fix map shift in hidden elements
                    var resizeFunction  = function(){
                        google.maps.event.trigger(This.map, 'resize');

                        if(This.marker !== null){
                            This.map.setCenter( This.marker.getPosition() );
                        }
                    };
                    var mapDivState     = This.mapDiv.is(":visible");
                    var click_function  = function(){
                        var newState = This.mapDiv.is(":visible");

                        if(This.map === null && newState){
                            This.__construct();
                        }

                        if(mapDivState != newState){
                            mapDivState = newState;

                            if(newState){
                                resizeFunction();
                            }
                        }
                    };

                    $(document.body).bind('click', click_function);

                    var interval = setInterval(function(){ // wait until tabs are loaded
                        var tabs = $('.ui-tabs-nav', This.mapDiv.closest('.tf_meta_tabs'));
                        mapDivState = false;
                        if( tabs.length ){
                            $('a', tabs).click(click_function);
                            click_function();
                            clearInterval(interval);
                        }
                    }, 1000);
                })();

            })();
        });
    </script>
    <?php

        return ob_get_clean();
    }
endif;


/* ----------------------------------------------------------------------------------- */

/* HELP: Option structure */
array(
    'name'          => __('Bedrooms', 'tfuse'),
        // This is used as label
    'pluralization' => array(
        // if item value is int, you can show name in plural or singular (abbreviated or not) depends on value
        // user helper function to show proper name: TF_SEEK_HELPER::get_property_pluralization_name(...)
        'single'        => __('Bedroom','tfuse'),
        'plural'        => __('Bedrooms','tfuse'),
        'single_abbr'   => __('Bed', 'tfuse'),
        'plural_abbr'   => __('Beds', 'tfuse')
    ),
    'desc'          => sprintf(__('Choose sale type of this %s', 'tfuse'), mb_strtolower(TF_SEEK_HELPER::get_option('seek_property_name_singular'), 'UTF-8')),
        // description shown near option when editing post
    'id'            => 'seek_property_bedrooms',
        // unique option id
    'value'         => '1',
        // default value
    'type'          => 'text',
        // input type
    'searchable'    => TRUE,
        // set this to true if you want to make this option searchable
        // if set tot true, for this option will be created a column in seek index table in database
        // / then you can use its id and make sql in some sql generator for some form items
        // Attention!!! once column is created in database table for this option id, it can't be deleted automacaly
        // / you have to delete it manually from database table
    'valtype'       => 'int',
        // set valtype for mysql comun in seek index table if you set this option as searchable
        // available values: 'int', 'varchar'
    'template_zone' => 'header',
        // default property template zone to show this option, later you can change this in admin
    'template_zone_priority' => 0,
        // priority/order for showing this option in template
        // if set to -1, this option will not be shown in zones
);
/* ^ */

$options = array(
    /* Post Media */
    array(
        'name'          => sprintf(__('%s details','tfuse'), ucfirst (TF_SEEK_HELPER::get_option('seek_property_name_singular'))),
        'id'            => 'seek_media',
        'type'          => 'metabox',
        'context'       => 'normal'
    ),
    // Slider Images
    array('name' => 'Images',
        'desc' => 'Manage the property images by pressing the "Upload" button. These images will automatically form the slider from the property detail page',
        'id' => TF_THEME_PREFIX . '_slider_images',
        'value' => '',
        'type' => 'multi_upload',
        'divider'   =>true,
        'searchable'    => FALSE,
    ),
    // Thumbnail Image
    array('name' => 'Thumbnail <br>(218px x 125px)',
        'desc' => 'This is the thumbnail for your '. mb_strtolower(TF_SEEK_HELPER::get_option('seek_property_name_singular'), 'UTF-8') . ' and it will be displayed in various sliders on the website and in the property listings. Upload one from your computer, or specify an online address for your image (Ex: http://yoursite.com/image.png).',
        'id' => TF_THEME_PREFIX . '_thumbnail_image',
        'value' => '',
        'type' => 'upload',
        'divider'   =>true,
        'searchable'    => FALSE,
    ),
    array(
        'name' => 'Additional info for sliders',
        'desc' => 'This additional information will appear in the homepage and similar properties sliders. You can use and values from the fields below to provide your visitors more info about the property. We chose to use the number of beds, baths and the price as follows (3 beds, 2baths:<span class="price">$295,000</span>)',
        'id' => TF_THEME_PREFIX . '_title_for_slider',
        'value' => '',
        'type' => 'text',
        'searchable'    => FALSE,
        'divider'       => true,
    ),
    // array(
    //     'name'          => __('Sale / Lease', 'tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Sale type', 'tfuse'),
    //         'plural'        => __('Sale type', 'tfuse'),
    //         'single_abbr'   => __('', 'tfuse'),
    //         'plural_abbr'   => __('', 'tfuse')
    //     ),
    //     'desc'          => sprintf(__('Choose the transaction type for this %s', 'tfuse'), mb_strtolower(TF_SEEK_HELPER::get_option('seek_property_name_singular'), 'UTF-8')),
    //     'id'            => 'seek_property_sale_type',
    //     'value'         => '1',
    //     'type'          => 'select',
    //     'options'       => array(
    //         1 => 'Sale',
    //         2 => 'Lease'
    //     ),
    //     'searchable'    => TRUE,
    //     'valtype'       => 'int',
    //     'template_zone' => '',
    //     'template_zone_priority' => 0
    // ),
    // array(
    //     'name'          => __('Price', 'tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Asking Price', 'tfuse'),
    //         'plural'        => __('Asking Price', 'tfuse'),
    //         'single_abbr'   => __('Price', 'tfuse'),
    //         'plural_abbr'   => __('Price', 'tfuse')
    //     ),
    //     'desc'          => sprintf(__('Enter the %s price without the currency symbol. You can <a href="admin.php?page=themefuse">change the global currency options</a> in the Fuse Framework.', 'tfuse'), mb_strtolower(TF_SEEK_HELPER::get_option('seek_property_name_singular'), 'UTF-8')),
    //     'id'            => 'seek_property_price',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => TRUE,
    //     'valtype'       => 'int',
    //     'template_zone' => '',
    //     'template_zone_priority' => 0
    // ),
    // array(
    //     'name'          => __('Bedrooms','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Bedroom','tfuse'),
    //         'plural'        => __('Bedrooms','tfuse'),
    //         'single_abbr'   => __('Bed', 'tfuse'),
    //         'plural_abbr'   => __('Beds', 'tfuse')
    //     ),
    //     'desc'          => __('Enter number of bedrooms', 'tfuse'),
    //     'id'            => 'seek_property_bedrooms',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => TRUE,
    //     'valtype'       => 'int',
    //     'template_zone' => 'header',
    //     'template_zone_priority' => 0
    // ),
    // array(
    //     'name'          => __('Baths','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Bathroom','tfuse'),
    //         'plural'        => __('Bathrooms','tfuse'),
    //         'single_abbr'   => __('Bath', 'tfuse'),
    //         'plural_abbr'   => __('Baths', 'tfuse')
    //     ),
    //     'desc'          => __('Enter number of baths', 'tfuse'),
    //     'id'            => 'seek_property_baths',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => TRUE,
    //     'valtype'       => 'int',
    //     'template_zone' => 'header',
    //     'template_zone_priority' => 1
    // ),
    // array(
    //     'name'          => __('Half-Baths','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Half-Bath','tfuse'),
    //         'plural'        => __('Half-Baths','tfuse'),
    //         'single_abbr'   => __('Half-Bath', 'tfuse'),
    //         'plural_abbr'   => __('Half-Baths', 'tfuse')
    //     ),
    //     'desc'          => __('Enter number of half-baths', 'tfuse'),
    //     'id'            => 'seek_property_half_baths',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'header',
    //     'template_zone_priority' => 2
    // ),
    // ( TF_SEEK_HELPER::get_option('seek_property_area_type') == 'feets'
    //     ? array(
    //         'name'          => __('Square feet','tfuse'),
    //         'pluralization' => array(
    //             'single'        => __('Square foot','tfuse'),
    //             'plural'        => __('Square feet','tfuse'),
    //             'single_abbr'   => __('Sq ft', 'tfuse'),
    //             'plural_abbr'   => __('Sq ft', 'tfuse')
    //         ),
    //         'desc'          => __('Enter square feet','tfuse'),
    //         'id'            => 'seek_property_square',
    //         'value'         => '',
    //         'type'          => 'text',
    //         'searchable'    => TRUE,
    //         'valtype'       => 'int',
    //         'template_zone' => 'header',
    //         'template_zone_priority' => 4
    //     )
    //     : array(
    //         'name'          => __('Square meters','tfuse'),
    //         'pluralization' => array(
    //             'single'        => __('Square meter','tfuse'),
    //             'plural'        => __('Square meters','tfuse'),
    //             'single_abbr'   => __('Sq m', 'tfuse'),
    //             'plural_abbr'   => __('Sq m', 'tfuse')
    //         ),
    //         'desc'          => __('Enter square meteres','tfuse'),
    //         'id'            => 'seek_property_square',
    //         'value'         => '',
    //         'type'          => 'text',
    //         'searchable'    => TRUE,
    //         'valtype'       => 'int',
    //         'template_zone' => 'header',
    //         'template_zone_priority' => 4
    //     )
    // ),
    // array(
    //     'name'          => __('Basement','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Basement','tfuse'),
    //         'plural'        => __('Basement','tfuse'),
    //         'single_abbr'   => __('Basement', 'tfuse'),
    //         'plural_abbr'   => __('Basement', 'tfuse')
    //     ),
    //     'desc'          => __('Enter basement description','tfuse'),
    //     'id'            => 'seek_property_basement',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 1
    // ),
    // array(
    //     'name'          => __('Exterior','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Exterior','tfuse'),
    //         'plural'        => __('Exterior','tfuse'),
    //         'single_abbr'   => __('Exterior', 'tfuse'),
    //         'plural_abbr'   => __('Exterior', 'tfuse')
    //     ),
    //     'desc'          => __('Enter exterior description','tfuse'),
    //     'id'            => 'seek_property_exterior',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 2
    // ),
    // array(
    //     'name'          => __('Fireplace','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Fireplace','tfuse'),
    //         'plural'        => __('Fireplaces','tfuse'),
    //         'single_abbr'   => __('Fireplace', 'tfuse'),
    //         'plural_abbr'   => __('Fireplaces', 'tfuse')
    //     ),
    //     'desc'          => __('Enter number of fireplaces', 'tfuse'),
    //     'id'            => 'seek_property_fireplaces',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 3
    // ),
    // array(
    //     'name'          => __('Flooring','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Flooring','tfuse'),
    //         'plural'        => __('Flooring','tfuse'),
    //         'single_abbr'   => __('Flooring', 'tfuse'),
    //         'plural_abbr'   => __('Flooring', 'tfuse')
    //     ),
    //     'desc'          => __('Enter flooring','tfuse'),
    //     'id'            => 'seek_property_flooring',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 5
    // ),
    // array(
    //     'name'          => __('Garage','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Garage','tfuse'),
    //         'plural'        => __('Garage','tfuse'),
    //         'single_abbr'   => __('Garage', 'tfuse'),
    //         'plural_abbr'   => __('Garage', 'tfuse')
    //     ),
    //     'desc'          => __('Enter exterior description','tfuse'),
    //     'id'            => 'seek_property_garage',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 6
    // ),
    // array(
    //     'name'          => __('Air Conditioning','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Air Conditioning','tfuse'),
    //         'plural'        => __('Air Conditioning','tfuse'),
    //         'single_abbr'   => __('Air Conditioning', 'tfuse'),
    //         'plural_abbr'   => __('Air Conditioning', 'tfuse')
    //     ),
    //     'desc'          => __('Enter Air Conditioning desciption','tfuse'),
    //     'id'            => 'seek_property_air_conditioning',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 7
    // ),
    // array(
    //     'name'          => __('Heat','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Heat','tfuse'),
    //         'plural'        => __('Heat','tfuse'),
    //         'single_abbr'   => __('Heat', 'tfuse'),
    //         'plural_abbr'   => __('Heat', 'tfuse')
    //     ),
    //     'desc'          => __('Enter Heat desciption','tfuse'),
    //     'id'            => 'seek_property_heat',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 8
    // ),
    // array(
    //     'name'          => __('Lot Size','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Lot Size','tfuse'),
    //         'plural'        => __('Lot Size','tfuse'),
    //         'single_abbr'   => __('Lot Size', 'tfuse'),
    //         'plural_abbr'   => __('Lot Size', 'tfuse')
    //     ),
    //     'desc'          => __('Enter Lot Size','tfuse'),
    //     'id'            => 'seek_property_lot_size',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 9
    // ),
    // array(
    //     'name'          => __('Road Type','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Road Type','tfuse'),
    //         'plural'        => __('Road Type','tfuse'),
    //         'single_abbr'   => __('Road Type', 'tfuse'),
    //         'plural_abbr'   => __('Road Type', 'tfuse')
    //     ),
    //     'desc'          => __('Enter Road Type description','tfuse'),
    //     'id'            => 'seek_property_road_type',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 10
    // ),
    // array(
    //     'name'          => __('Roof','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Roof','tfuse'),
    //         'plural'        => __('Roof','tfuse'),
    //         'single_abbr'   => __('Roof', 'tfuse'),
    //         'plural_abbr'   => __('Roof', 'tfuse')
    //     ),
    //     'desc'          => __('Enter roof description','tfuse'),
    //     'id'            => 'seek_property_roof',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 12
    // ),
    // array(
    //     'name'          => __('Sewer','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Sewer','tfuse'),
    //         'plural'        => __('Sewer','tfuse'),
    //         'single_abbr'   => __('Sewer', 'tfuse'),
    //         'plural_abbr'   => __('Sewer', 'tfuse')
    //     ),
    //     'desc'          => __('Enter sewer description','tfuse'),
    //     'id'            => 'seek_property_sewer',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 13
    // ),
    // array(
    //     'name'          => __('Water','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Water','tfuse'),
    //         'plural'        => __('Water','tfuse'),
    //         'single_abbr'   => __('Water', 'tfuse'),
    //         'plural_abbr'   => __('Water', 'tfuse')
    //     ),
    //     'desc'          => __('Enter water description','tfuse'),
    //     'id'            => 'seek_property_water',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 15
    // ),
    // array(
    //     'name'          => __('Zooning','tfuse'),
    //     'pluralization' => array(
    //         'single'        => __('Zooning','tfuse'),
    //         'plural'        => __('Zooning','tfuse'),
    //         'single_abbr'   => __('Zooning', 'tfuse'),
    //         'plural_abbr'   => __('Zooning', 'tfuse')
    //     ),
    //     'desc'          => __('Enter zoning description','tfuse'),
    //     'id'            => 'seek_property_zoning',
    //     'value'         => '',
    //     'type'          => 'text',
    //     'searchable'    => FALSE,
    //     'template_zone' => 'content',
    //     'template_zone_priority' => 16
    // ),
    // 
    
    // Google Maps Options
    // ! This options is used by ../includes/google_maps/GOOGLE_MAPS.php
    //     if you remove this, deactivate GOOGLE_MAPS.php in ../includes/custom_functions.php
    array(
        'name'          => __('Map','tfuse'),
        'id'            => 'google_maps',
        'type'          => 'metabox',
        'context'       => 'normal'
    ),
    array(
        'name'          => __('Google Map Position','tfuse'),
        'desc'          => __('Check if property has google maps position','tfuse'),
        'id'            => 'seek_property_maps_has_position',
        'value'         => '0',
        'type'          => 'checkbox',
        'searchable'    => TRUE,
        'template_zone' => '',
        'template_zone_priority' => -1,
        'valtype'       => 'int',
    ),
    array(
        'name'          => __('Google Map Latitude','tfuse'),
        'desc'          => __('Enter Google Maps Latitude','tfuse'),
        'id'            => 'seek_property_maps_lat',
        'value'         => '0',
        'type'          => 'text',
        'searchable'    => TRUE,
        'template_zone' => '',
        'template_zone_priority' => -1,
        'valtype'       => 'varchar',
    ),
    array(
        'name'          => __('Google Map Longitude','tfuse'),
        'desc'          => __('Enter Google Maps Longitude','tfuse'),
        'id'            => 'seek_property_maps_lng',
        'value'         => '0',
        'type'          => 'text',
        'searchable'    => TRUE,
        'template_zone' => '',
        'template_zone_priority' => -1,
        'valtype'       => 'varchar',
    ),
    array(
        'name'          => __('Choose Map Position','tfuse'),
        'id'            => 'seek_property_maps_position',
        'value'         => '',
        'type'          => 'raw',
        'html'          => tf_seek_post_type_options__html_script_google_maps_input(
            'seek_property_maps_position_map',
            'seek_property_maps_lat',
            'seek_property_maps_lng'),
        'searchable'    => FALSE,
        'template_zone' => '',
        'template_zone_priority' => -1,
        'valtype'       => '',
    ),
    // end Google Maps Options

);