

jQuery(document).ready(function($) {
    var anim = 600;
    if (isNumber(tf_script.slider_options.animation))
    {
         anim = parseInt(tf_script.slider_options.animation);
    } else
    {
         anim = tf_script.slider_options.animation;
    }

    if(tf_script.slider_options.count <= 4)
    {
        jQuery('#latest_properties_'+tf_script.slider_options.id).jcarousel({
            buttonNextHTML: null,
            buttonPrevHTML: null,
            easing: (String(tf_script.slider_options.easing)),
            animation: anim,
            scroll: parseInt(tf_script.slider_options.scroll),
            auto: parseInt(tf_script.slider_options.auto),
            rtl: tf_script.slider_options.rtl
        });
    }
    else
    {
        jQuery('#latest_properties_'+tf_script.slider_options.id).jcarousel({
            easing: (String(tf_script.slider_options.easing)),
            animation: anim,
            scroll: parseInt(tf_script.slider_options.scroll),
            auto: parseInt(tf_script.slider_options.auto),
            rtl: tf_script.slider_options.rtl
        });
    }

});