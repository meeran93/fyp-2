<?php

session_start();
include_once("config.php");
include("shorten-url.php");
isLoggedin($db);

$pageTitle    = 'Forms';
$pageContent  = '';
$errorMsg     = '';
$successMsg   = '';

// if (isset($_GET['action'])) {
//     if ($_GET['action'] == "saved") {
//         $successMsg .= 'The form has been saved successfully.';
//     } elseif($_GET['action'] == "delete") {
//         if (isset($_GET['id'])) {
//             if (mysqli_query($db, "UPDATE invoiceshelf_invoices SET deleted=1 WHERE invoiceID='".mysqli_real_escape_string($db, $_GET['id'])."'")) {
//                 $successMsg .= 'The invoice has been deleted successfully.';
//             } else {
//                 $errorMsg .= 'The invoice could not be deleted.';
//             }
//         } else {
//             $errorMsg .= 'No invoice ID has been received. Without a invoice ID the invoice can\'t be deleted.';
//         }
//     } elseif($_GET['action'] == "send") {
//         $successMsg .= 'The invoice <b>'.$_GET['invoicenr'].'</b> has been send to <b>'.$_GET['email'].'</b>.';
//     }
// }

// $query = mysqli_query($db, "UPDATE forms SET status='EXPIRED' WHERE status='ENABLED' AND expiry_date<=CURDATE() AND user_id='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));
// $query = mysqli_query($db, "UPDATE forms SET status='ENABLED' WHERE status='EXPIRED' AND expiry_date>CURDATE() AND user_id='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysqli_error($db));

mysqli_query($db, "CALL updateFormStatus('".mysqli_real_escape_string($db, $_SESSION['login_userId'])."');");

$query = mysqli_query($db, "SELECT * FROM forms WHERE user_id='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."' AND deleted=0 ORDER BY date_created DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no forms.</p>';
    $forms = '';
} else {
    $pageContent .= '<p>There are <strong>'.$result.'</strong> forms.</p>';
    while ($fetch = mysqli_fetch_assoc($query)) {
        $forms[] = array(
            'form_ID'=>$fetch['id'],
            'form_date'=>date_format(date_create($fetch['date_created']),"d-M-Y"),
            'form_job_title'=>$fetch['job_title'],
            'form_responses'=>$fetch['responses'],
            'form_expiry_date'=>date_format(date_create($fetch['expiry_date']),"d-M-Y"),
            // 'form_public_link'=>shortenUrl('http://www.smartrecruiter.invoiceshelf.com/candidate-form.php?formid='.$fetch['id'].''),
            'form_public_link'=>'127.0.0.1/fyp-2/candidate-form.php?formid='.$fetch['id'],
            'form_status'=>$fetch['status']
        );
    } 
}
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'forms');
$tpl->assign('forms', $forms);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$html = $tpl->draw('forms');
?>