<?php
  session_start();
  require( "config/db.php" );
  require( "data/products.php" );

  include( "auth/root_auth_chk.php" );

  $user_id = $_SESSION['user_id'];
  $orders = $pdo->prepare( "SELECT * FROM orders WHERE user_id = ?" );
  $orders->execute([$user_id]);
  $subtotal = 0;
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <title>Cart | GrabBoss</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <a href="index.php" class="navbar-brand">GrabBoss</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href=" products.php " class=" nav-link h6 ">Products</a></li>
            <li class="nav-item"><a href="cart.php" class=" nav-link text-light h6 ">Cart</a></li>
            <li class="nav-item"><a href=" auth/logout.php " class=" nav-link text-danger h6 ">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="container py-5">
      <h3 class="mb-4">Shopping Cart</h3>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <th>Product</th>
            <th>Price</th>
            <th width="120">Quantity</th>
            <th>Total</th>
            <th></th>
          </thead>
          <tbody>
            <?php 
              if($orders > 0) {
                foreach($orders as $row) {
                  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                  $stmt->execute([$row['product_id']]);
                  $product = $stmt->fetch(PDO::FETCH_ASSOC);
                  if(!$product) continue;
                  $subtotal += $row['total_price'];
                  ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <img src="<?php echo $product['images'] ?>"
                          width="50px" class="rounded me-2 shadow"
                          alt="<?php echo $product['name']; ?>"
                        >
                        <span><?php echo $product["name"]; ?></span>
                      </div>
                    </td>
                    <td>N<?php echo number_format($row['price']); ?></td>
                    <td>
                      <input type="number" class="form-control quantity-input" 
                        value="<?php echo $row['quantity']; ?>"
                        data-order-id="<?php echo $row['id']; ?>"
                      >
                    </td>
                    <td>
                      N<?php echo number_format($row['total_price']); ?>
                    </td>
                    <td>
                      <button class="btn btn-sm btn-danger remove-btn" data-order-id="<?php echo $row['id']; ?>">
                        Remove
                      </button>
                    </td>
                  </tr>
                  <?php
                }
              } else {
                  echo '<tr><td colspan="5" class="text-center text-muted py-3">Your cart is empty</td></tr>';
              }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <div class="row justify-content-center p-4 mt-4">
      <div class="col-12 col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>Cart Summary</h5>
          <hr>
          <p class="d-flex justify-content-between">
            <span>Subtotal</span>
            <strong>N<?php echo number_format($subtotal); ?></strong>
          </p>
          <p class="d-flex justify-content-between">
            <span>Delivery</span>
            <strong>N0</strong>
          </p>
          <p class="d-flex justify-content-between fs-5">
            <span>Total</span>
            <strong>N<?php echo number_format($subtotal); ?></strong>
          </p>
          <a class="btn btn-success w-100 mt-2 check_out_pro">
            Proceed To Checkout
          </a>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        //remove item
        $(".remove-btn").click(function(){
          var orderId = $(this).data("order-id");
          if(confirm("Remove this item from cart?")){
            $.post("cart_action.php",{action:"remove", order_id:orderId}, function(){
              location.reload();
            });
          }
        });

        // Upload quantity
        $(".quantity-input").change(function(){
          var orderId = $(this).data("order-id");
          var qty = $(this).val();
          if(qty < 1) qty = 1;
          $.post("cart_action.php", {action:"update", order_id:orderId, quantity:qty}, function(){
            location.reload();
          });
        });
      });
    </script>
    <?php //include "includes/footer.php"; ?>
  </body>
</html>