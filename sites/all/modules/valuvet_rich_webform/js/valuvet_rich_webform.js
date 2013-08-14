(function ($) {

  Drupal.behaviors.valuvetRichWebForms = {
    /////////////////////////////////////////////////////////////////////////////////////////////////
    //// VARIABLES //////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////




    /////////////////////////////////////////////////////////////////////////////////////////////////
    //// FUNCTIONS //////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    _resetForm: function() {
      $('form.webform-client-form input:text').blur(function(e) {                
        if($(this).val() === ''){
          $(this).val($(this).attr('title'));
        }
      });
      $('form.webform-client-form input:text').focus(function(e) {         
        if(($(this).attr('title') == undefined) || $(this).attr('title') == $(this).val()){            
          $(this).attr('title', $(this).val());
          $(this).val('');               
          return false;          
        }
      });              
    },
    
    _submitForm: function() {
      $('form.webform-client-form').submit(function(e) {         
        //alert('ciccio');       
      });        
    },    

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //// BEHAVIORS //////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    attach: function (context, settings) {
      // add necessary click-related behaviors to validate fields during tabs navigation
      Drupal.behaviors.valuvetRichWebForms._resetForm();
      
      //Drupal.behaviors.valuvetRichWebForms._submitForm();
    }
  };

})(jQuery);