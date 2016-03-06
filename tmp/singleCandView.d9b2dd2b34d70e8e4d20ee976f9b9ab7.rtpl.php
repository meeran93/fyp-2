<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>

  <div class="container">
    <div class="page-header">
      <a href="forms.php" class="btn btn-success pull-right">Back</a>
      <h2><?php echo $pageTitle;?></h2>
    </div>

    <div class="row rating-example">
      <div class="col-md-12 ">
      <?php if( $successMsg != '' ){ ?>

        <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php echo $successMsg;?>

        </div>
      <?php } ?>

      <?php if( $errorMsg != '' ){ ?>

        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php echo $errorMsg;?>

        </div>
      <?php } ?>

    <?php echo $pageContent;?>


        <table class="footable table table-bordered" id="reviews">
              <!--  <thead>
           <tr>
                <th>BASIC INFORMATION</th>
       <th>Name</th>
                <th>Contact Number</th>
				        <th>Score</th>
				        <th data-hide="phone">Actions</th> 
            </tr>
          </thead> -->
            <!--         BASIC INFORMATION                    -->
          <h2>BASIC INFORMATION</h2>
          <tbody>
          <?php $counter1=-1; if( isset($candidateData) && is_array($candidateData) && sizeof($candidateData) ) foreach( $candidateData as $key1 => $value1 ){ $counter1++; ?>

            <tr>
                
               <td><b>Full Name</b></td> <td><a href="#"><?php echo $value1["name"];?></a></td></tr>
             <tr>   <td><b>Nationality</b></td><td><?php echo $value1["nationality"];?></td></tr>
                <tr><td><b>Address</b></td><td><?php echo $value1["address"];?></td></tr>
                <tr><td><b>Contact Information</b></td><td><?php echo $value1["contact"];?></td></tr>
                <tr><td><b>Email ID</b></td>  <td><?php echo $value1["email"];?></td></tr>
                <tr><td><b>Score</b></td><td><?php echo $value1["score"];?></td></tr>
                 <tr><td><b>Date Applied</b></td> <td><?php echo $value1["date_applied"];?></td>
      <!--          <td>
                  
                  <a href="#" class="btn btn-sm btn-info">View Form</a>
                  <a href="<?php echo $value1["form_resume"];?>" target="_blank" class="btn btn-sm btn-danger">CV</a>
            
                </td>
          -->     
             </tr>
          <?php } ?>

          </tbody>
        </table>

        <!--         Education                    -->
<?php $number1=$this->var['number1']=1;?>

 <table class="footable table table-bordered" id="reviews1">
             <h2>EDUCATION</h2>
                <thead>
           <tr>
                <th>S.No</th>
                <th>Degree Name</th>
                <th>Field of Study</th>
            </tr>
          </thead> 
         
          <tbody>
           
          <?php $counter1=-1; if( isset($education_requirements) && is_array($education_requirements) && sizeof($education_requirements) ) foreach( $education_requirements as $key1 => $value1 ){ $counter1++; ?>


            <tr><td><?php echo $number1;?></td> <td><?php echo $value1["degree_name"];?></td><td><?php echo $value1["field_name"];?></td></tr>
           <?php $number1=$this->var['number1']=$number1+1;?>

          <?php } ?>

          </tbody>
        </table>

          <!--         Skills                    -->
<?php $number2=$this->var['number2']=1;?>

 <table class="footable table table-bordered" id="reviews2">
            
          <h2>SKILLS</h2>
               <thead>
           <tr>
                <th>S.No</th>
                <th>Skill Name</th>
                <th>Rating</th>
            </tr>
          </thead> 
         
          <tbody>
           
          <?php $counter1=-1; if( isset($skills_requirements) && is_array($skills_requirements) && sizeof($skills_requirements) ) foreach( $skills_requirements as $key1 => $value1 ){ $counter1++; ?>          
            <tr> <td><?php echo $number2;?></td><td><?php echo $value1["skill_name"];?></td><td><?php echo $value1["priority"];?></td></tr>
           <?php $number2=$this->var['number2']=$number2+1;?>

          <?php } ?>

          </tbody>
        </table>


          <!--         Certification                    -->
<?php $number3=$this->var['number3']=1;?>

 <table class="footable table table-bordered" id="reviews3">
            
          <h2>CERTIFICATION</h2>
              <thead>
           <tr>
                <th>S.No</th>
                <th>Certificate Name</th>
                <th>Date Awarded</th>
            </tr>
          </thead> 
         
          <tbody>
           
          <?php $counter1=-1; if( isset($certification_requirements) && is_array($certification_requirements) && sizeof($certification_requirements) ) foreach( $certification_requirements as $key1 => $value1 ){ $counter1++; ?>          
            <tr> <td><?php echo $number3;?></td><td><?php echo $value1["certificate_name"];?></td><td><?php echo $value1["data_awarded"];?></td></tr>
           
           <?php $number3=$this->var['number3']=$number3+1;?>

          <?php } ?>

          </tbody>
        </table>


  <!--         Work Experience                    -->
<?php $number4=$this->var['number4']=1;?>

 <table class="footable table table-bordered" id="reviews4">
                 <thead>
                 <tr>
                <th>S.No</th>
                <th>Job Title</th>
                <th>Company</th>
                <th>Experience (years)</th>
                <th>Responsiblities</th>
            </tr>
          </thead> 
         
          <h2>WORK EXPERIENCE</h2>
          <tbody>
           
          <?php $counter1=-1; if( isset($experience_requirements) && is_array($experience_requirements) && sizeof($experience_requirements) ) foreach( $experience_requirements as $key1 => $value1 ){ $counter1++; ?>          
            <tr> <td><?php echo $number4;?></td>
               <td><?php echo $value1["title_name"];?></td>
 <td><?php echo $value1["company"];?></td>
             <td><?php echo $value1["experience_years"];?></td>
><td><?php echo $value1["responsibilities"];?></td>
</tr>
           <?php $number4=$this->var['number4']=$number4+1;?>

          <?php } ?>

          </tbody>
        </table>


      </div>
    </div>

  </div>
  <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>