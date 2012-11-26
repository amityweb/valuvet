jQuery.noConflict();

  jQuery(document).ready(function(){
		jQuery( '.log_id' ).click(function() {
			jQuery('#logreply_'+ jQuery(this).val() ).toggle(250);
		});
		
	});
