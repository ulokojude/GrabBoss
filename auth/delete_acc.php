<?php 
  session_start();
  require '../config/db.php';
  $message = "";
  $mess = "";
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }
  $user_id = $_SESSION['user_id'];
  if ($_SERVER ["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    // Fetch user's hashed password from the database
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stm->fetch(PDO::FETCH_ASSOC);
    if($user) {
      if(password_verify($password, $user['password'])){
        //Delete account
        $del = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $del->execute([$user_id]);
        session_destroy();
        header("Location: login.php");
        exit();
      } else {
        $message = "Incorrect password";
        $mess = "alert-danger";
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="httpS://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/generals.css" >
    <title>Delete Account | GrabBoss</title>
  </head>
  <body class="bg-light">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
      <div class="row w-100 justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
          <div class="card- p-4 shadow">
            <h5 class="text-danger text-center mb-3">Delete Account</h5>
            <div class="alert <?php echo $mess; ?>">
              <?php echo $message; ?>
            </div>
            <form action="delete_acc.php" method="POST">
              <div class="mb-3">
                <label for="" class="form-label">
                  For your security verify password
                </label>
                <input type="password" placeholder="Enter your account password" class="form-control" name="password" required>
              </div>
              <button class="btn btn-danger w-100">
                Permanently Delete Account
              </button>
              <div class="text-center mt-3">
                <a href="#">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>