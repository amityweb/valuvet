<div style="display:none;">
        <div id="contact_popup" class="acc_con">
			<?php $nonce = wp_create_nonce( 'contact_property_form' );?>
    <script>
		jQuery(document).ready(function($) {
			var ajaxurl = '<?php echo  get_option( 'siteurl' ) ;?>/wp-admin/admin-ajax.php';
			<?php $successmessage = get_option('vv_propertylisting_contact_sucess_message');?>
			<?php if( empty( $successmessage ) ) $successmessage ='Your message is sent to publisher.';?>
			var makesuccess = '<?=get_option('vv_propertylisting_contact_sucess_message')?>';
			$('#sendbtn').click(function() { //start function when Random button is clicked
				$.ajax({
					type: "post",url: ajaxurl ,data: 
						{ 
						yourname: $('#yourname').val(),
						youremail: $('#youremail').val(),
						myemail: $('#myemail').val(),
						mysubject: $('#mysubject').val(),
						enquiry: $('#enquiry').val(),
						property_id: $('#property_id').val(),
						action: 'process_contact_us',
						_ajax_nonce: '<?php echo $nonce; ?>' 
						},
					beforeSend: function() {
						$("#cform_content").hide();
						$("#cform_msg").show();
						}, //show loading just when link is clicked
					complete: function() { $("#cform_content").show();}, //stop showing loading when the process is complete
					success: function(html){ //so, if data is retrieved, store it in html
						if( html=='success' ){
							$("#cform_msg").html(makesuccess); //show the html inside helloworld div
							$("#cform_content").hide(); //animation
						} else {
							$("#cform_msg").html(html); //show the html inside helloworld div
							$("#cform_content").show(); //show the html inside helloworld div
						}
					}
				}); //close jQuery.ajax(
				return false;
			});
		});
    </script>
	<div id="cform_msg" style="display:none;"><img src="<?php echo bloginfo('stylesheet_directory') ?>/images/social-small/loader.gif" border="0" align="absmiddle" /> Processing. . . Please wait.</div>
    <div id="cform_content">
        	<form action="" name="">
            <input type="hidden" id="myemail" name="myemail" value="" />
            <input type="hidden" id="property_id" name="property_id" value="" />
           <table width="550px" border="0">
              <tr>
                <td>Subject</td>
                <td><div id="mysubject_display"></div><input type="hidden" id="mysubject" name="mysubject" readonly="readonly" maxlength="30" size="35" value="" style="border:none;" /></td>
              </tr>
              <tr>
                <td>Your name</td>
                <td><input type="text" id="yourname" name="yourname" maxlength="30" size="35" value="" /></td>
              </tr>
              <tr>
                <td>Your email</td>
                <td><input type="text" id="youremail" name="youremail" maxlength="30" size="35" value="" /></td>
              </tr>
              <tr>
                <td>your message</td>
                <td><textarea class="contactus_textarea_form" name="enquiry" id="enquiry"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" id="sendbtn" class="tbutton_contact sendbtn" name="submint" value="SEND"></td>
              </tr>
            </table>
			</form>
	</div>
        </div>
    </div>
