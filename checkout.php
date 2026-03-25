<?php 
  session_start();
  include( "includes/header.php" );
  include( "auth/root_auth_chk.php" );

  $email = '';
  $card_num = '';
  $cvc = '';

  $btn_wrt = 'Complete Purchase';

  $total_price = $_SESSION['subtotal'] ?? 0;

  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST["email"];
    if (!empty($email)) {
      $message = "Complete Purchase";
      $mess = "btn-sucess"; 
      header("Location: order_sub.php");
      exit;
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" >
    <title>Checkout | GrabBoss</title>
    <style>
      .form-label {
        margin-bottom: 0.20rem;
      }

      .form-control:focus {
        box-shadow: none;
        border-color: skyblue;
      }
    </style>
  </head>
  <body>
    <div class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="card p-4 shadow-lg w-100" style="max-width: 400px;"> 
        <form action="checkout.php" method="POST">
          <h4 class="text-center mb-3">GrabBoss</h4>
          <?php $message = ''; ?>
          
          <div class="text-center text-muted mb-4">
            <?php echo $total_price; ?>
          </div>
          <?php if (!empty($message)): ?>
            <div class="alert <?php echo $mess; ?>">
              <?php echo $message ?>
            </div>
          <?php endif; ?>
          <div class="mb-3">
            <label for="" class="form-label text-muted">Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" required>
          </div>
          <div class="mb-3 card p-3">
            <div class="mb-3">
              <label for="cn" class="form-label text-muted">Card number</label>
              <input type="text"
                id="cn"
                name="card_num"
                value="<?php echo $card_num; ?>"
                class="form-control"
                inputmode="numeric" 
                maxlength="22"
                placeholder="1234 1234 1234 1234" id="cn"
              >
            </div>
            
            
            <div class="d-flex mb-3 gap-2 justify-content-between">
              <div>
                <label for="ed" class="form-label text-muted">Expiration date</label>
                <input type="text" name="expiry_date" id="ed" value="<?php ?>" class="form-control" maxlength="7" placeholder="MM / YY">
              </div>
              <div>
                <label for="ed" class="form-label text-muted">Security code</label>
                <input type="text" name="cvc" id="cvc" value="<?php ?>" maxlength="3" inputmode="numeric" placeholder="CVC" class="form-control">
              </div>
            </div>
          </div>
          
          <div class="mb-3">
            <!-- <button class="btn btn-secondary w-50 m-2">Cancle</button> -->
            <button class="btn btn-danger w-100 m-2" type="submit"><?php echo $btn_wrt; ?></button>
          </div>
          
        </form>
      </div>
    </div>
    <script>
      document.getElementById('cn').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4 && value.length <= 8) {
          value = value.slice(0, 4) + '  ' + value.slice(4);
        } else if (value.length > 8 && value.length <= 12) {
          value = value.slice(0, 4) + '  ' + value.slice(4, 8) + ' ' + value.slice(8);
        } else if (value.length > 12) {
          value = value.slice(0, 4) + '  ' + value.slice(4, 8) + '  ' + value.slice(8, 12) + '  ' + value.slice(12);
        }
        e.target.value = value;
      });

      document.getElementById('ed').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length === 1 && parseInt(value) > 1) {
          value = '0' + value;
        }
        if (value.length > 2 && value.length <= 4) {
          let month = parseInt(value.slice(0, 2));
          if (month > 12) value = '12' + value.slice(2);
          value = value.slice(0, 2) + ' / ' + value.slice(2);
        }
        e.target.value = value;
      });

      document.getElementById('cvc').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
      });

    </script>
  </body>
</html>

