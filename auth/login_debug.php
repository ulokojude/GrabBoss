<?php
  require_once("../config/db.php");
  session_start();

  $message = "";
  $mess = "";
  $debug_info = "";

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $debug_info .= "<hr><strong>DEBUG INFO:</strong><br>";
    $debug_info .= "Email submitted: " . htmlspecialchars($email) . "<br>";
    $debug_info .= "Password submitted: " . str_repeat("*", strlen($password)) . " (length: " . strlen($password) . ")<br>";

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($email) || empty($password)) {
      $message = "All fields are required";
      $mess = "alert-danger";
      $debug_info .= "❌ Empty fields detected<br>";

    } elseif (!$user) {
      $message = "Invalid email or password";
      $mess = "alert-danger";
      $debug_info .= "❌ User not found in database<br>";

    } elseif ($user['status'] == 0) {
      $message = "Your account has been disabled.";
      $mess = "alert-danger";
      $debug_info .= "❌ Account disabled<br>";

    } else {
      $debug_info .= "✓ User found in database<br>";
      $debug_info .= "Stored hash: " . substr($user["password"], 0, 20) . "... (length: " . strlen($user["password"]) . ")<br>";
      $debug_info .= "Hash format: " . (strpos($user["password"], '$2y$') === 0 ? '✓ bcrypt ($2y$)' : '❌ Not bcrypt') . "<br>";
      
      $password_check = password_verify($password, $user["password"]);
      $debug_info .= "password_verify result: " . ($password_check ? "✓ TRUE (Password matches!)" : "❌ FALSE (Password mismatch)") . "<br>";
      $debug_info .= "PHP version: " . phpversion() . "<br>";

      if (!password_verify($password, $user["password"])) {
        $message = "Invalid email or password";
        $mess = "alert-danger";

      } else {
        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["full_name"];
        $_SESSION["email"] = $user["email"];

        header("Location: ../products.php");
        exit();
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/general.css" >
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icon@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <title>Login | GrabBoss</title>
    <style>
      .form-control:focus {
        box-shadow: none;
        border-color: skyblue;
      }
      .debug-box {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 15px;
        margin-top: 20px;
        font-family: monospace;
        font-size: 12px;
      }
    </style>
  </head>
  <body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow-lg w-100" style="max-width: 400px;"> 
        <form action="login_debug.php" method="POST">
          <h4 class="text-center mb-3">GrabBoss</h4> 
          
          <div class="text-center text-muted mb-4">
            Login to your account
          </div>
          <?php if (!empty($message)): ?>
          <div class="alert <?php echo $mess; ?>">
            <?php echo $message ?>
          </div>
          <?php endif; ?>
          <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input type="email" placeholder="jude@email.com" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                <i class="bi bi-eye"></i>
              </span>
              <input 
                type="password" 
                id="password" 
                placeholder="password" 
                name="password" 
                class="form-control" 
                required
              >
            </div>
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
              <a href="register.php" class="text-decoration-none">
                Create account.
              </a>
            </p>
          </div>
        </form>

        <?php if (!empty($debug_info)): ?>
        <div class="debug-box">
          <?php echo $debug_info; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <script>
      const passwordInput = document.getElementById("password");
      const togglePassword = document.querySelector(".input-group-text");
      const icon = togglePassword.querySelector("i");
      togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.type = type;
        icon.classList.toggle("bi-eye");
        icon.classList.toggle("bi-eye-slash");
      });
    </script>
  </body>
</html>
