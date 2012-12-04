<?php
$input_value    = TF_SEEK_HELPER::get_input_value($parameter_name,'');
$input_values   = explode(';', $input_value);
if(sizeof($input_values)){
    $tmp = array();
    foreach($input_values as $value){
        if(is_numeric($value)){
            $tmp[] = intval($value);
        }
    }
    $input_values = $tmp;
}

$all_items      = TF_SEEK_HELPER::get_items_options();
if(!isset($all_items[ @$settings['parent_item_id'] ])){
    echo 'Wrong "parent_item_id" supplied in settings options for item with id = '.$item_id;
    return;
}

$parent_item        = $all_items[ $settings['parent_item_id'] ];
$parent_input_value = intval(TF_SEEK_HELPER::get_input_value($parent_item['parameter_name'],''));

$parent_list        = get_terms($parent_item['sql_generator_options']['search_on_id'], 'hide_empty=0&fields=ids&parent='.$parent_item['settings']['select_parent']);

if(!sizeof($parent_list)) return;

if(!in_array($parent_input_value, $parent_list)) return;

if(!isset($vars['label'])){
    $vars['label'] = $parent_item['template_vars']['label'];
}

$list = get_terms($parent_item['sql_generator_options']['search_on_id'], 'hide_empty=0&child_of='.$parent_input_value);

if(!sizeof($list)) return;

$valid_hidden   = array();
$select         = array();
foreach($list as $term){
    if(in_array($term->term_id, $input_values)){
        $valid_hidden[] = $term->term_id;
    }

    $select[$term->term_id] = array(
        'name'      => $term->name,
        'checked'   => in_array($term->term_id, $input_values)
    );
}

?>
<div class="row input_styled checklist">
    <label class="label_title"><?php print($vars['label']); ?>:</label>
    <input type="hidden" name="<?php print($parameter_name); ?>" value="<?php print( implode(';', $valid_hidden) ); ?>" id="sopt-seek-<?php print($item_id); ?>" />
    <?php foreach($select as $option_id=>$option): ?>
        <input type="checkbox" onchange="tf_seek_update_hidden_check_<?php print(preg_replace('/[^a-z0-9]/iU', '_', $item_id)); ?>();" class="sopt-seek-<?php print($item_id); ?>" id="sopt-seek-<?php print($item_id); ?>-<?php print $option_id; ?>" value="<?php print $option_id; ?>" <?php print($option['checked'] ? 'checked' : '') ?> /> <label for="sopt-seek-<?php print($item_id); ?>-<?php print($option_id); ?>"><?php print esc_attr($option['name']); ?></label>
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