<?php 

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle = 'Enter Job Requirement';

if (isset($_POST['submit'])) {

    // save all data input as variable for later use
    $form_description =  $_POST['description'];
    
    if (!empty($_POST['requirement_degree'])) {
        $form_education = array("degree"=>$_POST['requirement_degree'], "field"=>$_POST['requirement_field'], "priority"=>$_POST['requirement_education_priority']);
    }
    else {
        $form_education = null;    
    }
    if (!empty($_POST['requirement_skill'])) { 
        $form_skills = array("skills"=>$_POST['requirement_skill'], "priority"=>$_POST['requirement_skill_priority']);
    }
    else {
        $form_skills = null;
    }    
    if (!empty($_POST['requirement_experience'])) { 
        $form_experience = array("experience"=>$_POST['requirement_experience'], "experience_years"=>$_POST['requirement_experience_years'], "priority"=>$_POST['requirement_experience_priority']);
    }
    else {
        $form_experience = null;
    }
    if(!empty($_POST['requirement_certification'])) {
        $form_certification = array("certification"=>$_POST['requirement_certification'], "priority"=>$_POST['requirement_certification_priority']);
    }
    else {
        $form_certification = null;
    }
	
    if(mysqli_query($db, "INSERT INTO forms (
        user_id,
        date_created,
        description
        ) VALUES (
        '".mysqli_real_escape_string($db, $_SESSION['login_userId'])."',
        '".mysqli_real_escape_string($db, date("Y-m-d"))."',
        '".mysqli_real_escape_string($db, $_POST['description'])."'
        )")) {

            $formID = mysqli_insert_id($db);
            
            if (!is_null($form_education)) {
                
                $degree = $form_education['degree'];
                $field = $form_education['field'];
                $priority = $form_education['priority'];

                foreach($degree as $a => $b) {

                    mysqli_query($db, "CALL insertEducation(
                        '".$formID."',
                        '".mysqli_real_escape_string($db, $degree[$a])."',
                        '".mysqli_real_escape_string($db, $field[$a])."',
                        '".mysqli_real_escape_string($db, $priority[$a])."'
                        );"
                    ) or die(mysqli_error($db));
                }
            }

            if (!is_null($form_skills)) {
                
                $skills = $form_skills['skills'];
                $priority = $form_skills['priority'];

                foreach($skills as $a => $b) {

                    mysqli_query($db, "CALL insertSkills(
                        '".$formID."',
                        '".mysqli_real_escape_string($db, $skills[$a])."',
                        '".mysqli_real_escape_string($db, $priority[$a])."'
                        );"
                    ) or die(mysqli_error($db));
                }
            }

            if (!is_null($form_experience)) {
                
                $experience = $form_experience['experience'];
                $experience_years = $form_experience['experience_years'];
                $priority = $form_experience['priority'];

                foreach($experience as $a => $b) {

                    mysqli_query($db, "CALL insertExperience(
                        '".$formID."',
                        '".mysqli_real_escape_string($db, $experience[$a])."',
                        '".mysqli_real_escape_string($db, $experience_years[$a])."',
                        '".mysqli_real_escape_string($db, $priority[$a])."'
                        );"
                    ) or die(mysqli_error($db));
                }
            }

            if (!is_null($form_certification)) {
                
                $certification = $form_certification['certification'];
                $priority = $form_certification['priority'];

                foreach($certification as $a => $b) {

                    mysqli_query($db, "CALL insertCertification(
                        '".$formID."',
                        '".mysqli_real_escape_string($db, $certification[$a])."',
                        '".mysqli_real_escape_string($db, $priority[$a])."'
                        );"
                    ) or die(mysqli_error($db));
                }
            }

            header("location: forms.php?action=success");
        }
        else {
            header("location: forms.php?action=failed");
        }
}
else {
    $query = mysqli_query($db, "SELECT * FROM degree") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $degrees[] = array(
            'degree_id'=>$fetch['id'],
            'degree_name'=>$fetch['degree_name']
        );
    }
    $degrees = json_encode($degrees);

    $query = mysqli_query($db, "SELECT * FROM field_of_study") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $fields[] = array(
            'field_id'=>$fetch['id'],
            'field_name'=>$fetch['field_name']
        );
    }
    $fields = json_encode($fields);

    $query = mysqli_query($db, "SELECT * FROM skills") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $skills[] = array(
            'skill_id'=>$fetch['id'],
            'skill_name'=>$fetch['skill']
        );
    }
    $skills = json_encode($skills);

    $query = mysqli_query($db, "SELECT * FROM work_titles") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $titles[] = array(
            'title_id'=>$fetch['id'],
            'title_name'=>$fetch['title']
        );
    }
    $titles = json_encode($titles);

    $query = mysqli_query($db, "SELECT * FROM certificate") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $certificates[] = array(
            'certificate_id'=>$fetch['id'],
            'certificate_name'=>$fetch['certificate_name']
        );
    }
    $certificates = json_encode($certificates);

    include "resources/libraries/raintpl/rain.tpl.class.php";

    raintpl::configure("tpl_dir", "resources/templates/" );
    raintpl::configure("cache_dir", "tmp/" );

    $tpl = new RainTPL;

    $tpl->assign('page', 'forms');
    $tpl->assign('pageTitle', $pageTitle);
    $tpl->assign('degrees',$degrees);
    $tpl->assign('fields',$fields);
    $tpl->assign('skills',$skills);
    $tpl->assign('titles',$titles);
    $tpl->assign('certificates',$certificates);

    $html = $tpl->draw('create-job-requirement');
}

?>