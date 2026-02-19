<?php 
  session_start();
  include("../data/products.php");
  require("../config/db.php");

  if(!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
  }

  $message = "";
  $mess = "";

  // recieve the new info and update the database
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $user_id = $_SESSION["user_id"];

    $sql = "UPDATE users SET name = ?, password = ?, email = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, password_hash($password, PASSWORD_DEFAULT), $email, $user_id);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) > 0) {
      $_SESSION["user_name"] = $name;
      $message = "Profile updated successfully";
      $mess = "alert-success";
      header("refresh:2; url=settings.php");
      header("Location: settings.php");
      exit();
    } else {
      $message = "Error updating profile";
      $mess = "alert-danger";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/instyle.css">
    <title>My Account | GrabBoss</title>
  </head>
  <body>
    <div class="container py-4">
      <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-12 col-md-4 col-lg-3">
          <div class="account-sidebar p-3">
            <h6 class="mb-3 fw-bold">My Account</h6>
            <nav class="nav flex-column">
              <a href="../index.php" class="nav-link">Orders</a>
              <a href="../products.php" class="nav-link">Return to Catalogue</a>
              <a href="#" class="nav-link active">Settings</a>
              <a href="../auth/logout.php" class="nav-link text-danger">Logout</a>
            </nav>
          </div>
        </div>

        <div class="col-12 col-md-8 col-lg-9">
          <div class="account-card p-4">
            <!-- profile header -->
            <div class="profile-header">
              <h4 class="mb-1">Account Overview</h4>
              <small class="text-muted">Manage your personal information</small>
            </div>
            <!-- User Info -->
            <form action="settings.php" method="POST">
              <div class="row mb-4">
                <div class="col-12 col-md-6 mb-3">
                  <label for="" class="form-label">Full Name</label>
                  <input type="text" name="name" class="form-control" value="<?php echo $_SESSION["user_name"]; ?>" required>
                </div>

                <div class="col-12 col-md-6 mb-3">
                  <label for="" class="form-label">Email Adress</label>
                  <input type="email" class="form-control" value="<?php echo $_SESSION["email"]; ?>" disabled>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-12 col-md-6 mb-3">
                  <button class="btn btn-primary mb-4">Save Changes</button>
                </div>

                <div class="col-12 col-md-6 mb-3"> 
                  <div class="alert <?php echo $mess; ?>" role="alert">
                    <?php echo $message; ?>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <hr>
          <!-- Password Reset -->
          <h5 class="mt-4 mb-3">Change password</h5>

          <form action="settings.php" method="POST">
            <div class="row">
              <div class="col-12 col-md-4 mb-3">
                <label for="" class="form-label">Current Password</label>
                <input type="password" class="form-control" placeholder="Current Password">
              </div>

              <div class="col-12 col-md-4 mb-3">
                <label for="" class="form-label">New Password</label>
                <input type="password" class="form-control" placeholder="New password">
              </div>

            </div>
            <button type="submit" class="btn btn-dark">Update Profile</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>