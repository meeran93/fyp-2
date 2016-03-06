<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>

	<div class="container" style="max-width:none">
		<div class="page-header">
	      <a href="skills.php" class="btn btn-warning pull-right">Go Back</a>
	      <h3><?php echo $pageTitle;?></h3>
	    </div>
	</div>

	<div class="container-fluid"><!-- container-fluid -->
		<div class="row"><!-- row -->
			<div class="col-md-10 col-md-offset-1"><!-- Main form area -->
				<div class="panel panel-primary main-panel"><!-- panel-primary -->
					
					<div class="panel-heading"><!-- panel-heading -->
						Fill in skill details
					</div><!-- panel-heading -->
					
					<!-- Main Form -->
					<form method="POST" action="add-skill.php">
						<div class="panel-body"><!-- panel-body -->
							
							<!-- Skills Details -->
							<div class="form-group skills-details"><!-- form-group -->
								<h4 class="col-md-12"><u>Skills</u></h4>
								<div id="add-skills-list" data-skill-categories='<?php echo $skills_category;?>'></div>
								
								<div class="add-skill-button col-md-8">
									<input type="button" value="Add Skill" class="form-control" id="addNewSkill" />
								</div>
								
							</div><!-- END form-group -->
							<!-- END Skills Details -->							
							
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