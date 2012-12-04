<?php
/**
 * The template for displaying SlidesJS Slider.
 * To override this template in a child theme, copy this file to your
 * child theme's folder /theme_config/extensions/slider/designs/slidesjs/
 *
 * If you want to change style or javascript of this slider, copy files to your
 * child theme's folder /theme_config/extensions/slider/designs/slidesjs/static/
 * and change get_template_directory() with get_stylesheet_directory()
 */
//wp_enqueue_script( 'slides.jquery' );
//wp_enqueue_script( 'jquery.easing' );

$TFUSE->include->register_type('slides_js_folder', get_template_directory() . '/theme_config/extensions/slider/designs/'.$slider['design'].'/static/js');
$TFUSE->include->js('slidesjs_opt', 'slides_js_folder', 'tf_head',11);

$slider_options = array();
if (isset($slider['general']['slider_randomize'])) $slider_options['randomize'] = true; else $slider_options['randomize'] = false;
if (isset($slider['general']['slider_play'])) $slider_options['play'] = $slider['general']['slider_play']; else $slider_options['play'] = 7000;
if (isset($slider['general']['slider_pause'])) $slider_options['pause'] = $slider['general']['slider_pause']; else $slider_options['pause'] = 7000;
if (isset($slider['general']['slider_hoverPause'])) $slider_options['hoverPause'] = true; else $slider_options['hoverPause'] = false;
if (isset($slider['general']['slider_slideSpeed'])) $slider_options['slideSpeed'] = $slider['general']['slider_slideSpeed']; else $slider_options['slideSpeed'] = 700;
if (isset($slider['general']['slider_slideEasing'])) $slider_options['slideEasing'] = $slider['general']['slider_slideEasing']; else $slider_options['slideEasing'] = 'easeInOutExpo';
if (isset($slider['general']['slider_hideCaption'])) $slider_options['hideCaption'] = true; else $slider_options['hideCaption'] = false;
if (isset($slider['general']['slider_hideSpeed'])) $slider_options['hideSpeed'] =$slider['general']['slider_hideSpeed']; else $slider_options['hideSpeed'] = 58;

$TFUSE->include->js_enq('slides_options', $slider_options);
?>
<div class="header_slider">
    <span class="slider_ribbon"></span>
    <div class="slides_container">
        <?php foreach ($slider['slides'] as $slide) : ?>
        <div class="slide">
            <a href="<?php if(!empty($slide['slide_link_url'])) { echo $slide['slide_link_url'];} else { echo '#'; } ?>" target="<?php echo $slide['slide_link_target']; ?>"><img src="<?php echo $slide['slide_src']; ?>" width="645" height="407" alt=""></a>
            <div class="caption"><p><?php echo $slide['slide_title']; ?></p></div>
        </div>
        <?php endforeach; ?>
    </div>

</div>
