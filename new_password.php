
<?php 
 include('config.php');
  if(!isset($_SESSION))
 
    session_start();
    $msg = "";
  if(isset($_POST['submit'])) {
    $new_password = $_POST['new_password'];
    $con_password = $_POST['con_password'];
    if ( $new_password == $con_password) 
    {
      $updt_sqr ="UPDATE client_list SET password ='$new_password'";
      $result =mysqli_query($conn,$updt_sqr);
      if ($result)
       {
          header('location:otp.php');
       }
    }
    else
    {
      $msg = "New password does not match with confirm password !";
    }


   }
  
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<style type="text/css">
	.form-gap {
    padding-top: 80px;
}

</style>
</head>
<body>
<div class="form-gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">Enter New Password</h2>
                  <p style="color: red"><?php echo $msg; ?> </p>
                  <div class="panel-body">
                    <form  method="post" id="register-form"  role="form" autocomplete="off" class="form" >
    
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                          <input id="new_password" name="new_password" placeholder="Enter new password" class="form-control"  type="text" required="">
                        </div>
                      </div>

                       <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                          <input id="con_password" name="con_password" placeholder="Enter Confirm password" class="form-control"  type="text" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="submit" >
                      </div>
                    
                      
                       <input type="hidden" class="hide" name="token" id="token" value=""> 
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
	</div>
</div>
</body>
</html>