<?php 
  session_start();
  include( "includes/header.php" );
  require( "config/db.php" );
  require( "in/rate_star.php" );
  
  include( "auth/root_auth_chk.php" );

  $search = isset($_GET['search']) ? trim($_GET['search']) : '';

  if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT DISTINCT p.* 
        FROM products p
        LEFT JOIN product_keywords pk ON p.id = pk.product_id
        LEFT JOIN keywords k ON pk.keyword_id = k.id
        WHERE
          p.name LIKE :search
          OR k.keyword LIKE :search
        ORDER BY p.id DESC
    ");

    $stmt->execute([
      'search' => "%$search%"
    ]);
  } else {
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
  }

  $filteredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>