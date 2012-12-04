/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var _theme_index='homequest';
        jQuery(document).ready(function(){
            $=jQuery;
               $('#contactForm').ajaxForm({
               dataType:'json',
               data:{action:'tfuse_ajax_contactform',tf_action:'submitFrontendForm',form_id:$('#this_form_id').val()},
                beforeSubmit:check_fields,
               success:function(responseText, statusText, xhr){
                   if(responseText.error){
                       showErrorMessage(responseText.mess);
                   } else {
                       showSuccessMessage(responseText.mess);
                   }
               }
           });
            $('.tfuse_captcha_reload').live('click', function (event) {
                    _form = $(this).closest('form');
                    _captcha = _form.find('.tfuse_captcha_img');
                    _captcha_src = _captcha.attr('src');
                    _url = _captcha_src.split('?');
                    _ww = _url[0].substring(0, _url[0].lastIndexOf('/'));
                    _captcha.attr('src', _url[0] + '?' + event.timeStamp);
                });
        });
        function showErrorMessage(textMessage){
            _message=$('#form_messages').html('<h2>'+textMessage+'</h2>').addClass('error_submiting_form').show();
            $('#contactForm').hide();
        }
        function showSuccessMessage(textMessage){
            _message=$('#form_messages').html('<h2>'+textMessage+'</h2>').addClass('success_submited_form').show();
            $('#contactForm').hide();
        }
function check_fields() {
    _form=jQuery('#contactForm');
    _captcha = _form.find('.tfuse_captcha_img');
    _captcha_resp = true;
    if (_captcha.length > 0) {
        _captcha_src = _captcha.attr('src');
        _url = _captcha_src.split('?');
        _ww = _url[0].substring(0, _url[0].lastIndexOf('/'));
        $.ajax({
            url:_ww + '/check_captcha.php',
            dataType:'json',
            type:'POST',
            async:false,
            success:function (response, textStatus, XMLHttpRequest) {
                _captcha_input = _form.find('.tfuse_captcha_input');
                _captcha_resp = (response == _captcha_input.val()) ? true : false;
                if (!_captcha_resp) {
                    _captcha_input.css('borderColor', 'red');
                }
                else _captcha_input.css('borderColor', '#ccc');
            }

        });
    }
    _return_val = true;
    _required_inputs = _form.find('.tf_cf_required_input');
    _required_inputs.each(function () {
        if(jQuery(this).attr('type')=='checkbox'){
            if(!jQuery(this).is(':checked')){
                jQuery(this).next('label').css('color', 'red');
            } else {
                jQuery(this).next('label').css('color','#12A0A9');
            }
        } else {
        if (jQuery.trim(jQuery(this).val()) == '') {
            _return_val = false;
            jQuery(this).css('borderColor', 'red');
        } else {
            jQuery(this).css('borderColor', '#ccc');
        } 

    }
    });
            if (jQuery('.'+_theme_index + '_email').length>0) {
            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
           jQuery('.'+_theme_index + '_email').each(function(){
               if(!pattern.test(jQuery(this).val())){
                   _return_val = false;
                   jQuery(this).css('borderColor', 'red');
               } else {
                   jQuery(this).css('borderColor', '#ccc');
               }
           });
        }
    return  _captcha_resp &&_return_val;
}