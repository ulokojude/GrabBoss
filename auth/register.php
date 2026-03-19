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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
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
        <?php if (!empty($message)): ?>
          <div class="alert <?php echo $mess; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="register.php" method="POST">
          <input type="hidden" name="token" value="<?php echo $_SESSION[ 'token' ]; ?>">
          <div class="row">
            <div class="col-12 col-md-6 p-2">
              <div class="mb-3">
                <label for="" class="form-label">Full Name</label>
                <input type="text" class="form-control" placeholder="John Doe" name="full_name" id="full_name" required>
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
                <button class="btn btn-success mt-2 w-100 <?php // button(); ?>" id="registerBtn">
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

      const fullName = document.getElementById( 'full_name' );
      const email = document.getElementById( 'email' );
      const password = document.getElementById( 'password' );
      const confirmPassword = document.getElementById( 'confirm_password' );
      const registerBtn = document.getElementById( 'registerBtn' );

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