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
      $query = "SELECT id FROM users WHERE email='$email' LIMIT 1";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) == 1) {
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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <title>Forgot Password | GrabBoss</title>
    <style>
      .form-control:focus {
        box-shadow: none;
      }
    </style>
  </head>
  <body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow w-100" style="max-width: 400px;">
        <h4 class="text-center mb-4">GrabBoss</h4>
        <div class="alert alert <?php echo $mess; ?>">
          <?php echo $message; ?>
        </div>
        <form action="forgot-password.php" method="POST">
          <div class="mb-3">
            <label for="" class="form-label">Registered Email</label>
            <input type="text" name="email" class="form-control" placeholder="example@server.com" required>
          </div>
          <div class="mb-3">
            <a href="login.php" class="text-decoration-none">Back to Login</a>
          </div>
          <div class="mb-3">
            <button class="btn btn-warning w-100">Verify Email</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>