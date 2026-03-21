<?php 
  session_start();
  include("../config/db.php");

  $message = "";
  $mess = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    if (empty($email)) {
      $message = "Please enter your email";
      $mess = "alert-danger";
    } else {
      $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
      $stmt->execute([$email]);

      $count = $stmt->fetchColumn();

      if($count == 1) {

        session_regenerate_id(true);

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