jQuery(document).ready(function($) {

    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }

    jQuery('#taxonomy-property_locations input:checkbox').bind('change', function(e){
       var term_id = jQuery(this).attr("value");
       if (jQuery(this).is(':checked'))
       {
           jQuery.ajax({
               type: "POST",
               url: tf_script.ajaxurl,
               data: "action=tfuse_ajax_get_parents&id=" + term_id,
               success: function(msg){
                   var obj = jQuery.parseJSON(msg);
                   var msg_array = jQuery.makeArray( obj );
                   jQuery('#taxonomy-property_locations input:checkbox').each(function()
                   {
                       if(inArray(jQuery(this).attr("value"),msg_array)) jQuery(this).attr("checked","true");

                   });
               }
           });
       }
       else
       {
           jQuery.ajax({
               type: "POST",
               url: tf_script.ajaxurl,
               data: "action=tfuse_ajax_get_childs&id=" + term_id,
               success: function(msg){
                   var obj = jQuery.parseJSON(msg);
                   var msg_array = jQuery.makeArray( obj );
                   jQuery('#taxonomy-property_locations input:checkbox').each(function()
                   {
                       if(inArray(jQuery(this).attr("value"),msg_array)) jQuery(this).removeAttr("checked");

                   });
               }
           });
       }

    });

    jQuery("#slider_pause, #slider_play, #slider_slideSpeed, #slider_hideSpeed").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });

    $('#homequest_framework_options_metabox .handlediv, #homequest_framework_options_metabox .hndle').hide();
    $('#homequest_framework_options_metabox .handlediv, #homequest_framework_options_metabox .hndle').hide();
    var after_content = jQuery('#homequest_after_content_element, #homequest_before_page_content').length;
    var options = new Array();

    options['homequest_header_element'] = jQuery('#homequest_header_element').val();
    jQuery('#homequest_header_element').bind('change', function() {
        options['homequest_header_element'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['homequest_before_content_element'] = jQuery('#homequest_before_content_element').val();
    jQuery('#homequest_before_content_element').bind('change', function() {
        options['homequest_before_content_element'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['homequest_page_title'] = jQuery('#homequest_page_title').val();
    jQuery('#homequest_page_title').bind('change', function() {
        options['homequest_page_title'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });


    options['slider_hoverPause'] = jQuery('#slider_hoverPause').val();
    jQuery('#slider_hoverPause').bind('change', function() {
        if (jQuery(this).next('.tf_checkbox_switch').hasClass('on'))  options['slider_hoverPause']= true;
        else  options['slider_hoverPause'] = false;
        tfuse_toggle_options(options);
    });

    options['slider_hideCaption'] = jQuery('#slider_hideCaption').val();
    jQuery('#slider_hideCaption').bind('change', function() {
        if (jQuery(this).next('.tf_checkbox_switch').hasClass('on'))  options['slider_hideCaption']= true;
        else  options['slider_hideCaption'] = false;
        tfuse_toggle_options(options);
    });

    tfuse_toggle_options(options);

    function tfuse_toggle_options(options)
    {

        jQuery('#homequest_custom_title, #homequest_search_type, #homequest_select_search_slider, #homequest_select_slider, #homequest_before_content_select_slider, #homequest_properties_number,#homequest_page_map').parents('.option-inner').hide();jQuery('#homequest_custom_title, #homequest_search_type, #homequest_select_search_slider, #homequest_select_slider, #homequest_before_content_select_slider, #homequest_properties_number,#homequest_page_map, #homequest_header_element, #homequest_before_content_element').parent().parent().parent().next().removeClass('divider');
        jQuery('#homequest_custom_title, #homequest_search_type, #homequest_select_search_slider, #homequest_select_slider, #homequest_before_content_select_slider, #homequest_properties_number,#homequest_page_map').parents('.form-field').hide();

        switch (options['homequest_header_element'])
        {
            case 'search' :
                jQuery('#homequest_search_type').parents('.option-inner').show();
                jQuery('#homequest_search_type').parents('.form-field').show();
                jQuery('#homequest_search_type').parent().parent().parent().next().addClass('divider');
                break;

            case 'search_slider' :

                jQuery('#homequest_select_search_slider').parents('.option-inner').show();
                jQuery('#homequest_select_search_slider').parents('.form-field').show();
                jQuery('#homequest_select_search_slider').parent().parent().parent().next().addClass('divider');
                break;

            case 'slider' :
                jQuery('#homequest_select_slider').parents('.option-inner').show();
                jQuery('#homequest_select_slider').parents('.form-field').show();
                jQuery('#homequest_select_slider').parent().parent().parent().next().addClass('divider');
                break;
            default :
                jQuery('#homequest_header_element').parent().parent().parent().next().addClass('divider');
        }

        switch (options['homequest_before_content_element'])
        {
            case 'slider' :
                jQuery('#homequest_before_content_select_slider').parents('.option-inner').show();
                jQuery('#homequest_before_content_select_slider').parents('.form-field').show();
                if (after_content) jQuery('#homequest_before_content_select_slider').parent().parent().parent().next().addClass('divider');
                break;
            case 'latest_added' :
                jQuery('#homequest_properties_number').parents('.option-inner').show();
                jQuery('#homequest_properties_number').parents('.form-field').show();
                if (after_content) jQuery('#homequest_properties_number').parent().next().addClass('divider');
                break;
            case 'map' :
                jQuery('#homequest_page_map').parents('.option-inner').show();
                jQuery('#homequest_page_map').parents('.form-field').show();
                if(jQuery('#homequest_before_page_content').length ) jQuery('#homequest_page_map').parent().parent().parent().next().addClass('divider');
                if (after_content) jQuery('#homequest_before_content_element').parent().parent().parent().next().addClass('divider');
                break;
            default :
                if (after_content) jQuery('#homequest_before_content_element').parent().parent().parent().next().addClass('divider');
        }

        if(options['homequest_page_title'] == 'custom_title')
        {
            jQuery('#homequest_custom_title').parents('.option-inner').show();
            jQuery('#homequest_custom_title').parents('.form-field').show();
        }

        if (options['slider_hoverPause'])
        {
            jQuery('.slider_pause').show();
            jQuery('.slider_pause').next('.tfclear').show();
        }
        else
        {
            jQuery('.slider_pause').hide();
            jQuery('.slider_pause').next('.tfclear').hide();
        }

        if (options['slider_hideCaption'])
        {
            jQuery('.slider_hideSpeed').show();
            jQuery('.slider_hideSpeed').next('.tfclear').show();
        }
        else
        {
            jQuery('.slider_hideSpeed').hide();
            jQuery('.slider_hideSpeed').next('.tfclear').hide();
        }
    }

    if(jQuery('.slider_image_preview').attr('value') == 'jcarousel')
    {
       jQuery('#slider_scroll').attr('maxlength',2);
       jQuery('#slider_animation').attr('maxlength',5);
       jQuery('#slider_auto').attr('maxlength',5);
    }
    if(jQuery('.slider_image_preview').attr('value') == 'slidesjs')
    {
        jQuery('#slider_hideSpeed').attr('maxlength',3);

    }

});