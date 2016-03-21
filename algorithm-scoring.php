<?php

session_start();
include_once("config.php");
isLoggedin($db);

$formid = $_GET['formid'];

$candidates = null;

$query = mysqli_query($db, "SELECT id FROM candidate WHERE form_id = '".$formid."'") or die(mysqli_error($db));
$result = mysqli_num_rows($query);
while ($fetch = mysqli_fetch_assoc($query)) {
    $candidates[] = array(
        'candidate_id'=>$fetch['id']
    );
}

if (!is_null($candidates)) {

	$query = mysqli_query($db, "SELECT degree_id, field_of_study_id, priority FROM form_education WHERE form_id = '".$formid."'") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $form_education[] = array(
            'degree_id'=>$fetch['degree_id'],
            'field_id'=>$fetch['field_of_study_id'],
            'priority'=>$fetch['priority']
        );
    }
    $query = mysqli_query($db, "SELECT skill_id, priority FROM form_skills WHERE form_id = '".$formid."'") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $form_skill[] = array(
            'skill_id'=>$fetch['skill_id'],
            'priority'=>$fetch['priority']
        );
    }
    $query = mysqli_query($db, "SELECT title_id, years_of_experience, priority FROM form_experience WHERE form_id = '".$formid."'") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $form_experience[] = array(
            'title_id'=>$fetch['title_id'],
            'years_of_experience'=>$fetch['years_of_experience'],
            'priority'=>$fetch['priority']
        );
    }
    $query = mysqli_query($db, "SELECT certificate_id, priority FROM form_certification WHERE form_id = '".$formid."'") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $form_certification[] = array(
            'certificate_id'=>$fetch['certificate_id'],
            'priority'=>$fetch['priority']
        );
    }

    $candidate_scores = null;
    $candidate_scores_temp = null;
    $score_education_max = 0;
    $score_skill_max = 0;
    $score_experience_max = 0;
    $score_certification_max = 0;
    $score_max = 0;
                
    foreach($candidates as $key => $value) {

        $count_1 = 0;	// For checking if basic requirements matched
		$score_extra = 0;	// Score for all half matching fields
    	
    	$score_education = 0;
        $query = mysqli_query($db, "SELECT degree_id, field_id FROM candidate_education WHERE candidate_id = '".$value['candidate_id']."'") or die(mysqli_error($db));
	    $result = mysqli_num_rows($query);
	    while ($fetch = mysqli_fetch_assoc($query)) {
			$count_2 = 0;	// For calculating average score
			$score_1 = 0;	// Score for full matching field
	        $score_2 = 0;	// Score for half matching field

	        $degree_id = $fetch['degree_id'];
	        $field_id = $fetch['field_id'];
	        foreach ($form_education as $a => $b) {
	        	if($field_id == $b['field_id'] && $score_1 == 0){
	        		if($degree_id == $b['degree_id']){
	        			$score_1 = $b['priority'];
	        			$count_1++;
	        			break;
	        		}
	        		else{
	        			$score_2 += $b['priority'] / 2;
	        			$count_2++;
	        		}
	        	}	// Not considering candidates that have achivements in fields other than required...
	        }
	        if($score_1 == 0 && $score_2 != 0){
	        	$score_extra += $score_2 / $count_2;
	        }
	        else{
	        	$score_education += $score_1;
	        }
	    }
	    if($count_1 == count($form_education)){
	    	$score_education += $score_extra;
	    	$count_1 = 0;
	    	$score_extra = 0;
	    }
	    if($score_education > $score_education_max){
	    	$score_education_max = $score_education;
	    }

	    $score_skill = 0;
	    $query = mysqli_query($db, "SELECT skill_id, level_of_expertise FROM candidate_skills WHERE candidate_id = '".$value['candidate_id']."'") or die(mysqli_error($db));
	    $result = mysqli_num_rows($query);
	    while ($fetch = mysqli_fetch_assoc($query)) {
	        $skill_id = $fetch['skill_id'];
	        $level_of_expertise = $fetch['level_of_expertise'];
	        foreach ($form_skill as $a => $b) {
	        	if($skill_id == $b['skill_id']){
	        		$score_skill += $b['priority'] * $level_of_expertise;
	        	}
	        }
	    }
	    if($score_skill > $score_skill_max){
	    	$score_skill_max = $score_skill;
	    }

	    $score_experience = 0;
	    $query = mysqli_query($db, "SELECT title_id, experience_years FROM candidate_experience WHERE candidate_id = '".$value['candidate_id']."'") or die(mysqli_error($db));
	    $result = mysqli_num_rows($query);
	    while ($fetch = mysqli_fetch_assoc($query)) {
	        $candidate_experience[] = array(
	            'title_id'=>$fetch['title_id'],
	            'experience_years'=>$fetch['experience_years']
	        );
	    }
	    if($score_experience > $score_experience_max){
	    	$score_experience_max = $score_experience;
	    }

	    $score_certification = 0;
	    $query = mysqli_query($db, "SELECT certificate_id FROM candidate_certification WHERE candidate_id = '".$value['candidate_id']."'") or die(mysqli_error($db));
	    $result = mysqli_num_rows($query);
	    while ($fetch = mysqli_fetch_assoc($query)) {
	        $certificate_id = $fetch['certificate_id'];
	        foreach ($form_certification as $a => $b) {
	        	if($certificate_id == $b['certificate_id']){
	        		$score_certification += $b['priority'];
	        	}
	        }
	    }
	    if($score_certification > $score_certification_max){
	    	$score_certification_max = $score_certification;
	    }

	    $candidate_scores[] = array(
	    	'candidate_id' => $value['candidate_id'],
	    	'score_education' => $score_education,
	    	'score_skill' => $score_skill,
	    	'score_experience' => $score_experience,
	    	'score_certification' => $score_certification,
	    	'score_overall' => 0
    	);

    }
	foreach($candidate_scores as $key => $value) {
		if($score_education_max != 0){
			$score_education = $value['score_education'] / $score_education_max;
		}
		if($score_skill_max != 0){
			$score_skill = $value['score_skill'] / $score_skill_max;
		}
		if($score_experience_max != 0){
			$score_experience = $value['score_experience'] / $score_experience_max;
		}
		if($score_certification_max != 0){
			$score_certification = $value['score_certification'] / $score_certification_max;
		}
		$score_overall = ($score_education + $score_skill + $score_experience + $score_certification) / 4;
		if($score_overall > $score_max){
	    	$score_max = $score_overall;
	    }
		$candidate_scores_temp[] = array(
	    	'candidate_id' => $value['candidate_id'],
	    	'score_education' => $score_education * 100,
	    	'score_skill' => $score_skill * 100,
	    	'score_experience' => $score_experience * 100,
	    	'score_certification' => $score_certification * 100,
	    	'score_overall' => $score_overall
    	);
	}
	$candidate_scores = null;
	foreach ($candidate_scores_temp as $key => $value) {
		$candidate_scores[] = array(
	    	'candidate_id' => $value['candidate_id'],
	    	'score_education' => $value['score_education'],
	    	'score_skill' => $value['score_skill'],
	    	'score_experience' => $value['score_experience'],
	    	'score_certification' => $value['score_certification'],
	    	'score_overall' => $value['score_overall'] * 100 / $score_max,
    	);
	}
	$candidate_scores_temp = null;
    var_dump($candidate_scores);
}

?>