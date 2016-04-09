<?php

session_start();
include_once ("config.php");

$user_id = $_SESSION['login_userId'];

if(isset($_POST['category']) && isset($_POST['field_name'])) { 
	$field_name = $_POST['field_name'];
	$category_id = $_POST['category'];
	if(mysqli_query($db, "INSERT INTO field_of_study(field_name, category_id, user_id) VALUES (
	    '" . mysqli_real_escape_string($db, $field_name) ."', 
	    '" . mysqli_real_escape_string($db, $category_id) ."',
	    '" . mysqli_real_escape_string($db, $user_id) . "'
	    );")
	) {
		$field_id = mysqli_insert_id($db); 
		$result = array("field_id"=>$field_id,"field_name"=>$field_name);
		echo json_encode($result);
	}
	else {
		$result = "New Field of Study could not be added please try again";
		var_dump($result);
	}
}

elseif(isset($_POST['category']) && isset($_POST['skill_name'])) { 
	$skill_name = $_POST['skill_name'];
	$category_id = $_POST['category'];
	if(mysqli_query($db, "INSERT INTO skills (skill, category_id, user_id) VALUES(
        '".mysqli_real_escape_string($db, $skill_name)."',
        '".mysqli_real_escape_string($db, $category_id)."',
        '".mysqli_real_escape_string($db, $user_id)."'
        );")
	) {
		$skill_id = mysqli_insert_id($db); 
		$result = array("skill_id"=>$skill_id,"skill_name"=>$skill_name);
		echo json_encode($result);
	}
	else {
		$result = "New Skill could not be added please try again";
	}
}

elseif(isset($_POST['experience_name'])) { 
	$experience_name = $_POST['experience_name'];
	if(mysqli_query($db, "INSERT INTO work_titles (title, user_id) VALUES(
        '" . mysqli_real_escape_string($db, $experience_name) . "',
        '" . mysqli_real_escape_string($db, $user_id) . "'
        );")
	) {
		$experience_id = mysqli_insert_id($db); 
		$result = array("experience_id"=>$experience_id,"experience_name"=>$experience_name);
		echo json_encode($result);
	}
	else {
		$result = "New Experience could not be added please try again";
	}
}

elseif(isset($_POST['category']) && isset($_POST['certification_name'])) { 
	$certification_name = $_POST['certification_name'];
	$category_id = $_POST['category'];
	if(mysqli_query($db, "INSERT INTO certificate (certificate_name, category_id, user_id) VALUES (
        '".mysqli_real_escape_string($db, $certification_name)."',
        '".mysqli_real_escape_string($db, $category_id)."',
        '".mysqli_real_escape_string($db, $user_id)."'
        );")
	) {
		$certification_id = mysqli_insert_id($db); 
		$result = array("certification_id"=>$certification_id,"certification_name"=>$certification_name);
		echo json_encode($result);
	}
	else {
		$result = "New Certification could not be added please try again";
	}
}

?>