<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

$sliders = array(
    1 => array(
        'settings' => $settings
    )
);

$items_options = TF_SEEK_HELPER::get_items_options();

if(isset($vars['listen_checkbox_id'])){ // support for double sliders, showing depends on checkbox
    if(!isset($items_options[$vars['listen_checkbox_id']])) die('Undefined item id "'.esc_attr($vars['listen_checkbox_id']).'" in "listen_checkbox_id" option');

    $listen_item = $items_options[$vars['listen_checkbox_id']];

    $sliders[2] = $sliders[1];
}

$row = (isset($vars['row']) && ($vars['row'])) ? ' row' : '';

foreach($sliders as $skey=>$sval){
    $settings = &$sliders[$skey]['settings'];

    do{
        if(@$settings['auto_options']){
            global $wpdb;

            $settings['auto_steps'] = intval(isset($settings['auto_steps']) ? $settings['auto_steps'] : 2);

            $append_sql_where = "";
            if(sizeof($sliders) > 1){ // if is double slider
                $_GET_backup = @$_GET[ $listen_item['parameter_name'] ];
                $_GET[ $listen_item['parameter_name'] ] = ($skey == 1 ? $listen_item['settings']['min'] : $listen_item['settings']['max']);

                $append_sql_where = TF_SEEK_SQL_GENERATORS::$listen_item['sql_generator']($vars['listen_checkbox_id'], $listen_item['parameter_name'], $listen_item['sql_generator_options'], $listen_item['settings'], $listen_item['template_vars'], $listen_item);
                $append_sql_where = ($append_sql_where['sql'] ? " AND ".$append_sql_where['sql'] : "");

                $_GET[ $listen_item['parameter_name'] ] = $_GET_backup;
                unset($_GET_backup);
            }

            $col_name   = trim($wpdb->prepare('%s', $sql_generator_options['search_on_id']), "'");
            $db_min_max = $wpdb->get_row( "SELECT
            MAX(". $col_name .") as max
                FROM ". trim($wpdb->prepare('%s', TF_SEEK_HELPER::get_db_table_name()), "'") ." options
            INNER JOIN " . $wpdb->prefix . "posts AS p ON p.ID = options.post_id
                WHERE p.post_status = 'publish' " . $append_sql_where . "
            LIMIT 1", ARRAY_A);

            if(!$db_min_max['max']) $db_min_max['max'] = $settings['to'];

            $db_min_max['min'] = 0; //...

            if($db_min_max['min'] == $db_min_max['max']) return;

            $diff = $db_min_max['max']-$db_min_max['min'];
            if($diff < $settings['auto_steps']) return;

            $round = pow(10,strlen(strval($db_min_max['max']))-1);
            if($db_min_max['max'] % $round){
                $db_min_max['max'] = $db_min_max['max'] + ($round-($db_min_max['max'] % $round));
            }

            $step_size = intval($settings['step']);

            $settings['from']   = $db_min_max['min'];
            $settings['to']     = $db_min_max['max'];

            if(!function_exists('__get_num_short_prefix_version')):
                function __get_num_short_prefix_version($num, $prefix = ''){
                    $num = intval($num);

                    if($num >= 1000000){
                        $nf     = number_format( ( $num / 1000000 ), 1, ',', '');
                        $nzu    = array_pop( explode(',', $nf) );
                        if($nzu == '0'){
                            $nzu = '';
                        } else{
                            $nzu = ''.intval($nzu);
                        }
                        $nf     = intval( array_shift(explode(',', $nf)) ). ($nzu ? ','.$nzu : '');
                        return $prefix.$nf . __('Mil', 'tfuse');
                    }

                    if($num >= 10000){
                        $n = intval( $num / 1000 );
                        /*if($n%10){
                            $n = $n + (10 - ($n%10));
                        }*/
                        return $prefix.$n . __('k', 'tfuse');
                    }

                    if($num >= 1000){
                        $n = $num / 100 ;
                        $n = round($n)/10;
                        return $prefix.$n . __('k', 'tfuse');
                    }

                    if($num >= 100){
                        $n = $num / 10 ;
                        $n = round($n)*10;
                        return $prefix.$n;
                    }

                    return $prefix.$num;
                }
            endif;

            $settings['scale']  = array();
            for($curr_step = 1; $curr_step <= $settings['auto_steps']; $curr_step++){
                if($curr_step == 1){
                    $settings['scale'][] = __get_num_short_prefix_version($db_min_max['min']);
                } elseif($curr_step == $settings['auto_steps']){
                    $settings['scale'][] = '|';
                    $settings['scale'][] = __get_num_short_prefix_version($db_min_max['max']);
                } else {
                    $settings['scale'][] = '|';
                    //$settings['scale'][] = __get_num_short_prefix_version($db_min_max['min'] + (($curr_step-1) * $step_size));
                    $settings['scale'][] = __get_num_short_prefix_version($db_min_max['min'] + ((($db_min_max['max'] - $db_min_max['min']) / ($settings['auto_steps']-1)) *($curr_step-1)));
                }
            }
        }
    }while(false);
}
unset($settings); // unset pointer
if(isset($vars['exclude_sopt_div']) && ($vars['exclude_sopt_div'] == 1)) $sopt_div = false; else $sopt_div = true;
?>
<?php if ($sopt_div) {?><div class="sopt_range_slider<?php echo $row; ?> rangeField"><?php } ?>
    <?php if(isset($vars['label'])): ?><label class="label_title" ><?php print esc_attr( $vars['label'] ); ?>:</label><?php endif; ?>
    <?php foreach($sliders as $skey=>$slider): ?>
        <?php $settings = $slider['settings']; ?>
        <div class="range-slider">
            <input id="sopt_seek_slider_range_<?php print esc_attr($item_id); ?>_<?php print $skey; ?>" class="soption_value sopt_range_slider_range" type="text" name="<?php print esc_attr($parameter_name); ?>" value="<?php print esc_attr( TF_SEEK_HELPER::get_input_value($parameter_name, $settings['from'].';'.$settings['to'] ) ); ?>" />
        </div>
    <?php endforeach; ?>
<div class="clear"></div>
<?php if ($sopt_div) {?> </div> <?php } ?>
<script type="text/javascript">
    jQuery(document).ready(function($) {

    <?php foreach($sliders as $skey=>$slider): ?>
        <?php $settings = $slider['settings']; ?>

        $("input#sopt_seek_slider_range_<?php print esc_attr($item_id); ?>_<?php print $skey; ?>").slider({
            from: <?php print $settings['from']; ?>,
            to: <?php print $settings['to']; ?>,
            scale: <?php print str_replace('\\/', '/', json_encode($settings['scale']) ); ?>,
            <?php if(isset($settings['heterogeneity'])): ?>
                heterogeneity: <?php print str_replace('\\/', '/', json_encode($settings['heterogeneity']) ); ?>,
            <?php endif; ?>
            limits: <?php print (@$settings['limits'] ? 'true' : 'false'); ?>,
            step: <?php print $step_size; ?>,
            smooth: <?php print (@$settings['smooth'] ? 'true' : 'false'); ?>,
            <?php if(isset($settings['dimension'])): ?>
                dimension: '<?php print $settings['dimension']; ?>',
            <?php endif; ?>
            skin: "<?php print @$settings['skin']; ?>"
        });

    <?php endforeach; ?>

    <?php if(sizeof($sliders) > 1): ?>
        $('input[name=<?php print esc_attr($listen_item['parameter_name']) ?>]').change(function(){
            if(!$(this).is(':checked')) return;

            var ival = parseInt($(this).val());
            if(ival === NaN) ival = <?php print intval($listen_item['settings']['min']); ?>;

            var isFirst = true;
            if(ival == <?php print intval($listen_item['settings']['max']); ?>){
                isFirst = false;
            }

            $("input#sopt_seek_slider_range_<?php print esc_attr($item_id); ?>_" + (isFirst ? 1 : 2))
                .attr('name', '<?php print esc_attr($parameter_name); ?>')
                .closest('.range-slider')
                .show();
            $("input#sopt_seek_slider_range_<?php print esc_attr($item_id); ?>_" + (isFirst ? 2 : 1))
                .attr('name', '')
                .closest('.range-slider')
                .hide();
        }).trigger('change');
    <?php endif; ?>

    });
</script>