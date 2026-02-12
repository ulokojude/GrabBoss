<?php 
  session_start();
  if(!isses($_SESSION["user_id"])) {
    header("Location: /ecommerce/auth/login.php");
    exit();
  }
?>