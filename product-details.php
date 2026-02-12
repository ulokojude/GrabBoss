<?php 
  session_start();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
      crossorigin="anonymous">
    <title>Product Details | GrabBoss</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a href="index.php" class="navbar-brand">GrabBoss</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="products.php" class="nav-link text-light">Products</a></li>
            <li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
            <li class="nav-item"><a href="index.php" class="nav-link">Profile</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="container py-5">
      <div class="">
        <div class="align-items-center">
          <img class="product-image" src="/bathroom-rug.jpg" width="90px">
        </div>
        <div class="col-12 col-md-6">
          <h3>Smartphone</h3>
          <p class="text\">Category: Electronics</p>
          <h4 class="text-success">N120,000</h4>
          <p class="mt-3">
            This smartphone features a high-resolution
            display, fast proccessor, long-lasting
            battery, and modern design suitable for
            daily use
          </p>
          <div class="mb-3">
            <label for="form-label">Quantity</label>
            <input type="number" class="form-control w-50" value="1" min="1">
          </div>
          <button class="btn btn-primary me-2">Add to Cart</button>
          <a href="products.php" class="btn btn-outline-secondary">
            Back to products
          </a>
        </div>
      </div>
    </section>
  </body>
</html>