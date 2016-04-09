<?php

session_start();
include_once("config.php");

$form_id = $_POST['form_id'];
$action = $_POST['action'];

if(isset($_POST['expiry_date'])) { 
	mysqli_query($db,"UPDATE forms SET status='".mysqli_real_escape_string($db, $action)."', expiry_date='".mysqli_real_escape_string($db, $_POST['expiry_date'])."' WHERE id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
}
else {
	mysqli_query($db,"UPDATE forms SET status='".mysqli_real_escape_string($db, $action)."' WHERE id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
}

?>
