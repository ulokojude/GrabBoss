<?php 
  session_start();
  include("../config/db.php");
  // if (!isset($_SESSION["user_id"])) {
  //   header("Location: login.php");
  //   exit();
  // }

  require '../vendor/autoload.php';
  use PHPMailer\PHPMailer\PHPMailer;
  include '../config/db.php';

  $message = "";
  $mess = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['email'])) {
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      // check if user exists
      $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
      if(mysqli_num_rows($check) == 0) {
        die("Email not found");
      }
      // Generate OTP
      $otp = rand(100000, 999999);
      $expire = date("Y-m-d H:i:s", strtotime("+10 munutes"));

      // Store OTP in database
      mysqli_query($conn, "UPDATE users SET otp='$otp', otp_expire='$expire' WHERE email='$email'");

      // Send Email
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = "smtp.gmail.com";
      $mail->SMTPAuth = true;
      $mail->Username = "your-email@gmail.com"; // Replace with your Gmail address
      $mail->Password = "your-app-password"; // Replace with your Gmail app password
      $mail->SMTPSecure = 'tls';
      $mail->Port =587;

      $mail->setFrom("your-email@gmail.com", "GrabBoss");
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = " Password Reset OTP";
      $mail->Body = "Your OTP for password reset is: <b>$otp</b>. It expires in 10 minutes.";
      $mail->send();

      $message = "OTP sent to your email";
      header("Refresh: 5; URL=forgot-password.php");
      $message = "<div class='alert alert-success'>OTP sent to your email.</div>";
      header("Refresh: 5; URL=forgot-password.php");
      $message = "<input class='form-control' type='text' name='otp' placeholder='Enter OTP'>";
    }
 
  //   $email = trim($_POST["email"]);
  //   if (empty($email)) {
  //     $message = "Please enter your email";
  //     $mess = "alert-danger";
  //   } else {
  //     $query = "SELECT id FROM users WHERE email='$email' LIMIT 1";
  //     $result = mysqli_query($conn, $query);
  //     if(mysqli_num_rows($result) == 1) {
  //       $_SESSION["reset_email"] = $email;
  //       header("Location: reset-password.php");
  //       exit();
  //     } else {
  //       $message = "Email not found";
  //       $mess = "alert-danger";
  //     }
  //   }
  }

  // make querry and necesities PDO

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
      crossorigin="anonymous">
    <title>Forgot Password | GrabBoss</title>
  </head>
  <body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow w-100" style="max-width: 400px;">
        <h4 class="text-center mb-4">GrabBoss</h4>
        <div class="alert alert <?php echo $mess; ?>">
          <?php echo $message; ?>
        </div>
        <form action="forgot-password.php" method="POST">
          <div class="mb-3">
            <label for="" class="form-label">Registered Email</label>
            <input type="text" name="email" class="form-control" placeholder="example@server.com" required>
          </div>
          <div class="mb-3">
            <button class="btn btn-warning w-100">Verify Email</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>