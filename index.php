<?php 
  session_start();
  include("data/products.php");
  require("config/db.php");

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
    <link rel="stylesheet" href="http://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>My Account | GrabBoss</title>
    <link rel="stylesheet" href="styles/instyle.css">
  </head>
  <body>
    <div class="container py-4">
      <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-12 col-md-4 col-lg-3">
          <div class="account-sidebar p-3">
            <h6 class="mb-3 fw-bold">My Account</h6>
            <nav class="nav flex-column">
              <a href="#" class="nav-link active">Orders</a>
              <a href="products.php" class="nav-link">Return to Catalogue</a>
              <a href="in/settings.php" class="nav-link">Settings</a>
              <a href="auth/logout.php" class="nav-link text-danger">Logout</a>
            </nav>
          </div>
        </div>

        <div class="col-12 col-md-8 col-lg-9">
          <!-- Let my orders show here -->
          <div class="account-content p-3">
            <div class="d-flex align-items-center mb-4">
              <h5 class="mb-0">My Orders</h5>
            </div>
          </div>
          <?php 
            // If there are no orders, show a message
            echo '
            <div class="text-center text-muted py-5">
              <h6 class="mb-3">No orders yet</h6>
              <p>Looks like you haven\'t made any orders yet. Start shopping now!</p>
              <a href="products.php" class="btn btn-primary">Shop Now</a>
            </div>';
                  
                  ?>
        </div>
      </div>
    </div>
  </body>
</html>