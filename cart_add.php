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
  $res = mysqli_query($conn, "SELECT * FROM orders WHERE user_id=$user_id AND product_id=$product_id");

  if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $newQty = $row['quantity'] + 1;
    $newTotal = $price * $newQty;
    mysqli_query($conn, "UPDATE orders SET quantity=$newQty, total_price=$newTotal WHERE id=".$row['id']);
  } else {
    mysqli_query($conn, "INSERT INTO orders (user_id, product_id, quantity, price, total_price) 
      VALUES ($user_id, $product_id, 1, $price, $price)");
  }

  echo json_encode(['success'=>true]);
?>