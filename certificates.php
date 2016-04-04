<?php

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Certificates';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'The certifications have been saved successfully and are ready for use in job requirement form.';
    } elseif($_GET['action'] == "failed") {
        $errorMsg .= 'The certifications could not be saved successfully';
    }
}

$query = mysqli_query($db, "SELECT certificate_name,category from certificate,category where certificate.category_id = category.id && user_id = '".$_SESSION['login_userId']."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no certificates.</p>';
    $certificates = '';
} else {
    $pageContent .= '<p>There are <strong>'.$result.'</strong> certificates already in our database,</p><p><i>feel free to add more</i></p>';
    while ($fetch = mysqli_fetch_assoc($query)) {
		$certificates[] = array(
            'certificate'=>$fetch['certificate_name'],
            'category'=>$fetch['category'],
        );
    } 
}
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'certificates');
$tpl->assign('certificates', $certificates);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$html = $tpl->draw('certificates');
?>