<?php 
  session_start();
  include( "includes/header.php" );
  require( "config/db.php" );
  require( "in/rate_star.php" );
  
  include( "auth/root_auth_chk.php" );

  $search = htmlspecialchars( $_POST[ 'search' ] ?? '' );
  if(isset($search)){
    $stmt = $pdo->prepare( "SELECT * FROM products WHERE name LIKE :search OR keywords LIKE :search" );
    $stmt->execute([ ":search" => "%$search%" ]);
  } else {
    $stmt = $pdo->prepare( "SELECT * FROM products" );
    $stmt->execute();
  }
  $filteredProducts = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>