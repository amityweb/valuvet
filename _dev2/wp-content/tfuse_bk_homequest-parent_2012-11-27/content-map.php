<?php

global $post;

$tmp_conf = array(
    'load_markers'  => true,
    'post_id'       => 0,
    'post_coords'   => array(
        'lat'       => 0,
        'lng'       => 0,
        'html'      => ''
    ),
    'show_all_markers' => true
);
if ((is_page() || is_single()) && (get_post_type($post->ID))!= TF_SEEK_HELPER::get_post_type())
{
    //if is page
    $tmp_conf['post_id'] = $post->ID;
    $tmp_conf ['show_all_markers'] = false;
    $coords = explode(':', tfuse_page_options('page_map'));
    if((!$coords[0]) || (!$coords[1]))
    {
        $tmp_conf ['show_all_markers'] = true;
    }
    else
    {
        $tmp_conf['post_coords']['lat']     = preg_replace('[^0-9\.]', '', $coords[0]);
        $tmp_conf['post_coords']['lng']     = preg_replace('[^0-9\.]', '', $coords[1]);

        $tmp_conf['post_coords']['html']    = '<strong>'.__('We','tfuse').'</strong><span>'.__('are','tfuse').'</span>'.__('here','tfuse');
    }
}
elseif($post){
    // Check type
    if( ($tmp = get_post_type($post->ID)) && $tmp == TF_SEEK_HELPER::get_post_type() ){
        if(TF_SEEK_HELPER::get_post_option('property_maps_has_position')){
            $tmp_conf['post_id'] = $post->ID;
            $tmp_conf['post_coords']['lat']     = preg_replace('[^0-9\.]', '', TF_SEEK_HELPER::get_post_option('property_maps_lat'));
            $tmp_conf['post_coords']['lng']     = preg_replace('[^0-9\.]', '', TF_SEEK_HELPER::get_post_option('property_maps_lng'));
            $tmp_conf['post_coords']['html']    = '<strong>'.__('You','tfuse').'</strong><span>'.__('are','tfuse').'</span>'.__('here','tfuse');
        }
    }
}

?>
<script type="text/javascript">
    window.TF_SEEK_MAP_HOME_MARKER = function(opts){
        this.map_       = opts.map;
        this.html_      = '';
        this.latLng_    = Object();
    };

    jQuery(document).ready(function($){
        window.TF_SEEK_MAP_HOME_MARKER.prototype = new google.maps.OverlayView();

        window.TF_SEEK_MAP_HOME_MARKER.prototype.setLatLng = function(latLng){
            this.latLng_    = latLng;
        };

        window.TF_SEEK_MAP_HOME_MARKER.prototype.show = function(html){
            if(typeof html != 'undefined'){
                this.html_ = html;
            }

            this.setMap(this.map_);
        };

        window.TF_SEEK_MAP_HOME_MARKER.prototype.hide = function(){
            this.setMap(null);
        }

        /* Creates the DIV representing this InfoBox in the floatPane.  If the panes
        * object, retrieved by calling getPanes, is null, remove the element from the
        * DOM.  If the div exists, but its parent is not the floatPane, move the div
        * to the new pane.
        * Called from within draw.  Alternatively, this can be called specifically on
        * a panes_changed event.
        */
        window.TF_SEEK_MAP_HOME_MARKER.prototype.createElement = function() {
            var panes   = this.getPanes();
            var div     = this.div_;
            var This    = this;

            if (!div) {

                // This does not handle changing panes.  You can set the map to be null and
                // then reset the map to move the div.
                div = this.div_         = document.createElement("div");
                div.className           = "map-location current-location";
                div.style.position      = 'absolute';
                div.style.display       = 'none';
                div.innerHTML           = '<?php print str_replace("\'", "\\'", $tmp_conf['post_coords']['html']); ?>';

                panes.floatPane.appendChild(div);
            } else if (div.parentNode != panes.floatPane) {
                // The panes have changed.  Move the div.
                div.parentNode.removeChild(div);
                panes.floatPane.appendChild(div);
            } else {
                // The panes have not changed, so no need to create or move the div.
            }
        };

        /* Redraw the Bar based on the current projection and zoom level
        */
        window.TF_SEEK_MAP_HOME_MARKER.prototype.draw = function() {
            // Creates the element if it doesn't exist already.
            this.createElement();

            var pixPosition       = this.getProjection().fromLatLngToDivPixel(this.latLng_);

            var jDiv              = $(this.div_);

            // Now position our DIV based on the DIV coordinates of our bounds
            var float_offset_x      = pixPosition.x - parseInt(pixPosition.x);
                float_offset_x      = (float_offset_x<0 ? -float_offset_x : float_offset_x);
            var float_offset_y      = pixPosition.x - parseInt(pixPosition.x);
                float_offset_y      = (float_offset_y<0 ? -float_offset_y : float_offset_y);

            this.div_.style.left    = (pixPosition.x - ((jDiv.width()/2)+float_offset_x) ) + "px";
            this.div_.style.top     = (pixPosition.y - parseInt(jDiv.height()) - 12 + float_offset_y ) + "px";
            this.div_.style.display = 'block';
        };

        /* Creates the DIV representing this InfoBox
        */
        window.TF_SEEK_MAP_HOME_MARKER.prototype.remove = function() {
            if (this.div_) {
                this.div_.parentNode.removeChild(this.div_);
                this.div_ = null;
            }
        };
    });
</script>
<script type="text/javascript">
    window.TF_SEEK_CUSTOM_POST_INFO_BOX = function(opts){
        this.map_       = opts.map;
        this.html_      = '';
        this.latLng_    = Object();
    };

    jQuery(document).ready(function($){
        window.TF_SEEK_CUSTOM_POST_INFO_BOX.prototype = new google.maps.OverlayView();

        window.TF_SEEK_CUSTOM_POST_INFO_BOX.prototype.setHtml = function(html){
            this.html_      = html;
        };

        window.TF_SEEK_CUSTOM_POST_INFO_BOX.prototype.setLatLng = function(latLng){
            this.latLng_    = latLng;
        };

        window.TF_SEEK_CUSTOM_POST_INFO_BOX.prototype.show = function(html){
            if(typeof html != 'undefined'){
                this.html_ = html;
            }

            this.setMap(this.map_);
        };

        window.TF_SEEK_CUSTOM_POST_INFO_BOX.prototype.hide = function(){
            this.setMap(null);
        }

        /* Creates the DIV representing this InfoBox in the floatPane.  If the panes
        * object, retrieved by calling getPanes, is null, remove the element from the
        * DOM.  If the div exists, but its parent is not the floatPane, move the div
        * to the new pane.
        * Called from within draw.  Alternatively, this can be called specifically on
        * a panes_changed event.
        */
        window.TF_SEEK_CUSTOM_POST_INFO_BOX.prototype.createElement = function() {
            var panes   = this.getPanes();
            var div     = this.div_;
            var This    = this;

            if (!div) {

                var tmlHtml = '\
                    <div class="map-textbox-close"></div>\
                    <div class="map-textbox-top"></div>\
                    <div class="map-textbox-mid">\
                        '+ this.html_ +'\
                    </div>\
                    <div class="map-textbox-bot"></div>\
                ';

                // This does not handle changing panes.  You can set the map to be null and
                // then reset the map to move the div.
                div = this.div_         = document.createElement("div");
                div.className           = "map-textbox";
                div.innerHTML           = tmlHtml;

                var closeImg = $('div.map-textbox-close', this.div_)
                    .first()
                    .click(function() {
                        This.hide();
                    });

                panes.floatPane.appendChild(div);
            } else if (div.parentNode != panes.floatPane) {
                // The panes have changed.  Move the div.
                div.parentNode.removeChild(div);
                panes.floatPane.appendChild(div);
            } else {
                // The panes have not changed, so no need to create or move the div.
            }
        };

        /* Redraw the Bar based on the current projection and zoom level
        */
        window.TF_SEEK_CUSTOM_POST_INFO_BOX.prototype.draw = function() {
            var map = this.map_;

            var bounds = map.getBounds();
            if (!bounds) return;

            // Creates the element if it doesn't exist already.
            this.createElement();

            var pixPosition     = this.getProjection().fromLatLngToDivPixel(this.latLng_);

            var jDiv            = $(this.div_);

            // The dimension of the infowindow
            var iwWidth     = jDiv.width();
            var iwHeight    = jDiv.height();

            // The offset position of the infowindow
            var iwOffsetX = 0;
            var iwOffsetY = 0;

            // Padding on the infowindow
            var padX = 0;
            var padY = 0;

            var position        = this.latLng_;
            var mapDiv          = map.getDiv();
            var mapWidth        = mapDiv.offsetWidth;
            var mapHeight       = mapDiv.offsetHeight;
            var boundsSpan      = bounds.toSpan();
            var longSpan        = boundsSpan.lng();
            var latSpan         = boundsSpan.lat();
            var degPixelX       = longSpan / mapWidth;
            var degPixelY       = latSpan / mapHeight;
            var mapWestLng      = bounds.getSouthWest().lng();
            var mapEastLng      = bounds.getNorthEast().lng();
            var mapNorthLat     = bounds.getNorthEast().lat();
            var mapSouthLat     = bounds.getSouthWest().lat();

            // The bounds of the infowindow
            var iwWestLng  = position.lng() + (iwOffsetX - padX) * degPixelX;
            var iwEastLng  = position.lng() + (iwOffsetX + iwWidth + padX) * degPixelX;
            var iwNorthLat = position.lat() - (iwOffsetY - padY) * degPixelY;
            var iwSouthLat = position.lat() - (iwOffsetY + iwHeight + padY) * degPixelY;

            var myOffset    = parseInt(-((position.lat() / degPixelY - (100)) - mapNorthLat / degPixelY));
            //console.log([mapWestLng, mapEastLng, mapNorthLat, mapSouthLat]);
            //console.log([myOffset]);
            //console.log([mapWestLng - position.lng(), mapEastLng - position.lng(),  mapNorthLat - position.lat(), mapSouthLat - position.lat()]);

            // Now position our DIV based on the DIV coordinates of our bounds
            var float_offset_x      = pixPosition.x - parseInt(pixPosition.x);
                float_offset_x      = (float_offset_x<0 ? -float_offset_x : float_offset_x);
            var float_offset_y      = pixPosition.x - parseInt(pixPosition.x);
                float_offset_y      = (float_offset_y<0 ? -float_offset_y : float_offset_y);

            var myTopOffset         = (myOffset > 230
                    ? parseInt(jDiv.height()) + (37+float_offset_y)
                    : 0
                    );
            this.div_.style.left    = (pixPosition.x - (60+float_offset_x) ) + "px";
            this.div_.style.top     = (pixPosition.y - myTopOffset ) + "px";
            this.div_.style.display = 'block';
        };

        /* Creates the DIV representing this InfoBox
        */
        window.TF_SEEK_CUSTOM_POST_INFO_BOX.prototype.remove = function() {
            if (this.div_) {
                this.div_.parentNode.removeChild(this.div_);
                this.div_ = null;
            }
        };
    });
</script>
<script type="text/javascript">
    function TF_SEEK_CUSTOM_POST_GOOGLE_MAP(map_element, map_options){
        this.map        = Object();
        this.infoBox    = Object();

        // Init
        this.init(map_element, map_options);
    }
    TF_SEEK_CUSTOM_POST_GOOGLE_MAP.prototype = {
        $: jQuery,

        init: function(map_element, map_options){
            this.map        = new google.maps.Map(map_element, map_options);

            this.createHomeMarker();

            this.createInfoBox();

            this.load_markers();
        },

        load_markers: function(){
            var This = this;

            <?php if($tmp_conf['show_all_markers']): ?>
            $.post(tf_script.ajaxurl,
                {
                    action:     'tf_action',
                    tf_action:  'tf_action_ajax_seek_get_google_maps_markers'
                },
                function(data){

                    This.show_markers(data, <?php print($tmp_conf['post_id'] ? $tmp_conf['post_id'] : 0); ?>);
                },
                'json'
            );
            <?php endif; ?>
        },

        createInfoBox: function(){
            this.infoBox = new TF_SEEK_CUSTOM_POST_INFO_BOX({map: this.map});
        },

        createHomeMarker: function(){
            if( parseInt(<?php print $tmp_conf['post_id']; ?>) ){
                var position = new google.maps.LatLng( parseFloat( <?php print $tmp_conf['post_coords']['lat']; ?> ), parseFloat(<?php print $tmp_conf['post_coords']['lng']; ?>) );

                this.homeMarker = new TF_SEEK_MAP_HOME_MARKER({map: this.map});
                this.homeMarker.setLatLng( position );
                this.homeMarker.show();
            }
        },

        show_markers: function(markers, exclude_id){
            var This = this;

            var marker          = null;
            var marker_position = null;

            var bind_events = function(marker, mrkr, post_id){
                google.maps.event.addListener(marker, "mouseover", function(e) {
                    This.infoBox.hide();
                    This.infoBox.setLatLng(e.latLng);
                    This.infoBox.setHtml(mrkr.html);
                    This.infoBox.show();
                });
                google.maps.event.addListener(marker, "mouseout", function(e) {
                    This.infoBox.hide();

                });
                google.maps.event.addListener(marker, "click", function(e) {
                    $.post(tf_script.ajaxurl,
                        {
                            action:     'tf_action',
                            tf_action:  'tf_action_ajax_seek_get_google_maps_post_permalink',
                            post_id:    post_id
                        },
                        function(data){
                            window.location.replace(data.permalink);
                        },
                        'json'
                    );
                });
            }

            var mrkr = null;
            for(var post_id in markers){
                if(parseInt(exclude_id) == parseInt(post_id)) continue;
                mrkr = markers[post_id];

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng( mrkr.lat, mrkr.lng),
                    map: This.map,
                    icon: new google.maps.MarkerImage('<?php bloginfo('template_url'); ?>/images/gmap_marker.png',
                        new google.maps.Size(34, 40),
                        new google.maps.Point(0,0),
                        new google.maps.Point(16, 40)
                    )
                });

                bind_events(marker, mrkr, post_id);
            }
        },

        utils: {
            getFloatVal: function(value){
                value = parseFloat(value);

                if(String(value) == 'NaN'){
                    value = 0;
                }

                return value;
            }
        }
    };
</script>

<!-- map before content -->
<div class="maptop">
    <div class="maptop_content" id="tf-seek-post-before-content-google-map">
        <img src="<?php print bloginfo('template_url'); ?>/images/maptop_1.jpg" width="1920" height="309" alt="">
    </div>

    <div class="maptop_pane">
        <div class="container_12">
            <div class="maptop_hidebtn">Hide the Map <span></span></div>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var mapOptions = {
                zoom: 2,
                center: new google.maps.LatLng(0, 0),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                scrollwheel: false
            };

            <?php if($tmp_conf['post_id']): ?>
                mapOptions.zoom     = 14;
                mapOptions.center   = new google.maps.LatLng( parseFloat( <?php print $tmp_conf['post_coords']['lat']; ?> ), parseFloat(<?php print $tmp_conf['post_coords']['lng']; ?>) );
            <?php endif; ?>

            var seek_map = new TF_SEEK_CUSTOM_POST_GOOGLE_MAP(
                document.getElementById('tf-seek-post-before-content-google-map'),
                mapOptions
            );

            // Show/Hide Map
            $(".maptop_hidebtn").click(function(){
                if ($(this).closest(".maptop").hasClass("map_hide")) {
                    $(".maptop_content").stop().animate({height:'309px'},{queue:false, duration:550, easing: 'easeOutQuart'});
                    $(this).html("Hide the Map <span></span>");
                } else {
                    $(".maptop_content").stop().animate({height:'0px'},{queue:false, duration:550, easing: 'easeOutQuart'});
                    $(this).html("Show the Map <span></span>");
                }
                $(this).closest(".maptop").toggleClass("map_hide");
            });

        });
    </script>
</div>
<!--/ map before content -->
