<?php 
session_start();
include("../../config/db.php");
$message = "";
$mess = "";

$_SESSION['token'] = bin2hex(random_bytes(32));

if (empty($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
} else {
  // Regenerate token on each request for better security
  $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // CSRF validation
  if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
  $email = trim($_POST["email"]);
  $password = $_POST["password"];
  if (empty($email) || empty($password)) {
    $message = "All fields are required";
    $mess = "alert-danger";
  } else {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // Verify password
    if ($user) {
      // verify password using password_verify
      if(password_verify($password, $user["password"])) {
        //regenerate session variables
        session_regenerate_id(true); // Regenerate session ID for security
        $_SESSION['token'] = bin2hex(random_bytes(32)); // Regenerate token on login
        // store user data in session
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["full_name"];
        $_SESSION["email"] = $user["email"];

        header("Location: ../products.php");
        exit();
      } else {
        $message = "Invalid email or password";
        $mess = "alert-danger";
      }
    } else {
      $message = "Invalid email or password";
      $mess = "alert-danger";
    }
  }
}
?>