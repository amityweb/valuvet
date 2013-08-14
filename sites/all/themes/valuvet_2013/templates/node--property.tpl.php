<?php
/**
* @file
* Default theme implementation to display a node.
*
* Available variables:
* - $title: the (sanitized) title of the node.
* - $content: An array of node items. Use render($content) to print them all,
* or print a subset such as render($content['field_example']). Use
* hide($content['field_example']) to temporarily suppress the printing of a
* given element.
* - $user_picture: The node author's picture from user-picture.tpl.php.
* - $date: Formatted creation date. Preprocess functions can reformat it by
* calling format_date() with the desired parameters on the $created variable.
* - $name: Themed username of node author output from theme_username().
* - $node_url: Direct URL of the current node.
* - $display_submitted: Whether submission information should be displayed.
* - $submitted: Submission information created from $name and $date during
* template_preprocess_node().
* - $classes: String of classes that can be used to style contextually through
* CSS. It can be manipulated through the variable $classes_array from
* preprocess functions. The default values can be one or more of the
* following:
* - node: The current template type; for example, "theming hook".
* - node-[type]: The current node type. For example, if the node is a
* "Blog entry" it would result in "node-blog". Note that the machine
* name will often be in a short form of the human readable label.
* - node-teaser: Nodes in teaser form.
* - node-preview: Nodes in preview mode.
* The following are controlled through the node publishing options.
* - node-promoted: Nodes promoted to the front page.
* - node-sticky: Nodes ordered above other non-sticky nodes in teaser
* listings.
* - node-unpublished: Unpublished nodes visible only to administrators.
* - $title_prefix (array): An array containing additional output populated by
* modules, intended to be displayed in front of the main title tag that
* appears in the template.
* - $title_suffix (array): An array containing additional output populated by
* modules, intended to be displayed after the main title tag that appears in
* the template.
*
* Other variables:
* - $node: Full node object. Contains data that may not be safe.
* - $type: Node type; for example, story, page, blog, etc.
* - $comment_count: Number of comments attached to the node.
* - $uid: User ID of the node author.
* - $created: Time the node was published formatted in Unix timestamp.
* - $classes_array: Array of html class attribute values. It is flattened
* into a string within the variable $classes.
* - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
* teaser listings.
* - $id: Position of the node. Increments each time it's output.
*
* Node status variables:
* - $view_mode: View mode; for example, "full", "teaser".
* - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
* - $page: Flag for the full page state.
* - $promote: Flag for front page promotion state.
* - $sticky: Flags for sticky post setting.
* - $status: Flag for published status.
* - $comment: State of comment settings for the node.
* - $readmore: Flags true if the teaser content of the node cannot hold the
* main body content.
* - $is_front: Flags true when presented in the front page.
* - $logged_in: Flags true when the current user is a logged-in member.
* - $is_admin: Flags true when the current user is an administrator.
*
* Field variables: for each field instance attached to the node a corresponding
* variable is defined; for example, $node->body becomes $body. When needing to
* access a field's raw values, developers/themers are strongly encouraged to
* use these variables. Otherwise they will have to explicitly specify the
* desired field language; for example, $node->body['en'], thus overriding any
* language negotiation rule that was previously applied.
*
* @see template_preprocess()
* @see template_preprocess_node()
* @see template_process()
*
* @ingroup themeable
*/

function _valuvet_glue_list($field) {
  $pieces = array();
  if (isset($field['und']) && is_array($field['und']))
    foreach ($field['und'] as $item) {
      $pieces[] = $item['value'];
    }
  return implode(', ', $pieces);
}
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">



  <h1 class="title">
    <?php print $node->field_property_disposal['und'][0]['value']; ?> -
    <?php print $node->field_property_headline['und'][0]['value']; ?> -
    <?php print $node->field_business_address['und'][0]['city']; ?>, <?php print $node->field_business_address['und'][0]['province']; ?>
  </h1>

  <div class="separator" id="vv-overview-container-photo" style="display:none">
    <ul id="vv-listing-image" class="clearfix">
      <li>
		<a style="" href="<?php print image_style_url('property_gallery_big', 'images/property/'.$node->field_property_listing_image['und'][0]['filename']); ?>"><img src="<?php print image_style_url('property_gallery_main', 'images/property/'.$node->field_property_listing_image['und'][0]['filename']); ?>" /></a>
		<?php 
			$arrCaption = explode('.', $node->field_property_listing_image['und'][0]['filename']);
			echo '<span>'.$arrCaption[0].'</span>';
		?>
      </li>
	<?php foreach($node->field_property_image_gallery['und'] as $delta => $image) : ?>
		<li>
		        <a  href="<?php print image_style_url('property_gallery_main','images/property/'.$image['filename']); ?>"><?php print render($content['field_property_image_gallery'][$delta]); ?></a>
			<?php 
			$arrCaption = explode('.', $image['filename']);
			echo '<span>'.$arrCaption[0].'</span>';
			?>
		</li>		
	<?php endforeach; ?>
    </ul>
		
  </div>
  <div class="separator" id="vv-overview-container">
    <div id="vv-overview">

      <h3>Property overview:</h3>
      <h4 class="price">
  <?php if ($node->field_property_show_asking_price['und'][0]['value']): ?>
  <?php print number_format($node->field_property_asking_price['und'][0]['amount'],2,',','.'); ?> <?php print $node->field_property_asking_price['und'][0]['currency_code']; ?>
  <?php else: ?>
  P.O.A.
  <?php endif; ?>
  </h4>
      <ul id="vv-business-details">
      <li><strong>Business name:</strong><?php print $title; ?></li>
      <li><?php print render($content['field_business_address']); ?></li>
      </ul>
      <p id="vv-description">
        <?php print $node->body['und'][0]['value']; ?>
      </p>
      <ul id="vv-sales-details">
        <li><?php print render($content['field_property_disposal']); ?></li>
        <li><?php print render($content['field_property_real_estate']); ?></li>
        <li><strong>Equipment:</strong> <?php print ($node->field_property_eqpmnt_value_ask['und'][0]['value']) ? 'Included' : 'Not included'; ?></li>
        <li><strong>Stock:</strong> <?php print ($node->field_property_stock_value_ask['und'][0]['value']) ? 'Included' : 'Not included'; ?></li>
        <li><strong>ValuVet valuation:</strong> <?php print ($node->field_property_vv_valuation['und'][0]['value']) ? 'Available' : 'Not available'; ?></li>
        <li><strong>ValuVet report:</strong> <?php print ($node->field_property_vv_pract_report['und'][0]['value']) ? 'Available' : 'Not available'; ?></li>
      </ul>
    </div>
  </div>


    <h4 class="toggle">Property details<span class="ico">&nbsp;</span></h4>

    <div class="toggle_content boxed" style="display: none;">
      <div class="separator" id="vv-details-container">
        <h5>Type of practice</h5>
        <ul id="vv-practice-type">
          <li><?php print render($content['field_property_type']); ?></li>
          <?php if ($node->field_property_small_animals['und'][0]['value']): ?><li><strong><?php print $node->field_property_small_animals['und'][0]['value']; ?>%:</strong> <?php print _valuvet_glue_list($node->field_property_small_animals_cbs); ?></li><?php endif; ?>
          <?php if ($node->field_property_equine['und'][0]['value']): ?><li><strong><?php print $node->field_property_equine['und'][0]['value']; ?>%:</strong> <?php print _valuvet_glue_list($node->field_property_equine_cbs); ?></li><?php endif; ?>
          <?php if ($node->field_property_bovine['und'][0]['value']): ?><li><strong><?php print $node->field_property_bovine['und'][0]['value']; ?>%:</strong> <?php print _valuvet_glue_list($node->field_property_bovine_cbs); ?></li><?php endif; ?>
          <?php if ($node->field_property_other_animals['und'][0]['value']): ?><li><strong><?php print $node->field_property_other_animals['und'][0]['value']; ?>%:</strong> <?php print _valuvet_glue_list($node->field_property_other_animals_cb); ?></li><?php endif; ?>
        </ul>

        <h5>Staff</h5>
        <ul id="vv-practice-staff">
          <li><?php print render($content['field_property_vets_n']); ?></li>
          <li><?php print render($content['field_property_nurse_n']); ?></li>
          <li><?php print render($content['field_property_has_manager']); ?></li>
        </ul>

        <h5>Facilities</h5>
        <ul id="vv-practice-facilities">
          <li><?php print render($content['field_property_building_type']); ?></li>
          <li><?php print render($content['field_property_ownership']); ?></li>
          <li><?php print render($content['field_property_building_area']); ?></li>
          <li><?php print render($content['field_property_branch_clinics_n']); ?></li>
          <li><?php print render($content['field_property_open_days_week']); ?></li>
          <li><strong>Facilities include:</strong> <?php print _valuvet_glue_list($node->field_property_facilities_have); ?></li>
          <li><?php print render($content['field_property_carparks_n']); ?></li>
          <li><?php print render($content['field_property_pc_n']); ?></li>
          <li><?php print render($content['field_property_software']); ?></li>
        </ul>
      </div>
    </div>
    
  <div class="separator" id="vv-details-descriptions">
    <h4>The business</h4>
    <p><?php print $node->field_property_the_business['und'][0]['value']; ?></p>

    <h4>The opportunity</h4>
    <p><?php print $node->field_property_the_opportunity['und'][0]['value']; ?></p>

    <h4>The location</h4>
    <p><?php print $node->field_property_the_location['und'][0]['value']; ?></p>

  </div>

  <p class="property-reference">
    <strong>Ad ref. code:</strong> <?php print $node->nid?>
  </p>

  <div class="property-actions">
      <div class="back-link"><?php print l('< Back to properties listing', 'properties'); ?></div>
      <div class="node-flags"><?php print flag_create_link('bookmarks', $node->nid); ?></div>
<?php
global $base_root;
$nodeUrl = $base_root . request_uri();
?>
      <div class="mail-to-friend"><a title="Send to a friend" target="_blank" href="mailto:?subject=<?php print urlencode($title); ?>&amp;Content-type=text/html&amp;body=Hi%2C+I%27ve+run+into+this+offer+and+I+thought+it+might+interest+you.+Check+it+out%3<?php print urlencode($title); ?>+-+<?php echo urlencode($nodeUrl);?>"><img src="<?php print base_path() . drupal_get_path('theme', 'valuvet_2013'); ?>/images/icon_mail.png" alt="Mail icon"></a></div>
      <div class="print-page"><a title="Print this page" href="javascript:window.print()"><img src="<?php print base_path() . drupal_get_path('theme', 'valuvet_2013'); ?>/images/icon_print.png" alt="Print icon" /></a></div>
  </div>

</div>


<script type="text/javascript">
if (jQuery) { 
(function($) {

    $(window).load(function() {

      $('#vv-listing-image').pikachoose({autoPlay:false, carousel:true,carouselVertical:true, showCaption:true});
		
	$('.clip a').click(function(event){ event.preventDefault(); });

      $('.pika-stage a').first().click(function(event){
	  event.preventDefault();
	  $('.pika-stage a').first().addClass('galpika');
	  var avoid = $('.pika-stage img').first().attr('src');
	  $('.clip a').each(function( index ) {
	      if($(this).attr('href') !== avoid)
	      {
		  $(this).addClass('galpika');
	      }

	  });

	  $('.galpika').colorbox({rel:'galpika', slideshow:false, onClosed:function(){
		$.colorbox.remove();
		$('.clip a').removeClass('galpika');
	      }
	  });

      });


      $('#vv-overview-container-photo').show();

    });
})(jQuery);
}</script>