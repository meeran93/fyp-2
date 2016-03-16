<?php
session_start();
include_once ("config.php");

isLoggedin($db);
$pageTitle = 'Add new <strong>Field of Study</strong> requirement';

if (isset($_POST['submit'])) {
    if (!empty($_POST['field_name']) && !empty($_POST['field_of_study_category'])) {
        $field_name = $_POST['field_name'];
        $category_id = $_POST['field_of_study_category'];
        $user_id = $_SESSION['login_userId'];
        mysqli_query($db, "INSERT INTO field_of_study(field_name, category_id, user_id) VALUES (
            '" . mysqli_real_escape_string($db, $field_name) ."', 
            '" . mysqli_real_escape_string($db, $category_id) ."',
            '" . mysqli_real_escape_string($db, $user_id) . "'
            );"
        ) or die(mysqli_error($db));
        header("location: fields-of-study.php?action=saved");
    }
    else {
        header("location: fields-of-study.php?action=failed");
    }
}

else {    
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
$tpl->assign('page', 'fields-of-study');
$tpl->assign('pageTitle', $pageTitle);
$tpl->assign('categories', $categories);
$html = $tpl->draw('add-field-of-study');
?>
