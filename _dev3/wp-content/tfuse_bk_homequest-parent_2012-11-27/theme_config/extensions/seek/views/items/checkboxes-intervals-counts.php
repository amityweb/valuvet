<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

$from_min       = $settings['start'];
$from_max       = $settings['start'] + ( $settings['step'] * ($settings['max_steps']-1) );

$check_options  = array();
for($step = 1; $step <= $settings['max_steps']; $step++){
    $from = $settings['start'] + ( $settings['step'] * ($step-1) );
    $to   = $settings['start'] + ( $settings['step'] * ($step) );
    $check_options[$step] = array(
        'output'    => (string)$from.($step==$settings['max_steps'] ? '+' : '-'.$to),
        'count'     => 0,
        'from'      => $from,
        'to'        => $to
    );
}

if(@$vars['show_counts']){
    global $wpdb;

    $sql = 'SELECT
        COUNT(p.ID) AS counter
            FROM '.$wpdb->prefix.'posts AS p
        INNER JOIN '.(TF_SEEK_HELPER::get_db_table_name()).' AS options ON options.post_id = p.ID
            WHERE p.post_status = \'publish\' ';

    if(sizeof($check_options)){
        foreach($check_options as $step=>$val){
            $counter = $wpdb->get_results(
                $sql
                    .' AND options.'.$sql_generator_options['search_on_id'].' >= '.$check_options[$step]['from']
                    .($step<$settings['max_steps']
                        ? ' AND options.'.$sql_generator_options['search_on_id'].' <= '.$check_options[$step]['to']
                        : ''
                    )
                    .' LIMIT 1'
                , ARRAY_A);
            if(sizeof($counter)){
                foreach($counter as $row){
                    $check_options[$step]['count'] = $row['counter'];
                    break;
                }
            }
        }
    }
} else {
    if(sizeof($check_options)){
        foreach($check_options as $id=>$option){
            $check_options[$id]['output'] .= ' ' . mb_strtolower( TF_SEEK_HELPER::get_property_pluralization_name($sql_generator_options['search_on_id'], $id, true), 'UTF-8');
        }
    }
}

$input_value = TF_SEEK_HELPER::get_input_value($parameter_name,'');
$values      = explode(';', $input_value);

?>

<div class="row input_styled checklist">
    <label class="label_title"><?php print($vars['label']); ?>:</label>
    <input type="hidden" name="<?php print($parameter_name); ?>" value="<?php print(esc_attr($input_value)); ?>" id="sopt-seek-<?php print($item_id); ?>" />
    <?php foreach($check_options as $key=>$val): ?>
        <input type="checkbox" onchange="tf_seek_update_hidden_check_<?php print(preg_replace('/[^a-z0-9]/iU', '_', $item_id)); ?>();" class="sopt-seek-<?php print($item_id); ?>" id="sopt-seek-<?php print($item_id); ?>-<?php print($key); ?>" value="<?php print($key); ?>" <?php print( (in_array( (string)$key, $values ) ? 'checked="checked"' : '' ) ); ?> /> <label for="sopt-seek-<?php print($item_id); ?>-<?php print($key); ?>"><?php print($check_options[$key]['output']); ?><?php print( @$vars['show_counts'] ? ' ('.$check_options[$key]['count'].$vars['counts_label'].')' : '' ); ?></label>
    <?php endforeach; ?>
</div>
<script type="text/javascript" >
    function tf_seek_update_hidden_check_<?php print(preg_replace('/[^a-z0-9]/iU', '_', $item_id)); ?>(){
        var $ = jQuery;

        var values = [];
        $(".sopt-seek-<?php print($item_id); ?>").each(function(){
            if($(this).is(':checked')){
                var value = parseInt($(this).val());
                if(-1 == values.indexOf(value)){
                    values.push(value);
                }
            }
        });
        values = values.join(';');
        $("#sopt-seek-<?php print($item_id); ?>").val(values);
    }
</script>