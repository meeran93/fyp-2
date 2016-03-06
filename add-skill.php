<?php 

session_start();
include_once("config.php");
isLoggedin($db);

$pageTitle = 'Add new <strong>skill</strong> requirement';

if (isset($_POST['submit'])) {
	if (!empty($_POST['new-skill']) && !empty($_POST['skill-category']) ) { 
        $new_skills = array("skills"=>$_POST['new-skill'], "category"=>$_POST['skill-category']);
    }
    else {
        $new_skills = null;
    }
	
	if (!is_null($new_skills)) {
                
        $skills = $new_skills['skills'];
        $category = $new_skills['category'];
		
        foreach($skills as $a => $b) {
        
            mysqli_query($db, "Insert into skills (skill, user_id, category_id) Values(
                '".mysqli_real_escape_string($db, $skills[$a])."',
                '".mysqli_real_escape_string($db, $_SESSION['login_userId'])."','".mysqli_real_escape_string($db, $category[$a])."'
                );"
            ) or die(mysqli_error($db));
        }

	   header("location: skills.php?action=saved");
       
    }
    else {
        header("location: skills.php?action=failed");
    }
}
else {
    
	$query = mysqli_query($db, "SELECT * FROM category") or die(mysqli_error($db));
    $result = mysqli_num_rows($query);
    while ($fetch = mysqli_fetch_assoc($query)) {
        $skills_category[] = array(
            'category_id'=>$fetch['id'],
            'category_name'=>$fetch['category']
        );
    }
	$skills_category = json_encode($skills_category);
    include "resources/libraries/raintpl/rain.tpl.class.php";

    raintpl::configure("tpl_dir", "resources/templates/" );
    raintpl::configure("cache_dir", "tmp/" );

    $tpl = new RainTPL;

    $tpl->assign('page', 'skills');
    $tpl->assign('pageTitle', $pageTitle);
    $tpl->assign('skills_category',$skills_category);
    $html = $tpl->draw('add-skill');
}

?>