jQuery.noConflict();
jQuery(document).ready(function(){
    //original field values
    var field_values = {
            //id        :  value
            'hear_from'  : 'hear_from',
			'ad_title'  : 'ad_title',
			'ad_firstname'  : 'ad_firstname',
			'ad_surname'  : 'ad_surname',
			'ad_email'  : 'ad_email',
			'ad_contactnumber'  : 'ad_contactnumber',
			'ad_advertisem'  : 'ad_advertisem',
			'ad_practice_name2'  : 'ad_practice_name2',
			'ad_practice_phone2'  : 'ad_practice_phone2',
			'ad_address2'  : 'ad_address2',
			'ad_suburb2'  : 'ad_suburb2',
			'ad_postcode'  : 'ad_postcode',
			'ad_state'  : 'ad_state',
			'ad_country'  : 'ad_country',
			'position_headline'  : 'position_headline',
			'position_desc'  : 'position_desc',
			'up_image'  : 'up_image',
            'practice_type'  : 'practice_type',
            'position_available' : 'position_available',
			'position_available-other' : 'position_available-other',
			'position_hours' : 'position_hours',
			'position_salary' : 'position_salary',
			'position_salary_experience' : 'position_salary_experience',
			'position_super' : 'position_super',
			'position_benefits_1' : 'position_benefits_1',
			'position_benefits_2' : 'position_benefits_2',
			'position_benefits_3' : 'position_benefits_3',
			'position_benefits_4' : 'position_benefits_4',
			'position_benefits_5' : 'position_benefits_5',
			'position_financial_incentives' : 'position_financial_incentives',
			'position_benefits_6' : 'position_benefits_6',
			'position_personal_opportunities' : 'position_personal_opportunities',
			'position_benefits_7' : 'position_benefits_7',
			'position_benefits_other' : 'position_benefits_other',
			'position_skills_required_1' : 'position_skills_required_1',
			'position_skills_required_2' : 'position_skills_required_2',
			'position_skills_required_3' : 'position_skills_required_3',
			'position_skills_required_4' : 'position_skills_required_4',
			'position_qualifications_required_1' : 'position_qualifications_required_1',
			'position_qualifications_required_2' : 'position_qualifications_required_2',
			'position_qualifications_required_3' : 'position_qualifications_required_3',
			'position_qualifications_required_4' : 'position_qualifications_required_4',
			'position_qualifications_required_5' : 'position_qualifications_required_5',
			'position_practice_potential' : 'position_practice_potential',
			'position_local_attractions' : 'position_local_attractions'
    };


    //inputfocus
    /*jQuery('input#ad_firstname').inputfocus({ value: field_values['ad_firstname'] });
    jQuery('input#password').inputfocus({ value: field_values['password'] });
    jQuery('input#cpassword').inputfocus({ value: field_values['cpassword'] }); 
    jQuery('input#lastname').inputfocus({ value: field_values['lastname'] });
    jQuery('input#firstname').inputfocus({ value: field_values['firstname'] });
    jQuery('input#email').inputfocus({ value: field_values['email'] }); 
*/


	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; 
	var numberPattern = /^[0-9]{8,10}$/; 
    //reset progress bar
	jQuery('.form input[type=radio]').css('width','0');
	jQuery('.form input[type=checkbox]').css('width','0');
    jQuery('#progress').css('width','0');
    jQuery('#progress_text').html('0% Complete');
	jQuery("#progress_bar").animate({scrollTop:0}, 'slow');
    //first_step
    jQuery('form').submit(function(){ return false; });
	
    jQuery('#submit_1').click(function(){
        //remove classes
        jQuery('#step_1 input').removeClass('error').removeClass('valid');

        //ckeck if inputs aren't empty
        var fields = jQuery('#step_1 input[type=text],select');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
			// console.log('error='+error+'this='+jQuery(this).attr('id'));
            if( value.length<1 || value==field_values[jQuery(this).attr('id')]|| ( jQuery(this).attr('id')=='ad_email' && !emailPattern.test(value))|| ( jQuery(this).attr('id')=='ad_contactnumber' && !numberPattern.test(value)) || ( jQuery(this).attr('id')=='ad_advertisement' && !numberPattern.test(value))) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });        
		
        if(!error) {
            if( jQuery('#password').val() != jQuery('#cpassword').val() ) {
                    jQuery('#step_1 input[type=password]').each(function(){
                        jQuery(this).removeClass('valid').addClass('error');
                        jQuery(this).effect("shake", { times:3 }, 50);
                    });
                    
                    return false;
            } else {   
                //update progress bar
                jQuery('#progress_text').html('10% Complete');
                jQuery('#progress').css('width','33px');
                
                //slide steps
                jQuery('#step_1').slideUp();
                jQuery('#step_2').slideDown();  
				jQuery('html, body').animate({scrollTop:100}, 'slow');   
            }               
        } else return false;
    });

 jQuery('#step1').click(function(){
	    		jQuery('#progress_text').html('0% Complete');
                jQuery('#progress').css('width','0px');
                
                //slide steps
				jQuery('#step_2').slideUp(); 
                jQuery('#step_1').slideDown();
                
	  });
	  jQuery('#step2').click(function(){
	    		jQuery('#progress_text').html('10% Complete');
                jQuery('#progress').css('width','33px');
                
                //slide steps
				jQuery('#step_3').slideUp(); 
                jQuery('#step_2').slideDown();
                
	  });
	  jQuery('#step3').click(function(){
	    		jQuery('#progress_text').html('20% Complete');
                jQuery('#progress').css('width','66px');
                
                //slide steps
				jQuery('#step_4').slideUp(); 
                jQuery('#step_3').slideDown();
                
	  });
	  jQuery('#step4').click(function(){
	    		jQuery('#progress_text').html('30% Complete');
                jQuery('#progress').css('width','99px');
                
                //slide steps
				jQuery('#step_5').slideUp(); 
                jQuery('#step_4').slideDown();
                
	  });
	  jQuery('#step5').click(function(){
	    		jQuery('#progress_text').html('40% Complete');
                jQuery('#progress').css('width','132px');
                
                //slide steps
				jQuery('#step_6').slideUp(); 
                jQuery('#step_5').slideDown();
                
	  });
	  jQuery('#step6').click(function(){
	    		jQuery('#progress_text').html('50% Complete');
                jQuery('#progress').css('width','165px');
                
                //slide steps
				jQuery('#step_7').slideUp(); 
                jQuery('#step_6').slideDown();
                
	  });
	  jQuery('#step7').click(function(){
	    		jQuery('#progress_text').html('60% Complete');
                jQuery('#progress').css('width','198px');
                
                //slide steps
				jQuery('#step_8').slideUp(); 
                jQuery('#step_7').slideDown();
                
	  });
	  jQuery('#step8').click(function(){
	    		jQuery('#progress_text').html('70% Complete');
                jQuery('#progress').css('width','231px');
                
                //slide steps
				jQuery('#step_9').slideUp(); 
                jQuery('#step_8').slideDown();
                
	  });
	  jQuery('#step9').click(function(){
	    		jQuery('#progress_text').html('80% Complete');
                jQuery('#progress').css('width','264px');
                
                //slide steps
				jQuery('#step_10').slideUp(); 
                jQuery('#step_9').slideDown();
                
	  });
	  jQuery('#step10').click(function(){
	    		jQuery('#progress_text').html('90% Complete');
                jQuery('#progress').css('width','297px');
                
                //slide steps
				jQuery('#step_11').slideUp(); 
                jQuery('#step_10').slideDown();
                
	  });
	  ///////////
    jQuery('#submit_2').click(function(){
        //remove classes
        jQuery('#step_2 input').removeClass('error').removeClass('valid');

         
        var fields = jQuery('#step_2 input[type=text]');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
			 console.log('error='+error+'this='+jQuery(this).attr('id'));
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='ad_practice_phone2' && !numberPattern.test(value) ) || ( jQuery(this).attr('id')=='ad_postcode' && !numberPattern.test(value) )) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('20% Complete');
                jQuery('#progress').css('width','66px');
                
                //slide steps
                jQuery('#step_2').slideUp();
                jQuery('#step_3').slideDown();  
				jQuery('html, body').animate({scrollTop:100}, 'slow');   
        } else return false;

    });


    jQuery('#submit_3').click(function(){
         jQuery('#step_3 input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = jQuery('#step_3 input[type=text]');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('30% Complete');
                jQuery('#progress').css('width','99px');
                
                //slide steps
                jQuery('#step_3').slideUp();
                jQuery('#step_4').slideDown();  
				jQuery('html, body').animate({scrollTop:100}, 'slow');   
        } else return false;
          
    });
   jQuery('#submit_4').click(function(){
        //remove classes
        jQuery('#step_4 input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = jQuery('#step_4 textarea[name=position_desc]');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('40% Complete');
                jQuery('#progress').css('width','132px');
                
                //slide steps
                jQuery('#step_4').slideUp();
                jQuery('#step_5').slideDown();  
				jQuery('html, body').animate({scrollTop:100}, 'slow');   
        } else return false;

    });
   jQuery('#submit_5').click(function(){
        //remove classes
        jQuery('#step_5 input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = jQuery('#step_5 input[type=file]');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('50% Complete');
                jQuery('#progress').css('width','165px');
                
                //slide steps
                jQuery('#step_5').slideUp();
                jQuery('#step_6').slideDown();   
				jQuery('html, body').animate({scrollTop:100}, 'slow');  
        } else return false;

    });
	jQuery('#submit_6').click(function(){
        //remove classes
        jQuery('#step_6 input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = jQuery('#step_6 input[type=text]');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('60% Complete');
                jQuery('#progress').css('width','198px');
                
                //slide steps
                jQuery('#step_6').slideUp();
                jQuery('#step_7').slideDown(); 
				jQuery('html, body').animate({scrollTop:100}, 'slow');    
        } else return false;

    });
	jQuery('#submit_7').click(function(){
        //remove classes
        jQuery('#step_7 input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = jQuery('#step_7 input[type=text]');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('70% Complete');
                jQuery('#progress').css('width','231px');
                
                //slide steps
                jQuery('#step_7').slideUp();
                jQuery('#step_8').slideDown(); 
				jQuery('html, body').animate({scrollTop:100}, 'slow');    
        } else return false;

    });
	jQuery('#submit_8').click(function(){
        //remove classes
        jQuery('#step_8 input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = jQuery('#step_8 input[type=text]');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('80% Complete');
                jQuery('#progress').css('width','264px');
                
                //slide steps
                jQuery('#step_8').slideUp();
                jQuery('#step_9').slideDown(); 
				jQuery('html, body').animate({scrollTop:100}, 'slow');    
        } else return false;

    });
	jQuery('#submit_9').click(function(){
        //remove classes
        jQuery('#step_9 input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = jQuery('#step_2 input[type=text]');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('90% Complete');
                jQuery('#progress').css('width','297px');
                
                //slide steps
                jQuery('#step_9').slideUp();
                jQuery('#step_10').slideDown(); 
				jQuery('html, body').animate({scrollTop:100}, 'slow');    
        } else return false;

    });
	jQuery('#submit_10').click(function(){
        //remove classes
        jQuery('#step_10 input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = jQuery('#step_2 input[type=text]');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='email' && !emailPattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('100% Complete');
                jQuery('#progress').css('width','328px');
                
                //slide steps
                jQuery('#step_10').slideUp();
                jQuery('#step_11').slideDown(); 
				jQuery('html, body').animate({scrollTop:100}, 'slow');    
        } else return false;

    });

    jQuery('#submit_11').click(function(){
        //send information to server
        alert('Data sent');
    });

});