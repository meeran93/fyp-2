<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>
  <div class="container">
    <div class="page-header">
      <a href="forms.php" class="btn btn-success pull-right">Back</a>
      <h2><?php echo $pageTitle;?></h2>
    </div>

    <div class="row rating-example">
      <div class="col-md-12 ">
        <?php echo $pageContent;?>
        <?php if( $candidates != '' ){ ?>
          <table class="footable table table-bordered" id="reviews">
            <thead>
              <tr>
                <th>Date applied</th>
                <th>Name</th>
                <th>Contact Number</th>
				        <th>Score</th>
  				      <th data-hide="phone">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php $counter1=-1; if( isset($candidates) && is_array($candidates) && sizeof($candidates) ) foreach( $candidates as $key1 => $value1 ){ $counter1++; ?>
              <tr>
                <td><a href="#"><?php echo $value1["candidate_date_applied"];?></a></td>
                <td><?php echo $value1["candidate_name"];?></td>
                <td><?php echo $value1["candidate_contact"];?></td>
                <td><?php echo $value1["candidate_score"];?></td>
                <td>
                  <a href="candidate-data.php?id=<?php echo $value1["candidate_ID"];?>&form=<?php echo $form_id;?>" target="_blank" class="btn btn-sm btn-info">View Candidate's Data</a>
                  <a href="<?php echo $value1["candidate_resume"];?>" target="_blank" class="btn btn-sm btn-danger">CV</a>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>