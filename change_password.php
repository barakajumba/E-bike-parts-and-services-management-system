<?php
include('config.php'); // Ensure this includes your database connection details and starts the session

$msg1 = "";
$msg2 = "";
$msg3 = "";

if (!empty($_POST["submit"])) {
    $old_password = mysqli_real_escape_string($conn, $_POST["old_password"]);
    $new_password = mysqli_real_escape_string($conn, $_POST["new_password"]);
    $co_password = mysqli_real_escape_string($conn, $_POST["co_password"]);

    if ($new_password == $co_password) {
        $query = "SELECT * FROM client_list WHERE password = '$old_password' AND id = '".$_SESSION['id']."'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            // Update password
            $update_query = "UPDATE client_list SET password = '$new_password' WHERE id = '".$_SESSION['id']."'";
            $update_result = mysqli_query($conn, $update_query);
            
            if ($update_result) {
                $msg1 = "Password Updated Successfully!";
            } else {
                $msg2 = "Failed to update password. Please try again.";
            }
        } else {
            $msg2 = "Old Password Does Not Match";
        }
    } else {
        $msg3 = "New Password & Confirm Password Do Not Match";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - RevvRight Online Motorcycle Parts and Services</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Make sure to adjust the path -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <style>
        .bg-gradient-primary {
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            background-size: cover;
        }
    </style>
</head>
<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Change Password</h1>
                                        <h4 style="color: red;">
                                            <?php 
                                                if ($msg1) {
                                                    echo $msg1;
                                                } elseif ($msg2) {
                                                    echo $msg2;
                                                } elseif ($msg3) {
                                                    echo $msg3;
                                                }
                                            ?>  
                                        </h4>
                                    </div>
                                    <form method="post" action="" class="user">
                                        <div class="form-group">
                                            <input type="password" name="old_password" class="form-control form-control-user" placeholder="Enter Old Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="new_password" class="form-control form-control-user" placeholder="Enter New Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="co_password" class="form-control form-control-user" placeholder="Confirm New Password" required>
                                        </div>
                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-user btn-block">
                                        <a href="index.php" class="btn btn-danger btn-user btn-block">Cancel</a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
