<?php 
  session_start();
  include("../data/products.php");
  require("../config/db.php");

  if(!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
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
            <div class="row mb-4">
              <div class="col-12 col-md-6 mb-3">
                <label for="" class="form-label">Full Name</label>
                <input type="text" class="form-control" value="Jude Uloko">
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="" class="form-label">Email Adress</label>
                <input type="email" class="form-control" value="jude@example.com" disabled>
              </div>

              <!-- <div class="col-12">
                <label for="" class="form-label fw-semibold">About You</label>
                <textarea name="" class="form-control" rows="3" id="">
                  Lorem ipsum dolor sit amet consectetur 
                  adipisicing elit. Ea, iure! Sunt ullam 
                  tempora earum cupiditate repellat officia 
                  delectus, aperiam explicabo libero 
                  asperiores et cum quaerat laboriosam 
                  commodi? Laborum, explicabo eaque.
                </textarea>
              </div> -->
            </div>

            <button class="btn btn-primary mb-4">Save Changes</button>
          </div>
          <hr>
          <!-- Password Reset -->
          <h5 class="mt-4 mb-3">Change password</h5>

          <form action="" method="post">
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