<?php
/**
 * WP-Property Overview Template
 *
 *
 * You can also customize it based on property type.  For example, to create a custom
 * overview page for 'building' property type, create a file called property-overview-building.php
 * into your theme directory.
 *
 *
 * Settings passed via shortcode:
 * $properties: either array of properties or false
 * $show_children: default true
 * $thumbnail_size: slug of thumbnail to use for overview page
 * $thumbnail_sizes: array of image dimensions for the thumbnail_size type
 * $fancybox_preview: default loaded from configuration
 * $child_properties_title: default "Floor plans at location:"
 *
 *
 *
 * @version 1.4
 * @author Andy Potanin <andy.potnain@twincitiestech.com>
 * @package WP-Property
*/?>
 <?php if ( have_properties() ) {
	 wpea_btton_enquiries();
 ?>
 <div class="wpp_row_view wpp_property_view_result">
  <div class="all-properties">
  <?php foreach ( returned_properties('load_gallery=false') as $property) {  ?>
            <?php if( $property["property_type"]=='package_3'  ){
					package_3_overview( $property );
				} elseif( $property["property_type"]=='package_2'  ) {
					package_2_overview( $property );
				} else { 
					package_1_overview( $property );
				}  
				?>
    <?php } /** end of the propertyloop. */ ?>
    <?php include_once('property_contact_form.php')?>

    </div><?php // .all-properties ?>
	</div><?php // .wpp_row_view ?>
<?php } else {  ?>
<div class="wpp_nothing_found">
   <p><?php echo sprintf(__('Sorry, no properties found - try expanding your search, or <a href="%s">view all</a>.','wpp'), site_url().'/'.$wp_properties['configuration']['base_slug']); ?></p>
</div>
<?php } ?>

