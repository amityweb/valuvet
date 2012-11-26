<?php

$pageinfo = array('full_name' => __('Front form Configuration',"meenews"), 'optionname'=>'front', 'child'=>true, 'filename' => basename(__FILE__),
"tpl_needed" => array("home" => "styles.html","INSERTS" => "inserts.html","HEADER" => "header.html","FOOTER" => "footer.html"));

$options = array();


$options[] = array(	"name" => __("Html subscription form editor","meenews"),
                        "type" => "startBox");


                    
$options[] = array(	"name" => __("Want modify Html subscription form:","meenews"),
                        "desc" => __("Do you want modify front end subscription form'HTML code?","meenews"),
                        "id"   => "want_modify_html",
                        "std"  => "false",
                        "type2" => "hide_option",
			"type" => "Iswitch");

$options[] = array(	"name" => __("HTML subscription form:","meenews"),
                        "desc" => __("Here you can customize your subscription form, type your custom html here","meenews"),
                        "id"   => "html_front",
			"std"  => " <script type='text/javascript' src='".MEENEWS_URI."js/tvjava.js'></script>


                                    <form action='' id='frontendform' name='frontendform' method='post' >

                                     <input id='emailInput' onBlur=\" if(this.value==''){ this.value='Insert E-mail' }\"
                 onfocus=\"  if(this.value=' Insert E-mail'){ this.value=''}\"
                 type='text' name='emailInput'  value='Insert E-mail'  style = 'width:px; float:left ; margin-right:10px' /><br>

                <input type='hidden' id='newsletterHidden' name='newsletterHidden' value='true' />
                <input type='hidden' id='loadingurl' name='loadingurl' value='".MEENEWS_URI."images/ajax-loader2.gif' />
                <input type='hidden' id='messagenote' name='messagenote' value='Please check legal advice' />

                <input type='hidden' id='urlAjax' name='urlAjax' value='".MEENEWS_URI."' /> <input type='hidden' id='listSuscribes' name='listSuscribes' value='1' />
                            <a href='javascript:Inscribe()' style='float:left; margin-top:0px;'><img  src='".MEENEWS_URI."customimages/boton.jpg' style = 'float:left ; margin-right:10px'></a> </form>
        	     <div id='resultado' class='advertise'> </div>. ",
			"type" => "textarea",
                        "type2" => "endhide");

$options[] = array(     "type" => "endBox");

$options[] = array(	"name" => __("Form colors Configuration","meenews"),
                        "type" => "startBox");

                    
$options[] = array(	"name" => __("Input text Color","meenews"),
                        "desc" => __("Do you want call to action in you home page?","meenews"),
                        "id"   => "input_textcolor",
                        "std"  => "#000",
			"type" => "colorpicker");

$options[] = array(	"name" => __("Input background Color","meenews"),
                        "desc" => __("Do you want call to action in you home page?","meenews"),
                        "id"   => "input_backgroundcolor",
                        "std"  => "#FFF",
			"type" => "colorpicker");

$options[] = array(	"name" => __("Input border color","meenews"),
                        "desc" => __("Do you want call to action in you home page?","meenews"),
                        "id"   => "input_bordercolor",
                        "std"  => "#000",
			"type" => "colorpicker");


$options[] = array(	"name" => __("Advertise color","meenews"),
                        "desc" => __("Do you want call to action in you home page?","meenews"),
                        "id"   => "advertise_color",
                        "std"  => "#000",
			"type" => "colorpicker");


$options[] = array(     "type" => "endBox");


$options[] = array(	"name" => __("Default Front Form Configuration","meenews"),
                        "type" => "startBox");

$options[] = array(	"name" => __("Input Email","meenews"),
                        "desc" => __("This text appears into Email input field","meenews"),
                        "id"   => "input_text_email",
                        "std"  => __("Insert Email","meenews"),
			"type" => "text");

$options[] = array(	"name" => __("Default button","meenews"),
                        "desc" => __("Default image button subscription","meenews"),
                        "id"   => "default_button",
			"std"  => MEENEWS_LIB_URI."img/button_subscription.jpg",
                        "size" => 80,
			"type" => "image");
                    
$options[] = array(     "type" => "endBox");


$options[] = array(	"name" => __("Subscription form configuration","meenews"),
                        "type" => "startBox");


$options[] = array(	"name" => __("Input Name:","meenews"),
                        "desc" => __("If you want your users to insert their Name","meenews"),
                        "id"   => "want_name",
                        "std"  => "false",
                        "type2" => "hide_option",
			"type" => "Iswitch");


$options[] = array(	"name" => __("Name Field","meenews"),
                        "desc" => __("This text appears into Name input field","meenews"),
                        "id"   => "text_name",
                        "std"  => __("Your Name","meenews"),
                        "type2" => "end_hide",
			"type" => "text");
                    

$options[] = array(	"name" => __("Input Company:","meenews"),
                        "desc" => __("If you want your users to insert their Company","meenews"),
                        "id"   => "want_company",
                        "std"  => "false",
                        "type2" => "hide_option",
			"type" => "Iswitch");


$options[] = array(	"name" => __("Company Field","meenews"),
                        "desc" => __("This text appears into Company input field","meenews"),
                        "id"   => "text_company",
                        "std"  => __("Your Company","meenews"),
                        "type2" => "end_hide",
			"type" => "text");
                    

$options[] = array(	"name" => __("Input Country:","meenews"),
                        "desc" => __("If you want your users to insert their country","meenews"),
                        "id"   => "want_country",
                        "std"  => "false",
                        "type2" => "hide_option",
			"type" => "Iswitch");


$options[] = array(	"name" => __("Country Field","meenews"),
                        "desc" => __("This text appears into addres input field","meenews"),
                        "id"   => "country_text",
                        "std"  => __("Your Country","meenew"),
                        "type2" => "end_hide",
			"type" => "text");

$options[] = array(	"name" => __("Input Address:","meenews"),
                        "desc" => __("If you want your users to insert their address","meenews"),
                        "id"   => "want_address",
                        "std"  => "false",
                        "type2" => "hide_option",
			"type" => "Iswitch");


$options[] = array(	"name" => __("Address Field","meenews"),
                        "desc" => __("This text appears into addres input field","meenews"),
                        "id"   => "address_text",
                        "std"  => __("Your Address","meenews"),
                        "type2" => "end_hide",
			"type" => "text");
                    
$options[] = array(	"name" => __("Legal Conditions (check):","meenews"),
                        "desc" => __("Display checkbox of legal conditions","meenews"),
                        "id"   => "want_legal",
                        "std"  => "false",
                        "type2" => "hide_option",
			"type" => "Iswitch");

$options[] = array(	"name" => __("Url legal conditions","meenews"),
                        "desc" => __("Insert html link (http:www.web.com/legal).","meenews"),
                        "id"   => "url_legal",
                        "std"  => "<a href='http://www.example.com/legal' style='color:blue'>Legal Conditions</a>",
                        "type2" => "end_hide",
			"type" => "text");

$options[] = array(     "type" => "endBox");


$options_page = new MeenewsManager($options, $pageinfo);


