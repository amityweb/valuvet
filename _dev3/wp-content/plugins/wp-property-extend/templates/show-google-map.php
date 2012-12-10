<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Google Maps JavaScript API Example: Simple Map</title>
				<script type="text/javascript">
                var map;
                var marker;
                var infowindow;
                jQuery(document).ready(function() {
                  if(typeof jQuery.fn.fancybox == 'function') {
                    jQuery("a.fancybox_image, .gallery-item a").fancybox({
                      'transitionIn'  :  'elastic',
                      'transitionOut'  :  'elastic',
                      'speedIn'    :  600,
                      'speedOut'    :  200,
                      'overlayShow'  :  false
                    });
                  }
                  if(typeof google == 'object') {
                    initialize_this_map();
                  } else {
                    jQuery("#property_map").hide();
                  }
                });
				
              function initialize_this_map() {
                <?php if($coords = WPP_F::get_coordinates()): ?>
                var myLatlng = new google.maps.LatLng(<?php echo $coords['latitude']; ?>,<?php echo $coords['longitude']; ?>);
                var myOptions = {
                  zoom: <?php echo (!empty($wp_properties['configuration']['gm_zoom_level']) ? $wp_properties['configuration']['gm_zoom_level'] : 13); ?>,
                  center: myLatlng,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById("property_map"), myOptions);
                infowindow = new google.maps.InfoWindow({
                  content: '<?php echo WPP_F::google_maps_infobox($post); ?>',
                  maxWidth: 500
                });
                 marker = new google.maps.Marker({
                  position: myLatlng,
                  map: map,
                  title: '<?php echo addslashes($post->post_title); ?>',
                  icon: '<?php echo apply_filters('wpp_supermap_marker', '', $post->ID); ?>'
                });
                google.maps.event.addListener(infowindow, 'domready', function() {
                document.getElementById('infowindow').parentNode.style.overflow='hidden';
                document.getElementById('infowindow').parentNode.parentNode.style.overflow='hidden';
               });
               setTimeout("infowindow.open(map,marker);",1000);
                <?php endif; ?>
              }
              </script>
  </head>
  <body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: 500px; height: 300px"></div>
  </body>
</html>