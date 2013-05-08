if (jQuery) {
	(function($) {
		$(window).load(function() {
			
			$('#edit-field-business-address-lid-wrapper').hide();
			/*$('#edit-field-property-vets-n-value-wrapper').after(
				$('#edit-country-views-exposed-form').html()
			);*/
			
			/*$('#edit-country-views-exposed-form').change(
				function(){
					console.log($(this).val()); 
			});*/
			
			// populate this field before submit form!!! 
			$('#edit-field-business-address-lid').val('');
		});
		
		
		function ciccio() { console.log('aaaa'); }
	})(jQuery);
}
