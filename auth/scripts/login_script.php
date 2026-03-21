<?php 
  session_start();
  include("../config/db.php");

  $message = "";
  $mess = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);

    $count = $stmt->fetchColumn();

    if (empty($email) || empty($password)) {
      $message = "All fields are required";
      $mess = "alert-danger";
    } elseif ($count > 0) {
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        if ($user['status'] == 0) {
          $message = "Your account has been disabled.";
          $mess = "alert-danger";
        } elseif (password_verify($password, $user["password"])) {

          session_regenerate_id(true);
          $_SESSION["user_id"] = $user["id"];
          $_SESSION["user_name"] = $user["full_name"];
          $_SESSION["email"] = $user["email"];

          header("Location: ../products.php");
          exit();

        } else {
          $message = "Invalid email or password";
          $mess = "alert-danger";
        }
      }
    } else {
      $message = "Invalid email or password";
      $mess = "alert-danger";
    }
  }
?>