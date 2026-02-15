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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/generals.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>Login | GrabBoss</title>
  </head>
  <body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow-lg w-100" style="max-width: 400px;"> 
        <!-- <div>
          <img src="../images/icons/logo.png" style="border-radius: 4px;" width="25%">
        </div> -->
        <form action="" method="post">
          <h4 class="text-center mb-3">GrabBoss</h4> 
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
            <a href="forgot-password.php" class="text-decoration-none">
              Forgot password?
            </a>
            <p>
              Don't have an account? 
              <a href="register.php" class="text-decoration-none">Create account.</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>