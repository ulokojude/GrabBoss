<?php 
  session_start();
  include("../config/db.php");
  if(!isset($_SESSION["reset_email"])) {
    header( "Location: forgot-password.php" );
    exit();
  }
  $message = "Your eamil was found.";
  $mess = "alert-success";
  if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    if (empty($password) || empty($confirm)) {
      $message = "All fields are required";
      $mess = "alert-danger";
    } elseif ($password !== $confirm) {
      $message = "Password do not match";
      $mess = "alert-danger";
    } else {
      $message = "Password changed successfully";
      $mess = "alert-success";
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $email = $_SESSION["reset_email"];
      
      //$query = "UPDATE users SET password = '$hashed' WHERE email= '$email'";
      $stmt = $pdo->prepare( "UPDATE users SET password = ? WHERE email = ?" );
      
      if($stmt->execute([$hashed, $email])) {
        unset($_SESSION['reset_email']);
        session_regenerate_id(true); // Regenerate session ID for security
        $_SESSION['token'] = bin2hex(random_bytes(32)); // Regenerate token on password reset
        header("Location: login.php");
        exit();
      } else {
        $message = "Password reset failed";
        $mess = "alert-danger";
      }
    }
  }
  
?>