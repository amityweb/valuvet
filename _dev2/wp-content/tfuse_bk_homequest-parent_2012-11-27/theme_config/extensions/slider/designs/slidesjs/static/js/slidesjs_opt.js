function isNumber( input ) {
    return !isNaN( input );
}
jQuery(document).ready(function() {
    var slSpeed = 350;
    var hideSpeed = 58;
    if (isNumber(parseInt(tf_script.slides_options.slideSpeed)))
    {
         slSpeed = parseInt(tf_script.slides_options.slideSpeed);
    }


    if (isNumber(parseInt(tf_script.slides_options.hideSpeed)))
    {
         hideSpeed = parseInt(tf_script.slides_options.hideSpeed);
    }


    hideSpeed = hideSpeed / 100;

    if (tf_script.slides_options.hideCaption)
    {
        jQuery('.header_slider').slides({

            slideSpeed: slSpeed,
            slideEasing: tf_script.slides_options.slideEasing,
            randomize: tf_script.slides_options.randomize,
            play: parseInt(tf_script.slides_options.play),
            hoverPause: tf_script.slides_options.hoverPause,
            pause: parseInt(tf_script.slides_options.pause),
            animationStart: function(current){
                jQuery('.caption').animate({
                    bottom:-90
                },slSpeed * hideSpeed);
            },
            animationComplete: function(current){
                jQuery('.caption').animate({
                    bottom:0
                },slSpeed * hideSpeed);
            },
            slidesLoaded: function() {
                jQuery('.caption').animate({
                    bottom:0
                },slSpeed * hideSpeed);
            }
        });
    }
    else
    {
        jQuery('.header_slider').slides({
            slideSpeed: slSpeed,
            slideEasing: tf_script.slides_options.slideEasing,
            randomize: tf_script.slides_options.randomize,
            play: parseInt(tf_script.slides_options.play),
            hoverPause: tf_script.slides_options.hoverPause,
            pause: parseInt(tf_script.slides_options.pause)
        });
    }

});