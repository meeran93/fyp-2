<?php

session_start();
include_once ("config.php");

if($_POST['action'] === "shortlist") {
	mysqli_query($db, "UPDATE candidate SET status='SHORTLISTED' WHERE id='".mysqli_real_escape_string($db, $_POST['candidate_id'])."'") or die(mysqli_error($db));
}
elseif($_POST['action'] === "reject") {
	mysqli_query($db, "UPDATE candidate SET status='REJECTED' WHERE id='".mysqli_real_escape_string($db, $_POST['candidate_id'])."'") or die(mysqli_error($db));
}

?>