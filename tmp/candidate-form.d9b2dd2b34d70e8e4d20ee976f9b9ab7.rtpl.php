<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE HTML>

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    
    <title><?php echo $pageTitle;?> - SmartRecruiter</title>
    
    <meta name="viewport" content="width=device-width">

    <!-- Bootstrap stylesheet -->
    <link href="resources/templates/assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="resources/templates/assets/plugins/jquery-ui/css/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" />

    <!-- Font awesome -->
    <link href="resources/templates/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <!-- Select2 plugin stylesheet -->
    <link rel="stylesheet" type="text/css" href="resources/templates/assets/plugins/select2-4.0.1/dist/css/select2.css"/>
    <!-- Bootstrap Flat stylesheet -->
    <link href="resources/templates/assets/css/bootstrap-flat.css" rel="stylesheet" type="text/css"/>
    <!-- Admin stylesheet -->
    <link href="resources/templates/assets/css/invoiceShelfAdmin.css" rel="stylesheet" type="text/css"/>
    <!-- Create new invoice stylesheet -->
    <link href="resources/templates/assets/css/invoiceShelf.css" rel="stylesheet">
    <!-- Datepicker plugin stylesheet -->
    <link href="resources/templates/assets/plugins/bootstrap-datepicker/datepicker.css" rel="stylesheet">
    <!-- Bootstrap dialog stylesheet -->
    <link href="resources/templates/assets/plugins/bootstrap-dialog/css/bootstrap-dialog.css" rel="stylesheet" type="text/css" />
    <!-- Footable stylesheet -->
    <link href="resources/templates/assets/plugins/fooTable/css/footable.core.css" rel="stylesheet" type="text/css" />
    <!-- Typeahead plugin stylesheet -->
    <link href="resources/templates/assets/css/typeahead.js-bootstrap.css" rel="stylesheet" media="screen">
    <!-- TE Jquery WYSIWYG editor stylesheet -->
    <link href="resources/templates/assets/plugins/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet" type="text/css" />
    <!-- Bar rating stylesheet -->
    <link href="resources/templates/assets/plugins/barrating/css/bars-1to10.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
    .candidate-data {
    	margin-top: 6px;
    }
    </style>

</head>

<body>  
	
	<!-- Main Container -->
	<div class="container-fluid"><!-- container-fluid -->
		<div class="row"><!-- row -->
			<div class="col-md-10 col-md-offset-1"><!-- Main form area -->
				<div class="panel panel-primary main-panel"><!-- panel-primary -->
					
					<div class="panel-heading"><!-- panel-heading -->
						Fill the Form below to Apply for the Job -- <kbd><?php echo $description;?></kbd>
					</div><!-- panel-heading -->
					
					<!-- Main Form -->
					<form method="POST" action="candidate-form.php?formid=<?php echo $formid;?>" enctype="multipart/form-data">
						<div class="panel-body"><!-- panel-body -->
							
							<!-- Upload Resume/CV -->
							<div class="form-group upload-resume"><!-- form-group -->
								<h4 class="col-md-12"><u>Resume/CV</u></h4>

								<div class="upload-resume-button col-md-8">
									<!-- <input type="button" value="Add Education" class="form-control" id="addEducationCandidate" /> -->
									<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
									<input type="file" name="candidate_resume" value="Upload Resume/CV" class="form-control" required>
								</div>

							</div><!-- END form-group -->
							<!-- END Upload Resume/CV -->

							<!-- Personal Details -->
							<div class="form-group personal-details"><!-- form-group -->
								<h4 class="col-md-12"><u>Personal Information</u></h4>
								
								<div class="candidate-data col-md-8">
									<label class="control-label col-md-2">Full name:</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="requirement_name" required>
									</div>
								</div>

								<div class="candidate-data col-md-8">
									<label class="control-label col-md-2">Nationality:</label>
									<div class="col-md-10">
										<select class="form-control autocomplete-field" name="requirement_nationality" required>
											<option value="" disabled selected>- Select Nationality -</option>
											<option>Pakistani</option>
											<option>Russian</option>
											<option>Indian</option>
											<option>American</option>
										</select>
									</div>
								</div>

								<div class="candidate-data col-md-8">
									<label class="control-label col-md-2">Address:</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="requirement_address" required>	
									</div>
								</div>

								<div class="candidate-data col-md-8">
									<label class="control-label col-md-2">Contact:</label>
									<div class="col-md-10">
										<input type="number" class="form-control" name="requirement_contact" required>	
									</div>
								</div>

								<div class="candidate-data col-md-8">
									<label class="control-label col-md-2">Email:</label>
									<div class="col-md-10">
										<input type="email" class="form-control" name="requirement_email" required>	
									</div>
								</div>
							</div><!-- END form-group -->
							<!-- END Personal Details -->
							
							<!-- Education Details -->
							<div class="form-group education-requirements"><!-- form-group -->
								<h4 class="col-md-12"><u>Education</u></h4>

								<div id="educationList" data-degrees='<?php echo $degrees;?>' data-fields='<?php echo $fields;?>'><!-- EducationList -->
									
									<!-- ============================================================================================== -->
									<!-- ============================================================================================== -->

								</div><!-- END EducationList -->

								<div class="add-education-button col-md-8">
									<input type="button" value="Add Education" class="form-control" id="addEducationCandidate" />
								</div>

							</div><!-- END form-group -->
							<!-- END Education Details -->

							<!-- Skills Details -->
							<div class="form-group skills-details"><!-- form-group -->
								<h4 class="col-md-12"><u>Skills</u></h4>

								<div id="skillsList" data-skills='<?php echo $skills;?>'><!-- Skills List -->
									
									<!-- ============================================================================================== -->
									<?php $counter1=-1; if( isset($form_skills) && is_array($form_skills) && sizeof($form_skills) ) foreach( $form_skills as $key1 => $value1 ){ $counter1++; ?>
									<div class="candidate-data col-md-8"><!-- Loaded/Required Skill -->
										<label class="control-label col-md-4">Skill in <!--kbd id="name" data-id="<?php echo $value1["skill_id"];?>" data-name="<?php echo $value1["skill_name"];?>"><?php echo $value1["skill_name"];?></kbd-->
											<input name="requirement_skill[]" value="<?php echo $value1["skill_id"];?>" hidden><i><?php echo $value1["skill_name"];?></i>:
										</label>
										<div class="col-md-4">
											<!-- <input type="range" name="requirement_skill_expertise[]" min="0" max="10"> -->
											<select class="rating-bar" name="requirement_skill_expertise[]">
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
											</select>
										</div>
									</div>
									<div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>
									<?php } ?>
									<!-- ============================================================================================== -->

								</div><!-- END skillsList -->

								<div class="add-skill-button col-md-8">
									<input type="button" value="Add Skill" class="form-control" id="addCandidateSkill" />
								</div>
								
							</div><!-- END form-group -->
							<!-- END Skills Details -->

							<!-- Experience Details -->
							<div class="form-group experience-details"><!-- form-group -->
								<h4 class="col-md-12"><u>Experience</u></h4>

								<div id="experienceList" data-titles='<?php echo $titles;?>'><!-- Experience List -->

									<!-- ============================================================================================== -->
									<?php $counter1=-1; if( isset($form_experience) && is_array($form_experience) && sizeof($form_experience) ) foreach( $form_experience as $key1 => $value1 ){ $counter1++; ?>
									<div class="col-md-12"><!-- Loaded/Required Experience -->
										<label class="control-label col-md-4">Years of Experience -
											<input name="requirement_experience[]" value="<?php echo $value1["title_id"];?>" hidden><i><?php echo $value1["title_name"];?></i>:
										</label>
										<div class="col-md-1">
											<input type="number" class="form-control" name="requirement_experience_years[]">
										</div>
										<div class="col-md-1">
											<label class="control-label">Company:</label>
										</div>
										<div class="col-md-4">
											<input class="form-control" name="requirement_experience_company[]">
										</div>
									</div>
									<div class="candidate-data col-md-10">
										<label class="control-label col-md-2">Responsibilities:</label>
										<div class="col-md-10">
											<textarea class="form-control" name="requirement_experience_responsibilities[]"></textarea>
										</div>
									</div>
									<div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>
									<?php } ?>										
									<!-- ============================================================================================== -->

								</div><!-- END Experience List -->

								<div class="add-position-button col-md-8">
									<input type="button" value="Add Experience" class="form-control" id="addExperienceCandidate" />
								</div>
								
							</div><!-- END form-group -->
							<!-- END Experience Details -->

							<!-- Certification Details -->
							<div class="form-group skills-details"><!-- form-group -->
								<h4 class="col-md-12"><u>Certification</u></h4>
								
								<?php $counter1=-1; if( isset($form_certification) && is_array($form_certification) && sizeof($form_certification) ) foreach( $form_certification as $key1 => $value1 ){ $counter1++; ?>
								<div class="candidate-data col-md-10"><!-- Loaded/Required Certification -->
									<label class="control-label col-md-4">Do you have <i><?php echo $value1["certificate_name"];?></i> Certification?</label>
									<div class="col-md-2">
										<label class="radio-inline"><input type="checkbox" name="requirement_certification[]" value="<?php echo $value1["certificate_id"];?>"> Yes</label>
									</div>
									<div><!-- Date Awarded area -->
										<div class="col-md-2">
											<label class="control-label">Date Awarded: </label>
										</div>
										<div class="col-md-3">
											<input type="date" class="form-control" name="requirement_certification_date[]"/>
										</div>
									</div><!-- END Date Awarded area -->
								</div>
								<div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>
								<?php } ?>
								
								<div id="certificationList" data-certificates='<?php echo $certificates;?>'><!-- Certification List -->

									<!-- ============================================================================================== -->	
									<!-- ============================================================================================== -->

								</div><!-- END Certification List -->

								<div class="add-certificate-button col-md-8">
									<input type="button" value="Add Certificate" class="form-control" id="addCertificateCandidate" />
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
	<!-- END Main Container -->
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>