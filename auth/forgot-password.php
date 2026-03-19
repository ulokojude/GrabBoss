<?php include "scripts/forgot_pw_script.php"; ?>

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
          <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
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