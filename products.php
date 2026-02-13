<?php 
  session_start();
  include("includes/header.php");
  include("data/products.php");
  require("config/db.php");
  if(!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
  }
  $search = htmlspecialchars($_GET['search'] ?? '');
  // filter products if search term exists
  if ($search !== "") {
    foreach($products as $product) {
      if (stripos($product['name'], $search) !== false) {
        $filteredProducts[] = $product;
      }
    }
  } else {
    /// No search term show all products
    $filteredProducts = $products;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Grabboss | Catalog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"> -->
    <link rel="icon" type="image/png" href="images/icons/fab.png">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/grabboss-header.css">
    <link rel="stylesheet" href="styles/grabboss.css">
    <!-- <link rel="stylesheet" href="/styles/trans.css"> -->
    <style>
      .search-bar {
        
      }
    </style>
  </head>
  <body>
    <div class="amazon-header">
      <div class="amazon-header-left-section">
        <a href="index.php" class="header-link">
          <!-- <h4 style="color: white; ">
            <u>GrabBoss</u>
          </h4> -->
          <img src="images/icons/logo.png" width="50px" alt="web logo">
        </a>
      </div>
      <div class="amazon-header-middle-section">
        <form action="products.php" method="GET" class="search-form"></form>
          <input class="search-bar" type="text" name="search" placeholder="Search"
            value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
          >
          <button class="search-button">
            <img class="search-icon" src="images/icons/search-icon.png">
          </button>
        <!-- </form> -->
      </div>
      <div class="amazon-header-right-section">
        <a class="orders-link header-link" href="orders.html">
          <span class="returns-text">Returns</span>
          <span class="orders-text">& Orders</span>
        </a>
        <a class="cart-link header-link" href="cart.php">
          <img class="cart-icon" src="images/icons/cart-icon.png">
          <div class="cart-quantity js-cart-quantity">0</div>
          <div class="cart-text">Cart</div>
        </a>
      </div>
    </div>
    <div class="main">
      <div class="products-grid js-products-grid">
        <!-- catalogues goes here.. -->
        <?php foreach($filteredProducts as $product): ?>
          <div class="product-container">
            <div class="product-image-container">
              <img class="product-image"
                src="<?php echo $product['image']; ?>">
            </div> 
            <div class="product-name limit-text-to-2-lines">
              <?php echo $product['name']; ?>
            </div>
            <div class="product-rating-container">
              <img class="product-rating-stars"
                src="images/ratings/rating-<?php echo $product['rating']['stars'] * 10; ?>.png">
              <div class="product-rating-count link-primary">
                <?php echo $product['rating']['count']; ?>
              </div>
            </div>
            <div class="product-price">
              $<?php echo number_format($product['priceCents'] / 100, 2); ?>
            </div>
            <label>
              <a href="product-details.php">View details</a>
            </label>
            <div class="product-spacer"></div>
            <div class="added-to-cart">
              <img src="images/icons/checkmark.png">
              Added
            </div>
            <button 
              class="add-to-cart-button button-primary js-add-to-cart-button"
              data-product-id="<?php echo $product['id']; ?>">
              Add to Cart
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php include("includes/footer.php"); ?>
    <script type="module" src="/scripts/amazon.js"></script>
  </body>
</html>




