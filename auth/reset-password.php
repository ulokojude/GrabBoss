<?php 
  session_start();
  include("../config/db.php");
  if(!isset($_SESSION["reset_email"])) {
    header("Location: forgot-password.php");
    exit();
  }
  $message = "";
  $mess = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
      $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
      $stmt->bind_param("ss", $hashed, $$email);
      if($stmt->execute()) {
        unset($_SESSION['reset_email']);
        header("Location: login.php");
      exit();
      } else {
        $message = "Password reset failed";
        $mess = "alert-danger";
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
      crossorigin="anonymous">
    <title>Reset Password | GrabBoss</title>
  </head>
  <body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow w-100" style="max-width: 400px;">
        <h4 class="text-center mb-3">Reset Password</h4>
        <div class="alert <?php echo $mess; ?>">
          <?php echo $message ?>
        </div>
        <form action="" method="post">
          <div class="mb-3">
            <label for="" class="form-label">New password</label>
            <input type="password" name="password" class="form-control" placeholder="new password" required>
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Confirm Password</label>
            <input type="password" name="confirm" class="form-control" placeholder="re-type password" required>
          </div>
          <div class="mb-3">
            <button class="btn btn-success w-100">Reset Password</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>