<?php 
  session_start();
  include("../../config/db.php");

  $message = "";
  $mess = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    if (empty($email)) {
      $message = "Please enter your email";
      $mess = "alert-danger";
    } else {
      $query = "SELECT id FROM users WHERE email='$email' LIMIT 1";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) == 1) {
        $_SESSION['token'] = bin2hex(random_bytes(32)); // Generate token for password reset
        session_regenerate_id(true); // Regenerate session ID for security
        $_SESSION["reset_email"] = $email;
        header("Location: reset-password.php");
        exit();
      } else {
        $message = "Email not found";
        $mess = "alert-danger";
      }
    }
  }

?>