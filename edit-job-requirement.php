<?php 

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle = 'Edit Job Requirement';

if (isset($_POST['submit'])) {

    $formID = $_POST['form_ID'];

    // save all data input as variable for later use
    $form_description =  $_POST['description'];
    $form_preferred_max_salary =  $_POST['requirement_salary'];
    $form_expiry_date =  $_POST['requirement_expiry_date'];
    
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
	
    if(mysqli_query($db, "CALL deleteFormRequirements('".$formID."');")) {
            
        $query = mysqli_query($db, "UPDATE forms SET description='".$form_description."', preferred_max_salary='".$form_preferred_max_salary."', expiry_date='".$form_expiry_date."' WHERE id='".mysqli_real_escape_string($db, $formID)."'") or die(mysqli_error($db));

        if (!is_null($form_education)) {
            
            $degree = $form_education['degree'];
            $field = $form_education['field'];
            $priority = $form_education['priority'];
            $score_education_max = 0;

            foreach($degree as $a => $b) {

                mysqli_query($db, "CALL insertEducation(
                    '".$formID."',
                    '".mysqli_real_escape_string($db, $degree[$a])."',
                    '".mysqli_real_escape_string($db, $field[$a])."',
                    '".mysqli_real_escape_string($db, $priority[$a])."'
                    );"
                ) or die(mysqli_error($db));
                $score_education_max += $priority[$a];
            }
            //...//
            mysqli_query($db, "UPDATE forms SET 
                score_education_max = '".$score_education_max."'
                WHERE id = '".$formID."';"
            ) or die(mysqli_error($db));
        }

        if (!is_null($form_skills)) {
            
            $skills = $form_skills['skills'];
            $priority = $form_skills['priority'];
            $score_skills_max = 0;

            foreach($skills as $a => $b) {

                mysqli_query($db, "CALL insertSkills(
                    '".$formID."',
                    '".mysqli_real_escape_string($db, $skills[$a])."',
                    '".mysqli_real_escape_string($db, $priority[$a])."'
                    );"
                ) or die(mysqli_error($db));
                $score_skills_max += 10 * $priority[$a];
            }
            //...//
            mysqli_query($db, "UPDATE forms SET 
                score_skills_max = '".$score_skills_max."'
                WHERE id = '".$formID."';"
            ) or die(mysqli_error($db));
        }

        if (!is_null($form_experience)) {
            
            $experience = $form_experience['experience'];
            $experience_years = $form_experience['experience_years'];
            $priority = $form_experience['priority'];
            $score_experience_max = 0;

            foreach($experience as $a => $b) {

                mysqli_query($db, "CALL insertExperience(
                    '".$formID."',
                    '".mysqli_real_escape_string($db, $experience[$a])."',
                    '".mysqli_real_escape_string($db, $experience_years[$a])."',
                    '".mysqli_real_escape_string($db, $priority[$a])."'
                    );"
                ) or die(mysqli_error($db));
                $score_experience_max += $priority[$a];
            }
            //...//
            mysqli_query($db, "UPDATE forms SET 
                score_experience_max = '".$score_experience_max."'
                WHERE id = '".$formID."';"
            ) or die(mysqli_error($db));
        }

        if (!is_null($form_certification)) {
            
            $certification = $form_certification['certification'];
            $priority = $form_certification['priority'];
            $score_certification_max = 0;

            foreach($certification as $a => $b) {

                mysqli_query($db, "CALL insertCertification(
                    '".$formID."',
                    '".mysqli_real_escape_string($db, $certification[$a])."',
                    '".mysqli_real_escape_string($db, $priority[$a])."'
                    );"
                ) or die(mysqli_error($db));
                $score_certification_max += $priority[$a];
            }
            //...//
            mysqli_query($db, "UPDATE forms SET 
                score_certification_max = '".$score_certification_max."'
                WHERE id = '".$formID."';"
            ) or die(mysqli_error($db));
        }

        header("location: forms.php");
    }
    else {
        header("location: forms.php?action=failed");
    }
}
else {

    $form_id = $_GET['id'];

    $query = mysqli_query($db, "SELECT description, expiry_date, preferred_max_salary FROM forms WHERE id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
    $result = mysqli_fetch_row($query);
    $description = $result[0];
    $expiry_date = $result[1];
    $preferred_max_salary = $result[2];

    $query = mysqli_query($db, "SELECT * FROM category") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $categories[] = array(
            'category_id'=>$fetch['id'],
            'category_name'=>$fetch['category']
        );
    }
    $categories = json_encode($categories);

    $query = mysqli_query($db, "SELECT degree.id as degree_id, field_of_study.id as field_id, form_education.priority, degree.degree_name, field_of_study.field_name FROM form_education, degree, field_of_study WHERE form_education.degree_id = degree.id AND form_education.field_of_study_id = field_of_study.id AND form_education.form_id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    if($result != null) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            $education_requirements[] = array(
                'degree_id'=>$fetch['degree_id'],
                'degree_name'=>$fetch['degree_name'],
                'field_id'=>$fetch['field_id'],
                'field_name'=>$fetch['field_name'],
                'priority'=>$fetch['priority']
            );
        }
    }
    else $education_requirements = null;

    $query = mysqli_query($db, "SELECT skills.id as skill_id, form_skills.priority, skills.skill FROM form_skills, skills WHERE form_skills.skill_id = skills.id AND form_skills.form_id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    if($result != null) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            $skills_requirements[] = array(
                'skill_id'=>$fetch['skill_id'],
                'skill_name'=>$fetch['skill'],
                'priority'=>$fetch['priority']
            );
        }
    }
    else $skills_requirements = null;

    $query = mysqli_query($db, "SELECT work_titles.id as title_id, form_experience.years_of_experience, form_experience.priority, work_titles.title FROM form_experience, work_titles WHERE form_experience.title_id = work_titles.id AND form_experience.form_id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    if($result != null) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            $experience_requirements[] = array(
                'title_id'=>$fetch['title_id'],
                'title_name'=>$fetch['title'],
                'experience_years'=>$fetch['years_of_experience'],
                'priority'=>$fetch['priority']
            );
        }
    }
    else $experience_requirements = null;

    $query = mysqli_query($db, "SELECT certificate.id as certificate_id, form_certification.priority, certificate.certificate_name FROM form_certification, certificate WHERE form_certification.certificate_id = certificate.id AND form_certification.form_id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    if($result != null) {
        while ($fetch = mysqli_fetch_assoc($query)) {
            $certification_requirements[] = array(
                'certificate_id'=>$fetch['certificate_id'],
                'certificate_name'=>$fetch['certificate_name'],
                'priority'=>$fetch['priority']
            );
        }
    }
    else $certification_requirements = null;

    $query = mysqli_query($db, "SELECT * FROM degree") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $degrees[] = array(
            'degree_id'=>$fetch['id'],
            'degree_name'=>$fetch['degree_name']
        );
    }
    $degrees_json = json_encode($degrees);

    $query = mysqli_query($db, "SELECT * FROM field_of_study") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $fields[] = array(
            'field_id'=>$fetch['id'],
            'field_name'=>$fetch['field_name']
        );
    }
    $fields_json = json_encode($fields);

    $query = mysqli_query($db, "SELECT * FROM skills") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $skills[] = array(
            'skill_id'=>$fetch['id'],
            'skill_name'=>$fetch['skill']
        );
    }
    $skills_json = json_encode($skills);

    $query = mysqli_query($db, "SELECT * FROM work_titles") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $titles[] = array(
            'title_id'=>$fetch['id'],
            'title_name'=>$fetch['title']
        );
    }
    $titles_json = json_encode($titles);

    $query = mysqli_query($db, "SELECT * FROM certificate") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $certificates[] = array(
            'certificate_id'=>$fetch['id'],
            'certificate_name'=>$fetch['certificate_name']
        );
    }
    $certificates_json = json_encode($certificates);

    include "resources/libraries/raintpl/rain.tpl.class.php";

    raintpl::configure("tpl_dir", "resources/templates/" );
    raintpl::configure("cache_dir", "tmp/" );

    $tpl = new RainTPL;

    $tpl->assign('page', 'forms');
    $tpl->assign('pageTitle', $pageTitle);
    $tpl->assign('form_id',$form_id);
    $tpl->assign('description',$description);
    $tpl->assign('expiry_date',$expiry_date);
    $tpl->assign('preferred_max_salary',$preferred_max_salary);

    $tpl->assign('education_requirements',$education_requirements);
    $tpl->assign('skills_requirements',$skills_requirements);
    $tpl->assign('experience_requirements',$experience_requirements);
    $tpl->assign('certification_requirements',$certification_requirements);

    $tpl->assign('categories',$categories);
    
    $tpl->assign('degrees',$degrees);
    $tpl->assign('degrees_json',$degrees_json);
    
    $tpl->assign('fields',$fields);
    $tpl->assign('fields_json',$fields_json);
    
    $tpl->assign('skills',$skills);
    $tpl->assign('skills_json',$skills_json);
    
    $tpl->assign('titles',$titles);
    $tpl->assign('titles_json',$titles_json);
    
    $tpl->assign('certificates',$certificates);
    $tpl->assign('certificates_json',$certificates_json);

    $html = $tpl->draw('edit-job-requirement');
}

?>