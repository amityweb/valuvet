<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

$result = array();
foreach($options as $id=>$val){
    if($val['type']=='option'){

        if(!trim($val['value'])) continue;

        $title  = TF_SEEK_HELPER::get_property_pluralization_name($id, $val['value']);
        $value  = $val['value'];
    } elseif($val['type']=='taxonomy') {

        if(!sizeof($val['value'])) continue;

        $tax    = get_taxonomy($id);
		if(!$tax) continue;

        $title  = $tax->labels->name;

        $value  = array();
        foreach($val['value'] as $vkey=>$vval){
            $value[] = '<a href="' . get_term_link($vval->slug,$tax->name) . '">' . $vval->name . '</a>';
        }
        $value  = implode(', ', $value);
    } else {
        continue;
    }

    $result[]   = '<li><strong>' . $title . ':</strong> ' . $value . '</li>' ;
}

?>

<script type="text/javascript" src="<?php print( get_template_directory_uri() ); ?>/js/jquery.easyListSplitter.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.split_list').easyListSplitter({colNumber: 3});
    });
</script>
<div class="re-details">
    <h2><?php print( sprintf( __('%s Details','tfuse'), TF_SEEK_HELPER::get_option('seek_property_name_singular','Property') ) ); ?>:</h2>
    <ul class="split_list">
        <?php print( implode("\n", $result) ); ?>
        <li><strong>Number of Full-time Vet:</strong> <?php meta('full-time-vet'); ?></li>
        <li><strong>Number of Nurse:</strong> <?php meta('number-nurse'); ?></li>
        <li><strong>Practice Manager:</strong> <?php meta('practice-manager'); ?></li>
    </ul>
    <div class="clear"></div>
</div>