<?php
if($_POST['acc'] == "add_member"){
    global $wpdb, $user_identity, $user_ID;

		if(empty($_POST['newsletter'])) {

			return;
		}
        require_once('../../../../../wp-config.php');

        $datas = array("email" => $_POST['email'],
                      "name" => $_POST['name'],
                      "id_categoria" =>$_POST['lista'],
                      "direction" => $_POST['direction'],
                      "enterprise" => $_POST['company'],
                      "country"=>$_POST['country']);
                  
        if($datas['email'] != "") {


            $bots_useragent = array('googlebot', 'google', 'msnbot', 'ia_archiver', 'lycos', 'jeeves', 'scooter', 'fast-webcrawler', 'slurp@inktomi', 'turnitinbot', 'technorati', 'yahoo', 'findexa', 'findlinks', 'gaisbo', 'zyborg', 'surveybot', 'bloglines', 'blogsearch', 'ubsub', 'syndic8', 'userland', 'gigabot', 'become.com');
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            foreach ($bots_useragent as $bot) {
                    if (stristr($useragent, $bot) !== false) {
                            return;
                    }
            }
            if($datas['lista'] == "") {
                $lista = 1;
            }

			$message = "";
			$result = 0;
                        $user = new MeeUsers($options,$datas);
			$value = $user->addSubscriptor($datas);

		    echo $user->message;


			exit();
		}
		echo __("Please insert you mail", 'meenews');;

		exit();
}

if(!class_exists('FrontMeeNews')){
##################################################################
class FrontMeeNews {
##################################################################		

	//constructor
        function FrontMeeNews()
	{
		// set options and page variables
                $this->showFront();
	}


        function printFormSubscription($list = 1){

            global $meenews_datas;



                $action = get_bloginfo("url");
                $urloading = MEENEWS_LIB_URI."img/loading.gif";
                $inputTextColor     =  $meenews_datas['front']['input_textcolor'];
                $inputTextBackColor =  $meenews_datas['front']['input_backgroundcolor'];
                $inputTextBorderColor =$meenews_datas['front']['input_bordercolor'];

                $inputTextImage     =  $meenews_datas['front']['size_title'];

                $inputTextcolorLink =  $meenews_datas['front']['advertise_link_color'];
                $advertiseColor     =  $meenews_datas['front']['advertise_color'];
                $inputWidth         =  $meenews_datas['front']['color_background'];
                $email              =  $meenews_datas['front']['input_text_email'];

                $form ="
                    <script type='text/javascript' src='".MEENEWS_LIB_URI."js/tvjava.js'></script>


                    <form action='' id='frontendform' name='frontendform' method='post' >
<h1 style = 'padding-right:10px'>Subscribe to our Newsletter </h1>
  <label for='emailInput'>Email:</label> 
                    <input id='emailInput' onBlur=\" if(this.value==''){ this.value='".$meenews_datas['front']['input_text_email']."' }\"
                     onfocus=\"  if(this.value='".$meenews_datas['front']['input_text_email']."'){ this.value=''}\"
                     type='text' name='emailInput'  value=\"".$meenews_datas['front']['input_text_email']." \"  style = 'width:".$meenews_datas['front']['input_width']."px; border:1px solid $inputTextBorderColor; color: $inputTextColor; background-color: $inputTextBackColor;margin-right:10px' /><br>

                    <input type='hidden' id='newsletterHidden' name='newsletterHidden' value='true' />
                    <input type='hidden' id='loadingurl' name='loadingurl' value='$urloading' />
                    <input type='hidden' id='messagenote' name='messagenote' value='' />

                    <input type='hidden' id='urlAjax' name='urlAjax' value='".MEENEWS_CLASSES_URI."front_meenews.php' />";


                    $form .= " <input type='hidden' id='listSuscribes' name='listSuscribes' value='$list' />";
                    
                    if ($meenews_datas['front']['want_name'] == 'true'){
                        $form .= "
                       <label for='nameInput' >Name:</label>  
                     <input id='nameInput' onBlur=\" if(this.value==''){ this.value='".$meenews_datas['front']['text_name']."' }\"
                     onfocus=\"  if(this.value='".$meenews_datas['front']['text_name']."'){ this.value=''}\"
                     type='text' name='nameInput'  value=\"".$meenews_datas['front']['text_name']." \"  style = 'width:".$meenews_datas['front']['input_width']."px; border:1px solid $inputTextBorderColor; color: $inputTextColor; background-color: $inputTextBackColor;margin-right:10px' /><br>";
              
                    }
                    if ($meenews_datas['front']['want_address'] == 'true'){
                        $form .= "
                         <input id='directionInput' onBlur=\" if(this.value==''){ this.value='".$meenews_datas['front']['address_text']."' }\"
                         onfocus=\"  if(this.value='".$meenews_datas['front']['address_text']."'){ this.value=''}\"
                         type='text' name='directionInput'  value=\"".$meenews_datas['front']['address_text']." \"  style = 'width:".$meenews_datas['front']['input_width']."px; float:left ;border:1px solid $inputTextBorderColor; color: $inputTextColor; background-color: $inputTextBackColor;margin-right:10px'/><br>";

                    }
                     if ($meenews_datas['front']['want_company'] == 'true'){
                          $form .= "
                         <input id='companyInput' onBlur=\" if(this.value==''){ this.value='".$meenews_datas['front']['text_company']."' }\"
                         onfocus=\"  if(this.value='".$meenews_datas['front']['text_company']."'){ this.value=''}\"
                         type='text' name='companyInput'  value=\"".$meenews_datas['front']['text_company']." \"  style = 'width:".$meenews_datas['front']['input_width']."px; float:left ;border:1px solid $inputTextBorderColor; color: $inputTextColor; background-color: $inputTextBackColor;margin-right:10px' /><br>";

                    }
                    if ($meenews_datas['front']['want_country'] == 'true'){
                         $form .= "
                         <input id='countryInput' onBlur=\" if(this.value==''){ this.value='".$meenews_datas['front']['country_text']."' }\"
                         onfocus=\"  if(this.value='".$meenews_datas['front']['country_text']."'){ this.value=''}\"
                         type='text' name='countryInput'  value=\"".$meenews_datas['front']['country_text']." \"  style = 'width:".$meenews_datas['front']['input_width']."px; float:left ;border:1px solid $inputTextBorderColor; color: $inputTextColor; background-color: $inputTextBackColor;margin-right:10px' /><br>";
                    }



                     $form .= "
                                <a href='javascript:Inscribe()' style='position:relative; clear:both;'>
                                
                                <img  src='".$meenews_datas['front']['default_button']."' style = 'position:relative; clear:both; margin-top:15px; '></a>";

                    if ($meenews_datas['front']['want_legal'] == 'true'){
                        $form .= "
                             <p style='clear:both;float:none'><input type='checkbox' name='legalnote' id='legalnote' value='' />".$meenews_datas['front']['url_legal']."</p>
                        ";
                    }
                    $form .= " </form>
                         <div id='resultado' class='advertise'> </div>
                ";
                
               return $form;
 
            }

            function showFront(){
                global $meenews_datas;
                if($meenews_datas['front']['want_modify_html'] == "false"){
                    $form = $this->printFormSubscription();
                    
                }else{
                    $form = $meenews_datas['front']['html_front'];
                }
                return $form;
            }
            
            function showMessage($send){
            global $meenews_datas;

                  switch ($send['message'])
                  {
                    case 'confirm':
                       $this->mailer->Subject  =  __("Activate account confirmation","meenews")." - ".get_bloginfo("name");
                       $send['content'] = $this->giveMessageProperties($meenews_datas['meenews']['text_mail_confirmation'],$send['member']['confkey']);
                       return $this->send($send);
                    break;
                    case 'delete':
                       $this->mailer->Subject  = __("Delete account confirmation","meenews")." - ".get_bloginfo("name");
                       $send['content'] = $this->giveMessageProperties($meenews_datas['meenews']['text_delete_subscription'],$send['member']['confkey']);
                       return $this->send($send);
                    break;
                    case 'end_subscription':
                       $this->mailer->Subject  =  __("Congratulations your subcription has finished","meenews")." - ".get_bloginfo("name");;;
                       $send['content'] = $this->giveMessageProperties($meenews_datas['meenews']['text_end_subscription'],$send['member']['confkey']);
                       return $this->send($send);
                    break;
                  }
        }
          
##################################################################
} # end class
##################################################################
}