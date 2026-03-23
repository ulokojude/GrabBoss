<?php include ("scripts/reset_pw_script.php"); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/generals.css">
    <title>Reset Password | GrabBoss</title>
    <style>
      .form-control:focus {
        box-shadow: none;
      }
    </style>
  </head>
  <body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow w-100" style="max-width: 400px;">
        <h4 class="text-center mb-3">Reset Password</h4>
        <div class="alert <?php echo $mess; ?>">
          <?php echo $message ?>
        </div>
        <form action="" method="POST">
          
          <div class="mb-3">
            <label for="" class="form-label">New password</label>
            <input type="password" name="password" class="form-control" placeholder="New Password" required>
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Confirm Password</label>
            <input type="password" name="confirm" class="form-control" placeholder="Confirm Password" required>
          </div>
          <div class="mb-3">
            <button class="btn btn-success w-100">
              Reset Password
            </button>
          </div>
        </form>
      </div>
    </div>
    <script>

    </script>
  </body>
</html>