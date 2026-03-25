<?php 
  session_start();
  require_once( "config/db.php" );
  
  if(!isset($_SESSION[ "user_id" ])) {
    header( "Location: auth/login.php" );
  }

  // Get product ID from URL hash
  $productId = $_GET[ 'id' ] ?? '';

  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$productId]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  // Handle product not found
  if (empty($productId)) {
    header( "Location: products.php" );
    exit();
  }

  $keywords = $product['keywords'];

  $stmt = $pdo->prepare("
    SELECT * FROM products
    WHERE keywords LIKE :keywords
    AND id != :id
    LIMIT 4
  ");

  $stmt->execute([
    ':keywords' => "%$keywords%",
    ':id' => $productId
  ]);

  $relatedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['productId'];

    // Initialise cart if not exist
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    // if product in cart, increase quantity
    if (isset($_SESSION['cart'][$productId])) {
      $_SESSION['cart'][$productId]++;
    } else {
      $_SESSION['cart'][$productId] = 1;
    }
    echo "<script>alert('product added to cart');</script>";
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
            alt="<?php echo htmlspecialchars($product['name']); ?>"
            src="../GrabBoss_admin/<?php echo htmlspecialchars($product['image']); ?>" 
            width="90px"
          >
        </div>
        <div class="col-12 col-md-6">
          <h3><?php echo htmlspecialchars($product['name']); ?></h3>
          <p class="text">Category:<?php htmlspecialchars($product['category']); ?></p>
          <h4 class="text-success">
            N<?php echo htmlspecialchars(number_format($product['price'] / 10, 2)); ?>
          </h4>
          <p class="mt-3"></p>
          <div class="mb-3">
            <img class="product-rating-stars"
              src="images/ratings/rating-<?php echo $product['rating'] * 10; ?>.png">
          </div>
          <div class="d-flex g-2">
            <form method="POST">
              <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
              <button class="btn btn-primary me-2" type="submit">
                Add to Cart
              </button>
            </form>
            <a href="products.php" class="btn btn-outline-secondary">
              Back to products
            </a>
          </div>
        </div>

        <?php 
          if (count($relatedProducts) > 0) {
            $sentence = "Related Products";
          } else {
            $sentence = "";
          }
        ?>

        <!-- Related products -->
        <h4 class="mt-5 mb-3"><?php echo $sentence; ?></h4>

        <div class="row">
          <?php foreach ($relatedProducts as $item): ?>
            <div class="col-6 col-md-4 col-lg-3 mb-3">
              <div class="card h-100 shadow-sm">
                <img src="<?php echo $item['image']; ?>"
                  class="card-img-top"
                  style="height:180px; object-fit:cover;" 
                >
                <div class="card-body d-flex flex-column">
                  <h6 class="card-title">
                    <?php echo htmlspecialchars($item['name']); ?>
                  </h6>
                  <p class="text-primary fw-bold">
                    N<?php echo number_format($item['price']); ?>
                  </p>
                  <a href="product-details.php?id=<?php echo $item['id']; ?>"
                    class="btn btn-sm btn-outline-primary mt-auto"> View Details
                  </a>
                </div>

              </div>
            </div>
          <?php endforeach; ?>
        </div>

        </div>
      </div>
    </section>
    <?php /*include("includes/footer.php");*/ ?>
  </body>
</html>