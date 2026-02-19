<?php 
  session_start();

  if(!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
  }

  include("data/products.php");
  require("config/db.php");

  $user_id = $_SESSION["user_id"];

  $sql = "SELECT o.id as o.id. o.quantity, o.total_price, p.name, p.image FROM orders o JOIN products p ON o.product_id = p.id WHERE o.user_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
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
              <?php if($result->num_row > 0); ?>
                <?php while($row = $result->fetch_assoc()); ?>
                  <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                      <img src="uploads/<?php echo $row['image']; ?>"
                        class="card-img-top img-fluid"
                        style="height: 200px; object-fit:cover;"   
                        alt="Product"
                      >
                      <div class="card-body">
                        <h6 class="fw-bold"><?php echo $row['name']; ?></h6>
                        <p class="mb-1">Quantity: <?php echo $row['quantity']; ?></p>
                        <p class="text-primary fw-bold">
                          N<?php  ?>
                        </p>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>