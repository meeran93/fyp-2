<?php
session_start();
include_once ("config.php");

isLoggedin($db);
$pageTitle = 'Add new <strong>Experience</strong> requirement';

if (isset($_POST['submit']))
    {
    if (!empty($_POST['new-experience']))
        {
        $new_experience = array(
            "experience" => $_POST['new-experience']
        );
        }
      else
        {
        $new_experience = null;
        }

    if (!is_null($new_experience))
        {
        $experiences = $new_experience['experience'];
        foreach($experiences as $a => $b)
            {
            mysqli_query($db, "Insert into work_titles (title, user_id) Values(
                '" . mysqli_real_escape_string($db, $experiences[$a]) . "',
                '" . mysqli_real_escape_string($db, $_SESSION['login_userId']) . "');") or die(mysqli_error($db));
            }

        header("location: experience.php?action=saved");
        }
      else
        {
        header("location: experience.php?action=failed");
        }
    }

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/");
raintpl::configure("cache_dir", "tmp/");
$tpl = new RainTPL;
$tpl->assign('page', 'experience');
$tpl->assign('pageTitle', $pageTitle);
$html = $tpl->draw('add-experience');
?>