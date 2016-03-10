<?php
session_start();
include_once ("config.php");

isLoggedin($db);
$pageTitle = 'Add new <strong>Field of Study</strong> requirement';

if (isset($_POST['submit']))
    {
    if (!empty($_POST['field_name']) && !empty($_POST['field_of_study_category']))
        {
        $new_field_of_study = array(
            "field_name" => $_POST['field_name'],
            "category_id" => $_POST['field_of_study_category']
        );
        }
      else
        {
        $new_field_of_study = null;
        }

    if (!is_null($new_field_of_study))
        {
        $degrees = $new_degrees['degrees'];
        foreach($degrees as $a => $b)
            {
            mysqli_query($db, " INSERT INTO degree(degree_name) VALUES ('" . mysqli_real_escape_string($db, $degrees[$a]) . "');") or die(mysqli_error($db));
            }

        header("location: degrees.php?action=saved");
        }
      else
        {
        header("location: degrees.php?action=failed");
        }
    }
  else
    {
        $query = mysqli_query($db, "SELECT * FROM category") or die(mysqli_error($db));
        $result = mysqli_num_rows($query);
        while ($fetch = mysqli_fetch_assoc($query)) {
            $categories[] = array(
                'category_id'=>$fetch['id'],
                'category_name'=>$fetch['category']
            );
        }
    }

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/");
raintpl::configure("cache_dir", "tmp/");
$tpl = new RainTPL;
$tpl->assign('page', 'degrees');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('categories', $categories);
$html = $tpl->draw('add-field-of-study');
?>
