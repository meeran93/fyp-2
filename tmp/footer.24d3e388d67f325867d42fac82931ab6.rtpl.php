<?php if(!class_exists('raintpl')){exit;}?>
      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
        <script type='text/javascript' src="resources/templates/./assets/js/jquery-2.0.3.min.js"></script>
        <script src="resources/templates/./assets/plugins/jquery-ui/jquery-ui-1.9.2.custom.min.js"></script>

        <script type='text/javascript' src="resources/templates/./assets/js/bootstrap.min.js"></script>
        <script type='text/javascript' src="resources/templates/./assets/js/invoiceShelf.js"></script>
        <script type='text/javascript' src="resources/templates/./assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <script type='text/javascript' src="resources/templates/./assets/plugins/form-validator/jquery.form-validator.min.js"></script>
        <script type='text/javascript' src="resources/templates/./assets/plugins/datatables/jquery.dataTables.js"></script>
        <script type='text/javascript' src="resources/templates/./assets/js/invoiceShelfAdmin.js"></script>
        <script src="resources/templates/./assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
        <script src="resources/templates/./assets/plugins/bootstrap-dialog/js/bootstrap-dialog.js"></script>
        <script src="resources/templates/./assets/plugins/fooTable/js/footable.js"></script>
        <script src="resources/templates/./assets/plugins/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js"></script>
        <script src="resources/templates/./assets/plugins/barrating/js/jquery.barrating.js"></script>
    
        <script type="text/javascript">

            $(document).ready(function() {

                function ratingEnable() {
                    $('.rating-bar').barrating('show', {
                        theme: 'bars-1to10'
                    });
                }

                $(function() {
                    ratingEnable();
                });

				$(".remove_button").click(function() {
                    var mainDiv = $(this).parent().parent();
                    var nextDiv = mainDiv.next();
                    nextDiv.remove();
                    mainDiv.remove();
                });

                // footable plugin - to make tables responsive
                $('.footable').footable();
                $(".autocomplete-field").select2();
                
                // JQuery for requirement-addition-functionality
				
				// Adding education requirement - HR
                
				var getDegrees = function() {
					var degrees = $("#educationList").data('degrees');
					var degree_options = "";
					for(var i=0;i<degrees.length;i++){
						degree_options += '<option value="' + degrees[i]['degree_id'] + '">' + degrees[i]['degree_name'] + '</option>';
					}
					return degree_options;
				}
				
				var getFields = function() {
					var fields = $("#educationList").data('fields');
					var field_options = "";
					for(var i=0;i<fields.length;i++){
						field_options += '<option value="' + fields[i]['field_id'] + '">' + fields[i]['field_name'] + '</option>';
					}
					return field_options;
				}

                $("#addEducation").click(function() {
					var degree_options = getDegrees();
					var field_options = getFields();
                    var fieldWrapper = $('<div class="requirement-data education col-md-12">');
                    var fName = $('<label class="control-label col-md-1">Degree:</label><div class="col-md-3"><select class="form-control autocomplete-field" name="requirement_degree[]" required><option value="" disabled selected>- Select Degree -</option>' + degree_options + '</select></div><label class="control-label col-md-1">Field of Study:</label><div class="col-md-3"><select class="form-control autocomplete-field" name="requirement_field[]" required><option value="" disabled selected>- Select Field -</option>' + field_options + '</select></div><label class="control-label col-md-1">Priority:</label><div class="col-md-2"><input type="range" name="requirement_education_priority[]" min="0" max="10" required></div>');
                    var removeButton = $('<div class="col-md-1"><a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a></div></div><div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#educationList").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                });
                // END - Adding education requirement - HR
                
				// Adding education requirement - Candidate [Doesn't have Priority field] ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~START
                $("#addEducationCandidate").click(function() {
				    var degree_options = getDegrees();
                    var field_options = getFields();
                    var fieldWrapper = $('<div class="requirement-data education col-md-12">');
                    var fName = $('<div class="candidate-data col-md-8"><label class="control-label col-md-2">School/Institute:</label><div class="col-md-10"><input type="text" class="form-control" name="requirement_school[]"></div></div><div class="candidate-data col-md-8"><label class="control-label col-md-3">Dates Attended:</label><span class="col-md-1" style="margin-top:4px">from</span><div class="col-md-3"><select class="form-control" name="requirement_school_start[]" required><option value="">-</option><option>2016</option><option>2015</option><option>2014</option><option>2013</option><option>2012</option><option>2011</option><option>2010</option></select></div><span class="col-md-1" style="margin-top:4px">to</span><div class="col-md-3"><select class="form-control" name="requirement_school_end[]" required><option value="">-</option><option>2016</option><option>2015</option><option>2014</option><option>2013</option><option>2012</option><option>2011</option><option>2010</option></select></div></div><div class="candidate-data col-md-8"><label class="control-label col-md-2">Degree:</label><div class="col-md-10"><select class="form-control autocomplete-field" name="requirement_degree[]" required><option value="" disabled selected>- Select Degree -</option>' + degree_options + '</select></div></div><div class="candidate-data col-md-8"><label class="control-label col-md-3">Field of Study:</label><div class="col-md-9"><select class="form-control autocomplete-field" name="requirement_field[]" required><option value="" disabled selected>- Select Field -</option>' + field_options + '</select></div></div></div>');

                    var removeButton = $('<div class="col-md-1"><a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a></div></div><div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#educationList").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                });
                // END - Adding education requirement - Candidate ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~END
				
                // Adding skill requirement - HR
                var getSkills = function() {
					var skills = $("#skillsList").data('skills');
					var skill_options = "";
					for(var i=0;i<skills.length;i++){
						skill_options += '<option value="' + skills[i]['skill_id'] + '">' + skills[i]['skill_name'] + '</option>';
					}
					return skill_options;
				}
				
                $("#addSkill").click(function() {
					var skill_options = getSkills();
                    var fieldWrapper = $('<div class="requirement-data-data skill col-md-10">');
                    var fName = $('<label class="control-label col-md-1">Skill:</label><div class="col-md-5"><select class="form-control autocomplete-field" name="requirement_skill[]" required><option value="" disabled selected>- Select Skill -</option>' + skill_options + '</select></div><label class="control-label col-md-1">Priority:</label><div class="col-md-3"><select class=rating-bar name=requirement_skill_expertise[]><option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10</select></div>');
                    var removeButton = $('<div class="col-md-1"><a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a></div><div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#skillsList").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                    ratingEnable();
                });
                // END - Adding skill requirement - HR
				
				// Adding skill requirement - Candidate
				$("#addCandidateSkill").click(function() {
					var skill_options = getSkills();
                    var fieldWrapper = $('<div class="candidate-data skill col-md-10">');
                    var fName = $('<label class="control-label col-md-1">Skill:</label><div class="col-md-4"><select class="form-control autocomplete-field" name="requirement_skill[]" required><option value="" disabled selected>- Select Skill -</option>' + skill_options + '</select></div><label class="control-label col-md-3">Level of Expertise:</label><div class="col-md-3"><select class=rating-bar name=requirement_skill_expertise[]><option value=1>1<option value=2>2<option value=3>3<option value=4>4<option value=5>5<option value=6>6<option value=7>7<option value=8>8<option value=9>9<option value=10>10</select></div>');
                    var removeButton = $('<div class="col-md-1"><a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a></div><div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#skillsList").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                    ratingEnable();
                });
                // END - Adding skill requirement - Candidate
				
                // Adding experience requirement - HR
                var getWorkTitles = function() {
					var titles = $("#experienceList").data('titles');
					var title_options = "";
					for(var i=0;i<titles.length;i++){
						title_options += '<option value="' + titles[i]['title_id'] + '">' + titles[i]['title_name'] + '</option>';
					}
					return title_options;
				}
                $("#addExperience").click(function() {
				    var title_options = getWorkTitles();
                    var fieldWrapper = $('<div class="requirement-data experience col-md-12">');
                    var fName = $('<label class="control-label col-md-1">Field Type:</label><div class="col-md-4"><select class="form-control autocomplete-field" name="requirement_experience[]" required><option value="" disabled selected>- Select Area -</option>' + title_options + '</select></div><label class="control-label col-md-2">Years of Experience:</label><div class="col-md-1"><input type="number" class="form-control" name="requirement_experience_years[]" min=0 required></div><label class="control-label col-md-1">Priority:</label><div class=col-md-2><input type="range" name="requirement_experience_priority[]" min=0 max=10 required></div>');
                    var removeButton = $('<div class="col-md-1"><a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a></div><div class="col-md-12" style="height:1px;background:#aaa;margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#experienceList").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                });
                // END - Adding experience requirement - HR

                // Adding experience requirement - Candidate [Doesn't have Priority field] ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~START
                $("#addExperienceCandidate").click(function() {
                    var title_options = getWorkTitles();
                    var fieldWrapper = $('<div class="requirement-data experience"></div>');
                    var fName = $('<div class="col-md-12"><label class="control-label col-md-1">Company:</label><div class="col-md-4"><input class="form-control" name="requirement_experience_company[]"></div><label class="control-label col-md-1">Title:</label><div class="col-md-4"><select class="form-control autocomplete-field" name="requirement_experience[]" required><option value="" disabled selected>- Select Title -</option>' + title_options + '</select></div></div><div class="candidate-data col-md-10"><label class="control-label col-md-2">Years of Experience:</label><div class="col-md-2"><input type="number" class="form-control" name="requirement_experience_years[]" min="0" required></div><label class="control-label col-md-2">Description:</label><div class="col-md-6"><textarea class="form-control" name="requirement_experience_responsibilities[]" placeholder="Your responsiblities"></textarea></div></div>');
                    var removeButton = $('<div class="col-md-1"><a style=cursor:pointer><span class="remove glyphicon glyphicon-remove"></span></a></div><div class="col-md-12" style="height:1px;background:#aaa;margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#experienceList").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                });
                // END - Adding experience requirement - Candidate ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~END

                // Adding certification requirement -HR
				var getCertificates = function() {
					var certificates = $("#certificationList").data('certificates');
					var certificate_options = "";
					for(var i=0;i<certificates.length;i++){
						certificate_options += '<option value="' + certificates[i]['certificate_id'] + '">' + certificates[i]['certificate_name'] + '</option>';
					}
					return certificate_options;
				}
                $("#addCertificate").click(function() {
				    var certificate_options = getCertificates();
                    var fieldWrapper = $('<div class="candidate-data certification col-md-8">');
                    var fName = $('<label class="control-label col-md-2">Certification:</label><div class="col-md-4"><select class="form-control autocomplete-field" name="requirement_certification[]" required><option value="" disabled selected>- Select Certification -</option>' + certificate_options + '</select></div><label class="control-label col-md-1">Priority:</label><div class="col-md-4"><input type="range" name="requirement_certification_priority[]" min=0 max=10></div>');
                    var removeButton = $('<div class=col-md-1><a style=cursor:pointer><span class="remove glyphicon glyphicon-remove"></span></a></div><div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#certificationList").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                });
                // END - Adding certification requirement - HR

                // Adding certification requirement - Candidate [Doesn't have Priority field. Has Date field] ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~START
                $("#addCertificateCandidate").click(function() {
                    var certificate_options = getCertificates();
                    var fieldWrapper = $('<div class="candidate-data certification col-md-8">');
                    var fName = $('<label class="control-label col-md-2">Certification:</label><div class="col-md-4"><select class="form-control autocomplete-field" name="requirement_certification[]" required><option value="" disabled selected>- Select Certification -</option>' + certificate_options + '</select></div><div><div class="col-md-2"><span>Date Awarded: </span></div><div class="col-md-3"><input type="date" class="form-control" name="requirement_certification_date[]"/></div></div>');
                    var removeButton = $('<div class="col-md-1"><a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a></div><div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#certificationList").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                });
                // END - Adding certification requirement - Candidate ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~END
				
                // Add new skill
				var getSkillsCategories = function() {
					var categories = $("#add-skills-list").data('skill-categories');
					var skill_category = "";
					for(var i=0;i<categories.length;i++){
						skill_category += '<option value="' + categories[i]['category_id'] + '">' + categories[i]['category_name'] + '</option>';
					}
					return skill_category;
				}
				$("#addNewSkill").click(function() {
                    var skill_category = getSkillsCategories();
					var fieldWrapper = $('<div class="candidate-data certification col-md-8">');
                    var fName = $('<label class="control-label col-md-1">Skill:</label><div class="col-md-4"><input type="text" class="form-control" name="new-skill[]" placeholder="Enter skill" required></div><div><label class="control-label col-md-2">Category:</label></div><div class="col-md-4"><select class="form-control autocomplete-field" name="skill-category[]" required><option value="" disabled selected>- Select Category -</option>' + skill_category + '</select></div>');
                    var removeButton = $('<div class="col-md-1"><a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a></div><div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#add-skills-list").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                });
                // END - Adding skill
                
				// Create new certificate
                var getCertificateCategories = function() {
                    var skills = $("#certificationList").data('certificate-categories');
                    var skill_category = "";
                    for(var i=0;i<skills.length;i++){
                        skill_category += '<option value="' + skills[i]['category_id'] + '">' + skills[i]['category_name'] + '</option>';
                    }
                    return skill_category;
                }

				$("#addNewCertificate").click(function() {
					var certificate_category = getCertificateCategories();
                    var fieldWrapper = $('<div class="candidate-data certification col-md-10">');
                    var fName = $('<label class="control-label col-md-2">Certificate title:</label><div class="col-md-3"><input type="text" class="form-control" name="new-certificate[]" required></div><div><label class="control-label col-md-1">Category:</label></div><div class="col-md-4"><select class="form-control autocomplete-field" name="certificate-category" required><option value="" disabled selected>- Select Category -</option>' + certificate_category + '</select></div>');
                    var removeButton = $('<div class="col-md-1"><a style="cursor:pointer"><span class="remove glyphicon glyphicon-remove"></span></a></div><div class="col-md-12" style="height:1px; background:#aaa; margin:10px 0"></div>');
                    removeButton.click(function() {
                        $(this).parent().remove();
                    });
                    fieldWrapper.append(fName);
                    fieldWrapper.append(removeButton);
                    $("#certificationList").append(fieldWrapper);
                    $(".autocomplete-field").select2();
                });
                // END - Adding certificate
                // END - JQuery requirement-addition-functionality
            });
        </script>
                
    </body>
</html>