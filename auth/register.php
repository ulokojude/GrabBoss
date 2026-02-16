<?php
  include("../config/db.php");
  $message = "";
  $mess = "";
  // $diss = "";

  if($_SERVER["REQUEST_METHOD"] == "POST") {
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
    } 
    // elseif (strlen($password) <= 5) {
    //   $message = "Your password leght must be greater than 5 caracters";
    //   $mess = "alert-danger";
    // } 
    else {
      // Hash Password
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      //chech if email exists
      // change to PDO
      $chech = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
      if (mysqli_num_rows($chech) > 0) {
        $message = "Email already registered";
        $mess = "alert-danger";
      } else {
        // Insert users
        // change to PDO
        $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
          header("Location: login.php");
          exit();
        } else {
          $message = "Registration failed";
          $mess = "alert-danger";
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="httpS://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>Register | GrabBoss</title>
    <style>
      .form-control:focus {
        box-shadow: none;
      }
    </style>
  </head>
  <body class="bg-light">
    <div class="container min-vh-100 d-flex py-4 align-items-center justify-content-center">
      <div class="card p-4 shadow w-100 w-md-75 w-lg-50">
        <h4 class="text-center mb-3">GrabBoss</h4>
        <p class="text-center text-muted mb-4">
          Register to start shopping
        </p>
        <div class="alert <?php echo $mess; ?>"><?php echo $message; ?></div>
        <form action="register.php" method="POST">
          <div class="row">
            <div class="col-12 col-md-6 p-2">
              <div class="mb-3">
                <label for="" class="form-label">Full Nmae</label>
                <input type="text" class="form-control" placeholder="Jogh Doe" name="full_name" id="full_name" required>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="example@host.com" name="email" id="email" required>
              </div>
            </div>
            
            <div class="col-12 col-md-6 p-2">
              <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="create password" required>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="re-type password" required>
              </div>
            </div>
          </div>
           <div class="">
              <div class="mb-3">
                <button class="btn btn-success mt-2 w-100 <?php // button(); ?>" id="registerBtn" disabled>
                  Register
                </button>
              </div>
              <div class="mt-3 text-center">
                <span>Already have an account?</span>
                <a href="login.php" >Login</a>
              </div>
            </div>
        </form>
      </div>
    </div>
    <script>
      const fullName = document.getElementById('full_name');
      const email = document.getElementById('email');
      const password = document.getElementById('password');
      const confirmPassword = document.getElementById('confirm_password');
      const registerBtn = document.getElementById('registerBtn');

      function checkFields() {
        if (fullName.value.trim() !== "" &&
            email.value.trim() !== "" &&
            password.value.trim() !== "" &&
            confirmPassword.value.trim() !== "") {
          registerBtn.disabled = false;
        } else {
          registerBtn.disabled = true;
        }
      }

      fullName.addEventListener('input', checkFields);
      email.addEventListener('input', checkFields);
      password.addEventListener('input', checkFields);
      confirmPassword.addEventListener('input', checkFields);
    </script>
  </body>
</html>