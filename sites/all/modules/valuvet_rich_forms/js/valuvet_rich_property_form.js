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

    _calcAskingPrice: function() {
      var total = 0;
      $(Drupal.behaviors.valuvetRichForms._priceFields).each(function(idx, data){
        if (!data.check || $(data.check).attr('checked'))
          total += parseFloat($(data.el).val());
      });
      $(Drupal.behaviors.valuvetRichForms._askingPrice).val(total.toFixed(2));
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
            thousandsSeparator: ''
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
      lastIdx     = $(formID+' .vertical-tabs-list > .last').index();

      $('#edit-submit').hide();

      if ( selectedIdx <= firstIdx ) {
        $('#valuvet-multistep-btn-next').show();
        $('#valuvet-multistep-btn-prev').hide();
      }
      else if ( selectedIdx >= lastIdx ) {
        $('#valuvet-multistep-btn-next').hide();
        $('#valuvet-multistep-btn-prev').show();
        $('#edit-submit').show();
        // re-enable this field so it could be sent
        $(Drupal.behaviors.valuvetRichForms._askingPrice).prop('disabled',false);
      }
      else {
        $('#valuvet-multistep-btn-next').show();
        $('#valuvet-multistep-btn-prev').show();
      }

    },

    _alterVTabs: function() {

      var formID = Drupal.behaviors.valuvetRichForms._formID;

      // update progress bar as the form goes and check controls
      $(formID+' .vertical-tabs-list li a').click(function(e) {

        var progressBar = $('#progressbar .meter');
        var index = $(formID+' .vertical-tabs-list li').index($(this).parent());

        var max  = $(formID+' .vertical-tabs-list li').length;
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

    _applyWordCounter: function() {

      var formID = Drupal.behaviors.valuvetRichForms._formID;

      $(Drupal.behaviors.valuvetRichForms._wordCounters).each(function(index, data) {
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
          if (idx >= destinationIdx) return false; // stop loop if we overrun clicked element

          // find the panel relative to the index
          destinationPanel = $(formID+' .vertical-tabs-panes > fieldset:eq('+idx+')');

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

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //// BEHAVIORS //////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    attach: function (context, settings) {

      // don't execute this stuff more than once (should have used jQuery Once, but I don't want to declare it)
      // at every stinking call. Maybe another behavior can be used but I sincerely don't give a dime.
      // It works!
      if ($('#progressbar-container').length > 0) return false;

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

    }
  };

})(jQuery);