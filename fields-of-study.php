<?php
session_start();
include_once ("config.php");

isLoggedin($db);
$pageTitle = 'Fields of Study';
$pageContent = '';
$errorMsg = '';
$successMsg = '';

if (isset($_GET['action'])) {
    if ($_GET['action'] == "saved") {
        $successMsg.= 'New Field of Study have been saved successfully and is ready for use in job requirement form. Please feel free to add more';
    }
    elseif ($_GET['action'] == "failed") {
        $errorMsg.= 'New Field of Study could not be saved successfully';
    }
}

$query = mysqli_query($db, "SELECT field_name, category from field_of_study, category where field_of_study.category_id = category.id && user_id = '".$_SESSION['login_userId']."' ORDER BY field_name") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0)
	{
	$pageContent.= '<p>There are currently no field of studies to display.</p>';
	$fields_of_study = '';
	}
  else
	{
	$pageContent.= '<p>There are <strong>' . $result . '</strong> fields of study already in our database,</p><p><i>feel free to add more</i></p>';
	while ($fetch = mysqli_fetch_assoc($query))
		{
		$fields_of_study[] = array(
			'field_name' => $fetch['field_name'],
			'field_category' => $fetch['category']
		);
		}
	}

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/");
raintpl::configure("cache_dir", "tmp/");
$tpl = new RainTPL;
$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'fields-of-study');
$tpl->assign('fields_of_study', $fields_of_study);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);
$html = $tpl->draw('fields-of-study');
?>