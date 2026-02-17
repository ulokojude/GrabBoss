<?php 
  session_start();
  require("config/db.php");
  require("data/products.php");
  if(!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
  }

  // Get product ID from URL hash
  $productId = $_GET['id'] ?? '';

  //search for product in products array
  $productDetails = null;
  foreach($products as $product) {
    if ($product['id'] === $productId) {
      $productDetails = $product;
      break;
    }
  }

  // Handle product not found
  if (!$productDetails) {
    echo "<h2>Product not found</h2>";
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
    <style>
      .form-control:active {
        
      }
    </style>
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
            <li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
            <li class="nav-item"><a href="index.php" class="nav-link text-light">Profile</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="container py-5">
      <div class="">
        <div class="align-items-center">
          <img 
            class="img-fluid rounded" 
            alt="<?php echo htmlspecialchars($productDetails['name']); ?>"
            src="<?php echo htmlspecialchars($productDetails['image']); ?>" 
            width="90px"
          >
        </div>
        <div class="col-12 col-md-6">
          <h3><?php echo htmlspecialchars($productDetails['name']); ?></h3>
          <!-- <p class="text">Category: (Category)</p> -->
          <h4 class="text-success">
            N<?php echo number_format($productDetails['priceCents'] / 100, 2); ?>
          </h4>
          <p class="mt-3"></p>
          <!-- <div class="mb-3"> -->
            <!-- <label for="form-label">Quantity</label>
            <?php //echo $productDetai']; ?> -->
          </div>
          <button class="btn btn-primary me-2" data-product-id="<?php echo $productDetails['id']; ?>">
            Add to Cart
          </button>
          <a href="products.php" class="btn btn-outline-secondary">
            Back to products
          </a>
        </div>
      </div>
    </section>
    <?php /*include("includes/footer.php");*/ ?>
  </body>
</html>