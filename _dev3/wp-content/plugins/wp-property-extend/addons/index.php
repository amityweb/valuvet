<?php

//-- initialize environment ---------------------------------------------------

date_default_timezone_set("Australia/Brisbane");

define('DEV', (substr($_SERVER['SERVER_NAME'], 0, 4) == 'dev.'));

set_include_path('.'.PATH_SEPARATOR.dirname(__FILE__).DIRECTORY_SEPARATOR.'_include');
// $time_start = microtime(1);


//
$redirects = array(
//   from            =>   to
	'whoweare.htm'   =>  'about_us',
	'admission.htm'  =>  'services',
	'employment.htm' =>  'employment',
	'contact.htm'    =>  'contact_us'
);


//-- initialize environment ---------------------------------------------------

// determine site root
$_SR = '/'.trim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($_SR != '/') $_SR .= '/';

// get page name
$page = empty($_GET['p'])
	? 'pages/index'
	: "pages/".trim($_GET['p'], '/\\');

if (is_dir('_include/'.$page))
{
	$page .= '/index';
}

$page .= '.php';

if (! file_exists('_include/'.$page))
{
	// redirect
	if (isset($redirects[$_SERVER['REQUEST_URI']]))
	{
		header("HTTP/1.0 301 Moved Permanently");
		header("Location: ".$_SR.$redirects[$_SERVER['REQUEST_URI']]);
		exit;
	}

	// page not found
	echo $page;
	header("HTTP/1.0 404 Not Found");
	$page = 'pages/error/404.php';
}

// load page
include $page;
