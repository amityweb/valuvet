jQuery(document).ready(function($){
    $('input.tf-optigen-input-maps').each(function(){
        var El      = $(this);
        var iD      = El.attr('id');
        var inputX  = $('input#' + iD + '_x');
        var inputY  = $('input#' + iD + '_y');
        var mapDiv  = $('#' + iD + '_map');

        (function(){
            this.marker = null;
            this.map    = null;
            this.LatLng = null;

            this.__construct = function(){
                if(google === undefined){
                    mapDiv.html('Error: goolge API cannot be loaded');
                    return;
                }

                var x = inputX.val();
                    x = (This.isFloat(x) ? parseFloat(x) : null );
                var y = inputY.val();
                    y = (This.isFloat(y) ? parseFloat(y) : null );

                if(x !== null && y !== null){
                    var mapCenter   = new google.maps.LatLng(x, y);
                    var mapZoom     = 7;
                    This.LatLng     = mapCenter;
                } else {
                    var mapCenter   = new google.maps.LatLng(0, 0);
                    var mapZoom     = 2;
                    This.LatLng     = null;
                }

                This.map = new google.maps.Map(
                    document.getElementById( mapDiv.attr('id') ),
                    {
                        zoom:               mapZoom,
                        center:             mapCenter,
                        mapTypeId:          google.maps.MapTypeId.ROADMAP,
                        streetViewControl:  false
                    }
                );

                (function(){ // Fix map shift in hidden elements
                    var closestTabId    = mapDiv.closest('.ui-tabs-panel').first().attr('id');
                    var closestPostBox  = mapDiv.closest('.postbox').first().children('h3').first();
                    var resizeFunction  = function(){
                        google.maps.event.trigger(This.map, 'resize');

                        if(This.marker !== null){
                            This.map.setCenter( This.marker.getPosition() );
                        }
                    };
                    closestPostBox.click(resizeFunction);
                    $('a[href=#' + closestTabId + ']').click(resizeFunction);
                })();

                This.setMarker(x, y);

                google.maps.event.addListener(This.map, 'click', function(event) {
                    This.setMarker(event.latLng);
                });

                (function(){
                    var changeFunction = function(){
                        var x = inputX.val();
                            x = (This.isFloat(x) ? parseFloat(x) : null );
                        var y = inputY.val();
                            y = (This.isFloat(y) ? parseFloat(y) : null );

                        if(x !== null && y !== null){
                            var tmp = new google.maps.LatLng(x, y);

                            El.val(tmp.lat() + ':' + tmp.lng());

                            This.setMarker(x, y, true);
                        } else {
                            El.val('');

                            if(This.marker !== null){
                                This.marker.setMap(null);
                            }
                        }
                    };
                    inputX.bind('blur change keyup', changeFunction);
                    inputY.bind('blur change keyup', changeFunction);
                })();
            };

            this.setMarker = function(x ,y, iAmFromChange){
                var newPoint = null;

                if(typeof(x) == 'object'){
                    newPoint = x; // assume google maps LatLng point
                } else {
                    x = (This.isFloat(x) ? parseFloat(x) : null );
                    y = (This.isFloat(y) ? parseFloat(y) : null );

                    if(x !== null && y !== null){
                        newPoint = new google.maps.LatLng(x, y);
                    }
                }

                if(newPoint !== null){
                    if(This.marker === null){
                        This.marker = new google.maps.Marker({
                            position:   newPoint,
                            map:        This.map,
                            draggable:  true,
                            animation:  google.maps.Animation.DROP
                        });
                        google.maps.event.addListener(This.marker, 'dragend', function(event) {
                            This.setMarker(event.latLng);
                        });
                    } else {
                        This.marker.setMap(This.map);
                        This.marker.setPosition(newPoint);
                    }

                    inputX.val( newPoint.lat() );
                    inputY.val( newPoint.lng() );
                    if(iAmFromChange !== undefined){
                        This.map.setCenter(newPoint);
                    } else {
                        inputX.trigger('change');
                    }

                    return true; // Return success
                } else {
                    if(This.marker !== null){
                        This.marker.setMap(null);
                    }
                    return false; // Fail
                }
            };

            this.isFloat = function(value){
                if( $.trim(value) == '') return false;

                value = parseFloat(value);

                if(String(value) == 'NaN'){
                    return false;
                }

                return true;
            };

            // __construct
            var This    = this;
            this.__construct();
        })();
    });
});