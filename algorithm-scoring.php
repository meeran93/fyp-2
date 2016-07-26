<?php

function score_education($degree, $field, $req_education, $db){
	
    $score_education = 0;

	$count_1 = 0;	// For checking if basic requirements matched
	$score_extra = 0;	// Score for all half matching fields
	$scored = false;	//For checking of field is Extra or not
	
	foreach($degree as $key => $value) {
        // $degree[$a]
        // $field[$a]
        $count_2 = 0;	// For calculating average score
		$score_1 = 0;	// Score for full matching field
        $score_2 = 0;	// Score for half matching field

        $degree_id = $degree[$key];
        $field_id = $field[$key];
        // get order of candidate degree
        $query = mysqli_query($db, "SELECT * FROM degree WHERE id='".mysqli_real_escape_string($db, $degree_id)."'") or die(mysqli_error($db));
        $result = mysqli_num_rows($query);
        while ($fetch = mysqli_fetch_assoc($query)) {
            $order_cand = $fetch['order'];
        }
        
        foreach ($req_education as $a => $b) {
            // get order of required degree
            $query = mysqli_query($db, "SELECT * FROM degree WHERE id='".mysqli_real_escape_string($db, $b['degree_id'])."'") or die(mysqli_error($db));
            $result = mysqli_num_rows($query);
            while ($fetch = mysqli_fetch_assoc($query)) {
                $order_req = $fetch['order'];
            }

        	if($order_cand >= $order_req && $field_id == $b['field_id']){
        		if($degree_id == $b['degree_id']){
        			$score_1 = $b['priority'];	// found perfect match
        			$count_1++;
    				$scored = true;
        			break;
        		}
        		else{
        			$score_2 += $b['priority'] / 2;	// found partial match
        			$count_2++;
    				$scored = true;
        		}
        	}
        }
        if(!$scored){	// mis match
        	// RELEVANCE
        }
        else{
	        if($score_1 == 0 && $score_2 != 0){	// partial match
	        	$score_extra += $score_2 / $count_2;
	        }
	        else{	// full match
	        	$score_education += $score_1;
	        }
        }
    }
    if($count_1 == count($req_education)){
    	$score_education += $score_extra;
    }
	return $score_education;
}

function score_skills($skills, $expertise, $req_skill, $form_id, $db){
	
	$score_skills = 0;
	foreach($skills as $key => $value) {
        $scored = false;
		$skill_id = $skills[$key];
        $level_of_expertise = $expertise[$key];
        foreach ($req_skill as $a => $b) {
        	if($skill_id == $b['skill_id']){
        		$score_skills += $b['priority'] * $level_of_expertise;
    			$scored = true;
        	}
        }
        if(!$scored){   // If NOT Scored in the conventional way...
            // RELEVANCE
            $jd_current = null;
            $jd_past = null;
            $forms_req = null;
            // 1. Get all unique form_ids from form_skills table where skill_id matches current skill_id [which Past JDs]
            $query = mysqli_query($db, "SELECT DISTINCT form_id FROM form_skills WHERE skill_id='".mysqli_real_escape_string($db, $skill_id)."'") or die(mysqli_error($db));
            $result = mysqli_num_rows($query);
            while ($fetch = mysqli_fetch_assoc($query)) {
                if($fetch['form_id'] != $form_id){  //So only Past JDs data gets stored here, not the current one
                    $forms_req[] = array(
                        'form_id' => $fetch['form_id']
                    );
                }
            }
            // 2. Retrieve all required forms [Past JDs]
            foreach($forms_req as $b){
                //...Get Skill
                $skills = null;
                $query = mysqli_query($db, "SELECT skill_id, priority FROM form_skills WHERE form_id='".mysqli_real_escape_string($db, $b['form_id'])."'") or die(mysqli_error($db));
                $result = mysqli_num_rows($query);
                while ($fetch = mysqli_fetch_assoc($query)) {
                    $skills[] = array(
                        'skill_id' => $fetch['skill_id'],
                        'priority' => $fetch['priority']
                    );
                }
                //...Get Certification
                $certification = null;
                $query = mysqli_query($db, "SELECT certificate_id, priority FROM form_certification WHERE form_id='".mysqli_real_escape_string($db, $b['form_id'])."'") or die(mysqli_error($db));
                $result = mysqli_num_rows($query);
                while ($fetch = mysqli_fetch_assoc($query)) {
                    $certification[] = array(
                        'certificate_id' => $fetch['certificate_id'],
                        'priority' => $fetch['priority']
                    );
                }
                $jd_past[] = array(
                    'skills' => $skills,
                    'certification' => $certification
                );
            }
            // 3. Retrieve Current JD
            //...Get Skill
            $skills = null;
            $query = mysqli_query($db, "SELECT skill_id, priority FROM form_skills WHERE form_id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
            $result = mysqli_num_rows($query);
            while ($fetch = mysqli_fetch_assoc($query)) {
                $skills[] = array(
                    'skill_id' => $fetch['skill_id'],
                    'priority' => $fetch['priority']
                );
            }
            //...Get Certification
            $certification = null;
            $query = mysqli_query($db, "SELECT certificate_id, priority FROM form_certification WHERE form_id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
            $result = mysqli_num_rows($query);
            while ($fetch = mysqli_fetch_assoc($query)) {
                $certification[] = array(
                    'certificate_id' => $fetch['certificate_id'],
                    'priority' => $fetch['priority']
                );
            }
            $jd_current[] = array(
                'skills' => $skills,
                'certification' => $certification
            );
            
            //...[ At this point, we have all the data ready to process ]...//

            // 4. Calculate Similarity, Strength of Relationship
            $similarity_max = (count($jd_current, 1) - 2) / 2;  //counts the number of rows in the current JD [is also the max possible similarity] [total number of skills and certificates in Current JD]
            if($similarity_max != 0){   //[in case Current JD is empty] [handling divide by zero exception]
                $priorities = null; //holds priorities of all fields in current JD [to prevent redundant calculation]
                $similarities = null; //holds similarities of current JD with each past JDs
                $sor_all = null;    //holds entire SoR table
                $count = 0; //reference to use later for finding number of past JDs
                if($jd_current != null && $jd_past != null){    //[handling null exception]
                    foreach ($jd_current as $c) {     //runs only once [because only one current JD]
                        //...SKILLS
                        $similarity_s = null;   //holds similarities of fields [skills] of current JD with [skills] past JDs
                        //...[COLUMN]
                        foreach ($jd_past as $p) {    //runs once for each past JD
                            $similarity = 0;    //similarity of [skills] current JD with [skills] past JD [for COLUMN]
                            $sor_col = null;    //holds SoR values for a row [skills]
                            if($c['skills'] != null){    //[handling null exception]
                                //...[ROW]
                                foreach ($c['skills'] as $cs) {    //iterates each skill in the current JDs
                                    $priorities[] = $cs['priority']; //holds priorities of all fields [skills] in current JD
                                    $sor = 0;   //strength of relationship of a skill in current JD, as it is according to the past JD [for each skill, sor will be recalculated]
                                    $col_p = 0; //holds priority of target skill from past JD [will always have a value]
                                    $row_p = 0; //holds priority of field skill from past JD [might not have a value]
                                    if($p['skills'] != null){    //[handling null exception]
                                        //...[IN-COLUMN]
                                        foreach ($p['skills'] as $ps) {    //iterates each skill in the past JD
                                            if($ps['skill_id'] == $skill_id){   //if is target skill in past JD [will only happen once in this loop]
                                                $col_p = $ps['priority'];    //stores priority of target skill from past JD [for later use]
                                            }
                                            if($cs['skill_id'] == $ps['skill_id']){   //if the ids of skills match in both JDs [will only happen once in this loop]
                                                $row_p = $ps['priority'];    //stores priority of field skill from past JD [for later use]
                                                if($cs['priority'] > $ps['priority']){  //smaller value in numerator
                                                    if($cs['priority'] != 0){   //[handling divide by zero error]
                                                        $similarity += $ps['priority'] / $cs['priority']; //for each skill that matches, the similarity will go up
                                                    }
                                                }
                                                else{
                                                    if($ps['priority'] != 0){   //[handling divide by zero error]
                                                        $similarity += $cs['priority'] / $ps['priority']; //for each skill that matches, the similarity will go up
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    //...SoR [for CELL] [into COLUMN]
                                    if($row_p > $col_p){    //smaller value in numerator
                                        if($row_p != 0){    //[handling divide by zero error]
                                            $sor = $col_p / $row_p; //SoR calculated for that Past JD
                                        }
                                    }
                                    else{
                                        if($col_p != 0){    //[handling divide by zero error]
                                            $sor = $row_p / $col_p; //SoR calculated for that Past JD
                                        }
                                    }
                                    $sor_col[] = $sor;   //cascades SoR values of that cell, into an array for that row
                                    //...Similarity [for CELL]
                                    //already updated in [IN-COLUMN] loop
                                }
                            }
                            //...SoR [for COLUMN] [into TABLE]
                            $sor_all[] = $sor_col;   //cascades the SoR array for that row into the SoR table array
                            //...Similarity [for COLUMN] [into ARRAY]
                            $similarity_s[] = $similarity;    //similarity of [skills] current JD with [skills] past JD
                        }
                        //...CERTIFICATION
                        $similarity_c = null;   //holds similarities of [certification] current JD with [certification] past JDs
                        // foreach ($jd_past as $p) {    //runs once for each past JD
                        //     $similarity = 0;    //similarity of [certfication] current JD with [certification] past JD
                        //     $sor_row = null;    //holds SoR values for a row [certification]
                        //     if($c['certification'] != null){    //[handling null exception]
                        //         foreach ($c['certification'] as $cc) {    //iterates each certificate in the current JD
                        //             $priorities[] = array($cc['priority']); //holds priorities of all fields [certificates] in current JD
                        //             $sor = 0;   //strength of relationship of a certificate in current JD, as it is according to the past JD [for each certificate, sor will be recalculated]
                        //             $col_p = 0; //holds priority of target certificate from past JD
                        //             $row_p = 0; //holds priority of field certificate from past JD
                        //             foreach ($p['skills'] as $ps) {    //iterates each skill in the past JD [extra calculation]
                        //                 if($ps['skill_id'] == $skill_id){   //if is target skill in past JD
                        //                     $col_p = $ps['priority'];    //stores priority of target skill from past JD [for later use]
                        //                     break;  //only looking for one target field in past JD
                        //                 }
                        //             }
                        //             foreach ($p['certification'] as $pc) {    //iterates each certificate in the past JD
                        //                 if($cc['certificate_id'] == $pc['certificate_id']){   //if the ids of certificates match in both JDs
                        //                     $row_p = $ps['priority'];    //stores priority of field certificate from past JD [for later use]
                        //                     if($cc['priority'] > $pc['priority']){
                        //                         $similarity += $pc['priority'] / $cc['priority']; //for each certificate that matches, the similarity will go up
                        //                     }
                        //                     else{
                        //                         $similarity += $cc['priority'] / $pc['priority']; //for each certificate that matches, the similarity will go up
                        //                     }
                        //                 }
                        //             }
                        //             if($row_p > $col_p){    //smaller value in numerator
                        //                 if($row_p != 0){    //[handling divide by zero error]
                        //                     $sor = $col_p / $row_p;
                        //                 }
                        //             }
                        //             else{
                        //                 if($col_p != 0){    //[handling divide by zero error]
                        //                     $sor = $row_p / $col_p;
                        //                 }
                        //             }
                        //             $sor_row[] = $sor;   //cascades SoR values of that cell, into an array for that row
                        //         }
                        //     }
                        //     $sor_all[] = $sor_row;   //cascades the SoR array for that row into the SoR table array
                        //     $similarity_c[] = $similarity;    //similarity of [certification] current JD with [certification] past JD
                        // }
                        $count = count($jd_past);   //number of past JDs
                        for ($i=0; $i < $count; $i++) {
                            // $similarities[] = ($similarity_s[$i] + $similarity_c[$i]) / $similarity_max;
                            $similarities[] = ($similarity_s[$i]) / $similarity_max;
                        }
                    }
                }
                // 5. Calculate Relevance
                $relevance = 0;
                if($count != 0){    //if past JDs exist
                    $sor_fields = null;  //SoR values of all fields
                    $isready = 0;   //have all fields been traversed once
                    foreach ($sor_all as $id_c => $sor_col) {   //iterate COLUMN
                        // Calculate all Field's SoR
                        foreach ($sor_col as $id_r => $sor_jd) {    //iterate CELL
                            if($isready != 0){  //if ready, can refer Field by id
                                $sor_fields[$id_r] += $sor_jd * $similarities[$id_c] / $count;
                            }
                            else{
                                $sor_fields[] += $sor_jd * $similarities[$id_c] / $count;
                            }
                        }
                        $isready = 1;   //all Fields traversed once
                    }
                    // Calculate Target's Relevance
                    foreach ($sor_fields as $id_r => $sor_field) {
                        $relevance += $sor_field * $priorities[$id_r] / $similarity_max;
                    }
                }
                // 6. Use Relevance to calculate Score
                $score_skills += $relevance * $level_of_expertise;
            }
        }
	}
	return $score_skills;
}

function score_experience($title, $experience, $req_experience){
	
	$score_experience = 0;

	$scored = false;
	foreach($title as $key => $value) {
		$title_id = $title[$key];
        $experience_years = $experience[$key];
        foreach ($req_experience as $a => $b) {
        	if($title_id == $b['title_id']){
        		$score_experience += $b['priority'] * ($experience_years / $b['years_of_experience']);
    			$scored = true;
        	}
        }
        if(!$scored){
        	// RELEVANCE
        }
	}
	return $score_experience;
}

function score_certification($certification, $req_certification){
	
	$score_certification = 0;

	$scored = false;
	foreach($certification as $key => $value) {
		$certificate_id = $certification[$key];
        foreach ($req_certification as $a => $b) {
        	if($certificate_id == $b['certificate_id']){
        		$score_certification += $b['priority'];
    			$scored = true;
        	}
        }
        if(!$scored){
        	// RELEVANCE
        }
	}
	return $score_certification;
}

function score_normalized($query, $db, $form_id){

    $candidate_temp = null;
    $candidate_scores = null;
    $candidate_scores_temp = null;
    // $score_education_max = 0;
    // $score_skills_max = 0;
    // $score_experience_max = 0;
    // $score_certification_max = 0;
    // $score_max = 0;

    $query1 = mysqli_query($db, "SELECT score_education_max, score_skills_max, score_experience_max, score_certification_max FROM forms WHERE id='".mysqli_real_escape_string($db, $form_id)."'") or die(mysqli_error($db));
    while ($fetch = mysqli_fetch_assoc($query1)) {
        $score_education_max = $fetch['score_education_max'];
        $score_skills_max = $fetch['score_skills_max'];
        $score_experience_max = $fetch['score_experience_max'];
        $score_certification_max = $fetch['score_certification_max'];
    }

    while ($fetch = mysqli_fetch_assoc($query)) {
        // $candidates[] = array(
  //           'candidate_ID'=>$fetch['id'],
  //           'candidate_date_applied'=>$fetch['date_applied'],
        //  'candidate_name'=>$fetch['name'],
  //           'candidate_contact'=>$fetch['contact'],
  //           'candidate_score'=>$fetch['score_overall'],
  //           'candidate_resume'=>'resources/candidate-files/'.$fetch['resume']
  //       );
        if($fetch['score_education'] > $score_education_max){
            $score_education_max = $fetch['score_education'];
            mysqli_query($db, "UPDATE forms SET 
                score_education_max = '".$score_education_max."'
                WHERE id = '".$form_id."';"
            ) or die(mysqli_error($db));
        }
        if($fetch['score_skills'] > $score_skills_max){
            $score_skills_max = $fetch['score_skills'];
            mysqli_query($db, "UPDATE forms SET 
                score_skills_max = '".$score_skills_max."'
                WHERE id = '".$form_id."';"
            ) or die(mysqli_error($db));
        }
        if($fetch['score_experience'] > $score_experience_max){
            $score_experience_max = $fetch['score_experience'];
            mysqli_query($db, "UPDATE forms SET 
                score_experience_max = '".$score_experience_max."'
                WHERE id = '".$form_id."';"
            ) or die(mysqli_error($db));
        }
        if($fetch['score_certification'] > $score_certification_max){
            $score_certification_max = $fetch['score_certification'];
            mysqli_query($db, "UPDATE forms SET 
                score_certification_max = '".$score_certification_max."'
                WHERE id = '".$form_id."';"
            ) or die(mysqli_error($db));
        }
        $candidate_temp[] = array(
            'candidate_ID'=>$fetch['id'],
            'candidate_date_applied'=>$fetch['date_applied'],
            'candidate_name'=>$fetch['name'],
            'candidate_contact'=>$fetch['contact'],
            'candidate_expected_salary'=>number_format($fetch['expected_salary']),
            'candidate_expected_salary_within_range'=>$fetch['expected_salary_within_range'],
            'candidate_resume'=>'resources/candidate-files/'.$fetch['resume'],
            'candidate_status'=>$fetch['status']
        );
        $candidate_scores[] = array(
            'score_education' => $fetch['score_education'],
            'score_skills' => $fetch['score_skills'],
            'score_experience' => $fetch['score_experience'],
            'score_certification' => $fetch['score_certification']
        );
    }
    foreach($candidate_scores as $key => $value) {
        $score_education = 0;
        if($score_education_max != 0){
            $score_education = $value['score_education'] / $score_education_max;
        }
        $score_skills = 0;
        if($score_skills_max != 0){
            $score_skills = $value['score_skills'] / $score_skills_max;
        }
        $score_experience = 0;
        if($score_experience_max != 0){
            $score_experience = $value['score_experience'] / $score_experience_max;
        }
        $score_certification = 0;
        if($score_certification_max != 0){
            $score_certification = $value['score_certification'] / $score_certification_max;
        }
        $score_overall = ($score_education + $score_skills + $score_experience + $score_certification) / 4;
        // if($score_overall > $score_max){
        //     $score_max = $score_overall;
        // }
        $candidate_scores_temp[] = array(
            'score_education' => $score_education * 100,
            'score_skills' => $score_skills * 100,
            'score_experience' => $score_experience * 100,
            'score_certification' => $score_certification * 100,
            'score_overall' => $score_overall
        );
    }
    $candidates = null;
    foreach ($candidate_scores_temp as $key => $value) {
        $candidates[] = array(
            'candidate_ID' => $candidate_temp[$key]['candidate_ID'],
            'candidate_date_applied' => date_format(date_create($candidate_temp[$key]['candidate_date_applied']),"d-M-Y"),
            'candidate_name' => $candidate_temp[$key]['candidate_name'],
            'candidate_contact' => $candidate_temp[$key]['candidate_contact'],
            'candidate_expected_salary' => $candidate_temp[$key]['candidate_expected_salary'],
            'candidate_expected_salary_within_range' => $candidate_temp[$key]['candidate_expected_salary_within_range'],
            'candidate_resume' => $candidate_temp[$key]['candidate_resume'],
            'candidate_status'=> $candidate_temp[$key]['candidate_status'],

            'candidate_score_education' => number_format(($value['score_education']), 2),
            'candidate_score_skills' => number_format(($value['score_skills']), 2),
            'candidate_score_experience' => number_format(($value['score_experience']), 2),
            'candidate_score_certification' => number_format(($value['score_certification']), 2),
            'candidate_score' => number_format(($value['score_overall'] * 100), 2) // $score_max,
        );
    }
    $candidate_temp = null;
    return $candidates;
}

?>