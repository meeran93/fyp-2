<?php

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = 'Responses';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';
$form_id = $_GET['id'];

$query = mysqli_query($db, "SELECT * from candidate WHERE form_id='".$form_id."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no responses.</p>';
    $candidates = '';
} else {
    $pageContent .= '<p>There are <strong>'.$result.'</strong> applicants.</p>';
    while ($fetch = mysqli_fetch_assoc($query)) {
		$candidates[] = array(
            'candidate_ID'=>$fetch['id'],
            'candidate_date_applied'=>$fetch['date_applied'],
			'candidate_name'=>$fetch['name'],
            'candidate_contact'=>$fetch['contact'],
            'candidate_score'=>$fetch['score_overall'],
            'candidate_resume'=>'resources/candidate-files/'.$fetch['resume']
        );
    } 
}
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('form_id', $form_id);
$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'forms');
$tpl->assign('candidates', $candidates);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$html = $tpl->draw('responses');
?>