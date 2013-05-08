<?php 
$arr = get_defined_vars();
#dpm($arr); ?> 
<table class="views-table cols-8 table" > 
  <thead> 
    <tr> 
      <th class="views-field views-field-nid" > ID </th> 
      <th class="views-field views-field-title" > Title </th> 
      <th class="views-field views-field-field-property-asking-price" > Asking price </th> 
      <th class="views-field views-field-created" > Post date </th> 
      <th class="views-field views-field-edit-node" > Edit link </th> 
      <th class="views-field views-field-upgrade-order-pratice-1-to-2" > </th> 
      <th class="views-field views-field-upgrade-order-pratice-1-to-3" > </th> 
      <th class="views-field views-field-upgrade-order-pratice-2-to-3" > </th> 
  </tr> 
  </thead> 
    <tbody> 
      <?php echo $arr['rows']; ?>
    </tbody> 
</table>