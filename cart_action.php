<?php 
  session_start();
  require("config/db.php");
  if(!isset($_SESSION['user_id'])) exit;
  $user_id = $_SESSION['user_id'];
  
  $action = $_POST['action'] ?? '';
  $order_id = $_POST['order_id'] ?? 0;

  if($action == 'remove'){
    mysqli_query($conn, "DELETE FROM orders WHERE id=$order_id AND user_id=$user_id");
  }

  if($action == 'update'){
    $quantity = $_POST['quantity'] ?? 1;
    $res = mysqli_query($conn, "SELECT price FROM orders WHERE id=$order_id AND user_id=$user_id");
    $row = mysqli_fetch_assoc($res);
    $price = $row['price'] ?? 0;
    $total = $price * $quantity;
    mysqli_query($conn, "UPDATE orders SET quantity=$quantity, total_price=$total WHERE id=$order_id AND user_id=$user_id");
  }
?>