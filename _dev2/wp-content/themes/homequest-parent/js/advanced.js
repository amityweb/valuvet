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

    /*404*/
    options['homequest_header_element_404'] = jQuery('#homequest_header_element_404').val();
    jQuery('#homequest_header_element_404').bind('change', function() {
        options['homequest_header_element_404'] = jQuery(this).val();
        tfuse_toggle_options_404(options);
    });

    options['homequest_before_content_element_404'] = jQuery('#homequest_before_content_element_404').val();
    jQuery('#homequest_before_content_element_404').bind('change', function() {
        options['homequest_before_content_element_404'] = jQuery(this).val();
        tfuse_toggle_options_404(options);
    });

    tfuse_toggle_options_404 (options);

    function tfuse_toggle_options_404 (options)
    {
        jQuery('#homequest_search_type_404, #homequest_select_search_slider_404, #homequest_select_slider_404, #homequest_before_content_select_slider_404, #homequest_properties_number_404,#homequest_page_map_404').parents('.option-inner').hide();jQuery('#homequest_search_type_404, #homequest_select_search_slider_404, #homequest_select_slider_404, #homequest_before_content_select_slider_404, #homequest_properties_number_404,#homequest_page_map_404, #homequest_header_element_404, #homequest_before_content_element_404').parent().parent().parent().next().removeClass('divider');
        jQuery('#homequest_search_type_404, #homequest_select_search_slider_404, #homequest_select_slider_404, #homequest_before_content_select_slider_404, #homequest_properties_number_404,#homequest_page_map_404').parents('.form-field').hide();

        switch (options['homequest_header_element_404'])
        {
            case 'search' :
                jQuery('#homequest_search_type_404').parents('.option-inner').show();
                jQuery('#homequest_search_type_404').parents('.form-field').show();
                jQuery('#homequest_search_type_404').parent().parent().parent().next().addClass('divider');
                break;

            case 'search_slider' :

                jQuery('#homequest_select_search_slider_404').parents('.option-inner').show();
                jQuery('#homequest_select_search_slider_404').parents('.form-field').show();
                jQuery('#homequest_select_search_slider_404').parent().parent().parent().next().addClass('divider');
                break;

            case 'slider' :
                jQuery('#homequest_select_slider_404').parents('.option-inner').show();
                jQuery('#homequest_select_slider_404').parents('.form-field').show();
                jQuery('#homequest_select_slider_404').parent().parent().parent().next().addClass('divider');
                break;
            default :
                jQuery('#homequest_header_element_404').parent().parent().parent().next().addClass('divider');
        }

        switch (options['homequest_before_content_element_404'])
        {
            case 'slider' :
                jQuery('#homequest_before_content_select_slider_404').parents('.option-inner').show();
                jQuery('#homequest_before_content_select_slider_404').parents('.form-field').show();
                break;
            case 'latest_added' :
                jQuery('#homequest_properties_number_404').parents('.option-inner').show();
                jQuery('#homequest_properties_number_404').parents('.form-field').show();
                break;
            case 'map' :
                jQuery('#homequest_page_map_404').parents('.option-inner').show();
                jQuery('#homequest_page_map_404').parents('.form-field').show();
                break;
        }
    }
    /*End 404*/

    /*Search*/
    options['homequest_header_element_search'] = jQuery('#homequest_header_element_search').val();
    jQuery('#homequest_header_element_search').bind('change', function() {
        options['homequest_header_element_search'] = jQuery(this).val();
        tfuse_toggle_options_search(options);
    });

    options['homequest_before_content_element_search'] = jQuery('#homequest_before_content_element_search').val();
    jQuery('#homequest_before_content_element_search').bind('change', function() {
        options['homequest_before_content_element_search'] = jQuery(this).val();
        tfuse_toggle_options_search(options);
    });

    tfuse_toggle_options_search (options);

    function tfuse_toggle_options_search (options)
    {
        jQuery('#homequest_search_type_search, #homequest_select_search_slider_search, #homequest_select_slider_search, #homequest_before_content_select_slider_search, #homequest_properties_number_search,#homequest_page_map_search').parents('.option-inner').hide();jQuery('#homequest_search_type_search, #homequest_select_search_slider_search, #homequest_select_slider_search, #homequest_before_content_select_slider_search, #homequest_properties_number_search,#homequest_page_map_search, #homequest_header_element_search, #homequest_before_content_element_search').parent().parent().parent().next().removeClass('divider');
        jQuery('#homequest_search_type_search, #homequest_select_search_slider_search, #homequest_select_slider_search, #homequest_before_content_select_slider_search, #homequest_properties_number_search,#homequest_page_map_search').parents('.form-field').hide();

        switch (options['homequest_header_element_search'])
        {
            case 'search' :
                jQuery('#homequest_search_type_search').parents('.option-inner').show();
                jQuery('#homequest_search_type_search').parents('.form-field').show();
                jQuery('#homequest_search_type_search').parent().parent().parent().next().addClass('divider');
                break;

            case 'search_slider' :

                jQuery('#homequest_select_search_slider_search').parents('.option-inner').show();
                jQuery('#homequest_select_search_slider_search').parents('.form-field').show();
                jQuery('#homequest_select_search_slider_search').parent().parent().parent().next().addClass('divider');
                break;

            case 'slider' :
                jQuery('#homequest_select_slider_search').parents('.option-inner').show();
                jQuery('#homequest_select_slider_search').parents('.form-field').show();
                jQuery('#homequest_select_slider_search').parent().parent().parent().next().addClass('divider');
                break;
            default :
                jQuery('#homequest_header_element_search').parent().parent().parent().next().addClass('divider');
        }

        switch (options['homequest_before_content_element_search'])
        {
            case 'slider' :
                jQuery('#homequest_before_content_select_slider_search').parents('.option-inner').show();
                jQuery('#homequest_before_content_select_slider_search').parents('.form-field').show();
                break;
            case 'latest_added' :
                jQuery('#homequest_properties_number_search').parents('.option-inner').show();
                jQuery('#homequest_properties_number_search').parents('.form-field').show();
                break;
            case 'map' :
                jQuery('#homequest_page_map_search').parents('.option-inner').show();
                jQuery('#homequest_page_map_search').parents('.form-field').show();
                break;
        }
    }
    /*End Search*/

    /*Tag*/
    options['homequest_header_element_tag'] = jQuery('#homequest_header_element_tag').val();
    jQuery('#homequest_header_element_tag').bind('change', function() {
        options['homequest_header_element_tag'] = jQuery(this).val();
        tfuse_toggle_options_tag(options);
    });

    options['homequest_before_content_element_tag'] = jQuery('#homequest_before_content_element_tag').val();
    jQuery('#homequest_before_content_element_tag').bind('change', function() {
        options['homequest_before_content_element_tag'] = jQuery(this).val();
        tfuse_toggle_options_tag(options);
    });

    tfuse_toggle_options_tag (options);

    function tfuse_toggle_options_tag (options)
    {
        jQuery('#homequest_search_type_tag, #homequest_select_search_slider_tag, #homequest_select_slider_tag, #homequest_before_content_select_slider_tag, #homequest_properties_number_tag,#homequest_page_map_tag').parents('.option-inner').hide();jQuery('#homequest_search_type_tag, #homequest_select_search_slider_tag, #homequest_select_slider_tag, #homequest_before_content_select_slider_tag, #homequest_properties_number_tag,#homequest_page_map_tag, #homequest_header_element_tag, #homequest_before_content_element_tag').parent().parent().parent().next().removeClass('divider');
        jQuery('#homequest_search_type_tag, #homequest_select_search_slider_tag, #homequest_select_slider_tag, #homequest_before_content_select_slider_tag, #homequest_properties_number_tag,#homequest_page_map_tag').parents('.form-field').hide();

        switch (options['homequest_header_element_tag'])
        {
            case 'search' :
                jQuery('#homequest_search_type_tag').parents('.option-inner').show();
                jQuery('#homequest_search_type_tag').parents('.form-field').show();
                jQuery('#homequest_search_type_tag').parent().parent().parent().next().addClass('divider');
                break;

            case 'search_slider' :

                jQuery('#homequest_select_search_slider_tag').parents('.option-inner').show();
                jQuery('#homequest_select_search_slider_tag').parents('.form-field').show();
                jQuery('#homequest_select_search_slider_tag').parent().parent().parent().next().addClass('divider');
                break;

            case 'slider' :
                jQuery('#homequest_select_slider_tag').parents('.option-inner').show();
                jQuery('#homequest_select_slider_tag').parents('.form-field').show();
                jQuery('#homequest_select_slider_tag').parent().parent().parent().next().addClass('divider');
                break;
            default :
                jQuery('#homequest_header_element_tag').parent().parent().parent().next().addClass('divider');
        }

        switch (options['homequest_before_content_element_tag'])
        {
            case 'slider' :
                jQuery('#homequest_before_content_select_slider_tag').parents('.option-inner').show();
                jQuery('#homequest_before_content_select_slider_tag').parents('.form-field').show();
                break;
            case 'latest_added' :
                jQuery('#homequest_properties_number_tag').parents('.option-inner').show();
                jQuery('#homequest_properties_number_tag').parents('.form-field').show();
                break;
            case 'map' :
                jQuery('#homequest_page_map_tag').parents('.option-inner').show();
                jQuery('#homequest_page_map_tag').parents('.form-field').show();
                break;
        }
    }
    /*End Tag*/

    /*Author*/
    options['homequest_header_element_author'] = jQuery('#homequest_header_element_author').val();
    jQuery('#homequest_header_element_author').bind('change', function() {
        options['homequest_header_element_author'] = jQuery(this).val();
        tfuse_toggle_options_author(options);
    });

    options['homequest_before_content_element_author'] = jQuery('#homequest_before_content_element_author').val();
    jQuery('#homequest_before_content_element_author').bind('change', function() {
        options['homequest_before_content_element_author'] = jQuery(this).val();
        tfuse_toggle_options_author(options);
    });

    tfuse_toggle_options_author (options);

    function tfuse_toggle_options_author (options)
    {
        jQuery('#homequest_search_type_author, #homequest_select_search_slider_author, #homequest_select_slider_author, #homequest_before_content_select_slider_author, #homequest_properties_number_author,#homequest_page_map_author').parents('.option-inner').hide();jQuery('#homequest_search_type_author, #homequest_select_search_slider_author, #homequest_select_slider_author, #homequest_before_content_select_slider_author, #homequest_properties_number_author,#homequest_page_map_author, #homequest_header_element_author, #homequest_before_content_element_author').parent().parent().parent().next().removeClass('divider');
        jQuery('#homequest_search_type_author, #homequest_select_search_slider_author, #homequest_select_slider_author, #homequest_before_content_select_slider_author, #homequest_properties_number_author,#homequest_page_map_author').parents('.form-field').hide();

        switch (options['homequest_header_element_author'])
        {
            case 'search' :
                jQuery('#homequest_search_type_author').parents('.option-inner').show();
                jQuery('#homequest_search_type_author').parents('.form-field').show();
                jQuery('#homequest_search_type_author').parent().parent().parent().next().addClass('divider');
                break;

            case 'search_slider' :

                jQuery('#homequest_select_search_slider_author').parents('.option-inner').show();
                jQuery('#homequest_select_search_slider_author').parents('.form-field').show();
                jQuery('#homequest_select_search_slider_author').parent().parent().parent().next().addClass('divider');
                break;

            case 'slider' :
                jQuery('#homequest_select_slider_author').parents('.option-inner').show();
                jQuery('#homequest_select_slider_author').parents('.form-field').show();
                jQuery('#homequest_select_slider_author').parent().parent().parent().next().addClass('divider');
                break;
            default :
                jQuery('#homequest_header_element_author').parent().parent().parent().next().addClass('divider');
        }

        switch (options['homequest_before_content_element_author'])
        {
            case 'slider' :
                jQuery('#homequest_before_content_select_slider_author').parents('.option-inner').show();
                jQuery('#homequest_before_content_select_slider_author').parents('.form-field').show();
                break;
            case 'latest_added' :
                jQuery('#homequest_properties_number_author').parents('.option-inner').show();
                jQuery('#homequest_properties_number_author').parents('.form-field').show();
                break;
            case 'map' :
                jQuery('#homequest_page_map_author').parents('.option-inner').show();
                jQuery('#homequest_page_map_author').parents('.form-field').show();
                break;
        }
    }
    /*End Author*/

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

    options['homequest_homepage_category'] = jQuery('#homequest_homepage_category option:selected').val();
    jQuery('#homequest_homepage_category').bind('change', function() {
        options['homequest_homepage_category'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['homequest_template'] = jQuery('#homequest_template option:selected').val();
    jQuery('#homequest_template').bind('change', function() {
        options['homequest_template'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['homequest_blogpage_category'] = jQuery('#homequest_blogpage_category option:selected').val();
    jQuery('#homequest_blogpage_category').bind('change', function() {
        options['homequest_blogpage_category'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['homequest_header_element_blog'] = jQuery('#homequest_header_element_blog option:selected').val();
    jQuery('#homequest_header_element_blog').bind('change', function() {
        options['homequest_header_element_blog'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['homequest_before_content_element_blog'] = jQuery('#homequest_before_content_element_blog option:selected').val();
    jQuery('#homequest_before_content_element_blog').bind('change', function() {
        options['homequest_before_content_element_blog'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['page_template'] = jQuery('#page_template option:selected').val();
    jQuery('#page_template').bind('change', function() {
        options['page_template'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    tfuse_toggle_options(options);

    function tfuse_toggle_options(options)
    {

        jQuery('#homequest_custom_title, #homequest_search_type, #homequest_select_search_slider, #homequest_select_slider, #homequest_before_content_select_slider, #homequest_properties_number,#homequest_page_map').parents('.option-inner').hide();jQuery('#homequest_custom_title, #homequest_search_type, #homequest_select_search_slider, #homequest_select_slider, #homequest_before_content_select_slider, #homequest_properties_number,#homequest_page_map, #homequest_header_element, #homequest_before_content_element').parent().parent().parent().next().removeClass('divider');
        jQuery('#homequest_custom_title, #homequest_search_type, #homequest_select_search_slider, #homequest_select_slider, #homequest_before_content_select_slider, #homequest_properties_number,#homequest_page_map').parents('.form-field').hide();

        if(options['page_template']=='default'){
            jQuery('.homequest_content_bottom').show();
            jQuery('.homequest_before_page_content').hide();
        }
        else{
            jQuery('.homequest_before_page_content').show();
            jQuery('.homequest_content_bottom').hide();
        }

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
                jQuery('.homequest_before_content_select_slider').next().hide();
                break;
            case 'latest_added' :
                jQuery('#homequest_properties_number').parents('.option-inner').show();
                jQuery('#homequest_properties_number').parents('.form-field').show();
                if (after_content) jQuery('#homequest_properties_number').parent().next().addClass('divider');
                jQuery('#homequest_properties_number').parent().next().hide();
                break;
            case 'map' :
                jQuery('#homequest_page_map').parents('.option-inner').show();
                jQuery('#homequest_page_map').parents('.form-field').show();
                if(jQuery('#homequest_before_page_content').length ) jQuery('#homequest_page_map').parent().parent().parent().next().addClass('divider');
                if (after_content) jQuery('#homequest_before_content_element').parent().parent().parent().next().addClass('divider');
                jQuery('.homequest_page_map').next().hide();
                break;
            default :
                if (after_content) jQuery('#homequest_before_content_element').parent().parent().parent().next().addClass('divider');
                jQuery('.homequest_before_content_element').next().hide();
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

        if(options['homequest_homepage_category']=='all'){
            jQuery('.homequest_use_page_options,.homequest_categories_select_categ,.homequest_home_page,.homequest_template,.homequest_content_bottom,.homequest_before_page_content').hide();
            jQuery('#homepage-header,#homepage-shortcodes').show();
        }
        else if(options['homequest_homepage_category']=='specific'){
            jQuery('.homequest_use_page_options,.homequest_home_page,.homequest_template,.homequest_content_bottom,.homequest_before_page_content').hide();
            jQuery('#homepage-header,#homepage-shortcodes,.homequest_categories_select_categ').show();
        }
        else if(options['homequest_homepage_category']=='page'){
            jQuery('.homequest_use_page_options,.homequest_home_page,.homequest_template,.homequest_content_bottom,.homequest_before_page_content').show();
            jQuery('.homequest_categories_select_categ').hide();
            if(options['homequest_template']=='home'){
                jQuery('.homequest_before_page_content').show();
                jQuery('.homequest_content_bottom').hide();
                jQuery('.homequest_before_page_content').next().hide();
            }
            else{
                jQuery('.homequest_before_page_content').hide();
                jQuery('.homequest_content_bottom').show();
            }
            if($('#homequest_use_page_options').is(':checked')) jQuery('#homepage-header,#homepage-shortcodes').hide();
            jQuery('#homequest_use_page_options').live('change',function () {
                if(jQuery(this).is(':checked'))
                    jQuery('#homepage-header,#homepage-shortcodes').hide();
                else
                    jQuery('#homepage-header,#homepage-shortcodes').show();
            });
        }

        if(options['homequest_blogpage_category']=='specific')
            jQuery('.homequest_categories_select_categ_blog').show();
        else
            jQuery('.homequest_categories_select_categ_blog').hide();

        if(options['homequest_header_element_blog']=='search'){
            jQuery('.homequest_search_type_blog').show();
            jQuery('.homequest_select_slider_blog,.homequest_select_search_slider_blog').hide();
        }
        else if(options['homequest_header_element_blog']=='slider'){
            jQuery('.homequest_select_slider_blog').show();
            jQuery('.homequest_search_type_blog,.homequest_select_search_slider_blog').hide();
        }
        else if(options['homequest_header_element_blog']=='search_slider'){
            jQuery('.homequest_select_search_slider_blog').show();
            jQuery('.homequest_select_slider_blog,.homequest_select_slider_blog').hide();
        }
        else {
            jQuery('.homequest_search_type_blog,.homequest_select_slider_blog,.homequest_select_search_slider_blog').hide();
        }

        if(options['homequest_before_content_element_blog']=='map'){
            jQuery('.homequest_page_map_blog').show();
            jQuery('.homequest_before_content_select_slider_blog,.homequest_properties_number_blog').hide();
        }
        else if(options['homequest_before_content_element_blog']=='slider'){
            jQuery('.homequest_before_content_select_slider_blog').show();
            jQuery('.homequest_page_map_blog,.homequest_properties_number_blog').hide();
        }
        else if(options['homequest_before_content_element_blog']=='latest_added'){
            jQuery('.homequest_properties_number_blog').show();
            jQuery('.homequest_page_map_blog,.homequest_before_content_select_slider_blog').hide();
        }
        else{
            jQuery('.homequest_page_map_blog,.homequest_before_content_select_slider_blog,.homequest_properties_number_blog').hide();
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
	
	$('.tfuse_selectable_code').live('click', function () {
        var r = document.createRange();
        var w = $(this).get(0);
        r.selectNodeContents(w);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(r);
    });
    $('#tf_rf_form_name_select').change(function(){
        $_get=getUrlVars();
        if($(this).val()==-1 && 'formid' in $_get){
            delete $_get.formid;
        } else if($(this).val()!=-1){
            $_get.formid=$(this).val();
        }
        $_url_str='?';
        $.each($_get,function(key,val){
            $_url_str +=key+'='+val+'&';
        })
        $_url_str = $_url_str.substring(0,$_url_str.length-1);
        window.location.href=$_url_str;
    });


    function getUrlVars() {
        urlParams = {};
        var e,
            a = /\+/g,
            r = /([^&=]+)=?([^&]*)/g,
            d = function (s) {
                return decodeURIComponent(s.replace(a, " "));
            },
            q = window.location.search.substring(1);
        while (e = r.exec(q))
            urlParams[d(e[1])] = d(e[2]);
        return urlParams;
    }
});