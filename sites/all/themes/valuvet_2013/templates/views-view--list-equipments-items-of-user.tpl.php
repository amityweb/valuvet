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
				echo l('<img src="'. $imgUrl.'"/>', 'node/'.$eq->nid);*/
				
				$imgUrl = image_style_url('thumbnail', $eq->_field_data['nid']['entity']->field_ei_image['und'][0]['uri']);
				$link = $base_url . '/'. $eq->_field_data['nid']['entity']->path['alias'];
				echo '<a href="'.$link.'" title=""><img src="'.$imgUrl.'" title="'.$eq->_field_data['nid']['entity']->field_ei_image['und'][0]['title'].'" alt="'.$eq->_field_data['nid']['entity']->field_ei_image['und'][0]['alt'].'" width="150" height="150"></a>';

			 ?>
		</div>
	</div>  
	<div class="views-field views-field-title">
		<span class="field-content">
			<?php echo l($eq->_field_data['nid']['entity']->title, 'node/'.$eq->nid); ?>
			
		</span>
	</div>  
	<div class="views-field views-field-comment-count">
		<span class="field-content">
			<?php 
				$cLabel = $eq->_field_data['nid']['entity']->comment . ' Comment'; 
				$cLabel .= ($eq->_field_data['nid']['entity']->comment > 1) ? 's' : '';
			?>
			<?php echo l($cLabel, 'node/'.$eq->nid); ?>
		</span>
	</div>  
	<div class="views-field views-field-field-ei-price-nz">
		<div class="field-content">
			<div class="eqipment_display">
				<span>Product category: <?php echo $eq->field_field_ei_product_category[0]['rendered']['#markup']; ?></span><br />
				<span>Quantity: <?php echo $eq->_field_data['nid']['entity']->field_ei_quantity['und'][0]['value']; ?></span><br />
				<span>Location: <?php echo $eq->field_field_user_new_address[0]['raw']['city'].', '.$eq->field_field_user_new_address[0]['raw']['province'].', '.$eq->field_field_user_new_address[0]['raw']['country_name']?></span><br />
				
				<span>Price	
				<?php
					if ($eq->field_field_user_new_address[0]['raw']['country_name'] == 'Australia')
					{
						echo '(AUD): '.$eq->field_field_ei_price_aud[0]['rendered']['#markup'];
					}
					else
					{
						echo '(NZ): '.$eq->field_field_ei_price_nz[0]['rendered']['#markup'];
					}

					
				?>
				</span><br />
				
			</div>
		</div>
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