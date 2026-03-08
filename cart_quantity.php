<?php 
  session_start();
  require( "config/db.php" );

  $user_id = $_SESSION[ 'user_id' ] ?? 0;
  $stmt = $pdo->prepare( "SELECT SUM(quantity) AS qty FROM orders WHERE user_id = ?" );
  $stmt->execute([$user_id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  echo $row[ 'qty' ] ?? 0;
?>