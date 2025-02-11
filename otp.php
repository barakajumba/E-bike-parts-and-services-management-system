<!DOCTYPE html>
<html>
<head>
    <title>Reset Password OTP Verification</title>
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
                        <h2 class="text-center">Check your email for the OTP</h2>
                        <p style="color: red;"><?php echo $msg; ?></p>
                        <div class="panel-body">
                            <form id="register-form" action="verify_otp.php" role="form" autocomplete="off" class="form" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                        <input id="otp" name="otp" placeholder="Enter OTP" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Submit">
                                </div>
                                <a href="login.php" class="btn btn-danger btn-user btn-block">Cancel</a>
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
