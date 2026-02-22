<?php 
  session_start();
  require_once "config/db.php";

  if(!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
  }

  $user_id = $_SESSION["user_id"];
  $sql = "SELECT o.id, o.quantity, o.total_price, p.name, p.image 
          FROM orders o 
          JOIN products p ON o.product_id = p.id 
          WHERE o.user_id = $user_id";
  $stmt = mysqli_query($conn, $sql);
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
          <div class="account-content p-3">
            <div class="d-flex align-items-center mb-4">
              <h5 class="mb-0">My Orders</h5>
            </div>

            <div class="row g-4">
              <?php if(mysqli_num_rows($result) > 0) { ?>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                  <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                      <img src="uploads/<?php echo $row['image']; ?>" 
                        class="card-img-top img-fluid" alt="Product"
                        style="height:200px; object-fit:cover;"
                      >
                      <div class="card-body">
                        <h6 class="fw-bold"><?php echo $row['name']; ?></h6>
                        <p class="mb-1">Quantity: <?php echo $row['quantity']; ?></p>
                        <p class="text-primary fw-bold">
                          N<?php echo number_format($row['total_price']); ?>
                        </p>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              <?php } else { ?>
                <div class="text-center text-muted py-5">
                  <h6 class="mb-3">No orders yet</h6>
                  <p>Looks like you hav't made any orders yet.</p>
                  <a href="products.php" class="btn btn-primary">Shop Now</a>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>