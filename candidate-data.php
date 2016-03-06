<?php

session_start();
include_once("config.php");
isLoggedin($db);

$candidate_id = $_GET['id'];
$form_id = $_GET['form'];

// fetching personal info
$query = mysqli_query($db, "SELECT * FROM candidate WHERE id = '".mysqli_real_escape_string($db, $candidate_id)."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
   
$fetch = mysqli_fetch_assoc($query);

$name = $fetch['name'];
$nationality = $fetch['nationality'];
$address = $fetch['address'];
$contact = $fetch['contact'];
$email = $fetch['email'];
$date_applied = $fetch['date_applied'];
$score = $fetch['score'];
$pageTitle = $name . '(score = ' . $score . ')';
// END - fetching personal info

$query = mysqli_query($db, "SELECT degree_id,degree_name,field_id,field_name FROM candidate c, candidate_education ced, degree d,field_of_study fos WHERE c.id='".mysqli_real_escape_string($db, $candidate_id)."' AND c.id=ced.candidate_id AND d.id=ced.degree_id AND fos.id=ced.field_id GROUP BY degree_id,field_id") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
if($result != null) {
    while ($fetch = mysqli_fetch_assoc($query)) {
        $candidate_education[] = array(
            'degree_id'=>$fetch['degree_id'],
            'degree_name'=>$fetch['degree_name'],
            'field_id'=>$fetch['field_id'],
            'field_name'=>$fetch['field_name']
        );
    }
}
else{
	$candidate_education = '';
} 
	
$query = mysqli_query($db, "SELECT skill,level_of_expertise FROM candidate_skills, skills WHERE candidate_skills.skill_id = skills.id AND candidate_skills.candidate_id='".mysqli_real_escape_string($db, $candidate_id)."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
if($result != null) {
    while ($fetch = mysqli_fetch_assoc($query)) {
        $candidate_skills[] = array(
            'skill_name'=>$fetch['skill'],
            'skill_expertise'=>$fetch['level_of_expertise']
        );
    }
}
else { 
   $candidate_skills = '';
}

$query = mysqli_query($db, "SELECT title, experience_years, company, responsibilities FROM work_titles, candidate_experience WHERE candidate_experience.title_id=work_titles.id AND candidate_experience.candidate_id='".mysqli_real_escape_string($db, $candidate_id)."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
if($result != null) {
    while ($fetch = mysqli_fetch_assoc($query)) {
        $candidate_experience[] = array(
            'candidate_work_title'=>$fetch['title'],
            'candidate_experience_years'=>$fetch['experience_years'],     
            'candidate_company'=>$fetch['company'],
            'candidate_responsibilities'=>$fetch['responsibilities']
        );
    }
}
else {
   $candidate_experience = '';
}   

$query = mysqli_query($db, "SELECT certificate_name, date_awarded FROM candidate_certification cc,certificate cer WHERE cer.id=cc.certificate_id AND cc.candidate_id='".mysqli_real_escape_string($db, $candidate_id)."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
if($result != null) {
    while ($fetch = mysqli_fetch_assoc($query)) {
        $candidate_certifications[] = array(
            'certificate_name'=>$fetch['certificate_name'],
            'date_awarded'=>$fetch['date_awarded']
        );
    }
}
else{
    $candidate_certifications = '';	
} 

include "resources/libraries/raintpl/rain.tpl.class.php";

raintpl::configure("tpl_dir", "resources/templates/" );
raintpl::configure("cache_dir", "tmp/" );

$tpl = new RainTPL;

$tpl->assign('page', 'forms');
$tpl->assign('form_id',$form_id);
$tpl->assign('pageTitle', $pageTitle);

$tpl->assign('name', $name);
$tpl->assign('nationality', $nationality);
$tpl->assign('address', $address);
$tpl->assign('contact', $contact);
$tpl->assign('email', $email);
$tpl->assign('date_applied', $date_applied);
$tpl->assign('score', $score);

$tpl->assign('candidate_education',$candidate_education);
$tpl->assign('candidate_skills',$candidate_skills);
$tpl->assign('candidate_experience',$candidate_experience);
$tpl->assign('candidate_certifications',$candidate_certifications);

$html = $tpl->draw('candidate-data');

?>