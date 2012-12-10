<?php

add_action( 'wp_print_styles', 'tfuse_add_css' );
add_action( 'wp_print_scripts', 'tfuse_add_js' );

if ( ! function_exists( 'tfuse_add_css' ) ) :
/**
 * This function include files of css.
 */
    function tfuse_add_css()
    {
        $template_directory = get_template_directory_uri();

        $color_scheme = tfuse_options('color_scheme');

        switch($color_scheme)
        {
            case 'turquoisered':
                wp_register_style( 'turquoise-red', $template_directory.'/styles/turquoise-red.css', array(), false, 'screen' );
                wp_enqueue_style( 'turquoise-red' );
                break;
            case 'greenpink':
                wp_register_style( 'green-pink', $template_directory.'/styles/green-pink.css', array(), false, 'screen' );
                wp_enqueue_style( 'green-pink' );
                break;
            case 'orangeblue':
                wp_register_style( 'orange-blue', $template_directory.'/styles/orange-blue.css', array(), false, 'screen' );
                wp_enqueue_style( 'orange-blue' );
                break;
        }

        wp_register_style( 'cusel', $template_directory.'/css/cusel.css', array(), false );
        wp_enqueue_style( 'cusel' );

        wp_register_style( 'customInput', $template_directory.'/css/customInput.css', false, '0.1' );
        wp_enqueue_style( 'customInput' );

        wp_register_style( 'qtip', $template_directory.'/css/jquery.qtip.css', false, '2.0' );
        wp_enqueue_style( 'qtip' );

        wp_register_style( 'jslider', $template_directory.'/css/jslider.css', false, '0.1' );
        wp_enqueue_style( 'jslider' );

        wp_register_style( 'pikachoose', $template_directory.'/css/pikachoose.css', false, '0.1' );
        wp_enqueue_style( 'pikachoose' );

        wp_register_style( 'prettyPhoto', $template_directory.'/css/prettyPhoto.css', false, '3.1.3' );
        wp_enqueue_style( 'prettyPhoto' );

        wp_register_style( 'shCore', $template_directory.'/css/shCore.css', false, '2.1.382' );
        wp_enqueue_style( 'shCore' );

        wp_register_style( 'shThemeDefault', $template_directory.'/css/shThemeDefault.css', false, '2.1.382' );
        wp_enqueue_style( 'shThemeDefault' );

        wp_register_style( 'autocomplete', $template_directory.'/css/autocomplete.css', false, '0.1' );
        wp_enqueue_style( 'autocomplete' );

        wp_register_style( 'skin', $template_directory.'/images/skins/tango/skin.css', false, '0.2.8' );
        wp_enqueue_style( 'skin' );

        wp_register_style( 'custom', $template_directory.'/custom.css', false, '1.0.0' );
        wp_enqueue_style( 'custom' );

        $tfuse_browser_detect = tfuse_browser_body_class();

        if ( $tfuse_browser_detect[0] == 'ie7' )
            wp_enqueue_style('ie7-style', $template_directory.'/css/ie.css');
	}
endif;


if ( ! function_exists( 'tfuse_add_js' ) ) :
/**
 * This function include files of javascript.
 */
    function tfuse_add_js()
    {
        $template_directory = get_template_directory_uri();

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script('jquery-ui-autocomplete');

        wp_register_script( 'jquery.customInput', $template_directory.'/js/jquery.customInput.js', array('jquery'), '0.1', false );
        wp_enqueue_script( 'jquery.customInput' );

        wp_register_script( 'cusel-min', $template_directory.'/js/cusel-min.js', array('jquery'), '2.5', false );
        wp_enqueue_script( 'cusel-min' );

        // general.js can be overridden in a child theme by copying it in child theme's js folder
        wp_register_script( 'general', tfuse_get_file_uri('/js/general.js'), array('jquery'), '2.0', false );
        wp_enqueue_script( 'general' );

        wp_register_script( 'contactform', $template_directory.'/js/contactform.js', array('jquery'), '2.0', true );

        wp_register_script( 'jquery.dependClass', $template_directory.'/js/jquery.dependClass.js', array('jquery'), '0.1', true );
        wp_enqueue_script( 'jquery.dependClass' );

        wp_register_script( 'jquery.easing', $template_directory.'/js/jquery.easing.1.3.js', array('jquery'), '1.3', true );
        wp_enqueue_script( 'jquery.easing' );

        wp_register_script( 'jquery.easyListSplitter', $template_directory.'/js/jquery.easyListSplitter.min.js', array('jquery'), '1.0.2', true );
        wp_enqueue_script( 'jquery.easyListSplitter' );

        wp_register_script( 'jquery.gmap', $template_directory.'/js/jquery.gmap.min.js', array('jquery'), '3.2.0', true );
        wp_enqueue_script( 'jquery.gmap' );

        wp_register_script( 'jquery.jcarousel', $template_directory.'/js/jquery.jcarousel.min.js', array('jquery'), '0.1', true );
        wp_enqueue_script( 'jquery.jcarousel' );

        wp_register_script( 'jquery.mousewheel', $template_directory.'/js/jquery.mousewheel.js', array('jquery'), '3.0', true );
        wp_enqueue_script( 'jquery.mousewheel' );

        wp_register_script( 'jquery.pikachoose', $template_directory.'/js/jquery.pikachoose.js', array('jquery'), '0.1', true );
        wp_enqueue_script( 'jquery.pikachoose' );

        wp_register_script( 'jquery.preloadify', $template_directory.'/js/jquery.preloadify.min.js', array('jquery'), '0.1', true );
        wp_enqueue_script( 'jquery.preloadify' );

        wp_register_script( 'jquery.prettyPhoto', $template_directory.'/js/jquery.prettyPhoto.js', array('jquery'), '3.1.3', true );
        wp_enqueue_script( 'jquery.prettyPhoto' );

        wp_register_script( 'jquery.qtip', $template_directory.'/js/jquery.qtip.min.js', array('jquery'), '2.0', true );
        wp_enqueue_script( 'jquery.qtip' );

        wp_register_script( 'jquery.slider', $template_directory.'/js/jquery.slider-min.js', array('jquery'), '0.1', true );
        wp_enqueue_script( 'jquery.slider' );

        wp_register_script( 'jquery.tools', $template_directory.'/js/jquery.tools.min.js', array('jquery'), '1.2.6', true );
        wp_enqueue_script( 'jquery.tools' );

        wp_register_script( 'jScrollPane', $template_directory.'/js/jScrollPane.js', array('jquery'), '0.1', true );
        wp_enqueue_script( 'jScrollPane' );

        wp_register_script( 'shCore', $template_directory.'/js/shCore.js', array('jquery'), '2.1.382', true );
        wp_enqueue_script( 'shCore' );

        wp_register_script( 'shBrushPlain', $template_directory.'/js/shBrushPlain.js', array('jquery'), '2.1.382', true );
        wp_enqueue_script( 'shBrushPlain' );

        wp_register_script( 'slides.jquery', $template_directory.'/js/slides.min.jquery.js', array('jquery'), '1.1.9', false );
        wp_enqueue_script( 'slides.jquery' );

        if ( !tfuse_options('disable_preload_css') )
        {
            wp_register_script( 'preloadCssImages', $template_directory.'/js/preloadCssImages.js', array('jquery'), '5.0', true );
            wp_enqueue_script( 'preloadCssImages' );
        }





    }
endif;
