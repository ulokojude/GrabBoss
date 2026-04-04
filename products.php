<?php 
  session_start();
  include( "includes/header.php" );
  require( "config/db.php" );
  require( "in/rate_star.php" );
  
  include( "auth/root_auth_chk.php" );

  $search = isset($_GET['search']) ? trim($_GET['search']) : '';
  
  if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT DISTINCT p.* 
        FROM products p
        LEFT JOIN product_keywords pk ON p.id = pk.product_id
        LEFT JOIN keywords k ON pk.keyword_id = k.id
        WHERE
          p.name LIKE :search
          OR k.keyword LIKE :search
        ORDER BY p.id DESC
    ");

    $stmt->execute([
      'search' => "%$search%"
    ]);
  } else {
    $stmt = $pdo->prepare( "SELECT * FROM products ORDER BY id DESC" );
    $stmt->execute();
  }

  $filteredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
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
    header("Location: products.php");
    exit;
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
    
    <link rel="icon" type="image/png" href="images/icons/fab.png">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/grabboss-header.css">
    <link rel="stylesheet" href="styles/grabboss.css">
    <link rel="stylesheet" href="styles/products.css">
    <style>
      .btn {
        display: inline-block;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        border-radius: 0.25rem;
        transition: all 0.15s ease-in-out;
      }

      .btn-primary {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
      }

      .btn-primary:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.5);
      }

      .pr {
        margin-right: 1rem !important;
        margin-top: 0.5rem !important;
        margin-bottom: 1rem !important;
        font-weight: 700 !important;
        color: #0d6efd !important;
      }
    </style>
  </head>
  <body>
    <div class="amazon-header">
      <div class="amazon-header-left-section">
        <a href="#" class="header-link">
          <!-- <h4 style="color: white; ">
            <u>GrabBoss</u>
          </h4> -->
          <img src="images/icons/logo.png" width="50px" alt="web logo">
        </a>
      </div>
      <div class="amazon-header-middle-section">
        <input class="search-bar" type="text" name="search" 
          placeholder="Search" id="searchInput"
          value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
        >
        <button class="search-button" id="searchButton">
          <img class="search-icon" alt="Search" src="images/icons/search-icon.png">
        </button>
      </div>
      <div class="amazon-header-right-section">
        <?php $count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
        <a class="cart-link header-link" href="cart.php">
          <img class="cart-icon" src="images/icons/cart-icon.png">
          <div class="cart-quantity js-cart-quantity"><?php echo $count; ?></div>
          <div class="cart-text">Cart</div>
        </a>
      </div>
    </div>
    <div class="main">

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-danger text-center">
          Order Placed Successfully!
        </div>
      <?php endif; ?>
      
      <div class="products-grid js-products-grid">
        <!-- catalogues goes here.. -->
        <?php foreach($filteredProducts as $product): ?>
          <div class="product-container">
            <div class="product-image-container">
              <img class="product-image"
                alt="<?php echo htmlspecialchars($product['name']); ?>"
                src="../GrabBoss_admin/<?php echo $product['image']; ?>"
              >
            </div> 
            <div style="font-weight:bolder; color:#0d6efd" class="product-name limit-text-to-2-lines" style="color: #333;">
              <?php echo htmlspecialchars($product['name']); ?>
            </div>
            <div class="product-rating-container">
              <a href="#">
                <img class="product-rating-stars"
                  src="images/ratings/rating-<?php echo $product['rating'] * 10; ?>.png"
                >
              </a>
              <div class="product-rating-count link-primary">
                <?php echo $product['rating']; ?>
              </div>
            </div>

            <p class=" pr">
              &#8358; <?php echo number_format($product['price']); ?>
            </p>

           <form method="POST" action="products.php">
              <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
              <button class="btn btn-primary" name="add_to_cart" type="submit">
                Add to Cart
              </button>
            </form>
          </div>
        <?php endforeach; ?>

      </div>
    </div>
    <?php //include("includes/footer.php"); ?>
    <script src="auth/scripts/products.js"></script>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.querySelector('#searchInput');
        const searchButton = document.querySelector( '#searchButton' );
        // Handle search button click
        searchButton.addEventListener('click', (e) => {
          e.preventDefault();
          performSearch();
        });
        // Handle enter key in search_input
        searchInput.addEventListener('keypress', (e) => {
          if (e.key === 'Enter') {
            e.preventDefault();
            performSearch();
          }
        });
    
        function performSearch() {
          const query = searchInput.value.trim();
          if (query) {
            window.location.href = `products.php?search=${ encodeURIComponent(query) }`;
          } else {
            window.location.href = 'products.php';
          }
          //performSearch();
        }
      });
    </script>
  </body>
</html>




