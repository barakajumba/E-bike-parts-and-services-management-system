<?php
session_start();

// Check if form is submitted
if (isset($_POST['submit'])) {
    $submit_otp = $_POST['otp'];
    
    // Check if OTP matches the stored OTP in session
    if ($submit_otp == $_SESSION['otp']) {
        // Redirect to new password page upon successful OTP verification
        header('Location: new_password.php');
        exit(); // Make sure to exit after redirecting
    } else {
        // If OTP does not match, set error message
        $msg = "Please Enter Valid OTP";
        // Redirect back to index.php with error message
        header('Location: index.php?msg=' . urlencode($msg));
        exit();
    }
} else {
    // If form is not submitted, redirect back to index.php
    header('Location: index.php');
    exit();
}
?>
