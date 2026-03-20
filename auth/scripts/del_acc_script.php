<?php 
  session_start();
  require '../config/db.php';
  $message = "";
  $mess = "";
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }
  $user_id = $_SESSION['user_id'];
  // Generate CSRF token if it doesn't exist
  if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
  if ($_SERVER ["REQUEST_METHOD"] == "POST") {
    // CSRF check
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      die("Invalid Request");
    }
    $password = $_POST['password'];
    // Fetch user's hashed password from the database
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user) {
      if(password_verify($password, $user['password'])){
        //Delete account
        $del = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $del->execute([$user_id]);
        session_destroy();
        session_regenerate_id(true); // Regenerate session ID for security
        header("Location: login.php");
        exit();
      } else {
        $message = "Incorrect password";
        $mess = "alert-danger";
      }
    } else {
      $message = "User not found";
      $mess = "alert-danger";
    }
  }
?>