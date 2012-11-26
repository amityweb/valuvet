    //original field values
    var field_values = {
            //id        :  value
            'hear_from'  : 'hear_from',
            'pkg_id'  : 'pkg_id',
			'ad_title'  : 'ad_title',
			'ad_firstname'  : 'ad_firstname',
			'ad_surname'  : 'ad_surname',
			'ad_email'  : 'ad_email',
			'ad_contactnumber'  : 'ad_contactnumber',
			'business_address'  : 'business_address',
			'suburb'  : 'suburb',
			'post_code'  : 'post_code',
			'equipment_state'  : 'equipment_state',
			'equipment_country'  : 'equipment_country',
			'post_title'  : 'post_title',
			'equipment_category'  : 'equipment_category',
			'equipment_description'  : 'equipment_description',
			'equipment_price'  : 'equipment_price',
			'equipment_noof_items'  : 'equipment_noof_items'
    };

	
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; 
	var numberPattern = /^[0-9]{10}$/; 
	var moneyPattern = /^([0-9]{1,5})[\.][0-9]{2}$/; 
	var postcodepattern = /^[0-9]{4,5}$/;
	var anynumberPattern = /^[0-9]{1,5}$/; 

 	jQuery('#step0').click(function(){
	    		jQuery('#progress_text').html('0% Complete');
                jQuery('#progress').css('width','0px');
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
				jQuery('#step_1').slideUp(); 
                jQuery('#step_0').slideDown();
                
	  });
	
	jQuery('#step1').click(function(){
                jQuery('#progress_text').html('10% Complete');
                jQuery('#progress').css('width','34px');
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
				jQuery('#step_2').slideUp(); 
                jQuery('#step_1').slideDown();
                
	  });
	jQuery('#step2').click(function(){
		  jQuery('#progress_text').html('40% Complete');
		  jQuery('#progress').css('width','102px');
			  //slide steps
		  jQuery('html, body').animate({scrollTop:0}, 'slow'); 
		  jQuery('#step_3').slideUp(); 
		  jQuery('#step_2').slideDown();
	});
	jQuery('#step3').click(function(){
		  jQuery('#progress_text').html('60% Complete');
		  jQuery('#progress').css('width','204px');
			  //slide steps
		  jQuery('html, body').animate({scrollTop:0}, 'slow'); 
		  jQuery('#step_4').slideUp(); 
		  jQuery('#step_3').slideDown();
	});
	  
	  
		
    jQuery('#submit_0').click(function(){
        //remove classes
        jQuery('#step_0 input').removeClass('error').removeClass('valid');

				
        //ckeck if inputs aren't empty
        var fields = jQuery('#step_0 .step0p');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
			 console.log('error='+error+'this='+jQuery(this).attr('id'));
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='hear_from' && value=='Other' && jQuery('#ad_hearabout_other').val()=='' )  ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });      

        if(!error) {
                jQuery('#progress_text').html('10% Complete');
                jQuery('#progress').css('width','34px');

                //slide steps
                jQuery('#step_0').slideUp();
                jQuery('#step_1').slideDown();  
				jQuery('html, body').animate({scrollTop:0}, 'slow');   
        } else {
			return false;
		}
    });
	  
    jQuery('#submit_1').click(function(){
        //remove classes
        jQuery('#step_1 input').removeClass('error').removeClass('valid');
				
        //ckeck if inputs aren't empty
        var fields = jQuery('#step_1 .step1p');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
			// console.log('error='+error+'this='+jQuery(this).attr('id'));
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='ad_email' && !emailPattern.test(value)) || ( jQuery(this).attr('id')=='ad_contactnumber' && !numberPattern.test(value)) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });        
        if(!error) {

		    	jQuery('#progress_text').html('40% Complete');
    	    	jQuery('#progress').css('width','136px');

                //slide steps
                jQuery('#step_1').slideUp();
                jQuery('#step_2').slideDown();  
				jQuery('html, body').animate({scrollTop:0}, 'slow');   
        } else return false;
    });
	
    jQuery('#submit_2').click(function(){
        //remove classes
        jQuery('#step_2 input').removeClass('error').removeClass('valid');
        var fields = jQuery('#step_2 .step2p');
		
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
			 console.log('error='+error+'this='+jQuery(this).attr('id'));
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='post_code' && !postcodepattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });
        if(!error) {
		    	jQuery('#progress_text').html('60% Complete');
    	    	jQuery('#progress').css('width','204px');
                jQuery('#step_3').slideDown(); 
                jQuery('#step_2').slideUp();
				jQuery('html, body').animate({scrollTop:0}, 'slow');   
        } else return false;
    });
	
	
    jQuery('#submit_3').click(function(){//STEP 3
         jQuery('#submit_3 input').removeClass('error').removeClass('valid');
        var fields = jQuery('#step_3 .step3p');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')]  || ( jQuery(this).attr('id')=='equipment_price' && !moneyPattern.test(value) )  || ( jQuery(this).attr('id')=='equipment_noof_items' && !anynumberPattern.test(value) ) ) {
	                jQuery(this).addClass('error');
    	            jQuery(this).effect("shake", { times:3 }, 50);
        	        error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });
		
        if(!error) {
       	    jQuery('#progress_text').html('80% Complete');
	        jQuery('#progress').css('width','272px');
        	jQuery('#step_4').slideDown();	
            jQuery('#step_3').slideUp();
			jQuery('html, body').animate({scrollTop:0}, 'slow');   
        } else return false;
          
    });
	
jQuery(document).ready(function(){
	jQuery('#hear_from').change(function() {
		change_refresh_changes();
	});	
});	

	
	function change_refresh_changes(){
		hereform = jQuery('#hear_from').val();
		if( hereform=='Other' ){
			jQuery("#ad_hereabout_other_tr").show();
		} else {
			jQuery("#ad_hereabout_other_tr").hide();
		}
		
		property_is_for = jQuery('#property_is_for').val();
		if( property_is_for=='For Lease' || property_is_for=='For Sale/Lease' ){
			jQuery("#lease_details").show();
		} else {
			jQuery("#lease_details").hide();
		}
		
	}
	
change_refresh_changes();