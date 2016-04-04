<?php

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Skills';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg .= 'Skills have been saved successfully and are ready for use in job requirement form.';
    } elseif($_GET['action'] == "failed") {
        $errorMsg .= 'Skills could not be saved successfully';
    }
}

$query = mysqli_query($db, "SELECT skill, category from skills,category where skills.category_id = category.id && user_id = '".$_SESSION['login_userId']."' ORDER BY skill") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no skills.</p>';
    $skills = '';
} else {
    $pageContent .= '<p>There are <strong>'.$result.'</strong> skills already in our database,</p><p><i>feel free to add more</i></p>';
    while ($fetch = mysqli_fetch_assoc($query)) {
		$skills[] = array(
            'skill'=>$fetch['skill'],
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
$tpl->assign('page', 'skills');
$tpl->assign('skills', $skills);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$html = $tpl->draw('skills');
?>