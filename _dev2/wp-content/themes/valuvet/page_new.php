<?php 
 if(is_page(172)){
	
	if(isset($_POST['vac_sub']) && $_POST['vac_sub']=='Submit')
	{
$data=array('id'=>'Null',
                     'title'=>$_POST['ad_title'],
		             'f_name'=>$_POST['ad_firstname'],
					 's_name'=>$_POST['ad_surname'],
					 'email'=>$_POST['ad_email'],
					 'contact'=>$_POST['ad_contactnumber'],
					 'add_inq_cont'=>$_POST['ad_advertisement'],
					 'hear_from'=>$_POST['position_hearabout'],
					  'other'=>$_POST['ad_hearabout_other'],
					  'package'=>$_POST['position_vacant_pack'],
					  'date'=>date('Y-m-d'));
					  
$data_practice=array('id'=>'NUll',
                                 'p_name'=>$_POST['ad_practice_name'],
			                      'p_contact'=>$_POST['ad_practice_phone'],
								  'p_bussiness'=>$_POST['ad_address'],
								   'p_sub'=>$_POST['ad_suburb'],
								   'p_p_code'=>$_POST['ad_postcode'],
								   'p_state'=>$_POST['ad_state'],
								    'p_country'=>$_POST['ad_country']);	
																
$data_adver=array('id'=>'Null',
'prac_type'=>$_POST['practice_type'],
'pos_av'=>$_POST['position_available'],
'pos_other'=>$_POST['position_available-other'],
'hour_pr_week'=>$_POST['position_hours'],
'pos_sallry'=>$_POST['position_salary'],
'from'=>$_POST['position_salary_experience'],
'Inclusive'=>$_POST['position_super'],

'position_1'=>$_POST['position_benefits_1'],
'position_2'=>$_POST['position_benefits_2'],
'position_3'=>$_POST['position_benefits_3'],
'position_4'=>$_POST['position_benefits_4'],
'position_5'=>$_POST['position_benefits_5'],
'financial_in_da'=>$_POST['position_financial_incentives'],
'position_6'=>$_POST['position_benefits_6'],
'pos_per_op'=>$_POST['position_personal_opportunities'],
'position_7'=>$_POST['position_benefits_7'],
'pos7_other'=>$_POST['position_benefits_other'],

'headline'=>$_POST['position_headline'],
'position_dis'=>$_POST['position_desc'],

'responsibilities_1'=>$_POST['position_skills_required_1'],
'responsibilities_2'=>$_POST['position_skills_required_2'],
'responsibilities_3'=>$_POST['position_skills_required_3'],
'responsibilities_4'=>$_POST['position_skills_required_4'],
'responsibilities_5'=>$_POST['position_skills_required_5'],

'qualification_1'=>$_POST['position_qualifications_required_1'],
'qualification_2'=>$_POST['position_qualifications_required_2'],
'qualification_3'=>$_POST['position_qualifications_required_3'],
'qualification_4'=>$_POST['position_qualifications_required_4'],
'qualification_5'=>$_POST['position_qualifications_required_5'],

'prac_potential'=>$_POST['position_practice_potential'],
'prac_attractions'=>$_POST['position_local_attractions']);




$result=$wpdb->insert('wp_vacant',$data);
$result1=$wpdb->insert('wp_vacant_prac',$data_practice);
$result2=$wpdb->insert('wp_vacant_add',$data_adver);
if($result && $result1 && $result2)
{
	$message="<font color='#FF0000'>Register Successfully</font>";
}

	}
 } 


if(is_page(171))
{
	if(isset($_POST['add_booking']) && $_POST['add_booking']=='Submit')
	{
	$booking_data_details=array('id'=>'NUll','ad_hear_abt'=>$_POST['hear_from'],
	'ad_hear_other'=>$_POST['ad_hearabout_other'],
	'ad_Advertisement'=>$_POST['ad_booking'],
	'ad_title'=>$_POST['ad_title'],
	'ad_f_name'=>$_POST['ad_firstname'],
	'ad_s_name'=>$_POST['ad_surname'],
	'ad_email'=>$_POST['ad_email'],
	'ad_contact'=>$_POST['ad_contactnumber'],
	 'ad_add_inq'=>$_POST['ad_advertisement'],
	 'date'=>date('Y-m-d'));
	 
	 
	 $booking_prac_details1=array('id'=>'Null',
	 'b_practice_name'=>$_POST['ad_practice_name'],
	 'b_practice_phone'=>$_POST['ad_practice_phone'],
	 'b_address'=>$_POST['ad_address'],
	 'b_subrb'=>$_POST['ad_suburb'],
	 'b_post'=>$_POST['ad_postcode'],
	 'b_state'=>$_POST['ad_state'],
	 'b_country'=>$_POST['ad_country'],
	 'b_headline_pck1_2_3'=>$_POST['ad_headline'],
	 'b_shor_dis_pk2_pk3'=>$_POST['ad_short_desc'],
	 'b_full_profile_dis_pck_3'=>$_POST['ad_short_desc1'],
	 'b_type_prac'=>$_POST['ad_type_1'],
	 'b_prac_other'=>$_POST['ad_type_other'],
	 'b_pro_medicine'=>$_POST['ad_prof_sevices_type_1'],
	 'b_pro_surgery'=>$_POST['ad_prof_sevices_type_2'],
	 'b_pro_densirt'=>$_POST['ad_prof_sevices_type_3'],
	 'b_pro_behav'=>$_POST['ad_prof_sevices_type_4'],
	 'b_pro_house'=>$_POST['ad_prof_sevices_type_5'],
	 'b_pro_emer'=>$_POST['ad_prof_sevices_type_6'],
	 'b_pro_digno'=>$_POST['ad_prof_sevices_type_7'],
	 'b_pro_radiology'=>$_POST['ad_prof_sevices_type_8'],
	 'b_pro_ultrsond'=>$_POST['ad_prof_sevices_type_9'],
	 'b_pro_endoscopy'=>$_POST['ad_prof_sevices_type_10'],
	 'b_pro_specialist'=>$_POST['ad_prof_sevices_type_11'],
	 'b_pro_other'=>$_POST['ad_prof_sevices_other']
	 );
	
	 
	$booking_prac_details=array(
	 'id'=>'NUll',
	 'faci_place'=>$_POST['ad_type'],
	 'faci_building'=>$_POST['ad_ownership'],
	 'faci_b_area'=>$_POST['ad_buliding_size'],
	 'faci_n_brach'=>$_POST['ad_number_clinics'],
	 'faci_no_days'=>$_POST['ad_open_days'],
	 'faci_do_kennel'=>$_POST['ad_facilities_include'],
	 'faci_do_stable'=>$_POST['ad_facilities_stable'],
	 'faci_off_street'=>$_POST['ad_parking'],
	 'faci_car_park'=>$_POST['ad_parking_number']
	 ,'faci_no_computer'=>$_POST['ad_number_computers']
	 ,'faci_comp_soft'=>$_POST['ad_software']
	 ,'faci_other_soft'=>$_POST['ad_software_other']
	 ,'staff_no_of_full_vet'=>$_POST['ad_number_vets']
	 ,'staff_no_of_full_nurce'=>$_POST['ad_number_nurse']
	 ,'staff_prac_manager'=>$_POST['ad_manager']
	 ,'extra_real_for_sale'=>$_POST['ad_realestate_sale']
	 ,'extra_by_valuvet'=>$_POST['ad_vv_valuation']
	 ,'small_animal_per'=>$_POST['ad_species_small_animal']
	  ,'small_animal_per_type1'=>$_POST['ad_species_small_animal_type_1']
	   ,'small_animal_per_type2'=>$_POST['ad_species_small_animal_type_2']
	  ,'small_animal_per_type3'=>$_POST['ad_species_small_animal_type_3']
	,'small_animal_per_type4'=>$_POST['ad_species_small_animal_type_4']
    ,'small_animal_per_type5'=>$_POST['ad_species_small_animal_type_5'],
	'ad_species_equine'=>$_POST['ad_species_equine'],
	'ad_species_equine_type1'=>$_POST['ad_species_equine_type_1'],
	'ad_species_equine_type2'=>$_POST['ad_species_equine_type_2'],
	'ad_species_equine_type3'=>$_POST['ad_species_equine_type_3'],
	 'ad_species_bovine'=>$_POST['ad_species_bovine'],
	 'ad_species_bovine_type_1'=>$_POST['ad_species_bovine_type_1'],
	 'ad_species_bovine_type_2'=>$_POST['ad_species_bovine_type_2'],
	 'ad_species_bovine_type_3'=>$_POST['ad_species_bovine_type_3'],
	 'ad_species_other'=>$_POST['ad_species_other'],
	 'ad_species_other_type_1'=>$_POST['ad_species_other_type_1'],
	 'ad_species_other_type_2'=>$_POST['ad_species_other_type_2'],
	 'ad_species_other_type_3'=>$_POST['ad_species_other_type_3'],
	  'ad_species_other_type_4'=>$_POST['ad_species_other_type_4'],
      'ad_species_other_more'=>$_POST['ad_species_other_more'],
	  'ad_anc_sevices_type_1'=>$_POST['ad_anc_sevices_type_1'],
	  'ad_anc_sevices_type_2'=>$_POST['ad_anc_sevices_type_2'],
	  'ad_anc_sevices_type_3'=>$_POST['ad_anc_sevices_type_3'],
	  'ad_anc_sevices_type_4'=>$_POST['ad_anc_sevices_type_4'],
	  'ad_anc_sevices_type_5'=>$_POST['ad_anc_sevices_type_5'],
	  'ad_anc_sevices_other'=>$_POST['ad_anc_sevices_other'],
	  'ad_value_property'=>$_POST['ad_value_property'],
	  'ad_value_stock_equip'=>$_POST['ad_value_stock_equip'],
	  'ad_value_goodwill'=>$_POST['ad_value_goodwill'],
	  'ad_value_asking'=>$_POST['ad_value_asking'],
	  'ad_pricing'=>$_POST['ad_pricing']
	 );
	 
	 
	 $result1=$wpdb->insert('wp_bokking_add_data',$booking_prac_details);
     $result2=$wpdb->insert('wp_booking_add',$booking_data_details);	
     $result3=$wpdb->insert('wp_booking_prac',$booking_prac_details1);
	
 if($result1 && $result2 && $result3)
 {
	$message="<font color='#FF0000'>Register Successfully</font>"; 
	 
 }
	 
	}
	
	
}





  ?>

<?php get_header(); ?>
<?php if(is_page(171)){?>

<div id="content">
<div id="main_content">
    <div id="forsell_bg">
		<h1>Vet's Practice Market Place - Advertise your practice FOR SALE!</h1>
        
        <div id="booking_form">
        	<h2>Advertisement Booking Form</h2>
      <div align="center"><?php echo $message    ?></div>
                  <p><em>How did you hear about Vet's Practice Market Place</em></p>
            <div><form action="" method="post" name="booking_farm" id="booking_farm">
            	<table cellpadding="0" cellspacing="0">
                	<tr>
                    	<td valign="top">
                        <select name="hear_from" id="hear_from" onchange="show_other()">
                            <option value="">Please select an option</option>
                            <option value="Newsletter">ValuVet Newsletter</option>
                            <option value="Conference">Conference</option>
                            <option value="Referral by Colleague">Referral by Colleague</option>
                            <option value="Referred by a Purchaser">Referred by a Purchaser</option>
                            <option value="Valuvet Consultant">ValuVet Consultant</option>
                            <option value="Internet Search Engine">Internet Search Engine</option>
                            <option value="Advertisement">Magazine Advertisement</option>
                            <option value="Direct mail received">Direct Mail Received</option>
                            <option value="Other">Other</option>
                        </select>
                        </td>
                       <td valign="top"> &nbsp;&nbsp;<label id="otherhear_text" style="display:none"> <span>Other</span></label></td>
                        <td valign="top"><input id="ad_hearabout_other" name="ad_hearabout_other" size="24" style="display:none" class=""></td>
                    </tr>
                </table>
                <div>&nbsp;</div>
                <hr />
                
                <table cellpadding="0" cellspacing="0" width="100%" class="font_size">
                	<tr>
                        <td width="272"><p><span>Advertisement Package</span></p> <hr /></td>
                        <td width="50">&nbsp;</td>
                        <td><p><span>Your Contact Details</span></p> <hr /></td>
                	</tr>
                    <tr>
                    	<td valign="top"><br />Advertisement Packages 
                        <select name="ad_booking">
                            <option selected="" value="">Select one</option>
                            <option value="level1_$165">Package 1 - $165</option>
                            <option value="level2_$330">Package 2 - $330</option>
                            <option value="level3_$550">Package 3 - $550</option>
                        </select>
                        <br /><em>Prices include GST</em>
                        </td>
                        <td>&nbsp;</td>
                        <td valign="top">*NOTE: Form fields designate with the grey highlight will be displayed as contact details on the advertisement.
                        	<br />
                            <div>
                            	<table cellpadding="0" cellspacing="0" width="100%" class="contact_details">
                                	<tr>
                                    	<th>Title</th>
                                        <th>
                                        	<select name="ad_title">
                                             <option selected="" value="">Select --&gt;</option>
                                             <option value="Mr">Mr</option>
                                             <option value="Mrs">Mrs</option>
                                             <option value="Miss">Miss</option>
                                             <option value="Ms">Ms</option>
                                             <option value="Dr">Dr</option>
                                             <option value="Proff">Proff</option>
                                             </select>
	     								</th>
                                    </tr>
                                    
                                    <tr>
                                    	<td>First Name<b>*</b></td>
                                        <td><input name="ad_firstname"></td>
                                    </tr>
                                    <tr>
                                    	<td>Surname<b>*</b></td>
                                        <td><input name="ad_surname"></td>
                                    </tr>
                                    <tr>
                                    	<td>Email<b>*</b></td>
                                        <td><input name="ad_email" style="width:140px;"></td>
                                    </tr>
                                    <tr>
                                    	<th>Contact Number<b>*</b></th>
                                        <th><input name="ad_contactnumber" style="width:140px;"> (No Spaces)</th>
                                    </tr>
                                    <tr>
                                    	<td colspan="2">Advertisement Enquiry Contact Phone Number<b>*</b><br /><input name="ad_advertisement" style="margin-top:2px; width:150px;"> (No Spaces)</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td><p><span>Practice Details </span></p><hr /></td>
                        <td>&nbsp;</td>
                        <td><p><span>Size of the Practice </span></p><hr /></td>
                    </tr>
                    
                    <tr>
                    	<td valign="top" id="practice_details"><br />
                        	<div>Practice Name<b>*</b><br /><input name="ad_practice_name" ></div>
                            <div>Practice Phone Number<b>*</b><br /><input name="ad_practice_phone"> (No Spaces)</div>
                            <div>Business Address<b>*</b><br /><input name="ad_address"></div>
                            <div>Suburb<b>*</b><br /><input name="ad_suburb"></div>
                            
                            <div>
                            	<table cellpadding="0" cellspacing="0" width="90%" id="postal_code">
                                	<tr>
                                    	<td width="50%">Post Code<b>*</b></td>
                                        <td width="50%"><input name="ad_postcode"></td>
                                    </tr>
                                    <tr>
                                    	<td valign="top">State</td>
                                        <td>
                                        <select name="ad_state">
                                            <option selected="" value="">Select --&gt;</option>
                                            <option>ACT</option>
                                            <option>NSW</option>
                                            <option>NT</option>
                                            <option>QLD</option>
                                            <option>SA</option>
                                            <option>TAS</option>
                                            <option>VIC</option>
                                            <option>WA</option>
                                         </select>
     									</td>
                                    </tr>
                                    <tr>
                                    	<td valign="top">Country<b>*</b></td>
                                        <td><input name="ad_country"></td>
                                    </tr>
                                </table>
                            </div>
                            
                            <p>&nbsp;</p>
                            <div><p><em>Headline</em><b>*</b></p><b>(Package 1, 2, 3)</b><br /><input name="ad_headline"></div>
                            <p>&nbsp;</p>
                            
                            <div><p><em>Short Description</em> - 100 Words</p><b>(Package 2, 3)</b><br /><textarea name="ad_short_desc" rows="5"></textarea><br />
                            <span style="font-size:10px;">Word Count:&nbsp;&nbsp;&nbsp;&nbsp; Word Remaining:</span></div>
                            
                            <p>&nbsp;</p>
                            <div><p><em>Full Profile Description</em> - 500 Words</p><b>(Package 3)</b><br /><textarea name="ad_short_desc" rows="5"></textarea><br />
                            <span style="font-size:10px;">Word Count:&nbsp;&nbsp;&nbsp;&nbsp; Word Remaining:</span></div>
                        </td>
                        <td>&nbsp;</td>
                        <td valign="top">
                        	<div>&nbsp;</div>
                            <p><em>Facilities</em></p>
                            <div class="from_list">
                            <ol>
                            	<li><input type="radio" value="Hospital" name="ad_type">&nbsp; Hospital (Large Building) &nbsp;OR &nbsp;<input type="radio" value="Clinic" name="ad_type">&nbsp; Clinic (Small Building)&nbsp; OR <input type="radio" value="Surgery" name="ad_type">&nbsp; Surgery (Room)</li>
                            <li><input type="radio" value="owned" name="ad_ownership">&nbsp; Building Owned&nbsp; / OR &nbsp;<input type="radio" value="rented" name="ad_ownership">&nbsp; Building Rented</li>
                            <li>Building Area Sqm&nbsp; <input name="ad_buliding_size" class="small"></li>
                            <li>Number of Branch Clinics&nbsp; <input name="ad_number_clinics" class="small"></li>
                            <li>Number of Days Open per week&nbsp; <input name="ad_open_days" class="small"></li>
                            <li>Do the facilities include:&nbsp; <input type="checkbox" value="kennels" name="ad_facilities_include"> &nbsp;Kennels&nbsp; &nbsp; <input type="checkbox" value="Stables" name="ad_facilities_include"> &nbsp;Stables</li>
                            <li>Off Street Parking&nbsp; <input type="radio" value="yes" name="ad_parking"> &nbsp;Yes&nbsp; <input type="radio" value="no" name="ad_parking"> &nbsp;No</li>
                            <li>If YES - How many Car Parks&nbsp; <input name="ad_parking_number" class="small"></li>
                            <li>Number of computer terminals &nbsp; <input name="ad_number_computers" class="small"></li>
                            <li>Computer Software &nbsp; <select name="ad_software" id="ad_software" onchange="show_software()">
                            <option value="">Please select an option</option>
                            <option value="RxWorks">RxWorks</option>
                            <option value="Cornerstone">Cornerstone</option>
                            <option value="VetAid DOS">VetAid DOS</option>
                            <option value="VetAid Visual">VetAid Visual</option>
                            <option value="Netvet">Netvet</option>
                            <option value="Vetcare">Vetcare</option>
                            <option value="Vetware">Vetware</option>
                            <option value="Quickvet">Quickvet</option>
                            <option value="Custom built program">Custom built program</option>
                            <option value="Other">Other</option>
                            </select>
                            </li>
                           <li><label id="other_soft_text" style="display:none">Other Software&nbsp; </label><input name="ad_software_other" id="ad_software_other" class="small" style="display:none"></li>
                          </ol>
                          
                          <p>&nbsp;</p>
                          <p><em>Staff</em></p>  
                          
                          <ol>
                            <li>Number of Full-time Vet Equivalents (40 hrs)&nbsp; <input name="ad_number_vets" class="small"></li>
                            <li>Number of Full-time Nurse Equivalents (38 hrs)&nbsp; <input name="ad_number_nurse" class="small"></li>
                            <li>Practice Manager&nbsp; <input type="radio" value="yes" name="ad_manager"> &nbsp;Yes &nbsp;<input type="radio" value="no" name="ad_manager">&nbsp; No</li>
                          </ol>
                          
                          <p>&nbsp;</p>
                          <p><em>Extra</em></p> 
                            <ol>
                            <li>Real Estate available for sale&nbsp; <input type="radio" value="yes" name="ad_realestate_sale">&nbsp; Yes &nbsp;<input type="radio" value="no" name="ad_realestate_sale"> &nbsp;No</li>
                            <li>Valuation by ValuVet&nbsp; <input type="radio" value="yes" name="ad_vv_valuation"> &nbsp;Yes&nbsp; <input type="radio" value="no" name="ad_vv_valuation"> &nbsp;No</li>
                            <li>ValuVet Practice Report available&nbsp; <input type="radio" value="yes" name="ad_vv_report"> &nbsp;Yes &nbsp;<input type="radio" value="no" name="ad_vv_report"> &nbsp;No</li>
                            </ol>
                            </div>
                        </td>
                    </tr>
                    
                    <tr><td colspan="3"><p>&nbsp;</p></td></tr>
                    <tr>
                    	<td><p><span>Type of Practice</span></p><hr /></td>
                        <td>&nbsp;</td>
                        <td><p><span>Species Treated</span></p><hr /></td>
                    </tr>
                    
                    <tr>
                    	<td valign="top">
                        <div>&nbsp;</div>
                        <div class="from_list">
                        	<ol>
                                <li><input type="radio" value="Small Animal" name="ad_type_1"> &nbsp;Small Animal</li>
                                <li><input type="radio" value="Large Animal" name="ad_type_1"> &nbsp;Large Animal</li>
                                <li><input type="radio" value="Mixed" name="ad_type_1">&nbsp; Mixed</li>
                                <li><input type="radio" value="Specialist" name="ad_type_1"> &nbsp;Specialist</li>
                                <li>Other &nbsp;<input id="ad_type_other" name="ad_type_other" class="wide"></li>
                            </ol>
						</div>
                        </td>
                        <td>&nbsp;</td>
                        <td valign="top">
                        	<div>&nbsp;</div>
                            <div>
                            	<table cellpadding="0" cellspacing="0" width="100%">
                                	<tr>
                                    	<td valign="top">
                                        <div class="from_list">
                                        	<ol>
                                            <li><p><em>Small Animal %</em></p><input name="ad_species_small_animal" class="small"></li>
                                            <li><input type="checkbox" value="Canine" name="ad_species_small_animal_type_1">&nbsp; Canine</li>
                                            <li><input type="checkbox" value="Feline" name="ad_species_small_animal_type_2">&nbsp; Feline</li>
                                            <li><input type="checkbox" value="Avian" name="ad_species_small_animal_type_3">&nbsp; Avian</li>
                                            <li><input type="checkbox" value="Exotics" name="ad_species_small_animal_type_4">&nbsp; Exotics</li>
                                            <li><input type="checkbox" value="Fauna" name="ad_species_small_animal_type_5">&nbsp; Fauna</li>
                                            </ol>
											</div>
                                        </td>
                                        <td valign="top">
                                        <div class="from_list">
                                        	<ol>
                                                <li><p><em>Equine %</em></p><input name="ad_species_equine" class="small"></li>
                                                <li><input type="checkbox" value="Pleasure" name="ad_species_equine_type_1">&nbsp; Pleasure</li>
                                                <li><input type="checkbox" value="Stud" name="ad_species_equine_type_2">&nbsp; Stud</li>
                                                <li><input type="checkbox" value="Stables" name="ad_species_equine_type_3">&nbsp; Stables</li>
                                           </ol>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td class="2"><p>&nbsp;</p></td>
                                    </tr>
                                    <tr>
                                    	<td valign="top">
                                        <div class="from_list">
                                        	<ol>
                                                <li><p><em>Bovine %</em></p><input name="ad_species_bovine" class="small"></li>
                                                <li><input type="checkbox" value="Beef" name="ad_species_bovine_type_1"> &nbsp;Beef</li>
                                                <li><input type="checkbox" value="Dairy" name="ad_species_bovine_type_2"> &nbsp;Dairy</li>
                                                <li><input type="checkbox" value="Stud" name="ad_species_bovine_type_3"> &nbsp;Stud</li>
                                            </ol>
                                        </div>
                                        </td>
                                        <td valign="top">
                                        	<div class="from_list">
                                        	<ol>
                                            <li><p><em>Other %</em></p><input name="ad_species_other" class="small"></li>
                                            <li><input type="checkbox" value="Porcine" name="ad_species_other_type_1">&nbsp; Porcine</li>
                                            <li><input type="checkbox" value="Ovine" name="ad_species_other_type_2">&nbsp; Ovine</li>
                                            <li><input type="checkbox" value="Caprine" name="ad_species_other_type_3">&nbsp; Caprine</li>
                                            <li><input type="checkbox" value="Camelid" name="ad_species_other_type_4">&nbsp; Camelid</li>
                                            </ol>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="3">
                                        	 Other Cont..<br />
                                             <textarea class="wide" name="ad_species_other_more" rows="5" style="width:230px;"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td colspan="3"><p>&nbsp;</p></td>
                    </tr>
                    <tr>
                    	<td><p><span>Professional Services </span></p><hr /></td>
                        <td>&nbsp;</td>
                        <td><p><span>Ancillary Services</span></p><hr /></td>
                    </tr>
                    
                    <tr>
                    	<td valign="top">
                        <div>&nbsp;</div>
                        <div class="from_list">
                        	<ol>
                                <li><input type="checkbox" value="Medicine" name="ad_prof_sevices_type_1">&nbsp; Medicine</li>
                                <li><input type="checkbox" value="Surgery" name="ad_prof_sevices_type_2">&nbsp; Surgery</li>
                                <li><input type="checkbox" value="Dentistry" name="ad_prof_sevices_type_3">&nbsp; Dentistry</li>
                                <li><input type="checkbox" value="Behaviour" name="ad_prof_sevices_type_4">&nbsp; Behaviour</li>
                                <li><input type="checkbox" value="House Calls" name="ad_prof_sevices_type_5">&nbsp; House Calls</li>
                                <li><input type="checkbox" value="Emergency Service" name="ad_prof_sevices_type_6">&nbsp; Emergency Service</li>
                                <li><input type="checkbox" value="Diagnostic Laboratory" name="ad_prof_sevices_type_7">&nbsp; Diagnostic Laboratory</li>
                                <li><input type="checkbox" value="Radiology" name="ad_prof_sevices_type_8">&nbsp; Radiology</li>
                                <li><input type="checkbox" value="Ultrasound" name="ad_prof_sevices_type_9">&nbsp; Ultrasound</li>
                                <li><input type="checkbox" value="Endoscopy" name="ad_prof_sevices_type_10">&nbsp; Endoscopy</li>
                                <li><input type="checkbox" value="Specialist" name="ad_prof_sevices_type_11">&nbsp; Specialist</li>
                                <li>Other<br><textarea name="ad_prof_sevices_other" rows="5" style="width:230px;"></textarea></li>
                                </ol>
                        </div>
                        </td>
                        <td>&nbsp;</td>
                        <td valign="top">
                        	<div>&nbsp;</div>
                        	<div class="from_list">
                            	<ol>
                                <li><input type="checkbox" value="Grooming" name="ad_anc_sevices_type_1">&nbsp; Grooming</li>
                                <li><input type="checkbox" value="Puppy School" name="ad_anc_sevices_type_2">&nbsp;Puppy School</li>
                                <li><input type="checkbox" value="Boarding" name="ad_anc_sevices_type_3">&nbsp; Boarding</li>
                                <li><input type="checkbox" value="Merchandising" name="ad_anc_sevices_type_4">&nbsp; Merchandising</li>
                                <li><input type="checkbox" value="Export Certificate" name="ad_anc_sevices_type_5">&nbsp; Export Certificate</li>
                                <li>Other<br><textarea id="ad_anc_sevices_other" name="ad_anc_sevices_other" rows="5" style="width:230px;"></textarea></li>
                                </ol>
                            </div>
                            
                            <div>&nbsp;</div>
                            <div>
                            	<p><span>Asking Price</span></p><hr />
                            </div>
                            <div>&nbsp;</div>
                            
                            <div class="from_list">
                            	<ol>
                                <li><label for="ad_value_property" class="label_list">Property Value</label>&nbsp; <input id="ad_value_property" name="ad_value_property" class="wide"></li>
                                <li><label for="ad_value_stock_equip" class="label_list">Stock &amp; Equipment</label>&nbsp; <input id="ad_value_stock_equip" name="ad_value_stock_equip" class="wide"></li>
                                <li><label for="ad_value_goodwill" class="label_list">Goodwill</label>&nbsp; <input id="ad_value_goodwill" name="ad_value_goodwill" class="wide"></li>
                                <li><label for="ad_value_asking" class="label_list">Asking Price</label>&nbsp; <input id="ad_value_asking" name="ad_value_asking" class="wide"></li>
                                <li>Show the  "Asking Price" on the advertisment&nbsp; <input type="radio" checked="" value="yes" name="ad_pricing">&nbsp; Yes&nbsp / &nbsp;<input type="radio" value="POA" name="ad_pricing"> &nbsp;P.O.A.<br>(Price on Application)</li>
								</ol>
                                <div style="clear:both;"></div>	
                            </div>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="3"><hr /></td>
                    </tr>
                    <tr>
                    	<td colspan="3" align="right"><input type="submit" value="Submit" name="add_booking" id="add_booking" /></td>
                    </tr>
                </table>	
            </form>
            </div>
        </div>    
    </div>
</div>
</div>

<?PHP }elseif(is_page(172)){ ?>

<div id="content">
<div id="main_content">
    <div id="forsell_bg" style="background:none;">
		<h1>Vet's Practice Market Place - Advertise your practice FOR SALE!</h1><br />
         <div class="grey_div" align="center"><?php echo $message  ?></div>
        
        <div id="booking_form">
        	<h2>Positions Vacant - Booking Form</h2>
            <div>&nbsp;</div>
            <p><em>How did you hear about Vet's Practice Market Place - Positions Vacant</em></p>
            <div><form action="" name="vacant_booking_frm" id="vacant_booking_frm" method="post">
            	<table cellpadding="0" cellspacing="0">
                	<tr>
                    	<td valign="top">
                         <select name="position_hearabout" id="position_hearabout" onchange="show_vacant_other()">
                        <option value="">Please select an option</option>
                        <option value="Newsletter">ValuVet Newsletter</option>
                        <option value="Conference">Conference</option>
                        <option value="Referral by Colleague">Referral by Colleague</option>
                        <option value="Referred by a Purchaser">Referred by a Purchaser</option>
                        <option value="Valuvet Consultant">ValuVet Consultant</option>
                        <option value="Internet Search Engine">Internet Search Engine</option>
                        <option value="Advertisement">Magazine Advertisement</option>
                        <option value="Direct mail received">Direct Mail Received</option>
                        <option value="Other">Other</option>
                        </select>
                        </td>
                         <td valign="top"> &nbsp;&nbsp;<span id="ad_text_other" style="display:none">Other</span></td>
                        <td valign="top"><input name="ad_hearabout_other" id="ad_hearabout_other" style="display:none" size="24"></td>
                    </tr>
                </table>
                <div>&nbsp;</div>
                <hr />
                
                <table cellpadding="0" cellspacing="0" width="100%" class="font_size">
                	<tr>
                        <td width="272"><p><span>Advertisement Packages</span></p> <hr /></td>
                        <td width="50">&nbsp;</td>
                        <td><p><span>Your Contact Details</span></p> <hr /></td>
                	</tr>
                    <tr>
                    	<td valign="top"><br /><em>Prices include GST</em>
                        <p>&nbsp;</p>
                        <div class="from_list">
                        <ol>
                            <li><input type="radio" checked="checked" value="pack-1"  name="position_vacant_pack"> Package 1: <br> Headline advert - ($110 - 3 months)</li>
                            <li><input type="radio" value="pack-2" name="position_vacant_pack"> Package 2: <br> Paragraph advert + 1 photo - ($220 - 6 months)</li>
                            <li><input type="radio" value="pack-3" name="position_vacant_pack"> Package 3: <br> Paragraph advert + link to full practice profile + 8 photos - ($330 - till position filled)</li>
        				</ol>
                        </div>
                        </td>
                        <td>&nbsp;</td>
                        <td valign="top">*NOTE: Form fields designate with the grey highlight will be displayed as contact details on the advertisement.
                        	<br />
                            <div>
                            	<table cellpadding="0" cellspacing="0" width="100%" class="contact_details">
                                	<tr>
                                    	<th>Title</th>
                                        <th>
                                        	<select name="ad_title">
                                             <option selected="" value="">Select --&gt;</option>
                                             <option value="Mr">Mr</option>
                                             <option value="Mrs">Mrs</option>
                                             <option value="Miss">Miss</option>
                                             <option value="Ms">Ms</option>
                                             <option value="Dr">Dr</option>
                                             <option value="Proff">Proff</option>
                                             </select>
	     								</th>
                                    </tr>
                                    
                                    <tr>
                                    	<td>First Name<b>*</b></td>
                                        <td><input name="ad_firstname"></td>
                                    </tr>
                                    <tr>
                                    	<td>Surname<b>*</b></td>
                                        <td><input name="ad_surname"></td>
                                    </tr>
                                    <tr>
                                    	<td>Email<b>*</b></td>
                                        <td><input name="ad_email" style="width:140px;"></td>
                                    </tr>
                                    <tr>
                                    	<th>Contact Number<b>*</b></th>
                                        <th><input name="ad_contactnumber" style="width:140px;"> (No Spaces)</th>
                                    </tr>
                                    <tr>
                                    	<td colspan="2">Advertisement Enquiry Contact Phone Number<b>*</b><br /><input name="ad_advertisement" style="margin-top:2px; width:150px;"> (No Spaces)</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td><p><span>Practice Details </span></p><hr /></td>
                        <td>&nbsp;</td>
                        <td><p><span>Advertisement Details </span></p><hr /></td>
                    </tr>
                    
                    <tr>
                    	<td valign="top" id="practice_details"><br />
                        	<div>Practice Name<b>*</b><br /><input name="ad_practice_name" ></div>
                            <div>Practice Phone Number<b>*</b><br /><input name="ad_practice_phone">
                            </div>
                            <div>Business Address<b>*</b><br /><input name="ad_address"></div>
                            <div>Suburb<b>*</b><br /><input name="ad_suburb"></div>
                            
                            <div>
                            	<table cellpadding="0" cellspacing="0" width="90%" id="postal_code">
                                	<tr>
                                    	<td width="50%">Post Code<b>*</b></td>
                                        <td width="50%"><input name="ad_postcode"></td>
                                    </tr>
                                    <tr>
                                    	<td valign="top">State</td>
                                        <td>
                                        <select name="ad_state">
                                            <option selected="" value="">Select --&gt;</option>
                                            <option>ACT</option>
                                            <option>NSW</option>
                                            <option>NT</option>
                                            <option>QLD</option>
                                            <option>SA</option>
                                            <option>TAS</option>
                                            <option>VIC</option>
                                            <option>WA</option>
                                         </select>
     									</td>
                                    </tr>
                                    <tr>
                                    	<td valign="top">Country<b>*</b></td>
                                        <td><input name="ad_country"></td>
                                    </tr>

                                </table>
                            </div>
                            
                        </td>
                        <td>&nbsp;</td>
                        <td valign="top">
                        	<div>&nbsp;</div>
                            <div><p><em>Practice Type/Size:</em></p>
                            <input name="practice_type" class="wide"></div>
                            <p>&nbsp;</p>
                            
                            <div class="from_list">
                                <p><em>Position Available</em></p>
                                <ol>
                                    <li><input type="radio" checked="checked" value="Partnership" name="position_available"> Partnership</li>
                                    <li><input type="radio" value="Associateship-fulltime" name="position_available"> Associateship (full time)</li>
                                    <li><input type="radio" value="Associateship-partime" name="position_available"> Associateship (part time)</li>
                                    <li><input type="radio" value="other" name="position_available"> Other <input name="position_available-other" class="wide"></li>
                               	</ol>
                           	</div>
                            <p>&nbsp;</p>
                            
                            <div class="from_list">
                                <p><em>Position Salary</em></p>
                                <ol>
                                    <li>Number of hours per wk:&nbsp; <input name="position_hours" class="small"></li>
                                    <li>Salary (K) &nbsp;<input name="position_salary" class="small">&nbsp; <input type="radio" value="Commensurable with experience" name="position_salary_experience"> From - Commensurable with experience.</li>
                                    <li>Inclusive of 9% Super &nbsp;<input type="radio" checked="checked" value="super-yes" name="position_super"> YES &nbsp;&nbsp;<input type="radio" value="super-no" name="position_super"> NO</li>
                               	</ol>
                           	</div>
                            
                            <p>&nbsp;</p>
                            <div class="from_list">
                            	<p><em>Position Benefits</em></p>
                                <ol>
                                	<li><input type="checkbox" value="no_after_hours " name="position_benefits_1"> No after-hours duties</li>
                                    <li><input type="checkbox" value="paid_conference_leave " name="position_benefits_2"> Paid conference leave</li>
                                    <li><input type="checkbox" value="vehicle_supplied" name="position_benefits_3"> Vehicle supplied</li>
                                    <li><input type="checkbox" value="accommodation_supplied " name="position_benefits_4"> Accommodation supplied</li>
                                    <li><input type="checkbox" value="financial_incentives " name="position_benefits_5"> Financial incentives <input class="text" name="position_financial_incentives"></li>
                                    <li><input type="checkbox" value="personal_opportunities " name="position_benefits_6"> Personal opportunities <input class="text" name="position_personal_opportunities"></li>
                                    <li><input type="checkbox" value="other " name="position_benefits_7"> Other <input class="text" name="position_benefits_other"></li>
                                </ol>
                            </div>
                            
                            <p>&nbsp;</p>
                            <div>
                            	<p><em>Headline</em><b>*</b></p>
                                <input id="position_headline" name="position_headline" class="wide form_req">
                            </div>
                            
                            <p>&nbsp;</p>
                            <div>
                            	<p><em>Position Description</em> - 500 Words</p>
                                <textarea name="position_desc" rows="5" cols="30"></textarea>
								<div style="font-family:helvetica; font-size:10px;">Word Count: &nbsp;&nbsp;&nbsp; Word Remaining:</div>
                            </div>
                            
                            <p>&nbsp;</p>
                            <div class="from_list">
                            	<p><em>Position Responsibilities</em></p>
                                
                                <ol>
                                	<li>1. <input name="position_skills_required_1" class="wide"></li>
                                    <li>2. <input name="position_skills_required_2" class="wide"></li>
                                    <li>3. <input name="position_skills_required_3" class="wide"></li>
                                    <li>4. <input name="position_skills_required_4" class="wide"></li>
                                    <li>5. <input name="position_skills_required_5" class="wide"></li>
                                </ol>
                            </div>
                            <p>&nbsp;</p>
                            
                            <div class="from_list">
                            	<p><em>Qualifications and Skills:</em></p>
                                
                                <ol>
                                	<li>1. <input name="position_qualifications_required_1" class="wide"></li>
                                    <li>2. <input name="position_qualifications_required_2" class="wide"></li>
                                    <li>3. <input name="position_qualifications_required_3" class="wide"></li>
                                    <li>4. <input name="position_qualifications_required_4" class="wide"></li>
                                    <li>5. <input name="position_qualifications_required_5" class="wide"></li>
                                </ol>
                            </div>
                            <p>&nbsp;</p>
                            
                            <div class="from_list">
                            	<p><em>Practice Potential</em> - 250 Words</p>
                                <textarea name="position_practice_potential" rows="5" cols="30"></textarea>
                                <div style="font-family:helvetica; font-size:10px;">Word Count: &nbsp;&nbsp;&nbsp;&nbsp;Word Remaining: </div>
                            </div>
                            <p>&nbsp;</p>
                            
                            
                             <div class="from_list">
                            	<p><em>Local Attractions</em> - 250 Words</p>
                                <textarea name="position_local_attractions" rows="5" cols="30"></textarea>
                                <div style="font-family:helvetica; font-size:10px;">Word Count: &nbsp;&nbsp;&nbsp;&nbsp;Word Remaining: </div>
                            </div>
                            <p>&nbsp;</p>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="3"><hr /></td>
                    </tr>
                    <tr>
                    	<td colspan="3" align="right"><input type="submit" value="Submit" id="vac_sub" name="vac_sub"/></td>
                    </tr>
                </table>	
            </form>
            </div>
        </div>    
    </div>
</div>
</div>


<?php } if(is_page(25)){?>



<div id="content">
<div id="main_content">
<div id="content_allpage">
<div>
<div class="maincontent_left">
<?php get_sidebar(); ?>
</div>



<div class="maincontent_right">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>


</div>
</div>
</div>    
    
    
    
</div>
</div>


<?php }else{?>

	<div id="content">
		
   		<div id="main_content">
        <div id="content_allpage">
        	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
       	</div>
        </div>
<?php } ?>
	</div>
<?php get_footer(); ?>