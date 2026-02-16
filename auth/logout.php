<?php 
  session_start();
  array();
  session_destroy();
  header("Location: login.php");
  exit();
?>