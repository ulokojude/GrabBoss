<?php 
  session_start();
  require( "config/db.php" );
  
  if(!isset($_SESSION[ "user_id" ])) {
    header( "Location: auth/login.php" );
  }

  // Get product ID from URL hash
  $productId = $_GET[ 'id' ] ?? '';

  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$productId]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  //search for product in products array
  $productDetails = null;
  foreach($products as $product) {
    if ($product['id'] === $productId) {
      $productDetails = $product;
      break;
    }
  }

  // Handle product not found
  if (/*!$productDetails ||*/ empty($productId)) {
    header( "Location: products.php" );
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <title>Product Details | GrabBoss</title>
    <style></style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <a href="#" class="navbar-brand">GrabBoss</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="products.php" class="nav-link h6">Products</a></li>
            <li class="nav-item"><a href="cart.php" class="nav-link h6">Cart</a></li>
            <li class="nav-item"><a href="auth/logout.php" class="nav-link text-danger h6">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="container py-5">
      <div class="col-12 container">
        <div class="align-items-center mb-3">
          <img 
            class="img-fluid rounded" 
            alt="<?php echo htmlspecialchars($productDetails['name']); ?>"
            src="<?php echo htmlspecialchars($productDetails['image']); ?>" 
            width="90px"
          >
        </div>
        <div class="col-12 col-md-6">
          <h3><?php echo htmlspecialchars($productDetails['name']); ?></h3>
          <p class="text">Category:<?php htmlspecialchars($productDetails['category']); ?></p>
          <h4 class="text-success">
            N<?php echo htmlspecialchars(number_format($productDetails['priceCents'] / 10, 2)); ?>
          </h4>
          <p class="mt-3"></p>
          <div class="mb-3">
            <img class="product-rating-stars"
              src="images/ratings/rating-<?php echo $product['rating']['stars'] * 10; ?>.png">
          </div>
          <button class="btn btn-primary me-2" data-product-id="<?php echo $productDetails['id']; ?>">
            Add to Cart
          </button>
          <a href="products.php" class="btn btn-outline-secondary">
            Back to products
          </a>
        </div>

        <!-- Related products -->
        <!-- <div class="products-grid js-products-grid">
          <?php //foreach($filteredProducts as $product): ?>
            <div class="product-container">
              <div class="product-image-container">
                <img class="product-image"
                  alt="<?php //echo htmlspecialchars($product['name']); ?>"
                  src="<?php //echo $product['image']; ?>"
                >
              </div> 
              <div class="product-name limit-text-to-2-lines" style="color: #333;">
                <?php //echo htmlspecialchars($product['name']); ?>
              </div>
              <div class="product-rating-container">
                <img class="product-rating-stars"
                  src="images/ratings/rating-<?php //echo $product['rating']['stars'] * 10; ?>.png">
                <div class="product-rating-count link-primary">
                  <?php //echo $product['rating']['count']; ?>
                </div>
              </div>
              <div class="product-price">
                $<?php //echo number_format($product['price'], 2); ?>
              </div>
              <a class="view-details-link" href="product-details.php?id=<?php //echo $product['id']; ?>">
                View details
              </a>
              <div class="product-spacer"></div>
              <div class="added-to-cart">
                <img src="images/icons/checkmark.png">
                Added
              </div>
              <button 
                class="add-to-cart-button button-primary js-add-to-cart-button"
                data-product-id="<?php //echo $product['id']; ?>">
                Add to Cart
              </button>
            </div>
          <?php //endforeach; ?>
        </div> -->

        </div>
      </div>
    </section>
    <?php /*include("includes/footer.php");*/ ?>
  </body>
</html>