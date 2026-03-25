<?php 
  session_start();
  require("config/db.php");
  if(!isset($_SESSION[ 'user_id' ])) exit;
  $user_id = $_SESSION['user_id'];
  
  $action = $_POST[ 'action' ] ?? '';
  $order_id = $_POST['order_id'] ?? 0;

if ($_POST['action'] == 'remove') {
  unset($_SESSION['cart'][$_POST['product_id']]);
}

if ($_POST['action'] == 'update') {
  $_SESSION['cart'][$_POST['product_id']] = $_POST['quantity'];
}
?>