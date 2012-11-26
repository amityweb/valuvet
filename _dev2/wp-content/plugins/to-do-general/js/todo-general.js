jQuery.noConflict();

	function validate_selection(){
		var data=jQuery("#todo_operation").val();
		if(data=='Remove from dashboard') {
			return confirm('Are you sure you need to remove selected entry/ies from todo list');
		}
	}

  jQuery(document).ready(function(){
		jQuery( '#todo_operation' ).change(function() {
			var data=jQuery("#todo_operation").val();
			jQuery(".inforequired").hide(100);
			if(data=='Info Required') {
				jQuery(':checkbox:checked').each(function(i){
					jQuery("#inforequired_"+jQuery(this).val()).show(100);
				});
			}
		});
		
		jQuery( '.todopid' ).click(function() {
			var data=jQuery("#todo_operation").val();
			if(data=='Info Required') {
				jQuery('#inforequired_'+ jQuery(this).val() ).toggle(250);
			}
		});
		
		
		
		jQuery('a.showlog').click(function(){
			idv = jQuery(this).attr("id");
			jQuery("#log_"+idv).toggle(250);
		});
		
	});
