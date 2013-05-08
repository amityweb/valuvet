<header id="navbar" role="banner" class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="row header">
            <section class="span4">
              <?php if ($logo): ?>
                <a class="logo pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
                  <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
                </a>
              <?php endif; ?>

              <?php if ($site_name): ?>
                <h1 id="site-name">
                  <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" class="brand"><?php print $site_name; ?></a>
                </h1>
              <?php endif; ?>
          </section>
          <section class="span8">
              <?php if ($primary_nav || $secondary_nav || !empty($page['navigation'])): ?>
                <div class="nav-collapse">
                  <nav role="navigation">
                    <?php if (!empty($page['navigation'])): ?>
                      <?php print render($page['navigation']); ?>
                    <?php endif; ?>
                  </nav>
                </div>
              <?php endif; ?>
          </div>
        </div>
</div>
</header>
<div class="topblack">
      <div class="container">
        <section class="row">
            <div class="jcarousel span12"><?php print render($page['jcarousel']); ?></div>
        </section>
      </div>
    <div id="map-canvas" style="width:100%;height:400px;display:block;"></div>
</div>
<div class="container">
  <header role="banner" id="page-header">
    <?php if ( $site_slogan ): ?>
      <p class="lead"><?php print $site_slogan; ?></p>
    <?php endif; ?>

    <?php print render($page['header']); ?>
  </header> <!-- /#header -->

  <div class="row content">
    <section class="<?php print empty($page['sidebar_right']) ? 'span12' : 'span8'; ?>">
      <div class="row" style="clear:both">
	<div class="span8">
	  <?php if ($page['highlighted']): ?>
	    <div class="highlighted hero-unit"><?php print render($page['highlighted']); ?></div>
	  <?php endif; ?>
	  <a id="main-content"></a>
	  <?php print $messages; ?>
	  <?php if ($page['help']): ?>
	    <div class="well"><?php print render($page['help']); ?></div>
	  <?php endif; ?>
	  <?php if ($action_links): ?>
	    <ul class="action-links"><?php print render($action_links); ?></ul>
	  <?php endif; ?>
	</div>
      </div>
     
      
      <?php print render($page['content']); ?>


       <div class="row" style="clear:both">
	<div class="span8">
	  <?php if ($page['highlighted']): ?>
	    <div class="highlighted hero-unit"><?php print render($page['highlighted']); ?></div>
	  <?php endif; ?>
	  <a id="main-content"></a>
	  <?php print render($title_prefix); ?>
	  <?php print render($title_suffix); ?>
	  <?php #if ($tabs): ?>
	    <?php #print render($tabs); ?>
	  <?php #endif; ?>
	  <?php if ($page['help']): ?>
	    <div class="well"><?php print render($page['help']); ?></div>
	  <?php endif; ?>
	  <?php if ($action_links): ?>
	    <ul class="action-links"><?php print render($action_links); ?></ul>
	  <?php endif; ?>
	</div>
      </div>
    </section>

    <?php if ($page['sidebar_right']): ?>
      <aside class="span4" role="complementary">
        <?php print render($page['sidebar_right']); ?>
      </aside>  <!-- /#sidebar-right -->
    <?php endif; ?>
  </div>
  <div class="row">
    <section class="span4">
        <div class="preface_first"><?php print render($page['preface_first']); ?></div>
    </section>
    <section class="span4">
        <div class="preface_second"><?php print render($page['preface_second']); ?></div>
    </section>
    <section class="span4">
        <div class="preface_third"><?php print render($page['preface_third']); ?></div>
    </section>
  </div>
  </div>

  <div class="row footer">
    <div id="footer">

      <footer class="footer container">
        <?php print render($page['footer']); ?>
      </footer>
    </div>
  </div>

<?php
global $base_url;

$nId = arg(1);
$mapAddress = $page['content']['system_main']['nodes'][$nId]['body']['#object']->field_business_address['und'][0]['street'].','.
		    $page['content']['system_main']['nodes'][$nId]['body']['#object']->field_business_address['und'][0]['city'].','.
		   $page['content']['system_main']['nodes'][$nId]['body']['#object']->field_business_address['und'][0]['postal_code'].','.
		    $page['content']['system_main']['nodes'][$nId]['body']['#object']->field_business_address['und'][0]['province_name'].','.
		    $page['content']['system_main']['nodes'][$nId]['body']['#object']->field_business_address[0]['country_name'];
?>
<script type="text/javascript">

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  
  var mapOptions = {
      zoom: 14,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  
  
 
    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
  
    var address = '<?php echo $mapAddress;?>';
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var Marker = new google.maps.Marker();
	var MarkerOptions = {};
	MarkerOptions.map = map;
	MarkerOptions.position = results[0].geometry.location;
	MarkerOptions.animation = google.maps.Animation.DROP;
	MarkerOptions.clickable = false;
	MarkerOptions.cursor = 'pointer';

	Marker.smallicon = [{
	   
	    anchor:null,
	    origin:null,
	    scaledSize:null,
	    url:'<?php print $base_url. '/' .drupal_get_path('theme', 'valuvet_2013'); ?>/images/gmap_marker.png'
	    }];
	Marker.setIcon(Marker.smallicon[0]);
	Marker.setOptions(MarkerOptions);
    
      } else {
	alert("Geocode was not successful for the following reason: " + status);
      }
    });
 

      }
     google.maps.event.addDomListener(window, 'load', initialize);
</script>