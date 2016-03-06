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
					<form method="POST" action="edit-job-requirement.php">
						<div class="panel-body"><!-- panel-body -->
							
							<input type="hidden" value="<?php echo $form_id;?>" name="form_ID">

							<!-- Description -->
							<div class="form-group description"><!-- form-group -->
								<h4 class="col-md-12"><u>Short Description</u></h4>
								<div class="col-md-10">
									<input type="text" class="form-control" name="description" value="<?php echo $description;?>" required>
								</div>
							</div><!-- END form-group -->
							<!-- END Description -->

							<!-- Education Details -->
							<div class="form-group education-requirements"><!-- form-group -->
								<h4 class="col-md-12"><u>Education</u></h4>
								
								<div id="educationList" data-degrees='<?php echo $degrees_json;?>' data-fields='<?php echo $fields_json;?>'><!-- EducationList -->

									<!-- ============================================================================================== -->
									<?php $counter1=-1; if( isset($education_requirements) && is_array($education_requirements) && sizeof($education_requirements) ) foreach( $education_requirements as $key1 => $value1 ){ $counter1++; ?>
									<div class="requirement-data education col-md-12">
										<label class="control-label col-md-1">Degree:</label>
										<div class="col-md-3">
											<select class="form-control autocomplete-field" name="requirement_degree[]" required>
												<option value="" disabled>- Select Degree -</option>
												<?php $counter2=-1; if( isset($degrees) && is_array($degrees) && sizeof($degrees) ) foreach( $degrees as $key2 => $value2 ){ $counter2++; ?>
												<option value="<?php echo $value2["degree_id"];?>" <?php if( $value1["degree_id"] == $value2["degree_id"] ){ ?>selected {continue}<?php } ?>><?php echo $value2["degree_name"];?></option>
												<?php } ?>
											</select>
										</div>
										<label class="control-label col-md-1">Field of Study:</label>
										<div class="col-md-3">
											<select class="form-control autocomplete-field" name="requirement_field[]" required>
												<option value="" disabled>- Select Field -</option>
												<?php $counter2=-1; if( isset($fields) && is_array($fields) && sizeof($fields) ) foreach( $fields as $key2 => $value2 ){ $counter2++; ?>
												<option value="<?php echo $value2["field_id"];?>" <?php if( $value1["field_id"] == $value2["field_id"] ){ ?> selected {continue}<?php } ?>><?php echo $value2["field_name"];?></option>
												<?php } ?>
											</select>
										</div>
										<label class="control-label col-md-1">Priority:</label>
										<div class="col-md-2">
											<input type="range" name="requirement_education_priority[]" value="<?php echo $value1["priority"];?>" min="0" max="10">	
										</div>
										<div class="col-md-1">
											<a style="cursor:pointer" class="remove_button"><span class="remove glyphicon glyphicon-remove"></span></a>
										</div>
									</div>
									
									<div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>
									<?php } ?>
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

								<div id="skillsList" data-skills='<?php echo $skills_json;?>'><!-- Skills List -->
									
									<!-- ============================================================================================== -->
									<?php $counter1=-1; if( isset($skills_requirements) && is_array($skills_requirements) && sizeof($skills_requirements) ) foreach( $skills_requirements as $key1 => $value1 ){ $counter1++; ?>
									<div class="candidate-data skill col-md-10">
										<label class="control-label col-md-1">Skill:</label>
										<div class="col-md-5">
											<select class="form-control autocomplete-field" name="requirement_skill[]" required>
												<option value="" disabled>- Select Skill -</option>
												<?php $counter2=-1; if( isset($skills) && is_array($skills) && sizeof($skills) ) foreach( $skills as $key2 => $value2 ){ $counter2++; ?>
												<option value="<?php echo $value2["skill_id"];?>" <?php if( $value1["skill_id"] == $value2["skill_id"] ){ ?> selected {continue}<?php } ?>><?php echo $value2["skill_name"];?></option>
												<?php } ?>
											</select>
										</div>
										<label class="control-label col-md-1">Priority:</label>
										<div class="col-md-4">
											<input type="range" name="requirement_skill_priority[]" value="<?php echo $value1["priority"];?>" min="0" max="10">	
										</div>
										<div class="col-md-1">
											<a style="cursor:pointer" class="remove_button"><span class="remove glyphicon glyphicon-remove"></span></a>
										</div>
									</div>

									<div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>
									<?php } ?>
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

								<div id="experienceList" data-titles='<?php echo $titles_json;?>'><!-- Experience List -->

									<!-- ============================================================================================== -->
									<?php $counter1=-1; if( isset($experience_requirements) && is_array($experience_requirements) && sizeof($experience_requirements) ) foreach( $experience_requirements as $key1 => $value1 ){ $counter1++; ?>
									<div class="requirement-data experience col-md-12">
										<label class="control-label col-md-1">Field Type:</label>
										<div class="col-md-4">
											<select class="form-control autocomplete-field" name="requirement_experience[]" required>
												<option value="" disabled>- Select Title -</option>
												<?php $counter2=-1; if( isset($titles) && is_array($titles) && sizeof($titles) ) foreach( $titles as $key2 => $value2 ){ $counter2++; ?>
												<option value="<?php echo $value2["title_id"];?>" <?php if( $value1["title_id"] == $value2["title_id"] ){ ?> selected {continue}<?php } ?>><?php echo $value2["title_name"];?></option>
												<?php } ?>
											</select>
										</div>
										<label class="control-label col-md-2">Years of Experience:</label>
										<div class="col-md-1">
											<input type="number" class="form-control" name="requirement_experience_years[]" value="<?php echo $value1["experience_years"];?>" min="0" max="10">
										</div>
										<label class="control-label col-md-1">Priority:</label>
										<div class="col-md-2">
											<input type="range" name="requirement_experience_priority[]" value="<?php echo $value1["priority"];?>" min="0" max="10">
										</div>
										<div class="col-md-1">
											<a style="cursor:pointer" class="remove_button"><span class="remove glyphicon glyphicon-remove"></span></a>
										</div>
									</div>
									
									<div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>
									<?php } ?>
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
								
								<div id="certificationList" data-certificates='<?php echo $certificates_json;?>'><!-- Certification List -->

									<!-- ============================================================================================== -->
									<?php $counter1=-1; if( isset($certification_requirements) && is_array($certification_requirements) && sizeof($certification_requirements) ) foreach( $certification_requirements as $key1 => $value1 ){ $counter1++; ?>	
									<div class="candidate-data certification col-md-8">
										<label class="control-label col-md-2">Certification:</label>
										<div class="col-md-4">
											<select class="form-control autocomplete-field" name="requirement_certification[]" required>
												<option value="" disabled>- Select Certification -</option>
												<?php $counter2=-1; if( isset($certificates) && is_array($certificates) && sizeof($certificates) ) foreach( $certificates as $key2 => $value2 ){ $counter2++; ?>
												<option value="<?php echo $value2["certificate_id"];?>" <?php if( $value1["certificate_id"] == $value2["certificate_id"] ){ ?> selected {continue}<?php } ?>><?php echo $value2["certificate_name"];?></option>
												<?php } ?>
											</select>
										</div>
										<label class="control-label col-md-1">Priority:</label>
										<div class="col-md-4">
											<input type="range" name="requirement_certification_priority[]" value="<?php echo $value1["priority"];?>" min="0" max="10">	
										</div>
										<div class="col-md-1">
											<a style="cursor:pointer" class="remove_button"><span class="remove glyphicon glyphicon-remove"></span></a>
										</div>
									</div>
									<div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>
									<?php } ?>
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