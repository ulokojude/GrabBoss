<?php 
  session_start();
  require( "config/db.php" );
  
  include( "auth/root_auth_chk.php" );

  // Get product ID from URL hash
  $productId = $_GET[ 'id' ] ?? '';

  //search for product in products array
  $productDetails = null;
  foreach($products as $product) {
    if ($product['id'] === $productId) {
      $productDetails = $product;
      break;
    }
  }

  // Handle product not found
  if (!$productDetails || empty($productId)) {
    header( "Location: products.php" );
    exit();
  }
?>