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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
      crossorigin="anonymous">
    <title>profile | GrabBoss</title>
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
            <li class="nav-item"><a href="auth/logout.php" class="nav-link text-danger">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>


  </body>
</html>