<?php
/**
 * The template for displaying JCarousel Slider.
 * To override this template in a child theme, copy this file to your 
 * child theme's folder /theme_config/extensions/slider/designs/jcarousel/
 * 
 * If you want to change style or javascript of this slider, copy files to your 
 * child theme's folder /theme_config/extensions/slider/designs/jcarousel/static/
 * and change get_template_directory() with get_stylesheet_directory()
 */
/*$TFUSE->include->register_type('jcarousel_js_folder', get_template_directory() . '/theme_config/extensions/slider/designs/'.$slider['design'].'/static/js');
$TFUSE->include->js('jcarousel_opt', 'jcarousel_js_folder', 'tf_head',11);*/
wp_enqueue_script( 'jquery.jcarousel' );
$slider_options = array();
if (isset($slider['general']['slider_animation'])) $slider_options['animation'] = $slider['general']['slider_animation']; else $slider_options['animation'] = 600;
if (isset($slider['general']['slider_scroll'])) $slider_options['scroll'] = $slider['general']['slider_scroll']; else $slider_options['scroll'] = 1;
if (isset($slider['general']['slider_auto'])) $slider_options['auto'] = $slider['general']['slider_auto']; else $slider_options['auto'] = 0;
if (isset($slider['general']['slider_easing'])) $slider_options['easing'] = $slider['general']['slider_easing']; else $slider_options['easing'] = 'easeOutBack';
$slider_options['count'] = count($slider['slides']);

/*$TFUSE->include->js_enq('slider_options', $slider_options);*/
?>
<?php if ($slider['location'] == 'header') {?>
<div class="header_carusel">
    <?php }elseif($slider['location'] == 'before_content') {?>
<!-- carousel before content -->
<div class="before_content">
	<div class="container_12">
<?php }?>
    <strong class="carusel_title"><?php _e($slider['general']['slider_title'], 'tfuse');?></strong>

    <div class="carusel_list carusel_small">
        <ul id="latest_properties_<?php echo $slider['id'] . '_' . $slider['location']; ?>" class="jcarousel-skin-tango">
            <?php foreach ($slider['slides'] as $slide) : ?>
            <li>
                <div class="item_image"><a href="<?php if(!empty($slide['slide_link_url'])) { echo $slide['slide_link_url'];} else { echo '#'; } ?>" target="<?php echo $slide['slide_link_target']; ?>"><img src="<?php echo $slide['slide_src']; ?>" width="218" height="125" alt=""></a></div>
                <div class="item_name"><a href="<?php if(!empty($slide['slide_link_url'])) { echo $slide['slide_link_url'];} else { echo '#'; } ?>" target="<?php echo $slide['slide_link_target']; ?>"><?php echo $slide['slide_title']; ?></a></div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php if ($slider['location'] == 'header') {?>
</div>
    <?php }elseif($slider['location'] == 'before_content') {?>
    </div>
</div>
<?php }?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        function isNumber( input ) {
            return !isNaN( input );
        }
        var anim = 600;
        if (isNumber('<?php echo $slider_options['animation']; ?>'))
        {
            anim = parseInt(<?php echo $slider_options['animation']; ?>);
        } else
        {
            anim = '<?php echo $slider_options['animation']; ?>';
        }


            jQuery('#latest_properties_'+'<?php echo $slider['id'] . '_' . $slider['location']; ?>').jcarousel({
                <?php if($slider_options['count'] <= 4) echo 'buttonNextHTML: null,buttonPrevHTML: null,';?>
                easing: '<?php echo $slider_options['easing']; ?>',
                animation: anim,
                scroll: parseInt(<?php echo $slider_options['scroll']; ?>),
                auto: parseInt(<?php echo $slider_options['auto']; ?>)
            });



    });
</script>