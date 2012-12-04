<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

$from_min       = $settings['start'];
$from_max       = $settings['start'] + ( $settings['step'] * ($settings['max_steps']-1) );

$check_options  = array();
for($step = 1; $step <= $settings['max_steps']; $step++){
    $from = $settings['start'] + ( $settings['step'] * ($step-1) );
    $to   = $settings['start'] + ( $settings['step'] * ($step) ) - 1;
    $check_options[$step] = array(
        'output'    => (string)$from.($step==$settings['max_steps'] && @$settings['max_unlimited'] ? '+' : '-'.$to),
        'count'     => 0,
        'from'      => $from,
        'to'        => $to
    );
}

if(@$vars['show_counts']){
    global $wpdb;

    $search_sql = TF_SEEK_HELPER::get_search_sql(array(
        'noJoins'   => true,
        'noWhere'   => true,
    ));
    $search_sql .= " INNER JOIN " . $wpdb->prefix . "posts AS p ON p.ID = options.post_id ";
    $search_sql .= TF_SEEK_HELPER::get_search_sql(array(
        'noFrom'    => true,
        'noJoins'   => true,
    ));;

    if(@$vars['listen_form_id']){

        $parent_form_id = $vars['listen_form_id'];

        if($parent_form_id == $form_id){
            die('Error: Item option "listen_form_id" cannot be the same as its parent form');
        }

        $sql_where  = TF_SEEK_HELPER::build_form_search_where_sql('main_search', array($parameter_name) );

        if(trim($sql_where['sql'])){
            $search_sql .= " AND ".$sql_where['sql'];
        }
    }

    if(sizeof($check_options)){
        $select_counts  = '';
        $counter        = 0;
        foreach($check_options as $id=>$option){
            $select_counts .= "IF( ";

            $select_counts .= "( options.".$sql_generator_options['search_on_id'] . " >= " . $option['from'];
            if($id>=$settings['max_steps'] && @$settings['max_unlimited']){
                $select_counts .= " )";
            } else {
                $select_counts .= " AND options.".$sql_generator_options['search_on_id'] . " <= " . $option['to'] . ")";
            }

            $select_counts .= ", 'c|".$id."', ";

            $counter++;
        }
        $select_counts .= "'c|~'";
        while(($counter--)>0){
            $select_counts .= ')';
        }
        $select_counts .= ' AS options_counts';

        $search_sql = "SELECT
            COUNT(options.post_id) as posts_counts,
            " . $select_counts . "
            " . $search_sql . "
            GROUP BY options_counts";

        $sql_results = $wpdb->get_results($search_sql);

        if(sizeof($sql_results)){
            foreach($sql_results as $row){
                $check_option_id = intval(array_pop( explode('|', $row->options_counts) ));
                if(isset($check_options[ $check_option_id ])){
                    $check_options[ $check_option_id ]['count'] = $row->posts_counts;
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
        <input type="checkbox" onchange="tf_seek_update_hidden_check_<?php print(preg_replace('/[^a-z0-9]/iU', '_', $item_id)); ?>();" class="sopt-seek-<?php print($item_id); ?>" id="sopt-seek-<?php print($item_id); ?>-<?php print($key); ?>" value="<?php print($key); ?>" <?php print( (in_array( (string)$key, $values ) ? 'checked="checked"' : '' ) ); ?> /> <label for="sopt-seek-<?php print($item_id); ?>-<?php print($key); ?>"><?php print($check_options[$key]['output']); ?><?php print( @$vars['show_counts'] ? ' ('.$check_options[$key]['count'].$vars['counts_label_'.($check_options[$key]['count']==1 ? 'singular' : 'plural')].')' : '' ); ?></label>
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