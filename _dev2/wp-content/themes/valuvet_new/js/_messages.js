
function validate_listproperty(form) {

var fullname = form.fullname.value;
if(fullname == "") {
inlineMsg('fullname','You must enter your name.');
return false;
}

var email = form.email.value;
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
if(email == "") {
inlineMsg('email','<strong>Error</strong><br />You must enter your email.',2);
return false;
}
if(!email.match(emailRegex)) {
inlineMsg('email','<strong>Error</strong><br />You have entered an invalid email.',2);
return false;
}

var phone = form.phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
inlineMsg('phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
inlineMsg('phone','You have entered an invalid phone number.',2);
return false;
}

// all ok
return true;
}




function validate_interest(form) {

var fullname = form.e_fullname.value;
if(fullname == "") {
inlineMsg('e_fullname','You must enter your name.');
return false;
}

var email = form.e_email.value;
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
if(email == "") {
inlineMsg('e_email','<strong>Error</strong><br />You must enter your email.',2);
return false;
}
if(!email.match(emailRegex)) {
inlineMsg('e_email','<strong>Error</strong><br />You have entered an invalid email.',2);
return false;
}

var phone = form.e_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
inlineMsg('e_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
inlineMsg('e_phone','You have entered an invalid phone number.',2);
return false;
}

var id = form.e_id.value;
if(id == "") {
inlineMsg('e_id','You must enter your a Property ID.');
return false;
}

// all ok
return true;
}

function validate_valuation(form) {

var practice = form.v_practice.value;
if(practice == "") {
inlineMsg('v_practice','You must enter the name of your Practice.');
return false;
}


var fullname = form.v_fullname.value;
if(fullname == "") {
inlineMsg('v_fullname','You must enter your name.');
return false;
}

var email = form.v_email.value;
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
if(email == "") {
inlineMsg('v_email','<strong>Error</strong><br />You must enter your email.',2);
return false;
}
if(!email.match(emailRegex)) {
inlineMsg('v_email','<strong>Error</strong><br />You have entered an invalid email.',2);
return false;
}

var phone = form.v_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
inlineMsg('v_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
inlineMsg('v_phone','You have entered an invalid phone number.',2);
return false;
}

// all ok
return true;
}







function validate_alert(form) {

var fullname = form.a_fullname.value;
if(fullname == "") {
inlineMsg('a_fullname','You must enter your name.');
return false;
}

var email = form.a_email.value;
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
if(email == "") {
inlineMsg('a_email','<strong>Error</strong><br />You must enter your email.',2);
return false;
}
if(!email.match(emailRegex)) {
inlineMsg('a_email','<strong>Error</strong><br />You have entered an invalid email.',2);
return false;
}


// all ok
return true;
}




function validate_enews(form) {

var fullname = form.s_fullname.value;
if(fullname == "") {
inlineMsg('s_fullname','You must enter your name.');
return false;
}

var email = form.s_email.value;
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
if(email == "") {
inlineMsg('s_email','<strong>Error</strong><br />You must enter your email.',2);
return false;
}
if(!email.match(emailRegex)) {
inlineMsg('s_email','<strong>Error</strong><br />You have entered an invalid email.',2);
return false;
}


// all ok
return true;
}




function validate_enquiry(form) {

var fullname = form.g_fullname.value;
if(fullname == "") {
inlineMsg('g_fullname','You must enter your name.');
return false;
}

var email = form.g_email.value;
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
if(email == "") {
inlineMsg('g_email','<strong>Error</strong><br />You must enter your email.',2);
return false;
}
if(!email.match(emailRegex)) {
inlineMsg('g_email','<strong>Error</strong><br />You have entered an invalid email.',2);
return false;
}

var phone = form.g_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
inlineMsg('g_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
inlineMsg('g_phone','You have entered an invalid phone number.',2);
return false;
}

var id = form.g_subject.value;
if(id == "") {
inlineMsg('g_subject','You must enter your a subject heading.');
return false;
}

var id = form.g_comments.value;
if(id == "") {
inlineMsg('g_comments','You have not provided the detials of your enquiry.');
return false;
}

// all ok
return true;
}






function validate_advertise(form) {

var firstname = form.ad_firstname.value;
if(firstname == "") {
form.ad_firstname.focus();
inlineMsg('ad_firstname','You must enter your name.');
return false;
}

var surname = form.ad_surname.value;
if(surname == "") {
form.ad_surname.focus();
inlineMsg('ad_surname','You must enter your surname.');
return false;
}

var email = form.ad_email.value;
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
if(email == "") {
form.ad_email.focus();
inlineMsg('ad_email','<strong>Error</strong><br />You must enter your email.',2);
return false;
}
if(!email.match(emailRegex)) {
form.ad_email.focus();
inlineMsg('ad_email','<strong>Error</strong><br />You have entered an invalid email.',2);
return false;
}

var phone = form.ad_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
form.ad_phone.focus();
inlineMsg('ad_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
form.ad_phone.focus();
inlineMsg('ad_phone','You have entered an invalid phone number.',2);
return false;
}

var phone = form.ad_alt_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
form.ad_alt_phone.focus();
inlineMsg('ad_alt_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
form.ad_alt_phone.focus();
inlineMsg('ad_alt_phone','You have entered an invalid phone number.',3);
return false;
}
 
var id = form.ad_practice_name.value;
if(id == "") {
form.ad_practice_name.focus();
inlineMsg('ad_practice_name','You must enter the trading name of your business.');
return false;
}

var phone = form.ad_practice_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
form.ad_practice_phone.focus();
inlineMsg('ad_practice_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
form.ad_practice_phone.focus();
inlineMsg('ad_practice_phone','You have entered an invalid phone number.',2);
return false;
}

var id = form.ad_address.value;
if(id == "") {
form.ad_address.focus();
inlineMsg('ad_address','You must enter your business address.');
return false;
}

var id = form.ad_suburb.value;
if(id == "") {
form.ad_suburb.focus();
inlineMsg('ad_suburb','You must enter your suburb.');
return false;
}

var id = form.ad_postcode.value;
if(id == "") {
form.ad_postcode.focus();
inlineMsg('ad_postcode','Please entre a Postcode.');
return false;
}

var id = form.ad_headline.value;
if(id == "") {
form.ad_headline.focus();
inlineMsg('ad_headline','You must enter your a advertisement headline.');
return false;
}


// all ok
return true;
}

// ==================

function validate_seminar(form) {

var firstname = form.seminar_firstname.value;
if(firstname == "") {
form.seminar_firstname.focus();
inlineMsg('seminar_firstname','You must enter your name.');
return false;
}

var surname = form.seminar_surname.value;
if(surname == "") {
form.seminar_surname.focus();
inlineMsg('seminar_surname','You must enter your surname.');
return false;
}

var email = form.seminar_email.value;
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
if(email == "") {
form.seminar_email.focus();
inlineMsg('seminar_email','<strong>Error</strong><br />You must enter your email.',2);
return false;
}
if(!email.match(emailRegex)) {
form.seminar_email.focus();
inlineMsg('seminar_email','<strong>Error</strong><br />You have entered an invalid email.',2);
return false;
}

var phone = form.seminar_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
form.seminar_phone.focus();
inlineMsg('seminar_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
form.seminar_phone.focus();
inlineMsg('seminar_phone','You have entered an invalid phone number.',2);
return false;
}


// all ok
return true;
}



// ==================

function validate_position(form) {

var firstname = form.position_firstname.value;
if(firstname == "") {
form.position_firstname.focus();
inlineMsg('position_firstname','You must enter your name.');
return false;
}

var surname = form.position_surname.value;
if(surname == "") {
form.position_surname.focus();
inlineMsg('position_surname','You must enter your surname.');
return false;
}
var email = form.position_email.value;
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
if(email == "") {
form.position_email.focus();
inlineMsg('position_email','<strong>Error</strong><br />You must enter your email.',2);
return false;
}
if(!email.match(emailRegex)) {
form.position_email.focus();
inlineMsg('position_email','<strong>Error</strong><br />You have entered an invalid email.',2);
return false;
}

var phone = form.position_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
form.position_phone.focus();
inlineMsg('position_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
form.position_phone.focus();
inlineMsg('position_phone','You have entered an invalid phone number.',2);
return false;
}
var phone = form.position_alt_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
form.position_alt_phone.focus();
inlineMsg('position_alt_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
form.position_alt_phone.focus();
inlineMsg('position_alt_phone','You have entered an invalid phone number.',3);
return false;
}
 var id = form.position_practice_name.value;
if(id == "") {
form.position_practice_name.focus();
inlineMsg('position_practice_name','You must enter the trading name of your business.');
return false;
}
var phone = form.position_practice_phone.value;
var phoneRegex = /^[0-9]{8,}$/;
if(phone== "") {
form.position_practice_phone.focus();
inlineMsg('position_practice_phone','You must enter a phone number.');
return false;
}
if(!phone.match(phoneRegex)) {
form.position_practice_phone.focus();
inlineMsg('position_practice_phone','You have entered an invalid phone number.',2);
return false;
}
var id = form.position_address.value;
if(id == "") {
form.position_address.focus();
inlineMsg('position_address','You must enter your business address.');
return false;
}
var id = form.position_suburb.value;
if(id == "") {
form.position_suburb.focus();
inlineMsg('position_suburb','You must enter your suburb.');
return false;
}
var id = form.position_postcode.value;
if(id == "") {
form.position_postcode.focus();
inlineMsg('position_postcode','Please entre a Postcode.');
return false;
}
var id = form.position_headline.value;
if(id == "") {
form.position_headline.focus();
inlineMsg('position_headline','You must enter your a advertisement headline.');
return false;
}


// all ok
return true;
}


// START OF MESSAGE SCRIPT //

var MSGTIMER = 20;
var MSGSPEED = 5;
var MSGOFFSET = 3;
var MSGHIDE = 3;

// build out the divs, set attributes and call the fade function //
function inlineMsg(target,string,autohide) {
  var msg;
  var msgcontent;
  if(!document.getElementById('msg')) {
    msg = document.createElement('div');
    msg.id = 'msg';
    msgcontent = document.createElement('div');
    msgcontent.id = 'msgcontent';
    document.body.appendChild(msg);
    msg.appendChild(msgcontent);
    msg.style.filter = 'alpha(opacity=0)';
    msg.style.opacity = 0;
    msg.alpha = 0;
  } else {
    msg = document.getElementById('msg');
    msgcontent = document.getElementById('msgcontent');
  }
  msgcontent.innerHTML = string;
  msg.style.display = 'block';
  var msgheight = msg.offsetHeight;
  var targetdiv = document.getElementById(target);
  targetdiv.select();
  var targetheight = targetdiv.offsetHeight;
  var targetwidth = targetdiv.offsetWidth;
  var topposition = topPosition(targetdiv) - ((msgheight - targetheight) / 2);
  var leftposition = leftPosition(targetdiv) + targetwidth + MSGOFFSET;
  msg.style.top = topposition + 'px';
  msg.style.left = leftposition + 'px';
  clearInterval(msg.timer);
  msg.timer = setInterval("fadeMsg(1)", MSGTIMER);
  if(!autohide) {
    autohide = MSGHIDE;
  }
  window.setTimeout("hideMsg()", (autohide * 1000));
}

// hide the form alert //
function hideMsg(msg) {
  var msg = document.getElementById('msg');
  if(!msg.timer) {
    msg.timer = setInterval("fadeMsg(0)", MSGTIMER);
  }
}

// face the message box //
function fadeMsg(flag) {
  if(flag == null) {
    flag = 1;
  }
  var msg = document.getElementById('msg');
  var value;
  if(flag == 1) {
    value = msg.alpha + MSGSPEED;
  } else {
    value = msg.alpha - MSGSPEED;
  }
  msg.alpha = value;
  msg.style.opacity = (value / 100);
  msg.style.filter = 'alpha(opacity=' + value + ')';
  if(value >= 99) {
    clearInterval(msg.timer);
    msg.timer = null;
  } else if(value <= 1) {
    msg.style.display = "none";
    clearInterval(msg.timer);
  }
}

// calculate the position of the element in relation to the left of the browser //
function leftPosition(target) {
  var left = 0;
  if(target.offsetParent) {
    while(1) {
      left += target.offsetLeft;
      if(!target.offsetParent) {
        break;
      }
      target = target.offsetParent;
    }
  } else if(target.x) {
    left += target.x;
  }
  return left;
}

// calculate the position of the element in relation to the top of the browser window //
function topPosition(target) {
  var top = 0;
  if(target.offsetParent) {
    while(1) {
      top += target.offsetTop;
      if(!target.offsetParent) {
        break;
      }
      target = target.offsetParent;
    }
  } else if(target.y) {
    top += target.y;
  }
  return top;
}

// preload the arrow //
if(document.images) {
  arrow = new Image(7,80);
  arrow.src = "images/msg_arrow.gif";
}