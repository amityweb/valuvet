<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

$result = array();
foreach($options as $id=>$val){
    if ( $id == 'seek_property_square')
    {
        $result[] = number_format(intval($val['value'])) . ' ' . mb_strtolower( TF_SEEK_HELPER::get_property_pluralization_name($id, $val['value'], true), 'UTF-8');
        continue;
    }
    if($val['type']=='option'){
        // if(is_numeric($val['value']) && !intval($val['value'])) continue;
        $result[] = $val['value'] . ' ' . mb_strtolower( TF_SEEK_HELPER::get_property_pluralization_name($id, $val['value'], true), 'UTF-8');
    } elseif($val['type']=='taxonomy') {
        continue; // Skip taxonomies in this zone, only options
    } else {
        continue;
    }
}

?>
<em><?php print( implode('   <span class="separator">|</span>   ', $result) ); ?></em>