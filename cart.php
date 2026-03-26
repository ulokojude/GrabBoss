<?php
  session_start();
  require("config/db.php");
  include("auth/root_auth_chk.php");

  $user_id = $_SESSION['user_id'];
  $cart = $_SESSION['cart'] ?? [];

  if (!empty($cart)) {
    $ids = implode(',', array_keys($cart));
    $stmt = $pdo->query( "SELECT * FROM products WHERE id IN ($ids)" );
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  //$quantity = $cart[$product['id']];
  // $total = $product['price'] * $quantity;
  $user_id = $_SESSION['user_id'];

  // ✅ Define cart
  $cart = $_SESSION['cart'] ?? [];
  $products = [];
  $subtotal = 0;

  if (!empty($cart)) {
    $ids = implode(',', array_keys($cart));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <title>Cart | GrabBoss</title>

    <style>
      .form-control:focus {
        box-shadow: none;
        border-color: skyblue;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <!-- Brand -->
      <a href="#" class="navbar-brand fw-bold">
        Cart
      </a>

      <!-- Mobile toggle Button -->
      <button
        class="navbar-toggler" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarMenu"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- nAVBAR LINK -->
      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href=" products.php " class=" nav-link h6 ">Products</a></li>
            <li class="nav-item"><a href="cart.php" class=" nav-link text-light h6 ">Cart</a></li>
            <li class="nav-item"><a href=" auth/logout.php " class=" nav-link text-danger h6 ">Logout</a></li>

        </ul>
      </div>
    </div>
  </nav>
  <style>
    body {
      padding-top: 56px;
    }
  </style>

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
            <?php foreach ($products as $product): 
              $quantity = $cart[$product['id']];
              $total = $product['price'] * $quantity;
              $subtotal += $total;
            ?>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <img src="../GrabBoss_admin/<?php echo $product['image']; ?>"
                    width="50" class="rounded me-2 shadow"
                    alt="<?php echo $product['name']; ?>"
                  >
                  <span><?php echo $product["name"]; ?></span>
                </div>
              </td>

              <td>₦<?php echo number_format($product['price']); ?></td>

              <td>
                <input type="number" class="form-control quantity-input" 
                  value="<?php echo $quantity; ?>"
                  data-id="<?php echo $product['id']; ?>"
                  min="1" readonly
                >
              </td>
              <td>₦<?php echo number_format($total); ?></td>
              <td>
                <button class="btn btn-sm btn-danger remove-btn" 
                  data-id="<?php echo $product['id']; ?>">
                  Remove
                </button>
              </td>
            </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
    <?php $count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
    <div class="row justify-content-center p-4 mt-4">
      <div class="col-12 col-md-4">
        <div class="card p-3 shadow-sm">
          <h5>Cart Summary</h5>
          <hr>
          <p class="d-flex justify-content-between">
            <span>Total Products</span>
            <strong><?php echo $count; ?></strong>
          </p>
          <p class="d-flex justify-content-between">
            <span>Delivery</span>
            <strong>N0</strong>
          </p>
          <p class="d-flex justify-content-between fs-5">
            <span>Total</span>
            <strong>N<?php echo number_format($subtotal); ?></strong>
          </p>
          <?php if ($count): ?>
            <a href="checkout.php" class="btn btn-success w-100 mt-2 check_out_pro">
              Proceed To Checkout
            </a>
          <?php else: ?>
            <button class="btn btn-secondary w-100 mt-2" disabled>
              Cart is Empty
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function(){
        // Remove item
        $(".remove-btn").click(function(){
          var btn = $(this);
          var productId = $(this).data("id");

          if(confirm("Remove this item from cart?")){
            $.post("cart_action.php", {
              action: "remove",
              product_id: productId
            }, function(){
              location.reload();
            });
          }
        });
        // Update quantity
        $(".quantity-input").change(function(){
          var productId = $(this).data("id");
          var qty = $(this).val();
          if(qty < 1) qty = 1;
          $.post("cart_action.php", {
            action: "update",
            product_id: productId,
            quantity: qty
          }, function(){
            location.reload();
          });
        });
      });
    </script>
    <?php //include "includes/footer.php"; ?>
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
  </body>
</html>