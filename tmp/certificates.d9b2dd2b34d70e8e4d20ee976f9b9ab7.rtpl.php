<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>
  <div class="container">
    <div class="page-header">
      <a href="add-certificate.php" class="btn btn-success pull-right">Add Certificate</a>
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
      <?php if( $certificates != '' ){ ?>
        <table class="footable table table-bordered" id="reviews">
          <thead>
            <tr>
                <th>Certificate</th>
				        <th>Category</th>
            </tr>
          </thead>
          <tbody>
          <?php $counter1=-1; if( isset($certificates) && is_array($certificates) && sizeof($certificates) ) foreach( $certificates as $key1 => $value1 ){ $counter1++; ?>
            <tr>
              <td><?php echo $value1["certificate"];?></td>
				      <td><?php echo $value1["category"];?></td>                
            </tr>
          <?php } ?>
          </tbody>
        </table>
      <?php } ?>
      </div>
    </div>
  </div>
  <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>