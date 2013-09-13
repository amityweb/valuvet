(function ($) {

  Drupal.behaviors.valuvetRichForms = {

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //// VARIABLES //////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    _formID: '#property-node-form',

    _doValidation: true,

    // describe controls for multistep form
    _controls: [
      {
        text: 'Previous',
        id: 'prev',
        onclick: function(e) {
          e.preventDefault();
          e.stopPropagation();

          var formID = Drupal.behaviors.valuvetRichForms._formID;
          var selected = $(formID+' .vertical-tabs-list > .selected');
          var candidate = selected.hasClass('first') ? null : selected.prev('li');

          candidate.find('a').click();
        }
      },
      {
        text: 'Next',
        id: 'next',
        onclick: function(e) {
          e.preventDefault();
          e.stopPropagation();

          var formID = Drupal.behaviors.valuvetRichForms._formID;
          var selected = $(formID+' .vertical-tabs-list > li.selected');
          var candidate = selected.hasClass('last') ? null : selected.next('li');

          candidate.find('a').click();
        }
      }
    ],

    _wordCounters: [
      { el: '#edit-body-und-0-value', limit: 100 },
      { el: '#edit-field-property-the-business-und-0-value', limit: 300 },
      { el: '#edit-field-property-the-opportunity-und-0-value', limit: 300 },
      { el: '#edit-field-property-the-location-und-0-value', limit: 300 }
    ],

    _priceFields: [
      { el: '#edit-field-property-real-estate-value-und-0-amount', check: false },
      { el: '#edit-field-property-stock-value-und-0-amount', check: '#edit-field-property-stock-value-ask-und' },
      { el: '#edit-field-property-equipment-value-und-0-amount', check: '#edit-field-property-eqpmnt-value-ask-und' },
      { el: '#edit-field-property-goodwill-value-und-0-amount', check: false }
    ],

    _askingPrice: '#edit-field-property-asking-price-und-0-amount',
    _titleField : '#edit-field-property-headline-und-0-value',

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //// FUNCTIONS //////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    _addHeadlines: function() {
      // cache some value and avoid
      var formID = Drupal.behaviors.valuvetRichForms._formID;
      var buttons = $(formID+' .vertical-tabs-list > li.vertical-tab-button');

      buttons.each(function(idx, el){
        var title = $(el).find('a strong').text();
        $(formID+' .vertical-tabs-panes > fieldset:eq('+idx+')').prepend('<h2 class="pane-title generated">'+title+'</h2>');
      });
    },

    _createControls: function() {

      var formID = Drupal.behaviors.valuvetRichForms._formID;

      // add the progress bar markup above the form
      $(formID).prepend(
        '<div id="progressbar-container"><div id="progressbar"><div class="meter"></div></div></div>'
      );

      // add controls container
      $(formID).append('<ul id="valuvet-multistep-controls"></ul>');

      // create controls as defined above
      $.each(Drupal.behaviors.valuvetRichForms._controls, function(i, item) {
        $('#valuvet-multistep-controls').append(
            '<li><a id="valuvet-multistep-btn-'+item.id+'" class="btn" href="#" title="'+item.text+' step">'+item.text+'</a></li>'
        );
        $('#valuvet-multistep-btn-'+item.id).click(item.onclick);
      });

      // display right element based on position
      Drupal.behaviors.valuvetRichForms._setControls();

    },

    // IMPORTANT NOTE - THERE SHALL BE HARDCODED VALUES! BEWARE!
    _setImageLoaders: function (value) {

      var listingCont = $('#edit-field-property-listing-image');
      var galleryCont = $('#edit-field-property-image-gallery');

      var listing = $('#edit-field-property-listing-image-und-0-ajax-wrapper');
      var gallery = $('#edit-field-property-image-gallery-und-ajax-wrapper');

      switch (value) {
        case '5':
          listing.hide();
          gallery.hide();
          $('.package-img-message').show();
          break;
        case '6':
          listing.show();
          gallery.hide();
          listingCont.find('.package-img-message').hide();
          galleryCont.find('.package-img-message').show();
          break;
        case '7':
          listing.show();
          gallery.show();
          $('.package-img-message').hide();
      }
    },

    _imageLoadersInit: function() {

      // Add messages to the DOM (hidden)
      var listingCont = $('#edit-field-property-listing-image');
      var galleryCont = $('#edit-field-property-image-gallery');

      var msgPck1 = $('<div class="package-img-message"><h3>Listing image</h3><p>Listing image is available with packages 2 and 3 only</p></div>');
      var msgPck2 = $('<div class="package-img-message"><h3>Image gallery</h3><p>Image gallery is available with package 3 only</p></div>');

      listingCont.append(msgPck1);
      galleryCont.append(msgPck2);

      $('.package-img-message').hide();

      // when user choose another package the fields pop up
      $('#edit-field-property-package-und').change(function(e){
        Drupal.behaviors.valuvetRichForms._setImageLoaders($(this).val());
      });

      // set the field status on the first load
      Drupal.behaviors.valuvetRichForms._setImageLoaders($('#edit-field-property-package-und').val());
    },

    _wordCounterInit: function() {
      // when user choose another package the word counter should change (sic... again)
      $('#edit-field-property-package-und').change(function(e){
        Drupal.behaviors.valuvetRichForms._setWordCounter($(this).val());
      });
    },

    _calcAskingPrice: function() {
      var total = 0;
      $(Drupal.behaviors.valuvetRichForms._priceFields).each(function(idx, data){
        if (!data.check || $(data.check).attr('checked'))
          total += parseFloat($(data.el).val().replace(",", ""));
      });
      $(Drupal.behaviors.valuvetRichForms._askingPrice).val(total.toFixed(2));
      $(Drupal.behaviors.valuvetRichForms._askingPrice).priceFormat({
            prefix: '',
            centsSeparator: '.',
            thousandsSeparator: ','
        });
    },

    _alterPrices: function() {

      // disable asking price field and make it calculate by Javascript
      $(Drupal.behaviors.valuvetRichForms._askingPrice).attr('disabled',true);

      // make up for each single price field
      $(Drupal.behaviors.valuvetRichForms._priceFields).each(function(idx, data){
       // add masked money input to price fields
        $(data.el).priceFormat({
            prefix: '',
            centsSeparator: '.',
            thousandsSeparator: ','
        });

        // if user digits in prices field or "price included" checkboxes status
        // update the price
        $(data.el).keyup(function(e) {
          Drupal.behaviors.valuvetRichForms._calcAskingPrice();
        });
        if (data.check) {
          $(data.check).change(function(e) {
            Drupal.behaviors.valuvetRichForms._calcAskingPrice();
          });
        }
      });

      // change currency if the user change from Australia to New Zealand
      $('#edit-field-business-address-und-0-country').change(function(e){
        // change currency descriptor
        var currency = 'AUD';
        if ($('#edit-field-business-address-und-0-country').val() == 'nz') currency = 'NZD';

        // change asking price field
        $(Drupal.behaviors.valuvetRichForms._askingPrice).next('span.field-suffix').html(currency);

        // change other fields
        $(Drupal.behaviors.valuvetRichForms._priceFields).each(function(idx, data){
          $(data.el).next('span.field-suffix').html(currency);
        });
      });

    },

    _setControls: function() {

      var formID = Drupal.behaviors.valuvetRichForms._formID;

      selectedIdx = $(formID+' .vertical-tabs-list > .selected').index();
      firstIdx    = $(formID+' .vertical-tabs-list > .first').index();
      //lastIdx     = $(formID+' .vertical-tabs-list > .last').index();  
      lastIdx     = $(formID+' .vertical-tabs-list > li').filter(':visible').length - 1;
      
      $('#edit-submit').hide();

      if ( selectedIdx <= firstIdx ) {
        $('#valuvet-multistep-btn-next').show();
        $('#valuvet-multistep-btn-prev').hide();
      }
      else if ( selectedIdx >= lastIdx ) {
        $('#valuvet-multistep-btn-next').hide();
        $('#valuvet-multistep-btn-prev').show();
        $('#edit-submit').show();
        // re-enable these fields so it could be sent
        $(Drupal.behaviors.valuvetRichForms._askingPrice).attr('disabled',false);
        $(Drupal.behaviors.valuvetRichForms._titleField).attr('disabled',false);
      }
      else {
        $('#valuvet-multistep-btn-next').show();
        $('#valuvet-multistep-btn-prev').show();
        $(Drupal.behaviors.valuvetRichForms._askingPrice).attr('disabled',true);
        if ($('#edit-field-property-package-und').val() == 5) { //////// WARNING!!! HARDCODED VALUE! THIS SUCKS!!!
          $(Drupal.behaviors.valuvetRichForms._titleField).attr('disabled',true);
        }
      }

    },
    

    _setChangeTabs: function() {
      var formID = Drupal.behaviors.valuvetRichForms._formID;
      lastIdx     = $(formID+' .vertical-tabs-list > .last').index();
      var pkg        = $('#edit-field-property-package-und').val();      
      if(pkg == 5 || pkg == 6){
        //Hide unnecessary tabs
          for (i=8; i<=lastIdx; i++) { 
            $(formID+' .vertical-tabs-list > li:eq('+i+')').hide();             
          }                   
      }
      else{
        //Show all tabs
          for (i=0; i<lastIdx; i++) { 
            $(formID+' .vertical-tabs-list > li:eq('+i+')').show();             
          }                  
      }            
    },

    _initPackage: function() {
      var formID = Drupal.behaviors.valuvetRichForms._formID;
      
      var split = location.search.replace('?', '').split('=');
      if(split[0] == 'property_type'){
        if(split[1] == 'package_2'){
          $('#edit-field-property-package-und').val(6);
        }
        if(split[1] == 'package_3'){
          $('#edit-field-property-package-und').val(7);
        }        
      }
      //Change tabs according to the passed parameter
      Drupal.behaviors.valuvetRichForms._setChangeTabs();           
    },

    _alterVTabs: function() {

      var formID = Drupal.behaviors.valuvetRichForms._formID;

      // update progress bar as the form goes and check controls
      $(formID+' .vertical-tabs-list li a').click(function(e) {

        var progressBar = $('#progressbar .meter');
        var index = $(formID+' .vertical-tabs-list li').index($(this).parent());

        var max  = $(formID+' .vertical-tabs-list li').filter(':visible').length;  //Paolo: I have to consider only the visible tabs
        var step = Math.floor(100/max);

        if (index == max) progressBar.width('100%');
        else progressBar.width((index*step)+'%');

        // set percentage in the progressbar
        if (index < 1) progressBar.html('');
        else progressBar.html((index*step)+'% completed');

        // display right element based on position
        Drupal.behaviors.valuvetRichForms._setControls();
       

        Drupal.behaviors.valuvetRichForms._gotoError(index);  // <---------- comment this line if you're developing
      });
    },

    // IMPORTANT NOTE - THERE SHALL BE HARDCODED VALUES! BEWARE!
    _setWordCounter: function (value) {

      switch (value) {
        case '5':
          Drupal.behaviors.valuvetRichForms._wordCounters[0].limit = 100;
          break;
        case '6':
        case '7':
          Drupal.behaviors.valuvetRichForms._wordCounters[0].limit = 150;
          break;
      }

      Drupal.behaviors.valuvetRichForms._applyWordCounter();
    },

    _applyWordCounter: function() {

      var formID = Drupal.behaviors.valuvetRichForms._formID;

      $(Drupal.behaviors.valuvetRichForms._wordCounters).each(function(index, data) {
        // reset in case of variation in package selection (sic...)
        $(data.el).unbind('keyup');
        // set the count limit in the help
        $(data.el).closest("div.controls").find("p.help-block").html('('+data.limit+' words)');
        // start counting when the user enter text
        $(data.el).keyup(function(e){

          // find elements and count words in there
          helpblock = $(this).closest("div.controls").find("p.help-block");
          count = $.trim($(this).val()).split(/[\s\n]+/).length;

          // if we reached the limit... bye bye character
          if (count >= data.limit) $(formID).validate().element(this);

          // fix the counter
          $(helpblock).html('('+count+'/'+data.limit+' words)');
        });
      });
    },

    _setNodeTitle: function(value) {
      var titleField = $(Drupal.behaviors.valuvetRichForms._titleField);
      var disposal   = $('#edit-field-property-disposal-und').val().toUpperCase();
      var type       = $('#edit-field-property-type-und').val();
      var pkg        = $('#edit-field-property-package-und').val();
      switch (pkg) {
        case '5':
          titleField.val(disposal + ' - ' + type + ' practice');
          titleField.attr('disabled',true);
          break;
        case '6':
        case '7':
          titleField.val(disposal + ' - ' + type + ' practice');
          titleField.attr('disabled',false);
          break;
      }

      Drupal.behaviors.valuvetRichForms._setNodeTitlePreview(titleField.val());
    },

    _setNodeTitlePreview: function(value) {
      preview = $('#vv-headline-preview');
      city = $('#edit-field-business-address-und-0-city').val();
      province = $('#edit-field-business-address-und-0-province').val();;
      preview.html(value + ' - ' + city + ', ' + province);
    },

    _nodeTitleInit: function() {
      var titleField = $(Drupal.behaviors.valuvetRichForms._titleField);
      // create the necessary dom elements
      titleField.after('<p id="vv-headline-preview"></p>');

      // when user moves involved variables the practice headline should update accordingly
      $('#edit-field-property-package-und,#edit-field-business-address-und-0-city,#edit-field-business-address-und-0-province,#edit-field-property-disposal-und,#edit-field-property-type-und').change(function(e){
        Drupal.behaviors.valuvetRichForms._setNodeTitle();
        
        // reset the tabs depending on the Package
        Drupal.behaviors.valuvetRichForms._setChangeTabs();                
      });
      
      titleField.keyup(function(e){        
        Drupal.behaviors.valuvetRichForms._setNodeTitlePreview(titleField.val());
      });
      
      //Hide edit-field-property-lease-details when combo is not selected (the conditional was not working with OR)
      $('#edit-field-property-lease-details').hide();      
      $('#edit-field-property-disposal-und').change(function(e){
        if($('#edit-field-property-disposal-und').val() == '_none'){
                $('#edit-field-property-lease-details').hide();            
        }
      });      
      
      Drupal.behaviors.valuvetRichForms._setNodeTitle();

    },
    
    _advInfoInit: function() {
        if ($('#edit-field-property-package-und').val() == 5) { //////// WARNING!!! HARDCODED VALUE! THIS SUCKS!!!
          $('#edit-field-property-the-business').hide();
          $('#edit-field-property-the-business textarea').removeClass('required');
          $('#edit-field-property-the-opportunity').hide();
          $('#edit-field-property-the-opportunity textarea').removeClass('required');
          $('#edit-field-property-the-location').hide();
          $('#edit-field-property-the-location textarea').removeClass('required');
        }      
    },

    _gotoError: function(destinationIdx) {

      var formID = Drupal.behaviors.valuvetRichForms._formID;

      // ok, try to validate an element and re-click on the previous link if
      if (Drupal.behaviors.valuvetRichForms._doValidation) {

        // for each form-panel which preced the clicked one (the destination),
        // perform validation on all fields. If a field proves invalid, exit
        // and go to the panel
        var isValid = true;
        $(formID+' .vertical-tabs-list li').each(function(idx, value) {

          // don't validate tabs other that the preceding ones
          if (idx >= destinationIdx) return false; // stop loop if we overrun clicked element (side effect, don't validate in case of backward click...)

          // find the panel relative to the index
          destinationPanel = $(formID+' .vertical-tabs-panes > fieldset:eq('+idx+')');

          // validate percent elements in animals treated tab (done by hand)
          if (destinationPanel.hasClass('group-property-animals')) {
            Drupal.behaviors.valuvetRichForms._removePercentErrors(idx);
            isValid = Drupal.behaviors.valuvetRichForms._validatePercents();
            if (!isValid) {
              $(formID+' .vertical-tabs-list li:eq('+idx+')').find('a').removeClass('valid').addClass('error');
            } else {
              $(formID+' .vertical-tabs-list li:eq('+idx+')').find('a').removeClass('error').addClass('valid');
            }
            return isValid;
          }

          // validate each form element in the panel
          destinationPanel.find('.required').each(function(idx, value) {
            isValid = isValid && $(formID).validate().element(value);
            return isValid; // stop if an element is not valid
          });

          return isValid; // stop if an element is not valid
        });

        if (!isValid) {

          var errorTabTrigger = $(formID+' .vertical-tabs-list > li > a.error').first();
          //Drupal.behaviors.valuvetRichForms._doValidation = false;
          errorTabTrigger.click();
        }
      } else {
          Drupal.behaviors.valuvetRichForms._doValidation = true;
      }

    },

    _validatePercents: function() {
      // a bunch of courtensy vars
      var
        fieldsContainer = $('#node_property_form_group_property_animals > .fieldset-wrapper'),
        errorLabelTemplate = '<label generated="true" class="error" style="display: block;"></label>',
        animalTypes = [
          'small-animals',
          'equine',
          'bovine',
          'other-animals'
        ];

      result = true; // no errors so far
      total = 0;
      $(animalTypes).each(function(idx, type) {
        percValue      = parseInt(0+$('#edit-field-property-'+type+'-und-0-value').val());
        percDetailed   = false;
        // this hack SUCKS!!!
        var typecb = type;
        typecb = (type != 'other-animals') ?  typecb+'-cbs': typecb+'-cb';
        $('#edit-field-property-' + typecb + ' input.form-checkbox').each(function(idx, el){
          if ($(el).is(':checked')) percDetailed = true;
        });

        total += percValue;

        // if a percent is set but no details are given
        if (percValue > 0 && !percDetailed) {
          fieldsContainer.before($(errorLabelTemplate).addClass('vv-percent-match').html('Please provide details for this type of animal'));
          $('#edit-field-property-'+type+'-und-0-value').addClass('error');
          result = false;
        }
        // viceversa, if details are given but no percent is set
        else if (percValue == 0 && percDetailed) {
          fieldsContainer.before($(errorLabelTemplate).addClass('vv-percent-match').html('Please provide details for this type of animal'));
          $('#edit-field-property-'+type+'-und-0-value').addClass('error');
          result = false;
        }
      });
      // if percent total is not 100...
      if (total != 100) {
        // set the error
        fieldsContainer.before($(errorLabelTemplate).addClass('vv-percent-match').html('Total must match 100%'));
        $(animalTypes).each(function(idx, type) {
          $('#edit-field-property-'+type+'-und-0-value').addClass('error');
        });
        result = false;
      }

      return result;

    },

    _removePercentErrors: function(idx) {
      var formID = Drupal.behaviors.valuvetRichForms._formID;
      $(formID+' .vertical-tabs-list li:eq('+idx+')').find('a.error').removeClass('error');
      $(formID+' .vertical-tabs-panes > fieldset:eq('+idx+')').find('label.error').remove();
      $(formID+' .vertical-tabs-panes > fieldset:eq('+idx+')').find('input.error').removeClass('error');
    },

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //// BEHAVIORS //////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    attach: function (context, settings) {

      // don't execute this stuff more than once (should have used jQuery Once, but I don't want to declare it)
      // at every stinking call. Maybe another behavior can be used but I sincerely don't give a dime.
      // It works!
      if ($('#progressbar-container').length > 0) return false;
      //Doing some initialization
      Drupal.behaviors.valuvetRichForms._initPackage();
      
      // add necessary click-related behaviors to validate fields during tabs navigation
      Drupal.behaviors.valuvetRichForms._alterVTabs();

      // add next/previous buttons below the form
      Drupal.behaviors.valuvetRichForms._createControls();

      // mask image loaders depending on chosen package
      Drupal.behaviors.valuvetRichForms._setImageLoaders();

      // activate word counters for textareas
      Drupal.behaviors.valuvetRichForms._applyWordCounter();

      // add necessary behaviors to price fields
      Drupal.behaviors.valuvetRichForms._alterPrices();

      // add Headlines to panes
      Drupal.behaviors.valuvetRichForms._addHeadlines();

      // image loaders initialization
      Drupal.behaviors.valuvetRichForms._imageLoadersInit();

      // word counters initialization
      Drupal.behaviors.valuvetRichForms._wordCounterInit();

      // set properties of the title field per-package
      Drupal.behaviors.valuvetRichForms._nodeTitleInit();
      
      // set adv info per Package
      Drupal.behaviors.valuvetRichForms._advInfoInit();      

    }
  };

})(jQuery);