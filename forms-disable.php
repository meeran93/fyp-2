<?php

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle    = ' Disable Forms';
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

$query = mysqli_query($db, "SELECT * FROM forms WHERE status='DISABLED' && user_id='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."' AND deleted=0 ORDER BY date_created DESC") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0) {
    $pageContent .= '<p>There are currently no Disabled forms.</p>';
    $forms_disable = '';
} else {
    $pageContent .= '<p>There are <strong>'.$result.'</strong> forms.</p>';
    while ($fetch = mysqli_fetch_assoc($query)) {
        $forms_disable[] = array(
            'form_disable_ID'=>$fetch['id'],
            'form_disable_date'=>$fetch['date_created'],
            'form_disable_description'=>$fetch['description'],
            'form_disable_responses'=>$fetch['responses'],
            'form_disable_status'=>$fetch['status']
        );
    } 
}
    
include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'forms-disable');
$tpl->assign('forms_disable', $forms_disable);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);

$html = $tpl->draw('forms-disable');
?>