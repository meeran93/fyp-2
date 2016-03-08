<?php

session_start();
include_once("config.php");
//isLoggedin($db);

$pageTitle    = '';

$errorMsg     = '';
$successMsg   = '';

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;
	if($_GET['action'] == "success"){
		$pageTitle    = 'Thank You!';
		$successMsg = 'Thank You! Your Form has been submitted sucessfully.';	
	}
	else if($_GET['action'] == "fail"){
		$pageTitle= 'Sorry!';
		$errorMsg= 'Sorry your form could not be submitted. Please again.';	
	}

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('pageTitle', $pageTitle);

$html = $tpl->draw('candidateMessageFinal');
?>