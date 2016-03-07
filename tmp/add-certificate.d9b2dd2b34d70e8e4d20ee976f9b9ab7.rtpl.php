<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>

	<div class="container" style="max-width:none">
		<div class="page-header">
	      <a href="forms.php" class="btn btn-warning pull-right">Go Back</a>
	      <h3><?php echo $pageTitle;?></h3>
	    </div>
	</div>

	<div class="container-fluid"><!-- container-fluid -->
		<div class="row"><!-- row -->
			<div class="col-md-10 col-md-offset-1"><!-- Main form area -->
				<div class="panel panel-primary main-panel"><!-- panel-primary -->
					
					<div class="panel-heading"><!-- panel-heading -->
						Fill in certificate details
					</div><!-- panel-heading -->
					
					<!-- Main Form -->
					<form method="POST" action="add-certificate.php">
						<div class="panel-body"><!-- panel-body -->
							
							<!-- Certification Details -->
							<div class="form-group certificate-details"><!-- form-group -->
								<h4 class="col-md-12"><u>Certification</u></h4>
								
								<div id="certificationList" data-certificate-categories='<?php echo $certificate_categories;?>' ><!-- Certification List -->
								</div><!-- END Certification List -->

								<div class="add-certificate-button col-md-8">
									<input type="button" value="Add Certificate" class="form-control" id="addNewCertificate" />
								</div>
								
							</div><!-- END form-group -->
							<!-- END Certification Details -->

						</div><!-- END panel-body -->

						<div class="panel-footer"><!-- panel-footer -->					
							<button type="submit" name="submit" class="btn btn-primary">Submit</button>								
						</div><!-- END panel-footer -->

					</form>
					<!-- END Main Form -->
				</div><!-- END panel-primary -->
			</div><!-- END Main form area -->
		</div><!-- END row -->
	</div><!-- END container-fluid -->
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>