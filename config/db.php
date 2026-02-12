<?php
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = "ecommerce_db";
  $conn = mysqli_connect($host, $user, $pass, $db);
  if (!$conn) {
    die("Database connection failed");
  }
?>