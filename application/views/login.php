<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>E-CoviMED - log in or sign up</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link class="first" href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link class="second" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

  <div class="container">

    <!-- Outer Row -->
    <!-- <div class="justify-content-center"> -->

      <!--<div class="col-xl-10 col-lg-12 col-md-9">-->

        <div class="o-hidden border-0 my-5 custom_container3">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <!-- <div class="row"> -->
              <!-- <div class="col-"> -->
                <div class="p-5 custom_container2 align-self-baseline">
                <div class="form-group">
                          <span id="success_message"></span>
						    </div>
                    <div class="d-flex flex-column align-items-center">
                        <img src="<?php echo base_url(); ?>assets/img/E-CoviMED logo extra small.png"  alt="Responsive image">
                    </div>
                    <br>
                  <form class="user" id="login_form" action="<?php echo base_url(); ?>login/login_validations" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" name="email" placeholder="Enter User Name..." value="<?php echo set_value('email');?>">
                      <?php echo form_error("email");?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                      <?php echo form_error("password"); ?>
                    </div>
                    <button name="login" id="login" class="btn btn-primary btn-user btn-block" type="submit">Login</button>
                    <hr>
                    <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a> -->
                  </form>
                  <div class="text-center">
                    <a class="small" href="<?php echo base_url(); ?>login/forgot_password">Forgot Password?</a>
                  </div>
                  <br>
                  <div class="text-center">
                    <a class="btn btn-success btn-block" href="<?php echo base_url(); ?>Patient/patient_registration">Create New Account</a>
                  </div>
                </div>
              <!-- </div> -->
            <!-- </div> -->
          </div>
        </div>

      <!--</div>-->

    <!-- </div> -->

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>

</body>

</html>
<script>
  $(document).ready(function(){


    var url_string = window.location.href;
    var url = new URL(url_string);
    var c = url.searchParams.get("c");
    if(c)
    {
      $('#success_message').html('<div class="alert alert-success">New account created successfully..Please Sign In</div>');
    }
    
});
</script>
