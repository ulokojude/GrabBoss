<?php 
  session_start();
  include("../config/db.php");
  require '../vendor/autoload.php';
  use PHPMailer\PHPMailer\PHPMailer; 
  $message = "";
  $mess = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    $row = mysqli_fetch_assoc($check);
    if (!$row) {
      $message = "Email not found";
      $mess = "alert-danger";
    } else {
      $otp = random_int(100000, 999999);
      $expire = date("Y-m-d H:i:s", strtotime("+10 minutes"));
      mysqli_query($conn, "UPDATE users SET otp_code='$otp', otp_expire='$expire' WHERE email='$email'");

      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = "smtp.gmail.com";
      $mail->SMTPAuth = true;
      $mail->Username = "myadonaitech@gm**.com";
      $mail->Password = "your-app-password";
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom("your-email@gmail.com", "GrabBoss");
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = "GrabBoss Password Reset OTP";
      $mail->Body = "Your OTP is: <b>$otp</b><br>This expires in 10 minutes.";
      $mail->AltBody = "Your OTP is: $otp This expires in 10 minutes.";
      $mail->send();
      $_SESSION['reset_email'] = $email;
      header("Location: verify-otp.php");
      exit();
    }
  }

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