<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE HTML>

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    
    <title>Login to SmartRecuiter</title>
    
    <meta name="viewport" content="width=device-width">
    <!-- Bootstrap stylesheet -->
    <link href="resources/templates/assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>

    <!-- Bootstrap Flat stylesheet -->
    <link href="resources/templates/assets/css/bootstrap-flat.css" rel="stylesheet" type="text/css"/>
    
    <!-- ReviewForm stylesheet -->
    <link href="resources/templates/assets/css/invoiceShelfAdmin.css" rel="stylesheet" type="text/css"/>
    
    <!-- Jquery -->
    <!-- <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> -->
    <script src="resources/templates/assets/js/jquery-1.7.2.min.js"></script>
    
    <!-- jQuery Form Validator -->
    <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.34/jquery.form-validator.min.js"></script> -->
    <script src="resources/templates/assets/js/jquery.form-validator.min.js"></script>
    
    <!-- starReviews Login -->
    <script src="resources/templates/assets/js/invoiceShelfAdminLogin.js"></script>

</head>

<body>

<div class="container">

  <div class="login">

    <form class="form-login" role="form" method="POST" id="form-login" action="login.php">
      <h3>Login to SmartRecuiter</h3>
      <p>Enter the fields below to login.</p>
      
      <div class="error-msg alert alert-danger" id="error-msg" style="display:none;">You have entered a invalid login.</div>
      <div class="success-msg alert alert-success" id="success-msg" style="display:none;">You have logged in. Please wait... <div class="loading"></div></div>

      <div class="form-group">
        <label for="username">Email</label>
        <div>
          <input type="text" class="form-control" id="username" name="username" placeholder="Your username" data-validation="email"  data-validation-error-msg="Please enter a valid email address.">
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div>
          <input type="password" class="form-control" id="password" name="password" placeholder="*********" data-validation="required"  data-validation-error-msg="Please enter your password.">
        </div>
      </div>

      <div class="form-group">
        <div>
          <button type="submit" class="btn btn-primary">Login</button>
          <!-- <a href="signUp.php" style="margin-left:10px"><em>Sign up</em></a> -->
        </div>
      </div>
    </form>

  </div>
  
  <div class="login-footer">
    <p>Copyright &copy; 2016 by <strong>SmartRecuiter Inc</strong>. All rights reserved.</p>
  </div>
  
</div>

</body>

</html>