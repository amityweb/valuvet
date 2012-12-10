// JavaScript Document
jQuery(document).ready(function() {
	jQuery(".bulk_enquiry").click(function(){
		var id = jQuery(this).attr("id");
		var cook = checkCookie(id);
		var proid = id.split("_");
		if( !cook ){
			 setCookie(id,proid[1], 2);
			 jQuery("#"+id).html("- Remove Enquiry");
		} else {
			clearCookie(id);
			jQuery("#"+id).html("+ Add Enquiry");
		}
		check_comments_tags();
	});
	
	jQuery("#bulk_enquiery_alert").fancybox({
		'hideOnContentClick': false,
		'scrolling'			: 'auto',
		'onStart'		: function() {
			co = get_allthis_cookies();
			jQuery("#bulk_cform_content").show();
			jQuery("#bulk_cform_msg").hide();
			setSendform();
		},
		'onClosed'		: function() {
		  jQuery("#bulk_properties").val('');
		  jQuery("#bulk_yourname").val('');  
		  jQuery("#bulk_youremail").val('');
		  jQuery("#bulk_yourphone").val('');
		  jQuery("#bulk_mysubject_display").html('');
		  jQuery("#bulk_cform_msg").html('Processing. . . Please wait.');
		}
	});


	function set_comments_tags(){
		var i,x,y,ARRcookies=document.cookie.split(";");
		for (i=0;i<ARRcookies.length;i++)
		  {
			  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
			  x=x.replace(/^\s+|\s+$/g,"");
			 if( jQuery("#"+x) ){
				 jQuery("#"+x).html("- Remove Enquiry");
			 }
		  }
	}
	
	function get_allthis_cookies(){
		var co=0;
		var i,x,y,ARRcookies=document.cookie.split(";");
		for (i=0;i<ARRcookies.length;i++)
		  {
			  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
			  x=x.replace(/^\s+|\s+$/g,"");
			 if( jQuery("#"+x) ){
				 var id = jQuery("#"+x).attr("id");
				 if( id ){
					 var proid = id.split("_");
					 if( proid[1]==y ){
						 co = co+ 1;
					 }
				 }
			 }
		  }
		  return co;
	}
	
	function check_comments_tags(){
		co = get_allthis_cookies();
		if( co>0 ){
			jQuery("#enquiery_btn").show();
		} else {
			jQuery("#enquiery_btn").hide();
		}
	}
	
	function setSendform(){
		var properyids = 'c';
		var flaged_properyids = '';
		var first = true;
		var i,x,y,ARRcookies=document.cookie.split(";");
		for (i=0;i<ARRcookies.length;i++)
		  {
			  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
			  x=x.replace(/^\s+|\s+$/g,"");
			 if( x.substr(0, 5)=="flag_" ){
				 if( first ){
				 	properyids = y.toString();
					flaged_properyids = 'S'+y.toString();
					first = false;
				 } else {
					flaged_properyids = flaged_properyids +','+'S'+y.toString();
				 	properyids = properyids +','+ y.toString();
				 }
			 }
		  }
		jQuery("#bulk_properties").val(properyids);
		jQuery("#bulk_mysubject_display").text('Enquiry for : '+flaged_properyids);
	}
	
	set_comments_tags();
	check_comments_tags();
});
