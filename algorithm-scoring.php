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

function score_skills($skills, $expertise, $req_skill){
	
	$score_skills = 0;
	$scored = false;
	foreach($skills as $key => $value) {
		$skill_id = $skills[$key];
        $level_of_expertise = $expertise[$key];
        foreach ($req_skill as $a => $b) {
        	if($skill_id == $b['skill_id']){
        		$score_skills += $b['priority'] * $level_of_expertise;
    			$scored = true;
        	}
        }
        if(!$scored){
        	/*// RELEVANCE
        	// 1. Get all unique form_ids from form_skills table where skill_id matches current skill_id [which Past JDs]
            $query = mysqli_query($db, "SELECT DISTINCT form_id FROM form_skills WHERE skill_id='".mysqli_real_escape_string($db, $skill_id)."'") or die(mysqli_error($db));
            $result = mysqli_num_rows($query);
            while ($fetch = mysqli_fetch_assoc($query)) {
                $forms_req[] = array(
                    'form_id' => $fetch['form_id']
                );
            }
        	// 2. Retrieve all required forms [Past JDs]
            foreach($forms_req as $a => $b){
                //...Get Education
                $education = null;
                $query = mysqli_query($db, "SELECT degree_id, field_of_study_id, priority FROM form_education WHERE form_id='".mysqli_real_escape_string($db, $b['form_id'])."'") or die(mysqli_error($db));
                $result = mysqli_num_rows($query);
                while ($fetch = mysqli_fetch_assoc($query)) {
                    $education[] = array(
                        'degree_id' => $fetch['degree_id'],
                        'field_id' => $fetch['field_id'],
                        'priority' => $fetch['priority']
                    );
                }
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
                //...Get Experience
                $experience = null;
                $query = mysqli_query($db, "SELECT title_id, years_of_experience, priority FROM form_experience WHERE form_id='".mysqli_real_escape_string($db, $b['form_id'])."'") or die(mysqli_error($db));
                $result = mysqli_num_rows($query);
                while ($fetch = mysqli_fetch_assoc($query)) {
                    $experience[] = array(
                        'title_id' => $fetch['title_id'],
                        'years_of_experience' => $fetch['years_of_experience'],
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
                }  //(?) Can these four be put in a single array
                if($form_id != $b['form_id']){
                    $jd_past[] = array(
                        'education' => $education,
                        'skills' => $skills,
                        'experience' => $experience,
                        'certification' => $certification
                    );
                }
                else{
                    $jd_current[] = array(
                        'education' => $education,
                        'skills' => $skills,
                        'experience' => $experience,
                        'certification' => $certification
                    );
                }
            }
        	// 3. Create and populate SoR Table
            // 4. Calculate Similarities
        	// 5. Calculate Target Field's SoR
        	// 6. Calculate Target Field's Relevance
            */
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