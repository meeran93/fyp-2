
<?php
session_start();
include_once ("config.php");

isLoggedin($db);
$pageTitle = 'Experiences';
$pageContent = '';
$errorMsg = '';
$successMsg = '';

if (isset($_GET['action']))
    {
    if ($_GET['action'] == "saved")
        {
        $successMsg.= 'Experiences have been saved successfully and are ready for use in job requirement form.';
        }
    elseif ($_GET['action'] == "failed")
        {
        $errorMsg.= 'Experiences could not be saved successfully';
        }
    }

$query = mysqli_query($db, "SELECT title FROM work_titles where user_id = '".$_SESSION['login_userId']."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);

if ($result == 0)
    {
    $pageContent.= '<p>You have not created custom experience requirements.</p>';
    $experiences = '';
    }
  else
    {
    $pageContent.= '<p>There are <strong>' . $result . '</strong> skills already in our database,</p><p><i>feel free to add more</i></p>';
    while ($fetch = mysqli_fetch_assoc($query))
        {
        $experiences[] = array(
            'title' => $fetch['title']
        );
        }
    }

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/");
raintpl::configure("cache_dir", "tmp/");
$tpl = new RainTPL;
$tpl->assign('errorMsg', $errorMsg);
$tpl->assign('successMsg', $successMsg);
$tpl->assign('page', 'experiences');
$tpl->assign('experiences', $experiences);
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('pageContent', $pageContent);
$html = $tpl->draw('experience');
?>