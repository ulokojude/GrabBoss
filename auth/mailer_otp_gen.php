<?php
  require 'vendor/autoload.php';
  use PHPMailer\PHPMailer\PHPMailer;

  include '../config/db.php';

  if(isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // check if user exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) == 0) {
      die("Email not found");
    }
    // Generate OTP
    $otp = rand(100000, 999999);
    $expire = date("Y-m-d H:i:s", strtotime("+10 munutes"));

    // Store OTP in database
    mysqli_query($conn, "UPDATE users SET otp='$otp', otp_expire='$expire' WHERE email='$email'");

    // Send Email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "your-email@gmail.com"; // Replace with your Gmail address
    $mail->Password = "your-app-password"; // Replace with your Gmail app password
    $mail->SMTPSecure = 'tls';
    $mail->Port =587;

    $mail->setFrom("your-email@gmail.com", "GrabBoss");
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = " Password Reset OTP";
    $mail->Body = "Your OTP for password reset is: <b>$otp</b>. It expires in 10 minutes.";
    $mail->send();

    echo "OTP sent to your email";
  }

  
?>