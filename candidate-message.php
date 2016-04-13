<?php

session_start();
include_once("config.php");
//isLoggedin($db); ==> Not required here since this is a public page

$pageTitle    = '';
$errorMsg     = '';
$successMsg   = '';

if($_GET['action'] == "success"){
	$pageTitle = 'Thank You!';
	$successMsg = 'Thank You! Your Form has been submitted sucessfully.';	
}
else if($_GET['action'] == "fail"){
	$pageTitle = 'Sorry!';
	$errorMsg = 'Sorry your form could not be submitted. Please try again.';	
}
else if($_GET['action'] == "expired"){
	$pageTitle = 'Sorry!';
	$errorMsg = 'The due date of this form has passed. Thank you for your interest!';	
}
else if($_GET['action'] == "unavailable"){
	$pageTitle = 'Sorry!';
	$errorMsg = 'The application form is not available right now. Give it a try some other time!';	
}
else {
	$pageTitle = 'Sorry!';
	$errorMsg = 'There was some problem in processing your request. Try again!';	
}

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('pageTitle', $pageTitle);

$html = $tpl->draw('candidate-message');
?>