<?php 
  session_start();
  require("config/db.php");
  if(!isset($_SESSION[ 'user_id' ])) exit;
  $user_id = $_SESSION['user_id'];
  
  $action = $_POST[ 'action' ] ?? '';
  $order_id = $_POST['order_id'] ?? 0;

  if($action == 'remove' ){
    $stmt = $pdo->prepare( "DELETE FROM orders WHERE id = ? AND user_id = ?" );
    $stmt->execute([$order_id, $user_id]);
  }

  if($action == 'update'){
    $quantity = $_POST[ 'quantity' ] ?? 1;
    $stmt = $pdo->prepare( "SELECT price FROM orders WHERE id = ? AND user_id = ?" );
    $stmt->execute([$order_id, $user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $price = $row[ 'price' ] ?? 0;
    $total = $price * $quantity;
    $update = $pdo->prepare( "UPDATE orders SET quantity= ?, total_price= ? WHERE id= ? AND user_id= ?" );
    $update->execute([$quantity, $total, $order_id, $user_id]);
  }
?>