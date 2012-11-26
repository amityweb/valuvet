jQuery.noConflict();
var max_images = 0;
function stopRKey(evt) {
   var evt = (evt) ? evt : ((event) ? event : null);
   var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
   if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}

document.onkeypress = stopRKey; 

String.prototype.capitalize = function(){
   return this.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );
  };
  
function word_counter( elementid, word, countlocation, remainlocation ){
	var message1 = document.getElementById( elementid );
	var len1 = message1.value.split(" ").length;
	
	if( countlocation!='' )	document.getElementById(countlocation).innerHTML = len1;
	if( remainlocation!='' ) document.getElementById(remainlocation).innerHTML = word - len1;
	
	if (len1 > word) {
        message1.value = message1.value.substring(0, word); 
        len1--; 
		alert("Message limited to " + word + " words.");
		return false;
	}
}

jQuery(document).ready(function(){
	jQuery("#booking_farm").validate({
		ignore:":not(:visible)",
		rules:{
			hear_from:{
				selectnone:true
				},
			
			ad_hearabout_other:{
				required:true
				
				},
	ad_booking:{
	selectnone:true	
		
	},
	ad_title:{
		required:true
	
	},
	ad_firstname:{
	letteronly:true,
	required:true
	
	},
	ad_surname:{
	required:true,
	letteronly:true
		},
	ad_email:{
	required:true,
	email:true
			
	},
	ad_contactnumber:{
			required:true,
			digits:true
					
		},
	ad_advertisement:{
			required:true
				},
			ad_practice_name:{
				required:true,
				letteronly:true
						},
				practice_phone_number:{
					required:true,
						digits:true
						},
				ad_address:{
					required:true
						},
					ad_suburb:{
						required:true
							},
					post_code:{
					required:true,
						digits:true
						},
					ad_state:{
						selectnone:true
							},
						ad_country:{
							required:true
							},
						ad_headline:{
							required:true
								},
							ad_short_desc:{
							required:true
								},
								ad_full_desc:{
								required:true
									},
							ad_buliding_size:{
									digits:true
									},
							ad_number_clinics:{
									digits:true
									},
								ad_open_days:{
									digits:true
															
								},
							ad_parking_number:{
						digits:true
							},
						ad_number_computers:{
							
							digits:true
							},
							ad_number_vets:{
								digits:true
								},
					ad_number_nurse:{
						digits:true
						},
						ad_value_property:{
							number:true
							},
							ad_value_stock_equip:{
								
								number:true
								},
								ad_value_goodwill:{
									number:true
									
									},
									ad_value_asking:{
										number:true
										
								},
								ad_software_other:{
									
									digits:true
									},
									ad_species_small_animal:{
										number:true
										
										},
										ad_species_equine:{
											
											number:true
											},
											ad_species_bovine:{
												number:true
												},
												ad_species_other:{
													number:true
													
													}	
									
			
			}
		
		});
		
});
		
			

jQuery(document).ready(function(){
	jQuery('#hear_from').change(function() {
		  var data=jQuery("#hear_from").val();
		  if(data=='Other') {
			  jQuery("#ad_hereabout_other_tr").show();
		  } else {
			  jQuery("#ad_hereabout_other_tr").hide();
	  	  }	
	});	
	
	jQuery('#ad_software').change(function() {
		  var data=jQuery("#ad_software").val();
		  if(data=='Other') {
			  jQuery("#other_software_display").show();
		  } else {
			  jQuery("#other_software_display").hide();
	  	  }	
	});	
	
	jQuery('#off_street_parking').change(function() {
		  var data=jQuery("#off_street_parking").val();
		  if(data=='Yes') {
			  jQuery("#show_offstreet_parking").show();
		  } else {
			  jQuery("#show_offstreet_parking").hide();
	  	  }	
	});	
	
	
	
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
			'ad_advertisem'  : 'ad_advertisem',
			'ad_practice_name'  : 'ad_practice_name',
			'practice_phone_number'  : 'practice_phone_number',
			'ad_address'  : 'ad_address',
			'ad_suburb'  : 'ad_suburb',
			'post_code'  : 'post_code',
			'ad_state'  : 'ad_state',
			'ad_country'  : 'ad_country',
			'position_headline'  : 'position_headline',
			'position_desc'  : 'position_desc',
			'up_image'  : 'up_image',
            'ad_type'  : 'ad_type',
            'ad_ownership' : 'ad_ownership',
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

	function create_pkg1_preview(){
		jQuery("#pkg1_title").html( jQuery("#post_title").val() );
		jQuery("#pkg1_business_name").html( jQuery("#practice_name").val() );
		jQuery("#pkg1_business_address").html( jQuery("#business_address").val() +' '+ jQuery("#suburb").val() +' '+ jQuery("#post_code").val() );
		jQuery("#pkg1_contact_name").html( jQuery("#ad_firstname").val() );
		jQuery("#pkg1_contact_phone").html( jQuery("#ad_advertisement").val() );

		var stock_on_sale = jQuery('#stock_on_sale').val();
		var equipments_on_sale = jQuery('#equipments_on_sale').val();
		
		if( stock_on_sale=='include' ){
			var stock = jQuery('#stock').val() ? jQuery('#stock').val() : 0;
		} else {
			var stock = 0;
		}
		if( equipments_on_sale=='include' ){
			var equipments = jQuery('#equipments').val() ? jQuery('#equipments').val() : 0;
		} else {
			var equipments = 0;
		}
		jQuery("#pkg1_askingprice").html( parseFloat( jQuery("#property_value").val() ) + parseFloat(stock) + parseFloat(equipments) );
	}
	
	function create_pkg2_preview(){
		jQuery("#pkg2_title").html( jQuery("#post_title").val() );
		jQuery("#pkg2_business_name").html( jQuery("#practice_name").val() );
		jQuery("#pkg2_business_address").html( jQuery("#business_address").val() +' '+ jQuery("#suburb").val() +' '+ jQuery("#post_code").val() );
		jQuery("#pkg2_contact_name").html( jQuery("#ad_firstname").val() );
		jQuery("#pkg2_contact_phone").html( jQuery("#ad_advertisement").val() );


		var stock_on_sale = jQuery('#stock_on_sale').val();
		var equipments_on_sale = jQuery('#equipments_on_sale').val();
		
		if( stock_on_sale=='include' ){
			var stock = jQuery('#stock').val() ? jQuery('#stock').val() : 0;
		} else {
			var stock = 0;
		}
		if( equipments_on_sale=='include' ){
			var equipments = jQuery('#equipments').val() ? jQuery('#equipments').val() : 0;
		} else {
			var equipments = 0;
		}
		jQuery("#pkg2_askingprice").html( parseFloat( jQuery("#property_value").val() ) + parseFloat(stock) + parseFloat(equipments) );
		jQuery("#pkg2_overview").html( jQuery("#ad_short_desc").val() );
	}
	
	function create_overview(){
		output = '';
		show=false
		output += '<ul class="bullet_list">';
		if( jQuery("#property_is_for").val()!='' ) { output += '<li><span class="bull tri">Real Estate: '+jQuery("#property_is_for").val()+'</span></li>' ; show = true; }
		if( jQuery("#property_is_for").val()!='' && jQuery("#property_is_for").val()!='For Sale'   ) { output += '<li><span class="bull tri">Lease Details: '+jQuery("#lease_details").val()+'</span></li>' ; show = true; }
		if( jQuery("#real_estate_available_for_sale").val()=='For Lease' ) { output += '<li><span class="bull tri">Real Estate : For Lease</span></li>' ; show = true; }
		if( jQuery("#real_estate_available_for_sale").val()=='For Lease' ) { output += '<li><span class="bull tri">Lease details : '+jQuery("#re_lease_details").val()+'</span></li>' ; show = true; }
		if( jQuery("#equipments_on_sale").val()!='' ) { output += '<li><span class="bull tri">Equipment: <span style="text-transform:capitalize">'+jQuery("#equipments_on_sale").val()+'</span></span></li>' ; show = true; }
		if( jQuery("#stock_on_sale").val()!='' ) { output += '<li><span class="bull tri">Stock:  <span style="text-transform:capitalize">'+jQuery("#stock_on_sale").val()+'</span></span></li>' ; show = true; }
		if( jQuery("#valuation_by_valuvet").val()!='' && jQuery("#valuation_by_valuvet").val()=='Yes' ) { output += '<li><span class="bull tri">ValuVet Valuation: Available</span></li>' ; show = true; }
		if( jQuery("#valuation_by_valuvet").val()!='' && jQuery("#valuation_by_valuvet").val()=='No' ) { output += '<li><span class="bull tri">ValuVet Valuation: Not Available</span></li>' ; show = true; }
		if( jQuery("#practice_report_by_valuvet").val()!='' && jQuery("#practice_report_by_valuvet").val()=='Yes' ) { output += '<li><span class="bull tri">Valuvet Report: Available</span></li>' ; show = true; }
		if( jQuery("#practice_report_by_valuvet").val()!='' && jQuery("#practice_report_by_valuvet").val()=='No' ) { output += '<li><span class="bull tri">Valuvet Report: Not Available</span></li>' ; show = true; }
		output += '</ul><p>&nbsp;</p>';
		if(show==true) jQuery("#pkg3_overview").html( output );
	}
	
	
	function create_staff(){
		show = false;
	
		output = '<ul id="headline"><li><span class="button_left">Staff</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
		output += '<ul class="bullet_list">';
		if( jQuery("#noof_vets").val()!='' )  { output += '<li><span class="bull tri">Number of full-time vet: '+jQuery("#noof_vets").val()+'</span></li>' ; show = true; }
		if( jQuery("#noof_nurse").val()!='' )  { output += '<li><span class="bull tri">Number of full-time nurse: '+jQuery("#noof_nurse").val()+'</span></li>' ; show = true; }
		if( jQuery("#practice_manager").val()!='' )  { output += '<li><span class="bull tri">Practice Manager: '+ jQuery("#practice_manager").val() +'</span></li>'; show = true; }
		output += '</ul><p>&nbsp;</p>';
		if(show==true) jQuery("#pkg3_staff").html( output );
	}
	
	function type_of_practice(){
		show = false;
		output = '<ul id="headline"><li><span class="button_left">Type of Practice</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
		output += '<ul class="bullet_list">';
		if( jQuery("#type_of_practice").val()!='' && jQuery("#type_of_practice").val()=='Other' )  { output += '<li><span class="bull tri">Type of Practice: '+jQuery("#type_of_practice").val()+'</span></li>' ; show = true; }
		if( jQuery("#small_animal_precentage").val()!='' ) {
			show = true;
			first = false;
			last = false;
				output += '<li><span class="bull tri">'+jQuery("#small_animal_precentage").val()+'% (' ;
				if( jQuery('#canine').is(':checked') ) { 
					output += 'Canine'; 
					if(!first) {
						first=true;
					} 
				}
				if( jQuery('#feline').is(':checked') ) { if(first) {output += ', ';} output += 'Feline'; if(!first) {first=true;} }
				if( jQuery('#avian').is(':checked') ) { if(first) {output += ', ';} output += 'Avian'; if(!first) {first=true;} }
				if( jQuery('#exotics').is(':checked') ) { if(first) {output += ', ';} output += 'Exotics'; if(!first) {first=true;} }
				if( jQuery('#fauna').is(':checked') ) { if(first) {output += ', ';} output += 'Fauna'; if(!first) {first=true;} }
				output += ')</span></li>';
		}
		if( jQuery("#equine_presentage").val()!='' ) {
			show = true;
			first = false;
			last = false;
				output += '<li><span class="bull tri">'+jQuery("#equine_presentage").val()+'% (' ;
				if( jQuery('#pleasure').is(':checked') ) { if(first) {output += ', ';} output += 'Pleasure'; if(!first) {first=true;} }
				if( jQuery('#equine_stud').is(':checked') ) { if(first) {output += ', ';} output += 'Stud'; if(!first) {first=true;} }
				if( jQuery('#equine_stables').is(':checked') ) { if(first) {output += ', ';} output += 'Stables'; if(!first) {first=true;} }
				output += ')</span></li>';
		}
		if( jQuery("#bovine_presentage").val()!='' ) {
			show = true;
			first = false;
			last = false;
				output += '<li><span class="bull tri">'+jQuery("#bovine_presentage").val()+'% (' ;
				if( jQuery('#beef').is(':checked') ) { if(first) {output += ', ';} output += 'Beef'; if(!first) {first=true;} }
				if( jQuery('#dairy').is(':checked') ) { if(first) {output += ', ';} output += 'Dairy'; if(!first) {first=true;} }
				if( jQuery('#bovine_stud').is(':checked') ) { if(first) {output += ', ';} output += 'Stud'; if(!first) {first=true;} }
				output += ')</span></li>';
		}
		if( jQuery("#other_presentage").val()!='' ) {
			show = true;
			first = false;
			last = false;
				output += '<li><span class="bull tri">'+jQuery("#other_presentage").val()+'% (' ;
				if( jQuery('#porcine').is(':checked') ) { if(first) {output += ', ';} output += 'Porcine'; if(!first) {first=true;} }
				if( jQuery('#ovine').is(':checked') ) { if(first) {output += ', ';} output += 'Ovine'; if(!first) {first=true;} }
				if( jQuery('#caprine').is(':checked') ) { if(first) {output += ', ';} output += 'Caprine'; if(!first) {first=true;}}
				if( jQuery('#camelid').is(':checked') ) { if(first) {output += ', ';} output += 'Camelid'; if(!first) {first=true;}}
				output += ')</span></li>';
		}
		if( jQuery("#other_extra_details").val()!=''  )  { output += '<li><span class="bull tri">Other: '+jQuery("#other_extra_details").val()+'</span></li>' ; show = true; }

		output += '</ul><p>&nbsp;</p>';
		if(show==true) jQuery("#pkg3_practice").html( output );
	}

	function create_facilities(){
	show = false;

		output = '<ul id="headline"><li><span class="button_left">Facilities</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
		output += '<ul class="bullet_list">';
		if( jQuery("#building_type").val()!='' )  { output += '<li><span class="bull tri">Building Type: '+jQuery("#building_type").val()+'</span></li>'; show = true; }
		if( jQuery("#building_ownership").val()!='' && jQuery("#building_ownership").val()=='Building Owned'  )  { output += '<li><span class="bull tri">Property: Owned</span></li>' ; show = true; }
		if( jQuery("#building_type").val()!='' && jQuery("#building_ownership").val()=='Building Rented' )  { output += '<li><span class="bull tri">Property: Rented</span></li>' ; show = true; }
		if( jQuery("#number_of_days_open_per_week").val()!='' )  { output += '<li><span class="bull tri">Opened: '+jQuery("#number_of_days_open_per_week").val()+' Days</span></li>' ; show = true; }
		
		if( jQuery("#kennels").val()=='Yes' || jQuery("#stables").val()=='Yes' )  { 
			output += '<li><span class="bull tri">Facilities include : '; 
			first = false;
			last = false;
				if( jQuery("#kennels").val()=='Yes' )  { if(first) {output += ', ';} output += 'Kennels';if(!first) {first=true;} }
				if( jQuery("#stables").val()=='Yes' )  { if(first) {output += ', ';} output += 'Stables';if(!first) {first=true;} }
			output += '</li>' ; show = true; 
		}

		if( jQuery("#number_of_branch_clinics").val()!='' )  { output += '<li><span class="bull tri">Number of clinics: '+jQuery("#number_of_branch_clinics").val()+'</span></li>' ; show = true; }
		if( jQuery("#off_street_parking").val()!='' && jQuery("#off_street_parking").val()=='Yes' )  { output += '<li><span class="bull tri">Number of Carparks: '+jQuery("#no_of_off_street_cars").val()+'</span></li>' ; show = true; }
		if( jQuery("#number_of_computer_terminals").val()!='' )  { output += '<li><span class="bull tri">Number of Computers: '+jQuery("#number_of_computer_terminals").val()+'</span></li>' ; show = true; }
		if( jQuery("#ad_software").val()!='' && jQuery("#ad_software").val()=='Other' ) { output += '<li><span class="bull tri">Software: '+jQuery("#other_software").val()+'</span></li>' ; show = true; }
		if( jQuery("#ad_software").val()!='' && jQuery("#ad_software").val()!='Other' ) { output += '<li><span class="bull tri">Software: '+jQuery("#ad_software").val()+'</span></li>' ; show = true; }
		output += '</ul><p>&nbsp;</p>';
		if(show==true) jQuery("#pkg3_facilities").html( output );
	}
	
	function professional_services(){
		show = false;
		output = '<ul id="headline"><li><span class="button_left">Professional Services</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
		output += '<ul class="bullet_list">';
			if( jQuery('#medicine').is(':checked') )  { output += '<li><span class="bull tri">Medicine</span></li>' ; show = true; }
			if( jQuery('#surgery').is(':checked') )  { output += '<li><span class="bull tri">Surgery</span></li>' ; show = true; }
			if( jQuery('#dentistry').is(':checked') )  { output += '<li><span class="bull tri">Dentistry</span></li>' ; show = true; }
			if( jQuery('#behaviour').is(':checked') )  { output += '<li><span class="bull tri">Behaviour</span></li>' ; show = true; }
			if( jQuery('#emergency_service').is(':checked') )  { output += '<li><span class="bull tri">Emergency Service</span></li>' ; show = true; }
			if( jQuery('#diagnostic_laboratory').is(':checked') )  { output += '<li><span class="bull tri">Diagnostic Laboratory</span></li>' ; show = true; }
			if( jQuery('#radiology').is(':checked') )  { output += '<li><span class="bull tri">Radiology</span></li>' ; show = true; }
			if( jQuery('#ultrasound').is(':checked') )  { output += '<li><span class="bull tri">Ultrasound</span></li>' ; show = true; }
			if( jQuery('#specialist').is(':checked') )  { output += '<li><span class="bull tri">Specialist</span></li>' ; show = true; }
			if( jQuery('#house_calls').is(':checked') )  { output += '<li><span class="bull tri">House Calls</span></li>' ; show = true; }
			if( jQuery('#endoscopy').is(':checked') )  { output += '<li><span class="bull tri">Endoscopy</span></li>' ; show = true; }
			if( jQuery("#other_professional_services").val()!=''  )  { output += '<li><span class="bull tri">Other: '+jQuery("#other_professional_services").val()+'</span></li>' ; show = true; }
		output += '</ul><p>&nbsp;</p>';
		if(show==true) jQuery("#pkg3_pro_service").html( output );
	}
	

	
	function ancillary_services(){
		show = false;
		output = '<ul id="headline"><li><span class="button_left">Ancillary Services</span> <span class="button_right buttonsidebar">&nbsp;</span></li></ul>';
		output += '<ul class="bullet_list">';
			if( jQuery('#grooming').is(':checked') )  { output += '<li><span class="bull tri">Grooming</span></li>' ; show = true; }
			if( jQuery('#puppy_school').is(':checked'))  { output += '<li><span class="bull tri">Puppy School</span></li>' ; show = true; }
			if( jQuery('#boarding').is(':checked'))  { output += '<li><span class="bull tri">Boarding</span></li>' ; show = true; }
			if( jQuery('#merchandising').is(':checked') )  { output += '<li><span class="bull tri">Merchandising</span></li>' ; show = true; }
			if( jQuery('#export_certificate').is(':checked') )  { output += '<li><span class="bull tri">Export Certificate</span></li>' ; show = true; }
			
			if( jQuery("#other_ancillary_services").val()!=''  )  { output += '<li><span class="bull tri">Other: '+jQuery("#other_ancillary_services").val()+'</span></li>' ; show = true; }
		output += '</ul><p>&nbsp;</p>';
		if(show==true) jQuery("#pkg3_anc_services").html( output );
	}
	
	function create_map(){
		var address =  jQuery("#business_address").val() +' '+ jQuery("#suburb").val() +' '+ jQuery("#post_code").val();
		var urlencode = encodeURIComponent(address);
		jQuery("#pkg3_map").html( '<iframe width="600" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com.au/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q="+urlencode+"&amp;aq=&amp;sll=-25.335448,135.745076&amp;sspn=64.389233,135.263672&amp;ie=UTF8&amp;hq=&amp;hnear=4%2F54+Myrtle+St,+Heidelberg+Heights+Victoria+3081&amp;t=m&amp;ll=-37.754769,145.053005&amp;spn=0.016965,0.051413&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>' );
	}



	function create_pkg3_preview(){
		for(k=0; k<=8; k++){
			jQuery("#prev_image_desc"+k).html('');
		} 
		jQuery("#pkg3_title").html( jQuery("#post_title").val() );
		jQuery("#pkg3_business_name").html( jQuery("#practice_name").val() );
		jQuery("#pkg3_business_address").html( jQuery("#business_address").val() +' '+ jQuery("#suburb").val().capitalize() +' '+ jQuery("#post_code").val() );
		jQuery("#pkg3_contact_name").html( jQuery("#user_title").val() + ' ' + jQuery("#ad_firstname").val().capitalize()+ ' ' + jQuery("#ad_surname").val().capitalize() );
		jQuery("#pkg3_contact_phone").html( jQuery("#ad_advertisement").val() );
		var stock_on_sale = jQuery('#stock_on_sale').val();
		var equipments_on_sale = jQuery('#equipments_on_sale').val();
		
		if( stock_on_sale=='include' ){
			var stock = jQuery('#stock').val() ? jQuery('#stock').val() : 0;
		} else {
			var stock = 0;
		}
		if( equipments_on_sale=='include' ){
			var equipments = jQuery('#equipments').val() ? jQuery('#equipments').val() : 0;
		} else {
			var equipments = 0;
		}
		jQuery("#pkg3_askingprice").html( String( jQuery("#property_value").val() )  );
		create_map();
		create_overview();
		create_facilities();
		create_staff();
		professional_services();
		ancillary_services()
		type_of_practice();
		jQuery("#pkg3_shortdescription").html( jQuery("#ad_short_desc").val() );
		jQuery("#pkg3_business").html( jQuery("#the_business").val() );
		jQuery("#pkg3_opportunity").html( jQuery("#the_opportunity").val() );
		jQuery("#pkg3_location").html( jQuery("#the_location").val() );

		for(k=0; k<=8; k++){
			if( jQuery("#more_upload_description_"+k).val()!='' ) jQuery("#prev_image_desc"+k).html( jQuery("#more_upload_description_"+k).val() );
		} 
	}
	
	
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; 
	var numberPattern = /^[0-9]{10}$/; 
	var postcodepattern = /^[0-9]{4,5}$/;
    //reset progress bar
	jQuery('.form input[type=radio]').css('width','0');
	jQuery('.form input[type=checkbox]').css('width','0');
    jQuery('#progress').css('width','0');
    jQuery('#progress_text').html('0% Complete');
	jQuery("#progress_bar").animate({scrollTop:0}, 'slow');
    //first_step
    jQuery('form').submit(function(){ return false; });
	
	function make_noof_images(){
		pkg_id = jQuery('#pkg_id').val();
		if( pkg_id=='package_2' ){
			jQuery("#get_noof_images").val(1);
			max_images = 1;
		} else if( pkg_id=='package_3' ) {
			jQuery("#get_noof_images").val(8);
			max_images = 8;
		} else {
			jQuery("#get_noof_images").val(0);
			max_images = 0;
		}
		jQuery("#noofimages_can_upload").html('You can upload '+max_images+' images');
	}
	
	function change_package_items(){
		  pkgvalue = jQuery('#pkg_id').val();
		  if( pkgvalue=='package_2' ){
			  jQuery('#pkg_short_description').show();
			  jQuery('#the_business_tr').hide();
			  jQuery('#the_opportunity_tr').hide();
			  jQuery('#the_location_tr').hide();
			  jQuery('#img_upload').show();
			  jQuery('#img_upload_pkg3').hide();
			  jQuery('#pkg1_preview').hide();
			  jQuery('#pkg2_preview').show();
			  jQuery('#pkg3_preview').hide();
		  } else if ( pkgvalue=='package_3' ){
			  jQuery('#pkg_short_description').show();
			  jQuery('#the_business_tr').show();
			  jQuery('#the_opportunity_tr').show();
			  jQuery('#the_location_tr').show();
			  jQuery('#img_upload').show();
			  jQuery('#img_upload_pkg3').show();
			  jQuery('#pkg1_preview').hide();
			  jQuery('#pkg2_preview').hide();
			  jQuery('#pkg3_preview').show();
		  } else {
			  jQuery('#pkg_short_description').hide();
			  jQuery('#the_business_tr').hide();
			  jQuery('#the_opportunity_tr').hide();
			  jQuery('#the_location_tr').hide();
			  jQuery('#img_upload').hide();
			  jQuery('#img_upload_pkg3').hide();
			  jQuery('#pkg1_preview').show();
			  jQuery('#pkg2_preview').hide();
			  jQuery('#pkg3_preview').hide();
		  }
		  make_noof_images();
	}
	
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
			jQuery('#lease_details').val('');
			jQuery("#lease_details").hide();
		}
		
	}
	
	function change_property_is_for(){
		var property_is_for = jQuery('#property_is_for').val();
		if( property_is_for=='For Lease' || property_is_for=='For Sale/Lease' ){
			jQuery('#lease_details').show(200);
		} else {
			jQuery('#lease_details').val('');
			jQuery('#lease_details').hide(200);
		}
	}
	
	function change_realestate_is_for(){
		var property_is_for = jQuery('#real_estate_available_for_sale').val();
		if( property_is_for=='For Lease' ){
			jQuery('#realestate_lease_details').show(200);
			jQuery('#realestate_value_hide').hide(200);
		} else {
			jQuery('#realestate_lease_details').hide(200);
			jQuery('#re_lease_details').val('');
			jQuery('#realestate_value_hide').show(200);
		}
	}
	
	function change_type_of_practice(){
		var type_of_practice = jQuery('#type_of_practice').val();
		if( type_of_practice=='Other' ){
			jQuery('#show_type_of_practice_other').show(100);
		} else {
			jQuery('#show_type_of_practice_other').hide(100);
		}
	}
	
	change_package_items();
	change_refresh_changes();
	change_type_of_practice();
	
	//WORKS ON STEP 3
	jQuery('#pkg_id').change(function() {
		make_noof_images();
	});
	//WORKS ON STEP 3
	jQuery('#property_is_for').change(function() {
		change_property_is_for();
	});
	//WORKS ON STEP 3
	jQuery('#real_estate_available_for_sale').change(function() {
		change_realestate_is_for();
	});
	//WORKS ON STEP 3
	jQuery('#type_of_practice').change(function() {
		change_type_of_practice();
	});

 	jQuery('#step0').click(function(){
	    		jQuery('#progress_text').html('0% Complete');
                jQuery('#progress').css('width','0px');
                
				change_package_items();
                //slide steps
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
				jQuery('#step_1').slideUp(); 
                jQuery('#step_0').slideDown();
                
	  });
	
	
 	jQuery('#step1').click(function(){
	    		jQuery('#progress_text').html('5% Complete');
                jQuery('#progress').css('width','17px');
                
				change_package_items();
                //slide steps
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
				jQuery('#step_2').slideUp(); 
                jQuery('#step_1').slideDown();
                
	  });
	  jQuery('#step2').click(function(){
			pkgvalue = jQuery('#pkg_id').val();
		  	if( pkgvalue=='package_1' ){
		    	jQuery('#progress_text').html('30% Complete');
    	    	jQuery('#progress').css('width','102px');
			} else {
	    		jQuery('#progress_text').html('10% Complete');
	        	jQuery('#progress').css('width','66px');
			}
  				change_package_items();
				change_property_is_for();
				change_realestate_is_for();
                //slide steps
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
				jQuery('#step_3').slideUp(); 
                jQuery('#step_2').slideDown();
                
	  });
	  jQuery('#step3').click(function(){
			change_property_is_for();
			change_realestate_is_for();
									  
			pkgvalue = jQuery('#pkg_id').val();
		  	if( pkgvalue=='package_1' ){
		    	jQuery('#progress_text').html('50% Complete');
    	    	jQuery('#progress').css('width','170px');
			} else if( pkgvalue=='package_3' ) {
	    		jQuery('#progress_text').html('40% Complete');
                jQuery('#progress').css('width','136px');
			} else {
                jQuery('#progress_text').html('20% Complete');
                jQuery('#progress').css('width','68px');
			}

                //slide steps
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
                	jQuery('#step_3').slideDown();
					jQuery('#step_4').slideUp(); 
                
	  });
	  jQuery('#step2_3').click(function(){
			pkgvalue = jQuery('#pkg_id').val();
		  	if( pkgvalue=='package_3' ){
		    	jQuery('#progress_text').html('50% Complete');
    	    	jQuery('#progress').css('width','170px');
			} else {
		    	jQuery('#progress_text').html('60% Complete');
    	    	jQuery('#progress').css('width','204px');
			}

            //slide steps
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
				jQuery('#step_3_4').slideUp(); 
                jQuery('#step_4').slideDown();
                
	  });
	  jQuery('#step4').click(function(){
									  
	    		jQuery('#progress_text').html('40% Complete');
                jQuery('#progress').css('width','136px');
                
                //slide steps
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
				jQuery('#step_5').slideUp(); 
                jQuery('#step_3_4').slideDown();
                
	  });
	  jQuery('#step5').click(function(){
	    		jQuery('#progress_text').html('70% Complete');
                jQuery('#progress').css('width','238px');
                
                //slide steps
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
				jQuery('#step_6').slideUp(); 
                jQuery('#step_5').slideDown();
                
	  });
	  jQuery('#step6').click(function(){
		    		jQuery('#progress_text').html('75% Complete');
                	jQuery('#progress').css('width','255px');

                //slide steps
				jQuery('#step_7').slideUp(); 
   	            jQuery('#step_6').slideDown();
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
	  });
	  jQuery('#step7').click(function(){
				create_headline();
				jQuery('#step_8').slideUp(); 
				if( pkgvalue=='package_1'  ){
			    	jQuery('#progress_text').html('80% Complete');
    	    		jQuery('#progress').css('width','272px');
	                jQuery('#step_3').slideDown();
				} else if( pkgvalue=='package_2' ) {
			    	jQuery('#progress_text').html('80% Complete');
    	    		jQuery('#progress').css('width','272px');
	                jQuery('#step_3_4').slideDown();
				} else {
					jQuery('#progress_text').html('85% Complete');
					jQuery('#progress').css('width','289px');
					jQuery('#step_7').slideDown();
				}

                //slide steps
				jQuery('html, body').animate({scrollTop:0}, 'slow'); 
				jQuery('#step_8').slideUp(); 

	  });

	  ///////////
		
    jQuery('#submit_0').click(function(){
        //remove classes
        jQuery('#step_0 input').removeClass('error').removeClass('valid');
		change_package_items();
				
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
                jQuery('#progress_text').html('5% Complete');
                jQuery('#progress').css('width','17px');

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
		change_package_items();
				
        //ckeck if inputs aren't empty
        var fields = jQuery('#step_1 .step1p');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
			// console.log('error='+error+'this='+jQuery(this).attr('id'));
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='ad_email' && !emailPattern.test(value)) || ( jQuery(this).attr('id')=='ad_contactnumber' && !numberPattern.test(value)) || ( jQuery(this).attr('id')=='ad_advertisement' && !numberPattern.test(value))) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });        
        if(!error) {
                //update progress bar
			pkgvalue = jQuery('#pkg_id').val();
		  	if( pkgvalue=='package_1' ){
		    	jQuery('#progress_text').html('30% Complete');
    	    	jQuery('#progress').css('width','102px');
			} else {
                jQuery('#progress_text').html('10% Complete');
                jQuery('#progress').css('width','34px');
			}

                //slide steps
                jQuery('#step_1').slideUp();
                jQuery('#step_2').slideDown();  
				jQuery('html, body').animate({scrollTop:0}, 'slow');   
        } else return false;
    });
	
    jQuery('#submit_2').click(function(){
        //remove classes
        jQuery('#step_2 input').removeClass('error').removeClass('valid');
		change_property_is_for();
		change_realestate_is_for();
		
		var pkgvalue = jQuery('#pkg_id').val();	
        var fields = jQuery('#step_2 .step2p');
		
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
			 console.log('error='+error+'this='+jQuery(this).attr('id'));
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] || ( jQuery(this).attr('id')=='practice_phone_number' && !numberPattern.test(value) ) || ( jQuery(this).attr('id')=='post_code' && !postcodepattern.test(value) ) ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });
        if(!error) {
                //update progress bar
			jQuery("#street_name").val( jQuery("#business_address").val() );
			jQuery("#city").val( jQuery("#suburb").val() );
			jQuery("#zip_code").val( jQuery("#post_code").val() );
			jQuery("#state").val( jQuery("#practice_state").val() );
			
			
			
			pkgvalue = jQuery('#pkg_id').val();
		  	if( pkgvalue=='package_1' ){
		    	jQuery('#progress_text').html('50% Complete');
    	    	jQuery('#progress').css('width','170px');
			} else if( pkgvalue=='package_3' ) {				
	    		jQuery('#progress_text').html('40% Complete');
	        	jQuery('#progress').css('width','136px');
			} else {
	    		jQuery('#progress_text').html('20% Complete');
	        	jQuery('#progress').css('width','68px');
			}
             
		  	if( pkgvalue=='package_1' ){
                jQuery('#step_3').slideDown(); 
			} else {
                jQuery('#step_3').slideDown(); 
			}
                //slide steps
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
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] ) {
	                jQuery(this).addClass('error');
    	            jQuery(this).effect("shake", { times:3 }, 50);
        	        error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });
		
        if(!error) {
                //update progress bar
			pkgvalue = jQuery('#pkg_id').val();
		  	if( pkgvalue=='package_1' || pkgvalue=='package_2'  ){
		    	jQuery('#progress_text').html('80% Complete');
    	    	jQuery('#progress').css('width','272px');
			} else {
        	    jQuery('#progress_text').html('60% Complete');
		        jQuery('#progress').css('width','204px');
			}
		   
				if( pkgvalue=='package_2'  ){
				create_headline();
				create_pkg2_preview();
				}
               	jQuery('#step_3_4').slideDown();	
               jQuery('#step_4').slideUp();
                //slide steps
				jQuery('html, body').animate({scrollTop:0}, 'slow');   
        } else return false;
          
    });
	jQuery('#submit_4').click(function(){
        //remove classes
        jQuery('#step_3 input').removeClass('error').removeClass('valid');

        var fields = jQuery('#step_3 .step3p');
        var error = 0;
        fields.each(function(){
			var property_is_for = jQuery('#property_is_for').val();
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] ) {
				if( jQuery(this).attr('id')=='lease_details' && ( property_is_for=='Not For Sale' || property_is_for=='For Sale' )  ){
	                jQuery(this).addClass('valid');
				} else {
	                jQuery(this).addClass('error');
    	            jQuery(this).effect("shake", { times:3 }, 50);
        	        error++;
				}
            } else {
                jQuery(this).addClass('valid');
            }
        });
		if( jQuery('#type_of_practice').val()=='Other' && jQuery('#type_of_practice_other').val()=='' ){
                jQuery('#type_of_practice_other').addClass('error');
                jQuery('#type_of_practice_other').effect("shake", { times:3 }, 50);
                error++;
		}

		var property_value = get_formatted_price( jQuery('#property_value').val() );
			
		var tmpreval = "";
		if( jQuery('#real_estate_available_for_sale').val()=="For Lease" ) {
			var realestate_value = 0;
			tmpreval = tmpreval+'';
		} else {
			var realestate_value = get_formatted_price( jQuery('#realestate_value').val() );
			tmpreval = tmpreval+'Real Estate, ';
			if( realestate_value==0 || realestate_value=='' || isNaN( realestate_value ) ){
                jQuery('#pbreak').effect("shake", { times:3 }, 50);
				jQuery('#pbreak').html('<div style="color:#900;">Real Estate value can not be empty</style>');
                error++;
			}
		}
		
		var stock_on_sale = jQuery('#stock_on_sale').val();
		var equipments_on_sale = jQuery('#equipments_on_sale').val();
		var realestate_value = jQuery('#realestate_value').val() ? get_formatted_price( jQuery('#realestate_value').val() ) : 0;
		
		if( stock_on_sale=='include' ){
			var stock = ( jQuery('#stock').val()!='' ) ? get_formatted_price( jQuery('#stock').val() ) : 0;
			tmpreval = tmpreval+'Stock, ';
		} else {
			var stock = 0;
			tmpreval = tmpreval+'';
		}
		if( equipments_on_sale=='include' ){
			var equipments = ( jQuery('#equipments').val()!='' ) ? get_formatted_price( jQuery('#equipments').val() ) : 0;
			tmpreval = tmpreval+'Equipments ';
		} else {
			var equipments = 0;
			tmpreval = tmpreval+'';
		}
		
		var goodwill = ( jQuery('#goodwill').val()!='' ) ? get_formatted_price( jQuery('#goodwill').val() ) : 0;
		var total_value = parseFloat( stock ) + parseFloat( equipments ) + parseFloat( realestate_value ) + parseFloat( goodwill );
		if( total_value != parseFloat( property_value ) ){
                jQuery('#realestate_value').addClass('error');
                jQuery('#stock').addClass('error');
                jQuery('#equipments').addClass('error');
                jQuery('#goodwill').addClass('error');
                jQuery('#property_value').addClass('error');
                jQuery('#realestate_value').effect("shake", { times:3 }, 50);
                jQuery('#stock').effect("shake", { times:3 }, 50);
                jQuery('#equipments').effect("shake", { times:3 }, 50);
                jQuery('#goodwill').effect("shake", { times:3 }, 50);
                jQuery('#pbreak').show();
                jQuery('#pbreak').effect("shake", { times:3 }, 50);
				jQuery('#pbreak').html('<div style="color:#900;">'+tmpreval+' and Goodwill value should equal to Total Asking price</style>');
                error++;
		} else {
         	jQuery('#step_3 input').removeClass('error').removeClass('valid');
		}
		
		if( property_value<10 || total_value<10 ){
               error++;
                jQuery('#pbreak').show();
                jQuery('#pbreak').effect("shake", { times:3 }, 50);
				jQuery('#pbreak').html('<div style="color:#900;">Incorrect values on asking price or total pricing structure</style>');
		}
		
		if( isNaN( property_value ) ){
			error++;
			jQuery('#property_value_message').show();
            jQuery('#property_value_message').effect("shake", { times:3 }, 50);
			jQuery('#property_value_message').html('<div style="color:#900;">Property value should be numbers only</style>');
		} else {
			jQuery('#property_value_message').html('');
		}
		
        if(!error) {
                jQuery('#pbreak').hide();
				if( pkgvalue=='package_1' ){
					create_pkg1_preview();
				}
				
				
			pkgvalue = jQuery('#pkg_id').val();
		  	if( pkgvalue=='package_1'  ){
               jQuery('#progress_text').html('80% Complete');
               jQuery('#progress').css('width','272px');
    			jQuery('#step_8').slideDown();
			} else if( pkgvalue=='package_3' ){
                //update progress bar
	          	jQuery('#step_4').slideDown();  
               jQuery('#progress_text').html('50% Complete');
               jQuery('#progress').css('width','170px');			
			} else {
                //update progress bar
	          	jQuery('#step_4').slideDown();  
               jQuery('#progress_text').html('60% Complete');
               jQuery('#progress').css('width','204px');
		    }
			create_headline();

               //slide steps
    			jQuery('#step_3').slideUp();
				jQuery('html, body').animate({scrollTop:0}, 'slow');    
        } else return false;
    });
    jQuery('#submit_3_4').click(function(){//STEP 3
        jQuery('#submit_3_4 input').removeClass('error').removeClass('valid');
		
		var vals = jQuery(".featured:checked").attr('id');
        var fields = jQuery('#submit_3_4 .step34p');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] ) {
                jQuery(this).addClass('error');
   	            jQuery(this).effect("shake", { times:3 }, 50);
       	        error++;
			}
        });
		
		
        if(!error) {
			pkgvalue = jQuery('#pkg_id').val();
		  	if( pkgvalue=='package_2'  ){
               jQuery('#progress_text').html('90% Complete');
               jQuery('#progress').css('width','272px');
    			jQuery('#step_8').slideDown();
			} else {
                //update progress bar
	          	jQuery('#step_5').slideDown();  
            	jQuery('#progress_text').html('70% Complete');
            	jQuery('#progress').css('width','238px');
		    }
			jQuery("#pkg2_featured").html('<img src="' + vals + '"/>');
			jQuery("#pkg3_featured").html('<img src="' + vals + '" style="height:300px;" />');
			   
            jQuery('#step_3_4').slideUp();
                //slide steps
			jQuery('html, body').animate({scrollTop:0}, 'slow');   
       } else return false;
          
    });
  	jQuery('#submit_5').click(function(){
        //remove classes
        jQuery('#step_5 input').removeClass('error').removeClass('valid');

        var fields = jQuery('#step_5 .step5p');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')]   ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });

		if( jQuery('#ad_software').val()=='Other' && jQuery('#other_software').val()=='' ){
                jQuery('#other_software').addClass('error');
                jQuery('#other_software').effect("shake", { times:3 }, 50);
                error++;
		}
		if( jQuery('#off_street_parking').val()=='Yes' && jQuery('#no_of_off_street_cars').val()=='' ){
                jQuery('#no_of_off_street_cars').addClass('error');
                jQuery('#no_of_off_street_cars').effect("shake", { times:3 }, 50);
                error++;
		}

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('75% Complete');
                jQuery('#progress').css('width','275px');
                
                //slide steps
                jQuery('#step_5').slideUp();
                jQuery('#step_6').slideDown();   
				jQuery('html, body').animate({scrollTop:0}, 'slow');  
        } else return false;

    });
	jQuery('#submit_6').click(function(){
        //remove classes
        jQuery('#step_6 input').removeClass('error').removeClass('valid');

        var fields = jQuery('#step_6 .step7p');
        var error = 0;
		var animaltreatmsg=false;
		var animalmessage = '';
		var pass_small_animal_precentage=true;
		var	pass_equine_presentage=true;
		var	pass_bovine_presentage=true;
		var	pass_other_presentage=true;
		
		var pass_flip_small_animal_precentage=true;
		var	pass_flip_equine_presentage=true;
		var	pass_flip_bovine_presentage=true;
		var	pass_flip_other_presentage=true;
		
		
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });
		
		var small_animal_precentage = jQuery('#small_animal_precentage').val() ? jQuery('#small_animal_precentage').val() : 0;
		var equine_presentage = jQuery('#equine_presentage').val() ? jQuery('#equine_presentage').val() : 0;
		var bovine_presentage = jQuery('#bovine_presentage').val() ? jQuery('#bovine_presentage').val() : 0;
		var other_presentage = jQuery('#other_presentage').val() ? jQuery('#other_presentage').val() : 0;
		
		
		var total_presentage= parseInt( small_animal_precentage ) + parseInt( equine_presentage ) + parseInt( bovine_presentage ) + parseInt( other_presentage );
		if( small_animal_precentage!='' || small_animal_precentage>0 ) {
			if( jQuery('#canine').is(':checked') || jQuery('#feline').is(':checked') || jQuery('#avian').is(':checked') || jQuery('#exotics').is(':checked') || jQuery('#fauna').is(':checked') ) { 
				pass_small_animal_precentage=true;
			} else {
				pass_small_animal_precentage=false;
			}
		} else {
			if( jQuery('#canine').is(':checked') || jQuery('#feline').is(':checked') || jQuery('#avian').is(':checked') || jQuery('#exotics').is(':checked') || jQuery('#fauna').is(':checked') ) { 
				pass_flip_small_animal_precentage=false;
			} 
		}
		
		if( equine_presentage!='' || equine_presentage>0 ) {
			if( jQuery('#pleasure').is(':checked') || jQuery('#equine_stud').is(':checked') || jQuery('#stables').is(':checked') ) { 
				pass_equine_presentage=true;
			} else {
				pass_equine_presentage=false;
			}
		} else {
			if( jQuery('#pleasure').is(':checked') || jQuery('#equine_stud').is(':checked') || jQuery('#stables').is(':checked') ) { 
				pass_flip_equine_presentage=false;
			}
		}
		if( bovine_presentage!='' || bovine_presentage>0 ) {
			if( jQuery('#beef').is(':checked') || jQuery('#dairy').is(':checked') || jQuery('#bovine_stud').is(':checked')  ) { 
				pass_bovine_presentage=true;
			} else {
				pass_bovine_presentage=false;
			}
		} else {
			if( jQuery('#beef').is(':checked') || jQuery('#dairy').is(':checked') || jQuery('#bovine_stud').is(':checked')  ) { 
				pass_flip_bovine_presentage=false;
			}
		}
		if( other_presentage!='' || other_presentage>0 ) {
			if( jQuery('#porcine').is(':checked') || jQuery('#ovine').is(':checked') || jQuery('#caprine').is(':checked') || jQuery('#camelid').is(':checked')  ) { 
				pass_other_presentage=true;
			} else {
				pass_other_presentage=false;
			}
		} else {
			if( jQuery('#porcine').is(':checked') || jQuery('#ovine').is(':checked') || jQuery('#caprine').is(':checked') || jQuery('#camelid').is(':checked')  ) { 
				pass_flip_other_presentage=false;
			}
		}
			
			
			if( pass_small_animal_precentage==false  ){
				animaltreatmsg=true;
				animalmessage += '<div style="color:#900;">Select atleast one Small Animal treatment</div>';
				error++;
			}
			if( pass_equine_presentage==false  ){
				animaltreatmsg=true;
				animalmessage += '<div style="color:#900;">Select atleast one equine treatment</div>';
				error++;
			}
			if( pass_bovine_presentage==false  ){
				animaltreatmsg=true;
				animalmessage += '<div style="color:#900;">Select atleast one bovine treatment</div>';
				error++;
			}
			if( pass_other_presentage==false  ){
				animaltreatmsg=true;
				animalmessage += '<div style="color:#900;">Select atleast one other treatment</div>';
				error++;
			}
			
			if( pass_flip_small_animal_precentage==false  ){
				animaltreatmsg=true;
				animalmessage += '<div style="color:#900;">You haven\'t set Small Animal treatment Percentage</div>';
				error++;
			}
			if( pass_flip_equine_presentage==false  ){
				animaltreatmsg=true;
				animalmessage += '<div style="color:#900;">You haven\'t set equine treatment Percentage</div>';
				error++;
			}
			if( pass_flip_bovine_presentage==false  ){
				animaltreatmsg=true;
				animalmessage += '<div style="color:#900;">You haven\'t set bovine treatment Percentage</div>';
				error++;
			}
			if( pass_flip_other_presentage==false  ){
				animaltreatmsg=true;
				animalmessage += '<div style="color:#900;">You haven\'t set other treatment Percentage</div>';
				error++;
			}

		if( total_presentage!=100 ){
                jQuery('#small_animal_precentage').addClass('error');
                jQuery('#equine_presentage').addClass('error');
                jQuery('#bovine_presentage').addClass('error');
                jQuery('#other_presentage').addClass('error');
                jQuery('#small_animal_precentage').effect("shake", { times:3 }, 50);
                jQuery('#equine_presentage').effect("shake", { times:3 }, 50);
                jQuery('#bovine_presentage').effect("shake", { times:3 }, 50);
                jQuery('#other_presentage').effect("shake", { times:3 }, 50);
				animaltreatmsg=true;
				animalmessage += '<div style="color:#900;">Percentage values of animal practices must equal to 100%</div>';
                error++;
		} 
		
		if( animaltreatmsg==true ){
			jQuery('#animal_treated_message').show();
            jQuery('#animal_treated_message').effect("shake", { times:3 }, 50);
			jQuery('#animal_treated_message').html(animalmessage);
		}

        if(!error) {
                //update progress bar
                jQuery('#progress_text').html('85% Complete');
                jQuery('#progress').css('width','289px');
                jQuery('#animal_treated_message').hide();
				jQuery('#animal_treated_message').html(''); 
                //slide steps
                jQuery('#step_6').slideUp();
                jQuery('#step_7').slideDown(); 
				jQuery('html, body').animate({scrollTop:0}, 'slow');    
        } else return false;

    });
	jQuery('#submit_7').click(function(){
        //remove classes
        jQuery('#step_7 input').removeClass('error').removeClass('valid');

        var fields = jQuery('#step_7 .step7p');
        var error = 0;
        fields.each(function(){
            var value = jQuery(this).val();
            if( value.length<1 || value==field_values[jQuery(this).attr('id')] ) {
                jQuery(this).addClass('error');
                jQuery(this).effect("shake", { times:3 }, 50);
                
                error++;
            } else {
                jQuery(this).addClass('valid');
            }
        });
		
		
		
        if(!error) {
			create_headline();
			pkgvalue = jQuery('#pkg_id').val();
		  	if( pkgvalue=='package_2' ){
				create_pkg2_preview();
			} else if( pkgvalue=='package_3' ){
				create_pkg3_preview();
			} else {
				create_pkg1_preview();
			}

				create_pkg2_preview();
                jQuery('#progress_text').html('98% Complete');
                jQuery('#progress').css('width','333px');
                
                //slide steps
                jQuery('#step_7').slideUp();
                jQuery('#step_8').slideDown(); 
				jQuery('html, body').animate({scrollTop:0}, 'slow');    
        } else return false;

    });
	
	function create_headline(){
		var suburb = jQuery('#suburb').val().capitalize();
		jQuery('#post_title').val( jQuery('#property_is_for').val().toUpperCase() +' - '+jQuery('#type_of_practice').val()+' Practice - '+suburb+ ', ' +jQuery('#state').val() );
		jQuery('#show_heading').html( jQuery('#post_title').val() );
	}

});


jQuery(document).ready(function() {

    jQuery('.word_count').each(function() {
        var input = '#' + this.id;
        var count = input + '_count';
        jQuery(count).show();
        word_count(input, count);
        jQuery(this).keyup(function() { word_count(input, count) });
    });

});




function word_count(field, count) {
   var number = 0;
    var matches = $(field).val().match(/\b/g);
    if(matches) {
        number = matches.length/2;
    }
    $(count).text( number + ' word' + (number != 1 ? 's' : '') + ' approx');
}
