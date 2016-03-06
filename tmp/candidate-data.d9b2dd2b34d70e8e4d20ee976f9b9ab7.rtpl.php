<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>

  <div class="container">
    <div class="page-header">
      <!-- <a href="responses.php?id=<?php echo $form_id;?>" class="btn btn-success pull-right">Back</a> -->
      <h2><?php echo $pageTitle;?></h2>
    </div>

    <div class="row rating-example">
      <div class="col-md-12 ">
        <h3><u>Personal Information</u></h3>

        <label class="col-sm-2 control-label">Full Name:</label><p><?php echo $name;?></p>
        <label class="col-sm-2 control-label">Nationality:</label><p><?php echo $nationality;?></p>
        <label class="col-sm-2 control-label">Address:</label><p><?php echo $address;?></p>
        <label class="col-sm-2 control-label">Contact:</label><p><?php echo $contact;?></p>
        <label class="col-sm-2 control-label">Email:</label><p><?php echo $email;?></p>
        <label class="col-sm-2 control-label">Application date:</label><p><?php echo $date_applied;?></p>
        <!-- <label class="col-sm-2 control-label">Score:</label><p><strong><u><?php echo $score;?></u></strong></p> -->

        <!-- Candidate Education -->
        <h3><u>Education</u></h3>
        <?php if( $candidate_education != '' ){ ?>

        <table class="footable table table-bordered">
          <thead>
            <tr>
              <th>Degree</th>
              <th>Field</th>
            </tr>
          </thead>
          <tbody>
          <?php $counter1=-1; if( isset($candidate_education) && is_array($candidate_education) && sizeof($candidate_education) ) foreach( $candidate_education as $key1 => $value1 ){ $counter1++; ?>

            <tr>
              <td><?php echo $value1["degree_name"];?></td>
              <td><?php echo $value1["field_name"];?></td>
            </tr>
          <?php } ?>

          </tbody>
        </table>
        <?php }else{ ?>

          <p>Applicant hasn't provided his/her education information.</p>
        <?php } ?>

        <!-- END - Candidate Education -->
        
        <!-- Candidate Skills -->
        <h3><u>Skills</u></h3>
        <?php if( $candidate_skills != '' ){ ?>

        <table class="footable table table-bordered">
          <thead>
            <tr>
              <th>Skill</th>
              <th>Expertise</th>
            </tr>
          </thead>
          <tbody>
          <?php $counter1=-1; if( isset($candidate_skills) && is_array($candidate_skills) && sizeof($candidate_skills) ) foreach( $candidate_skills as $key1 => $value1 ){ $counter1++; ?>

            <tr>
              <td><?php echo $value1["skill_name"];?></td>
              <td><?php echo $value1["skill_expertise"];?></td>
            </tr>
          <?php } ?>

          </tbody>
        </table>
        <?php }else{ ?>

          <p>Applicant hasn't provided his/her skill set information.</p>
        <?php } ?>

        <!-- END - Candidate Skills -->

        <!-- Candidate Experience -->
        <h3><u>Work Experience</u></h3>
        <?php if( $candidate_experience != '' ){ ?>

        <p hidden><?php $serial_num_counter=$this->var['serial_num_counter']=1;?></p>
        <table class="footable table table-bordered">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Work Title</th>
              <th>Years of Experience</th>
              <th>Company</th>
              <th>Responsibilities</th>
            </tr>
          </thead>
          <tbody>
          <?php $counter1=-1; if( isset($candidate_experience) && is_array($candidate_experience) && sizeof($candidate_experience) ) foreach( $candidate_experience as $key1 => $value1 ){ $counter1++; ?>

            <tr>
              <td><?php echo $serial_num_counter;?></td>
              <td><?php echo $value1["candidate_work_title"];?></td>
              <td><?php echo $value1["candidate_experience_years"];?></td>
              <td><?php echo $value1["candidate_company"];?></td>
              <td><?php echo $value1["candidate_responsibilities"];?></td>
            </tr>
            <p hidden><?php echo $serial_num_counter+=1;?></p>
          <?php } ?>

          </tbody>
        </table> 
        <?php }else{ ?>

          <p>Applicant hasn't provided any information on his/her work experience.</p>
        <?php } ?>

        <!-- END - Candidate Experience -->

        <!-- Candidate Skills -->
        <h3><u>Certifications</u></h3>
        <?php if( $candidate_certifications != '' ){ ?>

        <table class="footable table table-bordered">
          <thead>
            <tr>
              <th>Certification</th>
              <th>Date Awarded</th>
            </tr>
          </thead>
          <tbody>
          <?php $counter1=-1; if( isset($candidate_certifications) && is_array($candidate_certifications) && sizeof($candidate_certifications) ) foreach( $candidate_certifications as $key1 => $value1 ){ $counter1++; ?>

            <tr>
              <td><?php echo $value1["certificate_name"];?></td>
              <td><?php echo $value1["date_awarded"];?></td>
            </tr>
          <?php } ?>

          </tbody>
        </table>
        <?php }else{ ?>

          <p>Applicant hasn't provided any information on his/her certification.</p>
        <?php } ?>

        <!-- END - Candidate Skills -->

      </div>
    </div>

  </div>
  <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>