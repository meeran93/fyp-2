<?php 

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle = 'Add new <strong>certification</strong> requirement';

if (isset($_POST['submit'])) {
    if (!empty($_POST['new-certificate']) && !empty($_POST['certificate-category']) ) {
        $new_certificates = array("certificate"=>$_POST['new-certificate'], "category"=>$_POST['certificate-category']);
    }
    else {
        $new_certificates = null;
    }
	if (!is_null($new_certificates)) {

        $certificate = $new_certificates['certificate'];
        $category = $new_certificates['category'];

        foreach($certificate as $a => $b) {

            mysqli_query($db, "INSERT INTO certificate (certificate_name, user_id, category_id) VALUES (
                '".mysqli_real_escape_string($db, $certificate[$a])."',
                '".mysqli_real_escape_string($db, $_SESSION['login_userId'])."','".mysqli_real_escape_string($db, $category[$a])."'
                );"
            ) or die(mysqli_error($db));
        }
    
	   header("location: certificates.php?action=saved");
    }
    else {
        header("location: certificates.php?action=failed");
    }
}
  
else {
	$query = mysqli_query($db, "SELECT * FROM category") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $certificate_categories[] = array(
            'category_id'=>$fetch['id'],
            'category_name'=>$fetch['category']
        );
    }
	$certificate_categories = json_encode($certificate_categories);

    
    include "resources/libraries/raintpl/rain.tpl.class.php";

    raintpl::configure("tpl_dir", "resources/templates/" );
    raintpl::configure("cache_dir", "tmp/" );

    $tpl = new RainTPL;

    $tpl->assign('page', 'certificates');
    $tpl->assign('pageTitle', $pageTitle);
    $tpl->assign('certificate_categories', $certificate_categories);
    $html = $tpl->draw('add-certificate');
}

?>