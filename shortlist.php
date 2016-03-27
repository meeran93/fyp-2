<?php

session_start();
include_once("config.php");
isLoggedin($db);

$candidate_id = $_GET['id'];
$form_id = $_GET['form_id'];
$form_status = $_GET['status_data'];

$status = "UPDATE CANDIDATE SET status='".$form_status."' WHERE id = '".$candidate_id."'";
$result = mysqli_query($db,$status);


 
header("location: responses.php?id={$form_id}");


echo $candidate_id ;
?>