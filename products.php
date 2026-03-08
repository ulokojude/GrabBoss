<?php 
  session_start();
  include( "includes/header.php" );
 
  require( "config/db.php" );
  if(!isset($_SESSION[ "user_id" ])) {
    header( "Location: auth/login.php" );
  }
  $search = htmlspecialchars( $_GET['search'] ?? '' );
  
  if($search != ''){
    $stmt = $pdo->prepare( "SELECT * FROM products WHERE name LIKE :search OR keywords LIKE :search" );
    $stmt->execute([ ":search" => "%$search%" ]);
  } else {
    $stmt = $pdo->prepare( "SELECT * FROM products" );
    $stmt->execute();
  }
  $filteredProducts = $stmt->fetchALL(PDO::FETCH_ASSOC);
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
    <!-- <link rel="stylesheet" href="/styles/trans.css"> -->
    <style>
      .view-details-link {
        color: #0d6efd;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
      }

      .view-details-link:hover {
        color: #0a58ca;
        text-decoration: underline;
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
                alt="<?php echo htmlspecialchars($product['name']); ?>"
                src="<?php echo $product['image']; ?>">
            </div> 
            <div class="product-name limit-text-to-2-lines" style="color: #333;">
              <?php echo htmlspecialchars($product['name']); ?>
            </div>
            <div class="product-rating-container">
              <img class="product-rating-stars"
                src="images/ratings/rating-<?php echo $product['rating']['stars'] * 10; ?>.png">
              <div class="product-rating-count link-primary">
                <?php echo $product['rating']['count']; ?>
              </div>
            </div>
            <div class="product-price">
              $<?php echo number_format($product['price'], 2); ?>
            </div>
            <a class="view-details-link" href="product-details.php?id=<?php echo $product['id']; ?>">
              View details
            </a>
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
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.querySelector('#searchInput');
        const searchButton = document.querySelector( '#searchButton' );
        // Handle search button click
        searchButton.addEventListener('click', (e) => {
          e.preventDefault();
          performSearch();
        });
        // Handle enter key in search input
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
        }
      });

      $(document).ready(function(){
        // Add to cart button
        $(".js-add-to-cart-button").click(function(){
          var button = $(this);
          var productId = button.data("product-id");
          $.post("cart_add.php", {product_id: productId}, function(res){
            //show added message
            button.siblings(".added-to-cart").fadeIn().delay(1000).fadeOut();
            //update cart quantity in header
            $.get("cart_quantity.php", function(data){
              $(".js-cart-quantity").text(data);
            }, "json");
          });
          // Load cart quantity on page load
          $.get("cart_quantity.php", function(data){
            $(".js-cart-quantity").text(data);
          });
        });
      });
    </script>
  </body>
</html>




