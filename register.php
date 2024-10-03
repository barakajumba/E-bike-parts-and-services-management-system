<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en">
 <?php require_once('inc/header.php') ?>

<body class="">
  <script>
    start_loader()
  </script>
  <style>
        body {
            font-family: 'Arial', sans-serif; /* Change to a suitable font family */
            background-image: url('<?= validate_image($_settings->info('cover')) ?>'); /* Background image */
            background-repeat: no-repeat;
            background-size: cover;
            color: #ffffff; /* White text color */
        }

        .card {
            border: none;
            border-radius: 15px; /* Rounded corners */
            background-color: #ffffff; /* White background color */
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); /* Shadow effect */
        }

        .card-header {
            background-color: #343a40; /* Dark background color */
            color: #ffffff; /* White text color */
            font-size: 24px;
            padding: 20px;
            border-bottom: 2px solid #ffffff; /* White bottom border */
            border-radius: 15px 15px 0 0; /* Rounded corners */
        }

        .card-body {
            background-color: #f8f9fa; /* Light background color */
            padding: 30px; /* Increased padding */
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 10px; /* Rounded corners */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 20px; /* Rounded corners */
            padding: 10px 20px;
            font-size: 18px; /* Increased font size */
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-link {
            color: #007bff;
            font-weight: bold;
        }

        .img-thumbnail {
            border: 2px solid #ffffff; /* White border */
            border-radius: 50%; /* Circular shape */
        }

        #logo-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            object-position: center;
        }

        .pass_type {
            cursor: pointer;
        }
    </style>
<div class="d-flex align-items-center justify-content-center h-100">
  <!-- /.login-logo -->
  <div class="d-flex h-100 justify-content-center align-items-center col-lg-5">
      <center><img src="<?= validate_image($_settings->info('logo')) ?>" alt="System Logo" class="img-thumbnail rounded-circle" id="logo-img"></center>
      <div class="clear-fix my-2"></div>
  </div>
  <div class="d-flex h-100 justify-content-center align-items-center col-lg-7">
    <div class="card card-outline card-primary w-75">
      <div class="card-header text-center">
        <a href="./" class="text-decoration-none text-light"><b>Create an Account</b></a>
      </div>
      <div class="card-body">
        <form id="register-frm" action="" method="post">
          <input type="hidden" name="id">
          <div class="row">
            <div class="form-group col-md-6">
                <input type="text" name="firstname" id="firstname" placeholder="Enter First Name" autofocus class="form-control form-control-sm form-control-border" required>
                <small class="ml-3">First Name</small>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="middlename" id="middlename" placeholder="Enter Middle Name (optional)" class="form-control form-control-sm form-control-border">
                <small class="ml-3">Middle Name</small>
            </div>
            <div class="form-group col-md-6">
                <input type="text" name="lastname" id="lastname" placeholder="Enter Last Name" class="form-control form-control-sm form-control-border" required>
                <small class="ml-3">Last Name</small>
            </div>
            <div class="form-group col-md-6">
                <select name="gender" id="gender" class="custom-select custom-select-sm form-control-border" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <small class="ml-3">Gender</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
                  <input type="text" name="contact" id="contact" placeholder="Enter Contact #" class="form-control form-control-sm form-control-border" required>
                  <small class="ml-3">Contact #</small>
              </div>
          </div>
          <div class="row">
              <div class="form-group col-md-12">
                  <small class="ml-3">Address</small>
                  <textarea name="address" id="address" rows="3" class="form-control form-control-sm rounded-0" placeholder="City, District, Address"></textarea>
              </div>
          </div>
          <hr>
          <div class="row">
              <div class="form-group col-md-6">
                  <input type="email" name="email" id="email" placeholder="jsmith@sample.com" class="form-control form-control-sm form-control-border" required>
                  <small class="ml-3">Email</small>
              </div>
          </div>
          <div class="row">
              <div class="form-group col-md-6">
                  <div class="input-group">
                      <input type="password" name="password" id="password" placeholder="" class="form-control form-control-sm form-control-border" required>
                      <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                          <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                      </div>
                  </div>
                  <small class="ml-3">Password</small>
              </div>
              <div class="form-group col-md-6">
                  <div class="input-group">
                      <input type="password" id="cpassword" placeholder="" class="form-control form-control-sm form-control-border" required>
                      <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                          <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                      </div>
                  </div>
                  <small class="ml-3">Confirm Password</small>
              </div>
          </div>
          <div class="row align-items-center">
              <div class="col-8">
                  <a href="<?php echo base_url ?>">Previous Page</a>
              </div>
              <!-- /.col -->
              <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-sm btn-flat btn-block">Register</button>
              </div>
              <!-- /.col -->
          </div>
          <div class="row">
              <div class="col-12 text-center">
                  <a href="<?php echo base_url.'login.php' ?>">Already have an Account? Log In</a>
              </div>
          </div>
        </form>
        <!-- /.social-auth-links -->

        <!-- <p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p> -->
        
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>

</div>

<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<!-- <script src="<?= base_url ?>dist/js/adminlte.min.js"></script> -->

<script>
  $(document).ready(function(){
    end_loader();
    $('.pass_type').click(function(){
      var type = $(this).attr('data-type')
      if(type == 'password'){
        $(this).attr('data-type','text')
        $(this).closest('.input-group').find('input').attr('type',"text")
        $(this).removeClass("fa-eye-slash")
        $(this).addClass("fa-eye")
      }else{
        $(this).attr('data-type','password')
        $(this).closest('.input-group').find('input').attr('type',"password")
        $(this).removeClass("fa-eye")
        $(this).addClass("fa-eye-slash")
      }
    })
    $('#register-frm').submit(function(e){
      e.preventDefault()
      var _this = $(this)
             $('.err-msg').remove();
       var el = $('<div>')
            el.hide()
      if($('#password').val() != $('#cpassword').val()){
        el.addClass('alert alert-danger err-msg').text('Password does not match.');
        _this.prepend(el)
        el.show('slow')
        return false;
      }
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Users.php?f=save_client",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp =='object' && resp.status == 'success'){
                        location.href = "./login.php";
                    }else if(resp.status == 'failed' && !!resp.msg){   
              el.addClass("alert alert-danger err-msg").text(resp.msg)
              _this.prepend(el)
              el.show('slow')
          }else{
                        alert_toast("An error occured",'error');
                        end_loader();
                        console.log(resp)
                    }
          $('html, body').scrollTop(0)
                }
            })
    })
  })
</script>
</body>
</html>
