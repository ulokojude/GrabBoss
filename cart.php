<?php
  session_start();
  require("config/db.php");
  if(!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
  }
  require("data/products.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
      crossorigin="anonymous">
    <title>Cart | GrabBoss</title>
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
            <li class="nav-item"><a href="products.php" class="nav-link">Products</a></li>
            <li class="nav-item"><a href="cart.php" class="nav-link text-light">Cart</a></li>
            <li class="nav-item"><a href="index.php" class="nav-link">Profile</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="container py-5">
      <h3 class="mb-4">Shopping Cart</h3>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <th>Product</th>
            <th>Price</th>
            <th width="120">Quantity</th>
            <th>Total</th>
            <th></th>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <img src="bathroom-rug.jpg" width="50px" class="rounded me-2 shadow" alt="Product">
                  <span>Smartphone</span>
                </div>
              </td>
              <td>N120,000</td>
              <td>
                <input type="number" class="form-control" value="1">
              </td>
              <td>N120,000</td>
              <td>
                <button class="btn btn-sm btn-danger">Remove</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <div class="row justify-content-center p-4 mt-4">
      <div class="col-12 col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>Cart Summary</h5>
          <hr>
          <p class="d-flex justify-content-between">
            <span>Subtotal</span>
            <strong>N120,000</strong>
          </p>
          <p class="d-flex justify-content-between">
            <span>Delivery</span>
            <strong>N0</strong>
          </p>
          <p class="d-flex justify-content-between fs-5">
            <span>Total</span>
            <strong>N120,000</strong>
          </p>
          <a href="checkout.php" class="btn btn-success w-100 mt-2">
            Proceed To Checkout
          </a>
        </div>
      </div>
    </div>
  </body>
</html>