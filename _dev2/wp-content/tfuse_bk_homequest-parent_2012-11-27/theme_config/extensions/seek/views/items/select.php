<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

$value = intval(TF_SEEK_HELPER::get_input_value($parameter_name));

?>
<?php if(isset($vars['label'])): ?>
    <label class="label_title"><?php print esc_attr( $vars['label'] ); ?>:</label>
<?php endif; ?>

<select class="select_styled" name="<?php print esc_attr($parameter_name); ?>" id="<?php print( isset($vars['id']) ? esc_attr( $vars['id'] ) : 'sopt_range_slider_range_'.esc_attr($item_id) ); ?>" title="<?php print(esc_attr( $vars['title'] )); ?>">
    <?php for( $i=$settings['min']; $i<=$settings['max']; $i++ ): ?><?php

        $i = intval($i);
        if($i != 0){
            $option_text = ($i<$settings['max'] ? (@$vars['min_prefix']).$i.' ' : $i.(@$vars['max_prefix']));
            if((@$vars['hide_option_name'])){
                $option_text .= '';
            } else {
                $option_text .= (isset($vars['option_name']) ? esc_attr( $vars['option_name'] ) : TF_SEEK_HELPER::get_property_pluralization_name($sql_generator_options['search_on_id'], $i, true));;
            }

        } else {
            $option_text = (isset($vars['option_name']) ? esc_attr( $vars['option_name'] ) : ( (@$vars['hide_option_name']) ? '---' : TF_SEEK_HELPER::get_property_pluralization_name($sql_generator_options['search_on_id'], 2, true)) );
        }

        ?><option value="<?php print((string)$i); ?>" <?php print( $value==$i ? 'selected="selected"' : '' ); ?> ><?php print $option_text; ?></option>
    <?php endfor; ?>
</select>
