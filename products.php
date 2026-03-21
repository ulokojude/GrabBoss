<?php include "auth/scripts/products_script.php"; ?>

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
    <!-- <link rel="stylesheet" href="/styles/trans.css" -->

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
        <?php include "auth/scripts/products_catalogue.php"; ?>

      </div>
    </div>
    <?php //include("includes/footer.php"); ?>
    <script src="auth/scripts/products.js"></script>
  </body>
</html>




