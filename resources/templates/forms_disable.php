{include="header"}
  <div class="container">  
    <div class="page-header">
      <a href="create-job-requirement.php" class="btn btn-success pull-right">Create form</a>
      <h2>{$pageTitle}</h2>
    </div>

    <div class="row rating-example">
      <div class="col-md-12 ">
      {if="$successMsg != ''"}
        <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {$successMsg}
        </div>
      {/if}
      {if="$errorMsg != ''"}
        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {$errorMsg}
        </div>
      {/if}
    {$pageContent}
      {if="$forms != ''"}
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
          {loop="forms"}
            <tr>
                <td><a href="#">{$value.form_date}</a></td>
                <td>{$value.form_description}</td>
                <td>{$value.form_responses}</td>
                <td>{$value.form_status}</td>
                <td>
                  <a href="responses.php?id={$value.form_ID}" class="btn btn-sm btn-primary">Responses</a>
                  <a href="candidate-form.php?formid={$value.form_ID}" class="btn btn-sm btn-info" target="_blank">Candidate Form</a>
                  <a href="edit-job-requirement.php?id={$value.form_ID}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit Job Requirement"><span class="glyphicon glyphicon-edit"></span></a>
                  <a class="disable-status-btn btn btn-sm btn-danger" data-form-id="{$value.form_ID}" data-toggle="tooltip" data-placement="top" title="Disable this form"><span class="glyphicon glyphicon-off"></span></a>
                  <a class="clipboard-btn btn btn-sm btn-default"  id="{$value.form_ID}" data-toggle="tooltip" data-placement="right" title="Copy application form link" data-clipboard-action="copy" data-clipboard-text="127.0.0.1/fyp-2/candidate-form.php?formid={$value.form_ID}"><img src="assets/img/clippy.svg" alt="Copy"></a>
				        </td>
            </tr>
          {/loop}
          </tbody>
        </table>
      {/if}
      </div>
      <!--YOU HAVE BEEN FRAPED xD--> 
    </div>

  </div>
  {include="footer"}