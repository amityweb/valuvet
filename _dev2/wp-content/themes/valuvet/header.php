<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/menu3.css">
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/toggle.css">
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/viewer.css">
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/menu/cmxform.css">

<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/style.css" media="all" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fadeslideshow.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.inputfocus-0.9.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.main.js"></script>
<script type="text/javascript">
jQuery.noConflict();

jQuery.validator.addMethod("selectnone",function(value,element){
	if(element.value=='')
	{
		return false;
	}else
	{
		return true;
	}
	
	},"This field is required.");
	
	jQuery.validator.addMethod("letteronly",function(value,element){
		return this.optional(element) ||/^[a-z]+$/i.test(value);
		
		},"Please Enter letter only");
	

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
				ad_practice_phone:{
					required:true,
						digits:true
						},
				ad_address:{
					required:true
						},
					ad_suburb:{
						required:true
							},
					ad_postcode:{
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
						ad_short_desc1:{
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
	   
	   jQuery("#vacant_booking_frm").validate({
		   ignore:":not(:visible)",
		   rules:{
			   position_hearabout:{
				   selectnone:true
				   },
				   ad_hearabout_other:{
					   required:true
					   },
					   ad_title:{
						   selectnone:true
						   },
						   ad_firstname:{
							   required:true,
							   letteronly:true
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
											   required:true,
											   digits:true
											   },
											   ad_practice_name:{
												   required:true,
												   letteronly:true
												   },
												   ad_practice_phone:{
													   required:true
													   },
													   ad_address:{
														   required:true
														   },
														   ad_suburb:{
															   required:true
															   },
															   ad_postcode:{
																   required:true,
																   digits:true
																   },
																   ad_state:{

																	   selectnone:true
																	   },
																	   ad_country:{
																		   required:true
																		   },
																		   position_hours:{
																			   digits:true
																			   },
																			   position_salary:{
																				   digits:true
																				   },position_financial_incentives:{
																					   digits:true
																					   
																					   }
			   
			   }
		   
		   
		   });
	   
	   
	   
	   });


	function show_other()
	{
		jQuery(document).ready(function(){
			var data=jQuery("#hear_from").val();
			if(data=='Other')
			{
				jQuery("#ad_hearabout_other").show();
				jQuery("#otherhear_text").show();
				
			}
			else
			{
				jQuery("#ad_hearabout_other").hide();
				jQuery("#otherhear_text").hide();
			}
			});
	}
	function show_software()
	{
	jQuery(document).ready(function(){
			var data=jQuery("#ad_software").val();
			if(data=='Other')
			{
				jQuery("#ad_software_other").show();
				jQuery("#other_soft_text").show();
			}
			else
			{
				jQuery("#ad_software_other").hide();
			    jQuery("#other_soft_text").hide();
			}
			});	
		
	}
	function show_vacant_other()
	{
		
		jQuery(document).ready(function(){
			var data=jQuery("#position_hearabout").val();
			if(data=='Other')
			{
				jQuery("#ad_text_other").show();
				jQuery("#ad_hearabout_other").show();
			}
			else
			{
				jQuery("#ad_text_other").hide();
			    jQuery("#ad_hearabout_other").hide();
			}
			});	
		
	}
	
	
	
	
	
	

</script>



























<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery(".headingmenu10").click(function () {
	jQuery(".form_openclose").slideToggle("slow");
	});
});

jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery("#heading_01").click(function () {
	jQuery("#openclose_01").slideToggle("slow");
	});
});

jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery("#heading_02").click(function () {
	jQuery("#openclose_02").slideToggle("slow");
	});
});

jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery("#heading_03").click(function () {
	jQuery("#openclose_03").slideToggle("slow");
	});
});

jQuery.noConflict();
jQuery(document).ready(function() {
	jQuery("#heading_policy").click(function () {
	jQuery("#openclose_policy").slideToggle("slow");
	});
});
</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/menu/mootools-1_002.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/menu/viewer.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/menu/morphlist_1.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/menu/dropMenu2.js"></script>

<script type="text/javascript">

var mygallery=new fadeSlideShow({
	wrapperid: "fadeshow1", //ID of blank DIV on page to house Slideshow
	dimensions: [346, 100], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
		["wp-content/themes/valuvet/images/banner_01.jpg", "", "", ""],
		["wp-content/themes/valuvet/images/banner_02.jpg", "#", "_new", ""],
		["wp-content/themes/valuvet/images/banner_03.jpg"],
		["wp-content/themes/valuvet/images/banner_04.jpg"],
		["wp-content/themes/valuvet/images/banner_05.jpg"],
		["wp-content/themes/valuvet/images/banner_06.jpg"],
		["wp-content/themes/valuvet/images/banner_07.jpg", "", "", ""] //<--no trailing comma after very last image element!
	],
	displaymode: {type:'auto', pause:2500, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 500, //transition duration (milliseconds)
	descreveal: "ondemand",
	togglerid: ""
});
</script>

<!--<script type="text/javascript">
//<![CDATA[
var site_root='/';

window.addEvent('load', function(){
  if ($('feature_property')) new viewer($('feature_property').getChildren(),{mode:'bottom', interval:8000}).play(true);
  new viewer($('header-slide').getChildren(),{mode:'alpha', interval:4000}).play(true);

SqueezeBox.assign($$('a[rel=boxed]'), {size: {x: 650, y: 400},ajaxOptions: {method: 'get'}});
});

//]]>
</script>

<script type="text/javascript">
//<![CDATA[
var site_root='/';

window.addEvent('load', function(){
  if ($('feature_property2')) new viewer($('feature_property2').getChildren(),{mode:'bottom', interval:8000}).play(true);
  new viewer($('header-slide').getChildren(),{mode:'alpha', interval:4000}).play(true);

SqueezeBox.assign($$('a[rel=boxed]'), {size: {x: 650, y: 400},ajaxOptions: {method: 'get'}});
});

//]]>
</script>
-->



<script type="text/javascript">
window.addEvent('domready',function(){
var menu = new DropMenu('navmenu-h');

var follow = new MorphList($('navmenu-h'), {
    transition: Fx.Transitions.backOut,
    duration: 700
    /*onClick: function(ev, item) { ev.stop(); } */
});
});

</script>

</head>
<body>
<div id="container">
<div id="header">
	<div style="height:102px; text-align:left; width:983px;">
    	<div id="logo_main"><a href="./"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="Logo" /></a></div>
        <div id="top_banner">
        	<div id="fadeshow1"></div>
       	</div>
        <div class="clear"></div>	
    </div>

		<div id="menu-container">
        <div id="menu_center">
		<?php wp_nav_menu( array('menu' => 'main_menu', 'menu_id' => 'navmenu-h',  'menu_class' => 'mainmenu' )); ?>
        </div></div>

		<div id="header-phone">
            <p class="hp-line1">Please call us on</p>
            <h2 class="hp-line2">07 <b>3831 5555</b></h2>
        </div> 

</div>


  
<!--Search-->

<!--End Search-->

<!-- start page -->
<div id="page">
<div id="page-bgtop">