<div class="view-list-equipments-items-of-user">
<ul>
<?php
global $base_url;
foreach($variables['view']->result AS $eq) {
?>
<li class="views-row views-row-2 views-row-even clearfix" style="list-style-type:none">  
	<div class="views-field views-field-field-ei-image">        
		<div class="field-content">
			<?php 
				/*$imgUrl = image_style_url('thumbnail', $eq->_field_data['nid']['entity']->field_ei_image['und'][0]['uri']);
				echo '<img src="'. $imgUrl.'">';
				echo l('<img src="'. $imgUrl.'">', 'node/'.$eq->nid);*/
				
				$imgUrl = image_style_url('thumbnail', $eq->_field_data['nid']['entity']->field_ei_image['und'][0]['uri']);
				$link = $base_url . '/'. $eq->_field_data['nid']['entity']->path['alias'];
				echo '<a href="'.$link.'" title=""><img src="'.$imgUrl.'" title="'.$eq->_field_data['nid']['entity']->field_ei_image['und'][0]['title'].'" alt="'.$eq->_field_data['nid']['entity']->field_ei_image['und'][0]['alt'].'" width="50" height="50"></a>';

			 ?>
		</div>
	</div>  
	<div class="views-field views-field-title">
		<span class="field-content">
			<?php echo l($eq->_field_data['nid']['entity']->title, 'node/'.$eq->nid); ?>
			
		</span>
	</div>  
	<div class="views-field views-field-ops" style="margin-top:20px">        
		<span class="field-content"><?php print flag_create_link('equipments_wishlist', $eq->nid); ?></span>  
	</div>
</li>
<?php
}
?>
</ul>
</div>