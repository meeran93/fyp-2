<?php

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Settings';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';

$query = mysqli_query($db, "SELECT * FROM user WHERE id='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'settings');
$tpl->assign('pageTitle', $pageTitle);

$tpl->assign('company', $row['company_name']);
$tpl->assign('company_website', $row['company_website']);
$tpl->assign('contact_number', $row['contact']);
$tpl->assign('facebook_link', $row['company_fb_page']);
$tpl->assign('twitter_link', $row['company_twitter_handle']);
$tpl->assign('linkedin_link', $row['company_linkedin_page']);
$tpl->assign('email_default_subject', $row['email_default_subject']);
$tpl->assign('email_default_message', $row['email_default_message']);

$html = $tpl->draw('settings');
?>