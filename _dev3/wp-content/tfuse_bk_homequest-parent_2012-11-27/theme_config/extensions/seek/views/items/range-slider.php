<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

$row = (isset($vars['row']) && ($vars['row'])) ? ' row' : '';
?><div class="sopt_range_slider<?php echo $row; ?> rangeField">
    <?php if(isset($vars['label'])): ?><label class="label_title" ><?php print esc_attr( $vars['label'] ); ?>:</label><?php endif; ?>
    <div class="range-slider">
        <input id="sopt_seek_slider_range_<?php print esc_attr($item_id); ?>" class="soption_value sopt_range_slider_range" type="text" name="<?php print esc_attr($parameter_name); ?>" value="<?php print esc_attr( TF_SEEK_HELPER::get_input_value($parameter_name, $settings['from'].';'.$settings['to'] ) ); ?>" />
    </div>
</div>
<div class="clear"></div>

<script type="text/javascript">
    jQuery(document).ready(function($) {

        $("input#sopt_seek_slider_range_<?php print esc_attr($item_id); ?>").slider({
            from: <?php print $settings['from']; ?>,
            to: <?php print $settings['to']; ?>,
            scale: <?php print str_replace('\\/', '/', json_encode($settings['scale']) ); ?>,
            <?php if(isset($settings['heterogeneity'])): ?>
                heterogeneity: <?php print str_replace('\\/', '/', json_encode($settings['heterogeneity']) ); ?>,
            <?php endif; ?>
            limits: <?php print ($settings['limits'] ? 'true' : 'false'); ?>,
            step: <?php print $settings['step']; ?>,
            smooth: <?php print ($settings['smooth'] ? 'true' : 'false'); ?>,
            <?php if(isset($settings['dimension'])): ?>
                dimension: '<?php print $settings['dimension']; ?>',
            <?php endif; ?>
            skin: "<?php print $settings['skin']; ?>"
        });
    });
</script>