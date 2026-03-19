<?php include "scripts/login_script.php"; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/generals.css" >
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
    </style>
  </head>
  <body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow-lg w-100" style="max-width: 400px;"> 
        <!-- <div>
          <img src="../images/icons/logo.png" style="border-radius: 4px;" width="25%">
        </div> -->
        <form action="" method="post">
          <h4 class="text-center mb-3">GrabBoss</h4> 
          <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
          <div class="text-center text-muted mb-4">
            Login to your account
          </div>
          <div class="alert <?php echo $mess; ?>">
            <?php echo $message ?>
          </div>
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
      </div>
    </div>
    <script>
      // make the password hidden and plain
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


