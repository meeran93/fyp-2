<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE HTML>

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    
    <title>SmartRecruiter</title>
    
    <meta name="viewport" content="width=device-width">

    <!-- Bootstrap stylesheet -->
    <link href="resources/templates/./assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="resources/templates/./assets/plugins/jquery-ui/css/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css" />

    <!-- Font awesome -->
    <link href="resources/templates/./assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <!-- Select2 plugin stylesheet -->
    <link rel="stylesheet" type="text/css" href="resources/templates/./assets/plugins/select2-4.0.1/dist/css/select2.css"/>
    <!-- Bootstrap Flat stylesheet -->
    <link href="resources/templates/./assets/css/bootstrap-flat.css" rel="stylesheet" type="text/css"/>
    <!-- Admin stylesheet -->
    <link href="resources/templates/./assets/css/invoiceShelfAdmin.css" rel="stylesheet" type="text/css"/>
    <!-- Create new invoice stylesheet -->
    <link href="resources/templates/./assets/css/invoiceShelf.css" rel="stylesheet">
    <!-- Datepicker plugin stylesheet -->
    <link href="resources/templates/./assets/plugins/bootstrap-datepicker/datepicker.css" rel="stylesheet">
    <!-- Bootstrap dialog stylesheet -->
    <link href="resources/templates/./assets/plugins/bootstrap-dialog/css/bootstrap-dialog.css" rel="stylesheet" type="text/css" />
    <!-- Footable stylesheet -->
    <link href="resources/templates/./assets/plugins/fooTable/css/footable.core.css" rel="stylesheet" type="text/css" />
    <!-- Typeahead plugin stylesheet -->
    <link href="resources/templates/./assets/css/typeahead.js-bootstrap.css" rel="stylesheet" media="screen">
    <!-- TE Jquery WYSIWYG editor stylesheet -->
    <link href="resources/templates/./assets/plugins/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet" type="text/css" />
    <!-- Bar rating stylesheet -->
    <link href="resources/templates/./assets/plugins/barrating/css/bars-1to10.css" rel="stylesheet" type="text/css" />

</head>

<body>

  <!-- Static navbar -->
  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- <a class="navbar-brand" href="invoices.php"><img src="resources/templates/./assets/img/invoiceform-logo.png" alt="InvoiceForm" style="margin-top:-8px;"></a> -->
        <a class="navbar-brand" href="#">SmartRecruiter</a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li <?php if( $page == 'forms' ){ ?>class="active"<?php } ?>>
            <a href="forms.php"><span class="glyphicon glyphicon-list-alt"></span> Forms</a>
          </li>
          <li class="dropdown <?php if( $page == 'skills' ){ ?>active<?php } ?> <?php if( $page == 'certificates' ){ ?>active<?php } ?>" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-tasks"></span> Requirements <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="skills.php">Skills</a></li>
              <li><a href="certificates.php">Certificates</a></li>
            </ul>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li><a href="login.php?logout=1"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
  