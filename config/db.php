<?php
  $host = "localhost";
  $db_name = "grabboss";
  $usr = "root";
  $pw = "";

  try {
    $pdo = new PDO( "mysql:host=$host;dbname=$db_name;charset=utf8", $usr, $pw );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    die("Database connection failed: ".$e->getMessage());
  }
  
?>

