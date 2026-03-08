<?php
  $host = "localhost";
  $dbname = "grabboss";
  $username = "root";
  $password = "";

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // ENABLE ERROR MODE
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    die("Database connection failed: ".$e->getMessage());
  }
  
?>

