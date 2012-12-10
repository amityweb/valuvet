/**
 * Contact Form
 *
 * To override this function in a child theme, copy this file to your child theme's
 * js folder.
 * /js/contactform.js
 *
 * @version 1.0
 */

jQuery(document).ready(function(){
    tfuse_contact_agent_form();
});

function tfuse_contact_agent_form()
{
    jQuery('.widget_adv_filter .btn-submit').bind('click', function()
    {


        var my_error = false;

        jQuery('.widget_adv_filter input,.widget_adv_filter textarea,').each(function(i)
        {
            var surrounding_element = jQuery(this);
            var value               = jQuery(this).attr('value');
            var check_for           = jQuery(this).attr('name');
            var required            = jQuery(this).hasClass('required');

            if(check_for == 'email')
            {
                surrounding_element.removeClass('error valid');
                baseclases = surrounding_element.attr('class');
                if(!value.match(/^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$/)) {
                    surrounding_element.attr('class',baseclases).addClass('error');
                    my_error = true;
                } else {
                    surrounding_element.attr('class',baseclases).addClass('valid');
                }
            }

            if(required && check_for != 'email')
            {
                surrounding_element.removeClass('error valid');
                baseclases = surrounding_element.attr('class');
                if(value == '') {
                    surrounding_element.attr('class',baseclases).addClass('error');
                    my_error = true;
                } else {
                    surrounding_element.attr('class',baseclases).addClass('valid');
                }
            }

        });

        if (!my_error)
        {
            var email = jQuery('.widget_adv_filter #email').val();
            var message = jQuery('.widget_adv_filter #message').val();
            var contact = 'ct_email';

            var first_name = jQuery('.widget_adv_filter #first_name').val();
            var last_name = jQuery('.widget_adv_filter #last_name').val();
            var phone = jQuery('.widget_adv_filter #phone').val();
            var prop_id = jQuery('#submit_to_agent').attr("rel");

            jQuery('.widget_adv_filter .contact_type').each(function(e){
                    if (jQuery(this).is(':checked')) { contact = jQuery(this).attr("value")}
            });
            var datastring = 'action=tfuse_send_agent_email&first=' + first_name + '&last=' + last_name + '&email=' + email + '&phone=' + phone + '&message=' + message + '&contact=' + contact + '&prop_id=' + prop_id;

            if (jQuery('.widget_adv_filter #newsletter_subscribe').is(':checked'))
            {
                jQuery.post(tf_script.ajaxurl, {
                    action:'tfuse_ajax_newsletter',
                    tf_action:'tfuse_ajax_newsletter_save_email',
                    email:email,
                    name:first_name
                });
            }

            jQuery.ajax({
                type: 'POST',
                url: tf_script.ajaxurl,
                data: datastring,
                success: function(response)
                {
                    if (response == 'true')
                    {
                        jQuery('.widget_adv_filter .contact_agent_success').fadeIn(500);

                    }
                    else
                    {
                        jQuery('.widget_adv_filter .contact_agent_error').fadeIn(500);
                    }
                    setTimeout(remove_messages,3000);
                }
            });

        }
        return false;
    });
}

function remove_messages()
{
    jQuery('.widget_adv_filter .contact_agent_success').fadeOut(500);
    jQuery('.widget_adv_filter .contact_agent_error').fadeOut(500);
}