<?php

session_start();
include_once("config.php");
isLoggedin($db);

$form_id = $_GET['id'];
 
$query = "SELECT status from forms WHERE id='".$form_id."'";
$result = mysqli_query($db,$query);
$fetch = mysqli_fetch_assoc($result);

if(strcmp($fetch['status'],"ENABLED")==0){
	$query2 = "UPDATE FORMS SET STATUS = 'DISABLED' WHERE id='".$form_id."'";
	$result = mysqli_query($db,$query2);
 }

 else { 	
	$query2 = "UPDATE FORMS SET STATUS = 'ENABLED' WHERE id='".$form_id."'";
	$result = mysqli_query($db,$query2);
}

header("location: forms.php");

?>
