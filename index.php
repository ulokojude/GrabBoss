<?php 
  session_start();
  require_once "config/db.php";

  if(!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
  }

  $user_id = $_SESSION["user_id"];
   
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>
    
  </body>
</html>