<?php 
  session_start();
  if(!isset($_SESSION["user_id"])) {
    header("Location: /GrbBoss/auth/login.php");
    exit();
  }
?>