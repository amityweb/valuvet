function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	  {
		  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		  x=x.replace(/^\s+|\s+$/g,"");
		  if (x==c_name)
			{
			return unescape(y);
			}
	  }
}


function clearCookie( c_name ){
	document.cookie = c_name +"=;  expires=Thu, 01-Jan-70 00:00:01 GMT;";
}


function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function checkCookie( c_name )
{
	var cokiee=getCookie(c_name);
	
	if (cokiee!=null && cokiee!="") {
		return true;
	} else {
		return false;
  	}
}


window.addEvent('domready',function(){
	var menu = new DropMenu('navmenu-h');
	var follow = new MorphList($('navmenu-h'), {
		transition: Fx.Transitions.backOut,
		duration: 700
		/*onClick: function(ev, item) { ev.stop(); } */
	});

});
window.addEvent('load', function(){
	  if ($('feature_property')) new viewer($('feature_property').getChildren(),{mode:'bottom', interval:8000}).play(true);
});


jQuery(document).ready(function() {
	jQuery("#pkg1link").fancybox({
		'hideOnContentClick': false,
		'width'				: 800,
		'height'			: '90%',
        'autoScale'     	: false,
		'onStart'		: function() {
		  jQuery("#pkg1_show").show();  
		  jQuery("#pkg2_show").hide();
		  jQuery("#pkg2_show").hide();
		},
		'onClosed'		: function() {
		  jQuery("#pkg1_show").show();  
		  jQuery("#pkg2_show").hide();
		  jQuery("#pkg3_show").hide();
		}
	});
	jQuery("#pkg2link").fancybox({
		'hideOnContentClick': false,
		'width'				: 800,
		'height'			: '90%',
        'autoScale'     	: false,
		'onStart'		: function() {
		  jQuery("#pkg1_show").hide();  
		  jQuery("#pkg2_show").show();
		  jQuery("#pkg3_show").hide();
		},
		'onClosed'		: function() {
		  jQuery("#pkg1_show").hide();  
		  jQuery("#pkg2_show").hide();
		  jQuery("#pkg3_show").show();
		}
	});
	jQuery("#pkg3link").fancybox({
		'hideOnContentClick': false,
		'width'				: 800,
		'height'			: '70%',
        'autoScale'     	: false,
		'autoDimensions'	: false,
		'scrolling'			: 'yes',
		'onStart'		: function() {
		  jQuery("#pkg1_show").hide();  
		  jQuery("#pkg2_show").hide();
		  jQuery("#pkg3_show").show();
		},
		'onClosed'		: function() {
		  jQuery("#pkg1_show").show();  
		  jQuery("#pkg2_show").hide();
		  jQuery("#pkg3_show").hide();
		}
	});
	
	
	jQuery("#nextpgk2").click(function(){
		  jQuery("#pkg1_show").toggle(300);  
		  jQuery("#pkg2_show").toggle(300);
	});
	jQuery("#nextpgk3").click(function(){
		  jQuery("#pkg2_show").toggle(300);  
		  jQuery("#pkg3_show").toggle(300);
	});
	
	jQuery("#prepgk2").click(function(){
		  jQuery("#pkg3_show").toggle(300);  
		  jQuery("#pkg2_show").toggle(300);
	});
	jQuery("#prepgk1").click(function(){
		  jQuery("#pkg2_show").toggle(300);  
		  jQuery("#pkg1_show").toggle(300);
	});
	jQuery(".fancybox-google-map").click(function(){
		  jQuery("#google_map").toggle(300);  
	});
	

	jQuery("a.fancybox-contact").fancybox({
		'hideOnContentClick': false
	});
	

	jQuery("a.newsletter_popup_link").fancybox({
		'hideOnContentClick': false
	});
	
	
	jQuery(".fancybox-iframe").fancybox({
		'width'				: 750,
		'height'			: 500,
		'autoDimensions'	: false,
        'autoScale'     	: false,
        'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});

});
jQuery(document).ready(function() {
	jQuery("a.fancybox-image").fancybox();
	jQuery("a#fancybox-image").fancybox();
	
	jQuery('.dollar_sign').priceFormat({
		prefix: '',
		thousandsSeparator: ','
	});
});


function get_formatted_price( amount ){
	var delimiter = ","; // replace comma if desired
	amount = new String(amount);
	//remove all commas
	var t =  amount.replace(/\,/g,'');
	return parseFloat(t);
}

/**var mygallery=new fadeSlideShow({
	wrapperid: "headershow", //ID of blank DIV on page to house Slideshow
	dimensions: [346, 100], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_01.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_02.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_03.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_04.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_05.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_06.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_07.jpg"] //<--no trailing comma after very last image element!
	],
	displaymode: {type:'auto', pause:2500, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 500, //transition duration (milliseconds)
	descreveal: "ondemand",
	togglerid: ""
});
/**/
function takemethere1() {
	var domain = 'http://valuvet.com.au/_dev2/property-overview/?p=property?wpp_search[pagination]=on&wpp_search[practice_state]=';
	  if (document.selectlistform.selectlist1.selectedIndex == 0) alert("Please make a selection.");
	  else if (document.selectlistform.selectlist1.selectedIndex == 1) location = domain+'QLD'; 
	  else if (document.selectlistform.selectlist1.selectedIndex == 2) location = domain+'NSW';
	  else if (document.selectlistform.selectlist1.selectedIndex == 3) location = domain+'ACT';
	  else if (document.selectlistform.selectlist1.selectedIndex == 4) location = domain+'VIC'; 
	  else if (document.selectlistform.selectlist1.selectedIndex == 5) location = domain+'SA';
	  else if (document.selectlistform.selectlist1.selectedIndex == 6) location = domain+'WA';
	  else if (document.selectlistform.selectlist1.selectedIndex == 7) location = domain+'NT';
	  else if (document.selectlistform.selectlist1.selectedIndex == 8) location = domain+'TAS'; 
}
