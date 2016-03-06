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
						Fill in your requirements
					</div><!-- panel-heading -->
					
					<!-- Main Form -->
					<form method="POST" action="create-job-requirement.php">
						<div class="panel-body"><!-- panel-body -->
							
							<!-- Description -->
							<div class="form-group description"><!-- form-group -->
								<h4 class="col-md-12"><u>Short Description</u></h4>
								<div class="col-md-10">
									<input type="text" class="form-control" name="description" required>
								</div>
							</div><!-- END form-group -->
							<!-- END Description -->

							<!-- Education Details -->
							<div class="form-group education-requirements"><!-- form-group -->
								<h4 class="col-md-12"><u>Education</u></h4>
								
								<div id="educationList" data-degrees='<?php echo $degrees;?>' data-fields='<?php echo $fields;?>'><!-- EducationList -->

									<!-- ============================================================================================== -->
									<!-- <div class="requirement-data education col-md-12">
										<label class="control-label col-md-1">Degree:</label>
										<div class="col-md-3">
											<select class="autocomplete-field" name="requirement_degree[]" required>
												<option value="" disabled selected>- Select Degree -</option>
												<?php $counter1=-1; if( isset($degrees) && is_array($degrees) && sizeof($degrees) ) foreach( $degrees as $key1 => $value1 ){ $counter1++; ?>
												<option value="<?php echo $value1["degree_id"];?>"><?php echo $value1["degree_name"];?></option>
												<?php } ?>
											</select>
										</div>
										<label class="control-label col-md-1">Field of Study:</label>
										<div class="col-md-3">
											<select class="autocomplete-field" name="requirement_field[]" required>
												<option value="" disabled selected>- Select Fields -</option>
												<?php $counter1=-1; if( isset($fields) && is_array($fields) && sizeof($fields) ) foreach( $fields as $key1 => $value1 ){ $counter1++; ?>
												<option value="<?php echo $value1["field_id"];?>"><?php echo $value1["field_name"];?></option>
												<?php } ?>
											</select>
										</div>
										<label class="control-label col-md-1">Priority:</label>
										<div class="col-md-2">
											<input type="range" name="reqirement_education_priority[]" min="0" max="10">	
										</div>
										<div class="col-md-1">
											<a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a>
										</div>
									</div>
									
									<div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div> -->
									<!-- ============================================================================================== -->

								</div><!-- END EducationList -->

								<div class="add-education-button col-md-8">
									<input type="button" value="Add Education" class="form-control" id="addEducation" />
								</div>

							</div><!-- END form-group -->
							<!-- END Education Details -->

							<!-- Skills Details -->
							<div class="form-group skills-details"><!-- form-group -->
								<h4 class="col-md-12"><u>Skills</u></h4>

								<div id="skillsList" data-skills='<?php echo $skills;?>'><!-- Skills List -->
									
									<!-- ============================================================================================== -->
									<!-- <div class="candidate-data skill col-md-10">
										<label class="control-label col-md-1">Skill:</label>
										<div class="col-md-5">
											<select class="form-control" name="requirement_skill[]">
												<option>HTML</option>
												<option>CSS</option>
												<option>JQuery</option>
											</select>
										</div>
										<label class="control-label col-md-1">Priority:</label>
										<div class="col-md-4">
											<input type="range" name="requirement_skill_priority[]" min="0" max="10">	
										</div>
										<div class="col-md-1">
											<a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a>
										</div>
									</div> -->
									<!-- ============================================================================================== -->

								</div><!-- END skillsList -->

								<div class="add-skill-button col-md-8">
									<input type="button" value="Add Skill" class="form-control" id="addSkill" />
								</div>
								
							</div><!-- END form-group -->
							<!-- END Skills Details -->

							<!-- Experience Details -->
							<div class="form-group skills-details"><!-- form-group -->
								<h4 class="col-md-12"><u>Experience</u></h4>

								<div id="experienceList" data-titles='<?php echo $titles;?>'><!-- Experience List -->

									<!-- ============================================================================================== -->
									<!-- <div class="requirement-data experience col-md-12">
										<label class="control-label col-md-1">Field Type:</label>
										<div class="col-md-4">
											<select class="form-control" name="requirement_experience[]" required>
												<option value="">- Select Area -</option>
												<option>Software Development</option>
												<option>Software Project Managment</option>
												<option>Hotel Management</option>
												<option>System Architecture</option>
												<option>Supply Chain Management</option>
												<option>Other</option>
											</select>
										</div>
										<label class="control-label col-md-2">Years of Experience:</label>
										<div class="col-md-1">
											<input type="number" class="form-control" name="reqirement_experience_years[]" min="0" max="10">
										</div>
										<label class="control-label col-md-1">Priority:</label>
										<div class="col-md-2">
											<input type="range" name="reqirement_experience_priority[]" min="0" max="10">
										</div>
										<div class="col-md-1">
											<a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a>
										</div>
									</div>
									
									<div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div> -->
									<!-- ============================================================================================== -->

								</div><!-- END Experience List -->

								<div class="add-position-button col-md-8">
									<input type="button" value="Add Experience Requirement" class="form-control" id="addExperience" />
								</div>
								
							</div><!-- END form-group -->
							<!-- END Experience Details -->

							<!-- Certification Details -->
							<div class="form-group skills-details"><!-- form-group -->
								<h4 class="col-md-12"><u>Certification</u></h4>
								
								<div id="certificationList" data-certificates='<?php echo $certificates;?>'><!-- Certification List -->

									<!-- ============================================================================================== -->	
									<!-- <div class="candidate-data certification col-md-8">
										<label class="control-label col-md-2">Certification:</label>
										<div class="col-md-4">
											<select class="form-control" name="requirement_certification[]">
												<option>CCNA</option>
												<option>MCCP</option>
												<option>ACCA</option>
											</select>
										</div>
										<label class="control-label col-md-1">Priority:</label>
										<div class="col-md-4">
											<input type="range" name="requirement_skill_priority[]" min="0" max="10">	
										</div>
										<div class="col-md-1">
											<a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a>
										</div>
									</div> -->
									<!-- <div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div> -->
									<!-- ============================================================================================== -->

								</div><!-- END Certification List -->

								<div class="add-certificate-button col-md-8">
									<input type="button" value="Add Certificate" class="form-control" id="addCertificate" />
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