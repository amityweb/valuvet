<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

$check_options = array();
for($i = $settings['min']; $i <= $settings['max']; $i++){
    $check_options[$i] = array(
        'output'    => (string)$i.($i==$settings['max'] ? '+' : ''),
        'count'     => 0,
    );
}

if(@$vars['show_counts']){
    global $wpdb;
    $sql = 'SELECT
        options.'.$sql_generator_options['search_on_id'].' AS element,
        COUNT(p.ID) AS counter
            FROM '.$wpdb->prefix.'posts AS p
        INNER JOIN '.(TF_SEEK_HELPER::get_db_table_name()).' AS options ON options.post_id = p.ID
            WHERE p.post_status = \'publish\' ';

    $all_no_max = $wpdb->get_results(
        $sql
        .
        ' AND options.'.$sql_generator_options['search_on_id'].' >= '.$settings['min']
            .' AND options.'.$sql_generator_options['search_on_id'].' < '.$settings['max']
        .' GROUP BY options.'.$sql_generator_options['search_on_id']
    , ARRAY_A);
    if(sizeof($all_no_max)){
        foreach($all_no_max as $row){
            if(isset($check_options[$row['element']])){
                $check_options[$row['element']]['count'] = $row['counter'];
            }
        }
    }

    $max = $wpdb->get_results(
        $sql
        .
        ' AND options.'.$sql_generator_options['search_on_id'].' >= '.$settings['max']
        .' LIMIT 1'
    , ARRAY_A);
    if(sizeof($max)){
        foreach($max as $row){
            if(isset($check_options[$settings['max']])){
                $check_options[$settings['max']]['count'] = $row['counter'];
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