<?php 
  session_start();
  include("../config/db.php");
  $message = "";
  $mess = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
      $message = "All fields are required";
      $mess = "alert-danger";
    } else {
      $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        // Verify password
        if(password_verify($password, $user["password"])) {
          $_SESSION["user_id"] = $user["id"];
          $_SESSION["user_name"] = $user["full_name"];
          header("Location: ../index.php");
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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
      crossorigin="anonymous">
    <title>Login | GrabBoss</title>
  </head>
  <body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow w-100" style="max-width: 400px;">
        <h4 class="text-center mb-3">GrabBoss</h4>  
        <form action="" method="post">
          <div class="alert <?php echo $mess; ?>"><?php echo $message ?></div>
          <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input type="email" placeholder="jude@email.com" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Password</label>
            <input type="password" placeholder="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <button class="btn btn-primary w-100">Login</button>
          </div>
          <div class="text-center mt-3">
            <a href="forgot-password.php">Forgot password</a>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>