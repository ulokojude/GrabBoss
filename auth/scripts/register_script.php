<?php
  include("../config/db.php");
  session_start();

  $message = "";
  $mess = "";
  $diss = "";

  if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
  
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      die("Invalid CSRF token");
    }
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];
    //Validation
    if(empty($full_name) || empty($email) || empty($password)) {
      $message = "All fields are required";
      $mess = "alert-danger";
      $diss = "disabled";
    } elseif($password !== $confirm) {
      $message = "Password do not match";
      $mess = "alert-danger";
      $diss = "disabled";
    } elseif (strlen($password) < 6) {
      $message = "Your password must be at least 6 characters long";
      $mess = "alert-danger";
    }
    else {

      //chech if email exists
      $stmt = $pdo->prepare( "SELECT id FROM users WHERE email = ?" );
      $stmt->execute([$email]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format";
      }
      if ($stmt->rowCount() > 0) {
        $message = "Email already registered";
        $mess = "alert-danger";
      } else {
        // Insert users
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare( "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)" );
        if ($stmt->execute([$full_name, $email, $hashed_password])) {
          session_regenerate_id(true); // Regenerate session ID for security
          $_SESSION['token'] = bin2hex(random_bytes(32)); // Regenerate token on registration
          header( "Location: ../products.php" );
          exit();
        } else {
          $message = "Registration failed";
          $mess = "alert-danger";
        }
      }
    }
  }
?>