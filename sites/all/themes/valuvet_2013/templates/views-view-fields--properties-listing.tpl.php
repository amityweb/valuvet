<?
/**
 * HEADLINE of property depends on package type
 *   PCK1 -> "Business [For Sales / For Lease] – Type of Practice [ Small Animal / Large Animal / Mixed Animal / Specialist / Other] – [Suburb], STATE"
 *   PCK2 -> "Business [For Sales / For Lease] – Custom headline – [Suburb], STATE"
 *   PCK3 -> "Business [For Sales / For Lease] – Custom headline – [Suburb], STATE"    (linked to node)
 *
 * IMAGE of property depends on package type
 *   PCK1 -> no image
 *   PCK2 -> image
 *   PCK3 -> linked image
 *
 */
$practice_details = '';
if(isset ($fields['field_property_type']->content)){
  $practice_details .= '<h2>Type of Practice: ' . $fields['field_property_type']->content . '</h2>';
}
if(isset ($fields['field_property_disposal']->content)){
  $practice_details .= '<h2>Practice is for: ' . $fields['field_property_disposal']->content . '</h2>';
}
if(isset ($fields['field_property_disposal']->content)){
  $practice_details .= '<h2>Real estate: ' . $fields['field_property_real_estate']->content . '</h2>';
}
if(isset ($fields['field_property_vv_pract_report']->content)){
  $practice_details .= '<h2>Practice report by ValuVet: ' . $fields['field_property_vv_pract_report']->content . '</h2>';
}
if(isset ($fields['field_property_vv_valuation']->content)){
  $practice_details .= '<h2>Valuation by ValuVet: ' . $fields['field_property_vv_valuation']->content . '</h2>';
}
if(isset ($fields['field_property_vets_n']->content)){
  $practice_details .= '<h2>Number of Vets: ' . $fields['field_property_vets_n']->content . '</h2>';
}
if(isset ($fields['field_property_has_manager']->content)){
  $practice_details .= '<h2>Practice manager: ' . $fields['field_property_has_manager']->content . '</h2>';
}

if($practice_details != ''){
    $practice_details = '<h1>Details</h1>' . $practice_details;
}

switch ($fields['field_property_package']->content) {
  case 'PRP-PCK3':
	//dpm($fields);
	$headline = implode(' - ', array(
				  $fields['field_property_disposal']->content,
				  $fields['field_property_headline']->content,
				  $fields['city']->content.', '.$fields['province']->content,
				));
	$image    = $fields['field_property_listing_image']->content;
	$headline = l($headline, 'node/'.$fields['nid']->content);
	$image    = l($image, 'node/'.$fields['nid']->content, array('html' => true));
	
	$arrImages = explode(',', $fields['field_property_image_gallery']->content);
	$arrImages2 = array();
	foreach ($arrImages AS &$i) {
	    $i = str_replace('>', ' class="colorbox-gallery-'.$fields['nid']->content.'" style="display:none;">', $i);
	    preg_match( '/src="([^"]*)"/i', $i, $array ) ;
	    array_push($arrImages2, $array[1] );
	}
      
	$details  = true;
	break;
  case 'PRP-PCK2':
	$headline = implode(' - ', array(
				  $fields['field_property_disposal']->content,
				  $fields['field_property_headline']->content,
				  $fields['city']->content.', '.$fields['province']->content,
				));
	$image    = $fields['field_property_listing_image']->content;
  	$details  = false;
	break;
  default:
	$headline = implode(' - ', array(
				  $fields['field_property_disposal']->content,
				  $fields['field_property_type']->content.' practice',
				  $fields['city']->content.', '.$fields['province']->content,
				));
	$image = false;
	$details  = false;
	break;
}
?>
<div class="property-row clearfix">
	<div class="vv-property-header">
	  <h3 class="property-headline">
	    <?php print $headline; ?>
	  </h3>
	  <h4 class="property-price">
		  <?php
			  print ($fields['field_property_show_asking_price']->content == 'Yes')
				? $fields['field_property_asking_price']->content
				: $fields['field_property_show_asking_price']->content;
		  ?>
	  </h4>
	</div>
	<div class="vv-property-body">
	  <?php if ($image): ?>
	  <div class="property-image">
	    <?php print $image; ?>
	  </div>
	  <?php endif; ?>
	  <p class="property-overview">
		<?php print $fields['body']->content;?>
	  </p>
	  <p class="property-reference">
		<strong>Ad ref. code:</strong> <?php print $fields['nid']->content?>
	  </p>

	  <div class="property-actions">
		  <?php if ($details): ?>
		    <div class="node-link">
			<?php print l('View details', 'node/'.$fields['nid']->content); ?> - <?php print l('View on map', 'node/'.$fields['nid']->content, array('fragment' => 'map-canvas', 'external' => TRUE)); ?>
			<?php 
			  foreach($arrImages2 AS $img){
			      echo '<a style="display:none;" class="colorbox-gallery-'.$fields['nid']->content.'" href="'.$img.'">View Images</a>';
			  }
			?>
		     - <a class="<?php echo 'colorbox-gallery-'.$fields['nid']->content;?>" href="<?php echo $arrImages2[0];?>">View Images</a>
                     - <a class="<?php echo 'colorbox-preview-'.$fields['nid']->content;?>" href="#">Preview</a>
		   </div>
		  <?php endif; ?>
		  <div class="node-flags"><?php print $fields['ops']->content; ?></div>
	  </div>
	</div>
</div>
<script type="text/javascript">
if (jQuery) {  
(function($) {           
    $(window).load(function() {
	$('.<?php echo 'colorbox-gallery-'.$fields['nid']->content;?>').colorbox({rel:'<?php echo 'colorbox-gallery-'.$fields['nid']->content;?>', slideshow:false});
        $('.<?php echo 'colorbox-preview-'.$fields['nid']->content;?>').colorbox({rel:'<?php echo 'colorbox-preview-'.$fields['nid']->content;?>', html:'<?php print $practice_details; ?>'});
 });
})(jQuery);
}
</script>