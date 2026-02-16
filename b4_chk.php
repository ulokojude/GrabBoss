<?php
  if(!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>Orders | GrabBoss</title>
  </head>
  <body>
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow-lg w-100" style="max-width: 400px;">
        <form action="b4_chk.php" method="POST">
          <div class="mb-3">
            <input type="text">
          </div>
        </form>
      </div>
    </div>
  </body>
</html>