<?php 
  session_start();
  require ("config/db.php");

  if (!isset($_SESSION['user_id'])) exit;

  $user_id = $_SESSION['user_id'];
  $product_id = $_POST['product_id'] ?? 0;

  //include product array to get price
  include("data/products.php");

  $price = 0;
  foreach ($products as $product) {
    if ($product['id'] == $product_id) {
      $price = $product['priceCents'];
      break;
    }
  }

  if ($price == 0) exit;

  // check if product already in cart
  $stmt = $pdo->prepare( "SELECT * FROM orders WHERE user_id = ? AND product_id = ?" );
  $stmt->execute([$user_id, $product_id]);

  if (mysqli_num_rows($res) > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $newQty = $row[ 'quantity' ] + 1;
    $newTotal = $price * $newQty;

    $update = $pdo->prepare( "UPDATE orders SET quantity= ?, total_price= ? WHERE id= ?" );
    $update->execute([$newQty, $newTotal, $row['id']]);
  } else {
    $insert = $pdo->prepare( "INSERT INTO orders (user_id, product_id, quantity, price, total_price) 
      VALUES (?, ?, 1, ?, ?)" );
    $insert->execute([$user_id, $product_id, $price, $price]);
  }
  
  echo json_encode([ 'success'=>true]);
?>