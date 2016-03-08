<?php

session_start();
include_once("config.php");
//isLoggedin($db);

if (isset($_POST['submit'])) {

    // save all data input as variable for later use
    $form_name =  $_POST['requirement_name'];
    $form_nationality =  $_POST['requirement_nationality'];
    $form_address =  $_POST['requirement_address'];
    $form_contact =  $_POST['requirement_contact'];
    $form_email =  $_POST['requirement_email'];
    
    if (!empty($_FILES['candidate_resume'])) {
        
        $target_dir = "resources/candidate-files/";
        $target_file = $target_dir . basename($_FILES["candidate_resume"]["name"]);
        $uploadOk = 0;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if (file_exists($target_file)) {
            // $uploadOk = 1;
        }
        // Check file size
        // if ($_FILES["candidate_resume"]["size"] > 500000) {
        //     $uploadOk = 2;
        // }
        if($fileType != "pdf" && $fileType != "docx" && $fileType != "doc") {
            // $uploadOk = 3;
        }
        if ($uploadOk != 0) {
            $form_resume = NULL; 
        } else {
            if (move_uploaded_file($_FILES["candidate_resume"]["tmp_name"], $target_file)) {
                $form_resume = basename($_FILES["candidate_resume"]["name"]);
            } else {
                // $uploadOk = 4;
                $form_resume = NULL;
            }
        }
    }
    else {
        $form_resume = NULL;
    }
    if (!empty($_POST['requirement_degree']) && !empty($_POST['requirement_field'])) {
        $form_education = array("degree"=>$_POST['requirement_degree'], "field"=>$_POST['requirement_field']);
    }
    else {
        $form_education = NULL;
    }
    if (!empty($_POST['requirement_skill'])) { 
        $form_skills = array("skills"=>$_POST['requirement_skill'], "level_of_expertise"=>$_POST['requirement_skill_expertise']);
    }
    else {
        $form_skills = NULL;
    }    
    if (!empty($_POST['requirement_experience']) && !empty($_POST['requirement_experience_years']) && !empty($_POST['requirement_experience_company']) && !empty($_POST['requirement_experience_responsibilities'])) { 
        $form_experience = array("experience"=>$_POST['requirement_experience'], "experience_years"=>$_POST['requirement_experience_years'], "experience_company"=>$_POST['requirement_experience_company'], "experience_responsibilities"=>$_POST['requirement_experience_responsibilities']);
    }
    else {
        $form_experience = NULL;
    }
    if(!empty($_POST['requirement_certification']) && !empty($_POST['requirement_certification_date'])) {
        $form_certification = array("certification"=>$_POST['requirement_certification'], "certification_date"=>$_POST['requirement_certification_date']);
    }
    else {
        $form_certification = NULL;
    }
    
    if(mysqli_query($db, "INSERT INTO candidate (
        form_id,
        resume,
        name,
        nationality,
        address,
        contact,
        email,
        date_applied
        ) VALUES (
        '".mysqli_real_escape_string($db, $_GET['formid'])."',
        '".mysqli_real_escape_string($db, $form_resume)."',
        '".mysqli_real_escape_string($db, $form_name)."',
        '".mysqli_real_escape_string($db, $form_nationality)."',
        '".mysqli_real_escape_string($db, $form_address)."',
        '".mysqli_real_escape_string($db, $form_contact)."',
        '".mysqli_real_escape_string($db, $form_email)."',
        '".mysqli_real_escape_string($db, date("Y-m-d"))."'
        )")) {

            $candidateID = mysqli_insert_id($db);
            
            if (!is_null($form_education)) {
                
                $degree = $form_education['degree'];
                $field = $form_education['field'];

                foreach($degree as $a => $b) {

                    mysqli_query($db, "INSERT INTO candidate_education (
                        candidate_id,
                        degree_id,
                        field_id
                        ) VALUES (
                        '".$candidateID."',
                        '".mysqli_real_escape_string($db, $degree[$a])."',
                        '".mysqli_real_escape_string($db, $field[$a])."'
                        );"
                    ) or die(mysqli_error($db));
                }
            }

            if (!is_null($form_skills)) {
                
                $skills = $form_skills['skills'];
                $level_of_expertise = $form_skills['level_of_expertise'];

                foreach($skills as $a => $b) {

                    mysqli_query($db, "INSERT INTO candidate_skills (
                        candidate_id,
                        skill_id,
                        level_of_expertise
                        ) VALUES (
                        '".$candidateID."',
                        '".mysqli_real_escape_string($db, $skills[$a])."',
                        '".mysqli_real_escape_string($db, $level_of_expertise[$a])."'
                        );"
                    ) or die(mysqli_error($db));
                }
            }

            if (!is_null($form_experience)) {
                
                $experience = $form_experience['experience'];
                $experience_years = $form_experience['experience_years'];
                $experience_company = $form_experience['experience_company'];
                $experience_responsibilities = $form_experience['experience_responsibilities'];

                foreach($experience as $a => $b) {

                    mysqli_query($db, "INSERT INTO candidate_experience (
                        candidate_id,
                        title_id,
                        experience_years,
                        company,
                        responsibilities
                        ) VALUES (
                        '".$candidateID."',
                        '".mysqli_real_escape_string($db, $experience[$a])."',
                        '".mysqli_real_escape_string($db, $experience_years[$a])."',
                        '".mysqli_real_escape_string($db, $experience_company[$a])."',
                        '".mysqli_real_escape_string($db, $experience_responsibilities[$a])."'
                        );"
                    ) or die(mysqli_error($db));
                }
            }

            if (!is_null($form_certification)) {
                
                $certification = $form_certification['certification'];
                $certification_date = $form_certification['certification_date'];

                foreach($certification as $a => $b) {

                    mysqli_query($db, "INSERT INTO candidate_certification (
                        candidate_id,
                        certificate_id,
                        date_awarded
                        ) VALUES (
                        '".$candidateID."',
                        '".mysqli_real_escape_string($db, $certification[$a])."',
                        '".mysqli_real_escape_string($db, $certification_date[$a])."'
                        );"
                    ) or die(mysqli_error($db));
                }
            }
            mysqli_query($db, "CALL updateResponse('".mysqli_real_escape_string($db, $_GET['formid'])."')") or die(mysqli_error($db));
            header("location: forms.php?action=success");

        }
        else {
            header("location: forms.php?action=failed");
        }

} else {
    $form_id = $_GET['formid'];

    $query = mysqli_query($db, "SELECT description FROM forms WHERE id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
    $result = mysqli_fetch_row($query);
    $description = $result[0];

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


    $query = mysqli_query($db, "SELECT a.skill_id skill_id, b.skill skill_name FROM form_skills a, skills b  WHERE form_id='".$form_id."' AND a.skill_id=b.id") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    if ($result == 0) {
        $form_skills = NULL;
    } else {
    	while ($fetch = mysqli_fetch_assoc($query)) {
            $form_skills[] = array(
            	'skill_id'=>$fetch['skill_id'],
                'skill_name'=>$fetch['skill_name']
            );
        } 
    }

    $query = mysqli_query($db, "SELECT a.title_id title_id, b.title title_name FROM form_experience a, work_titles b WHERE form_id='".$form_id."' AND a.title_id=b.id") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    if ($result == 0) {
        $form_experience = NULL;
    } else {
        while ($fetch = mysqli_fetch_assoc($query)) {
            $form_experience[] = array(
                'title_id'=>$fetch['title_id'],
                'title_name'=>$fetch['title_name']
            );
        } 
    }

    $query = mysqli_query($db, "SELECT a.certificate_id certificate_id, b.certificate_name certificate_name FROM form_certification a, certificate b WHERE form_id='".$form_id."' AND a.certificate_id=b.id") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    if ($result == 0) {
        $form_certification = NULL;
    } else {
        while ($fetch = mysqli_fetch_assoc($query)) {
            $form_certification[] = array(
                'certificate_id'=>$fetch['certificate_id'],
                'certificate_name'=>$fetch['certificate_name']
            );
        } 
    }

    $pageTitle    = 'Application Form';
    $pageContent  = '';
    $errorMsg     = '';
    $successMsg   = '';
        
    include "resources/libraries/raintpl/rain.tpl.class.php";

    raintpl::configure("tpl_dir", "resources/templates/" );	//this be the location
    raintpl::configure("cache_dir", "tmp/" );

    $tpl = new RainTPL;

    $tpl->assign('errorMsg', $errorMsg);
    $tpl->assign('successMsg', $successMsg);
    $tpl->assign('page', 'forms');
    
    $tpl->assign('formid', $form_id);
    $tpl->assign('description',$description);

    $tpl->assign('degrees',$degrees);
    $tpl->assign('fields',$fields);
    $tpl->assign('skills',$skills);
    $tpl->assign('titles',$titles);
    $tpl->assign('certificates',$certificates);

    $tpl->assign('form_skills', $form_skills);
    $tpl->assign('form_experience', $form_experience);
    $tpl->assign('form_certification', $form_certification);

    $tpl->assign('pageTitle', $pageTitle);
    $tpl->assign('pageContent', $pageContent);

    $html = $tpl->draw('candidate-form');	//this be the file name (html)
}
?>