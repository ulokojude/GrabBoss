<?php 
  session_start();
  require("config/db.php");

  $user_id = $_SESSION['user_id'] ?? 0;
  $res = mysqli_query($conn, "SELECT SUM(quantity) AS qty FROM orders WHERE user_id=$user_id");
  $row = mysqli_fetch_assoc($res);
  echo $row['qty'] ?? 0;
?>