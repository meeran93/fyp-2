<?php

session_start();
require 'resources/libraries/php_mailer/PHPMailerAutoload.php';
include_once("config.php");
include_once("algorithm-scoring.php");
//isLoggedin($db); ==> Not required here since this is a public page

$query = mysqli_query($db, "SELECT expiry_date, status, preferred_max_salary FROM forms WHERE id='" . mysqli_real_escape_string($db, $_GET['formid']) . "'") or die(mysqli_error($db));
$result = mysqli_fetch_row($query);
$today = date("Y-m-d");
$expiryDate = $result[0];
$status = $result[1];
$preferred_max_salary = $result[2];

if ($today >= $expiryDate || $status !== "ENABLED") {
    if ($status === "ENABLED") {
        $sql_query = "UPDATE forms SET status='EXPIRED' WHERE id='" . mysqli_real_escape_string($db, $_GET['formid']) . "'";
        mysqli_query($db, $sql_query);
        mysqli_close($db);
        header("Location: candidate-message.php?action=expired");
    }
    else if($status === "EXPIRED"){
        header("Location: candidate-message.php?action=expired");
    }
    else {
        header("Location: candidate-message.php?action=unavailable");
    }
}

function construct_email($company_name, $candidate_name, $email_default_message, $company_website, $company_fb_page, $company_twitter_handle, $company_linkedin_page, $company_contact, $email) {
    $html = '<html><head> <meta name="viewport" content="width=device-width"/> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> <title>SmartRecruiter</title> <style type="text/css"> /* ------------------------------------- GLOBAL ------------------------------------- */ *{margin: 0; padding: 0;}*{font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;}img{max-width: 100%;}.collapse{margin: 0; padding: 0;}body{-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100%!important; height: 100%;}/* ------------------------------------- ELEMENTS ------------------------------------- */ a{color: #2BA6CB;}.btn{text-decoration: none; color: #FFF; background-color: #666; padding: 10px 16px; font-weight: bold; margin-right: 10px; text-align: center; cursor: pointer; display: inline-block;}p.callout{padding: 15px; background-color: #ECF8FF; margin-bottom: 15px;}.callout a{font-weight: bold; color: #2BA6CB;}table.social{/* padding:15px; */ background-color: #ebebeb;}.social .soc-btn{padding: 3px 7px; font-size: 12px; margin-bottom: 10px; text-decoration: none; color: #FFF; font-weight: bold; display: block; text-align: center;}a.fb{background-color: #3B5998!important;}a.tw{background-color: #1daced!important;}a.gp{background-color: #DB4A39!important;}a.lkin{background-color: #333!important;}a.ms{background-color: #000!important;}.sidebar .soc-btn{display: block; width: 100%;}/* ------------------------------------- HEADER ------------------------------------- */ table.head-wrap{width: 100%;}.header.container table td.logo{padding: 15px;}.header.container table td.label{padding: 15px; padding-left: 0px;}/* ------------------------------------- BODY ------------------------------------- */ table.body-wrap{width: 100%;}/* ------------------------------------- FOOTER ------------------------------------- */ table.footer-wrap{width: 100%; clear: both!important;}.footer-wrap .container td.content p{border-top: 1px solid rgb(215, 215, 215); padding-top: 15px;}.footer-wrap .container td.content p{font-size: 10px; font-weight: bold;}/* ------------------------------------- TYPOGRAPHY ------------------------------------- */ h1, h2, h3, h4, h5, h6{font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom: 15px; color: #000;}h1 small, h2 small, h3 small, h4 small, h5 small, h6 small{font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none;}h1{font-weight: 200; font-size: 44px;}h2{font-weight: 200; font-size: 37px;}h3{font-weight: 500; font-size: 27px;}h4{font-weight: 500; font-size: 23px;}h5{font-weight: 900; font-size: 17px;}h6{font-weight: 900; font-size: 14px; text-transform: uppercase; color: #444;}.collapse{margin: 0!important;}p, ul{margin-bottom: 10px; font-weight: normal; font-size: 14px; line-height: 1.6;}p.lead{font-size: 17px;}p.last{margin-bottom: 0px;}ul li{margin-left: 5px; list-style-position: inside;}/* ------------------------------------- SIDEBAR ------------------------------------- */ ul.sidebar{background: #ebebeb; display: block; list-style-type: none;}ul.sidebar li{display: block; margin: 0;}ul.sidebar li a{text-decoration: none; color: #666; padding: 10px 16px; /* font-weight:bold; */ margin-right: 10px; /* text-align:center; */ cursor: pointer; border-bottom: 1px solid #777777; border-top: 1px solid #FFFFFF; display: block; margin: 0;}ul.sidebar li a.last{border-bottom-width: 0px;}ul.sidebar li a h1, ul.sidebar li a h2, ul.sidebar li a h3, ul.sidebar li a h4, ul.sidebar li a h5, ul.sidebar li a h6, ul.sidebar li a p{margin-bottom: 0!important;}.container{display: block!important; max-width: 600px!important; margin: 0 auto!important; /* makes it centered */ clear: both!important;}/* This should also be a block element, so that it will fill 100% of the .container */ .content{padding: 15px; max-width: 600px; margin: 0 auto; display: block;}/* Let us make sure tables in the content area are 100% wide */ .content table{width: 100%;}/* Odds and ends */ .column{width: 300px; float: left;}.column tr td{padding: 15px;}.column-wrap{padding: 0!important; margin: 0 auto; max-width: 600px!important;}.column table{width: 100%;}.social .column{width: 280px; min-width: 279px; float: left;}/* Be sure to place a .clear element after each set of columns, just to be safe */ .clear{display: block; clear: both;}/* ------------------------------------------- PHONEFor clients that support media queries.Nothing fancy. -------------------------------------------- */ @media only screen and (max-width: 600px){a[class="btn"]{display: block!important; margin-bottom: 10px!important; background-image: none!important; margin-right: 0!important;}div[class="column"]{width: auto!important; float: none!important;}table.social div[class="column"]{width: auto!important;}}</style></head><body bgcolor="#FFFFFF"> <table class="head-wrap" bgcolor="#999999"> <tr> <td></td><td class="header container"> <div class="content"> <table bgcolor="#999999"> <tr> <td><img src="resources/company-logos/digiweb.png"/></td><td align="right"> <h6 class="collapse">'.$company_name.'</h6></td></tr></table> </div></td><td></td></tr></table> <table class="body-wrap"> <tr> <td></td><td class="container" bgcolor="#FFFFFF"> <div class="content"> <table> <tr> <td> <h3>Hi, ' . $candidate_name . '</h3> <p class="lead">'.$email_default_message.'</p><p class="callout">For more information, visit our website. <a href="'. $company_website .'">Visit website! &raquo;</a></p><table class="social" width="100%"><tr><td><table align="left" class="column"> <tr> <td> <h5 class="">Contact Info:</h5> <p>Phone: <strong>'. $company_contact .'</strong> <br/> Email: <strong><a href="emailto:'. $email .'">'. $email .'</a></strong></p></td></tr></table>';
    if($fb !== null || $tw !== null || $lkin !== null) {
        $html .= '<table align="left" class="column"> <tr> <td> <h5 class="">Connect with Us:</h5><p>';
        if($company_fb_page !== null) {
            $html .= '<a href="'. $company_fb_page .'" class="soc-btn fb">Facebook</a>';
        }
        if($company_twitter_handle !== null) {
            $html .= '<a href="'. $company_twitter_handle .'" class="soc-btn tw">Twitter</a>';
        }
        if($company_linkedin_page !== null) {
            $html .= '<a href="'. $company_linkedin_page .'" class="soc-btn lkin">LinkedIn</a>';
        }
        $html .= '</p></td></tr></table>';
    }
    $html .= '<span class="clear"></span> </td></tr></table> </td></tr></table> </div></td><td></td></tr></table></body></html>';
}

if (isset($_POST['submit'])) {

    // save all data input as variable for later use
    $form_name =  $_POST['requirement_name'];
    $form_nationality =  $_POST['requirement_nationality'];
    $form_address =  $_POST['requirement_address'];
    $form_contact =  $_POST['requirement_contact'];
    $form_email =  $_POST['requirement_email'];
    $form_expected_salary =  $_POST['requirement_expected_salary'];
    if($form_expected_salary <= $preferred_max_salary) {
        $form_expected_salary_within_range = 'YES';
    }
    else {
        $form_expected_salary_within_range = 'NO';
    }
    
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
    if (!empty($_POST['requirement_school']) && !empty($_POST['requirement_degree']) && !empty($_POST['requirement_field']) && !empty($_POST['requirement_school_start'])  && !empty($_POST['requirement_school_end'])) {
        $form_education = array("school"=>$_POST['requirement_school'], "degree"=>$_POST['requirement_degree'], "field"=>$_POST['requirement_field'], "start_date"=>$_POST['requirement_school_start'], "end_date"=>$_POST['requirement_school_end']);
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
    if (!empty($_POST['requirement_experience']) && !empty($_POST['requirement_experience_years'])) {
        $form_experience_required = array("experience"=>$_POST['requirement_experience'], "experience_years"=>$_POST['requirement_experience_years']);
    }
    else {
        $form_experience_required = NULL;
    }
    if (!empty($_POST['requirement_experience_company']) && !empty($_POST['requirement_experience_title']) && !empty($_POST['requirement_experience_start_date']) && !empty($_POST['requirement_experience_end_date']) && !empty($_POST['requirement_experience_description'])) {
        $form_experience = array("company"=>$_POST['requirement_experience_company'], "title"=>$_POST['requirement_experience_title'], "start_date"=>$_POST['requirement_experience_start_date'], "end_date"=>$_POST['requirement_experience_end_date'], "description"=>$_POST['requirement_experience_description']);
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
        expected_salary,
        expected_salary_within_range,
        date_applied
        ) VALUES (
        '".mysqli_real_escape_string($db, $_GET['formid'])."',
        '".mysqli_real_escape_string($db, $form_resume)."',
        '".mysqli_real_escape_string($db, $form_name)."',
        '".mysqli_real_escape_string($db, $form_nationality)."',
        '".mysqli_real_escape_string($db, $form_address)."',
        '".mysqli_real_escape_string($db, $form_contact)."',
        '".mysqli_real_escape_string($db, $form_email)."',
        '".mysqli_real_escape_string($db, $form_expected_salary)."',
        '".mysqli_real_escape_string($db, $form_expected_salary_within_range)."',
        '".mysqli_real_escape_string($db, date("Y-m-d"))."'
        )")) {

            $candidateID = mysqli_insert_id($db);

            $req_education = null;
            $req_skill = null;
            $req_experience = null;
            $req_certification = null;

            $score_education = 0;
            $score_skills = 0;
            $score_experience = 0;
            $score_certification = 0;
            $score_overall = 0;

            // load form data
            $query = mysqli_query($db, "SELECT degree_id, field_of_study_id, priority FROM form_education WHERE form_id = '".$_GET['formid']."'") or die(mysqli_error($db));
            $result = mysqli_num_rows($query);
            while ($fetch = mysqli_fetch_assoc($query)) {
                $req_education[] = array(
                    'degree_id'=>$fetch['degree_id'],
                    'field_id'=>$fetch['field_of_study_id'],
                    'priority'=>$fetch['priority']
                );
            }
            $query = mysqli_query($db, "SELECT skill_id, priority FROM form_skills WHERE form_id = '".$_GET['formid']."'") or die(mysqli_error($db));
            $result = mysqli_num_rows($query);
            while ($fetch = mysqli_fetch_assoc($query)) {
                $req_skill[] = array(
                    'skill_id'=>$fetch['skill_id'],
                    'priority'=>$fetch['priority']
                );
            }
            $query = mysqli_query($db, "SELECT title_id, years_of_experience, priority FROM form_experience WHERE form_id = '".$_GET['formid']."'") or die(mysqli_error($db));
            $result = mysqli_num_rows($query);
            while ($fetch = mysqli_fetch_assoc($query)) {
                $req_experience[] = array(
                    'title_id'=>$fetch['title_id'],
                    'years_of_experience'=>$fetch['years_of_experience'],
                    'priority'=>$fetch['priority']
                );
            }
            $query = mysqli_query($db, "SELECT certificate_id, priority FROM form_certification WHERE form_id = '".$_GET['formid']."'") or die(mysqli_error($db));
            $result = mysqli_num_rows($query);
            while ($fetch = mysqli_fetch_assoc($query)) {
                $req_certification[] = array(
                    'certificate_id'=>$fetch['certificate_id'],
                    'priority'=>$fetch['priority']
                );
            }
            
            if (!is_null($form_education)) {

                $school = $form_education['school'];
                $degree = $form_education['degree'];
                $field = $form_education['field'];
                $start_date = $form_education['start_date'];
                $end_date = $form_education['end_date'];

                foreach($school as $a => $b) {

                    mysqli_query($db, "INSERT INTO candidate_education (
                        candidate_id,
                        school,
                        degree_id,
                        field_id,
                        start_date,
                        end_date
                        ) VALUES (
                        '".$candidateID."',
                        '".mysqli_real_escape_string($db, $school[$a])."',
                        '".mysqli_real_escape_string($db, $degree[$a])."',
                        '".mysqli_real_escape_string($db, $field[$a])."',
                        '".mysqli_real_escape_string($db, $start_date[$a])."',
                        '".mysqli_real_escape_string($db, $end_date[$a])."'
                        );"
                    ) or die(mysqli_error($db));
                }
                // score education
                $score_education = score_education($degree, $field, $req_education, $db);
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
                // score skills
                $score_skills = score_skills($skills, $level_of_expertise, $req_skill);
            }

            if (!is_null($form_experience_required)) {

                $experience = $form_experience_required['experience'];
                $experience_years = $form_experience_required['experience_years'];

                foreach($experience as $a => $b) {

                    mysqli_query($db, "INSERT INTO candidate_experience_required (
                            candidate_id,
                            title_id,
                            experience_years
                            ) VALUES (
                            '".$candidateID."',
                            '".mysqli_real_escape_string($db, $experience[$a])."',
                            '".mysqli_real_escape_string($db, $experience_years[$a])."'
                            );"
                    ) or die(mysqli_error($db));
                }
                // score experience
                $score_experience = score_experience($experience, $experience_years, $req_experience);
            }

            if (!is_null($form_experience)) {
                
                $company = $form_experience['company'];
                $title = $form_experience['title'];
                $start_date = $form_experience['start_date'];
                $end_date = $form_experience['end_date'];
                $description = $form_experience['description'];

                foreach($company as $a => $b) {

                    mysqli_query($db, "INSERT INTO candidate_experience (
                        candidate_id,
                        company,
                        title_id,
                        start_date,
                        end_date,
                        description
                        ) VALUES (
                        '".$candidateID."',
                        '".mysqli_real_escape_string($db, $company[$a])."',
                        '".mysqli_real_escape_string($db, $title[$a])."',
                        '".mysqli_real_escape_string($db, $start_date[$a])."',
                        '".mysqli_real_escape_string($db, $end_date[$a])."',
                        '".mysqli_real_escape_string($db, $description[$a])."'
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
                // score certification
                $score_certification = score_certification($certification, $req_certification);
            }
            // update score fields in table
            mysqli_query($db, "UPDATE candidate SET 
                score_education = '".$score_education."',
                score_skills = '".$score_skills."',
                score_experience = '".$score_experience."',
                score_certification = '".$score_certification."'
                WHERE id = '".$candidateID."';"
            ) or die(mysqli_error($db));
            
            mysqli_query($db, "CALL updateResponse('".mysqli_real_escape_string($db, $_GET['formid'])."')") or die(mysqli_error($db));
            
            $query = mysqli_query($db, "SELECT email, company_name, company_website, contact, company_fb_page, company_twitter_handle, company_linkedin_page, email_default_subject, email_default_message FROM user WHERE id=(select user_id from forms where id='" . mysqli_real_escape_string($db, $_GET['formid']) . ")'") or die(mysqli_error($db));
            $user_details = mysqli_fetch_array($query, MYSQLI_ASSOC);
            $mail = new PHPMailer;
            $mail->setFrom($user_details['email'], $user_details['email']);
            $mail->addAddress($form_email, $form_name);
            $mail->Subject = $user_details['email_default_subject'];
            $mail->msgHTML(construct_email( $user_details['company_name'], $form_name, $user_details['email_default_message'], $user_details['company_website'], $user_details['company_fb_page'], $user_details['company_twitter_handle'], $user_details['company_linkedin_page'], $user_details['contact'], $user_details['email'] ) );
            $mail->addAttachment('resources/company-profiles/company-profile.pdf');
            if (!$mail->send()) {
                header("location: candidate-message.php?action=fail");
            } else {
                header("location: candidate-message.php?action=success");
            }
            header("location: candidate-message.php?action=success");
        }
        else {
            header("location: candidate-message.php?action=fail");
        }

} else {
    $form_id = $_GET['formid'];

    $query = mysqli_query($db, "SELECT job_title FROM forms WHERE id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
    $result = mysqli_fetch_row($query);
    $job_title = $result[0];

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
    $tpl->assign('job_title',$job_title);

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