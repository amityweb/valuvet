<?php

$values      = explode(';', TF_SEEK_HELPER::get_input_value($parameter_name,''));

// cleanup input
$old_values  = $values;
$values      = array();
if(sizeof($old_values)){
    foreach($old_values as $id){
        if(1 > ( $id = intval($id)) ) continue;

        $values[ $id ] = '...';
    }
}
$values = array_keys($values);
unset($old_values);

$check_options  = array();
$terms          = get_terms($sql_generator_options['search_on_id'], 'hide_empty=0' . (@$vars['get_terms_args']) );
if(sizeof($terms)){
    foreach($terms as $term){
        $check_options[ $term->term_id ] = array(
            'output'    => $term->name
        );
    }
}

if(!sizeof($check_options)) return;

?>
<div class="row input_styled checklist">
    <label class="label_title"><?php print($vars['label']); ?>:</label>
    <input type="hidden" name="<?php print($parameter_name); ?>" value="<?php print(esc_attr( implode(';', $values) )); ?>" id="sopt-seek-<?php print($item_id); ?>" />
    <?php foreach($check_options as $key=>$val): ?>
        <input type="checkbox" onchange="tf_seek_update_hidden_check_<?php print(preg_replace('/[^a-z0-9]/iU', '_', $item_id)); ?>();" class="sopt-seek-<?php print($item_id); ?>" id="sopt-seek-<?php print($item_id); ?>-<?php print($key); ?>" value="<?php print($key); ?>" <?php print( (in_array( $key, $values ) ? 'checked="checked"' : '' ) ); ?> /> <label for="sopt-seek-<?php print($item_id); ?>-<?php print($key); ?>"><?php print($check_options[$key]['output']); ?><?php print( @$vars['show_counts'] ? ' ('.$check_options[$key]['count'].$vars['counts_label'].')' : '' ); ?></label>
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