<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>
  <div class="container">  
    <div class="page-header">
      <a href="create-job-requirement.php" class="btn btn-success pull-right">Create form</a>
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
      <?php if( $forms != '' ){ ?>
        <table class="footable table table-bordered" id="reviews">
          <thead>
            <tr>
                <th width="12%">Date</th>
                <th>Description</th>
                <th>Responses</th>
                <th data-hide="phone">Status</th>
                <th data-hide="phone">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php $counter1=-1; if( isset($forms) && is_array($forms) && sizeof($forms) ) foreach( $forms as $key1 => $value1 ){ $counter1++; ?>
            <tr>
                <td><a href="#"><?php echo $value1["form_date"];?></a></td>
                <td><?php echo $value1["form_description"];?></td>
                <td><?php echo $value1["form_responses"];?></td>
                <td><?php echo $value1["form_status"];?></td>
                <td>
                  <a href="responses.php?id=<?php echo $value1["form_ID"];?>" class="btn btn-sm btn-primary">Responses</a>
                  <a href="candidate-form.php?formid=<?php echo $value1["form_ID"];?>" class="btn btn-sm btn-info" target="_blank">Candidate Form</a>
                  <a href="edit-job-requirement.php?id=<?php echo $value1["form_ID"];?>" class="btn btn-sm btn-warning">Edit</a>
                  <a class="clipboard-btn btn btn-sm btn-default"  id="<?php echo $value1["form_ID"];?>" data-toggle="tooltip" data-placement="right" title="Copy application form link" data-clipboard-action="copy" data-clipboard-text="127.0.0.1/fyp-2/candidate-form.php?formid=<?php echo $value1["form_ID"];?>"><img src="resources/templates/assets/img/clippy.svg" alt="Copy"></a>
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